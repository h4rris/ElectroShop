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
        // envoi d'un email pour informer l'utilisateur
        try{
            $requete1 = $bdd->prepare('SELECT DISTINCT(email) FROM commande INNER JOIN panier AS p ON commande.id_panier=p.id_panier INNER JOIN users AS u ON p.id_user=u.id_user WHERE id_commande=:id_commande');
            $requete1->execute(array(
                'id_commande' => $id_commande,
            ));
            while ($ligne=$requete1->fetch()){
                $email= $ligne[0];                
            }
            $requete1->closeCursor();
            if(isset($email)){
                $subject = 'Votre commande est validée !!';
                $headers = "Content-Type: text/html";
                
                $message = '<html><body>';
                $message .= '<h3 style="text-align: center;">Bonne nouvelle, votre commande est validée !</h3><br/>';
                $message .= "<p>Votre commande vient d'etre validée par les administrateurs d'ElectrShop !</p>";
                $message .= "<p>Votre ID de commande :".$id_commande."</p>";
                $message .= '<p>Pour suivre votre commande, cliquez <a href=http://localhost/electroshop/tracking.php?order='.$id_commande.'>ici</a> :</p>';
                $message .= '<p>En vous remerciant à nouveau de faire parti de notre communauté :) </p>';
                $message .= '<p style="text-align: center;">Cordialement,</p>';
                $message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
                $message .= '</body></html>';
                mail($email,$subject, $message, $headers);
            }
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
        // envoi d'un email pour informer l'utilisateur
        try{
            $requete1 = $bdd->prepare('SELECT DISTINCT(email) FROM commande INNER JOIN panier AS p ON commande.id_panier=p.id_panier INNER JOIN users AS u ON p.id_user=u.id_user WHERE id_commande=:id_commande');
            $requete1->execute(array(
                'id_commande' => $id_commande,
            ));
            while ($ligne=$requete1->fetch()){
                $email= $ligne[0];                
            }
            $requete1->closeCursor();
            if(isset($email)){
                $subject = 'Votre commande est annulée ...';
                $headers = "Content-Type: text/html";
                
                $message = '<html><body>';
                $message .= '<h3 style="text-align: center;">Oh non, quel dommage votre commande est annulée !</h3><br/>';
                $message .= "<p>Votre ID de commande :".$id_commande." est annulée par les administrateurs d'ElectrShop</p>";
                $message .= '<p>Pour suivre votre commande, cliquez <a href=http://localhost/electroshop/tracking.php?order='.$id_commande.'>ici</a> :</p>';
                $message .= '<p>En vous remerciant à nouveau de faire parti de notre communauté :) </p>';
                $message .= '<p style="text-align: center;">Cordialement,</p>';
                $message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
                $message .= '</body></html>';
                mail($email,$subject, $message, $headers);
            }
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
        // envoi d'un email pour informer l'utilisateur
        try{
            $requete1 = $bdd->prepare('SELECT DISTINCT(email) FROM commande INNER JOIN panier AS p ON commande.id_panier=p.id_panier INNER JOIN users AS u ON p.id_user=u.id_user WHERE id_commande=:id_commande');
            $requete1->execute(array(
                'id_commande' => $id_commande,
            ));
            while ($ligne=$requete1->fetch()){
                $email= $ligne[0];                
            }
            $requete1->closeCursor();
            if(isset($email)){
                $subject = 'Votre commande est en cours de préparation !!';
                $headers = "Content-Type: text/html";
                
                $message = '<html><body>';
                $message .= '<h3 style="text-align: center;">Bonne nouvelle, votre commande est en cours de préparation !</h3><br/>';
                $message .= "<p>Nos équipes sont en train de préparer votre commande !</p>";
                $message .= "<p>Votre ID de commande :".$id_commande."</p>";
                $message .= '<p>Pour suivre votre commande, cliquez <a href=http://localhost/electroshop/tracking.php?order='.$id_commande.'>ici</a> :</p>';
                $message .= '<p>En vous remerciant à nouveau de faire parti de notre communauté :) </p>';
                $message .= '<p style="text-align: center;">Cordialement,</p>';
                $message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
                $message .= '</body></html>';
                mail($email,$subject, $message, $headers);
            }
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
        // envoi d'un email pour informer l'utilisateur
        try{
            $requete1 = $bdd->prepare('SELECT DISTINCT(email) FROM commande INNER JOIN panier AS p ON commande.id_panier=p.id_panier INNER JOIN users AS u ON p.id_user=u.id_user WHERE id_commande=:id_commande');
            $requete1->execute(array(
                'id_commande' => $id_commande,
            ));
            while ($ligne=$requete1->fetch()){
                $email= $ligne[0];                
            }
            $requete1->closeCursor();
            if(isset($email)){
                $subject = 'Votre commande est expédiée !!';
                $headers = "Content-Type: text/html";
                
                $message = '<html><body>';
                $message .= '<h3 style="text-align: center;">Bonne nouvelle, votre commande est expédiée !</h3><br/>';
                $message .= "<p>Nos équipes sont en train de livrer votre commande !</p>";
                $message .= "<p>Votre ID de commande :".$id_commande."</p>";
                $message .= '<p>Pour suivre votre commande, cliquez <a href=http://localhost/electroshop/tracking.php?order='.$id_commande.'>ici</a> :</p>';
                $message .= '<p>En vous remerciant à nouveau de faire parti de notre communauté :) </p>';
                $message .= '<p style="text-align: center;">Cordialement,</p>';
                $message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
                $message .= '</body></html>';
                mail($email,$subject, $message, $headers);
            }
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    elseif($typeChgmnt =='suppression'){
        //$id_panier = $_GET['id_panier'];
        try{
            // on recupere ID panier
            $requete1 = $bdd->prepare('SELECT id_panier FROM commande WHERE id_commande=:id_commande');
            $requete1->execute(array(
                'id_commande' => $id_commande
            ));
            while ($ligne=$requete1->fetch()){
                $id_panier = $ligne[0];
            }
            $requete1->closeCursor();

            // supprime le panier
            $requete1 = $bdd->prepare('DELETE FROM panier WHERE id_panier=:id_panier');
            $requete1->execute(array(
                'id_panier' => $id_panier
            ));

            // supprime adresse livraison
            $requete1 = $bdd->prepare('DELETE FROM adresse_livraison WHERE id_commande=:id_commande');
            $requete1->execute(array(
                'id_commande' => $id_commande
            ));
            $requete1->closeCursor();

            //supprime la commande  
            $requete = $bdd->prepare('DELETE FROM commande WHERE id_commande=:id_commande');
            $requete->execute(array(
                'id_commande' => $id_commande
            ));
            $requete->closeCursor();
            
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    
?>