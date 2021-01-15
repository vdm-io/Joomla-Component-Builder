<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

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
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();
		// Load the filter form from xml.
		$this->filterForm = $this->get('FilterForm');
		// Load the active filters.
		$this->activeFilters = $this->get('ActiveFilters');
		// Add the list ordering clause.
		$this->listOrder = $this->escape($this->state->get('list.ordering', 'a.id'));
		$this->listDirn = $this->escape($this->state->get('list.direction', 'desc'));
		$this->saveOrder = $this->listOrder == 'a.ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('custom_code');
		$this->canEdit = $this->canDo->get('custom_code.edit');
		$this->canState = $this->canDo->get('custom_code.edit.state');
		$this->canCreate = $this->canDo->get('custom_code.create');
		$this->canDelete = $this->canDo->get('custom_code.delete');
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
		if ($this->user->authorise('custom_code.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			JToolBarHelper::custom('custom_codes.runExpansion', 'expand-2 custom-button-runexpansion', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
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

		// Only load published batch if state and batch is allowed
		if ($this->canState && $this->canBatch)
		{
			JHtmlBatch_::addListSelection(
				JText::_('COM_COMPONENTBUILDER_KEEP_ORIGINAL_STATE'),
				'batch[published]',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
			);
		}

		// Only load access batch if create, edit and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
				JText::_('COM_COMPONENTBUILDER_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Only load Component System Name batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Component System Name Selection
			$this->componentSystem_nameOptions = JFormHelper::loadFieldType('Joomlacomponent')->options;
			// We do some sanitation for Component System Name filter
			if (ComponentbuilderHelper::checkArray($this->componentSystem_nameOptions) &&
				isset($this->componentSystem_nameOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->componentSystem_nameOptions[0]->value))
			{
				unset($this->componentSystem_nameOptions[0]);
			}
			// Component System Name Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMPONENT_LABEL').' -',
				'batch[component]',
				JHtml::_('select.options', $this->componentSystem_nameOptions, 'value', 'text')
			);
		}

		// Only load Target batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Target Selection
			$this->targetOptions = JFormHelper::loadFieldType('customcodesfiltertarget')->options;
			// We do some sanitation for Target filter
			if (ComponentbuilderHelper::checkArray($this->targetOptions) &&
				isset($this->targetOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->targetOptions[0]->value))
			{
				unset($this->targetOptions[0]);
			}
			// Target Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TARGET_LABEL').' -',
				'batch[target]',
				JHtml::_('select.options', $this->targetOptions, 'value', 'text')
			);
		}

		// Only load Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Type Selection
			$this->typeOptions = JFormHelper::loadFieldType('customcodesfiltertype')->options;
			// We do some sanitation for Type filter
			if (ComponentbuilderHelper::checkArray($this->typeOptions) &&
				isset($this->typeOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->typeOptions[0]->value))
			{
				unset($this->typeOptions[0]);
			}
			// Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TYPE_LABEL').' -',
				'batch[type]',
				JHtml::_('select.options', $this->typeOptions, 'value', 'text')
			);
		}

		// Only load Comment Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Comment Type Selection
			$this->comment_typeOptions = JFormHelper::loadFieldType('customcodesfiltercommenttype')->options;
			// We do some sanitation for Comment Type filter
			if (ComponentbuilderHelper::checkArray($this->comment_typeOptions) &&
				isset($this->comment_typeOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->comment_typeOptions[0]->value))
			{
				unset($this->comment_typeOptions[0]);
			}
			// Comment Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMMENT_TYPE_LABEL').' -',
				'batch[comment_type]',
				JHtml::_('select.options', $this->comment_typeOptions, 'value', 'text')
			);
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
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_CUSTOM_CODES'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/custom_codes.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'g.system_name' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMPONENT_LABEL'),
			'a.path' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PATH_LABEL'),
			'a.target' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TARGET_LABEL'),
			'a.type' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TYPE_LABEL'),
			'a.comment_type' => JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMMENT_TYPE_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
