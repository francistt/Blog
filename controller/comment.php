<?php

require_once "model/commentModel.php";
require_once "view/view.php";
require_once "view/commentView.php";
/**
 * 
 */
class Comment
{
	public $html;
	public $numberOfComments;
	private $slug;

	/**
	 * [__construct description]
	 * @param Array $argument soit un tableau avec comme clé un id, un slug, ou list
	 */
	public function __construct($argument){
		$dataCommentaires = new CommentModel($argument);
		if (isset($argument["slug"]))$this->slug = $argument["slug"];
		if (isset($argument["chapitre"])){
			$this->listerLesCommentaires($dataCommentaires->data);
		}
		$this->numberOfComments = count($dataCommentaires->data);
	}
	private function listerLesCommentaires($data){
		$commentaireVue = new CommentView($data,$this->slug);
		$vue = new View(
			[
				"{{ commentaires }}" => $commentaireVue->html
			],
			"commentaireBase"
		);
		$this->html = $vue->html;
	}
}