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
    <link href="css/theme.css" rel="stylesheet" media="all">
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
								<ul class="dropdown-menu">
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
     <?php
        if(isset($_POST['buttonajout'])){
            if(!empty($_POST['name'])){
                $nomf = str_replace(" ","_",$_FILES['fichier']['name']);
                $now = date("Y-m-d_H-i-s");
                $nomf_sansDoublon = $now."-".$nomf;
                
                // On vérifie que le dossier personnel existe
                if(file_exists($path_image)){
                    
                    // Si le téléchargement c'est bien effectué
                    if(move_uploaded_file($_FILES['fichier']['tmp_name'],$path_image."/".$nomf)){
                        
                        try{
                            // on insere l'article
                            $requete2 = $bdd->prepare('INSERT INTO article (nom_article,description_article,id_categorie,stock_article,lien_image) VALUE(:nom_article,:description_article,:id_categorie,:stock_article,:lien_image);');
                            $requete2->execute(array(
                                'nom_article' => $_POST['name'],
                                'description_article' => $_POST['description'],
                                'id_categorie' => $_POST['categorie'],
                                'stock_article' => $_POST['quantity'],
                                'lien_image' => $nomf
                            ));
                            $requete2->closeCursor();
                            // on recupere l'id qui vient d'etre inserer
                            $requete1 = $bdd->prepare('SELECT id_article FROM article WHERE nom_article=:nom_article AND lien_image=:lien_image');
                            $requete1->execute(array(
                                'nom_article' => $_POST['name'],
                                'lien_image' => $nomf
                            ));
                            
                            while ($ligne=$requete1->fetch()){
                                $id_article = $ligne[0];
                            }
                            $requete1->closeCursor();
                            // on insere le prix
                            $requete = $bdd->prepare('INSERT INTO prix VALUE(:id_article,:prix)');
                            $requete->execute(array(
                                'id_article' => $id_article,
                                'prix' => $_POST['price']
                            ));
                            $requete->closeCursor();
                            ?>
                            <script>
                                swal({
                                title: "Article ajouté avec succès !",
                                text: "",
                                icon: "success"
                                })
                                .then((willDelete) => {
                                    window.location.href = "gestionarticles.php";
                                });
                            </script>
                            <?php
                        }
                        catch (Exception $e){
                            die('Erreur : ' . $e->getMessage());
                        }
                    }
                }
            } 
        }
     ?>

    <!--================Blog Area =================-->
    <br/><br/>
    <br/>
    <section class="blog_area single-post-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-3">
                    <div class="blog_info text-right">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Gestion des articles </a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Ajouter un article</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9  col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <style>
									.dataTables_filter input { background-color : #ddd; };
								</style>
                                
                                <table id="table_id" class="table table-data2 display">
                                    <thead>
                                        <tr>
                                            <th>Article</th>
                                            <th>Prix</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $requete = $bdd->prepare('SELECT * FROM article;');
                                            $requete->execute();
                                            while ($ligne=$requete->fetch()){
                                                echo "<tr>";
                                                echo "<td>".$ligne[1]."</td>";
                                                // Pour echo le prix
                                                $requete1 = $bdd->prepare('SELECT prix FROM prix WHERE id_article=:id_article');
                                                $requete1->execute(array(
                                                    'id_article' => $ligne[0]
                                                ));
                                                while ($ligne1=$requete1->fetch()){
                                                    echo "<td>".$ligne1[0]."&euro;</td>";
                                                }
                                                
                                                $requete1->closeCursor();
                                                // FIN DU PRIX
                                                echo "<td>".$ligne[4]."</td><td>";?>
                                                <div class="table-data-feature">
                                                <?php 
                                                echo "<button onclick=valid('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Gérer les stocks' >
                                                <i class='zmdi zmdi-plus'></i>
                                                </button>";
                                                echo "<button onclick=suppr('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Supprimer'>
                                                    <i class='zmdi zmdi-delete'></i>
                                                </button>";
                                                echo "<button onclick=prix('$ligne[0]') class='item' data-toggle='tooltip' data-placement='top' title='Modifier le prix'>
                                                    <i class='zmdi zmdi-money'></i>
                                                </button>"; 
                                                ?>
                                                </div><?php
                                                echo "</td></tr>";
                                            }
                                            $requete->CloseCursor();
                                        ?>
                                        
                                    </tbody>
                                </table>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="comment-form">
                            <h4>Ajouter un article </h4>
                            <form method="post" id="form1" enctype="multipart/form-data">
                                <div class="form-group form-inline">
                                    <div class="form-group col-lg-6 col-md-6 name">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nom de l'article" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Nom de l article'">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 email">
                                        <select name="categorie" id="categorie" class="form-control">
                                        
											<?php
                                            $query1=$bdd->prepare('SELECT * FROM categorie');
            								$query1->execute();
            								while ($ligne1=$query1->fetch()){
            									
            									echo "<option value='".$ligne1[0]."'>".$ligne1[2]."</option>";
            								}
                                            $query1->closeCursor();
                                            ?>
										</select>
                                    </div>
                                </div>
                                <style>
                                    .plus-minus-input {
                                    -webkit-align-items: center;
                                        -ms-flex-align: center;
                                            align-items: center;
                                    }

                                    .plus-minus-input .input-group-field {
                                    text-align: center;
                                    margin-left: 0.5rem;
                                    margin-right: 0.5rem;
                                    padding: 1rem;
                                    }

                                    .plus-minus-input .input-group-field::-webkit-inner-spin-button,
                                    .plus-minus-input .input-group-field ::-webkit-outer-spin-button {
                                    -webkit-appearance: none;
                                            appearance: none;
                                    }

                                    .plus-minus-input .input-group-button .circle {
                                    border-radius: 50%;
                                    padding: 0.25em 0.8em;
                                    }  
                                </style>
                                <!-- QUANTITE-->
                                <div class="form-group form-inline">
                                    <div class="form-group col-lg-12 col-md-12">
                                    <div class="input-group plus-minus-input">
                                        <h5>Quantité :</h5>
                                        <div class="input-group-button">
                                            <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <input class="input-group-field" type="number" name="quantity" value="0">
                                        <div class="input-group-button">
                                            <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>  
                                    </div>
                                    <br><br><br>
                                    <div class="form-group col-lg-12 col-md-12">
                                    <h5>Prix :</h5>
                                    <input type="number" name="price" value="1" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="currency" id="c1" />
                                    </div>
                                    <br><br><br>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <input type="text" class="form-control" name="description" id="description" placeholder="Description de l'article" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Description de l article'">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6"><br/><br/>
                                    <input id="file-select" type="file" name="fichier"><br/>
                                    </div>
                                </div>
                                
                                <button type="submit" value="submit" name="buttonajout" id="buttonajout" class="primary-btn">Ajouter</button>
                            </form>
                            
                        </div>
                        
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        
    </section>
    <script>
        jQuery(document).ready(function(){
            // This button will increment the value
            $('[data-quantity="plus"]').click(function(e){
                // Stop acting like a button
                e.preventDefault();
                // Get the field name
                fieldName = $(this).attr('data-field');
                // Get its current value
                var currentVal = parseInt($('input[name='+fieldName+']').val());
                // If is not undefined
                if (!isNaN(currentVal)) {
                    // Increment
                    $('input[name='+fieldName+']').val(currentVal + 1);
                } else {
                    // Otherwise put a 0 there
                    $('input[name='+fieldName+']').val(0);
                }
            });
            // This button will decrement the value till 0
            $('[data-quantity="minus"]').click(function(e) {
                // Stop acting like a button
                e.preventDefault();
                // Get the field name
                fieldName = $(this).attr('data-field');
                // Get its current value
                var currentVal = parseInt($('input[name='+fieldName+']').val());
                // If it isn't undefined or its greater than 0
                if (!isNaN(currentVal) && currentVal > 0) {
                    // Decrement one
                    $('input[name='+fieldName+']').val(currentVal - 1);
                } else {
                    // Otherwise put a 0 there
                    $('input[name='+fieldName+']').val(0);
                }
            });
        });


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
        function valid(id_article){
            swal("Voulez vous modifier le stock de cet article ?", {
                icon: "warning",
                content:"input",
                buttons: true,
                dangerMode: true,
                })
                .then((value) => {
                    if(value){
                        var stock = value;
                        console.log(stock);
                        console.log(id_article);
                        $.ajax({
                            url : "modif_article.php",
                            data : {
                                typeChgmnt: 'stock',
                                id_article: id_article,
                                stock : stock
                            },
                            cache : false,
                            success : function(response){
                                swal("Action traitée avec succès!", {
                                    icon: "success",
                                    timer: 3000
                                })
                                .then((willDelete) => {
                                        window.location.href = "gestionarticles.php";
                                
                                });
                            },
                            error : function(request, error){
                                console.log(error);
                            }
                        });
                    }
                    else{
                        swal("Changement de prix annulé!", {
                        icon: "info",
                        });
                    }
                });
            
        }
        function suppr(id_article){
            swal({
            title: "Etes-vous sur de vouloir supprimer cet article?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_article);
                    $.ajax({
                        url : "modif_article.php",
                        data : {
                            typeChgmnt: 'suppression',
                            id_article: id_article
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "gestionarticles.php";
                            
                            });
                        },
                        error : function(request, error){
                            console.log(error);
                        }
                    });
                } 
            });
            
        }
        function prix(id_article){
            swal("Voulez vous modifier le prix de cet article ?", {
                icon: "warning",
                content:"input",
                buttons: true,
                dangerMode: true,
                })
                .then((value) => {
                    if(value){
                        var prix = value;
                        console.log(prix);
                        console.log(id_article);
                        $.ajax({
                            url : "modif_article.php",
                            data : {
                                typeChgmnt: 'prix',
                                id_article: id_article,
                                prix : prix
                            },
                            cache : false,
                            success : function(response){
                                swal("Action traitée avec succès!", {
                                    icon: "success",
                                    timer: 3000
                                })
                                .then((willDelete) => {
                                        window.location.href = "gestionarticles.php";
                                
                                });
                            },
                            error : function(request, error){
                                console.log(error);
                            }
                        });
                    }
                    else{
                        swal("Changement de prix annulé!", {
                        icon: "info",
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
    <script src="js/select2.min.js"></script>
    <script src="js/main.js"></script>
   
</body>
</html>