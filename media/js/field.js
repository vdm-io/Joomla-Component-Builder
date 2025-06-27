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
jform_vvvvwbdvwx_required = false;
jform_vvvvwbevwy_required = false;
jform_vvvvwbfvwz_required = false;
jform_vvvvwbgvxa_required = false;
jform_vvvvwbjvxb_required = false;
jform_vvvvwbjvxc_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var datalenght_vvvvwbd = jQuery("#jform_datalenght").val();
	vvvvwbd(datalenght_vvvvwbd);

	var datadefault_vvvvwbe = jQuery("#jform_datadefault").val();
	vvvvwbe(datadefault_vvvvwbe);

	var datatype_vvvvwbf = jQuery("#jform_datatype").val();
	vvvvwbf(datatype_vvvvwbf);

	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	vvvvwbg(datatype_vvvvwbg);

	var store_vvvvwbj = jQuery("#jform_store").val();
	vvvvwbj(store_vvvvwbj);

	var add_css_view_vvvvwbk = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwbk(add_css_view_vvvvwbk);

	var add_css_views_vvvvwbl = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwbl(add_css_views_vvvvwbl);

	var add_javascript_view_footer_vvvvwbm = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwbm(add_javascript_view_footer_vvvvwbm);

	var add_javascript_views_footer_vvvvwbn = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwbn(add_javascript_views_footer_vvvvwbn);
});

// the vvvvwbd function
function vvvvwbd(datalenght_vvvvwbd)
{
	if (isSet(datalenght_vvvvwbd) && datalenght_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = datalenght_vvvvwbd;
		var datalenght_vvvvwbd = [];
		datalenght_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(datalenght_vvvvwbd))
	{
		var datalenght_vvvvwbd = [];
	}
	var datalenght = datalenght_vvvvwbd.some(datalenght_vvvvwbd_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbdvwx_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbdvwx_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbdvwx_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbdvwx_required = true;
		}
	}
}

// the vvvvwbd Some function
function datalenght_vvvvwbd_SomeFunc(datalenght_vvvvwbd)
{
	// set the function logic
	if (datalenght_vvvvwbd == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbe function
function vvvvwbe(datadefault_vvvvwbe)
{
	if (isSet(datadefault_vvvvwbe) && datadefault_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = datadefault_vvvvwbe;
		var datadefault_vvvvwbe = [];
		datadefault_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(datadefault_vvvvwbe))
	{
		var datadefault_vvvvwbe = [];
	}
	var datadefault = datadefault_vvvvwbe.some(datadefault_vvvvwbe_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbevwy_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbevwy_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbevwy_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbevwy_required = true;
		}
	}
}

// the vvvvwbe Some function
function datadefault_vvvvwbe_SomeFunc(datadefault_vvvvwbe)
{
	// set the function logic
	if (datadefault_vvvvwbe == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbf function
function vvvvwbf(datatype_vvvvwbf)
{
	if (isSet(datatype_vvvvwbf) && datatype_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = datatype_vvvvwbf;
		var datatype_vvvvwbf = [];
		datatype_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(datatype_vvvvwbf))
	{
		var datatype_vvvvwbf = [];
	}
	var datatype = datatype_vvvvwbf.some(datatype_vvvvwbf_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbfvwz_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbfvwz_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbfvwz_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbfvwz_required = true;
		}
	}
}

// the vvvvwbf Some function
function datatype_vvvvwbf_SomeFunc(datatype_vvvvwbf)
{
	// set the function logic
	if (datatype_vvvvwbf == 'CHAR' || datatype_vvvvwbf == 'VARCHAR' || datatype_vvvvwbf == 'DATETIME' || datatype_vvvvwbf == 'DATE' || datatype_vvvvwbf == 'TIME' || datatype_vvvvwbf == 'INT' || datatype_vvvvwbf == 'TINYINT' || datatype_vvvvwbf == 'BIGINT' || datatype_vvvvwbf == 'FLOAT' || datatype_vvvvwbf == 'DECIMAL' || datatype_vvvvwbf == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbg function
function vvvvwbg(datatype_vvvvwbg)
{
	if (isSet(datatype_vvvvwbg) && datatype_vvvvwbg.constructor !== Array)
	{
		var temp_vvvvwbg = datatype_vvvvwbg;
		var datatype_vvvvwbg = [];
		datatype_vvvvwbg.push(temp_vvvvwbg);
	}
	else if (!isSet(datatype_vvvvwbg))
	{
		var datatype_vvvvwbg = [];
	}
	var datatype = datatype_vvvvwbg.some(datatype_vvvvwbg_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwbgvxa_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwbgvxa_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwbgvxa_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwbgvxa_required = true;
		}
	}
}

// the vvvvwbg Some function
function datatype_vvvvwbg_SomeFunc(datatype_vvvvwbg)
{
	// set the function logic
	if (datatype_vvvvwbg == 'CHAR' || datatype_vvvvwbg == 'VARCHAR' || datatype_vvvvwbg == 'INT' || datatype_vvvvwbg == 'TINYINT' || datatype_vvvvwbg == 'BIGINT' || datatype_vvvvwbg == 'FLOAT' || datatype_vvvvwbg == 'DECIMAL' || datatype_vvvvwbg == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbj function
function vvvvwbj(store_vvvvwbj)
{
	if (isSet(store_vvvvwbj) && store_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = store_vvvvwbj;
		var store_vvvvwbj = [];
		store_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(store_vvvvwbj))
	{
		var store_vvvvwbj = [];
	}
	var store = store_vvvvwbj.some(store_vvvvwbj_SomeFunc);


	// set this function logic
	if (store)
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').show();
		jQuery('#jform_initiator_on_save_model').closest('.control-group').show();
		jQuery('.note_expert_field_save_mode').closest('.control-group').show();
		jQuery('#jform_on_get_model_field').closest('.control-group').show();
		// add required attribute to on_get_model_field field
		if (jform_vvvvwbjvxb_required)
		{
			updateFieldRequired('on_get_model_field',0);
			jQuery('#jform_on_get_model_field').prop('required','required');
			jQuery('#jform_on_get_model_field').attr('aria-required',true);
			jQuery('#jform_on_get_model_field').addClass('required');
			jform_vvvvwbjvxb_required = false;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').show();
		// add required attribute to on_save_model_field field
		if (jform_vvvvwbjvxc_required)
		{
			updateFieldRequired('on_save_model_field',0);
			jQuery('#jform_on_save_model_field').prop('required','required');
			jQuery('#jform_on_save_model_field').attr('aria-required',true);
			jQuery('#jform_on_save_model_field').addClass('required');
			jform_vvvvwbjvxc_required = false;
		}
	}
	else
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').hide();
		jQuery('#jform_initiator_on_save_model').closest('.control-group').hide();
		jQuery('.note_expert_field_save_mode').closest('.control-group').hide();
		jQuery('#jform_on_get_model_field').closest('.control-group').hide();
		// remove required attribute from on_get_model_field field
		if (!jform_vvvvwbjvxb_required)
		{
			updateFieldRequired('on_get_model_field',1);
			jQuery('#jform_on_get_model_field').removeAttr('required');
			jQuery('#jform_on_get_model_field').removeAttr('aria-required');
			jQuery('#jform_on_get_model_field').removeClass('required');
			jform_vvvvwbjvxb_required = true;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').hide();
		// remove required attribute from on_save_model_field field
		if (!jform_vvvvwbjvxc_required)
		{
			updateFieldRequired('on_save_model_field',1);
			jQuery('#jform_on_save_model_field').removeAttr('required');
			jQuery('#jform_on_save_model_field').removeAttr('aria-required');
			jQuery('#jform_on_save_model_field').removeClass('required');
			jform_vvvvwbjvxc_required = true;
		}
	}
}

// the vvvvwbj Some function
function store_vvvvwbj_SomeFunc(store_vvvvwbj)
{
	// set the function logic
	if (store_vvvvwbj == 6)
	{
		return true;
	}
	return false;
}

// the vvvvwbk function
function vvvvwbk(add_css_view_vvvvwbk)
{
	// set the function logic
	if (add_css_view_vvvvwbk == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbl function
function vvvvwbl(add_css_views_vvvvwbl)
{
	// set the function logic
	if (add_css_views_vvvvwbl == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbm function
function vvvvwbm(add_javascript_view_footer_vvvvwbm)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwbm == 1)
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbn function
function vvvvwbn(add_javascript_views_footer_vvvvwbn)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwbn == 1)
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').hide();
	}
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (document.getElementById('jform_not_required')) {
		var not_required = jQuery('#jform_not_required').val().split(",");

		if(status == 1)
		{
			not_required.push(name);
		}
		else
		{
			not_required = removeFieldFromNotRequired(not_required, name);
		}

		jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());
	}
}

// remove field from not_required
function removeFieldFromNotRequired(array, what) {
	return array.filter(function(element){
		return element !== what;
	});
}

// fix not required array
function fixNotRequiredArray(array) {
	var seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function(item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

// remove empty from not_required array
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		// remove ( 一_一) as well - lol
		return (el.length > 0 && '一_一' !== el);
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

function getFieldTypeProperties(fieldtype, db){
	getCodeFrom_server(fieldtype, 'type', 'type', 'fieldTypeProperties').then(function(result) {
		if(result.subform){
			// load the list of properties
			propertiesArray = result.nameListOptions;
			// remove previous forms of exist
			jQuery('.prop_removal').remove();
			// hide notice
			jQuery('.note_select_field_type').closest('.control-group').remove();
			// append to note_filter_information class
			jQuery('.note_filter_information').closest('.control-group').prepend(result.extra);
			// append to note_filter_information class
			if(result.textarea){
				jQuery.each( result.textarea, function( i, tField ) {
					// append to note_filter_information class
					jQuery('.note_filter_information').closest('.control-group').prepend(tField);
				});
			}
			// append to note_filter_information class
			jQuery('.note_filter_information').closest('.control-group').prepend(result.subform);
			// add the watcher
			rowWatcher();
			// initialize the new form
			jQuery('div.subform-repeatable').trigger('update');
			// jQuery('div.subform-repeatable').subformRepeatable();
			// update all the list fields to only show items not selected already
			propertyDynamicSet();
			// set the field type info
			jQuery('#help').remove();
			jQuery('.helpNote').append('<div id="help">'+result.description+'<br />'+result.values_description+'</div>');
			// load the database properties if not set and defaults were found
			if (db && result.database){
				// update datatype
				jQuery('#jform_datatype').val(result.database.datatype);
				jQuery('#jform_datatype').trigger("liszt:updated");
				jQuery('#jform_datatype').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('datatype', 0);
				// update datalenght
				jQuery('#jform_datalenght').val(result.database.datalenght);
				jQuery('#jform_datalenght').trigger("liszt:updated");
				jQuery('#jform_datalenght').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('datalenght', 0);
				// load the datalenght_other if needed
				if ('Other' === result.database.datalenght){
					jQuery('#jform_datalenght_other').val(result.database.datalenght_other);
					// be sure to remove from no required
					updateFieldRequired('datalenght_other', 0);
				}
				// update datadefault
				jQuery('#jform_datadefault').val(result.database.datadefault);
				jQuery('#jform_datadefault').trigger("liszt:updated");
				jQuery('#jform_datadefault').trigger("change");
				// load the datadefault_other if needed
				if ('Other' === result.database.datadefault){
					jQuery('#jform_datadefault_other').val(result.database.datadefault_other);
					// be sure to remove from no required
					updateFieldRequired('datadefault_other', 0);
				}
				// update indexes
				jQuery('#jform_indexes').val(result.database.indexes);
				jQuery('#jform_indexes').trigger("liszt:updated");
				jQuery('#jform_indexes').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('indexes', 0);
				// update store
				jQuery('#jform_store').val(result.database.store);
				jQuery('#jform_store').trigger("liszt:updated");
				jQuery('#jform_store').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('store', 0);
			}
		}
	})
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

function getCodeFrom_server(id, type, type_name, callingName) {
	var url = "index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod;
	if (token.length > 0 && getCodeFrom_isValidId(id) && type.length > 0) {
		url += '&' + token + '=1&' + type_name + '=' + type + '&id=' + id;
	} else {
		console.error('There was a issue with the values passed to the [getCodeFrom_server] method and we could not make the Ajax call.');
		return;
	}
	var getUrl = JRouter(url);
	return fetch(getUrl, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function(response) {
		if (response.ok) {
			return response.json();
		} else {
			throw new Error('Network response was not ok');
		}
	}).then(function(data) {
		return data;
	}).catch(function(error) {
		console.error('There was a problem with the fetch operation:', error);
	});
}
function getCodeFrom_isValidId(id) {
    if (typeof id === 'number') {
        // Check if it's a positive integer
        return Number.isInteger(id) && id > 0;
    } else if (typeof id === 'string') {
        // Check if it's a string of length > 30
        return id.length > 30;
    }
    // If neither a number nor a string, return false
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

function addButton_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButton(type, where, size){
	// just to insure that default behaviour still works
	size = typeof size !== 'undefined' ? size : 1;
	addButton_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	})
}

function getEditCustomCodeButtons_server(id) {
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	let requestParams = '';
	if (token.length > 0 && id > 0) {
		requestParams = token+'=1&id='+id+'&return_here='+return_here;
	}
	// Construct URL with parameters for GET request
	const urlWithParams = getUrl + '&' + requestParams;

	// Using the Fetch API for the GET request
	return fetch(urlWithParams, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		return response.json();
	});
}

function getEditCustomCodeButtons() {
	// Get the id using pure JavaScript
	const id = document.querySelector("#jform_id").value;
	getEditCustomCodeButtons_server(id).then(function(result) {
		if (typeof result === 'object') {
			Object.entries(result).forEach(([field, buttons]) => {
				// Creating the div element for buttons
				const div = document.createElement('div');
				div.className = 'control-group';
				div.innerHTML = '<div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div>';

				// Insert the div before .control-wrapper-{field}
				const insertBeforeElement = document.querySelector(".control-wrapper-"+field);
				if (insertBeforeElement) {
					insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);
				}

				// Adding buttons to the div
				Object.entries(buttons).forEach(([name, button]) => {
					const controlsDiv = document.querySelector(".control-customcode-buttons-"+field);
					if (controlsDiv) {
						controlsDiv.innerHTML += button;
					}
				});
			});
		}
	}).catch(error => {
		console.error('Error:', error);
	});
}
