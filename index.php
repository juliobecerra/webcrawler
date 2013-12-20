<?php
	include("libs/PHPCrawler.class.php");

	class MyCrawler extends PHPCrawler {
		//Override the handleDocumentInfo function. Echo whatever you want for each url followed
	  	function handleDocumentInfo($DocInfo) {
	  		//Echo the url as link
			echo "<a href='{$DocInfo->url}'>{$DocInfo->url}</a>".(PHP_SAPI == "cli"? "\n":"<br />");
			flush();
	  	} 
	}
	//Define specific rules for each site. In this case we'll be sending URL's from different domains.
	function setRules($crawler,$url){
		//Vendobara
		if(strpos($url, "vendobara")!==false){
			$crawler->addURLFollowRule("#^.*gratis/detalle.*$# i");
			$crawler->addURLFilterRule("#(=false|=true|SSL|\()$# i");		
		}
		//sevendeporquesevende
		else if(strpos($url, "sevendeporquesevende")!==false){
			$crawler->addURLFollowRule("#^.*detalles_anuncio.*$# i");
			$crawler->addURLFilterRule("#(jpg)$# i");		
		}
	}
	//If any URL is sent as parameter
	if(isset($_GET["url"])){
		$url=$_GET["url"];
		//Init class
		$crawler = new MyCrawler();
		$crawler->setURL($url);
		$crawler->enableCookieHandling(true);
		//Check for the rules for each specific site
		setRules($crawler,$url);
		//Start crawling
		$crawler->go();
	}
?>