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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_activate_slideshows')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Activate_slideshows');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
