<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\CustomAdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomButtons;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomAdmin\AddToolBarInterface;


/**
 * Custom Admin Views Add ToolBar Class for Joomla 4
 * 
 * @since 5.1.4
 */
final class AddToolBar implements AddToolBarInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.4
	 */
	protected Config $config;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.4
	 */
	protected ContentOne $contentone;

	/**
	 * The CustomButtons Class.
	 *
	 * @var   CustomButtons
	 * @since 5.1.4
	 */
	protected CustomButtons $custombuttons;

	/**
	 * Constructor.
	 *
	 * @param Config          $config          The Config Class.
	 * @param ContentOne      $contentone      The ContentOne Class.
	 * @param CustomButtons   $custombuttons   The CustomButtons Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, ContentOne $contentone,
		CustomButtons $custombuttons)
	{
		$this->config = $config;
		$this->contentone = $contentone;
		$this->custombuttons = $custombuttons;
	}

	/**
	 * Build and return the toolbar configuration code for the given view.
	 *
	 * @param  array  $view  The view configuration array, including settings and description.
	 *
	 * @return string  The generated PHP toolbar code.
	 * @since  5.1.4
	 */
	public function get(array $view): string
	{
		/** @var object $settings */
		$settings = (object) ($view['settings'] ?? []);

		$nameListCode = $settings->code ?? $settings->name_list_code ?? null;

		if (empty($nameListCode))
		{
			return '';
		}

		return $this->buildToolbar($view, $nameListCode);
	}

	/**
	 * Build the toolbar for the view.
	 *
	 * @param  array   $view          The view array containing settings.
	 * @param  string  $nameListCode  The list item code name.
	 *
	 * @return string  The toolbar code.
	 * @since  5.1.4
	 */
	protected function buildToolbar(array $view, string $nameListCode): string
	{
		$langViews = $this->config->lang_prefix . '_' . StringHelper::safe($nameListCode, 'U');
		$icomoon   = $view['icomoon'] ?? '';

		// Step 1: Prepare toolbar
		$toolBar = $this->initializeToolbar();

		// Step 2: Add the title
		$toolBar  .= $this->buildTitle($langViews, $icomoon);

		// Step 3: Add custom buttons
		$toolBar .= $this->addCustomButtons($view);

		// Step 4: Add help and inline help
		$toolBar .= $this->addHelpSection($nameListCode);

		// Step 5: Add preferences
		$toolBar .= $this->buildPreferences();

		return $toolBar;
	}

	/**
	 * Initialize the toolbar.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function initializeToolbar(): string
	{
		return "\$this->input->set('hidemainmenu', true);" . PHP_EOL;
	}

	/**
	 * Build the toolbar title line.
	 *
	 * @param  string  $langViews   The language prefix for the title.
	 * @param  string  $icomoon    The Icomoon icon name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildTitle(string $langViews, string $icomoon): string
	{
		$toolBar = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__) . " add title to the page";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title(Joomla__"
			. "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('{$langViews}'), '{$icomoon}');";

		return $toolBar;
	}

	/**
	 * Add custom buttons and finalize main action group.
	 *
	 * @param  array   $view            The view data.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function addCustomButtons(array $view): string
	{
		return $this->custombuttons->get($view);
	}

	/**
	 * Append inline help, and contextual help links.
	 *
	 * @param  string  $nameListCode  The single item code name.
	 *
	 * @return string  The completed toolbar section.
	 * @since  5.1.4
	 */
	protected function addHelpSection(string $nameListCode): string
	{
		$toolBar = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__)
			. " set help url for this view if found";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "\$this->help_url = " . $this->contentone->get('Component') . "Helper::getHelpUrl('" . $nameListCode . "');";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->help_url))";
		$toolBar .= PHP_EOL . Indent::_(2) . "{";
		$toolBar .= PHP_EOL . Indent::_(3)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::help('"
			. $this->config->lang_prefix . "_HELP_MANAGER', false, \$this->help_url);";
		$toolBar .= PHP_EOL . Indent::_(2) . "}" . PHP_EOL;

		return $toolBar;
	}

	/**
	 * Build preferences toolbar items.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildPreferences(): string
	{
		$toolbar = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " add the options comp button" . PHP_EOL;
		$toolbar .= Indent::_(2)
			. "if (\$this->canDo->get('core.admin') || \$this->canDo->get('core.options'))" . PHP_EOL;
		$toolbar .= Indent::_(2) . "{" . PHP_EOL;
		$toolbar .= Indent::_(3)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::preferences('com_{$this->config->component_code_name}');" . PHP_EOL;
		$toolbar .= Indent::_(2) . "}";

		return $toolbar;
	}
}

