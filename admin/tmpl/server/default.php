<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')->useScript('form.validate');
Html::_('bootstrap.tooltip');

// No direct access to this file
defined('_JEXEC') or die;

$layout  = $this->isModal ? 'modal' : 'edit';
$tmpl    = $this->input->get('tmpl');
$tmpl    = $tmpl ? '&tmpl=' . $tmpl : '';
?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = document.querySelector('body');
	var loadingDiv = document.createElement('div');
	loadingDiv.id = 'loading';
	loadingDiv.style.cssText = "background: rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/ajax.gif') 50% 35% no-repeat; top: " + (outerDiv.getBoundingClientRect().top + window.pageYOffset) + "px; left: " + (outerDiv.getBoundingClientRect().left + window.pageXOffset) + "px; width: " + outerDiv.offsetWidth + "px; height: " + outerDiv.offsetHeight + "px; position: fixed; opacity: 0.80; -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80); filter: alpha(opacity=80); display: none;";
	outerDiv.appendChild(loadingDiv);
	loadingDiv.style.display = 'block';
	// when page is ready remove and show
	window.addEventListener('load', function() {
		var componentLoader = document.getElementById('componentbuilder_loader');
		if (componentLoader) componentLoader.style.display = 'block';
		loadingDiv.style.display = 'none';
	});
</script>
<div id="componentbuilder_loader" style="display: none;">
<form action="<?php echo Route::_('index.php?option=com_componentbuilder&&layout=' . $layout . $tmpl . '&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<?php echo LayoutHelper::render('server.details_above', $this); ?>
<div class="main-card">

	<?php echo Html::_('uitab.startTabSet', 'serverTab', ['active' => 'details', 'recall' => true]); ?>

	<?php echo Html::_('uitab.addTab', 'serverTab', 'details', Text::_('COM_COMPONENTBUILDER_SERVER_DETAILS', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('server.details_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('server.details_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('server.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'serverTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('server.edit.created_by') || $this->canDo->get('server.edit.created') || $this->canDo->get('server.edit.state') || ($this->canDo->get('server.delete') && $this->canDo->get('server.edit.state'))) : ?>
	<?php echo Html::_('uitab.addTab', 'serverTab', 'publishing', Text::_('COM_COMPONENTBUILDER_SERVER_PUBLISHING', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('server.publishing', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('server.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('uitab.addTab', 'serverTab', 'permissions', Text::_('COM_COMPONENTBUILDER_SERVER_PERMISSION', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<fieldset id="fieldset-rules" class="options-form">
					<legend><?php echo Text::_('COM_COMPONENTBUILDER_SERVER_PERMISSION'); ?></legend>
					<div>
						<?php echo $this->form->getInput('rules'); ?>
					</div>
				</fieldset>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php echo Html::_('uitab.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="server.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_protocol listeners for protocol_vvvvwcf function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwcf = jQuery("#jform_protocol").val();
	vvvvwcf(protocol_vvvvwcf);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcf = jQuery("#jform_protocol").val();
	vvvvwcf(protocol_vvvvwcf);

});

// #jform_protocol listeners for protocol_vvvvwcg function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwcg = jQuery("#jform_protocol").val();
	vvvvwcg(protocol_vvvvwcg);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcg = jQuery("#jform_protocol").val();
	vvvvwcg(protocol_vvvvwcg);

});

// #jform_protocol listeners for protocol_vvvvwch function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwch = jQuery("#jform_protocol").val();
	var authentication_vvvvwch = jQuery("#jform_authentication").val();
	vvvvwch(protocol_vvvvwch,authentication_vvvvwch);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwch = jQuery("#jform_protocol").val();
	var authentication_vvvvwch = jQuery("#jform_authentication").val();
	vvvvwch(protocol_vvvvwch,authentication_vvvvwch);

});

// #jform_authentication listeners for authentication_vvvvwch function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwch = jQuery("#jform_protocol").val();
	var authentication_vvvvwch = jQuery("#jform_authentication").val();
	vvvvwch(protocol_vvvvwch,authentication_vvvvwch);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwch = jQuery("#jform_protocol").val();
	var authentication_vvvvwch = jQuery("#jform_authentication").val();
	vvvvwch(protocol_vvvvwch,authentication_vvvvwch);

});

// #jform_protocol listeners for protocol_vvvvwcj function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwcj = jQuery("#jform_protocol").val();
	var authentication_vvvvwcj = jQuery("#jform_authentication").val();
	vvvvwcj(protocol_vvvvwcj,authentication_vvvvwcj);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcj = jQuery("#jform_protocol").val();
	var authentication_vvvvwcj = jQuery("#jform_authentication").val();
	vvvvwcj(protocol_vvvvwcj,authentication_vvvvwcj);

});

// #jform_authentication listeners for authentication_vvvvwcj function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwcj = jQuery("#jform_protocol").val();
	var authentication_vvvvwcj = jQuery("#jform_authentication").val();
	vvvvwcj(protocol_vvvvwcj,authentication_vvvvwcj);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcj = jQuery("#jform_protocol").val();
	var authentication_vvvvwcj = jQuery("#jform_authentication").val();
	vvvvwcj(protocol_vvvvwcj,authentication_vvvvwcj);

});

// #jform_protocol listeners for protocol_vvvvwcl function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwcl = jQuery("#jform_protocol").val();
	var authentication_vvvvwcl = jQuery("#jform_authentication").val();
	vvvvwcl(protocol_vvvvwcl,authentication_vvvvwcl);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcl = jQuery("#jform_protocol").val();
	var authentication_vvvvwcl = jQuery("#jform_authentication").val();
	vvvvwcl(protocol_vvvvwcl,authentication_vvvvwcl);

});

// #jform_authentication listeners for authentication_vvvvwcl function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwcl = jQuery("#jform_protocol").val();
	var authentication_vvvvwcl = jQuery("#jform_authentication").val();
	vvvvwcl(protocol_vvvvwcl,authentication_vvvvwcl);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcl = jQuery("#jform_protocol").val();
	var authentication_vvvvwcl = jQuery("#jform_authentication").val();
	vvvvwcl(protocol_vvvvwcl,authentication_vvvvwcl);

});

// #jform_protocol listeners for protocol_vvvvwcn function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwcn = jQuery("#jform_protocol").val();
	var authentication_vvvvwcn = jQuery("#jform_authentication").val();
	vvvvwcn(protocol_vvvvwcn,authentication_vvvvwcn);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcn = jQuery("#jform_protocol").val();
	var authentication_vvvvwcn = jQuery("#jform_authentication").val();
	vvvvwcn(protocol_vvvvwcn,authentication_vvvvwcn);

});

// #jform_authentication listeners for authentication_vvvvwcn function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwcn = jQuery("#jform_protocol").val();
	var authentication_vvvvwcn = jQuery("#jform_authentication").val();
	vvvvwcn(protocol_vvvvwcn,authentication_vvvvwcn);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcn = jQuery("#jform_protocol").val();
	var authentication_vvvvwcn = jQuery("#jform_authentication").val();
	vvvvwcn(protocol_vvvvwcn,authentication_vvvvwcn);

});

</script>
