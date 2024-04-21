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

?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = document.querySelector('body');
	var loadingDiv = document.createElement('div');
	loadingDiv.id = 'loading';
	loadingDiv.style.cssText = "background: rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat; top: " + (outerDiv.getBoundingClientRect().top + window.pageYOffset) + "px; left: " + (outerDiv.getBoundingClientRect().left + window.pageXOffset) + "px; width: " + outerDiv.offsetWidth + "px; height: " + outerDiv.offsetHeight + "px; position: fixed; opacity: 0.80; -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80); filter: alpha(opacity=80); display: none;";
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
<form action="<?php echo Route::_('index.php?option=com_componentbuilder&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

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

	<?php if ($this->canDo->get('joomla_component.access')) : ?>
	<?php echo Html::_('uitab.addTab', 'serverTab', 'linked_components', Text::_('COM_COMPONENTBUILDER_SERVER_LINKED_COMPONENTS', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('server.linked_components_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

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
	vvvvwch(protocol_vvvvwch);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwch = jQuery("#jform_protocol").val();
	vvvvwch(protocol_vvvvwch);

});

// #jform_protocol listeners for protocol_vvvvwci function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwci = jQuery("#jform_protocol").val();
	var authentication_vvvvwci = jQuery("#jform_authentication").val();
	vvvvwci(protocol_vvvvwci,authentication_vvvvwci);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwci = jQuery("#jform_protocol").val();
	var authentication_vvvvwci = jQuery("#jform_authentication").val();
	vvvvwci(protocol_vvvvwci,authentication_vvvvwci);

});

// #jform_authentication listeners for authentication_vvvvwci function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwci = jQuery("#jform_protocol").val();
	var authentication_vvvvwci = jQuery("#jform_authentication").val();
	vvvvwci(protocol_vvvvwci,authentication_vvvvwci);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwci = jQuery("#jform_protocol").val();
	var authentication_vvvvwci = jQuery("#jform_authentication").val();
	vvvvwci(protocol_vvvvwci,authentication_vvvvwci);

});

// #jform_protocol listeners for protocol_vvvvwck function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwck = jQuery("#jform_protocol").val();
	var authentication_vvvvwck = jQuery("#jform_authentication").val();
	vvvvwck(protocol_vvvvwck,authentication_vvvvwck);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwck = jQuery("#jform_protocol").val();
	var authentication_vvvvwck = jQuery("#jform_authentication").val();
	vvvvwck(protocol_vvvvwck,authentication_vvvvwck);

});

// #jform_authentication listeners for authentication_vvvvwck function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwck = jQuery("#jform_protocol").val();
	var authentication_vvvvwck = jQuery("#jform_authentication").val();
	vvvvwck(protocol_vvvvwck,authentication_vvvvwck);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwck = jQuery("#jform_protocol").val();
	var authentication_vvvvwck = jQuery("#jform_authentication").val();
	vvvvwck(protocol_vvvvwck,authentication_vvvvwck);

});

// #jform_protocol listeners for protocol_vvvvwcm function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwcm = jQuery("#jform_protocol").val();
	var authentication_vvvvwcm = jQuery("#jform_authentication").val();
	vvvvwcm(protocol_vvvvwcm,authentication_vvvvwcm);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcm = jQuery("#jform_protocol").val();
	var authentication_vvvvwcm = jQuery("#jform_authentication").val();
	vvvvwcm(protocol_vvvvwcm,authentication_vvvvwcm);

});

// #jform_authentication listeners for authentication_vvvvwcm function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwcm = jQuery("#jform_protocol").val();
	var authentication_vvvvwcm = jQuery("#jform_authentication").val();
	vvvvwcm(protocol_vvvvwcm,authentication_vvvvwcm);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcm = jQuery("#jform_protocol").val();
	var authentication_vvvvwcm = jQuery("#jform_authentication").val();
	vvvvwcm(protocol_vvvvwcm,authentication_vvvvwcm);

});

// #jform_protocol listeners for protocol_vvvvwco function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwco = jQuery("#jform_protocol").val();
	var authentication_vvvvwco = jQuery("#jform_authentication").val();
	vvvvwco(protocol_vvvvwco,authentication_vvvvwco);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwco = jQuery("#jform_protocol").val();
	var authentication_vvvvwco = jQuery("#jform_authentication").val();
	vvvvwco(protocol_vvvvwco,authentication_vvvvwco);

});

// #jform_authentication listeners for authentication_vvvvwco function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwco = jQuery("#jform_protocol").val();
	var authentication_vvvvwco = jQuery("#jform_authentication").val();
	vvvvwco(protocol_vvvvwco,authentication_vvvvwco);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwco = jQuery("#jform_protocol").val();
	var authentication_vvvvwco = jQuery("#jform_authentication").val();
	vvvvwco(protocol_vvvvwco,authentication_vvvvwco);

});

</script>
