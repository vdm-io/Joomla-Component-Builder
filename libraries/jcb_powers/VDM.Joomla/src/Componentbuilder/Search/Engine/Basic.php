<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Engine;


use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Search\Interfaces\SearchTypeInterface;
use VDM\Joomla\Componentbuilder\Search\Abstraction\Engine;


/**
 * Search Type String
 * 
 * @since 3.2.0
 */
class Basic extends Engine implements SearchTypeInterface
{
	/**
	 * Regex Search Value
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $regexValue = '';

	/**
	 * Constructor
	 *
	 * @param Config|null    $config    The search config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null)
	{
		parent::__construct($config);

		// quote all regular expression characters
		$searchValue = \preg_quote($this->searchValue);

		$start = ''; $end = '';

		// if this is a whole word search we need to do some prep
		if ($this->wholeWord == 1)
		{
			// get first character of search string
			$first = mb_substr($this->searchValue, 0, 1);
			// get last character of search string
			$last = mb_substr($this->searchValue, -1);

			// set the start boundary behavior
			$start = '(\b)';
			if (\preg_match("/\W/", $first))
			{
				$start = '(\b|\B)';
			}

			// set the boundary behavior
			$end = '(\b)';
			if (\preg_match("/\W/", $last))
			{
				$end = '(\b|\B)';
			}
		}

		// set search based on match case
		$case = '';
		if ($this->matchCase == 0)
		{
			$case = 'i';
		}

		$this->regexValue = "/" . $start . '(' . $searchValue . ')' . $end . "/" . $case;
	}

	/**
	 * Search inside a string
	 *
	 * @param   string    $value   The string value
	 *
	 * @return  string|null    The marked string if found, else null
	 * @since 3.2.0
	 */
	public function string(string $value): ?string
	{
		if (StringHelper::check($this->searchValue))
		{
			if ($this->wholeWord == 1)
			{
				return $this->searchWhole($value);
			}
			else
			{
				return $this->searchAll($value);
			}
		}

		return null;
	}

	/**
	 * Replace found instances inside string value
	 *
	 * @param   string     $value      The string value to update
	 *
	 * @return  string      The updated string
	 * @since 3.2.0
	 */
	public function replace(string $value): string
	{
		if (StringHelper::check($this->searchValue))
		{
			if ($this->wholeWord == 1)
			{
				return $this->replaceWhole($value);
			}
			else
			{
				return $this->replaceAll($value);
			}
		}
		return $value;
	}

	/**
	 * Replace whole words
	 *
	 * @param   string    $value   The string value
	 *
	 * @return  string    The marked string if found, else null
	 * @since 3.2.0
	 */
	protected function replaceWhole(string $value): string
	{
		if ($this->match($value))
		{
			return preg_replace(
				$this->regexValue . 'm',
				"$1" . $this->replaceValue . "$3",
				$value
			);
		}

		return $value;
	}

	/**
	 * Search for whole words
	 *
	 * @param   string    $value   The string value
	 *
	 * @return  string|null    The marked string if found, else null
	 * @since 3.2.0
	 */
	protected function searchWhole(string $value): ?string
	{
		if ($this->match($value))
		{
			return trim(preg_replace(
				$this->regexValue . 'm',
				"$1" . $this->start . "$2" . $this->end . "$3",
				$value
			));
		}

		return null;
	}

	/**
	 * Math the Regular Expression
	 *
	 * @param   string    $value  The string value
	 *
	 * @return  bool  true if match is found
	 * @since  3.0.9
	 */
	public function match(string $value): bool
	{
		$match = [];

		preg_match($this->regexValue, $value, $match);

		$match = array_filter(
			$match,
			function ($found) {
				return !empty($found);
			}
		);

		if (ArrayHelper::check($match))
		{
			return true;
		}

		return false;
	}

	/**
	 * Search for all instances
	 *
	 * @param   string    $value   The string value
	 *
	 * @return  string|null    The marked string if found, else null
	 * @since 3.2.0
	 */
	protected function searchAll(string $value): ?string
	{
		if ($this->matchCase == 1)
		{
			if (strpos($value, $this->searchValue) !== false)
			{
				return trim(preg_replace(
					$this->regexValue . 'm',
					$this->start . "$1" . $this->end,
					$value
				));
			}
		}
		elseif (stripos($value, $this->searchValue) !== false)
		{
			return trim(preg_replace(
				$this->regexValue . 'm',
				$this->start . "$1" . $this->end,
				$value
			));
		}

		return null;
	}

	/**
	 * Replace for all instances
	 *
	 * @param   string    $value   The string value
	 *
	 * @return  string    The marked string if found, else null
	 * @since 3.2.0
	 */
	protected function replaceAll(string $value): string
	{
		if ($this->matchCase == 1)
		{
			if (strpos($value, $this->searchValue) !== false)
			{
				return preg_replace(
					$this->regexValue . 'm',
					$this->replaceValue,
					$value
				);
			}
		}
		elseif (stripos($value, $this->searchValue) !== false)
		{
			return preg_replace(
				$this->regexValue . 'm',
				$this->replaceValue,
				$value
			);
		}

		return $value;
	}

}

