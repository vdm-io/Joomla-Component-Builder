/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwalvzu_required = false;
jform_vvvvwamvzv_required = false;
jform_vvvvwanvzw_required = false;
jform_vvvvwaovzx_required = false;
jform_vvvvwarvzy_required = false;
jform_vvvvwasvzz_required = false;
jform_vvvvwatwaa_required = false;
jform_vvvvwauwab_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwal = jQuery("#jform_datalenght").val();
	vvvvwal(datalenght_vvvvwal);

	var datadefault_vvvvwam = jQuery("#jform_datadefault").val();
	vvvvwam(datadefault_vvvvwam);

	var datatype_vvvvwan = jQuery("#jform_datatype").val();
	vvvvwan(datatype_vvvvwan);

	var datatype_vvvvwao = jQuery("#jform_datatype").val();
	vvvvwao(datatype_vvvvwao);

	var store_vvvvwap = jQuery("#jform_store").val();
	var datatype_vvvvwap = jQuery("#jform_datatype").val();
	vvvvwap(store_vvvvwap,datatype_vvvvwap);

	var add_css_view_vvvvwar = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwar(add_css_view_vvvvwar);

	var add_css_views_vvvvwas = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwas(add_css_views_vvvvwas);

	var add_javascript_view_footer_vvvvwat = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwat(add_javascript_view_footer_vvvvwat);

	var add_javascript_views_footer_vvvvwau = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwau(add_javascript_views_footer_vvvvwau);
});

// the vvvvwal function
function vvvvwal(datalenght_vvvvwal)
{
	if (isSet(datalenght_vvvvwal) && datalenght_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = datalenght_vvvvwal;
		var datalenght_vvvvwal = [];
		datalenght_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(datalenght_vvvvwal))
	{
		var datalenght_vvvvwal = [];
	}
	var datalenght = datalenght_vvvvwal.some(datalenght_vvvvwal_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwalvzu_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwalvzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwalvzu_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwalvzu_required = true;
		}
	}
}

// the vvvvwal Some function
function datalenght_vvvvwal_SomeFunc(datalenght_vvvvwal)
{
	// set the function logic
	if (datalenght_vvvvwal == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwam function
function vvvvwam(datadefault_vvvvwam)
{
	if (isSet(datadefault_vvvvwam) && datadefault_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = datadefault_vvvvwam;
		var datadefault_vvvvwam = [];
		datadefault_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(datadefault_vvvvwam))
	{
		var datadefault_vvvvwam = [];
	}
	var datadefault = datadefault_vvvvwam.some(datadefault_vvvvwam_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwamvzv_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwamvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwamvzv_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwamvzv_required = true;
		}
	}
}

// the vvvvwam Some function
function datadefault_vvvvwam_SomeFunc(datadefault_vvvvwam)
{
	// set the function logic
	if (datadefault_vvvvwam == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwan function
function vvvvwan(datatype_vvvvwan)
{
	if (isSet(datatype_vvvvwan) && datatype_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = datatype_vvvvwan;
		var datatype_vvvvwan = [];
		datatype_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(datatype_vvvvwan))
	{
		var datatype_vvvvwan = [];
	}
	var datatype = datatype_vvvvwan.some(datatype_vvvvwan_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwanvzw_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwanvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwanvzw_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwanvzw_required = true;
		}
	}
}

// the vvvvwan Some function
function datatype_vvvvwan_SomeFunc(datatype_vvvvwan)
{
	// set the function logic
	if (datatype_vvvvwan == 'CHAR' || datatype_vvvvwan == 'VARCHAR' || datatype_vvvvwan == 'DATETIME' || datatype_vvvvwan == 'DATE' || datatype_vvvvwan == 'TIME' || datatype_vvvvwan == 'INT' || datatype_vvvvwan == 'TINYINT' || datatype_vvvvwan == 'BIGINT' || datatype_vvvvwan == 'FLOAT' || datatype_vvvvwan == 'DECIMAL' || datatype_vvvvwan == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwao function
function vvvvwao(datatype_vvvvwao)
{
	if (isSet(datatype_vvvvwao) && datatype_vvvvwao.constructor !== Array)
	{
		var temp_vvvvwao = datatype_vvvvwao;
		var datatype_vvvvwao = [];
		datatype_vvvvwao.push(temp_vvvvwao);
	}
	else if (!isSet(datatype_vvvvwao))
	{
		var datatype_vvvvwao = [];
	}
	var datatype = datatype_vvvvwao.some(datatype_vvvvwao_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwaovzx_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwaovzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwaovzx_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwaovzx_required = true;
		}
	}
}

// the vvvvwao Some function
function datatype_vvvvwao_SomeFunc(datatype_vvvvwao)
{
	// set the function logic
	if (datatype_vvvvwao == 'CHAR' || datatype_vvvvwao == 'VARCHAR' || datatype_vvvvwao == 'TEXT' || datatype_vvvvwao == 'MEDIUMTEXT' || datatype_vvvvwao == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(store_vvvvwap,datatype_vvvvwap)
{
	if (isSet(store_vvvvwap) && store_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = store_vvvvwap;
		var store_vvvvwap = [];
		store_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(store_vvvvwap))
	{
		var store_vvvvwap = [];
	}
	var store = store_vvvvwap.some(store_vvvvwap_SomeFunc);

	if (isSet(datatype_vvvvwap) && datatype_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = datatype_vvvvwap;
		var datatype_vvvvwap = [];
		datatype_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(datatype_vvvvwap))
	{
		var datatype_vvvvwap = [];
	}
	var datatype = datatype_vvvvwap.some(datatype_vvvvwap_SomeFunc);


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

// the vvvvwap Some function
function store_vvvvwap_SomeFunc(store_vvvvwap)
{
	// set the function logic
	if (store_vvvvwap == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwap Some function
function datatype_vvvvwap_SomeFunc(datatype_vvvvwap)
{
	// set the function logic
	if (datatype_vvvvwap == 'CHAR' || datatype_vvvvwap == 'VARCHAR' || datatype_vvvvwap == 'TEXT' || datatype_vvvvwap == 'MEDIUMTEXT' || datatype_vvvvwap == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwar function
function vvvvwar(add_css_view_vvvvwar)
{
	// set the function logic
	if (add_css_view_vvvvwar == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwarvzy_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwarvzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwarvzy_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwarvzy_required = true;
		}
	}
}

// the vvvvwas function
function vvvvwas(add_css_views_vvvvwas)
{
	// set the function logic
	if (add_css_views_vvvvwas == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwasvzz_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwasvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwasvzz_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwasvzz_required = true;
		}
	}
}

// the vvvvwat function
function vvvvwat(add_javascript_view_footer_vvvvwat)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwat == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwatwaa_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwatwaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwatwaa_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwatwaa_required = true;
		}
	}
}

// the vvvvwau function
function vvvvwau(add_javascript_views_footer_vvvvwau)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwau == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwauwab_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwauwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwauwab_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwauwab_required = true;
		}
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
	getFieldOptions(fieldtype);
	// get the linked details
	getLinked();
	// get the validation rules
	getValidationRulesTable();
	// set button to create more fields
	addButton('validation_rule', 'validation_rules_header', 2);
});

function getLinked_server(type){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&vdm="+vastDevMod;
	if(token.length > 0 && type > 0){
		var request = 'token='+token+'&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
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
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = 'token='+token+'&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
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

// the options row id key
var rowIdKey = 'properties';

function getFieldOptions_server(fieldtype){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.fieldOptions&format=json&vdm="+vastDevMod;
	if(token.length > 0 && fieldtype > 0){
		var request = 'token='+token+'&id='+fieldtype;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getFieldOptions(fieldtype){
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getFieldPropertyDesc&format=json&vdm="+vastDevMod;
	if(token.length > 0 && (fieldtype > 0 || fieldtype.length > 0)&& property.length > 0){
		var request = 'token='+token+'&fieldtype='+fieldtype+'&property='+property;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}


function getValidationRulesTable_server(){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getValidationRulesTable&format=json&vdm="+vastDevMod;
	if(token.length > 0){
		var request = 'token='+token+'&id=1';
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getValidationRulesTable(){
	getValidationRulesTable_server().done(function(result) {
		if(result){
			jQuery('#display_validation_rules').html(result);
		}
	});
} 
