<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connettersi al database
require 'db_connect.php';

// Recuperare i dati dell'utente
$user_id = $_SESSION['user_id'];
$sql = "SELECT nome, cognome, email FROM utente WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nome, $cognome, $email);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
<div class="header">
        <div class="logo">
            <img src="logo\logo.png" alt="Logo">
        </div>
    </div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo - DoYourCocktail</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .profile-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        .profile-group { margin-bottom: 15px; }
        .profile-group label { display: block; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Profilo</h1>
        <div class="profile-group">
            <label>Nome:</label>
            <p><?php echo htmlspecialchars($nome); ?></p>
        </div>
        <div class="profile-group">
            <label>Cognome:</label>
            <p><?php echo htmlspecialchars($cognome); ?></p>
        </div>
        <div class="profile-group">
            <label>Email:</label>
            <p><?php echo htmlspecialchars($email); ?></p>
        </div>
    </div>
</body>
</html>
