<?php
include 'pdo_config.php';
try {
    $requeteInsert = $db->prepare("UPDATE CHARACTERISTICS SET label = :label, id_criteria = :criteria WHERE id_characteristic = :id");

    $requeteInsert->execute([

        'id' => $_POST["id"],
        'label' => $_POST["label"],
        'criteria' => $_POST["id_criteria"]
    ]);
} catch (PDOException $e) {
    $Error = "Erreur : " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNMADE - Modification</title>
    <link rel="icon" type="image/x-icon" href="/img/logo_costumerie.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        <div class="card shadow p-4">
            <?php if ($Error == null)
                echo "<h1 class=\"text-success\">✔ Succès</h1>
                <p class=\"mt-3\">Caractéristique modifiée avec succès !</p>";
            else {

                echo "
                <div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">
                 " . $Error . "
                </div>
                <h1 class=\"text-danger\"><i class=\"bi bi-x-circle\"></i> Erreur</h1>
                <p class=\"mt-3\">Une erreur est survenue lors de la modification de la caractéristique.</p>";
            }
            ?>
            <a href="characteristics.php" class="btn btn-primary mt-3">Retour à l'accueil</a>
        </div>
    </div>

</body>

</html>