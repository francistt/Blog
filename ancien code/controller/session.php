<?php

class Session{

  private $data = [];
  private $sessionId;  
  private $uuid;  //length : 23

  public function __construct() {
    global $model;
    global $secure;

    // get safe session ID
    $this->data = $secure->cookies;

    switch ($this->data) {
      case null: //create new session ID
        $this->uuid = uniqid(date('yz').(date("H")*60+date("i"))*60+date("s"));
        $this->data = $model->getData([
          "type" => "insert",
          "req"  => [
            "set"  => [
              'uuid' => $this->uuid
            ],
            "table"  => "sessions"
          ]
        ]);
        if ($this->data["succeed"]){
          $this->sessionId = $this->data["data"];
          setcookie ( "PHPSESSID", $this->uuid);
        }
        else die("can't store new session : ".$this->data["data"]);
        break;
      
      default:
        $this->uuid = $this->data["PHPSESSID"];
        $this->data = $model->getData([
          "type" => "select",
          "req"  => [
            "need"  => [ 'data', 'id' ],
            "table" => "sessions",
            "limit" => 1,
            "where" => [ "`uuid` = '$this->uuid'" ]
          ]
        ]);
        if ($this->data["succeed"]){
          $this->data      = $this->data["data"][0]["data"];
          $this->sessionId = $this->data["data"][0]["id"];
        }
        else die("can't store new session : ".$this->data["data"]);
        break;
    }
  }

  public function add($key, $value){
    $this->update($key, $value);
  }

  public function get($key){
    return $this->data[$key];
  }

  public function remove($key){
    unset($this->data[$key]);
    $this->storeInDatabase();
  }

  public function update($key, $value){
    $this->data[$key] = $value;
    $this->storeInDatabase();
  }

  private function storeInDatabase(){
    global $agility;
    $result = $agility->model->update([
      "table" => "sessions",
      "data"  => [
        "data" => json_encode($this->data)
      ],
      "where" => ["`sessions`.`id`=$this->sessionId", "`sessions`.`uuid`='$this->uuid'"]
    ]);
    if (! $result["succeed"]) $agility->errorManager->log("can't update session in database : ".$this->data["data"]);
  }
}


/*

todo : tester comportement quand phpssid altéré

*/