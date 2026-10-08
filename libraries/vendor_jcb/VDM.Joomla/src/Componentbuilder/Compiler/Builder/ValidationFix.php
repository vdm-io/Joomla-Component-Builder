<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Validation Fix Builder Class
 * 
 * Which fields of a view have their required attribute switched at runtime,
 * and so need the form validation override.
 * 
 * @since 6.1.7
 */
final class ValidationFix extends Registry implements Registryinterface
{
	/**
	 * Base switch to add values as string or array
	 *
	 * @var    boolean
	 * @since 6.1.7
	 **/
	protected bool $addAsArray = true;

	/**
	 * Server validation groups, separate from the legacy field-name registry.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $conditions = [];

	/**
	 * Store the exact condition groups selected for the browser script.
	 *
	 * @param   string  $view    The single view name.
	 * @param   array   $groups  The ordered condition groups.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function setConditions(string $view, array $groups): void
	{
		$this->conditions[$view] = $groups;
	}

	/**
	 * Read the server validation groups without changing field-name values.
	 *
	 * @param   string  $view  The single view name.
	 *
	 * @return  array
	 * @since   6.2.0
	 */
	public function getConditions(string $view): array
	{
		return $this->conditions[$view] ?? [];
	}
}

