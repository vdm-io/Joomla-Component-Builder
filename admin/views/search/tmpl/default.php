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

<div class="alert alert-danger" role="alert">
	<?php echo JText::_('COM_COMPONENTBUILDER_THIS_AREA_IS_STILL_UNDER_DEVELOPMENT_ALTHOUGH_IT_WORKS_IT_SHOULD_BE_USED_WITH_EXTREME_CAUTION_AS_ITS_NOT_STABLE'); ?>
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
			<div class="row-fluid" id="search_progress_block" style="display: none">
				<div class="uk-progress uk-progress-striped uk-active">
					<div id="search_progress_bar" class="uk-progress-bar" style="width: 0%;">0%</div>
				</div>
			</div>
			<div class="row-fluid" id="search_details_block" style="display: none">
				<span id="search_details">
					<span class="search_details_title"><?php echo JText::_('COM_COMPONENTBUILDER_SEARCHED_FOR'); ?></span>:
					&nbsp;[<span id="searched" class="found_code">....</span>]&nbsp;&nbsp;&nbsp;&nbsp;
				</span>
				<span id="replace_details" style="display: none">
					<span class="search_details_title"><?php echo JText::_('COM_COMPONENTBUILDER_REPLACED_WITH'); ?></span>:
					&nbsp;[<span id="replaced" class="found_code">....</span>]
				</span>
				<button style="float: right;" type="button" onclick="showSearch();" class="btn button-new btn-success">
					<span class="icon-search icon-white" aria-hidden="true"></span>
					<?php echo JText::_('COM_COMPONENTBUILDER_SEARCH_DATABASE_AGAIN'); ?>
				</button>
			</div>
			<div class="row-fluid" id="search_settings_block">
				<div class="span7">
					<?php echo $this->form->renderField('type_search'); ?>
					<?php echo $this->form->renderField('search_value'); ?>
					<?php echo $this->form->renderField('replace_value'); ?>
				</div>
				<div class="span4">
					<?php echo $this->form->renderFieldset('settings'); ?>
				</div>
			</div>
			<div class="row-fluid" id="search_results_block">
				<hr>
				<div id="search_results_table_block">
					<?php echo JLayoutHelper::render('table', ['id' => 'search_results_table', 'headers' => $this->table_headers, 'items' => 7, 'init' => false]); ?>
				</div>
			</div>
			<div class="row-fluid" id="item_view_block">
				<hr>
				<div>
					<span id="item_notice_block" style="display: none">
						<span id="item_edit_button"></span>&nbsp;
							<?php echo JText::_('COM_COMPONENTBUILDER_TABLE'); ?>:&nbsp;<b><span id="item_table_name">
								</span></b>(<?php echo JText::_('COM_COMPONENTBUILDER_ID'); ?>:<b><span id="item_row_id">
									</span></b>)&nbsp;|&nbsp;
							<?php echo JText::_('COM_COMPONENTBUILDER_FIELD'); ?>:&nbsp;<b><span id="item_field_name">
								</span></b>(<?php echo JText::_('COM_COMPONENTBUILDER_LINE'); ?>:<b><span id="item_line_number">
									</span></b>)&nbsp;&nbsp;&nbsp;
						<button type="button" id="item_button_update" onclick="" class="hasTooltip btn btn-small button-new btn-success"
							title="<?php echo JText::_('COM_COMPONENTBUILDER_SAVE_ALL_CHANGES_MADE_TO_THE_SELECTED_ITEM'); ?>">
							<?php echo JText::_('COM_COMPONENTBUILDER_SAVE_ITEM'); ?>
						</button>
					</span>
					<span id="update_all_block" style="display: none;">
						<button style="float: right;" type="button" onclick="replaceAllCheck();" class="hasTooltip btn btn-small button-new btn-danger"
							title="<?php echo JText::_('COM_COMPONENTBUILDER_UPDATE_ALL_ITEMS_FOUND_WITH_THIS_DATABASE_SEARCH_WITH_THE_REPLACE_VALUE'); ?>">
							<?php echo JText::_('COM_COMPONENTBUILDER_UPDATE_ALL'); ?>
						</button>
					</span>
				</div>
				<hr>
				<?php echo $this->form->getInput('item_code'); ?>
			</div>
		</div>
	</form>
	<?php endif; ?>
</div>
<?php if (isset($this->item['tables']) && ComponentbuilderHelper::checkArray($this->item['tables'])) : ?>
<script>
// To class="uk-autoload uk-progress" UIkit.notify

// get search table values
const searchTables = <?php echo json_encode($this->item['tables']); ?>;

// the search Ajax URLs
const Url = '<?php echo JUri::base(); ?>index.php?option=com_componentbuilder&format=json&raw=true&<?php echo JSession::getFormToken(); ?>=1&task=ajax.';

// make sure our controller is set
let controller = null;

// start search time keepers
var startSearchTime, endSearchTime;

// active edit button of row selected
var editButtonSelected;

// get search progress area
const searchProgressObject = document.getElementById("search_progress_block");
const searchProgressBarObject = document.getElementById("search_progress_bar");

// get search settings area
const searchSettingsObject = document.getElementById("search_settings_block");
const searchDetailsObject = document.getElementById("search_details_block");
const searchedObject = document.getElementById("searched");

// get replace settings area
const replaceDetailsObject = document.getElementById("replace_details");
const replacedObject = document.getElementById("replaced");

// set the search mode object
const modeObject = document.getElementById("type_search");

// set the search settings objects
const searchObject = document.getElementById("search_value");
const replaceObject = document.getElementById("replace_value");
const matchObject = document.getElementById("search_behaviour0");
const wholeObject = document.getElementById("search_behaviour1");
const regexObject = document.getElementById("search_behaviour2");
const tableObject = document.getElementById("table_name");

// Do the search on key up of search or replace input elements
searchObject.onkeyup = onChange;

// when the made changes and there is replace value do search
modeObject.onchange = onChange;
replaceObject.onkeyup = onChange;

// Do the search on key up of search input elements
matchObject.onchange = onChange;
wholeObject.onchange = onChange;
regexObject.onchange = onChange;
tableObject.onchange = onChange;

// set the item notice area
const itemNoticeObject = document.getElementById("item_notice_block");
const itemEditButtonObject = document.getElementById("item_edit_button");
const itemTableNameObject = document.getElementById("item_table_name");
const itemRowIdObject = document.getElementById("item_row_id");
const itemFieldNameObject = document.getElementById("item_field_name");
const itemLineNumberObject = document.getElementById("item_line_number");

// set the update buttons
const buttonUpdateItemObject = document.getElementById("item_button_update");
const buttonUpdateAllObject = document.getElementById("update_all_block");

// get the editor
var editorObject;

// set some global objects
document.addEventListener('DOMContentLoaded', function () {
	// get the editor
	editorObject = Joomla.editors.instances['item_code'];
});

// configurations of the table
const tableConfigObject = {
	responsive: true,
	order: [[ 2, "asc" ]],
	select:  true,
	paging: true,
	lengthMenu: [5, 10, 20 ,50, 80, 100, 150, 200, 500, 1000, 1500, 2000],
	pageLength: 80,
	scrollY: 170,
	columnDefs: [
		{ 'targets': [ 0 ], 'visible': false, 'searchable': false },
		{ 'targets': [ 0, 1 ], type: 'html' },
		{ responsivePriority: 1, targets: 1 },
		{ responsivePriority: 2, targets: 2 },
		{ responsivePriority: 3, targets: 3 }
	],
	columns: [
		{
			data: 'edit'
		},
		{
			data: 'code'
		},
		{
			data: 'table'
		},
		{
			data: 'field'
		},
		{
			data: 'id',
			width: "15px",
			className:  "small_column"
		},
		{
			data: 'line',
			width: "15px",
			className:  "small_column"
		}
	]
};

// set some table object
var tableSearchObject;
var tableLengthObject;
var tableActiveObject;

// The Result Table Code
document.addEventListener('DOMContentLoaded', function () {

	// init the table
	let searchResultsTable = new DataTable('#search_results_table', tableConfigObject);

	searchResultsTable.on( 'select', function ( e, dt, type, indexes ) {
		if ( type === 'row' ) {
			// get the data from the row
			let data = searchResultsTable.rows( indexes ).data();

			// get the item data
			let item_id = data[0].id;
			let item_table = data[0].table;
			let item_field = data[0].field;
			let item_line = data[0].line;

			// set the active edit button
			editButtonSelected = data[0].edit; 
			// set active row
			tableActiveObject = searchResultsTable.row( indexes );

			// get selected item
			getSelectedItem(item_table, item_id, item_field, item_line);

			// hide the search settings
			hideSearch();
		}
	});

	searchResultsTable.on( 'deselect', function ( e, dt, type, indexes ) {
		if ( type === 'row' ) {
			clearSelectedItem(false);
		}
	});

	// set the table search object
	tableSearchObject = document.getElementById("search_results_table_filter");
	tableLengthObject = document.getElementById("search_results_table_length");

	showSearch();
<?php if (strlen($this->urlvalues['search_value']) > 2): ?>
	onChange();
<?php endif; ?>
});
</script>
<?php endif; ?>
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>

