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

	<?php if ($this->canDo->get('joomla_component.access')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'serverTab', 'linked_components', Text::_('COM_COMPONENTBUILDER_SERVER_LINKED_COMPONENTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('server.linked_components_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

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

// #jform_protocol listeners for protocol_vvvvwdy function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwdy = jQuery("#jform_protocol").val();
	vvvvwdy(protocol_vvvvwdy);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwdy = jQuery("#jform_protocol").val();
	vvvvwdy(protocol_vvvvwdy);

});

// #jform_protocol listeners for protocol_vvvvwdz function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwdz = jQuery("#jform_protocol").val();
	vvvvwdz(protocol_vvvvwdz);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwdz = jQuery("#jform_protocol").val();
	vvvvwdz(protocol_vvvvwdz);

});

// #jform_protocol listeners for protocol_vvvvwea function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	var authentication_vvvvwea = jQuery("#jform_authentication").val();
	vvvvwea(protocol_vvvvwea,authentication_vvvvwea);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	var authentication_vvvvwea = jQuery("#jform_authentication").val();
	vvvvwea(protocol_vvvvwea,authentication_vvvvwea);

});

// #jform_authentication listeners for authentication_vvvvwea function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	var authentication_vvvvwea = jQuery("#jform_authentication").val();
	vvvvwea(protocol_vvvvwea,authentication_vvvvwea);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	var authentication_vvvvwea = jQuery("#jform_authentication").val();
	vvvvwea(protocol_vvvvwea,authentication_vvvvwea);

});

// #jform_protocol listeners for protocol_vvvvwec function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});

// #jform_authentication listeners for authentication_vvvvwec function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});

// #jform_protocol listeners for protocol_vvvvwee function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});

// #jform_authentication listeners for authentication_vvvvwee function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});

// #jform_protocol listeners for protocol_vvvvweg function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});

// #jform_authentication listeners for authentication_vvvvweg function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});

</script>
