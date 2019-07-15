<?php
	session_start();
	require("parameters.php");
	if(isset($_SESSION['username'])){
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>

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
	
</head>

<body>
	<!--ICI : PDO + partie connexion (user + password) --> 
	<?php 
		try{
			$bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
			}
			catch (Exception $e){
				die('Erreur : ' . $e->getMessage());
			}
			
			if (!empty($_POST['username']) && !empty($_POST['password']) ) {
					$requete1 = $bdd->prepare('SELECT users.id_user,username,password,users.statut,validation.statut FROM users INNER JOIN validation ON users.id_user=validation.id_user WHERE username=:username AND password=:password AND users.statut != 0');
					$requete1->execute(array(
						'username' => $_POST['username'],
						'password' => $_POST['password']
					));
					while ($ligne=$requete1->fetch()){

						if(($ligne[1] == $_POST['username']) && ($ligne[2] == $_POST['password'])){
							$_SESSION['username'] = $_POST['username'];
							$_SESSION['id'] = $ligne[0];
							$_SESSION['valid']=$ligne[4];
							if($ligne[3] == "1"){
								$_SESSION['statut'] = 1;
							}
							elseif($ligne[3] == "2"){
								$_SESSION['statut'] =2;
							}
							elseif ($ligne[3] == "3") {
								$_SESSION['statut'] =3;
							}
							
							header('Location: index.php');
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
	<!-- FIN PDO +connexion -->


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
	<br/><br/>
	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap banner-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<!-- FORM HTML de creation -->
					<div class="login_form_inner" style="background:white;">
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
					<!-- FIN FORM HTML de creation -->
				</div>

				<!-- PHP GESTION CREATION DE COMPTE -->
				<?php
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
									$rqte1 = $bdd->prepare('INSERT INTO users(username,password,email,statut) VALUES(:username,:password,:email,"1");');
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
									//$_SESSION['username'] = $_POST['Pseudo'];
									//$_SESSION['statut']=1;
									session_write_close();
									?>
									<script>
										$.ajax({
											url : "send_verification.php",
											data : {
												email : "<?php echo $_POST['email'];?>"
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
										
									</script>
									<?php
								}
							}
						}
						
					}
					
				}
				?>
				<!-- FIN PHP GESTION CREATION DE COMPTE -->

				<!-- FORMULAIRE DE CONNETION -->
				<div class="col-lg-6">
					<div class="login_form_inner" style="background:white;">
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
								<a href="#" onclick=mdpforget()>Mot de passe oublié ?</a>
							</div>
						</form>
						
					</div>
				</div>
				<!-- FIN FORMULAIRE DE CONNETION -->
			</div>
		</div>
	</section>
	<script>
		function mdpforget(){
			swal({
            title: "Etes-vous sur d'avoir oublié votre mot de passe ?",
            text: "Si oui, entrer votre email :",
            icon: "warning",
			content:"input",
            buttons: true,
            dangerMode: true,
            })
			.then((value) => {
                
				console.log(id_user);
				$.ajax({
					url : "oublie_mdp.php",
					data : {
						email: value
					},
					cache : false,
					success : function(response){
						swal("Action traitée avec succès!", {
							icon: "success",
							timer: 3000
						})
						.then((willDelete) => {
								window.location.href = "login.php";
						
						});
					},
					error : function(request, error){
						console.log(error);
					}
				});
                
            });
		}
	</script>
	<!--================End Login Box Area =================-->

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
	<script src="js/main.js"></script>>
</body>

</html>