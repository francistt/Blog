<?php

require_once "view/view.php";
require_once "controller/chapter.php";
require_once "controller/comment.php";
/**
 * 
 */
class Front{

  public $html;
  private $title;

  public function __construct($uri)
  {
    global $config;
    switch ($uri[0]) {
      case 'contact':
      $this->contact();
      break;
      case 'chapitre':
      $this->chapter(array_slice($uri, 1));
      break;
      case 'bio':
      $this->bio();
      break;
      case 'chapitrelist':
      $this->chapitrelist();
      break;
      default:
      $this->home();
      break;
    }
    $chapitre = new Chapter(["lastChapter"=>true]);
    $vue = new View(
      [
        "{{ content }}"     => htmlspecialchars_decode ($this->html),
        "{{ title }}"       => $this->title,
        "{{ lastChapter }}" => $chapitre->lastChapter,
      ],
      "main"
    );
    $this->html = $vue->html;
  }
  
  //private function addComment(){
  //  $comment     = new Comment(["addComment"=>true]);
  //  $this->title = "ajouter un commentaire";
  //  $this->html  = file_get_contents("template/commentaireBase.html"); 
  //}

  private function bio(){
    $this->html   = file_get_contents("template/bio.html");
    $this->title  = "Biographie de Jean Forteroche";
  }

  private function chapter($uri){
    $slug = $uri[0];
    $ack = null;

    global $secure;
    if ($secure->post !== null){
      if ($secure->post["commentAction"] === "Ajouter"){
        $comment = new Comment(["add" => $secure->post]);

        if ($comment->saved) $ack = [
          "msg"   => "votre commentaire à bien été enregistré. Il est en attente de modération",
          "class" => "succeed"
        ];
        else $ack = [
          "msg"   => "nous rencontrons un problème technique, veuillez rééssayer plus tard.",
          "class" => "error"
        ];
        $vue = new View( [ "ack" => $ack ], "ackOnly" );
        $ack = $vue->html;
      }
      if ($secure->post["commentAction"] === "signaler") $chapitre = new Comment(["moderate" => $secure->post]);
    }
    $chapitre = new Chapter(["slug" => $slug]);
    $this->html        = $chapitre->html;
    $this->title       = $chapitre->title;
    $this->lastChapter = $chapitre->lastChapter;
    $commentData = [
      "chapitre" => $chapitre->id,
      "slug"     => $slug
    ];
    if (isset ($uri[1])){
      if ($uri[1] === "moderate"){
        $commentData["moderate"] = [
          "id"    => $uri[3],
          "state" => $uri[2]
        ];
      }
    }
    $commentaire = new Comment($commentData);
    $this->html .= $commentaire->html;

    if ($ack !== null) $this->html .= $ack;
  }

  private function chapitrelist(){
    $chapters = new Chapter(["listFront"=>true]);
    $this->html   = $chapters->html;
    $this->title  = "liste des chapitres";
  }

  private function contact(){
    global $secure;
    if ($secure->post["message"] !== null) {
      $succeed = $this->sendMail();
      if ($succeed) $ack = [
        "msg"   => "votre message à bien été envoyé",
        "class" => "succeed"
      ];
      else $ack = [
        "msg"   => "nous rencontrons un problème technique, veuillez rééssayer plus tard.",
        "class" => "error"
      ];
      $vue = new View( [ "ack" => $ack ], "ackOnly" );
      $this->html = $vue->html;
      return;
    }
    $this->html   = file_get_contents("template/contact.html");  
  }

  private function home(){
    $chapitre = new Chapter(["featured" => true]);
    $comments = new Comment([
      "chapitre"    => $chapitre->id,
      "slug"        => $chapitre->slug,
      "listComment" => true
    ]);
    $chapitre->data["{{ numberOfComments }}"] = $comments->numberOfComments;
    $featuredView = new View($chapitre->data,"home");
    $this->html   = $featuredView->html;
    $this->title  = $chapitre->title;
  }

  private function sendMail(){
    global $secure;
    try{
      mail($secure->post['email'], 'Envoi depuis la page Contact de '.$secure->post['nom'], $secure->post['message'], 'From : virg.franfran@gmail.com');
      return true;
    }
    catch (Exception $e){
      return false;
    }
  }
}