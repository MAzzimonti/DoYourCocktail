<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DoYourCocktail"; // Sostituisci con il nome del tuo database

// Creazione connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '';

$sql = "SELECT cocktail.nome, cocktail.descrizione, AVG(recensione.valutazione) as media_valutazione 
        FROM cocktail 
        LEFT JOIN recensione ON cocktail.id = recensione.id_cocktail
        WHERE cocktail.nome LIKE ? ";

if ($rating != '') {
    $sql .= "HAVING media_valutazione >= ?";
}

$sql .= " GROUP BY cocktail.id";

$stmt = $conn->prepare($sql);

if ($rating != '') {
    $search_param = "%" . $search . "%";
    $stmt->bind_param("sd", $search_param, $rating);
} else {
    $search_param = "%" . $search . "%";
    $stmt->bind_param("s", $search_param);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoYourCocktail</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .search-bar { margin-bottom: 20px; }
        .cocktail-list { margin-top: 20px; }
        .cocktail-item { margin-bottom: 10px; }
        .home-button { margin-top: 20px; }
        .home-button a { text-decoration: none; }
    </style>
</head>
<body>
    <div class="header">    //bottone spostato a in alto a destra
        <h1>DoYourCocktail</h1>
        <div class="home-button">
            <a href="index.php"><button>Home</button></a>
        </div>
    </div>
    <form method="GET" action="">
        <div class="search-bar">
            <input type="text" name="search" placeholder="Cerca cocktail..." value="<?php echo htmlspecialchars($search); ?>">
            <select name="rating">
                <option value="">Valutazione minima</option>
                <option value="1" <?php if ($rating == '1') echo 'selected'; ?>>1</option>
                <option value="2" <?php if ($rating == '2') echo 'selected'; ?>>2</option>
                <option value="3" <?php if ($rating == '3') echo 'selected'; ?>>3</option>
                <option value="4" <?php if ($rating == '4') echo 'selected'; ?>>4</option>
                <option value="5" <?php if ($rating == '5') echo 'selected'; ?>>5</option>
            </select>
            <button type="submit">Cerca</button>
        </div>
    </form>

    <div class="cocktail-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cocktail-item">';
                echo '<h2>' . htmlspecialchars($row['nome']) . '</h2>';
                echo '<p>' . htmlspecialchars($row['descrizione']) . '</p>';
                echo '<p>Valutazione media: ' . round($row['media_valutazione'], 1) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>Nessun cocktail trovato.</p>';
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>


