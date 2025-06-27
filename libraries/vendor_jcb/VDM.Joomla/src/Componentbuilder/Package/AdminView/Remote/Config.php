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

namespace VDM\Joomla\Componentbuilder\Package\AdminView\Remote;


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
	protected string $table = 'admin_view';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 3.2.2
	 */
	protected ?string $area = 'Admin View';

	/**
	 * The main readme file path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $main_readme_path = 'README_ADMIN_VIEWS.md';

	/**
	 * The index file path (index of all items)
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_path = 'index/admin-view.json';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $src_path = 'src/admin_view';

	/**
	 * The ignore fields
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $ignore = [
		'access',
		'addtables'
	];

	/**
	 * The files (to map target files to move in an entity)
	 *
	 *   Use a pipe in the name to denote
	 *   subform location of the value
	 *      format: [field_name => path, field_name|subfrom_key => path]
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $files = [
		'icon' => 'images',
		'icon_add' => 'images',
		'icon_category' => 'images'
	];

	/**
	 * The direct entities/children of this entity
	 *
	 * @var    array
	 * @since  5.1.1
	 */
	protected array $children = [
		'admin_fields',
		'admin_fields_relations',
		'admin_fields_conditions',
		'admin_custom_tabs'
	];

	/**
	 * The index map
	 *    must always have: [name,path,settings,guid]
	 *    you can add more
	 *
	 * @var    array
	 * @since  5.0.3
	 */
	protected array $index_map = [
		'name' => 'index_map_IndexName',
		'path' => 'index_map_IndexPath',
		'settings' => 'index_map_IndexSettingsPath',
		'guid' => 'index_map_IndexGUID',
		'desc' => 'index_map_ShortDescription'
	];

	/**
	 * The index header
	 *    mapping the index map to a table
	 *    must always have: [name,path,settings,guid,local]
	 *    with [name] always first
	 *    with [path,settings,guid,local] always last
	 *    you can add more in between
	 *
	 * @var    array
	 * @since  5.1.1
	 */
	protected array $index_header = [
		'name',
		'desc',
		'path',
		'settings',
		'guid',
		'local'
	];
}

