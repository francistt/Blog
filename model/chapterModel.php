<?php
require_once "model/model.php";

class ChapterModel extends Model{

  public $content;
  public $date;
  public $id;
  public $numeroChapitre;
  public $slug;
  public $title;

/**
 * __construct permet de définir quelles sont les actions à faire pour créer une itération unique de la classe en fonction des arguments donnés 
 * @param Array   $args   soit un id, soit un slug, soit un tableau "save" ou "update" contenant les données à enregistrer
 */
function __construct($args){
  parent::__construct();
  extract($args);
  if ( isset($delete)   ) return $this->deletePost($delete);
  if ( isset($featured) ) return $this->readFeaturedPost($featured);
  if ( isset($id)       ) return $this->readChapterFromId($id);
  if ( isset($list)     ) return $this->getListChapters($list);
  if ( isset($save)     ) return $this->saveContent($save);
  if ( isset($slug)     ) return $this->readChapterFromSlug($slug);
  if ( isset($update)   ) return $this->updatePost($update);
  if ( isset($create)   ) return $this->createChapter($create);
  }

  private function deletePost($slug){
    $req = $this->db->prepare('DELETE FROM chapters WHERE slug = ?');
    $req->execute([$slug]);
        //return $suppr;
  }

  private function readFeaturedPost($featured){
        // $sql= "SELECT * FROM `chapters` ORDER BY date DESC limit 1";
    $sql = "SELECT title AS '{{ title }}', DATE_FORMAT(date, '%d-%m-%Y') AS '{{ date }}', slug AS '{{ slug }}', content AS '{{ content }}' FROM `chapters` ORDER BY date DESC limit 1";
    $request = $this->query($sql);
    $this->data = $request["data"];
    $sql = "SELECT title, id, slug FROM `chapters` ORDER BY date DESC limit 1";
    $request = $this->query($sql);
    $this->checkSucced($request,"hydrate");
  }

  private function readChapterFromId($id){
    $sql = "SELECT * FROM chapters WHERE id = '$id'";
    $request = $this->query($sql); //fonction dans la classe Model
    $this->checkSucced($request,"hydrate");
  }

  private function getListChapters($list){
    $sql = "SELECT `numeroChapitre` AS `{{ numeroChapitre }}` ,`slug` AS `{{ slug }}`,`title` AS `{{ titre }}` FROM `chapters` ORDER BY numeroChapitre DESC limit $list";
    $request = $this->query($sql,true);
    $this->slugList = $request["data"];
  }

  private function saveContent($dataPost){
      //requete pour enregister les données
    $req = $this->db->prepare("INSERT INTO `chapters` (`numeroChapitre`, `title`, `content`, `date`,  `image`, `slug`) VALUES (:numeroChapitre,:title,:content,NOW(), :image, :slug)");
    $req->execute($dataPost);
  }

  private function readChapterFromSlug($slug){
    $sql = "SELECT * FROM chapters WHERE slug = '$slug'";
    $request = $this->query($sql); //fonction dans la classe Model
    $this->checkSucced($request,"hydrate");
  }

  private function createChapter($create){
    $req = $this->db->prepare("INSERT INTO `chapters`(`id`, `image`, `numeroChapitre`, `title`, `content`, `date`, `slug`) VALUES (:id, :image, :numeroChapitre, :title, :chapitre, NOW(), :slug)");
    $req->execute([$create]);
  }

  private function updatePost($update){
    try{
      $sql = "UPDATE `chapters` SET `title` = :title,`numeroChapitre` = :numeroChapitre, `slug` = :slug, `content` = :chapitre WHERE  `id` = :id";
      $req = $this->db->prepare($sql);
      $req->execute($values = [
        "id"=>$update["id"],
        "title"=>$update["titre"],
        "numeroChapitre"=>$update["numeroChapitre"],
        "slug"=>$update["slug"],
        "chapitre"=>$update["chapitre"]
      ]);
      $this->succeed = true;
    }
    catch (Exception $e) {
      $this->reason  = $e;
      $this->succeed = false;
    }
  }
}