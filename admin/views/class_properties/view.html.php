<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Componentbuilder View class for the Class_properties
 */
class ComponentbuilderViewClass_properties extends JViewLegacy
{
	/**
	 * Class_properties view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('class_properties');
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
		$this->canDo = ComponentbuilderHelper::getActions('class_property');
		$this->canEdit = $this->canDo->get('class_property.edit');
		$this->canState = $this->canDo->get('class_property.edit.state');
		$this->canCreate = $this->canDo->get('class_property.create');
		$this->canDelete = $this->canDo->get('class_property.delete');
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
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_CLASS_PROPERTIES'), 'cube');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=class_properties');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('class_property.add');
		}

		// Only load if there are items
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('class_property.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('class_properties.publish');
				JToolBarHelper::unpublishList('class_properties.unpublish');
				JToolBarHelper::archiveList('class_properties.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('class_properties.checkin');
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
				JToolbarHelper::deleteList('', 'class_properties.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('class_properties.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('class_property.export'))
			{
				JToolBarHelper::custom('class_properties.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('class_property.import'))
		{
			JToolBarHelper::custom('class_properties.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('class_properties');
		if (ComponentbuilderHelper::checkString($this->help_url))
		{
				JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
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

		// Only load Visibility batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Visibility Selection
			$this->visibilityOptions = JFormHelper::loadFieldType('classpropertiesfiltervisibility')->options;
			// We do some sanitation for Visibility filter
			if (ComponentbuilderHelper::checkArray($this->visibilityOptions) &&
				isset($this->visibilityOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->visibilityOptions[0]->value))
			{
				unset($this->visibilityOptions[0]);
			}
			// Visibility Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CLASS_PROPERTY_VISIBILITY_LABEL').' -',
				'batch[visibility]',
				JHtml::_('select.options', $this->visibilityOptions, 'value', 'text')
			);
		}

		// Only load Extension Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Extension Type Selection
			$this->extension_typeOptions = JFormHelper::loadFieldType('classpropertiesfilterextensiontype')->options;
			// We do some sanitation for Extension Type filter
			if (ComponentbuilderHelper::checkArray($this->extension_typeOptions) &&
				isset($this->extension_typeOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->extension_typeOptions[0]->value))
			{
				unset($this->extension_typeOptions[0]);
			}
			// Extension Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_CLASS_PROPERTY_EXTENSION_TYPE_LABEL').' -',
				'batch[extension_type]',
				JHtml::_('select.options', $this->extension_typeOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_CLASS_PROPERTIES'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/class_properties.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.name' => JText::_('COM_COMPONENTBUILDER_CLASS_PROPERTY_NAME_LABEL'),
			'a.visibility' => JText::_('COM_COMPONENTBUILDER_CLASS_PROPERTY_VISIBILITY_LABEL'),
			'a.extension_type' => JText::_('COM_COMPONENTBUILDER_CLASS_PROPERTY_EXTENSION_TYPE_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
