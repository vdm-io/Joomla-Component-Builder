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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use VDM\Joomla\Utilities\MathHelper;


/**
 * Compiler Utilities Counter
 * 
 * @since 3.2.0
 */
class Counter
{
	/**
	 * The folder counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	public int $folder = 0;

	/**
	 * The file counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	public int $file = 0;

	/**
	 * The line counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	public int $line = 0;

	/**
	 * The field counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	public int $field = 0;

	/**
	 * The number of admin views.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $adminView = 0;

	/**
	 * The number of custom admin views.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $customAdminView = 0;

	/**
	 * The number of site views.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $siteView = 0;

	/**
	 * The number of dynamic get statements.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $dynamicGet = 0;

	/**
	 * The number of layouts.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $layout = 0;

	/**
	 * The number of templates.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $template = 0;

	/**
	 * The number of powers used.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $power = 0;

	/**
	 * The number of custom code blocks used.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $customCodeBlock = 0;

	/**
	 * The number of modules.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $module = 0;

	/**
	 * The number of plugins.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $plugin = 0;

	/**
	 * The access size
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	public int $accessSize = 0;

	/**
	 * The time stamp of the start of the project in JCB
	 *   - this date can be manually set via the component create date
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	public int $projectStart = 0;

	/**
	 * The compiler start timer
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $start = 0;

	/**
	 * The compiler end timer
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $end = 0;

	/**
	 * The timer switch
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $started = 0;

	/**
	 * The Valuation Class.
	 *
	 * @var   Valuation
	 * @since 5.1.4
	 */
	protected Valuation $valuation;

	/**
	 * Constructor.
	 *
	 * @param  Valuation   $valuation   The Valuation Class.
	 *
	 * @since  3.2.0
	 */
	public function __construct(Valuation $valuation)
	{
		$this->valuation = $valuation;
		$this->start();
	}

	/**
	 * Start the timer.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function start(): void
	{
		if ($this->started === 0)
		{
			$this->start = microtime(true);
			$this->started = 1;
		}
	}

	/**
	 * End the timer.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function end(): void
	{
		if ($this->started === 1)
		{
			$this->end = microtime(true);
			$this->started = 2;
		}
	}

	/**
	 * Finalize results and store calculated metrics.
	 *
	 * @return void
	 * @since  3.2.0
	 */
	public function set(): void
	{
		$this->end();
		$this->valuation->set($this);
	}

	/**
	 * Retrieve a counter value by property name.
	 *
	 * @param  string  $name     The property name.
	 * @param  mixed   $default  The default value to return if not set.
	 *
	 * @return mixed
	 * @since  5.1.4
	 */
	public function get(string $name, mixed $default = 0): mixed
	{
		return property_exists($this, $name) ? ($this->$name ?? $default) : $default;
	}
}

