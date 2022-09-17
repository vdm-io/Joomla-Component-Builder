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

namespace VDM\Joomla\Componentbuilder\Search\Type;


use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Search\Interfaces\SearchTypeInterface;
use VDM\Joomla\Componentbuilder\Search\Type;


/**
 * Search Type Regex
 * 
 * @since 3.2.0
 */
class Regex extends Type implements SearchTypeInterface
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

		// set search based on match case
		$case = '';
		if ($this->matchCase == 0)
		{
			$case = 'i';
		}

		$this->regexValue = "/(" . $this->searchValue . ")/" . $case;
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
		if (StringHelper::check($this->searchValue) && $this->match($value))
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
	 * Replace found instances inside string value
	 *
	 * @param   string     $value      The string value to update
	 *
	 * @return  string      The updated string
	 * @since 3.2.0
	 */
	public function replace(string $value): string
	{
		if (StringHelper::check($this->searchValue) && $this->match($value))
		{
			return preg_replace(
				$this->regexValue . 'm',
				$this->replaceValue,
				$value
			);
		}

		return $value;
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

}

