<?php
session_start();
require("parameters.php");
	try{   
		$bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
	}
	catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
    }

    $id_com = $_GET['id_com'];

    $requete4 = $bdd->prepare('DELETE FROM commentaires WHERE id_com=:id_com');
    $requete4->execute(array(
        'id_com' => $id_com
    ));
    $requete4->closeCursor();

?>