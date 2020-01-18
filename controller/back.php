<?php
require_once "view/view.php";
require_once "controller/chapter.php";
require_once "controller/comment.php";
require_once "controller/user.php";

class Back{
  public  $html;
  private $user;
  private $uri;

  function __construct($uri){
    $this->uri = $uri;                                   // on enregistre l'adresse demandée    
    $todo = $uri[0];                                     // on garde le premier segment pour savoir quelle fonction appeler
    if ($todo === "") $todo = "accueil";                 // si le segment est la racine on affiche la page d'accueil
    if (!method_exists($this, $todo)) $todo = "accueil"; // si la fonction n'existe pas on affiche la page d'accueil
    $this->user = new User();
    if ($this->user->name === null) $todo = "login";     //si l'utilisateur n'a pas de nom c'est que l'authentification à échoué alors on affiche la page de login
    return $this->$todo();
  }

  private function accueil(){
    $this->html = file_get_contents("template/home.html"); 
  }

  private function comments(){
    $this->html = file_get_contents("template/commentaireBase.html"); 
  }

  private function chapter(){
    $this->html = file_get_contents("template/chapterModel.html");
  }

  private function editChapter(){
    $this->html="modifieChapitre test"; 
  }

  private function addChapter(){
    $this->html="ajouteChapitre test"; 
  }

  public function connexion(){   
  }

  public function deconnexion(){
  }

  public function eraseComment(){
  }

  private function login(){
    $this->html = file_get_contents("template/login.html");
  }
}
