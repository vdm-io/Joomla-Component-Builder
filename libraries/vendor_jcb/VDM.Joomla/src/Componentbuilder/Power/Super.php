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

namespace VDM\Joomla\Componentbuilder\Power;


use VDM\Joomla\Componentbuilder\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Componentbuilder\Interfaces\Database\InsertInterface as Insert;
use VDM\Joomla\Componentbuilder\Interfaces\Database\UpdateInterface as Update;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Componentbuilder\Interfaces\SuperInterface;


/**
 * Superpower of JCB
 * 
 * @since 3.2.0
 */
class Super implements SuperInterface
{
	/**
	 * The Power Search Tool
	 *
	 * @var    Grep
	 * @since 3.2.0
	 **/
	protected Grep $grep;

	/**
	 * Insert Data Class
	 *
	 * @var    Insert
	 * @since 3.2.0
	 **/
	protected Insert $insert;

	/**
	 * Update Data Class
	 *
	 * @var    Update
	 * @since 3.2.0
	 **/
	protected Update $update;

	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.1
	 */
	protected string $table = 'power';

	/**
	 * Constructor.
	 *
	 * @param Grep      $grep     The Power Grep object.
	 * @param Insert    $insert   The Power Database Insert object.
	 * @param Update    $update   The Power Database Update object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Grep $grep, Insert $insert, Update $update)
	{
		$this->grep = $grep;
		$this->insert = $insert;
		$this->update = $update;
	}

	/**
	 * Init all power not found in database
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function init(): bool
	{
		if (($powers = $this->grep->getRemotePowersGuid()) !== null)
		{
			foreach($powers as $guid)
			{
				if ($this->action($guid) === 'insert' && ($power = $this->grep->get($guid, ['remote'])) !== null)
				{
					$this->insert($power);
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Reset the powers
	 *
	 * @param array   $powers    The global unique ids of the powers
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function reset(array $powers): bool
	{
		if ($powers === [])
		{
			return false;
		}

		$success = true;

		foreach($powers as $guid)
		{
			if (!$this->load($guid, ['remote']))
			{
				$success = false;
			}
		}

		return $success;
	}

	/**
	 * Load a superpower
	 *
	 * @param string   $guid    The global unique id of the power
	 * @param array    $order   The search order
	 * @param string|null   $action  The action to load power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function load(string $guid, array $order = ['remote', 'local'], ?string $action = null): bool
	{
		if (($power = $this->grep->get($guid, $order)) !== null &&
			($action !== null || ($action = $this->action($power->guid)) !== null))
		{
			return method_exists($this, $action) ? $this->{$action}($power) : false;
		}

		return false;
	}

	/**
	 * Insert a superpower
	 *
	 * @param object   $power    The power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	private function insert(object $power): bool
	{
		return $this->insert->item($power);
	}

	/**
	 * Update a superpower
	 *
	 * @param object   $power    The power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	private function update(object $power): bool
	{
		return $this->update->item($power);
	}

	/**
	 * Get loading action
	 *
	 * @param string   $guid   The global unique id of the power
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function action(string $guid): string
	{
		if (($id = GuidHelper::item($guid, $this->table)) !== null && $id > 0)
		{
			return 'update';
		}

		return 'insert';
	}
}

