<?php
include 'pdo_config.php';
try {
    $requeteInsert = $db->prepare("INSERT INTO users (last_name, first_name, password, email, status, first_login, created_at)
    VALUES (:last_name, :first_name, :password, :email, :status, :first_login, :created_at)");

    $requeteInsert->execute([

        'last_name' => $_POST["last_name"],
        'first_name' => $_POST["first_name"],
        'password' => sha1($_POST["password"]),
        'email' => $_POST["email"],
        'status' => $_POST["status"],
        'first_login' => 1,
        'created_at' => date('Y-m-d H:i:s'),
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
    <title>Success Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        <div class="card shadow p-4">
            <?php if ($e == null)
                echo "<h1 class=\"text-success\">✔ Succès</h1>
                <p class=\"mt-3\">Utilisateur ajouté avec succès !</p>";
            else {

                echo "
                <div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">
                 " . $e->getMessage() . "
                </div>
                <h1 class=\"text-danger\"><i class=\"bi bi-x-circle\"></i> Erreur</h1>
                <p class=\"mt-3\">Une erreur est survenue lors de l'ajout de l'utilisateur.</p>";
            }
            ?>
            <a href="tables.php" class="btn btn-primary mt-3">Retour à l'accueil</a>
        </div>
    </div>

</body>

</html>