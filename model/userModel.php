<?php

require_once "model/model.php";

class UserModel extends Model{
public $data;
	function __construct($args){
		parent::__construct();
		//var_dump($args);
		switch ($args["identification"]) {
			case 'cookie':
				$request = $this->db->prepare ("SELECT * FROM users WHERE login = :login AND token = :token");
				$args = [
					"login" => $args["login"],
					"token" => $args["token"]
				]
				;
				break;
			default:
				$request = $this->db->prepare ("SELECT id,nom,prenom FROM users WHERE login = :login AND pass = :password");
				$args = [
					"login" => $args["identification"]["login"],
					"password" => $args["identification"]["password"]
				];
				break;
		}
		$request->execute($args);
		$this->data = $request->fetch();
	}

	function updateToken($id, $newToken){
		$request = $this->db->prepare ("UPDATE `users` SET token = :token WHERE $id = :id");
		return $request->execute(
			["id"   =>$id,
			"token"=>$newToken]
		);
	}
}