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

<?php echo LayoutHelper::render('library.behaviour_above', $this); ?>
<div class="form-horizontal">

	<?php echo Html::_('bootstrap.startTabSet', 'libraryTab', ['active' => 'behaviour', 'recall' => true]); ?>

	<?php echo Html::_('bootstrap.addTab', 'libraryTab', 'behaviour', Text::_('COM_COMPONENTBUILDER_LIBRARY_BEHAVIOUR', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('library.behaviour_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('library.behaviour_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('library.behaviour_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'libraryTab', 'files_folders_urls', Text::_('COM_COMPONENTBUILDER_LIBRARY_FILES_FOLDERS_URLS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('library.files_folders_urls_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'libraryTab', 'config', Text::_('COM_COMPONENTBUILDER_LIBRARY_CONFIG', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('library.config_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'libraryTab', 'linked', Text::_('COM_COMPONENTBUILDER_LIBRARY_LINKED', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('library.linked_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'libraryTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('library.edit.state') || ($this->canDo->get('library.delete') && $this->canDo->get('library.edit.state'))) : ?>
	<?php echo Html::_('bootstrap.addTab', 'libraryTab', 'publishing', Text::_('COM_COMPONENTBUILDER_LIBRARY_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('library.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('library.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'libraryTab', 'permissions', Text::_('COM_COMPONENTBUILDER_LIBRARY_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="library.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('library.behaviour_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_how listeners for how_vvvvwch function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});

// #jform_target listeners for target_vvvvwch function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

});

// #jform_how listeners for how_vvvvwcj function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});

// #jform_target listeners for target_vvvvwcj function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

});

// #jform_how listeners for how_vvvvwcl function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});

// #jform_target listeners for target_vvvvwcl function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

});

// #jform_how listeners for how_vvvvwcn function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});

// #jform_target listeners for target_vvvvwcn function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

});

// #jform_how listeners for how_vvvvwcp function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});

// #jform_target listeners for target_vvvvwcp function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

});

// #jform_target listeners for target_vvvvwcq function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});

// #jform_how listeners for how_vvvvwcq function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

});

// #jform_how listeners for how_vvvvwcr function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});

// #jform_target listeners for target_vvvvwcr function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

});

// #jform_target listeners for target_vvvvwcs function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});

// #jform_how listeners for how_vvvvwcs function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

});

// #jform_how listeners for how_vvvvwct function
jQuery('#jform_how').on('keyup',function()
{
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});

// #jform_target listeners for target_vvvvwct function
jQuery('#jform_target').on('keyup',function()
{
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

});

// #jform_target listeners for target_vvvvwcu function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});

// #jform_how listeners for how_vvvvwcu function
jQuery('#jform_how').on('keyup',function()
{
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});
jQuery('#adminForm').on('change', '#jform_how',function (e)
{
	e.preventDefault();
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

});

// #jform_target listeners for target_vvvvwcv function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});

// #jform_type listeners for type_vvvvwcv function
jQuery('#jform_type').on('keyup',function()
{
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

});

// #jform_target listeners for target_vvvvwcx function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcx = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcx(target_vvvvwcx);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcx = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcx(target_vvvvwcx);

});

// #jform_target listeners for target_vvvvwcy function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwcy = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcy(target_vvvvwcy);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwcy = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcy(target_vvvvwcy);

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
		echo 'var url = "'. \Joomla\CMS\Uri\Uri::root() . '";';
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
