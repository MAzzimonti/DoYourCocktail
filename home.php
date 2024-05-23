<?php
include 'db_connect.php';

// Query per i drink più recensiti
$popolari_query = "SELECT * FROM drinks ORDER BY review_count DESC LIMIT 3";
$popolari_result = $conn->query($popolari_query);

// Query per le nuove uscite
$nuove_uscite_query = "SELECT * FROM drinks ORDER BY published_date DESC LIMIT 3";
$nuove_uscite_result = $conn->query($nuove_uscite_query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>DoYourCocktail</title>
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
            margin-left: 10px; /* Spazio tra i pulsanti */
        }
        .section {
            padding: 20px;
        }
        .drink {
            margin: 10px 0;
        }
        .button-container {
            text-align: center;
            margin: 20px;
        }
        .button-container a {
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
            <img src="logo.png" alt="Logo">
            <span>DoYourCocktail</span>
        </div>
        <div class="auth-buttons">
            <a href="login.php">Login</a>
            <a href="register.php">Registrazione</a>
            <a href="pagina_filtri_ricerca.php">Filtri di Ricerca</a>
        </div>
    </div>

    <div class="section">
        <h2>Popolari</h2>
        <?php while($row = $popolari_result->fetch_assoc()): ?>
            <div class="drink">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="section">
        <h2>Nuove Uscite</h2>
        <?php while($row = $nuove_uscite_result->fetch_assoc()): ?>
            <div class="drink">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="button-container">
        <a href="all_drinks.php">Mostra tutti</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
