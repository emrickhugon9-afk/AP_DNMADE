<?php
$dbname = 'bdd_dnmade';
$host = 'localhost';
$user = 'root';

try{
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion à Laragon : ' . $e->getMessage());
}
?>
