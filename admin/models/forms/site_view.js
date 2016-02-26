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
	@subpackage		site_view.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_xAguIPPELg_required = false;
jform_ORHXbJzJUw_required = false;
jform_KgpxOcOsJs_required = false;
jform_FhRQABAwZq_required = false;
jform_vKdiMgPrRI_required = false;
jform_KCUZaCbOcP_required = false;
jform_kMVcwCDeSv_required = false;
jform_pukAxWEooy_required = false;
jform_dUaWTbzSQJ_required = false;
jform_dUaWTbzLYo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_view_xAguIPP = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	xAguIPP(add_php_view_xAguIPP);

	var add_php_jview_display_ORHXbJz = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	ORHXbJz(add_php_jview_display_ORHXbJz);

	var add_php_jview_KgpxOcO = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	KgpxOcO(add_php_jview_KgpxOcO);

	var add_php_document_FhRQABA = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	FhRQABA(add_php_document_FhRQABA);

	var add_css_document_vKdiMgP = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vKdiMgP(add_css_document_vKdiMgP);

	var add_js_document_KCUZaCb = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	KCUZaCb(add_js_document_KCUZaCb);

	var add_css_kMVcwCD = jQuery("#jform_add_css input[type='radio']:checked").val();
	kMVcwCD(add_css_kMVcwCD);

	var add_php_ajax_pukAxWE = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	pukAxWE(add_php_ajax_pukAxWE);

	var add_custom_button_dUaWTbz = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	dUaWTbz(add_custom_button_dUaWTbz);
});

// the xAguIPP function
function xAguIPP(add_php_view_xAguIPP)
{
	// set the function logic
	if (add_php_view_xAguIPP == 1)
	{
		jQuery('#jform_php_view').closest('.control-group').show();
		if (jform_xAguIPPELg_required)
		{
			updateFieldRequired('php_view',0);
			jQuery('#jform_php_view').prop('required','required');
			jQuery('#jform_php_view').attr('aria-required',true);
			jQuery('#jform_php_view').addClass('required');
			jform_xAguIPPELg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_view').closest('.control-group').hide();
		if (!jform_xAguIPPELg_required)
		{
			updateFieldRequired('php_view',1);
			jQuery('#jform_php_view').removeAttr('required');
			jQuery('#jform_php_view').removeAttr('aria-required');
			jQuery('#jform_php_view').removeClass('required');
			jform_xAguIPPELg_required = true;
		}
	}
}

// the ORHXbJz function
function ORHXbJz(add_php_jview_display_ORHXbJz)
{
	// set the function logic
	if (add_php_jview_display_ORHXbJz == 1)
	{
		jQuery('#jform_php_jview_display').closest('.control-group').show();
		if (jform_ORHXbJzJUw_required)
		{
			updateFieldRequired('php_jview_display',0);
			jQuery('#jform_php_jview_display').prop('required','required');
			jQuery('#jform_php_jview_display').attr('aria-required',true);
			jQuery('#jform_php_jview_display').addClass('required');
			jform_ORHXbJzJUw_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview_display').closest('.control-group').hide();
		if (!jform_ORHXbJzJUw_required)
		{
			updateFieldRequired('php_jview_display',1);
			jQuery('#jform_php_jview_display').removeAttr('required');
			jQuery('#jform_php_jview_display').removeAttr('aria-required');
			jQuery('#jform_php_jview_display').removeClass('required');
			jform_ORHXbJzJUw_required = true;
		}
	}
}

// the KgpxOcO function
function KgpxOcO(add_php_jview_KgpxOcO)
{
	// set the function logic
	if (add_php_jview_KgpxOcO == 1)
	{
		jQuery('#jform_php_jview').closest('.control-group').show();
		if (jform_KgpxOcOsJs_required)
		{
			updateFieldRequired('php_jview',0);
			jQuery('#jform_php_jview').prop('required','required');
			jQuery('#jform_php_jview').attr('aria-required',true);
			jQuery('#jform_php_jview').addClass('required');
			jform_KgpxOcOsJs_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview').closest('.control-group').hide();
		if (!jform_KgpxOcOsJs_required)
		{
			updateFieldRequired('php_jview',1);
			jQuery('#jform_php_jview').removeAttr('required');
			jQuery('#jform_php_jview').removeAttr('aria-required');
			jQuery('#jform_php_jview').removeClass('required');
			jform_KgpxOcOsJs_required = true;
		}
	}
}

// the FhRQABA function
function FhRQABA(add_php_document_FhRQABA)
{
	// set the function logic
	if (add_php_document_FhRQABA == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_FhRQABAwZq_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_FhRQABAwZq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_FhRQABAwZq_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_FhRQABAwZq_required = true;
		}
	}
}

// the vKdiMgP function
function vKdiMgP(add_css_document_vKdiMgP)
{
	// set the function logic
	if (add_css_document_vKdiMgP == 1)
	{
		jQuery('#jform_css_document').closest('.control-group').show();
		if (jform_vKdiMgPrRI_required)
		{
			updateFieldRequired('css_document',0);
			jQuery('#jform_css_document').prop('required','required');
			jQuery('#jform_css_document').attr('aria-required',true);
			jQuery('#jform_css_document').addClass('required');
			jform_vKdiMgPrRI_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_document').closest('.control-group').hide();
		if (!jform_vKdiMgPrRI_required)
		{
			updateFieldRequired('css_document',1);
			jQuery('#jform_css_document').removeAttr('required');
			jQuery('#jform_css_document').removeAttr('aria-required');
			jQuery('#jform_css_document').removeClass('required');
			jform_vKdiMgPrRI_required = true;
		}
	}
}

// the KCUZaCb function
function KCUZaCb(add_js_document_KCUZaCb)
{
	// set the function logic
	if (add_js_document_KCUZaCb == 1)
	{
		jQuery('#jform_js_document').closest('.control-group').show();
		if (jform_KCUZaCbOcP_required)
		{
			updateFieldRequired('js_document',0);
			jQuery('#jform_js_document').prop('required','required');
			jQuery('#jform_js_document').attr('aria-required',true);
			jQuery('#jform_js_document').addClass('required');
			jform_KCUZaCbOcP_required = false;
		}

	}
	else
	{
		jQuery('#jform_js_document').closest('.control-group').hide();
		if (!jform_KCUZaCbOcP_required)
		{
			updateFieldRequired('js_document',1);
			jQuery('#jform_js_document').removeAttr('required');
			jQuery('#jform_js_document').removeAttr('aria-required');
			jQuery('#jform_js_document').removeClass('required');
			jform_KCUZaCbOcP_required = true;
		}
	}
}

// the kMVcwCD function
function kMVcwCD(add_css_kMVcwCD)
{
	// set the function logic
	if (add_css_kMVcwCD == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_kMVcwCDeSv_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_kMVcwCDeSv_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_kMVcwCDeSv_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_kMVcwCDeSv_required = true;
		}
	}
}

// the pukAxWE function
function pukAxWE(add_php_ajax_pukAxWE)
{
	// set the function logic
	if (add_php_ajax_pukAxWE == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_pukAxWEooy_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_pukAxWEooy_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_pukAxWEooy_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_pukAxWEooy_required = true;
		}
	}
}

// the dUaWTbz function
function dUaWTbz(add_custom_button_dUaWTbz)
{
	// set the function logic
	if (add_custom_button_dUaWTbz == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_dUaWTbzSQJ_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_dUaWTbzSQJ_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_dUaWTbzLYo_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_dUaWTbzLYo_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_dUaWTbzSQJ_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_dUaWTbzSQJ_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_dUaWTbzLYo_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_dUaWTbzLYo_required = true;
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
	getDynamicFormDetails_server(id).done(function(result) {
		if(result){
			jQuery('#details').append(result);
			// make sure the code bocks are active
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
		}
	})
}  
