<?php


class Security{
	public $cookies = null;
	public $get     = null;
	public $post    = null;
	public $session = null;
	public $uri     = null;
	
	public function __construct($args){
		if (isset($args["cookies"])) $this->cookies = filter_input_array(INPUT_COOKIE,$args["cookies"]);
		if (isset($args["post"]))    $this->post    = filter_input_array(INPUT_POST,$args["post"]);
		if (isset($args["get"]))     $this->get     = filter_input_array(INPUT_GET,$args["get"]);
		if (isset($args["uri"]))     $this->uri     = $this->safeUri($args["uri"]);
	}

	public function safeUri($extraPath){
		$this->uri = strtolower(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW));
		if ($extraPath !== ""){
			$extraPath .= "/";
			$this->uri = explode($extraPath, $this->uri);
			$this->uri = implode("", $this->uri);
		}
		$this->uri = explode ( "/", $this->uri);
		return array_slice($this->uri, 1);
	}

	public function crypt($password){
		return hash ( "sha256" , $password );
	}
}