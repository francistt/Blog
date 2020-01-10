<?php

require_once "model/userModel.php";
class User{
	
	public  $id			= null;
	public  $name		= null;
	private $token;
	private $model;

	function __construct($identification = null)
	{
		global $session;
		if ($identification === null or !isset($identification["login"]) or !isset($identification["password"])) {
			if ($session->read("name") === null) return;
			$this->$id		= $session->read("id");
			$this->$name	= $session->read("name");
		}
		//aller chercher les informations de session)
		else {
			//die (var_dump($identification));
			$this->model = new UserModel(["identification"=>$identification]);
			if ($this->model->data) {
				$this->id   = $this->model->data["id"];
				$this->name = $this->model->data["prenom"].' '.$this->model->data["nom"];
				$session->save(compact($this->id, $this->name));
			}
			// else $session->destroy();
		}
	}

}
