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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
Html::addIncludePath(JPATH_COMPONENT.'/helpers/html');
Html::_('behavior.formvalidator');
Html::_('formbehavior.chosen', 'select');
Html::_('behavior.keepalive');

$componentParams = $this->params; // will be removed just use $this->params instead
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
<div class="form-horizontal">

	<?php echo Html::_('bootstrap.startTabSet', 'serverTab', ['active' => 'details', 'recall' => true]); ?>

	<?php echo Html::_('bootstrap.addTab', 'serverTab', 'details', Text::_('COM_COMPONENTBUILDER_SERVER_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('server.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('server.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('server.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'serverTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('server.edit.created_by') || $this->canDo->get('server.edit.created') || $this->canDo->get('server.edit.state') || ($this->canDo->get('server.delete') && $this->canDo->get('server.edit.state'))) : ?>
	<?php echo Html::_('bootstrap.addTab', 'serverTab', 'publishing', Text::_('COM_COMPONENTBUILDER_SERVER_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('server.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('server.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'serverTab', 'permissions', Text::_('COM_COMPONENTBUILDER_SERVER_PERMISSION', true)); ?>
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
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo Html::_('bootstrap.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="server.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_protocol listeners for protocol_vvvvwce function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	vvvvwce(protocol_vvvvwce);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	vvvvwce(protocol_vvvvwce);

});

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
	var authentication_vvvvwcg = jQuery("#jform_authentication").val();
	vvvvwcg(protocol_vvvvwcg,authentication_vvvvwcg);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcg = jQuery("#jform_protocol").val();
	var authentication_vvvvwcg = jQuery("#jform_authentication").val();
	vvvvwcg(protocol_vvvvwcg,authentication_vvvvwcg);

});

// #jform_authentication listeners for authentication_vvvvwcg function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwcg = jQuery("#jform_protocol").val();
	var authentication_vvvvwcg = jQuery("#jform_authentication").val();
	vvvvwcg(protocol_vvvvwcg,authentication_vvvvwcg);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcg = jQuery("#jform_protocol").val();
	var authentication_vvvvwcg = jQuery("#jform_authentication").val();
	vvvvwcg(protocol_vvvvwcg,authentication_vvvvwcg);

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

</script>
