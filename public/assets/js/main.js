/*==============================
	Logique de géolocalisation
  ==============================*/

$(document).ready(function() {

	/* ===========================================================
		Génération dynamique des checkbox de filtrage d'évènements
	   =========================================================== */
	$.ajax({
		url: '/api/categories',
		type: 'GET',
		dataType: 'json',
	})
	.done(function(json) {
		console.log(json);
		//
		$(json).each(function(index, el) {
			if($(json)[index]['parent_id'] == 0)
			{
				$div_checkbox = $('<div class="checkbox-inline">');

				$input_checkbox = $('<input type="checkbox" checked>');
				$categorie = $(json)[index]['libelle'];

				$input_checkbox.attr('value', $categorie);
				$input_checkbox.attr('id', $categorie + "Box");

				$label_checkbox = $('<label for="' + $categorie + 'Box">' + $categorie + '</label>');

				$div_checkbox.append($input_checkbox);
				$div_checkbox.append($label_checkbox);

				$('#triCategorieId').append($div_checkbox);
			}
		});
	})
	.fail(function(error) {
		console.log(error);
	})
	.always(function() {
		console.log("complete");
	});


	/*
		Récupération des références sur les objets
	*/
	var $zoneError = $('#mapError'); // ciblage pour la zone des erreurs
	var $zoneMap = $('#mapOk'); // ciblage de la zone de la carte

	/*
		État initial des objets
	*/
	$zoneMap.show(); // afficher la zone de la carte
	$zoneError.hide();

	/*
		Initialise une carte selon l'API Google
	*/
	var initGoogleMap = function(latitude, longitude) {

		// latitude et longitude fournies
		// par l'API HTML5 Geolocation du navigateur
		var localCoords = {
			lat: latitude,
			lng: longitude
		};

		// Objet carte Google dans la div correspondante
		var map = new google.maps.Map($zoneMap[0], {
			zoom: 15,
			center: localCoords,
			disableDefaultUI : true, // masque l'interface par défaut de Google
			mapTypeId: google.maps.MapTypeId.ROADMAP // affichage graphique par défaut
		});

		// marqueur des coordonnées locales
		var markerDefault = new google.maps.Marker({
			position: localCoords,
			map: map,
			draggable: false,	// le marqueur n'est pas déplaçable
			title: 'Position actuelle'
		});


		// gestion du filtre d'affichage par catégorie:
			// Initialisation du tableau de marker d'événements
			// enrichi des catégories
		var gmarkers = [];

		/* ================================================
		   Chargement des évènements ciblés, par appel AJAX
		   ================================================ */
		$.ajax({
			url: '/api/events',
			type: 'GET',
			dataType: 'json',
		})
		.done(function(json) {
			$(json).each(function(index, el) {
				
				$latitude = $(json)[index]['latitude'];
				$longitude = $(json)[index]['longitude'];
				$titreEvent = $(json)[index]['titre'];
				
				if($(json)[index]['payant'] == 0){
					$payant = "Gratuit"
				}else{ 
					$payant = "Payant"
				};

				if($(json)[index]['description'] != ""){
					$description = $(json)[index]['description']
				}else{
					$description = "Aucune description"
				};

				var $categorieEvent = $(json)[index]['categorie_id'];

				var $eventCoords = {
					lat: $latitude,//48.837799072265625,
					lng: $longitude//2.3342411518096924
				};

				// Gestion des icônes pour les sous-catégories (id>8) :
				// attribution de l'id de catégorie parent
				if ($categorieEvent > 8) {
					$categorieEvent = $(json)[index]['parent_id'];
				}

				var icons = {
					'1': 'icomoon-glass.png',
					'2': 'icomoon-music.png',
					'3': 'icomoon-camera.png',
					'4': 'icomoon-heart.png',
					'5': 'icomoon-earth.png',
					'6': 'icomoon-point-right.png',
					'7': 'icomoon-fire.png',
					'8': 'linecons-vynil.png',
				};

				// marqueur des coordonnées locales pour chaque event
				var marker = new google.maps.Marker({
					position: $eventCoords,
					map: map,
					draggable: false,	// le marqueur n'est pas déplaçable
					title: $titreEvent,
					icon: '/assets/img/'+icons[$categorieEvent] // icône de marqueur personnalisée
				});


				/*
					Filtrage des markers de GoogleMap par catégorie:
				*/
				// création d'un tableau d'objets markers surchargés de la propriété mycategory 
				marker['mycategory'] = $(json)[index]['libelle'];
				gmarkers.push(marker);
				// fonction pour montrer les marqueurs en fonction des catégories choisies 
				function show(category){
					for( var i=0; i<gmarkers.length; i++ ){
						if (gmarkers[i].mycategory == category) {
							gmarkers[i].setVisible(true);
					    }
					}
					// document.getElementById(category+"Box").checked = true;
				}
				// fonction pour cacher les marqueurs en fonction des catégories choisies 
				function hide(category) {
			        for ( var i=0; i<gmarkers.length; i++ ) {
				        if (gmarkers[i].mycategory == category) {
				          gmarkers[i].setVisible(false);
				        }
			      	}
			    }

			    // fonction pour montrer ou cacher des marqueurs en réaction au clic sur une des checkbox en fonction de l'état de la checkbox
				function boxclick(box,category) {
			        if (box.checked) {
			        	this.checked = true;
			          	show(category);

			        } else {
			        	this.checked = false;
			        	hide(category);
			        }
			    }

			 	// Au clic sur une checkbox, on applique l'action de filtrage avec la fonction boxclick		  
			   $('input[type=checkbox]').on('click', $('input[type=checkbox]') ,function(event) {
			    	$categorie_traitee = $(this).val();
			    	boxclick(this, $categorie_traitee);
			    });
					
					// Infobulle
					
					if($(json)[index]['vote'] == undefined){
						$form = "";
					}else if(Object.keys($(json)[index]['vote']) == ""){
						$form = "<form method='POST' action=''><input type='hidden' name='plusun' value='"+$(json)[index]['id']+"'><button type='submit' name='submit' style='margin-left:5px'><span class='glyphicon glyphicon-thumbs-up'></span></button></form></p><br>";
					}else{
						if($(json)[index]['vote'] != undefined){
							for(i = 0; i< $(json)[index]['vote'].length; i++){
								if($(json)[index]['vote'][i]['event_id'] == $(json)[index]['id']){
									$form = " Vous avez déjà voté!"
									break;
								}else{
									$form = "<form method='POST' action=''><input type='hidden' name='plusun' value='"+$(json)[index]['id']+"'><button type='submit' name='submit' style='margin-left:5px'><span class='glyphicon glyphicon-thumbs-up'></span></button></form></p><br>";
								}
							}
						
						}
					}
					
					var contenuInfoBulle =	"<div class='infobulle'>"+
											"<h3>Titre : "+$(json)[index]['titre']+ "</h3><br>" +
											"<h4>Type d'évenement : " + $(json)[index]['libelle'] + "</h4><br>"+
											"<p>Adresse : "+$(json)[index]['adresse'] + "</p><br>" +
											"<p>Payant : "+ $payant + "</p><br>"+
											"<p>Description : " + $description + "</p><br>" +
											"<p>Heure de début : " + $(json)[index]['date_debut'] + "</p><br>" +
											"<p>Heure de fin : " + $(json)[index]['date_fin'] + "</p><br>" +
											"<p>Fiabilité : " + $(json)[index]['plus_un'] + 
											$form +				
											"</div>";
					
											
					var infoBulle = new google.maps.InfoWindow( {
						content: contenuInfoBulle,
						shadowStyle: 1,
						padding: 0,
						backgroundColor: 'rgb(57,57,57)',
						borderRadius: 4,
						arrowSize: 10,
						borderWidth: 1,
						borderColor: '#2c2c2c',
						disableAutoPan: true,
						hideCloseButton: true,
						arrowPosition: 30,
						
						} )

					google.maps.event.addListener(marker, 'click', function() {
					infoBulle.open(map, marker);
						});
				
		});


		})
		.fail(function(error) {
			console.log(error);
		})
		.always(function() {
			console.log("complete");
		});

	};

	/*
		Initialise une carte (alternative) selon l'API Google
	*/
	// var initOpenStreetMap = function(latitude, longitude) {
	// }

	/*
		Affiche la carte centrée sur la position de l'utilisateur
	*/
	// Détecte le support de la géolocalisation dans le navigateur
	if (Modernizr.geolocation) {
		console.info('Géolocalisation disponible.');

		// utilise le service fourni par le navigateur
		navigator.geolocation.watchPosition(
			// initialise la Google Map avec les coordonnées locales
			function(position) {
				// récupère les coordonnées
				initGoogleMap( position.coords.latitude, position.coords.longitude );
			},
			// Gère les erreurs
			function(error) {
				$zoneMap.hide();
				$zoneError.show(); // affiche la zone des erreurs

				switch(error.code) {

					case error.PERMISSION_DENIED:
						$zoneError.text('problèmes de droit.');
						break;

					case error.POSITION_UNAVAILABLE:
						$zoneError.text('coordonnées indisponibles.');
						break;

					case error.TIMEOUT:
						$zoneError.text('Temps d\'attente trop élevé');
						break;

					case error.UNKNOWN_ERROR:
					default:
						console.log('Erreur inconnue.');
						break;
				}
			}
		);
	}
	// Alerte : le navigateur ne gère pas la géolocalisation
	else {
		error();
	}

})