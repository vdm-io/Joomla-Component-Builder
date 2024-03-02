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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); ###LICENSE_LOCKED_DEFINED###

###CUSTOM_ADMIN_VIEW_HTML_HEADER######CUSTOM_ADMIN_GET_MODULE_JIMPORT###

/**
 * ###Component### Html View class for the ###SView###
 */
class ###Component###View###SView### extends HtmlView
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = ComponentHelper::getParams('com_###component###');
		// get the application
		$this->app = Factory::getApplication();
		// get the user object
		$this->user = Factory::getUser();
		// get global action permissions
		$this->canDo = ###Component###Helper::getActions('###sview###');###CUSTOM_ADMIN_DIPLAY_METHOD###
	}###CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS###

	/**
	 * Prepares the document
	 */
	protected function setDocument()
	{###CUSTOM_ADMIN_LIBRARIES_LOADER######CUSTOM_ADMIN_DOCUMENT_METADATA######CUSTOM_ADMIN_UIKIT_LOADER######CUSTOM_ADMIN_GOOGLECHART_LOADER######CUSTOM_ADMIN_FOOTABLE_LOADER######CUSTOM_ADMIN_DOCUMENT_CUSTOM_PHP###
		// add the document default css file
		Html::_('stylesheet', 'administrator/components/com_###component###/assets/css/###sview###.css', ['version' => 'auto']);###CUSTOM_ADMIN_DOCUMENT_CUSTOM_CSS######CUSTOM_ADMIN_DOCUMENT_CUSTOM_JS###
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
			$title = Text::_('COM_###COMPONENT###_###SVIEW###');
		}
		// add title to the page
		ToolbarHelper::title($title,'###ICOMOON###');###CUSTOM_ADMIN_CUSTOM_BUTTONS###

		// set help url for this view if found
		$this->help_url = ###Component###Helper::getHelpUrl('###sviews###');
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($this->help_url))
		{
			ToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_###component###');
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
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($var, $this->_charset);
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
?>
