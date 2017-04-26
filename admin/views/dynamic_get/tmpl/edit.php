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

	@version		@update number 81 of this MVC
	@build			15th January, 2017
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

	<?php echo JLayoutHelper::render('dynamic_get.gettable_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'dynamic_getTab', array('active' => 'gettable')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'gettable', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_GETTABLE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.gettable_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.gettable_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.gettable_fullwidth', $this); ?>
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
<?php echo JLayoutHelper::render('dynamic_get.gettable_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_gettype listeners for gettype_vvvvvys function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvys = jQuery("#jform_gettype").val();
	vvvvvys(gettype_vvvvvys);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvys = jQuery("#jform_gettype").val();
	vvvvvys(gettype_vvvvvys);

});

// #jform_main_source listeners for main_source_vvvvvyt function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyt = jQuery("#jform_main_source").val();
	vvvvvyt(main_source_vvvvvyt);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyt = jQuery("#jform_main_source").val();
	vvvvvyt(main_source_vvvvvyt);

});

// #jform_main_source listeners for main_source_vvvvvyu function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyu = jQuery("#jform_main_source").val();
	vvvvvyu(main_source_vvvvvyu);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyu = jQuery("#jform_main_source").val();
	vvvvvyu(main_source_vvvvvyu);

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

// #jform_addcalculation listeners for addcalculation_vvvvvyx function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyx = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyx(addcalculation_vvvvvyx);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyx = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyx(addcalculation_vvvvvyx);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyy function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyy = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(addcalculation_vvvvvyy,gettype_vvvvvyy);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyy = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(addcalculation_vvvvvyy,gettype_vvvvvyy);

});

// #jform_gettype listeners for gettype_vvvvvyy function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvyy = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(addcalculation_vvvvvyy,gettype_vvvvvyy);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyy = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(addcalculation_vvvvvyy,gettype_vvvvvyy);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyz function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz);

});

// #jform_gettype listeners for gettype_vvvvvyz function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz);

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

// #jform_main_source listeners for main_source_vvvvvzd function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzd = jQuery("#jform_main_source").val();
	vvvvvzd(main_source_vvvvvzd);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzd = jQuery("#jform_main_source").val();
	vvvvvzd(main_source_vvvvvzd);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvvze function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvvze = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(add_php_before_getitem_vvvvvze,gettype_vvvvvze);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvze = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(add_php_before_getitem_vvvvvze,gettype_vvvvvze);

});

// #jform_gettype listeners for gettype_vvvvvze function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvvze = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(add_php_before_getitem_vvvvvze,gettype_vvvvvze);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvze = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(add_php_before_getitem_vvvvvze,gettype_vvvvvze);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvvzf function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzf = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(add_php_after_getitem_vvvvvzf,gettype_vvvvvzf);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzf = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(add_php_after_getitem_vvvvvzf,gettype_vvvvvzf);

});

// #jform_gettype listeners for gettype_vvvvvzf function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzf = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(add_php_after_getitem_vvvvvzf,gettype_vvvvvzf);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzf = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(add_php_after_getitem_vvvvvzf,gettype_vvvvvzf);

});

// #jform_gettype listeners for gettype_vvvvvzh function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(gettype_vvvvvzh);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(gettype_vvvvvzh);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvvzi function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzi = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_getlistquery_vvvvvzi,gettype_vvvvvzi);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzi = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_getlistquery_vvvvvzi,gettype_vvvvvzi);

});

// #jform_gettype listeners for gettype_vvvvvzi function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvvzi = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_getlistquery_vvvvvzi,gettype_vvvvvzi);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvzi = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_getlistquery_vvvvvzi,gettype_vvvvvzi);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvvzj function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzj = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_before_getitems_vvvvvzj,gettype_vvvvvzj);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzj = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_before_getitems_vvvvvzj,gettype_vvvvvzj);

});

// #jform_gettype listeners for gettype_vvvvvzj function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvvzj = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_before_getitems_vvvvvzj,gettype_vvvvvzj);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvzj = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_before_getitems_vvvvvzj,gettype_vvvvvzj);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvvzk function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzk = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_after_getitems_vvvvvzk,gettype_vvvvvzk);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzk = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_after_getitems_vvvvvzk,gettype_vvvvvzk);

});

// #jform_gettype listeners for gettype_vvvvvzk function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvvzk = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_after_getitems_vvvvvzk,gettype_vvvvvzk);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvzk = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_after_getitems_vvvvvzk,gettype_vvvvvzk);

});

// #jform_gettype listeners for gettype_vvvvvzm function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(gettype_vvvvvzm);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(gettype_vvvvvzm);

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


<?php $fieldNrs = range(1,50,1); ?>
<?php $fieldNames = array('db' => 'Db','view' => 'View'); ?>
<?php foreach($fieldNames as $fieldName => $funcName): ?>jQuery('#jform_join_<?php echo $fieldName ?>_table_modal').on('show.bs.modal', function (e) {
 	<?php foreach($fieldNrs as $fieldNr): ?>jQuery('#jform_join_<?php echo $fieldName ?>_table_modal').on('change', '#jform_join_<?php echo $fieldName ?>_table_fields_<?php echo $fieldName ?>_table-<?php echo $fieldNr ?>',function (e) {
		e.preventDefault();
		// get options
		var <?php echo $fieldName ?>_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_<?php echo $fieldName ?>_table-<?php echo $fieldNr ?> option:selected").val();
		var as_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_as-<?php echo $fieldNr ?> option:selected").val();
		var row_<?php echo $fieldName ?>_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_row_type-<?php echo $fieldNr ?> option:selected").val();
		get<?php echo $funcName ?>TableColumns(<?php echo $fieldName ?>_<?php echo $fieldNr ?>,as_<?php echo $fieldNr ?>,<?php echo $fieldNr ?>,row_<?php echo $fieldName ?>_<?php echo $fieldNr ?>,false);
	});
	<?php endforeach; ?>
	<?php foreach($fieldNrs as $fieldNr): ?>jQuery('#jform_join_<?php echo $fieldName ?>_table_modal').on('change', '#jform_join_<?php echo $fieldName ?>_table_fields_as-<?php echo $fieldNr ?>',function (e) {
		e.preventDefault();
		// get options
		var <?php echo $fieldName ?>_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_<?php echo $fieldName ?>_table-<?php echo $fieldNr ?> option:selected").val();
		var as_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_as-<?php echo $fieldNr ?> option:selected").val();
		var row_<?php echo $fieldName ?>_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_row_type-<?php echo $fieldNr ?> option:selected").val();
		get<?php echo $funcName ?>TableColumns(<?php echo $fieldName ?>_<?php echo $fieldNr ?>,as_<?php echo $fieldNr ?>,<?php echo $fieldNr ?>,row_<?php echo $fieldName ?>_<?php echo $fieldNr ?>,false);
	});
	<?php endforeach; ?>
	<?php foreach($fieldNrs as $fieldNr): ?>jQuery('#jform_join_<?php echo $fieldName ?>_table_modal').on('change', '#jform_join_<?php echo $fieldName ?>_table_fields_row_type-<?php echo $fieldNr ?>',function (e) {
		e.preventDefault();
		// get options
		var <?php echo $fieldName ?>_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_<?php echo $fieldName ?>_table-<?php echo $fieldNr ?> option:selected").val();
		var as_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_as-<?php echo $fieldNr ?> option:selected").val();
		var row_<?php echo $fieldName ?>_<?php echo $fieldNr ?> = jQuery("#jform_join_<?php echo $fieldName ?>_table_fields_row_type-<?php echo $fieldNr ?> option:selected").val();
		get<?php echo $funcName ?>TableColumns(<?php echo $fieldName ?>_<?php echo $fieldNr ?>,as_<?php echo $fieldNr ?>,<?php echo $fieldNr ?>,row_<?php echo $fieldName ?>_<?php echo $fieldNr ?>,false);
	});
	<?php endforeach; ?>
});
<?php endforeach; ?>

<?php foreach($fieldNames as $fieldName => $funcName): ?>jQuery('#gettable').on('change', '#jform_<?php echo $fieldName ?>_table_main',function (e) {
	// get options
	var value_<?php echo $fieldName ?> = jQuery("#jform_<?php echo $fieldName ?>_table_main option:selected").val();
	get<?php echo $funcName; ?>TableColumns(value_<?php echo $fieldName ?>,'a','<?php echo $fieldName ?>',3,true);
});
<?php endforeach; ?>
</script>
