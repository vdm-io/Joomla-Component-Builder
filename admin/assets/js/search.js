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
		let searchValue = document.querySelector('input[name="search_value"]').value;
		let replaceValue = document.querySelector('input[name="replace_value"]').value;

		// Display 'loading' message in search results message div
		document.getElementById('search-mssg-box').innerHTML =
			'<progress id="search-loading-progressbar" class="uk-progress" value="10" max="100" style="width: 200px; display: inline-block; margin: 0 !important;"></progress>' +
			' <div id="search-loading-spinner" style="margin: -4px 12px 0;" uk-spinner="ratio: 0.8"></div>' +
			' <span id="search-loading-percent">0%</span> ' +
			'Loading for search text: <b style="font-size: 2em;">' + searchValue + '</b>'
		;
		// Clear results table
		let search_loading_percent = document.getElementById('search-loading-percent');
		let tbl_obj_body = document.getElementById('search-results-tbl-tbody');
		tbl_obj_body.innerHTML = '';
		let abort_this_search_value = false;

		let total = 0;
		let index;

		for (index = 0; index < searchTables.length; index++) {
			const formData = new FormData();
			let tableName = searchTables[index];

			formData.append('table_name', '');
			formData.append('search_value', searchValue);
			formData.append('replace_value', replaceValue);
			formData.append('match_case', document.querySelector('input[name="match_case"]').checked ? 1 : 0);
			formData.append('whole_word', document.querySelector('input[name="whole_word"]').checked ? 1 : 0);
			formData.append('regex_search', document.querySelector('input[name="regex_search"]').checked ? 1 : 0);
			formData.append('table_name', tableName);

			let url = document.getElementById('adminForm').getAttribute('action') + '&layout=dosearch';
			let options = {
				signal: signal,
				method: 'POST', // *GET, POST, PUT, DELETE, etc.
				body: formData
			}

			if (abort_this_search_value) {
				console.log('Aborting this searchValue:' + searchValue);
				break;
			}
			console.log(total + ' -- SEARCHING: ' + searchValue + ' @[' + tableName + ']');
			const response = await fetch(url, options)
				// Note: response.text() is a promise ...
				.then(response => {
					total++;
					//console.log(total + ' ' + sTables.length);
					if (sTables.length == total) setTimeout(function () {
						document.getElementById('search-mssg-box').innerHTML = '<div class="alert alert-success" role="alert"><strong>Enter</strong> your text.</div>';
					}, 200);

					response.text().then(data => {
						console.log('++ Fetched for ' + searchValue + ' [' + tableName + ']');
						let percent = 100.0 * (total / sTables.length);
						search_loading_percent.innerHTML = '' + percent.toFixed(2) + '%';
						document.getElementById('search-loading-progressbar').value = percent;

						let use_json = false, json_data = false, items = false;
						if (use_json) {
							try {
								json_data = data ? JSON.parse(data) : false;
								items = json_data ? json_data.items : false;
							} catch (error) {
								console.log(error);
							}
						}

						// Very fast and low memory display HTML table row prepared server-side via PHP instead of JS !!
						if (!json_data) {
							tbl_obj_body.innerHTML = tbl_obj_body.innerHTML + data;
						}

						// Very slow fast and very high memory: Display HTML table rows by creating them now in browser (client-side) via JS instead of using PHP
						if (json_data && items) {
							let table_rows = '';
							for (const [row_num, row_field_vals] of Object.entries(items)) {
								for (const [fname, fvals] of Object.entries(row_field_vals)) {
									for (const [line, fval] of Object.entries(fvals)) {
										let lnk = 'getFSText(this, \'' + tableName + '\', ' + row_num + ', \'' + fname + '\', line)';
										let val = fval;
										val = val.replaceAll(marker_start, '<b>');
										val = val.replaceAll(marker_end, '</b>');
										table_rows = table_rows + '<tr onclick="' + lnk + '; return false" style="cursor: pointer;">' +
											'<td>' + val + '</td>' +
											'<td>' + tableName + '</td>' +
											'<td>' + fname + '</td>' +
											'<td>' + row_num + '</td>' +
											'<td>' + line + '</td>' +
											'</tr>';
									}
								}
							}
							tbl_obj_body.innerHTML = tbl_obj_body.innerHTML + table_rows;
						} // END IF json_data && items

					});
				})
				.catch(error => {
					total++;
					if (sTables.length == total) document.getElementById('search-mssg-box').innerHTML = '<div class="alert alert-success" role="alert"><strong>Enter</strong> your text.</div>';
					// Stop further searches for this search value
					if (error.name === "AbortError") abort_this_search_value = true;
					error.name === "AbortError"
						? console.log(" ... ABORTED fetch() for: " + searchValue)
						: console.log(error.toString());
				});
		}
	} catch (error) {
		console.log(error);
	} finally {
		// Executed regardless if we caught the error
	}
};

/**
 * JS Function to execute the search
 */
const getFSText = async (el, table_name, row_id, field_name, line) => {
	let sibling = el.parentNode.firstElementChild;
	do {
		sibling != el
		? sibling.classList.remove('active')
		: sibling.classList.add('active');
	} while (sibling = sibling.nextElementSibling);

	try {
		const formData = new FormData();

		formData.append('table_name', table_name);
		formData.append('get_full_search_text', 1);
		formData.append('row_id', row_id);
		formData.append('field_name', field_name);

		//let url = `https://jsonplaceholder.typicode.com/posts/${searchValue}`,
		let url = document.getElementById('adminForm').getAttribute('action') + '&layout=dosearch';
		let options = {
			method: 'POST', // *GET, POST, PUT, DELETE, etc.
			mode: 'cors', // no-cors, *cors, same-origin
			cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
			credentials: 'same-origin', // include, *same-origin, omit
			/*
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',  //'application/x-www-form-urlencoded',
			},*/
			redirect: 'follow', // manual, *follow, error
			referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
			// body: JSON.stringify(formData) // body data type must match "Content-Type" header
			body: formData
		}

		// Clear full text box
		document.getElementById('match-full-text-box').innerHTML = 'Loading ...';
		const response = await fetch(url, options)
			// Note: response.text() is a promise ...
			.then(response => {
				response.text().then(data => {
					console.log("Fetched full text for row: " + row_id + ' field name: ' + field_name + ' for Table: ' + table_name);
					document.getElementById('match-full-text-box').innerHTML = '<div id="match-full-text-header">'
						+ table_name + ' @ ' + field_name + ': ' + row_id + '</div><textarea id="match-full-text">' + data + '</textarea>';
		document.getElementById('match-full-text-box').style.display = '';
		attachCodeMirror(jQuery('#match-full-text'), null);
			    cm_toggle_fully_searchable('match-full-text', 1);
		      cm_jumpToLine('match-full-text', line);
				  //cm_toggle_plain_textarea('match-full-text-box', 1);
				});
			})
			.catch(error => {
				// Stop further searches for this search value
				if (error.name === "AbortError") abort_this_search_value = true;
				error.name === "AbortError"
					? console.log(" ... ABORTED fetch() for: " + searchValue)
					: console.log(error.toString());
			});
	} catch (error) {
		console.log(error);
	} finally {
		// Executed regardless if we caught the error
	}
};


const cm_jumpToLine = function (tag_id, row)
{
	console.log('#' + tag_id);
	let codeMirrorEl = jQuery('#' + tag_id).next('.CodeMirror');
	if (!codeMirrorEl.length) return;
	let codeMirrorRef = jQuery('#' + tag_id).next('.CodeMirror').get(0).CodeMirror;
	let t = codeMirrorRef.charCoords({line: row, ch: 0}, "local").top;
	let middleHeight = codeMirrorRef.getScrollerElement().offsetHeight / 2;
	codeMirrorRef.scrollTo(null, t - middleHeight - 5);
}

/* Attach CodeMirror with optional settings */
const cm_toggle_fully_searchable = function (el, toggle)
{
	if (typeof CodeMirror === 'undefined') {alert('CodeMirror not loaded'); return;}

	jQuery([el]).each(function(i, tag_id) {
		let codeMirrorEl = jQuery('#' + tag_id).next('.CodeMirror');
		if (!codeMirrorEl.length) return;
		let codeMirrorRef = jQuery('#' + tag_id).next('.CodeMirror').get(0).CodeMirror;
		codeMirrorRef.setOption('viewportMargin', toggle ? '9999' : '');
	});

}

const cm_toggle_plain_textarea = function (el, toggle)
{
	if (typeof CodeMirror === 'undefined') {alert('CodeMirror not loaded'); return;}

	jQuery([el]).each(function(i, tag_id) {
		let codeMirrorEl = jQuery('#' + tag_id).next('.CodeMirror');
		if (toggle) {
			let options = jQuery('#' + tag_id).data('options');
			options.viewportMargin = jQuery('#cm_toggle_fully_searchable_btn input').prop('checked') ? '9999' : '';
			jQuery('#' + tag_id).prev('p').show();
			attachCodeMirror(jQuery('#' + tag_id), options);
		}
		else if (codeMirrorEl.length)
		{
			let codeMirrorRef = codeMirrorEl.get(0).CodeMirror;
			jQuery('#' + tag_id).prev('p').hide();
			jQuery('#' + tag_id).css({width: '100%', height: '400px'});
			codeMirrorRef.toTextArea();
			// Remove codemirror container in case that removing it failed
			if (jQuery('#' + tag_id).next('.CodeMirror').length) {
				jQuery('#' + tag_id).next('.CodeMirror').remove();
			}
		}
	});

}

const attachCodeMirror = function (txtareas, CMoptions, mode)
{
	CMoptions = typeof CMoptions!=='undefined' && CMoptions ? CMoptions : {
		mode: mode || 'application/x-httpd-php',
		indentUnit: 2,
		lineNumbers: true,
		matchBrackets: true,
		lineWrapping: true,
		onCursorActivity: function(CM)
		{
			CM.setLineClass(hlLine, null);
			hlLine = CM.setLineClass(CM.getCursor().line, 'activeline');
		}
	};

	var editor, theArea;
	txtareas.each(function(i, txtarea)
	{
		theArea = jQuery(txtarea);
		theArea.removeClass(); // Remove all classes from the textarea
		editor = CodeMirror.fromTextArea(theArea.get(0), CMoptions);
		editor.refresh();
	});

	return txtareas.length==1 ? editor : true;
}

/**
 * JS Function to execute (A) on search text change , (B) on search options changes
 */
const onChange = () => {
	const searchValue = searchValueInp.value;
	if (searchValue.length > 2) {
		// Cancel any ongoing requests
		if (controller) controller.abort();

		// Create new controller and issue new request
		controller = new AbortController();
		doSearch(controller.signal, sTables);
	} else {
		// Clear any message in search results message div
		//document.getElementById('search-mssg-box').innerHTML = '';
	}
};

const previewReplace = () => {
	const replaceValue = replaceValueInp.value;
	console.log(replaceValueInp);
	if (replaceValue.length) {
		document.getElementById('search-mssg-box').innerHTML = replaceValue;
	}
}

// Do the search on key up of search or replace input element
searchValueInp.onkeyup = onChange;
replaceValueInp.onkeyup = previewReplace;

// Do the search on key up of search input element
caseSensitiveLbl.onchange = onChange;
completeWordLbl.onchange = onChange;
regexpSearchLbl.onchange = onChange;
