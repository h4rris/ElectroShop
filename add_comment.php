<?php
session_start();
require("parameters.php");
	try{   
		$bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
	}
	catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
    }	
    $id_article= $_GET['id_article'];
    $id_user = $_GET['id_user'];
    $comm = $_GET['comm'];
    $nbetoile = $_GET['nbetoile'];

    $requete1 = $bdd->prepare('INSERT INTO commentaires(id_article,id_user,message,nb_etoile) VALUES(:id_article,:id_user,:message,:nb_etoile)');
    $requete1->execute(array(
        'id_user' => $id_user,
        'id_article' => $id_article,
        'message' => $comm,
        'nb_etoile' => $nbetoile
    ));
    $requete1->closeCursor();  
  
?>