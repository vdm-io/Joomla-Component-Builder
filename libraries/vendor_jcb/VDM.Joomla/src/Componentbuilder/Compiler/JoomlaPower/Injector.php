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

namespace VDM\Joomla\Componentbuilder\Compiler\JoomlaPower;


use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Power\InjectorInterface;
use VDM\Joomla\Componentbuilder\Compiler\Power\Injector as ExtendingInjector;


/**
 * Compiler Joomla Power Injector
 * @since 3.2.0
 */
final class Injector extends ExtendingInjector implements InjectorInterface
{
	/**
	 * Builds the namespace statement from the power object's namespace and class name.
	 *
	 * @param object $power  The power object.
	 *
	 * @return string The constructed use statement.
	 * @since 3.2.0
	 */
	protected function buildNamespaceStatment(object $power): string
	{
		return $power->_namespace . '\\' . $power->class_name;
	}

	/**
	 * Ensures the name for the use statement is unique, avoiding conflicts with other classes.
	 *
	 * @param string  $name       The current name
	 * @param object  $power      The power object containing type, namespace, and class name.
	 *
	 * @return string  The unique name
	 * @since 3.2.0
	 */
	protected function getUniqueName(string $name, object $power): string
	{
		// set search namespace
		$namespace = ($name !== $power->class_name) ? $this->buildNamespaceStatment($power) : $power->_namespace;

		// check if we need to update the name
		if (isset($this->other[$name]))
		{
			// if the name is already used
			while (isset($this->other[$name]))
			{
				if (($tmp = $this->extractClassNameOrAlias($namespace)) !== null)
				{
					$name = ucfirst($tmp) . $name;
					$namespace = $this->removeLastNameFromNamespace($namespace);
				}
				else
				{
					$name = 'Unique' . $name;
				}
			}
		}

		// also loop new found use statements
		if (isset($this->useStatements[$name]))
		{
			// if the name is already used
			while (isset($this->useStatements[$name]))
			{
				if (($tmp = $this->extractClassNameOrAlias($namespace)) !== null)
				{
					$name = ucfirst($tmp) . $name;
					$namespace = $this->removeLastNameFromNamespace($namespace);
				}
				else
				{
					$name = 'Unique' . $name;
				}
			}
		}

		return $name;
	}
}

