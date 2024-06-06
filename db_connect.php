<?php
// Configurazione del database
$host = 'localhost'; // Indirizzo del server MySQL
$user = 'root'; // Nome utente del database
$pass = ''; // Password dell'utente del database
$dbName = 'doyourcocktail'; // Nome del database

// Connessione al server MySQL
$conn = new mysqli($host, $user, $pass);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzione per eseguire il file SQL
function importSQL($filename, $conn) {
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
if ($dbExists->num_rows == 0) {
    if ($conn->query("CREATE DATABASE $dbName") === true) {
        echo "Database '$dbName' creato con successo. Procedo con l'importazione.<br>";
        $conn->select_db($dbName);
        $filename = 'backup.sql';
        importSQL($filename, $conn);
        // Dopo l'importazione, ricarica la pagina
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        die("Errore nella creazione del database: " . $conn->error);
    }
} else {
    $conn->select_db($dbName);
}
?>
