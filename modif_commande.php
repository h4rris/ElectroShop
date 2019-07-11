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
    $id_commande = $_GET['id_commande'];
    if($typeChgmnt =='valider'){
        try{
            $requete = $bdd->prepare('UPDATE commande SET statut_commande=:statut WHERE id_commande=:id_commande');
            $requete->execute(array(
                'id_commande' => $id_commande,
                'statut' => 'valide'
            ));
            $requete->closeCursor();
            $requete1 = $bdd->prepare('SELECT quantite,a.id_article FROM commande INNER JOIN panier AS p ON commande.id_panier=p.id_panier INNER JOIN article a ON p.id_article=a.id_article WHERE id_commande=:id_commande');
            $requete1->execute(array(
                'id_commande' => $id_commande,
            ));
            while ($ligne=$requete1->fetch()){
                $requete2 = $bdd->prepare('UPDATE article SET stock_article=stock_article-:quantite WHERE id_article=:id_article');
                $requete2->execute(array(
                    'id_article' => $ligne[1],
                    'quantite' => $ligne[0]
                ));
                $requete2->closeCursor();
            }
            $requete1->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    elseif($typeChgmnt =='annuler'){
        try{
            $requete = $bdd->prepare('UPDATE commande SET statut_commande=:statut WHERE id_commande=:id_commande');
            $requete->execute(array(
                'id_commande' => $id_commande,
                'statut' => 'annule'
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    elseif($typeChgmnt =='preparer'){
        try{
            $requete = $bdd->prepare('UPDATE commande SET statut_commande=:statut WHERE id_commande=:id_commande');
            $requete->execute(array(
                'id_commande' => $id_commande,
                'statut' => 'en cours preparation'
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    elseif($typeChgmnt =='expedier'){
        try{
            $requete = $bdd->prepare('UPDATE commande SET statut_commande=:statut WHERE id_commande=:id_commande');
            $requete->execute(array(
                'id_commande' => $id_commande,
                'statut' => 'expedie'
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    elseif($typeChgmnt =='suppression'){
        $id_panier = $_GET['id_panier'];
        try{
            $requete = $bdd->prepare('DELETE FROM commande WHERE id_commande=:id_commande');
            $requete->execute(array(
                'id_commande' => $id_commande
            ));
            $requete->closeCursor();
            $requete1 = $bdd->prepare('DELETE FROM panier WHERE id_panier=:id_panier');
            $requete1->execute(array(
                'id_panier' => $id_panier
            ));
            $requete1->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    
?>