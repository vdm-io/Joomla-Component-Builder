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

// #jform_gettype listeners for gettype_kIxqawN function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_kIxqawN = jQuery("#jform_gettype").val();
	kIxqawN(gettype_kIxqawN);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_kIxqawN = jQuery("#jform_gettype").val();
	kIxqawN(gettype_kIxqawN);

});

// #jform_main_source listeners for main_source_KOzpbDU function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_KOzpbDU = jQuery("#jform_main_source").val();
	KOzpbDU(main_source_KOzpbDU);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_KOzpbDU = jQuery("#jform_main_source").val();
	KOzpbDU(main_source_KOzpbDU);

});

// #jform_main_source listeners for main_source_XHdfPdM function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_XHdfPdM = jQuery("#jform_main_source").val();
	XHdfPdM(main_source_XHdfPdM);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_XHdfPdM = jQuery("#jform_main_source").val();
	XHdfPdM(main_source_XHdfPdM);

});

// #jform_main_source listeners for main_source_CqBhCBw function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_CqBhCBw = jQuery("#jform_main_source").val();
	CqBhCBw(main_source_CqBhCBw);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_CqBhCBw = jQuery("#jform_main_source").val();
	CqBhCBw(main_source_CqBhCBw);

});

// #jform_main_source listeners for main_source_gxMyNJb function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_gxMyNJb = jQuery("#jform_main_source").val();
	gxMyNJb(main_source_gxMyNJb);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_gxMyNJb = jQuery("#jform_main_source").val();
	gxMyNJb(main_source_gxMyNJb);

});

// #jform_addcalculation listeners for addcalculation_aFHdKxk function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_aFHdKxk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	aFHdKxk(addcalculation_aFHdKxk);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_aFHdKxk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	aFHdKxk(addcalculation_aFHdKxk);

});

// #jform_addcalculation listeners for addcalculation_xtDYvhA function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_xtDYvhA = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_xtDYvhA = jQuery("#jform_gettype").val();
	xtDYvhA(addcalculation_xtDYvhA,gettype_xtDYvhA);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_xtDYvhA = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_xtDYvhA = jQuery("#jform_gettype").val();
	xtDYvhA(addcalculation_xtDYvhA,gettype_xtDYvhA);

});

// #jform_gettype listeners for gettype_xtDYvhA function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_xtDYvhA = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_xtDYvhA = jQuery("#jform_gettype").val();
	xtDYvhA(addcalculation_xtDYvhA,gettype_xtDYvhA);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_xtDYvhA = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_xtDYvhA = jQuery("#jform_gettype").val();
	xtDYvhA(addcalculation_xtDYvhA,gettype_xtDYvhA);

});

// #jform_addcalculation listeners for addcalculation_ZDpXEUF function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_ZDpXEUF = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_ZDpXEUF = jQuery("#jform_gettype").val();
	ZDpXEUF(addcalculation_ZDpXEUF,gettype_ZDpXEUF);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_ZDpXEUF = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_ZDpXEUF = jQuery("#jform_gettype").val();
	ZDpXEUF(addcalculation_ZDpXEUF,gettype_ZDpXEUF);

});

// #jform_gettype listeners for gettype_ZDpXEUF function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_ZDpXEUF = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_ZDpXEUF = jQuery("#jform_gettype").val();
	ZDpXEUF(addcalculation_ZDpXEUF,gettype_ZDpXEUF);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_ZDpXEUF = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_ZDpXEUF = jQuery("#jform_gettype").val();
	ZDpXEUF(addcalculation_ZDpXEUF,gettype_ZDpXEUF);

});

// #jform_main_source listeners for main_source_AtRXJnW function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_AtRXJnW = jQuery("#jform_main_source").val();
	AtRXJnW(main_source_AtRXJnW);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_AtRXJnW = jQuery("#jform_main_source").val();
	AtRXJnW(main_source_AtRXJnW);

});

// #jform_main_source listeners for main_source_dXTbBIH function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_dXTbBIH = jQuery("#jform_main_source").val();
	dXTbBIH(main_source_dXTbBIH);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_dXTbBIH = jQuery("#jform_main_source").val();
	dXTbBIH(main_source_dXTbBIH);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_RxeeGhA function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_RxeeGhA = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_RxeeGhA = jQuery("#jform_gettype").val();
	RxeeGhA(add_php_before_getitem_RxeeGhA,gettype_RxeeGhA);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_RxeeGhA = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_RxeeGhA = jQuery("#jform_gettype").val();
	RxeeGhA(add_php_before_getitem_RxeeGhA,gettype_RxeeGhA);

});

// #jform_gettype listeners for gettype_RxeeGhA function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_RxeeGhA = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_RxeeGhA = jQuery("#jform_gettype").val();
	RxeeGhA(add_php_before_getitem_RxeeGhA,gettype_RxeeGhA);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_RxeeGhA = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_RxeeGhA = jQuery("#jform_gettype").val();
	RxeeGhA(add_php_before_getitem_RxeeGhA,gettype_RxeeGhA);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_rUiYvBP function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_rUiYvBP = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_rUiYvBP = jQuery("#jform_gettype").val();
	rUiYvBP(add_php_after_getitem_rUiYvBP,gettype_rUiYvBP);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_rUiYvBP = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_rUiYvBP = jQuery("#jform_gettype").val();
	rUiYvBP(add_php_after_getitem_rUiYvBP,gettype_rUiYvBP);

});

// #jform_gettype listeners for gettype_rUiYvBP function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_rUiYvBP = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_rUiYvBP = jQuery("#jform_gettype").val();
	rUiYvBP(add_php_after_getitem_rUiYvBP,gettype_rUiYvBP);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_rUiYvBP = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_rUiYvBP = jQuery("#jform_gettype").val();
	rUiYvBP(add_php_after_getitem_rUiYvBP,gettype_rUiYvBP);

});

// #jform_gettype listeners for gettype_tdubUQf function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_tdubUQf = jQuery("#jform_gettype").val();
	tdubUQf(gettype_tdubUQf);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_tdubUQf = jQuery("#jform_gettype").val();
	tdubUQf(gettype_tdubUQf);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_WUTdSww function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_WUTdSww = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_WUTdSww = jQuery("#jform_gettype").val();
	WUTdSww(add_php_getlistquery_WUTdSww,gettype_WUTdSww);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_WUTdSww = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_WUTdSww = jQuery("#jform_gettype").val();
	WUTdSww(add_php_getlistquery_WUTdSww,gettype_WUTdSww);

});

// #jform_gettype listeners for gettype_WUTdSww function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_WUTdSww = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_WUTdSww = jQuery("#jform_gettype").val();
	WUTdSww(add_php_getlistquery_WUTdSww,gettype_WUTdSww);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_WUTdSww = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_WUTdSww = jQuery("#jform_gettype").val();
	WUTdSww(add_php_getlistquery_WUTdSww,gettype_WUTdSww);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_OjNsfeN function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_OjNsfeN = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_OjNsfeN = jQuery("#jform_gettype").val();
	OjNsfeN(add_php_before_getitems_OjNsfeN,gettype_OjNsfeN);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_OjNsfeN = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_OjNsfeN = jQuery("#jform_gettype").val();
	OjNsfeN(add_php_before_getitems_OjNsfeN,gettype_OjNsfeN);

});

// #jform_gettype listeners for gettype_OjNsfeN function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_OjNsfeN = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_OjNsfeN = jQuery("#jform_gettype").val();
	OjNsfeN(add_php_before_getitems_OjNsfeN,gettype_OjNsfeN);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_OjNsfeN = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_OjNsfeN = jQuery("#jform_gettype").val();
	OjNsfeN(add_php_before_getitems_OjNsfeN,gettype_OjNsfeN);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_mzPeyNJ function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_mzPeyNJ = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_mzPeyNJ = jQuery("#jform_gettype").val();
	mzPeyNJ(add_php_after_getitems_mzPeyNJ,gettype_mzPeyNJ);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_mzPeyNJ = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_mzPeyNJ = jQuery("#jform_gettype").val();
	mzPeyNJ(add_php_after_getitems_mzPeyNJ,gettype_mzPeyNJ);

});

// #jform_gettype listeners for gettype_mzPeyNJ function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_mzPeyNJ = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_mzPeyNJ = jQuery("#jform_gettype").val();
	mzPeyNJ(add_php_after_getitems_mzPeyNJ,gettype_mzPeyNJ);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_mzPeyNJ = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_mzPeyNJ = jQuery("#jform_gettype").val();
	mzPeyNJ(add_php_after_getitems_mzPeyNJ,gettype_mzPeyNJ);

});

// #jform_gettype listeners for gettype_LAQluZc function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_LAQluZc = jQuery("#jform_gettype").val();
	LAQluZc(gettype_LAQluZc);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_LAQluZc = jQuery("#jform_gettype").val();
	LAQluZc(gettype_LAQluZc);

});

// #jform_gettype listeners for gettype_eqvQVqX function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_eqvQVqX = jQuery("#jform_gettype").val();
	eqvQVqX(gettype_eqvQVqX);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_eqvQVqX = jQuery("#jform_gettype").val();
	eqvQVqX(gettype_eqvQVqX);

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
