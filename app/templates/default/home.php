<?php $this->layout('layout', ['title' => '']) ?>

<?php $this->start('main_content') ?>


<nav class="navbar navbar-default" id="navBurgerTri">
  	<div class="container-fluid">	
		 <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header" id="menuBurgerTriId">
	      	<button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#navbarTriEventId" aria-expanded="false" id="burgerTriId">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
	      	</button>
	    </div>

	     <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="navbarTriEventId">
		<!-- checkbox de tri des évènements par catégorie(s) -->
			<ul id="triCategorieId" class="nav navbar-nav">
			</ul>
		</div>

	</div>
</nav>

	<div id="msgAddEventId"></div>
	<!-- Appel Google map -->
	<div id="mapOk"></div>
	<!-- zone d'erreur -->
	<div id="mapError"></div>

<?php $this->stop('main_content') ?>

<?php $this->start('scripts') ?>

	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

<?php $this->stop('scripts') ?>