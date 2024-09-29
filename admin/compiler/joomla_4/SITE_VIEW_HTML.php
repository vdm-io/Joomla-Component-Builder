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
namespace ###NAMESPACEPREFIX###\Component\###ComponentNamespace###\Site\View\###SView###;

###SITE_VIEW_HTML_HEADER######SITE_GET_MODULE_JIMPORT###

// No direct access to this file
\defined('_JEXEC') or die;###LICENSE_LOCKED_DEFINED###

/**
 * ###Component### Html View class for the ###SView###
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The toolbar object
	 *
	 * @var    Toolbar
	 * @since  3.10.11
	 */
	public Toolbar $toolbar;

	/**
	 * The styles url array
	 *
	 * @var    array
	 * @since  3.10.11
	 */
	protected array $styles;

	/**
	 * The scripts url array
	 *
	 * @var    array
	 * @since  3.10.11
	 */
	protected array $scripts;

	/**
	 * The user object.
	 *
	 * @var    Joomla___effdaf6d_2275_425d_9f52_d4952e564d34___Power
	 * @since  3.10.11
	 */
	public Joomla___effdaf6d_2275_425d_9f52_d4952e564d34___Power $user;

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
		// get combined params of both component and menu
		$this->app ??= Factory::getApplication();
		$this->params = $this->app->getParams();
		$this->menu = $this->app->getMenu()->getActive();
		$this->styles = $this->get('Styles') ?? [];
		$this->scripts = $this->get('Scripts') ?? [];
		// get the user object
		$this->user ??= $this->getCurrentUser();###SITE_DIPLAY_METHOD###

		parent::display($tpl);
	}###SITE_EXTRA_DIPLAY_METHODS###

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{###SITE_LIBRARIES_LOADER######SITE_UIKIT_LOADER######SITE_GOOGLECHART_LOADER######SITE_FOOTABLE_LOADER######SITE_DOCUMENT_METADATA######SITE_DOCUMENT_CUSTOM_PHP###
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}###SITE_DOCUMENT_CUSTOM_CSS###
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}###SITE_DOCUMENT_CUSTOM_JS######SITE_JAVASCRIPT_FOR_BUTTONS###
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{###SITE_CUSTOM_BUTTONS###

		// set help url for this view if found
		$this->help_url = ###Component###Helper::getHelpUrl('###sview###');
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($this->help_url))
		{
			ToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}

		// now initiate the toolbar
		$this->toolbar ??= Toolbar::getInstance();
	}###SITE_GET_MODULE###

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
