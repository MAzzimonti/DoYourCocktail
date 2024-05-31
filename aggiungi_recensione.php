<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Aggiungi Recensione</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-right: -20px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Aggiungi Recensione</h2>
        <form method="POST" action="process_add_review.php">
            <div class="form-group">
                <label for="valutazione">Valutazione (da 1 a 5)</label>
                <input type="number" id="valutazione" name="valutazione" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="commento">Commento</label>
                <textarea id="commento" name="commento" required></textarea>
            </div>
            <input type="hidden" name="cocktail_id" value="<?php echo $_GET['cocktail_id']; ?>">
            <button type="submit">Aggiungi Recensione</button>
        </form>
    </div>
</body>
</html>
