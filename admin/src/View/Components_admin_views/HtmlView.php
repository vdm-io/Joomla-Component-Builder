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
namespace VDM\Component\Componentbuilder\Administrator\View\Components_admin_views;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\User\User;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Document\Document;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Html View class for the Components_admin_views
 *
 * @since  1.6
 */
#[\AllowDynamicProperties]
class HtmlView extends BaseHtmlView
{
	/**
	 * The items from the model
	 *
	 * @var    mixed
	 * @since  3.10.11
	 */
	public mixed $items;

	/**
	 * The state object
	 *
	 * @var    mixed
	 * @since  3.10.11
	 */
	public mixed $state;

	/**
	 * The styles url array
	 *
	 * @var    array
	 * @since  5.0.0
	 */
	protected array $styles;

	/**
	 * The scripts url array
	 *
	 * @var    array
	 * @since  5.0.0
	 */
	protected array $scripts;

	/**
	 * The actions object
	 *
	 * @var    object
	 * @since  3.10.11
	 */
	public object $canDo;

	/**
	 * The return here base64 url
	 *
	 * @var    string
	 * @since  3.10.11
	 */
	public string $return_here;

	/**
	 * The user object.
	 *
	 * @var    User
	 * @since  3.10.11
	 */
	public User $user;

	/**
	 * Components_admin_views view display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @throws \Exception
	 * @since  1.6
	 */
	public function display($tpl = null): void
	{
		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->styles = $this->get('Styles');
		$this->scripts = $this->get('Scripts');
		$this->user ??= $this->getCurrentUser();
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
		$this->canDo = ComponentbuilderHelper::getActions('component_admin_views');
		$this->canEdit = $this->canDo->get('component_admin_views.edit');
		$this->canState = $this->canDo->get('component_admin_views.edit.state');
		$this->canCreate = $this->canDo->get('component_admin_views.create');
		$this->canDelete = $this->canDo->get('component_admin_views.delete');
		$this->canBatch = ($this->canDo->get('component_admin_views.batch') && $this->canDo->get('core.batch'));

		// If we don't have items we load the empty state
		if (is_array($this->items) && !count((array) $this->items) && $this->isEmptyState = $this->get('IsEmptyState'))
		{
			$this->setLayout('emptystate');
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \Exception(implode("\n", $errors), 500);
		}

		// Set the html view document stuff
		$this->_prepareDocument();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_COMPONENTS_ADMIN_VIEWS'), 'joomla');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('component_admin_views.add');
		}

		// Only load if there are items
		if (ArrayHelper::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('component_admin_views.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('components_admin_views.publish');
				ToolbarHelper::unpublishList('components_admin_views.unpublish');
				ToolbarHelper::archiveList('components_admin_views.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('components_admin_views.checkin');
				}
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				ToolbarHelper::deleteList('', 'components_admin_views.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('components_admin_views.trash');
			}
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('components_admin_views');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_componentbuilder');
		}
	}

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{
		// Load jQuery
		Html::_('jquery.framework');
		$this->getDocument()->setTitle(Text::_('COM_COMPONENTBUILDER_COMPONENTS_ADMIN_VIEWS'));
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var     The output to escape.
	 * @param   bool   $shorten The switch to shorten.
	 * @param   int    $length  The shorting length.
	 *
	 * @return  mixed  The escaped value.
	 * @since   1.6
	 */
	public function escape($var, bool $shorten = true, int $length = 50)
	{
		if (!is_string($var))
		{
			return $var;
		}

		return StringHelper::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array   containing the field name to sort by as the key and display text as value
	 * @since   1.6
	 */
	protected function getSortFields()
	{
		return array(
			'a.ordering' => Text::_('JGRID_HEADING_ORDERING'),
			'a.published' => Text::_('JSTATUS'),
			'a.id' => Text::_('JGRID_HEADING_ID')
		);
	}
}
