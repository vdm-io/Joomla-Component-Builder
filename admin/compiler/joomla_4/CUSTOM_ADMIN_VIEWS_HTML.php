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
	 * @throws \Exception
	 * @since  1.6
	 */
	public function display($tpl = null): void
	{
		// get component params
		$this->params = Joomla___aeb8e463_291f_4445_9ac4_34b637c12dbd___Power::getParams('com_###component###');
		// get the application
		$this->app ??= Joomla___39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();
		// get the user object
		$this->user ??= $this->getCurrentUser();
		// get global action permissions
		$this->canDo = ###Component###Helper::getActions('###sview###');
		$this->styles = $this->get('Styles') ?? [];
		$this->scripts = $this->get('Scripts') ?? [];###CUSTOM_ADMIN_DIPLAY_METHOD###

		// Set the html view document stuff
		$this->_prepareDocument();

		parent::display($tpl);
	}###CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS###

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
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{###HIDEMAINMENU###
		// add title to the page
		Joomla___0c1a176a_304f_433a_8233_37d01ff87815___Power::title(Joomla___ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('COM_###COMPONENT###_###SVIEWS###'),'###ICOMOON###');###CUSTOM_ADMIN_CUSTOM_BUTTONS###

		// set help url for this view if found
		$this->help_url = ###Component###Helper::getHelpUrl('###sviews###');
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($this->help_url))
		{
			Joomla___0c1a176a_304f_433a_8233_37d01ff87815___Power::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			Joomla___0c1a176a_304f_433a_8233_37d01ff87815___Power::preferences('com_###component###');
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
