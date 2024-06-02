<?php
// Configurazione del database
$host = 'localhost'; // Indirizzo del server MySQL
$user = 'root'; // Nome utente del database
$pass = ''; // Password dell'utente del database
$dbName = 'doyourcocktail'; // Nome del database

// Connessione al server MySQL
$conn = new mysqli($host, $user, $pass, $dbName);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
