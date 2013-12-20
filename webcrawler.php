<?php
	set_time_limit(10000);
	include("libs/PHPCrawler.class.php");

	class MyCrawler extends PHPCrawler {
		//Override the handleDocumentInfo function. Echo whatever you want for each url followed
	  	function handleDocumentInfo($DocInfo) {
	  		//Echo the url as link
			echo "<a target='_blank' href='{$DocInfo->url}'>{$DocInfo->url}</a>".(PHP_SAPI == "cli"? "\n":"<br />");
			flush();
	  	} 
	}
	//Define specific rules for each site. In this case we'll be sending URL's from different domains.
	function setRules($domain,$search){
		switch($domain){
			case "vendobara":
				$rules["follow"]="#^.*gratis/detalle.*$# i";
				$rules["filter"]="#(=false|=true|SSL|\()$# i";
				$rules["url"]="www.vendobara.com/anuncios-gratis/resultados?clasificados=$search";
			break;
			case "sevendeporquesevende":
				$rules["follow"]="#^.*detalles_anuncio.*$# i";
				$rules["filter"]="#(jpg)$# i";
				$rules["url"]="www.sevendeporquesevende.com/buscar-anuncio.php?contenido=$search&cat=%25";
			break;			
		}
		return $rules;
	}

	//If any URL is sent as parameter
	if(isset($_GET["search"])&&isset($_GET["domain"])){
		//Check for the rules for each specific site
		$rules=setRules($_GET["domain"],$_GET["search"]);
		//Init class
		$crawler = new MyCrawler();
		//Set search URL
		$crawler->setURL($rules["url"]);
		//Set Rules
		$crawler->addURLFollowRule($rules["follow"]);
		$crawler->addURLFilterRule($rules["filter"]);	
		$crawler->enableCookieHandling(true);
		//Start crawling
		$crawler->go();
	}
?>