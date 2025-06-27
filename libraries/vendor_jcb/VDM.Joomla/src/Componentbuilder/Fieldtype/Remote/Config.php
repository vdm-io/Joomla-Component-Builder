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

namespace VDM\Joomla\Componentbuilder\Fieldtype\Remote;


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
	 * @since 5.0.3
	 */
	protected string $table = 'fieldtype';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 5.0.3
	 */
	protected ?string $area = 'Field Type';

	/**
	 * Prefix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $prefix_key = '';

	/**
	 * Suffix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $suffix_key = '';

	/**
	 * The ignore fields
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $ignore = ['catid', 'access'];

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

