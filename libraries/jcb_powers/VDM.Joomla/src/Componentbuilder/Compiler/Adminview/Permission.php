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

namespace VDM\Joomla\Componentbuilder\Compiler\Adminview;


use VDM\Joomla\Componentbuilder\Compiler\Builder\HasPermissions;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Admin View Permission Class
 * 
 * @since 3.2.0
 */
final class Permission
{
	/**
	 * The HasPermissions Class.
	 *
	 * @var   HasPermissions
	 * @since 3.2.0
	 */
	protected HasPermissions $haspermissions;

	/**
	 * Constructor.
	 *
	 * @param HasPermissions   $haspermissions   The HasPermissions Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(HasPermissions $haspermissions)
	{
		$this->haspermissions = $haspermissions;
	}

	/**
	 * Check to see if a view has permissions
	 *
	 * @param   array   $view            View details
	 * @param   string  $nameSingleCode  View Single Code Name
	 *
	 * @return  bool   true if it has permissions
	 * @since 3.2.0
	 */
	public function check(array &$view, string &$nameSingleCode): bool
	{
		// first check if we have checked this already
		if (!$this->haspermissions->exists($nameSingleCode))
		{
			// when a view has history, it has permissions
			// since it tracks the version access
			if (isset($view['history']) && $view['history'] == 1)
			{
				// set the permission for later
				$this->haspermissions->set($nameSingleCode, true);

				// break out here
				return true;
			}
			// check if the view has permissions
			if (isset($view['settings'])
				&& ArrayHelper::check(
					$view['settings']->permissions, true
				))
			{
				foreach ($view['settings']->permissions as $per)
				{
					// check if the permission targets the view
					// 1 = view
					// 3 = both view & component
					if (isset($per['implementation'])
						&& (
							$per['implementation'] == 1
							|| $per['implementation'] == 3
						))
					{
						// set the permission for later
						$this->haspermissions->set($nameSingleCode, true);

						// break out here
						return true;
					}
				}
			}
			// check if the fields has permissions
			if (isset($view['settings'])
				&& ArrayHelper::check(
					$view['settings']->fields, true
				))
			{
				foreach ($view['settings']->fields as $field)
				{
					// if a field has any permissions
					// the a view has permissions
					if (isset($field['permission'])
						&& ArrayHelper::check(
							$field['permission'], true
						))
					{
						// set the permission for later
						$this->haspermissions->set($nameSingleCode, true);

						// break out here
						return true;
					}
				}
			}
		}

		return $this->haspermissions->exists($nameSingleCode);
	}
}

