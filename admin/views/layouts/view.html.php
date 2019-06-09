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
 * Componentbuilder View class for the Layouts
 */
class ComponentbuilderViewLayouts extends JViewLegacy
{
	/**
	 * Layouts view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('layouts');
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
		$this->canDo = ComponentbuilderHelper::getActions('layout');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
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
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_LAYOUTS'), 'brush');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=layouts');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('layout.add');
		}

		// Only load if there are items
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('layout.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('layouts.publish');
				JToolBarHelper::unpublishList('layouts.unpublish');
				JToolBarHelper::archiveList('layouts.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('layouts.checkin');
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
				JToolbarHelper::deleteList('', 'layouts.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('layouts.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('layout.export'))
			{
				JToolBarHelper::custom('layouts.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}
		if ($this->user->authorise('layout.get_snippets', 'com_componentbuilder'))
		{
			// add Get Snippets button.
			JToolBarHelper::custom('layouts.getSnippets', 'search', '', 'COM_COMPONENTBUILDER_GET_SNIPPETS', false);
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('layout.import'))
		{
			JToolBarHelper::custom('layouts.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('layouts');
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

		// Set Dynamic Get Name Selection
		$this->dynamic_getNameOptions = JFormHelper::loadFieldType('Dynamicget')->options;
		// We do some sanitation for Dynamic Get Name filter
		if (ComponentbuilderHelper::checkArray($this->dynamic_getNameOptions) &&
			isset($this->dynamic_getNameOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->dynamic_getNameOptions[0]->value))
		{
			unset($this->dynamic_getNameOptions[0]);
		}
		// Only load Dynamic Get Name filter if it has values
		if (ComponentbuilderHelper::checkArray($this->dynamic_getNameOptions))
		{
			// Dynamic Get Name Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_LAYOUT_DYNAMIC_GET_LABEL').' -',
				'filter_dynamic_get',
				JHtml::_('select.options', $this->dynamic_getNameOptions, 'value', 'text', $this->state->get('filter.dynamic_get'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Dynamic Get Name Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_LAYOUT_DYNAMIC_GET_LABEL').' -',
					'batch[dynamic_get]',
					JHtml::_('select.options', $this->dynamic_getNameOptions, 'value', 'text')
				);
			}
		}

		// Set Add Php View Selection
		$this->add_php_viewOptions = $this->getTheAdd_php_viewSelections();
		// We do some sanitation for Add Php View filter
		if (ComponentbuilderHelper::checkArray($this->add_php_viewOptions) &&
			isset($this->add_php_viewOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->add_php_viewOptions[0]->value))
		{
			unset($this->add_php_viewOptions[0]);
		}
		// Only load Add Php View filter if it has values
		if (ComponentbuilderHelper::checkArray($this->add_php_viewOptions))
		{
			// Add Php View Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_LAYOUT_ADD_PHP_VIEW_LABEL').' -',
				'filter_add_php_view',
				JHtml::_('select.options', $this->add_php_viewOptions, 'value', 'text', $this->state->get('filter.add_php_view'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Add Php View Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_LAYOUT_ADD_PHP_VIEW_LABEL').' -',
					'batch[add_php_view]',
					JHtml::_('select.options', $this->add_php_viewOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_LAYOUTS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/layouts.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.name' => JText::_('COM_COMPONENTBUILDER_LAYOUT_NAME_LABEL'),
			'a.description' => JText::_('COM_COMPONENTBUILDER_LAYOUT_DESCRIPTION_LABEL'),
			'g.name' => JText::_('COM_COMPONENTBUILDER_LAYOUT_DYNAMIC_GET_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheAdd_php_viewSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('add_php_view'));
		$query->from($db->quoteName('#__componentbuilder_layout'));
		$query->order($db->quoteName('add_php_view') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $add_php_view)
			{
				// Translate the add_php_view selection
				$text = $model->selectionTranslation($add_php_view,'add_php_view');
				// Now add the add_php_view and its text to the options array
				$_filter[] = JHtml::_('select.option', $add_php_view, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}
}
