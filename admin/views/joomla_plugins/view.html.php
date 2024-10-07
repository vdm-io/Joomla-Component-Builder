<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;

/**
 * Componentbuilder Html View class for the Joomla_plugins
 */
class ComponentbuilderViewJoomla_plugins extends HtmlView
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
		$this->user = Factory::getUser();
		// Load the filter form from xml.
		$this->filterForm = $this->get('FilterForm');
		// Load the active filters.
		$this->activeFilters = $this->get('ActiveFilters');
		// Add the list ordering clause.
		$this->listOrder = $this->escape($this->state->get('list.ordering', 'a.id'));
		$this->listDirn = $this->escape($this->state->get('list.direction', 'desc'));
		$this->saveOrder = $this->listOrder == 'a.ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) Uri::getInstance()));
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('joomla_plugin');
		$this->canEdit = $this->canDo->get('joomla_plugin.edit');
		$this->canState = $this->canDo->get('joomla_plugin.edit.state');
		$this->canCreate = $this->canDo->get('joomla_plugin.create');
		$this->canDelete = $this->canDo->get('joomla_plugin.delete');
		$this->canBatch = ($this->canDo->get('joomla_plugin.batch') && $this->canDo->get('core.batch'));

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

		// Set the document
		$this->setDocument();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=joomla_plugins');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGINS'), 'power-cord');
		FormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('joomla_plugin.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('joomla_plugin.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('joomla_plugins.publish');
				ToolbarHelper::unpublishList('joomla_plugins.unpublish');
				ToolbarHelper::archiveList('joomla_plugins.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('joomla_plugins.checkin');
				}
			}

			// Add a batch button
			if ($this->canBatch && $this->canCreate && $this->canEdit && $this->canState)
			{
				// Get the toolbar object instance
				$bar = Toolbar::getInstance('toolbar');
				// set the batch button name
				$title = Text::_('JTOOLBAR_BATCH');
				// Instantiate a new JLayoutFile instance and render the batch button
				$layout = new FileLayout('joomla.toolbar.batch');
				// add the button to the page
				$dhtml = $layout->render(array('title' => $title));
				$bar->appendButton('Custom', $dhtml, 'batch');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				ToolbarHelper::deleteList('', 'joomla_plugins.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('joomla_plugins.trash');
			}
		}
		if ($this->user->authorise('joomla_plugin.get_boilerplate', 'com_componentbuilder'))
		{
			// add Get Boilerplate button.
			ToolbarHelper::custom('joomla_plugins.getBoilerplate', 'joomla custom-button-getboilerplate', '', 'COM_COMPONENTBUILDER_GET_BOILERPLATE', false);
		}
		if ($this->user->authorise('joomla_plugin.methods', 'com_componentbuilder'))
		{
			// add Methods button.
			ToolbarHelper::custom('joomla_plugins.openClassMethods', 'joomla custom-button-openclassmethods', '', 'COM_COMPONENTBUILDER_METHODS', false);
		}
		if ($this->user->authorise('joomla_plugin.properties', 'com_componentbuilder'))
		{
			// add Properties button.
			ToolbarHelper::custom('joomla_plugins.openClassProperties', 'joomla custom-button-openclassproperties', '', 'COM_COMPONENTBUILDER_PROPERTIES', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('joomla_plugins');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_componentbuilder');
		}

		// Only load published batch if state and batch is allowed
		if ($this->canState && $this->canBatch)
		{
			JHtmlBatch_::addListSelection(
				Text::_('COM_COMPONENTBUILDER_KEEP_ORIGINAL_STATE'),
				'batch[published]',
				Html::_('select.options', Html::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
			);
		}

		// Only load access batch if create, edit and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
				Text::_('COM_COMPONENTBUILDER_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				Html::_('select.options', Html::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Only load Class Extends Name batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Class Extends Name Selection
			$this->class_extendsNameOptions = FormHelper::loadFieldType('Classextends')->options;
			// We do some sanitation for Class Extends Name filter
			if (ArrayHelper::check($this->class_extendsNameOptions) &&
				isset($this->class_extendsNameOptions[0]->value) &&
				!StringHelper::check($this->class_extendsNameOptions[0]->value))
			{
				unset($this->class_extendsNameOptions[0]);
			}
			// Class Extends Name Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CLASS_EXTENDS_LABEL').' -',
				'batch[class_extends]',
				Html::_('select.options', $this->class_extendsNameOptions, 'value', 'text')
			);
		}

		// Only load Joomla Plugin Group Name batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Joomla Plugin Group Name Selection
			$this->joomla_plugin_groupNameOptions = FormHelper::loadFieldType('Joomlaplugingroups')->options;
			// We do some sanitation for Joomla Plugin Group Name filter
			if (ArrayHelper::check($this->joomla_plugin_groupNameOptions) &&
				isset($this->joomla_plugin_groupNameOptions[0]->value) &&
				!StringHelper::check($this->joomla_plugin_groupNameOptions[0]->value))
			{
				unset($this->joomla_plugin_groupNameOptions[0]);
			}
			// Joomla Plugin Group Name Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_JOOMLA_PLUGIN_GROUP_LABEL').' -',
				'batch[joomla_plugin_group]',
				Html::_('select.options', $this->joomla_plugin_groupNameOptions, 'value', 'text')
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
		// Load Core
		Html::_('behavior.core');
		// Load jQuery
		Html::_('jquery.framework');

		if (!isset($this->document))
		{
			$this->document = Factory::getDocument();
		}
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGINS'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/joomla_plugins.css", ['version' => 'auto']);
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
			return StringHelper::html($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return StringHelper::html($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array   Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
			'a.ordering' => Text::_('JGRID_HEADING_ORDERING'),
			'a.published' => Text::_('JSTATUS'),
			'a.system_name' => Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_SYSTEM_NAME_LABEL'),
			'g.name' => Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CLASS_EXTENDS_LABEL'),
			'h.name' => Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_JOOMLA_PLUGIN_GROUP_LABEL'),
			'a.id' => Text::_('JGRID_HEADING_ID')
		);
	}

	/**
	 * Get the Document (helper method toward Joomla 4 and 5)
	 */
	public function getDocument()
	{
		$this->document ??= JFactory::getDocument();

		return $this->document;
	}
}
