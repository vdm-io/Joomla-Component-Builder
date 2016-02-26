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

	@version		2.1.0
	@build			26th February, 2016
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

<script type="text/javascript">

// #jform_gettype listeners for gettype_vvvvvxv function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvxv = jQuery("#jform_gettype").val();
	vvvvvxv(gettype_vvvvvxv);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvxv = jQuery("#jform_gettype").val();
	vvvvvxv(gettype_vvvvvxv);

});

// #jform_main_source listeners for main_source_vvvvvxw function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvxw = jQuery("#jform_main_source").val();
	vvvvvxw(main_source_vvvvvxw);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvxw = jQuery("#jform_main_source").val();
	vvvvvxw(main_source_vvvvvxw);

});

// #jform_main_source listeners for main_source_vvvvvxx function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvxx = jQuery("#jform_main_source").val();
	vvvvvxx(main_source_vvvvvxx);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvxx = jQuery("#jform_main_source").val();
	vvvvvxx(main_source_vvvvvxx);

});

// #jform_main_source listeners for main_source_vvvvvxy function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvxy = jQuery("#jform_main_source").val();
	vvvvvxy(main_source_vvvvvxy);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvxy = jQuery("#jform_main_source").val();
	vvvvvxy(main_source_vvvvvxy);

});

// #jform_main_source listeners for main_source_vvvvvxz function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvxz = jQuery("#jform_main_source").val();
	vvvvvxz(main_source_vvvvvxz);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvxz = jQuery("#jform_main_source").val();
	vvvvvxz(main_source_vvvvvxz);

});

// #jform_addcalculation listeners for addcalculation_vvvvvya function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvya = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvya(addcalculation_vvvvvya);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvya = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvya(addcalculation_vvvvvya);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyb function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyb = jQuery("#jform_gettype").val();
	vvvvvyb(addcalculation_vvvvvyb,gettype_vvvvvyb);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyb = jQuery("#jform_gettype").val();
	vvvvvyb(addcalculation_vvvvvyb,gettype_vvvvvyb);

});

// #jform_gettype listeners for gettype_vvvvvyb function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvyb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyb = jQuery("#jform_gettype").val();
	vvvvvyb(addcalculation_vvvvvyb,gettype_vvvvvyb);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyb = jQuery("#jform_gettype").val();
	vvvvvyb(addcalculation_vvvvvyb,gettype_vvvvvyb);

});

// #jform_addcalculation listeners for addcalculation_vvvvvyc function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvyc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyc = jQuery("#jform_gettype").val();
	vvvvvyc(addcalculation_vvvvvyc,gettype_vvvvvyc);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyc = jQuery("#jform_gettype").val();
	vvvvvyc(addcalculation_vvvvvyc,gettype_vvvvvyc);

});

// #jform_gettype listeners for gettype_vvvvvyc function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvyc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyc = jQuery("#jform_gettype").val();
	vvvvvyc(addcalculation_vvvvvyc,gettype_vvvvvyc);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvyc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyc = jQuery("#jform_gettype").val();
	vvvvvyc(addcalculation_vvvvvyc,gettype_vvvvvyc);

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

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvvyh function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvvyh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyh = jQuery("#jform_gettype").val();
	vvvvvyh(add_php_before_getitem_vvvvvyh,gettype_vvvvvyh);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvyh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyh = jQuery("#jform_gettype").val();
	vvvvvyh(add_php_before_getitem_vvvvvyh,gettype_vvvvvyh);

});

// #jform_gettype listeners for gettype_vvvvvyh function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvvyh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyh = jQuery("#jform_gettype").val();
	vvvvvyh(add_php_before_getitem_vvvvvyh,gettype_vvvvvyh);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvyh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyh = jQuery("#jform_gettype").val();
	vvvvvyh(add_php_before_getitem_vvvvvyh,gettype_vvvvvyh);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvvyi function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvvyi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyi = jQuery("#jform_gettype").val();
	vvvvvyi(add_php_after_getitem_vvvvvyi,gettype_vvvvvyi);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvyi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyi = jQuery("#jform_gettype").val();
	vvvvvyi(add_php_after_getitem_vvvvvyi,gettype_vvvvvyi);

});

// #jform_gettype listeners for gettype_vvvvvyi function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvvyi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyi = jQuery("#jform_gettype").val();
	vvvvvyi(add_php_after_getitem_vvvvvyi,gettype_vvvvvyi);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvyi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyi = jQuery("#jform_gettype").val();
	vvvvvyi(add_php_after_getitem_vvvvvyi,gettype_vvvvvyi);

});

// #jform_gettype listeners for gettype_vvvvvyk function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(gettype_vvvvvyk);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(gettype_vvvvvyk);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvvyl function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvvyl = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyl = jQuery("#jform_gettype").val();
	vvvvvyl(add_php_getlistquery_vvvvvyl,gettype_vvvvvyl);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvyl = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyl = jQuery("#jform_gettype").val();
	vvvvvyl(add_php_getlistquery_vvvvvyl,gettype_vvvvvyl);

});

// #jform_gettype listeners for gettype_vvvvvyl function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvvyl = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyl = jQuery("#jform_gettype").val();
	vvvvvyl(add_php_getlistquery_vvvvvyl,gettype_vvvvvyl);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvvyl = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyl = jQuery("#jform_gettype").val();
	vvvvvyl(add_php_getlistquery_vvvvvyl,gettype_vvvvvyl);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvvym function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvvym = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvym = jQuery("#jform_gettype").val();
	vvvvvym(add_php_before_getitems_vvvvvym,gettype_vvvvvym);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvym = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvym = jQuery("#jform_gettype").val();
	vvvvvym(add_php_before_getitems_vvvvvym,gettype_vvvvvym);

});

// #jform_gettype listeners for gettype_vvvvvym function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvvym = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvym = jQuery("#jform_gettype").val();
	vvvvvym(add_php_before_getitems_vvvvvym,gettype_vvvvvym);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvvym = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvym = jQuery("#jform_gettype").val();
	vvvvvym(add_php_before_getitems_vvvvvym,gettype_vvvvvym);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvvyn function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvvyn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_after_getitems_vvvvvyn,gettype_vvvvvyn);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvyn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_after_getitems_vvvvvyn,gettype_vvvvvyn);

});

// #jform_gettype listeners for gettype_vvvvvyn function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvvyn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_after_getitems_vvvvvyn,gettype_vvvvvyn);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvvyn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_after_getitems_vvvvvyn,gettype_vvvvvyn);

});

// #jform_gettype listeners for gettype_vvvvvyp function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(gettype_vvvvvyp);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(gettype_vvvvvyp);

});

// #jform_gettype listeners for gettype_vvvvvyq function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(gettype_vvvvvyq);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(gettype_vvvvvyq);

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
