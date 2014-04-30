<?php
/**
 * @version     1.0.0
 * @package     com_activate_slideshows
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Activate Media <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
// no direct access
defined('_JEXEC') or die;
?>

<div class="latest-slideshow">
<?php
$attribs["slideshow_ids"] = array($this->item->id);
$attribs["layout"] = 'bootstrap-carousel-with-thumbs-navigation';
$attribs["bootstrap_carousel_thumbs_per_row"] = '6';
$attribs["jquery"] = '0';
$module = JModuleHelper::getModule( 'mod_activate_slideshows', 'Slideshow' );
if($module) // Checks if the module exists
{
    echo JModuleHelper::renderModule( $module, $attribs );
}
?>
</div>

<div class="more-slideshows">
<?php
$attribs["layout"] = 'more-slideshows';
$attribs["jquery"] = '0';
$module = JModuleHelper::getModule( 'mod_activate_slideshows', 'Slideshow' );
if($module) // Checks if the module exists
{
    echo JModuleHelper::renderModule( $module, $attribs );
}
?>
</div>

