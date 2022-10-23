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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
use VDM\Joomla\Componentbuilder\Search\Factory as SearchFactory;

$this->app->input->set('hidemainmenu', false);
$selectNotice = '<h3>' . JText::_('COM_COMPONENTBUILDER_HI') . ' ' . $this->user->name . '</h3>';
$selectNotice .= '<p>' . JText::_('COM_COMPONENTBUILDER_ENTER_YOUR_SEARCH_TEXT') . '</p>';
?>
<?php if ($this->canDo->get('search.access')): ?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task === 'search.back') {
			parent.history.back();
			return false;
		} else {
			var form = document.getElementById('adminForm');
			form.task.value = task;
			form.submit();
		}
	}
</script>
<?php $urlId = (isset($this->item->id)) ? '&id='. (int) $this->item->id : ''; ?>

<div class="alert alert-info" role="alert">
	<?php echo JText::_('COM_COMPONENTBUILDER_THIS_AREA_IS_STILL_UNDER_DEVELOPMENT_AND_DOES_NOT_WORK'); ?>
</div>
<hr />
<?php if(!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif; ?>
	<?php if ($this->form): ?>
	<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=search'); ?>" method="post"
		name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
		<div class="form-horizontal">
			<div class="row-fluid">
				<div class="span8">
					<?php echo $this->form->renderField('type_search'); ?>
					<?php echo $this->form->renderField('search_value'); ?>
					<?php echo $this->form->renderField('replace_value'); ?>
				</div>
				<div class="span3">
					<?php echo $this->form->renderFieldset('settings'); ?>
				</div>
			</div>
			<div class="row-fluid" id="search_view">
				<div id="search-results-tbl-box">
					<table id="search-results-tbl" class="table">
						<thead>
							<tr>
								<th><?php echo JText::_('COM_COMPONENTBUILDER_FOUND_TEXT'); ?></th>
								<th><?php echo JText::_('COM_COMPONENTBUILDER_TABLE'); ?></th>
								<th><?php echo JText::_('COM_COMPONENTBUILDER_FIELD'); ?></th>
								<th><?php echo JText::_('ID'); ?></th>
								<th><?php echo JText::_('COM_COMPONENTBUILDER_LINE'); ?></th>
							</tr>
						</thead>
						<tbody id="search-results-tbl-tbody"></tbody>
					</table>
				</div>
			</div>
			<div class="row-fluid" id="item_view" style="display: none;">
				<?php echo $this->form->renderFieldset('view'); ?>
			</div>
		</div>
	</form>
	<?php endif; ?>
</div>
<?php if (isset($this->item['tables']) && ComponentbuilderHelper::checkArray($this->item['tables'])) : ?>
<script>
	var searchTables = json_encode($this->item['tables']);

	const searchValueInp = document.getElementById("search_value");
	const replaceValueInp = document.getElementById("replace_value");
	const caseSensitiveLbl = document.getElementById("match_case_lbl");
	const completeWordLbl = document.getElementById("whole_word_lbl");
	const regexpSearchLbl = document.getElementById("regex_search_lbl");
	let controller = null;
</script>
<?php endif; ?>
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>

