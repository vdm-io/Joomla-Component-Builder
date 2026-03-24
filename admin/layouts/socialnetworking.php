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
<div id="llewellyns-social-icons" class="float-end social-icons">
	<a href="https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_JOIN_LLEWELLYN_ON_THE_JOOMLA_VOLUNTEER_PORTAL_SHAPING_THE_FUTURE_TOGETHER'); ?>">
		<i class="fa fa-joomla"></i>
	</a>
	<a href="https://github.com/joomengine" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_BUILD_PREMIUM_JOOMLA_EXTENSIONS_WITH_JOOMENGINE_ON_GITHUB_HELP_US_RAISE_JOOMLA_EXTENSION_STANDARDS'); ?>">
		<i class="fa fa-git"></i>
	</a>
	<a href="https://git.vdm.dev/octoleo" class="text-decoration-none me-2" data-description="--quiet">
		<i class="fa fa-linux"></i>
	</a>
	<a href="https://git.vdm.dev/Llewellyn" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_COLLABORATE_AND_INNOVATE_WITH_LLEWELLYN_ON_GIT_BUILDING_A_BETTER_CODE_FUTURE'); ?>">
		<i class="fa fa-code"></i>
	</a>
	<a href="https://t.me/Joomla_component_builder" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_JOIN_LLEWELLYN_AND_THE_COMMUNITY_ON_TELEGRAM_BUILDING_JOOMLA_COMPONENTS_TOGETHER'); ?>">
		<i class="fa-brands fa-telegram"></i>
	</a>
	<a href="https://joomla.social/@llewellyn" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_CONNECT_AND_ENGAGE_WITH_LLEWELLYN_ON_JOOMLA_SOCIAL_EMPOWERING_COMMUNITIES_ONE_POST_AT_A_TIME'); ?>">
		<i class="fa-brands fa-mastodon"></i>
	</a>
	<a href="https://x.com/llewellynvdm" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_JOIN_THE_CONVERSATION_WITH_LLEWELLYN_ON_X_WHERE_IDEAS_TAKE_FLIGHT'); ?>">
		<i class="fa-brands fa-x-twitter"></i>
	</a>
	<a href="https://github.com/Llewellynvdm" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_BUILD_INNOVATE_AND_THRIVE_WITH_LLEWELLYN_ON_GITHUB_TURNING_IDEAS_INTO_IMPACT'); ?>">
		<i class="fa fa-github"></i>
	</a>
	<a href="https://www.youtube.com/@OctoYou" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_EXPLORE_LEARN_AND_CREATE_WITH_LLEWELLYN_ON_YOUTUBE_YOUR_GATEWAY_TO_INSPIRATION'); ?>">
		<i class="fa fa-youtube"></i>
	</a>
	<a href="https://n8n.io/creators/octoleo" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_EFFORTLESS_AUTOMATION_AND_IMPACTFUL_WORKFLOWS_WITH_LLEWELLYN_ON_NEIGHTN'); ?>">
		<i class="fa fa-code-fork"></i>
	</a>
	<a href="https://hub.docker.com/r/octoleo/joomengine" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_JOOMENGINE_ON_DOCKER_CONTAINERIZE_YOUR_CREATIVITY'); ?>">
		<i class="fa-brands fa-docker"></i>
	</a>
	<a href="https://opencollective.com/joomla-component-builder" class="text-decoration-none me-2" data-description="<?php echo Text::_('COM_COMPONENTBUILDER_DONATE_TOWARDS_JCB_HELP_LLEWELLYN_FINANCIALLY_SO_HE_CAN_CONTINUE_DEVELOPING_THIS_GREAT_TOOL'); ?>">
		<i class="fa-solid fa-circle-dollar-to-slot"></i>
	</a>
	<a href="https://git.vdm.dev/Llewellyn/gpg" class="text-decoration-none" data-description="<?php echo Text::_("COM_COMPONENTBUILDER_UNLOCK_TRUST_AND_SECURITY_WITH_LLEWELLYNS_GPG_KEY_YOUR_GATEWAY_TO_VERIFIED_CONNECTIONS"); ?>">
		<i class="fa-solid fa-fingerprint"></i>
	</a>
</div>
<br>
<div id="llewellyns-social-icon-details" class="float-end social-icon-details"></div>
<script>
document.addEventListener("DOMContentLoaded", () => {
  new IconWaveAnimator("llewellyns-social-icons", "llewellyns-social-icon-details");
});
</script>
