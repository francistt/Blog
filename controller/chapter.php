<?php

require_once "model/chapterModel.php";
require_once "view/view.php";

class Chapter
{
  public  $ack                = null;
  public  $date;
  private $deleteConfirmation = false;
  private $delete             = false;
  public  $html;
  public  $id;
  public  $lastChapter;
  public  $slug;
  public  $title;
  
  /**
   * [__construct description]
   * @param Array $argument is an array with an id, a slug, or a list as a key
   */
  public function __construct($argument)
  {
    $this->defineToDo($argument);    
    $this->lastChapter = $this->lastChapterHtml();
  }

  private function defineToDo($args){
    extract($args);
    global $secure;
    if ($secure->post !== null)     $this->saveOrUpdate($secure->post, $args);
    if (isset($list))        return $this->listOfChapters();
    if (isset($listFront))   return $this->listOfChaptersFront();
    if (isset($featured))    return $this->featured();
    if (isset($editChapter)) return $this->editChapter($args);
   
    $this->singleChapter($args);
  }

  private function deleteChapter(){
    global $secure;
    $model = new ChapterModel(["delete" => end($secure->uri)]);
    global $config;
    header("Location: ".$config['basePath']."/admin/listChapters");
  }

  private function deleteConfirm(){
    $this->html = file_get_contents("template/confirmationSupression.html"); 
    $this->title   = "voulez vous supprimer ";    
  }

  private function editChapter($args){
    if ($this->deleteConfirmation) return $this->deleteConfirm($args);
    if ($this->delete) return $this->deleteChapter();

    $dataChapter = new ChapterModel(["slug"=>$args["editChapter"]]);
    $this->title   = "edition du chapite ".$dataChapter->title;
    $vue = new View(
      [
        "{{ ack }}"            => $this->ack,
        "{{ id }}"             => $dataChapter->id,
        "{{ numeroChapitre }}" => $dataChapter->numeroChapitre,
        "{{ titre }}"          => htmlspecialchars_decode($dataChapter->title),
        "{{ lastChapter }}"    => $dataChapter->content,    
        "{{ image }}"          => $dataChapter->image
      ],
      "editChapter"
    );
    $this->html = $vue->html;
  }

  private function featured(){
    $featured    = new ChapterModel(["featured" => true]);
    $this->id    = $featured->id;
    $this->title = htmlspecialchars_decode($featured->title);
    $this->data  = $featured->data;
    $this->slug  = $featured->slug;
  }

  private function insertChapter($dataPost){
    $slug = $this->makeSlug($dataPost["titre"]);
    $enregistrement = new ChapterModel([
      "save" => [
        "numeroChapitre" => $dataPost["numeroChapitre"], 
        "title"          => $dataPost["titre"],
        "content"        => $dataPost["chapitre"],
        "slug"           => $slug,
        "image"          => $dataPost["image"],
      ]
    ]);
    global $config;
    header("Location: ".$config['basePath']."/admin/listChapters");
  }

  private function lastChapterHtml(){
    $list     = new ChapterModel(["list" => 3]);
    $lastView = new View($list->slugList,"lastChapter");
    //transmettre les données de la liste à une vue
    return $lastView->html;
  }

  private function listOfChapters(){
    $list = new ChapterModel(["list" => 100]);
    $vue  = new View(
      $list->slugList,
      "listOfChapters"
    );
    $this->html = $vue->html;
  }

  private function listOfChaptersFront(){
    $list = new ChapterModel(["list" => 100]);
    $vue  = new View(
      $list->slugList,
      "listOfChaptersFront"
    );
    $this->html = $vue->html;
  }

  private function makeSlug($title){
    $title = html_entity_decode($title, ENT_QUOTES, "UTF-8");
    $title = trim($title);
    $title = str_replace("'" , "-", $title);
    $title = str_replace(" " , "-", $title);
    $title = preg_replace('#Ç#', 'C', $title);
    $title = preg_replace('#ç#', 'c', $title);
    $title = preg_replace('#è|é|ê|ë#', 'e', $title);
    $title = preg_replace('#È|É|Ê|Ë#', 'E', $title);
    $title = preg_replace('#à|á|â|ã|ä|å#', 'a', $title);
    $title = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $title);
    $title = preg_replace('#ì|í|î|ï#', 'i', $title);
    $title = preg_replace('#Ì|Í|Î|Ï#', 'I', $title);
    $title = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $title);
    $title = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $title);
    $title = preg_replace('#ù|ú|û|ü#', 'u', $title);
    $title = preg_replace('#Ù|Ú|Û|Ü#', 'U', $title);
    $title = strtolower($title);
    $title = htmlentities( $title, ENT_NOQUOTES, "UTF-8" );
    
    //$title = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $title );
    //$title = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $title );
    //$title = preg_replace( '#&[^;]+;#', '', $title );

    return $title;
  }

  private function saveOrUpdate($dataPost, $args){
    if ($dataPost["valider"] === "valider") return $this->updatePostContent($dataPost);
    if ($dataPost["valider"] === "ajouter") return $this->insertChapter($dataPost);
    if ($dataPost["supprimerConfirmation"] === "oui") $this->delete = true;
    if ($dataPost["supprimer"] === "supprimer") $this->deleteConfirmation = true;
  }

  private function singleChapter($args){
    $dataChapter = new ChapterModel($args);
    if (isset($dataChapter->error)){
      die("erreur serveur ".$dataChapter->error);

    }
    foreach ($dataChapter as $key => $value) {
      $this->$key = $value;
    }
    if (!isset($this->slug)){
      global $secure;
      $this->slug = end($secure->uri);
    }

    $dateText = IntlDateFormatter::formatObject(
      new DateTime($this->date), 
      "dd-MM-yyyy", //UCI standard formatted string
      'fr_FR'
    );

    $vue = new View(
      [
        "{{ content }}" => $this->content,
        "{{ dateText }}"=> $dateText,
        "{{ dateSEO }}" => $this->date,
        "{{ title }}"   => htmlspecialchars_decode($this->title),
        "{{ slug }}"    => $this->slug,
        "{{ image }}"   => $this->image
      ],
      "singleChapter"
    );
    $this->html = $vue->html;
  }

  private function updatePostContent($dataPost){
    $dataPost["slug"] = $this->makeSlug($dataPost["titre"]);
    $model = new ChapterModel(["update" => $dataPost]);
    if (!$model->succeed) $this->ack= [
      "msg" =>"erreur d'enregistrement : ".$model->reason,
      "class" => "error"
    ];
  }
}
