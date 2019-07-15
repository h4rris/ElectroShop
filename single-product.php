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
	<!--
			CSS
			============================================= -->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="css/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <script src="js/sweetalert.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore.js"></script>
    <link rel="stylesheet" href="css/style.css">

    
<script language="javascript" type="text/javascript">
	function removeSpaces(string) {
	return string.split(' ').join('');
	}
	</script>
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
	<?php
		try
		{
			$id_article = $_GET['id_article'];
			$bdd = new PDO('mysql:host=localhost;dbname=ElectroShop;charset=utf8', 'root', '');

			//Récupération des articles
			$reponse = $bdd->query('SELECT * FROM categorie 
										JOIN article ON categorie.id_categorie = article.id_categorie 
    									JOIN prix ON article.id_article = prix.id_article
    									WHERE article.id_article = '. $id_article);
			$donnees_articles = $reponse->fetchAll();
			if($reponse->rowCount() == 0){
				header('Location: category.php');
			}
		}
		catch (Exception $e)
		{
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
							if(isset($_SESSION['id'])){
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
					<h1>Details du produit</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.php">Articles<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Details du produit</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Single Product Area =================-->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="img/product/<?php echo reset($donnees_articles)['lien_image']; ?>" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="img/product/<?php echo reset($donnees_articles)['lien_image']; ?>"alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="img/product/<?php echo reset($donnees_articles)['lien_image']; ?>" alt="">
						</div>
					</div>
				</div>
				
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3 id="nom_article"><?php echo reset($donnees_articles)['nom_article']; ?></h3>
						<h2 id="prix"><?php echo reset($donnees_articles)['prix']."€"; ?></h2>
						<ul class="list">
							<li><a class="active"><span>Catégorie</span> : <?php echo reset($donnees_articles)['texte_categorie']; ?></a></li>
							<li><a><span>Disponibilité</span> : <?php if(reset($donnees_articles)['stock_article'] >1) { echo reset($donnees_articles)['stock_article']. ' articles en stock'; } else { echo '<span style="color:red;width: 150px;">En rupture de stock</span>';} ?></a></li>
						</ul>
						<?php
						$requete = $bdd->prepare('SELECT description_article FROM article WHERE id_article=:id_article;');
						$requete->execute(array(
							'id_article' => $_GET['id_article']
						));
						while ($ligne=$requete->fetch()){
							echo '<p>'.$ligne[0].'</p>';
						}
						$requete->closeCursor();
						?>		
						<div id="product_add_to_cart">
							<div class="product_count">
								<label for="qty">Quantity:</label>
								<input id="quantity" type="text" name="qty" id="sst" max="<?php echo reset($donnees_articles)['stock_article']; ?>" value="1" title="Quantity:" class="input-text qty">
								<button class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
								<button class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
							</div>
							<div class="card_area d-flex align-items-center">
								<a id="add_to_cart" data-id_article="<?php echo reset($donnees_articles)['id_article']; ?>" class="primary-btn" style="color: white">Ajouter dans le panier</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->

	<!--================Product Description Area =================-->
	<script>
		function action_com(id_user,id_article){
			var sansspace = removeSpaces(document.getElementById("message").value);
			$(document).ready(function() {
					var comm =document.getElementById("message").value;
					if(sansspace.length == 0){
						console.log("vide");
					}
					else{
						var star1 =document.getElementById("id_stars1").className;
						var star2 =document.getElementById("id_stars2").className;
						var star3 =document.getElementById("id_stars3").className;
						var star4 =document.getElementById("id_stars4").className;
						var star5 =document.getElementById("id_stars5").className;
						var nbetoile;
						if(star1 =='fa fa-star-o'){
							nbetoile='0';
						}
						else{
							if(star2 =='fa fa-star-o'){
								nbetoile='1';
							}
							else{
								if(star3 =='fa fa-star-o'){
									nbetoile='2';
								}
								else{
									if(star4 =='fa fa-star-o'){
										nbetoile='3';
									}
									else{
										if(star5 =='fa fa-star-o'){
											nbetoile='4';
										}
										else{
											nbetoile='5';
										}
									}
								}
							}

						}
						swal({
							title: "Etes-vous sur de vouloir ajouter ce commentaire ?",
							text: "Si oui, finaliser l'action, si non annuler",
							icon: "info",
							buttons: true,
							dangerMode: true,
							})
							.then((willDelete) => {
								if (willDelete) {
									$.ajax({
										url : "add_comment.php",
										data : {
											id_user: id_user,
											id_article :id_article,
											comm :comm,
											nbetoile : nbetoile
										},
										cache : false,
										success : function(response){
											swal("Action traitée avec succès!", {
												icon: "success",
												timer: 3000
											})
											.then((willDelete) => {
													window.location.href = "single-product.php?id_article="+id_article;
											
											});
										},
										error : function(request, error){
											console.log(error);
										}
									});
								} 
							});
					}
					
			});
		}
	</script>
	<section class="product_description_area">
		<div class="container">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<h4>COMMENTAIRES</h4>
			</ul>
			<div class="tab-content" id="myTabContent">
				
				<div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
					<div class="row">
						<div class="col-lg-6">
							<div class="row total_rate">
								<div class="col-6">
									<div class="box_total">
										<h5>NOTE MOYENNE</h5>
										<?php 
											$requete1 = $bdd->prepare('SELECT COUNT(nb_etoile),SUM(nb_etoile) FROM commentaires WHERE id_article=:id_article');
											$requete1->execute(array(
												'id_article' => $_GET['id_article']
											));
											$total=0;
											$nb_etoile=0;
											while ($ligne=$requete1->fetch()){
												$nb_etoile=$ligne[0];
												$total=$ligne[1];
											}
											if($nb_etoile == 0){
												echo '<h4>0.00</h4>';
											}
											else{
												echo '<h4>'.round(floatval($total) / $nb_etoile,2).'</h4>';
											}
											echo '<h6>('.$nb_etoile.' commentaires)</h6>';
											$requete1->closeCursor(); 
										?>
										
									</div>
								</div>
								<div class="col-6">
									<div class="rating_list">
										<h3>Basé sur <?php echo $nb_etoile; ?> notes</h3>
										<ul class="list">
											<li><a><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
													 class="fa fa-star"></i><i class="fa fa-star"></i> &nbsp;<span id="5_stars"></span></a></li>
											<li><a><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
													 class="fa fa-star"> &nbsp;</i><span id="4_stars"></span></a></li>
											<li><a><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> &nbsp;<span id="3_stars"></span></a></li>
											<li><a><i class="fa fa-star"></i><i class="fa fa-star"></i> &nbsp;<span id="2_stars"></span></a></li>
											<li><a><i class="fa fa-star"></i></i> &nbsp;<span id="1_stars"></span></a></li>
										</ul>
									</div>
								</div>
							</div>
							<?php
								$requete1 = $bdd->prepare('SELECT message,nb_etoile,u.username FROM commentaires INNER JOIN users AS u ON commentaires.id_user=u.id_user WHERE id_article=:id_article');
								$requete1->execute(array(
									'id_article' => $_GET['id_article']
								));
								while ($ligne=$requete1->fetch()){
									?>
									<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="img/user.png" alt="">
										</div>
										<div class="media-body">
										<?php echo '<h4>'.$ligne[2].'</h4>';
										for($i=0;$i<$ligne[1];$i++){
											echo '<i class="fa fa-star"></i>';
										}
										?>
											
										</div>
									</div>
									<?php echo '<p>'.$ligne[0].'</p>';?>
								</div><?php
								}
								$requete1->closeCursor();
							?>
							
						</div>
						<?php 
						if(isset($_SESSION['username'])){
							?>
							<div class="col-lg-6">
							<div class="review_box">
								<h4>Ajouter un commentaire</h4>
								<p>Votre note :</p>
								<style>
								.star-rating {
									line-height:32px;
									font-size:1.25em;
								}
								.star-rating .fa-star{color: yellow;}
								</style>
								<div id="id_stars" class="star-rating">
									<span id="id_stars1" class="fa fa-star" data-rating="1"></span>
									<span id="id_stars2" class="fa fa-star-o" data-rating="2"></span>
									<span id="id_stars3" class="fa fa-star-o" data-rating="3"></span>
									<span id="id_stars4" class="fa fa-star-o" data-rating="4"></span>
									<span id="id_stars5" class="fa fa-star-o" data-rating="5"></span>
									<input type="hidden" name="whatever1" class="rating-value" value="2.56">
								</div>
								<hr>
								<!-- <form class="row contact_form" method="post" id="contactForm" novalidate="novalidate"> -->
									
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" name="message" id="message" rows="3" placeholder="Votre commentaire" onfocus="this.placeholder = ''" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Votre commentaire'"></textarea></textarea>
										</div>
									</div>
									<div class="col-md-12 text-right"><?php
										$id_session =$_SESSION['id'];
										$id_article =$_GET['id_article'];
										echo "<button onclick=action_com('$id_session','$id_article') name='action_com' id='action_com' type='submit' value='submit' class='primary-btn'>Ajouter</button>";
									?></div>
								<!-- </form> -->
							</div>
						</div>
						<?php
						}
						?>						
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Product Description Area =================-->



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
	<script>
	
	var $star_rating = $('.star-rating .fa');

var SetRatingStar = function() {
  return $star_rating.each(function() {
    if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
      return $(this).removeClass('fa-star-o').addClass('fa-star');
    } else {
      return $(this).removeClass('fa-star').addClass('fa-star-o');
    }
  });
};

$star_rating.on('click', function() {
  $star_rating.siblings('input.rating-value').val($(this).data('rating'));
  return SetRatingStar();
});

</script>
	<!-- End footer Area -->

	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
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
	<script src="js/single-product.js"></script>
    <script src="js/sweetalert.min.js"></script>

</body>

</html>