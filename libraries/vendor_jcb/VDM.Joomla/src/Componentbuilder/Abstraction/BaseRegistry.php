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

namespace VDM\Joomla\Componentbuilder\Abstraction;


use Joomla\Registry\Registry as JoomlaRegistry;


/**
 * Registry
 * 
 * So we have full control over this class
 * 
 * @since 3.2.0
 */
abstract class BaseRegistry extends JoomlaRegistry implements \JsonSerializable, \ArrayAccess, \IteratorAggregate, \Countable
{
	/**
	 * Method to iterate over any part of the registry
	 *
	 * @param   string  $path  Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  \ArrayIterator|null  This object represented as an ArrayIterator.
	 *
	 * @since   3.4.0
	 */
	public function _(string $path): ?\ArrayIterator
	{
		$data = $this->extract($path);

		if ($data === null)
		{
			return null;
		}

		return $data->getIterator();
	}

	/**
	 * Append value to a path in registry of an array
	 *
	 * @param  string  $path   Parent registry Path (e.g. joomla.content.showauthor)
	 * @param  mixed   $value  Value of entry
	 *
	 * @return  mixed  The value of the that has been set.
	 *
	 * @since 3.2.0
	 */
	public function appendArray(string $path, $value)
	{
		// check if it does not exist
		if (!$this->exists($path))
		{
			$this->set($path, []);
		}

		return $this->append($path, $value);
	}

	/**
	 * Check if a registry path exists and is an array
	 *
	 * @param  string  $path  Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  boolean
	 *
	 * @since 3.2.0
	 */
	public function isArray(string $path): bool
	{
		// Return default value if path is empty
		if (empty($path)) {
			return false;
		}

		// get the value
		if (($node = $this->get($path)) !== null
			&& is_array($node)
			&& $node !== [])
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if a registry path exists and is a string
	 *
	 * @param  string  $path  Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  boolean
	 *
	 * @since 3.2.0
	 */
	public function isString(string $path): bool
	{
		// Return default value if path is empty
		if (empty($path)) {
			return false;
		}

		// get the value
		if (($node = $this->get($path)) !== null
			&& is_string($node)
			&& strlen((string) $node) > 0)
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if a registry path exists and is numeric
	 *
	 * @param  string  $path  Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  boolean
	 *
	 * @since 3.2.0
	 */
	public function isNumeric(string $path): bool
	{
		// Return default value if path is empty
		if (empty($path)) {
			return false;
		}

		// get the value
		if (($node = $this->get($path)) !== null
			&& is_numeric($node))
		{
			return true;
		}

		return false;
	}

}

