<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this JCB template file (EVER)
defined('_JCB_TEMPLATE') or die;
?>
###BOM###
namespace ###NAMESPACEPREFIX###\Component\###ComponentNameSpace###\Administrator\View\###Views###;

###ADMIN_VIEWS_HTML_HEADER###

// No direct access to this file
\defined('_JEXEC') or die;###LICENSE_LOCKED_DEFINED###

/**
 * ###Component### Html View class for the ###Views###
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * ###Views### view display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @since  1.6
	 */
	public function display($tpl = null)
	{
		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->styles = $this->get('Styles');
		$this->scripts = $this->get('Scripts');
		$this->user ??= Factory::getApplication()->getIdentity();###ADMIN_DIPLAY_METHOD###
		$this->saveOrder = $this->listOrder == 'a.ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) Uri::getInstance()));
		// get global action permissions
		$this->canDo = ###Component###Helper::getActions('###view###');###JVIEWLISTCANDO###

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
		ToolbarHelper::title(Text::_('COM_###COMPONENT###_###VIEWS###'), '###ICOMOON###');

		if ($this->canCreate)
		{
			ToolbarHelper::addNew('###view###.add');
		}

		// Only load if there are items
		if (Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($this->items))
		{
			if ($this->canEdit)
			{
				ToolbarHelper::editList('###view###.edit');
			}

			if ($this->canState)
			{
				ToolbarHelper::publishList('###views###.publish');
				ToolbarHelper::unpublishList('###views###.unpublish');
				ToolbarHelper::archiveList('###views###.archive');

				if ($this->canDo->get('core.admin'))
				{
					ToolbarHelper::checkin('###views###.checkin');
				}
			}###CUSTOM_ADMIN_DYNAMIC_BUTTONS######ADMIN_CUSTOM_BUTTONS_LIST###

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				ToolbarHelper::deleteList('', '###views###.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				ToolbarHelper::trash('###views###.trash');
			}###EXPORTBUTTON###
		}###ADMIN_CUSTOM_FUNCTION_ONLY_BUTTONS_LIST######IMPORTBUTTON###

		// set help url for this view if found
		$this->help_url = ###Component###Helper::getHelpUrl('###views###');
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($this->help_url))
		{
			ToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_###component###');
		}###FILTERFIELDDISPLAYHELPER######BATCHDISPLAYHELPER###
	}

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{###JQUERY###
		$this->getDocument()->setTitle(Text::_('COM_###COMPONENT###_###VIEWS###'));
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}###ADMIN_ADD_JAVASCRIPT_FILE###
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

		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array   containing the field name to sort by as the key and display text as value
	 * @since   1.6
	 */
	protected function getSortFields()
	{
		###SORTFIELDS###
	}###FILTERFUNCTIONS###
}
