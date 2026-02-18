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
namespace ###NAMESPACEPREFIX###\Component\###ComponentNamespace###\Administrator\View\###SViews###;

###CUSTOM_ADMIN_VIEWS_HTML_HEADER######CUSTOM_ADMIN_GET_MODULE_JIMPORT###

// No direct access to this file
\defined('_JEXEC') or die;###LICENSE_LOCKED_DEFINED###

/**
 * ###Component### Html View class for the ###SViews###
 *
 * @since  1.6
 */
#[\AllowDynamicProperties]
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
		// get the application
		$this->app ??= Joomla___39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();
		// get input
		$this->input ??= method_exists($this->app, 'getInput') ? $this->app->getInput() : $this->app->input;
		// get component params
		$this->params ??= method_exists($this->app, 'getParams')
			? $this->app->getParams()
			: Joomla___aeb8e463_291f_4445_9ac4_34b637c12dbd___Power::getParams('com_###component###');
		// get the user object
		$this->user ??= $this->getCurrentUser();

		// get the permitted actions the current user can do.
		$this->canDo = Super___7d95ce74_53dc_4672_bd8a_3b71cdacabea___Power::get('###sview###');

		// Load module values
		$model = $this->getModel();
		$this->styles = $model->getStyles() ?? [];
		$this->scripts = $model->getScripts() ?? [];###CUSTOM_ADMIN_DIPLAY_METHOD###

		// Set the html view document stuff
		$this->_prepareDocument();

		parent::display($tpl);
	}###CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS###

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @throws  \Exception
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		###CUSTOM_ADMIN_ADDTOOLBAR###
	}

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{###CUSTOM_ADMIN_LIBRARIES_LOADER######CUSTOM_ADMIN_UIKIT_LOADER######CUSTOM_ADMIN_GOOGLECHART_LOADER######CUSTOM_ADMIN_FOOTABLE_LOADER######CUSTOM_ADMIN_DOCUMENT_CUSTOM_PHP###
		// add styles
		foreach ($this->styles as $style)
		{
			Joomla___34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('stylesheet', $style, ['version' => 'auto']);
		}###CUSTOM_ADMIN_DOCUMENT_CUSTOM_CSS###
		// add scripts
		foreach ($this->scripts as $script)
		{
			Joomla___34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('script', $script, ['version' => 'auto']);
		}###CUSTOM_ADMIN_DOCUMENT_CUSTOM_JS###
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
	}###CUSTOM_ADMIN_GET_MODULE###
}
