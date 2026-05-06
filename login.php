<?php if (isset($erreur)) { ?>
    <p style="color:red;"><?php echo $erreur; ?></p>
<?php } ?>
<?php
session_start();

if (isset($_POST['submit'])) {

    if (empty($_POST['login']) || empty($_POST['password'])) {
        $erreur = "Champs obligatoires !";
    } 
    else {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $m = '/^\S*(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
            
            if(isset($_POST['password'])){
                if(preg_match($m, $_POST['password'])){
                    echo 'Le mot de passe choisi convient';
                }else{
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