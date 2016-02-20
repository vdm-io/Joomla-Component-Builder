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
	@build			20th February, 2016
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

// #jform_gettype listeners for gettype_kMOrrzi function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_kMOrrzi = jQuery("#jform_gettype").val();
	kMOrrzi(gettype_kMOrrzi);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_kMOrrzi = jQuery("#jform_gettype").val();
	kMOrrzi(gettype_kMOrrzi);

});

// #jform_main_source listeners for main_source_rzqACdN function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_rzqACdN = jQuery("#jform_main_source").val();
	rzqACdN(main_source_rzqACdN);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_rzqACdN = jQuery("#jform_main_source").val();
	rzqACdN(main_source_rzqACdN);

});

// #jform_main_source listeners for main_source_mVMUMnJ function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_mVMUMnJ = jQuery("#jform_main_source").val();
	mVMUMnJ(main_source_mVMUMnJ);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_mVMUMnJ = jQuery("#jform_main_source").val();
	mVMUMnJ(main_source_mVMUMnJ);

});

// #jform_main_source listeners for main_source_IBBCRTc function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_IBBCRTc = jQuery("#jform_main_source").val();
	IBBCRTc(main_source_IBBCRTc);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_IBBCRTc = jQuery("#jform_main_source").val();
	IBBCRTc(main_source_IBBCRTc);

});

// #jform_main_source listeners for main_source_ihwGAYE function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_ihwGAYE = jQuery("#jform_main_source").val();
	ihwGAYE(main_source_ihwGAYE);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_ihwGAYE = jQuery("#jform_main_source").val();
	ihwGAYE(main_source_ihwGAYE);

});

// #jform_addcalculation listeners for addcalculation_sjihbTt function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_sjihbTt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	sjihbTt(addcalculation_sjihbTt);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_sjihbTt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	sjihbTt(addcalculation_sjihbTt);

});

// #jform_addcalculation listeners for addcalculation_EaalDSf function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_EaalDSf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EaalDSf = jQuery("#jform_gettype").val();
	EaalDSf(addcalculation_EaalDSf,gettype_EaalDSf);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_EaalDSf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EaalDSf = jQuery("#jform_gettype").val();
	EaalDSf(addcalculation_EaalDSf,gettype_EaalDSf);

});

// #jform_gettype listeners for gettype_EaalDSf function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_EaalDSf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EaalDSf = jQuery("#jform_gettype").val();
	EaalDSf(addcalculation_EaalDSf,gettype_EaalDSf);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_EaalDSf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EaalDSf = jQuery("#jform_gettype").val();
	EaalDSf(addcalculation_EaalDSf,gettype_EaalDSf);

});

// #jform_addcalculation listeners for addcalculation_EVaCfhZ function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_EVaCfhZ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EVaCfhZ = jQuery("#jform_gettype").val();
	EVaCfhZ(addcalculation_EVaCfhZ,gettype_EVaCfhZ);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_EVaCfhZ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EVaCfhZ = jQuery("#jform_gettype").val();
	EVaCfhZ(addcalculation_EVaCfhZ,gettype_EVaCfhZ);

});

// #jform_gettype listeners for gettype_EVaCfhZ function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_EVaCfhZ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EVaCfhZ = jQuery("#jform_gettype").val();
	EVaCfhZ(addcalculation_EVaCfhZ,gettype_EVaCfhZ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_EVaCfhZ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EVaCfhZ = jQuery("#jform_gettype").val();
	EVaCfhZ(addcalculation_EVaCfhZ,gettype_EVaCfhZ);

});

// #jform_main_source listeners for main_source_PTyAUzG function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_PTyAUzG = jQuery("#jform_main_source").val();
	PTyAUzG(main_source_PTyAUzG);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_PTyAUzG = jQuery("#jform_main_source").val();
	PTyAUzG(main_source_PTyAUzG);

});

// #jform_main_source listeners for main_source_TuRxzZw function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_TuRxzZw = jQuery("#jform_main_source").val();
	TuRxzZw(main_source_TuRxzZw);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_TuRxzZw = jQuery("#jform_main_source").val();
	TuRxzZw(main_source_TuRxzZw);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_cOupVhV function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_cOupVhV = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_cOupVhV = jQuery("#jform_gettype").val();
	cOupVhV(add_php_before_getitem_cOupVhV,gettype_cOupVhV);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_cOupVhV = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_cOupVhV = jQuery("#jform_gettype").val();
	cOupVhV(add_php_before_getitem_cOupVhV,gettype_cOupVhV);

});

// #jform_gettype listeners for gettype_cOupVhV function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_cOupVhV = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_cOupVhV = jQuery("#jform_gettype").val();
	cOupVhV(add_php_before_getitem_cOupVhV,gettype_cOupVhV);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_cOupVhV = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_cOupVhV = jQuery("#jform_gettype").val();
	cOupVhV(add_php_before_getitem_cOupVhV,gettype_cOupVhV);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_gkhfYbE function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_gkhfYbE = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_gkhfYbE = jQuery("#jform_gettype").val();
	gkhfYbE(add_php_after_getitem_gkhfYbE,gettype_gkhfYbE);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_gkhfYbE = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_gkhfYbE = jQuery("#jform_gettype").val();
	gkhfYbE(add_php_after_getitem_gkhfYbE,gettype_gkhfYbE);

});

// #jform_gettype listeners for gettype_gkhfYbE function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_gkhfYbE = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_gkhfYbE = jQuery("#jform_gettype").val();
	gkhfYbE(add_php_after_getitem_gkhfYbE,gettype_gkhfYbE);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_gkhfYbE = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_gkhfYbE = jQuery("#jform_gettype").val();
	gkhfYbE(add_php_after_getitem_gkhfYbE,gettype_gkhfYbE);

});

// #jform_gettype listeners for gettype_GqMVAul function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_GqMVAul = jQuery("#jform_gettype").val();
	GqMVAul(gettype_GqMVAul);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_GqMVAul = jQuery("#jform_gettype").val();
	GqMVAul(gettype_GqMVAul);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_mVOBZID function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_mVOBZID = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_mVOBZID = jQuery("#jform_gettype").val();
	mVOBZID(add_php_getlistquery_mVOBZID,gettype_mVOBZID);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_mVOBZID = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_mVOBZID = jQuery("#jform_gettype").val();
	mVOBZID(add_php_getlistquery_mVOBZID,gettype_mVOBZID);

});

// #jform_gettype listeners for gettype_mVOBZID function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_mVOBZID = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_mVOBZID = jQuery("#jform_gettype").val();
	mVOBZID(add_php_getlistquery_mVOBZID,gettype_mVOBZID);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_mVOBZID = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_mVOBZID = jQuery("#jform_gettype").val();
	mVOBZID(add_php_getlistquery_mVOBZID,gettype_mVOBZID);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_PoGBgSs function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_PoGBgSs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_PoGBgSs = jQuery("#jform_gettype").val();
	PoGBgSs(add_php_before_getitems_PoGBgSs,gettype_PoGBgSs);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_PoGBgSs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_PoGBgSs = jQuery("#jform_gettype").val();
	PoGBgSs(add_php_before_getitems_PoGBgSs,gettype_PoGBgSs);

});

// #jform_gettype listeners for gettype_PoGBgSs function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_PoGBgSs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_PoGBgSs = jQuery("#jform_gettype").val();
	PoGBgSs(add_php_before_getitems_PoGBgSs,gettype_PoGBgSs);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_PoGBgSs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_PoGBgSs = jQuery("#jform_gettype").val();
	PoGBgSs(add_php_before_getitems_PoGBgSs,gettype_PoGBgSs);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_wpkYIZn function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_wpkYIZn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wpkYIZn = jQuery("#jform_gettype").val();
	wpkYIZn(add_php_after_getitems_wpkYIZn,gettype_wpkYIZn);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_wpkYIZn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wpkYIZn = jQuery("#jform_gettype").val();
	wpkYIZn(add_php_after_getitems_wpkYIZn,gettype_wpkYIZn);

});

// #jform_gettype listeners for gettype_wpkYIZn function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_wpkYIZn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wpkYIZn = jQuery("#jform_gettype").val();
	wpkYIZn(add_php_after_getitems_wpkYIZn,gettype_wpkYIZn);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_wpkYIZn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wpkYIZn = jQuery("#jform_gettype").val();
	wpkYIZn(add_php_after_getitems_wpkYIZn,gettype_wpkYIZn);

});

// #jform_gettype listeners for gettype_WIkoAta function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_WIkoAta = jQuery("#jform_gettype").val();
	WIkoAta(gettype_WIkoAta);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_WIkoAta = jQuery("#jform_gettype").val();
	WIkoAta(gettype_WIkoAta);

});

// #jform_gettype listeners for gettype_sSlmiqZ function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_sSlmiqZ = jQuery("#jform_gettype").val();
	sSlmiqZ(gettype_sSlmiqZ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_sSlmiqZ = jQuery("#jform_gettype").val();
	sSlmiqZ(gettype_sSlmiqZ);

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
