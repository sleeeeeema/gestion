<?php
session_start();
include 'db.php';

// Fetch all document records
$sql_documents = "SELECT ID_DOC, TYPE_DOC, DATE_VALIDITE FROM DOCUMENT_LEGAL";
$result_documents = mysqli_query($conn, $sql_documents);

// Fetch all vehicle records
$sql_vehicles = "SELECT V.ID_VEHICULE, V.TYPE_VEHICULE, V.ETAT_VEHICULE, V.MARQUE_VEHICULE, V.MODELE_VEHICULE, V.ANNEE_FABRICATION, D.TYPE_DOC 
                FROM VEHICULE V 
                LEFT JOIN DOCUMENT_LEGAL D ON V.ID_DOC = D.ID_DOC";
$result_vehicles = mysqli_query($conn, $sql_vehicles);

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gestion des Documents et Véhicules</title>
    <style>
        body { background-color: #f8f9fa; font-family: 'Helvetica Neue', Arial, sans-serif; }
        .header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
        .content { padding: 40px; }
        .table-container { overflow-x: auto; background-color: white; padding: 20px; margin-bottom: 40px; }
        .btn { padding: 10px 20px; border-radius: 5px; margin-right: 10px; }
        .btn-primary { background-color: #28a745; }
        .btn-warning { background-color: #ffc107; }
        .btn-danger { background-color: #dc3545; }
        h2.section-title { margin-bottom: 20px; color: #343a40; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Gestion des Documents et Véhicules</h2>
    </div>

    <div class="content">

        <!-- Message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Documents Section -->
        <div class="table-container">
            <h2 class="section-title">Liste des Documents Légaux</h2>
            <a href="ajoutDocument.php" class="btn btn-primary">Ajouter un document</a>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID Document</th>
                        <th>Type</th>
                        <th>Date de Validité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_documents && mysqli_num_rows($result_documents) > 0) {
                        while ($row = mysqli_fetch_assoc($result_documents)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['ID_DOC']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['TYPE_DOC']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['DATE_VALIDITE']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">Aucun document trouvé.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Vehicles Section -->
        <div class="table-container">
            <h2 class="section-title">Liste des Véhicules</h2>
            <a href="ajoutVehicule.php" class="btn btn-primary">Ajouter un véhicule</a>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID Véhicule</th>
                        <th>Type</th>
                        <th>État</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Année de Fabrication</th>
                        <th>Document Associé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_vehicles && mysqli_num_rows($result_vehicles) > 0) {
                        while ($row = mysqli_fetch_assoc($result_vehicles)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['ID_VEHICULE']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['TYPE_VEHICULE']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['ETAT_VEHICULE']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['MARQUE_VEHICULE']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['MODELE_VEHICULE']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['ANNEE_FABRICATION']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['TYPE_DOC'] ?? 'Aucun document') . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7">Aucun véhicule trouvé.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function confirmDeleteDocument(id) {
            const confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce document ?");
            if (confirmation) {
                window.location.href = 'supprimerDocument.php?id=' + id;
            }
        }

        function confirmDeleteVehicle(id) {
            const confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce véhicule ?");
            if (confirmation) {
                window.location.href = 'supprimerVehicule.php?id=' + id;
            }
        }
    </script>
</body>
</html>
