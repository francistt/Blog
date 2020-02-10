<?php

class Page{
  public    $ack = [
    "msg"   => "",
    "class" => null
  ];
  public    $html;
  public    $title;
  protected $uri;

  // public function __construct(){
  // }

  /**
   * define which function should be launched
   * @param  array  $uri           the uri splited in array
   * @param  srting $defaultAction the function that should be lanched if the uri doesn't respect the conditions
   * @param  object $target        the class where the functions souhld be
   * @return string                the function to fire
   */
  protected function defineTodo($uri, $defaultAction, $target){
    $this->uri = $uri;
    if (empty($uri)) $uri[0] = $defaultAction;
    $todo = $uri[0];                                            // on garde le premier segment pour savoir quelle fonction appeler
    if ($todo === "") $todo = $defaultAction;                   // si le segment est la racine on affiche la page d'accueil
    if ($todo === "login") $todo = $defaultAction;                   // si le segment est login on affiche la page d'accueil
    if (strrpos($todo, "-")) $todo = $this->convertToCamelCase($todo);
    if (!method_exists($target, $todo)) $todo = $defaultAction; // si la fonction n'existe pas on affiche la page d'accueil
    return $todo;
  }

  /**
   * convert a string
   * @param  string $segment
   * @return string         
   */
  private function convertToCamelCase($segment){
    $segment = explode("-", $segment);
    for ($i=1; $i < count($segment); $i++) { 
      $segment[$i] = ucfirst ( $segment[$i] );
    }
    return implode("", $segment);
  }
}