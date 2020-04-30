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
	if ( isset($create)   ) return $this->creatChapter($create);
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
		$this->data	= $request["data"];
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
		$req = $this->db->prepare("INSERT INTO `chapters` (`numeroChapitre`, `title`, `content`, `date`, `slug`) VALUES (:numeroChapitre,:title,:content,NOW(),:slug)");
		$req->execute($dataPost);
	}

	private function readChapterFromSlug($slug){
		$sql = "SELECT * FROM chapters WHERE slug = '$slug'";
		$request = $this->query($sql); //fonction dans la classe Model
		$this->checkSucced($request,"hydrate");
	}

    private function creatChapter($create){
	    $req = $this->db->prepare("INSERT INTO `chapters`(`id`, `numeroChapitre`, `title`, `content`, `date`, `slug`) VALUES (:id, :numeroChapitre, :title, :chapitre, NOW(), :slug)");
	    $req->execute([$create]);
	}

    private function updatePost($update){
		$request = $this->db->prepare("UPDATE `chapters` SET `title` = ':titre',`numeroChapitre` = ':numeroChapitre', `content` = ':chapitre', `date` = NOW(), `slug` = ':slug' WHERE `chapters`.`id` = ':id'");

		try{
		    //$request = $this->db->prepare($req);
		    //$request->bindParam(':titre', $update["titre"]);
			//$request->bindParam(':numeroChapitre', $update["numeroChapitre"]);
			//$request->bindParam(':slug', $update["slug"]);
			//$request->bindParam(':chapitre', $update["chapitre"]);
			//$request->bindParam(':id', $update["id"]);
			$request->execute([
				'title' 	 	 => $update["titre"],
				'numeroChapitre' => $update["numeroChapitre"], 
				'content' 		 => $update["chapitre"],
				'slug' 			 => $update["slug"]
			]);

			var_dump($update);
			$this->succeed = true;
		}
		catch (Exception $e) {
			$this->succeed = false;
		}
	}

}

//UPDATE `chapters` SET `content` = 'Phasellus in nunc orci. Vivamus ut dui ex. Proin mollis dolor id massa ultricies tempor. Nam quis tortor euismod, aliquet tortor non, porta velit. Vivamus semper euismod nunc, fermentum tempus felis vestibulum a. Suspendisse ac sem rutrum, condimentum lacus semper, interdum ipsum.VVV' WHERE `chapters`.`id` = 3

		//if (isset($args["add"])){
		//	$newData = [

		//		"titre"	            => $args["add"]["titre"], 
		//		"numeroChapitre"	=> $args["add"]["numeroChapitre"],
        //	    "content"	        => $args["add"]["chapitre"],
		//		"slug"	            => $args["add"]["slug"],
		//		"id"	            => $args["add"]["id"]
		//	];


	    //$sql = $this->db->prepare ("INSERT INTO `comments` (`author`, `comment`, `date`, `idPost`, `state`) VALUES (:author, :comment, NOW(), :idPost, 0)");
	    //$sql->execute($newData);
		//}

//UPDATE `chapters` SET `content` = '&lt;p&gt;DFFFF&lt;/p&gt; vert' WHERE `chapters`.`id` = 24;
//UPDATE `chapters` SET `numeroChapitre` = '32' WHERE `chapters`.`id` = 24;