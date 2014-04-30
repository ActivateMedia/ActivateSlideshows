jQuery( document ).ready(function($) {
// -- start bootstrap-carousel-with-thumbs-navigation layout --
$('#'+bootstrap_carousel_id).carousel({
    interval: 4000
});

var previousSlideID = 0;

// handles the carousel thumbnails
$('[id^=carousel-selector-]').click( function(){
  var id_selector = $(this).attr("id");
//  console.log("id_selector = " + id_selector);
  //var id = id_selector.substr(id_selector.length -1);
  var id = id_selector.substr(id_selector.length -reverse(id_selector).search("-"));
  id = parseInt(id);
  $('#'+bootstrap_carousel_id).carousel(id);
  $('[id^=carousel-selector-]').removeClass('selected');
  $(this).addClass('selected');
});

$('#'+bootstrap_carousel_id).on('slid.bs.carousel', function () {   doThisOnSlide(); })

// when the carousel slides, auto update
$('#'+bootstrap_carousel_id).on('slid', function (e) {
  doThisOnSlide();
});
	function reverse(s){
		return s.split("").reverse().join("");
	}
	
	function doThisOnSlide() {
	var id = $('.item.active').data('slide-number');
  id = parseInt(id);
  $('[id^=carousel-selector-]').removeClass('selected');
  $('[id^=carousel-selector-'+id+']').addClass('selected');
  
  /*console.log("Siamo alla slide numero: " + id);
  console.log("Slide precedente con id: " + previousSlideID);
  console.log("carousel_thumbs_per_row: " + bootstrap_carousel_thumbs_per_row);
  console.log("______________________________________");*/
  if(id % bootstrap_carousel_thumbs_per_row == 0 && id != 0)
  {
	console.log("entro qui ---->");
	if(id>previousSlideID) $('#'+bootstrap_carousel_id+"Nav").carousel('next');
	//else $('#'+bootstrap_carousel_id+"Nav").carousel('prev');
  }
  else if(id == 0 && previousSlideID == items_number-1)
  {
	$('#'+bootstrap_carousel_id+"Nav").carousel('next');
  }
  else if(id == items_number-1 && previousSlideID == 0)
  {
	$('#'+bootstrap_carousel_id+"Nav").carousel('prev');
  }
  else if(previousSlideID % bootstrap_carousel_thumbs_per_row == 0 && previousSlideID != 0)
  {
	if(id<previousSlideID)
		$('#'+bootstrap_carousel_id+"Nav").carousel('prev');
  }
  previousSlideID = id;
	}
	// -- end bootstrap-carousel-with-thumbs-navigation layout --
});