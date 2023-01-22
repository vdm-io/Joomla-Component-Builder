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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Content;


/**
 * Compiler Counter
 * 
 * @since 3.2.0
 */
class Counter
{
	/**
	 * The folder counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	public int $folder = 0;

	/**
	 * The file counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	public int $file = 0;

	/**
	 * The page counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	public int $page = 0;

	/**
	 * The line counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	public int $line = 0;

	/**
	 * The field counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	public int $field = 0;

	/**
	 * The seconds counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $seconds = 0;

	/**
	 * The actual seconds counter
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $actualSeconds = 0;

	/**
	 * The folder seconds counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $folderSeconds = 0;

	/**
	 * The file seconds counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $fileSeconds = 0;

	/**
	 * The line seconds counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $lineSeconds = 0;

	/**
	 * The seconds debugging counter
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $secondsDebugging = 0;

	/**
	 * The seconds planning counter
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $secondsPlanning = 0;

	/**
	 * The seconds mapping counter
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $secondsMapping = 0;

	/**
	 * The seconds office counter
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $secondsOffice = 0;

	/**
	 * The total hours counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $totalHours = 0;

	/**
	 * The debugging hours counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $debuggingHours = 0;

	/**
	 * The planning hours counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $planningHours = 0;

	/**
	 * The mapping hours counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $mappingHours = 0;

	/**
	 * The office hours counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $officeHours = 0;

	/**
	 * The actual Total Hours counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $actualTotalHours = 0;

	/**
	 * The actual hours spent counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $actualHoursSpent = 0;

	/**
	 * The actual days spent counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $actualDaysSpent = 0;

	/**
	 * The total days counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $totalDays = 0;

	/**
	 * The actual Total Days counter
	 *
	 * @var     int
	 * @since 3.2.0
	 */
	protected int $actualTotalDays = 0;

	/**
	 * The project week time counter
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $projectWeekTime = 0;

	/**
	 * The project month time counter
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $projectMonthTime = 0;

	/**
	 * The compiler start timer
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $start = 0;

	/**
	 * The compiler end timer
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $end = 0;

	/**
	 * The compiler timer
	 *
	 * @var     float
	 * @since 3.2.0
	 */
	protected float $timer = 0;

	/**
	 * Compiler Content
	 *
	 * @var    Content
	 * @since 3.2.0
	 **/
	protected Content $content;

	/**
	 * Constructor
	 *
	 * @param Content|null     $content    The compiler content object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Content $content = null)
	{
		$this->content = $content ?: Compiler::_('Content');
	}

	/**
	 * Start the timer
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function start()
	{
		$this->start = microtime(true);
	}

	/**
	 * End the timer
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function end()
	{
		$this->end = microtime(true);

		// calculate the lenght
		$this->timer = $this->end - $this->start;

		// compiler time
		$this->content->set('COMPILER_TIMER_START', $this->start);
		$this->content->set('COMPILER_TIMER_END', $this->end);
		$this->content->set('COMPILER_TIMER', $this->timer);
	}

	/**
	 * Set all the time values
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set()
	{
		// calculate all the values
		$this->calculate();

		// set some defaults
		$this->content->set('LINE_COUNT', $this->line);
		$this->content->set('FIELD_COUNT', $this->field);
		$this->content->set('FILE_COUNT', $this->file);
		$this->content->set('FOLDER_COUNT', $this->folder);
		$this->content->set('PAGE_COUNT', $this->page);
		$this->content->set('folders', $this->folderSeconds);
		$this->content->set('foldersSeconds', $this->folderSeconds);
		$this->content->set('files', $this->fileSeconds);
		$this->content->set('filesSeconds', $this->fileSeconds);
		$this->content->set('lines', $this->lineSeconds);
		$this->content->set('linesSeconds', $this->lineSeconds);
		$this->content->set('seconds', $this->actualSeconds);
		$this->content->set('actualSeconds', $this->actualSeconds);
		$this->content->set('totalHours', $this->totalHours);
		$this->content->set('totalDays', $this->totalDays);
		$this->content->set('debugging', $this->secondsDebugging);
		$this->content->set('secondsDebugging', $this->secondsDebugging);
		$this->content->set('planning', $this->secondsPlanning);
		$this->content->set('secondsPlanning', $this->secondsPlanning);
		$this->content->set('mapping', $this->secondsMapping);
		$this->content->set('secondsMapping', $this->secondsMapping);
		$this->content->set('office', $this->secondsOffice);
		$this->content->set('secondsOffice', $this->secondsOffice);
		$this->content->set('actualTotalHours', $this->actualTotalHours);
		$this->content->set('actualTotalDays', $this->actualTotalDays);
		$this->content->set('debuggingHours', $this->debuggingHours);
		$this->content->set('planningHours', $this->planningHours);
		$this->content->set('mappingHours', $this->mappingHours);
		$this->content->set('officeHours', $this->officeHours);
		$this->content->set('actualHoursSpent', $this->actualHoursSpent);
		$this->content->set('actualDaysSpent', $this->actualDaysSpent);
		$this->content->set('projectWeekTime', $this->projectWeekTime);
		$this->content->set('projectMonthTime', $this->projectMonthTime);

		// compiler time
		$this->content->set('COMPILER_TIMER_START', $this->start);
		$this->content->set('COMPILER_TIMER_END', $this->end);
		$this->content->set('COMPILER_TIMER', $this->timer);
	}

	/**
	 * Calculate all the time values
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function calculate()
	{
		// what is the size in terms of an A4 book
		$this->page = round($this->line / 56);

		// setup the unrealistic numbers
		$this->folderSeconds = $this->folder * 5;
		$this->fileSeconds   = $this->file * 5;
		$this->lineSeconds   = $this->line * 10;
		$this->seconds       = $this->folderSeconds + $this->fileSeconds
			+ $this->lineSeconds;
		$this->totalHours    = round($this->seconds / 3600);
		$this->totalDays     = round($this->totalHours / 8);

		// setup the more realistic numbers
		$this->secondsDebugging = $this->seconds / 4;
		$this->secondsPlanning  = $this->seconds / 7;
		$this->secondsMapping   = $this->seconds / 10;
		$this->secondsOffice    = $this->seconds / 6;
		$this->actualSeconds    = $this->folderSeconds + $this->fileSeconds
			+ $this->lineSeconds + $this->secondsDebugging
			+ $this->secondsPlanning + $this->secondsMapping
			+ $this->secondsOffice;
		$this->actualTotalHours = round($this->actualSeconds / 3600);
		$this->actualTotalDays  = round($this->actualTotalHours / 8);
		$this->debuggingHours   = round($this->secondsDebugging / 3600);
		$this->planningHours    = round($this->secondsPlanning / 3600);
		$this->mappingHours     = round($this->secondsMapping / 3600);
		$this->officeHours      = round($this->secondsOffice / 3600);

		// the actual time spent
		$this->actualHoursSpent = $this->actualTotalHours - $this->totalHours;
		$this->actualDaysSpent  = $this->actualTotalDays - $this->totalDays;

		// calculate the projects actual time frame of completion
		$this->projectWeekTime  = round($this->actualTotalDays / 5, 1);
		$this->projectMonthTime = round($this->actualTotalDays / 24, 1);
	}

}

