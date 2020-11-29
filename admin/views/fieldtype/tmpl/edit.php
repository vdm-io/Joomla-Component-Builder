<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2020 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$componentParams = $this->params; // will be removed just use $this->params instead
?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = jQuery('body');
	jQuery('<div id="loading"></div>')
		.css("background", "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat")
		.css("top", outerDiv.position().top - jQuery(window).scrollTop())
		.css("left", outerDiv.position().left - jQuery(window).scrollLeft())
		.css("width", outerDiv.width())
		.css("height", outerDiv.height())
		.css("position", "fixed")
		.css("opacity", "0.80")
		.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
		.css("filter", "alpha(opacity = 80)")
		.css("display", "none")
		.appendTo(outerDiv);
	jQuery('#loading').show();
	// when page is ready remove and show
	jQuery(window).load(function() {
		jQuery('#componentbuilder_loader').fadeIn('fast');
		jQuery('#loading').hide();
	});
</script>
<div id="componentbuilder_loader" style="display: none;">
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('fieldtype.details_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'fieldtypeTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'details', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('fieldtype.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'database_defaults', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_DATABASE_DEFAULTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.database_defaults_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.database_defaults_right', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('field.access')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'fields', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_FIELDS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('fieldtype.fields_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'fieldtypeTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('fieldtype.edit.state') || ($this->canDo->get('fieldtype.delete') && $this->canDo->get('fieldtype.edit.state'))) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'publishing', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'permissions', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="fieldtype.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_vvvvwdk function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_vvvvwdk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwdk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdk(datalenght_vvvvwdk,has_defaults_vvvvwdk);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwdk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwdk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdk(datalenght_vvvvwdk,has_defaults_vvvvwdk);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdk function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datalenght_vvvvwdk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwdk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdk(datalenght_vvvvwdk,has_defaults_vvvvwdk);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwdk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwdk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdk(datalenght_vvvvwdk,has_defaults_vvvvwdk);

});

// #jform_datadefault listeners for datadefault_vvvvwdm function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_vvvvwdm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwdm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdm(datadefault_vvvvwdm,has_defaults_vvvvwdm);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwdm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwdm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdm(datadefault_vvvvwdm,has_defaults_vvvvwdm);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdm function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datadefault_vvvvwdm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwdm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdm(datadefault_vvvvwdm,has_defaults_vvvvwdm);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwdm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwdm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdm(datadefault_vvvvwdm,has_defaults_vvvvwdm);

});

// #jform_datatype listeners for datatype_vvvvwdo function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwdo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdo(datatype_vvvvwdo,has_defaults_vvvvwdo);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwdo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdo(datatype_vvvvwdo,has_defaults_vvvvwdo);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdo function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwdo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdo(datatype_vvvvwdo,has_defaults_vvvvwdo);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwdo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdo(datatype_vvvvwdo,has_defaults_vvvvwdo);

});

// #jform_datatype listeners for datatype_vvvvwdq function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwdq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdq(datatype_vvvvwdq,has_defaults_vvvvwdq);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwdq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdq(datatype_vvvvwdq,has_defaults_vvvvwdq);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdq function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwdq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdq(datatype_vvvvwdq,has_defaults_vvvvwdq);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwdq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdq(datatype_vvvvwdq,has_defaults_vvvvwdq);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdr function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwdr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwdr = jQuery("#jform_datatype").val();
	vvvvwdr(has_defaults_vvvvwdr,datatype_vvvvwdr);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwdr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwdr = jQuery("#jform_datatype").val();
	vvvvwdr(has_defaults_vvvvwdr,datatype_vvvvwdr);

});

// #jform_datatype listeners for datatype_vvvvwdr function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwdr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwdr = jQuery("#jform_datatype").val();
	vvvvwdr(has_defaults_vvvvwdr,datatype_vvvvwdr);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwdr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwdr = jQuery("#jform_datatype").val();
	vvvvwdr(has_defaults_vvvvwdr,datatype_vvvvwdr);

});

// #jform_datatype listeners for datatype_vvvvwds function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwds = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwds = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwds(datatype_vvvvwds,has_defaults_vvvvwds);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwds = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwds = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwds(datatype_vvvvwds,has_defaults_vvvvwds);

});

// #jform_has_defaults listeners for has_defaults_vvvvwds function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwds = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwds = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwds(datatype_vvvvwds,has_defaults_vvvvwds);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwds = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwds = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwds(datatype_vvvvwds,has_defaults_vvvvwds);

});

// #jform_store listeners for store_vvvvwdu function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwdu = jQuery("#jform_store").val();
	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwdu = jQuery("#jform_store").val();
	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu);

});

// #jform_datatype listeners for datatype_vvvvwdu function
jQuery('#jform_datatype').on('keyup',function()
{
	var store_vvvvwdu = jQuery("#jform_store").val();
	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var store_vvvvwdu = jQuery("#jform_store").val();
	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdu function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var store_vvvvwdu = jQuery("#jform_store").val();
	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var store_vvvvwdu = jQuery("#jform_store").val();
	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu);

});

// #jform_datatype listeners for datatype_vvvvwdv function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var store_vvvvwdv = jQuery("#jform_store").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var store_vvvvwdv = jQuery("#jform_store").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv);

});

// #jform_store listeners for store_vvvvwdv function
jQuery('#jform_store').on('keyup',function()
{
	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var store_vvvvwdv = jQuery("#jform_store").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var store_vvvvwdv = jQuery("#jform_store").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdv function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var store_vvvvwdv = jQuery("#jform_store").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var store_vvvvwdv = jQuery("#jform_store").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdw function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw);

});

// #jform_store listeners for store_vvvvwdw function
jQuery('#jform_store').on('keyup',function()
{
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw);

});

// #jform_datatype listeners for datatype_vvvvwdw function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw);

});

// #jform_has_defaults listeners for has_defaults_vvvvwdx function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwdx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdx(has_defaults_vvvvwdx);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwdx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdx(has_defaults_vvvvwdx);

});




<?php
	$app = JFactory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'.JURI::root().'";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}
</script>
