<?php

require_once "model/model.php";

class CommentModel extends Model{
public $data;
	function __construct($args){
		parent::__construct();
		if (isset($args["moderate"])){

			if (!isset($args["moderate"]['commentState'])) return;
			if (!isset($args["moderate"]['id'])) return;

			$state = $args["moderate"]['commentState']+1;
			if ($state > 3) return;

			$newValue = [
			"id" => $args["moderate"]['id'],
			"state" => $state
			];
			$request = $this->db->prepare ("UPDATE comments SET state = :state WHERE id = :id");
			$request->execute($newValue);
		}
		if (isset($args["chapitre"])){
			$sql= "SELECT ID, author AS '{{ author }}', comment AS '{{ comment }}', DATE_FORMAT(date, '%d-%m-%Y') AS '{{ date }}', state FROM comments WHERE idPost= ".$args['chapitre'];
			$request = $this->query($sql,TRUE); //fonction dans la classe Model
			$this->data = $request["data"];
		}
		if (isset($args["listModerate"])){
			$sql= "SELECT ID, author AS '{{ author }}', comment AS '{{ comment }}', DATE_FORMAT(date, '%d-%m-%Y') AS '{{ date }}', state FROM comments WHERE  `state` = 2 OR `state` = 0";
			$request = $this->query($sql,TRUE); //fonction dans la classe Model
			$this->data = $request["data"];
		}


	}
}