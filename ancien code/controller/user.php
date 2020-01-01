<?php


/**
 * 
 */
class User
{
  public $name = false;
  public $id;
  function __construct($args=null) {
    
    if ($args === null)  $this->initFromSession();
    else $this->initFromPostData($args["user"], $args["password"]);
  }

  private function initFromSession(){
    global $session;
    $donneesSession = $session->get("data");
    if (isset($donneesSession["user"])) $this->name = $donneesSession["user"];
  }

  private function initFromPostData($username,$password){
    global $model;
    $request =[
      "type" => "select",
      "req"  => [
        "need"  => ["id"],
        "table" => "user",
        "where" => ["name = '".$username."'", "password = '". $password."'"]
      ]
    ];

    $user = $model->getData($request); 
    if (empty($user["data"])) {
      //l'authentification a échoué
      die("mauvaise association");
    }
    else{
      //l'authentification a réussie ->id
      $this->name = $username;
      $this->id = $user["data"][0]["id"];
    }
  }
}



