<?php
    session_start();
    require("parameters.php");

	
?><!DOCTYPE html>
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
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link href="css/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="css/style.css">
    <link href="css/style_track.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/main.css">
    <link href="css/select2.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link href="css/buttons.dataTables.min.css" rel="stylesheet" media="all">
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="js/dataTables.buttons.min.js"></script>
<script src="js/buttons.flash.min.js"></script>
<script src="js/buttons.html5.min.js"></script>
<script src="js/buttons.print.min.js"></script>
    
    
</head>

<body>
    <?php
        try{
            $bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
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
                    <h1>Suivre ma commande</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Accueil<span class="lnr lnr-arrow-right"></span></a>
                        <a href="commandes.php">Mes commandes<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Suivi de commande</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Tracking Box Area =================-->
    <section class="tracking_box_area section_gap">
    <h3 class="title-5 m-b-35 text-center">Commande Numéro : <?php echo $_GET['order'];?></h3>
        <?php 
            if(!isset($_SESSION['username'])){
                if(empty($_GET['order']) || empty($_GET['mail'])){
                    ?>
                        <script>
                        swal({
                            title :"Erreur ID de Commande Invalide !",
                            text : "connectez-vous pour avoir accès à votre commande ",
                            icon: "error",
                            timer: 3000
                        })
                        .then((willDelete) => {
                                window.location.href = "commandes.php";
                        
                        });
                        </script><?php 
                }
                else{
                    $requete = $bdd->prepare('SELECT DISTINCT(statut_commande),date_now FROM commande INNER JOIN panier AS p ON commande.id_panier = p.id_panier INNER JOIN users AS u ON p.id_user=u.id_user WHERE id_commande=:id_commande AND u.email=:email');
                    $requete->execute(array(
                        'id_commande' => $_GET['order'],
                        'email' => $_GET['mail']
                    ));
                    $existe=0;
                    while ($ligne=$requete->fetch()){
                        $existe=1;
                        if($ligne[0] =="valide"){
                            ?>
                            <div class="container">
                                <div class="row">
                                <div class="content">
                                    <div class="content2 d-flex justify-content-center">
                                        <div class="content2-header1">
                                            <p>Status : <span><?php echo $ligne[0];?></span></p>
                                        </div>
                                        <div class="content2-header1">
                                            <p>Expected Date : <span><?php echo $ligne[1];?> </span></p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="content3">
                                        <div class="shipment d-flex justify-content-center">
                                            <div class="confirm">
                                                <div class="imgcircle">
                                                    <img src="img/confirm.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>Confirmé</p>
                                            </div>
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/process.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>en cours de préparation</p>
                                            </div>
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/dispatch.png" alt="dispatch product">
                                                </div>
                                                <span class="line"></span>
                                                <p>Commande expédiée</p>
                                            </div>
                                            <div class="delivery">
                                                <div class="imgcircle">
                                                    <img src="img/delivery.png" alt="delivery">
                                                </div>
                                                <p>Commande délivrée</p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
                            <?php
                        }
                        elseif ($ligne[0] =="en cours validation") {
                            ?>
                            <div class="container">
                                <div class="row">
                                <div class="content">
                                    <div class="content2 d-flex justify-content-center">
                                        <div class="content2-header1">
                                            <p>Status : <span><?php echo $ligne[0];?></span></p>
                                        </div>
                                        <div class="content2-header1">
                                            <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="content3">
                                        <div class="shipment d-flex justify-content-center">
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/confirm.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>Confirmé</p>
                                            </div>
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/process.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>en cours de préparation</p>
                                            </div>
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/dispatch.png" alt="dispatch product">
                                                </div>
                                                <span class="line"></span>
                                                <p>Commande expédiée</p>
                                            </div>
                                            <div class="delivery">
                                                <div class="imgcircle">
                                                    <img src="img/delivery.png" alt="delivery">
                                                </div>
                                                <p>Commande délivrée</p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
                            <?php
                        }
                        elseif ($ligne[0] =="en cours preparation") {
                            ?>
                            <div class="container">
                                <div class="row">
                                <div class="content">
                                    <div class="content2 d-flex justify-content-center">
                                        <div class="content2-header1">
                                            <p>Status : <span><?php echo $ligne[0];?></span></p>
                                        </div>
                                        <div class="content2-header1">
                                            <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="content3">
                                        <div class="shipment d-flex justify-content-center">
                                            <div class="confirm">
                                                <div class="imgcircle">
                                                    <img src="img/confirm.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>Confirmé</p>
                                            </div>
                                            <div class="confirmfinal">
                                                <div class="imgcircle">
                                                    <img src="img/process.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>en cours de préparation</p>
                                            </div>
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/dispatch.png" alt="dispatch product">
                                                </div>
                                                <span class="line"></span>
                                                <p>Commande expédiée</p>
                                            </div>
                                            <div class="delivery">
                                                <div class="imgcircle">
                                                    <img src="img/delivery.png" alt="delivery">
                                                </div>
                                                <p>Commande délivrée</p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
                            <?php
                        }
                        elseif ($ligne[0] =="annule") {
                            ?>
                            <div class="container">
                                <div class="row">
                                <div class="content">
                                    <div class="content2 d-flex justify-content-center">
                                        <div class="content2-header1">
                                            <p>Status : <span><?php echo $ligne[0];?></span></p>
                                        </div>
                                        <div class="content2-header1">
                                            <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="content3">
                                        <div class="shipment d-flex justify-content-center">
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/confirm.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>Confirmé</p>
                                            </div>
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/process.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>en cours de préparation</p>
                                            </div>
                                            <div class="dispatch">
                                                <div class="imgcircle">
                                                    <img src="img/dispatch.png" alt="dispatch product">
                                                </div>
                                                <span class="line"></span>
                                                <p>Commande expédiée</p>
                                            </div>
                                            <div class="delivery">
                                                <div class="imgcircle">
                                                    <img src="img/delivery.png" alt="delivery">
                                                </div>
                                                <p>Commande délivrée</p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
                            <?php
                        }
                        elseif ($ligne[0] =="expedie") {
                            ?>
                            <div class="container">
                                <div class="row">
                                <div class="content">
                                    <div class="content2 d-flex justify-content-center">
                                        <div class="content2-header1">
                                            <p>Status : <span><?php echo $ligne[0];?></span></p>
                                        </div>
                                        <div class="content2-header1">
                                            <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="content3">
                                        <div class="shipment d-flex justify-content-center">
                                            <div class="confirm">
                                                <div class="imgcircle">
                                                    <img src="img/confirm.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>Confirmé</p>
                                            </div>
                                            <div class="confirmfinal">
                                                <div class="imgcircle">
                                                    <img src="img/process.png">
                                                </div>
                                                <span class="line"></span>
                                                <p>en cours de préparation</p>
                                            </div>
                                            <div class="confirmfinal">
                                                <div class="imgcircle">
                                                    <img src="img/dispatch.png" alt="dispatch product">
                                                </div>
                                                <span class="line"></span>
                                                <p>Commande expédiée</p>
                                            </div>
                                            <div class="delivery">
                                                <div class="imgcircle">
                                                    <img src="img/delivery.png" alt="delivery">
                                                </div>
                                                <p>Commande délivrée</p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
                            <?php
                        }
                    }
                    if($existe == 0){
                        ?>
                        <script>
                        swal("Erreur ID de Commande Invalide !", {
                            icon: "error",
                            timer: 3000
                        })
                        .then((willDelete) => {
                                window.location.href = "commandes.php";
                        
                        });
                        </script><?php
                    }
                }
            }
            else{
                $requete = $bdd->prepare('SELECT DISTINCT(statut_commande),date_now FROM commande INNER JOIN panier AS p ON commande.id_panier = p.id_panier WHERE id_commande=:id_commande AND id_user=:id_user');
                $requete->execute(array(
                    'id_commande' => $_GET['order'],
                    'id_user' => $_SESSION['id']
                ));
                $existe=0;
                while ($ligne=$requete->fetch()){
                    $existe=1;
                    if($ligne[0] =="valide"){
                        ?>
                        <div class="container">
                            <div class="row">
                            <div class="content">
                                <div class="content2 d-flex justify-content-center">
                                    <div class="content2-header1">
                                        <p>Status : <span><?php echo $ligne[0];?></span></p>
                                    </div>
                                    <div class="content2-header1">
                                        <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="content3">
                                    <div class="shipment d-flex justify-content-center">
                                        <div class="confirm">
                                            <div class="imgcircle">
                                                <img src="img/confirm.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>Confirmé</p>
                                        </div>
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/process.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>en cours de préparation</p>
                                        </div>
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/dispatch.png" alt="dispatch product">
                                            </div>
                                            <span class="line"></span>
                                            <p>Commande expédiée</p>
                                        </div>
                                        <div class="delivery">
                                            <div class="imgcircle">
                                                <img src="img/delivery.png" alt="delivery">
                                            </div>
                                            <p>Commande délivrée</p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                                
                            </div>
                        </div>
                        <?php
                    }
                    elseif ($ligne[0] =="en cours validation") {
                        ?>
                        <div class="container">
                            <div class="row">
                            <div class="content">
                                <div class="content2 d-flex justify-content-center">
                                    <div class="content2-header1">
                                        <p>Status : <span><?php echo $ligne[0];?></span></p>
                                    </div>
                                    <div class="content2-header1">
                                        <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="content3">
                                    <div class="shipment d-flex justify-content-center">
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/confirm.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>Confirmé</p>
                                        </div>
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/process.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>en cours de préparation</p>
                                        </div>
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/dispatch.png" alt="dispatch product">
                                            </div>
                                            <span class="line"></span>
                                            <p>Commande expédiée</p>
                                        </div>
                                        <div class="delivery">
                                            <div class="imgcircle">
                                                <img src="img/delivery.png" alt="delivery">
                                            </div>
                                            <p>Commande délivrée</p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                                
                            </div>
                        </div>
                        <?php
                    }
                    elseif ($ligne[0] =="en cours preparation") {
                        ?>
                        <div class="container">
                            <div class="row">
                            <div class="content">
                                <div class="content2 d-flex justify-content-center">
                                    <div class="content2-header1">
                                        <p>Status : <span><?php echo $ligne[0];?></span></p>
                                    </div>
                                    <div class="content2-header1">
                                        <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="content3">
                                    <div class="shipment d-flex justify-content-center">
                                        <div class="confirm">
                                            <div class="imgcircle">
                                                <img src="img/confirm.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>Confirmé</p>
                                        </div>
                                        <div class="confirmfinal">
                                            <div class="imgcircle">
                                                <img src="img/process.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>en cours de préparation</p>
                                        </div>
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/dispatch.png" alt="dispatch product">
                                            </div>
                                            <span class="line"></span>
                                            <p>Commande expédiée</p>
                                        </div>
                                        <div class="delivery">
                                            <div class="imgcircle">
                                                <img src="img/delivery.png" alt="delivery">
                                            </div>
                                            <p>Commande délivrée</p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                                
                            </div>
                        </div>
                        <?php
                    }
                    elseif ($ligne[0] =="annule") {
                        ?>
                        <div class="container">
                            <div class="row">
                            <div class="content">
                                <div class="content2 d-flex justify-content-center">
                                    <div class="content2-header1">
                                        <p>Status : <span><?php echo $ligne[0];?></span></p>
                                    </div>
                                    <div class="content2-header1">
                                        <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="content3">
                                    <div class="shipment d-flex justify-content-center">
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/confirm.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>Confirmé</p>
                                        </div>
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/process.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>en cours de préparation</p>
                                        </div>
                                        <div class="dispatch">
                                            <div class="imgcircle">
                                                <img src="img/dispatch.png" alt="dispatch product">
                                            </div>
                                            <span class="line"></span>
                                            <p>Commande expédiée</p>
                                        </div>
                                        <div class="delivery">
                                            <div class="imgcircle">
                                                <img src="img/delivery.png" alt="delivery">
                                            </div>
                                            <p>Commande délivrée</p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                                
                            </div>
                        </div>
                        <?php
                    }
                    elseif ($ligne[0] =="expedie") {
                        ?>
                        <div class="container">
                            <div class="row">
                            <div class="content">
                                <div class="content2 d-flex justify-content-center">
                                    <div class="content2-header1">
                                        <p>Status : <span><?php echo $ligne[0];?></span></p>
                                    </div>
                                    <div class="content2-header1">
                                        <p>Expected Date : <span><?php echo $ligne[1];?></span></p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="content3">
                                    <div class="shipment d-flex justify-content-center">
                                        <div class="confirm">
                                            <div class="imgcircle">
                                                <img src="img/confirm.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>Confirmé</p>
                                        </div>
                                        <div class="confirmfinal">
                                            <div class="imgcircle">
                                                <img src="img/process.png">
                                            </div>
                                            <span class="line"></span>
                                            <p>en cours de préparation</p>
                                        </div>
                                        <div class="confirmfinal">
                                            <div class="imgcircle">
                                                <img src="img/dispatch.png" alt="dispatch product">
                                            </div>
                                            <span class="line"></span>
                                            <p>Commande expédiée</p>
                                        </div>
                                        <div class="delivery">
                                            <div class="imgcircle">
                                                <img src="img/delivery.png" alt="delivery">
                                            </div>
                                            <p>Commande délivrée</p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                                
                            </div>
                        </div>
                        <?php
                    }
                }
                if($existe == 0){
                    ?>
                    <script>
                    swal("Erreur ID de Commande Invalide !", {
                        icon: "error",
                        timer: 3000
                    })
                    .then((willDelete) => {
                            window.location.href = "commandes.php";
                    
                    });
                    </script><?php
                }
            }
            
        ?>
        
    </section>
    <!--================End Tracking Box Area =================-->

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
</body>

</html>