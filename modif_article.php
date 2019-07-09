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
    if(isset($_GET['stock'])){
        $stock=(int)$_GET['stock'];
    }
    if(isset($_GET['prix'])){
        $prix=(float)$_GET['prix'];
    }
    $id_article=$_GET['id_article'];

    if($typeChgmnt =='stock'){
        if(is_int($stock)){
            $requete1 = $bdd->prepare('UPDATE article SET stock_article=:stock WHERE id_article=:id_article');
            $requete1->execute(array(
                'id_article' => $id_article,
                'stock' => $stock
            ));
            $requete1->closeCursor();
        }
        
    }
    elseif($typeChgmnt =='suppression'){
        try{
            $requete2 = $bdd->prepare('DELETE FROM prix WHERE id_article=:id_article');
            $requete2->execute(array(
                'id_article' => $id_article
            ));
            $requete2->closeCursor();
            $requete2 = $bdd->prepare('DELETE FROM panier WHERE id_article=:id_article');
            $requete2->execute(array(
                'id_article' => $id_article
            ));
            $requete2->closeCursor();
            $requete2 = $bdd->prepare('DELETE FROM commentaires WHERE id_article=:id_article');
            $requete2->execute(array(
                'id_article' => $id_article
            ));
            $requete2->closeCursor();
            $requete = $bdd->prepare('DELETE FROM article WHERE id_article=:id_article');
            $requete->execute(array(
                'id_article' => $id_article
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    elseif($typeChgmnt =='prix'){
        if(is_float($prix)){
            try{
                $requete2 = $bdd->prepare('UPDATE prix SET prix=:prix WHERE id_article=:id_article');
                $requete2->execute(array(
                    'id_article' => $id_article,
                    'prix' => $prix
                ));
                $requete2->closeCursor();
            }
            catch (Exception $e){
                die('Erreur : ' . $e->getMessage());
            }
        }
    }
?>