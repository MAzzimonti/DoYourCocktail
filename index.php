<?php
session_start();
include 'db_connect.php';

// Funzione per eseguire il file SQL
function importSQL($filename, $conn, $dbName) {
    if (!$conn->select_db($dbName)) {
        die("Errore nella selezione del database: " . $conn->error);
    }

    $sql = file_get_contents($filename);
    if ($sql === false) {
        die("Impossibile leggere il file $filename");
    }

    $queries = explode(';', $sql);
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            if ($conn->query($query) === false) {
                echo "Errore nell'esecuzione della query: " . $conn->error . "<br>";
            }
        }
    }
    echo "Importazione completata con successo.";
}

// Verifica se il database esiste
$dbExists = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'");
if ($dbExists->num_rows > 0) {
    $conn->select_db($dbName);
} else {
    if ($conn->query("CREATE DATABASE $dbName") === true) {
        echo "Database '$dbName' creato con successo. Procedo con l'importazione.<br>";
        $conn->select_db($dbName);
        $filename = 'backup.sql';
        importSQL($filename, $conn, $dbName);
    } else {
        die("Errore nella creazione del database: " . $conn->error);
    }
}

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

// Query per le nuove uscite
$nuove_uscite_query = "
    SELECT id, nome, descrizione, immagine, data_pubblicazione, AVG(valutazione) AS valutazione_media
    FROM cocktail
    ORDER BY data_pubblicazione DESC
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
                    <p>Media valutazioni: <?php echo round($row['valutazione_media'], 2); ?></p>
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
