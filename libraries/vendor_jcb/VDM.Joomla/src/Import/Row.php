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

namespace VDM\Joomla\Import;


use VDM\Joomla\Interfaces\Import\RowInterface;


/**
 * Import Row Class
 * 
 * @since  4.0.3
 */
final class Row implements RowInterface
{
	/**
	 * The row array of values.
	 *
	 * @var   array
	 * @since 5.0.2
	 */
	private array $values;

	/**
	 * The row index.
	 *
	 * @var   int
	 * @since 5.0.2
	 */
	private int $index;

	/**
	 * A flag to track if values and index are set.
	 *
	 * @var   bool
	 * @since 5.0.2
	 */
	private bool $isSet = false;

	/**
	 * Set the row details
	 *
	 * @param   int        $index    The row index
	 * @param   array   $values   The values
	 *
	 * @return  void
	 * @since  5.0.2
	 */
	public function set(int $index, array $values): void
	{
		$this->index = $index;
		$this->values = $values;
		$this->isSet = true;
	}

	/**
	 * Clear the row details
	 *
	 * @return  self
	 * @since  5.0.2
	 */
	public function clear(): self
	{
		$this->index = 0;
		$this->values = [];
		$this->isSet = false;

		return $this;
	}

	/**
	 * Get Index
	 *
	 * @return  int
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  5.0.2
	 */
	public function getIndex(): int
	{
		if (!$this->isSet)
		{
			throw new \InvalidArgumentException('Index must not be null or empty. Use the set method to first set the index.');
		}

		return $this->index;
	}

	/**
	 * Get Value
	 *
	 * @return  mixed
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  5.0.2
	 */
	public function getValue(string $key)
	{
		if (!$this->isSet)
		{
			throw new \InvalidArgumentException('Values must be set before accessing. Use the set method to first set the values.');
		}

		return $this->values[$key] ?? null;
	}

	/**
	 * Unset Value
	 *
	 * @return  void
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  5.0.2
	 */
	public function unsetValue(string $key): void
	{
		if (!$this->isSet)
		{
			throw new \InvalidArgumentException('Values must be set before accessing. Use the set method to first set the values.');
		}

		unset($this->values[$key]);
	}
}

