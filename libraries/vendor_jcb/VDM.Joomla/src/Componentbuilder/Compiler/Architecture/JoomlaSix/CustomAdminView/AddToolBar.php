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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\CustomAdminView;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomButtons;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomAdmin\AddToolBarInterface;


/**
 * Custom Admin View Add ToolBar Class for Joomla 6
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
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.4
	 */
	protected Placeholder $placeholder;

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
	 * @param Placeholder     $placeholder     The Placeholder Class.
	 * @param ContentOne      $contentone      The ContentOne Class.
	 * @param CustomButtons   $custombuttons   The CustomButtons Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		ContentOne $contentone, CustomButtons $custombuttons)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
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

		$nameSingleCode = $settings->code ?? $settings->name_single_code ?? null;

		if (empty($nameSingleCode))
		{
			return '';
		}

		return $this->buildToolbar($view, $nameSingleCode);
	}

	/**
	 * Build the toolbar for the view.
	 *
	 * @param  array   $view            The view array containing settings.
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  The toolbar code.
	 * @since  5.1.4
	 */
	protected function buildToolbar(array $view, string $nameSingleCode): string
	{
		/** @var object $settings */
		$settings = (object) ($view['settings'] ?? []);

		$overrideToolbar = $this->placeholder->update_((string) ($settings->view_toolbar ?? ''));

		$langView = $this->config->lang_prefix . '_' . StringHelper::safe($nameSingleCode, 'U');
		$icomoon   = $view['icomoon'] ?? '';

		// Step 1: Prepare toolbar
		$toolBar = $this->initializeToolbar(
			!str_contains($overrideToolbar, "set('hidemainmenu',"),
			!str_contains($overrideToolbar, 'this->getDocument()->getToolbar(')
		);

		// Step 2: Add the title
		$toolBar  .= $this->buildTitle(
			(!str_contains($overrideToolbar, "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title(")
				&& !str_contains($overrideToolbar, "ToolbarHelper::title(")),
			$langView, $icomoon
		);

		if (empty(trim($overrideToolbar)))
		{
			// Step 3: Add custom buttons
			$toolBar .= $this->addCustomButtons($view);

			// Step 4: Add help and inline help
			$toolBar .= $this->addHelpSection($nameSingleCode);

			// Step 5: Add preferences
			$toolBar .= $this->buildPreferences();

			return $toolBar;
		}

		// Step 6: Add custom buttons
		$customButtons = $this->addCustomButtons($view);
		$placeholder = Placefix::_('CUSTOM_BUTTONS');
		if (strpos($overrideToolbar, $placeholder) !== false)
		{
			$overrideToolbar = str_replace($placeholder, $customButtons, $overrideToolbar);
		}
		else
		{
			$toolBar .= $customButtons;
		}

		// Step 7: Add override toolbar
		$toolBar .= $overrideToolbar;

		return $toolBar;
	}

	/**
	 * Initialize the toolbar.
	 *
	 * @param bool $addHideMenu The switch to add the hidemainmenu to the toolbar method.
	 * @param bool $addInit     The switch to add the initialization of the toolbar.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function initializeToolbar(bool $addHideMenu, bool $addInit): string
	{
		$toolBar = '';

		if ($addHideMenu)
		{
			$toolBar .= "\$this->input->set('hidemainmenu', true);" . PHP_EOL;
		}

		if ($addInit)
		{
			if ($addHideMenu)
			{
				$toolBar .= PHP_EOL . Indent::_(2);
			}
			$toolBar .= "/** @var Joomla__" . "_47ee1f2b_9902_4f26_a856_04930ac9ddc3___Power \$toolbar */";
			$toolBar .= PHP_EOL . Indent::_(2) . "\$toolbar = \$this->getDocument()->getToolbar();" . PHP_EOL;
		}

		return $toolBar;
	}

	/**
	 * Build the toolbar title line.
	 *
	 * @param  bool    $addTitle   The switch to add the title to the toolbar method.
	 * @param  string  $langView   The language prefix for the title.
	 * @param  string  $icomoon    The Icomoon icon name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildTitle(bool $addTitle, string $langView, string $icomoon): string
	{
		if (!$addTitle)
		{
			return '';
		}

		$toolBar =  PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__) . " set the title";
		$toolBar .= PHP_EOL . Indent::_(2) . "if (!empty(\$this->item->name))";
		$toolBar .= PHP_EOL . Indent::_(2) . "{";
		$toolBar .= PHP_EOL . Indent::_(3) . "\$title = \$this->item->name;";
		$toolBar .= PHP_EOL . Indent::_(2) . "}";
		$toolBar .= PHP_EOL . PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__) . " check for empty title to add the view name";
		$toolBar .= PHP_EOL . Indent::_(2) . "if (empty(\$title))";
		$toolBar .= PHP_EOL . Indent::_(2) . "{";
		$toolBar .= PHP_EOL . Indent::_(3) . "\$title = Joomla__"
			. "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('{$langView}');";
		$toolBar .= PHP_EOL . Indent::_(2) . "}";
		$toolBar .= PHP_EOL . PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__) . " add title to the page";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title(\$title, '{$icomoon}');";

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
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  The completed toolbar section.
	 * @since  5.1.4
	 */
	protected function addHelpSection(string $nameSingleCode): string
	{
		$toolBar = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__)
			. " set help url for this view if found";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "\$this->help_url = " . $this->contentone->get('Component') . "Helper::getHelpUrl('" . $nameSingleCode . "');";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->help_url))";
		$toolBar .= PHP_EOL . Indent::_(2) . "{";
		$toolBar .= PHP_EOL . Indent::_(3)
			. "\$toolbar->help('"
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
			. "\$toolbar->preferences('com_{$this->config->component_code_name}');" . PHP_EOL;
		$toolbar .= Indent::_(2) . "}";

		return $toolbar;
	}
}

