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
	@build			18th February, 2016
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

// #jform_gettype listeners for gettype_bSeMSaX function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_bSeMSaX = jQuery("#jform_gettype").val();
	bSeMSaX(gettype_bSeMSaX);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_bSeMSaX = jQuery("#jform_gettype").val();
	bSeMSaX(gettype_bSeMSaX);

});

// #jform_main_source listeners for main_source_KKWOFzR function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_KKWOFzR = jQuery("#jform_main_source").val();
	KKWOFzR(main_source_KKWOFzR);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_KKWOFzR = jQuery("#jform_main_source").val();
	KKWOFzR(main_source_KKWOFzR);

});

// #jform_main_source listeners for main_source_lLQgZeA function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_lLQgZeA = jQuery("#jform_main_source").val();
	lLQgZeA(main_source_lLQgZeA);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_lLQgZeA = jQuery("#jform_main_source").val();
	lLQgZeA(main_source_lLQgZeA);

});

// #jform_main_source listeners for main_source_MIGOzrO function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_MIGOzrO = jQuery("#jform_main_source").val();
	MIGOzrO(main_source_MIGOzrO);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_MIGOzrO = jQuery("#jform_main_source").val();
	MIGOzrO(main_source_MIGOzrO);

});

// #jform_main_source listeners for main_source_XVCVMmC function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_XVCVMmC = jQuery("#jform_main_source").val();
	XVCVMmC(main_source_XVCVMmC);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_XVCVMmC = jQuery("#jform_main_source").val();
	XVCVMmC(main_source_XVCVMmC);

});

// #jform_addcalculation listeners for addcalculation_sSBhZAk function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_sSBhZAk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	sSBhZAk(addcalculation_sSBhZAk);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_sSBhZAk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	sSBhZAk(addcalculation_sSBhZAk);

});

// #jform_addcalculation listeners for addcalculation_jiIMVbg function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_jiIMVbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_jiIMVbg = jQuery("#jform_gettype").val();
	jiIMVbg(addcalculation_jiIMVbg,gettype_jiIMVbg);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_jiIMVbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_jiIMVbg = jQuery("#jform_gettype").val();
	jiIMVbg(addcalculation_jiIMVbg,gettype_jiIMVbg);

});

// #jform_gettype listeners for gettype_jiIMVbg function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_jiIMVbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_jiIMVbg = jQuery("#jform_gettype").val();
	jiIMVbg(addcalculation_jiIMVbg,gettype_jiIMVbg);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_jiIMVbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_jiIMVbg = jQuery("#jform_gettype").val();
	jiIMVbg(addcalculation_jiIMVbg,gettype_jiIMVbg);

});

// #jform_addcalculation listeners for addcalculation_FylKwjr function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_FylKwjr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_FylKwjr = jQuery("#jform_gettype").val();
	FylKwjr(addcalculation_FylKwjr,gettype_FylKwjr);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_FylKwjr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_FylKwjr = jQuery("#jform_gettype").val();
	FylKwjr(addcalculation_FylKwjr,gettype_FylKwjr);

});

// #jform_gettype listeners for gettype_FylKwjr function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_FylKwjr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_FylKwjr = jQuery("#jform_gettype").val();
	FylKwjr(addcalculation_FylKwjr,gettype_FylKwjr);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_FylKwjr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_FylKwjr = jQuery("#jform_gettype").val();
	FylKwjr(addcalculation_FylKwjr,gettype_FylKwjr);

});

// #jform_main_source listeners for main_source_zQWGYym function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_zQWGYym = jQuery("#jform_main_source").val();
	zQWGYym(main_source_zQWGYym);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_zQWGYym = jQuery("#jform_main_source").val();
	zQWGYym(main_source_zQWGYym);

});

// #jform_main_source listeners for main_source_EYLinRu function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_EYLinRu = jQuery("#jform_main_source").val();
	EYLinRu(main_source_EYLinRu);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_EYLinRu = jQuery("#jform_main_source").val();
	EYLinRu(main_source_EYLinRu);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_FGaqcjK function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_FGaqcjK = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_FGaqcjK = jQuery("#jform_gettype").val();
	FGaqcjK(add_php_before_getitem_FGaqcjK,gettype_FGaqcjK);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_FGaqcjK = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_FGaqcjK = jQuery("#jform_gettype").val();
	FGaqcjK(add_php_before_getitem_FGaqcjK,gettype_FGaqcjK);

});

// #jform_gettype listeners for gettype_FGaqcjK function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_FGaqcjK = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_FGaqcjK = jQuery("#jform_gettype").val();
	FGaqcjK(add_php_before_getitem_FGaqcjK,gettype_FGaqcjK);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_FGaqcjK = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_FGaqcjK = jQuery("#jform_gettype").val();
	FGaqcjK(add_php_before_getitem_FGaqcjK,gettype_FGaqcjK);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_whfxEUB function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_whfxEUB = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_whfxEUB = jQuery("#jform_gettype").val();
	whfxEUB(add_php_after_getitem_whfxEUB,gettype_whfxEUB);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_whfxEUB = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_whfxEUB = jQuery("#jform_gettype").val();
	whfxEUB(add_php_after_getitem_whfxEUB,gettype_whfxEUB);

});

// #jform_gettype listeners for gettype_whfxEUB function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_whfxEUB = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_whfxEUB = jQuery("#jform_gettype").val();
	whfxEUB(add_php_after_getitem_whfxEUB,gettype_whfxEUB);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_whfxEUB = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_whfxEUB = jQuery("#jform_gettype").val();
	whfxEUB(add_php_after_getitem_whfxEUB,gettype_whfxEUB);

});

// #jform_gettype listeners for gettype_DTmXrXX function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_DTmXrXX = jQuery("#jform_gettype").val();
	DTmXrXX(gettype_DTmXrXX);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_DTmXrXX = jQuery("#jform_gettype").val();
	DTmXrXX(gettype_DTmXrXX);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_ekriOWe function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_ekriOWe = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_ekriOWe = jQuery("#jform_gettype").val();
	ekriOWe(add_php_getlistquery_ekriOWe,gettype_ekriOWe);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_ekriOWe = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_ekriOWe = jQuery("#jform_gettype").val();
	ekriOWe(add_php_getlistquery_ekriOWe,gettype_ekriOWe);

});

// #jform_gettype listeners for gettype_ekriOWe function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_ekriOWe = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_ekriOWe = jQuery("#jform_gettype").val();
	ekriOWe(add_php_getlistquery_ekriOWe,gettype_ekriOWe);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_ekriOWe = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_ekriOWe = jQuery("#jform_gettype").val();
	ekriOWe(add_php_getlistquery_ekriOWe,gettype_ekriOWe);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_jtKKkdm function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_jtKKkdm = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_jtKKkdm = jQuery("#jform_gettype").val();
	jtKKkdm(add_php_before_getitems_jtKKkdm,gettype_jtKKkdm);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_jtKKkdm = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_jtKKkdm = jQuery("#jform_gettype").val();
	jtKKkdm(add_php_before_getitems_jtKKkdm,gettype_jtKKkdm);

});

// #jform_gettype listeners for gettype_jtKKkdm function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_jtKKkdm = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_jtKKkdm = jQuery("#jform_gettype").val();
	jtKKkdm(add_php_before_getitems_jtKKkdm,gettype_jtKKkdm);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_jtKKkdm = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_jtKKkdm = jQuery("#jform_gettype").val();
	jtKKkdm(add_php_before_getitems_jtKKkdm,gettype_jtKKkdm);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_XvyTBjV function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_XvyTBjV = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_XvyTBjV = jQuery("#jform_gettype").val();
	XvyTBjV(add_php_after_getitems_XvyTBjV,gettype_XvyTBjV);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_XvyTBjV = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_XvyTBjV = jQuery("#jform_gettype").val();
	XvyTBjV(add_php_after_getitems_XvyTBjV,gettype_XvyTBjV);

});

// #jform_gettype listeners for gettype_XvyTBjV function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_XvyTBjV = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_XvyTBjV = jQuery("#jform_gettype").val();
	XvyTBjV(add_php_after_getitems_XvyTBjV,gettype_XvyTBjV);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_XvyTBjV = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_XvyTBjV = jQuery("#jform_gettype").val();
	XvyTBjV(add_php_after_getitems_XvyTBjV,gettype_XvyTBjV);

});

// #jform_gettype listeners for gettype_aNkZZKN function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_aNkZZKN = jQuery("#jform_gettype").val();
	aNkZZKN(gettype_aNkZZKN);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_aNkZZKN = jQuery("#jform_gettype").val();
	aNkZZKN(gettype_aNkZZKN);

});

// #jform_gettype listeners for gettype_JzmWmUy function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_JzmWmUy = jQuery("#jform_gettype").val();
	JzmWmUy(gettype_JzmWmUy);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_JzmWmUy = jQuery("#jform_gettype").val();
	JzmWmUy(gettype_JzmWmUy);

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
