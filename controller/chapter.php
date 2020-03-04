<?php

require_once "model/chapterModel.php";
require_once "view/view.php";
/**
 * 
 */
class Chapter
{

  public $html;
  public $id;
  public $lastChapter;
  public $title;
  public $slug;
  public $date;
  
  /**
   * [__construct description]
   * @param Array $argument soit un tableau avec comme clé un id, un slug, ou list
   */
  function __construct($argument)
  {
    global $secure;
    extract($argument);
    if (isset($secure->post->titre)) $this->saveOrUpdate($argument); //a revoir plus tard
    if (isset($list)) $this->listOfChapters(); //a revoir plus tard
    else {
      if (isset($featured)) $this->featured();
      else $this->singleChapter($argument);
    }
    $this->lastChapter = $this->lastChapterHtml();
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
      "eeee dd MMMM yyyy", //UCI standard formatted string
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
    die("listOfChapters");
  }

  private function saveOrUpdate(){
    die("saveOrUpdate");
  }

  function update($id){
    die("update");
    $model = new ChapterModel(["id" => $id]);
    // $model = new ChapterModel(["slug"=>"un-super-chapitre"]);
    $this->title = $model->title;

    $vue = new View(
      [
        "{{ title }}"   => $model->title,
        "{{ content }}" => $model->content,
      ],
      "templateUpdate.html"
    );

    $this->html = $vue->html;
  }

  function createChapter(){
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
}