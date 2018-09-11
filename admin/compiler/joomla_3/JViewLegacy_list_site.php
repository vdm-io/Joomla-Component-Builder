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
defined('_JEXEC') or die('Restricted access');###LICENSE_LOCKED_DEFINED######SITE_GET_MODULE_JIMPORT###

/**
 * ###Component### View class for the ###SViews###
 */
class ###Component###View###SViews### extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{		
		// get combined params of both component and menu
		$this->app = JFactory::getApplication();
		$this->params = $this->app->getParams();
		$this->menu = $this->app->getMenu()->getActive();
		// get the user object
		$this->user = JFactory::getUser();###SITE_DIPLAY_METHOD###
	}###SITE_EXTRA_DIPLAY_METHODS###

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{###SITE_LIBRARIES_LOADER######SITE_UIKIT_LOADER######SITE_GOOGLECHART_LOADER######SITE_FOOTABLE_LOADER######SITE_DOCUMENT_METADATA######SITE_DOCUMENT_CUSTOM_PHP###
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/components/com_###component###/assets/css/###sview###.css', (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');###SITE_DOCUMENT_CUSTOM_CSS######SITE_DOCUMENT_CUSTOM_JS######SITE_JAVASCRIPT_FOR_BUTTONS###
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// adding the joomla toolbar to the front
		JLoader::register('JToolbarHelper', JPATH_ADMINISTRATOR.'/includes/toolbar.php');###SITE_CUSTOM_BUTTONS###
		
		// set help url for this view if found
		$help_url = ###Component###Helper::getHelpUrl('###sviews###');
		if (###Component###Helper::checkString($help_url))
		{
			JToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $help_url);
		}
		// now initiate the toolbar
		$this->toolbar = JToolbar::getInstance();
	}###SITE_GET_MODULE###

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var, $sorten = false, $length = 40)
	{
		// use the helper htmlEscape method instead.
		return ###Component###Helper::htmlEscape($var, $this->_charset, $sorten, $length);
	}
}
