<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>

	<!-- checkbox de tri des évènements par catégorie(s) -->
	<div id="triCategorieId">
		
	</div>

	<div id="msgAddEventId"></div>
	<!-- Appel Google map -->
	<div id="mapOk"></div>
	<!-- zone d'erreur -->
	<div id="mapError"></div>

<?php $this->stop('main_content') ?>

<?php $this->start('scripts') ?>

	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

<?php $this->stop('scripts') ?>