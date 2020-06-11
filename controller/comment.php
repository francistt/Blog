<?php

require_once "model/commentModel.php";
require_once "view/view.php";
require_once "view/commentView.php";
/**
 * 
 */
class Comment
{
	public  $html;
	public  $numberOfComments;
	private $slug;

	/**
	 * [__construct description]
	 * @param Array $argument soit un tableau avec comme clé un id, un slug, ou list
	 */
	public function __construct($argument){
		$dataCommentaires = new CommentModel($argument);
		if (isset($argument["slug"]))$this->slug = $argument["slug"];
		if (isset($argument["chapitre"])){
			$this->listerLesCommentaires($dataCommentaires->data, $argument["chapitre"]);
		}
		if (isset($argument["listModerate"])) $this->listeModeration($dataCommentaires->data);
		if (isset($argument["add"])){
			$this->insertComment($argument["add"]);
			return;
		}
		$this->numberOfComments = count($dataCommentaires->data);
	}

	private function listerLesCommentaires($data, $idPost){
		$commentaireVue = new CommentView($data, $this->slug);
		$vue = new View(
			[
				"{{ commentaires }}" => $commentaireVue->html,
        "{{ idPost }}"       => $idPost
			],
			"commentaireBase"
		);
		$this->html = $vue->html;
	}
	
	private function deleteComment($data){
		if ($this->deleteConfirmation) return $this->deleteConfirm($data);
		if ($this->delete) return $this->deleteComment();
	}

	private function listeModeration($data){
		$commentaireVue = new CommentView($data, $this->slug);
		$this->html = $commentaireVue->html;
	}







	private function insertComment($data){
	    $enregistrement = new CommentModel([
	      "save" => [
	        "id" 			 =>	$data["id"], 
	        "author"         => $data["author"],
	        "comment"        => $data["comment"],
	        "idPost"         => $data["id"],
	        "state"          => 0
	      ]
	    ]);
	    $this->saved = $enregistrement->succeed;
    }

	private function moderateComment($data){
	}

}