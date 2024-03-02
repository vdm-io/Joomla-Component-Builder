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
 * Componentbuilder Html View class for the Custom_codes
 */
class ComponentbuilderViewCustom_codes extends HtmlView
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
		$this->canDo = ComponentbuilderHelper::getActions('custom_code');
		$this->canEdit = $this->canDo->get('custom_code.edit');
		$this->canState = $this->canDo->get('custom_code.edit.state');
		$this->canCreate = $this->canDo->get('custom_code.create');
		$this->canDelete = $this->canDo->get('custom_code.delete');
		$this->canBatch = ($this->canDo->get('custom_code.batch') && $this->canDo->get('core.batch'));

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
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=custom_codes');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_CUSTOM_CODES'), 'shuffle');
		FormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('custom_code.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('custom_code.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('custom_codes.publish');
				ToolbarHelper::unpublishList('custom_codes.unpublish');
				ToolbarHelper::archiveList('custom_codes.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('custom_codes.checkin');
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
				ToolbarHelper::deleteList('', 'custom_codes.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('custom_codes.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('custom_code.export'))
			{
				ToolbarHelper::custom('custom_codes.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}
		if ($this->user->authorise('custom_code.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			ToolbarHelper::custom('custom_codes.runExpansion', 'expand-2 custom-button-runexpansion', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('custom_code.import'))
		{
			ToolbarHelper::custom('custom_codes.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('custom_codes');
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

		// Only load Component System Name batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Component System Name Selection
			$this->componentSystem_nameOptions = FormHelper::loadFieldType('Joomlacomponent')->options;
			// We do some sanitation for Component System Name filter
			if (ArrayHelper::check($this->componentSystem_nameOptions) &&
				isset($this->componentSystem_nameOptions[0]->value) &&
				!StringHelper::check($this->componentSystem_nameOptions[0]->value))
			{
				unset($this->componentSystem_nameOptions[0]);
			}
			// Component System Name Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMPONENT_LABEL').' -',
				'batch[component]',
				Html::_('select.options', $this->componentSystem_nameOptions, 'value', 'text')
			);
		}

		// Only load Target batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Target Selection
			$this->targetOptions = FormHelper::loadFieldType('customcodesfiltertarget')->options;
			// We do some sanitation for Target filter
			if (ArrayHelper::check($this->targetOptions) &&
				isset($this->targetOptions[0]->value) &&
				!StringHelper::check($this->targetOptions[0]->value))
			{
				unset($this->targetOptions[0]);
			}
			// Target Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TARGET_LABEL').' -',
				'batch[target]',
				Html::_('select.options', $this->targetOptions, 'value', 'text')
			);
		}

		// Only load Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Type Selection
			$this->typeOptions = FormHelper::loadFieldType('customcodesfiltertype')->options;
			// We do some sanitation for Type filter
			if (ArrayHelper::check($this->typeOptions) &&
				isset($this->typeOptions[0]->value) &&
				!StringHelper::check($this->typeOptions[0]->value))
			{
				unset($this->typeOptions[0]);
			}
			// Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TYPE_LABEL').' -',
				'batch[type]',
				Html::_('select.options', $this->typeOptions, 'value', 'text')
			);
		}

		// Only load Comment Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Comment Type Selection
			$this->comment_typeOptions = FormHelper::loadFieldType('customcodesfiltercommenttype')->options;
			// We do some sanitation for Comment Type filter
			if (ArrayHelper::check($this->comment_typeOptions) &&
				isset($this->comment_typeOptions[0]->value) &&
				!StringHelper::check($this->comment_typeOptions[0]->value))
			{
				unset($this->comment_typeOptions[0]);
			}
			// Comment Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMMENT_TYPE_LABEL').' -',
				'batch[comment_type]',
				Html::_('select.options', $this->comment_typeOptions, 'value', 'text')
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
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_CUSTOM_CODES'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/custom_codes.css", ['version' => 'auto']);
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
			'g.system_name' => Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMPONENT_LABEL'),
			'a.path' => Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PATH_LABEL'),
			'a.target' => Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TARGET_LABEL'),
			'a.type' => Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_TYPE_LABEL'),
			'a.comment_type' => Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_COMMENT_TYPE_LABEL'),
			'a.joomla_version' => Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_JOOMLA_VERSION_LABEL'),
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
