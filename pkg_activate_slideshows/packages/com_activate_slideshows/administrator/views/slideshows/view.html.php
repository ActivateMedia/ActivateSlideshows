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

jimport('joomla.application.component.view');

/**
 * View class for a list of Activate_slideshows.
 */
class Activate_slideshowsViewSlideshows extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		Activate_slideshowsHelper::addSubmenu('slideshows');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/activate_slideshows.php';

		$state	= $this->get('State');
		$canDo	= Activate_slideshowsHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_ACTIVATE_SLIDESHOWS_TITLE_SLIDESHOWS'), 'slideshows.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/slideshow';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('slideshow.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('slideshow.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('slideshows.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('slideshows.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'slideshows.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('slideshows.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('slideshows.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'slideshows.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('slideshows.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_activate_slideshows');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_activate_slideshows&view=slideshows');
        
        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

			//Filter for the field creation
			$this->extra_sidebar .= '<small><label for="filter_from_creation">From Date</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.creation.from'), 'filter_from_creation', 'filter_from_creation', '%Y-%m-%d', 'style="width:142px;" onchange="this.form.submit();"');
			$this->extra_sidebar .= '<small><label for="filter_to_creation">To Date</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.creation.to'), 'filter_to_creation', 'filter_to_creation', '%Y-%m-%d', 'style="width:142px;" onchange="this.form.submit();"');
			$this->extra_sidebar .= '<hr class="hr-condensed">';

		//Filter for the field exluded
		$select_label = JText::sprintf('COM_ACTIVATE_SLIDESHOWS_FILTER_SELECT_LABEL', 'Exluded');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "Exclude this slideshow";
		$options[1] = new stdClass();
		$options[1]->value = "0";
		$options[1]->text = "Include this slideshow";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_exluded',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.exluded'), true)
		);

        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.title' => JText::_('COM_ACTIVATE_SLIDESHOWS_SLIDESHOWS_TITLE'),
		'a.creation' => JText::_('COM_ACTIVATE_SLIDESHOWS_SLIDESHOWS_CREATION'),
		'a.exluded' => JText::_('COM_ACTIVATE_SLIDESHOWS_SLIDESHOWS_EXLUDED'),
		'a.tags' => JText::_('COM_ACTIVATE_SLIDESHOWS_SLIDESHOWS_TAGS'),
		);
	}

    
}
