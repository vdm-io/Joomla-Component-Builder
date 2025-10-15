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
	 * The app class
	 *
	 * @var    Joomla___a6ee04f5_33c7_4a9b_aa6d_6a03f3715a88___Power
	 * @since  5.2.1
	 */
	public Joomla___a6ee04f5_33c7_4a9b_aa6d_6a03f3715a88___Power $app;

	/**
	 * The input class
	 *
	 * @var    Joomla___59106b64_dd51_4280_be0a_1b9b9ebb7161___Power
	 * @since  5.2.1
	 */
	public Joomla___59106b64_dd51_4280_be0a_1b9b9ebb7161___Power $input;

	/**
	 * The params registry
	 *
	 * @var    Joomla___a87c432d_b5b4_428e_b7ff_14b51664c624___Power
	 * @since  5.2.1
	 */
	public Joomla___a87c432d_b5b4_428e_b7ff_14b51664c624___Power $params;

	/**
	 * The user object.
	 *
	 * @var    Joomla___effdaf6d_2275_425d_9f52_d4952e564d34___Power
	 * @since  3.10.11
	 */
	public Joomla___effdaf6d_2275_425d_9f52_d4952e564d34___Power $user;

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
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @throws \Exception
	 * @since  1.6
	 */
	public function display($tpl = null): void
	{
		// get application
		$this->app ??= Joomla___39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();
		// get input
		$this->input ??= method_exists($this->app, 'getInput') ? $this->app->getInput() : $this->app->input;
		// set params
		$this->params ??= method_exists($this->app, 'getParams')
			? $this->app->getParams()
			: Joomla___aeb8e463_291f_4445_9ac4_34b637c12dbd___Power::getParams('com_###component###');
		$this->menu = $this->app->getMenu()->getActive();
		// get the user object
		$this->user ??= $this->getCurrentUser();
		// Load module values
		$model = $this->getModel();
		$this->styles = $model->getStyles() ?? [];
		$this->scripts = $model->getScripts() ?? [];###SITE_DIPLAY_METHOD###

		parent::display($tpl);
	}###SITE_EXTRA_DIPLAY_METHODS###

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
			Joomla___0c1a176a_304f_433a_8233_37d01ff87815___Power::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}

		// add the toolbar if it's not already loaded
		$this->toolbar ??= $this->getDocument()->getToolbar();
	}

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
			Joomla___34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('stylesheet', $style, ['version' => 'auto']);
		}###SITE_DOCUMENT_CUSTOM_CSS###
		// add scripts
		foreach ($this->scripts as $script)
		{
			Joomla___34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('script', $script, ['version' => 'auto']);
		}###SITE_DOCUMENT_CUSTOM_JS######SITE_JAVASCRIPT_FOR_BUTTONS###
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
	public function escape($var, bool $shorten = false, int $length = 40)
	{
		if (!is_string($var))
		{
			return $var;
		}

		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}###SITE_GET_MODULE###
}
