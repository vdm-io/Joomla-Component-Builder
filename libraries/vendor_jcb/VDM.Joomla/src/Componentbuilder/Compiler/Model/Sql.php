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
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Model\Sqldump;


/**
 * Model Sql Class
 * 
 * @since 3.2.0
 */
class Sql
{
	/**
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Compiler SQL Dump
	 *
	 * @var    Sqldump
	 * @since 3.2.0
	 */
	protected Sqldump $dump;

	/**
	 * Constructor
	 *
	 * @param Dispenser|null  $dispenser   The compiler customcode dispenser.
	 * @param Sqldump|null    $dump        The compiler SQL dump.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Dispenser $dispenser = null, ?Sqldump $dump = null)
	{
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
		$this->dump = $dump ?: Compiler::_('Model.Sqldump');
	}

	/**
	 * Set sql
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		if (isset($item->add_sql) && $item->add_sql == 1 && isset($item->source))
		{
			if ($item->source == 1 && isset($item->tables) &&
				($string = $this->dump->get(
					$item->tables, $item->name_single_code, $item->id
				)) !== null)
			{
				// build and add the SQL dump
				// we add this directly to avoid
				// dynamic set behaviour 
				// TODO: create a function in dispenser to manage these
				$this->dispenser->hub['sql'][$item->name_single_code]
					= $string;
			}
			elseif ($item->source == 2 && isset($item->sql))
			{
				// add the SQL dump string
				$this->dispenser->set(
					$item->sql,
					'sql',
					$item->name_single_code
				);
			}
		}

		unset($item->tables);
		unset($item->sql);
	}

}

