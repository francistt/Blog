<?php

class SessionManager{
  private $data;
  public function __construct(){
    session_start();
    $this->data = (!empty($_SESSION)) ? $_SESSION : null;
    if ($this->data !== null) $this->updateValidity(true);
  }

  /**
   * give one or all data in the session
   * @param  [string] $name   optional : the value needed
   * @return *                return an associative array if several values, the needed value if only one asked, null if no answer
   */
  public function get($name = null){
    if ($name === null ) return $this->data;
    return ($this->data[$name]) ? $this->data[$name] : null;
  }

  /**
   * define / update  one or several values at once
   * @param array|string $newData   
   * @param [mixed]      $value     optional : the new value only when $newData is a string
   */
  public function set( $newData, $value=null ){
    if (gettype($newData) === "array") return $this->setSeveral($newData);
    $this->setOne($newData, $value);
  }

  /**
   * define / update a value of the session 
   * @param [type] $newData [description]
   * @param [type] $value   [description]
   */
  private function setOne($newData, $value){
    $this->data[$newData] = $value;
    $_SESSION[$newData] = $value;    
  }

  /**
   * define / update several value of the session 
   * @param [type] $array [description]
   */
  private function setSeveral( $array ){
    foreach ($array as $key => $value) {
      $this->setOne($key, $value);
    }
  }

  /**
   * says if session has data or not
   * @return boolean 
   */
  public function hasData(){
    if ( $this->data === null) return false;
    return true;
  }

  /**
   * update duration and optionaly check if the session has timed out
   * @param  [boolean]  $check  if we need to check if the session is still valide
   * @return void
   */
  public function updateValidity($check = false){
    global $config;
    $now = filter_input ( INPUT_SERVER , 'REQUEST_TIME', FILTER_SANITIZE_NUMBER_INT );
    if ($check) {
      if (isset($this->data['lastActivity']) && 
         ($now - $this->data['lastActivity']) > $config['sessionDuration']) {
          session_unset();
          session_destroy();
          session_start();
      }
    }
    $this->setOne('lastActivity', $now);
  }
}