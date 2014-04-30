jQuery( document ).ready(function($) {
// -- start more-slideshowos layout --
var numnberOfVisibleSlideshows = 0;
var slideshows;
initSlideshows();
showSomeSlideshows(6);
$("#load_more_slideshows").click(function() {
	showSomeSlideshows(6);
});
function initSlideshows() {
	slideshows = jQuery.parseJSON(jsonSlideshows);
	
	slideshows = slideshows.data;

	if(slideshows.length)
	{
		$("#slideshows-container").addClass("col-lg-12");	
	}
}
function showSomeSlideshows(count) {
	var limit = count+numnberOfVisibleSlideshows;
	if(limit > slideshows.length)
	{
		limit = slideshows.length;
		$('#load_more_slideshows').fadeOut();
	}
	var rowChild = '<div class="row" id="row-group-'+ limit +'"></div>';
	$("#slideshows-container").append(rowChild);
	var bootstrapColumnSize = Math.ceil(12/count);
	for(indexSlideshows = numnberOfVisibleSlideshows; indexSlideshows < limit; indexSlideshows++)
	{
		if(typeof slideshows[indexSlideshows].title !== "undefined") {
		var slideshow_title = slideshows[indexSlideshows].title;
		var slideshow_link = slideshows[indexSlideshows].slideshow_link;		
		var filepath;
		if(typeof slideshows[indexSlideshows].images[0] !== "undefined")
			filepath = slideshows[indexSlideshows].images["0"].filepath;			
		else
			filepath = "/media/mod_activate_slideshows/images/empty.png";

		var lastGenID = "activate-slideshow-" + indexSlideshows;	
	  	var slideshow = slideshows[indexSlideshows];
	  	//var randNum = Math.floor((Math.random()*600)+300);;					   
		var child = "";
		child  += '<a href="'+  slideshow_link +'" title="'+  slideshow_title +'">';
		child  += '<div class="col-lg-'+bootstrapColumnSize+'" style="display:none" id="'+lastGenID+'">';
		if(filepath !== '') child += '<div class="slideshow-thumb-coverbg" style="background-image:url('+filepath+')"></div>';		
		//if(filepath !== '') child += '<img src="' + filepath + '" class="img-responsive">';
		child += '<span class="slideshow-thumb-title">' + slideshow_title + '</span>';
		child += '</div></a>';
		$("#row-group-"+ limit).append(child);
		$("#"+lastGenID).fadeIn(300);
		lastGenID = "activate-slideshow-" + indexSlideshows;
		}	
	  numnberOfVisibleSlideshows++;
	}
}
// -- end more-slideshowos layout --
});