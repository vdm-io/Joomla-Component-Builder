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
 * Componentbuilder Html View class for the Components_routers
 */
class ComponentbuilderViewComponents_routers extends HtmlView
{
	/**
	 * Components_routers view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('components_routers');
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
		$this->listDirn = $this->escape($this->state->get('list.direction', 'DESC'));
		$this->saveOrder = $this->listOrder == 'a.ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) Uri::getInstance()));
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('component_router');
		$this->canEdit = $this->canDo->get('component_router.edit');
		$this->canState = $this->canDo->get('component_router.edit.state');
		$this->canCreate = $this->canDo->get('component_router.create');
		$this->canDelete = $this->canDo->get('component_router.delete');
		$this->canBatch = ($this->canDo->get('component_router.batch') && $this->canDo->get('core.batch'));

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
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=components_routers');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_COMPONENTS_ROUTERS'), 'joomla');
		FormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('component_router.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('component_router.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('components_routers.publish');
				ToolbarHelper::unpublishList('components_routers.unpublish');
				ToolbarHelper::archiveList('components_routers.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('components_routers.checkin');
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
				ToolbarHelper::deleteList('', 'components_routers.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('components_routers.trash');
			}
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('components_routers');
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

		// Only load Mode Constructor Before Parent batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Mode Constructor Before Parent Selection
			$this->mode_constructor_before_parentOptions = FormHelper::loadFieldType('componentsroutersfiltermodeconstructorbeforeparent')->options;
			// We do some sanitation for Mode Constructor Before Parent filter
			if (ArrayHelper::check($this->mode_constructor_before_parentOptions) &&
				isset($this->mode_constructor_before_parentOptions[0]->value) &&
				!StringHelper::check($this->mode_constructor_before_parentOptions[0]->value))
			{
				unset($this->mode_constructor_before_parentOptions[0]);
			}
			// Mode Constructor Before Parent Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_COMPONENT_ROUTER_MODE_CONSTRUCTOR_BEFORE_PARENT_LABEL').' -',
				'batch[mode_constructor_before_parent]',
				Html::_('select.options', $this->mode_constructor_before_parentOptions, 'value', 'text')
			);
		}

		// Only load Mode Constructor After Parent batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Mode Constructor After Parent Selection
			$this->mode_constructor_after_parentOptions = FormHelper::loadFieldType('componentsroutersfiltermodeconstructorafterparent')->options;
			// We do some sanitation for Mode Constructor After Parent filter
			if (ArrayHelper::check($this->mode_constructor_after_parentOptions) &&
				isset($this->mode_constructor_after_parentOptions[0]->value) &&
				!StringHelper::check($this->mode_constructor_after_parentOptions[0]->value))
			{
				unset($this->mode_constructor_after_parentOptions[0]);
			}
			// Mode Constructor After Parent Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_COMPONENT_ROUTER_MODE_CONSTRUCTOR_AFTER_PARENT_LABEL').' -',
				'batch[mode_constructor_after_parent]',
				Html::_('select.options', $this->mode_constructor_after_parentOptions, 'value', 'text')
			);
		}

		// Only load Mode Methods batch if create, edit, and batch is allowed
		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			// Set Mode Methods Selection
			$this->mode_methodsOptions = FormHelper::loadFieldType('componentsroutersfiltermodemethods')->options;
			// We do some sanitation for Mode Methods filter
			if (ArrayHelper::check($this->mode_methodsOptions) &&
				isset($this->mode_methodsOptions[0]->value) &&
				!StringHelper::check($this->mode_methodsOptions[0]->value))
			{
				unset($this->mode_methodsOptions[0]);
			}
			// Mode Methods Batch Selection
			JHtmlBatch_::addListSelection(
				'- Keep Original '.Text::_('COM_COMPONENTBUILDER_COMPONENT_ROUTER_MODE_METHODS_LABEL').' -',
				'batch[mode_methods]',
				Html::_('select.options', $this->mode_methodsOptions, 'value', 'text')
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
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_COMPONENTS_ROUTERS'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/components_routers.css", ['version' => 'auto']);
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
