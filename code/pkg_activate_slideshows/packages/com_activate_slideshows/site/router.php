<?php
/**
 * @version     1.0.0
 * @package     com_activate_slideshows
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Activate Media <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */

// No direct access
defined('_JEXEC') or die;

/**
 * @param	array	A named array
 * @return	array
 */
function Activate_slideshowsBuildRoute(&$query)
{
//print_r($query);

	$segments = array();
    
	if (isset($query['task'])) {
		$segments[] = implode('/',explode('.',$query['task']));
		unset($query['task']);
	}	
	if (isset($query['id'])) {
		$segments[] = $query['id'];
		unset($query['id']);
	}
	if (isset($query['slug'])) {
		$segments[] = $query['slug'];
		unset($query['slug']);
	}	
	return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 *
 * index.php?/activate_slideshows/task/id/Itemid
 *
 * index.php?/activate_slideshows/id/Itemid
 */
function Activate_slideshowsParseRoute($segments)
{
	$vars = array();
   
	// view is always the first element of the array
	$count = count($segments);

	if ($count)
	{
		$vars['id'] = $segments[0];
		$vars['slug'] = $segments[1];
		$vars["view"] = 'slideshow';
	}
	return $vars;
}
