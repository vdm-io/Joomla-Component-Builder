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

namespace VDM\Joomla\Componentbuilder\Package\CustomAdminView\Remote;


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
	protected string $table = 'custom_admin_view';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 3.2.2
	 */
	protected ?string $area = 'Custom Admin View';

	/**
	 * The main readme file path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $main_readme_path = 'README_CUSTOM_ADMIN_VIEWS.md';

	/**
	 * The index file path (index of all items)
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_path = 'index/custom-admin-view.json';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $src_path = 'src/custom_admin_view';

	/**
	 * The files (to map target files to move in an entity)
	 *
	 *   Use a pipe in the name to denote
	 *   subform location of the value
	 *      format: [field_name, field_name|subfrom_key]
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $files = [
		'icon'
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
		'desc' => 'index_map_ShortDescription',
		'path' => 'index_map_IndexPath',
		'settings' => 'index_map_IndexSettingsPath',
		'guid' => 'index_map_IndexGUID'
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
		// from here you can add more
		'desc',
		'path',
		'settings',
		'guid',
		'local'
	];
}

