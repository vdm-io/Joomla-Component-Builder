<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');###LICENSE_LOCKED_DEFINED###
###ADMIN_VIEWS_HTML_HEADER###
/**
 * ###Component### View class for the ###Views###
 */
class ###Component###View###Views### extends JViewLegacy
{
	/**
	 * ###Views### view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			###Component###Helper::addSubmenu('###views###');
		}

		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();###ADMIN_DIPLAY_METHOD###
		$this->saveOrder = $this->listOrder == 'a.ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = ###Component###Helper::getActions('###view###');###JVIEWLISTCANDO###

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
		JToolBarHelper::title(JText::_('COM_###COMPONENT###_###VIEWS###'), '###ICOMOON###');
		JHtmlSidebar::setAction('index.php?option=com_###component###&view=###views###');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('###view###.add');
		}

		// Only load if there are items
		if (###Component###Helper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('###view###.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('###views###.publish');
				JToolBarHelper::unpublishList('###views###.unpublish');
				JToolBarHelper::archiveList('###views###.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('###views###.checkin');
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
			}###CUSTOM_ADMIN_DYNAMIC_BUTTONS######ADMIN_CUSTOM_BUTTONS_LIST###

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				JToolbarHelper::deleteList('', '###views###.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('###views###.trash');
			}###EXPORTBUTTON###
		}###ADMIN_CUSTOM_FUNCTION_ONLY_BUTTONS_LIST######IMPORTBUTTON###

		// set help url for this view if found
		$this->help_url = ###Component###Helper::getHelpUrl('###views###');
		if (###Component###Helper::checkString($this->help_url))
		{
				JToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_###component###');
		}###FILTERFIELDDISPLAYHELPER######BATCHDISPLAYHELPER###
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
		$this->document->setTitle(JText::_('COM_###COMPONENT###_###VIEWS###'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_###component###/assets/css/###views###.css", (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');###ADMIN_ADD_JAVASCRIPT_FILE###
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
			return ###Component###Helper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return ###Component###Helper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		###SORTFIELDS###
	}###FILTERFUNCTIONS###
}
