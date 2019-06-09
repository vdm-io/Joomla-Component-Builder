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
 * Componentbuilder View class for the Snippets
 */
class ComponentbuilderViewSnippets extends JViewLegacy
{
	/**
	 * Snippets view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('snippets');
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
		$this->canDo = ComponentbuilderHelper::getActions('snippet');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
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
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_SNIPPETS'), 'pin');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=snippets');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('snippet.add');
		}

		// Only load if there are items
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('snippet.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('snippets.publish');
				JToolBarHelper::unpublishList('snippets.unpublish');
				JToolBarHelper::archiveList('snippets.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('snippets.checkin');
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
			if ($this->user->authorise('snippet.share_snippets', 'com_componentbuilder'))
			{
				// add Share Snippets button.
				JToolBarHelper::custom('snippets.shareSnippets', 'share', '', 'COM_COMPONENTBUILDER_SHARE_SNIPPETS', 'true');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				JToolbarHelper::deleteList('', 'snippets.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('snippets.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('snippet.export'))
			{
				JToolBarHelper::custom('snippets.exportData', 'download', '', 'COM_COMPONENTBUILDER_EXPORT_DATA', true);
			}
		}
		if ($this->user->authorise('snippet.get_snippets', 'com_componentbuilder'))
		{
			// add Get Snippets button.
			JToolBarHelper::custom('snippets.getSnippets', 'search', '', 'COM_COMPONENTBUILDER_GET_SNIPPETS', false);
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('snippet.import'))
		{
			JToolBarHelper::custom('snippets.importData', 'upload', '', 'COM_COMPONENTBUILDER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('snippets');
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

		// Set Type Name Selection
		$this->typeNameOptions = JFormHelper::loadFieldType('Snippettype')->options;
		// We do some sanitation for Type Name filter
		if (ComponentbuilderHelper::checkArray($this->typeNameOptions) &&
			isset($this->typeNameOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->typeNameOptions[0]->value))
		{
			unset($this->typeNameOptions[0]);
		}
		// Only load Type Name filter if it has values
		if (ComponentbuilderHelper::checkArray($this->typeNameOptions))
		{
			// Type Name Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_SNIPPET_TYPE_LABEL').' -',
				'filter_type',
				JHtml::_('select.options', $this->typeNameOptions, 'value', 'text', $this->state->get('filter.type'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Type Name Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_SNIPPET_TYPE_LABEL').' -',
					'batch[type]',
					JHtml::_('select.options', $this->typeNameOptions, 'value', 'text')
				);
			}
		}

		// Set Library Name Selection
		$this->libraryNameOptions = JFormHelper::loadFieldType('Library')->options;
		// We do some sanitation for Library Name filter
		if (ComponentbuilderHelper::checkArray($this->libraryNameOptions) &&
			isset($this->libraryNameOptions[0]->value) &&
			!ComponentbuilderHelper::checkString($this->libraryNameOptions[0]->value))
		{
			unset($this->libraryNameOptions[0]);
		}
		// Only load Library Name filter if it has values
		if (ComponentbuilderHelper::checkArray($this->libraryNameOptions))
		{
			// Library Name Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_COMPONENTBUILDER_SNIPPET_LIBRARY_LABEL').' -',
				'filter_library',
				JHtml::_('select.options', $this->libraryNameOptions, 'value', 'text', $this->state->get('filter.library'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Library Name Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_COMPONENTBUILDER_SNIPPET_LIBRARY_LABEL').' -',
					'batch[library]',
					JHtml::_('select.options', $this->libraryNameOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_COMPONENTBUILDER_SNIPPETS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/snippets.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			'a.name' => JText::_('COM_COMPONENTBUILDER_SNIPPET_NAME_LABEL'),
			'a.url' => JText::_('COM_COMPONENTBUILDER_SNIPPET_URL_LABEL'),
			'g.name' => JText::_('COM_COMPONENTBUILDER_SNIPPET_TYPE_LABEL'),
			'a.heading' => JText::_('COM_COMPONENTBUILDER_SNIPPET_HEADING_LABEL'),
			'h.name' => JText::_('COM_COMPONENTBUILDER_SNIPPET_LIBRARY_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
