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
		$this->canDo = ComponentbuilderHelper::getActions('power');
		$this->canEdit = $this->canDo->get('power.edit');
		$this->canState = $this->canDo->get('power.edit.state');
		$this->canCreate = $this->canDo->get('power.create');
		$this->canDelete = $this->canDo->get('power.delete');
		$this->canBatch = ($this->canDo->get('power.batch') && $this->canDo->get('core.batch'));

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
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=powers');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_POWERS'), 'flash');
		FormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('power.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('power.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('powers.publish');
				ToolbarHelper::unpublishList('powers.unpublish');
				ToolbarHelper::archiveList('powers.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('powers.checkin');
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
				ToolbarHelper::deleteList('', 'powers.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('powers.trash');
			}
		}
		if ($this->user->authorise('power.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			ToolbarHelper::custom('powers.runExpansion', 'expand-2 custom-button-runexpansion', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}
		if ($this->user->authorise('power.init', 'com_componentbuilder'))
		{
			// add Init button.
			ToolbarHelper::custom('powers.initPowers', 'health custom-button-initpowers', '', 'COM_COMPONENTBUILDER_INIT', false);
		}
		if ($this->user->authorise('power.reset', 'com_componentbuilder'))
		{
			// add Reset button.
			ToolbarHelper::custom('powers.resetPowers', 'joomla custom-button-resetpowers', '', 'COM_COMPONENTBUILDER_RESET', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('powers');
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

		// Only load Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Type Selection
			$this->typeOptions = FormHelper::loadFieldType('powersfiltertype')->options;
			// We do some sanitation for Type filter
			if (ArrayHelper::check($this->typeOptions) &&
				isset($this->typeOptions[0]->value) &&
				!StringHelper::check($this->typeOptions[0]->value))
			{
				unset($this->typeOptions[0]);
			}
			// Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_POWER_TYPE_LABEL').' -',
				'batch[type]',
				Html::_('select.options', $this->typeOptions, 'value', 'text')
			);
		}

		// Only load Approved batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Approved Selection
			$this->approvedOptions = FormHelper::loadFieldType('powersfilterapproved')->options;
			// We do some sanitation for Approved filter
			if (ArrayHelper::check($this->approvedOptions) &&
				isset($this->approvedOptions[0]->value) &&
				!StringHelper::check($this->approvedOptions[0]->value))
			{
				unset($this->approvedOptions[0]);
			}
			// Approved Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_POWER_APPROVED_LABEL').' -',
				'batch[approved]',
				Html::_('select.options', $this->approvedOptions, 'value', 'text')
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
			$this->document = Factory::getDocument();
		}
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_POWERS'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/powers.css", ['version' => 'auto']);
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
			'a.system_name' => Text::_('COM_COMPONENTBUILDER_POWER_SYSTEM_NAME_LABEL'),
			'a.namespace' => Text::_('COM_COMPONENTBUILDER_POWER_NAMESPACE_LABEL'),
			'a.type' => Text::_('COM_COMPONENTBUILDER_POWER_TYPE_LABEL'),
			'a.power_version' => Text::_('COM_COMPONENTBUILDER_POWER_POWER_VERSION_LABEL'),
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
