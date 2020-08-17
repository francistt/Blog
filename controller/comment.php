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
	 * @param Array $argument is an array with an id, a slug, or a list as a key
	 */
	public function __construct($argument){
		$dataCommentaires = new CommentModel($argument);
		if (isset($argument["listComment"])) {
			$this->numberOfComments = $dataCommentaires->data["total"];
			return;	
		}
		if (isset($argument["slug"]))$this->slug = $argument["slug"];
		if (isset($argument["chapitre"])){
			$this->listerLesCommentaires($dataCommentaires->data, $argument["chapitre"]);
		}
		if (isset($argument["listModerate"])) $this->listeModeration($dataCommentaires->data);
		if (isset($argument["add"])){
			$this->insertComment($argument["add"]);
			return;
		}
	}

	//private function deleteComment($data){
	//            die(var_dump($data));
	//	if ($this->deleteConfirmation) return $this->deleteConfirm($data);
	//	if ($this->delete) return $this->deleteComment();
	//}

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

	private function listeModeration($data){
		$commentaireVue = new CommentView($data, $this->slug);
		$this->html = $commentaireVue->html;
	}
}