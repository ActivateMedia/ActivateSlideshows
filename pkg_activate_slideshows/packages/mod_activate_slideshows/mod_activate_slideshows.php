<?php 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
require_once( dirname(__FILE__).'/helper.php' );
 
$module_name = "mod_activate_slideshows"; // make auto __FILE__
$media_folder = "media/".$module_name; 

$document = JFactory::getDocument();

if(isset($attribs["slideshow_ids"]))
{
	$slideshow_ids		   =  isset($attribs["slideshow_ids"])?$attribs["slideshow_ids"]:'';
	$slide    		  	   =  isset($attribs["slide"])?$attribs["slide"]:'slide';
	$autostart    		   =  isset($attribs["autostart"])?$attribs["autostart"]:'1';
	$interval      		   =  isset($attribs["interval"])?$attribs["interval"]:'2000';
	if(!$autostart) $interval = 'false';
	$layout        		   =  isset($attribs["layout"])?$attribs["layout"]:'default';
	$wrap         		   =  isset($attribs["wrap"])?$attribs["wrap"]:'1';
	$pause         		   =  isset($attribs["pause"])?$attribs["pause"]:'';
	$caption      		   =  isset($attribs["caption"])?$attribs["caption"]:'1';
	$arrows_navigation	   =  isset($attribs["arrows_navigation"])?$attribs["arrows_navigation"]:'1';
	$dots_navigation       =  isset($attribs["dots_navigation"])?$attribs["dots_navigation"]:'1';
	$jquery        		   =  isset($attribs["jquery"])?$attribs["jquery"]:'1';
	$bootstrap_carousel_id =  isset($attribs["bootstrap_carousel_id"])?$attribs["bootstrap_carousel_id"]:'myCarousel';
	$bootstrap_carousel_thumbs_per_row =  isset($attribs["bootstrap_carousel_thumbs_per_row"])?$attribs["bootstrap_carousel_thumbs_per_row"]:'8';
	$bootstrap_carousel_rows_of_thumbs =  isset($attribs["bootstrap_carousel_rows_of_thumbs"])?$attribs["bootstrap_carousel_rows_of_thumbs"]:'2';
}
else
{	
	$slideshow_ids         = $params->get("slideshow_ids", "");
	$slide 	           	   = $params->get("slide", "slide");
	$autostart 	           = $params->get("autostart", true);
	$interval              = $params->get("interval", "5000");
	if(!$autostart) $interval = 'false';
	$layout                = $params->get("layout", "default");
	$wrap                  = $params->get("wrap", "1");
	$pause                 = $params->get("pause", "");
	$arrows_navigation     = $params->get("arrows_navigation", "1");
	$dots_navigation       = $params->get("dots_navigation", "1");
	$caption               = $params->get("caption", "1");
	$jquery                = $params->get("jquery", "1");
	$bootstrap_carousel_id = $params->get("bootstrap_carousel_id", "myCarousel");
	$bootstrap_carousel_thumbs_per_row = $params->get("bootstrap_carousel_thumbs_per_row", "8");
	$bootstrap_carousel_rows_of_thumbs = $params->get("bootstrap_carousel_rows_of_thumbs", "2");
	
	//echo "Interval = ".$interval;
	//echo "slideshow_ids = ".print_r($slideshow_ids,1);
}

// If requires, I include jQuery
if($jquery)
{
	$document->addStyleSheet("//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js");
}

// CSS and JavaScript import depending on the selected layout
if(!empty($layout))
{
	$pureLayout = explode(":", $layout);
	if(count($pureLayout) > 1)
		$pureLayout = $pureLayout[1];
	else $pureLayout = $pureLayout[0];
}
else
{
	$pureLayout = '';
}

/*if($pureLayout == "default")
{
	$document->addStyleSheet(JURI::base().$media_folder."/css/activate.bootstrap.carousel.css");
	//$document->addScript(JURI::base().$media_folder."/js/activate.bootstrap.carousel.js");
}*/
$document->addStyleSheet(JURI::base().$media_folder."/css/activate.bootstrap.carousel.css");

if($pureLayout == "slideshows-gallery")
{
	$items = modActivateSlideshowsHelper::getSlideshows($slideshow_ids);
}
else	
{		
	$items = modActivateSlideshowsHelper::getItems($slideshow_ids);
}

require ( JModuleHelper::getLayoutPath ( $module_name, $layout ) );