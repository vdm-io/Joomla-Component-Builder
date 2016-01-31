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

// #jform_gettype listeners for gettype_FZGVCVB function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_FZGVCVB = jQuery("#jform_gettype").val();
	FZGVCVB(gettype_FZGVCVB);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_FZGVCVB = jQuery("#jform_gettype").val();
	FZGVCVB(gettype_FZGVCVB);

});

// #jform_main_source listeners for main_source_GFZLiKC function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_GFZLiKC = jQuery("#jform_main_source").val();
	GFZLiKC(main_source_GFZLiKC);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_GFZLiKC = jQuery("#jform_main_source").val();
	GFZLiKC(main_source_GFZLiKC);

});

// #jform_main_source listeners for main_source_ygJcdol function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_ygJcdol = jQuery("#jform_main_source").val();
	ygJcdol(main_source_ygJcdol);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_ygJcdol = jQuery("#jform_main_source").val();
	ygJcdol(main_source_ygJcdol);

});

// #jform_main_source listeners for main_source_aBvLDXA function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_aBvLDXA = jQuery("#jform_main_source").val();
	aBvLDXA(main_source_aBvLDXA);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_aBvLDXA = jQuery("#jform_main_source").val();
	aBvLDXA(main_source_aBvLDXA);

});

// #jform_main_source listeners for main_source_nWWtBge function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_nWWtBge = jQuery("#jform_main_source").val();
	nWWtBge(main_source_nWWtBge);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_nWWtBge = jQuery("#jform_main_source").val();
	nWWtBge(main_source_nWWtBge);

});

// #jform_addcalculation listeners for addcalculation_SORuSWQ function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_SORuSWQ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	SORuSWQ(addcalculation_SORuSWQ);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_SORuSWQ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	SORuSWQ(addcalculation_SORuSWQ);

});

// #jform_addcalculation listeners for addcalculation_AcudNSb function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_AcudNSb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_AcudNSb = jQuery("#jform_gettype").val();
	AcudNSb(addcalculation_AcudNSb,gettype_AcudNSb);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_AcudNSb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_AcudNSb = jQuery("#jform_gettype").val();
	AcudNSb(addcalculation_AcudNSb,gettype_AcudNSb);

});

// #jform_gettype listeners for gettype_AcudNSb function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_AcudNSb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_AcudNSb = jQuery("#jform_gettype").val();
	AcudNSb(addcalculation_AcudNSb,gettype_AcudNSb);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_AcudNSb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_AcudNSb = jQuery("#jform_gettype").val();
	AcudNSb(addcalculation_AcudNSb,gettype_AcudNSb);

});

// #jform_addcalculation listeners for addcalculation_uXqArsE function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_uXqArsE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_uXqArsE = jQuery("#jform_gettype").val();
	uXqArsE(addcalculation_uXqArsE,gettype_uXqArsE);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_uXqArsE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_uXqArsE = jQuery("#jform_gettype").val();
	uXqArsE(addcalculation_uXqArsE,gettype_uXqArsE);

});

// #jform_gettype listeners for gettype_uXqArsE function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_uXqArsE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_uXqArsE = jQuery("#jform_gettype").val();
	uXqArsE(addcalculation_uXqArsE,gettype_uXqArsE);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_uXqArsE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_uXqArsE = jQuery("#jform_gettype").val();
	uXqArsE(addcalculation_uXqArsE,gettype_uXqArsE);

});

// #jform_main_source listeners for main_source_QpPysiu function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_QpPysiu = jQuery("#jform_main_source").val();
	QpPysiu(main_source_QpPysiu);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_QpPysiu = jQuery("#jform_main_source").val();
	QpPysiu(main_source_QpPysiu);

});

// #jform_main_source listeners for main_source_pXRXojv function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_pXRXojv = jQuery("#jform_main_source").val();
	pXRXojv(main_source_pXRXojv);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_pXRXojv = jQuery("#jform_main_source").val();
	pXRXojv(main_source_pXRXojv);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_QfgugiS function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_QfgugiS = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_QfgugiS = jQuery("#jform_gettype").val();
	QfgugiS(add_php_before_getitem_QfgugiS,gettype_QfgugiS);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_QfgugiS = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_QfgugiS = jQuery("#jform_gettype").val();
	QfgugiS(add_php_before_getitem_QfgugiS,gettype_QfgugiS);

});

// #jform_gettype listeners for gettype_QfgugiS function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_QfgugiS = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_QfgugiS = jQuery("#jform_gettype").val();
	QfgugiS(add_php_before_getitem_QfgugiS,gettype_QfgugiS);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_QfgugiS = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_QfgugiS = jQuery("#jform_gettype").val();
	QfgugiS(add_php_before_getitem_QfgugiS,gettype_QfgugiS);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_lLptvBi function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_lLptvBi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_lLptvBi = jQuery("#jform_gettype").val();
	lLptvBi(add_php_after_getitem_lLptvBi,gettype_lLptvBi);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_lLptvBi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_lLptvBi = jQuery("#jform_gettype").val();
	lLptvBi(add_php_after_getitem_lLptvBi,gettype_lLptvBi);

});

// #jform_gettype listeners for gettype_lLptvBi function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_lLptvBi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_lLptvBi = jQuery("#jform_gettype").val();
	lLptvBi(add_php_after_getitem_lLptvBi,gettype_lLptvBi);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_lLptvBi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_lLptvBi = jQuery("#jform_gettype").val();
	lLptvBi(add_php_after_getitem_lLptvBi,gettype_lLptvBi);

});

// #jform_gettype listeners for gettype_ltPMoUR function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_ltPMoUR = jQuery("#jform_gettype").val();
	ltPMoUR(gettype_ltPMoUR);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_ltPMoUR = jQuery("#jform_gettype").val();
	ltPMoUR(gettype_ltPMoUR);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_HnBdEdL function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_HnBdEdL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_HnBdEdL = jQuery("#jform_gettype").val();
	HnBdEdL(add_php_getlistquery_HnBdEdL,gettype_HnBdEdL);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_HnBdEdL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_HnBdEdL = jQuery("#jform_gettype").val();
	HnBdEdL(add_php_getlistquery_HnBdEdL,gettype_HnBdEdL);

});

// #jform_gettype listeners for gettype_HnBdEdL function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_HnBdEdL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_HnBdEdL = jQuery("#jform_gettype").val();
	HnBdEdL(add_php_getlistquery_HnBdEdL,gettype_HnBdEdL);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_HnBdEdL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_HnBdEdL = jQuery("#jform_gettype").val();
	HnBdEdL(add_php_getlistquery_HnBdEdL,gettype_HnBdEdL);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_XpwobPt function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_XpwobPt = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_XpwobPt = jQuery("#jform_gettype").val();
	XpwobPt(add_php_before_getitems_XpwobPt,gettype_XpwobPt);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_XpwobPt = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_XpwobPt = jQuery("#jform_gettype").val();
	XpwobPt(add_php_before_getitems_XpwobPt,gettype_XpwobPt);

});

// #jform_gettype listeners for gettype_XpwobPt function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_XpwobPt = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_XpwobPt = jQuery("#jform_gettype").val();
	XpwobPt(add_php_before_getitems_XpwobPt,gettype_XpwobPt);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_XpwobPt = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_XpwobPt = jQuery("#jform_gettype").val();
	XpwobPt(add_php_before_getitems_XpwobPt,gettype_XpwobPt);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_wKesGPt function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_wKesGPt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wKesGPt = jQuery("#jform_gettype").val();
	wKesGPt(add_php_after_getitems_wKesGPt,gettype_wKesGPt);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_wKesGPt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wKesGPt = jQuery("#jform_gettype").val();
	wKesGPt(add_php_after_getitems_wKesGPt,gettype_wKesGPt);

});

// #jform_gettype listeners for gettype_wKesGPt function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_wKesGPt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wKesGPt = jQuery("#jform_gettype").val();
	wKesGPt(add_php_after_getitems_wKesGPt,gettype_wKesGPt);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_wKesGPt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wKesGPt = jQuery("#jform_gettype").val();
	wKesGPt(add_php_after_getitems_wKesGPt,gettype_wKesGPt);

});

// #jform_gettype listeners for gettype_ONeyMtT function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_ONeyMtT = jQuery("#jform_gettype").val();
	ONeyMtT(gettype_ONeyMtT);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_ONeyMtT = jQuery("#jform_gettype").val();
	ONeyMtT(gettype_ONeyMtT);

});

// #jform_gettype listeners for gettype_wWdgwIv function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_wWdgwIv = jQuery("#jform_gettype").val();
	wWdgwIv(gettype_wWdgwIv);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_wWdgwIv = jQuery("#jform_gettype").val();
	wWdgwIv(gettype_wWdgwIv);

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
