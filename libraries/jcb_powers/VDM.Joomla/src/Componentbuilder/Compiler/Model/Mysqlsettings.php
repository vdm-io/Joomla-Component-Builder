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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model MySQL Settings Class
 * 
 * @since 3.2.0
 */
class Mysqlsettings
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Compiler Registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Constructor
	 *
	 * @param Config|null    $config     The compiler config.
	 * @param Registry|null  $registry   The compiler registry.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
	}

	/**
	 * Set MySQL table settings
	 *
	 * @param   object   $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		foreach (
			$this->config->mysql_table_keys as $mysql_table_key => $mysql_table_val
		)
		{
			if (isset($item->{'mysql_table_' . $mysql_table_key})
				&& StringHelper::check(
					$item->{'mysql_table_' . $mysql_table_key}
				)
				&& !is_numeric($item->{'mysql_table_' . $mysql_table_key}))
			{
				$this->registry->set('builder.mysql_table_setting.' . $item->name_single_code . '.' .
					$mysql_table_key, $item->{'mysql_table_' . $mysql_table_key}
				);
			}
			else
			{
				$this->registry->set('builder.mysql_table_setting.' . $item->name_single_code . '.' .
					$mysql_table_key,  $mysql_table_val['default']
				);
			}

			// remove the table values since we moved to another object
			unset($item->{'mysql_table_' . $mysql_table_key});
		}
	}

}

