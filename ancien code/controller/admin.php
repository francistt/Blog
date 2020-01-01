<?php

require_once "controller/user.php";

class Admin{
  public $html;

  function __construct($uri){
    global $user;
    global $secure;
    // $uri = array_slice($uri, 0);

    // on enregistre l'adresse demandée
    $this->uri=$uri;

    // on garde le premier segment pour savoir quelle fonction appeler
    $todo = $uri[0];

    // si le segment est la racine on affiche la page d'accueil
    if ($todo == "") $todo = "accueil";

    // si la fonction n'existe pas on affiche la page d'accueil
    if (!method_exists($this, $todo)) $todo = "accueil";

    // on filtre les données potentiel en post

    if (isset($secure->post["user"])) { // il y a des données c'est que l'on essaye de se connecter
      $user  = new User([
        "user"     => $secure->post["user"],
        "password" => $secure->post["password"]
      ]);

      //si l'utilisateur n'a pas de nom c'est que l'authentification à échoué alors on affiche la page de login
      if (!$user->name) $todo = "login";
    }

    else { // il y a des données on vérifie donc qu'il y a bien une session d'active
      $user  = new User();
    }
    if (!$user->name) $todo = "login";
    return $this->$todo();
  }


  private function accueil(){
    
  }
  private function commentaires(){
  }
  private function chapitres(){
  }
  private function modifieChapitre(){
  }
  private function ajouteChapitre(){
  }
  private function login(){
    $this->html=file_get_contents("template/login.html");
  }
}