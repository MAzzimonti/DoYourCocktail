<?php
// Configurazione del database
$host = 'localhost'; // Indirizzo del server MySQL
$user = 'root'; // Nome utente del database
$pass = ''; // Password dell'utente del database
$dbName = 'DoYourCocktail'; // Nome del database da verificare

// Connessione al server MySQL
$conn = new mysqli($host, $user, $pass);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzione per eseguire il file SQL
function importSQL($filename, $conn) {
    // Leggi il contenuto del file
    $sql = file_get_contents($filename);
    if ($sql === false) {
        die("Impossibile leggere il file $filename");
    }

    // Suddividi le istruzioni SQL in singole query
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
    echo "Il database '$dbName' esiste già. Importazione non necessaria.";
} else {
    // Esegui l'importazione del file SQL se il database non esiste
    $filename = 'backup.sql'; // Nome del file SQL da importare
    importSQL($filename, $conn);
}

// Chiudi la connessione
$conn->close();
?>
