<?php
	include("libs/PHPCrawler.class.php");

	class MyCrawler extends PHPCrawler {
	  	function handleDocumentInfo($DocInfo) {
			echo "<a href='{$DocInfo->url}'>{$DocInfo->url}</a>".(PHP_SAPI == "cli"? "\n":"<br />");
			flush();
	  	} 
	}

	function setRules($crawler,$url){
		if(strpos($url, "vendobara")!==false){
			$crawler->addURLFollowRule("#^.*gratis/detalle.*$# i");
			$crawler->addURLFilterRule("#(=false|=true|SSL|\()$# i");		
		}
	}

	if(isset($_GET["url"])){
		$url=$_GET["url"];
		$crawler = new MyCrawler();
		$crawler->setURL($url);
		$crawler->enableCookieHandling(true);
		setRules($crawler,$url);
		$crawler->go();
		$report = $crawler->getProcessReport();
	}
?>