<?php $this->layout('layout', ['title' => 'Ajoute un évènement']) ?>


<?php $this->start('main_content'); ?>


	<!-- Formulaire simplifié d'ajout d'événement -->
	<form id="formEventId" class="form-horizontal" action="#" method="POST">
		<!-- Div de rangement des catégories -->
		<div class="form-group" id="rangeCategId">
			<h2>Type d'événement</h2>
			<?php if (isset($erreur)){ echo $erreur; } ?>
		</div>
		<!-- Apparition des sous catégories : -->
		<div class="form-group" id="rangeSubCategId">
		</div>
		<!-- Caractère payant ou non : -->
		<div class="form-group">
			<label for="selGratuitId" class="col-sm-2 control-label">Entrée</label>
			<div class="col-sm-10">
				<select id="selGratuitId" class="form-control" name="selGratuit" class="form-control">
					<option value="0">Gratuit</option>
					<option value="1">Payant</option>
				</select>
			</div>
		</div>
		<!-- implémentation des champs facultatifs -->
		<div id="facultatifForm">
			<!-- Champ Titre -->
			<div class="form-group">
    			<label for="inputTitreId" class="col-sm-2 control-label">Titre</label>
    			<div class="col-sm-10">
      				<input type="text" class="form-control" name="titre" id="inputTitreId" placeholder="Titre de l'événement (facultatif)">
    			</div>
  			</div>

			<input type="hidden" id="latitude" name="latitude" value="">
			<input type="hidden" id="longitude" name="longitude" value="">

			<div class="form-group">
				<label for="inputAdresseId" class="col-sm-2 control-label">Adresse</label>
				<div class="col-sm-10">
					<input type="text" id="inputAdresseId" onClick="this.select();" class="form-control" name="adresse" value="" placeholder="Adresse de l'événement">
				</div>
			</div>

			<div class="form-group">
				<label for="inputDescriptionId" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10">
					<textarea id="inputDescriptionId" class="form-control" row="2" name="description" placeholder="Description de l'événement (facultatif)"></textarea>
				</div>
			</div>

  			<div class="form-group">
    			<label for="inputDebutId" class="col-sm-2 control-label">Début</label>
				<div class="col-sm-5">
  					<input type="text" class="datepicker form-control" name="dateDebut" id="inputDateDebutId" data-value="<?= date('Y-m-d', time()); ?>">
  				</div>
				<div class="col-sm-5">
  					<input type="time" class="timepicker form-control" name="timeDebut" id="inputTimeDebutId" data-value="<?= date('H:i:s', time()) ?>">
  				</div>
  			</div>

 			<div class="form-group">
    			<label for="inputFinId" class="col-sm-2 control-label">Fin</label>
				<div class="col-sm-5">
  					<input type="text" class="datepicker form-control" name="dateFin" id="inputDateFinId" data-value="<?= date('Y-m-d', time()) ?>">
  				</div>
				<div class="col-sm-5">
  					<input type="time" class="timepicker form-control" name="timeFin" id="inputTimeFinId" data-value="<?= date('H:i:s', strtotime('+2 hours')) ?>">
  				</div>
  			</div>
		</div>	<!-- Fin de facultatifForm -->


		<!-- Bouton de soumission du form au serveur -->
		<button id="btnFormEvent" type="submit" class="btn btn-primary pull-right" name="btn">Valider</button>

		<!-- Bouton de choix d'un form complet ou non -->
		<button type="button" class="btn btn-primary pull-right" id="btnOptId" name="btnOpt">Plus d'options</button>

	</form>
	</div>


<?php $this->stop('main_content') ?>



<?php $this->start('scripts') ?>

	<!-- Scripts de date et time picker -->
	<script src="<?= $this->assetUrl('js/picker.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/picker.date.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/picker.time.js') ?>"></script>

	<!-- Chargement du scripts js d'ajout de formulaire dynamique-->
	<script src="<?= $this->assetUrl('js/form.js') ?>"></script>

<?php $this->stop('scripts') ?>