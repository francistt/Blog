<?php

class Security
{
	public $post    = null;
	public $uri     = null;
	//public $cookies = null;
	//public $get     = null;
	
	/** 
	 * crypt a string 
	 * @constructor  
	 * @param  Array  $args  needed data for build a security's iteration 
	 * @param  Array  [$args->post] rules for filter input post 
	 */ 
	public function __construct($args){
		if (isset($args["post"]))    $this->post    = filter_input_array(INPUT_POST,$args["post"]);
		if (isset($args["uri"]))     $this->uri     = $this->securizeUri($args["uri"]);
		//if (isset($args["cookies"])) $this->cookies = filter_input_array(INPUT_COOKIE,$args["cookies"]);
		//if (isset($args["get"]))     $this->get     = filter_input_array(INPUT_GET,$args["get"]);
	}

	/**
	 * crypt a string
	 * @param  string|number $str [description]
	 * @return string             a crypted string
	 */
	public function crypt($str){
		return hash ( "sha256" , $str );
	}

	/**
	 * securize and explode requested uri 
	 * @param  string   $extraPath   the path of the project (if it is in a subfolder)
	 * @return array                 the uri splited in an array
	 */
	private function securizeUri($extraPath){
		$this->uri = strtolower(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW));
		if ($extraPath !== ""){
			$this->uri = explode($extraPath, $this->uri);
			$this->uri = implode("", $this->uri);
		}
		$this->uri = explode ( "/", $this->uri);
		return array_slice($this->uri, 1);
	}
}