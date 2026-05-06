<?php
$password = $_POST['password'];
$resetpassword = $_POST['resetpassword'];
        $m = '/^\S*(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
            
            if(isset($_POST['password'])){
                if(preg_match($m, $_POST['password'])){
                    echo 'Le mot de passe choisi convient';
                }else{
                    echo 'Le mot de passe choisi ne répond pas aux critères';
                }
            }