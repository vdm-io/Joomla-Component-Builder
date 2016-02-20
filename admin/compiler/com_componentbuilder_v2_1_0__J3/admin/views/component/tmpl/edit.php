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

	<?php echo JLayoutHelper::render('component.details_above', $this); ?><div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'componentTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'details', JText::_('COM_COMPONENTBUILDER_COMPONENT_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('component.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('component.details_right', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'settings', JText::_('COM_COMPONENTBUILDER_COMPONENT_SETTINGS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('component.settings_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('component.settings_right', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'scripts', JText::_('COM_COMPONENTBUILDER_COMPONENT_SCRIPTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('component.scripts_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'readme', JText::_('COM_COMPONENTBUILDER_COMPONENT_README', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('component.readme_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('component.readme_right', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('admin_view.access')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'admin_views', JText::_('COM_COMPONENTBUILDER_COMPONENT_ADMIN_VIEWS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('component.admin_views_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('site_view.access')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'site_views', JText::_('COM_COMPONENTBUILDER_COMPONENT_SITE_VIEWS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('component.site_views_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'ftp_servers', JText::_('COM_COMPONENTBUILDER_COMPONENT_FTP_SERVERS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('component.ftp_servers_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('core.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'componentTab', 'publishing', JText::_('COM_COMPONENTBUILDER_COMPONENT_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('component.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('component.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="component.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('component.details_under', $this); ?>
</form>

<script type="text/javascript">

// #jform_add_php_helper_admin listeners for add_php_helper_admin_yZoKbtN function
jQuery('#jform_add_php_helper_admin').on('keyup',function()
{
	var add_php_helper_admin_yZoKbtN = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	yZoKbtN(add_php_helper_admin_yZoKbtN);

});
jQuery('#adminForm').on('change', '#jform_add_php_helper_admin',function (e)
{
	e.preventDefault();
	var add_php_helper_admin_yZoKbtN = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	yZoKbtN(add_php_helper_admin_yZoKbtN);

});

// #jform_add_php_helper_site listeners for add_php_helper_site_LrnMZHa function
jQuery('#jform_add_php_helper_site').on('keyup',function()
{
	var add_php_helper_site_LrnMZHa = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	LrnMZHa(add_php_helper_site_LrnMZHa);

});
jQuery('#adminForm').on('change', '#jform_add_php_helper_site',function (e)
{
	e.preventDefault();
	var add_php_helper_site_LrnMZHa = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	LrnMZHa(add_php_helper_site_LrnMZHa);

});

// #jform_add_css listeners for add_css_RWqVUxB function
jQuery('#jform_add_css').on('keyup',function()
{
	var add_css_RWqVUxB = jQuery("#jform_add_css input[type='radio']:checked").val();
	RWqVUxB(add_css_RWqVUxB);

});
jQuery('#adminForm').on('change', '#jform_add_css',function (e)
{
	e.preventDefault();
	var add_css_RWqVUxB = jQuery("#jform_add_css input[type='radio']:checked").val();
	RWqVUxB(add_css_RWqVUxB);

});

// #jform_add_sql listeners for add_sql_rTuBFxb function
jQuery('#jform_add_sql').on('keyup',function()
{
	var add_sql_rTuBFxb = jQuery("#jform_add_sql input[type='radio']:checked").val();
	rTuBFxb(add_sql_rTuBFxb);

});
jQuery('#adminForm').on('change', '#jform_add_sql',function (e)
{
	e.preventDefault();
	var add_sql_rTuBFxb = jQuery("#jform_add_sql input[type='radio']:checked").val();
	rTuBFxb(add_sql_rTuBFxb);

});

// #jform_emptycontributors listeners for emptycontributors_jOrwvlc function
jQuery('#jform_emptycontributors').on('keyup',function()
{
	var emptycontributors_jOrwvlc = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	jOrwvlc(emptycontributors_jOrwvlc);

});
jQuery('#adminForm').on('change', '#jform_emptycontributors',function (e)
{
	e.preventDefault();
	var emptycontributors_jOrwvlc = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	jOrwvlc(emptycontributors_jOrwvlc);

});

// #jform_add_license listeners for add_license_DfGhWDE function
jQuery('#jform_add_license').on('keyup',function()
{
	var add_license_DfGhWDE = jQuery("#jform_add_license input[type='radio']:checked").val();
	DfGhWDE(add_license_DfGhWDE);

});
jQuery('#adminForm').on('change', '#jform_add_license',function (e)
{
	e.preventDefault();
	var add_license_DfGhWDE = jQuery("#jform_add_license input[type='radio']:checked").val();
	DfGhWDE(add_license_DfGhWDE);

});

// #jform_add_admin_event listeners for add_admin_event_BdzNovg function
jQuery('#jform_add_admin_event').on('keyup',function()
{
	var add_admin_event_BdzNovg = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	BdzNovg(add_admin_event_BdzNovg);

});
jQuery('#adminForm').on('change', '#jform_add_admin_event',function (e)
{
	e.preventDefault();
	var add_admin_event_BdzNovg = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	BdzNovg(add_admin_event_BdzNovg);

});

// #jform_add_site_event listeners for add_site_event_ZxGUGnh function
jQuery('#jform_add_site_event').on('keyup',function()
{
	var add_site_event_ZxGUGnh = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	ZxGUGnh(add_site_event_ZxGUGnh);

});
jQuery('#adminForm').on('change', '#jform_add_site_event',function (e)
{
	e.preventDefault();
	var add_site_event_ZxGUGnh = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	ZxGUGnh(add_site_event_ZxGUGnh);

});

// #jform_addreadme listeners for addreadme_fnEKCCg function
jQuery('#jform_addreadme').on('keyup',function()
{
	var addreadme_fnEKCCg = jQuery("#jform_addreadme input[type='radio']:checked").val();
	fnEKCCg(addreadme_fnEKCCg);

});
jQuery('#adminForm').on('change', '#jform_addreadme',function (e)
{
	e.preventDefault();
	var addreadme_fnEKCCg = jQuery("#jform_addreadme input[type='radio']:checked").val();
	fnEKCCg(addreadme_fnEKCCg);

});

// #jform_add_update_server listeners for add_update_server_dKJKyYg function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_dKJKyYg = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	dKJKyYg(add_update_server_dKJKyYg);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_dKJKyYg = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	dKJKyYg(add_update_server_dKJKyYg);

});

// #jform_add_sales_server listeners for add_sales_server_FWlhVPM function
jQuery('#jform_add_sales_server').on('keyup',function()
{
	var add_sales_server_FWlhVPM = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	FWlhVPM(add_sales_server_FWlhVPM);

});
jQuery('#adminForm').on('change', '#jform_add_sales_server',function (e)
{
	e.preventDefault();
	var add_sales_server_FWlhVPM = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	FWlhVPM(add_sales_server_FWlhVPM);

});

// #jform_add_license listeners for add_license_OCbXDSr function
jQuery('#jform_add_license').on('keyup',function()
{
	var add_license_OCbXDSr = jQuery("#jform_add_license input[type='radio']:checked").val();
	OCbXDSr(add_license_OCbXDSr);

});
jQuery('#adminForm').on('change', '#jform_add_license',function (e)
{
	e.preventDefault();
	var add_license_OCbXDSr = jQuery("#jform_add_license input[type='radio']:checked").val();
	OCbXDSr(add_license_OCbXDSr);

});

// #jform_add_php_dashboard_methods listeners for add_php_dashboard_methods_HiUlIxx function
jQuery('#jform_add_php_dashboard_methods').on('keyup',function()
{
	var add_php_dashboard_methods_HiUlIxx = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	HiUlIxx(add_php_dashboard_methods_HiUlIxx);

});
jQuery('#adminForm').on('change', '#jform_add_php_dashboard_methods',function (e)
{
	e.preventDefault();
	var add_php_dashboard_methods_HiUlIxx = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	HiUlIxx(add_php_dashboard_methods_HiUlIxx);

});



<?php $fieldNrs = range(1,10,1); ?>
<?php foreach($fieldNrs as $nr): ?>jQuery('body').on('change', 'select[name="icomoon-<?php echo $nr; ?>"]',function (e) {
	// update the icon if changed
	var val_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"] option:selected').val();
	var key_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"]').attr('id').split('-');
	var target_<?php echo $nr; ?> = key_<?php echo $nr; ?>[0]+'_'+key_<?php echo $nr; ?>[1]+'_chzn';
	var div_<?php echo $nr; ?> = jQuery('#'+target_<?php echo $nr; ?>);
	// build new span
	var span = '<span id="icon_'+target_<?php echo $nr; ?>+'" class="icon-'+val_<?php echo $nr; ?>+'"></span>';
	// remove old one 
	jQuery('#icon_'+target_<?php echo $nr; ?>).remove();
	// add the new icon
	div_<?php echo $nr; ?>.closest("td").append(span);
});

jQuery(document).ready(function() {
	// get type value
	var val_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"] option:selected').val();
	var key_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"]').attr('id').split('-');
	var target_<?php echo $nr; ?> = key_<?php echo $nr; ?>[0]+'_'+key_<?php echo $nr; ?>[1]+'_chzn';
	var div_<?php echo $nr; ?> = jQuery('#'+target_<?php echo $nr; ?>);
	// build new span
	var span = '<span id="icon_'+target_<?php echo $nr; ?>+'" class="icon-'+val_<?php echo $nr; ?>+'"></span>';
	// remove old one 
	jQuery('#icon_'+target_<?php echo $nr; ?>).remove();
	// add the new icon
	div_<?php echo $nr; ?>.closest("td").append(span);
});
<?php endforeach; ?>
</script>
