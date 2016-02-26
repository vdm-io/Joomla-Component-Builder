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

// #jform_gettype listeners for gettype_LcgMIYv function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_LcgMIYv = jQuery("#jform_gettype").val();
	LcgMIYv(gettype_LcgMIYv);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_LcgMIYv = jQuery("#jform_gettype").val();
	LcgMIYv(gettype_LcgMIYv);

});

// #jform_main_source listeners for main_source_FkvroZo function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_FkvroZo = jQuery("#jform_main_source").val();
	FkvroZo(main_source_FkvroZo);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_FkvroZo = jQuery("#jform_main_source").val();
	FkvroZo(main_source_FkvroZo);

});

// #jform_main_source listeners for main_source_rnwZwJc function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_rnwZwJc = jQuery("#jform_main_source").val();
	rnwZwJc(main_source_rnwZwJc);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_rnwZwJc = jQuery("#jform_main_source").val();
	rnwZwJc(main_source_rnwZwJc);

});

// #jform_main_source listeners for main_source_YXjeKPc function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_YXjeKPc = jQuery("#jform_main_source").val();
	YXjeKPc(main_source_YXjeKPc);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_YXjeKPc = jQuery("#jform_main_source").val();
	YXjeKPc(main_source_YXjeKPc);

});

// #jform_main_source listeners for main_source_HBUeadd function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_HBUeadd = jQuery("#jform_main_source").val();
	HBUeadd(main_source_HBUeadd);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_HBUeadd = jQuery("#jform_main_source").val();
	HBUeadd(main_source_HBUeadd);

});

// #jform_addcalculation listeners for addcalculation_ZAlosBX function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_ZAlosBX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	ZAlosBX(addcalculation_ZAlosBX);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_ZAlosBX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	ZAlosBX(addcalculation_ZAlosBX);

});

// #jform_addcalculation listeners for addcalculation_JriQwPE function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_JriQwPE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_JriQwPE = jQuery("#jform_gettype").val();
	JriQwPE(addcalculation_JriQwPE,gettype_JriQwPE);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_JriQwPE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_JriQwPE = jQuery("#jform_gettype").val();
	JriQwPE(addcalculation_JriQwPE,gettype_JriQwPE);

});

// #jform_gettype listeners for gettype_JriQwPE function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_JriQwPE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_JriQwPE = jQuery("#jform_gettype").val();
	JriQwPE(addcalculation_JriQwPE,gettype_JriQwPE);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_JriQwPE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_JriQwPE = jQuery("#jform_gettype").val();
	JriQwPE(addcalculation_JriQwPE,gettype_JriQwPE);

});

// #jform_addcalculation listeners for addcalculation_yWMdEtX function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_yWMdEtX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_yWMdEtX = jQuery("#jform_gettype").val();
	yWMdEtX(addcalculation_yWMdEtX,gettype_yWMdEtX);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_yWMdEtX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_yWMdEtX = jQuery("#jform_gettype").val();
	yWMdEtX(addcalculation_yWMdEtX,gettype_yWMdEtX);

});

// #jform_gettype listeners for gettype_yWMdEtX function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_yWMdEtX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_yWMdEtX = jQuery("#jform_gettype").val();
	yWMdEtX(addcalculation_yWMdEtX,gettype_yWMdEtX);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_yWMdEtX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_yWMdEtX = jQuery("#jform_gettype").val();
	yWMdEtX(addcalculation_yWMdEtX,gettype_yWMdEtX);

});

// #jform_main_source listeners for main_source_vTigkwW function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vTigkwW = jQuery("#jform_main_source").val();
	vTigkwW(main_source_vTigkwW);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vTigkwW = jQuery("#jform_main_source").val();
	vTigkwW(main_source_vTigkwW);

});

// #jform_main_source listeners for main_source_WhsaKIX function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_WhsaKIX = jQuery("#jform_main_source").val();
	WhsaKIX(main_source_WhsaKIX);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_WhsaKIX = jQuery("#jform_main_source").val();
	WhsaKIX(main_source_WhsaKIX);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_lWZWBjF function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_lWZWBjF = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_lWZWBjF = jQuery("#jform_gettype").val();
	lWZWBjF(add_php_before_getitem_lWZWBjF,gettype_lWZWBjF);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_lWZWBjF = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_lWZWBjF = jQuery("#jform_gettype").val();
	lWZWBjF(add_php_before_getitem_lWZWBjF,gettype_lWZWBjF);

});

// #jform_gettype listeners for gettype_lWZWBjF function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_lWZWBjF = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_lWZWBjF = jQuery("#jform_gettype").val();
	lWZWBjF(add_php_before_getitem_lWZWBjF,gettype_lWZWBjF);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_lWZWBjF = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_lWZWBjF = jQuery("#jform_gettype").val();
	lWZWBjF(add_php_before_getitem_lWZWBjF,gettype_lWZWBjF);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_qRlnsgr function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_qRlnsgr = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_qRlnsgr = jQuery("#jform_gettype").val();
	qRlnsgr(add_php_after_getitem_qRlnsgr,gettype_qRlnsgr);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_qRlnsgr = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_qRlnsgr = jQuery("#jform_gettype").val();
	qRlnsgr(add_php_after_getitem_qRlnsgr,gettype_qRlnsgr);

});

// #jform_gettype listeners for gettype_qRlnsgr function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_qRlnsgr = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_qRlnsgr = jQuery("#jform_gettype").val();
	qRlnsgr(add_php_after_getitem_qRlnsgr,gettype_qRlnsgr);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_qRlnsgr = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_qRlnsgr = jQuery("#jform_gettype").val();
	qRlnsgr(add_php_after_getitem_qRlnsgr,gettype_qRlnsgr);

});

// #jform_gettype listeners for gettype_QMSOYPJ function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_QMSOYPJ = jQuery("#jform_gettype").val();
	QMSOYPJ(gettype_QMSOYPJ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_QMSOYPJ = jQuery("#jform_gettype").val();
	QMSOYPJ(gettype_QMSOYPJ);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_pVDveQI function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_pVDveQI = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_pVDveQI = jQuery("#jform_gettype").val();
	pVDveQI(add_php_getlistquery_pVDveQI,gettype_pVDveQI);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_pVDveQI = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_pVDveQI = jQuery("#jform_gettype").val();
	pVDveQI(add_php_getlistquery_pVDveQI,gettype_pVDveQI);

});

// #jform_gettype listeners for gettype_pVDveQI function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_pVDveQI = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_pVDveQI = jQuery("#jform_gettype").val();
	pVDveQI(add_php_getlistquery_pVDveQI,gettype_pVDveQI);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_pVDveQI = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_pVDveQI = jQuery("#jform_gettype").val();
	pVDveQI(add_php_getlistquery_pVDveQI,gettype_pVDveQI);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_qyOnvHr function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_qyOnvHr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qyOnvHr = jQuery("#jform_gettype").val();
	qyOnvHr(add_php_before_getitems_qyOnvHr,gettype_qyOnvHr);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_qyOnvHr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qyOnvHr = jQuery("#jform_gettype").val();
	qyOnvHr(add_php_before_getitems_qyOnvHr,gettype_qyOnvHr);

});

// #jform_gettype listeners for gettype_qyOnvHr function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_qyOnvHr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qyOnvHr = jQuery("#jform_gettype").val();
	qyOnvHr(add_php_before_getitems_qyOnvHr,gettype_qyOnvHr);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_qyOnvHr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qyOnvHr = jQuery("#jform_gettype").val();
	qyOnvHr(add_php_before_getitems_qyOnvHr,gettype_qyOnvHr);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_FjXnTSH function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_FjXnTSH = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_FjXnTSH = jQuery("#jform_gettype").val();
	FjXnTSH(add_php_after_getitems_FjXnTSH,gettype_FjXnTSH);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_FjXnTSH = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_FjXnTSH = jQuery("#jform_gettype").val();
	FjXnTSH(add_php_after_getitems_FjXnTSH,gettype_FjXnTSH);

});

// #jform_gettype listeners for gettype_FjXnTSH function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_FjXnTSH = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_FjXnTSH = jQuery("#jform_gettype").val();
	FjXnTSH(add_php_after_getitems_FjXnTSH,gettype_FjXnTSH);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_FjXnTSH = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_FjXnTSH = jQuery("#jform_gettype").val();
	FjXnTSH(add_php_after_getitems_FjXnTSH,gettype_FjXnTSH);

});

// #jform_gettype listeners for gettype_OSbLeAC function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_OSbLeAC = jQuery("#jform_gettype").val();
	OSbLeAC(gettype_OSbLeAC);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_OSbLeAC = jQuery("#jform_gettype").val();
	OSbLeAC(gettype_OSbLeAC);

});

// #jform_gettype listeners for gettype_xLDrwuQ function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_xLDrwuQ = jQuery("#jform_gettype").val();
	xLDrwuQ(gettype_xLDrwuQ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_xLDrwuQ = jQuery("#jform_gettype").val();
	xLDrwuQ(gettype_xLDrwuQ);

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
