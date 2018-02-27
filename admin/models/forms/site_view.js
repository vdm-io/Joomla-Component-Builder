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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		site_view.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvylvyi_required = false;
jform_vvvvvymvyj_required = false;
jform_vvvvvynvyk_required = false;
jform_vvvvvyovyl_required = false;
jform_vvvvvypvym_required = false;
jform_vvvvvyqvyn_required = false;
jform_vvvvvyrvyo_required = false;
jform_vvvvvysvyp_required = false;
jform_vvvvvytvyq_required = false;
jform_vvvvvyuvyr_required = false;
jform_vvvvvyuvys_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_view_vvvvvyl = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvyl(add_php_view_vvvvvyl);

	var add_php_jview_display_vvvvvym = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvym(add_php_jview_display_vvvvvym);

	var add_php_jview_vvvvvyn = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvyn(add_php_jview_vvvvvyn);

	var add_php_document_vvvvvyo = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvyo(add_php_document_vvvvvyo);

	var add_css_document_vvvvvyp = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvyp(add_css_document_vvvvvyp);

	var add_javascript_file_vvvvvyq = jQuery("#jform_add_javascript_file input[type='radio']:checked").val();
	vvvvvyq(add_javascript_file_vvvvvyq);

	var add_js_document_vvvvvyr = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvyr(add_js_document_vvvvvyr);

	var add_css_vvvvvys = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvys(add_css_vvvvvys);

	var add_php_ajax_vvvvvyt = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvyt(add_php_ajax_vvvvvyt);

	var add_custom_button_vvvvvyu = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvyu(add_custom_button_vvvvvyu);

	var button_position_vvvvvyv = jQuery("#jform_button_position").val();
	vvvvvyv(button_position_vvvvvyv);
});

// the vvvvvyl function
function vvvvvyl(add_php_view_vvvvvyl)
{
	// set the function logic
	if (add_php_view_vvvvvyl == 1)
	{
		jQuery('#jform_php_view').closest('.control-group').show();
		if (jform_vvvvvylvyi_required)
		{
			updateFieldRequired('php_view',0);
			jQuery('#jform_php_view').prop('required','required');
			jQuery('#jform_php_view').attr('aria-required',true);
			jQuery('#jform_php_view').addClass('required');
			jform_vvvvvylvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_view').closest('.control-group').hide();
		if (!jform_vvvvvylvyi_required)
		{
			updateFieldRequired('php_view',1);
			jQuery('#jform_php_view').removeAttr('required');
			jQuery('#jform_php_view').removeAttr('aria-required');
			jQuery('#jform_php_view').removeClass('required');
			jform_vvvvvylvyi_required = true;
		}
	}
}

// the vvvvvym function
function vvvvvym(add_php_jview_display_vvvvvym)
{
	// set the function logic
	if (add_php_jview_display_vvvvvym == 1)
	{
		jQuery('#jform_php_jview_display').closest('.control-group').show();
		if (jform_vvvvvymvyj_required)
		{
			updateFieldRequired('php_jview_display',0);
			jQuery('#jform_php_jview_display').prop('required','required');
			jQuery('#jform_php_jview_display').attr('aria-required',true);
			jQuery('#jform_php_jview_display').addClass('required');
			jform_vvvvvymvyj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview_display').closest('.control-group').hide();
		if (!jform_vvvvvymvyj_required)
		{
			updateFieldRequired('php_jview_display',1);
			jQuery('#jform_php_jview_display').removeAttr('required');
			jQuery('#jform_php_jview_display').removeAttr('aria-required');
			jQuery('#jform_php_jview_display').removeClass('required');
			jform_vvvvvymvyj_required = true;
		}
	}
}

// the vvvvvyn function
function vvvvvyn(add_php_jview_vvvvvyn)
{
	// set the function logic
	if (add_php_jview_vvvvvyn == 1)
	{
		jQuery('#jform_php_jview').closest('.control-group').show();
		if (jform_vvvvvynvyk_required)
		{
			updateFieldRequired('php_jview',0);
			jQuery('#jform_php_jview').prop('required','required');
			jQuery('#jform_php_jview').attr('aria-required',true);
			jQuery('#jform_php_jview').addClass('required');
			jform_vvvvvynvyk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview').closest('.control-group').hide();
		if (!jform_vvvvvynvyk_required)
		{
			updateFieldRequired('php_jview',1);
			jQuery('#jform_php_jview').removeAttr('required');
			jQuery('#jform_php_jview').removeAttr('aria-required');
			jQuery('#jform_php_jview').removeClass('required');
			jform_vvvvvynvyk_required = true;
		}
	}
}

// the vvvvvyo function
function vvvvvyo(add_php_document_vvvvvyo)
{
	// set the function logic
	if (add_php_document_vvvvvyo == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_vvvvvyovyl_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_vvvvvyovyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_vvvvvyovyl_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_vvvvvyovyl_required = true;
		}
	}
}

// the vvvvvyp function
function vvvvvyp(add_css_document_vvvvvyp)
{
	// set the function logic
	if (add_css_document_vvvvvyp == 1)
	{
		jQuery('#jform_css_document').closest('.control-group').show();
		if (jform_vvvvvypvym_required)
		{
			updateFieldRequired('css_document',0);
			jQuery('#jform_css_document').prop('required','required');
			jQuery('#jform_css_document').attr('aria-required',true);
			jQuery('#jform_css_document').addClass('required');
			jform_vvvvvypvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_document').closest('.control-group').hide();
		if (!jform_vvvvvypvym_required)
		{
			updateFieldRequired('css_document',1);
			jQuery('#jform_css_document').removeAttr('required');
			jQuery('#jform_css_document').removeAttr('aria-required');
			jQuery('#jform_css_document').removeClass('required');
			jform_vvvvvypvym_required = true;
		}
	}
}

// the vvvvvyq function
function vvvvvyq(add_javascript_file_vvvvvyq)
{
	// set the function logic
	if (add_javascript_file_vvvvvyq == 1)
	{
		jQuery('#jform_javascript_file').closest('.control-group').show();
		if (jform_vvvvvyqvyn_required)
		{
			updateFieldRequired('javascript_file',0);
			jQuery('#jform_javascript_file').prop('required','required');
			jQuery('#jform_javascript_file').attr('aria-required',true);
			jQuery('#jform_javascript_file').addClass('required');
			jform_vvvvvyqvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_file').closest('.control-group').hide();
		if (!jform_vvvvvyqvyn_required)
		{
			updateFieldRequired('javascript_file',1);
			jQuery('#jform_javascript_file').removeAttr('required');
			jQuery('#jform_javascript_file').removeAttr('aria-required');
			jQuery('#jform_javascript_file').removeClass('required');
			jform_vvvvvyqvyn_required = true;
		}
	}
}

// the vvvvvyr function
function vvvvvyr(add_js_document_vvvvvyr)
{
	// set the function logic
	if (add_js_document_vvvvvyr == 1)
	{
		jQuery('#jform_js_document').closest('.control-group').show();
		if (jform_vvvvvyrvyo_required)
		{
			updateFieldRequired('js_document',0);
			jQuery('#jform_js_document').prop('required','required');
			jQuery('#jform_js_document').attr('aria-required',true);
			jQuery('#jform_js_document').addClass('required');
			jform_vvvvvyrvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_js_document').closest('.control-group').hide();
		if (!jform_vvvvvyrvyo_required)
		{
			updateFieldRequired('js_document',1);
			jQuery('#jform_js_document').removeAttr('required');
			jQuery('#jform_js_document').removeAttr('aria-required');
			jQuery('#jform_js_document').removeClass('required');
			jform_vvvvvyrvyo_required = true;
		}
	}
}

// the vvvvvys function
function vvvvvys(add_css_vvvvvys)
{
	// set the function logic
	if (add_css_vvvvvys == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_vvvvvysvyp_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_vvvvvysvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_vvvvvysvyp_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_vvvvvysvyp_required = true;
		}
	}
}

// the vvvvvyt function
function vvvvvyt(add_php_ajax_vvvvvyt)
{
	// set the function logic
	if (add_php_ajax_vvvvvyt == 1)
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvytvyq_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvytvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvytvyq_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvytvyq_required = true;
		}
	}
}

// the vvvvvyu function
function vvvvvyu(add_custom_button_vvvvvyu)
{
	// set the function logic
	if (add_custom_button_vvvvvyu == 1)
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_vvvvvyuvyr_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_vvvvvyuvyr_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_vvvvvyuvys_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_vvvvvyuvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_vvvvvyuvyr_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_vvvvvyuvyr_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_vvvvvyuvys_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_vvvvvyuvys_required = true;
		}
	}
}

// the vvvvvyv function
function vvvvvyv(button_position_vvvvvyv)
{
	if (isSet(button_position_vvvvvyv) && button_position_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = button_position_vvvvvyv;
		var button_position_vvvvvyv = [];
		button_position_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(button_position_vvvvvyv))
	{
		var button_position_vvvvvyv = [];
	}
	var button_position = button_position_vvvvvyv.some(button_position_vvvvvyv_SomeFunc);


	// set this function logic
	if (button_position)
	{
		jQuery('.note_custom_toolbar_placeholder').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_custom_toolbar_placeholder').closest('.control-group').hide();
	}
}

// the vvvvvyv Some function
function button_position_vvvvvyv_SomeFunc(button_position_vvvvvyv)
{
	// set the function logic
	if (button_position_vvvvvyv == 5)
	{
		return true;
	}
	return false;
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
	// get the linked details
	getLinked();
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

function getSnippetDetails_server(snippetId){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.snippetDetails&format=json";
	if(token.length > 0 && snippetId > 0){
		var request = 'token='+token+'&id='+snippetId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getSnippetDetails(id){
	getSnippetDetails_server(id).done(function(result) {
		if(result.snippet){
			var description = '';
			if (result.description.length > 0) {
				description = '<p>'+result.description+'</p>';
			}
			var library = '';
			if (result.library.length > 0) {
				library = ' <b>('+result.library+')</b>';
			}
			var code = '<div id="snippet-code"><b>'+result.name+' ('+result.type+')</b> <a href="'+result.url+'" target="_blank" >see more details'+library+'</a><br /><em>'+result.heading+'</em><br /><textarea  id="snippet" class="span12" rows="11">'+result.snippet+'</textarea></div>';
			jQuery('#snippet-code').remove();
			jQuery('.snippet-code').append(code);
			// make sure the code block is active
			jQuery("#snippet").focus(function() {
				var jQuerythis = jQuery(this);
				jQuerythis.select();
			
				// Work around Chrome's little problem
				jQuerythis.mouseup(function() {
					// Prevent further mouseup intervention
					jQuerythis.unbind("mouseup");
					return false;
				});
			});
		}
		if(result.usage){
			var usage = '<div id="snippet-usage"><p>'+result.usage+'</p></div>';
			jQuery('#snippet-usage').remove();
			jQuery('.snippet-usage').append(usage);
		}
	})
}

function getDynamicValues_server(dynamicId){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getDynamicValues&format=json";
	if(token.length > 0 && dynamicId > 0){
		var request = 'token='+token+'&view=site_view&id='+dynamicId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getDynamicValues(id){
	getDynamicValues_server(id).done(function(result) {
		if(result){
			jQuery('#dynamic_values').remove();
			jQuery('.dynamic_values').append('<div id="dynamic_values">'+result+'</div>');
			// make sure the code bocks are active
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
		}
	})
}

function getLayoutDetails_server(id){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLayoutDetails&format=json";
	if(token.length > 0 && id > 0){
		var request = 'token='+token+'&id='+id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getLayoutDetails(id){
	getLayoutDetails_server(id).done(function(result) {
		if(result){
			jQuery('#details').append(result);
			// make sure the code bocks are active
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
		}
	})
}

function getTemplateDetails_server(id){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.templateDetails&format=json";
	if(token.length > 0 && id > 0){
		var request = 'token='+token+'&id='+id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getTemplateDetails(id){
	getTemplateDetails_server(id).done(function(result) {
		if(result){
			jQuery('#details').append(result);
			// make sure the code bocks are active
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
		}
	})
}

// set snippets that are on the page
var snippetIds = [];
var snippets = {};
var snippet = 0;
jQuery(document).ready(function($)
{
	jQuery("#jform_snippet option").each(function()
	{
		var key =  jQuery(this).val();
		var text =  jQuery(this).text();
		snippets[key] = text;
		snippetIds.push(key);
	});
	snippet = jQuery("#jform_snippet").val();
	getSnippets();
});

function getSnippets_server(libraries){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getSnippets&format=json";
	if(token.length > 0 && libraries.length > 0){
		var request = 'token='+token+'&libraries='+JSON.stringify(libraries);
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}
function getSnippets(){
	jQuery("#loading").show();
	// clear the selection
	jQuery('#jform_snippet').find('option').remove().end();
	jQuery('#jform_snippet').trigger('liszt:updated');
	// get country value if set
	var libraries = jQuery("#jform_libraries").val();
	if (libraries) {
		getSnippets_server(libraries).done(function(result) {
			setSnippets(result);
			jQuery("#loading").hide();
			if (typeof snippetButton !== 'undefined') {
				// ensure button is correct
				var snippet = jQuery('#jform_snippet').val();
				snippetButton(snippet);
			}
		});
	}
	else
	{
		// load all snippets in none is selected
		setSnippets(snippetIds);
		jQuery("#loading").hide();
	}
}
function setSnippets(array){
	if (array) {
		jQuery('#jform_snippet').append('<option value="">'+select_a_snippet+'</option>');
		jQuery.each( array, function( i, id ) {
			if (id in snippets) {
				jQuery('#jform_snippet').append('<option value="'+id+'">'+snippets[id]+'</option>');
			}
			if (id == snippet) {
				jQuery('#jform_snippet').val(id);
			}
		});
	} else {
		jQuery('#jform_snippet').append('<option value="">'+create_a_snippet+'</option>');
	}
	jQuery('#jform_snippet').trigger('liszt:updated');
} 
