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

	@version		@update number 39 of this MVC
	@build			7th April, 2017
	@created		3rd April, 2017
	@package		Component Builder
	@subpackage		language_translation.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/



jQuery(document).ready(function($)
{
	// build table of translations
	var translation = encodeURIComponent(jQuery('#jform_translation').val());
	if (translation) {
		getBuildTable(translation,'jform_translation');
	}
	// set button to add more languages
	addButton('language','components');
});
			
function getBuildTable_server(string, idName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getBuildTable&format=json&vdm="+vastDevMod);
	if(token.length > 0 && string.length > 0 && idName.length > 0){
		var request = 'token='+token+'&idName='+idName+'&object='+string;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}
function getBuildTable(string, idName){
	getBuildTable_server(string, idName).done(function(result) {
		jQuery('#table_'+idName).remove();
		if(result){
			addData(result, '#'+idName);
		}
	})
}
function addData(result, where){
	jQuery(where).closest('.control-group').parent().append(result);
}			 
function addButton_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
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
function addButton(type, where){
	addButton_server(type).done(function(result) {
		if(result){
			setButton(result, '#jform_'+where);
		}
	});
}
function setButton(result, where){
	jQuery(where).closest('.control-group').append(result);
} 
