<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>

	<!-- === STYLESHEETS CSS === -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Appel de la CSS reset -->
	<!-- <link rel="stylesheet" href="<?= $this->assetUrl('css/normalize.css')?>"> -->
	
	<!-- Appel des CSS de datepicker -->
	<link rel="stylesheet" href="<?= $this->assetUrl('css/default.css')?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/default.date.css')?>">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/default.time.css')?>">

	<!-- Appel à notre CSS -->
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">


	<!-- === SCRIPTS JS === -->
	<!-- Appel script (vendor) Modernizr -->
	<script src="<?= $this->assetUrl('js/vendor/modernizr-2.8.3.min.js') ?>"></script>
</head>

<body>

	<nav class="navbar navbar-default navbar-fixed-bottom ourMenu">
	  <div class="container-fluid">


	    <div class="navbar-header">
		    <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false" id="burgerId">
		      	<span class="sr-only">Toggle navigation</span>
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	        	<span class="icon-bar"></span>
	      	</button>
      	</div>

		<div class="collapse navbar-collapse ourBurgerMenu" id="bs-navbar-collapse-1">
			<ul class="nav navbar-nav">

				<li>
					<a href="<?= $this->url('home')?>">
						<button type="button" class="btn btn-default btn-menu">Accueil</button>
					</a>
				</li>
				<?php
				if(!isset($_SESSION['user']))
				{
				?>
			  		<li>
			  			<a href="<?= $this->url('inscription')?>">
			  				<button type="button" class="btn btn-default btn-menu">Inscription</button>
			  			</a>
			  		</li>
			  		<li>
			  			<a href="<?= $this->url('login')?>">
			  				<button type="button" class="btn btn-default btn-menu">Login</button>
			  			</a>
			  		</li>
		 		<?php
		 		}
		 		else
		 		{
		 		?>
					<li>
						<a href="<?= $this->url('logout')?>">
							<button type="button" class="btn btn-default btn-menu">Déconnexion</button>
						</a>
					</li>
					<li>
						<a href="<?= $this->url('addEvent')?>">
							<button  type="button" class="btn btn-default btn-menu">Ajout Evénement</button>
						</a>
					</li>
				<?php
				}
				?>
			</ul>		
	    </div>
	  </div>
	</nav>

	


	<div class="contents">
		<header>
			<h1><?= $this->e($title) ?></h1>
		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>
	</div>




	<!-- Appel à jQuery -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>

	<!-- Appel JS bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<!-- Chargement de l'API Google Maps -->

	<script src="https://maps.googleapis.com/maps/api/js?libraries=places&language=fr&key=AIzaSyAGNXG4UdnErAn4jfJ2lgwZ0OEGbT-6lws"></script>

	<!-- === SCRIPTS CUSTOM JS === -->
	<!-- Appel à jstorage -->
	<script src="<?= $this->assetUrl('js/jstorage.js') ?>"></script>
	
	<!-- Appel des scripts spécifiques -->

	<?= $this->section('scripts') ?>

</body>
</html>


