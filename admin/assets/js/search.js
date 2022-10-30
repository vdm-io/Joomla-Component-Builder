/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/* JS Document */
/**
 * JS Function to execute the search
 */
const doSearch = async (signal, tables) => {
	try {
		// build form
		const formData = new FormData();

		// load the result table
		const resultsTable = new DataTable('#search_results_table');

		// set some search values
		let searchValue = searchObject.value;
		let replaceValue = replaceObject.value;

		// add the form data
		formData.append('table_name', '');
		formData.append('search_value', searchValue);
		formData.append('replace_value', replaceValue);
		formData.append('match_case', matchObject.checked ? 1 : 0);
		formData.append('whole_word', wholeObject.checked ? 1 : 0);
		formData.append('regex_search', regexObject.checked ? 1 : 0);

		let abort_this_search_value = false;

		let total = 0;
		let index;

		for (index = 0; index < tables.length; index++) {

			let tableName = tables[index];

			// add the table name
			formData.set('table_name', tableName);

			let options = {
				signal: signal,
				method: 'POST', // *GET, POST, PUT, DELETE, etc.
				body: formData
			}

			if (abort_this_search_value) {
				console.log('Aborting this searchValue:' + searchValue);
				break;
			}
			const response = await fetch(Url + 'doSearch', options).then(response => {
				total++;
				if (response.ok) {
					return response.json();
				}
			}).then((data) => {
				if (typeof data.items !== 'undefined') {
					console.log('++ Fetched for ' + searchValue + ' [' + tableName + ']');
					addTableItems(resultsTable, data.items);
				}
			}).catch(error => {
				console.log(error);
			});
		}
	} catch (error) {
		console.log(error);
	} finally {
		// Executed regardless if we caught the error
	}
};

/**
 * JS Function to fetch selected item
 */
const getSelectedItem = async (table, row, field, line) => {
	try {
		// get the search mode
		let mode = modeObject.querySelector('input[type=\'radio\']:checked').value;

		// build form
		const formData = new FormData();

		// get search value
		if (mode == 1) {
			formData.append('field_name', field);
			formData.append('row_id', row);
			formData.append('table_name', table);

			// calling URL
			getURL = Url + 'getSearchValue';
		} else {
			formData.append('field_name', field);
			formData.append('row_id', row);
			formData.append('line_nr', line);
			formData.append('table_name', table);
			formData.append('search_value', searchObject.value);
			formData.append('replace_value', replaceObject.value);
			formData.append('match_case', matchObject.checked ? 1 : 0);
			formData.append('whole_word', wholeObject.checked ? 1 : 0);
			formData.append('regex_search', regexObject.checked ? 1 : 0);

			// calling URL
			getURL = Url + 'getReplaceValue';
		}

		let options = {
			method: 'POST', // *GET, POST, PUT, DELETE, etc.
			body: formData
		}

		const response = await fetch(getURL, options).then(response => {
			if (response.ok) {
				return response.json();
			}
		}).then((data) => {
			if (typeof data.value !== 'undefined') {
				addSelectedItem(data.value, table, row, field, line);
			}
		}).catch(error => {
			console.log(error);
		});
	} catch (error) {
		console.log(error);
	} finally {
		// Executed regardless if we caught the error
	}
}

/**
 * JS Function to add item to the editor
 */
const addSelectedItem = async (value, table, row, field, line) => {
	// display area
	if (value.length > 1)
	{
		editorObject.setValue(value);
		editorNoticeObject.innerHTML = 'Table: <b>' + table + '</b>(id:<b>' + row + '</b>) | Field: <b>' + field + '</b>(line:<b>' + line + '</b>)';
	}
}

/**
 * JS Function to clear item from the editor and hide it
 */
const clearSelectedItem = async () => {
	// display area
	editorObject.setValue('');
	editorNoticeObject.innerHTML = '';
}

/**
 * JS Function to clear table items
 */
const clearTableItems = async () => {
	let table = new DataTable('#search_results_table');
	table.clear().draw( true );
}

/**
 * JS Function to clear all details of the search
 */
const clearAll = async () => {
	// clear all details
	clearTableItems();
	clearSelectedItem();
}

/**
 * JS Function to add items to the table
 */
const addTableItems = async (table, items) => {
	table.rows.add(items).draw( false );
}

/**
 * JS Function to execute (A) on search text change , (B) on search options changes
 */
const onChange = () => {
	const searchValue = searchObject.value;
	if (searchValue.length > 2) {
		// Cancel any ongoing requests
		if (controller) controller.abort();

		// we clear the table again
		clearAll();

		// Create new controller and issue new request
		controller = new AbortController();

		// check if any specific table was set
		let tables = [];
		let table = tableObject.value;
		if (table != -1) {
			tables.push(table);
			doSearch(controller.signal, tables);
		} else {
			doSearch(controller.signal, searchTables);
		}
	} else {
		// Clear the table
		clearAll();
	}
};
