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

<?php echo LayoutHelper::render('help_document.details_above', $this); ?>
<div class="main-card">

	<?php echo Html::_('uitab.startTabSet', 'help_documentTab', ['active' => 'details', 'recall' => true]); ?>

	<?php echo Html::_('uitab.addTab', 'help_documentTab', 'details', Text::_('COM_COMPONENTBUILDER_HELP_DOCUMENT_DETAILS', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('help_document.details_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('help_document.details_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('help_document.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'help_documentTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('help_document.edit.state') || ($this->canDo->get('help_document.delete') && $this->canDo->get('help_document.edit.state'))) : ?>
	<?php echo Html::_('uitab.addTab', 'help_documentTab', 'publishing', Text::_('COM_COMPONENTBUILDER_HELP_DOCUMENT_PUBLISHING', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('help_document.publishing', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('help_document.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php echo Html::_('uitab.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="help_document.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('help_document.details_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_location listeners for location_vvvvwco function
jQuery('#jform_location').on('keyup',function()
{
	var location_vvvvwco = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwco(location_vvvvwco);

});
jQuery('#adminForm').on('change', '#jform_location',function (e)
{
	e.preventDefault();
	var location_vvvvwco = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwco(location_vvvvwco);

});

// #jform_location listeners for location_vvvvwcp function
jQuery('#jform_location').on('keyup',function()
{
	var location_vvvvwcp = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcp(location_vvvvwcp);

});
jQuery('#adminForm').on('change', '#jform_location',function (e)
{
	e.preventDefault();
	var location_vvvvwcp = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcp(location_vvvvwcp);

});

// #jform_type listeners for type_vvvvwcq function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvwcq = jQuery("#jform_type").val();
	vvvvwcq(type_vvvvwcq);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvwcq = jQuery("#jform_type").val();
	vvvvwcq(type_vvvvwcq);

});

// #jform_type listeners for type_vvvvwcr function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvwcr = jQuery("#jform_type").val();
	vvvvwcr(type_vvvvwcr);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvwcr = jQuery("#jform_type").val();
	vvvvwcr(type_vvvvwcr);

});

// #jform_type listeners for type_vvvvwcs function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvwcs = jQuery("#jform_type").val();
	vvvvwcs(type_vvvvwcs);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvwcs = jQuery("#jform_type").val();
	vvvvwcs(type_vvvvwcs);

});

// #jform_target listeners for target_vvvvwct function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(target_vvvvwct);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(target_vvvvwct);

});

</script>
