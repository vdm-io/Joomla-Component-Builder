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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminView;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Builder\History;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomButtons;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\AddToolBarInterface;


/**
 * Admin View Add ToolBar Class for Joomla 3
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
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 5.1.4
	 */
	protected Permission $permission;

	/**
	 * The History Class.
	 *
	 * @var   History
	 * @since 5.1.4
	 */
	protected History $history;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 5.1.4
	 */
	protected Language $language;

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
	 * @param Permission      $permission      The Permission Class.
	 * @param History         $history         The History Class.
	 * @param Language        $language        The Language Class.
	 * @param CustomButtons   $custombuttons   The CustomButtons Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, ContentOne $contentone,
		Permission $permission, History $history,
		Language $language, CustomButtons $custombuttons)
	{
		$this->config = $config;
		$this->contentone = $contentone;
		$this->permission = $permission;
		$this->history = $history;
		$this->language = $language;
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

		$nameSingleCode = $settings->name_single_code ?? null;
		$type = (int) ($settings->type ?? 0);

		if (empty($nameSingleCode))
		{
			return '';
		}

		// check type
		if ($type === 2)
		{
			return $this->buildReadonlyToolbar($settings, $nameSingleCode);
		}

		return $this->buildEditableToolbar($view, $nameSingleCode);
	}

	/**
	 * The code to initialize the toolbar only if it hasn't been initialized yet for the site area.
	 *         (should this admin view [EDIT VIEW] be used in the site area)
	 *
	 * @return string  The generated PHP toolbar code.
	 * @since  5.1.4
	 */
	public function initSite(): string
	{
		$toolBar = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__)
			. " Initialize the toolbar only if it hasn't been initialized yet.";
		$toolBar .= PHP_EOL . Indent::_(2) . "\$this->toolbar ??= Joomla__" . "_47ee1f2b_9902_4f26_a856_04930ac9ddc3___Power::getInstance();";

		return $toolBar;
	}

	/**
	 * Build the toolbar for readonly view type.
	 *
	 * @param  object   $settings            The view containing settings.
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  The toolbar code.
	 * @since  5.1.4
	 */
	protected function buildReadonlyToolbar(object $settings, string $nameSingleCode): string
	{
		// set lang strings
		$viewNameLang_readonly = $this->config->lang_prefix . '_'
			. StringHelper::safe(
				$settings->name_single . ' readonly', 'U'
			);

		// load to lang
		$this->language->set(
			$this->config->lang_target, $viewNameLang_readonly,
			$settings->name_single . ' :: Readonly'
		);

		// build toolbar
		$toolBar
				= "Joomla__" . "_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->input->set('hidemainmenu', true);";

		$toolBar .= PHP_EOL . Indent::_(2) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title(Text:"
			. ":_('{$viewNameLang_readonly}'), '{$nameSingleCode}');";
		$toolBar .= PHP_EOL . Indent::_(2) . "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::cancel('"
			. $nameSingleCode . ".cancel', 'JTOOLBAR_CLOSE');";

		return $toolBar;
	}

	/**
	 * Build the toolbar for editable (new/edit) views.
	 *
	 * @param  array   $view            The view array containing settings.
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  The toolbar code.
	 * @since  5.1.4
	 */
	protected function buildEditableToolbar(array $view, string $nameSingleCode): string
	{
		/** @var object $settings */
		$settings = (object) ($view['settings'] ?? []);

		// Step 1: Set up the language strings
		[$viewNameLang_new, $viewNameLang_edit] = $this->setEditableLanguageStrings($settings);

		// Step 2: Prepare toolbar and user setup
		$toolBar = $this->initializeToolbarUser();

		// Step 3: Add title
		$toolBar .= $this->addToolbarTitle($viewNameLang_new, $viewNameLang_edit);

		// Step 4: Referral-based permissions
		$toolBar .= $this->buildReferralSection($nameSingleCode);

		// Step 5: Add main permission and version sections
		$toolBar .= $this->buildPermissionSections($nameSingleCode);

		// Step 6: Add custom buttons
		$toolBar .= $this->addCustomButtons($view, $nameSingleCode);

		// Step 7: Add help and inline help
		$toolBar .= $this->addHelpSection($nameSingleCode);

		return $toolBar;
	}

	/**
	 * Define new/edit language strings and load them into the language system.
	 *
	 * @param  object  $settings  The view data containing settings.
	 *
	 * @return array<string>  The [newLangKey, editLangKey].
	 * @since  5.1.4
	 */
	protected function setEditableLanguageStrings(object $settings): array
	{
		$viewNameLang_new  = $this->config->lang_prefix . '_'
			. StringHelper::safe($settings->name_single . ' New', 'U');
		$viewNameLang_edit = $this->config->lang_prefix . '_'
			. StringHelper::safe($settings->name_single . ' Edit', 'U');

		$this->language->set(
			$this->config->lang_target,
			$viewNameLang_new,
			'A New ' . $settings->name_single
		);
		$this->language->set(
			$this->config->lang_target,
			$viewNameLang_edit,
			'Editing the ' . $settings->name_single
		);

		return [$viewNameLang_new, $viewNameLang_edit];
	}

	/**
	 * Initialize the toolbar, user, and basic view setup.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function initializeToolbarUser(): string
	{
		$toolBar
			= "Joomla__" . "_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->input->set('hidemainmenu', true);";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "\$user = Joomla__" . "_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";

		$toolBar .= PHP_EOL . Indent::_(2) . "\$userId = \$user->id;";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "\$isNew = \$this->item->id == 0;";

		return $toolBar;
	}

	/**
	 * Add the toolbar title and its logic line comment.
	 *
	 * @param  string  $viewNameLang_new   The new item language key.
	 * @param  string  $viewNameLang_edit  The edit item language key.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function addToolbarTitle(string $viewNameLang_new, string $viewNameLang_edit): string
	{
		$toolBar  = PHP_EOL . PHP_EOL . Indent::_(2)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::title( Joomla__"
			. "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_(\$isNew ? '"
			. $viewNameLang_new . "' : '" . $viewNameLang_edit
			. "'), 'pencil-2 article-add');";

		$toolBar .= PHP_EOL . Indent::_(2) . "//"
			. Line::_(__LINE__, __CLASS__) . " Built the actions for new and existing records.";

		return $toolBar;
	}

	/**
	 * Build the referral permission section.
	 *
	 * @param  string  $nameSingleCode  The name single code.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function buildReferralSection(string $nameSingleCode): string
	{
		$toolBar  = PHP_EOL . Indent::_(2)
			. "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->referral))";
		$toolBar .= PHP_EOL . Indent::_(2) . "{";
		$toolBar .= PHP_EOL . Indent::_(3)
			. "if (\$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.create')
			. "') && \$isNew)";
		$toolBar .= PHP_EOL . Indent::_(3) . "{";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "//" . Line::_(__LINE__, __CLASS__) . " We can create the record.";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::save('"
			. $nameSingleCode . ".save', 'JTOOLBAR_SAVE');";
		$toolBar .= PHP_EOL . Indent::_(3) . "}";
		$toolBar .= PHP_EOL . Indent::_(3)
			. "elseif (\$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.edit') . "'))";
		$toolBar .= PHP_EOL . Indent::_(3) . "{";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "//" . Line::_(__LINE__, __CLASS__) . " We can save the record.";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::save('"
			. $nameSingleCode . ".save', 'JTOOLBAR_SAVE');";
		$toolBar .= PHP_EOL . Indent::_(3) . "}";
		$toolBar .= PHP_EOL . Indent::_(3) . "if (\$isNew)";
		$toolBar .= PHP_EOL . Indent::_(3) . "{";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "//" . Line::_(__LINE__, __CLASS__) . " Do not create but cancel.";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::cancel('"
			. $nameSingleCode . ".cancel', 'JTOOLBAR_CANCEL');";
		$toolBar .= PHP_EOL . Indent::_(3) . "}";
		$toolBar .= PHP_EOL . Indent::_(3) . "else";
		$toolBar .= PHP_EOL . Indent::_(3) . "{";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "//" . Line::_(__LINE__, __CLASS__) . " We can close it.";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::cancel('"
			. $nameSingleCode . ".cancel', 'JTOOLBAR_CLOSE');";
		$toolBar .= PHP_EOL . Indent::_(3) . "}";
		$toolBar .= PHP_EOL . Indent::_(2) . "}";

		return $toolBar;
	}

	/**
	 * Build permissions, versioning, and related toolbar items.
	 *
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function buildPermissionSections(string $nameSingleCode): string
	{
		$toolBar  = PHP_EOL . Indent::_(2) . "else";
		$toolBar .= PHP_EOL . Indent::_(2) . "{";
		$toolBar .= PHP_EOL . Indent::_(3) . "if (\$isNew)";
		$toolBar .= PHP_EOL . Indent::_(3) . "{";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "//" . Line::_(__LINE__, __CLASS__) . " For new records, check the create permission.";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "if (\$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.create') . "'))";
		$toolBar .= PHP_EOL . Indent::_(4) . "{";
		$toolBar .= PHP_EOL . Indent::_(5)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::apply('"
			. $nameSingleCode . ".apply', 'JTOOLBAR_APPLY');";
		$toolBar .= PHP_EOL . Indent::_(5)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::save('"
			. $nameSingleCode . ".save', 'JTOOLBAR_SAVE');";
		$toolBar .= PHP_EOL . Indent::_(5)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::custom('"
			. $nameSingleCode . ".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
		$toolBar .= PHP_EOL . Indent::_(4) . "};";
		$toolBar .= PHP_EOL . Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::cancel('"
			. $nameSingleCode . ".cancel', 'JTOOLBAR_CANCEL');";
		$toolBar .= PHP_EOL . Indent::_(3) . "}";
		$toolBar .= PHP_EOL . Indent::_(3) . "else";
		$toolBar .= PHP_EOL . Indent::_(3) . "{";
		$toolBar .= $this->addHistoryAndVersioning($nameSingleCode);
		$toolBar .= PHP_EOL . Indent::_(4)
			. "if (\$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.create') . "'))";
		$toolBar .= PHP_EOL . Indent::_(4) . "{";
		$toolBar .= PHP_EOL . Indent::_(5)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::custom('"
			. $nameSingleCode . ".save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);";
		$toolBar .= PHP_EOL . Indent::_(4) . "}";

		return $toolBar;
	}

	/**
	 * Add versioning section for editable toolbar.
	 *
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function addHistoryAndVersioning(string $nameSingleCode): string
	{
		$toolBar = '';

		if ($this->permission->globalExist($nameSingleCode, 'core.edit'))
		{
			if ($this->history->exists($nameSingleCode))
			{
				$toolBar .= PHP_EOL . Indent::_(4)
					. "\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('"
					. $this->permission->getGlobal($nameSingleCode, 'core.version')
					. "'));";
				$toolBar .= PHP_EOL . Indent::_(4)
					. "if (\$this->state->params->get('save_history', 1) && \$this->canDo->get('"
					. $this->permission->getGlobal($nameSingleCode, 'core.edit')
					. "') && \$canVersion)";
				$toolBar .= PHP_EOL . Indent::_(4) . "{";
				$toolBar .= PHP_EOL . Indent::_(5)
					. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::versions('com_"
					. $this->config->component_code_name . "." . $nameSingleCode
					. "', \$this->item->id);";
				$toolBar .= PHP_EOL . Indent::_(4) . "}";
			}
		}
		else
		{
			if ($this->history->exists($nameSingleCode))
			{
				$toolBar .= PHP_EOL . Indent::_(4)
					. "\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('"
					. $this->permission->getGlobal($nameSingleCode, 'core.version') . "'));";
				$toolBar .= PHP_EOL . Indent::_(4)
					. "if (\$this->state->params->get('save_history', 1) && \$this->canDo->get('core.edit') && \$canVersion)";
				$toolBar .= PHP_EOL . Indent::_(4) . "{";
				$toolBar .= PHP_EOL . Indent::_(5)
					. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::versions('com_"
					. $this->config->component_code_name . "." . $nameSingleCode
					. "', \$this->item->id);";
				$toolBar .= PHP_EOL . Indent::_(4) . "}";
			}
		}

		return $toolBar;
	}

	/**
	 * Add custom buttons and finalize main action group.
	 *
	 * @param  array   $view            The view data.
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  Partial toolbar string.
	 * @since  5.1.4
	 */
	protected function addCustomButtons(array $view, string $nameSingleCode): string
	{
		$toolBar  = $this->custombuttons->get($view, 2, Indent::_(2));
		$toolBar .= PHP_EOL . Indent::_(4)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::cancel('"
			. $nameSingleCode . ".cancel', 'JTOOLBAR_CLOSE');";

		$toolBar .= PHP_EOL . Indent::_(3) . "}";
		$toolBar .= PHP_EOL . Indent::_(2) . "}";

		return $toolBar;
	}

	/**
	 * Append inline help, divider, and contextual help links.
	 *
	 * @param  string  $nameSingleCode  The single item code name.
	 *
	 * @return string  The completed toolbar section.
	 * @since  5.1.4
	 */
	protected function addHelpSection(string $nameSingleCode): string
	{
		$toolBar  = PHP_EOL . Indent::_(2)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::divider();";

		$toolBar .= PHP_EOL . Indent::_(2)
			. "//" . Line::_(__LINE__, __CLASS__)
			. " set help url for this view if found";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "\$this->help_url = " . $this->contentone->get('Component') . "Helper::getHelpUrl('" . $nameSingleCode . "');";
		$toolBar .= PHP_EOL . Indent::_(2)
			. "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->help_url))";
		$toolBar .= PHP_EOL . Indent::_(2) . "{";
		$toolBar .= PHP_EOL . Indent::_(3)
			. "Joomla__" . "_0c1a176a_304f_433a_8233_37d01ff87815___Power::help('"
			. $this->config->lang_prefix . "_HELP_MANAGER', false, \$this->help_url);";
		$toolBar .= PHP_EOL . Indent::_(2) . "}";

		return $toolBar;
	}
}

