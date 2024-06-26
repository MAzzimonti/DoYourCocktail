<?php
session_start();
include 'db_connect.php';

// Il resto del tuo codice per le query e la visualizzazione della pagina

// Query per i drink più recensiti
$popolari_query = "
    SELECT c.id, c.nome, c.descrizione, c.immagine, COUNT(r.id) AS review_count, AVG(r.valutazione) AS valutazione_media
    FROM cocktail c
    LEFT JOIN recensione r ON c.id = r.id_cocktail
    GROUP BY c.id
    ORDER BY review_count DESC
    LIMIT 3
";
$popolari_result = $conn->query($popolari_query);
if (!$popolari_result) {
    die("Errore nella query: " . $conn->error);
}

// Query per le nuove uscite con media delle valutazioni
$nuove_uscite_query = "
    SELECT c.id, c.nome, c.descrizione, c.immagine, c.data_pubblicazione, AVG(r.valutazione) AS valutazione_media
    FROM cocktail c
    LEFT JOIN recensione r ON c.id = r.id_cocktail
    GROUP BY c.id
    ORDER BY c.data_pubblicazione DESC
    LIMIT 3
";
$nuove_uscite_result = $conn->query($nuove_uscite_query);
if (!$nuove_uscite_result) {
    die("Errore nella query: " . $conn->error);
}
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
        .drink-container {
            display: flex;
            justify-content: space-between;
        }
        .drink {
            width: 30%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
        }
        .drink img {
            width: 100%;
            height: auto;
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
        .logout-container {
            text-align: center;
            margin: 20px;
        }
        .drink-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Spazio tra i drink */
        }

        .drink {
            width: 30%; /* 30% della larghezza della pagina */
            box-sizing: border-box;
            text-align: center;
        }

        .drink img {
            width: 100%;
            height: auto;
            aspect-ratio: 1 / 1; /* Rende l'immagine quadrata */
            object-fit: cover; /* Taglia l'immagine per riempire il contenitore mantenendo le proporzioni */
            margin-bottom: 10px;
        }

        .drink h3 {
            margin: 10px 0;
        }

        .drink p {
            margin: 5px 0;
        }

        .drink button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .drink button:hover {
            background-color: #0056b3;
        }
</style>
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
            <a href="pagina_filtri_ricerca.php">Filtri di Ricerca</a>
        </div>
    </div>

    <div class="section">
    <h2>Popolari</h2>
    <div class="drink-container">
        <?php while($row = $popolari_result->fetch_assoc()): ?>
            <div class="drink">
                <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                <img src="<?php echo htmlspecialchars($row['immagine']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                <p><?php echo htmlspecialchars($row['descrizione']); ?></p>
                <p>Media valutazioni: <?php echo round($row['valutazione_media'], 1); ?></p>
                <form method="GET" action="visualizza_recensioni.php">
                    <input type="hidden" name="cocktail_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Visualizza Recensioni</button>
                </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="section">
        <h2>Nuove Uscite</h2>
        <div class="drink-container">
            <?php while($row = $nuove_uscite_result->fetch_assoc()): ?>
                <div class="drink">
                    <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                    <img src="<?php echo htmlspecialchars($row['immagine']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                    <p><?php echo htmlspecialchars($row['descrizione']); ?></p>
                    <p>Media valutazioni: <?php echo round($row['valutazione_media'], 1); ?></p>
                    <form method="GET" action="visualizza_recensioni.php">
                        <input type="hidden" name="cocktail_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Visualizza Recensioni</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="button-container">
        <a href="pagina_filtri_ricerca.php">Mostra tutti</a>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="logout-container">
            <a href="logout.php">Logout</a>
        </div>
    <?php endif; ?>
</body>
</html>
<?php
$conn->close();
?>