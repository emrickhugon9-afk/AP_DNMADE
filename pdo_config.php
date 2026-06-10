<?php try {    
   $db = new PDO(
        'mysql:host=localhost;dbname=bdd_dnmade;charset=utf8',
        'bdd_dnmade',
        '7KElBmuUziB]b(Cj'
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $e->getMessage();
}
?>