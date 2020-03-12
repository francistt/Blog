<?php
//convetions https://www.mediawiki.org/wiki/Manual:Coding_conventions/PHP

require_once "controller/security.php";
require_once "controller/session-manager.php";

$config  = [
  'basePath'        => "/blog",    // chemin (sous dossier) à inclure dans l'url 
  'base'            => "blog",     // nom de la base de donnée
  'user'            => "root",     // utilisateur pour la base
  'password'        => "root",     // mot de passe pour se connecter
  'sessionDuration' => 1800,
  'debug'           => true
]; 

// configuration Lionel
$config  = [
 'basePath'        => "",
 'base'            => "francis-blog",
 'user'            => "root",
 'password'        => "root",
 'sessionDuration' => 1800,
 'debug'           => true
];

if ($config["debug"]) {
  error_reporting(E_ALL | E_STRICT);
  ini_set('display_errors',1);
}

$session = new SessionManager($config["sessionDuration"]);

$secure  = new Security([
  "post" => [
    'user'                  => FILTER_SANITIZE_STRING,
    'password'              => FILTER_SANITIZE_STRING,
    'nom'                   => FILTER_SANITIZE_STRING,
    'email'                 => FILTER_SANITIZE_STRING,
    'message'               => FILTER_SANITIZE_STRING,
    'valider'               => FILTER_SANITIZE_STRING,
    'supprimer'             => FILTER_SANITIZE_STRING,
    'supprimerConfirmation' => FILTER_SANITIZE_STRING,
    'annulerSuppression'    => FILTER_SANITIZE_STRING,
  ],
  "uri" => $config["basePath"]
]);

// on récupère la barre d'adresse dans une variable $uri sous la transforme d'un tableau 
$uri = $secure->uri;

// on va filtrer en fonction des différents cas
switch ($uri[0]) {
  case 'admin':
    require_once "controller/back.php";
    $page = new Back(array_slice($uri, 1));
    break;
  default:     // tous les autres cas
    require_once "controller/front.php";
    $page = new Front($uri);
    break;
}

echo $page->html;