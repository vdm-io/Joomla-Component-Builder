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

	@version		2.0.8
	@build			30th January, 2016
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

// #jform_gettype listeners for gettype_TTozUNE function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_TTozUNE = jQuery("#jform_gettype").val();
	TTozUNE(gettype_TTozUNE);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_TTozUNE = jQuery("#jform_gettype").val();
	TTozUNE(gettype_TTozUNE);

});

// #jform_main_source listeners for main_source_OabpNGm function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_OabpNGm = jQuery("#jform_main_source").val();
	OabpNGm(main_source_OabpNGm);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_OabpNGm = jQuery("#jform_main_source").val();
	OabpNGm(main_source_OabpNGm);

});

// #jform_main_source listeners for main_source_aZEjPke function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_aZEjPke = jQuery("#jform_main_source").val();
	aZEjPke(main_source_aZEjPke);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_aZEjPke = jQuery("#jform_main_source").val();
	aZEjPke(main_source_aZEjPke);

});

// #jform_main_source listeners for main_source_liYHBQw function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_liYHBQw = jQuery("#jform_main_source").val();
	liYHBQw(main_source_liYHBQw);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_liYHBQw = jQuery("#jform_main_source").val();
	liYHBQw(main_source_liYHBQw);

});

// #jform_main_source listeners for main_source_ihvkrmN function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_ihvkrmN = jQuery("#jform_main_source").val();
	ihvkrmN(main_source_ihvkrmN);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_ihvkrmN = jQuery("#jform_main_source").val();
	ihvkrmN(main_source_ihvkrmN);

});

// #jform_addcalculation listeners for addcalculation_qgcUmUf function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_qgcUmUf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	qgcUmUf(addcalculation_qgcUmUf);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_qgcUmUf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	qgcUmUf(addcalculation_qgcUmUf);

});

// #jform_addcalculation listeners for addcalculation_vEABeis function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vEABeis = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vEABeis = jQuery("#jform_gettype").val();
	vEABeis(addcalculation_vEABeis,gettype_vEABeis);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vEABeis = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vEABeis = jQuery("#jform_gettype").val();
	vEABeis(addcalculation_vEABeis,gettype_vEABeis);

});

// #jform_gettype listeners for gettype_vEABeis function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vEABeis = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vEABeis = jQuery("#jform_gettype").val();
	vEABeis(addcalculation_vEABeis,gettype_vEABeis);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vEABeis = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vEABeis = jQuery("#jform_gettype").val();
	vEABeis(addcalculation_vEABeis,gettype_vEABeis);

});

// #jform_addcalculation listeners for addcalculation_vzEXGQt function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vzEXGQt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vzEXGQt = jQuery("#jform_gettype").val();
	vzEXGQt(addcalculation_vzEXGQt,gettype_vzEXGQt);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vzEXGQt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vzEXGQt = jQuery("#jform_gettype").val();
	vzEXGQt(addcalculation_vzEXGQt,gettype_vzEXGQt);

});

// #jform_gettype listeners for gettype_vzEXGQt function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vzEXGQt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vzEXGQt = jQuery("#jform_gettype").val();
	vzEXGQt(addcalculation_vzEXGQt,gettype_vzEXGQt);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vzEXGQt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vzEXGQt = jQuery("#jform_gettype").val();
	vzEXGQt(addcalculation_vzEXGQt,gettype_vzEXGQt);

});

// #jform_main_source listeners for main_source_LKzirhH function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_LKzirhH = jQuery("#jform_main_source").val();
	LKzirhH(main_source_LKzirhH);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_LKzirhH = jQuery("#jform_main_source").val();
	LKzirhH(main_source_LKzirhH);

});

// #jform_main_source listeners for main_source_TOFQooo function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_TOFQooo = jQuery("#jform_main_source").val();
	TOFQooo(main_source_TOFQooo);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_TOFQooo = jQuery("#jform_main_source").val();
	TOFQooo(main_source_TOFQooo);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_fyWzBNh function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_fyWzBNh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_fyWzBNh = jQuery("#jform_gettype").val();
	fyWzBNh(add_php_before_getitem_fyWzBNh,gettype_fyWzBNh);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_fyWzBNh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_fyWzBNh = jQuery("#jform_gettype").val();
	fyWzBNh(add_php_before_getitem_fyWzBNh,gettype_fyWzBNh);

});

// #jform_gettype listeners for gettype_fyWzBNh function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_fyWzBNh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_fyWzBNh = jQuery("#jform_gettype").val();
	fyWzBNh(add_php_before_getitem_fyWzBNh,gettype_fyWzBNh);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_fyWzBNh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_fyWzBNh = jQuery("#jform_gettype").val();
	fyWzBNh(add_php_before_getitem_fyWzBNh,gettype_fyWzBNh);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_McnRHXs function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_McnRHXs = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_McnRHXs = jQuery("#jform_gettype").val();
	McnRHXs(add_php_after_getitem_McnRHXs,gettype_McnRHXs);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_McnRHXs = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_McnRHXs = jQuery("#jform_gettype").val();
	McnRHXs(add_php_after_getitem_McnRHXs,gettype_McnRHXs);

});

// #jform_gettype listeners for gettype_McnRHXs function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_McnRHXs = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_McnRHXs = jQuery("#jform_gettype").val();
	McnRHXs(add_php_after_getitem_McnRHXs,gettype_McnRHXs);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_McnRHXs = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_McnRHXs = jQuery("#jform_gettype").val();
	McnRHXs(add_php_after_getitem_McnRHXs,gettype_McnRHXs);

});

// #jform_gettype listeners for gettype_lajvdOy function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_lajvdOy = jQuery("#jform_gettype").val();
	lajvdOy(gettype_lajvdOy);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_lajvdOy = jQuery("#jform_gettype").val();
	lajvdOy(gettype_lajvdOy);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_DxYMqLK function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_DxYMqLK = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_DxYMqLK = jQuery("#jform_gettype").val();
	DxYMqLK(add_php_getlistquery_DxYMqLK,gettype_DxYMqLK);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_DxYMqLK = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_DxYMqLK = jQuery("#jform_gettype").val();
	DxYMqLK(add_php_getlistquery_DxYMqLK,gettype_DxYMqLK);

});

// #jform_gettype listeners for gettype_DxYMqLK function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_DxYMqLK = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_DxYMqLK = jQuery("#jform_gettype").val();
	DxYMqLK(add_php_getlistquery_DxYMqLK,gettype_DxYMqLK);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_DxYMqLK = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_DxYMqLK = jQuery("#jform_gettype").val();
	DxYMqLK(add_php_getlistquery_DxYMqLK,gettype_DxYMqLK);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_qXDrqWY function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_qXDrqWY = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qXDrqWY = jQuery("#jform_gettype").val();
	qXDrqWY(add_php_before_getitems_qXDrqWY,gettype_qXDrqWY);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_qXDrqWY = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qXDrqWY = jQuery("#jform_gettype").val();
	qXDrqWY(add_php_before_getitems_qXDrqWY,gettype_qXDrqWY);

});

// #jform_gettype listeners for gettype_qXDrqWY function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_qXDrqWY = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qXDrqWY = jQuery("#jform_gettype").val();
	qXDrqWY(add_php_before_getitems_qXDrqWY,gettype_qXDrqWY);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_qXDrqWY = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qXDrqWY = jQuery("#jform_gettype").val();
	qXDrqWY(add_php_before_getitems_qXDrqWY,gettype_qXDrqWY);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_oEefcMm function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_oEefcMm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_oEefcMm = jQuery("#jform_gettype").val();
	oEefcMm(add_php_after_getitems_oEefcMm,gettype_oEefcMm);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_oEefcMm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_oEefcMm = jQuery("#jform_gettype").val();
	oEefcMm(add_php_after_getitems_oEefcMm,gettype_oEefcMm);

});

// #jform_gettype listeners for gettype_oEefcMm function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_oEefcMm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_oEefcMm = jQuery("#jform_gettype").val();
	oEefcMm(add_php_after_getitems_oEefcMm,gettype_oEefcMm);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_oEefcMm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_oEefcMm = jQuery("#jform_gettype").val();
	oEefcMm(add_php_after_getitems_oEefcMm,gettype_oEefcMm);

});

// #jform_gettype listeners for gettype_pQuokmM function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_pQuokmM = jQuery("#jform_gettype").val();
	pQuokmM(gettype_pQuokmM);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_pQuokmM = jQuery("#jform_gettype").val();
	pQuokmM(gettype_pQuokmM);

});

// #jform_gettype listeners for gettype_DexlzKN function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_DexlzKN = jQuery("#jform_gettype").val();
	DexlzKN(gettype_DexlzKN);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_DexlzKN = jQuery("#jform_gettype").val();
	DexlzKN(gettype_DexlzKN);

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
