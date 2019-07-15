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
     

    <!--================Blog Area =================-->
    <br/><br/>
    <br/>
    <section class="blog_area single-post-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h3 class="title-5 m-b-35 text-center">Liste des comptes utilisateur : </h3>
                <style>
                    .dataTables_filter input { background-color : #ddd; };
                </style>
                
                <table id="table_id" class="table table-data2 display">
                    <thead>
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $requete = $bdd->prepare('SELECT users.id_user,username,users.statut,v.statut FROM users INNER JOIN validation as v ON users.id_user = v.id_user;');
                            $requete->execute();
                            while ($ligne=$requete->fetch()){
                                echo "<tr>";
                                echo "<td>".$ligne[1]."</td>";
                                
                                if($ligne[3] != "1"){
                                     echo "<td><span class='status--denied'>Email non validé</span></td><td>";
                                }
                                else{
                                    if($ligne[2] == 1){
                                        echo "<td><span class='status--process'>Compte activé</span></td><td>";
                                        
                                    }
                                    elseif ($ligne[2] == 2) {
                                        echo "<td><span class='status--process'>Compte activé : Administrateur</span></td><td>";
                                        
                                    }
                                    elseif ($ligne[2] == 3) {
                                        echo "<td><span class='status--process'>Compte activé :  Super-Administrateur</span></td><td>";
                                    }
                                    else{
                                        echo "<td><span class='status--denied'>Compte désactivé</span></td><td>";
                                    }
                                    
                                }
                                ?>
                                <div class="table-data-feature">
                                <?php 
                                if($_SESSION['statut'] == "2"){
                                    if($_SESSION['statut'] > $ligne[2]){
                                        // il peux promouvoir et desactiver et supprimer
                                        if($ligne[2] == 0){
                                            echo "<button onclick=activ('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Activer le compte' >
                                            <i class='zmdi zmdi-eye'></i>
                                            </button>";
                                        }
                                        else{
                                            echo "<button onclick=desact('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Désactiver le compte' >
                                            <i class='zmdi zmdi-eye-off'></i>
                                            </button>";
                                        }
                                            echo "<button onclick=suppr('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Supprimer le compte'>
                                            <i class='zmdi zmdi-delete'></i>
                                        </button>";
                                        if($ligne[2] != 0){
                                        echo "<button onclick=prom('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Promouvoir le compte'>
                                            <i class='zmdi zmdi-thumb-up'></i>
                                        </button>";
                                        } 
                                    }
                                }
                                elseif ($_SESSION['statut'] == "3") {
                                    if($_SESSION['statut'] > $ligne[2]){
                                        // il peux promouvoir retrograder desactiver et supprimer.
                                        if($ligne[2] == 0){
                                            echo "<button onclick=activ('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Activer le compte' >
                                            <i class='zmdi zmdi-eye'></i>
                                            </button>";
                                        }
                                        else{
                                            echo "<button onclick=desact('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Désactiver le compte' >
                                            <i class='zmdi zmdi-eye-off'></i>
                                            </button>";
                                        }
                                        echo "<button onclick=suppr('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Supprimer le compte'>
                                            <i class='zmdi zmdi-delete'></i>
                                        </button>";
                                        echo "<button onclick=prom('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Promouvoir le compte'>
                                            <i class='zmdi zmdi-thumb-up'></i>
                                        </button>";
                                        if($ligne[2] != 0){
                                        echo "<button onclick=retro('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Dégrader le compte'>
                                            <i class='zmdi zmdi-thumb-down'></i>
                                        </button>";
                                        }
                                    }
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
        function desact(id_user){
            swal({
            title: "Etes-vous sur de vouloir désactiver cet utilisateur?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_user);
                    $.ajax({
                        url : "modif_user.php",
                        data : {
                            typeChgmnt: 'desactiver',
                            id_user: id_user
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncomptes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });    
        }
        function activ(id_user){
            swal({
            title: "Etes-vous sur de vouloir Activer cet utilisateur?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_user);
                    $.ajax({
                        url : "modif_user.php",
                        data : {
                            typeChgmnt: 'activer',
                            id_user: id_user
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncomptes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });
            
        }
        function prom(id_user){
            swal({
            title: "Etes-vous sur de vouloir promouvoir cet utilisateur?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_user);
                    $.ajax({
                        url : "modif_user.php",
                        data : {
                            typeChgmnt: 'promouvoir',
                            id_user: id_user
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncomptes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });
            
        }
        function retro(id_user){
            swal({
            title: "Etes-vous sur de vouloir retrograder cet utilisateur?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_user);
                    $.ajax({
                        url : "modif_user.php",
                        data : {
                            typeChgmnt: 'retrograder',
                            id_user: id_user
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncomptes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });
            
        }
        function suppr(id_user){
            swal({
            title: "Etes-vous sur de vouloir supprimer cet utilisateur?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_user);
                    $.ajax({
                        url : "modif_user.php",
                        data : {
                            typeChgmnt: 'suppression',
                            id_user: id_user
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestioncomptes.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            }); 
        }
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