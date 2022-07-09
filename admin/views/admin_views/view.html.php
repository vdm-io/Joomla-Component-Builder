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

use Joomla\CMS\MVC\View\HtmlView;

/**
 * Componentbuilder Html View class for the Admin_views
 */
class ComponentbuilderViewAdmin_views extends HtmlView
{
	/**
	 * Admin_views view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('admin_views');
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
		$this->canDo = ComponentbuilderHelper::getActions('admin_view');
		$this->canEdit = $this->canDo->get('admin_view.edit');
		$this->canState = $this->canDo->get('admin_view.edit.state');
		$this->canCreate = $this->canDo->get('admin_view.create');
		$this->canDelete = $this->canDo->get('admin_view.delete');
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
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_ADMIN_VIEWS'), 'stack');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=admin_views');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('admin_view.add');
		}

		// Only load if there are items
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('admin_view.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('admin_views.publish');
				JToolBarHelper::unpublishList('admin_views.unpublish');
				JToolBarHelper::archiveList('admin_views.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('admin_views.checkin');
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
				JToolbarHelper::deleteList('', 'admin_views.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('admin_views.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('admin_view.export'))
			{
				JToolBarHelper::custom('admin_views.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}
		if ($this->user->authorise('admin_view.run_expansion', 'com_componentbuilder'))
		{
			// add Run Expansion button.
			JToolBarHelper::custom('admin_views.runExpansion', 'expand-2 custom-button-runexpansion', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('admin_view.import'))
		{
			JToolBarHelper::custom('admin_views.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('admin_views');
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

		// Only load Add Fadein batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Add Fadein Selection
			$this->add_fadeinOptions = JFormHelper::loadFieldType('adminviewsfilteraddfadein')->options;
			// We do some sanitation for Add Fadein filter
			if (ComponentbuilderHelper::checkArray($this->add_fadeinOptions) &&
				isset($this->add_fadeinOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->add_fadeinOptions[0]->value))
			{
				unset($this->add_fadeinOptions[0]);
			}
			// Add Fadein Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_ADD_FADEIN_LABEL').' -',
				'batch[add_fadein]',
				JHtml::_('select.options', $this->add_fadeinOptions, 'value', 'text')
			);
		}

		// Only load Type batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Type Selection
			$this->typeOptions = JFormHelper::loadFieldType('adminviewsfiltertype')->options;
			// We do some sanitation for Type filter
			if (ComponentbuilderHelper::checkArray($this->typeOptions) &&
				isset($this->typeOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->typeOptions[0]->value))
			{
				unset($this->typeOptions[0]);
			}
			// Type Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_TYPE_LABEL').' -',
				'batch[type]',
				JHtml::_('select.options', $this->typeOptions, 'value', 'text')
			);
		}

		// Only load Add Custom Button batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Add Custom Button Selection
			$this->add_custom_buttonOptions = JFormHelper::loadFieldType('adminviewsfilteraddcustombutton')->options;
			// We do some sanitation for Add Custom Button filter
			if (ComponentbuilderHelper::checkArray($this->add_custom_buttonOptions) &&
				isset($this->add_custom_buttonOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->add_custom_buttonOptions[0]->value))
			{
				unset($this->add_custom_buttonOptions[0]);
			}
			// Add Custom Button Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_ADD_CUSTOM_BUTTON_LABEL').' -',
				'batch[add_custom_button]',
				JHtml::_('select.options', $this->add_custom_buttonOptions, 'value', 'text')
			);
		}

		// Only load Add Php Ajax batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Add Php Ajax Selection
			$this->add_php_ajaxOptions = JFormHelper::loadFieldType('adminviewsfilteraddphpajax')->options;
			// We do some sanitation for Add Php Ajax filter
			if (ComponentbuilderHelper::checkArray($this->add_php_ajaxOptions) &&
				isset($this->add_php_ajaxOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->add_php_ajaxOptions[0]->value))
			{
				unset($this->add_php_ajaxOptions[0]);
			}
			// Add Php Ajax Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_ADD_PHP_AJAX_LABEL').' -',
				'batch[add_php_ajax]',
				JHtml::_('select.options', $this->add_php_ajaxOptions, 'value', 'text')
			);
		}

		// Only load Add Custom Import batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Add Custom Import Selection
			$this->add_custom_importOptions = JFormHelper::loadFieldType('adminviewsfilteraddcustomimport')->options;
			// We do some sanitation for Add Custom Import filter
			if (ComponentbuilderHelper::checkArray($this->add_custom_importOptions) &&
				isset($this->add_custom_importOptions[0]->value) &&
				!ComponentbuilderHelper::checkString($this->add_custom_importOptions[0]->value))
			{
				unset($this->add_custom_importOptions[0]);
			}
			// Add Custom Import Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_ADD_CUSTOM_IMPORT_LABEL').' -',
				'batch[add_custom_import]',
				JHtml::_('select.options', $this->add_custom_importOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_ADMIN_VIEWS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/admin_views.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.system_name' => JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_SYSTEM_NAME_LABEL'),
			'a.name_single' => JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_NAME_SINGLE_LABEL'),
			'a.short_description' => JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_SHORT_DESCRIPTION_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
