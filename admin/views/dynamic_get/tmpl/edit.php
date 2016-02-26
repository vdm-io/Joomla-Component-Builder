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

// #jform_gettype listeners for gettype_oIkUBwQ function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_oIkUBwQ = jQuery("#jform_gettype").val();
	oIkUBwQ(gettype_oIkUBwQ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_oIkUBwQ = jQuery("#jform_gettype").val();
	oIkUBwQ(gettype_oIkUBwQ);

});

// #jform_main_source listeners for main_source_tagnhvN function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_tagnhvN = jQuery("#jform_main_source").val();
	tagnhvN(main_source_tagnhvN);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_tagnhvN = jQuery("#jform_main_source").val();
	tagnhvN(main_source_tagnhvN);

});

// #jform_main_source listeners for main_source_KAhRcCC function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_KAhRcCC = jQuery("#jform_main_source").val();
	KAhRcCC(main_source_KAhRcCC);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_KAhRcCC = jQuery("#jform_main_source").val();
	KAhRcCC(main_source_KAhRcCC);

});

// #jform_main_source listeners for main_source_vAxEBga function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vAxEBga = jQuery("#jform_main_source").val();
	vAxEBga(main_source_vAxEBga);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vAxEBga = jQuery("#jform_main_source").val();
	vAxEBga(main_source_vAxEBga);

});

// #jform_main_source listeners for main_source_VMTbbbD function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_VMTbbbD = jQuery("#jform_main_source").val();
	VMTbbbD(main_source_VMTbbbD);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_VMTbbbD = jQuery("#jform_main_source").val();
	VMTbbbD(main_source_VMTbbbD);

});

// #jform_addcalculation listeners for addcalculation_pCbDvfi function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_pCbDvfi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	pCbDvfi(addcalculation_pCbDvfi);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_pCbDvfi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	pCbDvfi(addcalculation_pCbDvfi);

});

// #jform_addcalculation listeners for addcalculation_OqYoaAC function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_OqYoaAC = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_OqYoaAC = jQuery("#jform_gettype").val();
	OqYoaAC(addcalculation_OqYoaAC,gettype_OqYoaAC);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_OqYoaAC = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_OqYoaAC = jQuery("#jform_gettype").val();
	OqYoaAC(addcalculation_OqYoaAC,gettype_OqYoaAC);

});

// #jform_gettype listeners for gettype_OqYoaAC function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_OqYoaAC = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_OqYoaAC = jQuery("#jform_gettype").val();
	OqYoaAC(addcalculation_OqYoaAC,gettype_OqYoaAC);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_OqYoaAC = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_OqYoaAC = jQuery("#jform_gettype").val();
	OqYoaAC(addcalculation_OqYoaAC,gettype_OqYoaAC);

});

// #jform_addcalculation listeners for addcalculation_aMTREzM function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_aMTREzM = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_aMTREzM = jQuery("#jform_gettype").val();
	aMTREzM(addcalculation_aMTREzM,gettype_aMTREzM);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_aMTREzM = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_aMTREzM = jQuery("#jform_gettype").val();
	aMTREzM(addcalculation_aMTREzM,gettype_aMTREzM);

});

// #jform_gettype listeners for gettype_aMTREzM function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_aMTREzM = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_aMTREzM = jQuery("#jform_gettype").val();
	aMTREzM(addcalculation_aMTREzM,gettype_aMTREzM);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_aMTREzM = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_aMTREzM = jQuery("#jform_gettype").val();
	aMTREzM(addcalculation_aMTREzM,gettype_aMTREzM);

});

// #jform_main_source listeners for main_source_SCPJZNX function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_SCPJZNX = jQuery("#jform_main_source").val();
	SCPJZNX(main_source_SCPJZNX);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_SCPJZNX = jQuery("#jform_main_source").val();
	SCPJZNX(main_source_SCPJZNX);

});

// #jform_main_source listeners for main_source_aTmUxUz function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_aTmUxUz = jQuery("#jform_main_source").val();
	aTmUxUz(main_source_aTmUxUz);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_aTmUxUz = jQuery("#jform_main_source").val();
	aTmUxUz(main_source_aTmUxUz);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_nCtpSbY function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_nCtpSbY = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nCtpSbY = jQuery("#jform_gettype").val();
	nCtpSbY(add_php_before_getitem_nCtpSbY,gettype_nCtpSbY);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_nCtpSbY = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nCtpSbY = jQuery("#jform_gettype").val();
	nCtpSbY(add_php_before_getitem_nCtpSbY,gettype_nCtpSbY);

});

// #jform_gettype listeners for gettype_nCtpSbY function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_nCtpSbY = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nCtpSbY = jQuery("#jform_gettype").val();
	nCtpSbY(add_php_before_getitem_nCtpSbY,gettype_nCtpSbY);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_nCtpSbY = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nCtpSbY = jQuery("#jform_gettype").val();
	nCtpSbY(add_php_before_getitem_nCtpSbY,gettype_nCtpSbY);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_SpukdYZ function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_SpukdYZ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_SpukdYZ = jQuery("#jform_gettype").val();
	SpukdYZ(add_php_after_getitem_SpukdYZ,gettype_SpukdYZ);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_SpukdYZ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_SpukdYZ = jQuery("#jform_gettype").val();
	SpukdYZ(add_php_after_getitem_SpukdYZ,gettype_SpukdYZ);

});

// #jform_gettype listeners for gettype_SpukdYZ function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_SpukdYZ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_SpukdYZ = jQuery("#jform_gettype").val();
	SpukdYZ(add_php_after_getitem_SpukdYZ,gettype_SpukdYZ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_SpukdYZ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_SpukdYZ = jQuery("#jform_gettype").val();
	SpukdYZ(add_php_after_getitem_SpukdYZ,gettype_SpukdYZ);

});

// #jform_gettype listeners for gettype_TnpAxMN function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_TnpAxMN = jQuery("#jform_gettype").val();
	TnpAxMN(gettype_TnpAxMN);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_TnpAxMN = jQuery("#jform_gettype").val();
	TnpAxMN(gettype_TnpAxMN);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_CXzQkvO function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_CXzQkvO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_CXzQkvO = jQuery("#jform_gettype").val();
	CXzQkvO(add_php_getlistquery_CXzQkvO,gettype_CXzQkvO);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_CXzQkvO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_CXzQkvO = jQuery("#jform_gettype").val();
	CXzQkvO(add_php_getlistquery_CXzQkvO,gettype_CXzQkvO);

});

// #jform_gettype listeners for gettype_CXzQkvO function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_CXzQkvO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_CXzQkvO = jQuery("#jform_gettype").val();
	CXzQkvO(add_php_getlistquery_CXzQkvO,gettype_CXzQkvO);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_CXzQkvO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_CXzQkvO = jQuery("#jform_gettype").val();
	CXzQkvO(add_php_getlistquery_CXzQkvO,gettype_CXzQkvO);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_VRMRVLI function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_VRMRVLI = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_VRMRVLI = jQuery("#jform_gettype").val();
	VRMRVLI(add_php_before_getitems_VRMRVLI,gettype_VRMRVLI);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_VRMRVLI = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_VRMRVLI = jQuery("#jform_gettype").val();
	VRMRVLI(add_php_before_getitems_VRMRVLI,gettype_VRMRVLI);

});

// #jform_gettype listeners for gettype_VRMRVLI function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_VRMRVLI = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_VRMRVLI = jQuery("#jform_gettype").val();
	VRMRVLI(add_php_before_getitems_VRMRVLI,gettype_VRMRVLI);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_VRMRVLI = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_VRMRVLI = jQuery("#jform_gettype").val();
	VRMRVLI(add_php_before_getitems_VRMRVLI,gettype_VRMRVLI);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_DYujMuN function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_DYujMuN = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DYujMuN = jQuery("#jform_gettype").val();
	DYujMuN(add_php_after_getitems_DYujMuN,gettype_DYujMuN);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_DYujMuN = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DYujMuN = jQuery("#jform_gettype").val();
	DYujMuN(add_php_after_getitems_DYujMuN,gettype_DYujMuN);

});

// #jform_gettype listeners for gettype_DYujMuN function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_DYujMuN = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DYujMuN = jQuery("#jform_gettype").val();
	DYujMuN(add_php_after_getitems_DYujMuN,gettype_DYujMuN);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_DYujMuN = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DYujMuN = jQuery("#jform_gettype").val();
	DYujMuN(add_php_after_getitems_DYujMuN,gettype_DYujMuN);

});

// #jform_gettype listeners for gettype_okMXdwK function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_okMXdwK = jQuery("#jform_gettype").val();
	okMXdwK(gettype_okMXdwK);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_okMXdwK = jQuery("#jform_gettype").val();
	okMXdwK(gettype_okMXdwK);

});

// #jform_gettype listeners for gettype_Twzodcz function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_Twzodcz = jQuery("#jform_gettype").val();
	Twzodcz(gettype_Twzodcz);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_Twzodcz = jQuery("#jform_gettype").val();
	Twzodcz(gettype_Twzodcz);

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
