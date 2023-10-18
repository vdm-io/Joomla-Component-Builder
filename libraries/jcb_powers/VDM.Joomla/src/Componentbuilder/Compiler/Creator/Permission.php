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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionCore;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionViews;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionAction;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionComponent;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionGlobalAction;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionDashboard;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Permission Creator Class
 * 
 * @since 3.2.0
 */
final class Permission
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The PermissionCore Class.
	 *
	 * @var   PermissionCore
	 * @since 3.2.0
	 */
	protected PermissionCore $permissioncore;

	/**
	 * The PermissionViews Class.
	 *
	 * @var   PermissionViews
	 * @since 3.2.0
	 */
	protected PermissionViews $permissionviews;

	/**
	 * The PermissionAction Class.
	 *
	 * @var   PermissionAction
	 * @since 3.2.0
	 */
	protected PermissionAction $permissionaction;

	/**
	 * The PermissionComponent Class.
	 *
	 * @var   PermissionComponent
	 * @since 3.2.0
	 */
	protected PermissionComponent $permissioncomponent;

	/**
	 * The PermissionGlobalAction Class.
	 *
	 * @var   PermissionGlobalAction
	 * @since 3.2.0
	 */
	protected PermissionGlobalAction $permissionglobalaction;

	/**
	 * The PermissionDashboard Class.
	 *
	 * @var   PermissionDashboard
	 * @since 3.2.0
	 */
	protected PermissionDashboard $permissiondashboard;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The permissions
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $permissions;

	/**
	 * The Name List View
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $nameList;

	/**
	 * The Lowercase Name List View
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $nameListLower;

	/**
	 * The Lowercase Name Single View
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $nameSingleLower;

	/**
	 * Constructor.
	 *
	 * @param Config                   $config                   The Config Class.
	 * @param PermissionCore           $permissioncore           The PermissionCore Class.
	 * @param PermissionViews          $permissionviews          The PermissionViews Class.
	 * @param PermissionAction         $permissionaction         The PermissionAction Class.
	 * @param PermissionComponent      $permissioncomponent      The PermissionComponent Class.
	 * @param PermissionGlobalAction   $permissionglobalaction   The PermissionGlobalAction Class.
	 * @param PermissionDashboard      $permissiondashboard      The PermissionDashboard Class.
	 * @param Counter                  $counter                  The Counter Class.
	 * @param Language                 $language                 The Language Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, PermissionCore $permissioncore, PermissionViews $permissionviews,
		PermissionAction $permissionaction, PermissionComponent $permissioncomponent, PermissionGlobalAction $permissionglobalaction,
		PermissionDashboard $permissiondashboard, Counter $counter, Language $language)
	{
		$this->config = $config;
		$this->permissioncore = $permissioncore;
		$this->permissionviews = $permissionviews;
		$this->permissionaction = $permissionaction;
		$this->permissioncomponent = $permissioncomponent;
		$this->permissionglobalaction = $permissionglobalaction;
		$this->permissiondashboard = $permissiondashboard;
		$this->counter = $counter;
		$this->language = $language;
	}

	/**
	 * Get the permission action
	 *
	 * @param   string  $nameView      View Single Code Name
	 * @param   string  $action        The Permission Action
	 *
	 * @return  string|null   The action name if set
	 * @since 3.2.0
	 */
	public function getAction(string $nameView, string $action): ?string
	{
		if (($set_action = $this->getCore($nameView, $action)) !== null &&
			$this->permissionaction->exists("{$set_action}|{$nameView}"))
		{
			return $set_action;
		}

		return $action;
	}

	/**
	 * Get the global permission action
	 *
	 * @param   string  $nameView         View Single Code Name
	 * @param   string  $action           The Permission Action
	 *
	 * @return  string    The action name if set
	 * @since 3.2.0
	 */
	public function getGlobal(string $nameView, string $action): string
	{
		if (($set_action = $this->getCore($nameView, $action)) !== null &&
			$this->permissionglobalaction->exists("{$set_action}|{$nameView}"))
		{
			return $set_action;
		}

		return $action;
	}

	/**
	 * Check if the permission action exist
	 *
	 * @param   string  $nameView       View Single Code Name
	 * @param   string  $action         The Permission Action
	 *
	 * @return  bool    true if it exist
	 * @since 3.2.0
	 */
	public function actionExist(string $nameView, string $action): bool
	{
		if (($set_action = $this->getCore($nameView, $action)) !== null &&
			$this->permissionaction->exists("{$set_action}|{$nameView}"))
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if the global permission action exist
	 *
	 * @param   string  $nameView       View Single Code Name
	 * @param   string  $action         The Permission Action
	 *
	 * @return  bool    true if it exist
	 * @since 3.2.0
	 */
	public function globalExist(string $nameView, string $action): bool
	{
		if (($set_action = $this->getCore($nameView, $action)) !== null &&
			$this->permissionglobalaction->exists("{$set_action}|{$nameView}"))
		{
			return true;
		}

		return false;
	}

	/**
	 * Set the permissions
	 *
	 * @param   array   $view             View details
	 * @param   string  $nameView         View Single Code Name
	 * @param   string  $nameViews        View List Code Name
	 * @param   array   $menuControllers  Menu Controllers
	 * @param   string  $type             Type of permissions area
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(array &$view, string $nameView, string $nameViews, array $menuControllers, string $type = 'admin'): void
	{
		if ($this->initialise($view, $type))
		{
			$this->build($view, $nameView, $nameViews, $menuControllers, $type);
		}
	}

	/**
	 * Build of permissions
	 *
	 * @param   array   $view             View details
	 * @param   string  $nameView         View Single Code Name
	 * @param   string  $nameViews        View List Code Name
	 * @param   array   $menuControllers  Menu Controllers
	 * @param   string  $type             Type of permissions area
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function build(array &$view, string $nameView, string $nameViews,
		array $menuControllers, string $type = 'admin'): void
	{
		// load the permissions
		foreach ($this->permissions as &$permission)
		{
			// set action name
			$arr = explode('.', trim((string) $permission['action']));
			if ($arr[0] != 'core' || $arr[0] === 'view')
			{
				array_shift($arr);
				$action_main = implode('.', $arr);
				$action = $nameView . '.' . $action_main;
			}
			else
			{
				if ($arr[0] === 'core')
				{
					// core is already set in global access
					$permission['implementation'] = 1;
				}

				$action = $permission['action'];
			}

			// build action name
			$action_name_builder = explode('.', trim((string) $permission['action']));
			array_shift($action_name_builder);
			$name_builder = trim(implode('___', $action_name_builder));
			$custom_name = trim(implode(' ', $action_name_builder));

			// check if we have access set for this view (if not skip)
			if ($name_builder === 'edit___access' && $type === 'admin'
				&& (!isset($view['access']) || $view['access'] != 1))
			{
				continue;
			}

			// set the names
			$this->setNames($view['settings'], $custom_name, $type);

			// set title (only if not set already)
			if (!isset($permission['title']) || !StringHelper::check($permission['title']))
			{
				$permission['title'] = $this->getTitle($name_builder, $custom_name);
			}

			// set description (only if not set already)
			if (!isset($permission['description']) || !StringHelper::check($permission['description']))
			{
				$permission['description'] = $this->getDescription($name_builder, $custom_name);
			}

			// if core is not used update all core strings
			$core_check = explode('.', (string) $action);
			$core_check[0] = 'core';
			$core_target = implode('.', $core_check);

			$this->permissioncore->set("{$nameView}|{$core_target}", $action);

			// set array sort name
			$sort_key = StringHelper::safe($permission['title']);

			// set title
			$title = $this->config->lang_prefix . '_' . StringHelper::safe($permission['title'], 'U');

			// load the actions
			if ($permission['implementation'] == 1)
			{
				// only related to view
				$this->permissionviews->set("{$nameView}|{$action}", [
					'name' => $action,
					'title' => $title,
					'description' => "{$title}_DESC"
				]);

				// load permission to action
				$this->permissionaction->set("{$action}|{$nameView}", $nameView);
			}
			elseif ($permission['implementation'] == 2)
			{
				// relation to whole component
				$this->permissioncomponent->set($sort_key, [
					'name' => $action,
					'title' => $title,
					'description' => "{$title}_DESC"
				]);

				// the size needs increase
				$this->counter->accessSize++;

				// build permission switch
				$this->permissionglobalaction->set("{$action}|{$nameView}", $nameView);

				// add menu control view that has menus options
				$this->setDashboard($nameView, $nameViews, $menuControllers, $action, $core_target);
			}
			elseif ($permission['implementation'] == 3)
			{
				// only related to view
				$this->permissionviews->set("{$nameView}|{$action}", [
					'name' => $action,
					'title' => $title,
					'description' => "{$title}_DESC"
				]);

				// load permission to action
				$this->permissionaction->set("{$action}|{$nameView}", $nameView);

				// relation to whole component
				$this->permissioncomponent->set($sort_key, [
					'name' => $action,
					'title' => $title,
					'description' => "{$title}_DESC"
				]);

				// the size needs increase
				$this->counter->accessSize++;

				// build permission switch
				$this->permissionglobalaction->set("{$action}|{$nameView}", $nameView);

				// add menu control view that has menus options
				$this->setDashboard($nameView, $nameViews, $menuControllers, $action, $core_target);
			}

			// set to language file
			$this->language->set(
				'bothadmin', $title, $permission['title']
			);

			$this->language->set(
				'bothadmin',  "{$title}_DESC", $permission['description']
			);
		}

		// update permissions
		$view['settings']->permissions = $this->permissions;
	}

	/**
	 * Set dashboard permissions
	 *
	 * @param   string  $nameView         View Single Code Name
	 * @param   string  $nameViews        View List Code Name
	 * @param   array   $menuControllers  Menu Controllers
	 * @param   string  $action           The targeted action
	 * @param   string  $coreTarget       The core target
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setDashboard(string $nameView, string $nameViews,
		array $menuControllers, string $action, string $coreTarget): void
	{
		// dashboard icon checker
		if ($coreTarget === 'core.access')
		{
			$this->permissiondashboard->set(
				"{$nameViews}.access", $action
			);
			$this->permissiondashboard->set(
				"{$nameView}.access", $action
			);
		}

		if ($coreTarget === 'core.create')
		{
			$this->permissiondashboard->set(
				"{$nameView}.create", $action
			);
		}

		// add menu control view that has menus options
		foreach ($menuControllers as $menu_controller)
		{
			if ($coreTarget === 'core.' . $menu_controller)
			{
				if ($menu_controller === 'dashboard_add')
				{
					$this->permissiondashboard->set(
						"{$nameView}.{$menu_controller}", $action
					);
				}
				else
				{
					$this->permissiondashboard->set(
						"{$nameViews}.{$menu_controller}", $action
					);
				}
			}
		}
	}

	/**
	 * Initialise build of permissions
	 *
	 * @param   array   $view    View details
	 * @param   string  $type    Type of permissions area
	 *
	 * @return  bool   true if build can continue
	 * @since 3.2.0
	 */
	private function initialise(array $view, string $type): bool
	{
		if (isset($view['settings']) && (isset($view['settings']->permissions)
			&& ArrayHelper::check($view['settings']->permissions)
			|| (isset($view['port']) && $view['port'])
			|| (isset($view['history']) && $view['history'])))
		{
			if (isset($view['settings']->permissions)
				&& ArrayHelper::check($view['settings']->permissions))
			{
				$this->permissions = $view['settings']->permissions;
			}
			else
			{
				$this->permissions = [];
			}

			$this->initPort($view['port'] ?? 0);
			$this->initHistory($view['history'] ?? 0);
			$this->initBatch($type);

			return true;
		}

		return false;
	}

	/**
	 * Initialise build of import and export permissions
	 *
	 * @param   int   $port    The port adding switch
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function initPort(int $port): void
	{
		if ($port)
		{
			// export
			$add = [];
			$add['action'] = 'view.export';
			$add['implementation'] = '2';
			array_push($this->permissions, $add);

			// import
			$add = [];
			$add['action'] = 'view.import';
			$add['implementation'] = '2';
			array_push($this->permissions, $add);
		}
	}

	/**
	 * Initialise build of history permissions
	 *
	 * @param   int   $history    The history adding switch
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function initHistory(int $history): void
	{
		if ($history)
		{
			// export
			$add = [];
			$add['action'] = 'view.version';
			$add['implementation'] = '3';
			array_push($this->permissions, $add);
		}
	}

	/**
	 * Initialise build of batch permissions
	 *
	 * @param   string   $type   Type of permissions area
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function initBatch(string $type): void
	{
		// add batch permissions
		if ($type === 'admin')
		{
			// set batch control
			$add = [];
			$add['action'] = 'view.batch';
			$add['implementation'] = '2';
			array_push($this->permissions, $add);
		}
	}

	/**
	 * Initialise build of names used in permissions
	 *
	 * @param   object   $settings    The view settings object
	 * @param   string   $customName  The custom name
	 * @param   string   $type        Type of permissions area
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setNames(object $settings, string $customName, string $type): void
	{
		// build the names
		if ($type === 'admin')
		{
			$this->nameList = StringHelper::safe(
				$settings->name_list, 'W'
			);
			$this->nameListLower = StringHelper::safe(
				$customName . ' ' . $settings->name_list, 'w'
			);
			$this->nameSingleLower = StringHelper::safe(
				$settings->name_single, 'w'
			);
		}
		elseif ($type === 'customAdmin')
		{
			$this->nameList = StringHelper::safe(
				$settings->name, 'W'
			);
			$this->nameListLower = $settings->name;
			$this->nameSingleLower = $settings->name;
		}
	}

	/**
	 * Get the dynamic title
	 *
	 * @param   string   $nameBuilder   The target builder name
	 * @param   string   $customName    The dynamic custom name
	 *
	 * @return  string   The title
	 * @since 3.2.0
	 */
	private function getTitle(string $nameBuilder, string $customName): string
	{
		$actionTitles = [
			'edit'               => 'Edit',
			'edit___own'         => 'Edit Own',
			'edit___access'      => 'Edit Access',
			'edit___state'       => 'Edit State',
			'edit___created_by'  => 'Edit Created By',
			'edit___created'     => 'Edit Created Date',
			'create'             => 'Create',
			'delete'             => 'Delete',
			'access'             => 'Access',
			'export'             => 'Export',
			'import'             => 'Import',
			'version'            => 'Edit Version',
			'batch'              => 'Batch Use',
		];

		$titleSuffix = $actionTitles[$nameBuilder] ?? StringHelper::safe($customName, 'W');

		return $this->nameList . ' ' . $titleSuffix;
	}

	/**
	 * Get the dynamic description
	 *
	 * @param   string   $nameBuilder   The target builder name
	 * @param   string   $customName    The dynamic custom name
	 *
	 * @return  string   The description
	 * @since 3.2.0
	 */
	private function getDescription(string $nameBuilder, string $customName): string
	{
		$actionDescriptions = [
			'edit'               => 'edit the ' . $this->nameSingleLower,
			'edit___own'         => 'edit ' . $this->nameListLower . ' created by them',
			'edit___access'      => 'change the access of the ' . $this->nameListLower,
			'edit___state'       => 'update the state of the ' . $this->nameSingleLower,
			'edit___created_by'  => 'update the created by of the ' . $this->nameListLower,
			'edit___created'     => 'update the created date of the ' . $this->nameListLower,
			'create'             => 'create ' . $this->nameListLower,
			'delete'             => 'delete ' . $this->nameListLower,
			'access'             => 'access ' . $this->nameListLower,
			'export'             => 'export ' . $this->nameListLower,
			'import'             => 'import ' . $this->nameListLower,
			'version'            => 'edit versions of ' . $this->nameListLower,
			'batch'              => 'use batch copy/update method of ' . $this->nameListLower
		];

		$description = $actionDescriptions[$nameBuilder] ?? StringHelper::safe($customName, 'w') . ' of ' . $this->nameSingleLower;

		return ' Allows the users in this group to ' . $description;
	}

	/**
	 * Get the core permission action
	 *
	 * @param   string  $nameView         View Single Code Name
	 * @param   string  $action                The Permission Action
	 *
	 * @return  string|null     The action name if set
	 * @since 3.2.0
	 */
	private function getCore(string $nameView, string $action): ?string
	{
		return $this->permissioncore->get("{$nameView}|{$action}");
	}
}

