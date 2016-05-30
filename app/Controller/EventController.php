<?php
namespace Controller;

use \W\Controller\Controller;

class EventController extends Controller
{
	public function insertNewEvent()
	{
		$erreur = "";
		// Récupération de l'id user :
    	$loggedUser = $this->getUser();
    	$id_user = $loggedUser['id'];

		if(isset($_POST['btn']))
		{
			if(empty($_POST['radCategorie']))
			{
				$erreur = "Veuillez sélectionner une catégorie";
			}
			// Condition, en fonction la sélection d'une catégorie, de la soumission du formulaire et de l'insertion en BDD de l'évènement
			if(!$erreur)
			{
				// Validation des champs dates et heures relatifs au début de l'évènement
				if(empty($_POST['dateDebut_submit']))
				{
					$date_debut = date('Y-m-d',time());
					if (empty($_POST['timeDebut_submit'])) {
					// en cas de champ vide, on attribue à ce champ l'heure ou la date actuelle
						$time_debut = date('H:i:s',time());
					}
					else
					{
						$time_debut = $_POST['timeDebut_submit'];
					}
				}
				else
				{
					$date_debut = $_POST['dateDebut_submit'];
					if (empty($_POST['timeDebut_submit'])) {
					// en cas de champ vide, on attribue à ce champ l'heure ou la date actuelle
						$time_debut = date('H:i:s',time());
					}
					else
					{
						$time_debut = $_POST['timeDebut_submit'];
					}
				}

				$full_date_debut = $date_debut . " " . $time_debut;

				// fin de l'évènement
				if(empty($_POST['dateFin_submit']))
				{
					$date_fin = date('Y-m-d',time());
					if (empty($_POST['timeFin_submit'])) {
					// en cas de champ vide, on attribue à ce champ l'heure ou la date actuelle
						$time_fin = date('H:i:s',strtotime('+2 hours'));
					}
					else
					{
						$time_fin = $_POST['timeFin_submit'];
					}
				}
				else
				{
					$date_fin = $_POST['dateFin_submit'];
					if (empty($_POST['timeFin_submit'])) {
					// en cas de champ vide, on attribue à ce champ l'heure ou la date actuelle + 2 heures
						$time_fin = date('H:i:s',strtotime('+2 hours'));
					}
					else
					{
						$time_fin = $_POST['timeFin_submit'];
					}
				}

				$full_date_fin = $date_fin . " " . $time_fin;

				// gestion des sous-catégories éventuelles :
				if(empty($_POST['radSubCategorie']))
				{
					$id_categorie = $_POST['radCategorie'];
				}
				else
				{
					$id_categorie = $_POST['radSubCategorie'];
				}





				// tableau associatif  de données relatives à l'évènement à insérer en BDD
				$data = [
						 'id' => NULL,
						 // Récupération de la variable $w_user
						 'user_id' => $id_user,
						 'titre' => htmlentities(strip_tags($_POST['titre'])),
						 // Récupération des coordonnées de l'emplacement
						 // où l'on se trouve
						 'adresse' => htmlentities(strip_tags($_POST['adresse'])),
						 'latitude' => $_POST['latitude'],
						 'longitude' => $_POST['longitude'],
						 // 'categorie_id' => $_POST['radCategorie'],
						 'categorie_id' => $id_categorie,
						 'date_debut' => $full_date_debut,
						 'date_fin' => $full_date_fin,
						 'payant' => $_POST['selGratuit'],
						 'plus_un' => 1,
						 'description' => htmlentities(strip_tags($_POST['description']))
						];

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