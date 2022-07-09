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

use Joomla\CMS\MVC\View\HtmlView;

/**
 * Componentbuilder Html View class for the Powers
 */
class ComponentbuilderViewPowers extends HtmlView
{
	/**
	 * Powers view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('powers');
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
		$this->canDo = ComponentbuilderHelper::getActions('power');
		$this->canEdit = $this->canDo->get('power.edit');
		$this->canState = $this->canDo->get('power.edit.state');
		$this->canCreate = $this->canDo->get('power.create');
		$this->canDelete = $this->canDo->get('power.delete');
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
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_POWERS'), 'flash');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=powers');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('power.add');
		}

		// Only load if there are items
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('power.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('powers.publish');
				JToolBarHelper::unpublishList('powers.unpublish');
				JToolBarHelper::archiveList('powers.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('powers.checkin');
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
				JToolbarHelper::deleteList('', 'powers.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('powers.trash');
			}
		}
		if ($this->user->authorise('power.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			JToolBarHelper::custom('powers.runExpansion', 'expand-2 custom-button-runexpansion', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('powers');
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

		// Only load Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Type Selection
			$this->typeOptions = JFormHelper::loadFieldType('powersfiltertype')->options;
			// We do some sanitation for Type filter
			if (ComponentbuilderHelper::checkArray($this->typeOptions) &&
				isset($this->typeOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->typeOptions[0]->value))
			{
				unset($this->typeOptions[0]);
			}
			// Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_POWER_TYPE_LABEL').' -',
				'batch[type]',
				JHtml::_('select.options', $this->typeOptions, 'value', 'text')
			);
		}

		// Only load Power Version batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Power Version Selection
			$this->power_versionOptions = JFormHelper::loadFieldType('powersfilterpowerversion')->options;
			// We do some sanitation for Power Version filter
			if (ComponentbuilderHelper::checkArray($this->power_versionOptions) &&
				isset($this->power_versionOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->power_versionOptions[0]->value))
			{
				unset($this->power_versionOptions[0]);
			}
			// Power Version Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_POWER_POWER_VERSION_LABEL').' -',
				'batch[power_version]',
				JHtml::_('select.options', $this->power_versionOptions, 'value', 'text')
			);
		}

		// Only load Extends Name batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Extends Name Selection
			$this->extendsNameOptions = JFormHelper::loadFieldType('Classpowers')->options;
			// We do some sanitation for Extends Name filter
			if (ComponentbuilderHelper::checkArray($this->extendsNameOptions) &&
				isset($this->extendsNameOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->extendsNameOptions[0]->value))
			{
				unset($this->extendsNameOptions[0]);
			}
			// Extends Name Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_POWER_EXTENDS_LABEL').' -',
				'batch[extends]',
				JHtml::_('select.options', $this->extendsNameOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_POWERS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/powers.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.system_name' => JText::_('COM_COMPONENTBUILDER_POWER_SYSTEM_NAME_LABEL'),
			'a.namespace' => JText::_('COM_COMPONENTBUILDER_POWER_NAMESPACE_LABEL'),
			'a.type' => JText::_('COM_COMPONENTBUILDER_POWER_TYPE_LABEL'),
			'a.power_version' => JText::_('COM_COMPONENTBUILDER_POWER_POWER_VERSION_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
