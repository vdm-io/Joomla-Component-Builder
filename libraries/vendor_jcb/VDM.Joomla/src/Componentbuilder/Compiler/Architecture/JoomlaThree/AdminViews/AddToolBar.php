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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\DynamicButtons;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomButtons;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OnlyFunctionButtons;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\AddToolBarInterface;


/**
 * Admin Views Add ToolBar Class for Joomla 3
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
	 * @param ContentOne            $contentone            The ContentOne Class.
	 * @param DynamicButtons        $dynamicbuttons        The DynamicButtons Class.
	 * @param CustomButtons         $custombuttons         The CustomButtons Class.
	 * @param OnlyFunctionButtons   $onlyfunctionbuttons   The OnlyFunctionButtons Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, ContentOne $contentone,
		DynamicButtons $dynamicbuttons,
		CustomButtons $custombuttons,
		OnlyFunctionButtons $onlyfunctionbuttons)
	{
		$this->config = $config;
		$this->contentone = $contentone;
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
		$icomoon   = $view['icomoon'] ?? '';

		$toolbar  = $this->buildTitle($langViews, $icomoon);
		$toolbar .= $this->buildCreateButton($nameSingleCode);
		$toolbar .= $this->buildStateAndEditButtons($nameSingleCode, $nameListCode, $view);
		$toolbar .= $this->buildTrashAndDeleteButtons($nameListCode);
		$toolbar .= $this->buildFunctionButtons($nameListCode);
		$toolbar .= $this->buildHelpAndPreferences($nameListCode);

		return $toolbar;
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
		return PHP_EOL . Indent::_(2)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title(Joomla__"
			. "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('{$langViews}'), '{$icomoon}');"
			. PHP_EOL . PHP_EOL;
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
		$code  = Indent::_(2) . "if (\$this->canCreate)" . PHP_EOL;
		$code .= Indent::_(2) . "{" . PHP_EOL;
		$code .= Indent::_(3) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::addNew('{$nameSingleCode}.add');" . PHP_EOL;
		$code .= Indent::_(2) . "}" . PHP_EOL;

		return $code;
	}

	/**
	 * Build edit, publish, archive, and check-in buttons if permissions allow.
	 *
	 * @param  string  $nameSingleCode  The single item code.
	 * @param  string  $nameListCode    The list view code.
	 * @param  array   $view            The view configuration.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildStateAndEditButtons(string $nameSingleCode, string $nameListCode, array $view): string
	{
		$toolbar  = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " Only load if there are items" . PHP_EOL;
		$toolbar .= Indent::_(2) . "if (Super__" . "_0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->items))" . PHP_EOL;
		$toolbar .= Indent::_(2) . "{" . PHP_EOL;

		// Edit
		$toolbar .= Indent::_(3) . "if (\$this->canEdit)" . PHP_EOL;
		$toolbar .= Indent::_(3) . "{" . PHP_EOL;
		$toolbar .= Indent::_(4) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::editList('{$nameSingleCode}.edit');" . PHP_EOL;
		$toolbar .= Indent::_(3) . "}" . PHP_EOL . PHP_EOL;

		// State
		$toolbar .= Indent::_(3) . "if (\$this->canState)" . PHP_EOL;
		$toolbar .= Indent::_(3) . "{" . PHP_EOL;
		$toolbar .= Indent::_(4) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::publishList('{$nameListCode}.publish');" . PHP_EOL;
		$toolbar .= Indent::_(4) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::unpublishList('{$nameListCode}.unpublish');" . PHP_EOL;
		$toolbar .= Indent::_(4) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::archiveList('{$nameListCode}.archive');" . PHP_EOL;

		// Check-in for admins
		$toolbar .= PHP_EOL . Indent::_(4) . "if (\$this->canDo->get('core.admin'))" . PHP_EOL;
		$toolbar .= Indent::_(4) . "{" . PHP_EOL;
		$toolbar .= Indent::_(5) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::checkin('{$nameListCode}.checkin');" . PHP_EOL;
		$toolbar .= Indent::_(4) . "}" . PHP_EOL;

		$toolbar .= Indent::_(3) . "}";

		// Dynamic and custom buttons
		$toolbar .= $this->dynamicbuttons->get($nameListCode);
		$toolbar .= $this->custombuttons->get($view, 3, Indent::_(1)) . PHP_EOL;

		return $toolbar;
	}

	/**
	 * Build delete/trash button section.
	 *
	 * @param  string  $nameListCode  The list view code.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function buildTrashAndDeleteButtons(string $nameListCode): string
	{
		$toolbar  = PHP_EOL . Indent::_(3)
			. "if (\$this->state->get('filter.published') == -2 && (\$this->canState && \$this->canDelete))" . PHP_EOL;
		$toolbar .= Indent::_(3) . "{" . PHP_EOL;
		$toolbar .= Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::deleteList('', '{$nameListCode}.delete', 'JTOOLBAR_EMPTY_TRASH');" . PHP_EOL;
		$toolbar .= Indent::_(3) . "}" . PHP_EOL;
		$toolbar .= Indent::_(3) . "elseif (\$this->canState && \$this->canDelete)" . PHP_EOL;
		$toolbar .= Indent::_(3) . "{" . PHP_EOL;
		$toolbar .= Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::trash('{$nameListCode}.trash');" . PHP_EOL;
		$toolbar .= Indent::_(3) . "}" . PHP_EOL;

		return $toolbar;
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
		$toolbar  = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " set help url for this view if found" . PHP_EOL;
		$toolbar .= Indent::_(2)
			. "\$this->help_url = {$this->contentone->get('Component')}Helper::getHelpUrl('{$nameListCode}');" . PHP_EOL;
		$toolbar .= Indent::_(2)
			. "if (Super__" . "_1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->help_url))" . PHP_EOL;
		$toolbar .= Indent::_(2) . "{" . PHP_EOL;
		$toolbar .= Indent::_(3)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::help('{$this->config->lang_prefix}_HELP_MANAGER', false, \$this->help_url);" . PHP_EOL;
		$toolbar .= Indent::_(2) . "}" . PHP_EOL;

		$toolbar .= PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " add the options comp button" . PHP_EOL;
		$toolbar .= Indent::_(2)
			. "if (\$this->canDo->get('core.admin') || \$this->canDo->get('core.options'))" . PHP_EOL;
		$toolbar .= Indent::_(2) . "{" . PHP_EOL;
		$toolbar .= Indent::_(3)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::preferences('com_{$this->config->component_code_name}');" . PHP_EOL;
		$toolbar .= Indent::_(2) . "}";

		return $toolbar;
	}
}

