<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php
//$component_path = JPATH_BASE."/components/com_activate_slideshows/helpers/activate_slideshows.php";
//require_once $component_path;

//echo Activate_slideshowsHelper::getSlideshows($slideshow_ids);
$slideshows = modActivateSlideshowsHelper::getSlideshows();
echo "<script type='text/javascript'>var jsonSlideshows = '".addslashes(new JResponseJson($slideshows))."';</script>";
if(isset($_GET["dev"])) echo "<pre>".print_r($slideshows, true)."</pre>";

?>

<h3 id="more-slideshows-title">More slideshows</h3>
<button id="load_more_slideshows">Load More</button>

<div id="slideshows-container">

</div>

<script src="<?php echo Juri::base(); ?>media/<?php echo $module_name; ?>/js/activate.moreslideshows.js" type="text/javascript"></script>