<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Agent;


use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Table;


/**
 * Search Agent Search
 * 
 * @since 3.2.0
 */
class Search
{
	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Table
	 *
	 * @var    Table
	 * @since 3.2.0
	 */
	protected Table $table;

	/**
	 * Constructor
	 *
	 * @param Config|null           $config           The search config object.
	 * @param Table|null             $table            The search table object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Table $table = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->table = $table ?: Factory::_('Table');
	}

	/**
	 * Search inside a value
	 *
	 * @param   mixed         $value     The field value
	 * @param   int               $id          The item ID
	 * @param   string          $field      The field key
	 * @param   string|null    $table     The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function value($value, int $id, string $field, ?string $table = null): bool
	{
		return true;
	}

}

