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
jform_OCMTtfratI_required = false;
jform_UwwBRpOgvi_required = false;
jform_psctTaGnJz_required = false;
jform_IzUBliELjY_required = false;
jform_leuCGgSBso_required = false;
jform_HEEKSxFsIr_required = false;
jform_PuMMUYTAKd_required = false;
jform_zThNxSSrmk_required = false;
jform_MSMxEyTkXC_required = false;
jform_MSMxEyTCPd_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_view_OCMTtfr = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	OCMTtfr(add_php_view_OCMTtfr);

	var add_php_jview_display_UwwBRpO = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	UwwBRpO(add_php_jview_display_UwwBRpO);

	var add_php_jview_psctTaG = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	psctTaG(add_php_jview_psctTaG);

	var add_php_document_IzUBliE = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	IzUBliE(add_php_document_IzUBliE);

	var add_css_document_leuCGgS = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	leuCGgS(add_css_document_leuCGgS);

	var add_js_document_HEEKSxF = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	HEEKSxF(add_js_document_HEEKSxF);

	var add_css_PuMMUYT = jQuery("#jform_add_css input[type='radio']:checked").val();
	PuMMUYT(add_css_PuMMUYT);

	var add_php_ajax_zThNxSS = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	zThNxSS(add_php_ajax_zThNxSS);

	var add_custom_button_MSMxEyT = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	MSMxEyT(add_custom_button_MSMxEyT);
});

// the OCMTtfr function
function OCMTtfr(add_php_view_OCMTtfr)
{
	// set the function logic
	if (add_php_view_OCMTtfr == 1)
	{
		jQuery('#jform_php_view').closest('.control-group').show();
		if (jform_OCMTtfratI_required)
		{
			updateFieldRequired('php_view',0);
			jQuery('#jform_php_view').prop('required','required');
			jQuery('#jform_php_view').attr('aria-required',true);
			jQuery('#jform_php_view').addClass('required');
			jform_OCMTtfratI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_view').closest('.control-group').hide();
		if (!jform_OCMTtfratI_required)
		{
			updateFieldRequired('php_view',1);
			jQuery('#jform_php_view').removeAttr('required');
			jQuery('#jform_php_view').removeAttr('aria-required');
			jQuery('#jform_php_view').removeClass('required');
			jform_OCMTtfratI_required = true;
		}
	}
}

// the UwwBRpO function
function UwwBRpO(add_php_jview_display_UwwBRpO)
{
	// set the function logic
	if (add_php_jview_display_UwwBRpO == 1)
	{
		jQuery('#jform_php_jview_display').closest('.control-group').show();
		if (jform_UwwBRpOgvi_required)
		{
			updateFieldRequired('php_jview_display',0);
			jQuery('#jform_php_jview_display').prop('required','required');
			jQuery('#jform_php_jview_display').attr('aria-required',true);
			jQuery('#jform_php_jview_display').addClass('required');
			jform_UwwBRpOgvi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview_display').closest('.control-group').hide();
		if (!jform_UwwBRpOgvi_required)
		{
			updateFieldRequired('php_jview_display',1);
			jQuery('#jform_php_jview_display').removeAttr('required');
			jQuery('#jform_php_jview_display').removeAttr('aria-required');
			jQuery('#jform_php_jview_display').removeClass('required');
			jform_UwwBRpOgvi_required = true;
		}
	}
}

// the psctTaG function
function psctTaG(add_php_jview_psctTaG)
{
	// set the function logic
	if (add_php_jview_psctTaG == 1)
	{
		jQuery('#jform_php_jview').closest('.control-group').show();
		if (jform_psctTaGnJz_required)
		{
			updateFieldRequired('php_jview',0);
			jQuery('#jform_php_jview').prop('required','required');
			jQuery('#jform_php_jview').attr('aria-required',true);
			jQuery('#jform_php_jview').addClass('required');
			jform_psctTaGnJz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview').closest('.control-group').hide();
		if (!jform_psctTaGnJz_required)
		{
			updateFieldRequired('php_jview',1);
			jQuery('#jform_php_jview').removeAttr('required');
			jQuery('#jform_php_jview').removeAttr('aria-required');
			jQuery('#jform_php_jview').removeClass('required');
			jform_psctTaGnJz_required = true;
		}
	}
}

// the IzUBliE function
function IzUBliE(add_php_document_IzUBliE)
{
	// set the function logic
	if (add_php_document_IzUBliE == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_IzUBliELjY_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_IzUBliELjY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_IzUBliELjY_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_IzUBliELjY_required = true;
		}
	}
}

// the leuCGgS function
function leuCGgS(add_css_document_leuCGgS)
{
	// set the function logic
	if (add_css_document_leuCGgS == 1)
	{
		jQuery('#jform_css_document').closest('.control-group').show();
		if (jform_leuCGgSBso_required)
		{
			updateFieldRequired('css_document',0);
			jQuery('#jform_css_document').prop('required','required');
			jQuery('#jform_css_document').attr('aria-required',true);
			jQuery('#jform_css_document').addClass('required');
			jform_leuCGgSBso_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_document').closest('.control-group').hide();
		if (!jform_leuCGgSBso_required)
		{
			updateFieldRequired('css_document',1);
			jQuery('#jform_css_document').removeAttr('required');
			jQuery('#jform_css_document').removeAttr('aria-required');
			jQuery('#jform_css_document').removeClass('required');
			jform_leuCGgSBso_required = true;
		}
	}
}

// the HEEKSxF function
function HEEKSxF(add_js_document_HEEKSxF)
{
	// set the function logic
	if (add_js_document_HEEKSxF == 1)
	{
		jQuery('#jform_js_document').closest('.control-group').show();
		if (jform_HEEKSxFsIr_required)
		{
			updateFieldRequired('js_document',0);
			jQuery('#jform_js_document').prop('required','required');
			jQuery('#jform_js_document').attr('aria-required',true);
			jQuery('#jform_js_document').addClass('required');
			jform_HEEKSxFsIr_required = false;
		}

	}
	else
	{
		jQuery('#jform_js_document').closest('.control-group').hide();
		if (!jform_HEEKSxFsIr_required)
		{
			updateFieldRequired('js_document',1);
			jQuery('#jform_js_document').removeAttr('required');
			jQuery('#jform_js_document').removeAttr('aria-required');
			jQuery('#jform_js_document').removeClass('required');
			jform_HEEKSxFsIr_required = true;
		}
	}
}

// the PuMMUYT function
function PuMMUYT(add_css_PuMMUYT)
{
	// set the function logic
	if (add_css_PuMMUYT == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_PuMMUYTAKd_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_PuMMUYTAKd_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_PuMMUYTAKd_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_PuMMUYTAKd_required = true;
		}
	}
}

// the zThNxSS function
function zThNxSS(add_php_ajax_zThNxSS)
{
	// set the function logic
	if (add_php_ajax_zThNxSS == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_zThNxSSrmk_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_zThNxSSrmk_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_zThNxSSrmk_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_zThNxSSrmk_required = true;
		}
	}
}

// the MSMxEyT function
function MSMxEyT(add_custom_button_MSMxEyT)
{
	// set the function logic
	if (add_custom_button_MSMxEyT == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_MSMxEyTkXC_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_MSMxEyTkXC_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_MSMxEyTCPd_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_MSMxEyTCPd_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_MSMxEyTkXC_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_MSMxEyTkXC_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_MSMxEyTCPd_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_MSMxEyTCPd_required = true;
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
