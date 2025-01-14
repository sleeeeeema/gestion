<?php
session_start();
include 'db.php';

// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID_DOC = mysqli_real_escape_string($conn, $_POST['ID_DOC']);  // Manually entering ID_DOC
    $TYPE_DOC = mysqli_real_escape_string($conn, $_POST['TYPE_DOC']);
    $DATE_VALIDITE = mysqli_real_escape_string($conn, $_POST['DATE_VALIDITE']);

    // Validate input
    if (!empty($ID_DOC) && !empty($TYPE_DOC) && !empty($DATE_VALIDITE)) {
        // Insert document into the DOCUMENT_LEGAL table
        $sql = "INSERT INTO DOCUMENT_LEGAL (ID_DOC, TYPE_DOC, DATE_VALIDITE) 
                VALUES ('$ID_DOC', '$TYPE_DOC', '$DATE_VALIDITE')";

        if (mysqli_query($conn, $sql)) {
            $message = "Document ajouté avec succès. ID du document : $ID_DOC";
        } else {
            $message = "Erreur lors de l'ajout du document: " . mysqli_error($conn);
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 14px;
            color: #333;
        }
        .form-group input:focus {
            border-color: #2575fc;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #ffffff;
            background: #4caf50; /* Success message color */
            text-align: center;
        }
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a {
            color: #6a11cb;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un Document</h1>

        <!-- Display message -->
        <?php if (!empty($message)): ?>
            <div class="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="ajoutDocument.php">
            <div class="form-group">
                <label for="ID_DOC">ID du Document</label>
                <input type="text" id="ID_DOC" name="ID_DOC" required>
            </div>
            <div class="form-group">
                <label for="TYPE_DOC">Type de Document</label>
                <select id="TYPE_DOC" name="TYPE_DOC" required>
                    <option value="" disabled selected>Choisir un type</option>
                    <option value="Permis de conduire">Permis de conduire</option>
                    <option value="Carte grise">Carte grise</option>
                    <option value="Assurance">Assurance</option>
                    <option value="Contrôle technique">Contrôle technique</option>
                </select>
            </div>
            <div class="form-group">
                <label for="DATE_VALIDITE">Date de Validité</label>
                <input type="date" id="DATE_VALIDITE" name="DATE_VALIDITE" required>
            </div>
            <button type="submit" class="btn">Ajouter</button>
        </form>

        <div class="back-link">
            <a href="vehicules.php">← Retour à la liste des documents</a>
        </div>
    </div>
</body>
</html>
