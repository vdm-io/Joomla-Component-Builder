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

$this->app->input->set('hidemainmenu', false);

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>
<?php if ($this->canDo->get('assistant.access')): ?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task === 'assistant.back') {
			parent.history.back();
			return false;
		} else {
			var form = document.getElementById('adminForm');
			form.task.value = task;
			form.submit();
		}
	}
</script>
<?php $urlId = (isset($this->item->id)) ? '&id='. (int) $this->item->id : ''; ?>
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=assistant'.$urlId); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
</form>
<script type="text/javascript">
// Add spindle-wheel for importations:
jQuery(document).ready(function($) {

// waiting spinner
var outerDiv = jQuery('body');
jQuery('<div id="loading"></div>')
	.css("background", "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat")
	.css("top", outerDiv.position().top - jQuery(window).scrollTop())
	.css("left", outerDiv.position().left - jQuery(window).scrollLeft())
	.css("width", outerDiv.width())
	.css("height", outerDiv.height())
	.css("position", "fixed")
	.css("opacity", "0.80")
	.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
	.css("filter", "alpha(opacity = 80)")
	.css("display", "none")
	.appendTo(outerDiv);
});
</script>
<?php if(!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif; ?>
	<div id="assistant-form">
		<?php echo JHtml::_('bootstrap.startTabSet', 'assistant_tab', array('active' => 'jcb-assistant')); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'assistant_tab', 'jcb-assistant', JText::_('COM_COMPONENTBUILDER_PLAN', true)); ?>
				<div class="span7">
					<ul id="component-plan-builder" class="uk-switcher uk-margin">
						<li><?php echo $this->loadTemplate('jcbcomponentplan'); ?></li>
						<li><?php echo $this->loadTemplate('jcbviewsplan'); ?></li>
						<li><?php echo $this->loadTemplate('jcbplanoverview'); ?></li>
					</ul>
					<ul class="uk-tab uk-tab-bottom" data-uk-tab="{connect:'#component-plan-builder'}">
						<li><a href="#"><?php echo JText::_('COM_COMPONENTBUILDER_COMPONENT'); ?></a></li>
						<li><a href="#"><?php echo JText::_('COM_COMPONENTBUILDER_VIEWS'); ?></a></li>
						<li><a href="#"><?php echo JText::_('COM_COMPONENTBUILDER_OVERVIEW'); ?></a></li>
					</ul>
				</div>
				<div class="span4">
					<div id="plan-details"></div>
					<?php echo JLayoutHelper::render('jcbnoticeboardtabs', null); ?>
				</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'assistant_tab', 'plans', JText::_('COM_COMPONENTBUILDER_PLANS', true)); ?>
				<h2><?php echo JText::_('COM_COMPONENTBUILDER_WATCH_THIS_SPACE'); ?></h2>
				<h4><?php echo JText::_('COM_COMPONENTBUILDER_UNDER_DEVELOPMENT_TO_PROVIDE_PLAN_SHARING_OPTIONS_SIMILAR_TO_THE_JCB_SNIPPETS'); ?></h4>
				<?php // echo JLayoutHelper::render('jcbplansgui', null); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
</div>
<script type="text/javascript">
var all_is_good = '<?php echo JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_THERE_IS_NO_NOTICE_AT_THIS_TIME'); ?>';

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

