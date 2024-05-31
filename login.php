<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connect.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nome, cognome, password FROM utente WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['cognome'] = $row['cognome'];
            echo "<script>
                    alert('Login effettuato con successo.');
                    window.location.href = 'index.php';
                  </script>";
            exit(); // Assicurarsi che il codice si fermi dopo il reindirizzamento
        } else {
            echo "Email o password errati.";
        }
    } else {
        echo "Email o password errati.";
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
    <title>Login - DoYourCocktail</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 10px; background-color: #f8f9fa; }
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
        <h1>DoYourCocktail</h1>
        <div class="home-button">
            <a href="index.php"><button>Home</button></a>
        </div>
    </div>
    <div class="form-container">
        <form method="POST" action="login.php">
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
            <button type="submit">Login</button>
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
