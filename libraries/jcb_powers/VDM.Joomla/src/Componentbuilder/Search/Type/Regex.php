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


use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Interfaces\SearchTypeInterface;


/**
 * Search Type Regex
 * 
 * @since 3.2.0
 */
class Regex implements SearchTypeInterface
{
	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Search Value
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $searchValue;

	/**
	 * Replace Value
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $replaceValue;

	/**
	 * Search Should Match Case
	 *
	 * @var    int
	 * @since 3.2.0
	 */
	protected int $matchCase = 0;

	/**
	 * Search Should Match Whole Word
	 *
	 * @var    int
	 * @since 3.2.0
	 */
	protected int $wholeWord = 0;

	/**
	 * Constructor
	 *
	 * @param Config|null           $config           The search config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null)
	{
		$this->config = $config ?: Factory::_('Config');

		// set some class values
		$this->searchValue = $this->config->search_value;
		$this->replaceValue = $this->config->replace_value; // TODO
		$this->matchCase = $this->config->match_case;
		$this->wholeWord = $this->config->whole_word; // TODO
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
		return $value;
	}

}

