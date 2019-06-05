<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

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
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();
		$this->listOrder = $this->escape($this->state->get('list.ordering'));
		$this->listDirn = $this->escape($this->state->get('list.direction'));
		$this->saveOrder = $this->listOrder == 'ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('joomla_component');
		$this->canEdit = $this->canDo->get('joomla_component.edit');
		$this->canState = $this->canDo->get('joomla_component.edit.state');
		$this->canCreate = $this->canDo->get('joomla_component.create');
		$this->canDelete = $this->canDo->get('joomla_component.delete');
		$this->canBatch = $this->canDo->get('core.batch');

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
			if ($this->user->authorise('joomla_component.clone', 'com_componentbuilder'))
			{
				// add Clone button.
				JToolBarHelper::custom('joomla_components.cloner', 'save-copy', '', 'COM_COMPONENTBUILDER_CLONE', 'true');
			}
			if ($this->user->authorise('joomla_component.export_jcb_packages', 'com_componentbuilder'))
			{
				// add Export JCB Packages button.
				JToolBarHelper::custom('joomla_components.smartExport', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_JCB_PACKAGES', 'true');
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
		if ($this->user->authorise('joomla_component.import_jcb_packages', 'com_componentbuilder'))
		{
			// add Import JCB Packages button.
			JToolBarHelper::custom('joomla_components.smartImport', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_JCB_PACKAGES', false);
		}
		if ($this->user->authorise('joomla_component.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			JToolBarHelper::custom('joomla_components.runExpansion', 'expand-2', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}
		if ($this->user->authorise('joomla_component.backup', 'com_componentbuilder'))
		{
			// add Backup button.
			JToolBarHelper::custom('joomla_components.backup', 'archive', '', 'COM_COMPONENTBUILDER_BACKUP', false);
		}
		if ($this->user->authorise('joomla_component.clear_tmp', 'com_componentbuilder'))
		{
			// add Clear tmp button.
			JToolBarHelper::custom('joomla_components.clearTmp', 'purge', '', 'COM_COMPONENTBUILDER_CLEAR_TMP', false);
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
		// We do some sanitation for Companyname filter
		if (ComponentbuilderHelper::checkArray($this->companynameOptions) &&
			isset($this->companynameOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->companynameOptions[0]->value))
		{
			unset($this->companynameOptions[0]);
		}
		// Only load Companyname filter if it has values
		if (ComponentbuilderHelper::checkArray($this->companynameOptions))
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
		// We do some sanitation for Author filter
		if (ComponentbuilderHelper::checkArray($this->authorOptions) &&
			isset($this->authorOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->authorOptions[0]->value))
		{
			unset($this->authorOptions[0]);
		}
		// Only load Author filter if it has values
		if (ComponentbuilderHelper::checkArray($this->authorOptions))
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
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/joomla_components.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.short_description' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SHORT_DESCRIPTION_LABEL'),
			'a.companyname' => JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPANYNAME_LABEL'),
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
