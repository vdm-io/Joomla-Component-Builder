/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwbgvws_required = false;
jform_vvvvwbhvwt_required = false;
jform_vvvvwbivwu_required = false;
jform_vvvvwbjvwv_required = false;
jform_vvvvwbmvww_required = false;
jform_vvvvwbmvwx_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var datalenght_vvvvwbg = jQuery("#jform_datalenght").val();
	vvvvwbg(datalenght_vvvvwbg);

	var datadefault_vvvvwbh = jQuery("#jform_datadefault").val();
	vvvvwbh(datadefault_vvvvwbh);

	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	vvvvwbi(datatype_vvvvwbi);

	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	vvvvwbj(datatype_vvvvwbj);

	var store_vvvvwbm = jQuery("#jform_store").val();
	vvvvwbm(store_vvvvwbm);

	var add_css_view_vvvvwbn = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwbn(add_css_view_vvvvwbn);

	var add_css_views_vvvvwbo = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwbo(add_css_views_vvvvwbo);

	var add_javascript_view_footer_vvvvwbp = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwbp(add_javascript_view_footer_vvvvwbp);

	var add_javascript_views_footer_vvvvwbq = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwbq(add_javascript_views_footer_vvvvwbq);
});

// the vvvvwbg function
function vvvvwbg(datalenght_vvvvwbg)
{
	if (isSet(datalenght_vvvvwbg) && datalenght_vvvvwbg.constructor !== Array)
	{
		var temp_vvvvwbg = datalenght_vvvvwbg;
		var datalenght_vvvvwbg = [];
		datalenght_vvvvwbg.push(temp_vvvvwbg);
	}
	else if (!isSet(datalenght_vvvvwbg))
	{
		var datalenght_vvvvwbg = [];
	}
	var datalenght = datalenght_vvvvwbg.some(datalenght_vvvvwbg_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbgvws_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbgvws_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbgvws_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbgvws_required = true;
		}
	}
}

// the vvvvwbg Some function
function datalenght_vvvvwbg_SomeFunc(datalenght_vvvvwbg)
{
	// set the function logic
	if (datalenght_vvvvwbg == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbh function
function vvvvwbh(datadefault_vvvvwbh)
{
	if (isSet(datadefault_vvvvwbh) && datadefault_vvvvwbh.constructor !== Array)
	{
		var temp_vvvvwbh = datadefault_vvvvwbh;
		var datadefault_vvvvwbh = [];
		datadefault_vvvvwbh.push(temp_vvvvwbh);
	}
	else if (!isSet(datadefault_vvvvwbh))
	{
		var datadefault_vvvvwbh = [];
	}
	var datadefault = datadefault_vvvvwbh.some(datadefault_vvvvwbh_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbhvwt_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbhvwt_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbhvwt_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbhvwt_required = true;
		}
	}
}

// the vvvvwbh Some function
function datadefault_vvvvwbh_SomeFunc(datadefault_vvvvwbh)
{
	// set the function logic
	if (datadefault_vvvvwbh == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbi function
function vvvvwbi(datatype_vvvvwbi)
{
	if (isSet(datatype_vvvvwbi) && datatype_vvvvwbi.constructor !== Array)
	{
		var temp_vvvvwbi = datatype_vvvvwbi;
		var datatype_vvvvwbi = [];
		datatype_vvvvwbi.push(temp_vvvvwbi);
	}
	else if (!isSet(datatype_vvvvwbi))
	{
		var datatype_vvvvwbi = [];
	}
	var datatype = datatype_vvvvwbi.some(datatype_vvvvwbi_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbivwu_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbivwu_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbivwu_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbivwu_required = true;
		}
	}
}

// the vvvvwbi Some function
function datatype_vvvvwbi_SomeFunc(datatype_vvvvwbi)
{
	// set the function logic
	if (datatype_vvvvwbi == 'CHAR' || datatype_vvvvwbi == 'VARCHAR' || datatype_vvvvwbi == 'DATETIME' || datatype_vvvvwbi == 'DATE' || datatype_vvvvwbi == 'TIME' || datatype_vvvvwbi == 'INT' || datatype_vvvvwbi == 'TINYINT' || datatype_vvvvwbi == 'BIGINT' || datatype_vvvvwbi == 'FLOAT' || datatype_vvvvwbi == 'DECIMAL' || datatype_vvvvwbi == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbj function
function vvvvwbj(datatype_vvvvwbj)
{
	if (isSet(datatype_vvvvwbj) && datatype_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = datatype_vvvvwbj;
		var datatype_vvvvwbj = [];
		datatype_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(datatype_vvvvwbj))
	{
		var datatype_vvvvwbj = [];
	}
	var datatype = datatype_vvvvwbj.some(datatype_vvvvwbj_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwbjvwv_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwbjvwv_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwbjvwv_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwbjvwv_required = true;
		}
	}
}

// the vvvvwbj Some function
function datatype_vvvvwbj_SomeFunc(datatype_vvvvwbj)
{
	// set the function logic
	if (datatype_vvvvwbj == 'CHAR' || datatype_vvvvwbj == 'VARCHAR' || datatype_vvvvwbj == 'INT' || datatype_vvvvwbj == 'TINYINT' || datatype_vvvvwbj == 'BIGINT' || datatype_vvvvwbj == 'FLOAT' || datatype_vvvvwbj == 'DECIMAL' || datatype_vvvvwbj == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbm function
function vvvvwbm(store_vvvvwbm)
{
	if (isSet(store_vvvvwbm) && store_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = store_vvvvwbm;
		var store_vvvvwbm = [];
		store_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(store_vvvvwbm))
	{
		var store_vvvvwbm = [];
	}
	var store = store_vvvvwbm.some(store_vvvvwbm_SomeFunc);


	// set this function logic
	if (store)
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').show();
		jQuery('#jform_initiator_on_save_model').closest('.control-group').show();
		jQuery('.note_expert_field_save_mode').closest('.control-group').show();
		jQuery('#jform_on_get_model_field').closest('.control-group').show();
		// add required attribute to on_get_model_field field
		if (jform_vvvvwbmvww_required)
		{
			updateFieldRequired('on_get_model_field',0);
			jQuery('#jform_on_get_model_field').prop('required','required');
			jQuery('#jform_on_get_model_field').attr('aria-required',true);
			jQuery('#jform_on_get_model_field').addClass('required');
			jform_vvvvwbmvww_required = false;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').show();
		// add required attribute to on_save_model_field field
		if (jform_vvvvwbmvwx_required)
		{
			updateFieldRequired('on_save_model_field',0);
			jQuery('#jform_on_save_model_field').prop('required','required');
			jQuery('#jform_on_save_model_field').attr('aria-required',true);
			jQuery('#jform_on_save_model_field').addClass('required');
			jform_vvvvwbmvwx_required = false;
		}
	}
	else
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').hide();
		jQuery('#jform_initiator_on_save_model').closest('.control-group').hide();
		jQuery('.note_expert_field_save_mode').closest('.control-group').hide();
		jQuery('#jform_on_get_model_field').closest('.control-group').hide();
		// remove required attribute from on_get_model_field field
		if (!jform_vvvvwbmvww_required)
		{
			updateFieldRequired('on_get_model_field',1);
			jQuery('#jform_on_get_model_field').removeAttr('required');
			jQuery('#jform_on_get_model_field').removeAttr('aria-required');
			jQuery('#jform_on_get_model_field').removeClass('required');
			jform_vvvvwbmvww_required = true;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').hide();
		// remove required attribute from on_save_model_field field
		if (!jform_vvvvwbmvwx_required)
		{
			updateFieldRequired('on_save_model_field',1);
			jQuery('#jform_on_save_model_field').removeAttr('required');
			jQuery('#jform_on_save_model_field').removeAttr('aria-required');
			jQuery('#jform_on_save_model_field').removeClass('required');
			jform_vvvvwbmvwx_required = true;
		}
	}
}

// the vvvvwbm Some function
function store_vvvvwbm_SomeFunc(store_vvvvwbm)
{
	// set the function logic
	if (store_vvvvwbm == 6)
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(add_css_view_vvvvwbn)
{
	// set the function logic
	if (add_css_view_vvvvwbn == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbo function
function vvvvwbo(add_css_views_vvvvwbo)
{
	// set the function logic
	if (add_css_views_vvvvwbo == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbp function
function vvvvwbp(add_javascript_view_footer_vvvvwbp)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwbp == 1)
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbq function
function vvvvwbq(add_javascript_views_footer_vvvvwbq)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwbq == 1)
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').hide();
	}
}

/**
 * Update the "not required" field list by adding or removing a field name.
 *
 * Mirrors the original jQuery logic exactly but uses pure JavaScript.
 *
 * @param  {string}  name    The field name to add or remove.
 * @param  {number}  status  1 to add as not required, 0 to remove.
 *
 * @return {void}
 * @since  3.1.3
 */
function updateFieldRequired(name, status) {
	// Check if #jform_not_required exists
	const notRequiredField = document.getElementById('jform_not_required');
	if (!notRequiredField) {
		return;
	}

	// Split the comma-separated list into an array
	let not_required = notRequiredField.value ? notRequiredField.value.split(',') : [];

	// Add or remove the field name from the list
	if (status == 1) {
		not_required.push(name);
	} else {
		not_required = removeFieldFromNotRequired(not_required, name);
	}

	// Clean and deduplicate the list
	const fixedList = fixNotRequiredArray(not_required);

	// Write back the updated comma-separated list
	notRequiredField.value = fixedList.toString();
}

/**
 * Remove a specific field name from the "not required" array.
 *
 * @param  {Array<string>} array  The list of not-required field names.
 * @param  {string}        what   The field name to remove.
 *
 * @return {Array<string>}        The updated array.
 * @since  3.1.3
 */
function removeFieldFromNotRequired(array, what) {
	return array.filter(function (element) {
		return element !== what;
	});
}

/**
 * Deduplicate and clean a "not required" array.
 *
 * @param  {Array<string>} array  The array to fix.
 *
 * @return {Array<string>}        A cleaned, unique array.
 * @since  3.1.3
 */
function fixNotRequiredArray(array) {
	const seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function (item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

/**
 * Remove empty or invalid entries from a "not required" array.
 *
 * Also removes the literal '一_一' token (legacy quirk preserved for compatibility).
 *
 * @param  {Array<string>} array  The array to process.
 *
 * @return {Array<string>}        The cleaned array.
 * @since  3.1.3
 */
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		return el && el.length > 0 && el !== '一_一';
	});
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
}


jQuery(document).ready(function()
{
	// get type value
	var fieldtype = jQuery("#jform_fieldtype option:selected").val();
	getFieldTypeProperties(fieldtype, false);
	// get the linked details
	getLinked();
	// get the validation rules
	getValidationRulesTable();
	// set button to create more fields
	addButton('validation_rule', 'validation_rules_header', 2);
	// get the field type text
	var fieldText = jQuery("#jform_fieldtype option:selected").text().toLowerCase();
	// now check if database input is needed
	dbChecker(fieldText);
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

// the options row id key
var rowIdKey = 'properties';

/**
 * Load and initialize the field type properties dynamically.
 *
 * This method retrieves subform and database property information for a given
 * field type, updates the Joomla form dynamically, and initializes new form elements.
 * It reproduces the full behavior of the legacy jQuery implementation using pure JavaScript.
 *
 * @param  {string|number}  fieldtype  The field type identifier or ID.
 * @param  {boolean}        db         Whether to load database defaults if present.
 *
 * @return {void}
 * @since  5.1.3
 */
function getFieldTypeProperties(fieldtype, db) {
	getCodeFrom_server(fieldtype, 'type', 'type', 'fieldTypeProperties')
		.then(function (result) {
			// Ensure a valid response with subform data
			if (!result || !result.subform) {
				return;
			}

			// Store the property options list globally
			propertiesArray = result.nameListOptions;

			// --- Remove any previous dynamically added property forms ---
			document.querySelectorAll('.prop_removal').forEach(el => el.remove());

			// --- Remove "select field type" notices if they exist ---
			document.querySelectorAll('.note_select_field_type').forEach(el => {
				const group = el.closest('.control-group');
				if (group) group.remove();
			});

			// --- Locate the control group for filter information ---
			const noteInfo = document.querySelector('.note_filter_information');
			const targetGroup = noteInfo ? noteInfo.closest('.control-group') : null;

			// --- Prepend the new content in the correct order ---
			if (targetGroup) {
				// Prepend the "extra" HTML block
				if (result.extra) {
					targetGroup.insertAdjacentHTML('afterbegin', result.extra);
				}

				// Prepend any textarea fields returned by the AJAX response
				if (result.textarea && Array.isArray(result.textarea)) {
					for (const tField of result.textarea) {
						targetGroup.insertAdjacentHTML('afterbegin', tField);
					}
				}

				// Finally, prepend the subform structure itself
				targetGroup.insertAdjacentHTML('afterbegin', result.subform);
			}

			// --- Initialize row watcher if available ---
			if (typeof rowWatcher === 'function') {
				rowWatcher();
			}

			// --- Trigger "update" events on all subform-repeatable elements ---
			document.querySelectorAll('div.subform-repeatable').forEach(el => {
				el.dispatchEvent(new Event('update', { bubbles: true }));
			});

			// --- Reapply property dynamic list restrictions if available ---
			if (typeof propertyDynamicSet === 'function') {
				propertyDynamicSet();
			}

			// --- Remove any old help block and re-render updated help info ---
			document.querySelectorAll('#help').forEach(el => el.remove());

			const helpNote = document.querySelector('.helpNote');
			if (helpNote) {
				const helpDiv = document.createElement('div');
				helpDiv.id = 'help';
				helpDiv.innerHTML = `${result.description}<br />${result.values_description}`;
				helpNote.appendChild(helpDiv);
			}

			// --- If requested, load database-related default values ---
			if (db && result.database) {
				const dbData = result.database;

				// Update datatype
				setChoicesFieldValue('#jform_datatype', dbData.datatype);
				updateFieldRequired('datatype', 0);

				// Update datalenght
				setChoicesFieldValue('#jform_datalenght', dbData.datalenght);
				updateFieldRequired('datalenght', 0);
				if (dbData.datalenght === 'Other') {
					setChoicesFieldValue('#jform_datalenght_other', dbData.datalenght_other);
					updateFieldRequired('datalenght_other', 0);
				} else {
					updateFieldRequired('datalenght_other', 1);
				}

				// Update datadefault
				setChoicesFieldValue('#jform_datadefault', dbData.datadefault);
				updateFieldRequired('datadefault', 0);
				if (dbData.datadefault === 'Other') {
					setChoicesFieldValue('#jform_datadefault_other', dbData.datadefault_other);
					updateFieldRequired('datadefault_other', 0);
				} else {
					updateFieldRequired('datadefault_other', 1);
				}

				// Update indexes
				setChoicesFieldValue('#jform_indexes', dbData.indexes);
				updateFieldRequired('indexes', 0);

				// Update store
				setChoicesFieldValue('#jform_store', dbData.store);
				updateFieldRequired('store', 0);
			} else if (db) {
				// Reset datatype
				setChoicesFieldValue('#jform_datatype', '');

				// Reset datalenght
				setChoicesFieldValue('#jform_datalenght', '');
				updateFieldRequired('datalenght', 1);
				setChoicesFieldValue('#jform_datalenght_other', '');
				updateFieldRequired('datalenght_other', 1);

				// Reset datadefault
				setChoicesFieldValue('#jform_datadefault', '');
				updateFieldRequired('datadefault', 1);
				setChoicesFieldValue('#jform_datadefault_other', '');
				updateFieldRequired('datadefault_other', 1);

				// Reset indexes
				setChoicesFieldValue('#jform_indexes', '');
				updateFieldRequired('indexes', 1);

				// Reset store
				setChoicesFieldValue('#jform_store', 0);
			}
		})
		.catch(error => {
			console.error('[getFieldTypeProperties] Error:', error);
		});
}

function getFieldPropertyDesc(field, targetForm){
	// get the ID
	var id = jQuery(field).attr('id');
	// build the target array
	var target = id.split('__');
	// get property value
	var property = jQuery(field).val();
	// first check that there isn't any of this property type already set
	if (propertyIsSet(property, id, targetForm)) {
		// reset the selection
		jQuery('#'+id).val('');
		jQuery('#'+id).trigger("liszt:updated");
		// give out a notice
		jQuery.UIkit.notify({message: Joomla.Text._('COM_COMPONENTBUILDER_PROPERTY_ALREADY_SELECTED_TRY_ANOTHER'), timeout: 5000, status: 'warning', pos: 'top-center'});
		// update the values
		jQuery('#'+target[0]+'__desc').val('');
		jQuery('#'+target[0]+'__value').val('');
	} else {
		// do a dynamic update
		propertyDynamicSet();
		// get type value
		if (targetForm === 'properties') {
			var fieldtype = jQuery("#jform_fieldtype option:selected").val();
		} else {
			var fieldtype = 'extra';
		}
		getFieldPropertyDesc_server(fieldtype, property).done(function(result) {
			if(result.desc || result.value){
				// update the values
				jQuery('#'+target[0]+'__desc').val(result.desc);
				jQuery('#'+target[0]+'__value').val(result.value);
			} else {
				// update the values
				jQuery('#'+target[0]+'__desc').val(Joomla.Text._('COM_COMPONENTBUILDER_NO_DESCRIPTION_FOUND'));
				jQuery('#'+target[0]+'__value').val('');
			}
		});
	}
}

// set properties the options
propertiesArray = {};
var propertyIdRemoved;

function propertyDynamicSet() {
	propertiesAvailable = {};
	propertiesSelectedArray = {};
	propertiesTrackerArray = {};
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = rowIdKey+'_'+rowIdKey+i+'__name';
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length && propertyIdRemoved !== id_check) {
			// build the selected array
			var key =  jQuery("#"+id_check+" option:selected").val();
			var text =  jQuery("#"+id_check+" option:selected").text();
			propertiesSelectedArray[key] = text;
			// keep track of the value set
			propertiesTrackerArray[id_check] = key;
			// clear the options out
			jQuery("#"+id_check).find('option').remove().end();
		}
	}
	// trigger chosen on the list fields
	// jQuery('.field_list_name_options').chosen({"disable_search_threshold":10,"search_contains":true,"allow_single_deselect":true,"placeholder_text_multiple":Joomla.Text._("COM_COMPONENTBUILDER_TYPE_OR_SELECT_SOME_OPTIONS"),"placeholder_text_single":Joomla.Text._("COM_COMPONENTBUILDER_SELECT_A_PROPERTY"),"no_results_text":Joomla.Text._("COM_COMPONENTBUILDER_NO_RESULTS_MATCH")});
	// now build the list to keep
	jQuery.each( propertiesArray, function( prop, name ) {
		if (!propertiesSelectedArray.hasOwnProperty(prop)) {
			propertiesAvailable[prop] = name;
		}
	});
	// now add the lists back
	jQuery.each( propertiesTrackerArray, function( tId, tKey ) {
		if (jQuery('#'+tId).length) {
			jQuery('#'+tId).append('<option value="'+tKey+'">'+propertiesSelectedArray[tKey]+'</option>');
			jQuery.each( propertiesAvailable, function( aKey, aValue ) {
				jQuery('#'+tId).append('<option value="'+aKey+'">'+aValue+'</option>');
			});
			jQuery('#'+tId).val(tKey);
			jQuery('#'+tId).trigger('liszt:updated');
		}
	});
}

function rowWatcher() {
	jQuery(document).on('subform-row-remove', function(event, row){
       		propertyIdRemoved = jQuery(row.innerHTML).find('.field_list_name_options').attr('id');
       		propertyDynamicSet();
	});
	jQuery(document).on('subform-row-add', function(event, row){
       		propertyDynamicSet();
	});
}

function propertyIsSet(prop, id, targetForm) {
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = targetForm+'_'+targetForm+i+'__name';
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length && id_check != id) {
			// get the property value
			var tmp = jQuery("#"+id_check+" option:selected").val();
			// now validate
			if (tmp === prop) {
				return true;
			}
		}
	}
	return false;
}

function getFieldPropertyDesc_server(fieldtype, property){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getFieldPropertyDesc&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && (fieldtype > 0 || fieldtype.length > 0) && property.length > 0){
		var request = token+'=1&fieldtype='+fieldtype+'&property='+property;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getValidationRulesTable(){
	getCodeFrom_server(1,'type','type', 'getValidationRulesTable').then(function(result) {
		if(result){
			jQuery('#display_validation_rules').html(result);
		}
	});
}

function dbChecker(type){
	if ('note' === type || 'spacer' === type) {
		// update the datatype selection
		jQuery('#jform_datatype').val('').trigger('liszt:updated').change();
		jQuery('#jform_datalenght').val('').trigger('liszt:updated').change();
		jQuery('#jform_datadefault').val('').trigger('liszt:updated').change();
		jQuery('#jform_datadefault').val('').trigger('liszt:updated').change();
		jQuery('#jform_indexes').val(0).trigger('liszt:updated').change();
		jQuery('#jform_store').val(0).trigger('liszt:updated').change();
		// remove the datatype
		jQuery('#jform_datatype-lbl').closest('.control-group').hide();
		jQuery('#jform_datatype').closest('.control-group').hide();
		updateFieldRequired('datatype',1);
		jQuery('#jform_datatype').removeAttr('required');
		jQuery('#jform_datatype').removeAttr('aria-required');
		jQuery('#jform_datatype').removeClass('required');
		// remove the null selection
		jQuery('#jform_null_switch-lbl').closest('.control-group').hide();
		jQuery('#jform_null_switch').closest('.control-group').hide();
		updateFieldRequired('null_switch',1);
		jQuery('#jform_null_switch').removeAttr('required');
		jQuery('#jform_null_switch').removeAttr('aria-required');
		jQuery('#jform_null_switch').removeClass('required');
		// remove the store (modeling method)
		jQuery('#jform_store-lbl').closest('.control-group').hide();
		jQuery('#jform_store').closest('.control-group').hide();
		updateFieldRequired('store',1);
		jQuery('#jform_store').removeAttr('required');
		jQuery('#jform_store').removeAttr('aria-required');
		jQuery('#jform_store').removeClass('required');
		// show notice
		jQuery('.note_no_database_settings_needed').closest('.control-group').show();
		jQuery('.note_database_settings_needed').closest('.control-group').hide();
	} else {
		// add the datatype
		jQuery('#jform_datatype-lbl').closest('.control-group').show();
		jQuery('#jform_datatype').closest('.control-group').show();
		updateFieldRequired('datatype',0);
		jQuery('#jform_datatype').prop('required','required');
		jQuery('#jform_datatype').attr('aria-required',true);
		jQuery('#jform_datatype').addClass('required');
		// add the null selection
		jQuery('#jform_null_switch-lbl').closest('.control-group').show();
		jQuery('#jform_null_switch').closest('.control-group').show();
		updateFieldRequired('null_switch',0);
		jQuery('#jform_null_switch').prop('required','required');
		jQuery('#jform_null_switch').attr('aria-required',true);
		jQuery('#jform_null_switch').addClass('required');
		// remove the store (modeling method)
		jQuery('#jform_store-lbl').closest('.control-group').show();
		jQuery('#jform_store').closest('.control-group').show();
		updateFieldRequired('store',0);
		jQuery('#jform_store').prop('required','required');
		jQuery('#jform_store').attr('aria-required',true);
		jQuery('#jform_store').addClass('required');
		// remove notice
		jQuery('.note_no_database_settings_needed').closest('.control-group').hide();
		jQuery('.note_database_settings_needed').closest('.control-group').show();
	}
}

/**
 * Fetch data from the server with validated parameters.
 *
 * @param  {number|string} id          The record ID (integer > 0 or string > 30 chars)
 * @param  {string}        type        The type value to send
 * @param  {string}        typeName    The type parameter name (e.g. "type" or "context")
 * @param  {string}        callingName The AJAX task name (e.g. "getCode")
 * @global   {string}        token       The CSRF token name or key
 * @global   {string}        vastDevMod  The developer key or mode flag (optional)
 *
 * @return {Promise<object|null>}      Returns parsed JSON data or null on failure
 * @since  3.1.2
 */
async function getCodeFrom_server(id, type, typeName, callingName) {
	try {
		// --- Validation ---
		if (!getCodeFrom_isValidId(id)) {
			console.error('[getCodeFrom_server] Invalid ID provided:', id);
			return null;
		}
		if (typeof type !== 'string' || !type.trim()) {
			console.error('[getCodeFrom_server] Invalid type provided:', type);
			return null;
		}
		if (typeof typeName !== 'string' || !typeName.trim()) {
			console.error('[getCodeFrom_server] Invalid typeName provided:', typeName);
			return null;
		}
		if (typeof callingName !== 'string' || !callingName.trim()) {
			console.error('[getCodeFrom_server] Invalid callingName provided:', callingName);
			return null;
		}
		if (typeof token !== 'string' || !token.trim()) {
			console.error('[getCodeFrom_server] Missing security token.');
			return null;
		}

		// --- Construct URL safely ---
		const baseUrl = 'index.php';
		const params = new URLSearchParams({
			option: 'com_componentbuilder',
			task: `ajax.${callingName}`,
			format: 'json',
			raw: 'true',
			[token]: '1',
			[typeName]: type,
			id: id
		});
		if (vastDevMod) params.append('vdm', vastDevMod);

		const fullUrl = JRouter(`${baseUrl}?${params.toString()}`);

		// --- Execute request ---
		const response = await fetch(fullUrl, {
			method: 'GET',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			cache: 'no-store',
			credentials: 'same-origin'
		});

		// --- Validate HTTP response ---
		if (!response.ok) {
			console.error(`[getCodeFromServer] Server responded with status ${response.status}: ${response.statusText}`);
			return null;
		}

		// --- Parse JSON response ---
		const data = await response.json();
		return data ?? null;

	} catch (error) {
		console.error('[getCodeFromServer] Fetch operation failed:', error);
		return null;
	}
}

/**
 * Validate if the given ID is acceptable.
 *
 * @param  {number|string} id  The ID value to validate.
 * @return {boolean}           True if valid, false otherwise.
 * @since  3.1.2
 */
function getCodeFrom_isValidId(id) {
	if (typeof id === 'number') {
		return Number.isInteger(id) && id > 0;
	}
	if (typeof id === 'string') {
		return id.trim().length > 30;
	}
	return false;
}

function getLinked() {
	getCodeFrom_server(1, 'type', 'type', 'getLinked').then(function(result) {
		if (result.error) {
			console.error(result.error);
		} else if (result) {
			document.getElementById('display_linked_to').innerHTML = result;
		}
	});
}

/**
 * Fetches button data from the server.
 *
 * @param  {string} type        The button type identifier.
 * @param  {number} size        The button size indicator (default: 1).
 * @global  {string} token       The CSRF token key.
 * @global  {string} vastDevMod  Developer mode flag (optional).
 *
 * @return {Promise<object|null>} Returns JSON data or null on failure.
 * @since  3.1.3
 */
async function addButton_server(type, size = 1) {
	try {
		// --- Validate input ---
		if (typeof type !== 'string' || !type.trim()) {
			console.error('[addButton_server] Invalid type provided:', type);
			return null;
		}
		if (typeof token !== 'string' || !token.trim()) {
			console.error('[addButton_server] Missing CSRF token.');
			return null;
		}

		// --- Build URL and query ---
		const baseUrl = 'index.php';
		const params = new URLSearchParams({
			option: 'com_componentbuilder',
			task: 'ajax.getButton',
			format: 'json',
			raw: 'true',
			[token]: '1',
			type: type,
			size: size
		});
		if (vastDevMod) params.append('vdm', vastDevMod);

		const fullUrl = JRouter(`${baseUrl}?${params.toString()}`);

		// --- Fetch the data ---
		const response = await fetch(fullUrl, {
			method: 'GET',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			cache: 'no-store',
			credentials: 'same-origin'
		});

		if (!response.ok) {
			console.error(`[addButton_server] Server responded with ${response.status}: ${response.statusText}`);
			return null;
		}

		const data = await response.json();
		return data ?? null;
	} catch (error) {
		console.error('[addButton_server] Fetch failed:', error);
		return null;
	}
}

/**
 * Handles button rendering into the DOM.
 *
 * @param  {string} type   The button type identifier.
 * @param  {string} where  The target element ID or selector.
 * @param  {number} size   Optional button size (default: 1).
 * @global  {string} token  The CSRF token key.
 * @global  {string} vastDevMod  Developer mode flag (optional).
 *
 * @return {Promise<void>}
 * @since  3.1.3
 */
async function addButton(type, where, size) {
	const result = await addButton_server(type, size);

	if (!result) {
		console.warn('[addButton] No button data returned from server.');
		return;
	}

	const target = document.querySelector(size === 2 ? `#${where}` : `#jform_${where}`);
	if (!target) {
		console.error('[addButton] Target element not found:', where);
		return;
	}

	if (size === 2) {
		target.innerHTML = result;
	} else {
		addData(result, target);
	}
}

/**
 * Insert a new HTML element or markup right after
 * the closest `.control-group` ancestor of the target element.
 *
 * Equivalent to:
 *   jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
 *
 * @param  {string|HTMLElement} result  The HTML markup or DOM element to insert.
 * @param  {string}             where   A CSS selector or HTMLElement used to locate the `.control-group` ancestor.
 *
 * @return {void}
 * @since  3.1.3
 */
function addData(result, where) {
	try {
		// Resolve the base element (can be selector or element)
		const baseElement = typeof where === 'string'
			? document.querySelector(where)
			: where;

		if (!baseElement) {
			console.error('[addData] Target element not found:', where);
			return;
		}

		// Find the closest .control-group ancestor
		const controlGroup = baseElement.closest('.control-group');
		if (!controlGroup || !controlGroup.parentNode) {
			console.error('[addData] No .control-group ancestor found for:', where);
			return;
		}

		// Create or reuse element to insert
		let nodeToInsert;
		if (typeof result === 'string') {
			// Create a DOM node directly from HTML
			const wrapper = document.createElement('div');
			wrapper.innerHTML = result.trim();
			nodeToInsert = wrapper.firstElementChild;
		} else if (result instanceof HTMLElement) {
			nodeToInsert = result;
		} else {
			console.error('[addData] Invalid result type:', result);
			return;
		}

		// Insert the node after the .control-group element
		controlGroup.parentNode.insertBefore(nodeToInsert, controlGroup.nextSibling);
	} catch (error) {
		console.error('[addData] Error inserting element:', error);
	}
}

/**
 * Retrieve the Edit Custom Code buttons from the server.
 *
 * @param  {number} id  The record ID to load custom code buttons for.
 *
 * @return {Promise<object|null>}  Returns JSON object of buttons or null on failure.
 * @since  3.1.3
 */
async function getEditCustomCodeButtons_server(id) {
	try {
		// --- Validation ---
		if (typeof token !== 'string' || !token.trim()) {
			console.error('[getEditCustomCodeButtons_server] Missing or invalid CSRF token.');
			return null;
		}
		if (typeof id !== 'number' || id <= 0) {
			console.error('[getEditCustomCodeButtons_server] Invalid ID provided:', id);
			return null;
		}
		if (typeof return_here !== 'string' || !return_here.trim()) {
			console.warn('[getEditCustomCodeButtons_server] "return_here" not set; continuing without it.');
		}

		// --- Build URL safely ---
		const baseUrl = 'index.php';
		const params = new URLSearchParams({
			option: 'com_componentbuilder',
			task: 'ajax.getEditCustomCodeButtons',
			format: 'json',
			raw: 'true',
			[token]: '1',
			id: id,
			return_here: return_here || ''
		});
		if (typeof vastDevMod === 'string' && vastDevMod.length > 0) {
			params.append('vdm', vastDevMod);
		}

		const urlWithParams = JRouter(`${baseUrl}?${params.toString()}`);

		// --- Execute request ---
		const response = await fetch(urlWithParams, {
			method: 'GET',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			cache: 'no-store',
			credentials: 'same-origin'
		});

		// --- Handle network errors ---
		if (!response.ok) {
			console.error(`[getEditCustomCodeButtons_server] HTTP ${response.status}: ${response.statusText}`);
			return null;
		}

		// --- Parse JSON result ---
		const data = await response.json();
		return data ?? null;

	} catch (error) {
		console.error('[getEditCustomCodeButtons_server] Fetch failed:', error);
		return null;
	}
}

/**
 * Load and inject Edit Custom Code buttons into the DOM.
 *
 * @return {Promise<void>}
 * @since  3.1.3
 */
async function getEditCustomCodeButtons() {
	try {
		// --- Get record ID from the form ---
		const idField = document.querySelector('#jform_id');
		if (!idField) {
			console.error('[getEditCustomCodeButtons] #jform_id not found.');
			return;
		}

		const idValue = parseInt(idField.value, 10);
		if (isNaN(idValue) || idValue <= 0) {
			console.warn('[getEditCustomCodeButtons] Invalid or empty ID; skipping button load.');
			return;
		}

		// --- Request data from server ---
		const result = await getEditCustomCodeButtons_server(idValue);
		if (!result || typeof result !== 'object') {
			console.warn('[getEditCustomCodeButtons] No result returned or invalid format.');
			return;
		}

		// --- Inject returned button groups ---
		Object.entries(result).forEach(([field, buttons]) => {
			// Create the container div
			const div = document.createElement('div');
			div.className = 'control-group';
			div.innerHTML = `
<div class="control-label">
	<label>Add/Edit Customcode</label>
</div>
<div class="controls control-customcode-buttons-${field}"></div>
			`;

			// Find where to insert (before .control-wrapper-{field})
			const insertBeforeElement = document.querySelector(`.control-wrapper-${field}`);
			if (insertBeforeElement && insertBeforeElement.parentNode) {
				insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);
			}

			// Append buttons to the new container
			const controlsDiv = div.querySelector(`.control-customcode-buttons-${field}`);
			if (controlsDiv && typeof buttons === 'object') {
				Object.entries(buttons).forEach(([name, buttonHtml]) => {
					if (typeof buttonHtml === 'string') {
						const wrapper = document.createElement('div');
						wrapper.innerHTML = buttonHtml.trim();
						const buttonNode = wrapper.firstElementChild;
						if (buttonNode) {
							controlsDiv.appendChild(buttonNode);
						}
					}
				});
			}
		});
	} catch (error) {
		console.error('[getEditCustomCodeButtons] Error rendering buttons:', error);
	}
}

/**
 * Set a field value, trigger Joomla/Choices refresh,
 * and remove it from the required list when applicable.
 *
 * This ensures both the underlying value and visible UI remain synchronized.
 * If the element is a plain input (e.g. type="text"), Choices initialization is skipped.
 *
 * @param  {string} selector     CSS selector for the field element.
 * @param  {any}    value        The value to assign to the field.
 *
 * @return {void}
 * @since  5.1.3
 */
function setChoicesFieldValue(selector, value) {
	const field = document.querySelector(selector);
	if (!field) {
		return;
	}

	// Update the native field value
	field.value = value ?? '';

	// Skip Choices/FancySelect logic for plain input fields
	const tagName = field.tagName.toLowerCase();
	const fieldType = field.getAttribute('type') ? field.getAttribute('type').toLowerCase() : '';

	if (tagName === 'input' && (fieldType === 'text' || fieldType === 'number' || fieldType === 'email' || fieldType === 'url')) {
		// Trigger native change event for Joomla listeners
		field.dispatchEvent(new Event('change', { bubbles: true }));
		return;
	}

	// Ensure Choices or Joomla Fancy Select instance exists
	const choicesInstance = ensureChoicesInitialization(field);

	// Update the visible Choices UI if active
	if (choicesInstance) {
		try {
			choicesInstance.setChoiceByValue(String(value ?? ''));
			if (typeof choicesInstance._handleButtonAction === 'function') {
				choicesInstance._handleButtonAction();
			}
		} catch (err) {
			if (typeof choicesInstance.setValue === 'function') {
				choicesInstance.setValue(String(value ?? ''));
			}
		}
	}

	// Trigger native change event for Joomla listeners
	field.dispatchEvent(new Event('change', { bubbles: true }));
}

/**
 * Ensure a Joomla Fancy Select or Choices.js instance is initialized for a given field.
 *
 * This function checks whether the element already has a Choices/Fancy Select instance.
 * If not, it attempts to initialize one using Joomla.FieldChoices or a Choices.js fallback.
 *
 * @param  {HTMLElement} element  The field element to initialize.
 *
 * @return {object|null}          The initialized Choices/Fancy Select instance or null on failure.
 * @since  5.1.3
 */
function ensureChoicesInitialization(element) {
	if (!element) {
		return null;
	}

	// Detect existing wrapper or instance
	const fancyWrapper = element.closest('joomla-field-fancy-select');
	const existingChoices =
		element.choices ||
		(fancyWrapper && fancyWrapper.choicesInstance) ||
		(window.Joomla?.FieldChoices?.instances && Joomla.FieldChoices.instances[element.id]) ||
		null;

	// Return if already initialized
	if (existingChoices) {
		return existingChoices;
	}

	// Attempt Joomla FieldChoices initialization
	if (window.Joomla?.FieldChoices?.init) {
		try {
			const instance = Joomla.FieldChoices.init(element);
			return instance || null;
		} catch (e) {
			console.warn('ensureChoicesInitialization: Joomla FieldChoices.init failed', e);
		}
	}

	// Fallback: manually initialize Choices.js
	if (typeof Choices !== 'undefined') {
		try {
			const instance = new Choices(element, { shouldSort: false, searchEnabled: true });
			element.choices = instance;
			return instance;
		} catch (e) {
			console.warn('ensureChoicesInitialization: Choices fallback failed', e);
		}
	}

	return null;
}
