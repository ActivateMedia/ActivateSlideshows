<?php

/**
 * @version     1.0.0
 * @package     com_activate_slideshows
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Activate Media <andrea@activatemedia.co.uk> - http://activatemedia.co.uk
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Activate_slideshows records.
 */
class Activate_slideshowsModelSlideshows extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'title', 'a.title',
                'description', 'a.description',
                'creation', 'a.creation',
                'exluded', 'a.exluded',
                'tags', 'a.tags',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering creation
		$this->setState('filter.creation.from', $app->getUserStateFromRequest($this->context.'.filter.creation.from', 'filter_from_creation', '', 'string'));
		$this->setState('filter.creation.to', $app->getUserStateFromRequest($this->context.'.filter.creation.to', 'filter_to_creation', '', 'string'));

		//Filtering exluded
		$this->setState('filter.exluded', $app->getUserStateFromRequest($this->context.'.filter.exluded', 'filter_exluded', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_activate_slideshows');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.state', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );
        $query->from('`#__activate_slideshows_slideshows` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.state LIKE '.$search.'  OR  a.title LIKE '.$search.'  OR  a.creation LIKE '.$search.'  OR  a.tags LIKE '.$search.' )');
            }
        }

        

		//Filtering creation
		$filter_creation_from = $this->state->get("filter.creation.from");
		if ($filter_creation_from) {
			$query->where("a.creation >= '".$db->escape($filter_creation_from)."'");
		}
		$filter_creation_to = $this->state->get("filter.creation.to");
		if ($filter_creation_to) {
			$query->where("a.creation <= '".$db->escape($filter_creation_to)."'");
		}

		//Filtering exluded
		$filter_exluded = $this->state->get("filter.exluded");
		if ($filter_exluded) {
			$query->where("a.exluded = '".$db->escape($filter_exluded)."'");
		}


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
		foreach ($items as $oneItem) {

			if ( isset($oneItem->tags) ) {
				// Catch the item tags (string with ',' coma glue)
				$tags = explode(",",$oneItem->tags);

				$db = JFactory::getDbo();
					$namedTags = array(); // Cleaning and initalization of named tags array

					// Get the tag names of each tag id
					foreach ($tags as $tag) {

						$query = $db->getQuery(true);
						$query->select("title");
						$query->from('`#__tags`');
						$query->where( "id=" . intval($tag) );

						$db->setQuery($query);
						$row = $db->loadObjectList();

						// Read the row and get the tag name (title)
						if (!is_null($row)) {
							foreach ($row as $value) {
								if ( $value && isset($value->title) ) {
									$namedTags[] = trim($value->title);
								}
							}
						}

					}

					// Finally replace the data object with proper information
					$oneItem->tags = !empty($namedTags) ? implode(', ',$namedTags) : $oneItem->tags;
				}
		}
        return $items;
    }

}
