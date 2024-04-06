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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MysqlTableSetting;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model MySQL Settings Class
 * 
 * @since 3.2.0
 */
class Mysqlsettings
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The MysqlTableSetting Class.
	 *
	 * @var   MysqlTableSetting
	 * @since 3.2.0
	 */
	protected MysqlTableSetting $mysqltablesetting;

	/**
	 * Constructor.
	 *
	 * @param Config              $config              The Config Class.
	 * @param MysqlTableSetting   $mysqltablesetting   The MysqlTableSetting Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, MysqlTableSetting $mysqltablesetting)
	{
		$this->config = $config;
		$this->mysqltablesetting = $mysqltablesetting;
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
		foreach ($this->config->mysql_table_keys as $mysql_table_key => $mysql_table_val)
		{
			if (isset($item->{'mysql_table_' . $mysql_table_key})
				&& StringHelper::check($item->{'mysql_table_' . $mysql_table_key})
				&& !is_numeric($item->{'mysql_table_' . $mysql_table_key}))
			{
				$this->mysqltablesetting->set($item->name_single_code . '.' .
					$mysql_table_key, $item->{'mysql_table_' . $mysql_table_key}
				);
			}
			else
			{
				$this->mysqltablesetting->set($item->name_single_code . '.' .
					$mysql_table_key,  $mysql_table_val['default']
				);
			}

			// remove the table values since we moved to another object
			unset($item->{'mysql_table_' . $mysql_table_key});
		}
	}
}

