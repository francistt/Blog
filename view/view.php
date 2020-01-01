<?php

/**
 * 
 */
class View
{

	public $html = "";
	protected $base;
	
	function __construct($data, $template)

	{
		global $config;
		$this->base = $_SERVER["SERVER_NAME"]."/".$config["basePath"]."/";
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
		return str_replace(
			array_keys($simpleData),
			$simpleData,
			file_get_contents("template/$template.html"));

	}
}


// "j'ai une belle maison"
// "j'ai une belle voiture"



// [
// 	"{{ content }}" => "ljkljklj",
// 	"{{ date }}"    => "12/05/1986",
// 	"{{ title }}"   => "kljkljkljkl"
// ]


// [
// 	[
// 		"{{ content }}" => "ljkljklj",
// 		"{{ date }}"    => "12/05/1986",
// 		"{{ title }}"   => "kljkljkljkl"
// 	],
// 	[
// 		"{{ content }}" => "ljkljklj",
// 		"{{ date }}"    => "12/05/1986",
// 		"{{ title }}"   => "kljkljkljkl"
// 	],
// 	[
// 		"{{ content }}" => "ljkljklj",
// 		"{{ date }}"    => "12/05/1986",
// 		"{{ title }}"   => "kljkljkljkl"
// 	],
// ]