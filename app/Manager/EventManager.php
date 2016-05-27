<?php

namespace Manager;


class EventManager extends \W\Manager\Manager
{

	public function getEvents(){
		// Si événement pas commencé : on affiche les événements qui
		// commencent dans moins de 2h

		// Si événement commencé : on affiche les événements qui
		// ne sont pas terminés

		// Si événement terminé : on ne l'affiche pas
		if(isset($_SESSION['user'])){
			$time_limite_debut = strtotime("+2 hours");
			$time_limite_debut = date("Y-m-d H:i:s", $time_limite_debut);

			$current = date("Y-m-d H:i:s", time());
		
			$sql = "SELECT e.*, c.libelle, c.parent_id FROM events as e,
			categories AS c WHERE ((date_debut >= :now AND date_debut <= :now_plus_2h)
			OR (date_debut<=:now AND date_fin >=:now)) AND e.categorie_id = c.id";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(":now", $current);
			$stmt->bindValue(":now_plus_2h", $time_limite_debut);
			$stmt->execute();
			$events = $stmt->fetchAll();
			
			// $sql = "SELECT * FROM vote_user WHERE user_id = :id";
			// $stmt = $this->dbh->prepare($sql);
			// $stmt->bindValue(":id", $_SESSION['user']['id']);
			// $stmt->execute();
			// $votes = $stmt->fetchAll();
			
			foreach ($events as $key => $event) {
				$sql = "SELECT * FROM vote_user WHERE user_id = :id";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindValue(":id", $_SESSION['user']['id']);
				$stmt->execute();
				$votes = $stmt->fetchAll();
				$events[$key]['vote'] = $votes;
			}
			// var_dump($events);
			return $events;
			
		}else{
			$time_limite_debut = strtotime("+2 hours");
			$time_limite_debut = date("Y-m-d H:i:s", $time_limite_debut);

			$current = date("Y-m-d H:i:s", time());
		
			$sql = "SELECT e.*, c.libelle, c.parent_id FROM events as e, categories AS c WHERE ((date_debut >= :now AND date_debut <= :now_plus_2h) OR (date_debut<=:now AND date_fin >=:now)) AND e.categorie_id = c.id";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(":now", $current);
			$stmt->bindValue(":now_plus_2h", $time_limite_debut);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		
	}
	


	public function plusUnEvent(){
			
			$id = $_POST['plusun'];
			$sql = "SELECT plus_un FROM events WHERE id = :id";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$valeur = $stmt->fetch();

			$valeurplusun = ($valeur['plus_un'] + 1);
			
			$sql = "SELECT user_id, event_id FROM vote_user WHERE user_id = :id AND event_id = :event";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(":id", $_SESSION['user']['id']);
			$stmt->bindValue(":event", $_POST['plusun'] );
			$stmt->execute();
			$voteuser = $stmt->fetch();
			if(!$voteuser){
				$sql = "INSERT INTO vote_user (event_id, user_id) VALUES (:event_id, :user_id)";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindValue(":event_id", $id);
				$stmt->bindValue(":user_id", $_SESSION['user']['id']);
				$stmt->execute();
				
				$sql = "UPDATE events SET plus_un = :plus_un WHERE id = :id";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindValue(":id", $id);
				$stmt->bindValue(":plus_un", $valeurplusun);
				$stmt->execute();
				
					
			}
				
	}


	/**
	 * Récupère les informations du dernier évènement crée par un utilisateur connecté
	 */
	public function getEventByUser() {
		// SELECT "la ligne d'info" FROM events WHERE user_id like "utilisateur connecté"
		$sql = "SELECT e.*, c.libelle, c.parent_id FROM events as e, categories AS c WHERE ((date_debut >= :now AND date_debut <= :now_plus_2h) OR (date_debut<=:now AND date_fin >=:now)) AND e.categorie_id = c.id";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(":now", $current);
		$stmt->bindValue(":now_plus_2h", $time_limite_debut);
		$stmt->execute();
		return $stmt->fetchAll();
	}

}

