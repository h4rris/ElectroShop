<?php
    session_start();
    require("parameters.php");

    $email = $_GET['email'];
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
        $requete1 = $bdd->prepare('INSERT INTO validation (id_user,token,statut) VALUES(:id_user,:token,"0");');
        $requete1->execute(array(
                'id_user' => $id_user,
                'token' => $token
            ));
        $requete1->closeCursor();
        $subject = 'Validation de votre adresse email';
        $headers = "Content-Type: text/html";
        $message="<!DOCTYPE html> <html>
        <body leftmargin='0' marginwidth='0' topmargin='0' marginheight='0' offset='0' style='margin: 0pt auto; padding: 0px; background:#F4F7FA;'> 
        <table id='main' width='100%' height='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#F4F7FA'> 
            <tbody> <tr> <td valign='top'> <table class='innermain' cellpadding='0' width='580' cellspacing='0' border='0' bgcolor='#F4F7FA' align='center' style='margin:0 auto; table-layout: fixed;'>
            <tbody>  <tr> <td colspan='4'>  <table class='logo' width='100%' cellpadding='0' cellspacing='0' border='0'> 
            <tbody> <tr> <td colspan='2' height='30'></td> </tr> <tr> <td valign='top' align='center'> <a href= style='display:inline-block; cursor:pointer; text-align:center;'> 
            <img src='E:/Users/ville/Documents/EFREI/Electroshop/ElectroShop/img/logo_electroShop.png' height='24' width='104' border='0' alt='Electroshop'> </a> 
            </td> </tr> <tr> <td colspan='2' height='30'></td> </tr> 
            </tbody> </table>   
            <table width='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#ffffff' style='border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'> 
            <tbody> <tr> <td height='40'></td> </tr> <tr style='font-family: -apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Oxygen','Ubuntu','Cantarell','Fira Sans','Droid Sans','Helvetica Neue',sans-serif; color:#4E5C6E; font-size:14px; line-height:20px; margin-top:20px;'> 
            <td class='content' colspan='2' valign='top' align='center' style='padding-left:90px; padding-right:90px;'> 
            <table width='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#ffffff'> 
            <tbody> <tr> 
            <td align='center' valign='bottom' colspan='2' cellpadding='3'> <img alt='Electroshop' width='80' src='E:/Users/ville/Documents/EFREI/Electroshop/ElectroShop/img/mail.png' /> </td> </tr> <tr> <td height='30'  =''></td> 
            </tr> 
            <tr> <td align='center'> <span style='color:#48545d;font-size:22px;line-height: 24px;'> Vérifier votre email </span> 
            </td> </tr> <tr> <td height='24'  =''></td> </tr>
            <tr> <td height='1' bgcolor='#DAE1E9'></td> </tr> 
            <tr> 
            <td height='24'  =''></td> </tr> 
            <tr> <td align='center'> <span style='color:#48545d;font-size:14px;line-height:24px;'> Pour pouvoir valider votre compte Electroshop, vous avez besoin de valider votre email. </span> </td> </tr> 
            <tr> <td height='20'  =''></td> </tr> <tr> <td valign='top' width='48%' align='center'> <span> <a href=http://localhost/electroshop/verif_token.php?token=".$token." style='display:block; padding:15px 25px; background-color:#0087D1; color:#ffffff; border-radius:3px; text-decoration:none;'>Vérifier votre adresse email</a> </span> </td> </tr> 
            <tr> <td height='20'  =''></td> </tr> <tr> <td align='center'> <img src='' width='54' height='2' border='0'> </td> </tr> 
            <tr> <td height='20'  =''></td> </tr> <tr> <td align='center'> <p style='color:#a2a2a2; font-size:12px; line-height:17px; font-style:italic;'>Si vous ne vous êtes pas inscrit pour ce compte, vous pouvez ignorer cet email et le compte sera supprimé.</p> 
            </td> </tr> </tbody> </table> </td> </tr> <tr> <td height='60'></td> </tr> 
            </tbody> </table>    
            <table id='promo' width='100%' cellpadding='0' cellspacing='0' border='0' style='margin-top:20px;'> 
            <tbody> <tr> <td colspan='2' height='20'></td> </tr> 
            <tr> <td colspan='2' height='20'> </td> </tr> 
            <tr> <td colspan='2' align='center'> <span style='font-size:14px; font-weight:500; margin-bottom:10px; color:#7E8A98; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Oxygen','Ubuntu','Cantarell','Fira Sans','Droid Sans','Helvetica Neue',sans-serif;'>Téléchargez la dernière version de l'appli Electroshop sur votre téléphone </span> </td> </tr> 
            <tr> <td colspan='2' height='20'></td> </tr> <tr> 
            <td valign='top' width='50%' align='right'> <a href='' style='display:inline-block;margin-right:10px;'> <img src='' height='40' border='0' alt='Coinbase iOS mobile bitcoin wallet'> </a> </td> 
            <td valign='top'> <a href= style='display:inline-block;margin-left:5px;'> <img src= height='40' border='0' alt='Coinbase Android mobile bitcoin wallet'> </a> </td> </tr> 
            <tr> <td colspan='2' height='20'></td> </tr> 
            </tbody> </table>   
            <table width='100%' cellpadding='0' cellspacing='0' border='0'> 
            <tbody> <tr> <td height='10'> </td> </tr> 
            <tr> <td valign='top' align='center'> <span style='font-family: -apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Oxygen','Ubuntu','Cantarell','Fira Sans','Droid Sans','Helvetica Neue',sans-serif; color:#9EB0C9; font-size:10px;'>© <a href='' target='_blank' style='color:#9EB0C9 !important; text-decoration:none;'>Coinbase</a> 2017 </span> </td> </tr> 
            <tr> <td height='50'> </td> </tr> </tbody> </table>  </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </body> </html>";
        //$message = '<html><body>';
        //$message .= '<h3 style="text-align: center;">Encore une derniere etape pour valider votre compte !</h3><br/>';
        //$message .= '<p>Cliquer sur ce lien pour valider votre compte et pouvoir passer vos commandes :</p>';
        //$message .= '<a href=http://localhost/electroshop/verif_token.php?token='.$token.'>Cliquer sur ce lien</a>';
        //$message .= '<p>En vous remerciant à nousveau de faire parti de notre communauté :) </p>';
        //$message .= '<p style="text-align: center;">Cordialement,</p>';
        //$message .= '<p style="text-align: center;">ELECTROSHOP.</p>';
        //$message .= '</body></html>';
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

