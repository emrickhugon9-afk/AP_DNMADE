<?php
session_start();

// 1. On traite le formulaire UNIQUEMENT si le bouton a été cliqué
if (isset($_POST['submit'])) {

    // 2. On vérifie si les champs sont vides
    if (!empty($_POST['login']) && !empty($_POST['password'])) {

        $login = $_POST['login'];
        $password = $_POST['password'];

        // 3. On vérifie les identifiants
        if ($login === "admin" && $password === "1234") {
            $_SESSION["user"] = $login; // On crée la session
            header("Location: index.php"); // REDIRECTION VERS L'ACCUEIL SEULEMENT ICI
            exit();
        } else {
            $erreur = "Login ou mot de passe incorrect";
        }

    } else {
        // Si les champs sont vides, on reste ici et on prépare un message
        $erreur = "Veuillez remplir tous les champs";
    }
}
?>