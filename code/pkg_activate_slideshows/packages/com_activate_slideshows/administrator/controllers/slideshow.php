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

jimport('joomla.application.component.controllerform');

/**
 * Slideshow controller class.
 */
class Activate_slideshowsControllerSlideshow extends JControllerForm
{

    function __construct() {
        $this->view_list = 'slideshows';
        parent::__construct();
    }

}