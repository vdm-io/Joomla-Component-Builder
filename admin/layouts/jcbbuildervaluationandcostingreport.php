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



?>
<hr>
<h2><?php echo Text::_('COM_COMPONENTBUILDER_PROJECT_COST_MARKET_VALUATION'); ?></h2>

<p>
	<?php echo Text::_('COM_COMPONENTBUILDER_THIS_SECTION_ESTIMATES_THE_REALISTIC_FINANCIAL_VALUE_OF_THE_PROJECT_TAKING_INTO_ACCOUNT_ACTUAL_DEVELOPER_TIME_PROFESSIONAL_TOOL_LICENSING_MARKET_DEMAND_AND_BLUEPRINT_SCALABILITY'); ?>
</p>

<h3><?php echo Text::_('COM_COMPONENTBUILDER_BASE_DEVELOPMENT_VALUE'); ?></h3>
<ul>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_LABOR_BASE_VALUE_PURE_CODING_TIME'); ?>:
		<b><?php echo '#'.'##LABOR_BASE_VALUE##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_LABOR_WITH_OVERHEAD_INCLUDING_PLANNING_DEBUGGING_OFFICE_TIME'); ?>:
		<b><?php echo '#'.'##LABOR_WITH_OVERHEAD_VALUE##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_TOOL_LICENSE_ATTRIBUTION_NOTIONAL_JCB_PROFESSIONAL_SEAT_VALUE'); ?>:
		<b><?php echo '#'.'##TOOL_LICENSE_ATTRIBUTION##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_ACTUAL_TOTAL_PROJECT_VALUE_LABOR_TOOL_COST'); ?>:
		<b><?php echo '#'.'##ACTUAL_VALUE##'.'#'; ?></b>
	</li>
</ul>

<h3><?php echo Text::_('COM_COMPONENTBUILDER_MARKET_ADJUSTMENT_PERCEIVED_VALUE'); ?></h3>
<ul>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_APPLIED_MARKET_MULTIPLIER_BASED_ON_PROJECT_COMPLEXITY_AND_DEMAND'); ?>:
		<b><?php echo '#'.'##MARKET_MULTIPLIER##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_APPLIED_COMPLEXITY_INDEX_BASED_ON_THE_OUR_DEVELOPMENT_VALUATION_MODEL'); ?>:
		<b><?php echo '#'.'##COMPLEXITY_INDEX##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_MARKET_ADJUSTED_PROJECT_VALUE'); ?>:
		<b><?php echo '#'.'##MARKET_ADJUSTED_VALUE##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_PERCEIVED_MARKET_VALUE_INCLUDING_PROFIT_MARGIN'); ?>:
		<b><?php echo '#'.'##PERCEIVED_VALUE##'.'#'; ?></b>
	</li>
</ul>

<h3><?php echo Text::_('COM_COMPONENTBUILDER_BLUEPRINT_VALUE_REPLICATION_POTENTIAL'); ?></h3>
<ul>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_BLUEPRINT_REPLICATION_POTENTIAL'); ?>:
		<b><?php echo '#'.'##BLUEPRINT_REPLICATION_POTENTIAL##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_BLUEPRINT_RISK_FACTOR'); ?>:
		<b><?php echo '#'.'##BLUEPRINT_RISK_FACTOR##'.'#'; ?></b>
	</li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_CALCULATED_BLUEPRINT_VALUE'); ?>:
		<b><?php echo '#'.'##BLUEPRINT_VALUE##'.'#'; ?></b>
	</li>
</ul>

<h3><?php echo Text::_('COM_COMPONENTBUILDER_SUGGESTED_PRICING_MODELS'); ?></h3>
<p><?php echo Text::_('COM_COMPONENTBUILDER_BELOW_ARE_SUGGESTED_PRICING_STRATEGIES_BASED_ON_MARKET_STANDARDS_AND_SUSTAINABILITY_PRINCIPLES'); ?></p>
<ul>
	<li><?php echo Text::sprintf('COM_COMPONENTBUILDER_THE_BSUBSCRIPTIONB_MODEL_IS_BASED_ON_AN_EXPECTED_SUBSCRIPTION_OF_BSB_PER_MONTH', '#'.'##SUBSCRIPTION_PER_MONTH##'.'#'); ?></li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_THE_BBLUEPRINTB_IS_THE_JCB_PACKAGE_STORED_IN_A_BREPOSITORYB_THAT_CAN_BE_REUSED_IN_ANY_JCB_INSTALLATION_TO_REBUILD_THE_SAME_JOOMLA_EXTENSIONS_EXACTLY_AS_IT_WAS_ORIGINALLY_CREATED'); ?>
	<?php echo Text::_('COM_COMPONENTBUILDER_THE_BLUEPRINT_CONTAINS_THE_ENTIRE_ARCHITECTURE_OF_YOUR_PROJECT_NOT_JUST_FILES_BUT_INTENT_STRUCTURE_AND_DESIGN_MEANING_ANYONE_WITH_ACCESS_CAN_REBUILD_IT_REBRAND_IT_OR_EXTEND_IT_INTO_A_NEW_PRODUCT'); ?>
<?php echo Text::_('COM_COMPONENTBUILDER_THIS_MAKES_THE_BLUEPRINT_THE_MOST_VALUABLE_PART_OF_YOUR_PROJECT_AND_THE_TRUE_CONTAINER_OF_ITS_INTELLECTUAL_PROPERTY'); ?></li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_THE_BAPPB_IS_THE_JOOMLA_PACKAGE_YOU_INSTALL_THE_FINISHED_PRODUCT_BUILT_FROM_A_BLUEPRINT_REPRESENTING_A_SINGLE_USABLE_INSTANCE_OF_THE_PROJECT_RATHER_THAN_THE_ORIGINAL_DESIGN_THAT_CREATED_IT'); ?></li>
</ul>

<table class="table table-striped table-bordered" style="width:100%; max-width:800px;">
	<thead>
		<tr>
			<th><?php echo Text::_('COM_COMPONENTBUILDER_MODEL'); ?></th>
			<th><?php echo Text::_('COM_COMPONENTBUILDER_DURATION'); ?></th>
			<th><?php echo Text::_('COM_COMPONENTBUILDER_APP_PRICE'); ?></th>
			<th><?php echo Text::_('COM_COMPONENTBUILDER_BLUEPRINT_PRICE'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_ONETIME_LICENSE_FEE'); ?></td>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_LIFETIME'); ?></td>
			<td><b><?php echo '#'.'##ONE_TIME_APP_LICENSE_FEE##'.'#'; ?></b></td>
			<td><b><?php echo '#'.'##ONE_TIME_BLUEPRINT_LICENSE_FEE##'.'#'; ?></b></td>
		</tr>
		<tr>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_SUBSCRIPTION_PERMONTH'); ?></td>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_TWELVE_MONTHS'); ?></td>
			<td><b><?php echo '#'.'##APP_SUBSCRIPTION_MONTHLY_12##'.'#'; ?></b></td>
			<td><b><?php echo '#'.'##BLUEPRINT_SUBSCRIPTION_MONTHLY_12##'.'#'; ?></b></td>
		</tr>
		<tr>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_SUBSCRIPTION_PERMONTH'); ?></td>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_TWENTY_FOUR_MONTHS'); ?></td>
			<td><b><?php echo '#'.'##APP_SUBSCRIPTION_MONTHLY_24##'.'#'; ?></b></td>
			<td><b><?php echo '#'.'##BLUEPRINT_SUBSCRIPTION_MONTHLY_24##'.'#'; ?></b></td>
		</tr>
		<tr>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_SUBSCRIPTION_PERMONTH'); ?></td>
			<td><?php echo Text::_('COM_COMPONENTBUILDER_THIRTY_SIX_MONTHS'); ?></td>
			<td><b><?php echo '#'.'##APP_SUBSCRIPTION_MONTHLY_36##'.'#'; ?></b></td>
			<td><b><?php echo '#'.'##BLUEPRINT_SUBSCRIPTION_MONTHLY_36##'.'#'; ?></b></td>
		</tr>
	</tbody>
</table>
<p align="card card-body">
	<em><?php echo Text::_('COM_COMPONENTBUILDER_THESE_VALUES_PROVIDE_A_REALISTIC_INDUSTRYALIGNED_ESTIMATE_OF_THE_DEVELOPMENT_COST_AND_OVERALL_MARKET_WORTH_OF_THIS_PROJECT'); ?></em><br>
	<small>
		<?php echo Text::_('COM_COMPONENTBUILDER_ALL_VALUATIONS_ASSUME_THAT_THE_COMPILED_PACKAGE_IS_A_BCOMPLETE_FUNCTIONAL_AND_INDUSTRYRELEVANT_SOLUTIONB_WITH_BGENUINE_MARKET_DEMANDB_AND_BOPERATIONAL_STABILITYB_WITHIN_ITS_INTENDED_USE_CASE'); ?><br>
		<?php echo Text::_('COM_COMPONENTBUILDER_IF_THE_PACKAGE_IS_BINCOMPLETE_EXPERIMENTAL_OR_LACKS_A_DEFINED_PURPOSEB_THESE_FIGURES_SHOULD_NOT_BE_INTERPRETED_AS_ITS_ACTUAL_VALUE'); ?><br>
		<?php echo Text::_('COM_COMPONENTBUILDER_THESE_RESULTS_ARE_BINDICATIVEB_AND_MAY_VARY_ACROSS_REGIONS_DEPENDING_ON_BLOCAL_MARKET_CONDITIONS_INDUSTRY_MATURITY_AND_ECONOMIC_CONTEXTB'); ?><br>
		<?php echo Text::_('COM_COMPONENTBUILDER_ADJUSTING_THE_BASE_PARAMETERS_ENSURES_ACCURATE_ALIGNMENT_WITH_YOUR_LOCAL_STANDARDS_AND_BUSINESS_ENVIRONMENT'); ?><br>
		<?php echo Text::_('COM_COMPONENTBUILDER_ALL_CALCULATION_PARAMETERS_INCLUDING_BHOURLY_RATEB_BLICENSE_COSTB_BPROFIT_MARGINB_AND_BMARKET_DEMAND_THRESHOLDSB_CAN_BE_CUSTOMIZED_IN_THE_COMPONENT_BOPTIONSB_AREA_UNDER_THE_TAB_BDEVELOPMENT_VALUATION_MODELB_DVM'); ?><br>
	</small>
</p>
