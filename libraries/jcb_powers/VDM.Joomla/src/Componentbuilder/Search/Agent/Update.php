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
	 * @param   int      $line     The line to update  (0 = all)
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function value($value, int $line = 0)
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
	 * @param   int      $line    The line to update  (0 = all)
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	protected function updateValue($value, int $line = 0)
	{
		if (ArrayHelper::check($value))
		{
			echo '<pre>'; var_dump($value); exit;
		}
		elseif (StringHelper::check($value))
		{
			return $this->string($value, $line);
		}
		else
		{
			// this should not happen
			echo '<pre>Error:<br />'; var_dump($value); exit;
		}
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

