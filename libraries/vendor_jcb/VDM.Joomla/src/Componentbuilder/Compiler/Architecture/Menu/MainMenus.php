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
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Menu\MainMenusInterface;


/**
 * Main Menus Class.
 * 
 * Builds the administrator main menu of the component: the component's own
 * entry, an entry for every admin view that asks for one, and whatever the
 * custom main menus add between them.
 * 
 * A component that builds no dashboard of its own is given a menu entry that
 * reaches the default one. Joomla 3 has no such default, which is the one thing
 * about this menu the compile target decides, and it is the extension point
 * below.
 * 
 * @since  6.1.7
 */
class MainMenus implements MainMenusInterface
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
	 * The Custom Main Menu Class.
	 *
	 * @var   CustomMainMenu
	 * @since 6.1.7
	 */
	protected CustomMainMenu $custommainmenu;

	/**
	 * Constructor.
	 *
	 * @param Component       $component       The Component Class.
	 * @param Config          $config          The Config Class.
	 * @param Language        $language        The Language Class.
	 * @param Registry        $registry        The Compiler Registry Class.
	 * @param CustomMainMenu  $custommainmenu  The Custom Main Menu Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Component $component, Config $config,
		Language $language, Registry $registry, CustomMainMenu $custommainmenu)
	{
		$this->component = $component;
		$this->config = $config;
		$this->language = $language;
		$this->registry = $registry;
		$this->custommainmenu = $custommainmenu;
	}

	/**
	 * Build the component's administrator main menu.
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
			$lang = $this->config->lang_prefix . '_MENU';
			// set the code name
			$codeName = $this->config->component_code_name;
			// default prefix is none
			$prefix = '';
			// check if local is set
			if ($this->component->isNumeric('add_menu_prefix'))
			{
				// set main menu prefix switch
				$addPrefix = $this->component->get('add_menu_prefix');
				if ($addPrefix == 1 && $this->component->isString('menu_prefix'))
				{
					$prefix = trim((string) $this->component->get('menu_prefix')) . ' ';
				}
			}
			else
			{
				// set main menu prefix switch
				$addPrefix = $this->config->get('add_menu_prefix', 1);
				if ($addPrefix == 1)
				{
					$prefix = trim((string) $this->config->get('menu_prefix', '&#187;'))
						. ' ';
				}
			}
			// add the prefix
			if ($addPrefix == 1)
			{
				$this->language->set(
					'adminsys', $lang, $prefix . $this->component->get('name')
				);
			}
			else
			{
				$this->language->set(
					'adminsys', $lang, $this->component->get('name')
				);
			}

			$menus .= $this->dashboardEntry($codeName, $lang);

			// loop over the admin views
			foreach ($this->component->get('admin_views') as $view)
			{
				// set custom menu
				$menus .= $this->custommainmenu->get($view, $codeName, $lang);
				if (isset($view['mainmenu']) && $view['mainmenu'] == 1)
				{
					$nameList  = StringHelper::safe(
						$view['settings']->name_list
					);
					$nameUpper = StringHelper::safe(
						$view['settings']->name_list, 'U'
					);
					$menus     .= PHP_EOL . Indent::_(3) . '<menu option="com_'
						. $codeName . '" view="' . $nameList . '">' . $lang
						. '_' . $nameUpper . '</menu>';
					$this->language->set(
						'adminsys', $lang . '_' . $nameUpper,
						$view['settings']->name_list
					);
				}
			}
			// the entries the custom main menus held back are taken, which is
			// what the unset here used to do once they had been read
			$deferred = $this->custommainmenu->takeDeferred();

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

	/**
	 * Build the entry that reaches the default dashboard.
	 *
	 * A component that builds a dashboard of its own already has an entry that
	 * reaches it, and gets none from here.
	 *
	 * @param   string  $codeName  The component code name.
	 * @param   string  $lang      The menu language prefix.
	 *
	 * @return  string  The entry, or nothing when the component builds its own dashboard.
	 *
	 * @since   6.1.7
	 */
	protected function dashboardEntry(string $codeName, string $lang): string
	{
		if ($this->registry->get('build.dashboard', null) !== null)
		{
			return '';
		}

		// built first and registered after, in the order the caller had them
		$entry = PHP_EOL . Indent::_(3) . '<menu option="com_'
			. $codeName . '" view="' . $codeName . '">' . $lang
			. '_DASHBOARD</menu>';

		$this->language->set('adminsys', $lang . '_DASHBOARD', 'Dashboard');

		return $entry;
	}
}

