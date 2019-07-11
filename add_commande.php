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

    if($typeChgmnt == 'formulaire'){
        // AJOUT DU PANIER
        $date_now =date("Y-m-d_H-i-s");
        $max_id=0;
        //recuperation de lid max 
        try{
            $requete = $bdd->prepare('SELECT MAX(id_panier)+1 FROM panier');
            $requete->execute();
            while ($ligne=$requete->fetch()){
                $max_id=$ligne[0];
            }
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
        // INSERT INTO PANIER
        foreach ($_GET['data'] as $article){
            try{
                $requete = $bdd->prepare('INSERT INTO panier(id_panier,id_user,id_article,quantite,date) VALUE(:id_panier,:id_user,:id_article,:quantite,:date)');
                $requete->execute(array(
                    'id_panier' => $max_id,
                    'id_article' => $article['id_article'],
                    'id_user' => $_SESSION['id'],
                    'quantite' =>$article['quantity'],
                    'date' => $date_now
                ));
                $requete->closeCursor();
            }
            catch (Exception $e){
                die('Erreur : ' . $e->getMessage());
            }
        }
        
        /// AJOUT de la commande
        try{
            $requete = $bdd->prepare('INSERT INTO commande(id_panier,statut_commande,total_commande,date_now) VALUES(:id_panier,:statut_commande,:total_commande,:date_now)');
            $requete->execute(array(
                'id_panier' => $max_id,
                'statut_commande' => 'en cours validation',
                'total_commande' =>$_GET['total'],
                'date_now' => $date_now,
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

        // AJOUT DE L adresse de livraison
        $prenom= $_GET['prenom'];
        $nom= $_GET['nom'];
        $ville= $_GET['ville'];
        $pays= $_GET['pays'];
        $codepostal= $_GET['codepostal'];
        $telephone= $_GET['telephone'];
        $rue =$_GET['rue'];
        $id_commande=0;
        try{
            $requete = $bdd->prepare('SELECT MAX(id_commande) FROM commande');
            $requete->execute();
            while ($ligne=$requete->fetch()){
                $id_commande=$ligne[0];
            }
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
        try{
            $requete = $bdd->prepare('INSERT INTO adresse_livraison(id_user,id_commande,rue,ville,pays_livraison,code_postal,tel_livraison,nom_livraison,prenom_livraison) VALUES(:id_user,:id_commande,:rue,:ville,:pays_livraison,:code_postal,:tel_livraison,:nom_livraison,:prenom_livraison)');
            $requete->execute(array(
                'id_commande' => $id_commande,
                'id_user' => $_SESSION['id'],
                'prenom_livraison' => $prenom,
                'nom_livraison' => $nom,
                'tel_livraison' => $telephone,
                'code_postal' => $codepostal,
                'pays_livraison' => $pays,
                'ville' => $ville,
                'rue' => $rue
                
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
?>