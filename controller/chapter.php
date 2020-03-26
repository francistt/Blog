<?php

require_once "model/chapterModel.php";
require_once "view/view.php";
/**
 * 
 */
class Chapter
{

  public  $html;
  public  $id;
  public  $lastChapter;
  public  $title;
  public  $slug;
  public  $date;
  public  $ack                = null;
  private $deleteConfirmation = false;
  private $delete             = false;
  
  /**
   * [__construct description]
   * @param Array $argument soit un tableau avec comme clé un id, un slug, ou list
   */
  function __construct($argument)
  {
    $this->defineToDo($argument);    
    $this->lastChapter = $this->lastChapterHtml();
  }

  private function defineToDo($args){
    extract($args);
    global $secure; //a revoir plus tard
    if ($secure->post !== null) $this->saveOrUpdate($secure->post, $args);

    if (isset($list))        return $this->listOfChapters();
    if (isset($featured))    return $this->featured();
    if (isset($editChapter)) return $this->editChapter($args);
    //if (isset($addChapter))  return $this->addChapter();

    $this->singleChapter($args);
  }


  private function singleChapter($args){
    $dataChapter = new ChapterModel($args);
    if (isset($dataChapter->error)){
      die("// a completer");

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
      "dd.MM.yyyy", //UCI standard formatted string
      'fr_FR'
      );


    $vue = new View(
      [
        "{{ content }}" => $this->content,
        "{{ dateText }}"=> $dateText,
        "{{ dateSEO }}" => $this->date,
        "{{ title }}"   => $this->title,
        "{{ slug }}"    => $this->slug
      ],
      "singleChapter"
    );
    $this->html = $vue->html;
  }

  private function listOfChapters(){
    $list = new ChapterModel(["list" => 100]);
     //$featured = new ChapterModel(["content" => 100]);
    $vue  = new View(
      $list->slugList,
      //$content->data,
      "listOfChapters"
    );
    $this->html = $vue->html;
  }

  private function saveOrUpdate($dataPost, $args){
    // die(var_dump($dataPost));
    if ($dataPost["valider"] === "valider") return $this->updatePostContent($dataPost);
    if ($dataPost["supprimerConfirmation"] === "oui") $this->delete = true;
    if ($dataPost["supprimer"] === "supprimer") $this->deleteConfirmation = true;
  }

  private function updatePostContent($dataPost){
    $dataPost["slug"] = $this->makeSlug($dataPost["titre"]);
    $model = new ChapterModel(["update" => $dataPost]);
    if (!$model->succeed) $this->ack= [
      "msg" =>"erreur d'enregistrement",
      "class" => "error"
    ];
  }

  private function createChapter(){
    die("createChapter");
    //si pas donnée post -> on affiche une page où il va pouvoir saisir

    //si données en post -> on enregistre
    $enregistrement = new ChapterModel([
      "save" => [
        "id"    => 17,
        "title" => "lkjkljkljklj"
      ]
    ]);
  }
  private function lastChapterHtml(){
    $list     = new ChapterModel(["list" => 3]);
    $lastView = new View($list->slugList,"lastChapter");
    //transmettre les données de la liste à une vue
    
    return $lastView->html;
  }
  private function featured(){
    $featured    = new ChapterModel(["featured" => true]);
    $this->id    = $featured->id;
    $this->title = $featured->title;
    $this->data  = $featured->data;
    $this->slug  = $featured->slug;
  }


  // function convertTitleToSlug($title){
  //  // $title = "la vie est géniale"
  //  // la-vie-est-geniale

  // $title = implode("-", explode(" ", $title));
  // $title = implode("e", explode("é", $title));
  // return $title;
  // }
  // 
  private function editChapter($args){
    if ($this->deleteConfirmation) return $this->deleteConfirm($args);
    if ($this->delete) return $this->deleteChapter();

    $dataChapter = new ChapterModel(["slug"=>$args["editChapter"]]);
    $this->title   = "edition du chapite ".$dataChapter->title;

    // die(var_dump($dataChapter));

    $vue = new View(
      [
        "{{ ack }}" => $this->ack,
        "{{ id }}" => $dataChapter->id,
        "{{ titre }}" => $dataChapter->title,
        "{{ lastChapter }}" => $dataChapter->content
      ],
      "editChapter"
    );

    $this->html = $vue->html;
  }

  private function deleteConfirm(){
    $this->html = file_get_contents("template/confirmationSupression.html"); 
    $this->title   = "voulez vous supprimer ";
    
  }

  private function makeSlug($title){
    $title = strtolower($title);
    $title = str_replace(" ", "-", $title);
    return $title;
  }
}
