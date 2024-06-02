<?php
session_start();
include 'db_connect.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT cocktail.id, cocktail.nome, cocktail.descrizione, cocktail.immagine, AVG(recensione.valutazione) as valutazione
        FROM cocktail 
        LEFT JOIN recensione ON cocktail.id = recensione.id_cocktail
        WHERE cocktail.nome LIKE ?
        GROUP BY cocktail.id";

$stmt = $conn->prepare($sql);

$search_param = "%" . $search . "%";
$stmt->bind_param("s", $search_param);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoYourCocktail - Filtra e Cerca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .header img {
            height: 50px;
        }
        .header a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            margin-left: 10px;
        }
        .section {
            padding: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .cocktail-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .cocktail-item {
            width: 30%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
        }
        .cocktail-item img {
            width: 100%;
            height: auto;
        }
        .home-button {
            text-align: center;
            margin: 20px;
        }
        .home-button a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="logo\logo.png" alt="Logo">
        </div>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="inserisci_cocktail.php">Inserisci Cocktail</a>
                <a href="profilo.php">Profilo</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Registrazione</a>
            <?php endif; ?>
            <a href="index.php">Home</a>
        </div>
    </div>
    
    <div class="section">
        <form method="GET" action="">
            <div class="search-bar">
                <input type="text" name="search" placeholder="Cerca cocktail..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Cerca</button>
            </div>
        </form>
        
        <div class="cocktail-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="cocktail-item">';
                    echo '<h3>' . htmlspecialchars($row['nome']) . '</h3>';
                    echo '<img src="' . htmlspecialchars($row['immagine']) . '" alt="' . htmlspecialchars($row['nome']) . '">';
                    echo '<p>' . htmlspecialchars($row['descrizione']) . '</p>';
                    echo '<p>Valutazione: ' . round($row['valutazione'], 1) . '</p>';
                    echo '<form method="GET" action="visualizza_recensioni.php">';
                    echo '<input type="hidden" name="cocktail_id" value="' . htmlspecialchars($row['id']) . '">';
                    echo '<button type="submit">Visualizza Recensioni</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>Nessun cocktail trovato.</p>';
            }
            
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="home-button">
            <a href="logout.php">Logout</a>
        </div>
    <?php endif; ?>
</body>
</html>
