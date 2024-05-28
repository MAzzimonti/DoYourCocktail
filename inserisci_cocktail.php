<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cocktail_db";

// Creazione connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $data_pubblicazione = date('Y-m-d');
    $immagine = $_POST['immagine'];

    $sql = "INSERT INTO cocktail (nome, descrizione, data_pubblicazione, immagine) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $descrizione, $data_pubblicazione, $immagine);

    if ($stmt->execute()) {
        echo "Cocktail inserito con successo!";
    } else {
        echo "Errore: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci Cocktail</title>
</head>
<body>
    <h1>Inserisci un nuovo Cocktail</h1>
    <form method="POST" action="">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>
        <label for="descrizione">Descrizione:</label><br>
        <textarea id="descrizione" name="descrizione" required></textarea><br><br>
        <label for="immagine">Immagine (URL):</label><br>
        <input type="text" id="immagine" name="immagine"><br><br>
        <button type="submit">Inserisci</button>
    </form>
    <a href="index.php"><button>Torna alla Home</button></a>
</body>
</html>
