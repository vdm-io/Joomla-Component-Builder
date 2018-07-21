/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */




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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getCodeGlueOptions&format=json";
	// make sure the joinfields are set
	if (!_isSet(joinfields)) {
		joinfields = 'none';
	}
	if(token.length > 0 && listfield > 0 && type > 0 && area > 0) {
		var request = 'token='+token+'&listfield='+listfield+'&type='+type+'&area='+area+'&joinfields='+joinfields;
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
 
