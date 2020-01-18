<?php

require_once "model/userModel.php";

class User{
  
  public  $id   = null;
  public  $name = null;
  // private $token;
  // private $model;

  function __construct()
  {
    global $session, $secure;

    if (isset($secure->post["user"])) { // il y a des données c'est que l'on essaye de se connecter
      $model = new UserModel([
        "identification"=>[
          "login"    => $secure->post["user"],
          "password" => $secure->crypt($secure->post["password"])
        ]
      ]);
      if ($model->data) {
        $this->id   = $model->data["id"];
        $this->name = $model->data["prenom"].' '.$model->data["nom"];
        $session->set([
          "id"   => $this->id,
          "name" => $this->name
        ]);
        $session->updateValidity();
      }
    }
    else { // il y a des données on vérifie donc qu'il y a bien une session d'active
      if ( ! $session->hasData() ) return;
      $this->id   = $session->get("id");
      $this->name = $session->get("name");
    }
  }
}
