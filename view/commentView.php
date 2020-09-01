<?php
 
require_once "view/view.php";

class CommentView extends View{
	
public $data;

	public function __construct($data, $slug){
		global $secure;
		parent::__construct(null, null);
		if ($secure->uri[0] === "admin") $slug = null;
		$newData = [];
		foreach ($data as $key => $value) {
			/*
			states :
				0 : il vient d'être saisi par l'user -> donc pas visible sur le front mais visible sur le back
				1 : il est validé par l'admin -> visible sur le front mais pas sur le back
				2 : il est signalé  -> donc pas visible sur le front mais visible sur le back
				3 : il est validé définitivement -> visible sur le front mais pas sur le back
			 */
			if ($slug !== null) { //on est sur le front
				if ($value['state'] === '0' || $value['state'] === '2') {
					continue;
				}
			}

			if ($slug === null) { //on est sur le back
				if ($value['state'] === '1' || $value['state'] === '3') {
					continue;
				}
			}
			$data[$key]["{{ button }}"] = $this->generateButton($value['state'], $value['ID'], $slug);
			$data[$key]["{{ comment }}"] = nl2br($data[$key]["{{ comment }}"]);
			array_push($newData, $data[$key]);

		}
		if (count($newData) === 0)return;
		//faire boucle  sur les données recu de la view (idPost, etat)
		$this->html = $this->makeHtmlLoop($newData, "commentaire");
	}

	private function generateButton($state, $id, $slug){
		if ($state === "3") return "";
		if ($slug === null) {
			$button = $this->makeButton($id, "valider", $state);
			return $button . $this->makeButton($id, "supprimer", $state);
		}
		return $this->makeButton($id, "signaler", $state);
	}

	private function makeButton($id, $text, $state){
		return '
			<form action="" method="post">
				<input type="hidden" name="id" value="'.$id.'">
				<input type="hidden" name="commentState" value="'.$state.'">
				<input type="submit" name="commentAction" value="'.$text.'">
			</form>
		';
	}
}
