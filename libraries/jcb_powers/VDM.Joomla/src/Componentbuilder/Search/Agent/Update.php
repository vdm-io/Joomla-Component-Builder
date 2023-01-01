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

namespace VDM\Joomla\Componentbuilder\Search\Agent;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Interfaces\SearchTypeInterface as SearchEngine;


/**
 * Search Agent Update
 * 
 * @since 3.2.0
 */
class Update
{
	/**
	 * Search Engine
	 *
	 * @var    SearchEngine
	 * @since 3.2.0
	 */
	protected SearchEngine $search;

	/**
	 * Constructor
	 *
	 * @param SearchEngine|null    $search    The search engine object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?SearchEngine $search = null)
	{
		$this->search = $search ?: Factory::_('Search');
	}

	/**
	 * Update the value
	 *
	 * @param   mixed    $value    The field value
	 * @param   mixed    $line     The line to update  (0 = all)
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function value($value, $line = 0)
	{
		// update the value
		$update = $this->updateValue($value, $line);

		// was anything updated
		if ($value === $update)
		{
			return null;
		}

		return $update;
	}

	/**
	 * Update all search-replace instances inside a value
	 *
	 * @param   mixed    $value   The field value
	 * @param   mixed    $line    The line to update  (0 = all)
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	protected function updateValue($value, $line = 0)
	{
		// I know this is a little crazy... TODO refactor into recursion functions
		// the possibility of updating sub-forms in sub-forms
		if (ArrayHelper::check($value))
		{
			if (strpos((string) $line, '.') !== false)
			{
				$line = explode('.', (string) $line);
			}
			// first layer
			foreach ($value as $keys => &$rows)
			{
				if (ArrayHelper::check($rows))
				{
					// second layer
					foreach ($rows as $key => &$row)
					{
						if (ArrayHelper::check($row))
						{
							// third layer
							foreach ($row as $ke => &$ro)
							{
								if (ArrayHelper::check($ro))
								{
									// forth layer
									foreach ($ro as $k => &$r)
									{
										if (StringHelper::check($r) &&
											$this->validateUpdateKey($line, $keys, $key, $ke, $k))
										{
											$_line = (isset($line[4])) ? $line[4] : 0;
												$r = $this->string($r, $_line);
										}
									}
								}
								elseif (StringHelper::check($ro) &&
									$this->validateUpdateKey($line, $keys, $key, $ke))
								{
									$_line = (isset($line[3])) ? $line[3] : 0;
									$ro = $this->string($ro, $_line);
								}

							}
						}
						elseif (StringHelper::check($row) &&
							$this->validateUpdateKey($line, $keys, $key))
						{
							$_line = (isset($line[2])) ? $line[2] : 0;
							$row  = $this->string($row, $_line);
						}
					}
				}
				elseif (StringHelper::check($rows) &&
					$this->validateUpdateKey($line, $keys))
				{
					$_line = (isset($line[1])) ? $line[1] : 0;
					$rows = $this->string($rows, $_line);
				}
			}
		}
		elseif (StringHelper::check($value))
		{
			$value = $this->string($value, $line);
		}

		return $value;
	}

	/**
	 * Check if the keys are valid for search when working with arrays
	 *
	 * @param   int            $line     The lines array
	 * @param   mixed      $keys   The line keys
	 * @param   mixed      $key     The line key
	 * @param   mixed      $k        The line ke
	 * @param   mixed      $k        The line k
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function validateUpdateKey($line, $keys = null, $key = null, $ke = null, $k = null): bool
	{
		if (ArrayHelper::check($line))
		{
			$_keys = (isset($line[0])) ? $line[0] : null;
			$_key = (isset($line[1])) ? $line[1] : null;
			$_ke = (isset($line[2])) ? $line[2] : null;
			$_k = (isset($line[3])) ? $line[3] : null;

			if ($keys && $_keys && $_keys !== $keys)
			{
				return false;
			}

			if ($key && $_key && $_key !== $key)
			{
				return false;
			}

			if ($ke && $_ke && $_ke !== $ke)
			{
				return false;
			}

			if ($k && $_k && $_k !== $k)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Update all search-replace instances inside a string
	 *
	 * @param   string    $value   The field value
	 * @param   int       $line    The line to update  (0 = all)
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function string(string $value, int $line = 0): string
	{
		// check if string has a new line
		if (\preg_match('/\R/', $value) && $line > 0)
		{
			// line counter
			$line_number = 1;

			$search_array = \preg_split('/\R/', $value);

			// loop over the lines
			foreach ($search_array as $nr => $line_value)
			{
				if ($line_number == $line)
				{
					$search_array[$nr] = $this->search->replace($line_value);

					// since we are targeting on line (and possibly one number)
					// this can only happen once, and so we return at this point
					return implode(PHP_EOL, $search_array);
				}
				// next line
				$line_number++;
			}

			// no update took place so we just return the original value
			return $value;
		}

		return $this->search->replace($value);
	}

}

