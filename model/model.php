<?php


class model
{
	public $db;
	public function __construct()
	{
		global $config;
		try {
      $this->db = new PDO('mysql:host=localhost;dbname='.$config["base"].';charset=utf8', $config["user"], $config["password"]);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
      if ($config["debug"]) $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e){
      die('Erreur : '.$e->getMessage());
    }
	}
	public function query($sql,$all=false)
	{
		try {
      	$resultat = $this->db->query($sql);
  		if ($all == true) $data = $resultat->fetchAll();
  		else $data= $resultat->fetch();
 		$resultat->closeCursor();
 		return [
  		"succeed" => TRUE,
  		"data" => $data
  		];
		}
		catch(Exception $e) {
  		return [
  		"succeed" => FALSE,
  		"data" => $e
  		];
		}
	}
	public function hydrate($modelData)
	{
		foreach ($modelData as $key => $value) {
			$this->$key = $value;
		}
	}
	public function checkSucced($donnees, $callBack)
	{
		if ($donnees["succeed"]) $this->$callBack($donnees["data"]);
		else $this->error = $donnees["data"];
	}
}

