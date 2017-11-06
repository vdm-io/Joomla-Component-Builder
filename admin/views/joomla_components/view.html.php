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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		view.html.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Componentbuilder View class for the Joomla_components
 */
class ComponentbuilderViewJoomla_components extends JViewLegacy
{
	/**
	 * Joomla_components view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('joomla_components');
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
		$this->canDo		= ComponentbuilderHelper::getActions('joomla_component');
		$this->canEdit		= $this->canDo->get('joomla_component.edit');
		$this->canState		= $this->canDo->get('joomla_component.edit.state');
		$this->canCreate	= $this->canDo->get('joomla_component.create');
		$this->canDelete	= $this->canDo->get('joomla_component.delete');
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
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS'), 'joomla');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=joomla_components');
                JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
                {
			JToolBarHelper::addNew('joomla_component.add');
		}

                // Only load if there are items
                if (ComponentbuilderHelper::checkArray($this->items))
		{
                        if ($this->canEdit)
                        {
                            JToolBarHelper::editList('joomla_component.edit');
                        }

                        if ($this->canState)
                        {
                            JToolBarHelper::publishList('joomla_components.publish');
                            JToolBarHelper::unpublishList('joomla_components.unpublish');
                            JToolBarHelper::archiveList('joomla_components.archive');

                            if ($this->canDo->get('core.admin'))
                            {
                                JToolBarHelper::checkin('joomla_components.checkin');
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
			if ($this->user->authorise('joomla_component.export_components', 'com_componentbuilder'))
			{
				// add Export Components button.
				JToolBarHelper::custom('joomla_components.smartExport', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_COMPONENTS', false);
			}
			if ($this->user->authorise('joomla_component.backup', 'com_componentbuilder'))
			{
				// add Backup button.
				JToolBarHelper::custom('joomla_components.backup', 'archive', '', 'COM_COMPONENTBUILDER_BACKUP', false);
			}

                        if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
                        {
                            JToolbarHelper::deleteList('', 'joomla_components.delete', 'JTOOLBAR_EMPTY_TRASH');
                        }
                        elseif ($this->canState && $this->canDelete)
                        {
                                JToolbarHelper::trash('joomla_components.trash');
                        }

			if ($this->canDo->get('core.export') && $this->canDo->get('joomla_component.export'))
			{
				JToolBarHelper::custom('joomla_components.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
                }
		if ($this->user->authorise('joomla_component.import_components', 'com_componentbuilder'))
		{
			// add Import Components button.
			JToolBarHelper::custom('joomla_components.smartImport', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_COMPONENTS', false);
		} 

		if ($this->canDo->get('core.import') && $this->canDo->get('joomla_component.import'))
		{
			JToolBarHelper::custom('joomla_components.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

                // set help url for this view if found
                $help_url = ComponentbuilderHelper::getHelpUrl('joomla_components');
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

		// Set Companyname Selection
		$this->companynameOptions = $this->getTheCompanynameSelections();
		if ($this->companynameOptions)
		{
			// Companyname Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPANYNAME_LABEL').' -',
				'filter_companyname',
				JHtml::_('select.options', $this->companynameOptions, 'value', 'text', $this->state->get('filter.companyname'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Companyname Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPANYNAME_LABEL').' -',
					'batch[companyname]',
					JHtml::_('select.options', $this->companynameOptions, 'value', 'text')
				);
			}
		}

		// Set Author Selection
		$this->authorOptions = $this->getTheAuthorSelections();
		if ($this->authorOptions)
		{
			// Author Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_AUTHOR_LABEL').' -',
				'filter_author',
				JHtml::_('select.options', $this->authorOptions, 'value', 'text', $this->state->get('filter.author'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Author Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_AUTHOR_LABEL').' -',
					'batch[author]',
					JHtml::_('select.options', $this->authorOptions, 'value', 'text')
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
		$document->setTitle(JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS'));
		$document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/joomla_components.css");
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
			'a.system_name' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SYSTEM_NAME_LABEL'),
			'a.name_code' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_NAME_CODE_LABEL'),
			'a.component_version' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPONENT_VERSION_LABEL'),
			'a.short_description' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SHORT_DESCRIPTION_LABEL'),
			'a.companyname' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPANYNAME_LABEL'),
			'a.author' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_AUTHOR_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	} 

	protected function getTheCompanynameSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('companyname'));
		$query->from($db->quoteName('#__componentbuilder_joomla_component'));
		$query->order($db->quoteName('companyname') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $companyname)
			{
				// Now add the companyname and its text to the options array
				$_filter[] = JHtml::_('select.option', $companyname, $companyname);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheAuthorSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('author'));
		$query->from($db->quoteName('#__componentbuilder_joomla_component'));
		$query->order($db->quoteName('author') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $author)
			{
				// Now add the author and its text to the options array
				$_filter[] = JHtml::_('select.option', $author, $author);
			}
			return $_filter;
		}
		return false;
	}
}
