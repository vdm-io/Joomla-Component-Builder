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


use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Custom Sub Menu Class.
 * 
 * Builds the sub menu entries of every custom admin view and every custom menu
 * the component declares, for the admin view whose sub menu is being written.
 * 
 * An entry that belongs after the component's own views is held back rather
 * than returned, and the caller takes what was held once it has walked them
 * all. That is a hand over, not a copy: what is taken is forgotten here, which
 * is what the caller's unset used to do.
 * 
 * @since  6.1.7
 */
final class CustomSubMenu
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
	 * The Permission Creator Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * The entries held back until every view has been walked.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $deferred = [];

	/**
	 * The custom admin views already given a menu entry elsewhere.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $customAdminAdded = [];

	/**
	 * Constructor.
	 *
	 * @param Component   $component   The Component Class.
	 * @param Config      $config      The Config Class.
	 * @param Language    $language    The Language Class.
	 * @param Permission  $permission  The Permission Creator Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Component $component, Config $config,
		Language $language, Permission $permission)
	{
		$this->component = $component;
		$this->config = $config;
		$this->language = $language;
		$this->permission = $permission;
	}

	/**
	 * Build the custom sub menu entries that sit beside the given admin view.
	 *
	 * @param   array   $view              The admin view being walked.
	 * @param   string  $codeName          The component code name.
	 * @param   string  $lang              The menu language prefix.
	 * @param   array   $customAdminAdded  The custom admin views already given an entry.
	 *
	 * @return  string  The entries, or nothing when the component declares none.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view, $codeName, $lang, array $customAdminAdded = []): string
	{
		$this->customAdminAdded = $customAdminAdded;
		// see if we should have custom menus
		$custom = '';
		if ($this->component->isArray('custom_admin_views'))
		{
			foreach ($this->component->get('custom_admin_views') as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]))
				{
					if (($_custom = $this->customAdminSubMenu(
							$view, $codeName, $lang, $nr, $menu, 'customView'
						)) !== false)
					{
						$custom .= $_custom;
					}
				}
			}
		}
		if ($this->component->isArray('custommenus'))
		{
			foreach ($this->component->get('custommenus') as $nr => $menu)
			{
				if (($_custom = $this->customAdminSubMenu(
						$view, $codeName, $lang, $nr, $menu, 'customMenu'
					)) !== false)
				{
					$custom .= $_custom;
				}
			}
		}

		return $custom;
	}

	/**
	 * Take the entries that were held back, and forget them.
	 *
	 * @return  array  What was held, keyed as the caller wrote it.
	 *
	 * @since   6.1.7
	 */
	public function takeDeferred(): array
	{
		$deferred = $this->deferred;
		$this->deferred = [];

		return $deferred;
	}

	/**
	 * Build one custom admin view's or custom menu's sub menu entry.
	 *
	 * @param   array   $view      The admin view being walked.
	 * @param   string  $codeName  The component code name.
	 * @param   string  $lang      The menu language prefix.
	 * @param   int     $nr        Which of the declared menus this is.
	 * @param   array   $menu      The menu being built.
	 * @param   string  $type      Whether this is a customView or a customMenu.
	 *
	 * @return  string|false  The entry, or false when this menu declares none.
	 *
	 * @since   6.1.7
	 */
	protected function customAdminSubMenu(&$view, &$codeName, &$lang, &$nr, &$menu,
		$type = 'customView')
	{
		if ($type === 'customMenu')
		{
			$name       = $menu['name'];
			$nameSingle = StringHelper::safe($menu['name']);
			$nameList   = StringHelper::safe($menu['name']);
			$nameUpper  = StringHelper::safe(
				$menu['name'], 'U'
			);
		}
		elseif ($type === 'customView')
		{
			$name       = $menu['settings']->name;
			$nameSingle = $menu['settings']->code;
			$nameList   = $menu['settings']->code;
			$nameUpper  = $menu['settings']->CODE;
		}
		if (isset($menu['submenu']) && $menu['submenu'] == 1
			&& $view['adminview'] == $menu['before'])
		{
			// setup access defaults
			$tab = "";
			$custom = '';
			// check if the item has permissions.
			if ($this->permission->globalExist($nameSingle, 'core.access'))
			{
				$custom .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Access control (" . $this->permission->getGlobal($nameSingle, 'core.access') . " && "
					. $nameSingle . ".submenu).";
				$custom .= PHP_EOL . Indent::_(2) . "if (\$user->authorise('"
					. $this->permission->getGlobal($nameSingle, 'core.access') . "', 'com_" . $codeName
					. "') && \$user->authorise('" . $nameSingle
					. ".submenu', 'com_" . $codeName . "'))";
				$custom .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			else
			{
				$custom .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Access control (" . $nameSingle . ".submenu).";
				$custom .= PHP_EOL . Indent::_(2) . "if (\$user->authorise('"
					. $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$custom .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			if (isset($menu['link'])
				&& StringHelper::check(
					$menu['link']
				))
			{

				$this->language->set(
					$this->config->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$custom .= PHP_EOL . Indent::_(2) . $tab
					. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang . "_"
					. $nameUpper . "'), '" . $menu['link']
					. "', \$submenu === '" . $nameList . "');";
			}
			else
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$custom .= PHP_EOL . Indent::_(2) . $tab
					. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang . "_"
					. $nameUpper . "'), 'index.php?option=com_" . $codeName
					. "&view=" . $nameList . "', \$submenu === '" . $nameList
					. "');";
			}
			// check if the item has permissions.
			$custom .= PHP_EOL . Indent::_(2) . "}";

			return $custom;
		}
		elseif (isset($menu['submenu']) && $menu['submenu'] == 1
			&& empty($menu['before']))
		{
			// setup access defaults
			$tab        = "";
			$nameSingle = StringHelper::safe($name);
			$this->deferred[$nr] = '';
			// check if the item has permissions.
			if ($this->permission->globalExist($nameSingle, 'core.access'))
			{
				$this->deferred[$nr] .= PHP_EOL . Indent::_(2)
					. "if (\$user->authorise('" . $this->permission->getGlobal($nameSingle, 'core.access')
					. "', 'com_" . $codeName . "') && \$user->authorise('"
					. $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$this->deferred[$nr] .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			else
			{
				$this->deferred[$nr] .= PHP_EOL . Indent::_(2)
					. "if (\$user->authorise('" . $nameSingle
					. ".submenu', 'com_" . $codeName . "'))";
				$this->deferred[$nr] .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			if (isset($menu['link'])
				&& StringHelper::check(
					$menu['link']
				))
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$this->deferred[$nr] .= PHP_EOL . Indent::_(2) . $tab
					. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang . "_"
					. $nameUpper . "'), '" . $menu['link']
					. "', \$submenu === '" . $nameList . "');";
			}
			else
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$this->deferred[$nr] .= PHP_EOL . Indent::_(2) . $tab
					. "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addEntry(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $lang . "_"
					. $nameUpper . "'), 'index.php?option=com_" . $codeName
					. "&view=" . $nameList . "', \$submenu === '" . $nameList
					. "');";
			}
			// check if the item has permissions.
			$this->deferred[$nr] .= PHP_EOL . Indent::_(2) . "}";
		}

		return false;
	}
}

