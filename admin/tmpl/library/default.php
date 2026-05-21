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

$layout  = $this->isModal ? 'modal' : 'edit';
$tmpl    = $this->input->get('tmpl');
$tmpl    = $tmpl ? '&tmpl=' . $tmpl : '';
?>
<script type="text/javascript">
	(function() {
		// create loading overlay
		var loadingDiv = document.createElement('div');
		loadingDiv.id = 'loading';
		loadingDiv.style.position = 'fixed';
		loadingDiv.style.top = '0';
		loadingDiv.style.left = '0';
		loadingDiv.style.right = '0';
		loadingDiv.style.bottom = '0';
		loadingDiv.style.width = '100%';
		loadingDiv.style.height = '100%';
		loadingDiv.style.background = "rgba(255,255,255,0.8) url('components/com_componentbuilder/assets/images/ajax.gif') 50% 35% no-repeat";
		loadingDiv.style.opacity = '0.8';
		loadingDiv.style.zIndex = '9999';
		loadingDiv.style.display = 'block';
		loadingDiv.style.msFilter = "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
		loadingDiv.style.filter = "alpha(opacity=80)";
		document.body.appendChild(loadingDiv);
		// remove overlay when page fully loaded
		window.addEventListener('load', function() {
			var componentLoader = document.getElementById('componentbuilder_loader');
			if (componentLoader) componentLoader.style.display = 'block';
			loadingDiv.style.display = 'none';
		});
	})();
</script>
<div id="componentbuilder_loader" style="display: none;">
<form action="<?php echo Route::_('index.php?option=com_componentbuilder&view=library&layout=' . $layout . $tmpl . '&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<?php echo LayoutHelper::render('library.behaviour_above', $this); ?>
<div class="main-card">

	<?php echo Html::_('uitab.startTabSet', 'libraryTab', ['active' => 'behaviour', 'recall' => true]); ?>

	<?php echo Html::_('uitab.addTab', 'libraryTab', 'behaviour', Text::_('COM_COMPONENTBUILDER_LIBRARY_BEHAVIOUR', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('library.behaviour_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('library.behaviour_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('library.behaviour_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'libraryTab', 'files_folders_urls', Text::_('COM_COMPONENTBUILDER_LIBRARY_FILES_FOLDERS_URLS', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('library.files_folders_urls_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'libraryTab', 'config', Text::_('COM_COMPONENTBUILDER_LIBRARY_CONFIG', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('library.config_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'libraryTab', 'linked', Text::_('COM_COMPONENTBUILDER_LIBRARY_LINKED', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('library.linked_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'libraryTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('library.edit.state') || ($this->canDo->get('library.delete') && $this->canDo->get('library.edit.state'))) : ?>
	<?php echo Html::_('uitab.addTab', 'libraryTab', 'publishing', Text::_('COM_COMPONENTBUILDER_LIBRARY_PUBLISHING', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('library.publishing', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('library.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('uitab.addTab', 'libraryTab', 'permissions', Text::_('COM_COMPONENTBUILDER_LIBRARY_PERMISSION', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<fieldset id="fieldset-rules" class="options-form">
					<legend><?php echo Text::_('COM_COMPONENTBUILDER_LIBRARY_PERMISSION'); ?></legend>
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
		<input type="hidden" name="task" value="library.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('library.behaviour_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_how listeners for how_vvvvwas function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwas = jQuery("#jform_how").val();
	var target_vvvvwas = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwas(how_vvvvwas,target_vvvvwas);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwas = jQuery("#jform_how").val();
	var target_vvvvwas = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwas(how_vvvvwas,target_vvvvwas);

});

// #jform_target listeners for target_vvvvwas function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwas = jQuery("#jform_how").val();
	var target_vvvvwas = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwas(how_vvvvwas,target_vvvvwas);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwas = jQuery("#jform_how").val();
	var target_vvvvwas = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwas(how_vvvvwas,target_vvvvwas);

});

// #jform_how listeners for how_vvvvwau function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwau = jQuery("#jform_how").val();
	var target_vvvvwau = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwau(how_vvvvwau,target_vvvvwau);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwau = jQuery("#jform_how").val();
	var target_vvvvwau = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwau(how_vvvvwau,target_vvvvwau);

});

// #jform_target listeners for target_vvvvwau function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwau = jQuery("#jform_how").val();
	var target_vvvvwau = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwau(how_vvvvwau,target_vvvvwau);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwau = jQuery("#jform_how").val();
	var target_vvvvwau = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwau(how_vvvvwau,target_vvvvwau);

});

// #jform_how listeners for how_vvvvwaw function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwaw = jQuery("#jform_how").val();
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaw(how_vvvvwaw,target_vvvvwaw);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwaw = jQuery("#jform_how").val();
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaw(how_vvvvwaw,target_vvvvwaw);

});

// #jform_target listeners for target_vvvvwaw function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwaw = jQuery("#jform_how").val();
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaw(how_vvvvwaw,target_vvvvwaw);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwaw = jQuery("#jform_how").val();
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaw(how_vvvvwaw,target_vvvvwaw);

});

// #jform_how listeners for how_vvvvway function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvway = jQuery("#jform_how").val();
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvway(how_vvvvway,target_vvvvway);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvway = jQuery("#jform_how").val();
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvway(how_vvvvway,target_vvvvway);

});

// #jform_target listeners for target_vvvvway function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvway = jQuery("#jform_how").val();
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvway(how_vvvvway,target_vvvvway);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvway = jQuery("#jform_how").val();
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvway(how_vvvvway,target_vvvvway);

});

// #jform_how listeners for how_vvvvwba function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwba = jQuery("#jform_how").val();
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwba(how_vvvvwba,target_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwba = jQuery("#jform_how").val();
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwba(how_vvvvwba,target_vvvvwba);

});

// #jform_target listeners for target_vvvvwba function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwba = jQuery("#jform_how").val();
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwba(how_vvvvwba,target_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwba = jQuery("#jform_how").val();
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwba(how_vvvvwba,target_vvvvwba);

});

// #jform_target listeners for target_vvvvwbb function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbb = jQuery("#jform_how").val();
	vvvvwbb(target_vvvvwbb,how_vvvvwbb);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbb = jQuery("#jform_how").val();
	vvvvwbb(target_vvvvwbb,how_vvvvwbb);

});

// #jform_how listeners for how_vvvvwbb function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbb = jQuery("#jform_how").val();
	vvvvwbb(target_vvvvwbb,how_vvvvwbb);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbb = jQuery("#jform_how").val();
	vvvvwbb(target_vvvvwbb,how_vvvvwbb);

});

// #jform_how listeners for how_vvvvwbc function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwbc = jQuery("#jform_how").val();
	var target_vvvvwbc = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbc(how_vvvvwbc,target_vvvvwbc);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwbc = jQuery("#jform_how").val();
	var target_vvvvwbc = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbc(how_vvvvwbc,target_vvvvwbc);

});

// #jform_target listeners for target_vvvvwbc function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwbc = jQuery("#jform_how").val();
	var target_vvvvwbc = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbc(how_vvvvwbc,target_vvvvwbc);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwbc = jQuery("#jform_how").val();
	var target_vvvvwbc = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbc(how_vvvvwbc,target_vvvvwbc);

});

// #jform_target listeners for target_vvvvwbd function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbd = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbd = jQuery("#jform_how").val();
	vvvvwbd(target_vvvvwbd,how_vvvvwbd);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbd = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbd = jQuery("#jform_how").val();
	vvvvwbd(target_vvvvwbd,how_vvvvwbd);

});

// #jform_how listeners for how_vvvvwbd function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwbd = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbd = jQuery("#jform_how").val();
	vvvvwbd(target_vvvvwbd,how_vvvvwbd);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwbd = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbd = jQuery("#jform_how").val();
	vvvvwbd(target_vvvvwbd,how_vvvvwbd);

});

// #jform_how listeners for how_vvvvwbe function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwbe = jQuery("#jform_how").val();
	var target_vvvvwbe = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbe(how_vvvvwbe,target_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwbe = jQuery("#jform_how").val();
	var target_vvvvwbe = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbe(how_vvvvwbe,target_vvvvwbe);

});

// #jform_target listeners for target_vvvvwbe function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwbe = jQuery("#jform_how").val();
	var target_vvvvwbe = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbe(how_vvvvwbe,target_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwbe = jQuery("#jform_how").val();
	var target_vvvvwbe = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbe(how_vvvvwbe,target_vvvvwbe);

});

// #jform_target listeners for target_vvvvwbf function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbf = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbf = jQuery("#jform_how").val();
	vvvvwbf(target_vvvvwbf,how_vvvvwbf);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbf = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbf = jQuery("#jform_how").val();
	vvvvwbf(target_vvvvwbf,how_vvvvwbf);

});

// #jform_how listeners for how_vvvvwbf function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwbf = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbf = jQuery("#jform_how").val();
	vvvvwbf(target_vvvvwbf,how_vvvvwbf);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwbf = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbf = jQuery("#jform_how").val();
	vvvvwbf(target_vvvvwbf,how_vvvvwbf);

});

// #jform_target listeners for target_vvvvwbg function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbg = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbg = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbg(target_vvvvwbg,type_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbg = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbg = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbg(target_vvvvwbg,type_vvvvwbg);

});

// #jform_type listeners for type_vvvvwbg function
jQuery('#jform_type').on('keyup',function()
{
	var target_vvvvwbg = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbg = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbg(target_vvvvwbg,type_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var target_vvvvwbg = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbg = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbg(target_vvvvwbg,type_vvvvwbg);

});

// #jform_target listeners for target_vvvvwbi function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbi = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbi(target_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbi = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbi(target_vvvvwbi);

});

// #jform_target listeners for target_vvvvwbj function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbj(target_vvvvwbj);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbj(target_vvvvwbj);

});



<?php $numberAddconditions = range(0, count( (array) $this->item->addconditions) + 3, 1);?>

// for the values already set
jQuery(document).ready(function(){
<?php foreach($numberAddconditions as $fieldNr): ?>
	jQuery('#adminForm').on('change', '#jform_addconditions__addconditions<?php echo $fieldNr ?>__option_field',function (e) {
		e.preventDefault();
		getFieldSelectOptions(<?php echo $fieldNr ?>);
	});
<?php endforeach; ?>
	jQuery(document).on('subform-row-add', function(event, row){
		var groupName = jQuery(row).data('group');
		var fieldName = groupName.replace(/([0-9])/g, '');
		var fieldNr = groupName.replace(/([A-z_])/g, '');
		if ('addconditions' === fieldName) {
			jQuery('#adminForm').on('change', '#jform_addconditions__addconditions'+fieldNr+'__option_field',function (e) {
				e.preventDefault();
				getFieldSelectOptions(fieldNr);
			});
		}
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
</script>
