<?php
    session_start();
    require("parameters.php");
    if(!isset($_SESSION['username'])){
		header('Location: login.php');
    }
    
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
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
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
							<li class="nav-item "><a class="nav-link" href="index.php">Home</a></li>
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
								<li class="nav-item submenu active dropdown">
									<a href="#" class="nav-link  dropdown-toggle">Administration</a>
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
     

    <!--================Blog Area =================-->
    <br/><br/>
    <br/>
    <section class="blog_area single-post-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h3 class="title-5 m-b-35 text-center">Liste des commandes : </h3>
                <style>
                    .dataTables_filter input { background-color : #ddd; };
                </style>
                
                <table id="table_id" class="table table-data2 display">
                    <thead>
                        <tr>
                            <th>ID Commande</th>
                            <th>Nom d'utilisateur</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $requete = $bdd->prepare('SELECT DISTINCT(id_commande),u.username,statut_commande FROM commande INNER JOIN panier as p ON commande.id_panier = p.id_panier INNER JOIN article AS a ON p.id_article = a.id_article INNER JOIN users u ON p.id_user=u.id_user;');
                            $requete->execute();
                            while ($ligne=$requete->fetch()){
                                echo "<tr>";
                                echo "<td>".$ligne[0]."</td>";
                                echo "<td>".$ligne[1]."</td>";
                                if($ligne[2] == "en cours validation"){
                                    echo "<td><span class='status--warning'>".$ligne[2]."</td><td>";
                                    ?>
                                    <div class="table-data-feature">
                                    <?php 
                                    echo "<button onclick=valid('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Valider la commande'>
                                    <i class='zmdi zmdi-check'></i>
                                    </button>";
                                    echo "<button onclick=annul('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Annuler la commande'>
                                    <i class='zmdi zmdi-close'></i>
                                    </button>";
                                }
                                elseif ($ligne[2] == "valide") {
                                    echo "<td><span class='status--off'>".$ligne[2]."</td><td>";
                                        ?>
                                    <div class="table-data-feature">
                                    <?php 
                                    echo "<button onclick=prepa('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Préparer la commande'>
                                    <i class='zmdi zmdi-inbox'></i>
                                    </button>";
                                }
                                elseif ($ligne[2] == "en cours preparation") {
                                    echo "<td><span class='status--prepa'>".$ligne[2]."</td><td>";
                                    ?>
                                    <div class="table-data-feature">
                                    <?php 
                                    echo "<button onclick=expedier('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Expédier la commande'>
                                    <i class='zmdi zmdi-airplane'></i>
                                    </button>";
                                    
                                }
                                elseif ($ligne[2] == "expedie") {
                                    echo "<td><span class='status--process'>".$ligne[2]."</td><td>";
                                    ?>
                                    <div class="table-data-feature">
                                    <?php 
                                    echo "<button onclick=suppr('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Supprimer la commande'>
                                    <i class='zmdi zmdi-delete'></i>
                                    </button>";
                                }
                                elseif ($ligne[2] == "annule") {
                                    echo "<td><span class='status--denied'>".$ligne[2]."</td><td>";
                                    ?>
                                    <div class="table-data-feature">
                                    <?php 
                                    echo "<button onclick=suppr('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Supprimer la commande'>
                                    <i class='zmdi zmdi-delete'></i>
                                    </button>";
                                }
                                  
                                
                                
                                ?>
                                </div><?php
                                echo "</td></tr>";
                            }
                            $requete->CloseCursor();?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </section>
    <script>
        function annul(id_commande){
            swal({
            title: "Etes-vous sur de vouloir annuler cette commande ?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_commande);
                    $.ajax({
                        url : "modif_commande.php",
                        data : {
                            typeChgmnt: 'annuler',
                            id_commande: id_commande
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncommandes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });    
        }
        function valid(id_commande){
            swal({
            title: "Etes-vous sur de vouloir valider cette commande ?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "success",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_commande);
                    $.ajax({
                        url : "modif_commande.php",
                        data : {
                            typeChgmnt: 'valider',
                            id_commande: id_commande
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncommandes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });
            
        }
        function prepa(id_commande){
            swal({
            title: "Etes-vous sur de vouloir préparer cette commande ?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "info",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_commande);
                    $.ajax({
                        url : "modif_commande.php",
                        data : {
                            typeChgmnt: 'preparer',
                            id_commande: id_commande
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncommandes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });
            
        }
        function expedier(id_commande){
            swal({
            title: "Etes-vous sur de vouloir expédier cette commande ?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "info",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_commande);
                    $.ajax({
                        url : "modif_commande.php",
                        data : {
                            typeChgmnt: 'expedier',
                            id_commande: id_commande
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncommandes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });
            
        }
        function suppr(id_commande){
            swal({
            title: "Etes-vous sur de vouloir supprimer cet commande?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_commande);
                    $.ajax({
                        url : "modif_commande.php",
                        data : {
                            typeChgmnt: 'suppression',
                            id_commande: id_commande
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncommandes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            }); 
        }
        $("#table_id").DataTable( {
            "language": {
                "lengthMenu": "Affichage _MENU_ ligne par page ",
                "zeroRecords": "Désolé Rien trouvé",
                "info": "Affichage de la page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun fichier trouvé",
                "infoFiltered": "(filtré parmi _MAX_ lignes au total)",
                "search":"rechercher"
            },
            "paging" : false,
            stateSave: true,
            aLengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Tout"]
            ]
        });
        
    </script>
    <!--================Blog Area =================-->

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
    <script src="js/select2.min.js"></script>
</body>

</html>