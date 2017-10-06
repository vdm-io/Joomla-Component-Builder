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

	@version		@update number 94 of this MVC
	@build			27th September, 2017
	@created		21st May, 2015
	@package		Component Builder
	@subpackage		edit.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
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

	<?php echo JLayoutHelper::render('dynamic_get.main_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'dynamic_getTab', array('active' => 'main')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'main', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_MAIN', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.main_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.main_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.main_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'joint', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_JOINT', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.joint_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'custom_script', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_CUSTOM_SCRIPT', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.custom_script_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'abacus', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_ABACUS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.abacus_left', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.abacus_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('dynamic_get.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('dynamic_get.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'publishing', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'permissions', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="dynamic_get.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('dynamic_get.main_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_gettype listeners for gettype_vvvvvyu function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(gettype_vvvvvyu);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(gettype_vvvvvyu);

});

// #jform_main_source listeners for main_source_vvvvvyv function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyv = jQuery("#jform_main_source").val();
	vvvvvyv(main_source_vvvvvyv);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyv = jQuery("#jform_main_source").val();
	vvvvvyv(main_source_vvvvvyv);

});

// #jform_main_source listeners for main_source_vvvvvyw function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyw = jQuery("#jform_main_source").val();
	vvvvvyw(main_source_vvvvvyw);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyw = jQuery("#jform_main_source").val();
	vvvvvyw(main_source_vvvvvyw);

});

// #jform_main_source listeners for main_source_vvvvvyx function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyx = jQuery("#jform_main_source").val();
	vvvvvyx(main_source_vvvvvyx);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyx = jQuery("#jform_main_source").val();
	vvvvvyx(main_source_vvvvvyx);

});

// #jform_main_source listeners for main_source_vvvvvyy function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyy = jQuery("#jform_main_source").val();
	vvvvvyy(main_source_vvvvvyy);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyy = jQuery("#jform_main_source").val();
	vvvvvyy(main_source_vvvvvyy);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyz function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyz(addcalculation_vvvvvyz);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyz(addcalculation_vvvvvyz);

});

// #jform_addcalculation listeners for addcalculation_vvvvvza function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvza = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvza = jQuery("#jform_gettype").val();
	vvvvvza(addcalculation_vvvvvza,gettype_vvvvvza);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvza = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvza = jQuery("#jform_gettype").val();
	vvvvvza(addcalculation_vvvvvza,gettype_vvvvvza);

});

// #jform_gettype listeners for gettype_vvvvvza function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvza = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvza = jQuery("#jform_gettype").val();
	vvvvvza(addcalculation_vvvvvza,gettype_vvvvvza);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvza = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvza = jQuery("#jform_gettype").val();
	vvvvvza(addcalculation_vvvvvza,gettype_vvvvvza);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzb function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(addcalculation_vvvvvzb,gettype_vvvvvzb);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(addcalculation_vvvvvzb,gettype_vvvvvzb);

});

// #jform_gettype listeners for gettype_vvvvvzb function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(addcalculation_vvvvvzb,gettype_vvvvvzb);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(addcalculation_vvvvvzb,gettype_vvvvvzb);

});

// #jform_main_source listeners for main_source_vvvvvze function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvze = jQuery("#jform_main_source").val();
	vvvvvze(main_source_vvvvvze);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvze = jQuery("#jform_main_source").val();
	vvvvvze(main_source_vvvvvze);

});

// #jform_main_source listeners for main_source_vvvvvzf function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzf = jQuery("#jform_main_source").val();
	vvvvvzf(main_source_vvvvvzf);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzf = jQuery("#jform_main_source").val();
	vvvvvzf(main_source_vvvvvzf);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvvzg function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzg = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(add_php_before_getitem_vvvvvzg,gettype_vvvvvzg);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzg = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(add_php_before_getitem_vvvvvzg,gettype_vvvvvzg);

});

// #jform_gettype listeners for gettype_vvvvvzg function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzg = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(add_php_before_getitem_vvvvvzg,gettype_vvvvvzg);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzg = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(add_php_before_getitem_vvvvvzg,gettype_vvvvvzg);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvvzh function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzh = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_after_getitem_vvvvvzh,gettype_vvvvvzh);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzh = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_after_getitem_vvvvvzh,gettype_vvvvvzh);

});

// #jform_gettype listeners for gettype_vvvvvzh function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzh = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_after_getitem_vvvvvzh,gettype_vvvvvzh);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzh = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_after_getitem_vvvvvzh,gettype_vvvvvzh);

});

// #jform_gettype listeners for gettype_vvvvvzj function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(gettype_vvvvvzj);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(gettype_vvvvvzj);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvvzk function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzk = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_getlistquery_vvvvvzk,gettype_vvvvvzk);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzk = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_getlistquery_vvvvvzk,gettype_vvvvvzk);

});

// #jform_gettype listeners for gettype_vvvvvzk function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzk = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_getlistquery_vvvvvzk,gettype_vvvvvzk);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzk = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_getlistquery_vvvvvzk,gettype_vvvvvzk);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvvzl function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzl = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_before_getitems_vvvvvzl,gettype_vvvvvzl);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzl = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_before_getitems_vvvvvzl,gettype_vvvvvzl);

});

// #jform_gettype listeners for gettype_vvvvvzl function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzl = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_before_getitems_vvvvvzl,gettype_vvvvvzl);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzl = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_before_getitems_vvvvvzl,gettype_vvvvvzl);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvvzm function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_after_getitems_vvvvvzm,gettype_vvvvvzm);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_after_getitems_vvvvvzm,gettype_vvvvvzm);

});

// #jform_gettype listeners for gettype_vvvvvzm function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_after_getitems_vvvvvzm,gettype_vvvvvzm);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_after_getitems_vvvvvzm,gettype_vvvvvzm);

});

// #jform_gettype listeners for gettype_vvvvvzo function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(gettype_vvvvvzo);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(gettype_vvvvvzo);

});

// #jform_gettype listeners for gettype_vvvvvzp function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(gettype_vvvvvzp);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(gettype_vvvvvzp);

});


<?php $fieldNrs = range(0,50,1); ?>
<?php $fieldNames = array('db' => 'Db','view' => 'View'); ?>
// for the vlaues already set
jQuery(document).ready(function(){
<?php foreach($fieldNames as $fieldName => $funcName): ?>
 	<?php foreach($fieldNrs as $fieldNr): ?>
		updateSubItems('<?php echo $fieldName ?>', <?php echo $fieldNr ?>, '_', '_');
	<?php endforeach; ?>
<?php endforeach; ?>
});
// for the values the will still be set
jQuery(document).ready(function(){
	jQuery(document).on('subform-row-add', function(event, row){
		var groupName = jQuery(row).data('group');
		var fieldName = groupName.replace('join_', '').replace('_table', '').replace(/([0-9])/g, '');
		var fieldNr = groupName.replace(/([A-z_])/g, '');
		updateSubItems(fieldName, fieldNr, '', '');
	});

});

<?php foreach($fieldNames as $fieldName => $funcName): ?>jQuery('#adminForm').on('change', '#jform_<?php echo $fieldName ?>_table_main',function (e) {
	// get options
	var value_<?php echo $fieldName ?> = jQuery("#jform_<?php echo $fieldName ?>_table_main option:selected").val();
	get<?php echo $funcName; ?>TableColumns(value_<?php echo $fieldName ?>,'a','<?php echo $fieldName ?>',3,true, '','');
});
<?php endforeach; ?>
</script>
