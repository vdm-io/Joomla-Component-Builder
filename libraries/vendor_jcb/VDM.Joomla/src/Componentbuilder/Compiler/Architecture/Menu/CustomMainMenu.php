<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Menu;


use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Menu Custom Main Menu Class.
 * 
 * Builds the admin menu entries a component declares for its custom admin
 * views and its own custom menus, and registers each entry's label for
 * translation.
 * 
 * An entry that names no view to sit before cannot be placed while the views
 * are still being walked, so it is held back. The caller collects those with
 * takeDeferred() once the walk is done and appends them last.
 * 
 * @since  6.1.7
 */
final class CustomMainMenu
{
	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The menu entries that must be placed after every view has been walked.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $deferred = [];

	/**
	 * Constructor.
	 *
	 * @param Component  $component  The Component Class.
	 * @param Language   $language   The Language Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Component $component, Language $language)
	{
		$this->component = $component;
		$this->language = $language;
	}

	/**
	 * Build the custom menu entries that sit before the given admin view.
	 *
	 * @param   array   $view              The admin view being walked.
	 * @param   string  $codeName          The component code name.
	 * @param   string  $lang              The menu language prefix.
	 * @param   array   $customAdminAdded  The custom admin views already placed.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(array $view, string $codeName, string $lang,
		array $customAdminAdded = []): string
	{
		$customMenu = '';
		// see if we should have custom admin views
		if ($this->component->isArray('custom_admin_views'))
		{
			foreach ($this->component->get('custom_admin_views') as $nr => $menu)
			{
				if (!isset($customAdminAdded[$menu['settings']->code]))
				{
					if (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
						&& $view['adminview'] == $menu['before'])
					{
						$this->language->set(
							'adminsys', $lang . '_' . $menu['settings']->CODE,
							$menu['settings']->name
						);
						// add custom menu
						$customMenu .= PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $menu['settings']->code . '">' . $lang . '_'
							. $menu['settings']->CODE . '</menu>';
					}
					elseif (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
						&& empty($menu['before']))
					{
						$this->language->set(
							'adminsys', $lang . '_' . $menu['settings']->CODE,
							$menu['settings']->name
						);
						// add custom menu
						$this->deferred[$nr] = PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $menu['settings']->code . '">' . $lang . '_'
							. $menu['settings']->CODE . '</menu>';
					}
				}
			}
		}
		// see if we should have custom menus
		if ($this->component->isArray('custommenus'))
		{
			foreach ($this->component->get('custommenus') as $nr => $menu)
			{
				$nr = $nr + 100;
				if (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
					&& $view['adminview'] == $menu['before'])
				{
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						$nameList  = StringHelper::safe(
							$menu['name']
						);
						$nameUpper = StringHelper::safe(
							$menu['name'], 'U'
						);
						$this->language->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// sanitize url
						if (strpos((string) $menu['link'], 'http') === false)
						{
							$menu['link'] = str_replace(
								'/administrator/index.php?', '', (string) $menu['link']
							);
							$menu['link'] = str_replace(
								'administrator/index.php?', '', $menu['link']
							);
							// check if the index is still there
							if (strpos($menu['link'], 'index.php?') !== false)
							{
								$menu['link'] = str_replace(
									'/index.php?', '', $menu['link']
								);
								$menu['link'] = str_replace(
									'index.php?', '', $menu['link']
								);
							}
						}
						// urlencode
						$menu['link'] = htmlspecialchars(
							(string) $menu['link'], ENT_XML1, 'UTF-8'
						);
						// add custom menu
						$customMenu .= PHP_EOL . Indent::_(3) . '<menu link="'
							. $menu['link'] . '">' . $lang . '_' . $nameUpper
							. '</menu>';
					}
					else
					{
						$nameList  = StringHelper::safe(
							$menu['name_code']
						);
						$nameUpper = StringHelper::safe(
							$menu['name_code'], 'U'
						);
						$this->language->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// add custom menu
						$customMenu .= PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $nameList . '">' . $lang . '_' . $nameUpper
							. '</menu>';
					}
				}
				elseif (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
					&& empty($menu['before']))
				{
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						$nameList  = StringHelper::safe(
							$menu['name']
						);
						$nameUpper = StringHelper::safe(
							$menu['name'], 'U'
						);
						$this->language->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// sanitize url
						if (strpos((string) $menu['link'], 'http') === false)
						{
							$menu['link'] = str_replace(
								'/administrator/index.php?', '', (string) $menu['link']
							);
							$menu['link'] = str_replace(
								'administrator/index.php?', '', $menu['link']
							);
							// check if the index is still there
							if (strpos($menu['link'], 'index.php?') !== false)
							{
								$menu['link'] = str_replace(
									'/index.php?', '', $menu['link']
								);
								$menu['link'] = str_replace(
									'index.php?', '', $menu['link']
								);
							}
						}
						// urlencode
						$menu['link'] = htmlspecialchars(
							(string) $menu['link'], ENT_XML1, 'UTF-8'
						);
						// add custom menu
						$this->deferred[$nr] = PHP_EOL . Indent::_(3)
							. '<menu link="' . $menu['link'] . '">' . $lang
							. '_' . $nameUpper . '</menu>';
					}
					else
					{
						$nameList  = StringHelper::safe(
							$menu['name_code']
						);
						$nameUpper = StringHelper::safe(
							$menu['name_code'], 'U'
						);
						$this->language->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// add custom menu
						$this->deferred[$nr] = PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $nameList . '">' . $lang . '_' . $nameUpper
							. '</menu>';
					}
				}
			}
		}

		return $customMenu;
	}

	/**
	 * Take the entries held back for the end of the menu, and forget them.
	 *
	 * @return  array
	 *
	 * @since   6.1.7
	 */
	public function takeDeferred(): array
	{
		$deferred = $this->deferred;
		$this->deferred = [];

		return $deferred;
	}
}

