<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

$this->app->input->set('hidemainmenu', false);
$selectNotice = '<h3>' . JText::_('COM_COMPONENTBUILDER_HI') . ' ' . $this->user->name . '</h3>';
$selectNotice .= '<p>' . JText::_('COM_COMPONENTBUILDER_PLEASE_SELECT_A_COMPONENT_THAT_YOU_WOULD_LIKE_TO_COMPILE') . '</p>';
?>
<?php if ($this->canDo->get('compiler.access')): ?>
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=compiler'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<script type="text/javascript">
Joomla.submitbutton = function(task, key)
{
	if (task == ''){
		return false;
	} else {
		var component = jQuery('#component').val();
		var isValid = true;
		
		if(component == '' && task == 'compiler.compiler'){
			isValid = false;
		}
		if (isValid){
			jQuery('#form').hide();
			// get correct form based on task
			var form = document.getElementById('adminForm');
			// set the plugin id
			if (task == 'compiler.installCompiledModule' || task == 'compiler.installCompiledPlugin') {
				form.install_item_id.value = key;
			}
			// set the task value
			form.task.value = task;
			form.submit();
			// some ui movements
			if (task == 'compiler.compiler'){
				// get the component name
				let component_name = jQuery("#component option:selected").text();
				// set the component name
				jQuery(".component-name").text(component_name);
				// wait a little since to much is happening...
				setTimeout(function() {
					jQuery('#compiler').show();
					jQuery('#compiling').css('display', 'block');
					// wait a little since to much is happening...
					setTimeout(function() {
						jQuery('#compiler-spinner').show();
						jQuery('#compiler-notice').show();
					}, 100);
				}, 100);
			} else if (task == 'compiler.clearTmp'){
				jQuery('#clear').show();
				jQuery('#loading').css('display', 'block');
			} else {
				jQuery('#loading').css('display', 'block');
			}
			return true;
		} else {
			jQuery('.notice').show();
			return false;
		}
	}
}
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
// for the compiler
var outerDiv = jQuery('body');
jQuery('<div id="compiling"></div>')
        .css("background", "rgba(16, 164, 230, .4)")
        .css("top", outerDiv.position().top - jQuery(window).scrollTop())
        .css("left", outerDiv.position().left - jQuery(window).scrollLeft())
        .css("width", outerDiv.width())
        .css("height", outerDiv.height())
        .css("position", "fixed")
        .css("opacity", "0.40")
        .css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 40)")
        .css("filter", "alpha(opacity = 40)")
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
	<div id="form">
		<div class="span4">
			<h3><?= JText::_('COM_COMPONENTBUILDER_READY_TO_COMPILE_A_COMPONENT') ?></h3>
			<div id="compilerForm">
				<div>
				<span class="notice" style="display:none; color:red;"><?= JText::_('COM_COMPONENTBUILDER_YOU_MUST_SELECT_A_COMPONENT') ?></span><br />
				<?php if ($this->form): ?>
					<?php foreach ($this->form as $field): ?>
					<div class="control-group">
						<div class="control-label"><?= $field->label ?></div>
						<div class="controls"><?= $field->input ?></div>
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
				</div>
				<br />
				<div class="clearfix"></div>
				<button class="btn btn-small btn-success" onclick="Joomla.submitbutton('compiler.compiler')"><span class="icon-cog icon-white"></span>
					<?= JText::_('COM_COMPONENTBUILDER_COMPILE_COMPONENT') ?>
				</button>
				<input type="hidden" name="install_item_id" value="0"> 
				<input type="hidden" name="version" value="3" />
			</div>
		</div>
		<div class="span7">
			<div id="component-details"><?= $selectNotice ?></div>
			<?= JLayoutHelper::render('jcbnoticeboardtabs', 'noticeboard') ?>
		</div>
	</div>
	<div id="clear" style="display:none;">
		<h1><?= JText::_('COM_COMPONENTBUILDER_PLEASE_WAIT_CLEARING_THE_TMP_FOLDER') ?> <span class="loading-dots">.</span></h1>
		<div class="clearfix"></div>
	</div>
	<div id="compiler" style="display:none;">
		<div id="compiler-spinner" class="span4" style="display:none;">
			<h3><?= JText::sprintf('COM_COMPONENTBUILDER_S_PLEASE_WAIT', $this->user->name) ?></h3>
			<div style="font-size: smaller;"><?= JText::_('COM_COMPONENTBUILDER_THIS_MAY_TAKE_A_WHILE_DEPENDING_ON_THE_SIZE_OF_YOUR_PROJECT') ?></div>
			<h4><b><span class="component-name"><?= JText::_('COM_COMPONENTBUILDER_THE_COMPONENT') ?></span></b> <?= JText::_('COM_COMPONENTBUILDER_IS_BEING_COMPILED') ?><span class="loading-dots">.</span></h4>
			<div style="text-align: center;"><?= ComponentbuilderHelper::getDynamicContent('builder-gif', '480-540') ?></div>
			<div class="clearfix"></div>
		</div>
		<div id="compiler-notice" class="span7" style="display:none;">
			<?= JLayoutHelper::render('jcbnoticeboardvdm', null) ?>
			<div class="jcb-sponsor-banner"><?= ComponentbuilderHelper::getDynamicContent('banner', '728-90') ?></div>
		</div>
	</div>
</div>
<script type="text/javascript">
// token 
var token = '<?= JSession::getFormToken() ?>';
var all_is_good = '<?= JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_THERE_IS_NO_NOTICE_AT_THIS_TIME') ?>';
jQuery('#compilerForm').on('change', '#component',function (e)
{
	var component = jQuery('#component').val();
	if(component == "") {
		jQuery('#component-details').html("<?= $selectNotice ?>");
		jQuery("#noticeboard").show();
		jQuery('.notice').show();
	} else {
		getComponentDetails(component);
		jQuery("#noticeboard").hide();
		jQuery('.notice').hide();
	}
});

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
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
