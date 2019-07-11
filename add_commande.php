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
        try{
            $requete = $bdd->prepare('INSERT INTO panier(id_user,id_article,quantite,date) VALUE(:id_user,:id_article,:quantite,:date)');
            $requete->execute(array(
                'id_article' => ,
                'id_user' => $_SESSION['id'],
                'quantite' =>,
                'date' => $date_now
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

        /// AJOUT de la commande
        try{
            $requete = $bdd->prepare('INSERT INTO commande(id_panier,statut_commande,total_commande,date_now) SELECT id_panier,:statut_commande,:total_commande,date_now FROM panier WHERE date=:date AND id_user=:id_user');
            $requete->execute(array(
                'statut_commande' => 'en cours validation',
                'id_user' => $_SESSION['id'],
                'total_commande' =>,
                'date' => $date_now,
                'date_now' => $date_now
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
        $rue =$_POST['adresse'];
        try{
            $requete = $bdd->prepare('INSERT INTO adresse_livraison(id_user,id_commande,rue,ville,pays_livraison,code_postal,tel_livraison,nom_livraison,prenom_livraison) SELECT id_commande,:id_user,:id_commande,:rue,:ville,:pays_livraison,:code_postal,:tel_livraison,:nom_livraison,:prenom_livraison WHERE date=:date AND id_user=:id_user');
            $requete->execute(array(
                'id_commande' => $id_commande,
                'id_user' => $_SESSION['id'],
                'prenom_livraison' => $prenom,
                'nom_livraison' => $nom,
                'tel_livraison' => $telephone,
                'code_postal' => $codepostal,
                'pays_livraison' => $pays,
                'ville' => $ville,
                'rue' => $rue,
                'date' => $date_now
                
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
?>