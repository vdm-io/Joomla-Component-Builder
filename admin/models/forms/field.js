/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwamvzv_required = false;
jform_vvvvwanvzw_required = false;
jform_vvvvwaovzx_required = false;
jform_vvvvwapvzy_required = false;
jform_vvvvwasvzz_required = false;
jform_vvvvwatwaa_required = false;
jform_vvvvwauwab_required = false;
jform_vvvvwavwac_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwam = jQuery("#jform_datalenght").val();
	vvvvwam(datalenght_vvvvwam);

	var datadefault_vvvvwan = jQuery("#jform_datadefault").val();
	vvvvwan(datadefault_vvvvwan);

	var datatype_vvvvwao = jQuery("#jform_datatype").val();
	vvvvwao(datatype_vvvvwao);

	var datatype_vvvvwap = jQuery("#jform_datatype").val();
	vvvvwap(datatype_vvvvwap);

	var store_vvvvwaq = jQuery("#jform_store").val();
	var datatype_vvvvwaq = jQuery("#jform_datatype").val();
	vvvvwaq(store_vvvvwaq,datatype_vvvvwaq);

	var add_css_view_vvvvwas = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwas(add_css_view_vvvvwas);

	var add_css_views_vvvvwat = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwat(add_css_views_vvvvwat);

	var add_javascript_view_footer_vvvvwau = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwau(add_javascript_view_footer_vvvvwau);

	var add_javascript_views_footer_vvvvwav = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwav(add_javascript_views_footer_vvvvwav);
});

// the vvvvwam function
function vvvvwam(datalenght_vvvvwam)
{
	if (isSet(datalenght_vvvvwam) && datalenght_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = datalenght_vvvvwam;
		var datalenght_vvvvwam = [];
		datalenght_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(datalenght_vvvvwam))
	{
		var datalenght_vvvvwam = [];
	}
	var datalenght = datalenght_vvvvwam.some(datalenght_vvvvwam_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwamvzv_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwamvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwamvzv_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwamvzv_required = true;
		}
	}
}

// the vvvvwam Some function
function datalenght_vvvvwam_SomeFunc(datalenght_vvvvwam)
{
	// set the function logic
	if (datalenght_vvvvwam == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwan function
function vvvvwan(datadefault_vvvvwan)
{
	if (isSet(datadefault_vvvvwan) && datadefault_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = datadefault_vvvvwan;
		var datadefault_vvvvwan = [];
		datadefault_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(datadefault_vvvvwan))
	{
		var datadefault_vvvvwan = [];
	}
	var datadefault = datadefault_vvvvwan.some(datadefault_vvvvwan_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwanvzw_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwanvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwanvzw_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwanvzw_required = true;
		}
	}
}

// the vvvvwan Some function
function datadefault_vvvvwan_SomeFunc(datadefault_vvvvwan)
{
	// set the function logic
	if (datadefault_vvvvwan == 'Other')
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
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwaovzx_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwaovzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwaovzx_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwaovzx_required = true;
		}
	}
}

// the vvvvwao Some function
function datatype_vvvvwao_SomeFunc(datatype_vvvvwao)
{
	// set the function logic
	if (datatype_vvvvwao == 'CHAR' || datatype_vvvvwao == 'VARCHAR' || datatype_vvvvwao == 'DATETIME' || datatype_vvvvwao == 'DATE' || datatype_vvvvwao == 'TIME' || datatype_vvvvwao == 'INT' || datatype_vvvvwao == 'TINYINT' || datatype_vvvvwao == 'BIGINT' || datatype_vvvvwao == 'FLOAT' || datatype_vvvvwao == 'DECIMAL' || datatype_vvvvwao == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(datatype_vvvvwap)
{
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
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwapvzy_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwapvzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwapvzy_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwapvzy_required = true;
		}
	}
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

// the vvvvwaq function
function vvvvwaq(store_vvvvwaq,datatype_vvvvwaq)
{
	if (isSet(store_vvvvwaq) && store_vvvvwaq.constructor !== Array)
	{
		var temp_vvvvwaq = store_vvvvwaq;
		var store_vvvvwaq = [];
		store_vvvvwaq.push(temp_vvvvwaq);
	}
	else if (!isSet(store_vvvvwaq))
	{
		var store_vvvvwaq = [];
	}
	var store = store_vvvvwaq.some(store_vvvvwaq_SomeFunc);

	if (isSet(datatype_vvvvwaq) && datatype_vvvvwaq.constructor !== Array)
	{
		var temp_vvvvwaq = datatype_vvvvwaq;
		var datatype_vvvvwaq = [];
		datatype_vvvvwaq.push(temp_vvvvwaq);
	}
	else if (!isSet(datatype_vvvvwaq))
	{
		var datatype_vvvvwaq = [];
	}
	var datatype = datatype_vvvvwaq.some(datatype_vvvvwaq_SomeFunc);


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

// the vvvvwaq Some function
function store_vvvvwaq_SomeFunc(store_vvvvwaq)
{
	// set the function logic
	if (store_vvvvwaq == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaq Some function
function datatype_vvvvwaq_SomeFunc(datatype_vvvvwaq)
{
	// set the function logic
	if (datatype_vvvvwaq == 'CHAR' || datatype_vvvvwaq == 'VARCHAR' || datatype_vvvvwaq == 'TEXT' || datatype_vvvvwaq == 'MEDIUMTEXT' || datatype_vvvvwaq == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwas function
function vvvvwas(add_css_view_vvvvwas)
{
	// set the function logic
	if (add_css_view_vvvvwas == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
		if (jform_vvvvwasvzz_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwasvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
		if (!jform_vvvvwasvzz_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwasvzz_required = true;
		}
	}
}

// the vvvvwat function
function vvvvwat(add_css_views_vvvvwat)
{
	// set the function logic
	if (add_css_views_vvvvwat == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
		if (jform_vvvvwatwaa_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwatwaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
		if (!jform_vvvvwatwaa_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwatwaa_required = true;
		}
	}
}

// the vvvvwau function
function vvvvwau(add_javascript_view_footer_vvvvwau)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwau == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwauwab_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwauwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwauwab_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwauwab_required = true;
		}
	}
}

// the vvvvwav function
function vvvvwav(add_javascript_views_footer_vvvvwav)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwav == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwavwac_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwavwac_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwavwac_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwavwac_required = true;
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
	// get the field type text
	var fieldText = jQuery("#jform_fieldtype option:selected").text().toLowerCase();
	// now check if database input is needed
	dbChecker(fieldText);
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
