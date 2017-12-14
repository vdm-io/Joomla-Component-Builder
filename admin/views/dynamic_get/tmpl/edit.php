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
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.main_left', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.main_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'tweak', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_TWEAK', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.tweak_fullwidth', $this); ?>
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

// #jform_gettype listeners for gettype_vvvvvyw function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(gettype_vvvvvyw);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(gettype_vvvvvyw);

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

// #jform_main_source listeners for main_source_vvvvvyz function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyz = jQuery("#jform_main_source").val();
	vvvvvyz(main_source_vvvvvyz);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyz = jQuery("#jform_main_source").val();
	vvvvvyz(main_source_vvvvvyz);

});

// #jform_main_source listeners for main_source_vvvvvza function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvza = jQuery("#jform_main_source").val();
	vvvvvza(main_source_vvvvvza);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvza = jQuery("#jform_main_source").val();
	vvvvvza(main_source_vvvvvza);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzb function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzb(addcalculation_vvvvvzb);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzb(addcalculation_vvvvvzb);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzc function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(addcalculation_vvvvvzc,gettype_vvvvvzc);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(addcalculation_vvvvvzc,gettype_vvvvvzc);

});

// #jform_gettype listeners for gettype_vvvvvzc function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvzc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(addcalculation_vvvvvzc,gettype_vvvvvzc);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(addcalculation_vvvvvzc,gettype_vvvvvzc);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzd function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(addcalculation_vvvvvzd,gettype_vvvvvzd);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(addcalculation_vvvvvzd,gettype_vvvvvzd);

});

// #jform_gettype listeners for gettype_vvvvvzd function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(addcalculation_vvvvvzd,gettype_vvvvvzd);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(addcalculation_vvvvvzd,gettype_vvvvvzd);

});

// #jform_main_source listeners for main_source_vvvvvzg function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzg = jQuery("#jform_main_source").val();
	vvvvvzg(main_source_vvvvvzg);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzg = jQuery("#jform_main_source").val();
	vvvvvzg(main_source_vvvvvzg);

});

// #jform_main_source listeners for main_source_vvvvvzh function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzh = jQuery("#jform_main_source").val();
	vvvvvzh(main_source_vvvvvzh);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzh = jQuery("#jform_main_source").val();
	vvvvvzh(main_source_vvvvvzh);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvvzi function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzi = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_before_getitem_vvvvvzi,gettype_vvvvvzi);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzi = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_before_getitem_vvvvvzi,gettype_vvvvvzi);

});

// #jform_gettype listeners for gettype_vvvvvzi function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzi = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_before_getitem_vvvvvzi,gettype_vvvvvzi);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzi = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_before_getitem_vvvvvzi,gettype_vvvvvzi);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvvzj function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzj = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_after_getitem_vvvvvzj,gettype_vvvvvzj);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzj = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_after_getitem_vvvvvzj,gettype_vvvvvzj);

});

// #jform_gettype listeners for gettype_vvvvvzj function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzj = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_after_getitem_vvvvvzj,gettype_vvvvvzj);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzj = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_after_getitem_vvvvvzj,gettype_vvvvvzj);

});

// #jform_gettype listeners for gettype_vvvvvzl function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvvzm function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzm = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_getlistquery_vvvvvzm,gettype_vvvvvzm);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzm = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_getlistquery_vvvvvzm,gettype_vvvvvzm);

});

// #jform_gettype listeners for gettype_vvvvvzm function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzm = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_getlistquery_vvvvvzm,gettype_vvvvvzm);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzm = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_getlistquery_vvvvvzm,gettype_vvvvvzm);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvvzn function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzn = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_before_getitems_vvvvvzn,gettype_vvvvvzn);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzn = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_before_getitems_vvvvvzn,gettype_vvvvvzn);

});

// #jform_gettype listeners for gettype_vvvvvzn function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzn = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_before_getitems_vvvvvzn,gettype_vvvvvzn);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzn = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_before_getitems_vvvvvzn,gettype_vvvvvzn);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvvzo function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzo = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_after_getitems_vvvvvzo,gettype_vvvvvzo);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzo = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_after_getitems_vvvvvzo,gettype_vvvvvzo);

});

// #jform_gettype listeners for gettype_vvvvvzo function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzo = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_after_getitems_vvvvvzo,gettype_vvvvvzo);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzo = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_after_getitems_vvvvvzo,gettype_vvvvvzo);

});

// #jform_gettype listeners for gettype_vvvvvzq function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(gettype_vvvvvzq);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(gettype_vvvvvzq);

});

// #jform_gettype listeners for gettype_vvvvvzr function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzr = jQuery("#jform_gettype").val();
	vvvvvzr(gettype_vvvvvzr);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzr = jQuery("#jform_gettype").val();
	vvvvvzr(gettype_vvvvvzr);

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
		updateSubItems(fieldName, fieldNr, '_', '_');
	});

});

<?php foreach($fieldNames as $fieldName => $funcName): ?>jQuery('#adminForm').on('change', '#jform_<?php echo $fieldName ?>_table_main',function (e) {
	// get options
	var value_<?php echo $fieldName ?> = jQuery("#jform_<?php echo $fieldName ?>_table_main option:selected").val();
	get<?php echo $funcName; ?>TableColumns(value_<?php echo $fieldName ?>,'a','<?php echo $fieldName ?>',3,true, '','');
});
<?php endforeach; ?>
</script>
