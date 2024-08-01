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
use Joomla\CMS\Uri\Uri;

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

<?php echo LayoutHelper::render('custom_code.details_above', $this); ?>
<div class="main-card">

	<?php echo Html::_('uitab.startTabSet', 'custom_codeTab', ['active' => 'details', 'recall' => true]); ?>

	<?php echo Html::_('uitab.addTab', 'custom_codeTab', 'details', Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_DETAILS', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('custom_code.details_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('custom_code.details_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('custom_code.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'custom_codeTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('custom_code.edit.created_by') || $this->canDo->get('custom_code.edit.created') || $this->canDo->get('custom_code.edit.state') || ($this->canDo->get('custom_code.delete') && $this->canDo->get('custom_code.edit.state'))) : ?>
	<?php echo Html::_('uitab.addTab', 'custom_codeTab', 'publishing', Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PUBLISHING', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('custom_code.publishing', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('custom_code.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('uitab.addTab', 'custom_codeTab', 'permissions', Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PERMISSION', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<fieldset id="fieldset-rules" class="options-form">
					<legend><?php echo Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PERMISSION'); ?></legend>
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
		<input type="hidden" name="task" value="custom_code.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('custom_code.details_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_target listeners for target_vvvvwah function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwah = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwah(target_vvvvwah);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwah = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwah(target_vvvvwah);

});

// #jform_target listeners for target_vvvvwai function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwai = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwai(target_vvvvwai);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwai = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwai(target_vvvvwai);

});

// #jform_target listeners for target_vvvvwaj function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwaj = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwaj = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwaj(target_vvvvwaj,type_vvvvwaj);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwaj = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwaj = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwaj(target_vvvvwaj,type_vvvvwaj);

});

// #jform_type listeners for type_vvvvwaj function
jQuery('#jform_type').on('keyup',function()
{
	var target_vvvvwaj = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwaj = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwaj(target_vvvvwaj,type_vvvvwaj);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var target_vvvvwaj = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwaj = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwaj(target_vvvvwaj,type_vvvvwaj);

});

// #jform_type listeners for type_vvvvwak function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvwak = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvwak = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwak(type_vvvvwak,target_vvvvwak);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvwak = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvwak = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwak(type_vvvvwak,target_vvvvwak);

});

// #jform_target listeners for target_vvvvwak function
jQuery('#jform_target').on('keyup',function()
{
	var type_vvvvwak = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvwak = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwak(type_vvvvwak,target_vvvvwak);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var type_vvvvwak = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvwak = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwak(type_vvvvwak,target_vvvvwak);

});



jQuery('#adminForm').on('change', '#jform_function_name',function (e)
{
	e.preventDefault();
	var target = jQuery("#jform_target input[type='radio']:checked").val();
	if (target == 2) {
		jQuery('#usedin').show();
		var functioName = jQuery('#jform_function_name').val();
		// check if this function name is taken
		checkFunctionName(functioName);
	} else {
		jQuery('#usedin').hide();
	}
});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target = jQuery("#jform_target input[type='radio']:checked").val();
	if (target == 2) {
		jQuery('#usedin').show();
		var functioName = jQuery('#jform_function_name').val();
		// check if this function name is taken
		checkFunctionName(functioName);
	} else {
		jQuery('#usedin').hide();
	}
});
jQuery('#adminForm').on('change', '#jform_comment_type',function (e)
{
	e.preventDefault();
	var type = jQuery("#jform_comment_type input[type='radio']:checked").val();
	if (type == 2) {
		jQuery('#html-comment-info').show();
		jQuery('#phpjs-comment-info').hide();
	} else {
		jQuery('#html-comment-info').hide();
		jQuery('#phpjs-comment-info').show();
	}
});

document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll(".loading-dots").forEach(function(loading_dots) {
		let x = 0;
		let intervalId = setInterval(function() {
			if (!loading_dots.classList.contains("loading-dots")) {
				clearInterval(intervalId);
				return;
			}
			let dots = ".".repeat(x % 8);
			loading_dots.textContent = dots;
			x++;
		}, 500);
	});
});

<?php
	$app = Factory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'. Uri::root() . '";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}
</script>
