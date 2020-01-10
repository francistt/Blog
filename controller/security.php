<?php


class Security{
	public $cookies = null;
	public $get     = null;
	public $post    = null;
	public $session = null;
	
	public function __construct($args){
		if (isset($args["cookies"])) $this->cookies = filter_input_array(INPUT_COOKIE,$args["cookies"]);
		if (isset($args["post"]))    $this->post    = filter_input_array(INPUT_POST,$args["post"]);
		if (isset($args["get"]))     $this->get     = filter_input_array(INPUT_GET,$args["get"]);
	}

	public function safeUri(){
		$uri = explode ( "/", strtolower(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW)));
		return array_slice($uri, 1);
	}

	public function cryptedPassword(){
		return hash ( "sha256" , $this->post["password"] );
	}
}