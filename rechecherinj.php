<?php
//Evite les injections sql
require_once 'config_bdd.php'; 

$keyword = "design"; 

$sql = "SELECT * FROM articles WHERE title LIKE :keyword";
$stmt = $bdd->prepare($sql); // Utilise bien $bdd, pas $dbname !

$stmt->execute([':keyword' => "%" . $keyword . "%"]);

?>