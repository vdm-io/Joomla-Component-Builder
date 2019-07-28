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
	var add_php_view_vvvvvzg = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvzg(add_php_view_vvvvvzg);

	var add_php_jview_display_vvvvvzh = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvzh(add_php_jview_display_vvvvvzh);

	var add_php_jview_vvvvvzi = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvzi(add_php_jview_vvvvvzi);

	var add_php_document_vvvvvzj = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvzj(add_php_document_vvvvvzj);

	var add_css_document_vvvvvzk = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvzk(add_css_document_vvvvvzk);

	var add_javascript_file_vvvvvzl = jQuery("#jform_add_javascript_file input[type='radio']:checked").val();
	vvvvvzl(add_javascript_file_vvvvvzl);

	var add_js_document_vvvvvzm = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvzm(add_js_document_vvvvvzm);

	var add_custom_button_vvvvvzn = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvzn(add_custom_button_vvvvvzn);

	var add_css_vvvvvzo = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvzo(add_css_vvvvvzo);

	var add_php_ajax_vvvvvzp = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvzp(add_php_ajax_vvvvvzp);
});

// the vvvvvzg function
function vvvvvzg(add_php_view_vvvvvzg)
{
	// set the function logic
	if (add_php_view_vvvvvzg == 1)
	{
		jQuery('#jform_php_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzh function
function vvvvvzh(add_php_jview_display_vvvvvzh)
{
	// set the function logic
	if (add_php_jview_display_vvvvvzh == 1)
	{
		jQuery('#jform_php_jview_display-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_jview_display-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzi function
function vvvvvzi(add_php_jview_vvvvvzi)
{
	// set the function logic
	if (add_php_jview_vvvvvzi == 1)
	{
		jQuery('#jform_php_jview-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_jview-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzj function
function vvvvvzj(add_php_document_vvvvvzj)
{
	// set the function logic
	if (add_php_document_vvvvvzj == 1)
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzk function
function vvvvvzk(add_css_document_vvvvvzk)
{
	// set the function logic
	if (add_css_document_vvvvvzk == 1)
	{
		jQuery('#jform_css_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzl function
function vvvvvzl(add_javascript_file_vvvvvzl)
{
	// set the function logic
	if (add_javascript_file_vvvvvzl == 1)
	{
		jQuery('#jform_javascript_file-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_file-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzm function
function vvvvvzm(add_js_document_vvvvvzm)
{
	// set the function logic
	if (add_js_document_vvvvvzm == 1)
	{
		jQuery('#jform_js_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_js_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzn function
function vvvvvzn(add_custom_button_vvvvvzn)
{
	// set the function logic
	if (add_custom_button_vvvvvzn == 1)
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').show();
		jQuery('#jform_php_controller-lbl').closest('.control-group').show();
		jQuery('#jform_php_model-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').hide();
		jQuery('#jform_php_controller-lbl').closest('.control-group').hide();
		jQuery('#jform_php_model-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzo function
function vvvvvzo(add_css_vvvvvzo)
{
	// set the function logic
	if (add_css_vvvvvzo == 1)
	{
		jQuery('#jform_css-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzp function
function vvvvvzp(add_php_ajax_vvvvvzp)
{
	// set the function logic
	if (add_php_ajax_vvvvvzp == 1)
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod-lbl').closest('.control-group').hide();
	}
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
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

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

function getSnippetDetails_server(snippetId){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.snippetDetails&format=json");
	if(token.length > 0 && snippetId > 0){
		var request = token+'=1&id='+snippetId;
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
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getDynamicValues&format=json");
	if(token.length > 0 && dynamicId > 0){
		var request = token+'=1&view=custom_admin_view&id='+dynamicId;
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
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLayoutDetails&format=json&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id;
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
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.templateDetails&format=json&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getSnippets&raw=true&format=json";
	if(token.length > 0 && libraries.length > 0){
		var request = token+'=1&libraries='+JSON.stringify(libraries);
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
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
