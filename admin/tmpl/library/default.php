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

// #jform_how listeners for how_vvvvwan function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwan = jQuery("#jform_how").val();
	var target_vvvvwan = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwan(how_vvvvwan,target_vvvvwan);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwan = jQuery("#jform_how").val();
	var target_vvvvwan = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwan(how_vvvvwan,target_vvvvwan);

});

// #jform_target listeners for target_vvvvwan function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwan = jQuery("#jform_how").val();
	var target_vvvvwan = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwan(how_vvvvwan,target_vvvvwan);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwan = jQuery("#jform_how").val();
	var target_vvvvwan = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwan(how_vvvvwan,target_vvvvwan);

});

// #jform_how listeners for how_vvvvwap function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwap = jQuery("#jform_how").val();
	var target_vvvvwap = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwap(how_vvvvwap,target_vvvvwap);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwap = jQuery("#jform_how").val();
	var target_vvvvwap = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwap(how_vvvvwap,target_vvvvwap);

});

// #jform_target listeners for target_vvvvwap function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwap = jQuery("#jform_how").val();
	var target_vvvvwap = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwap(how_vvvvwap,target_vvvvwap);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwap = jQuery("#jform_how").val();
	var target_vvvvwap = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwap(how_vvvvwap,target_vvvvwap);

});

// #jform_how listeners for how_vvvvwar function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwar = jQuery("#jform_how").val();
	var target_vvvvwar = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwar(how_vvvvwar,target_vvvvwar);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwar = jQuery("#jform_how").val();
	var target_vvvvwar = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwar(how_vvvvwar,target_vvvvwar);

});

// #jform_target listeners for target_vvvvwar function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwar = jQuery("#jform_how").val();
	var target_vvvvwar = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwar(how_vvvvwar,target_vvvvwar);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwar = jQuery("#jform_how").val();
	var target_vvvvwar = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwar(how_vvvvwar,target_vvvvwar);

});

// #jform_how listeners for how_vvvvwat function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwat = jQuery("#jform_how").val();
	var target_vvvvwat = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwat(how_vvvvwat,target_vvvvwat);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwat = jQuery("#jform_how").val();
	var target_vvvvwat = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwat(how_vvvvwat,target_vvvvwat);

});

// #jform_target listeners for target_vvvvwat function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwat = jQuery("#jform_how").val();
	var target_vvvvwat = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwat(how_vvvvwat,target_vvvvwat);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwat = jQuery("#jform_how").val();
	var target_vvvvwat = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwat(how_vvvvwat,target_vvvvwat);

});

// #jform_how listeners for how_vvvvwav function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwav = jQuery("#jform_how").val();
	var target_vvvvwav = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwav(how_vvvvwav,target_vvvvwav);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwav = jQuery("#jform_how").val();
	var target_vvvvwav = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwav(how_vvvvwav,target_vvvvwav);

});

// #jform_target listeners for target_vvvvwav function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwav = jQuery("#jform_how").val();
	var target_vvvvwav = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwav(how_vvvvwav,target_vvvvwav);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwav = jQuery("#jform_how").val();
	var target_vvvvwav = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwav(how_vvvvwav,target_vvvvwav);

});

// #jform_target listeners for target_vvvvwaw function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwaw = jQuery("#jform_how").val();
	vvvvwaw(target_vvvvwaw,how_vvvvwaw);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwaw = jQuery("#jform_how").val();
	vvvvwaw(target_vvvvwaw,how_vvvvwaw);

});

// #jform_how listeners for how_vvvvwaw function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwaw = jQuery("#jform_how").val();
	vvvvwaw(target_vvvvwaw,how_vvvvwaw);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwaw = jQuery("#jform_how").val();
	vvvvwaw(target_vvvvwaw,how_vvvvwaw);

});

// #jform_how listeners for how_vvvvwax function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwax = jQuery("#jform_how").val();
	var target_vvvvwax = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwax(how_vvvvwax,target_vvvvwax);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwax = jQuery("#jform_how").val();
	var target_vvvvwax = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwax(how_vvvvwax,target_vvvvwax);

});

// #jform_target listeners for target_vvvvwax function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwax = jQuery("#jform_how").val();
	var target_vvvvwax = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwax(how_vvvvwax,target_vvvvwax);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwax = jQuery("#jform_how").val();
	var target_vvvvwax = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwax(how_vvvvwax,target_vvvvwax);

});

// #jform_target listeners for target_vvvvway function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvway = jQuery("#jform_how").val();
	vvvvway(target_vvvvway,how_vvvvway);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvway = jQuery("#jform_how").val();
	vvvvway(target_vvvvway,how_vvvvway);

});

// #jform_how listeners for how_vvvvway function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvway = jQuery("#jform_how").val();
	vvvvway(target_vvvvway,how_vvvvway);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvway = jQuery("#jform_how").val();
	vvvvway(target_vvvvway,how_vvvvway);

});

// #jform_how listeners for how_vvvvwaz function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwaz = jQuery("#jform_how").val();
	var target_vvvvwaz = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaz(how_vvvvwaz,target_vvvvwaz);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwaz = jQuery("#jform_how").val();
	var target_vvvvwaz = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaz(how_vvvvwaz,target_vvvvwaz);

});

// #jform_target listeners for target_vvvvwaz function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwaz = jQuery("#jform_how").val();
	var target_vvvvwaz = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaz(how_vvvvwaz,target_vvvvwaz);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwaz = jQuery("#jform_how").val();
	var target_vvvvwaz = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaz(how_vvvvwaz,target_vvvvwaz);

});

// #jform_target listeners for target_vvvvwba function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwba = jQuery("#jform_how").val();
	vvvvwba(target_vvvvwba,how_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwba = jQuery("#jform_how").val();
	vvvvwba(target_vvvvwba,how_vvvvwba);

});

// #jform_how listeners for how_vvvvwba function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwba = jQuery("#jform_how").val();
	vvvvwba(target_vvvvwba,how_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwba = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwba = jQuery("#jform_how").val();
	vvvvwba(target_vvvvwba,how_vvvvwba);

});

// #jform_target listeners for target_vvvvwbb function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbb = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbb(target_vvvvwbb,type_vvvvwbb);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbb = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbb(target_vvvvwbb,type_vvvvwbb);

});

// #jform_type listeners for type_vvvvwbb function
jQuery('#jform_type').on('keyup',function()
{
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbb = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbb(target_vvvvwbb,type_vvvvwbb);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbb = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbb(target_vvvvwbb,type_vvvvwbb);

});

// #jform_target listeners for target_vvvvwbd function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbd = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbd(target_vvvvwbd);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbd = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbd(target_vvvvwbd);

});

// #jform_target listeners for target_vvvvwbe function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwbe = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbe(target_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwbe = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbe(target_vvvvwbe);

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
