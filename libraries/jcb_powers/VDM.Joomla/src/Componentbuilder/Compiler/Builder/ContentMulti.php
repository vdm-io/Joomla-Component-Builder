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

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Abstraction\Registry\Traits\IsArray;
use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Compiler Content Multi
 * 
 * @since 3.2.0
 */
class ContentMulti extends Registry implements Registryinterface
{
	/**
	 * Is an Array
	 *
	 * @since 3.2.0
	 */
	use IsArray;

	/**
	 * Constructor.
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		$this->setSeparator('|');
	}

	/**
	 * Get that the active keys from a path
	 *
	 * @param string  $path   The path to determine the location mapper.
	 *
	 * @return array|null      The valid array of keys
	 * @since 3.2.0
	 */
	protected function getActiveKeys(string $path): ?array
	{
		// Call the parent class's version of this method
		$keys = parent::getActiveKeys($path);

		if ($keys === null)
		{
			return null;
		}

		return $this->modelActiveKeys($keys);
	}

	/**
	 * Model that the active key
	 *
	 * @param array  $keys   The keys to the location mapper.
	 *
	 * @return array|null      The valid array of key
	 * @since 3.2.0
	 */
	protected function modelActiveKeys(array $keys): ?array
	{
		if (isset($keys[1]))
		{
			return [$keys[0], Placefix::_h($keys[1])];
		}

		if (isset($keys[0]))
		{
			return [$keys[0]];
		}

		return null;
	}
}

