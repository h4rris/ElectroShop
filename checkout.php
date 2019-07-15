<?php
    session_start();
    require("parameters.php");

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/logo_flavicon.ico">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Electro Shop</title>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
    <script type= "text/javascript" src = "js/countries.js"></script>
</head>

<body><?php
    try{   
		$bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
	}
	catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
    }
    if(isset($_POST['radio'])){
       if($_POST['radio'] == "formulaire"){
           //nouveau formulaire
           if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['adresse']) && !empty($_POST['ville']) && !empty($_POST['pays']) && !empty($_POST['codepostal']) && !empty($_POST['telephone'])){
                    ?><script>
                        var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
                        var sous_total = 0;
                        existingEntries.forEach(function(element) {
                            sous_total = (element.prix * element.quantity) + sous_total;
                        });
                        console.log('localStorage');
                        total=sous_total+5;
                        console.log(existingEntries);
                        
                        $.ajax({
                            url : "add_commande.php",
                            data : {
                                typeChgmnt: 'formulaire',
                                prenom : "<?php echo $_POST['prenom'];?>",
                                nom : "<?php echo $_POST['nom'];?>",
                                ville : "<?php echo $_POST['ville'];?>",
                                pays : "<?php echo $_POST['pays'];?>",
                                codepostal : "<?php echo $_POST['codepostal'];?>",
                                telephone : "<?php echo $_POST['telephone'];?>",
                                rue : "<?php echo $_POST['adresse'];?>",
                                data : existingEntries,
                                total : total

                            },
                            cache : false,
                            success : function(response){
                                localStorage.removeItem("cart_items");
                                swal("Action traitée avec succès!", {
                                    icon: "success",
                                    timer: 3000
                                })
                                .then((willDelete) => {
										window.location.href = "confirmation.php";
                                
                                });
                            },
                            error : function(request, error){
                                console.log(error);
                            }
                        });
                    </script><?php
            }
            else{
                ?><script>
                swal({
                    title: "Veuillez remplir tous les champs !",
                    icon: "error"
                    })
                    .then((willDelete) => {
                        window.location.href = "checkout.php";
                        
                    });
                </script>
                <?php
            }
       }
        else{
            ?><script>
                        var existingEntries = JSON.parse(localStorage.getItem("cart_items"));
                        var sous_total = 0;
                        existingEntries.forEach(function(element) {
                            sous_total = (element.prix * element.quantity) + sous_total;
                        });
                        console.log('localStorage');
                        total=sous_total+5;
                        console.log(existingEntries);
                        
                        $.ajax({
                            url : "add_commande.php",
                            data : {
                                typeChgmnt: 'existe',
                                id_adresse : "<?php echo $_POST['radio'];?>",
                                data : existingEntries,
                                total : total

                            },
                            cache : false,
							contentType: "application/json",
                            success : function(response){
								console.log(response);
                                swal("Action traitée avec succès!", {
                                    icon: "success",
                                    timer: 3000
                                })
                                .then((willDelete) => {
										window.location.href = "confirmation.php?id="+response;
                                
                                });
                            },
                            error : function(request, error){
                                console.log(error);
                            }
                        });
                    </script><?php
       }
    }
    
    
    ?>
    <!-- Start Header Area -->
	<div class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><img src="img/logo_electroShop.png" alt="" style="width: 150px"></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav ml-auto">
							<li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
							<li class="nav-item"><a class="nav-link" href="category.php">Articles</a></li>
							<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								aria-expanded="false">COMMANDE</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link" href="commandes.php">Suivre ma commande</a></li>
									
								</ul>
							</li>
							
							<?php 
							if(isset($_SESSION['statut'])){
								
								if(($_SESSION['statut'] == "2") || ($_SESSION['statut'] == "3")){?>
								<li class="nav-item submenu dropdown">
									<a href="#" class="nav-link dropdown-toggle">Administration</a>
									<ul class="dropdown-menu">	
										<li class="nav-item"><a class="nav-link" href="gestionarticles.php">Gestion des Articles</a></li>
										<li class="nav-item"><a class="nav-link" href="gestioncomptes.php">Gestion des comptes</a></li>
										<li class="nav-item"><a class="nav-link" href="gestioncommandes.php">Gestion commandes</a></li>
									</ul>
								</li><?php
							}
							}	
                            
                            $requete1 = $bdd->prepare('SELECT statut FROM validation WHERE id_user=:id_user');
                            $requete1->execute(array(
                                'id_user' => $_SESSION['id']
                            ));
                            
                            while ($ligne=$requete1->fetch()){
                                
                                if($ligne[0] == 0){
                                    ?>
                                        <li class="nav-item">
                                            <a onclick=email() class="nav-link"><span style="font-size:150%;" class="lnr lnr-envelope" data-toggle="dropdown" role="button" aria-haspopup="true"
                                            aria-expanded="false">!</span></a>
                                        </li>
                                    <?php
                                }
                            }
                            $requete1->closeCursor();
                            ?>
                            <li class="nav-item submenu dropdown">
								<a href="login.php" class="nav-link dropdown-toggle"><span class="lnr lnr-user" data-toggle="dropdown" role="button" aria-haspopup="true"
								aria-expanded="false"></span></a>
								<ul class="dropdown-menu" style="margin-left: -80px;">
									<?php 
										if(isset($_SESSION['username'])){
											?>
											<li class="nav-item"><a class="nav-link" href="commandes.php">Mes commandes</a></li>
											<li class="nav-item"><a class="nav-link" href="moncompte.php">Mon compte</a></li>
											<li class="nav-item"><a class="nav-link" href="deconnexion.php">Se déconnecter</a></li>
											<?php
										}
										else{
											?>
											<li class="nav-item"><a class="nav-link" href="login.php">Se connecter</a></li>
											<?php
										}
										?>
								</ul>
							</li>
							
						</ul>
						<ul class="nav navbar-nav navbar-right">
						<li class="nav-item"><a href="cart.php" class="cart"><span class="ti-bag"></span><span class="badge"></span></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</div>
	<!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Paiement</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Accueil<span class="lnr lnr-arrow-right"></span></a>
                        <a href="checkout.php">Paiement</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                
                    <div class="col-lg-8">
                    <form method="post">
                                            
                        <h3 class="text-center">Details de Facturation & Livraison  </h3>
                        <div class="accordion" id="accordionExample">
                        <?php
                        $requete1 = $bdd->prepare('SELECT * FROM adresse_livraison WHERE id_user=:id_user LIMIT 1');
                        $requete1->execute(array(
                            'id_user' => $_SESSION['id']
                        ));
                        $nb_adresse=0;
                        while ($ligne=$requete1->fetch()){
                            $nb_adresse+=1;
                            ?>
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <input checked type="radio" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" name="radio" value="<?php echo $ligne[0];?>">
                                    Utiliser l'adresse : <?php echo $ligne[3]." ".$ligne[4].", ".$ligne[6]." ".$ligne[5];?>
                                    </input>
                                </h5>
                                </div>
                               <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                <?php echo "NOM :  <b>".$ligne[8]."</b>";?><br>
                                <?php echo "PRENOM :  <b>".$ligne[9]."</b>";?><br>
                                <?php echo "TELEPHONE :  <b>".$ligne[7]."</b>";?><br>
                                <?php echo "RUE :  <b>".$ligne[3]."</b>";?><br>
                                <?php echo "VILLE :  <b>".$ligne[4].", ".$ligne[6]." ".$ligne[5]."</b>";?><br>
                                </div>
                                </div>
                            </div>
                            <?php
                        }
                        $requete1->closeCursor();
                        if($nb_adresse ==0){
                            ?>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <input checked type="radio" name="radio" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" value="formulaire">
                                        Saisir une nouvelle adresse de livraison :
                                        </input>
                                    </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                            <!-- <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                                                             -->
                                                <div class="row contact_form" >            
                                                <div class="col-md-6 form-group p_star">
                                                    <input type="text" class="form-control" id="prenom" name="prenom">
                                                    <span class="placeholder" data-placeholder="Prénom"></span>
                                                </div>
                                                <div class="col-md-6 form-group p_star">
                                                    <input type="text" class="form-control" id="nom" name="nom">
                                                    <span class="placeholder" data-placeholder="Nom"></span>
                                                </div>
                                                <div class="col-md-12 form-group p_star">
                                                    <input type="text" class="form-control" id="adresse" name="adresse">
                                                    <span class="placeholder" data-placeholder="Adresse"></span>
                                                </div>
                                                <div class="col-md-12 form-group p_star">
                                                    <input type="text" class="form-control" id="ville" name="ville">
                                                    <span class="placeholder" data-placeholder="Ville"></span>
                                                </div>
                                                <div class="col-md-12 form-group p_star">
                                                    <input type="text" class="form-control" id="pays" name="pays">
                                                    <span class="placeholder" data-placeholder="Pays"></span>
                                                </div>
                                                
                                                <div class="col-md-6 form-group">
                                                    <input type="text" class="form-control" id="codepostal" name="codepostal" placeholder="Code Postal">
                                                </div>
                                                <div class="col-md-6 form-group p_star">
                                                    <input type="text" class="form-control" id="telephone" name="telephone">
                                                    <span class="placeholder" data-placeholder="Téléphone"></span>
                                                </div>
                                                </div>
                                            <!-- </form> -->
                                    </div>
                                    </div>
                                </div>
                        
                        <?php
                        }
                        else{?>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <input type="radio" name="radio" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" value="formulaire">
                                        Saisir une nouvelle adresse de livraison :
                                        </input>
                                    </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                            <!-- <form class="row contact_form" action="#" method="post" novalidate="novalidate"> -->
                                            <div class="row contact_form">            
                                                <div class="col-md-6 form-group p_star">
                                                    <input type="text" class="form-control" id="prenom" name="prenom">
                                                    <span class="placeholder" data-placeholder="Prénom"></span>
                                                </div>
                                                <div class="col-md-6 form-group p_star">
                                                    <input type="text" class="form-control" id="nom" name="nom">
                                                    <span class="placeholder" data-placeholder="Nom"></span>
                                                </div>
                                                <div class="col-md-12 form-group p_star">
                                                    <input type="text" class="form-control" id="adresse" name="adresse">
                                                    <span class="placeholder" data-placeholder="Adresse"></span>
                                                </div>
                                                <div class="col-md-12 form-group p_star">
                                                    <input type="text" class="form-control" id="ville" name="ville">
                                                    <span class="placeholder" data-placeholder="Ville"></span>
                                                </div>
                                                <div class="col-md-12 form-group p_star">
                                                    <input type="text" class="form-control" id="pays" name="pays">
                                                    <span class="placeholder" data-placeholder="Pays"></span>
                                                </div>
                                                
                                                <div class="col-md-6 form-group">
                                                    <input type="text" class="form-control" id="codepostal" name="codepostal" placeholder="Code Postal">
                                                </div>
                                                <div class="col-md-6 form-group p_star">
                                                    <input type="number" class="form-control" id="telephone" name="telephone" pattern="[0-9]{10}">
                                                    <span class="placeholder" data-placeholder="Téléphone"></span>
                                                </div>
                                                </div>
                                            <!-- </form> -->
                                    </div>
                                    </div>
                                </div>
                                <?php
                        }
                        ?>
                    </div>    
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Votre commande</h2>
                            <table id="purchase_summary" style="width:100%">
                                <tr>
                                    <th>Article</th>
                                    <th align="center" style="text-align: center">Quantité</th>
                                    <th align="right" style="text-align: right">Total</th>
                                </tr>
                            </table>
                            <ul class="list list_2">
                                <li><a href="#">Sous-total <span id="sub_total"></span></a></li>
                                <li><a href="#">Livraison <span id="livraion">5€</span></a></li>
                                <li><a href="#">Total <span id="total"></span></a></li>
                            </ul>
                            <script
                                src="https://www.paypal.com/sdk/js?client-id=Ab9LOTR2uxWzZAtl-lPWqxsZtUPrLCYbG-aPVdlmcxUnrA7AjwgBB_iKddRyrvZIDr0kvCm7XkurpyPV">
                            </script>
                            <div id="paypal-button-container"></div>
                            <!-- <script>
                            paypal.Buttons().render('#paypal-button-container');
                            </script> -->
                            <button style="display:none;" type="submit" value="submit" id="buttonCreate" class="primary-btn text-center" >VALIDER MA COMMANDE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        
    paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '10.0'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        document.getElementById("paypal-button-container").style.display = "none";
        document.getElementById("buttonCreate").style.display = "block";
        // alert('Transaction completed by ' + details.payer.name.given_name);
        // // Call your server to save the transaction
        // return fetch('/confirmation', {
        //   method: 'post',
        //   headers: {
        //     'content-type': 'application/json'
        //   },
        //   body: JSON.stringify({
        //     orderID: data.orderID
        //   })
        // });
      });
    }
  }).render('#paypal-button-container');

    function email(){
        swal({
            title: "Votre email n'est pas validée !!",
            text: "Si vous n'avez pas reçu d'email, appuyez sur OK pour renvoyer un lien d'activation !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if(willDelete){
                    $.ajax({
                        url : "send_verification.php",
                        data : {
                            modif : 'oublie'
                        },
                        cache : false,
                        success : function(response){
                            swal({
                            title: "Compte crée avec succès !",
                            text: "Veuilez dès à présent valider votre compte en cliquant sur le mail que vous avez reçu :)",
                            icon: "success"
                            })
                            .then((willDelete) => {
                                window.location.href = "index.php";
                                
                            });
                        },
                        error : function(error){
                            console.log(error);
                        }
                    });
                }
                else{
                        swal("Action annulée!", {
                        icon: "info",
                        });
                    }
            });
    }
    </script>
    <!--================End Checkout Area =================-->

     <!-- start footer Area -->
	<footer class="footer-area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12  col-md-12 col-sm-12 text-center">
					<div class="single-footer-widget">
						<h6>About Us</h6>
						<p>
							Site crée par ASHOKAR Harris et VILLEDIEU Anthony <br>
							Copyright &copy; 2019 . All rights reserved
						</p>
					</div>
				</div>
			
			</div>
			<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
				<p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
			</div>
		</div>
	</footer>
	<!-- End footer Area -->


    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/checkout.js"></script>
</body>

</html>