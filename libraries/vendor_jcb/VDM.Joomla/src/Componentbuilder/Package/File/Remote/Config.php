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

namespace VDM\Joomla\Componentbuilder\Package\File\Remote;


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
	protected string $table = 'file_system';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 3.2.2
	 */
	protected ?string $area = 'File';

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
	protected string $index_path = 'index/file_folder.json';

	/**
	 * The item settings file name (item data)
	 *
	 * @var   string
	 * @since 3.2.2
	 */
	protected string $settings_name = '';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $src_path = 'src/file_folder';

	/**
	 * The item guid=unique field
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $guid_field = 'key';

	/**
	 * The item map
	 *
	 * @var    array
	 * @since 5.0.3
	 */
	protected array $map = [
		'key' => 'key',
		'value' => 'value',
		'target' => 'target'
	];

	/**
	 * The index map
	 *
	 * @var    array
	 * @since  5.0.3
	 */
	protected array $index_map = [
		'name' => 'index_map_IndexName',
		'path' => 'index_map_IndexPath',
		'guid' => 'index_map_IndexGUID'
	];

	/**
	 * Get the table title name field
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getTitleName(): string
	{
		return 'value';
	}
}

