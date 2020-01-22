<?php
// Nous interceptons le gestionnaire 'files' natif, mais ceci
// fonctionnera de la même façon avec les autres gestionnaires internes
// comme 'sqlite', 'memcache' ou 'memcached'
// qui sont fournis via des extensions PHP.
ini_set('session.save_handler', 'files');
require_once "controller/encryptedSessionHandler.php";
$session = new EncryptedSessionHandler("maClefQuiCrypte");
session_set_save_handler($session, true);
session_start();
error_reporting(E_ALL | E_STRICT);ini_set('display_errors',1);


//convetions https://www.mediawiki.org/wiki/Manual:Coding_conventions/PHP

require_once "controller/security.php";


$config	 = [
	'basePath' => "blog", // chemin (sous dossier) à inclure dans l'url 
	'base'     => "blog", // nom de la base de donnée
	'user'     => "root", // utilisateur pour la base
	'password' => "root"  // mot de passe pour se connecter
]; 

//configuration Lionel
// $config	 = [
// 	'basePath' => "",
// 	'base'     => "francis-blog",
// 	'user'     => "root",
// 	'password' => "root"
// ]; 

$secure  = new Security([
	"cookies" =>[
		"auth" => FILTER_SANITIZE_STRING,
	],
	"post"   =>[
		'user'     => FILTER_SANITIZE_STRING,
		"password" => FILTER_SANITIZE_STRING
	],
  "uri" => $config["basePath"]
]);


// var_dump($secure->session::write());

// on récupère la barre d'adresse dans une variable $uri sous la transforme d'un tableau 
$uri = $secure->uri;

// on va filtrer en fonction des différents cas
switch ($uri[0]) {
  case 'admin':
    require_once "controller/back.php";
    $page = new Back(array_slice($uri, 1));
    break;
       //case "admin"

// tous les autres cas
  default:
    require_once "controller/front.php";
    $page = new Front($uri);
    break;
}

echo $page->html;