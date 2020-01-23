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
    $vue = new View(
      [
        "{{ title }}"   => $this->title,
        "{{ username }}"=> $this->user->name,
        "{{ content }}" => $this->html,
      ],
      "admin"
    );
    $this->html = $vue->html;
  }

  private function accueil(){
    $this->title = "accueil";
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

  private function logout(){
    $this->user->deconnexion();
    header('Location:./login');
  }

  private function moderateComent(){
  }
}
