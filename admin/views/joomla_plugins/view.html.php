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
 * Componentbuilder View class for the Joomla_plugins
 */
class ComponentbuilderViewJoomla_plugins extends JViewLegacy
{
	/**
	 * Joomla_plugins view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('joomla_plugins');
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
		$this->canDo = ComponentbuilderHelper::getActions('joomla_plugin');
		$this->canEdit = $this->canDo->get('joomla_plugin.edit');
		$this->canState = $this->canDo->get('joomla_plugin.edit.state');
		$this->canCreate = $this->canDo->get('joomla_plugin.create');
		$this->canDelete = $this->canDo->get('joomla_plugin.delete');
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
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGINS'), 'power-cord');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=joomla_plugins');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('joomla_plugin.add');
		}

		// Only load if there are items
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('joomla_plugin.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('joomla_plugins.publish');
				JToolBarHelper::unpublishList('joomla_plugins.unpublish');
				JToolBarHelper::archiveList('joomla_plugins.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('joomla_plugins.checkin');
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
				JToolbarHelper::deleteList('', 'joomla_plugins.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('joomla_plugins.trash');
			}
		}
		if ($this->user->authorise('joomla_plugin.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			JToolBarHelper::custom('joomla_plugins.runExpansion', 'expand-2', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}
		if ($this->user->authorise('joomla_plugin.get_boilerplate', 'com_componentbuilder'))
		{
			// add Get Boilerplate button.
			JToolBarHelper::custom('joomla_plugins.getBoilerplate', 'joomla', '', 'COM_COMPONENTBUILDER_GET_BOILERPLATE', false);
		}
		if ($this->user->authorise('joomla_plugin.methods', 'com_componentbuilder'))
		{
			// add Methods button.
			JToolBarHelper::custom('joomla_plugins.openClassMethods', 'joomla', '', 'COM_COMPONENTBUILDER_METHODS', false);
		}
		if ($this->user->authorise('joomla_plugin.properties', 'com_componentbuilder'))
		{
			// add Properties button.
			JToolBarHelper::custom('joomla_plugins.openClassProperties', 'joomla', '', 'COM_COMPONENTBUILDER_PROPERTIES', false);
		}

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('joomla_plugins');
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

		// Set Class Extends Name Selection
		$this->class_extendsNameOptions = JFormHelper::loadFieldType('Classextends')->options;
		// We do some sanitation for Class Extends Name filter
		if (ComponentbuilderHelper::checkArray($this->class_extendsNameOptions) &&
			isset($this->class_extendsNameOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->class_extendsNameOptions[0]->value))
		{
			unset($this->class_extendsNameOptions[0]);
		}
		// Only load Class Extends Name filter if it has values
		if (ComponentbuilderHelper::checkArray($this->class_extendsNameOptions))
		{
			// Class Extends Name Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CLASS_EXTENDS_LABEL').' -',
				'filter_class_extends',
				JHtml::_('select.options', $this->class_extendsNameOptions, 'value', 'text', $this->state->get('filter.class_extends'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Class Extends Name Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CLASS_EXTENDS_LABEL').' -',
					'batch[class_extends]',
					JHtml::_('select.options', $this->class_extendsNameOptions, 'value', 'text')
				);
			}
		}

		// Set Joomla Plugin Group Name Selection
		$this->joomla_plugin_groupNameOptions = JFormHelper::loadFieldType('Joomlaplugingroups')->options;
		// We do some sanitation for Joomla Plugin Group Name filter
		if (ComponentbuilderHelper::checkArray($this->joomla_plugin_groupNameOptions) &&
			isset($this->joomla_plugin_groupNameOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->joomla_plugin_groupNameOptions[0]->value))
		{
			unset($this->joomla_plugin_groupNameOptions[0]);
		}
		// Only load Joomla Plugin Group Name filter if it has values
		if (ComponentbuilderHelper::checkArray($this->joomla_plugin_groupNameOptions))
		{
			// Joomla Plugin Group Name Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_JOOMLA_PLUGIN_GROUP_LABEL').' -',
				'filter_joomla_plugin_group',
				JHtml::_('select.options', $this->joomla_plugin_groupNameOptions, 'value', 'text', $this->state->get('filter.joomla_plugin_group'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Joomla Plugin Group Name Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_JOOMLA_PLUGIN_GROUP_LABEL').' -',
					'batch[joomla_plugin_group]',
					JHtml::_('select.options', $this->joomla_plugin_groupNameOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGINS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/joomla_plugins.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.system_name' => JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_SYSTEM_NAME_LABEL'),
			'g.name' => JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CLASS_EXTENDS_LABEL'),
			'h.name' => JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_JOOMLA_PLUGIN_GROUP_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
