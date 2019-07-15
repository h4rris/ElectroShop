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
        // recup de l'email 
        try{
            $requete = $bdd->prepare('SELECT email FROM users WHERE id_user=:id_user');
            $requete->execute(array(
                'id_user' => $_SESSION['id']
            ));
            while ($ligne=$requete->fetch()){
                $email=$ligne[0];
            }
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
        $subject = 'Merci de pour votre commande ! ';
        $headers = "Content-Type: text/html";
        
        $message = '<html><body>';
        $message .= '<h3 style="text-align: center;">Merci de pour votre commande !</h3><br/>';
        $message .= '<p>Nous vous remercions pour avoir passé commande chez nous !</p>';
        $message .= '<p>Pour suivre votre commande, cliquez <a href=http://localhost/electroshop/tracking.php?order='.$id_commande.'>ici</a> :</p>';
        $message .= '<p>En vous remerciant à nouveau de faire parti de notre communauté :) </p>';
        $message .= '<p style="text-align: center;">Cordialement,</p>';
        $message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
        $message .= '</body></html>';
        mail($email,$subject, $message, $headers);
		$data= $id_commande;
		echo json_encode(intval($data));
    }
	elseif($typeChgmnt == 'existe'){
		
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
		$id_commande=0;
        try{

            // on recup le plus grand id commande -> le dernier
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
		// INSERT INTO ADRESSE 
		$old_adresse = $_GET['id_adresse'];
        try{
            $requete = $bdd->prepare('INSERT INTO adresse_livraison(id_user,id_commande,rue,ville,pays_livraison,code_postal,tel_livraison,nom_livraison,prenom_livraison) SELECT id_user,:id_commande,rue,ville,pays_livraison,code_postal,tel_livraison,nom_livraison,prenom_livraison FROM adresse_livraison WHERE id_adresse=:id_adresse');
            $requete->execute(array(
                'id_adresse' => $old_adresse,
                'id_commande' => $id_commande
                
            ));
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
        // recup de l'email 
        try{
            $requete = $bdd->prepare('SELECT email FROM users WHERE id_user=:id_user');
            $requete->execute(array(
                'id_user' => $_SESSION['id']
            ));
            while ($ligne=$requete->fetch()){
                $email=$ligne[0];
            }
            $requete->closeCursor();
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

		$subject = 'Merci de pour votre commande ! ';
        $headers = "Content-Type: text/html";
        
        $message = '<html><body>';
        $message .= '<h3 style="text-align: center;">Merci de pour votre commande !</h3><br/>';
        $message .= '<p>Nous vous remercions pour avoir passé commande chez nous !</p>';
        $message .= '<p>Pour suivre votre commande, cliquez <a href=http://localhost/electroshop/tracking.php?order='.$id_commande.'>ici</a> :</p>';
        $message .= '<p>En vous remerciant à nouveau de faire parti de notre communauté :) </p>';
        $message .= '<p style="text-align: center;">Cordialement,</p>';
        $message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
        $message .= '</body></html>';
        mail($email,$subject, $message, $headers);
		$data= $id_commande;
		echo json_encode(intval($data));
	}
?>