<?php

require_once "model/model.php";

class CommentModel extends Model{
public $data;
	function __construct($args){
		parent::__construct();
		if (isset($args["moderate"])){
			$newValue = [
			"id" => $args["moderate"]['id'],
			"state" => $args["moderate"]['state']+1
			];
			$request = $this->db->prepare ("UPDATE comments SET state = :state WHERE id = :id");
			$request->execute($newValue);
		}
		if (isset($args["chapitre"])){
			$sql= "SELECT ID, author AS '{{ author }}', comment AS '{{ comment }}', date AS '{{ date }}', state FROM comments WHERE idPost= ".$args['chapitre'];
			$request = $this->query($sql,TRUE); //fonction dans la classe Model
			$this->data = $request["data"];
		}
	}
}