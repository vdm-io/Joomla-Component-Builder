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

	@version		2.1.0
	@build			26th February, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		custom_admin_view.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_EbgENkCAaJ_required = false;
jform_RycmCDhKsD_required = false;
jform_ELworxMpNp_required = false;
jform_bsrkXexADx_required = false;
jform_jnUoHyMKca_required = false;
jform_rAGNVdjEnW_required = false;
jform_SwpjFkoWJM_required = false;
jform_SwpjFkomPb_required = false;
jform_kZJCHxLMLp_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_view_EbgENkC = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	EbgENkC(add_php_view_EbgENkC);

	var add_php_jview_display_RycmCDh = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	RycmCDh(add_php_jview_display_RycmCDh);

	var add_php_jview_ELworxM = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	ELworxM(add_php_jview_ELworxM);

	var add_php_document_bsrkXex = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	bsrkXex(add_php_document_bsrkXex);

	var add_css_document_jnUoHyM = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	jnUoHyM(add_css_document_jnUoHyM);

	var add_js_document_rAGNVdj = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	rAGNVdj(add_js_document_rAGNVdj);

	var add_custom_button_SwpjFko = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	SwpjFko(add_custom_button_SwpjFko);

	var add_css_kZJCHxL = jQuery("#jform_add_css input[type='radio']:checked").val();
	kZJCHxL(add_css_kZJCHxL);
});

// the EbgENkC function
function EbgENkC(add_php_view_EbgENkC)
{
	// set the function logic
	if (add_php_view_EbgENkC == 1)
	{
		jQuery('#jform_php_view').closest('.control-group').show();
		if (jform_EbgENkCAaJ_required)
		{
			updateFieldRequired('php_view',0);
			jQuery('#jform_php_view').prop('required','required');
			jQuery('#jform_php_view').attr('aria-required',true);
			jQuery('#jform_php_view').addClass('required');
			jform_EbgENkCAaJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_view').closest('.control-group').hide();
		if (!jform_EbgENkCAaJ_required)
		{
			updateFieldRequired('php_view',1);
			jQuery('#jform_php_view').removeAttr('required');
			jQuery('#jform_php_view').removeAttr('aria-required');
			jQuery('#jform_php_view').removeClass('required');
			jform_EbgENkCAaJ_required = true;
		}
	}
}

// the RycmCDh function
function RycmCDh(add_php_jview_display_RycmCDh)
{
	// set the function logic
	if (add_php_jview_display_RycmCDh == 1)
	{
		jQuery('#jform_php_jview_display').closest('.control-group').show();
		if (jform_RycmCDhKsD_required)
		{
			updateFieldRequired('php_jview_display',0);
			jQuery('#jform_php_jview_display').prop('required','required');
			jQuery('#jform_php_jview_display').attr('aria-required',true);
			jQuery('#jform_php_jview_display').addClass('required');
			jform_RycmCDhKsD_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview_display').closest('.control-group').hide();
		if (!jform_RycmCDhKsD_required)
		{
			updateFieldRequired('php_jview_display',1);
			jQuery('#jform_php_jview_display').removeAttr('required');
			jQuery('#jform_php_jview_display').removeAttr('aria-required');
			jQuery('#jform_php_jview_display').removeClass('required');
			jform_RycmCDhKsD_required = true;
		}
	}
}

// the ELworxM function
function ELworxM(add_php_jview_ELworxM)
{
	// set the function logic
	if (add_php_jview_ELworxM == 1)
	{
		jQuery('#jform_php_jview').closest('.control-group').show();
		if (jform_ELworxMpNp_required)
		{
			updateFieldRequired('php_jview',0);
			jQuery('#jform_php_jview').prop('required','required');
			jQuery('#jform_php_jview').attr('aria-required',true);
			jQuery('#jform_php_jview').addClass('required');
			jform_ELworxMpNp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview').closest('.control-group').hide();
		if (!jform_ELworxMpNp_required)
		{
			updateFieldRequired('php_jview',1);
			jQuery('#jform_php_jview').removeAttr('required');
			jQuery('#jform_php_jview').removeAttr('aria-required');
			jQuery('#jform_php_jview').removeClass('required');
			jform_ELworxMpNp_required = true;
		}
	}
}

// the bsrkXex function
function bsrkXex(add_php_document_bsrkXex)
{
	// set the function logic
	if (add_php_document_bsrkXex == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_bsrkXexADx_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_bsrkXexADx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_bsrkXexADx_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_bsrkXexADx_required = true;
		}
	}
}

// the jnUoHyM function
function jnUoHyM(add_css_document_jnUoHyM)
{
	// set the function logic
	if (add_css_document_jnUoHyM == 1)
	{
		jQuery('#jform_css_document').closest('.control-group').show();
		if (jform_jnUoHyMKca_required)
		{
			updateFieldRequired('css_document',0);
			jQuery('#jform_css_document').prop('required','required');
			jQuery('#jform_css_document').attr('aria-required',true);
			jQuery('#jform_css_document').addClass('required');
			jform_jnUoHyMKca_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_document').closest('.control-group').hide();
		if (!jform_jnUoHyMKca_required)
		{
			updateFieldRequired('css_document',1);
			jQuery('#jform_css_document').removeAttr('required');
			jQuery('#jform_css_document').removeAttr('aria-required');
			jQuery('#jform_css_document').removeClass('required');
			jform_jnUoHyMKca_required = true;
		}
	}
}

// the rAGNVdj function
function rAGNVdj(add_js_document_rAGNVdj)
{
	// set the function logic
	if (add_js_document_rAGNVdj == 1)
	{
		jQuery('#jform_js_document').closest('.control-group').show();
		if (jform_rAGNVdjEnW_required)
		{
			updateFieldRequired('js_document',0);
			jQuery('#jform_js_document').prop('required','required');
			jQuery('#jform_js_document').attr('aria-required',true);
			jQuery('#jform_js_document').addClass('required');
			jform_rAGNVdjEnW_required = false;
		}

	}
	else
	{
		jQuery('#jform_js_document').closest('.control-group').hide();
		if (!jform_rAGNVdjEnW_required)
		{
			updateFieldRequired('js_document',1);
			jQuery('#jform_js_document').removeAttr('required');
			jQuery('#jform_js_document').removeAttr('aria-required');
			jQuery('#jform_js_document').removeClass('required');
			jform_rAGNVdjEnW_required = true;
		}
	}
}

// the SwpjFko function
function SwpjFko(add_custom_button_SwpjFko)
{
	// set the function logic
	if (add_custom_button_SwpjFko == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_SwpjFkoWJM_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_SwpjFkoWJM_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_SwpjFkomPb_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_SwpjFkomPb_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_SwpjFkoWJM_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_SwpjFkoWJM_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_SwpjFkomPb_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_SwpjFkomPb_required = true;
		}
	}
}

// the kZJCHxL function
function kZJCHxL(add_css_kZJCHxL)
{
	// set the function logic
	if (add_css_kZJCHxL == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_kZJCHxLMLp_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_kZJCHxLMLp_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_kZJCHxLMLp_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_kZJCHxLMLp_required = true;
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
			if (result.description.length > 0)
			{
				description = '<p>'+result.description+'</p>';
			}
			var code = '<div id="snippet-code"><b>'+result.name+' ('+result.type+')</b> <a href="'+result.url+'" target="_blank" >see more details</a><br /><em>'+result.heading+'</em><br /><textarea  id="snippet" class="span12" rows="11">'+result.snippet+'</textarea></div>';
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.dynamicValues&format=json";
	if(token.length > 0 && dynamicId > 0){
		var request = 'token='+token+'&view=template&id='+dynamicId;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.layoutDetails&format=json";
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

function getDynamicFormDetails_server(id){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.dynamicFormDetails&format=json";
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

function getDynamicFormDetails(id){
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
