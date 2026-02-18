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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ToolbarComposer;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\DynamicButtons;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomButtons;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OnlyFunctionButtons;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\AddToolBarInterface;


/**
 * Views Add ToolBar Class for Joomla 5
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
	 * The ToolbarComposer Class.
	 *
	 * @var   ToolbarComposer
	 * @since 5.1.4
	 */
	protected ToolbarComposer $toolbarcomposer;

	/**
	 * The DynamicButtons Class.
	 *
	 * @var   DynamicButtons
	 * @since 5.1.4
	 */
	protected DynamicButtons $dynamicbuttons;

	/**
	 * The CustomButtons Class.
	 *
	 * @var   CustomButtons
	 * @since 5.1.4
	 */
	protected CustomButtons $custombuttons;

	/**
	 * The OnlyFunctionButtons Class.
	 *
	 * @var   OnlyFunctionButtons
	 * @since 5.1.4
	 */
	protected OnlyFunctionButtons $onlyfunctionbuttons;

	/**
	 * Constructor.
	 *
	 * @param Config                $config                The Config Class.
	 * @param Placeholder           $placeholder           The Placeholder Class.
	 * @param ContentOne            $contentone            The ContentOne Class.
	 * @param ToolbarComposer       $toolbarcomposer       The ToolbarComposer Class.
	 * @param DynamicButtons        $dynamicbuttons        The DynamicButtons Class.
	 * @param CustomButtons         $custombuttons         The CustomButtons Class.
	 * @param OnlyFunctionButtons   $onlyfunctionbuttons   The OnlyFunctionButtons Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		ContentOne $contentone, ToolbarComposer $toolbarcomposer,
		DynamicButtons $dynamicbuttons,
		CustomButtons $custombuttons,
		OnlyFunctionButtons $onlyfunctionbuttons)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->contentone = $contentone;
		$this->toolbarcomposer = $toolbarcomposer;
		$this->dynamicbuttons = $dynamicbuttons;
		$this->custombuttons = $custombuttons;
		$this->onlyfunctionbuttons = $onlyfunctionbuttons;
	}

	/**
	 * Build and return the toolbar configuration code for the given views (list view).
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

		$nameSingleCode = $settings->name_single_code ?? null;
		$nameListCode   = $settings->name_list_code ?? null;

		if (empty($nameSingleCode) || empty($nameListCode))
		{
			return '';
		}

		$langViews = $this->config->lang_prefix . '_' . StringHelper::safe($nameListCode, 'U');
		$icomoon = $view['icomoon'] ?? '';

		$overrideToolbar = $this->placeholder->update_((string) ($settings->views_toolbar ?? ''));

		$toolBar = '';

		if ((!str_contains($overrideToolbar, "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title(")
			&& !str_contains($overrideToolbar, "ToolbarHelper::title(")))
		{
			$toolBar .= $this->buildTitle($langViews, $icomoon);
		}

		if (!str_contains($overrideToolbar, 'this->getDocument()->getToolbar('))
		{
			$toolBar .= $this->buildGetToolbar();
		}

		if (empty(trim($overrideToolbar)))
		{
			$toolBar .= $this->buildCreateButton($nameSingleCode);
			$toolBar .= $this->buildStateEditDeleteDropdown($nameSingleCode, $nameListCode, $view);
			$toolBar .= $this->buildFunctionButtons($nameListCode);
			$toolBar .= $this->buildHelpAndPreferences($nameListCode);

			return $toolBar;
		}

		$toolBar .= $overrideToolbar;

		return $this->toolbarcomposer->build(
			$toolBar,
			$this->dynamicbuttons->get($nameListCode),
			$this->custombuttons->get($view, 3, Indent::_(1)),
			$this->onlyfunctionbuttons->get($nameListCode, '')
		);
	}

	/**
	 * Build the toolbar title line.
	 *
	 * @param  string  $langViews  The language prefix for the title.
	 * @param  string  $icomoon    The Icomoon icon name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildTitle(string $langViews, string $icomoon): string
	{
		return "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title(Joomla__"
			. "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('{$langViews}'), '{$icomoon}');";
	}

	/**
	 * Build the get toolbar from document.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildGetToolbar(): string
	{
		$toolBar  = PHP_EOL . Indent::_(2)
			. "/** @var  Joomla__" . "_47ee1f2b_9902_4f26_a856_04930ac9ddc3___Power \$toolbar */";
		$toolBar .= PHP_EOL . Indent::_(2) . "\$toolbar = \$this->getDocument()->getToolbar();";

		return $toolBar;
	}

	/**
	 * Build the add new button if user can create.
	 *
	 * @param  string  $nameSingleCode  The single view name code.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildCreateButton(string $nameSingleCode): string
	{
		$code  = PHP_EOL . Indent::_(2) . "if (\$this->canCreate)" . PHP_EOL;
		$code .= Indent::_(2) . "{" . PHP_EOL;
		$code .= Indent::_(3) . "\$toolbar->addNew('{$nameSingleCode}.add');" . PHP_EOL;
		$code .= Indent::_(2) . "}" . PHP_EOL;

		return $code;
	}

	/**
	 * Build the Joomla 5 dropdown with edit/state and trash/delete actions.
	 *
	 * @param  string  $nameSingleCode  The single item code.
	 * @param  string  $nameListCode    The list view code.
	 * @param  array   $view            The view configuration.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildStateEditDeleteDropdown(string $nameSingleCode, string $nameListCode, array $view): string
	{
		$toolBar  = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " Only load if there are items" . PHP_EOL;
		$toolBar .= Indent::_(2) . "if (!\$this->isEmptyState)" . PHP_EOL;
		$toolBar .= Indent::_(2) . "{" . PHP_EOL;
		$toolBar .= Indent::_(3) . "/** @var  Joomla__" . "_f5a65880_6185_4f43_8d55_770616692a40___Power \$dropdown */" . PHP_EOL;
		$toolBar .= Indent::_(3) . "\$dropdown = \$toolbar->dropdownButton('status-group')" . PHP_EOL;
		$toolBar .= Indent::_(4) . "->text('JTOOLBAR_CHANGE_STATUS')" . PHP_EOL;
		$toolBar .= Indent::_(4) . "->toggleSplit(false)" . PHP_EOL;
		$toolBar .= Indent::_(4) . "->icon('icon-ellipsis-h')" . PHP_EOL;
		$toolBar .= Indent::_(4) . "->buttonClass('btn btn-action')" . PHP_EOL;
		$toolBar .= Indent::_(4) . "->listCheck(true);" . PHP_EOL;

		$toolBar .= PHP_EOL . Indent::_(3) . "\$childBar = \$dropdown->getChildToolbar();" . PHP_EOL;

		// Edit
		$toolBar .= PHP_EOL . Indent::_(3) . "if (\$this->canEdit)" . PHP_EOL;
		$toolBar .= Indent::_(3) . "{" . PHP_EOL;
		$toolBar .= Indent::_(4) . "\$childBar->edit('{$nameSingleCode}.edit')->listCheck(true);" . PHP_EOL;
		$toolBar .= Indent::_(3) . "}" . PHP_EOL;

		// State
		$toolBar .= PHP_EOL . Indent::_(3) . "if (\$this->canState)" . PHP_EOL;
		$toolBar .= Indent::_(3) . "{" . PHP_EOL;
		$toolBar .= Indent::_(4) . "\$childBar->publish('{$nameListCode}.publish')->listCheck(true);" . PHP_EOL;
		$toolBar .= Indent::_(4) . "\$childBar->unpublish('{$nameListCode}.unpublish')->listCheck(true);" . PHP_EOL;
		$toolBar .= Indent::_(4) . "\$childBar->archive('{$nameListCode}.archive')->listCheck(true);" . PHP_EOL;

		// Check-in for admins
		$toolBar .= PHP_EOL . Indent::_(4) . "if (\$this->canDo->get('core.admin'))" . PHP_EOL;
		$toolBar .= Indent::_(4) . "{" . PHP_EOL;
		$toolBar .= Indent::_(5) . "\$childBar->checkin('{$nameListCode}.checkin')->listCheck(true);" . PHP_EOL;
		$toolBar .= Indent::_(4) . "}" . PHP_EOL;

		// Trash/Delete
		$toolBar .= PHP_EOL . Indent::_(4) . "if (\$this->state->get('filter.published') == -2 && \$this->canDelete)" . PHP_EOL;
		$toolBar .= Indent::_(4) . "{" . PHP_EOL;
		$toolBar .= Indent::_(5) . "\$toolbar->delete('{$nameListCode}.delete', 'JTOOLBAR_DELETE_FROM_TRASH')" . PHP_EOL;
		$toolBar .= Indent::_(6) . "->message('JGLOBAL_CONFIRM_DELETE')" . PHP_EOL;
		$toolBar .= Indent::_(6) . "->listCheck(true);" . PHP_EOL;
		$toolBar .= Indent::_(4) . "}" . PHP_EOL;
		$toolBar .= Indent::_(4) . "elseif (\$this->canDelete)" . PHP_EOL;
		$toolBar .= Indent::_(4) . "{" . PHP_EOL;
		$toolBar .= Indent::_(5) . "\$childBar->trash('{$nameListCode}.trash')->listCheck(true);" . PHP_EOL;
		$toolBar .= Indent::_(4) . "}" . PHP_EOL;
		$toolBar .= Indent::_(3) . "}";

		// Dynamic and custom buttons
		$toolBar .= $this->dynamicbuttons->get($nameListCode);
		$toolBar .= $this->custombuttons->get($view, 3, Indent::_(1));

		return $toolBar;
	}

	/**
	 * Build function-only buttons section.
	 *
	 * @param  string  $nameListCode  The list view code.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildFunctionButtons(string $nameListCode): string
	{
		$fuctionOnlyButtons = $this->onlyfunctionbuttons->get($nameListCode, '');

		return PHP_EOL . Indent::_(2) . '}' . $fuctionOnlyButtons . PHP_EOL;
	}

	/**
	 * Build help and preferences toolbar items.
	 *
	 * @param  string  $nameListCode  The list view code.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildHelpAndPreferences(string $nameListCode): string
	{
		$toolBar  = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " set help url for this view if found" . PHP_EOL;
		$toolBar .= Indent::_(2)
			. "\$this->help_url = {$this->contentone->get('Component')}Helper::getHelpUrl('{$nameListCode}');" . PHP_EOL;
		$toolBar .= Indent::_(2)
			. "if (Super__" . "_1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->help_url))" . PHP_EOL;
		$toolBar .= Indent::_(2) . "{" . PHP_EOL;
		$toolBar .= Indent::_(3)
			. "\$toolbar->help('{$this->config->lang_prefix}_HELP_MANAGER', false, \$this->help_url);" . PHP_EOL;
		$toolBar .= Indent::_(2) . "}" . PHP_EOL;

		$toolBar .= PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " add the options comp button" . PHP_EOL;
		$toolBar .= Indent::_(2)
			. "if (\$this->canDo->get('core.admin') || \$this->canDo->get('core.options'))" . PHP_EOL;
		$toolBar .= Indent::_(2) . "{" . PHP_EOL;
		$toolBar .= Indent::_(3)
			. "\$toolbar->preferences('com_{$this->config->component_code_name}');" . PHP_EOL;
		$toolBar .= Indent::_(2) . "}";

		return $toolBar;
	}
}

