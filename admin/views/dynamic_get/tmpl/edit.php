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

	@version		2.0.9
	@build			31st January, 2016
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

// #jform_gettype listeners for gettype_uhmpvFR function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_uhmpvFR = jQuery("#jform_gettype").val();
	uhmpvFR(gettype_uhmpvFR);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_uhmpvFR = jQuery("#jform_gettype").val();
	uhmpvFR(gettype_uhmpvFR);

});

// #jform_main_source listeners for main_source_viJPqmX function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_viJPqmX = jQuery("#jform_main_source").val();
	viJPqmX(main_source_viJPqmX);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_viJPqmX = jQuery("#jform_main_source").val();
	viJPqmX(main_source_viJPqmX);

});

// #jform_main_source listeners for main_source_FFEwuyq function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_FFEwuyq = jQuery("#jform_main_source").val();
	FFEwuyq(main_source_FFEwuyq);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_FFEwuyq = jQuery("#jform_main_source").val();
	FFEwuyq(main_source_FFEwuyq);

});

// #jform_main_source listeners for main_source_LvuYTPE function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_LvuYTPE = jQuery("#jform_main_source").val();
	LvuYTPE(main_source_LvuYTPE);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_LvuYTPE = jQuery("#jform_main_source").val();
	LvuYTPE(main_source_LvuYTPE);

});

// #jform_main_source listeners for main_source_ZMeCvuV function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_ZMeCvuV = jQuery("#jform_main_source").val();
	ZMeCvuV(main_source_ZMeCvuV);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_ZMeCvuV = jQuery("#jform_main_source").val();
	ZMeCvuV(main_source_ZMeCvuV);

});

// #jform_addcalculation listeners for addcalculation_qHjbkLG function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_qHjbkLG = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	qHjbkLG(addcalculation_qHjbkLG);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_qHjbkLG = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	qHjbkLG(addcalculation_qHjbkLG);

});

// #jform_addcalculation listeners for addcalculation_NGghFXW function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_NGghFXW = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_NGghFXW = jQuery("#jform_gettype").val();
	NGghFXW(addcalculation_NGghFXW,gettype_NGghFXW);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_NGghFXW = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_NGghFXW = jQuery("#jform_gettype").val();
	NGghFXW(addcalculation_NGghFXW,gettype_NGghFXW);

});

// #jform_gettype listeners for gettype_NGghFXW function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_NGghFXW = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_NGghFXW = jQuery("#jform_gettype").val();
	NGghFXW(addcalculation_NGghFXW,gettype_NGghFXW);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_NGghFXW = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_NGghFXW = jQuery("#jform_gettype").val();
	NGghFXW(addcalculation_NGghFXW,gettype_NGghFXW);

});

// #jform_addcalculation listeners for addcalculation_kJhdBSg function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_kJhdBSg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_kJhdBSg = jQuery("#jform_gettype").val();
	kJhdBSg(addcalculation_kJhdBSg,gettype_kJhdBSg);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_kJhdBSg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_kJhdBSg = jQuery("#jform_gettype").val();
	kJhdBSg(addcalculation_kJhdBSg,gettype_kJhdBSg);

});

// #jform_gettype listeners for gettype_kJhdBSg function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_kJhdBSg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_kJhdBSg = jQuery("#jform_gettype").val();
	kJhdBSg(addcalculation_kJhdBSg,gettype_kJhdBSg);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_kJhdBSg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_kJhdBSg = jQuery("#jform_gettype").val();
	kJhdBSg(addcalculation_kJhdBSg,gettype_kJhdBSg);

});

// #jform_main_source listeners for main_source_jGrXfve function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_jGrXfve = jQuery("#jform_main_source").val();
	jGrXfve(main_source_jGrXfve);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_jGrXfve = jQuery("#jform_main_source").val();
	jGrXfve(main_source_jGrXfve);

});

// #jform_main_source listeners for main_source_RchWLce function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_RchWLce = jQuery("#jform_main_source").val();
	RchWLce(main_source_RchWLce);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_RchWLce = jQuery("#jform_main_source").val();
	RchWLce(main_source_RchWLce);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_TyycokT function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_TyycokT = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_TyycokT = jQuery("#jform_gettype").val();
	TyycokT(add_php_before_getitem_TyycokT,gettype_TyycokT);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_TyycokT = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_TyycokT = jQuery("#jform_gettype").val();
	TyycokT(add_php_before_getitem_TyycokT,gettype_TyycokT);

});

// #jform_gettype listeners for gettype_TyycokT function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_TyycokT = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_TyycokT = jQuery("#jform_gettype").val();
	TyycokT(add_php_before_getitem_TyycokT,gettype_TyycokT);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_TyycokT = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_TyycokT = jQuery("#jform_gettype").val();
	TyycokT(add_php_before_getitem_TyycokT,gettype_TyycokT);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_BgxxqfK function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_BgxxqfK = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_BgxxqfK = jQuery("#jform_gettype").val();
	BgxxqfK(add_php_after_getitem_BgxxqfK,gettype_BgxxqfK);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_BgxxqfK = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_BgxxqfK = jQuery("#jform_gettype").val();
	BgxxqfK(add_php_after_getitem_BgxxqfK,gettype_BgxxqfK);

});

// #jform_gettype listeners for gettype_BgxxqfK function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_BgxxqfK = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_BgxxqfK = jQuery("#jform_gettype").val();
	BgxxqfK(add_php_after_getitem_BgxxqfK,gettype_BgxxqfK);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_BgxxqfK = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_BgxxqfK = jQuery("#jform_gettype").val();
	BgxxqfK(add_php_after_getitem_BgxxqfK,gettype_BgxxqfK);

});

// #jform_gettype listeners for gettype_FrDJmVm function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_FrDJmVm = jQuery("#jform_gettype").val();
	FrDJmVm(gettype_FrDJmVm);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_FrDJmVm = jQuery("#jform_gettype").val();
	FrDJmVm(gettype_FrDJmVm);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_dggICwL function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_dggICwL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_dggICwL = jQuery("#jform_gettype").val();
	dggICwL(add_php_getlistquery_dggICwL,gettype_dggICwL);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_dggICwL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_dggICwL = jQuery("#jform_gettype").val();
	dggICwL(add_php_getlistquery_dggICwL,gettype_dggICwL);

});

// #jform_gettype listeners for gettype_dggICwL function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_dggICwL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_dggICwL = jQuery("#jform_gettype").val();
	dggICwL(add_php_getlistquery_dggICwL,gettype_dggICwL);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_dggICwL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_dggICwL = jQuery("#jform_gettype").val();
	dggICwL(add_php_getlistquery_dggICwL,gettype_dggICwL);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vRPhexT function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vRPhexT = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vRPhexT = jQuery("#jform_gettype").val();
	vRPhexT(add_php_before_getitems_vRPhexT,gettype_vRPhexT);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vRPhexT = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vRPhexT = jQuery("#jform_gettype").val();
	vRPhexT(add_php_before_getitems_vRPhexT,gettype_vRPhexT);

});

// #jform_gettype listeners for gettype_vRPhexT function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vRPhexT = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vRPhexT = jQuery("#jform_gettype").val();
	vRPhexT(add_php_before_getitems_vRPhexT,gettype_vRPhexT);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vRPhexT = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vRPhexT = jQuery("#jform_gettype").val();
	vRPhexT(add_php_before_getitems_vRPhexT,gettype_vRPhexT);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_bWGUoUa function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_bWGUoUa = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_bWGUoUa = jQuery("#jform_gettype").val();
	bWGUoUa(add_php_after_getitems_bWGUoUa,gettype_bWGUoUa);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_bWGUoUa = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_bWGUoUa = jQuery("#jform_gettype").val();
	bWGUoUa(add_php_after_getitems_bWGUoUa,gettype_bWGUoUa);

});

// #jform_gettype listeners for gettype_bWGUoUa function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_bWGUoUa = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_bWGUoUa = jQuery("#jform_gettype").val();
	bWGUoUa(add_php_after_getitems_bWGUoUa,gettype_bWGUoUa);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_bWGUoUa = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_bWGUoUa = jQuery("#jform_gettype").val();
	bWGUoUa(add_php_after_getitems_bWGUoUa,gettype_bWGUoUa);

});

// #jform_gettype listeners for gettype_DuMzQyj function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_DuMzQyj = jQuery("#jform_gettype").val();
	DuMzQyj(gettype_DuMzQyj);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_DuMzQyj = jQuery("#jform_gettype").val();
	DuMzQyj(gettype_DuMzQyj);

});

// #jform_gettype listeners for gettype_OhdLgOR function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_OhdLgOR = jQuery("#jform_gettype").val();
	OhdLgOR(gettype_OhdLgOR);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_OhdLgOR = jQuery("#jform_gettype").val();
	OhdLgOR(gettype_OhdLgOR);

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
