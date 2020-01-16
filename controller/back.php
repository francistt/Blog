<?php
require_once "view/view.php";
require_once "controller/chapter.php";
require_once "controller/comment.php";
require_once "controller/user.php";

class Back{
  public $html;
  private $user;
  private $uri;

  function __construct($uri){
    global $secure;

    // on enregistre l'adresse demandée
    $this->uri = $uri;

    // on garde le premier segment pour savoir quelle fonction appeler
    $todo = $uri[0];

    // si le segment est la racine on affiche la page d'accueil
    if ($todo === "") $todo = "accueil";

    // si la fonction n'existe pas on affiche la page d'accueil
    if (!method_exists($this, $todo)) $todo = "accueil";

    // on filtre les données potentiel en post

    if (isset($secure->post["user"])) { // il y a des données c'est que l'on essaye de se connecter
      $this->user = new User([
        "login"    => $secure->post["user"],
        "password" => $secure->cryptedPassword()
      ]);
    }
    else { // il y a des données on vérifie donc qu'il y a bien une session d'active
      $this->user = new User();
    }
      //si l'utilisateur n'a pas de nom c'est que l'authentification à échoué alors on affiche la page de login
    if (!$this->user->name) $todo = "login";
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
    //$this->html = file_get_contents("template/login.html");
   }
}
