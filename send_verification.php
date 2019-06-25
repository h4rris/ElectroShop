<?php
    session_start();
    require("parameters.php");

    $email = $_GET['email'];
    try{
        $token = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        $subject = 'Validation de votre adresse email';
        $headers = "Content-Type: text/html";
        $message = '<html><body>';
        $message .= '<h3 style="text-align: center;">Encore une derniere etape pour valider votre compte !</h3><br/>';
        $message .= '<p>Cliquer sur ce lien pour valider votre compte et pouvoir passer vos commandes :</p>';
        $message .= '<a href=http://localhost/electroshop/verif_token.php?token='.$token.'>Cliquer sur ce lien</a>';
        $message .= '<p>En vous remerciant à nousveau de faire parti de notre communauté :) </p>';
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

