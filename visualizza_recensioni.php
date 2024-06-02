<?php
session_start();

// Controllo se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connessione al database
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$dbName = 'DoYourCocktail';
$conn = new mysqli($host, $user, $pass, $dbName);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Preparazione della query per recuperare le recensioni del cocktail specificato, ordinate per data decrescente
$cocktail_id = $_GET['cocktail_id'];
$query = "SELECT c.nome AS nome_cocktail, r.valutazione, r.commento, DATE_FORMAT(r.data_recensione, '%d-%m-%Y') AS data_recensione_formatted 
          FROM recensione r 
          JOIN cocktail c ON r.id_cocktail = c.id 
          WHERE r.id_cocktail = $cocktail_id 
          ORDER BY r.data_recensione DESC";
$result = $conn->query($query);

if (!$result) {
    die("Errore nella query: " . $conn->error);
}

// Estrarre il nome del cocktail una sola volta
if ($row = $result->fetch_assoc()) {
    $nome_cocktail = htmlspecialchars($row['nome_cocktail']);
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Visualizza Recensioni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 70px auto 20px auto; /* Aggiornato il margine superiore */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .review {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .review:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .review p {
            margin-top: 5px;
        }
        .home-link {
            position: absolute;
            top: 20px; /* Distanza dal bordo superiore della finestra */
            right: 20px; /* Distanza dal bordo destro della finestra */
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
        .home-link:hover {
            background-color: #0056b3;
        }
        .add-review-btn {
            position: fixed;
            top: 20px; /* Distanza dal bordo superiore della finestra */
            left: 50%; /* Centro orizzontale */
            transform: translateX(-50%); /* Centra il bottone orizzontalmente */
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .add-review-btn:hover {
            background-color: #0056b3;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f8f9fa;
        }
        .header img {
            height: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="logo\logo.png" alt="Logo">
        </div>
    </div>
    <a href="index.php" class="home-link">Home</a>
    <a href="aggiungi_recensione.php?cocktail_id=<?php echo $cocktail_id; ?>" class="add-review-btn">Aggiungi Recensione</a>
    <div class="container">
        <h2>Recensioni di <?php echo $nome_cocktail; ?></h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review">
                <p><strong>Valutazione:</strong> <?php echo htmlspecialchars($row['valutazione']); ?></p>
                <p><strong>Commento:</strong> <?php echo htmlspecialchars($row['commento']); ?></p>
                <p><strong>Data Recensione:</strong> <?php echo htmlspecialchars($row['data_recensione_formatted']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
