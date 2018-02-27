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

// #jform_gettype listeners for gettype_vvvvvyy function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(gettype_vvvvvyy);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(gettype_vvvvvyy);

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

// #jform_main_source listeners for main_source_vvvvvzb function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzb = jQuery("#jform_main_source").val();
	vvvvvzb(main_source_vvvvvzb);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzb = jQuery("#jform_main_source").val();
	vvvvvzb(main_source_vvvvvzb);

});

// #jform_main_source listeners for main_source_vvvvvzc function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzc = jQuery("#jform_main_source").val();
	vvvvvzc(main_source_vvvvvzc);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzc = jQuery("#jform_main_source").val();
	vvvvvzc(main_source_vvvvvzc);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzd function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzd(addcalculation_vvvvvzd);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzd(addcalculation_vvvvvzd);

});

// #jform_addcalculation listeners for addcalculation_vvvvvze function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvze = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(addcalculation_vvvvvze,gettype_vvvvvze);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvze = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(addcalculation_vvvvvze,gettype_vvvvvze);

});

// #jform_gettype listeners for gettype_vvvvvze function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvze = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(addcalculation_vvvvvze,gettype_vvvvvze);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvze = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(addcalculation_vvvvvze,gettype_vvvvvze);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzf function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(addcalculation_vvvvvzf,gettype_vvvvvzf);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(addcalculation_vvvvvzf,gettype_vvvvvzf);

});

// #jform_gettype listeners for gettype_vvvvvzf function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvzf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(addcalculation_vvvvvzf,gettype_vvvvvzf);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(addcalculation_vvvvvzf,gettype_vvvvvzf);

});

// #jform_main_source listeners for main_source_vvvvvzi function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzi = jQuery("#jform_main_source").val();
	vvvvvzi(main_source_vvvvvzi);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzi = jQuery("#jform_main_source").val();
	vvvvvzi(main_source_vvvvvzi);

});

// #jform_main_source listeners for main_source_vvvvvzj function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzj = jQuery("#jform_main_source").val();
	vvvvvzj(main_source_vvvvvzj);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzj = jQuery("#jform_main_source").val();
	vvvvvzj(main_source_vvvvvzj);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvvzk function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzk = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_before_getitem_vvvvvzk,gettype_vvvvvzk);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzk = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_before_getitem_vvvvvzk,gettype_vvvvvzk);

});

// #jform_gettype listeners for gettype_vvvvvzk function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzk = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_before_getitem_vvvvvzk,gettype_vvvvvzk);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzk = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_before_getitem_vvvvvzk,gettype_vvvvvzk);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvvzl function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzl = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_after_getitem_vvvvvzl,gettype_vvvvvzl);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzl = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_after_getitem_vvvvvzl,gettype_vvvvvzl);

});

// #jform_gettype listeners for gettype_vvvvvzl function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzl = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_after_getitem_vvvvvzl,gettype_vvvvvzl);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzl = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_after_getitem_vvvvvzl,gettype_vvvvvzl);

});

// #jform_gettype listeners for gettype_vvvvvzn function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(gettype_vvvvvzn);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(gettype_vvvvvzn);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvvzo function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzo = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_getlistquery_vvvvvzo,gettype_vvvvvzo);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzo = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_getlistquery_vvvvvzo,gettype_vvvvvzo);

});

// #jform_gettype listeners for gettype_vvvvvzo function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzo = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_getlistquery_vvvvvzo,gettype_vvvvvzo);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzo = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_getlistquery_vvvvvzo,gettype_vvvvvzo);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvvzp function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzp = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(add_php_before_getitems_vvvvvzp,gettype_vvvvvzp);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzp = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(add_php_before_getitems_vvvvvzp,gettype_vvvvvzp);

});

// #jform_gettype listeners for gettype_vvvvvzp function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzp = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(add_php_before_getitems_vvvvvzp,gettype_vvvvvzp);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzp = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(add_php_before_getitems_vvvvvzp,gettype_vvvvvzp);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvvzq function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzq = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(add_php_after_getitems_vvvvvzq,gettype_vvvvvzq);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzq = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(add_php_after_getitems_vvvvvzq,gettype_vvvvvzq);

});

// #jform_gettype listeners for gettype_vvvvvzq function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzq = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(add_php_after_getitems_vvvvvzq,gettype_vvvvvzq);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzq = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(add_php_after_getitems_vvvvvzq,gettype_vvvvvzq);

});

// #jform_gettype listeners for gettype_vvvvvzs function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(gettype_vvvvvzs);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(gettype_vvvvvzs);

});

// #jform_gettype listeners for gettype_vvvvvzt function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(gettype_vvvvvzt);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(gettype_vvvvvzt);

});

// #jform_gettype listeners for gettype_vvvvvzu function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzu = jQuery("#jform_gettype").val();
	vvvvvzu(gettype_vvvvvzu);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzu = jQuery("#jform_gettype").val();
	vvvvvzu(gettype_vvvvvzu);

});

// #jform_gettype listeners for gettype_vvvvvzv function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzv = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzv(gettype_vvvvvzv,add_php_router_parse_vvvvvzv);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzv = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzv(gettype_vvvvvzv,add_php_router_parse_vvvvvzv);

});

// #jform_add_php_router_parse listeners for add_php_router_parse_vvvvvzv function
jQuery('#jform_add_php_router_parse').on('keyup',function()
{
	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzv = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzv(gettype_vvvvvzv,add_php_router_parse_vvvvvzv);

});
jQuery('#adminForm').on('change', '#jform_add_php_router_parse',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzv = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzv(gettype_vvvvvzv,add_php_router_parse_vvvvvzv);

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

// #jform_add_php_router_parse listeners
jQuery('#jform_add_php_router_parse').on('change',function() {
	var valueSwitch = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	getDynamicScripts(valueSwitch);
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
