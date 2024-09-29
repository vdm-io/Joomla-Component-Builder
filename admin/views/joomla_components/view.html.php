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
 * Componentbuilder Html View class for the Joomla_components
 */
class ComponentbuilderViewJoomla_components extends HtmlView
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
		$this->canDo = ComponentbuilderHelper::getActions('joomla_component');
		$this->canEdit = $this->canDo->get('joomla_component.edit');
		$this->canState = $this->canDo->get('joomla_component.edit.state');
		$this->canCreate = $this->canDo->get('joomla_component.create');
		$this->canDelete = $this->canDo->get('joomla_component.delete');
		$this->canBatch = ($this->canDo->get('joomla_component.batch') && $this->canDo->get('core.batch'));

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
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=joomla_components');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS'), 'joomla');
		FormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('joomla_component.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('joomla_component.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('joomla_components.publish');
				ToolbarHelper::unpublishList('joomla_components.unpublish');
				ToolbarHelper::archiveList('joomla_components.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('joomla_components.checkin');
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
			if ($this->user->authorise('joomla_component.clone', 'com_componentbuilder'))
			{
				// add Clone button.
				ToolbarHelper::custom('joomla_components.cloner', 'save-copy custom-button-cloner', '', 'COM_COMPONENTBUILDER_CLONE', 'true');
			}
			if ($this->user->authorise('joomla_component.export_jcb_packages', 'com_componentbuilder'))
			{
				// add Export JCB Packages button.
				ToolbarHelper::custom('joomla_components.smartExport', 'download custom-button-smartexport', '', 'COM_COMPONENTBUILDER_EXPORT_JCB_PACKAGES', 'true');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				ToolbarHelper::deleteList('', 'joomla_components.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('joomla_components.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('joomla_component.export'))
			{
				ToolbarHelper::custom('joomla_components.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}
		if ($this->user->authorise('joomla_component.import_jcb_packages', 'com_componentbuilder'))
		{
			// add Import JCB Packages button.
			ToolbarHelper::custom('joomla_components.smartImport', 'upload custom-button-smartimport', '', 'COM_COMPONENTBUILDER_IMPORT_JCB_PACKAGES', false);
		}
		if ($this->user->authorise('joomla_component.backup', 'com_componentbuilder'))
		{
			// add Backup button.
			ToolbarHelper::custom('joomla_components.backup', 'archive custom-button-backup', '', 'COM_COMPONENTBUILDER_BACKUP', false);
		}
		if ($this->user->authorise('joomla_component.clear_tmp', 'com_componentbuilder'))
		{
			// add Clear tmp button.
			ToolbarHelper::custom('joomla_components.clearTmp', 'purge custom-button-cleartmp', '', 'COM_COMPONENTBUILDER_CLEAR_TMP', false);
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('joomla_component.import'))
		{
			ToolbarHelper::custom('joomla_components.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('joomla_components');
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

		// Only load Companyname batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Companyname Selection
			$this->companynameOptions = FormHelper::loadFieldType('joomlacomponentsfiltercompanyname')->options;
			// We do some sanitation for Companyname filter
			if (ArrayHelper::check($this->companynameOptions) &&
				isset($this->companynameOptions[0]->value) &&
				!StringHelper::check($this->companynameOptions[0]->value))
			{
				unset($this->companynameOptions[0]);
			}
			// Companyname Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPANYNAME_LABEL').' -',
				'batch[companyname]',
				Html::_('select.options', $this->companynameOptions, 'value', 'text')
			);
		}

		// Only load Author batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Author Selection
			$this->authorOptions = FormHelper::loadFieldType('joomlacomponentsfilterauthor')->options;
			// We do some sanitation for Author filter
			if (ArrayHelper::check($this->authorOptions) &&
				isset($this->authorOptions[0]->value) &&
				!StringHelper::check($this->authorOptions[0]->value))
			{
				unset($this->authorOptions[0]);
			}
			// Author Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_AUTHOR_LABEL').' -',
				'batch[author]',
				Html::_('select.options', $this->authorOptions, 'value', 'text')
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
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/joomla_components.css", ['version' => 'auto']);
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
			'a.system_name' => Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SYSTEM_NAME_LABEL'),
			'a.name_code' => Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_NAME_CODE_LABEL'),
			'a.short_description' => Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SHORT_DESCRIPTION_LABEL'),
			'a.companyname' => Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPANYNAME_LABEL'),
			'a.created' => Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_CREATED_LABEL'),
			'a.modified' => Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_MODIFIED_LABEL'),
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
