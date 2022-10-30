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
				<div class="span7">
					<?php echo $this->form->renderField('type_search'); ?>
					<?php echo $this->form->renderField('search_value'); ?>
					<?php echo $this->form->renderField('replace_value'); ?>
				</div>
				<div class="span4">
					<?php echo $this->form->renderFieldset('settings'); ?>
				</div>
			</div>
			<div class="row-fluid" id="search_results_view">
				<hr>
				<div id="search_results_table_box">
					<?php echo JLayoutHelper::render('table', ['id' => 'search_results_table', 'headers' => $this->table_headers, 'items' => 7, 'init' => false]); ?>
				</div>
			</div>
			<div class="row-fluid" id="item_view_box">
				<hr>
				<div id="item_notice"></div>
				<?php echo $this->form->getInput('full_text'); ?>
			</div>
		</div>
	</form>
	<?php endif; ?>
</div>
<?php if (isset($this->item['tables']) && ComponentbuilderHelper::checkArray($this->item['tables'])) : ?>
<script>
	const searchTables = <?php echo json_encode($this->item['tables']); ?>;

	// the search Ajax URLs
	const Url = '<?php echo JUri::base(); ?>index.php?option=com_componentbuilder&format=json&raw=true&<?php echo JSession::getFormToken(); ?>=1&task=ajax.';

	// make sure our controller is set
	let controller = null;

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
	replaceObject.onkeyup = onChange;

	// Do the search on key up of search input elements
	matchObject.onchange = onChange;
	wholeObject.onchange = onChange;
	regexObject.onchange = onChange;
	tableObject.onchange = onChange;

	// get the editor
	var editorObject;
	var editorBoxObject;
	var editorNoticeObject;

	// set some global objects
	document.addEventListener('DOMContentLoaded', function () {
		// get the editor
		editorObject = Joomla.editors.instances['full_text'];
		editorBoxObject = document.getElementById("item_view_box");
		editorNoticeObject = document.getElementById("item_notice");
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
			{ 'targets': [ 4, 5 ], 'visible': false, 'searchable': false },
			{ 'targets': [ 0, 1 ], type: 'html' },
			{ responsivePriority: 1, targets: 1 },
			{ responsivePriority: 2, targets: 0 },
			{ responsivePriority: 3, targets: 2 },
			{ responsivePriority: 4, targets: 3 }
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
				data: 'id'
			},
			{
				data: 'line'
			}
		]
	};

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

				// get selected item
				getSelectedItem(item_table, item_id, item_field, item_line);
			}
		});

		searchResultsTable.on( 'deselect', function ( e, dt, type, indexes ) {
			if ( type === 'row' ) {
				clearSelectedItem(false);
			}
		});
	});
</script>
<?php endif; ?>
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>

