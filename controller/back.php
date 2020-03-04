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
    if ($this->user->name === null) 
    $this->login(); //si l'utilisateur n'a pas de nom c'est que l'authentification à échoué alors on affiche la page de login
    else {
      $this->template = "mainAdmin";
      $todo = $this->defineTodo($uri, "accueil", $this);
      $this->$todo();
    }
    $vue = new View(
      [
        "ack"            => $this->ack,
        "{{ content }}"  => $this->html,
        "{{ title }}"    => $this->title,
        "{{ username }}" => $this->user->name,
      ],
    $this->template
    );
    $this->html = $vue->html;
  }

  private function accueil(){
    $this->title = "accueil";
    $this->html  = file_get_contents("template/home.html"); 
  }

  private function addChapter(){
    $this->title = "titre à modifier 1";
    $this->html  = file_get_contents("template/addChapter.html"); 
  }

  private function editChapter(){
    $this->title   = "titre à modifier 2";
    $this->chapter = file_get_contents("template/editChapter.html");
  }

  private function moderateComment(){
    $this->html = file_get_contents("template/moderateComment.html");
  }

  private function login(){
    $this->title    = "interface";
    $this->template = "login";
    global $secure;
    if( $secure->post !== null ) $this->ack = [
      "msg"   => "Mauvais identifiant ou mot de passe",
      "class" => "error"
    ];
  }

  private function logout(){
    $this->user->deconnexion();
    header('Location:./login');
  }
}
