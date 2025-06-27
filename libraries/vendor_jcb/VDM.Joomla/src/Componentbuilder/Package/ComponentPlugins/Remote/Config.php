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

namespace VDM\Joomla\Componentbuilder\Package\ComponentPlugins\Remote;


use VDM\Joomla\Interfaces\Remote\ConfigInterface;
use VDM\Joomla\Abstraction\Remote\Config as ExtendingConfig;


/**
 * Base Configure values for the remote classes
 * 
 * @since 5.1.1
 */
class Config extends ExtendingConfig implements ConfigInterface
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since  5.0.3
	 */
	protected string $table = 'component_plugins';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 3.2.2
	 */
	protected ?string $area = 'Component Plugins';

	/**
	 * Prefix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	// [DEFAULT] protected string $prefix_key = '';

	/**
	 * Suffix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	// [DEFAULT] protected string $suffix_key = '';

	/**
	 * The main readme file path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $main_readme_path = '';

	/**
	 * The item readme file name
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $item_readme_name = '';

	/**
	 * The index file path (index of all items)
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_path = 'index/component-plugins.json';

	/**
	 * The item settings file name (item data)
	 *
	 * @var   string
	 * @since 3.2.2
	 */
	protected string $settings_name = 'component-plugins.json';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $src_path = 'src/joomla_component/children';

	/**
	 * The item guid=unique field
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $guid_field = 'joomla_component';

	/**
	 * The item map
	 *
	 * @var    array
	 * @since 5.0.3
	protected array $map = [];
	[DEFAULT] */

	/**
	 * The direct entities/children of this entity
	 *
	 * @var    array
	 * @since  5.1.1
	protected array $children = [];
	[DEFAULT] */

	/**
	 * The index map
	 *    must always have: [name,path,guid]
	 *    you can add more
	 *
	 * @var    array
	 * @since  5.0.3
	protected array $index_map = [
		'name' => 'index_map_IndexName',
		'path' => 'index_map_IndexPath',
		'guid' => 'index_map_IndexGUID'
	];
	[DEFAULT]  */

	/**
	 * The index header
	 *    mapping the index map to a table
	 *    must always have: [name,path,guid,local]
	 *    with [name] always first
	 *    with [path,guid,local] always last
	 *    you can add more in between
	 *
	 * @var    array
	 * @since  5.1.1
	protected array $index_header = [
		'name',
		'path',
		'guid',
		'local'
	];
	[DEFAULT]  */

	/**
	 * Core Placeholders
	 *
	 * @var    array
	 * @since  5.0.3
	protected array $placeholders = [];
	[DEFAULT] */
}

