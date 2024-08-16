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

namespace VDM\Joomla\Componentbuilder\Compiler\Component;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Component\SettingsInterface as Settings;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Model\Createdate;
use VDM\Joomla\Componentbuilder\Compiler\Model\Modifieddate;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;


/**
 * Multiple Files and Folders Builder Class
 * 
 * @since 3.2.0
 */
final class Structuremultiple
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Component Joomla Version Settings
	 *
	 * @var    Settings
	 * @since 3.2.0
	 */
	protected Settings $settings;

	/**
	 * Compiler Component
	 *
	 * @var    Component
	 * @since 3.2.0
	 **/
	protected Component $component;

	/**
	 * Compiler Model Createdate
	 *
	 * @var    Createdate
	 * @since 3.2.0
	 **/
	protected Createdate $createdate;

	/**
	 * Compiler Model Modifieddate
	 *
	 * @var    Modifieddate
	 * @since 3.2.0
	 **/
	protected Modifieddate $modifieddate;

	/**
	 * Compiler Utility to Build Structure
	 *
	 * @var    Structure
	 * @since 3.2.0
	 **/
	protected Structure $structure;

	/**
	 * Constructor
	 *
	 * @param Config|null           $config           The compiler config object.
	 * @param Registry|null         $registry         The compiler registry object.
	 * @param Settings|null    	    $settings         The compiler component Joomla version settings object.
	 * @param Component|null        $component        The component class.
	 * @param Createdate|null       $createdate       The compiler model to get create date class.
	 * @param Modifieddate|null     $modifieddate     The compiler model to get modified date class.
	 * @param Structure|null        $structure        The compiler structure to build dynamic folder and files class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?Settings $settings = null, ?Component $component = null,
		?Createdate $createdate = null, ?Modifieddate $modifieddate = null,
		?Structure $structure = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->settings = $settings ?: Compiler::_('Component.Settings');
		$this->component = $component ?: Compiler::_('Component');
		$this->createdate = $createdate ?: Compiler::_('Model.Createdate');
		$this->modifieddate = $modifieddate ?: Compiler::_('Model.Modifieddate');
		$this->structure = $structure ?: Compiler::_('Utilities.Structure');
	}

	/**
	 * Build the Multiple Files & Folders
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function build(): bool
	{
		$success = false;

		if ($this->settings->exists())
		{
			$success = $this->admin();
			$success = $this->site() || $success;
			$success = $this->custom() || $success;
		}

		return $success;
	}

	/**
	 * Build the Dynamic Admin Files & Folders
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function admin(): bool
	{
		if (!$this->component->isArray('admin_views'))
		{
			return false;
		}

		// check if we have a dynamic dashboard
		if (!$this->registry->get('build.dashboard'))
		{
			// setup the default dashboard
			$target = ['admin' => $this->component->get('name_code')];
			$this->structure->build($target, 'dashboard');
		}

		$config = [];
		$checkin = false;
		$api = null;

		foreach ($this->component->get('admin_views') as $view)
		{
			if (!$this->isValidAdminView($view, $config))
			{
				continue;
			}

			$this->buildAdminView($view, $config);

			// quick set of checkin once
			if (!$checkin && isset($view['checkin']) && $view['checkin'] == 1)
			{
				// switch to add checking to config
				$checkin = true;
				$this->config->set('add_checkin', $checkin);
			}

			if (($target = $this->hasApi($view)) > 0)
			{
				$this->buildApi($view, $config, $target);
				$api = 1;
			}
		}

		$this->config->set('add_api', $api);

		return true;
	}

	/**
	 * Build the Dynamic Site Files & Folders
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function site(): bool
	{
		if (!$this->component->isArray('site_views'))
		{
			return false;
		}

		$config = [];

		foreach ($this->component->get('site_views') as $view)
		{
			if (!$this->isValidView($view, $config))
			{
				continue;
			}

			$this->buildView($view, $config, 'site');
		}

		return true;
	}

	/**
	 * Build the Dynamic Custom Admin Files & Folders
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function custom(): bool
	{
		if (!$this->component->isArray('custom_admin_views'))
		{
			return false;
		}

		$config = [];

		foreach ($this->component->get('custom_admin_views') as $view)
		{
			if (!$this->isValidView($view, $config))
			{
				continue;
			}

			$this->buildView($view, $config, 'custom_admin');
		}

		return true;
	}

	/**
	 * Check if the view is a valid view
	 *
	 * @param array $view
	 * @param array $config
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	private function isValidAdminView(array $view, array &$config): bool
	{
		if (!isset($view['settings']) || !ObjectHelper::check($view['settings'])
			|| ((!isset($view['settings']->name_list) || $view['settings']->name_list == 'null')
				&& (!isset($view['settings']->name_single) || $view['settings']->name_single == 'null')))
		{
			return false;
		}

		$created = $this->createdate->get($view);
		$modified = $this->modifieddate->get($view);

		$config = [
			Placefix::_h('CREATIONDATE') => $created,
			Placefix::_h('BUILDDATE') => $modified,
			Placefix::_h('VERSION') => $view['settings']->version
		];

		return true;
	}

	/**
	 * Check if the view has an API
	 *
	 * @param array $view
	 *
	 * @return int
	 * @since  5.0.2
	 */
	private function hasApi(array $view): int
	{
		// only for Joomla 4 and above
		if ($this->config->get('joomla_version', 3) < 4 || !isset($view['add_api']))
		{
			return 0;
		}

		return (int) $view['add_api'];
	}

	/**
	 * Check if the view is a valid view
	 *
	 * @param array $view
	 * @param array $config
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	private function isValidView(array $view, array &$config): bool
	{
		if (!isset($view['settings']) || !ObjectHelper::check($view['settings'])
			|| !isset($view['settings']->main_get)
			|| !ObjectHelper::check($view['settings']->main_get)
			|| !isset($view['settings']->main_get->gettype)
			|| ($view['settings']->main_get->gettype != 1 && $view['settings']->main_get->gettype != 2))
		{
			return false;
		}

		$created = $this->createdate->get($view);
		$modified = $this->modifieddate->get($view);

		$config = [
			Placefix::_h('CREATIONDATE') => $created,
			Placefix::_h('BUILDDATE') => $modified,
			Placefix::_h('VERSION') => $view['settings']->version
		];

		return true;
	}

	/**
	 * Build the admin view
	 *
	 * @param array  $view
	 * @param array  $config
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function buildAdminView(array $view, array $config)
	{
		// build the admin edit view
		if ($view['settings']->name_single != 'null')
		{
			$target = ['admin' => $view['settings']->name_single];
			$this->structure->build($target, 'single', false, $config);

			// build the site edit view (of this admin view)
			if (isset($view['edit_create_site_view'])
				&& is_numeric($view['edit_create_site_view'])
				&& $view['edit_create_site_view'] > 0)
			{
				// setup the front site edit-view files
				$target = ['site' => $view['settings']->name_single];
				$this->structure->build($target, 'edit', false, $config);
			}
		}

		// build the list view
		if ($view['settings']->name_list != 'null')
		{
			$target = ['admin' => $view['settings']->name_list];
			$this->structure->build($target, 'list', false, $config);
		}
	}

	/**
	 * Build the api
	 *
	 * @param array  $view
	 * @param array  $config
	 * @param int    $targetArea
	 *
	 * @return void
	 * @since  5.0.2
	 */
	private function buildApi(array $view, array $config, int $targetArea)
	{
		$settings = $view['settings'];

		// build the api
		if ($settings->name_single != 'null' && $targetArea !== 1)
		{
			$target = ['api' => $settings->name_single];
			$this->structure->build($target, 'single', false, $config);
		}

		// build the list view
		if ($settings->name_list != 'null' && $targetArea !== 3)
		{
			$target = ['api' => $settings->name_list];
			$this->structure->build($target, 'list', false, $config);
		}
	}

	/**
	 * Build the custom view
	 *
	 * @param array  $view
	 * @param array  $config
	 * @param string $type
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function buildView(array $view, array $config, string $type)
	{
		$target = [$type => $view['settings']->code];
		$view_type = ($view['settings']->main_get->gettype == 1) ? 'single' : 'list';

		$this->structure->build($target, $view_type, false, $config);
	}
}

