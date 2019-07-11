<?php 
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=ElectroShop;charset=utf8', 'root', '');

    //Récupération des articles
    $reponse = $bdd->query('SELECT * FROM article');
    $donnees_articles = $reponse->fetchAll();

     $toReturn = json_encode($donnees_articles);
    echo $toReturn;
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

?>
