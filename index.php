<?php
//convetions https://www.mediawiki.org/wiki/Manual:Coding_conventions/PHP



require_once "controller/security.php";
require_once "controller/session-manager.php";


error_reporting(E_ALL | E_STRICT);
ini_set('display_errors',1);

$session = new SessionManager();

// $config	 = [
// 	'basePath' => "git/blog", // chemin (sous dossier) à inclure dans l'url 
// 	'base'     => "blog", // nom de la base de donnée
// 	'user'     => "root", // utilisateur pour la base
// 	'password' => "",     // mot de passe pour se connecter
//  'sessionDuration' => 1800,
//  'debug'    => true
// ]; 

// configuration Lionel
$config	 = [
  'basePath'        => "",
  'base'            => "francis-blog",
  'user'            => "root",
  'password'        => "root",
  'sessionDuration' => 1800,
  'debug'           => true
]; 

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