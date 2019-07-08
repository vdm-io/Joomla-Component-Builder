/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */




jQuery(document).ready(function()
{
	// check and load all the customcode edit buttons
	getEditCustomCodeButtons();
});
// little script to set the value
function getCodeGlueOptions(field) {
	// get the ID
	var id = jQuery(field).attr('id');
	var target = id.split('__');
	//set the subID
	var subID = target[0]+'__'+target[1];
	// get listfield value
	var listfield = jQuery('#'+subID+'__listfield').val();
	// get type value
	var type = jQuery('#'+subID+'__join_type').val();
	// get area value
	var area = jQuery('#'+subID+'__area').val();
	// check that values are set
	if (_isSet(listfield) && _isSet(type) && _isSet(area)) {
		// get joinfields values
		var joinfields = jQuery('#'+subID+'__joinfields').val();
		// get codeGlueOptions
		getCodeGlueOptions_server(listfield, joinfields, type, area).done(function(result) {
			if(result){
				jQuery('#'+subID+'__set').val(result);
			} else {
				jQuery('#'+subID+'__set').val('');
			}
		});
	} else {
		jQuery('#'+subID+'__set').val('');
	}
}

function getCodeGlueOptions_server(listfield, joinfields, type, area){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getCodeGlueOptions&format=json");
	// make sure the joinfields are set
	if (!_isSet(joinfields)) {
		joinfields = 'none';
	}
	if(token.length > 0 && listfield > 0 && type > 0 && area > 0) {
		var request = token+'=1&listfield='+listfield+'&type='+type+'&area='+area+'&joinfields='+joinfields;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

// the isSet function
function _isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
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
 
