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

namespace VDM\Joomla\Componentbuilder\Package\Component\Remote;


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
	 * @since  5.1.1
	 */
	protected string $table = 'joomla_component';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 5.1.1
	 */
	protected ?string $area = 'Joomla Component';

	/**
	 * The main readme file path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $main_readme_path = 'README.md';

	/**
	 * The index file path (index of all items)
	 *
	 * @var    string
	 * @since 5.1.1
	 */
	protected string $index_path = 'index/joomla-component.json';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $src_path = 'src/joomla_component';

	/**
	 * The ignore fields
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $ignore = [
		'access',
		'export_key',
		'joomla_source_link',
		'export_buy_link',
		'update_server',
		'add_sales_server',
		'sales_server',
		'translation_tool',
		'crowdin_project_identifier',
		'crowdin_project_api_key',
		'crowdin_username',
		'crowdin_account_api_key',
		'created',
		'modified'
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
		'image' => 'images'
	];

	/**
	 * The direct entities/children of this entity
	 *
	 * @var    array
	 * @since  5.1.1
	 */
	protected array $children = [
		'component_admin_views',
		'component_custom_admin_views',
		'component_site_views',
		'component_router',
		'component_config',
		'component_placeholders',
		'component_updates',
		'component_files_folders',
		'component_custom_admin_menus',
		'component_dashboard',
		'component_modules',
		'component_plugins',
		// 'custom_code' TODO
	];

	/**
	 * The index map
	 *    must always have: [name,path,guid]
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
	 *    must always have: [name,path,guid,local]
	 *    with [name] always first
	 *    with [path,guid,local] always last
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

