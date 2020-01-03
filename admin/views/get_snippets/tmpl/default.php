<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>
<?php if ($this->canDo->get('get_snippets.access')): ?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task === 'get_snippets.back') {
			parent.history.back();
			return false;
		} else {
			var form = document.getElementById('adminForm');
			form.task.value = task;
			form.submit();
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=get_snippets'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
</form>

<div id="snippets-github" class="bulk-updater-toggler">
	<br /><br /><br />
	<center><h1> <?php echo JText::_('COM_COMPONENTBUILDER_GETTING_AVAILABLE_LIBRARIES'); ?> <br /><?php echo JText::_('COM_COMPONENTBUILDER_LOADING'); ?>.<span class="loading-dots">.</span></h1></center>
</div>
<div id="libraries-display" style="display: none;">
	<div id="libraries-grid" class="uk-grid uk-grid-preserve uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{gutter:10}" data-uk-check-display>
	</div>
</div>
<div class="bulk-updater-toggler uk-hidden">
	<h1><?php echo JText::_('COM_COMPONENTBUILDER_BULK_TOOLS'); ?></h1>
</div>
<div id="snippets-display" style="display: none;">
	<div class="uk-hidden-small">
		<nav class="uk-navbar uk-width-1-1">
			<a href="https://github.com/vdm-io/Joomla-Component-Builder-Snippets" class="uk-navbar-brand uk-hidden-medium" target="_blank"><i class="uk-icon-github"></i> gitHub</a>
			<ul class="uk-navbar-nav snippets-menu bulk-updater-toggler">
				<li data-uk-filter="" class="uk-active"><a href=""><i class="uk-icon-asterisk"></i><span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_ALL'); ?></span></a></li>
				<li data-uk-filter="equal"><a href=""><i class="uk-icon-chain"></i><span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_IN_SYNC'); ?></span></a></li>
				<li data-uk-filter="behind"><a href=""><i class="uk-icon-chain-broken"></i><span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_OUT_OF_DATE'); ?></span></a></li>
				<li data-uk-filter="new"><a href=""><i class="uk-icon-coffee"></i><span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_NEW'); ?></span></a></li>
				<li data-uk-filter="diverged"><a href=""><i class="uk-icon-code-fork"></i><span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_DIVERGED'); ?></span></a></li>
				<li data-uk-filter="ahead"><a href=""><i class="uk-icon-joomla"></i><span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_AHEAD'); ?></span></a></li>
				<li data-uk-sort="snippet-name">
					<a href="">
						<i class="uk-icon-sort-amount-asc"></i>
						<span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_NAME_ASC'); ?></span>
						<span class="uk-visible-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_NAME'); ?></span>
					</a>
				</li>
				<li data-uk-sort="snippet-name:desc">
					<a href="">
						<i class="uk-icon-sort-amount-desc"></i>
						<span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_NAME_DESC'); ?></span>
						<span class="uk-visible-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_NAME'); ?></span>
					</a>
				</li>
				<li data-uk-sort="snippet-types">
					<a href="">
						<i class="uk-icon-sort-amount-asc"></i>
						<span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_TYPE_ASC'); ?></span>
						<span class="uk-visible-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_TYPE'); ?></span>
					</a>
				</li>
				<li data-uk-sort="snippet-types:desc">
					<a href="">
						<i class="uk-icon-sort-amount-desc"></i>
						<span class="uk-hidden-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_TYPE_DESC'); ?></span>
						<span class="uk-visible-medium"> <?php echo JText::_('COM_COMPONENTBUILDER_TYPE'); ?></span>
					</a>
				</li>
			</ul>
			<div class="uk-navbar-flip">
				<ul class="uk-navbar-nav">
					<li class="bulk-updater-toggler">
						<a class="getreaction" data-type="getLibraries" title="<?php echo JText::_('COM_COMPONENTBUILDER_BACK_TO_LIBRARIES'); ?>">
							<i class="uk-icon-puzzle-piece"></i>
							<span class="uk-hidden-medium"><?php echo JText::_('COM_COMPONENTBUILDER_LIBRARIES'); ?></span>
						</a>
					</li>
					<li>
						<a class="getreaction" data-uk-toggle="{target:'.bulk-updater-toggler', animation:'uk-animation-slide-bottom, uk-animation-slide-bottom'}" data-type="bulk" title="<?php echo JText::_('COM_COMPONENTBUILDER_ACCESS_BULK_TOOLS'); ?>">
							<i class="uk-icon-cog"></i>
							<span class="uk-hidden-medium"><?php echo JText::_('COM_COMPONENTBUILDER_BULK'); ?></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="uk-visible-small">
		<nav class="uk-navbar uk-width-1-1">
			<ul class="uk-navbar-nav snippets-menu">
				<li data-uk-filter="" class="uk-active"><a href=""><i class="uk-icon-asterisk"></i></a></li>
				<li data-uk-filter="equal"><a href=""><i class="uk-icon-chain"></i></a></li>
				<li data-uk-filter="behind"><a href=""><i class="uk-icon-chain-broken"></i></a></li>
				<li data-uk-filter="new"><a href=""><i class="uk-icon-coffee"></i></a></li>
				<li data-uk-filter="diverged"><a href=""><i class="uk-icon-code-fork"></i></a></li>
				<li data-uk-filter="ahead"><a href=""><i class="uk-icon-joomla"></i></a></li>
				<li class="bulk-updater-toggler"><a class="getreaction" data-type="getLibraries" title="<?php echo JText::_('COM_COMPONENTBUILDER_BACK_TO_LIBRARIES'); ?>"><i class="uk-icon-puzzle-piece"></i></a></li>
				<li><a class="getreaction" data-uk-toggle="{target:'.bulk-updater-toggler', animation:'uk-animation-slide-bottom, uk-animation-slide-bottom'}" data-type="bulk" title="<?php echo JText::_('COM_COMPONENTBUILDER_ACCESS_BULK_TOOLS'); ?>"><i class="uk-icon-cog"></i></a></li>
			</ul>
		</nav>
	</div>
	<div class="bulk-updater-toggler uk-hidden">
		<br />
		<div class="uk-grid" data-uk-grid-match="{target:'.uk-panel'}">
			<div class="uk-width-medium-1-4">
				<div class="uk-panel uk-panel-box uk-panel-box-primary">
					<div class="uk-badge uk-panel-badge uk-badge-notification"><a href="#behind-meaning" data-uk-offcanvas class="uk-text-contrast"><i class="uk-icon-info"></i></a></div>
					<h3 class="uk-panel-title"><i class="uk-icon-chain-broken"></i> <?php echo JText::_('COM_COMPONENTBUILDER_OUT_OF_DATE'); ?></h3>
					<div id="bulk-notice-behind" class="uk-alert uk-alert-warning" style="display: none;"><?php echo JText::_('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_SNIPPETS_AT_THIS_TIME'); ?></div>
					<button id="bulk-button-behind" class="getreaction uk-button uk-button-primary uk-width-1-1" data-status="behind" data-type="all" title="<?php echo JText::_('COM_COMPONENTBUILDER_BULK_UPDATE_ALL_OUT_DATED_SNIPPETS'); ?>">
						<i class="uk-icon-cloud-download"></i>
						<?php echo JText::_('COM_COMPONENTBUILDER_UPDATE_ALL_OUT_DATED_SNIPPETS'); ?>
					</button>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="uk-panel uk-panel-box uk-panel-box-primary">
					<div class="uk-badge uk-panel-badge uk-badge-notification"><a href="#new-meaning" data-uk-offcanvas class="uk-text-contrast"><i class="uk-icon-info"></i></a></div>
					<h3 class="uk-panel-title"><i class="uk-icon-coffee"></i> <?php echo JText::_('COM_COMPONENTBUILDER_NEW'); ?></h3>
					<div id="bulk-notice-new" class="uk-alert uk-alert-warning" style="display: none;"><?php echo JText::_('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_SNIPPETS_AT_THIS_TIME'); ?></div>
					<button id="bulk-button-new" class="getreaction uk-button uk-button-primary uk-width-1-1" data-status="new" data-type="all" title="<?php echo JText::_('COM_COMPONENTBUILDER_BULK_GET_ALL_NEW_SNIPPETS'); ?>">
						<i class="uk-icon-cloud-download"></i>
						<?php echo JText::_('COM_COMPONENTBUILDER_GET_ALL_NEW_SNIPPETS'); ?>
					</button>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="uk-panel uk-panel-box uk-panel-box-primary">
					<div class="uk-badge uk-panel-badge uk-badge-notification"><a href="#diverged-meaning" data-uk-offcanvas class="uk-text-contrast"><i class="uk-icon-info"></i></a></div>
					<h3 class="uk-panel-title"><i class="uk-icon-code-fork"></i> <?php echo JText::_('COM_COMPONENTBUILDER_DIVERGED'); ?></h3>
					<div id="bulk-notice-diverged" class="uk-alert uk-alert-warning" style="display: none;"><?php echo JText::_('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_SNIPPETS_AT_THIS_TIME'); ?></div>
					<button id="bulk-button-diverged" class="getreaction uk-button uk-button-primary uk-width-1-1" data-status="diverged" data-type="all" title="<?php echo JText::_('COM_COMPONENTBUILDER_BULK_UPDATE_ALL_DIVERGED_SNIPPETS'); ?>">
						<i class="uk-icon-cloud-download"></i>
						<?php echo JText::_('COM_COMPONENTBUILDER_UPDATE_ALL_DIVERGED_SNIPPETS'); ?>
					</button>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="uk-panel uk-panel-box uk-panel-box-primary">
					<div class="uk-badge uk-panel-badge uk-badge-notification"><a href="#ahead-meaning" data-uk-offcanvas class="uk-text-contrast"><i class="uk-icon-info"></i></a></div>
					<h3 class="uk-panel-title"><i class="uk-icon-joomla"></i> <?php echo JText::_('COM_COMPONENTBUILDER_AHEAD'); ?></h3>
					<div id="bulk-notice-ahead" class="uk-alert uk-alert-warning" style="display: none;"><?php echo JText::_('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_SNIPPETS_AT_THIS_TIME'); ?></div>
					<button id="bulk-button-ahead" class="getreaction uk-button uk-button-primary uk-width-1-1" data-status="ahead" data-type="all" title="<?php echo JText::_('COM_COMPONENTBUILDER_BULK_UPDATE_ALL_AHEAD_SNIPPETS'); ?>">
						<i class="uk-icon-cloud-download"></i>
						<?php echo JText::_('COM_COMPONENTBUILDER_REVERT_ALL_AHEAD_SNIPPETS'); ?>
					</button>
				</div>
			</div>
		</div>
		<br />
		<div id="bulk-notice-all" class="uk-alert uk-alert-warning" style="display: none;"><?php echo JText::_('COM_COMPONENTBUILDER_THERE_ARE_NO_SNIPPETS_TO_UPDATE_AT_THIS_TIME'); ?></div>
		<button id="bulk-button-all" class="getreaction uk-button uk-button-success uk-width-1-1" data-status="all" data-type="all" title="<?php echo JText::_('COM_COMPONENTBUILDER_BULK_UPDATE_ALL_AVAILABLE_SNIPPETS'); ?>">
			<i class="uk-icon-cloud-download"></i>
			<?php echo JText::_('COM_COMPONENTBUILDER_JUST_GET_ALL_SNIPPETS'); ?>
		</button>
	</div>
	<br />
	<div id="snippets-grid" class="bulk-updater-toggler uk-grid uk-grid-preserve uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{gutter:10, controls: '.snippets-menu'}" data-uk-check-display>
	</div>
</div>
<div id="new-meaning" class="uk-offcanvas">
	<div class="uk-offcanvas-bar"><br /><br /><br /><div class="uk-panel">
		<h3><?php echo JText::_('COM_COMPONENTBUILDER_NEW'); ?></h3>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_NEW_MEANS_THAT_WE_COULD_NOT_FIND_A_LOCAL_SNIPPET_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE_AND_SO_HAVE_MARKED_THIS_SNIPPET_AS_NEW'); ?></p>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_THE_SEARCH_FOR_THE_SNIPPETS_ARE_CASE_SENSITIVE_SO_IF_YOU_CHANGED_THE_LOCAL_BNAMESB_OF_EITHER_OR_THE_BSNIPPET_LIBRARY_OR_SNIPPET_TYPESB_IN_ANY_SMALL_WAY_THE_SYSTEM_WILL_NOT_BE_ABLE_TO_CONNECT_YOUR_LOCAL_SNIPPETS_WITH_THOSE_IN_THE_COMMUNITY_REPOSITORY_SO_WE_STRONGLY_ADVICE_TO_BKEEP_TO_THE_COMMUNITY_NAMINGB_TO_AVOID_MISMATCHING_THAT_WILL_IN_TURN_CAUSE_DUPLICATION_SO_IF_YOU_CHANGED_ANY_NAMES_JUST_CHANGE_THEM_BACK_AND_ALL_WILL_AGAIN_WORK_AS_EXPECTED'); ?></p>
	</div></div>
</div>
<div id="equal-meaning" class="uk-offcanvas">
	<div class="uk-offcanvas-bar"><br /><br /><br /><div class="uk-panel">
		<h3><?php echo JText::_('COM_COMPONENTBUILDER_EQUAL'); ?></h3>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_EQUAL_MEANS_THAT_THE_COMMUNITY_SNIPPET_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE_AND_YOUR_LOCAL_SNIPPET_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE_HAS_THE_SAME_BCREATIONB_AND_BMODIFIED_DATEB'); ?></p>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_WE_DID_NOT_CHECK_THE_SNIPPET_IT_SELF_TO_SEE_IF_IT_CHANGED_WE_ONLY_WORK_ON_DATES'); ?></p>
	</div></div>
</div>
<div id="ahead-meaning" class="uk-offcanvas">
	<div class="uk-offcanvas-bar"><br /><br /><br /><div class="uk-panel">
		<h3><?php echo JText::_('COM_COMPONENTBUILDER_AHEAD'); ?></h3>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_AHEAD_MEANS_YOUR_BLOCAL_SNIPPETB_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE_HAS_A_BNEWER_MODIFIED_DATEB_THEN_THE_COMMUNITY_SNIPPET_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE'); ?></p>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_WE_DID_NOT_CHECK_THE_SNIPPET_IT_SELF_TO_SEE_IF_IT_CHANGED_WE_ONLY_WORK_ON_DATES'); ?></p>
	</div></div>
</div>
<div id="behind-meaning" class="uk-offcanvas">
	<div class="uk-offcanvas-bar"><br /><br /><br /><div class="uk-panel">
		<h3><?php echo JText::_('COM_COMPONENTBUILDER_BEHIND'); ?></h3>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_BEHIND_MEANS_YOUR_BLOCAL_SNIPPETB_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE_HAS_A_BOLDER_MODIFIED_DATEB_THEN_THE_COMMUNITY_SNIPPET_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE'); ?></p>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_WE_DID_NOT_CHECK_THE_SNIPPET_IT_SELF_TO_SEE_IF_IT_CHANGED_WE_ONLY_WORK_ON_DATES'); ?></p>
	</div></div>
</div>
<div id="diverged-meaning" class="uk-offcanvas">
	<div class="uk-offcanvas-bar"><br /><br /><br /><div class="uk-panel">
		<h3><?php echo JText::_('COM_COMPONENTBUILDER_DIVERGED'); ?></h3>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_DIVERGED_MEANS_YOUR_BLOCAL_SNIPPETB_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE_HAS_A_BDIVERGEDB_FROM_THE_COMMUNITY_SNIPPET_WITH_THE_SAME_NAME_LIBRARY_AND_TYPE_IN_THAT_IT_DOES_NOT_HAVE_THE_SAME_BCREATIONB_OR_BMODIFIED_DATEB'); ?></p>
		<p><?php echo JText::_('COM_COMPONENTBUILDER_WE_DID_NOT_CHECK_THE_SNIPPET_IT_SELF_TO_SEE_IF_IT_CHANGED_WE_ONLY_WORK_ON_DATES'); ?></p>
	</div></div>
</div>
<div id="loading" style="display: none;"><br /><h3><?php echo JText::_('COM_COMPONENTBUILDER_PLEASE_WAIT_LOADING'); ?>.<span class="loading-dots">.</span></h3></div>
<script type="text/javascript">

// nice little dot trick :)
jQuery(document).ready( function($) {
  var x=0;
  setInterval(function() {
	var dots = "";
	x++;
	for (var y=0; y < x%8; y++) {
		dots+=".";
	}
	$(".loading-dots").text(dots);
  } , 500);
});

<?php
	$app = JFactory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'.JURI::root().'";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}
</script>
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
