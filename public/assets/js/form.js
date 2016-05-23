$(document).ready(function() {

	//*************************************************************
	// Gestion du passage de la géoloc au formulaire :

	if (Modernizr.geolocation) {
		console.info('Géolocalisation disponible.');

		// utilise le service fourni par le navigateur
		navigator.geolocation.watchPosition(
			// initialise la Google Map avec les coordonnées locales
			function(position) {
				// récupère les coordonnées
				latitude = position.coords.latitude;
				longitude = position.coords.longitude;
				// Attribution des valeurs dans les champs coords
				$('#latitude').val(latitude);
				$('#longitude').val(longitude);

				console.log(position);

				// Récupération de l'adresse formatée en fct des coords
				var geocoder = new google.maps.Geocoder();
				var latlng = new google.maps.LatLng(latitude, longitude);

				var adresse = '';
				geocoder.geocode({'latLng': latlng}, function(results, status) {
				    if (status == google.maps.GeocoderStatus.OK) {
				    	adresse = (results[0].formatted_address);
				    	console.log(adresse);
				    	console.log(results[0]);
						// Attribution de la valeur adresse le champ adresse
						var $inpAdress = $('#inputAdresseId');
						$inpAdress.val(adresse);
						$inpAdress.text(adresse);

						var options = {
						    types: [],
						    componentRestrictions: {country: 'fr'}
						};

						//Implémentation de l'autocomplétion pour l'adresse
						var autocomplete = new google.maps.places.Autocomplete($inpAdress[0], options);

						// Au changement d'adresse dans le champ : et 
						google.maps.event.addListener(autocomplete, 'place_changed', function() {
							// l'auto completion se declenche 
						    var place = autocomplete.getPlace();
						    var new_adresse = place.formatted_address;

							// on réattribue latitude et longitude :
				 			geocoder.geocode({ 'address': new_adresse }, function (results, status) {
				                if (status == google.maps.GeocoderStatus.OK) {
				                    latitude = results[0].geometry.location.lat();
				                    longitude = results[0].geometry.location.lng();
									// Réattribution des valeurs dans les champs coords
									$('#latitude').val(latitude);
									$('#longitude').val(longitude);
				                } else {
				                    alert("Request failed.")
				                }
				            });
						});
					}
				});
			})
	}

	// Appel AJAX sur les catégories :
	$.ajax({
		url: '/api/categories',
		type: 'GET',
		dataType: 'json',
		// data: {param1: 'value1'},
	})
	.done(function(json) {
		console.log(json);

		// Remplissage du form avec des checkboxes pour chaque catégorie principale :
		$form = $('#rangeCategId');
		$compteur = 0;

		// création de la première div de classe row
		// pour les boutons radios catégories
		$divRow = $('<div class="row">');

		$(json).each(function(index, el)
		{
			if ($(json)[index]['parent_id'] == 0)
			{
				if($compteur == 3)
				{
					//console.log("création div row");
					// création d'une nouvelle div de classe radio
					$divRadio = $('<div class="row">');
					// remise du compteur à zéro
					$compteur = 0;
				}

				// Gestion des icones des catégories parent :
				$id_categorie = $(json)[index]['id'];

				switch ($id_categorie) {
					case "1":
						$spanIcon = $('<span class="glyphicon glyphicon-glass">');
						break;
					case "2":
						$spanIcon = $('<span class="glyphicon glyphicon-music">');
						break;
					case "3":
						$spanIcon = $('<span class="glyphicon glyphicon-camera">');
						break;
					case "4":
						$spanIcon = $('<span class="glyphicon glyphicon-heart-empty">');
						break;
					case "5":
						$spanIcon = $('<span class="glyphicon glyphicon-globe">');
						break;
					case "6":
						$spanIcon = $('<span class="glyphicon glyphicon-hand-right">');
						break;
					case "7":
						$spanIcon = $('<span class="glyphicon glyphicon-fire">');
						break;
					case "8":
						$spanIcon = $('<span class="glyphicon glyphicon-cd">');
						break;
					default:
						// statements_def
						break;
				}

				// Création du label
				$label = $('<label class="radio-inline">');
				// création de l'input de type radio
				$input = $('<input type="radio" name="radCategorie" value="'+$id_categorie+'">');

				// console.log('libelle : ');
				$libelle = $(json)[index]['libelle'];
				//console.log($libelle);
				//console.log(typeof($libelle));

				// Remplissage des balises :
				$label.append($spanIcon);
					// on cache le bouton radio pour ne voir que le glyphicon
				$label.append($input.hide());
				$label.append($libelle);

				// Création d'un élément de ligne
				$elementRow = $('<div class="col-xs-4">');
				$elementRow.append($label);

				$divRow.append($elementRow);
				$form.append($divRow);

				// Incrémentation du compteur de catégories parent
				// afin de les afficher 3 par 3
				$compteur++;
			}
		});

	})
	.fail(function(error) {
		console.log(error);
	})
	.always(function() {
		console.log("complete");
	});

	
	// Gestion des limites calendaires
	// var $input = $('#inputDateDebutId').pickadate();

	var date_fin_min = '';
	var time_fin_min = '';

	// Création du datepicker de la date de début (avec pickadate):
	var $date_debut = $('#inputDateDebutId').pickadate({
		format: 'dd/mm/yyyy',
		formatSubmit: 'yyyy-mm-dd',
	});

	pickerDateDebut = $date_debut.pickadate('picker');
	// Affectation de la sélection de la date limite inférieure de début 
	// = date du jour :
	pickerDateDebut.set('min', true);


	// Création du datepicker du time de début
	var $time_debut = $('#inputTimeDebutId').pickatime({
		formatLabel: '<b>HH</b>:i',
		formatSubmit: 'HH:i',
		format: 'HH:i',
	});

	// Affectation de l'heure limite inférieure de début par rapport à NOW
	pickerTimeDebut = $time_debut.pickatime('picker');
	pickerTimeDebut.set('min', true);
	pickerTimeDebut.set('interval', 15);


	// Création du datepicker de la date de fin
	var $date_fin = $('#inputDateFinId').pickadate({
		format: 'dd/mm/yyyy',
		formatSubmit: 'yyyy-mm-dd',
	});

	// Limitation de la date de fin inférieure en fonction de la date de début
	pickerDateFin = $date_fin.pickadate('picker');
	pickerDateFin.set('min', $('#inputDateDebutId').val());

	// Création du datepicker du time de fin
	var $time_fin = $('#inputTimeFinId').pickatime({
		formatLabel: '<b>HH</b>:i',
		formatSubmit: 'HH:i',
		format: 'HH:i',
	});

	// Affectation de la limite inférieure du time de fin 
	// en fonction du time de début rentré par l'utilisateur 
	// TODO : (si date_debut == date_fin)
	pickerTimeFin = $time_fin.pickatime('picker');
	pickerTimeFin.set('interval', 15);

	// Récupération de la date saisie dans date_debut
	pickerDateDebut.on({
		close: function(){
			// Si on change date_debut pour une date inférieure à celle
			// de date_fin, on ne change pas date_fin, sinon :
			// on attribue date_debut à date_fin (sinon paradoxe temporel)

			if($('#inputDateDebutId').val() >  $('#inputDateFinId').val())
			{
				$('#inputDateFinId').val($('#inputDateDebutId').val());
			}
		}
	})
	pickerDateDebut.render(true);

	
	// Geston de la date de fin :
	pickerDateFin.on({
		open: function(){
			date_fin_min = $('#inputDateDebutId').val();
			pickerDateFin.set('min', date_fin_min);
		}
	});
	pickerDateFin.render(true);

	// Récupération de l'heure saisie dans time_debut
	pickerTimeDebut.on({
		close: function(){
			time_fin_min = pickerTimeDebut.get('value');
			// Réaffectation du time de fin limite en fonction 
			// du changement de time début (si même date):
			if ($('#inputDateDebutId').val() === $('#inputDateFinId').val()) {
				if($('#inputTimeDebutId').val() > $('#inputTimeFinId').val())
				{
					
					$('#inputTimeFinId').val($('#inputTimeDebutId').val());
				}
			}		
		}
	});

	pickerTimeDebut.render(true);

	pickerTimeFin.on({
		open: function(){
			if($('#inputDateFinId').val() === $('#inputDateDebutId').val())
			// if(pickerDateFin.get() == pickerDateDebut.get())
			{
				pickerTimeFin.set('min', time_fin_min);
			}
		}
	});

	pickerTimeFin.render(true);

	// Gestion du choix d'un formulaire de création d'événement
	// simplifié ou complet : au clic sur un bouton, on toggle
	// le form complet ou non. Par défaut, form simplifié.
	$optionnel = $('#facultatifForm');
	$optionnel.hide();

	$btnOpt = $('#btnOptId');

	$(function () {
		$('#btnOptId').click(function(event) {
			$('#btnOptId').text(function (i, text) {
				return text === "Plus d'options" ? "Moins d'options" : "Plus d'options";
			});
			$optionnel.toggle(250);
		});
	});

});
