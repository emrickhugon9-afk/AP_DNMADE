<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$erreur = "";
$succes = "";

require_once 'config_bdd.php';

if (isset($_POST['submit'])) {
    
    $pwd  = $_POST['password'] ?? '';
    $rpwd = $_POST['repet_password'] ?? '';
    $m = '/^\S*(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';

    if (empty($pwd) || empty($rpwd)) {
        $erreur = "Veuillez remplir tous les champs.";
    } elseif ($pwd !== $rpwd) {
        $erreur = "Les mots de passe ne sont pas identiques.";
    } elseif (!preg_match($m, $pwd)) {
        $erreur = "Le mot de passe doit contenir 8 caractères, une majuscule, un chiffre et un symbole.";
    } else {

        $password_hache = password_hash($pwd, PASSWORD_DEFAULT);
        $user_id = $_SESSION['user_id'] ?? null; 

        if ($user_id) {
            try {
                $req = $bdd->prepare("UPDATE utilisateurs SET mot_de_passe = :password WHERE id = :id");
                $req->execute([
                    'password' => $password_hache,
                    'id' => $user_id
                ]);
                $succes = "Le mot de passe vient d'être modifié !";
            } catch (Exception $e) {
                $erreur = "Une erreur est survenue : " . $e->getMessage();
            }
        } else {
            $erreur = "Erreur : Vous devez être connecté.";
        }
    }
    header("Location:login.html)");
    exit();
}   