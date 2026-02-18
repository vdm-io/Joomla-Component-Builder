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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Content;
use VDM\Joomla\Utilities\MathHelper;


/**
 * Calculates estimated project value using metrics provided by Counter.
 * 
 * @since 5.1.4
 */
final class Valuation
{
	/**
	 * The page counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $page = 0;

	/**
	 * The seconds counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $seconds = 0;

	/**
	 * The actual seconds counter
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $actualSeconds = 0;

	/**
	 * The folder seconds counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $folderSeconds = 0;

	/**
	 * The file seconds counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $fileSeconds = 0;

	/**
	 * The line seconds counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $lineSeconds = 0;

	/**
	 * The seconds debugging counter
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $secondsDebugging = 0;

	/**
	 * The seconds planning counter
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $secondsPlanning = 0;

	/**
	 * The seconds mapping counter
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $secondsMapping = 0;

	/**
	 * The seconds office counter
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $secondsOffice = 0;

	/**
	 * The total hours counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $totalHours = 0;

	/**
	 * The debugging hours counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $debuggingHours = 0;

	/**
	 * The planning hours counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $planningHours = 0;

	/**
	 * The mapping hours counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $mappingHours = 0;

	/**
	 * The office hours counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $officeHours = 0;

	/**
	 * The actual Total Hours counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $actualTotalHours = 0;

	/**
	 * The actual hours spent counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $actualHoursSpent = 0;

	/**
	 * The actual days spent counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $actualDaysSpent = 0;

	/**
	 * The total days counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $totalDays = 0;

	/**
	 * The actual Total Days counter
	 *
	 * @var   int
	 * @since 3.2.0
	 */
	protected int $actualTotalDays = 0;

	/**
	 * The project week time counter
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $projectWeekTime = 0;

	/**
	 * The project month time counter
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $projectMonthTime = 0;

	/**
	 * Default precision scale for BC math operations.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $scale = 2;

	/**
	 * Average seconds per folder creation.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $avgSecondsPerFolder;

	/**
	 * Average seconds per file creation.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $avgSecondsPerFile;

	/**
	 * Average seconds per line of code.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $avgSecondsPerLine;

	/**
	 * Lines per page average.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $avgLinesPerPage;

	/**
	 * Debugging overhead factor (0..1).
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $debuggingFactor;

	/**
	 * Planning overhead factor (0..1).
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $planningFactor;

	/**
	 * Mapping/architecture overhead factor (0..1).
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $mappingFactor;

	/**
	 * Office/admin/communication overhead factor (0..1).
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $officeFactor;

	/**
	 * Default hourly rate (USD).
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $avgHourlyRateUSD;

	/**
	 * The project estimate value.
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $projectValueUSD = 0.0;

	/**
	 * The project estimate value per line.
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $projectValuePerLine = 0.0;

	/**
	 * Annual cost of one professional JCB license seat (USD).
	 * This is a notional cost used for value attribution.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $licenseSeatAnnualCost;

	/**
	 * The number of developers assumed to be working on the project.
	 * Used to multiply the attributed tool license cost.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $assumedDeveloperCount;

	/**
	 * The number of subscriptions assumed per/month.
	 * Used to divide the subscription cost.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $assumedSubscriptionPerMonth;

	/**
	 * The number of workdays per year used for proportional attribution
	 * of the JCB license seat cost to this project.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $workdaysPerYear;

	/**
	 * The profit margin factor (0..1) applied after the market multiplier
	 * to calculate the perceived project value.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $profitMarginFactor;

	/**
	 * The estimated number of times the blueprint could be replicated
	 * or reused in other projects. Used in blueprint value calculations.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $blueprintReplicationPotential;

	/**
	 * The percentage risk factor (0..1) reducing the blueprint's total value.
	 * Represents market risk, competition, or uncertainty.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $blueprintRiskFactor;

	/**
	 * The calculated labor base value (USD), excluding overhead.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $laborBaseValue = 0.0;

	/**
	 * The calculated labor value including all overheads (USD).
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $laborWithOverheadValue = 0.0;

	/**
	 * The attributed cost of the professional JCB tool license (USD).
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $toolLicenseAttribution = 0.0;

	/**
	 * The combined actual project value (USD) including labor and tool attribution.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $actualValue = 0.0;

	/**
	 * The selected market multiplier based on the component complexity.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $marketMultiplier = 1.0;

	/**
	 * The market-adjusted project value (USD) after applying the multiplier.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $marketAdjustedValue = 0.0;

	/**
	 * The perceived project value (USD) after applying profit margin.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $perceivedValue = 0.0;

	/**
	 * The estimated blueprint value (USD) after replication potential and risk adjustments.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $blueprintValue = 0.0;

	/**
	 * The suggested monthly subscription fee (USD) for the app over 12 months.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $appMonthly12 = 0.0;

	/**
	 * The suggested monthly subscription fee (USD) for the app over 24 months.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $appMonthly24 = 0.0;

	/**
	 * The suggested monthly subscription fee (USD) for the app over 36 months.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $appMonthly36 = 0.0;

	/**
	 * The suggested monthly subscription fee (USD) for the blueprint over 12 months.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $blueprintMonthly12 = 0.0;

	/**
	 * The suggested monthly subscription fee (USD) for the blueprint over 24 months.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $blueprintMonthly24 = 0.0;

	/**
	 * The suggested monthly subscription fee (USD) for the blueprint over 36 months.
	 *
	 * @var   float
	 * @since 5.1.4
	 */
	protected float $blueprintMonthly36 = 0.0;

	/**
	 * The compiler timer
	 *
	 * @var   float
	 * @since 3.2.0
	 */
	protected float $timer = 0;

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The ContentOne Class.
	 *
	 * @var   Content
	 * @since 3.2.0
	 */
	protected Content $content;

	/**
	 * The ComplexityEngine Class.
	 *
	 * @var   ComplexityEngine
	 * @since 5.1.4
	 */
	protected ComplexityEngine $complexityengine;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * Constructor.
	 *
	 * @param  Config            $config            The Config Class.
	 * @param  Content           $content           The ContentOne Class.
	 * @param ComplexityEngine   $complexityengine  The ComplexityEngine Class.
	 *
	 * @since  3.2.0
	 */
	public function __construct(Config $config, Content $content,
		ComplexityEngine $complexityengine)
	{
		$this->config  = $config;
		$this->content = $content;
		$this->complexityengine = $complexityengine;
	}

	/**
	 * Finalize results and store calculated metrics.
	 *
	 * @param  Counter   $counter   The Counter class.
	 *
	 * @return void
	 * @since  3.2.0
	 */
	public function set(Counter $counter): void
	{
		$this->counter = $counter;

		$this->loadConfiguration();
		$this->calculateBaseTime();
		$this->calculateOverheadTime();
		$this->calculateTotals();

		$this->calculateProjectValue();
		$this->calculateLaborLayers();
		$this->calculateToolAttribution();
		$this->calculateActualValue();

		$this->determineMarketMultiplier();
		$this->calculateMarketAndPerceivedValues();
		$this->calculateBlueprintValue();
		$this->calculateSubscriptionBreakdowns();

		$this->storeResults();
		$this->storeExtendedResults();
	}

	/**
	 * Load configuration values from component options or defaults.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function loadConfiguration(): void
	{
		$this->avgSecondsPerFolder = (float) $this->config->get('avg_seconds_per_folder', 3.0);
		$this->avgSecondsPerFile   = (float) $this->config->get('avg_seconds_per_file', 5.0);
		$this->avgSecondsPerLine   = (float) $this->config->get('avg_seconds_per_line', 9.5);
		$this->avgLinesPerPage     = (int) $this->config->get('avg_lines_per_page', 56);
		$this->avgHourlyRateUSD    = (float) $this->config->get('avg_hourly_rate_usd', 75.0);

		$this->debuggingFactor     = (float) $this->config->get('debugging_factor', 0.25);
		$this->planningFactor      = (float) $this->config->get('planning_factor', 0.14);
		$this->mappingFactor       = (float) $this->config->get('mapping_factor', 0.10);
		$this->officeFactor        = (float) $this->config->get('office_factor', 0.16);

		$this->licenseSeatAnnualCost = (float) $this->config->get('license_seat_annual_cost', 3000.0);
		$this->assumedDeveloperCount = (int)   $this->config->get('assumed_developer_count', 1);
		$this->workdaysPerYear       = (int)   $this->config->get('workdays_per_year', 240);

		$this->assumedSubscriptionPerMonth = (int)   $this->config->get('assumed_subscription_per_month', 100);

		$this->profitMarginFactor             = (float) $this->config->get('profit_margin_factor', 0.6);

		$this->blueprintReplicationPotential  = (int)   $this->config->get('blueprint_replication_potential', 50);
		$this->blueprintRiskFactor            = (float) $this->config->get('blueprint_risk_factor', 0.2);
	}

	/**
	 * Calculate the base (raw) time values.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateBaseTime(): void
	{
		// calculate the compilation length
		$this->timer = MathHelper::bc('sub', $this->counter->get('end', 4), $this->counter->get('start', 8), 0);

		// what is the size in terms of an A4 book
		$this->page = (int) MathHelper::bc('div', $this->counter->get('line', 100), $this->avgLinesPerPage, 0);

		// baseline seconds (configurable)
		$this->folderSeconds = (int) MathHelper::bc('mul', $this->counter->get('folder', 100), $this->avgSecondsPerFolder, 0);
		$this->fileSeconds   = (int) MathHelper::bc('mul', $this->counter->get('file', 100), $this->avgSecondsPerFile, 0);
		$this->lineSeconds   = (int) MathHelper::bc('mul', $this->counter->get('line', 100), $this->avgSecondsPerLine, 0);

		$this->seconds       = (int) MathHelper::sum([$this->folderSeconds, $this->fileSeconds, $this->lineSeconds], 0);
	}

	/**
	 * Calculate the overhead time (planning, debugging, mapping, office).
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateOverheadTime(): void
	{
		// Overhead estimations (kept explicit for clarity & configurability)
		$this->secondsDebugging = (float) MathHelper::bc('mul', $this->seconds, $this->debuggingFactor, $this->scale);
		$this->secondsPlanning  = (float) MathHelper::bc('mul', $this->seconds, $this->planningFactor, $this->scale);
		$this->secondsMapping   = (float) MathHelper::bc('mul', $this->seconds, $this->mappingFactor, $this->scale);
		$this->secondsOffice    = (float) MathHelper::bc('mul', $this->seconds, $this->officeFactor, $this->scale);

		$this->actualSeconds = MathHelper::sum([
			$this->seconds,
			$this->secondsDebugging,
			$this->secondsPlanning,
			$this->secondsMapping,
			$this->secondsOffice
		], $this->scale);

		// Hours per overhead category (preserved)
		$this->debuggingHours = (int) MathHelper::bc('div', $this->secondsDebugging, 3600, 0) ?? 0;
		$this->planningHours  = (int) MathHelper::bc('div', $this->secondsPlanning, 3600, 0) ?? 0;
		$this->mappingHours   = (int) MathHelper::bc('div', $this->secondsMapping, 3600, 0) ?? 0;
		$this->officeHours    = (int) MathHelper::bc('div', $this->secondsOffice, 3600, 0) ?? 0;
	}

	/**
	 * Calculate totals (hours, days, projections).
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateTotals(): void
	{
		// Base totals
		$this->totalHours = (int) MathHelper::bc('div', $this->seconds, 3600, 0);
		$this->totalDays  = (int) MathHelper::bc('div', $this->totalHours, 8, 0);

		// Actual totals with overhead
		$this->actualTotalHours = (int) MathHelper::bc('div', $this->actualSeconds, 3600, 0);
		$this->actualTotalDays  = (int) MathHelper::bc('div', $this->actualTotalHours, 8, 0);

		// Overhead-only spent
		$this->actualHoursSpent = (int) MathHelper::bc('sub', $this->actualTotalHours, $this->totalHours, 0);
		$this->actualDaysSpent  = (int) MathHelper::bc('sub', $this->actualTotalDays, $this->totalDays, 0);

		// Project duration (keep legacy behavior: 5d/week, 24d/month)
		$this->projectWeekTime  = (float) MathHelper::bc('div', $this->actualTotalDays, 5, 1);
		$this->projectMonthTime = (float) MathHelper::bc('div', $this->actualTotalDays, 24, 1);
	}

	/**
	 * Estimate the monetary value of the generated project (USD).
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateProjectValue(): void
	{
		$this->projectValueUSD = (float) MathHelper::bc('mul', $this->actualTotalHours, $this->avgHourlyRateUSD, 2);
		$this->projectValuePerLine = (float) (MathHelper::bc('div', $this->projectValueUSD, $this->counter->get('line', 100), 2) ?? 0.00);
	}

	/**
	 * Compute labor base and labor with overhead values.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateLaborLayers(): void
	{
		$hoursBase = MathHelper::bc('div', $this->seconds, 3600, 2);
		$this->laborBaseValue = (float) (MathHelper::bc('mul', $hoursBase, $this->avgHourlyRateUSD, 2) ?? 0.00);

		$hoursActual = MathHelper::bc('div', $this->actualSeconds, 3600, 2);
		$this->laborWithOverheadValue = (float) (MathHelper::bc('mul', $hoursActual, $this->avgHourlyRateUSD, 2) ?? 0.00);
	}

	/**
	 * Attribute the notional professional JCB seat cost to this project.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateToolAttribution(): void
	{
		$days       = max(1, $this->actualTotalDays);
		$denom      = max(1, $this->workdaysPerYear);
		$fraction   = MathHelper::bc('div', $days, $denom, 6) ?? 0.0;
		$seatCost   = MathHelper::bc('mul', $this->licenseSeatAnnualCost, $fraction, 6) ?? 0.0;
		$totalSeat  = MathHelper::bc('mul', $seatCost, max(1, $this->assumedDeveloperCount), 2) ?? 0.0;

		$this->toolLicenseAttribution = (float) $totalSeat;
	}

	/**
	 * Combine labor and tool attribution for the actual value.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateActualValue(): void
	{
		$this->actualValue = (float) (MathHelper::bc(
			'add',
			$this->laborWithOverheadValue,
			$this->toolLicenseAttribution,
			2
		) ?? 0.00);
	}

	/**
	 * Choose a market multiplier based on total lines.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function determineMarketMultiplier(): void
	{
		$complexity = $this->complexityengine->get($this->counter);

		$this->marketMultiplier = $complexity['complexity_multiplier'];
		$this->content->set('COMPLEXITY_INDEX', $complexity['complexity_index']);
	}

	/**
	 * Apply market multiplier and profit margin to get perceived value.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateMarketAndPerceivedValues(): void
	{
		$marketAdjusted = MathHelper::bc('mul', $this->actualValue, $this->marketMultiplier, 2) ?? 0.00;
		$marginFactor   = MathHelper::bc('add', 1.0, max(0.0, $this->profitMarginFactor), 4) ?? 1.0;
		$perceived      = MathHelper::bc('mul', $marketAdjusted, $marginFactor, 2) ?? 0.00;

		$this->marketAdjustedValue = (float) $marketAdjusted;
		$this->perceivedValue      = (float) $perceived;
	}

	/**
	 * Blueprint value based on replication potential and risk.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateBlueprintValue(): void
	{
		$replication = max(1, $this->blueprintReplicationPotential);
		$risk        = min(1.0, max(0.0, $this->blueprintRiskFactor));
		$oneMinus    = MathHelper::bc('sub', 1.0, $risk, 4) ?? 1.0;

		$tmp         = MathHelper::bc('mul', $this->perceivedValue, $replication, 4) ?? 0.00;
		$value       = MathHelper::bc('mul', $tmp, $oneMinus, 2) ?? 0.00;

		$this->blueprintValue = (float) $value;
	}

	/**
	 * Compute subscription breakdowns for app and blueprint (12, 24, 36 months).
	 *
	 * The calculation first distributes the total perceived or blueprint value
	 * across the assumed number of annual clients, producing a per-client baseline.
	 * It then scales that baseline over 1-, 2-, and 3-year terms (12, 24, 36 months)
	 * to yield realistic subscription tiers where longer commitments cost less per month,
	 * yet preserve consistent overall revenue across time.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function calculateSubscriptionBreakdowns(): void
	{
		//  assumed client count per/period
		$assumedClientCountPer12Month = (float) (MathHelper::bc('mul', $this->assumedSubscriptionPerMonth, 12, 2) ?? 0.00);
		$assumedClientCountPer24Month = (float) (MathHelper::bc('mul', $this->assumedSubscriptionPerMonth, 24, 2) ?? 0.00);
		$assumedClientCountPer36Month = (float) (MathHelper::bc('mul', $this->assumedSubscriptionPerMonth, 36, 2) ?? 0.00);

		// perceived value divided by the assumed client count per/period
		$this->appMonthly12 = (float) (MathHelper::bc('div', $this->perceivedValue, $assumedClientCountPer12Month, 2) ?? 0.00);
		$this->appMonthly24 = (float) (MathHelper::bc('div', $this->perceivedValue, $assumedClientCountPer24Month, 2) ?? 0.00);
		$this->appMonthly36 = (float) (MathHelper::bc('div', $this->perceivedValue, $assumedClientCountPer36Month, 2) ?? 0.00);

		// blueprint value divided by the assumed client count per/period
		$this->blueprintMonthly12 = (float) (MathHelper::bc('div', $this->blueprintValue, $assumedClientCountPer12Month, 2) ?? 0.00);
		$this->blueprintMonthly24 = (float) (MathHelper::bc('div', $this->blueprintValue, $assumedClientCountPer24Month, 2) ?? 0.00);
		$this->blueprintMonthly36 = (float) (MathHelper::bc('div', $this->blueprintValue, $assumedClientCountPer36Month, 2) ?? 0.00);
	}

	/**
	 * Store all results into the Content object.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function storeResults(): void
	{
		// Timer
		$this->content->set('COMPILER_TIMER_START', $this->counter->get('start', 100));
		$this->content->set('COMPILER_TIMER_END', $this->counter->get('end', 100));
		$this->content->set('COMPILER_TIMER', $this->timer);

		// Counts
		$this->content->set('LINE_COUNT', $this->counter->get('line', 100));
		$this->content->set('FIELD_COUNT', $this->counter->get('field', 100));
		$this->content->set('FILE_COUNT', $this->counter->get('file', 100));
		$this->content->set('FOLDER_COUNT', $this->counter->get('folder', 100));
		$this->content->set('PAGE_COUNT', $this->page);

		// Legacy duplicates (keep intact)
		$this->content->set('folders', $this->folderSeconds);
		$this->content->set('foldersSeconds', $this->folderSeconds);
		$this->content->set('files', $this->fileSeconds);
		$this->content->set('filesSeconds', $this->fileSeconds);
		$this->content->set('lines', $this->lineSeconds);
		$this->content->set('linesSeconds', $this->lineSeconds);

		// Note: historically both 'seconds' and 'actualSeconds' hold actualSeconds
		$this->content->set('seconds', $this->actualSeconds);
		$this->content->set('actualSeconds', $this->actualSeconds);

		// Base totals
		$this->content->set('totalHours', $this->totalHours);
		$this->content->set('totalDays', $this->totalDays);

		// Overhead seconds (legacy keys preserved)
		$this->content->set('debugging', $this->secondsDebugging);
		$this->content->set('secondsDebugging', $this->secondsDebugging);
		$this->content->set('planning', $this->secondsPlanning);
		$this->content->set('secondsPlanning', $this->secondsPlanning);
		$this->content->set('mapping', $this->secondsMapping);
		$this->content->set('secondsMapping', $this->secondsMapping);
		$this->content->set('office', $this->secondsOffice);
		$this->content->set('secondsOffice', $this->secondsOffice);

		// Totals with overhead
		$this->content->set('actualTotalHours', $this->actualTotalHours);
		$this->content->set('actualTotalDays', $this->actualTotalDays);

		// Overhead hours per category (preserved)
		$this->content->set('debuggingHours', $this->debuggingHours);
		$this->content->set('planningHours', $this->planningHours);
		$this->content->set('mappingHours', $this->mappingHours);
		$this->content->set('officeHours', $this->officeHours);

		// Overhead-only totals
		$this->content->set('actualHoursSpent', $this->actualHoursSpent);
		$this->content->set('actualDaysSpent', $this->actualDaysSpent);

		// Duration projections (legacy divisors kept)
		$this->content->set('projectWeekTime', $this->projectWeekTime);
		$this->content->set('projectMonthTime', $this->projectMonthTime);
	}

	/**
	 * Store extended valuation results without altering legacy content keys.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function storeExtendedResults(): void
	{
		// Additional, project estimate financial value
		$this->content->set('PROJECT_VALUE_USD', $this->makeMoney($this->projectValueUSD));
		$this->content->set('PROJECT_VALUE_PER_LINE_USD', $this->makeMoney($this->projectValuePerLine));
		$this->content->set('PROJECT_HOURLY_RATE_USD', $this->makeMoney($this->avgHourlyRateUSD));

		// Labor layers
		$this->content->set('LABOR_BASE_VALUE', $this->makeMoney($this->laborBaseValue));
		$this->content->set('LABOR_WITH_OVERHEAD_VALUE', $this->makeMoney($this->laborWithOverheadValue));

		// Tool attribution and actual value
		$this->content->set('TOOL_LICENSE_ATTRIBUTION', $this->makeMoney($this->toolLicenseAttribution));
		$this->content->set('ACTUAL_VALUE', $this->makeMoney($this->actualValue));

		// Market and perceived
		$this->content->set('MARKET_MULTIPLIER', $this->marketMultiplier);
		$this->content->set('SUBSCRIPTION_PER_MONTH', $this->assumedSubscriptionPerMonth);
		$this->content->set('MARKET_ADJUSTED_VALUE', $this->makeMoney($this->marketAdjustedValue));
		$this->content->set('PERCEIVED_VALUE', $this->makeMoney($this->perceivedValue));

		// One-time license suggestions
		$this->content->set('ONE_TIME_APP_LICENSE_FEE', $this->makeMoney($this->perceivedValue));
		$this->content->set('ONE_TIME_BLUEPRINT_LICENSE_FEE', $this->makeMoney($this->blueprintValue));

		// Blueprint economics
		$this->content->set('BLUEPRINT_REPLICATION_POTENTIAL', $this->blueprintReplicationPotential);
		$this->content->set('BLUEPRINT_RISK_FACTOR', $this->blueprintRiskFactor);
		$this->content->set('BLUEPRINT_VALUE', $this->makeMoney($this->blueprintValue));

		// Subscription breakdowns (app)
		$this->content->set('APP_SUBSCRIPTION_MONTHLY_12', $this->makeMoney($this->appMonthly12));
		$this->content->set('APP_SUBSCRIPTION_MONTHLY_24', $this->makeMoney($this->appMonthly24));
		$this->content->set('APP_SUBSCRIPTION_MONTHLY_36', $this->makeMoney($this->appMonthly36));

		// Subscription breakdowns (blueprint)
		$this->content->set('BLUEPRINT_SUBSCRIPTION_MONTHLY_12', $this->makeMoney($this->blueprintMonthly12));
		$this->content->set('BLUEPRINT_SUBSCRIPTION_MONTHLY_24', $this->makeMoney($this->blueprintMonthly24));
		$this->content->set('BLUEPRINT_SUBSCRIPTION_MONTHLY_36', $this->makeMoney($this->blueprintMonthly36));
	}

	/**
	 * Convert a value to a properly formatted money string.
	 *
	 * @param  float   $value     The value to format.
	 * @param  string  $currency  The currency code (default: 'USD').
	 * @param  string  $symbol    The currency symbol (default: '$').
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function makeMoney(float $value, string $currency = 'USD', string $symbol = '$'): string
	{
		$formatted = number_format($value, 2, '.', ',');
		return sprintf('%s %s (%s)', $symbol, $formatted, $currency);
	}
}

