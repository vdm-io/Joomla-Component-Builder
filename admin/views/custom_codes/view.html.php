<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		@update number 86 of this MVC
	@build			27th October, 2017
	@created		11th October, 2016
	@package		Component Builder
	@subpackage		view.html.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Componentbuilder View class for the Custom_codes
 */
class ComponentbuilderViewCustom_codes extends JViewLegacy
{
	/**
	 * Custom_codes view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('custom_codes');
		}

		// Assign data to the view
		$this->items 		= $this->get('Items');
		$this->pagination 	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->user 		= JFactory::getUser();
		$this->listOrder	= $this->escape($this->state->get('list.ordering'));
		$this->listDirn		= $this->escape($this->state->get('list.direction'));
		$this->saveOrder	= $this->listOrder == 'ordering';
                // get global action permissions
		$this->canDo		= ComponentbuilderHelper::getActions('custom_code');
		$this->canEdit		= $this->canDo->get('custom_code.edit');
		$this->canState		= $this->canDo->get('custom_code.edit.state');
		$this->canCreate	= $this->canDo->get('custom_code.create');
		$this->canDelete	= $this->canDo->get('custom_code.delete');
		$this->canBatch	= $this->canDo->get('core.batch');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
                        // load the batch html
                        if ($this->canCreate && $this->canEdit && $this->canState)
                        {
                                $this->batchDisplay = JHtmlBatch_::render();
                        }
		}
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_CUSTOM_CODES'), 'shuffle');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=custom_codes');
                JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
                {
			JToolBarHelper::addNew('custom_code.add');
		}

                // Only load if there are items
                if (ComponentbuilderHelper::checkArray($this->items))
		{
                        if ($this->canEdit)
                        {
                            JToolBarHelper::editList('custom_code.edit');
                        }

                        if ($this->canState)
                        {
                            JToolBarHelper::publishList('custom_codes.publish');
                            JToolBarHelper::unpublishList('custom_codes.unpublish');
                            JToolBarHelper::archiveList('custom_codes.archive');

                            if ($this->canDo->get('core.admin'))
                            {
                                JToolBarHelper::checkin('custom_codes.checkin');
                            }
                        }

                        // Add a batch button
                        if ($this->canBatch && $this->canCreate && $this->canEdit && $this->canState)
                        {
                                // Get the toolbar object instance
                                $bar = JToolBar::getInstance('toolbar');
                                // set the batch button name
                                $title = JText::_('JTOOLBAR_BATCH');
                                // Instantiate a new JLayoutFile instance and render the batch button
                                $layout = new JLayoutFile('joomla.toolbar.batch');
                                // add the button to the page
                                $dhtml = $layout->render(array('title' => $title));
                                $bar->appendButton('Custom', $dhtml, 'batch');
                        } 

                        if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
                        {
                            JToolbarHelper::deleteList('', 'custom_codes.delete', 'JTOOLBAR_EMPTY_TRASH');
                        }
                        elseif ($this->canState && $this->canDelete)
                        {
                                JToolbarHelper::trash('custom_codes.trash');
                        }

			if ($this->canDo->get('core.export') && $this->canDo->get('custom_code.export'))
			{
				JToolBarHelper::custom('custom_codes.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
                } 

		if ($this->canDo->get('core.import') && $this->canDo->get('custom_code.import'))
		{
			JToolBarHelper::custom('custom_codes.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

                // set help url for this view if found
                $help_url = ComponentbuilderHelper::getHelpUrl('custom_codes');
                if (ComponentbuilderHelper::checkString($help_url))
                {
                        JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
                }

                // add the options comp button
                if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
                {
                        JToolBarHelper::preferences('com_componentbuilder');
                }

                if ($this->canState)
                {
			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);
                        // only load if batch allowed
                        if ($this->canBatch)
                        {
                            JHtmlBatch_::addListSelection(
                                JText::_('COM_COMPONENTBUILDER_KEEP_ORIGINAL_STATE'),
                                'batch[published]',
                                JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
                            );
                        }
		}

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'),
			'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);

		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
                                JText::_('COM_COMPONENTBUILDER_KEEP_ORIGINAL_ACCESS'),
                                'batch[access]',
                                JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
                }  

		// Set Component System Name Selection
		$this->componentSystem_nameOptions = JFormHelper::loadFieldType('Component')->getOptions();
		if ($this->componentSystem_nameOptions)
		{
			// Component System Name Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMPONENT_LABEL').' -',
				'filter_component',
				JHtml::_('select.options', $this->componentSystem_nameOptions, 'value', 'text', $this->state->get('filter.component'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Component System Name Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMPONENT_LABEL').' -',
					'batch[component]',
					JHtml::_('select.options', $this->componentSystem_nameOptions, 'value', 'text')
				);
			}
		}

		// Set Target Selection
		$this->targetOptions = $this->getTheTargetSelections();
		if ($this->targetOptions)
		{
			// Target Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TARGET_LABEL').' -',
				'filter_target',
				JHtml::_('select.options', $this->targetOptions, 'value', 'text', $this->state->get('filter.target'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Target Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TARGET_LABEL').' -',
					'batch[target]',
					JHtml::_('select.options', $this->targetOptions, 'value', 'text')
				);
			}
		}

		// Set Type Selection
		$this->typeOptions = $this->getTheTypeSelections();
		if ($this->typeOptions)
		{
			// Type Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TYPE_LABEL').' -',
				'filter_type',
				JHtml::_('select.options', $this->typeOptions, 'value', 'text', $this->state->get('filter.type'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Type Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TYPE_LABEL').' -',
					'batch[type]',
					JHtml::_('select.options', $this->typeOptions, 'value', 'text')
				);
			}
		}

		// Set Comment Type Selection
		$this->comment_typeOptions = $this->getTheComment_typeSelections();
		if ($this->comment_typeOptions)
		{
			// Comment Type Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMMENT_TYPE_LABEL').' -',
				'filter_comment_type',
				JHtml::_('select.options', $this->comment_typeOptions, 'value', 'text', $this->state->get('filter.comment_type'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Comment Type Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMMENT_TYPE_LABEL').' -',
					'batch[comment_type]',
					JHtml::_('select.options', $this->comment_typeOptions, 'value', 'text')
				);
			}
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_COMPONENTBUILDER_CUSTOM_CODES'));
		$document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/custom_codes.css");
	}

        /**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 50)
		{
                        // use the helper htmlEscape method instead and shorten the string
			return ComponentbuilderHelper::htmlEscape($var, $this->_charset, true);
		}
                // use the helper htmlEscape method instead.
		return ComponentbuilderHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
			'a.sorting' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'g.system_name' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMPONENT_LABEL'),
			'a.path' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PATH_LABEL'),
			'a.target' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TARGET_LABEL'),
			'a.type' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TYPE_LABEL'),
			'a.comment_type' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMMENT_TYPE_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	} 

	protected function getTheTargetSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('target'));
		$query->from($db->quoteName('#__componentbuilder_custom_code'));
		$query->order($db->quoteName('target') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $target)
			{
				// Translate the target selection
				$text = $model->selectionTranslation($target,'target');
				// Now add the target and its text to the options array
				$_filter[] = JHtml::_('select.option', $target, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheTypeSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('type'));
		$query->from($db->quoteName('#__componentbuilder_custom_code'));
		$query->order($db->quoteName('type') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $type)
			{
				// Translate the type selection
				$text = $model->selectionTranslation($type,'type');
				// Now add the type and its text to the options array
				$_filter[] = JHtml::_('select.option', $type, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheComment_typeSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('comment_type'));
		$query->from($db->quoteName('#__componentbuilder_custom_code'));
		$query->order($db->quoteName('comment_type') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $comment_type)
			{
				// Translate the comment_type selection
				$text = $model->selectionTranslation($comment_type,'comment_type');
				// Now add the comment_type and its text to the options array
				$_filter[] = JHtml::_('select.option', $comment_type, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}
}
