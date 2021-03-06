<?php

require_once "model/model.php";

class UserModel extends Model{

public $data;

  function __construct($args){
    parent::__construct();
    if (isset($args["identification"])) return $this->getUserInformation($args["identification"]);
  }
  
  private function getUserInformation($data){
    $request = $this->db->prepare ("SELECT id,nom,prenom FROM users WHERE login = :login AND pass = :password");
    $args = [
      "login"    => $data["login"],
      "password" => $data["password"]
    ];
    $request->execute($args);
    $this->data = $request->fetch();
  } 
}