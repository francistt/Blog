<?php

require_once "model/userModel.php";
class User{
	
	public  $id   = null;
	public  $name = null;
	private $token;
	private $model;

	function __construct($identification = null)
	{
		if ($identification === null or !isset($identification["login"]) or !isset($identification["password"])) {
			global $secure;
			//die (var_dump($secure));
			if ($secure->cookies["auth"] === null)return;
			var_dump(base64_decode($secure->cookies['auth']));
			$cookie = base64_decode(unserialize($secure->cookies['auth']));
			$this->model = new UserModel([
				"identification" => "cookie",
				"login"          =>$cookie["login"],
				"token"          =>$cookie["token"]
			]);
		}
		//aller chercher les informations de session)
		else {
			//die (var_dump($identification));
			$this->model = new UserModel(["identification"=>$identification]);
		}
		if ($this->model->data) {
			$this->id   = $this->model->data["id"];
			$this->name = $this->model->data["prenom"].' '.$this->model->data["nom"];
			$this->addCookie();
		}
		else $this->deleteCookie();
	}



	// private function identifyWithCookie($args){
	// 	global $secure;
	// 	if (isset ($secure->cookie["login"]) and isset($secure->cookie["pass"])){
	// 		try {
	// 			$db = new PDO('mysql:host=localhost;dbname='.$config["base"].';charset=utf8', $config["user"], $config["password"]);
	// 		}
	// 		catch(Exception $e){
	// 			die('Erreur : '.$e->getMessage());
	// 		}
	// 		$request = $this->db->prepare ("SELECT * FROM users WHERE login = :login AND pass = :password");
	// 		$request->execute(array(
	// 			'pseudo' => $_COOKIE['pseudo'],
	// 			'pass' => $_COOKIE['pass'])
	// 	);
	// 	}
	// }

	/**
	 * 	créer ou met à jour le cookie
	 *  @return void 
	 */
	private function addCookie(){
		//on génère un token
			$this->token = uniqid();
		//on enregistre le token
		$result = $this->model->updateToken($this->id, $this->token);

		//on génère un cookie
		var_dump($this);
		setcookie(
			'auth', 
			base64_encode(serialize([
				'login'=>$this->name,
				'token'=>$this->token
			])), 
			0
		);
		

	}
	private function deleteCookie(){
		setcookie(
			'auth', 
			"",
			time()
		);
	}
}
