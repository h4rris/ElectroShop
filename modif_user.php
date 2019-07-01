<?php
session_start();
require("parameters.php");
	try{   
		$bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
	}
	catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
    }	


    $typeChgmnt = $_GET['typeChgmnt'];
    $id_user = $_GET['id_user'];
    
    if($typeChgmnt =='desactiver'){
        
        $requete1 = $bdd->prepare('UPDATE users SET statut="0" WHERE id_user=:id_user');
        $requete1->execute(array(
            'id_user' => $id_user
        ));
        $requete1->closeCursor();  
    }
    elseif($typeChgmnt =='activer'){
        
        $requete1 = $bdd->prepare('UPDATE users SET statut="1" WHERE id_user=:id_user');
        $requete1->execute(array(
            'id_user' => $id_user
        ));
        $requete1->closeCursor();  
    }
    elseif($typeChgmnt =='promouvoir'){
        
        $requete2 = $bdd->prepare('SELECT statut FROM users WHERE id_user=:id_user');
        $requete2->execute(array(
            'id_user' => $id_user
        ));
        while ($ligne=$requete2->fetch()){
            $statut_actu= $ligne[0];
        }
        $requete2->closeCursor(); 
        $statut_actu+=1;
        $requete1 = $bdd->prepare('UPDATE users SET statut=:statut WHERE id_user=:id_user');
        $requete1->execute(array(
            'id_user' => $id_user,
            'statut' => $statut_actu
        ));
        $requete1->closeCursor();  
    }
    elseif($typeChgmnt =='retrograder'){
        
        $requete2 = $bdd->prepare('SELECT statut FROM users WHERE id_user=:id_user');
        $requete2->execute(array(
            'id_user' => $id_user
        ));
        while ($ligne=$requete2->fetch()){
            $statut_actu= $ligne[0];
        }
        $requete2->closeCursor(); 
        $statut_actu-=1;
        $requete1 = $bdd->prepare('UPDATE users SET statut=:statut WHERE id_user=:id_user');
        $requete1->execute(array(
            'id_user' => $id_user,
            'statut' => $statut_actu
        ));
        $requete1->closeCursor();  
    }
    elseif($typeChgmnt =='suppression'){
        try{
            $requete4 = $bdd->prepare('DELETE FROM validation WHERE id_user=:id_user');
            $requete4->execute(array(
                'id_user' => $id_user
            ));
            $requete4->closeCursor();
            $requete6 = $bdd->prepare('DELETE FROM panier WHERE id_user=:id_user');
            $requete6->execute(array(
                'id_user' => $id_user
            ));
            $requete6->closeCursor();
            $requete7 = $bdd->prepare('DELETE FROM commentaires WHERE id_user=:id_user');
            $requete7->execute(array(
                'id_user' => $id_user
            ));
            $requete7->closeCursor();
            $requete5 = $bdd->prepare('DELETE FROM users WHERE id_user=:id_user');
            $requete5->execute(array(
                'id_user' => $id_user
            ));
            $requete5->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
?>