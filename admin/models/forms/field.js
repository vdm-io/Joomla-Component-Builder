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

	@version		2.0.9
	@build			15th February, 2016
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
jform_EyWzgBQyJf_required = false;
jform_McPzOSbdRM_required = false;
jform_VGKTXXCBAB_required = false;
jform_WxmXHfGwQu_required = false;
jform_xKrSpMmdRm_required = false;
jform_MDsRWdyEtt_required = false;
jform_WpQktAuaXg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_EyWzgBQ = jQuery("#jform_datalenght").val();
	EyWzgBQ(datalenght_EyWzgBQ);

	var datadefault_McPzOSb = jQuery("#jform_datadefault").val();
	McPzOSb(datadefault_McPzOSb);

	var datatype_VGKTXXC = jQuery("#jform_datatype").val();
	VGKTXXC(datatype_VGKTXXC);

	var store_HfaEFgg = jQuery("#jform_store").val();
	var datatype_HfaEFgg = jQuery("#jform_datatype").val();
	HfaEFgg(store_HfaEFgg,datatype_HfaEFgg);

	var add_css_view_WxmXHfG = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	WxmXHfG(add_css_view_WxmXHfG);

	var add_css_views_xKrSpMm = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	xKrSpMm(add_css_views_xKrSpMm);

	var add_javascript_view_footer_MDsRWdy = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	MDsRWdy(add_javascript_view_footer_MDsRWdy);

	var add_javascript_views_footer_WpQktAu = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	WpQktAu(add_javascript_views_footer_WpQktAu);
});

// the EyWzgBQ function
function EyWzgBQ(datalenght_EyWzgBQ)
{
	if (isSet(datalenght_EyWzgBQ) && datalenght_EyWzgBQ.constructor !== Array)
	{
		var temp_EyWzgBQ = datalenght_EyWzgBQ;
		var datalenght_EyWzgBQ = [];
		datalenght_EyWzgBQ.push(temp_EyWzgBQ);
	}
	else if (!isSet(datalenght_EyWzgBQ))
	{
		var datalenght_EyWzgBQ = [];
	}
	var datalenght = datalenght_EyWzgBQ.some(datalenght_EyWzgBQ_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_EyWzgBQyJf_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_EyWzgBQyJf_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_EyWzgBQyJf_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_EyWzgBQyJf_required = true;
		}
	}
}

// the EyWzgBQ Some function
function datalenght_EyWzgBQ_SomeFunc(datalenght_EyWzgBQ)
{
	// set the function logic
	if (datalenght_EyWzgBQ == 'Other')
	{
		return true;
	}
	return false;
}

// the McPzOSb function
function McPzOSb(datadefault_McPzOSb)
{
	if (isSet(datadefault_McPzOSb) && datadefault_McPzOSb.constructor !== Array)
	{
		var temp_McPzOSb = datadefault_McPzOSb;
		var datadefault_McPzOSb = [];
		datadefault_McPzOSb.push(temp_McPzOSb);
	}
	else if (!isSet(datadefault_McPzOSb))
	{
		var datadefault_McPzOSb = [];
	}
	var datadefault = datadefault_McPzOSb.some(datadefault_McPzOSb_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_McPzOSbdRM_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_McPzOSbdRM_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_McPzOSbdRM_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_McPzOSbdRM_required = true;
		}
	}
}

// the McPzOSb Some function
function datadefault_McPzOSb_SomeFunc(datadefault_McPzOSb)
{
	// set the function logic
	if (datadefault_McPzOSb == 'Other')
	{
		return true;
	}
	return false;
}

// the VGKTXXC function
function VGKTXXC(datatype_VGKTXXC)
{
	if (isSet(datatype_VGKTXXC) && datatype_VGKTXXC.constructor !== Array)
	{
		var temp_VGKTXXC = datatype_VGKTXXC;
		var datatype_VGKTXXC = [];
		datatype_VGKTXXC.push(temp_VGKTXXC);
	}
	else if (!isSet(datatype_VGKTXXC))
	{
		var datatype_VGKTXXC = [];
	}
	var datatype = datatype_VGKTXXC.some(datatype_VGKTXXC_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_VGKTXXCBAB_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_VGKTXXCBAB_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_VGKTXXCBAB_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_VGKTXXCBAB_required = true;
		}
	}
}

// the VGKTXXC Some function
function datatype_VGKTXXC_SomeFunc(datatype_VGKTXXC)
{
	// set the function logic
	if (datatype_VGKTXXC == 'CHAR' || datatype_VGKTXXC == 'VARCHAR' || datatype_VGKTXXC == 'TEXT' || datatype_VGKTXXC == 'MEDIUMTEXT' || datatype_VGKTXXC == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the HfaEFgg function
function HfaEFgg(store_HfaEFgg,datatype_HfaEFgg)
{
	if (isSet(store_HfaEFgg) && store_HfaEFgg.constructor !== Array)
	{
		var temp_HfaEFgg = store_HfaEFgg;
		var store_HfaEFgg = [];
		store_HfaEFgg.push(temp_HfaEFgg);
	}
	else if (!isSet(store_HfaEFgg))
	{
		var store_HfaEFgg = [];
	}
	var store = store_HfaEFgg.some(store_HfaEFgg_SomeFunc);

	if (isSet(datatype_HfaEFgg) && datatype_HfaEFgg.constructor !== Array)
	{
		var temp_HfaEFgg = datatype_HfaEFgg;
		var datatype_HfaEFgg = [];
		datatype_HfaEFgg.push(temp_HfaEFgg);
	}
	else if (!isSet(datatype_HfaEFgg))
	{
		var datatype_HfaEFgg = [];
	}
	var datatype = datatype_HfaEFgg.some(datatype_HfaEFgg_SomeFunc);


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

// the HfaEFgg Some function
function store_HfaEFgg_SomeFunc(store_HfaEFgg)
{
	// set the function logic
	if (store_HfaEFgg == 4)
	{
		return true;
	}
	return false;
}

// the HfaEFgg Some function
function datatype_HfaEFgg_SomeFunc(datatype_HfaEFgg)
{
	// set the function logic
	if (datatype_HfaEFgg == 'CHAR' || datatype_HfaEFgg == 'VARCHAR' || datatype_HfaEFgg == 'TEXT' || datatype_HfaEFgg == 'MEDIUMTEXT' || datatype_HfaEFgg == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the WxmXHfG function
function WxmXHfG(add_css_view_WxmXHfG)
{
	// set the function logic
	if (add_css_view_WxmXHfG == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_WxmXHfGwQu_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_WxmXHfGwQu_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_WxmXHfGwQu_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_WxmXHfGwQu_required = true;
		}
	}
}

// the xKrSpMm function
function xKrSpMm(add_css_views_xKrSpMm)
{
	// set the function logic
	if (add_css_views_xKrSpMm == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_xKrSpMmdRm_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_xKrSpMmdRm_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_xKrSpMmdRm_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_xKrSpMmdRm_required = true;
		}
	}
}

// the MDsRWdy function
function MDsRWdy(add_javascript_view_footer_MDsRWdy)
{
	// set the function logic
	if (add_javascript_view_footer_MDsRWdy == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_MDsRWdyEtt_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_MDsRWdyEtt_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_MDsRWdyEtt_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_MDsRWdyEtt_required = true;
		}
	}
}

// the WpQktAu function
function WpQktAu(add_javascript_views_footer_WpQktAu)
{
	// set the function logic
	if (add_javascript_views_footer_WpQktAu == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_WpQktAuaXg_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_WpQktAuaXg_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_WpQktAuaXg_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_WpQktAuaXg_required = true;
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
