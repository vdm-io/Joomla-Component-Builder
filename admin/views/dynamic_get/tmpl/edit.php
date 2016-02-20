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

// #jform_gettype listeners for gettype_eXrZeKd function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_eXrZeKd = jQuery("#jform_gettype").val();
	eXrZeKd(gettype_eXrZeKd);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_eXrZeKd = jQuery("#jform_gettype").val();
	eXrZeKd(gettype_eXrZeKd);

});

// #jform_main_source listeners for main_source_quYDAgu function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_quYDAgu = jQuery("#jform_main_source").val();
	quYDAgu(main_source_quYDAgu);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_quYDAgu = jQuery("#jform_main_source").val();
	quYDAgu(main_source_quYDAgu);

});

// #jform_main_source listeners for main_source_GrCCmCE function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_GrCCmCE = jQuery("#jform_main_source").val();
	GrCCmCE(main_source_GrCCmCE);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_GrCCmCE = jQuery("#jform_main_source").val();
	GrCCmCE(main_source_GrCCmCE);

});

// #jform_main_source listeners for main_source_hiCxhMk function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_hiCxhMk = jQuery("#jform_main_source").val();
	hiCxhMk(main_source_hiCxhMk);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_hiCxhMk = jQuery("#jform_main_source").val();
	hiCxhMk(main_source_hiCxhMk);

});

// #jform_main_source listeners for main_source_CFRAjyM function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_CFRAjyM = jQuery("#jform_main_source").val();
	CFRAjyM(main_source_CFRAjyM);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_CFRAjyM = jQuery("#jform_main_source").val();
	CFRAjyM(main_source_CFRAjyM);

});

// #jform_addcalculation listeners for addcalculation_WNxzsEb function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_WNxzsEb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	WNxzsEb(addcalculation_WNxzsEb);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_WNxzsEb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	WNxzsEb(addcalculation_WNxzsEb);

});

// #jform_addcalculation listeners for addcalculation_CItlivX function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_CItlivX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_CItlivX = jQuery("#jform_gettype").val();
	CItlivX(addcalculation_CItlivX,gettype_CItlivX);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_CItlivX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_CItlivX = jQuery("#jform_gettype").val();
	CItlivX(addcalculation_CItlivX,gettype_CItlivX);

});

// #jform_gettype listeners for gettype_CItlivX function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_CItlivX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_CItlivX = jQuery("#jform_gettype").val();
	CItlivX(addcalculation_CItlivX,gettype_CItlivX);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_CItlivX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_CItlivX = jQuery("#jform_gettype").val();
	CItlivX(addcalculation_CItlivX,gettype_CItlivX);

});

// #jform_addcalculation listeners for addcalculation_tJpGpbD function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_tJpGpbD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_tJpGpbD = jQuery("#jform_gettype").val();
	tJpGpbD(addcalculation_tJpGpbD,gettype_tJpGpbD);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_tJpGpbD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_tJpGpbD = jQuery("#jform_gettype").val();
	tJpGpbD(addcalculation_tJpGpbD,gettype_tJpGpbD);

});

// #jform_gettype listeners for gettype_tJpGpbD function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_tJpGpbD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_tJpGpbD = jQuery("#jform_gettype").val();
	tJpGpbD(addcalculation_tJpGpbD,gettype_tJpGpbD);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_tJpGpbD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_tJpGpbD = jQuery("#jform_gettype").val();
	tJpGpbD(addcalculation_tJpGpbD,gettype_tJpGpbD);

});

// #jform_main_source listeners for main_source_lpwUTLg function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_lpwUTLg = jQuery("#jform_main_source").val();
	lpwUTLg(main_source_lpwUTLg);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_lpwUTLg = jQuery("#jform_main_source").val();
	lpwUTLg(main_source_lpwUTLg);

});

// #jform_main_source listeners for main_source_nTtZlBv function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_nTtZlBv = jQuery("#jform_main_source").val();
	nTtZlBv(main_source_nTtZlBv);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_nTtZlBv = jQuery("#jform_main_source").val();
	nTtZlBv(main_source_nTtZlBv);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_nExSoDC function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_nExSoDC = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nExSoDC = jQuery("#jform_gettype").val();
	nExSoDC(add_php_before_getitem_nExSoDC,gettype_nExSoDC);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_nExSoDC = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nExSoDC = jQuery("#jform_gettype").val();
	nExSoDC(add_php_before_getitem_nExSoDC,gettype_nExSoDC);

});

// #jform_gettype listeners for gettype_nExSoDC function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_nExSoDC = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nExSoDC = jQuery("#jform_gettype").val();
	nExSoDC(add_php_before_getitem_nExSoDC,gettype_nExSoDC);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_nExSoDC = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nExSoDC = jQuery("#jform_gettype").val();
	nExSoDC(add_php_before_getitem_nExSoDC,gettype_nExSoDC);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_iHxqXNJ function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_iHxqXNJ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_iHxqXNJ = jQuery("#jform_gettype").val();
	iHxqXNJ(add_php_after_getitem_iHxqXNJ,gettype_iHxqXNJ);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_iHxqXNJ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_iHxqXNJ = jQuery("#jform_gettype").val();
	iHxqXNJ(add_php_after_getitem_iHxqXNJ,gettype_iHxqXNJ);

});

// #jform_gettype listeners for gettype_iHxqXNJ function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_iHxqXNJ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_iHxqXNJ = jQuery("#jform_gettype").val();
	iHxqXNJ(add_php_after_getitem_iHxqXNJ,gettype_iHxqXNJ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_iHxqXNJ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_iHxqXNJ = jQuery("#jform_gettype").val();
	iHxqXNJ(add_php_after_getitem_iHxqXNJ,gettype_iHxqXNJ);

});

// #jform_gettype listeners for gettype_UJUsWyN function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_UJUsWyN = jQuery("#jform_gettype").val();
	UJUsWyN(gettype_UJUsWyN);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_UJUsWyN = jQuery("#jform_gettype").val();
	UJUsWyN(gettype_UJUsWyN);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_iawMqnC function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_iawMqnC = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_iawMqnC = jQuery("#jform_gettype").val();
	iawMqnC(add_php_getlistquery_iawMqnC,gettype_iawMqnC);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_iawMqnC = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_iawMqnC = jQuery("#jform_gettype").val();
	iawMqnC(add_php_getlistquery_iawMqnC,gettype_iawMqnC);

});

// #jform_gettype listeners for gettype_iawMqnC function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_iawMqnC = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_iawMqnC = jQuery("#jform_gettype").val();
	iawMqnC(add_php_getlistquery_iawMqnC,gettype_iawMqnC);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_iawMqnC = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_iawMqnC = jQuery("#jform_gettype").val();
	iawMqnC(add_php_getlistquery_iawMqnC,gettype_iawMqnC);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_xeNggFH function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_xeNggFH = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_xeNggFH = jQuery("#jform_gettype").val();
	xeNggFH(add_php_before_getitems_xeNggFH,gettype_xeNggFH);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_xeNggFH = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_xeNggFH = jQuery("#jform_gettype").val();
	xeNggFH(add_php_before_getitems_xeNggFH,gettype_xeNggFH);

});

// #jform_gettype listeners for gettype_xeNggFH function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_xeNggFH = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_xeNggFH = jQuery("#jform_gettype").val();
	xeNggFH(add_php_before_getitems_xeNggFH,gettype_xeNggFH);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_xeNggFH = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_xeNggFH = jQuery("#jform_gettype").val();
	xeNggFH(add_php_before_getitems_xeNggFH,gettype_xeNggFH);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_DZqePcX function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_DZqePcX = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DZqePcX = jQuery("#jform_gettype").val();
	DZqePcX(add_php_after_getitems_DZqePcX,gettype_DZqePcX);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_DZqePcX = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DZqePcX = jQuery("#jform_gettype").val();
	DZqePcX(add_php_after_getitems_DZqePcX,gettype_DZqePcX);

});

// #jform_gettype listeners for gettype_DZqePcX function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_DZqePcX = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DZqePcX = jQuery("#jform_gettype").val();
	DZqePcX(add_php_after_getitems_DZqePcX,gettype_DZqePcX);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_DZqePcX = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DZqePcX = jQuery("#jform_gettype").val();
	DZqePcX(add_php_after_getitems_DZqePcX,gettype_DZqePcX);

});

// #jform_gettype listeners for gettype_QnEXSEG function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_QnEXSEG = jQuery("#jform_gettype").val();
	QnEXSEG(gettype_QnEXSEG);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_QnEXSEG = jQuery("#jform_gettype").val();
	QnEXSEG(gettype_QnEXSEG);

});

// #jform_gettype listeners for gettype_fXMiVKB function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_fXMiVKB = jQuery("#jform_gettype").val();
	fXMiVKB(gettype_fXMiVKB);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_fXMiVKB = jQuery("#jform_gettype").val();
	fXMiVKB(gettype_fXMiVKB);

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
