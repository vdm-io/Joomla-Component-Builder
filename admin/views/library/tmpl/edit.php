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
$componentParams = $this->params; // will be removed just use $this->params instead
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
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

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

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'libraryTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

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

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('library.behaviour_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_how listeners for how_vvvvwch function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});

// #jform_target listeners for target_vvvvwch function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});

// #jform_how listeners for how_vvvvwcj function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});

// #jform_target listeners for target_vvvvwcj function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});

// #jform_how listeners for how_vvvvwcl function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});

// #jform_target listeners for target_vvvvwcl function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});

// #jform_how listeners for how_vvvvwcn function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});

// #jform_target listeners for target_vvvvwcn function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});

// #jform_how listeners for how_vvvvwcp function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});

// #jform_target listeners for target_vvvvwcp function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});

// #jform_target listeners for target_vvvvwcq function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});

// #jform_how listeners for how_vvvvwcq function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});

// #jform_how listeners for how_vvvvwcr function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});

// #jform_target listeners for target_vvvvwcr function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});

// #jform_target listeners for target_vvvvwcs function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});

// #jform_how listeners for how_vvvvwcs function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});

// #jform_how listeners for how_vvvvwct function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});

// #jform_target listeners for target_vvvvwct function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});

// #jform_target listeners for target_vvvvwcu function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});

// #jform_how listeners for how_vvvvwcu function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});

// #jform_target listeners for target_vvvvwcv function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});

// #jform_type listeners for type_vvvvwcv function
jQuery('#jform_type').on('keyup',function()
{
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});

// #jform_target listeners for target_vvvvwcx function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcx = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcx(target_vvvvwcx);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcx = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcx(target_vvvvwcx);

});

// #jform_target listeners for target_vvvvwcy function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcy = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcy(target_vvvvwcy);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcy = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcy(target_vvvvwcy);

});



<?php $numberAddconditions = range(0, count( (array) $this->item->addconditions) + 3, 1);?>

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
