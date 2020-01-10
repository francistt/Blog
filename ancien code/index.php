<?php

error_reporting(E_ALL | E_STRICT);ini_set('display_errors',1);

//convetions https://www.mediawiki.org/wiki/Manual:Coding_conventions/PHP

require_once "model/model.php";
require_once "controller/session.php";
require_once "controller/security.php";

// $model   = new Model("francis","root", "");
$model   = new Model("francis","devUser", "devPassword");
$secure  = new Security([
	"cookies" =>[
		"PHPSESSID" => [
			'filter' => FILTER_SANITIZE_STRING,
			'flags'  => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH
		]
	],
	"post" =>[
		'user'     => FILTER_SANITIZE_STRING,
		"password" => FILTER_SANITIZE_STRING
	]
]);
$session = new Session();

// on récupère la barre d'adresse dans une variable $uri sous la transforme d'un tableau 
$uri = $secure->safeUri();

// on va filtrer en fonction des différents cas
switch ($uri[0]) {
  case 'admin':
    require_once "controller/admin.php";
    $page = new Admin(array_slice($uri, 1));
    break;
       //case "admin"

// tous les autres cas
  default:
    require_once "controller/client.php";
    $page = new Client($uri);
    break;
}

echo $page->html;