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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		default.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
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
<div id="snippets-github">
	<br /><br /><br />
	<center><h1><?php echo JText::_('COM_COMPONENTBUILDER_THE_SNIPPETS_IS_LOADING'); ?>.<span class="loading-dots">.</span></h1></center>
</div>
<div id="snippets-display" style="display: none;">
	<nav class="uk-navbar">
		<a href="https://github.com/vdm-io/Joomla-Component-Builder-Snippets" class="uk-navbar-brand" target="_blank"><i class="uk-icon-github"></i> gitHub</a>
		<ul class="uk-navbar-nav uk-hidden-small snippets-menu">
			<li data-uk-filter=""><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_ALL'); ?></a></li>
			<li data-uk-filter="equal"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_IN_SYNC'); ?></a></li>
			<li data-uk-filter="behind"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_OUT_OF_DATE'); ?></a></li>
			<li data-uk-filter="new"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_NEW'); ?></a></li>
			<li data-uk-filter="diverged"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_DIVERGED'); ?></a></li>
			<li data-uk-filter="ahead"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_AHEAD'); ?></a></li>
			<li data-uk-sort="snippet-name"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_NAME_ASC'); ?></a></li>
			<li data-uk-sort="snippet-name:desc"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_NAME_DESC'); ?></a></li>
			<li data-uk-sort="snippet-libraries"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_LIBRARY_ASC'); ?></a></li>
			<li data-uk-sort="snippet-libraries:desc"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_LIBRARY_DESC'); ?></a></li>
			<li data-uk-sort="snippet-types"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_TYPE_ASC'); ?></a></li>
			<li data-uk-sort="snippet-types:desc"><a href=""><?php echo JText::_('COM_COMPONENTBUILDER_TYPE_DESC'); ?></a></li>
		</ul>
	</nav>
	<br />
	<div id="snippets-grid" class="uk-grid uk-grid-preserve uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{gutter:10, controls: '.snippets-menu'}" data-uk-check-display></div>
</div>
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
</script>
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
