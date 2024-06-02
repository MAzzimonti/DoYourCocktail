<?php
session_start();

// Controllo se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Controllo se sono stati forniti i dati necessari
if (!isset($_POST['valutazione']) || !isset($_POST['commento']) || !isset($_POST['cocktail_id'])) {
    echo "Dati mancanti.";
    exit();
}

// Connessione al database
include 'db_connect.php';

// Preparazione delle variabili
$valutazione = $_POST['valutazione'];
$commento = $_POST['commento'];
$cocktail_id = $_POST['cocktail_id'];
$user_id = $_SESSION['user_id'];
$data_recensione = date('Y-m-d');

echo $cocktail_id;

// Preparazione della query per l'inserimento della recensione nel database
$query = "INSERT INTO recensione (valutazione, commento, data_recensione, id_cocktail, id_utente) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("issii", $valutazione, $commento, $data_recensione, $cocktail_id, $user_id);

// Esecuzione della query
if ($stmt->execute()) {
    // Reindirizzamento alla pagina delle recensioni
    header('Location: visualizza_recensioni.php?cocktail_id=' . $cocktail_id);
    exit();
} else {
    echo "Errore durante l'aggiunta della recensione: " . $conn->error;
}

// Chiusura della connessione
$stmt->close();
$conn->close();
?>