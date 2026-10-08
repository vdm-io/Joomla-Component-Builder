<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Interfaces;


/**
 * Decides which source wins for each property of one field.
 * 
 * This is the only place in the pipeline that arbitrates precedence. Every
 * resolved property carries the tier that produced it, which is what allows a
 * run to explain itself instead of presenting a guess as a fact.
 * 
 * @since 6.1.6
 */
interface PrecedenceInterface
{
	/**
	 * Resolve every property of one column into a value and an origin.
	 *
	 * @param   string                $view    The JCB view name.
	 * @param   array<string,string>  $keys    Registry keys per tier, as schema and table.
	 * @param   string                $column  The source column name.
	 *
	 * @return  array<string, array{value: mixed, origin: string}>|null  Resolved properties.
	 * @since   6.1.6
	 */
	public function resolve(string $view, array $keys, string $column): ?array;
}

