<?php

/**
 * 
 */
class View
{

	public $html = "";
	protected $base;
	
	public function __construct($data, $template)

	{
		global $config;
		$this->base = $config["basePath"];
		if ($data === null) return;

		//définir si data est un objet ou un tableau normal
		if (isset($data[0])) $this->html = $this->makeHtmlLoop($data, $template);
		// si tableau faire une boucle de chaque entrée qui appelera makeHTML
		else		
	 	//si objet ligne 19
			$this->html = $this->makeHTML($data, $template);
		
	}
	protected function makeHtmlLoop($data, $template){
		$string = "";
		foreach ($data as $key => $value) {
			$string .= $this->makeHTML($value, $template);
		}
		return $string;
	}

	private function makeHTML($simpleData, $template){
		$simpleData["{{ base }}"] = $this->base;
		if ( isset ($simpleData["ack"])) {
			$simpleData["{{ ack }}"] = $this->generateAck($simpleData["ack"]);
			unset($simpleData["ack"]);
		}
		return str_replace(
			array_keys($simpleData),
			$simpleData,
			file_get_contents("template/$template.html")
		);
	}

	private function generateAck($ack){
		if ($ack["msg"] === "") return "";
		return '<ack class="'.$ack["class"].'" onclick="this.style.display = \'none\'">'.$ack['msg'].'</ack>';
	}
}
