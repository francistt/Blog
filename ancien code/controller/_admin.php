<?php

/**
 * 
 */
class Admin
{
	private $template = "template/mainBack.html";
	private $url;

	/**
	 * initalise la classe
	 *
	 * @param array $url le contenu de ldap_add(link_identifier, dn, entry) barre d'adresse
	 *
	 * @return null le constructeur ne retourne rien
	 */

	function __construct($url)
	{
		$url = array_slice($url, 1);
		//on fait un second routage en fonction 
		$this->url=$url;

		switch ($url[0]) {
			case 'contact':
				$this->showContact();
				break;
			case 'chapitre':
				$this->showChapter();
				break;
			
			default:  //si il sait pas on affiche la page d'accueil
				$this->home();
				break;
		}
	}

	private function home(){
		$liste = new Chapitre();
	}

	private function showContact(){
		$carte = new Map();
		$carteHTML = $carte->show();
	}

	private function showChapter(){
		// $chapter = $this->url[2];
		// $monChapitre = new Chapitre($chapter);
		// $commentaires = new Comment($chapter);
	}
}