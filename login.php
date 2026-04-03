<?php
section_sart():
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['submit'])) {

    if (!empty($_POST['login']) && !empty($_POST['password'])) {

        $login = $_POST['login'];
        $password = $_POST['password'];

        if ($login === "admin" && $password === "1234") {
            echo "Connexion réussie ";
        } else {
            echo "Login ou mot de passe incorrect";
        }

    } else {
        echo "Veuillez remplir tous les champs";
    }
}
?>