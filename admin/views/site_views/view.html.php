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
 * Componentbuilder Html View class for the Site_views
 */
class ComponentbuilderViewSite_views extends HtmlView
{
	/**
	 * Site_views view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('site_views');
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
		$this->canDo = ComponentbuilderHelper::getActions('site_view');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
		$this->canBatch = ($this->canDo->get('site_view.batch') && $this->canDo->get('core.batch'));

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
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=site_views');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_SITE_VIEWS'), 'palette');
		FormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('site_view.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('site_view.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('site_views.publish');
				ToolbarHelper::unpublishList('site_views.unpublish');
				ToolbarHelper::archiveList('site_views.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('site_views.checkin');
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
				ToolbarHelper::deleteList('', 'site_views.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('site_views.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('site_view.export'))
			{
				ToolbarHelper::custom('site_views.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}
		if ($this->user->authorise('site_view.get_snippets', 'com_componentbuilder'))
		{
			// add Get Snippets button.
			ToolbarHelper::custom('site_views.getSnippets', 'search custom-button-getsnippets', '', 'COM_COMPONENTBUILDER_GET_SNIPPETS', false);
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('site_view.import'))
		{
			ToolbarHelper::custom('site_views.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('site_views');
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

		// Only load Main Get Name batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Main Get Name Selection
			$this->main_getNameOptions = FormHelper::loadFieldType('Maingets')->options;
			// We do some sanitation for Main Get Name filter
			if (ArrayHelper::check($this->main_getNameOptions) &&
				isset($this->main_getNameOptions[0]->value) &&
				!StringHelper::check($this->main_getNameOptions[0]->value))
			{
				unset($this->main_getNameOptions[0]);
			}
			// Main Get Name Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_SITE_VIEW_MAIN_GET_LABEL').' -',
				'batch[main_get]',
				Html::_('select.options', $this->main_getNameOptions, 'value', 'text')
			);
		}

		// Only load Add Php Ajax batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Add Php Ajax Selection
			$this->add_php_ajaxOptions = FormHelper::loadFieldType('siteviewsfilteraddphpajax')->options;
			// We do some sanitation for Add Php Ajax filter
			if (ArrayHelper::check($this->add_php_ajaxOptions) &&
				isset($this->add_php_ajaxOptions[0]->value) &&
				!StringHelper::check($this->add_php_ajaxOptions[0]->value))
			{
				unset($this->add_php_ajaxOptions[0]);
			}
			// Add Php Ajax Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_SITE_VIEW_ADD_PHP_AJAX_LABEL').' -',
				'batch[add_php_ajax]',
				Html::_('select.options', $this->add_php_ajaxOptions, 'value', 'text')
			);
		}

		// Only load Add Custom Button batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Add Custom Button Selection
			$this->add_custom_buttonOptions = FormHelper::loadFieldType('siteviewsfilteraddcustombutton')->options;
			// We do some sanitation for Add Custom Button filter
			if (ArrayHelper::check($this->add_custom_buttonOptions) &&
				isset($this->add_custom_buttonOptions[0]->value) &&
				!StringHelper::check($this->add_custom_buttonOptions[0]->value))
			{
				unset($this->add_custom_buttonOptions[0]);
			}
			// Add Custom Button Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_SITE_VIEW_ADD_CUSTOM_BUTTON_LABEL').' -',
				'batch[add_custom_button]',
				Html::_('select.options', $this->add_custom_buttonOptions, 'value', 'text')
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
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_SITE_VIEWS'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/site_views.css", ['version' => 'auto']);
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
			'a.system_name' => Text::_('COM_COMPONENTBUILDER_SITE_VIEW_SYSTEM_NAME_LABEL'),
			'a.name' => Text::_('COM_COMPONENTBUILDER_SITE_VIEW_NAME_LABEL'),
			'a.description' => Text::_('COM_COMPONENTBUILDER_SITE_VIEW_DESCRIPTION_LABEL'),
			'g.name' => Text::_('COM_COMPONENTBUILDER_SITE_VIEW_MAIN_GET_LABEL'),
			'a.context' => Text::_('COM_COMPONENTBUILDER_SITE_VIEW_CONTEXT_LABEL'),
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
