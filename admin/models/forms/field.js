/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwbtvxl_required = false;
jform_vvvvwbuvxm_required = false;
jform_vvvvwbvvxn_required = false;
jform_vvvvwbwvxo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwbt = jQuery("#jform_datalenght").val();
	vvvvwbt(datalenght_vvvvwbt);

	var datadefault_vvvvwbu = jQuery("#jform_datadefault").val();
	vvvvwbu(datadefault_vvvvwbu);

	var datatype_vvvvwbv = jQuery("#jform_datatype").val();
	vvvvwbv(datatype_vvvvwbv);

	var datatype_vvvvwbw = jQuery("#jform_datatype").val();
	vvvvwbw(datatype_vvvvwbw);

	var store_vvvvwbx = jQuery("#jform_store").val();
	var datatype_vvvvwbx = jQuery("#jform_datatype").val();
	vvvvwbx(store_vvvvwbx,datatype_vvvvwbx);

	var add_css_view_vvvvwbz = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwbz(add_css_view_vvvvwbz);

	var add_css_views_vvvvwca = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwca(add_css_views_vvvvwca);

	var add_javascript_view_footer_vvvvwcb = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwcb(add_javascript_view_footer_vvvvwcb);

	var add_javascript_views_footer_vvvvwcc = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwcc(add_javascript_views_footer_vvvvwcc);
});

// the vvvvwbt function
function vvvvwbt(datalenght_vvvvwbt)
{
	if (isSet(datalenght_vvvvwbt) && datalenght_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = datalenght_vvvvwbt;
		var datalenght_vvvvwbt = [];
		datalenght_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(datalenght_vvvvwbt))
	{
		var datalenght_vvvvwbt = [];
	}
	var datalenght = datalenght_vvvvwbt.some(datalenght_vvvvwbt_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbtvxl_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbtvxl_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbtvxl_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbtvxl_required = true;
		}
	}
}

// the vvvvwbt Some function
function datalenght_vvvvwbt_SomeFunc(datalenght_vvvvwbt)
{
	// set the function logic
	if (datalenght_vvvvwbt == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbu function
function vvvvwbu(datadefault_vvvvwbu)
{
	if (isSet(datadefault_vvvvwbu) && datadefault_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = datadefault_vvvvwbu;
		var datadefault_vvvvwbu = [];
		datadefault_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(datadefault_vvvvwbu))
	{
		var datadefault_vvvvwbu = [];
	}
	var datadefault = datadefault_vvvvwbu.some(datadefault_vvvvwbu_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbuvxm_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbuvxm_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbuvxm_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbuvxm_required = true;
		}
	}
}

// the vvvvwbu Some function
function datadefault_vvvvwbu_SomeFunc(datadefault_vvvvwbu)
{
	// set the function logic
	if (datadefault_vvvvwbu == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbv function
function vvvvwbv(datatype_vvvvwbv)
{
	if (isSet(datatype_vvvvwbv) && datatype_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = datatype_vvvvwbv;
		var datatype_vvvvwbv = [];
		datatype_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(datatype_vvvvwbv))
	{
		var datatype_vvvvwbv = [];
	}
	var datatype = datatype_vvvvwbv.some(datatype_vvvvwbv_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbvvxn_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbvvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbvvxn_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbvvxn_required = true;
		}
	}
}

// the vvvvwbv Some function
function datatype_vvvvwbv_SomeFunc(datatype_vvvvwbv)
{
	// set the function logic
	if (datatype_vvvvwbv == 'CHAR' || datatype_vvvvwbv == 'VARCHAR' || datatype_vvvvwbv == 'DATETIME' || datatype_vvvvwbv == 'DATE' || datatype_vvvvwbv == 'TIME' || datatype_vvvvwbv == 'INT' || datatype_vvvvwbv == 'TINYINT' || datatype_vvvvwbv == 'BIGINT' || datatype_vvvvwbv == 'FLOAT' || datatype_vvvvwbv == 'DECIMAL' || datatype_vvvvwbv == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbw function
function vvvvwbw(datatype_vvvvwbw)
{
	if (isSet(datatype_vvvvwbw) && datatype_vvvvwbw.constructor !== Array)
	{
		var temp_vvvvwbw = datatype_vvvvwbw;
		var datatype_vvvvwbw = [];
		datatype_vvvvwbw.push(temp_vvvvwbw);
	}
	else if (!isSet(datatype_vvvvwbw))
	{
		var datatype_vvvvwbw = [];
	}
	var datatype = datatype_vvvvwbw.some(datatype_vvvvwbw_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbwvxo_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbwvxo_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbwvxo_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbwvxo_required = true;
		}
	}
}

// the vvvvwbw Some function
function datatype_vvvvwbw_SomeFunc(datatype_vvvvwbw)
{
	// set the function logic
	if (datatype_vvvvwbw == 'CHAR' || datatype_vvvvwbw == 'VARCHAR' || datatype_vvvvwbw == 'TEXT' || datatype_vvvvwbw == 'MEDIUMTEXT' || datatype_vvvvwbw == 'LONGTEXT' || datatype_vvvvwbw == 'BLOB' || datatype_vvvvwbw == 'TINYBLOB' || datatype_vvvvwbw == 'MEDIUMBLOB' || datatype_vvvvwbw == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbx function
function vvvvwbx(store_vvvvwbx,datatype_vvvvwbx)
{
	if (isSet(store_vvvvwbx) && store_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = store_vvvvwbx;
		var store_vvvvwbx = [];
		store_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(store_vvvvwbx))
	{
		var store_vvvvwbx = [];
	}
	var store = store_vvvvwbx.some(store_vvvvwbx_SomeFunc);

	if (isSet(datatype_vvvvwbx) && datatype_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = datatype_vvvvwbx;
		var datatype_vvvvwbx = [];
		datatype_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(datatype_vvvvwbx))
	{
		var datatype_vvvvwbx = [];
	}
	var datatype = datatype_vvvvwbx.some(datatype_vvvvwbx_SomeFunc);


	// set this function logic
	if (store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwbx Some function
function store_vvvvwbx_SomeFunc(store_vvvvwbx)
{
	// set the function logic
	if (store_vvvvwbx == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbx Some function
function datatype_vvvvwbx_SomeFunc(datatype_vvvvwbx)
{
	// set the function logic
	if (datatype_vvvvwbx == 'CHAR' || datatype_vvvvwbx == 'VARCHAR' || datatype_vvvvwbx == 'TEXT' || datatype_vvvvwbx == 'MEDIUMTEXT' || datatype_vvvvwbx == 'LONGTEXT' || datatype_vvvvwbx == 'BLOB' || datatype_vvvvwbx == 'TINYBLOB' || datatype_vvvvwbx == 'MEDIUMBLOB' || datatype_vvvvwbx == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbz function
function vvvvwbz(add_css_view_vvvvwbz)
{
	// set the function logic
	if (add_css_view_vvvvwbz == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvwca function
function vvvvwca(add_css_views_vvvvwca)
{
	// set the function logic
	if (add_css_views_vvvvwca == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
	}
}

// the vvvvwcb function
function vvvvwcb(add_javascript_view_footer_vvvvwcb)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwcb == 1)
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvwcc function
function vvvvwcc(add_javascript_views_footer_vvvvwcc)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwcc == 1)
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').hide();
	}
}

// update required fields
function updateFieldRequired(name,status)
{
	var not_required = jQuery('#jform_not_required').val();

	if(status == 1)
	{
		if (isSet(not_required) && not_required != 0)
		{
			not_required = not_required+','+name;
		}
		else
		{
			not_required = ','+name;
		}
	}
	else
	{
		if (isSet(not_required) && not_required != 0)
		{
			not_required = not_required.replace(','+name,'');
		}
	}

	jQuery('#jform_not_required').val(not_required);
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
	getFieldOptions(fieldtype, false);
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

function getFieldOptions_server(fieldtype){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.fieldOptions&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && fieldtype > 0){
		var request = token+'=1&id='+fieldtype;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getFieldOptions(fieldtype, db){
	getFieldOptions_server(fieldtype).done(function(result) {
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
			jQuery('div.subform-repeatable').subformRepeatable();
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
				// update datalenght
				jQuery('#jform_datalenght').val(result.database.datalenght);
				jQuery('#jform_datalenght').trigger("liszt:updated");
				jQuery('#jform_datalenght').trigger("change");
				// load the datalenght_other if needed
				if ('Other' == result.database.datalenght){
					jQuery('#jform_datalenght_other').val(result.database.datalenght_other);
				}
				// update datadefault
				jQuery('#jform_datadefault').val(result.database.datadefault);
				jQuery('#jform_datadefault').trigger("liszt:updated");
				jQuery('#jform_datadefault').trigger("change");
				// load the datadefault_other if needed
				if ('Other' == result.database.datadefault){
					jQuery('#jform_datadefault_other').val(result.database.datadefault_other);
				}
				// update indexes
				jQuery('#jform_indexes').val(result.database.indexes);
				jQuery('#jform_indexes').trigger("liszt:updated");
				jQuery('#jform_indexes').trigger("change");
				// update store
				jQuery('#jform_store').val(result.database.store);
				jQuery('#jform_store').trigger("liszt:updated");
				jQuery('#jform_store').trigger("change");
				// update null_switch (hmmm)
				// jQuery('#jform_null_switch').val(result.database.null_switch);
				// jQuery('#jform_null_switch').trigger("change");
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
		jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_PROPERTY_ALREADY_SELECTED_TRY_ANOTHER'), timeout: 5000, status: 'warning', pos: 'top-center'});
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
				jQuery('#'+target[0]+'__desc').val(Joomla.JText._('COM_COMPONENTBUILDER_NO_DESCRIPTION_FOUND'));
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
	jQuery('.field_list_name_options').chosen({"disable_search_threshold":10,"search_contains":true,"allow_single_deselect":true,"placeholder_text_multiple":Joomla.JText._("COM_COMPONENTBUILDER_TYPE_OR_SELECT_SOME_OPTIONS"),"placeholder_text_single":Joomla.JText._("COM_COMPONENTBUILDER_SELECT_A_PROPERTY"),"no_results_text":Joomla.JText._("COM_COMPONENTBUILDER_NO_RESULTS_MATCH")});
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
	if(token.length > 0 && (fieldtype > 0 || fieldtype.length > 0)&& property.length > 0){
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


function getValidationRulesTable_server(){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getValidationRulesTable&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0){
		var request = token+'=1&id=1';
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
	getValidationRulesTable_server().done(function(result) {
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
		// remove notice
		jQuery('.note_no_database_settings_needed').closest('.control-group').hide();
		jQuery('.note_database_settings_needed').closest('.control-group').show();
	}
}

function getLinked_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type > 0){
		var request = token+'=1&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
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

function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getEditCustomCodeButtons(){
	// get the id
	id = jQuery("#jform_id").val();
	getEditCustomCodeButtons_server(id).done(function(result) {
		if(isObject(result)){
			jQuery.each(result, function( field, buttons ) {
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
				jQuery.each(buttons, function( name, button ) {
					jQuery(".control-customcode-buttons-"+field).append(button);
				});
			});
		}
	})
}

// check object is not empty
function isObject(obj) {
	for(var prop in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, prop)) {
			return true;
		}
	}
	return false;
} 
