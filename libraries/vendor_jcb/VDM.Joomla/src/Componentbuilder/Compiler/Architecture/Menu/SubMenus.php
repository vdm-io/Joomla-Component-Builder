<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Menu;


use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryOtherName;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UninstallScriptContext;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UninstallScriptFields;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Sub Menus Class.
 * 
 * Builds the administrator sub menu of the component: an entry for every admin
 * view that asks for one, the fields and field group entries of a view that
 * carries custom fields, and whatever the custom admin views and custom menus
 * add beside them.
 * 
 * A view that carries custom fields also registers what has to be removed again
 * when the component is uninstalled, since the fields it registers outlive it.
 * 
 * @since  6.1.7
 */
final class SubMenus
{
	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Compiler Registry Class.
	 *
	 * @var   Registry
	 * @since 6.1.7
	 */
	protected Registry $registry;

	/**
	 * The Permission Creator Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * The Category Builder Class.
	 *
	 * @var   Category
	 * @since 6.1.7
	 */
	protected Category $category;

	/**
	 * The Category Other Name Builder Class.
	 *
	 * @var   CategoryOtherName
	 * @since 6.1.7
	 */
	protected CategoryOtherName $categoryothername;

	/**
	 * The Uninstall Script Context Builder Class.
	 *
	 * @var   UninstallScriptContext
	 * @since 6.1.7
	 */
	protected UninstallScriptContext $uninstallcontext;

	/**
	 * The Uninstall Script Fields Builder Class.
	 *
	 * @var   UninstallScriptFields
	 * @since 6.1.7
	 */
	protected UninstallScriptFields $uninstallfields;

	/**
	 * The Custom Sub Menu Class.
	 *
	 * @var   CustomSubMenu
	 * @since 6.1.7
	 */
	protected CustomSubMenu $customsubmenu;

	/**
	 * Constructor.
	 *
	 * @param Component               $component          The Component Class.
	 * @param Config                  $config             The Config Class.
	 * @param Language                $language           The Language Class.
	 * @param Registry                $registry           The Compiler Registry Class.
	 * @param Permission              $permission         The Permission Creator Class.
	 * @param Category                $category           The Category Builder Class.
	 * @param CategoryOtherName       $categoryothername  The Category Other Name Builder Class.
	 * @param UninstallScriptContext  $uninstallcontext   The Uninstall Script Context Builder Class.
	 * @param UninstallScriptFields   $uninstallfields    The Uninstall Script Fields Builder Class.
	 * @param CustomSubMenu           $customsubmenu      The Custom Sub Menu Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Component $component,
		Config $config,
		Language $language,
		Registry $registry,
		Permission $permission,
		Category $category,
		CategoryOtherName $categoryothername,
		UninstallScriptContext $uninstallcontext,
		UninstallScriptFields $uninstallfields,
		CustomSubMenu $customsubmenu)
	{
		$this->component = $component;
		$this->config = $config;
		$this->language = $language;
		$this->registry = $registry;
		$this->permission = $permission;
		$this->category = $category;
		$this->categoryothername = $categoryothername;
		$this->uninstallcontext = $uninstallcontext;
		$this->uninstallfields = $uninstallfields;
		$this->customsubmenu = $customsubmenu;
	}

	/**
	 * Build the component's administrator sub menu.
	 *
	 * @return  string  The menu, or nothing when the component declares no admin views.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		if ($this->component->isArray('admin_views'))
		{
			$menus = '';
			// main lang prefix
			$lang = $this->config->lang_prefix . '_SUBMENU';
			// set the code name
			$codeName = $this->config->component_code_name;
			// set default dashboard
			if (!$this->registry->get('build.dashboard'))
			{
				$menus .= "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang
					. "_DASHBOARD'), 'index.php?option=com_" . $codeName
					. "&view=" . $codeName . "', \$submenu === '" . $codeName
					. "');";
				$this->language->set(
					$this->config->lang_target, $lang . '_DASHBOARD', 'Dashboard'
				);
			}
			$catArray = [];
			// loop over all the admin views
			foreach ($this->component->get('admin_views') as $view)
			{
				// set custom menu
				$menus          .= $this->customsubmenu->get(
					$view, $codeName, $lang
				);
				$nameSingleCode = $view['settings']->name_single_code;
				$nameListCode   = $view['settings']->name_list_code;
				$nameUpper      = StringHelper::safe(
					$view['settings']->name_list, 'U'
				);
				// check if view is set to be in the sub-menu
				if (isset($view['submenu']) && $view['submenu'] == 1)
				{
					// setup access defaults
					$tab      = "";
					$has_permissions = false;
					// check if the item has permissions.
					if ($this->permission->globalExist($nameSingleCode, 'core.access'))
					{
						$menus .= PHP_EOL . Indent::_(2)
							. "if (\$user->authorise('"
							. $this->permission->getGlobal($nameSingleCode, 'core.access')
							. "', 'com_" . $codeName
							. "') && \$user->authorise('" . $nameSingleCode
							. ".submenu', 'com_" . $codeName . "'))";
						$menus .= PHP_EOL . Indent::_(2) . "{";
						// add tab to lines to follow
						$tab = Indent::_(1);
						$has_permissions = true;
					}
					$menus .= PHP_EOL . Indent::_(2) . $tab
						. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang . "_"
						. $nameUpper . "'), 'index.php?option=com_" . $codeName
						. "&view=" . $nameListCode . "', \$submenu === '"
						. $nameListCode . "');";
					$this->language->set(
						$this->config->lang_target, $lang . "_" . $nameUpper,
						$view['settings']->name_list
					);
					// check if category has another name
					$otherViews = $this->categoryothername->
						get($nameListCode . '.views', $nameListCode);
					// first check if category sub-menu should be added
					// then check if view has category, if true add sub-menu for it
					if ($view['settings']->add_category_submenu == 1
						&& $this->category->exists("{$nameListCode}.extension")
						&& !in_array($otherViews, $catArray))
					{
						// get the extension array
						$_extension_array = (array) explode(
							'.',
							(string) $this->category->get("{$nameListCode}.extension")
						);
						// set the menu selection
						if (isset($_extension_array[1]))
						{
							$_menu = "categories." . trim($_extension_array[1]);
						}
						else
						{
							$_menu = "categories";
						}
						// now load the menus
						$menus .= PHP_EOL . Indent::_(2) . $tab
							. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
							. $this->category->get("{$nameListCode}.name", 'error')
							. "'), 'index.php?option=com_categories&view=categories&extension="
							. $this->category->get("{$nameListCode}.extension")
							. "', \$submenu === '" . $_menu . "');";
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
					// check if the item has permissions.
					if ($has_permissions)
					{
						$menus .= PHP_EOL . Indent::_(2) . "}";
					}
				}
				// set the Joomla custom fields options
				if (isset($view['joomla_fields'])
					&& $view['joomla_fields'] == 1)
				{
					$menus .= PHP_EOL . Indent::_(2)
						. "if (ComponentHelper::isEnabled('com_fields'))";
					$menus .= PHP_EOL . Indent::_(2) . "{";
					$menus .= PHP_EOL . Indent::_(3)
						. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang . "_"
						. $nameUpper
						. "_FIELDS'), 'index.php?option=com_fields&context=com_"
						. $codeName . "." . $nameSingleCode
						. "', \$submenu === 'fields.fields');";
					$menus .= PHP_EOL . Indent::_(3)
						. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang . "_"
						. $nameUpper
						. "_FIELDS_GROUPS'), 'index.php?option=com_fields&view=groups&context=com_"
						. $codeName . "." . $nameSingleCode
						. "', \$submenu === 'fields.groups');";
					$menus .= PHP_EOL . Indent::_(2) . "}";
					$this->language->set(
						$this->config->lang_target, $lang . "_" . $nameUpper . "_FIELDS",
						$view['settings']->name_list . ' Fields'
					);
					$this->language->set(
						$this->config->lang_target,
						$lang . "_" . $nameUpper . "_FIELDS_GROUPS",
						$view['settings']->name_list . ' Field Groups'
					);
					// build uninstall script for fields
					$this->uninstallcontext->set($nameSingleCode, 'com_'
						. $codeName . '.' . $nameSingleCode);
					$this->uninstallfields->set($nameSingleCode, $nameSingleCode);
				}
			}
			// the entries the custom sub menus held back are taken, which is
			// what the unset here used to do once they had been read
			$deferred = $this->customsubmenu->takeDeferred();

			if (ArrayHelper::check($deferred))
			{
				foreach ($deferred as $menu)
				{
					$menus .= $menu;
				}
			}

			return $menus;
		}

		return false;
	}
}

