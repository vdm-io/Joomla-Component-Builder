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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface;
use VDM\Joomla\Componentbuilder\Compiler\Model\Updatesql;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Admin View History Class
 * 
 * @since 3.2.0
 */
class Historyadminview
{
	/**
	 * The compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler history
	 *
	 * @var    HistoryInterface
	 * @since 3.2.0
	 */
	protected HistoryInterface $history;

	/**
	 * The compiler update sql
	 *
	 * @var    Updatesql
	 * @since 3.2.0
	 */
	protected Updatesql $updatesql;

	/**
	 * Constructor
	 *
	 * @param Config|null             $config      The compiler config object.
	 * @param HistoryInterface|null   $history     The compiler history object.
	 * @param Updatesql|null          $updatesql   The compiler updatesql object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?HistoryInterface $history = null,
		?Updatesql $updatesql = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->history = $history ?: Compiler::_('History');
		$this->updatesql = $updatesql ?: Compiler::_('Model.Updatesql');
	}

	/**
	 * check if an update SQL is needed
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		if (($old = $this->history->get('admin_view', $item->id)) !== null)
		{
			// check if the view name changed
			if (StringHelper::check($old->name_single))
			{
				$this->updatesql->set(
					StringHelper::safe(
						$old->name_single
					), $item->name_single_code, 'table_name',
					$item->name_single_code
				);
			}

			// loop the mysql table settings
			foreach ($this->config->mysql_table_keys as $mysql_table_key => $mysql_table_val)
			{
				// check if the table engine changed
				if (isset($old->{'mysql_table_' . $mysql_table_key})
					&& isset($item->{'mysql_table_' . $mysql_table_key}))
				{
					$this->updatesql->set(
						$old->{'mysql_table_' . $mysql_table_key},
						$item->{'mysql_table_' . $mysql_table_key},
						'table_' . $mysql_table_key, $item->name_single_code
					);
				}
				// check if there is no history on table engine, and it changed from the default/global
				elseif (isset($item->{'mysql_table_' . $mysql_table_key})
					&& StringHelper::check(
						$item->{'mysql_table_' . $mysql_table_key}
					)
					&& !is_numeric(
						$item->{'mysql_table_' . $mysql_table_key}
					))
				{
					$this->updatesql->set(
						$mysql_table_val['default'],
						$item->{'mysql_table_' . $mysql_table_key},
						'table_' . $mysql_table_key, $item->name_single_code
					);
				}
			}
		}
	}

}

