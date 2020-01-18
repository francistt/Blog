<?php
require_once "controller/chapter.php";
require_once "controller/comment.php";
require_once "controller/page.php";
require_once "controller/user.php";
require_once "view/view.php";

class Back extends Page{

  private $user;

  public function __construct($uri){
    $this->user = new User();
    if ($this->user->name === null) $this->login(); //si l'utilisateur n'a pas de nom c'est que l'authentification à échoué alors on affiche la page de login
    else {
      $todo = $this->defineTodo($uri, "accueil", $this);
      $this->$todo();
    }
  }

  private function accueil(){
    $this->html = file_get_contents("template/home.html"); 
  }

  private function addChapter(){
    $this->html="ajouteChapitre test"; 
  }

  private function editChapter(){
    $this->html="modifieChapitre test"; 
  }

  private function login(){
    $this->html = file_get_contents("template/login.html");
  }
}
