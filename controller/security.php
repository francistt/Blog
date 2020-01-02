<?php

require_once "controller/encryptedSessionHandler.php";

class Security{
	public $cookies = null;
	public $get     = null;
	public $post    = null;
	public $session = null;
	
	public function __construct($args){
		if (isset($args["cookies"])) $this->cookies = filter_input_array(INPUT_COOKIE,$args["cookies"]);
		if (isset($args["post"]))    $this->post    = filter_input_array(INPUT_POST,$args["post"]);
		if (isset($args["get"]))     $this->get     = filter_input_array(INPUT_GET,$args["get"]);
		if (isset($args["session"])) $this->session = $this->createSession($args["session"]);
	}

	public function safeUri(){
		$uri = explode ( "/", strtolower(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW)));
		return array_slice($uri, 1);
	}

	public function cryptedPassword(){
		return hash ( "sha256" , $this->post["password"] );
	}


	/**
	  * Déchiffrement AES 256
	  *
	  * @param data $edata
	  * @param string $password
	  * @return decrypted data
	  */
	private function decrypt($edata, $password) {
	    $data = base64_decode($edata);
	    $salt = substr($data, 0, 16);
	    $ct = substr($data, 16);

	    $rounds = 3; // depends on key length
	    $data00 = $password.$salt;
	    $hash = array();
	    $hash[0] = hash('sha256', $data00, true);
	    $result = $hash[0];
	    for ($i = 1; $i < $rounds; $i++) {
	        $hash[$i] = hash('sha256', $hash[$i - 1].$data00, true);
	        $result .= $hash[$i];
	    }
	    $key = substr($result, 0, 32);
	    $iv  = substr($result, 32,16);

	    return openssl_decrypt($ct, 'AES-256-CBC', $key, true, $iv);
	  }

	/**
	 * Chiffrement AES 256
	 *
	 * @param data $data
	 * @param string $password
	 * @return base64 encrypted data
	 */
	private function encrypt($data, $password) {
	    // Set a random salt
	    $salt = openssl_random_pseudo_bytes(16);

	    $salted = '';
	    $dx = '';
	    // Salt the key(32) and iv(16) = 48
	    while (strlen($salted) < 48) {
	      $dx = hash('sha256', $dx.$password.$salt, true);
	      $salted .= $dx;
	    }

	    $key = substr($salted, 0, 32);
	    $iv  = substr($salted, 32,16);

	    $encrypted_data = openssl_encrypt($data, 'AES-256-CBC', $key, true, $iv);
	    return base64_encode($salt . $encrypted_data);
	}

	private function createSession($key)


	// Nous interceptons le gestionnaire 'files' natif, mais ceci
	// fonctionnera de la même façon avec les autres gestionnaires internes
	// comme 'sqlite', 'memcache' ou 'memcached'
	// qui sont fournis via des extensions PHP.
	ini_set('session.save_handler', 'files');
	$handler = new EncryptedSessionHandler($key);
	session_set_save_handler($handler, true);
	session_start();
	return $handler;
	}
}