<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Dashboard;


use Joomla\Filesystem\File;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryOtherName;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Dashboard Icons Class.
 * 
 * Builds the icon set the component dashboard renders: one icon per admin
 * view the user may reach, the extra icons a custom admin view adds, and the
 * category icons of any categorised view.
 * 
 * The icons read the same on every Joomla target, so this is one class.
 * 
 * @since  6.1.7
 */
final class Icons
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

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
	 * The Category Class.
	 *
	 * @var   Category
	 * @since 6.1.7
	 */
	protected Category $category;

	/**
	 * The Category Other Name Class.
	 *
	 * @var   CategoryOtherName
	 * @since 6.1.7
	 */
	protected CategoryOtherName $categoryothername;

	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 6.1.7
	 */
	protected Paths $paths;

	/**
	 * The icons collected while building, keyed by their target path.
	 *
	 * The legacy helper kept this on itself and shared it between the two
	 * methods below, which were its only readers and writers.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $iconBuilder = [];

	/**
	 * The trailing custom dashboard icon arguments, when any were added.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected $lastCustomDashboardIcon;

	/**
	 * The custom admin views already added, as the compiler cached them.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $customAdminAdded = [];

	/**
	 * Constructor.
	 *
	 * @param Config             $config              The Config Class.
	 * @param Component          $component           The Component Class.
	 * @param Language           $language            The Language Class.
	 * @param Category           $category            The Category Class.
	 * @param CategoryOtherName  $categoryothername   The Category Other Name Class.
	 * @param Paths              $paths               The Paths Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Component $component,
		Language $language,
		Category $category,
		CategoryOtherName $categoryothername,
		Paths $paths)
	{
		$this->config = $config;
		$this->component = $component;
		$this->language = $language;
		$this->category = $category;
		$this->categoryothername = $categoryothername;
		$this->paths = $paths;
	}

	/**
	 * Build the dashboard icon set of the component.
	 *
	 * @param   array  $customAdminAdded  The custom admin views already added.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(array $customAdminAdded = [])
	{
		$this->customAdminAdded = $customAdminAdded;

		if ($this->component->isArray('admin_views'))
		{
			$icons    = '';
			$counter  = 0;
			$catArray = [];
			foreach ($this->component->get('admin_views') as $view)
			{
				$name_single = StringHelper::safe(
					$view['settings']->name_single
				);
				$name_list   = StringHelper::safe(
					$view['settings']->name_list
				);

				$icons .= $this->getCustomIcons($view, $counter);
				if (isset($view['dashboard_add'])
					&& $view['dashboard_add'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo(
						$view['settings']->icon_add
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $name_single . ".add"]
							= $view['settings']->icon_add;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'" . $type . $name_single . ".add'";
					}
					else
					{
						$icons .= ", '" . $type . $name_single . ".add'";
					}
					// build lang
					$langName = 'Add&nbsp;'
						. StringHelper::safe(
							$view['settings']->name_single, 'W'
						) . '<br /><br />';
					$langKey  = $this->config->lang_prefix . '_DASHBOARD_'
						. StringHelper::safe(
							$view['settings']->name_single, 'U'
						) . '_ADD';
					// add to lang
					$this->language->set($this->config->lang_target, $langKey, $langName);
					$counter++;
				}
				if (isset($view['dashboard_list'])
					&& $view['dashboard_list'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo(
						$view['settings']->icon
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $name_list]
							= $view['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'" . $type . $name_list . "'";
					}
					else
					{
						$icons .= ", '" . $type . $name_list . "'";
					}
					// build lang
					$langName = StringHelper::safe(
							$view['settings']->name_list, 'W'
						) . '<br /><br />';
					$langKey  = $this->config->lang_prefix . '_DASHBOARD_'
						. StringHelper::safe(
							$view['settings']->name_list, 'U'
						);
					// add to lang
					$this->language->set($this->config->lang_target, $langKey, $langName);
					$counter++;
				}
				// dashboard link to category on dashboard is build here
				if ($this->category->exists("{$name_list}.code") &&
					$this->category->get("{$name_list}.add_icon"))
				{
					$catCode = $this->category->get("{$name_list}.code");

					// check if category has another name
					$otherViews = $this->categoryothername->
						get($name_list . '.views', $name_list);
					$otherNames  = $this->categoryothername->
						get($name_list . '.name');
					if ($otherNames !== null)
					{
						// build lang
						$langName = StringHelper::safe(
							$otherNames, 'W'
						);
					}
					else
					{
						// build lang
						$langName = 'Categories&nbsp;For<br />'
							. StringHelper::safe(
								$otherViews, 'W'
							);
					}
					// only load this category once
					if (!in_array($otherViews, $catArray))
					{
						// set the extension key string, new convention (more stable)
						$_key_extension = str_replace(
							'.', '_po0O0oq_',
							(string) $this->category->get("{$name_list}.extension", 'error')
						);

						// add to lang
						$langKey = $this->config->lang_prefix . '_DASHBOARD_'
							. StringHelper::safe(
								$otherViews, 'U'
							) . '_' . StringHelper::safe(
								$catCode, 'U'
							);
						$this->language->set($this->config->lang_target, $langKey, $langName);
						// get image type
						$type = ComponentbuilderHelper::imageInfo(
							$view['settings']->icon_category
						);
						if ($type)
						{
							$type = $type . ".";
							// icon builder loader
							$this->iconBuilder[$type . $otherViews . "."
							. $catCode]
								= $view['settings']->icon_category;
						}
						else
						{
							$type = 'png.';
						}
						if ($counter == 0)
						{
							$icons .= "'" . $type . $otherViews . "." . $catCode
								. '_qpo0O0oqp_' . $_key_extension . "'";
						}
						else
						{
							$icons .= ", '" . $type . $otherViews . "."
								. $catCode . '_qpo0O0oqp_' . $_key_extension
								. "'";
						}
						$counter++;
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
				}
			}
			if (isset($this->lastCustomDashboardIcon)
				&& ArrayHelper::check(
					$this->lastCustomDashboardIcon
				))
			{
				foreach ($this->lastCustomDashboardIcon as $icon)
				{
					$icons .= $icon;
				}
				unset($this->lastCustomDashboardIcon);
			}
			if (isset($this->iconBuilder)
				&& ArrayHelper::check(
					$this->iconBuilder
				))
			{
				$imagePath = $this->paths->component_path
					. '/admin/assets/images/icons';
				foreach ($this->iconBuilder as $icon => $path)
				{
					$array_buket = explode('.', (string) $icon);
					if (count((array) $array_buket) == 3)
					{
						list($type, $name, $action) = $array_buket;
					}
					else
					{
						list($type, $name) = $array_buket;
						$action = false;
					}
					// set the new image name
					if ($action)
					{
						$imageName = $name . '_' . $action . '.' . $type;
					}
					else
					{
						$imageName = $name . '.' . $type;
					}
					// move the image to its place
					File::copy(
						JPATH_SITE . '/' . $path, $imagePath . '/' . $imageName
					);
				}
			}

			return $icons;
		}

		return false;
	}

	/**
	 * Add the dashboard icons one custom admin view contributes.
	 *
	 * @param   object  $view              The custom admin view.
	 * @param   int     $counter           The icon counter.
	 * @param   array   $customAdminAdded  The custom admin views already added.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function getCustomIcons(&$view, &$counter, ?array $customAdminAdded = null)
	{
		if ($customAdminAdded !== null)
		{
			$this->customAdminAdded = $customAdminAdded;
		}

		$icon = '';
		if ($this->component->isArray('custom_admin_views'))
		{
			foreach ($this->component->get('custom_admin_views') as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code])
					&& isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& $menu['before'] == $view['adminview'])
				{
					$type = ComponentbuilderHelper::imageInfo(
						$menu['settings']->icon
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $menu['settings']->code]
							= $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName = $menu['settings']->name . '<br /><br />';
					$langKey  = $this->config->lang_prefix . '_DASHBOARD_'
						. $menu['settings']->CODE;
					// add to lang
					$this->language->set($this->config->lang_target, $langKey, $langName);
					// set icon
					if ($counter == 0)
					{
						$counter++;
						$icon .= "'" . $type . $menu['settings']->code . "'";
					}
					else
					{
						$counter++;
						$icon .= ", '" . $type . $menu['settings']->code . "'";
					}
				}
				elseif (!isset($this->customAdminAdded[$menu['settings']->code])
					&& isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& empty($menu['before']))
				{
					$type = ComponentbuilderHelper::imageInfo(
						$menu['settings']->icon
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $menu['settings']->code]
							= $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName = $menu['settings']->name . '<br /><br />';
					$langKey  = $this->config->lang_prefix . '_DASHBOARD_'
						. $menu['settings']->CODE;
					// add to lang
					$this->language->set($this->config->lang_target, $langKey, $langName);
					// set icon
					$this->lastCustomDashboardIcon[$nr] = ", '" . $type
						. $menu['settings']->code . "'";
				}
			}
		}
		// see if we should have custom menus
		if ($this->component->isArray('custommenus'))
		{
			foreach ($this->component->get('custommenus') as $nr => $menu)
			{
				$nr        = $nr + 100;
				$nameList  = StringHelper::safe(
					$menu['name_code']
				);
				$nameUpper = StringHelper::safe(
					$menu['name_code'], 'U'
				);
				if (isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& $view['adminview'] == $menu['before'])
				{
					$type = ComponentbuilderHelper::imageInfo(
						'images/' . $menu['icon']
					);
					if ($type)
					{
						// icon builder loader
						$this->iconBuilder[$type . "." . $nameList] = 'images/'
							. $menu['icon'];
					}
					else
					{
						$type = 'png';
					}
					// build lang
					$langName = $menu['name'] . '<br /><br />';
					$langKey  = $this->config->lang_prefix . '_DASHBOARD_' . $nameUpper;
					// add to lang
					$this->language->set($this->config->lang_target, $langKey, $langName);

					// if this is a link build the icon values with pipe
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						// set icon
						if ($counter == 0)
						{
							$counter++;
							$icon .= "'" . $type . "||" . $nameList . "||"
								. $menu['link'] . "'";
						}
						else
						{
							$counter++;
							$icon .= ", '" . $type . "||" . $nameList . "||"
								. $menu['link'] . "'";
						}
					}
					else
					{
						// set icon
						if ($counter == 0)
						{
							$counter++;
							$icon .= "'" . $type . "." . $nameList . "'";
						}
						else
						{
							$counter++;
							$icon .= ", '" . $type . "." . $nameList . "'";
						}
					}
				}
				elseif (isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& empty($menu['before']))
				{
					$type = ComponentbuilderHelper::imageInfo(
						'images/' . $menu['icon']
					);
					if ($type)
					{
						// icon builder loader
						$this->iconBuilder[$type . "." . $nameList] = 'images/'
							. $menu['icon'];
					}
					else
					{
						$type = 'png';
					}
					// build lang
					$langName = $menu['name'] . '<br /><br />';
					$langKey  = $this->config->lang_prefix . '_DASHBOARD_' . $nameUpper;
					// add to lang
					$this->language->set($this->config->lang_target, $langKey, $langName);

					// if this is a link build the icon values with pipe
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '" . $type
							. "||" . $nameList . "||" . $menu['link'] . "'";
					}
					else
					{
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '" . $type
							. "." . $nameList . "'";
					}
				}
			}
		}

		return $icon;
	}
}

