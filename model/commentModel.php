<?php

require_once "model/model.php";

class CommentModel extends Model{
	
	public $data;
	public $succeed = true;

	public function __construct($args){
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
			$sql= "SELECT ID, author AS '{{ author }}', comment AS '{{ comment }}', DATE_FORMAT(date, '%d-%m-%Y') AS '{{ date }}', state FROM comments WHERE idPost= :idPost";
			$request = $this->pae(
				$sql,
				[
					"idPost"=>$args['chapitre']
				],
				TRUE
			); //fonction dans la classe Model
			$this->data = $request["data"];
		}
		if (isset($args["listModerate"])){
			$sql= "SELECT ID, author AS '{{ author }}', comment AS '{{ comment }}', DATE_FORMAT(date, '%d-%m-%Y') AS '{{ date }}', state FROM comments WHERE  `state` = 2 OR `state` = 0";
			$request = $this->query($sql,TRUE); //fonction dans la classe Model
			$this->data = $request["data"];
		}
		if (isset($args["listComment"])){
			$request = $this->pae(
				"SELECT count(*) AS total FROM comments WHERE `state` != 0  AND `state` != 2 AND  idPost=:idPost",
				[
					"idPost"=>$args['chapitre']
				],
				FALSE
			); //fonction dans la classe Model
			$this->data = $request["data"];
		}
		if (isset($args["delete"])){
			if (!isset($args["delete"]['commentState'])) return;
			if (!isset($args["delete"]['id'])) return;
			$newValue = [
				"id" => $args["delete"]['id'],
			];
			$request = $this->db->prepare ("DELETE FROM `comments` WHERE id = :id");
			$request->execute($newValue);
		}

		if (isset($args["add"])){
			$newData = [
				"idPost"	=> $args["add"]["id"], 
				"author"	=> $args["add"]["author"],
				"comment"	=> $args["add"]["comment"]
			];
			try{
				$sql = $this->db->prepare ("INSERT INTO `comments` (`author`, `comment`, `date`, `idPost`, `state`) VALUES (:author, :comment, NOW(), :idPost, 0)");
				$sql->execute($newData);
			}
			catch(exception $e){
				$this->succeed = false;
			}
		}
	}
}
