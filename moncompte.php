<?php
    session_start();
    require("parameters.php");
    if(!isset($_SESSION['username'])){
		header('Location: login.php');
    }
    try{   
		$bdd = new PDO('mysql:host='.$serveur.';dbname='.$db.';charset=utf8',$login,$mdp);
	}
	catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
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
    <!--
			CSS
			============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="css/main.css">
    <script src="js/sweetalert.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>

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
    <?php
        $requete1 = $bdd->prepare('SELECT email,password FROM users WHERE id_user=:id_user');
        $requete1->execute(array(
            'id_user' => $_SESSION['id'],
        ));
        while ($ligne=$requete1->fetch()){
            $mail = $ligne[0];
            $old_mdp = $ligne[1];
        }
        $requete1->closeCursor();
        if(isset($_POST['buttonProfil'])){
            if($_POST['actual_username'] != $_SESSION['username']){
                //modif du username : 
                if($_POST['actual_username'] != ''){
                    try{
                        $requete1 = $bdd->prepare('UPDATE users SET username=:username WHERE id_user=:id_user');
                        $requete1->execute(array(
                            'username' => $_POST['actual_username'],
                            'id_user' => $_SESSION['id']
                        ));
                        $requete1->closeCursor();
                        $_SESSION['username'] = $_POST['actual_username'];
                    }
                    catch (Exception $e){
                        die('Erreur : ' . $e->getMessage());
                    }    
                }
            }
            elseif ($_POST['actual_email'] != $mail) {
                
                if($_POST['actual_email'] != ''){
                    try{
                        $requete1 = $bdd->prepare('UPDATE users SET email=:email WHERE id_user=:id_user');
                        $requete1->execute(array(
                            'email' => $_POST['actual_email'],
                            'id_user' => $_SESSION['id']
                        ));
                        $requete1->closeCursor();
                        
                    }
                    catch (Exception $e){
                        die('Erreur : ' . $e->getMessage());
                    }
                } 
            }
            elseif (($_POST['actual_password1'] == $_POST['actual_password2']) && ($_POST['actual_password1'] != $old_mdp)) {
                if(($_POST['actual_password1'] != '') && ($_POST['actual_password2'] != '')){
                    $requete1 = $bdd->prepare('UPDATE users SET password=:password WHERE id_user=:id_user');
                    $requete1->execute(array(
                        'password' => $_POST['actual_password1'],
                        'id_user' => $_SESSION['id']
                    ));
                    $requete1->closeCursor();
                }
            }
            
            ?><script>
            swal("Action traitée avec succès!", {
                icon: "success",
                timer: 3000
            })
            .then((willDelete) => {
                    window.location.href = "moncompte.php";
            
            });
            </script><?php
        }
    ?>
    <!--================Blog Area =================-->
    <br/><br/>
    <br/>
    <section class="blog_area single-post-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 posts-list">
                    <div class="single-post row">
                    <?php 
                    $requete1 = $bdd->prepare('SELECT email,username FROM users WHERE id_user=:id_user');
                    $requete1->execute(array(
                        'id_user' => $_SESSION['id'],
                    ));
                    while ($ligne=$requete1->fetch()){
                        $mail = $ligne[0];
                        $username= $ligne[1];
                    }
                    $requete1->closeCursor();?>
                    <div class="container">
                        <h3 class="text-center">Edit Profile</h3>
                        <hr>
                        <div class="row">
                        <!-- left column -->
                        <div class="col-md-3">
                            
                        </div>
                        
                        <!-- edit form column -->
                        <div class="col-md-9 personal-info">
                            <form class="form-horizontal" method="post">
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Nom d'utilisateur :</label>
                                <div class="col-lg-8">
                                <input class="form-control" type="text" name="actual_username" value="<?php echo $_SESSION['username'];?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email:</label>
                                <div class="col-lg-8">
                                <input class="form-control" name="actual_email" type="text" value="<?php echo $mail;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password:</label>
                                <div class="col-md-8">
                                <input class="form-control" name="actual_password1" type="password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm password:</label>
                                <div class="col-md-8">
                                <input class="form-control" name="actual_password2" type="password" value="">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                <button type="submit" value="submit" name="buttonProfil" id="buttonProfil" class="btn btn-primary">VALIDER</button>
                                <span></span>
                                
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    </div>
                    <hr>
                        
                    </div>
                    <div class="comments-area">
                        <h4>Mes commentaires</h4>
                        <?php 
                        $requete1 = $bdd->prepare('SELECT id_com,commentaires.id_article,id_user,message,nb_etoile,nom_article FROM commentaires INNER JOIN article ON commentaires.id_article=article.id_article WHERE id_user=:id_user');
                        $requete1->execute(array(
                            'id_user' => $_SESSION['id'],
                        ));
                        while ($ligne=$requete1->fetch()){
                           ?>
                            <div class="comment-list">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/user.png" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a><?php echo $username;?> </a></h5>
                                            <p class="date">Article : <?php echo $ligne[5];?><br>
                                            Nombre d'étoile :<?php echo $ligne[4];?> </p>
                                            <p class="comment">
                                            <?php echo $ligne[3];?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="reply-btn">
                                       <?php echo "<a onclick=supprime_com('$ligne[0]') class='btn-reply text-uppercase'>Supprimer</a>";?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        $requete1->closeCursor();?>
                        
                    </div>
                    <!-- <div class="comment-form">
                        <h4>Leave a Reply</h4>
                        <form>
                            <div class="form-group form-inline">
                                <div class="form-group col-lg-6 col-md-6 name">
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Enter Name'">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 email">
                                    <input type="email" class="form-control" id="email" placeholder="Enter email address"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="subject" placeholder="Subject" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Subject'">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control mb-10" rows="5" name="message" placeholder="Messege"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
                            </div>
                            <a href="#" class="primary-btn submit_btn">Post Comment</a>
                        </form>
                    </div> -->
                </div>
                
            </div>
        </div>
    </section>
    
    <!--================Blog Area =================-->
    <script>
        function supprime_com(id_com){
            swal({
            title: "Etes-vous sur de vouloir supprimer ce commentaire ?",
            text: "Si oui, finaliser l'action, si non annuler",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(id_com);
                    $.ajax({
                        url : "modif_com.php",
                        data : {
                            id_com: id_com
                        },
                        cache : false,
                        success : function(response){
                            swal("Action traitée avec succès!", {
                                icon: "success",
                                timer: 3000
                            })
                            .then((willDelete) => {
                                    window.location.href = "moncompte.php";
                            
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