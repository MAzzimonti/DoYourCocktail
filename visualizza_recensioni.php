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
            top: 20px;
            right: 150px; /* Modificato per fare spazio al bottone di aggiunta recensione */
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
            top: 20px;
            left: 20px; /* Spostato a sinistra */
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
        <h2>Recensioni dei Cocktail</h2>
        <?php
        session_start();

        // Controllo se l'utente è loggato
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        // Controllo se è stato passato l'ID del cocktail
        if (!isset($_GET['cocktail_id'])) {
            echo "ID del cocktail non fornito.";
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

        // Preparazione della query per recuperare le recensioni del cocktail specificato
        $cocktail_id = $_GET['cocktail_id'];
        $query = "SELECT c.nome AS nome_cocktail, r.valutazione, r.commento, r.data_recensione FROM recensione r JOIN cocktail c ON r.id_cocktail = c.id WHERE r.id_cocktail = $cocktail_id";
        $result = $conn->query($query);

        if (!$result) {
            die("Errore nella query: " . $conn->error);
        }
        ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review">
                <h3><?php echo htmlspecialchars($row['nome_cocktail']); ?></h3>
                <p><strong>Valutazione:</strong> <?php echo htmlspecialchars($row['valutazione']); ?></p>
                <p><strong>Commento:</strong> <?php echo htmlspecialchars($row['commento']); ?></p>
                <p><strong>Data Recensione:</strong> <?php echo htmlspecialchars($row['data_recensione']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
