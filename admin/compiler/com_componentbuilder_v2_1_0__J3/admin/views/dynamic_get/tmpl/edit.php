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

// #jform_gettype listeners for gettype_FgGYZgQ function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_FgGYZgQ = jQuery("#jform_gettype").val();
	FgGYZgQ(gettype_FgGYZgQ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_FgGYZgQ = jQuery("#jform_gettype").val();
	FgGYZgQ(gettype_FgGYZgQ);

});

// #jform_main_source listeners for main_source_sfdMRPF function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_sfdMRPF = jQuery("#jform_main_source").val();
	sfdMRPF(main_source_sfdMRPF);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_sfdMRPF = jQuery("#jform_main_source").val();
	sfdMRPF(main_source_sfdMRPF);

});

// #jform_main_source listeners for main_source_CkHaVTI function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_CkHaVTI = jQuery("#jform_main_source").val();
	CkHaVTI(main_source_CkHaVTI);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_CkHaVTI = jQuery("#jform_main_source").val();
	CkHaVTI(main_source_CkHaVTI);

});

// #jform_main_source listeners for main_source_ODFnDxC function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_ODFnDxC = jQuery("#jform_main_source").val();
	ODFnDxC(main_source_ODFnDxC);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_ODFnDxC = jQuery("#jform_main_source").val();
	ODFnDxC(main_source_ODFnDxC);

});

// #jform_main_source listeners for main_source_XgvcRpS function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_XgvcRpS = jQuery("#jform_main_source").val();
	XgvcRpS(main_source_XgvcRpS);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_XgvcRpS = jQuery("#jform_main_source").val();
	XgvcRpS(main_source_XgvcRpS);

});

// #jform_addcalculation listeners for addcalculation_zeHggva function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_zeHggva = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	zeHggva(addcalculation_zeHggva);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_zeHggva = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	zeHggva(addcalculation_zeHggva);

});

// #jform_addcalculation listeners for addcalculation_gPqKgRk function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_gPqKgRk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_gPqKgRk = jQuery("#jform_gettype").val();
	gPqKgRk(addcalculation_gPqKgRk,gettype_gPqKgRk);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_gPqKgRk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_gPqKgRk = jQuery("#jform_gettype").val();
	gPqKgRk(addcalculation_gPqKgRk,gettype_gPqKgRk);

});

// #jform_gettype listeners for gettype_gPqKgRk function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_gPqKgRk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_gPqKgRk = jQuery("#jform_gettype").val();
	gPqKgRk(addcalculation_gPqKgRk,gettype_gPqKgRk);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_gPqKgRk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_gPqKgRk = jQuery("#jform_gettype").val();
	gPqKgRk(addcalculation_gPqKgRk,gettype_gPqKgRk);

});

// #jform_addcalculation listeners for addcalculation_BjabfiD function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_BjabfiD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_BjabfiD = jQuery("#jform_gettype").val();
	BjabfiD(addcalculation_BjabfiD,gettype_BjabfiD);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_BjabfiD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_BjabfiD = jQuery("#jform_gettype").val();
	BjabfiD(addcalculation_BjabfiD,gettype_BjabfiD);

});

// #jform_gettype listeners for gettype_BjabfiD function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_BjabfiD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_BjabfiD = jQuery("#jform_gettype").val();
	BjabfiD(addcalculation_BjabfiD,gettype_BjabfiD);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_BjabfiD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_BjabfiD = jQuery("#jform_gettype").val();
	BjabfiD(addcalculation_BjabfiD,gettype_BjabfiD);

});

// #jform_main_source listeners for main_source_lwVqorb function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_lwVqorb = jQuery("#jform_main_source").val();
	lwVqorb(main_source_lwVqorb);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_lwVqorb = jQuery("#jform_main_source").val();
	lwVqorb(main_source_lwVqorb);

});

// #jform_main_source listeners for main_source_fsketqC function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_fsketqC = jQuery("#jform_main_source").val();
	fsketqC(main_source_fsketqC);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_fsketqC = jQuery("#jform_main_source").val();
	fsketqC(main_source_fsketqC);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_IqvJWRb function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_IqvJWRb = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_IqvJWRb = jQuery("#jform_gettype").val();
	IqvJWRb(add_php_before_getitem_IqvJWRb,gettype_IqvJWRb);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_IqvJWRb = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_IqvJWRb = jQuery("#jform_gettype").val();
	IqvJWRb(add_php_before_getitem_IqvJWRb,gettype_IqvJWRb);

});

// #jform_gettype listeners for gettype_IqvJWRb function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_IqvJWRb = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_IqvJWRb = jQuery("#jform_gettype").val();
	IqvJWRb(add_php_before_getitem_IqvJWRb,gettype_IqvJWRb);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_IqvJWRb = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_IqvJWRb = jQuery("#jform_gettype").val();
	IqvJWRb(add_php_before_getitem_IqvJWRb,gettype_IqvJWRb);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_WOCZdYT function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_WOCZdYT = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_WOCZdYT = jQuery("#jform_gettype").val();
	WOCZdYT(add_php_after_getitem_WOCZdYT,gettype_WOCZdYT);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_WOCZdYT = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_WOCZdYT = jQuery("#jform_gettype").val();
	WOCZdYT(add_php_after_getitem_WOCZdYT,gettype_WOCZdYT);

});

// #jform_gettype listeners for gettype_WOCZdYT function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_WOCZdYT = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_WOCZdYT = jQuery("#jform_gettype").val();
	WOCZdYT(add_php_after_getitem_WOCZdYT,gettype_WOCZdYT);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_WOCZdYT = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_WOCZdYT = jQuery("#jform_gettype").val();
	WOCZdYT(add_php_after_getitem_WOCZdYT,gettype_WOCZdYT);

});

// #jform_gettype listeners for gettype_aelJLJg function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_aelJLJg = jQuery("#jform_gettype").val();
	aelJLJg(gettype_aelJLJg);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_aelJLJg = jQuery("#jform_gettype").val();
	aelJLJg(gettype_aelJLJg);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_tpZPucO function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_tpZPucO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_tpZPucO = jQuery("#jform_gettype").val();
	tpZPucO(add_php_getlistquery_tpZPucO,gettype_tpZPucO);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_tpZPucO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_tpZPucO = jQuery("#jform_gettype").val();
	tpZPucO(add_php_getlistquery_tpZPucO,gettype_tpZPucO);

});

// #jform_gettype listeners for gettype_tpZPucO function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_tpZPucO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_tpZPucO = jQuery("#jform_gettype").val();
	tpZPucO(add_php_getlistquery_tpZPucO,gettype_tpZPucO);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_tpZPucO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_tpZPucO = jQuery("#jform_gettype").val();
	tpZPucO(add_php_getlistquery_tpZPucO,gettype_tpZPucO);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_AXROJKr function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_AXROJKr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_AXROJKr = jQuery("#jform_gettype").val();
	AXROJKr(add_php_before_getitems_AXROJKr,gettype_AXROJKr);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_AXROJKr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_AXROJKr = jQuery("#jform_gettype").val();
	AXROJKr(add_php_before_getitems_AXROJKr,gettype_AXROJKr);

});

// #jform_gettype listeners for gettype_AXROJKr function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_AXROJKr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_AXROJKr = jQuery("#jform_gettype").val();
	AXROJKr(add_php_before_getitems_AXROJKr,gettype_AXROJKr);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_AXROJKr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_AXROJKr = jQuery("#jform_gettype").val();
	AXROJKr(add_php_before_getitems_AXROJKr,gettype_AXROJKr);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_JrgxvrW function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_JrgxvrW = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_JrgxvrW = jQuery("#jform_gettype").val();
	JrgxvrW(add_php_after_getitems_JrgxvrW,gettype_JrgxvrW);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_JrgxvrW = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_JrgxvrW = jQuery("#jform_gettype").val();
	JrgxvrW(add_php_after_getitems_JrgxvrW,gettype_JrgxvrW);

});

// #jform_gettype listeners for gettype_JrgxvrW function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_JrgxvrW = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_JrgxvrW = jQuery("#jform_gettype").val();
	JrgxvrW(add_php_after_getitems_JrgxvrW,gettype_JrgxvrW);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_JrgxvrW = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_JrgxvrW = jQuery("#jform_gettype").val();
	JrgxvrW(add_php_after_getitems_JrgxvrW,gettype_JrgxvrW);

});

// #jform_gettype listeners for gettype_xrgAMeu function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_xrgAMeu = jQuery("#jform_gettype").val();
	xrgAMeu(gettype_xrgAMeu);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_xrgAMeu = jQuery("#jform_gettype").val();
	xrgAMeu(gettype_xrgAMeu);

});

// #jform_gettype listeners for gettype_yuTNrmv function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_yuTNrmv = jQuery("#jform_gettype").val();
	yuTNrmv(gettype_yuTNrmv);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_yuTNrmv = jQuery("#jform_gettype").val();
	yuTNrmv(gettype_yuTNrmv);

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
