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

	@version		2.0.8
	@build			31st January, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_ogLArBowSW_required = false;
jform_LNSaBqakxE_required = false;
jform_JSuRaPtDFD_required = false;
jform_XiCXzgvibW_required = false;
jform_YbNyEmVFiE_required = false;
jform_kwBwcMwxFd_required = false;
jform_UBqDFLFbRL_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_ogLArBo = jQuery("#jform_datalenght").val();
	ogLArBo(datalenght_ogLArBo);

	var datadefault_LNSaBqa = jQuery("#jform_datadefault").val();
	LNSaBqa(datadefault_LNSaBqa);

	var datatype_JSuRaPt = jQuery("#jform_datatype").val();
	JSuRaPt(datatype_JSuRaPt);

	var store_bSCLtUg = jQuery("#jform_store").val();
	var datatype_bSCLtUg = jQuery("#jform_datatype").val();
	bSCLtUg(store_bSCLtUg,datatype_bSCLtUg);

	var add_css_view_XiCXzgv = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	XiCXzgv(add_css_view_XiCXzgv);

	var add_css_views_YbNyEmV = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	YbNyEmV(add_css_views_YbNyEmV);

	var add_javascript_view_footer_kwBwcMw = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	kwBwcMw(add_javascript_view_footer_kwBwcMw);

	var add_javascript_views_footer_UBqDFLF = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	UBqDFLF(add_javascript_views_footer_UBqDFLF);
});

// the ogLArBo function
function ogLArBo(datalenght_ogLArBo)
{
	if (isSet(datalenght_ogLArBo) && datalenght_ogLArBo.constructor !== Array)
	{
		var temp_ogLArBo = datalenght_ogLArBo;
		var datalenght_ogLArBo = [];
		datalenght_ogLArBo.push(temp_ogLArBo);
	}
	else if (!isSet(datalenght_ogLArBo))
	{
		var datalenght_ogLArBo = [];
	}
	var datalenght = datalenght_ogLArBo.some(datalenght_ogLArBo_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_ogLArBowSW_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_ogLArBowSW_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_ogLArBowSW_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_ogLArBowSW_required = true;
		}
	}
}

// the ogLArBo Some function
function datalenght_ogLArBo_SomeFunc(datalenght_ogLArBo)
{
	// set the function logic
	if (datalenght_ogLArBo == 'Other')
	{
		return true;
	}
	return false;
}

// the LNSaBqa function
function LNSaBqa(datadefault_LNSaBqa)
{
	if (isSet(datadefault_LNSaBqa) && datadefault_LNSaBqa.constructor !== Array)
	{
		var temp_LNSaBqa = datadefault_LNSaBqa;
		var datadefault_LNSaBqa = [];
		datadefault_LNSaBqa.push(temp_LNSaBqa);
	}
	else if (!isSet(datadefault_LNSaBqa))
	{
		var datadefault_LNSaBqa = [];
	}
	var datadefault = datadefault_LNSaBqa.some(datadefault_LNSaBqa_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_LNSaBqakxE_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_LNSaBqakxE_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_LNSaBqakxE_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_LNSaBqakxE_required = true;
		}
	}
}

// the LNSaBqa Some function
function datadefault_LNSaBqa_SomeFunc(datadefault_LNSaBqa)
{
	// set the function logic
	if (datadefault_LNSaBqa == 'Other')
	{
		return true;
	}
	return false;
}

// the JSuRaPt function
function JSuRaPt(datatype_JSuRaPt)
{
	if (isSet(datatype_JSuRaPt) && datatype_JSuRaPt.constructor !== Array)
	{
		var temp_JSuRaPt = datatype_JSuRaPt;
		var datatype_JSuRaPt = [];
		datatype_JSuRaPt.push(temp_JSuRaPt);
	}
	else if (!isSet(datatype_JSuRaPt))
	{
		var datatype_JSuRaPt = [];
	}
	var datatype = datatype_JSuRaPt.some(datatype_JSuRaPt_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_JSuRaPtDFD_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_JSuRaPtDFD_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_JSuRaPtDFD_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_JSuRaPtDFD_required = true;
		}
	}
}

// the JSuRaPt Some function
function datatype_JSuRaPt_SomeFunc(datatype_JSuRaPt)
{
	// set the function logic
	if (datatype_JSuRaPt == 'CHAR' || datatype_JSuRaPt == 'VARCHAR' || datatype_JSuRaPt == 'TEXT' || datatype_JSuRaPt == 'MEDIUMTEXT' || datatype_JSuRaPt == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the bSCLtUg function
function bSCLtUg(store_bSCLtUg,datatype_bSCLtUg)
{
	if (isSet(store_bSCLtUg) && store_bSCLtUg.constructor !== Array)
	{
		var temp_bSCLtUg = store_bSCLtUg;
		var store_bSCLtUg = [];
		store_bSCLtUg.push(temp_bSCLtUg);
	}
	else if (!isSet(store_bSCLtUg))
	{
		var store_bSCLtUg = [];
	}
	var store = store_bSCLtUg.some(store_bSCLtUg_SomeFunc);

	if (isSet(datatype_bSCLtUg) && datatype_bSCLtUg.constructor !== Array)
	{
		var temp_bSCLtUg = datatype_bSCLtUg;
		var datatype_bSCLtUg = [];
		datatype_bSCLtUg.push(temp_bSCLtUg);
	}
	else if (!isSet(datatype_bSCLtUg))
	{
		var datatype_bSCLtUg = [];
	}
	var datatype = datatype_bSCLtUg.some(datatype_bSCLtUg_SomeFunc);


	// set this function logic
	if (store && datatype)
	{
		jQuery('.note_vdm_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_vdm_encryption').closest('.control-group').hide();
	}
}

// the bSCLtUg Some function
function store_bSCLtUg_SomeFunc(store_bSCLtUg)
{
	// set the function logic
	if (store_bSCLtUg == 4)
	{
		return true;
	}
	return false;
}

// the bSCLtUg Some function
function datatype_bSCLtUg_SomeFunc(datatype_bSCLtUg)
{
	// set the function logic
	if (datatype_bSCLtUg == 'CHAR' || datatype_bSCLtUg == 'VARCHAR' || datatype_bSCLtUg == 'TEXT' || datatype_bSCLtUg == 'MEDIUMTEXT' || datatype_bSCLtUg == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the XiCXzgv function
function XiCXzgv(add_css_view_XiCXzgv)
{
	// set the function logic
	if (add_css_view_XiCXzgv == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_XiCXzgvibW_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_XiCXzgvibW_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_XiCXzgvibW_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_XiCXzgvibW_required = true;
		}
	}
}

// the YbNyEmV function
function YbNyEmV(add_css_views_YbNyEmV)
{
	// set the function logic
	if (add_css_views_YbNyEmV == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_YbNyEmVFiE_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_YbNyEmVFiE_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_YbNyEmVFiE_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_YbNyEmVFiE_required = true;
		}
	}
}

// the kwBwcMw function
function kwBwcMw(add_javascript_view_footer_kwBwcMw)
{
	// set the function logic
	if (add_javascript_view_footer_kwBwcMw == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_kwBwcMwxFd_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_kwBwcMwxFd_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_kwBwcMwxFd_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_kwBwcMwxFd_required = true;
		}
	}
}

// the UBqDFLF function
function UBqDFLF(add_javascript_views_footer_UBqDFLF)
{
	// set the function logic
	if (add_javascript_views_footer_UBqDFLF == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_UBqDFLFbRL_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_UBqDFLFbRL_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_UBqDFLFbRL_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_UBqDFLFbRL_required = true;
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

function getFieldOptions_server(fieldId){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.fieldOptions&format=json";
	if(token.length > 0 && fieldId > 0){
		var request = 'token='+token+'&id='+fieldId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getFieldOptions(id,setValue){
	getFieldOptions_server(id).done(function(result) {
		if(result.values){
			if(setValue){
				jQuery('textarea#jform_xml').val(result.values);
			}
			jQuery('#help').remove();
			jQuery('.helpNote').append('<div id="help" style="margin: 10px;">'+result.description+'<br />'+result.values_description+'</div>');
		}
	})
}  
