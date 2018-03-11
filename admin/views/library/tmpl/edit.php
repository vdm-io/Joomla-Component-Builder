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
	@subpackage		edit.php
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
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
$componentParams = JComponentHelper::getParams('com_componentbuilder');
?>
<script type="text/javascript">
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
	jQuery('#loading').show();
	// when page is ready remove and show
	jQuery(window).load(function() {
		jQuery('#componentbuilder_loader').fadeIn('fast');
		jQuery('#loading').hide();
	});
</script>
<div id="componentbuilder_loader" style="display: none;">
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&layout=edit&id='.(int) $this->item->id.$this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('library.behaviour_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'libraryTab', array('active' => 'behaviour')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'libraryTab', 'behaviour', JText::_('COM_COMPONENTBUILDER_LIBRARY_BEHAVIOUR', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('library.behaviour_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('library.behaviour_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('library.behaviour_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'libraryTab', 'files_folders_urls', JText::_('COM_COMPONENTBUILDER_LIBRARY_FILES_FOLDERS_URLS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('library.files_folders_urls_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'libraryTab', 'config', JText::_('COM_COMPONENTBUILDER_LIBRARY_CONFIG', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('library.config_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'libraryTab', 'linked', JText::_('COM_COMPONENTBUILDER_LIBRARY_LINKED', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('library.linked_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('library.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('library.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'libraryTab', 'publishing', JText::_('COM_COMPONENTBUILDER_LIBRARY_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('library.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('library.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'libraryTab', 'permissions', JText::_('COM_COMPONENTBUILDER_LIBRARY_PERMISSION', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<fieldset class="adminform">
					<div class="adminformlist">
					<?php foreach ($this->form->getFieldset('accesscontrol') as $field): ?>
						<div>
							<?php echo $field->label; echo $field->input;?>
						</div>
						<div class="clearfix"></div>
					<?php endforeach; ?>
					</div>
				</fieldset>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="library.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('library.behaviour_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_how listeners for how_vvvvwad function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwad = jQuery("#jform_how").val();
	vvvvwad(how_vvvvwad);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwad = jQuery("#jform_how").val();
	vvvvwad(how_vvvvwad);

});

// #jform_how listeners for how_vvvvwae function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwae = jQuery("#jform_how").val();
	vvvvwae(how_vvvvwae);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwae = jQuery("#jform_how").val();
	vvvvwae(how_vvvvwae);

});

// #jform_how listeners for how_vvvvwaf function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwaf = jQuery("#jform_how").val();
	vvvvwaf(how_vvvvwaf);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwaf = jQuery("#jform_how").val();
	vvvvwaf(how_vvvvwaf);

});

// #jform_how listeners for how_vvvvwag function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwag = jQuery("#jform_how").val();
	vvvvwag(how_vvvvwag);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwag = jQuery("#jform_how").val();
	vvvvwag(how_vvvvwag);

});

// #jform_how listeners for how_vvvvwah function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwah = jQuery("#jform_how").val();
	vvvvwah(how_vvvvwah);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwah = jQuery("#jform_how").val();
	vvvvwah(how_vvvvwah);

});

// #jform_how listeners for how_vvvvwai function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwai = jQuery("#jform_how").val();
	vvvvwai(how_vvvvwai);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwai = jQuery("#jform_how").val();
	vvvvwai(how_vvvvwai);

});

// #jform_how listeners for how_vvvvwaj function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwaj = jQuery("#jform_how").val();
	vvvvwaj(how_vvvvwaj);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwaj = jQuery("#jform_how").val();
	vvvvwaj(how_vvvvwaj);

});

// #jform_type listeners for type_vvvvwak function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvwak = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwak(type_vvvvwak);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvwak = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwak(type_vvvvwak);

});



<?php $numberAddconditions = range(0, count($this->item->addconditions) + 3, 1);?>

// for the values already set
jQuery(document).ready(function(){
<?php foreach($numberAddconditions as $fieldNr): ?>
	jQuery('#adminForm').on('change', '#jform_addconditions__addconditions<?php echo $fieldNr ?>__option_field',function (e) {
		e.preventDefault();
		getFieldSelectOptions(<?php echo $fieldNr ?>);
	});
<?php endforeach; ?>
	jQuery(document).on('subform-row-add', function(event, row){
		var groupName = jQuery(row).data('group');
		var fieldName = groupName.replace(/([0-9])/g, '');
		var fieldNr = groupName.replace(/([A-z_])/g, '');
		if ('addconditions' === fieldName) {
			jQuery('#adminForm').on('change', '#jform_addconditions__addconditions'+fieldNr+'__option_field',function (e) {
				e.preventDefault();
				getFieldSelectOptions(fieldNr);
			});
		}
	});
});

<?php
	$app = JFactory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isSite())
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
