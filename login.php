<?php
	session_start();
	require("parameters.php");
	if(isset($_SESSION['username'])){
		header('Location: /electroshop/index.php');
	}
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
	
</head>

<body>

	<?php 
		try{
			$bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
			}
			catch (Exception $e){
				die('Erreur : ' . $e->getMessage());
			}
			
			if (!empty($_POST['username']) && !empty($_POST['password']) ) {
					$requete1 = $bdd->prepare('SELECT id_user,username,password FROM users WHERE username=:username AND password=:password');
					$requete1->execute(array(
						'username' => $_POST['username'],
						'password' => $_POST['password']
					));
					while ($ligne=$requete1->fetch()){
						if(($ligne[1] == $_POST['username']) && ($ligne[2] == $_POST['password'])){
							$_SESSION['username'] = $_POST['username'];
							$_SESSION['id'] = $ligne[0];
							header('Location: /electroshop/index.php');
						}
					}
					?>
					<script>
								swal({
								title: "Nom d'utilisateur ou mot de passe incorrect !",
								text: "Veuilez réessayer ou créer un compte sinon ",
								icon: "error"
								})
								.then((willDelete) => {
									window.location.href = "login.php";
									
								});
							</script>
					<?php
			}
		
	?>
	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><img src="img/logo_electroshop.png" style="width :150px;" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav ml-auto">
							<li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
							<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">Shop</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link" href="category.html">Shop Category</a></li>
									<li class="nav-item"><a class="nav-link" href="single-product.html">Product Details</a></li>
									<li class="nav-item"><a class="nav-link" href="checkout.html">Product Checkout</a></li>
									<li class="nav-item"><a class="nav-link" href="cart.html">Shopping Cart</a></li>
									<li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
								</ul>
							</li>
							<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">Blog</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
									<li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
								</ul>
							</li>
							<li class="nav-item submenu dropdown active">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">Pages</a>
								<ul class="dropdown-menu">
									<li class="nav-item active"><a class="nav-link" href="login.html">Login</a></li>
									<li class="nav-item"><a class="nav-link" href="tracking.html">Tracking</a></li>
									<li class="nav-item"><a class="nav-link" href="elements.html">Elements</a></li>
								</ul>
							</li>
							<li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->
	<!-- Start Banner Area -->
	<br/><br/>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_form_inner">
						<div class="hover">
							<h3>CREER UN COMPTE</h3>
							<p>Crée un compte pour pouvoir accès à toutes les nouveautés !</p>
							<form class="row login_form" method="post" id="notEmptyForm">
								<div class="col-md-12 form-group">
									<input type="text" class="form-control" id="Pseudo" name="Pseudo" placeholder="Pseudo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Pseudo'">
								</div>
								<div class="col-md-12 form-group">
									<input type="password" class="form-control" id="CreatePassword" name="CreatePassword" placeholder="Entrer le mot de passe" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrer le mot de passe'">
								</div>
								<div class="col-md-12 form-group">
									<input type="password" class="form-control" id="CreatePassword2" name="CreatePassword2" placeholder="Entrer à nouveau le mot de passe" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrer à nouveau le mot de passe'">
								</div>
								<div class="col-md-12 form-group">
									<input type="mail" class="form-control" id="email" name="email" placeholder="Entrer l'adresse email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Entrer adresse email'">
								</div>
								<div class="col-md-12 form-group">
									<br/>
									<button type="submit" value="submit" id="buttonCreate" class="primary-btn">CREER LE COMPTE</button>
								</div>
							</form>
							
						</div>
					</div>
				</div>
				<?php
				// si le formulaire CREATION est envoyé
				if(isset(($_POST['CreatePassword'])) && isset($_POST['Pseudo']) && isset($_POST['CreatePassword2']) && isset($_POST['email'])){
					if(!empty(($_POST['CreatePassword'])) && !empty($_POST['Pseudo']) && !empty($_POST['CreatePassword2']) && !empty($_POST['email'])){
						if($_POST['CreatePassword'] != $_POST['CreatePassword2']){
							?>
							<script>
										swal({
										title: "Mots de passe différent !",
										text: "Veuilez réessayer ",
										icon: "warning"
										})
										.then((willDelete) => {
											window.location.href = "login.php";
											
										});
									</script>
							<?php
						}
						else{
							$pseudo_exist = 0;
							$email_exist = 0;
							////////////////////////// 1 : PSEUDO 
							// test si le pseudo existe deja 
							$rqte = $bdd->prepare('SELECT username FROM users WHERE username=:pseudo;');
							$rqte->execute(array(
								'pseudo' => $_POST['Pseudo']
							));
							while ($ligne=$rqte->fetch()){

								if($ligne[0] == $_POST['Pseudo']){
									?>
									<script>
												swal({
												title: "Pseudo déjà utilisé !",
												text: "",
												icon: "error"
												})
												.then((willDelete) => {
													window.location.href = "login.php";
													
												});
											</script>
									<?php
									$pseudo_exist = 1;
								}
								
							}
							$rqte->closeCursor();
							if($pseudo_exist == 0){
								///TEST SI l'email n'est pas deja utilisé
								$rqte1 = $bdd->prepare('SELECT email FROM users WHERE email=:email;');
								$rqte1->execute(array(
									'email' => $_POST['email']
								));
								while ($ligne=$rqte1->fetch()){

									if($ligne[0] == $_POST['email']){
										?>
										<script>
													swal({
													title: "Email déjà utilisé !",
													text: "",
													icon: "error"
													})
													.then((willDelete) => {
														window.location.href = "login.php";
														
													});
												</script>
										<?php
										$email_exist = 1;
									}
									
								}
								$rqte1->closeCursor();
								if($email_exist == 0){
									$rqte1 = $bdd->prepare('INSERT INTO users(username,password,email) VALUES(:username,:password,:email);');
									$rqte1->execute(array(
										'username' => $_POST['Pseudo'],
										'password' => $_POST['CreatePassword'],
										'email' => $_POST['email']
									));
									$rqte1->closeCursor();
									$rqte2 = $bdd->prepare('SELECT id_user WHERE username=:username AND password=:password AND email=:email);');
									$rqte2->execute(array(
										'username' => $_POST['Pseudo'],
										'password' => $_POST['CreatePassword'],
										'email' => $_POST['email']
									));
									while ($ligne=$rqte2->fetch()){
										$_SESSION['id'] = $ligne[0];
									}
									$rqte2->closeCursor();
									$_SESSION['username'] = $_POST['Pseudo'];
									session_write_close();
									?>
									<script>
										$.ajax({
											url : "send_verification.php",
											data : {
												email : 'villedieu.anthony@yahoo.com'
											},
											dataType : 'json',
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
										
									</script>
									<?php
								}
							}
						}
						
					}
					
				}
				?>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>SE CONNECTER</h3>
						<form class="row login_form" method="post" id="connectForm">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" id="connectButton" class="primary-btn">SE CONNECTER</button>
								<a href="#">Mot de passe oublié ?</a>
							</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-3  col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>About Us</h6>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dolore
							magna aliqua.
						</p>
					</div>
				</div>
				<div class="col-lg-4  col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>Newsletter</h6>
						<p>Stay update with our latest</p>
						<div class="" id="mc_embed_signup">

							<form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
							 method="get" class="form-inline">

								<div class="d-flex flex-row">

									<input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '"
									 required="" type="email">


									<button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
									<div style="position: absolute; left: -5000px;">
										<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
									</div>

									<!-- <div class="col-lg-4 col-md-4">
													<button class="bb-btn btn"><span class="lnr lnr-arrow-right"></span></button>
												</div>  -->
								</div>
								<div class="info"></div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-3  col-md-6 col-sm-6">
					<div class="single-footer-widget mail-chimp">
						<h6 class="mb-20">Instragram Feed</h6>
						<ul class="instafeed d-flex flex-wrap">
							<li><img src="img/i1.jpg" alt=""></li>
							<li><img src="img/i2.jpg" alt=""></li>
							<li><img src="img/i3.jpg" alt=""></li>
							<li><img src="img/i4.jpg" alt=""></li>
							<li><img src="img/i5.jpg" alt=""></li>
							<li><img src="img/i6.jpg" alt=""></li>
							<li><img src="img/i7.jpg" alt=""></li>
							<li><img src="img/i8.jpg" alt=""></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>Suivez-nous !</h6>
						<p>Let us be social</p>
						<div class="footer-social d-flex align-items-center">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
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
	<script src="js/vendor/bootstrap.min.js"></script
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>>
</body>

</html>