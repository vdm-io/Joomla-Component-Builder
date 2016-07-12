<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.1.16
	@build			12th July, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		default.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
JHtml::_('jquery.framework');
?>

<script type="text/javascript">
Joomla.submitbutton = function(task)
{
	if (task == ''){
		return false;
	} else {
		var component = jQuery('#component').val();
		var isValid = true;
		
		if(component == "" && task == 'compiler.compiler'){
			isValid = false;
		}
		if (isValid){
			jQuery('#form').hide();
			Joomla.submitform(task);
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
	var outerDiv = $('body');

	$('<div id="loading"></div>')
		.css("background", "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat")
		.css("top", outerDiv.position().top - $(window).scrollTop())
		.css("left", outerDiv.position().left - $(window).scrollLeft())
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
<?php else: ?>
<div id="j-main-container">
<?php endif; ?>
	<div id="form">
        <h1>Ready to compile your component</h1>
        <form action="index.php?option=com_componentbuilder&view=compiler" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
            <div>
            	<span class="notice" style="display:none; color:red;">You must select a component!</span><br />
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
                Compile Component
            </button>
            <input type="hidden" name="version" value="3" />
            <input type="hidden" name="task" value="compiler.compiler" />
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
    <div id="clear" style="display:none;">
        <h1>Please wait! Clearing the tmp folder <span class="loading-dots">.</span></h1>
        <div class="clearfix"></div>
    </div>
    <div id="compiler" style="display:none;">
        <h1>Please wait! Compiling the component <span class="loading-dots">.</span></h1>
        <img src="components/com_componentbuilder/assets/images/ajax-loader.gif" />
        <div class="clearfix"></div>
    </div>
</div>
<script>
jQuery('#adminForm').on('change', '#component',function (e)
{
	var component = jQuery('#component').val();
	if(component == ""){
		jQuery('.notice').show();
	}
	else
	{
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
</script>
