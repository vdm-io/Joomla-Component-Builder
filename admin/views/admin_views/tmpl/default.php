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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
Html::_('behavior.multiselect');
Html::_('dropdown.init');
Html::_('formbehavior.chosen', 'select');
Html::_('formbehavior.chosen', '.multipleAdminviewsfiltertype', null, ['placeholder_text_multiple' => '- ' . Text::_('COM_COMPONENTBUILDER_FILTER_SELECT_TYPE') . ' -']);
Html::_('formbehavior.chosen', '.multipleAccessLevels', null, ['placeholder_text_multiple' => '- ' . Text::_('COM_COMPONENTBUILDER_FILTER_SELECT_ACCESS') . ' -']);

if ($this->saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_componentbuilder&task=admin_views.saveOrderAjax&tmpl=component';
	Html::_('sortablelist.sortable', 'admin_viewList', 'adminForm', strtolower($this->listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo Route::_('index.php?option=com_componentbuilder&view=admin_views'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif; ?>
<?php
	// Add the trash helper layout
	echo LayoutHelper::render('trashhelper', $this);
	// Add the searchtools
	echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
?>
<?php if (empty($this->items)): ?>
	<div class="alert alert-no-items">
		<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
	</div>
<?php else : ?>
	<table class="table table-striped" id="admin_viewList">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	<?php // Load the batch processing form. ?>
	<?php if ($this->canCreate && $this->canEdit) : ?>
		<?php echo Html::_(
			'bootstrap.renderModal',
			'collapseModal',
			array(
				'title' => Text::_('COM_COMPONENTBUILDER_ADMIN_VIEWS_BATCH_OPTIONS'),
				'footer' => $this->loadTemplate('batch_footer')
			),
			$this->loadTemplate('batch_body')
		); ?>
	<?php endif; ?>
	<input type="hidden" name="boxchecked" value="0" />
	</div>
<?php endif; ?>
	<input type="hidden" name="task" value="" />
	<?php echo Html::_('form.token'); ?>
</form>
<script type="text/javascript">
// admin_views footer script

	// get page body
	var outerBodyDiv = document.querySelector('body');

	// start loading spinner
	var loadingDiv = document.createElement('div');
	loadingDiv.id = 'loading';

	// Set CSS properties individually
	loadingDiv.style.background = "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat";
	loadingDiv.style.top = (outerBodyDiv.getBoundingClientRect().top + window.pageYOffset) + "px";
	loadingDiv.style.left = (outerBodyDiv.getBoundingClientRect().left + window.pageXOffset) + "px";
	loadingDiv.style.width = outerBodyDiv.offsetWidth + "px";
	loadingDiv.style.height = outerBodyDiv.offsetHeight + "px";
	loadingDiv.style.position = 'fixed';
	loadingDiv.style.opacity = '0.80';
	loadingDiv.style.msFilter = "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
	loadingDiv.style.filter = "alpha(opacity=80)";
	loadingDiv.style.display = 'none';

	// add to page body
	outerBodyDiv.appendChild(loadingDiv);
// when the expand button is clicked
jQuery('#toolbar').on('click',"button.button-expand-2", function(e){
	loadingDiv.style.display = 'block';
});
</script>
