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
jform_nCSLUzGwkO_required = false;
jform_VssoeDjYBq_required = false;
jform_DydXTjkvRY_required = false;
jform_LiAFRwhASo_required = false;
jform_oOCEZNckMK_required = false;
jform_zkkKicQqFH_required = false;
jform_ojUWKMBSht_required = false;
jform_ojUWKMBkqd_required = false;
jform_SUeAXqsBQx_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_view_nCSLUzG = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	nCSLUzG(add_php_view_nCSLUzG);

	var add_php_jview_display_VssoeDj = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	VssoeDj(add_php_jview_display_VssoeDj);

	var add_php_jview_DydXTjk = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	DydXTjk(add_php_jview_DydXTjk);

	var add_php_document_LiAFRwh = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	LiAFRwh(add_php_document_LiAFRwh);

	var add_css_document_oOCEZNc = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	oOCEZNc(add_css_document_oOCEZNc);

	var add_js_document_zkkKicQ = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	zkkKicQ(add_js_document_zkkKicQ);

	var add_custom_button_ojUWKMB = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	ojUWKMB(add_custom_button_ojUWKMB);

	var add_css_SUeAXqs = jQuery("#jform_add_css input[type='radio']:checked").val();
	SUeAXqs(add_css_SUeAXqs);
});

// the nCSLUzG function
function nCSLUzG(add_php_view_nCSLUzG)
{
	// set the function logic
	if (add_php_view_nCSLUzG == 1)
	{
		jQuery('#jform_php_view').closest('.control-group').show();
		if (jform_nCSLUzGwkO_required)
		{
			updateFieldRequired('php_view',0);
			jQuery('#jform_php_view').prop('required','required');
			jQuery('#jform_php_view').attr('aria-required',true);
			jQuery('#jform_php_view').addClass('required');
			jform_nCSLUzGwkO_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_view').closest('.control-group').hide();
		if (!jform_nCSLUzGwkO_required)
		{
			updateFieldRequired('php_view',1);
			jQuery('#jform_php_view').removeAttr('required');
			jQuery('#jform_php_view').removeAttr('aria-required');
			jQuery('#jform_php_view').removeClass('required');
			jform_nCSLUzGwkO_required = true;
		}
	}
}

// the VssoeDj function
function VssoeDj(add_php_jview_display_VssoeDj)
{
	// set the function logic
	if (add_php_jview_display_VssoeDj == 1)
	{
		jQuery('#jform_php_jview_display').closest('.control-group').show();
		if (jform_VssoeDjYBq_required)
		{
			updateFieldRequired('php_jview_display',0);
			jQuery('#jform_php_jview_display').prop('required','required');
			jQuery('#jform_php_jview_display').attr('aria-required',true);
			jQuery('#jform_php_jview_display').addClass('required');
			jform_VssoeDjYBq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview_display').closest('.control-group').hide();
		if (!jform_VssoeDjYBq_required)
		{
			updateFieldRequired('php_jview_display',1);
			jQuery('#jform_php_jview_display').removeAttr('required');
			jQuery('#jform_php_jview_display').removeAttr('aria-required');
			jQuery('#jform_php_jview_display').removeClass('required');
			jform_VssoeDjYBq_required = true;
		}
	}
}

// the DydXTjk function
function DydXTjk(add_php_jview_DydXTjk)
{
	// set the function logic
	if (add_php_jview_DydXTjk == 1)
	{
		jQuery('#jform_php_jview').closest('.control-group').show();
		if (jform_DydXTjkvRY_required)
		{
			updateFieldRequired('php_jview',0);
			jQuery('#jform_php_jview').prop('required','required');
			jQuery('#jform_php_jview').attr('aria-required',true);
			jQuery('#jform_php_jview').addClass('required');
			jform_DydXTjkvRY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview').closest('.control-group').hide();
		if (!jform_DydXTjkvRY_required)
		{
			updateFieldRequired('php_jview',1);
			jQuery('#jform_php_jview').removeAttr('required');
			jQuery('#jform_php_jview').removeAttr('aria-required');
			jQuery('#jform_php_jview').removeClass('required');
			jform_DydXTjkvRY_required = true;
		}
	}
}

// the LiAFRwh function
function LiAFRwh(add_php_document_LiAFRwh)
{
	// set the function logic
	if (add_php_document_LiAFRwh == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_LiAFRwhASo_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_LiAFRwhASo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_LiAFRwhASo_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_LiAFRwhASo_required = true;
		}
	}
}

// the oOCEZNc function
function oOCEZNc(add_css_document_oOCEZNc)
{
	// set the function logic
	if (add_css_document_oOCEZNc == 1)
	{
		jQuery('#jform_css_document').closest('.control-group').show();
		if (jform_oOCEZNckMK_required)
		{
			updateFieldRequired('css_document',0);
			jQuery('#jform_css_document').prop('required','required');
			jQuery('#jform_css_document').attr('aria-required',true);
			jQuery('#jform_css_document').addClass('required');
			jform_oOCEZNckMK_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_document').closest('.control-group').hide();
		if (!jform_oOCEZNckMK_required)
		{
			updateFieldRequired('css_document',1);
			jQuery('#jform_css_document').removeAttr('required');
			jQuery('#jform_css_document').removeAttr('aria-required');
			jQuery('#jform_css_document').removeClass('required');
			jform_oOCEZNckMK_required = true;
		}
	}
}

// the zkkKicQ function
function zkkKicQ(add_js_document_zkkKicQ)
{
	// set the function logic
	if (add_js_document_zkkKicQ == 1)
	{
		jQuery('#jform_js_document').closest('.control-group').show();
		if (jform_zkkKicQqFH_required)
		{
			updateFieldRequired('js_document',0);
			jQuery('#jform_js_document').prop('required','required');
			jQuery('#jform_js_document').attr('aria-required',true);
			jQuery('#jform_js_document').addClass('required');
			jform_zkkKicQqFH_required = false;
		}

	}
	else
	{
		jQuery('#jform_js_document').closest('.control-group').hide();
		if (!jform_zkkKicQqFH_required)
		{
			updateFieldRequired('js_document',1);
			jQuery('#jform_js_document').removeAttr('required');
			jQuery('#jform_js_document').removeAttr('aria-required');
			jQuery('#jform_js_document').removeClass('required');
			jform_zkkKicQqFH_required = true;
		}
	}
}

// the ojUWKMB function
function ojUWKMB(add_custom_button_ojUWKMB)
{
	// set the function logic
	if (add_custom_button_ojUWKMB == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_ojUWKMBSht_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_ojUWKMBSht_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_ojUWKMBkqd_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_ojUWKMBkqd_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_ojUWKMBSht_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_ojUWKMBSht_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_ojUWKMBkqd_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_ojUWKMBkqd_required = true;
		}
	}
}

// the SUeAXqs function
function SUeAXqs(add_css_SUeAXqs)
{
	// set the function logic
	if (add_css_SUeAXqs == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_SUeAXqsBQx_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_SUeAXqsBQx_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_SUeAXqsBQx_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_SUeAXqsBQx_required = true;
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
