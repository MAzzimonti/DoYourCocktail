<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $descrizione = $conn->real_escape_string($_POST['descrizione']);
    $immagine = $conn->real_escape_string($_POST['immagine']);
    $data_pubblicazione = date('Y-m-d'); // Data odierna

    $query = "INSERT INTO cocktail (nome, descrizione, immagine, data_pubblicazione) VALUES ('$nome', '$descrizione', '$immagine', '$data_pubblicazione')";

    if ($conn->query($query) === TRUE) {
        // Reindirizzamento alla home
        header('Location: index.php');
        exit();
    } else {
        echo "Errore: " . $query . "<br>" . $conn->error;
    }
}

// Chiudi la connessione
$conn->close();
?>
