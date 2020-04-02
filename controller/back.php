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
    $this->$todo($uri);
  }
  $vue = new View(
    [
      "ack"            => $this->ack,
      "{{ content }}"  => $this->html,
        //"{{ commentaires }}"  => $this->comment,
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
  $chapter     = new Chapter(["addChapter"=>true]);
  $this->title = "ajouter un chapitre";
  $this->html  = file_get_contents("template/addChapter.html"); 
}

private function editChapter($uri){
  $chapter     = new Chapter(["editChapter"=>$uri[1]]);
  $this->html  = $chapter->html;
  $this->title = $chapter->title;
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

private function listChapters(){
  $chapters    = new Chapter(["list"=>true]);
  $this->title = "choisir le chapitre à modifier";
  $this->html  = $chapters->html;
}




private function listComments($id){
  //die(var_dump($id));
  $comments    = new Comment(["moderateComments"=>id]);
  $this->title = "choisir le commentaire à modérer";
  $this->html  = $comments->html;
}

private function moderateComments($data){
    //die(var_dump($data));
  //$comments = new Comment(["moderateComments"=>ID]);
  //$this->html  = $comment->html;
  //$this->title = $comment->title;

    //$this->html = file_get_contents("template/moderateComments.html");
}
}