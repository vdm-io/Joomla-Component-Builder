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
$selectNotice = '<h3>' . JText::_('COM_COMPONENTBUILDER_HI') . ' ' . $this->user->name . '</h3>';
$selectNotice .= '<p>' . JText::_('COM_COMPONENTBUILDER_PLEASE_SELECT_A_COMPONENT_THAT_YOU_WOULD_LIKE_TO_COMPILE') . '</p>';

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>
<?php if ($this->canDo->get('compiler.access')): ?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task === 'compiler.back') {
			parent.history.back();
			return false;
		} else {
			var form = document.getElementById('adminForm');
			form.task.value = task;
			form.submit();
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=compiler'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
</form>
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
			if (task == 'compiler.compiler' || task == 'compiler.installCompiledModule' || task == 'compiler.installCompiledPlugin') {
				var form = document.getElementById('compilerForm');
			} else {
				var form = document.getElementById('adminForm');
			}
			// set the plugin id
			if (task == 'compiler.installCompiledModule' || task == 'compiler.installCompiledPlugin') {
				form.install_item_id.value = key;
			}
			// set the task value
			form.task.value = task;
			form.submit();
			// some ui movements
			if (task == 'compiler.compiler'){
				jQuery('#compiler').show();
			} else if (task == 'compiler.clearTmp'){
				jQuery('#loading').css('display', 'block');
				jQuery('#clear').show();
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
			<h3><?php echo JText::_('COM_COMPONENTBUILDER_READY_TO_COMPILE_A_COMPONENT'); ?></h3>
			<form action="index.php?option=com_componentbuilder&view=compiler" method="post" name="compilerForm" id="compilerForm" class="form-validate" enctype="multipart/form-data">
				<div>
				<span class="notice" style="display:none; color:red;"><?php echo JText::_('COM_COMPONENTBUILDER_YOU_MUST_SELECT_A_COMPONENT'); ?></span><br />
				<?php if ($this->form): ?>
					<?php foreach ($this->form as $field): ?>
					<div class="control-group">
						<div class="control-label"><?php echo $field->label;?></div>
						<div class="controls"><?php echo $field->input;?></div>
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
				</div>
				<br />
				<div class="clearfix"></div>
				<button class="btn btn-small btn-success" onclick="Joomla.submitbutton('compiler.compiler')"><span class="icon-cog icon-white"></span>
					<?php echo JText::_('COM_COMPONENTBUILDER_COMPILE_COMPONENT'); ?>
				</button>
				<input type="hidden" name="install_item_id" value="0"> 
				<input type="hidden" name="version" value="3" />
				<input type="hidden" name="task" value="compiler.compiler" />
				<?php echo JHtml::_('form.token'); ?>
			</form>
		</div>
		<div class="span7">
			<div id="component-details"><?php echo $selectNotice; ?></div>
			<?php echo JLayoutHelper::render('jcbnoticeboardtabs', null); ?>
		</div>
	</div>
	<div id="clear" style="display:none;">
		<h1><?php echo JText::_('COM_COMPONENTBUILDER_PLEASE_WAIT_CLEARING_THE_TMP_FOLDER'); ?> <span class="loading-dots">.</span></h1>
		<div class="clearfix"></div>
	</div>
	<div id="compiler" style="display:none;">
		<h1><?php echo JText::sprintf('COM_COMPONENTBUILDER_S_PLEASE_WAIT_THE_COMPONENT_IS_BEING_COMPILED', $this->user->name); ?><span class="loading-dots">.</span></h1>
		<?php echo ComponentbuilderHelper::getDynamicContent('builder-gif', '707-400'); ?>
		<div class="clearfix"></div>
	</div>
</div>
<script type="text/javascript">
// token 
var token = '<?php echo JSession::getFormToken(); ?>';
var all_is_good = '<?php echo JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_THERE_IS_NO_NOTICE_AT_THIS_TIME'); ?>';
jQuery('#compilerForm').on('change', '#component',function (e)
{
	var component = jQuery('#component').val();
	if(component == "") {
		jQuery('#component-details').html("<?php echo $selectNotice; ?>");
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
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
