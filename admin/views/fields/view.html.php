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
 * Componentbuilder Html View class for the Fields
 */
class ComponentbuilderViewFields extends HtmlView
{
	/**
	 * Fields view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('fields');
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
		$this->canDo = ComponentbuilderHelper::getActions('field');
		$this->canEdit = $this->canDo->get('field.edit');
		$this->canState = $this->canDo->get('field.edit.state');
		$this->canCreate = $this->canDo->get('field.create');
		$this->canDelete = $this->canDo->get('field.delete');
		$this->canBatch = ($this->canDo->get('field.batch') && $this->canDo->get('core.batch'));

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
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=fields');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_FIELDS'), 'lamp');
		FormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('field.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('field.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('fields.publish');
				ToolbarHelper::unpublishList('fields.unpublish');
				ToolbarHelper::archiveList('fields.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('fields.checkin');
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
				ToolbarHelper::deleteList('', 'fields.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('fields.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('field.export'))
			{
				ToolbarHelper::custom('fields.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}
		if ($this->user->authorise('field.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			ToolbarHelper::custom('fields.runExpansion', 'expand-2 custom-button-runexpansion', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('field.import'))
		{
			ToolbarHelper::custom('fields.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('fields');
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

		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Category Batch selection.
			JHtmlBatch_::addListSelection(
				Text::_('COM_COMPONENTBUILDER_KEEP_ORIGINAL_CATEGORY'),
				'batch[category]',
				Html::_('select.options', Html::_('category.options', 'com_componentbuilder.field'), 'value', 'text')
			);
		}

		// Only load Fieldtype Name batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Fieldtype Name Selection
			$this->fieldtypeNameOptions = FormHelper::loadFieldType('Fieldtypes')->options;
			// We do some sanitation for Fieldtype Name filter
			if (ArrayHelper::check($this->fieldtypeNameOptions) &&
				isset($this->fieldtypeNameOptions[0]->value) &&
				!StringHelper::check($this->fieldtypeNameOptions[0]->value))
			{
				unset($this->fieldtypeNameOptions[0]);
			}
			// Fieldtype Name Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_FIELD_FIELDTYPE_LABEL').' -',
				'batch[fieldtype]',
				Html::_('select.options', $this->fieldtypeNameOptions, 'value', 'text')
			);
		}

		// Only load Datatype batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Datatype Selection
			$this->datatypeOptions = FormHelper::loadFieldType('fieldsfilterdatatype')->options;
			// We do some sanitation for Datatype filter
			if (ArrayHelper::check($this->datatypeOptions) &&
				isset($this->datatypeOptions[0]->value) &&
				!StringHelper::check($this->datatypeOptions[0]->value))
			{
				unset($this->datatypeOptions[0]);
			}
			// Datatype Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_FIELD_DATATYPE_LABEL').' -',
				'batch[datatype]',
				Html::_('select.options', $this->datatypeOptions, 'value', 'text')
			);
		}

		// Only load Indexes batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Indexes Selection
			$this->indexesOptions = FormHelper::loadFieldType('fieldsfilterindexes')->options;
			// We do some sanitation for Indexes filter
			if (ArrayHelper::check($this->indexesOptions) &&
				isset($this->indexesOptions[0]->value) &&
				!StringHelper::check($this->indexesOptions[0]->value))
			{
				unset($this->indexesOptions[0]);
			}
			// Indexes Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_FIELD_INDEXES_LABEL').' -',
				'batch[indexes]',
				Html::_('select.options', $this->indexesOptions, 'value', 'text')
			);
		}

		// Only load Null Switch batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Null Switch Selection
			$this->null_switchOptions = FormHelper::loadFieldType('fieldsfilternullswitch')->options;
			// We do some sanitation for Null Switch filter
			if (ArrayHelper::check($this->null_switchOptions) &&
				isset($this->null_switchOptions[0]->value) &&
				!StringHelper::check($this->null_switchOptions[0]->value))
			{
				unset($this->null_switchOptions[0]);
			}
			// Null Switch Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_FIELD_NULL_SWITCH_LABEL').' -',
				'batch[null_switch]',
				Html::_('select.options', $this->null_switchOptions, 'value', 'text')
			);
		}

		// Only load Store batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Store Selection
			$this->storeOptions = FormHelper::loadFieldType('fieldsfilterstore')->options;
			// We do some sanitation for Store filter
			if (ArrayHelper::check($this->storeOptions) &&
				isset($this->storeOptions[0]->value) &&
				!StringHelper::check($this->storeOptions[0]->value))
			{
				unset($this->storeOptions[0]);
			}
			// Store Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_FIELD_STORE_LABEL').' -',
				'batch[store]',
				Html::_('select.options', $this->storeOptions, 'value', 'text')
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
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_FIELDS'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/fields.css", ['version' => 'auto']);
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
			'a.name' => Text::_('COM_COMPONENTBUILDER_FIELD_NAME_LABEL'),
			'g.name' => Text::_('COM_COMPONENTBUILDER_FIELD_FIELDTYPE_LABEL'),
			'a.datatype' => Text::_('COM_COMPONENTBUILDER_FIELD_DATATYPE_LABEL'),
			'a.indexes' => Text::_('COM_COMPONENTBUILDER_FIELD_INDEXES_LABEL'),
			'a.null_switch' => Text::_('COM_COMPONENTBUILDER_FIELD_NULL_SWITCH_LABEL'),
			'a.store' => Text::_('COM_COMPONENTBUILDER_FIELD_STORE_LABEL'),
			'category_title' => Text::_('COM_COMPONENTBUILDER_FIELD_FIELDS_CATEGORIES'),
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
