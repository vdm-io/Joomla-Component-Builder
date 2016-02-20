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
	@build			20th February, 2016
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
jform_tCpxhKKmop_required = false;
jform_xQRgZFuYXs_required = false;
jform_nwKjhVuBxn_required = false;
jform_HiMbhLuCbZ_required = false;
jform_KhTfPtsQmk_required = false;
jform_gxgnzwHLXN_required = false;
jform_IEYBGhgbIj_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_tCpxhKK = jQuery("#jform_datalenght").val();
	tCpxhKK(datalenght_tCpxhKK);

	var datadefault_xQRgZFu = jQuery("#jform_datadefault").val();
	xQRgZFu(datadefault_xQRgZFu);

	var datatype_nwKjhVu = jQuery("#jform_datatype").val();
	nwKjhVu(datatype_nwKjhVu);

	var store_dROmpWc = jQuery("#jform_store").val();
	var datatype_dROmpWc = jQuery("#jform_datatype").val();
	dROmpWc(store_dROmpWc,datatype_dROmpWc);

	var add_css_view_HiMbhLu = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	HiMbhLu(add_css_view_HiMbhLu);

	var add_css_views_KhTfPts = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	KhTfPts(add_css_views_KhTfPts);

	var add_javascript_view_footer_gxgnzwH = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	gxgnzwH(add_javascript_view_footer_gxgnzwH);

	var add_javascript_views_footer_IEYBGhg = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	IEYBGhg(add_javascript_views_footer_IEYBGhg);
});

// the tCpxhKK function
function tCpxhKK(datalenght_tCpxhKK)
{
	if (isSet(datalenght_tCpxhKK) && datalenght_tCpxhKK.constructor !== Array)
	{
		var temp_tCpxhKK = datalenght_tCpxhKK;
		var datalenght_tCpxhKK = [];
		datalenght_tCpxhKK.push(temp_tCpxhKK);
	}
	else if (!isSet(datalenght_tCpxhKK))
	{
		var datalenght_tCpxhKK = [];
	}
	var datalenght = datalenght_tCpxhKK.some(datalenght_tCpxhKK_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_tCpxhKKmop_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_tCpxhKKmop_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_tCpxhKKmop_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_tCpxhKKmop_required = true;
		}
	}
}

// the tCpxhKK Some function
function datalenght_tCpxhKK_SomeFunc(datalenght_tCpxhKK)
{
	// set the function logic
	if (datalenght_tCpxhKK == 'Other')
	{
		return true;
	}
	return false;
}

// the xQRgZFu function
function xQRgZFu(datadefault_xQRgZFu)
{
	if (isSet(datadefault_xQRgZFu) && datadefault_xQRgZFu.constructor !== Array)
	{
		var temp_xQRgZFu = datadefault_xQRgZFu;
		var datadefault_xQRgZFu = [];
		datadefault_xQRgZFu.push(temp_xQRgZFu);
	}
	else if (!isSet(datadefault_xQRgZFu))
	{
		var datadefault_xQRgZFu = [];
	}
	var datadefault = datadefault_xQRgZFu.some(datadefault_xQRgZFu_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_xQRgZFuYXs_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_xQRgZFuYXs_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_xQRgZFuYXs_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_xQRgZFuYXs_required = true;
		}
	}
}

// the xQRgZFu Some function
function datadefault_xQRgZFu_SomeFunc(datadefault_xQRgZFu)
{
	// set the function logic
	if (datadefault_xQRgZFu == 'Other')
	{
		return true;
	}
	return false;
}

// the nwKjhVu function
function nwKjhVu(datatype_nwKjhVu)
{
	if (isSet(datatype_nwKjhVu) && datatype_nwKjhVu.constructor !== Array)
	{
		var temp_nwKjhVu = datatype_nwKjhVu;
		var datatype_nwKjhVu = [];
		datatype_nwKjhVu.push(temp_nwKjhVu);
	}
	else if (!isSet(datatype_nwKjhVu))
	{
		var datatype_nwKjhVu = [];
	}
	var datatype = datatype_nwKjhVu.some(datatype_nwKjhVu_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_nwKjhVuBxn_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_nwKjhVuBxn_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_nwKjhVuBxn_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_nwKjhVuBxn_required = true;
		}
	}
}

// the nwKjhVu Some function
function datatype_nwKjhVu_SomeFunc(datatype_nwKjhVu)
{
	// set the function logic
	if (datatype_nwKjhVu == 'CHAR' || datatype_nwKjhVu == 'VARCHAR' || datatype_nwKjhVu == 'TEXT' || datatype_nwKjhVu == 'MEDIUMTEXT' || datatype_nwKjhVu == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the dROmpWc function
function dROmpWc(store_dROmpWc,datatype_dROmpWc)
{
	if (isSet(store_dROmpWc) && store_dROmpWc.constructor !== Array)
	{
		var temp_dROmpWc = store_dROmpWc;
		var store_dROmpWc = [];
		store_dROmpWc.push(temp_dROmpWc);
	}
	else if (!isSet(store_dROmpWc))
	{
		var store_dROmpWc = [];
	}
	var store = store_dROmpWc.some(store_dROmpWc_SomeFunc);

	if (isSet(datatype_dROmpWc) && datatype_dROmpWc.constructor !== Array)
	{
		var temp_dROmpWc = datatype_dROmpWc;
		var datatype_dROmpWc = [];
		datatype_dROmpWc.push(temp_dROmpWc);
	}
	else if (!isSet(datatype_dROmpWc))
	{
		var datatype_dROmpWc = [];
	}
	var datatype = datatype_dROmpWc.some(datatype_dROmpWc_SomeFunc);


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

// the dROmpWc Some function
function store_dROmpWc_SomeFunc(store_dROmpWc)
{
	// set the function logic
	if (store_dROmpWc == 4)
	{
		return true;
	}
	return false;
}

// the dROmpWc Some function
function datatype_dROmpWc_SomeFunc(datatype_dROmpWc)
{
	// set the function logic
	if (datatype_dROmpWc == 'CHAR' || datatype_dROmpWc == 'VARCHAR' || datatype_dROmpWc == 'TEXT' || datatype_dROmpWc == 'MEDIUMTEXT' || datatype_dROmpWc == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the HiMbhLu function
function HiMbhLu(add_css_view_HiMbhLu)
{
	// set the function logic
	if (add_css_view_HiMbhLu == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_HiMbhLuCbZ_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_HiMbhLuCbZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_HiMbhLuCbZ_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_HiMbhLuCbZ_required = true;
		}
	}
}

// the KhTfPts function
function KhTfPts(add_css_views_KhTfPts)
{
	// set the function logic
	if (add_css_views_KhTfPts == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_KhTfPtsQmk_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_KhTfPtsQmk_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_KhTfPtsQmk_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_KhTfPtsQmk_required = true;
		}
	}
}

// the gxgnzwH function
function gxgnzwH(add_javascript_view_footer_gxgnzwH)
{
	// set the function logic
	if (add_javascript_view_footer_gxgnzwH == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_gxgnzwHLXN_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_gxgnzwHLXN_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_gxgnzwHLXN_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_gxgnzwHLXN_required = true;
		}
	}
}

// the IEYBGhg function
function IEYBGhg(add_javascript_views_footer_IEYBGhg)
{
	// set the function logic
	if (add_javascript_views_footer_IEYBGhg == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_IEYBGhgbIj_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_IEYBGhgbIj_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_IEYBGhgbIj_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_IEYBGhgbIj_required = true;
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
