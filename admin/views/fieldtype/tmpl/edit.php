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

<?php echo LayoutHelper::render('fieldtype.details_above', $this); ?>
<div class="form-horizontal">

	<?php echo Html::_('bootstrap.startTabSet', 'fieldtypeTab', ['active' => 'details', 'recall' => true]); ?>

	<?php echo Html::_('bootstrap.addTab', 'fieldtypeTab', 'details', Text::_('COM_COMPONENTBUILDER_FIELDTYPE_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('fieldtype.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('fieldtype.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('fieldtype.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'fieldtypeTab', 'database_defaults', Text::_('COM_COMPONENTBUILDER_FIELDTYPE_DATABASE_DEFAULTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('fieldtype.database_defaults_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('fieldtype.database_defaults_right', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('field.access')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'fieldtypeTab', 'fields', Text::_('COM_COMPONENTBUILDER_FIELDTYPE_FIELDS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('fieldtype.fields_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'fieldtypeTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('fieldtype.edit.state') || ($this->canDo->get('fieldtype.delete') && $this->canDo->get('fieldtype.edit.state'))) : ?>
	<?php echo Html::_('bootstrap.addTab', 'fieldtypeTab', 'publishing', Text::_('COM_COMPONENTBUILDER_FIELDTYPE_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('fieldtype.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('fieldtype.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'fieldtypeTab', 'permissions', Text::_('COM_COMPONENTBUILDER_FIELDTYPE_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="fieldtype.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_vvvvwbq function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_vvvvwbq = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datalenght_vvvvwbq,has_defaults_vvvvwbq);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwbq = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datalenght_vvvvwbq,has_defaults_vvvvwbq);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbq function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datalenght_vvvvwbq = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datalenght_vvvvwbq,has_defaults_vvvvwbq);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwbq = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datalenght_vvvvwbq,has_defaults_vvvvwbq);

});

// #jform_datadefault listeners for datadefault_vvvvwbs function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_vvvvwbs = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(datadefault_vvvvwbs,has_defaults_vvvvwbs);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbs = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(datadefault_vvvvwbs,has_defaults_vvvvwbs);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbs function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datadefault_vvvvwbs = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(datadefault_vvvvwbs,has_defaults_vvvvwbs);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbs = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(datadefault_vvvvwbs,has_defaults_vvvvwbs);

});

// #jform_datatype listeners for datatype_vvvvwbu function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbu(datatype_vvvvwbu,has_defaults_vvvvwbu);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbu(datatype_vvvvwbu,has_defaults_vvvvwbu);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbu function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbu(datatype_vvvvwbu,has_defaults_vvvvwbu);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbu(datatype_vvvvwbu,has_defaults_vvvvwbu);

});

// #jform_datatype listeners for datatype_vvvvwbw function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbw(datatype_vvvvwbw,has_defaults_vvvvwbw);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbw(datatype_vvvvwbw,has_defaults_vvvvwbw);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbw function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbw(datatype_vvvvwbw,has_defaults_vvvvwbw);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbw(datatype_vvvvwbw,has_defaults_vvvvwbw);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbx function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwbx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbx = jQuery("#jform_datatype").val();
	vvvvwbx(has_defaults_vvvvwbx,datatype_vvvvwbx);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbx = jQuery("#jform_datatype").val();
	vvvvwbx(has_defaults_vvvvwbx,datatype_vvvvwbx);

});

// #jform_datatype listeners for datatype_vvvvwbx function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwbx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbx = jQuery("#jform_datatype").val();
	vvvvwbx(has_defaults_vvvvwbx,datatype_vvvvwbx);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbx = jQuery("#jform_datatype").val();
	vvvvwbx(has_defaults_vvvvwbx,datatype_vvvvwbx);

});

// #jform_datatype listeners for datatype_vvvvwby function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwby = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwby = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwby(datatype_vvvvwby,has_defaults_vvvvwby);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwby = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwby = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwby(datatype_vvvvwby,has_defaults_vvvvwby);

});

// #jform_has_defaults listeners for has_defaults_vvvvwby function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwby = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwby = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwby(datatype_vvvvwby,has_defaults_vvvvwby);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwby = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwby = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwby(datatype_vvvvwby,has_defaults_vvvvwby);

});

// #jform_store listeners for store_vvvvwca function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca);

});

// #jform_datatype listeners for datatype_vvvvwca function
jQuery('#jform_datatype').on('keyup',function()
{
	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca);

});

// #jform_has_defaults listeners for has_defaults_vvvvwca function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca);

});

// #jform_datatype listeners for datatype_vvvvwcb function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var store_vvvvwcb = jQuery("#jform_store").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var store_vvvvwcb = jQuery("#jform_store").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb);

});

// #jform_store listeners for store_vvvvwcb function
jQuery('#jform_store').on('keyup',function()
{
	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var store_vvvvwcb = jQuery("#jform_store").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var store_vvvvwcb = jQuery("#jform_store").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb);

});

// #jform_has_defaults listeners for has_defaults_vvvvwcb function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var store_vvvvwcb = jQuery("#jform_store").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var store_vvvvwcb = jQuery("#jform_store").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb);

});

// #jform_has_defaults listeners for has_defaults_vvvvwcc function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc);

});

// #jform_store listeners for store_vvvvwcc function
jQuery('#jform_store').on('keyup',function()
{
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc);

});

// #jform_datatype listeners for datatype_vvvvwcc function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc);

});

// #jform_has_defaults listeners for has_defaults_vvvvwcd function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwcd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcd(has_defaults_vvvvwcd);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwcd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcd(has_defaults_vvvvwcd);

});




<?php
	$app = Factory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'. \Joomla\CMS\Uri\Uri::root() . '";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}
</script>
