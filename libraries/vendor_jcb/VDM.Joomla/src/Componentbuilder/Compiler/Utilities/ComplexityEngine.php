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
use VDM\Joomla\Utilities\MathHelper;


/**
 * Calculates project structural complexity and determines market multiplier.
 * 
 * @since 5.1.4
 */
final class ComplexityEngine
{
	/**
	 * Default BCMath precision scale.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $scale = 4;

	/**
	 * The Config instance.
	 *
	 * @var   Config
	 * @since 5.1.4
	 */
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param  Config  $config  The Config instance from Valuation.
	 *
	 * @since  5.1.4
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Get the calculated complexity index and corresponding market multiplier.
	 *
	 * @param  Counter  $counter  The Counter class instance.
	 *
	 * @return array  ['complexity_index' => float, 'complexity_multiplier' => float]
	 * @since  5.1.4
	 */
	public function get(Counter $counter): array
	{
		// ---------------------------------------------------------------------
		// 1. Thresholds tuned from JoomEngine repository averages
		// ---------------------------------------------------------------------
		$thresholds = [
			'adminView'       => 10,
			'field'           => 500,
			'customAdminView' => 5,
			'siteView'        => 10,
			'layout'          => 20,
			'template'        => 25,
			'module'          => 1,
			'plugin'          => 2,
			'dynamicGet'      => 15,
			'power'           => 100,
			'customCodeBlock' => 50,
			'accessSize'      => 2500,
		];

		// ---------------------------------------------------------------------
		// 2. Weight factors
		// ---------------------------------------------------------------------
		$weights = [
			'adminView'       => 0.04,
			'field'           => 0.02,
			'customAdminView' => 0.10,
			'siteView'        => 0.15,
			'layout'          => 0.08,
			'template'        => 0.08,
			'module'          => 0.10,
			'plugin'          => 0.09,
			'dynamicGet'      => 0.03,
			'power'           => 0.15,
			'customCodeBlock' => 0.07,
			'accessSize'      => 0.07,
		];

		// ---------------------------------------------------------------------
		// 3. Compute normalized weighted scores
		// ---------------------------------------------------------------------
		$scores = [];

		foreach ($thresholds as $key => $limit)
		{
			$value = (int) $counter->get($key, 0);
			$normalized = min(1.0, (float) MathHelper::bc('div', $value, $limit, $this->scale));
			$scores[$key] = MathHelper::bc('mul', $normalized, $weights[$key], $this->scale);
		}

		$complexityBase = (float) MathHelper::sum($scores, $this->scale);
		if ($complexityBase > 1.0)
		{
			$complexityBase = 1.0;
		}

		// ---------------------------------------------------------------------
		// 4. Add project age and compile-time bonuses
		// ---------------------------------------------------------------------
		$projectStart = (int) $counter->get('projectStart', 0);
		$now          = time();
		$ageSeconds   = max(0, $now - $projectStart);
		$years        = (float) MathHelper::bc('div', $ageSeconds, 31536000, $this->scale);
		$ageBonus     = min(0.05, (float) MathHelper::bc('div', $years, 10, $this->scale));

		$start  = (float) $counter->get('start', 0.0);
		$end    = (float) $counter->get('end', 0.0);
		$length = max(0.0, (float) MathHelper::bc('sub', $end, $start, $this->scale));
		$compileBonus = 0.0;
		if ($length > 60.0)
		{
			$compileBonus = min(0.05, (float) MathHelper::bc('div', $length, 600.0, $this->scale));
		}

		$complexityIndex = (float) MathHelper::sum([$complexityBase, $ageBonus, $compileBonus], $this->scale);
		if ($complexityIndex > 1.0)
		{
			$complexityIndex = 1.0;
		}

		// ---------------------------------------------------------------------
		// 5. Map complexity to your configured multiplier model
		// ---------------------------------------------------------------------
		$low  = (float) $this->config->get('market_multiplier_low', 0.9);
		$mid  = (float) $this->config->get('market_multiplier_medium', 1.2);
		$high = (float) $this->config->get('market_multiplier_high', 2.0);
		$rev  = (float) $this->config->get('market_multiplier_revolutionary', 4.0);

		// Non-linear interpolation across four tiers
		// ---------------------------------------------------------------------
		if ((float) MathHelper::bc('comp', $complexityIndex, 0.25, $this->scale) === -1)
		{
			// range 0.00 – 0.25
			$step  = MathHelper::bc('div', $complexityIndex, 0.25, $this->scale);
			$diff  = MathHelper::bc('sub', $mid, $low, $this->scale);
			$add   = MathHelper::bc('mul', $diff, $step, $this->scale);
			$multiplier = (float) MathHelper::bc('add', $low, $add, 2);
		}
		elseif ((float) MathHelper::bc('comp', $complexityIndex, 0.6, $this->scale) === -1)
		{
			// range 0.25 – 0.59
			$offset = MathHelper::bc('sub', $complexityIndex, 0.25, $this->scale);
			$step   = MathHelper::bc('div', $offset, 0.35, $this->scale);
			$diff   = MathHelper::bc('sub', $high, $mid, $this->scale);
			$add    = MathHelper::bc('mul', $diff, $step, $this->scale);
			$multiplier = (float) MathHelper::bc('add', $mid, $add, 2);
		}
		elseif ((float) MathHelper::bc('comp', $complexityIndex, 1.0, $this->scale) <= 0)
		{
			// range 0.6 – 1.0
			$offset = MathHelper::bc('sub', $complexityIndex, 0.6, $this->scale);
			$step   = MathHelper::bc('div', $offset, 0.4, $this->scale);
			$diff   = MathHelper::bc('sub', $rev, $high, $this->scale);
			$add    = MathHelper::bc('mul', $diff, $step, $this->scale);
			$multiplier = (float) MathHelper::bc('add', $high, $add, 2);
		}
		else
		{
			$multiplier = (float) $rev;
		}

		// ---------------------------------------------------------------------
		// 6. Return result
		// ---------------------------------------------------------------------
		return [
			'complexity_index'      => round($complexityIndex, 4),
			'complexity_multiplier' => round($multiplier, 2)
		];
	}
}

