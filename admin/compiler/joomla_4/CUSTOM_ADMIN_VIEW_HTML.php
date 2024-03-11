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
namespace ###NAMESPACEPREFIX###\Component\###ComponentNamespace###\Administrator\View\###SView###;

###CUSTOM_ADMIN_VIEW_HTML_HEADER######CUSTOM_ADMIN_GET_MODULE_JIMPORT###

// No direct access to this file
\defined('_JEXEC') or die; ###LICENSE_LOCKED_DEFINED###

/**
 * ###Component### Html View class for the ###SView###
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @since  1.6
	 */
	public function display($tpl = null)
	{
		// get component params
		$this->params = ComponentHelper::getParams('com_###component###');
		// get the application
		$this->app ??= Factory::getApplication();
		// get the user object
		$this->user ??= Factory::getApplication()->getIdentity();
		// get global action permissions
		$this->canDo = ###Component###Helper::getActions('###sview###');
		$this->styles = $this->get('Styles');
		$this->scripts = $this->get('Scripts');###CUSTOM_ADMIN_DIPLAY_METHOD###

		// Set the html view document stuff
		$this->_prepareDocument();
	}###CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS###

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{###CUSTOM_ADMIN_LIBRARIES_LOADER######CUSTOM_ADMIN_DOCUMENT_METADATA######CUSTOM_ADMIN_UIKIT_LOADER######CUSTOM_ADMIN_GOOGLECHART_LOADER######CUSTOM_ADMIN_FOOTABLE_LOADER######CUSTOM_ADMIN_DOCUMENT_CUSTOM_PHP###
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}###CUSTOM_ADMIN_DOCUMENT_CUSTOM_CSS###
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}###CUSTOM_ADMIN_DOCUMENT_CUSTOM_JS###
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
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
	 * @param   mixed  $var     The output to escape.
	 * @param   bool   $shorten The switch to shorten.
	 * @param   int    $length  The shorting length.
	 *
	 * @return  mixed  The escaped value.
	 * @since   1.6
	 */
	public function escape($var, bool $shorten = false, int $length = 40)
	{
		if (!is_string($var))
		{
			return $var;
		}

		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}
}
