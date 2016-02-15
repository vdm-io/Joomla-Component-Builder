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
	@build			15th February, 2016
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

// #jform_gettype listeners for gettype_GtJWYHV function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_GtJWYHV = jQuery("#jform_gettype").val();
	GtJWYHV(gettype_GtJWYHV);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_GtJWYHV = jQuery("#jform_gettype").val();
	GtJWYHV(gettype_GtJWYHV);

});

// #jform_main_source listeners for main_source_qUEIIzH function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_qUEIIzH = jQuery("#jform_main_source").val();
	qUEIIzH(main_source_qUEIIzH);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_qUEIIzH = jQuery("#jform_main_source").val();
	qUEIIzH(main_source_qUEIIzH);

});

// #jform_main_source listeners for main_source_aXSPZKG function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_aXSPZKG = jQuery("#jform_main_source").val();
	aXSPZKG(main_source_aXSPZKG);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_aXSPZKG = jQuery("#jform_main_source").val();
	aXSPZKG(main_source_aXSPZKG);

});

// #jform_main_source listeners for main_source_McooZiU function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_McooZiU = jQuery("#jform_main_source").val();
	McooZiU(main_source_McooZiU);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_McooZiU = jQuery("#jform_main_source").val();
	McooZiU(main_source_McooZiU);

});

// #jform_main_source listeners for main_source_xZJeHvC function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_xZJeHvC = jQuery("#jform_main_source").val();
	xZJeHvC(main_source_xZJeHvC);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_xZJeHvC = jQuery("#jform_main_source").val();
	xZJeHvC(main_source_xZJeHvC);

});

// #jform_addcalculation listeners for addcalculation_zylrqpV function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_zylrqpV = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	zylrqpV(addcalculation_zylrqpV);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_zylrqpV = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	zylrqpV(addcalculation_zylrqpV);

});

// #jform_addcalculation listeners for addcalculation_MJoWXuh function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_MJoWXuh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_MJoWXuh = jQuery("#jform_gettype").val();
	MJoWXuh(addcalculation_MJoWXuh,gettype_MJoWXuh);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_MJoWXuh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_MJoWXuh = jQuery("#jform_gettype").val();
	MJoWXuh(addcalculation_MJoWXuh,gettype_MJoWXuh);

});

// #jform_gettype listeners for gettype_MJoWXuh function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_MJoWXuh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_MJoWXuh = jQuery("#jform_gettype").val();
	MJoWXuh(addcalculation_MJoWXuh,gettype_MJoWXuh);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_MJoWXuh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_MJoWXuh = jQuery("#jform_gettype").val();
	MJoWXuh(addcalculation_MJoWXuh,gettype_MJoWXuh);

});

// #jform_addcalculation listeners for addcalculation_SpQINPu function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_SpQINPu = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_SpQINPu = jQuery("#jform_gettype").val();
	SpQINPu(addcalculation_SpQINPu,gettype_SpQINPu);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_SpQINPu = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_SpQINPu = jQuery("#jform_gettype").val();
	SpQINPu(addcalculation_SpQINPu,gettype_SpQINPu);

});

// #jform_gettype listeners for gettype_SpQINPu function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_SpQINPu = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_SpQINPu = jQuery("#jform_gettype").val();
	SpQINPu(addcalculation_SpQINPu,gettype_SpQINPu);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_SpQINPu = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_SpQINPu = jQuery("#jform_gettype").val();
	SpQINPu(addcalculation_SpQINPu,gettype_SpQINPu);

});

// #jform_main_source listeners for main_source_obQcKhZ function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_obQcKhZ = jQuery("#jform_main_source").val();
	obQcKhZ(main_source_obQcKhZ);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_obQcKhZ = jQuery("#jform_main_source").val();
	obQcKhZ(main_source_obQcKhZ);

});

// #jform_main_source listeners for main_source_DKWnxOF function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_DKWnxOF = jQuery("#jform_main_source").val();
	DKWnxOF(main_source_DKWnxOF);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_DKWnxOF = jQuery("#jform_main_source").val();
	DKWnxOF(main_source_DKWnxOF);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_qsHGlds function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_qsHGlds = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_qsHGlds = jQuery("#jform_gettype").val();
	qsHGlds(add_php_before_getitem_qsHGlds,gettype_qsHGlds);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_qsHGlds = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_qsHGlds = jQuery("#jform_gettype").val();
	qsHGlds(add_php_before_getitem_qsHGlds,gettype_qsHGlds);

});

// #jform_gettype listeners for gettype_qsHGlds function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_qsHGlds = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_qsHGlds = jQuery("#jform_gettype").val();
	qsHGlds(add_php_before_getitem_qsHGlds,gettype_qsHGlds);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_qsHGlds = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_qsHGlds = jQuery("#jform_gettype").val();
	qsHGlds(add_php_before_getitem_qsHGlds,gettype_qsHGlds);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_nDrOPtH function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_nDrOPtH = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_nDrOPtH = jQuery("#jform_gettype").val();
	nDrOPtH(add_php_after_getitem_nDrOPtH,gettype_nDrOPtH);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_nDrOPtH = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_nDrOPtH = jQuery("#jform_gettype").val();
	nDrOPtH(add_php_after_getitem_nDrOPtH,gettype_nDrOPtH);

});

// #jform_gettype listeners for gettype_nDrOPtH function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_nDrOPtH = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_nDrOPtH = jQuery("#jform_gettype").val();
	nDrOPtH(add_php_after_getitem_nDrOPtH,gettype_nDrOPtH);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_nDrOPtH = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_nDrOPtH = jQuery("#jform_gettype").val();
	nDrOPtH(add_php_after_getitem_nDrOPtH,gettype_nDrOPtH);

});

// #jform_gettype listeners for gettype_rFFXUXF function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_rFFXUXF = jQuery("#jform_gettype").val();
	rFFXUXF(gettype_rFFXUXF);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_rFFXUXF = jQuery("#jform_gettype").val();
	rFFXUXF(gettype_rFFXUXF);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_fZixNaL function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_fZixNaL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_fZixNaL = jQuery("#jform_gettype").val();
	fZixNaL(add_php_getlistquery_fZixNaL,gettype_fZixNaL);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_fZixNaL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_fZixNaL = jQuery("#jform_gettype").val();
	fZixNaL(add_php_getlistquery_fZixNaL,gettype_fZixNaL);

});

// #jform_gettype listeners for gettype_fZixNaL function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_fZixNaL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_fZixNaL = jQuery("#jform_gettype").val();
	fZixNaL(add_php_getlistquery_fZixNaL,gettype_fZixNaL);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_fZixNaL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_fZixNaL = jQuery("#jform_gettype").val();
	fZixNaL(add_php_getlistquery_fZixNaL,gettype_fZixNaL);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_dJlwHnq function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_dJlwHnq = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_dJlwHnq = jQuery("#jform_gettype").val();
	dJlwHnq(add_php_before_getitems_dJlwHnq,gettype_dJlwHnq);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_dJlwHnq = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_dJlwHnq = jQuery("#jform_gettype").val();
	dJlwHnq(add_php_before_getitems_dJlwHnq,gettype_dJlwHnq);

});

// #jform_gettype listeners for gettype_dJlwHnq function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_dJlwHnq = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_dJlwHnq = jQuery("#jform_gettype").val();
	dJlwHnq(add_php_before_getitems_dJlwHnq,gettype_dJlwHnq);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_dJlwHnq = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_dJlwHnq = jQuery("#jform_gettype").val();
	dJlwHnq(add_php_before_getitems_dJlwHnq,gettype_dJlwHnq);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_qyQnfur function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_qyQnfur = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_qyQnfur = jQuery("#jform_gettype").val();
	qyQnfur(add_php_after_getitems_qyQnfur,gettype_qyQnfur);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_qyQnfur = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_qyQnfur = jQuery("#jform_gettype").val();
	qyQnfur(add_php_after_getitems_qyQnfur,gettype_qyQnfur);

});

// #jform_gettype listeners for gettype_qyQnfur function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_qyQnfur = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_qyQnfur = jQuery("#jform_gettype").val();
	qyQnfur(add_php_after_getitems_qyQnfur,gettype_qyQnfur);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_qyQnfur = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_qyQnfur = jQuery("#jform_gettype").val();
	qyQnfur(add_php_after_getitems_qyQnfur,gettype_qyQnfur);

});

// #jform_gettype listeners for gettype_Eltkuhs function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_Eltkuhs = jQuery("#jform_gettype").val();
	Eltkuhs(gettype_Eltkuhs);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_Eltkuhs = jQuery("#jform_gettype").val();
	Eltkuhs(gettype_Eltkuhs);

});

// #jform_gettype listeners for gettype_PUWmnBK function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_PUWmnBK = jQuery("#jform_gettype").val();
	PUWmnBK(gettype_PUWmnBK);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_PUWmnBK = jQuery("#jform_gettype").val();
	PUWmnBK(gettype_PUWmnBK);

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
