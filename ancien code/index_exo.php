<?php

class Video{
	private $length;
	public  $name;

	public function __construct($name, $seconds){
		$this->name = $name;
		$this->length = $seconds;
	}

	public function play(){
		echo "[Vidéo] Lecture de $this->name <br>\r\n";
	}
}

class Photo{
	public  $name;

	public function __construct($name){
		$this->name = $name;
	}
}

class Music{
	private $length;
	public  $name;

	public function __construct($name, $seconds){
		$this->name = $name;
		$this->length = $seconds;
	}
}

class Playlist{
	public  $name;
	public  $list = [];

	public function __construct($name){
		$this->name = $name;
	}

	public function __toString(){
		return $this->showPlaylistElements($this);
  }

  private function showPlaylistElements($playlist, $level=1){
  	$affichage = $playlist->name."<br>\r\n";
		foreach ($playlist->list as $key => $value) {
			$affichage .= $playlist->listElement($value, $level)."<br />\r\n";
		}
    return $affichage;
  }

  private function listElement($elm, $level){
  	$return = "";
  	for ($i=0; $i < $level; $i++) { 
  		$return .= "| ";
  	}
  	if ($elm instanceof Video)    $return .= $elm->name.' (vidéo)';
  	if ($elm instanceof Photo)    $return .= $elm->name.' (image)';
  	if ($elm instanceof Music)    $return .= $elm->name.' (audio)';
  	if ($elm instanceof Playlist) $return .= $this->showPlaylistElements($elm, $level+1);
  	return $return;
  }

	public function add($element){
		array_push($this->list, $element);
	}
}



// Création d'une vidéo "Matrix" (1.5h)
$matrix = new Video('Matrix', 1.5*3600);
// Création d'une photo "Joconde"
$joconde = new Photo('Joconde');
// Création d'une musique "Stairway to heaven" (8 min)
$stairway = new Music('Stairway to heaven', 8*60);
// Création d'une playlist "P1"
$p1 = new Playlist('P1');
// Ajout de "Matrix" à "P1"
$p1->add($matrix);
// Ajout de "Joconde" à "P1"
$p1->add($joconde);
// Création d'une playlist "P2"
$p2 = new Playlist('P2');
// Ajout de "Stairway to heaven" à "P2"
$p2->add($stairway);
// Ajout de "P1" à "P2"
$p2->add($p1);
// Affichage de "Lecture de Matrix (durée: 5400s)"
$matrix->play();
// Affichage de P2
echo $p2;
?>