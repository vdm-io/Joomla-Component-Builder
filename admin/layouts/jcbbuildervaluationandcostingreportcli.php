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



use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
defined('JPATH_BASE') or die;

/**
 * JCB Compiler - Project Cost & Market Valuation (CLI)
 *
 * SymfonyStyle-compatible CLI layout.
 * Plain text only. No Markdown. No HTML.
 *
 * @since 5.1.4
 */
$lines = [];

/**
 * Section header
 */
$lines[] = str_repeat('=', 60);
$lines[] = Text::_('COM_COMPONENTBUILDER_PROJECT_COST_MARKET_VALUATION');
$lines[] = str_repeat('=', 60);
$lines[] = '';

/**
 * Intro
 */
$lines[] = Text::_('COM_COMPONENTBUILDER_THIS_SECTION_ESTIMATES_THE_REALISTIC_FINANCIAL');
$lines[] = '   ' . Text::_('COM_COMPONENTBUILDER_VALUE_OF_THE_PROJECT_TAKING_INTO_ACCOUNT_ACTUAL');
$lines[] = '   ' . Text::_('COM_COMPONENTBUILDER_DEVELOPER_TIME_PROFESSIONAL_TOOL_LICENSING');
$lines[] = '   ' . Text::_('COM_COMPONENTBUILDER_MARKET_DEMAND_AND_BLUEPRINT_SCALABILITY');

/**
 * Base Development Value
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_BASE_DEVELOPMENT_VALUE');
$lines[] = str_repeat('-', 60);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_LABOR_BASE_VALUE_PURE_CODING_TIME'),
	'#' . '##LABOR_BASE_VALUE##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_LABOR_WITH_OVERHEAD_INCLUDING_PLANNING_DEBUGGING_OFFICE_TIME'),
	'#' . '##LABOR_WITH_OVERHEAD_VALUE##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_TOOL_LICENSE_ATTRIBUTION_NOTIONAL_JCB_PROFESSIONAL_SEAT_VALUE'),
	'#' . '##TOOL_LICENSE_ATTRIBUTION##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_ACTUAL_TOTAL_PROJECT_VALUE_LABOR_TOOL_COST'),
	'#' . '##ACTUAL_VALUE##' . '#'
);

/**
 * Market Adjustment
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_MARKET_ADJUSTMENT_PERCEIVED_VALUE');
$lines[] = str_repeat('-', 60);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_APPLIED_MARKET_MULTIPLIER_BASED_ON_PROJECT_COMPLEXITY_AND_DEMAND'),
	'#' . '##MARKET_MULTIPLIER##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_APPLIED_COMPLEXITY_INDEX_BASED_ON_THE_DEVELOPMENT_VALUATION_MODEL'),
	'#' . '##COMPLEXITY_INDEX##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_MARKET_ADJUSTED_PROJECT_VALUE'),
	'#' . '##MARKET_ADJUSTED_VALUE##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_PERCEIVED_MARKET_VALUE_INCLUDING_PROFIT_MARGIN'),
	'#' . '##PERCEIVED_VALUE##' . '#'
);

/**
 * Blueprint Value
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_BLUEPRINT_VALUE_REPLICATION_POTENTIAL');
$lines[] = str_repeat('-', 60);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_BLUEPRINT_REPLICATION_POTENTIAL'),
	'#' . '##BLUEPRINT_REPLICATION_POTENTIAL##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_BLUEPRINT_RISK_FACTOR'),
	'#' . '##BLUEPRINT_RISK_FACTOR##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_CALCULATED_BLUEPRINT_VALUE'),
	'#' . '##BLUEPRINT_VALUE##' . '#'
);

/**
 * Pricing Models
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_SUGGESTED_PRICING_MODELS');
$lines[] = str_repeat('-', 60);

$lines[] = Text::sprintf('COM_COMPONENTBUILDER_SUBSCRIPTION_MODEL_EXPECTED_S_PER_MONTH',
	'#' . '##SUBSCRIPTION_PER_MONTH##' . '#'
);

$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_BLUEPRINT_THE_JCB_PACKAGE_STORED_IN_A_REPOSITORY_THAT_CAN_BE_REUSED_IN');
$lines[] = '                    ' . Text::_('COM_COMPONENTBUILDER_ANY_JCB_INSTALLATION_TO_REBUILD_THE_SAME');
$lines[] = '                    ' . Text::_('COM_COMPONENTBUILDER_JOOMLA_EXTENSIONS_EXACTLY_AS_ORIGINALLY_CREATED');
$lines[] = '                  ' . Text::_('COM_COMPONENTBUILDER_THE_BLUEPRINT_CONTAINS_THE_COMPLETE_ARCHITECTURE_OF_THE');
$lines[] = '                    ' . Text::_('COM_COMPONENTBUILDER_PROJECT_INTENT_STRUCTURE_AND_DESIGN_ENABLING_REBUILDING');
$lines[] = '                    ' . Text::_('COM_COMPONENTBUILDER_REBRANDING_OR_EXTENSION_INTO_NEW_PRODUCTS');
$lines[] = '                  ' . Text::_('COM_COMPONENTBUILDER_THIS_MAKES_THE_BLUEPRINT_THE_PRIMARY_CONTAINER');
$lines[] = '                    ' . Text::_('COM_COMPONENTBUILDER_OF_THE_PROJECTS_INTELLECTUAL_PROPERTY');

$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_APP_THE_INSTALLABLE_JOOMLA_PACKAGE_BUILT_FROM_A_BLUEPRINT');
$lines[] = '  ' . Text::_('COM_COMPONENTBUILDER_REPRESENTING_A_SINGLE_USABLE_INSTANCE_RATHER_THAN_THE_ORIGINAL_DESIGN');

/**
 * Pricing Table
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_PRICING_TABLE');
$lines[] = str_repeat('-', 60);

/**
 * One-time license
 */
$lines[] = Text::_('COM_COMPONENTBUILDER_MODEL_ONETIME_LICENSE_FEE');
$lines[] = Text::_('COM_COMPONENTBUILDER_DURATION_LIFETIME');
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_APP_PRICE_S',
	'#' . '##ONE_TIME_APP_LICENSE_FEE##' . '#'
);
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_BLUEPRINT_PRICE_S',
	'#' . '##ONE_TIME_BLUEPRINT_LICENSE_FEE##' . '#'
);

/**
 * Subscription tiers
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_MODEL_SUBSCRIPTION_PER_MONTH');
$lines[] = Text::_('COM_COMPONENTBUILDER_DURATION_TWELVE_MONTHS');
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_APP_PRICE_S',
	'#' . '##APP_SUBSCRIPTION_MONTHLY_12##' . '#'
);
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_BLUEPRINT_PRICE_S',
	'#' . '##BLUEPRINT_SUBSCRIPTION_MONTHLY_12##' . '#'
);

$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_DURATION_TWENTY_FOUR_MONTHS');
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_APP_PRICE_S',
	'#' . '##APP_SUBSCRIPTION_MONTHLY_24##' . '#'
);
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_BLUEPRINT_PRICE_S',
	'#' . '##BLUEPRINT_SUBSCRIPTION_MONTHLY_24##' . '#'
);

$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_DURATION_THIRTY_SIX_MONTHS');
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_APP_PRICE_S',
	'#' . '##APP_SUBSCRIPTION_MONTHLY_36##' . '#'
);
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_BLUEPRINT_PRICE_S',
	'#' . '##BLUEPRINT_SUBSCRIPTION_MONTHLY_36##' . '#'
);

/**
 * Notes & disclaimers
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_THESE_VALUES_PROVIDE_A_REALISTIC_INDUSTRYALIGNED_ESTIMATE');
$lines[] = '     ' . Text::_('COM_COMPONENTBUILDER_OF_THE_DEVELOPMENT_COST_AND_OVERALL_MARKET_WORTH_OF_THIS_PROJECT');
$lines[] = Text::_('COM_COMPONENTBUILDER_ALL_VALUATIONS_ASSUME_A_COMPLETE_FUNCTIONAL_INDUSTRYRELEVANT');
$lines[] = '     ' . Text::_('COM_COMPONENTBUILDER_SOLUTION_WITH_GENUINE_MARKET_DEMAND_AND_OPERATIONAL_STABILITY');
$lines[] = Text::_('COM_COMPONENTBUILDER_IF_THE_PACKAGE_IS_INCOMPLETE_EXPERIMENTAL_OR_LACKS_A_DEFINED');
$lines[] = '     ' . Text::_('COM_COMPONENTBUILDER_PURPOSE_THESE_FIGURES_SHOULD_NOT_BE_INTERPRETED_AS_ACTUAL_VALUE');
$lines[] = Text::_('COM_COMPONENTBUILDER_RESULTS_ARE_INDICATIVE_AND_MAY_VARY_BY_REGION_DUE_TO_LOCAL');
$lines[] = '     ' . Text::_('COM_COMPONENTBUILDER_MARKET_CONDITIONS_AND_ECONOMIC_CONTEXT');
$lines[] = Text::_('COM_COMPONENTBUILDER_CALCULATION_PARAMETERS_HOURLY_RATE_LICENSE_COST_PROFIT');
$lines[] = '     ' . Text::_('COM_COMPONENTBUILDER_MARGIN_AND_DEMAND_THRESHOLDS_CAN_BE_ADJUSTED_IN_THE');
$lines[] = '     ' . Text::_('COM_COMPONENTBUILDER_OPTIONS_AREA_UNDER_DEVELOPMENT_VALUATION_MODEL_DVM');

?>
<?php echo implode(PHP_EOL, $lines); ?>
