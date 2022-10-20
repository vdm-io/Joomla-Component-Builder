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

namespace VDM\Joomla\Componentbuilder\Search\Abstraction;


use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;


/**
 * Search Engine
 * 
 * @since 3.2.0
 */
abstract class Engine
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
	 * @var    string|null
	 * @since 3.2.0
	 */
	protected ?string $searchValue;

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
	 * Start marker
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $start = '';

	/**
	 * End marker
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $end = '';

	/**
	 * Constructor
	 *
	 * @param Config|null    $config  The search config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null)
	{
		$this->config = $config ?: Factory::_('Config');

		// set search value
		$this->searchValue = $this->config->search_value;

		// set replace value
		$this->replaceValue = $this->config->replace_value;

		// set match case
		$this->matchCase = $this->config->match_case;

		// set whole word
		$this->wholeWord = $this->config->whole_word;

		// set start marker
		$this->start = $this->config->marker_start;

		// set end marker
		$this->end = $this->config->marker_end;
	}

}

