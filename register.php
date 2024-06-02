<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connettiti al database
    require 'db_connect.php';

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash della password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Query di inserimento
    $sql = "INSERT INTO utente (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $cognome, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registrazione completata con successo.');
                window.location.href = 'login.php';
              </script>";
        exit(); // Assicurarsi che il codice si fermi dopo il reindirizzamento
    } else {
        echo "Errore durante la registrazione: " . $stmt->error;
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
    <title>Registrazione - DoYourCocktail</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 10px; background-color: #f8f9fa; }
        .header img { height: 50px; }
        .form-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #fff; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: calc(100% - 40px); padding: 10px; }
        .form-group .show-password { width: 40px; display:flex; align-items: center; justify-content: center;}
        .home-button { margin-top: 20px; }
        .home-button a { text-decoration: none; }
        button { padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="logo/logo.png" alt="Logo">
        </div>
        <div class="home-button">
            <a href="index.php"><button>Home</button></a>
        </div>
    </div>
    <div class="form-container">
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="cognome">Cognome</label>
                <input type="text" id="cognome" name="cognome" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div style="display: flex;">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="show-password" onclick="togglePassword()">👁</button>
                </div>
            </div>
            <button type="submit">Registrati</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var passwordButton = document.querySelector('.show-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordButton.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                passwordButton.textContent = '👁';
            }
        }
    </script>
</body>
</html>
