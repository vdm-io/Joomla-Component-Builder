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

	@version		2.1.19
	@build			7th September, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		edit.php
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

	<?php echo JLayoutHelper::render('dynamic_get.gettable_above', $this); ?><div class="form-horizontal">

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

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('dynamic_get.gettable_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_gettype listeners for gettype_vvvvvyd function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyd = jQuery("#jform_gettype").val();
	vvvvvyd(gettype_vvvvvyd);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyd = jQuery("#jform_gettype").val();
	vvvvvyd(gettype_vvvvvyd);

});

// #jform_main_source listeners for main_source_vvvvvye function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvye = jQuery("#jform_main_source").val();
	vvvvvye(main_source_vvvvvye);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvye = jQuery("#jform_main_source").val();
	vvvvvye(main_source_vvvvvye);

});

// #jform_main_source listeners for main_source_vvvvvyf function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyf = jQuery("#jform_main_source").val();
	vvvvvyf(main_source_vvvvvyf);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyf = jQuery("#jform_main_source").val();
	vvvvvyf(main_source_vvvvvyf);

});

// #jform_main_source listeners for main_source_vvvvvyg function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyg = jQuery("#jform_main_source").val();
	vvvvvyg(main_source_vvvvvyg);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyg = jQuery("#jform_main_source").val();
	vvvvvyg(main_source_vvvvvyg);

});

// #jform_main_source listeners for main_source_vvvvvyh function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyh = jQuery("#jform_main_source").val();
	vvvvvyh(main_source_vvvvvyh);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyh = jQuery("#jform_main_source").val();
	vvvvvyh(main_source_vvvvvyh);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyi function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyi(addcalculation_vvvvvyi);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyi(addcalculation_vvvvvyi);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyj function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyj = jQuery("#jform_gettype").val();
	vvvvvyj(addcalculation_vvvvvyj,gettype_vvvvvyj);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyj = jQuery("#jform_gettype").val();
	vvvvvyj(addcalculation_vvvvvyj,gettype_vvvvvyj);

});

// #jform_gettype listeners for gettype_vvvvvyj function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvyj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyj = jQuery("#jform_gettype").val();
	vvvvvyj(addcalculation_vvvvvyj,gettype_vvvvvyj);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyj = jQuery("#jform_gettype").val();
	vvvvvyj(addcalculation_vvvvvyj,gettype_vvvvvyj);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyk function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(addcalculation_vvvvvyk,gettype_vvvvvyk);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(addcalculation_vvvvvyk,gettype_vvvvvyk);

});

// #jform_gettype listeners for gettype_vvvvvyk function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvyk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(addcalculation_vvvvvyk,gettype_vvvvvyk);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(addcalculation_vvvvvyk,gettype_vvvvvyk);

});

// #jform_main_source listeners for main_source_vvvvvyn function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyn = jQuery("#jform_main_source").val();
	vvvvvyn(main_source_vvvvvyn);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyn = jQuery("#jform_main_source").val();
	vvvvvyn(main_source_vvvvvyn);

});

// #jform_main_source listeners for main_source_vvvvvyo function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvyo = jQuery("#jform_main_source").val();
	vvvvvyo(main_source_vvvvvyo);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvyo = jQuery("#jform_main_source").val();
	vvvvvyo(main_source_vvvvvyo);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvvyp function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvvyp = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(add_php_before_getitem_vvvvvyp,gettype_vvvvvyp);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvyp = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(add_php_before_getitem_vvvvvyp,gettype_vvvvvyp);

});

// #jform_gettype listeners for gettype_vvvvvyp function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvvyp = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(add_php_before_getitem_vvvvvyp,gettype_vvvvvyp);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvyp = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(add_php_before_getitem_vvvvvyp,gettype_vvvvvyp);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvvyq function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvvyq = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(add_php_after_getitem_vvvvvyq,gettype_vvvvvyq);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvyq = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(add_php_after_getitem_vvvvvyq,gettype_vvvvvyq);

});

// #jform_gettype listeners for gettype_vvvvvyq function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvvyq = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(add_php_after_getitem_vvvvvyq,gettype_vvvvvyq);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvyq = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(add_php_after_getitem_vvvvvyq,gettype_vvvvvyq);

});

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

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvvyt function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvvyt = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(add_php_getlistquery_vvvvvyt,gettype_vvvvvyt);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvyt = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(add_php_getlistquery_vvvvvyt,gettype_vvvvvyt);

});

// #jform_gettype listeners for gettype_vvvvvyt function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvvyt = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(add_php_getlistquery_vvvvvyt,gettype_vvvvvyt);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvyt = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(add_php_getlistquery_vvvvvyt,gettype_vvvvvyt);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvvyu function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvvyu = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(add_php_before_getitems_vvvvvyu,gettype_vvvvvyu);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvyu = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(add_php_before_getitems_vvvvvyu,gettype_vvvvvyu);

});

// #jform_gettype listeners for gettype_vvvvvyu function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvvyu = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(add_php_before_getitems_vvvvvyu,gettype_vvvvvyu);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvyu = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(add_php_before_getitems_vvvvvyu,gettype_vvvvvyu);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvvyv function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvvyv = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(add_php_after_getitems_vvvvvyv,gettype_vvvvvyv);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvyv = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(add_php_after_getitems_vvvvvyv,gettype_vvvvvyv);

});

// #jform_gettype listeners for gettype_vvvvvyv function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvvyv = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(add_php_after_getitems_vvvvvyv,gettype_vvvvvyv);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvyv = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(add_php_after_getitems_vvvvvyv,gettype_vvvvvyv);

});

// #jform_gettype listeners for gettype_vvvvvyx function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyx = jQuery("#jform_gettype").val();
	vvvvvyx(gettype_vvvvvyx);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyx = jQuery("#jform_gettype").val();
	vvvvvyx(gettype_vvvvvyx);

});

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
