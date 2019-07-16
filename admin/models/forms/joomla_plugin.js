/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Initial Script
jQuery(document).ready(function()
{
	var class_extends_vvvvvxb = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxb = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb);

	var joomla_plugin_group_vvvvvxc = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxc = jQuery("#jform_class_extends").val();
	vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc);
});

// the vvvvvxb function
function vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb)
{
	if (isSet(class_extends_vvvvvxb) && class_extends_vvvvvxb.constructor !== Array)
	{
		var temp_vvvvvxb = class_extends_vvvvvxb;
		var class_extends_vvvvvxb = [];
		class_extends_vvvvvxb.push(temp_vvvvvxb);
	}
	else if (!isSet(class_extends_vvvvvxb))
	{
		var class_extends_vvvvvxb = [];
	}
	var class_extends = class_extends_vvvvvxb.some(class_extends_vvvvvxb_SomeFunc);

	if (isSet(joomla_plugin_group_vvvvvxb) && joomla_plugin_group_vvvvvxb.constructor !== Array)
	{
		var temp_vvvvvxb = joomla_plugin_group_vvvvvxb;
		var joomla_plugin_group_vvvvvxb = [];
		joomla_plugin_group_vvvvvxb.push(temp_vvvvvxb);
	}
	else if (!isSet(joomla_plugin_group_vvvvvxb))
	{
		var joomla_plugin_group_vvvvvxb = [];
	}
	var joomla_plugin_group = joomla_plugin_group_vvvvvxb.some(joomla_plugin_group_vvvvvxb_SomeFunc);


	// set this function logic
	if (class_extends && joomla_plugin_group)
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').show();
		jQuery('#jform_method_selection-lbl').closest('.control-group').show();
		jQuery('#jform_property_selection-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').hide();
		jQuery('#jform_method_selection-lbl').closest('.control-group').hide();
		jQuery('#jform_property_selection-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxb Some function
function class_extends_vvvvvxb_SomeFunc(class_extends_vvvvvxb)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxb))
	{
		return true;
	}
	return false;
}

// the vvvvvxb Some function
function joomla_plugin_group_vvvvvxb_SomeFunc(joomla_plugin_group_vvvvvxb)
{
	// set the function logic
	if (isSet(joomla_plugin_group_vvvvvxb))
	{
		return true;
	}
	return false;
}

// the vvvvvxc function
function vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc)
{
	if (isSet(joomla_plugin_group_vvvvvxc) && joomla_plugin_group_vvvvvxc.constructor !== Array)
	{
		var temp_vvvvvxc = joomla_plugin_group_vvvvvxc;
		var joomla_plugin_group_vvvvvxc = [];
		joomla_plugin_group_vvvvvxc.push(temp_vvvvvxc);
	}
	else if (!isSet(joomla_plugin_group_vvvvvxc))
	{
		var joomla_plugin_group_vvvvvxc = [];
	}
	var joomla_plugin_group = joomla_plugin_group_vvvvvxc.some(joomla_plugin_group_vvvvvxc_SomeFunc);

	if (isSet(class_extends_vvvvvxc) && class_extends_vvvvvxc.constructor !== Array)
	{
		var temp_vvvvvxc = class_extends_vvvvvxc;
		var class_extends_vvvvvxc = [];
		class_extends_vvvvvxc.push(temp_vvvvvxc);
	}
	else if (!isSet(class_extends_vvvvvxc))
	{
		var class_extends_vvvvvxc = [];
	}
	var class_extends = class_extends_vvvvvxc.some(class_extends_vvvvvxc_SomeFunc);


	// set this function logic
	if (joomla_plugin_group && class_extends)
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').show();
		jQuery('#jform_method_selection-lbl').closest('.control-group').show();
		jQuery('#jform_property_selection-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').hide();
		jQuery('#jform_method_selection-lbl').closest('.control-group').hide();
		jQuery('#jform_property_selection-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxc Some function
function joomla_plugin_group_vvvvvxc_SomeFunc(joomla_plugin_group_vvvvvxc)
{
	// set the function logic
	if (isSet(joomla_plugin_group_vvvvvxc))
	{
		return true;
	}
	return false;
}

// the vvvvvxc Some function
function class_extends_vvvvvxc_SomeFunc(class_extends_vvvvvxc)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxc))
	{
		return true;
	}
	return false;
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
	// get the linked details
	getLinked();
	// load the active array values
	buildSelectionArray('property');
	buildSelectionArray('method');
	// set joomla_plugin_group Array
	selectionArray['joomla_plugin_group'] = {};
	jQuery("#jform_joomla_plugin_group option").each(function() {
		var key =  jQuery(this).val();
		var text =  jQuery(this).text();
		selectionArray['joomla_plugin_group'][key] = text;
	});
	// load the active selection array values
	getClassCodeIds('joomla_plugin_group', 'jform_class_extends', false);
	getClassCodeIds('property', 'jform_joomla_plugin_group', false);
	getClassCodeIds('method', 'jform_joomla_plugin_group', false);
	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
	// trigger the row watcher
	rowWatcher();
});

function getClassStuff_server(id, type, callingName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax."+callingName+"&format=json&raw=true");
	if(token.length > 0 && id > 0 && type.length > 0){
		var request = token+'=1&type=' + type + '&id=' + id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getClassCodeIds(type, target_field, reset_all){
	// now get the value
	var value = jQuery('#'+target_field).val();
	// now get the code
	getClassStuff_server(value, type, 'getClassCodeIds').done(function(result) {
		if(result){
			// reset the selection
			selectionActiveArray[type] = {};
			// update the active array
			jQuery.each( result, function(i, prop) {
				selectionActiveArray[type][prop] = selectionArray[type][prop];
			});
			// update the active field selection
			updateActiveFieldSelection(type, reset_all);
		}
	});
}

function updateActiveFieldSelection(type, reset_all){
	// update the selection options
	if ('joomla_plugin_group' === type) {
		// get value if not going to reset all
		if (!reset_all){
			// get the active values
			var activeValue =  jQuery("#jform_"+type+" option:selected").val();
			var activeText =  jQuery("#jform_"+type+" option:selected").text();
			// clear the options out
			jQuery("#jform_"+type).find('option').remove().end();
			// add the active selection back (must be what is available)
			jQuery("#jform_"+type).append('<option value="'+activeValue+'">'+activeText+'</option>');
			// now add the lists back
			jQuery.each( selectionActiveArray[type], function(aValue, aText ) {
				if (activeValue !== aValue) {
					jQuery("#jform_"+type).append('<option value="'+aValue+'">'+aText+'</option>');
				}
			});
			jQuery("#jform_"+type).val(activeValue);			
		} else {
			// clear the options out
			jQuery("#jform_"+type).find('option').remove().end();
			// now add the lists back
			jQuery.each( selectionActiveArray[type], function(aValue, aText ) {
				jQuery("#jform_"+type).append('<option value="'+aValue+'">'+aText+'</option>');
			});
			jQuery("#jform_"+type).val('');
		}
		jQuery("#jform_"+type).trigger('liszt:updated');
		// reset all when global update is made
		if (reset_all) {
			resetAll('method');
			resetAll('property');
		}
	} else {
		selectionDynamicUpdate(type);
		// reset all when global update is made
		if (reset_all) {
			resetAll(type);
		}
	}
}

function resetAll(type) {
	var i;
	for (i = 0; i < 10; i++) {
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length) {
			if (i == 0) {
				jQuery('#'+id_check).val('');
				jQuery('#'+id_check).trigger('liszt:updated');
			} else {
				// remove the row
				jQuery('#'+id_check).closest('tr').remove();
			}
		}
	}
	Joomla.editors.instances['jform_main_class_code'].setValue('');
}

function getClassCode(field, type){
	// get the ID
	var id = jQuery(field).attr('id');
	// now get the value
	var value = jQuery('#' + id).val();
	if (propertyIsSet(value, id, type)) {
		// reset the selection
		jQuery('#'+id).val('');
		jQuery('#'+id).trigger("liszt:updated");
		// give out a notice
		jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_ALREADY_SELECTED_TRY_ANOTHER'), timeout: 5000, status: 'warning', pos: 'top-center'});
	} else {
		// set the active removed value
		selectedIdRemoved[type] = id;
		// do a dynamic update (to remove what was already used)
		selectionDynamicUpdate(type);
		// now get the code
		getClassStuff_server(value, type, 'getClassCode').done(function(result) {
			if(result){
				if (Joomla.editors.instances.hasOwnProperty("jform_main_class_code")) {
					var old_result = Joomla.editors.instances['jform_main_class_code'].getValue();
					if (old_result.length > 0) {
						// make sure not to load the same string twice
						if (old_result.indexOf(result) !== -1) {
							// reset the selection
							jQuery('#'+id).val('');
							jQuery('#'+id).trigger("liszt:updated");
							// give out a notice
							jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_ALREADY_SELECTED_TRY_ANOTHER'), timeout: 5000, status: 'warning', pos: 'top-center'});
						} else {
							Joomla.editors.instances['jform_main_class_code'].setValue(old_result + "\n\n" + result);
						}
					} else {
						Joomla.editors.instances['jform_main_class_code'].setValue(result);
					}
				} else {
					var old_result = jQuery('textarea#jform_main_class_code').val();
					if (old_result.length > 0) {
						// make sure not to load the same string twice
						if (old_result.indexOf(result) !== -1) {
							// reset the selection
							jQuery('#'+id).val('');
							jQuery('#'+id).trigger("liszt:updated");
							// give out a notice
							jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_ALREADY_SELECTED_TRY_ANOTHER'), timeout: 5000, status: 'warning', pos: 'top-center'});
						} else {
							jQuery('textarea#jform_main_class_code').val(old_result + "\n\n" + result);
						}
					} else {
						jQuery('textarea#jform_main_class_code').val(result);
					}
				}
			}
		});
	}
}

// set selection the options
selectionArray = {'property':{},'method':{}};
selectionActiveArray = {'property':{},'method':{}};
selectedIdRemoved = {'property':'not','method':'not'};
justonce = {'property':1,'method':1};

function buildSelectionArray(type) {
	var i;
	for (i = 0; i < 10; i++) {
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
		// first check if Id is on page as that not the same as the one currently calling
		if (justonce[type] == 1 && jQuery("#"+id_check).length) {
			// set buckets
			jQuery("#"+id_check+" option").each(function() {
				var key =  jQuery(this).val();
				var text =  jQuery(this).text();
				selectionArray[type][key] = text;
			});
			justonce[type]++;
		}
	}
}

function selectionDynamicUpdate(type) {
	selectionAvailable = {};
	selectionSelectedArray = {};
	selectionTrackerArray = {};
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length && selectedIdRemoved[type] !== id_check) {
			// build the selected array
			var key =  jQuery("#"+id_check+" option:selected").val();
			var text =  jQuery("#"+id_check+" option:selected").text();
			selectionSelectedArray[key] = text;
			// keep track of the value set
			selectionTrackerArray[id_check] = key;
			// clear the options out
			jQuery("#"+id_check).find('option').remove().end();
		}
	}
	// trigger chosen on the list fields
	// jQuery('.'+type+'_selection_list').chosen({"disable_search_threshold":10,"search_contains":true,"allow_single_deselect":true,"placeholder_text_multiple":Joomla.JText._("COM_COMPONENTBUILDER_TYPE_OR_SELECT_SOME_OPTIONS"),"placeholder_text_single":Joomla.JText._("COM_COMPONENTBUILDER_SELECT_A_PROPERTY"),"no_results_text":Joomla.JText._("COM_COMPONENTBUILDER_NO_RESULTS_MATCH")});
	// now build the list to keep
	jQuery.each( selectionActiveArray[type], function( prop, name ) {
		if (!selectionSelectedArray.hasOwnProperty(prop)) {
			selectionAvailable[prop] = name;
		}
	});
	// now add the lists back
	jQuery.each( selectionTrackerArray, function( tId, tKey ) {
		if (jQuery('#'+tId).length) {
			jQuery('#'+tId).append('<option value="'+tKey+'">'+selectionSelectedArray[tKey]+'</option>');
			jQuery.each( selectionAvailable, function( aKey, aValue ) {
				jQuery('#'+tId).append('<option value="'+aKey+'">'+aValue+'</option>');
			});
			jQuery('#'+tId).val(tKey);
			jQuery('#'+tId).trigger('liszt:updated');
		}
	});
}

function rowWatcher() {
	jQuery(document).on('subform-row-remove', function(event, row){
		// we first chck if this is a method call
       		var valid_call = jQuery(row.innerHTML).find('.method_selection_list').attr('id');
		var type_call = 'method';
		if (!isSet(valid_call)){
			// now lets see if this is a property call
			var valid_call = jQuery(row.innerHTML).find('.property_selection_list').attr('id');
			var type_call = 'property';
		}
		// so lets update selection if call valid
		if (isSet(valid_call)){
			selectedIdRemoved[type_call] = valid_call;
			selectionDynamicUpdate(type_call);
			// also remove from code
			var valid_value = jQuery(row.innerHTML).find('#' + valid_call + ' option:selected').val();
			getClassStuff_server(valid_value, type_call, 'getClassCode').done(function(result) {
				if(result){
					if (Joomla.editors.instances.hasOwnProperty("jform_main_class_code")) {
						var old_result = Joomla.editors.instances['jform_main_class_code'].getValue();
						if (old_result.length > 0) {
							// make sure not to load the same string twice
							if (old_result.indexOf(result) !== -1) {
								// remove the code
								Joomla.editors.instances['jform_main_class_code'].setValue(old_result.replace(result+"\n\n",'').replace("\n\n"+result,'').replace(result,''));
							}
						}
					} else {
						var old_result = jQuery('textarea#jform_main_class_code').val();
						if (old_result.length > 0) {
							// make sure not to load the same string twice
							if (old_result.indexOf(result) !== -1) {
								// remove the code
								jQuery('textarea#jform_main_class_code').val(old_result.replace(result+"\n\n",'').replace("\n\n"+result,'').replace(result,''));
							}
						}
					}
				}
			});
		}
	});
	jQuery(document).on('subform-row-add', function(event, row){
		// we first chck if this is a method call
       		var valid_call = jQuery(row.innerHTML).find('.method_selection_list').attr('id');
		var type_call = 'method';
		if (!isSet(valid_call)){
			// now lets see if this is a property call
			var valid_call = jQuery(row.innerHTML).find('.property_selection_list').attr('id');
			var type_call = 'property';
		}
		// so lets update selection if call valid
		if (isSet(valid_call)){
			selectedIdRemoved[type_call] = 'not';
			selectionDynamicUpdate(type_call);
		}
	});
}

function propertyIsSet(prop, id, type) {
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
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
