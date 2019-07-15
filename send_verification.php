<?php
    session_start();
    require("parameters.php");
    if(isset($_GET['email'])){
        $email = $_GET['email'];
    }
    
    try{
        try{
            $bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
        $token = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);

        //recuperation de l'id de l'utilisateur
        if(isset($_GET['email'])){
            $requete = $bdd->prepare('SELECT id_user FROM users WHERE email=:email');
            $requete->execute(array(
                'email' => $email
            ));
            while ($ligne=$requete->fetch()){
                if($ligne[0]){
                    $id_user = $ligne[0];
                }
            }
            $requete->closeCursor();
        }
        else{
            $requete = $bdd->prepare('SELECT email FROM users WHERE id_user=:id_user');
            $requete->execute(array(
                'id_user' => $_SESSION['id']
            ));
            while ($ligne=$requete->fetch()){
                if($ligne[0]){
                    $email = $ligne[0];
                }
            }
            $requete->closeCursor();
        }
        


        // SECOND EMAIL DUCOUP SUPPR PREMIER
        if(isset($_GET['modif'])){
            if($_GET['modif'] == 'oublie'){
                $requete1 = $bdd->prepare('DELETE FROM validation WHERE id_user=:id_user;');
                $requete1->execute(array(
                        'id_user' => $_SESSION['id']
                    ));
                $requete1->closeCursor();
                $requete1 = $bdd->prepare('INSERT INTO validation (id_user,token,statut) VALUES(:id_user,:token,"0");');
                $requete1->execute(array(
                        'id_user' => $_SESSION['id'],
                        'token' => $token
                    ));
                $requete1->closeCursor();
            }
        }
        else{
            $requete1 = $bdd->prepare('INSERT INTO validation (id_user,token,statut) VALUES(:id_user,:token,"0");');
            $requete1->execute(array(
                    'id_user' => $id_user,
                    'token' => $token
                ));
            $requete1->closeCursor();
        }
        
        $subject = 'Validation de votre adresse email';
        $headers = "Content-Type: text/html";
        
        $message = '<html><body>';
        $message .= '<h3 style="text-align: center;">Encore une derniere etape pour valider votre compte !</h3><br/>';
        $message .= '<p>Cliquer sur ce lien pour valider votre compte et pouvoir passer vos commandes :</p>';
        $message .= '<a href=http://localhost/electroshop/verif_token.php?token='.$token.'>Cliquer sur ce lien</a>';
        $message .= '<p>En vous remerciant à nouveau de faire parti de notre communauté :) </p>';
        $message .= '<p style="text-align: center;">Cordialement,</p>';
        $message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
        $message .= '</body></html>';
        mail($email,$subject, $message, $headers);
        header('Content-type: application/json');
		?>
		{
			"response": "ok"
		}                                           
		<?php
    }
    catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
?>

