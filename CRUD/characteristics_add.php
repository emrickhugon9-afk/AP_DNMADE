<?php
include 'pdo_config.php';
try {

    $requeteInsert = $db->prepare("INSERT INTO characteristics (label, id_criteria)
    VALUES (:label, :id_criteria)");

    $requeteInsert->execute([

        'label' => $_POST["characteristic"],
        'id_criteria' => $_POST["id_criteria"]
    ]);
} catch (PDOException $e) {
    $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNMADE - Ajout</title>
    <link rel="icon" type="image/x-icon" href="/img/logo_costumerie.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        <div class="card shadow p-4">
            <?php if ($e == null)
                echo "<h1 class=\"text-success\">✔ Succès</h1>
                <p class=\"mt-3\">Caractéristique ajoutée avec succès !</p>";
            else {

                echo "
                <div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">
                 " . $e->getMessage() . "
                </div>
                <h1 class=\"text-danger\"><i class=\"bi bi-x-circle\"></i> Erreur</h1>
                <p class=\"mt-3\">Une erreur est survenue lors de l'ajout de la caractéristique.</p>";
            }
            ?>
            <a href="characteristics.php" class="btn btn-primary mt-3">Retour à l'accueil</a>
        </div>
    </div>

</body>

</html>