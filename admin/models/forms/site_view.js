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

	@version		@update number 44 of this MVC
	@build			29th January, 2017
	@created		29th May, 2015
	@package		Component Builder
	@subpackage		site_view.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvyhvyf_required = false;
jform_vvvvvyivyg_required = false;
jform_vvvvvyjvyh_required = false;
jform_vvvvvykvyi_required = false;
jform_vvvvvylvyj_required = false;
jform_vvvvvymvyk_required = false;
jform_vvvvvynvyl_required = false;
jform_vvvvvyovym_required = false;
jform_vvvvvypvyn_required = false;
jform_vvvvvypvyo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_view_vvvvvyh = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvyh(add_php_view_vvvvvyh);

	var add_php_jview_display_vvvvvyi = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvyi(add_php_jview_display_vvvvvyi);

	var add_php_jview_vvvvvyj = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvyj(add_php_jview_vvvvvyj);

	var add_php_document_vvvvvyk = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvyk(add_php_document_vvvvvyk);

	var add_css_document_vvvvvyl = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvyl(add_css_document_vvvvvyl);

	var add_js_document_vvvvvym = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvym(add_js_document_vvvvvym);

	var add_css_vvvvvyn = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvyn(add_css_vvvvvyn);

	var add_php_ajax_vvvvvyo = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvyo(add_php_ajax_vvvvvyo);

	var add_custom_button_vvvvvyp = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvyp(add_custom_button_vvvvvyp);
});

// the vvvvvyh function
function vvvvvyh(add_php_view_vvvvvyh)
{
	// set the function logic
	if (add_php_view_vvvvvyh == 1)
	{
		jQuery('#jform_php_view').closest('.control-group').show();
		if (jform_vvvvvyhvyf_required)
		{
			updateFieldRequired('php_view',0);
			jQuery('#jform_php_view').prop('required','required');
			jQuery('#jform_php_view').attr('aria-required',true);
			jQuery('#jform_php_view').addClass('required');
			jform_vvvvvyhvyf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_view').closest('.control-group').hide();
		if (!jform_vvvvvyhvyf_required)
		{
			updateFieldRequired('php_view',1);
			jQuery('#jform_php_view').removeAttr('required');
			jQuery('#jform_php_view').removeAttr('aria-required');
			jQuery('#jform_php_view').removeClass('required');
			jform_vvvvvyhvyf_required = true;
		}
	}
}

// the vvvvvyi function
function vvvvvyi(add_php_jview_display_vvvvvyi)
{
	// set the function logic
	if (add_php_jview_display_vvvvvyi == 1)
	{
		jQuery('#jform_php_jview_display').closest('.control-group').show();
		if (jform_vvvvvyivyg_required)
		{
			updateFieldRequired('php_jview_display',0);
			jQuery('#jform_php_jview_display').prop('required','required');
			jQuery('#jform_php_jview_display').attr('aria-required',true);
			jQuery('#jform_php_jview_display').addClass('required');
			jform_vvvvvyivyg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview_display').closest('.control-group').hide();
		if (!jform_vvvvvyivyg_required)
		{
			updateFieldRequired('php_jview_display',1);
			jQuery('#jform_php_jview_display').removeAttr('required');
			jQuery('#jform_php_jview_display').removeAttr('aria-required');
			jQuery('#jform_php_jview_display').removeClass('required');
			jform_vvvvvyivyg_required = true;
		}
	}
}

// the vvvvvyj function
function vvvvvyj(add_php_jview_vvvvvyj)
{
	// set the function logic
	if (add_php_jview_vvvvvyj == 1)
	{
		jQuery('#jform_php_jview').closest('.control-group').show();
		if (jform_vvvvvyjvyh_required)
		{
			updateFieldRequired('php_jview',0);
			jQuery('#jform_php_jview').prop('required','required');
			jQuery('#jform_php_jview').attr('aria-required',true);
			jQuery('#jform_php_jview').addClass('required');
			jform_vvvvvyjvyh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_jview').closest('.control-group').hide();
		if (!jform_vvvvvyjvyh_required)
		{
			updateFieldRequired('php_jview',1);
			jQuery('#jform_php_jview').removeAttr('required');
			jQuery('#jform_php_jview').removeAttr('aria-required');
			jQuery('#jform_php_jview').removeClass('required');
			jform_vvvvvyjvyh_required = true;
		}
	}
}

// the vvvvvyk function
function vvvvvyk(add_php_document_vvvvvyk)
{
	// set the function logic
	if (add_php_document_vvvvvyk == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_vvvvvykvyi_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_vvvvvykvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_vvvvvykvyi_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_vvvvvykvyi_required = true;
		}
	}
}

// the vvvvvyl function
function vvvvvyl(add_css_document_vvvvvyl)
{
	// set the function logic
	if (add_css_document_vvvvvyl == 1)
	{
		jQuery('#jform_css_document').closest('.control-group').show();
		if (jform_vvvvvylvyj_required)
		{
			updateFieldRequired('css_document',0);
			jQuery('#jform_css_document').prop('required','required');
			jQuery('#jform_css_document').attr('aria-required',true);
			jQuery('#jform_css_document').addClass('required');
			jform_vvvvvylvyj_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_document').closest('.control-group').hide();
		if (!jform_vvvvvylvyj_required)
		{
			updateFieldRequired('css_document',1);
			jQuery('#jform_css_document').removeAttr('required');
			jQuery('#jform_css_document').removeAttr('aria-required');
			jQuery('#jform_css_document').removeClass('required');
			jform_vvvvvylvyj_required = true;
		}
	}
}

// the vvvvvym function
function vvvvvym(add_js_document_vvvvvym)
{
	// set the function logic
	if (add_js_document_vvvvvym == 1)
	{
		jQuery('#jform_js_document').closest('.control-group').show();
		if (jform_vvvvvymvyk_required)
		{
			updateFieldRequired('js_document',0);
			jQuery('#jform_js_document').prop('required','required');
			jQuery('#jform_js_document').attr('aria-required',true);
			jQuery('#jform_js_document').addClass('required');
			jform_vvvvvymvyk_required = false;
		}

	}
	else
	{
		jQuery('#jform_js_document').closest('.control-group').hide();
		if (!jform_vvvvvymvyk_required)
		{
			updateFieldRequired('js_document',1);
			jQuery('#jform_js_document').removeAttr('required');
			jQuery('#jform_js_document').removeAttr('aria-required');
			jQuery('#jform_js_document').removeClass('required');
			jform_vvvvvymvyk_required = true;
		}
	}
}

// the vvvvvyn function
function vvvvvyn(add_css_vvvvvyn)
{
	// set the function logic
	if (add_css_vvvvvyn == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_vvvvvynvyl_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_vvvvvynvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_vvvvvynvyl_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_vvvvvynvyl_required = true;
		}
	}
}

// the vvvvvyo function
function vvvvvyo(add_php_ajax_vvvvvyo)
{
	// set the function logic
	if (add_php_ajax_vvvvvyo == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvyovym_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvyovym_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvyovym_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvyovym_required = true;
		}
	}
}

// the vvvvvyp function
function vvvvvyp(add_custom_button_vvvvvyp)
{
	// set the function logic
	if (add_custom_button_vvvvvyp == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_vvvvvypvyn_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_vvvvvypvyn_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_vvvvvypvyo_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_vvvvvypvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_vvvvvypvyn_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_vvvvvypvyn_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_vvvvvypvyo_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_vvvvvypvyo_required = true;
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
