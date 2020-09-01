<?php
require_once "model/model.php";

class ChapterModel extends Model{

  public $content;
  public $date;
  public $id;
  public $numeroChapitre;
  public $slug;
  public $title;
  public $image;

/**
 * __construct allows you to define what actions to do to create a unique iteration of the class according to the arguments given 
 * @param Array   $args is an id, or a slug, or an array "save" or "update" with data to record 
 */
public function __construct($args){
  parent::__construct();
  extract($args);
  if ( isset($delete)    ) return $this->deletePost($delete);
  if ( isset($featured)  ) return $this->readFeaturedPost($featured);
  if ( isset($list)      ) return $this->getListChapters($list);
  if ( isset($save)      ) return $this->saveContent($save);
  if ( isset($slug)      ) return $this->readChapterFromSlug($slug);
  if ( isset($update)    ) return $this->updatePost($update);
  if ( isset($getNextId) ) return $this->getNextId();
  }

  private function deletePost($slug){
    $req = $this->db->prepare('DELETE FROM chapters WHERE slug = ?');
    $req->execute([$slug]);
  }

  private function readFeaturedPost(){
    $sql = "SELECT title AS '{{ title }}', DATE_FORMAT(date, '%d-%m-%Y') AS '{{ date }}', slug AS '{{ slug }}', content AS '{{ content }}', image AS '{{ image }}' FROM `chapters` ORDER BY date DESC limit 1";
    $request = $this->query($sql);
    $this->data = $request["data"];
    $sql = "SELECT title, id, slug FROM `chapters` ORDER BY date DESC limit 1";
    $request = $this->query($sql);
    $this->checkSucced($request,"hydrate");
  }

  private function getListChapters($list){
    $sql = "SELECT `numeroChapitre` AS `{{ numeroChapitre }}` ,`slug` AS `{{ slug }}`,`title` AS `{{ titre }}` FROM `chapters` ORDER BY numeroChapitre DESC limit $list";
    $request = $this->query($sql,true);
    $this->slugList = $request["data"];
  }

  private function saveContent($dataPost){
      //requete pour enregister les données
    $req = $this->db->prepare("INSERT IGNORE INTO `chapters` (`numeroChapitre`, `title`, `content`, `date`,  `image`, `slug`) VALUES (:numeroChapitre,:title,:content,NOW(), :image, :slug)");
    $count = $req->rowCount();
    $req->execute($dataPost);
    //(var_dump($count));
  }

  private function readChapterFromSlug($slug){
    $sql = "SELECT * FROM chapters WHERE slug = :slug";
    $request = $this->pae($sql, ["slug"=>$slug]);
    $this->checkSucced($request,"hydrate");
  }

  private function updatePost($update){
    try{
      $sql = "UPDATE `chapters` SET `title` = :title,`numeroChapitre` = :numeroChapitre,`date` = NOW(), `slug` = :slug, `image` = :image, `content` = :chapitre WHERE  `id` = :id";
      $req = $this->db->prepare($sql);
      $req->execute([
        "id"=>$update["id"],
        "title"=>$update["titre"],
        "numeroChapitre"=>$update["numeroChapitre"],
        "slug"=>$update["slug"],
        "chapitre"=>$update["chapitre"],
        "image"=>$update["image"]
      ]);
      $this->succeed = true;
    }
    catch (Exception $e) {
      $this->reason  = $e;
      $this->succeed = false;
    }
  }

  private function getNextId(){
    $sql = "SELECT numeroChapitre FROM `chapters` ORDER BY numeroChapitre DESC limit 1";
    $request = $this->query($sql);
    $this->checkSucced($request,"hydrate");
  }
}