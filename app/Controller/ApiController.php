<?php

namespace Controller;

use \W\Controller\Controller;

class ApiController extends Controller
{

	public function categories(){
		$m = new \Manager\CategorieManager();
		// Récupération de toute les catégories :
		$categories = $m->findAll($orderBy = "id", $orderDir = "ASC", $limit = null, $offset = null);

		// création du fichier json :
		$liste_categories = json_encode($categories);
		echo $liste_categories;
	}

	public function subCategories($id_categorie_parent){
		$m = new \Manager\CategorieManager();
		// Récupération des sous catégories d'une catégorie parent
		$subCategories = $m->get_sub_categories($id_categorie_parent);
		$liste_sub_categories = json_encode($subCategories);
		echo $liste_sub_categories;
	}


	// Fonction qui récupère les events ciblés et les encode en json
	public function apiEvent(){
		 $m = new \Manager\EventManager();
		 $events = $m->getEvents();
		 $liste_events = json_encode($events, JSON_NUMERIC_CHECK);
		 echo $liste_events;
	}

	public function insertNewEvent($id_user,$titre,$adresse,$latitude, $longitude, $categorie_id, $date_debut, $date_fin, $payant, $description)
	{
		$erreur = "";

		if($id_user == "0")
		{
			$id_user = 1;
		}

		if($titre == "0")
		{
			$titre = "Nouvel événement";
		}

		if($description == "0")
		{
			$description = "Un nouvel événement";
		}

		if($adresse == "0" || $latitude == "0" || $longitude == "0" || $categorie_id == "0")
		{
			$erreur = "Requête incomplète (adresse, latitude, longitude, catégorie d'événement obligatoires !)";
		}

		// Condition, en fonction la sélection d'une catégorie, de la soumission du formulaire et de l'insertion en BDD de l'évènement
		if(!$erreur)
		{
			// Validation des champs dates et heures relatifs au début de l'évènement
			if($date_debut == "0")
			{
				$date_debut = date('Y-m-d H:i:s',time());
			}

			// fin de l'évènement
			if($date_fin == "0")
			{
				list($annee,$mois,$jour,$h,$m,$s) = sscanf($date_debut,"%d-%d-%d %d:%d:%d");
				$h = 2;
				$timestamp = mktime($h,$m,$s,$mois,$jour,$annee);
				$date_fin = date('Y-m-d H:i:s',$timestamp);
			}
			elseif ($date_fin < $date_debut)
			{
				$erreur = "Erreur : Date de début supérieure à date de fin.";
			}

			// tableau associatif  de données relatives à l'évènement à insérer en BDD
			$data = [
				 'id' => NULL,
				 // Récupération de la variable $w_user
				 'user_id' => $id_user,
				 'titre' => htmlentities(strip_tags($titre)),
				 // Récupération des coordonnées de l'emplacement
				 // où l'on se trouve
				 'adresse' => htmlentities(strip_tags($adresse)),
				 'latitude' => $latitude,
				 'longitude' => $longitude,
				 // 'categorie_id' => $_POST['radCategorie'],
				 'categorie_id' => $categorie_id,
				 'date_debut' => $date_debut,
				 'date_fin' => $date_fin,
				 'payant' => $payant,
				 'plus_un' => 1,
				 'description' => htmlentities(strip_tags($description))
					];
			if(!$erreur)
			{
				$m = new \Manager\EventManager;
				$m->setTable('events');
				$m->insert($data, true);
			}
		}

		if(isset($m))
		{
			$this->redirectToRoute('home');
		}
		else
		{
			$this->show('default/addevent', ['erreur' => $erreur]);
		}
	}
}


