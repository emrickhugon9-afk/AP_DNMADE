<?php
$temps_inactivite = 1440; 

session_set_cookie_params($temps_inactivite);

session_start();

if (isset($_POST['submit'])) {

    if (empty($_POST['login']) || empty($_POST['password'])) {
        $erreur = "Champs obligatoires !";
        $_POST['login'] = '';
        $_POST['password'] = '';
    }
    else {
        $login = $_POST['login'];
        $password = $_POST['password'];
            
            if(isset($_POST['password'])){
                if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $_POST['password'])) {
                    echo 'Le mot de passe choisi convient';
                } else {
                    echo 'Le mot de passe choisi ne répond pas aux critères';
                }
            } 
        if ($login === "admin" && $password === "1234") {
            $_SESSION["user"] = $login;
            header("Location: index.html"); 
            exit(); 
        } else {
            $erreur = "Identifiants incorrects";
        }
    }
}
?>