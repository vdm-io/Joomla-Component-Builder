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

namespace VDM\Joomla\Componentbuilder\JoomlaPower;


use VDM\Joomla\Data\Repository as ExtendingRepository;


/**
 * Set JoomlaPower based on global unique ids to remote repository
 * 
 * @since 3.2.2
 */
final class Repository extends ExtendingRepository
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.1
	 */
	protected string $table = 'joomla_power';

	/**
	 * The item map
	 *
	 * @var    array
	 * @since 3.2.2
	 */
	protected array $map = [
		'system_name' => 'system_name',
		'settings' => 'settings',
		'guid' => 'guid',
		'description' => 'description'
	];
}

