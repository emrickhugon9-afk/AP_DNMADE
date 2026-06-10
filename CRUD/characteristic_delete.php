<?php
include 'pdo_config.php';
try {

    $requete = $db->prepare('SELECT * FROM CHARACTERISTICS');
    $requete->execute();
    $caracteristiques = $requete->fetchAll();


    $requete = $db->prepare('DELETE FROM CHARACTERISTICS WHERE id_characteristic = :id');

    $requete->execute([

        'id' =>  $_GET["id"]

    ]);
} catch (PDOException $e) {
    $Error = "Erreur : " . $e->getMessage();
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        <div class="card shadow p-4">
            <?php if ($Error == null)
                echo "<h1 class=\"text-success\">✔ Succès</h1>
                <p class=\"mt-3\">Caractéristique supprimée avec succès !</p>";
            else {

                echo "
                <div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">
                 " . $Error . "
                </div>
                <h1 class=\"text-danger\"><i class=\"bi bi-x-circle\"></i> Erreur</h1>
                <p class=\"mt-3\">Une erreur est survenue lors de la suppression de la caractéristique.</p>";
            }
            ?>
            <a href="characteristics.php" class="btn btn-primary mt-3">Retour à l'accueil</a>
        </div>
    </div>

</body>

</html>