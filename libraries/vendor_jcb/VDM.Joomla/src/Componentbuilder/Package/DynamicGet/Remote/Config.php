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

namespace VDM\Joomla\Componentbuilder\Package\DynamicGet\Remote;


use VDM\Joomla\Interfaces\Remote\ConfigInterface;
use VDM\Joomla\Abstraction\Remote\Config as ExtendingConfig;


/**
 * Base Configure values for the remote classes
 * 
 * @since 5.1.1
 */
final class Config extends ExtendingConfig implements ConfigInterface
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since  5.0.3
	 */
	protected string $table = 'dynamic_get';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 3.2.2
	 */
	protected ?string $area = 'Dynamic Get';

	/**
	 * The main readme file path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $main_readme_path = 'README_DYNAMIC_GETS.md';

	/**
	 * The index file path (index of all items)
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_path = 'index/dynamic-get.json';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $src_path = 'src/dynamic_get';
}

