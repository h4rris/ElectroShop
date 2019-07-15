<?php
    session_start();
    require("parameters.php");
    $token = $_GET['token'];
    try{
        $bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    // validation du token
    try{
        $token_is_validate=0;
        $requete = $bdd->prepare('SELECT statut FROM validation WHERE token=:token AND statut="0";');
        $requete->execute(array(
            'token' => $token
        ));
        while ($ligne=$requete->fetch()){
            if($ligne[0] == 0){
                $token_is_validate=1;
                $requete1 = $bdd->prepare('UPDATE validation SET statut="1" WHERE token=:token;');
                $requete1->execute(array(
                    'token' => $token
                ));
                $requete->closeCursor();
                
            }
        }
        $requete->closeCursor();
        if($token_is_validate == 0){
            //deja validé ou alors non connu de la base
        }
        else{
            $_SESSION['validate']=1;
            $_SESSION['valid']=1;
            session_write_close();
            header('Location: index.php');

        }
    }
    catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
?>