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

// Different support requests/appreciation 
$support = [
	Text::_("COM_COMPONENTBUILDER_JOOMLA_COMPONENT_BUILDER_JCB_IS_A_CRUCIAL_TOOL_FOR_PHP_PROGRAMMERS_WHO_USE_JOOMLA_TO_EARN_A_LIVING_BY_MAKING_A_BFINANCIAL_DONATIONB_YOU_CAN_SUPPORT_THE_GROWTH_AND_CONTINUITY_OF_THIS_VITAL_RESOURCE_AND_ENSURE_ITS_RELEVANCE_FOR_YEARS_TO_COME_YOUR_CONTRIBUTION_NO_MATTER_HOW_BIG_OR_SMALL_WILL_BE_DEEPLY_APPRECIATED_BY_THE_PROJECTS_TEAM_AND_THE_WIDER_COMMUNITY"),
	Text::_("COM_COMPONENTBUILDER_THE_CONTINUED_SUPPORT_OF_INDIVIDUALS_LIKE_YOU_HAS_ALLOWED_JOOMLA_COMPONENT_BUILDER_JCB_TO_THRIVE_FOR_SEVEN_YEARS_SINCE_GOING_PUBLIC_YOUR_CONTRIBUTIONS_HAVE_BEEN_CRUCIAL_IN_ENSURING_THE_GROWTH_AND_RELEVANCE_OF_THIS_VITAL_TOOL_FOR_PHP_PROGRAMMERS_THANK_YOU_FOR_YOUR_SUPPORT_AND_FOR_BEING_A_PART_OF_JCBS_JOURNEY"),
	Text::_("COM_COMPONENTBUILDER_SUPPORT_JOOMLA_COMPONENT_BUILDER_JCB_WITH_A_BFINANCIAL_DONATIONB_TO_SHOW_GRATITUDE_FOR_THE_TIME_AND_EFFORT_SAVED_IN_YOUR_DEVELOPMENT_PROCESS_YOUR_CONTRIBUTION_NO_MATTER_THE_SIZE_WILL_BE_APPRECIATED_BY_THE_PROJECTS_TEAM_AND_THE_WIDER_COMMUNITY_HELP_ENSURE_THE_GROWTH_AND_RELEVANCE_OF_THIS_ESSENTIAL_TOOL"),
	Text::_("COM_COMPONENTBUILDER_INVEST_IN_THE_FUTURE_OF_JOOMLA_COMPONENT_BUILDER_JCB_BY_MAKING_A_BFINANCIAL_DONATIONB_SUPPORT_THE_NECESSARY_DEVELOPMENT_AND_MAINTENANCE_OF_THIS_OPENSOURCE_PROJECT_ENSURING_ITS_CONTINUED_GROWTH_AND_RELEVANCE_FOR_THE_COMMUNITY_YOUR_CONTRIBUTION_WILL_HELP_SECURE_THE_FUTURE_OF_THIS_VITAL_TOOL_FOR_PHP_PROGRAMMERS"),
	Text::_("COM_COMPONENTBUILDER_INVEST_IN_THE_FUTURE_OF_JOOMLA_COMPONENT_BUILDER_JCB_BY_MAKING_A_BFINANCIAL_CONTRIBUTIONB_NO_MATTER_HOW_SMALL_THE_CONTINUAL_SUPPORT_OF_ALL_THOSE_USING_THE_TOOL_WILL_BE_MORE_THAN_ENOUGH_TO_ENSURE_ITS_CONTINUED_GROWTH_AND_RELEVANCE_BY_INVESTING_IN_THIS_OPENSOURCE_PROJECT_YOU_ARE_SECURING_ITS_FUTURE_AS_A_VITAL_TOOL_FOR_PHP_PROGRAMMERS"),
	Text::_("COM_COMPONENTBUILDER_WE_EXTEND_OUR_GRATITUDE_TO_ALL_THOSE_WHO_SUPPORT_JOOMLA_COMPONENT_BUILDER_JCB_WHETHER_AS_A_HOBBY_OR_AS_A_PART_OF_THEIR_BUSINESS_YOUR_CONTRIBUTIONS_WHETHER_FINANCIAL_OR_IN_THE_FORM_OF_ACTIVE_INVOLVEMENT_HAVE_HAD_A_SIGNIFICANT_IMPACT_ON_ENSURING_THE_GROWTH_AND_RELEVANCE_OF_THIS_VITAL_TOOL_FOR_PHP_PROGRAMMERS_WE_HIGHLY_VALUE_THE_DEDICATION_OF_HOBBYISTS_AND_THE_COMMITMENT_OF_COMPANIES_WHO_SUPPORT_JCB_AS_THEY_HAVE_ALLOWED_THE_PROJECT_TO_CONTINUE_ITS_DEVELOPMENT_AND_MAINTENANCE_PROVIDING_VALUABLE_RESOURCES_FOR_THE_COMMUNITY_WE_ARE_GRATEFUL_FOR_YOUR_CONTRIBUTIONS_NO_MATTER_HOW_SMALL_AND_THANK_YOU_FOR_BEING_A_PART_OF_THE_POSITIVE_IMPACT_THAT_JCB_HAS_ON_THE_PHP_PROGRAMMING_COMMUNITY"),
	Text::_("COM_COMPONENTBUILDER_WITHOUT_SUFFICIENT_SUPPORT_THE_FUTURE_OF_JOOMLA_COMPONENT_BUILDER_JCB_IS_IN_JEOPARDY_AS_A_VITAL_TOOL_FOR_PHP_PROGRAMMERS_IT_IS_CRUCIAL_TO_ENSURE_ITS_CONTINUED_DEVELOPMENT_AND_MAINTENANCE_BY_MAKING_A_BFINANCIAL_CONTRIBUTIONB_NO_MATTER_HOW_SMALL_YOU_ARE_HELPING_TO_SAFEGUARD_THE_FUTURE_OF_THIS_OPENSOURCE_PROJECT_NEGLECTING_TO_SUPPORT_JCB_COULD_RESULT_IN_ITS_DECLINE_AND_LOSS_AS_A_RESOURCE_FOR_THE_COMMUNITY"),
	Text::_("COM_COMPONENTBUILDER_WE_EXTEND_OUR_HEARTFELT_APPRECIATION_TO_THOSE_WHO_HAVE_SUPPORTED_THE_JOOMLA_COMPONENT_BUILDER_JCB_PROJECT_OVER_THE_YEARS_YOUR_CONTRIBUTIONS_NO_MATTER_HOW_BIG_OR_SMALL_HAVE_BEEN_INSTRUMENTAL_IN_ENSURING_ITS_GROWTH_AND_RELEVANCE_AS_A_VITAL_TOOL_FOR_PHP_PROGRAMMERS_SEVEN_YEARS_AFTER_GOING_PUBLIC_JCB_IS_STILL_HERE_TODAY_BECAUSE_OF_THE_SUPPORT_OF_INDIVIDUALS_LIKE_YOU_WHO_BELIEVE_IN_THE_IMPORTANCE_OF_THIS_OPENSOURCE_PROJECT_YOUR_GENEROSITY_HAS_ALLOWED_THE_PROJECT_TO_CONTINUE_ITS_DEVELOPMENT_AND_MAINTENANCE_PROVIDING_VALUABLE_RESOURCES_FOR_THE_COMMUNITY_THANK_YOU_FOR_YOUR_UNWAVERING_SUPPORT_AND_FOR_BEING_A_PART_OF_JCBS_JOURNEY"),
	Text::_("COM_COMPONENTBUILDER_WE_EXTEND_OUR_SINCERE_APPRECIATION_TO_THE_COMPANIES_WHO_USE_JOOMLA_COMPONENT_BUILDER_JCB_AND_SUPPORT_THE_PROJECT_YOUR_CONTRIBUTIONS_WHETHER_FINANCIAL_OR_IN_THE_FORM_OF_ACTIVE_INVOLVEMENT_HAVE_BEEN_INSTRUMENTAL_IN_ENSURING_THE_GROWTH_AND_RELEVANCE_OF_THIS_VITAL_TOOL_FOR_PHP_PROGRAMMERS_YOUR_SUPPORT_HAS_ALLOWED_JCB_TO_CONTINUE_ITS_DEVELOPMENT_AND_MAINTENANCE_PROVIDING_VALUABLE_RESOURCES_FOR_THE_COMMUNITY_THANK_YOU_FOR_YOUR_UNWAVERING_COMMITMENT_TO_THE_PROJECT_AND_FOR_BEING_A_PART_OF_JCBS_JOURNEY")
];

// build the support message
$support_message = $support[random_int(0, 8)];

// the button titles
$titles = [
	Text::_("COM_COMPONENTBUILDER_JCB_ENABLES_PHP_DEVELOPMENT"),
	Text::_("COM_COMPONENTBUILDER_JCB_SUPPORTS_OPENSOURCE"),
	Text::_("COM_COMPONENTBUILDER_JCB_SAVES_TIME"),
	Text::_("COM_COMPONENTBUILDER_JCB_IMPROVES_WORKFLOW"),
	Text::_("COM_COMPONENTBUILDER_JCB_EMPOWERS_PHP_DEVELOPERS"),
	Text::_("COM_COMPONENTBUILDER_JCB_STREAMLINES_DEVELOPMENT"),
	Text::_("COM_COMPONENTBUILDER_JCB_PROMOTES_EFFICIENCY"),
	Text::_("COM_COMPONENTBUILDER_JCB_ENHANCES_PRODUCTIVITY"),
	Text::_("COM_COMPONENTBUILDER_JCB_INCREASES_REVENUE"),
	Text::_("COM_COMPONENTBUILDER_JCB_REDUCES_DEVELOPMENT_COSTS"),
	Text::_("COM_COMPONENTBUILDER_JCB_SUPPORTS_THE_PHP_COMMUNITY"),
	Text::_("COM_COMPONENTBUILDER_JCB_IMPROVES_PHP_DEVELOPMENT"),
	Text::_("COM_COMPONENTBUILDER_JCB_HELPS_GROW_BUSINESSES"),
	Text::_("COM_COMPONENTBUILDER_JCB_SUPPORTS_PHP_INNOVATION"),
	Text::_("COM_COMPONENTBUILDER_JCB_CONTRIBUTES_TO_OPENSOURCE"),
	Text::_("COM_COMPONENTBUILDER_JCB_PROVIDES_A_BETTER_EXPERIENCE"),
	Text::_("COM_COMPONENTBUILDER_JCB_OFFERS_MORE_FEATURES"),
	Text::_("COM_COMPONENTBUILDER_JCB_INCREASES_DEVELOPMENT_SPEED"),
	Text::_("COM_COMPONENTBUILDER_JCB_IMPROVES_USER_EXPERIENCE"),
	Text::_("COM_COMPONENTBUILDER_JCB_INCREASES_USER_SATISFACTION"),
	Text::_("COM_COMPONENTBUILDER_JCB_LOWERS_DEVELOPMENT_STRESS"),
	Text::_("COM_COMPONENTBUILDER_JCB_PROMOTES_GOODWILL"),
	Text::_("COM_COMPONENTBUILDER_JCB_OFFERS_A_STRONGER_SOLUTION"),
	Text::_("COM_COMPONENTBUILDER_JCB_SUPPORTS_A_WORTHY_CAUSE"),
	Text::_("COM_COMPONENTBUILDER_JCB_BUILDS_A_BETTER_FUTURE"),
	Text::_("COM_COMPONENTBUILDER_JCB_FOSTERS_A_STRONG_COMMUNITY"),
	Text::_("COM_COMPONENTBUILDER_JCB_IMPROVES_PHPS_REPUTATION"),
	Text::_("COM_COMPONENTBUILDER_JCB_SUPPORTS_A_THRIVING_ECOSYSTEM"),
	Text::_("COM_COMPONENTBUILDER_JCB_HELPS_PHP_THRIVE"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVESTS_IN_PHPS_SUCCESS")
];

// build the support button
$support_titles = $titles[random_int(0, 29)];

// the button names
$button_names = [
	Text::_("COM_COMPONENTBUILDER_DONATE_TO_JCB"),
	Text::_("COM_COMPONENTBUILDER_SUPPORT_JCB_TODAY"),
	Text::_("COM_COMPONENTBUILDER_CONTRIBUTE_TO_JCB"),
	Text::_("COM_COMPONENTBUILDER_INVEST_IN_JCB"),
	Text::_("COM_COMPONENTBUILDER_GIVE_TO_JCB"),
	Text::_("COM_COMPONENTBUILDER_JOIN_JCBS_MISSION"),
	Text::_("COM_COMPONENTBUILDER_HELP_JCB_GROW"),
	Text::_("COM_COMPONENTBUILDER_BE_A_PART_OF_JCB"),
	Text::_("COM_COMPONENTBUILDER_JCB_NEEDS_YOU"),
	Text::_("COM_COMPONENTBUILDER_BECOME_A_CONTRIBUTOR"),
	Text::_("COM_COMPONENTBUILDER_EMPOWER_JCB"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_IMPACT"),
	Text::_("COM_COMPONENTBUILDER_JOIN_JCBS_COMMUNITY"),
	Text::_("COM_COMPONENTBUILDER_MAKE_A_DIFFERENCE_WITH_JCB"),
	Text::_("COM_COMPONENTBUILDER_JCB_YOUR_SUPPORT_MATTERS"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_THE_FUTURE"),
	Text::_("COM_COMPONENTBUILDER_JOIN_JCBS_JOURNEY"),
	Text::_("COM_COMPONENTBUILDER_JCB_YOUR_SUPPORT_COUNTS"),
	Text::_("COM_COMPONENTBUILDER_EMPOWER_THE_FUTURE_WITH_JCB"),
	Text::_("COM_COMPONENTBUILDER_JCB_YOUR_CONTRIBUTION_MATTERS"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_PROGRESS"),
	Text::_("COM_COMPONENTBUILDER_JOIN_JCBS_VISION"),
	Text::_("COM_COMPONENTBUILDER_ELEVATE_JCB_TODAY"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_CHANGE"),
	Text::_("COM_COMPONENTBUILDER_JCB_YOUR_DONATION_MATTERS"),
	Text::_("COM_COMPONENTBUILDER_JCB_BE_THE_CHANGE"),
	Text::_("COM_COMPONENTBUILDER_JOIN_JCBS_SUCCESS"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_SUCCESS"),
	Text::_("COM_COMPONENTBUILDER_JCB_YOUR_SUPPORT_IS_KEY"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_THE_COMMUNITY"),
	Text::_("COM_COMPONENTBUILDER_JCB_YOUR_SUPPORT_MATTERS_MOST"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_YOUR_FUTURE"),
	Text::_("COM_COMPONENTBUILDER_JCB_INVEST_IN_PROGRESS_TODAY")
];

// build the support button
$support_button = $button_names[random_int(0, 32)];

?>
<?php echo $support_message; ?>
<br /><br />
<img src="https://opencollective.com/joomla-component-builder/tiers/badge.svg" />
<br /><br />
<a class="btn btn-mini btn-success" href="https://opencollective.com/joomla-component-builder/donate?interval=month&amount=20" title="<?php echo $support_titles; ?>" trage="_blank">
	<?php echo $support_button; ?>
</a>
<br />
