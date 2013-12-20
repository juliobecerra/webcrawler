$(document).ready(function(){

	$("#search").keypress(function(e){
		if(e.which==13){
			$("#search-btn").click();			
		}
	});
	function searchSite(currentSite){
		$("#results").append(
			"<div id='"+sitesSearch[currentSite]+"' class='well not-shown'>"+
				"<h2>"+sitesSearch[currentSite]+"</h2>"+
				"<div class='progress progress-striped active' id='progress-bar'>"+
            		"<div class='progress-bar' style='width: 100%'></div>"+
          		"</div>"+				
				"<div class='results not-shown'>"+
            	"</div>"+
			"</div>");
		$("#"+sitesSearch[currentSite]).fadeIn();
		$.get( "webcrawler.php", { search: $("#search").val(),domain:sitesSearch[currentSite] } )
		.done(function( data ) {
			$("#"+sitesSearch[currentSite]+" #progress-bar").fadeOut();
			$("#"+sitesSearch[currentSite]+" .results").html(data).fadeIn();
			currentSite++;
			if(currentSite<=(sitesSearch.length-1))
				searchSite(currentSite);
		}).error(function(data){
			$("#"+sitesSearch[currentSite]+" #progress-bar").fadeOut();
			$("#"+sitesSearch[currentSite]+" .results").html("<div class='text-danger'>Error accesing "+sitesSearch[currentSite]+"</div>").fadeIn();
		});			
	}

	$("#search-btn").click(function(){
		$("#results").html("").show();
		searchSite(0);
	});
});