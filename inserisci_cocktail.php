<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="header">
        <div class="logo">
            <img src="logo\logo.png" alt="Logo">
        </div>
    </div>
    <title>Inserisci Cocktail - DoYourCocktail</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 10px; background-color: #f8f9fa; }
        .header img { height: 50px; }
        .form-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea { width: calc(100% - 20px); padding: 10px; margin-right: -20px; }
        button { padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .home-link {position: absolute; top: 20px; right: 20px; text-decoration: none; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 5px; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Inserisci Cocktail</h1>
        <a href="index.php" class="home-link">Home</a>
        <form method="POST" action="process_insert_cocktail.php">
            <div class="form-group">
                <label for="nome">Nome del Cocktail</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="descrizione">Descrizione</label>
                <textarea id="descrizione" name="descrizione" required></textarea>
            </div>
            <div class="form-group">
                <label for="immagine">Link dell'Immagine</label>
                <input type="text" id="immagine" name="immagine" required>
            </div>
            <button type="submit">Inserisci</button>
        </form>
    </div>
</body>
</html>
