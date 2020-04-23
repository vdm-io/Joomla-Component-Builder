<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); ###LICENSE_LOCKED_DEFINED######CUSTOM_ADMIN_GET_MODULE_JIMPORT###

/**
 * ###Component### View class for the ###SView###
 */
class ###Component###View###SView### extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = JComponentHelper::getParams('com_###component###');
		// get the application
		$this->app = JFactory::getApplication();
		// get the user object
		$this->user = JFactory::getUser();
		// get global action permissions
		$this->canDo = ###Component###Helper::getActions('###sview###');###CUSTOM_ADMIN_DIPLAY_METHOD###
	}###CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS###

	/**
	 * Prepares the document
	 */
	protected function setDocument()
	{###CUSTOM_ADMIN_LIBRARIES_LOADER######CUSTOM_ADMIN_DOCUMENT_METADATA######CUSTOM_ADMIN_UIKIT_LOADER######CUSTOM_ADMIN_GOOGLECHART_LOADER######CUSTOM_ADMIN_FOOTABLE_LOADER######CUSTOM_ADMIN_DOCUMENT_CUSTOM_PHP###
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_###component###/assets/css/###sview###.css', (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');###CUSTOM_ADMIN_DOCUMENT_CUSTOM_CSS######CUSTOM_ADMIN_DOCUMENT_CUSTOM_JS###
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{###HIDEMAINMENU###
		// set the title
		if (isset($this->item->name) && $this->item->name)
		{
			$title = $this->item->name;
		}
		// Check for empty title and add view name if param is set
		if (empty($title))
		{
			$title = JText::_('COM_###COMPONENT###_###SVIEW###');
		}
		// add title to the page
		JToolbarHelper::title($title,'###ICOMOON###');###CUSTOM_ADMIN_CUSTOM_BUTTONS###

		// set help url for this view if found
		$help_url = ###Component###Helper::getHelpUrl('###sviews###');
		if (###Component###Helper::checkString($help_url))
		{
			JToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_###component###');
		}
	}###CUSTOM_ADMIN_GET_MODULE###

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		// use the helper htmlEscape method instead.
		return ###Component###Helper::htmlEscape($var, $this->_charset);
	}
}
?>
