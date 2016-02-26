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
	@subpackage		field.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_NODNrMYYLd_required = false;
jform_CnYULvxyUL_required = false;
jform_yPbYchbBeJ_required = false;
jform_dteIYbmqSt_required = false;
jform_pUAxoDgTwH_required = false;
jform_VZpFBddrmR_required = false;
jform_UwmbYqeqEV_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_NODNrMY = jQuery("#jform_datalenght").val();
	NODNrMY(datalenght_NODNrMY);

	var datadefault_CnYULvx = jQuery("#jform_datadefault").val();
	CnYULvx(datadefault_CnYULvx);

	var datatype_yPbYchb = jQuery("#jform_datatype").val();
	yPbYchb(datatype_yPbYchb);

	var store_xRDbEOO = jQuery("#jform_store").val();
	var datatype_xRDbEOO = jQuery("#jform_datatype").val();
	xRDbEOO(store_xRDbEOO,datatype_xRDbEOO);

	var add_css_view_dteIYbm = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	dteIYbm(add_css_view_dteIYbm);

	var add_css_views_pUAxoDg = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	pUAxoDg(add_css_views_pUAxoDg);

	var add_javascript_view_footer_VZpFBdd = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	VZpFBdd(add_javascript_view_footer_VZpFBdd);

	var add_javascript_views_footer_UwmbYqe = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	UwmbYqe(add_javascript_views_footer_UwmbYqe);
});

// the NODNrMY function
function NODNrMY(datalenght_NODNrMY)
{
	if (isSet(datalenght_NODNrMY) && datalenght_NODNrMY.constructor !== Array)
	{
		var temp_NODNrMY = datalenght_NODNrMY;
		var datalenght_NODNrMY = [];
		datalenght_NODNrMY.push(temp_NODNrMY);
	}
	else if (!isSet(datalenght_NODNrMY))
	{
		var datalenght_NODNrMY = [];
	}
	var datalenght = datalenght_NODNrMY.some(datalenght_NODNrMY_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_NODNrMYYLd_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_NODNrMYYLd_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_NODNrMYYLd_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_NODNrMYYLd_required = true;
		}
	}
}

// the NODNrMY Some function
function datalenght_NODNrMY_SomeFunc(datalenght_NODNrMY)
{
	// set the function logic
	if (datalenght_NODNrMY == 'Other')
	{
		return true;
	}
	return false;
}

// the CnYULvx function
function CnYULvx(datadefault_CnYULvx)
{
	if (isSet(datadefault_CnYULvx) && datadefault_CnYULvx.constructor !== Array)
	{
		var temp_CnYULvx = datadefault_CnYULvx;
		var datadefault_CnYULvx = [];
		datadefault_CnYULvx.push(temp_CnYULvx);
	}
	else if (!isSet(datadefault_CnYULvx))
	{
		var datadefault_CnYULvx = [];
	}
	var datadefault = datadefault_CnYULvx.some(datadefault_CnYULvx_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_CnYULvxyUL_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_CnYULvxyUL_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_CnYULvxyUL_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_CnYULvxyUL_required = true;
		}
	}
}

// the CnYULvx Some function
function datadefault_CnYULvx_SomeFunc(datadefault_CnYULvx)
{
	// set the function logic
	if (datadefault_CnYULvx == 'Other')
	{
		return true;
	}
	return false;
}

// the yPbYchb function
function yPbYchb(datatype_yPbYchb)
{
	if (isSet(datatype_yPbYchb) && datatype_yPbYchb.constructor !== Array)
	{
		var temp_yPbYchb = datatype_yPbYchb;
		var datatype_yPbYchb = [];
		datatype_yPbYchb.push(temp_yPbYchb);
	}
	else if (!isSet(datatype_yPbYchb))
	{
		var datatype_yPbYchb = [];
	}
	var datatype = datatype_yPbYchb.some(datatype_yPbYchb_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_yPbYchbBeJ_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_yPbYchbBeJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_yPbYchbBeJ_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_yPbYchbBeJ_required = true;
		}
	}
}

// the yPbYchb Some function
function datatype_yPbYchb_SomeFunc(datatype_yPbYchb)
{
	// set the function logic
	if (datatype_yPbYchb == 'CHAR' || datatype_yPbYchb == 'VARCHAR' || datatype_yPbYchb == 'TEXT' || datatype_yPbYchb == 'MEDIUMTEXT' || datatype_yPbYchb == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the xRDbEOO function
function xRDbEOO(store_xRDbEOO,datatype_xRDbEOO)
{
	if (isSet(store_xRDbEOO) && store_xRDbEOO.constructor !== Array)
	{
		var temp_xRDbEOO = store_xRDbEOO;
		var store_xRDbEOO = [];
		store_xRDbEOO.push(temp_xRDbEOO);
	}
	else if (!isSet(store_xRDbEOO))
	{
		var store_xRDbEOO = [];
	}
	var store = store_xRDbEOO.some(store_xRDbEOO_SomeFunc);

	if (isSet(datatype_xRDbEOO) && datatype_xRDbEOO.constructor !== Array)
	{
		var temp_xRDbEOO = datatype_xRDbEOO;
		var datatype_xRDbEOO = [];
		datatype_xRDbEOO.push(temp_xRDbEOO);
	}
	else if (!isSet(datatype_xRDbEOO))
	{
		var datatype_xRDbEOO = [];
	}
	var datatype = datatype_xRDbEOO.some(datatype_xRDbEOO_SomeFunc);


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

// the xRDbEOO Some function
function store_xRDbEOO_SomeFunc(store_xRDbEOO)
{
	// set the function logic
	if (store_xRDbEOO == 4)
	{
		return true;
	}
	return false;
}

// the xRDbEOO Some function
function datatype_xRDbEOO_SomeFunc(datatype_xRDbEOO)
{
	// set the function logic
	if (datatype_xRDbEOO == 'CHAR' || datatype_xRDbEOO == 'VARCHAR' || datatype_xRDbEOO == 'TEXT' || datatype_xRDbEOO == 'MEDIUMTEXT' || datatype_xRDbEOO == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the dteIYbm function
function dteIYbm(add_css_view_dteIYbm)
{
	// set the function logic
	if (add_css_view_dteIYbm == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_dteIYbmqSt_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_dteIYbmqSt_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_dteIYbmqSt_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_dteIYbmqSt_required = true;
		}
	}
}

// the pUAxoDg function
function pUAxoDg(add_css_views_pUAxoDg)
{
	// set the function logic
	if (add_css_views_pUAxoDg == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_pUAxoDgTwH_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_pUAxoDgTwH_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_pUAxoDgTwH_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_pUAxoDgTwH_required = true;
		}
	}
}

// the VZpFBdd function
function VZpFBdd(add_javascript_view_footer_VZpFBdd)
{
	// set the function logic
	if (add_javascript_view_footer_VZpFBdd == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_VZpFBddrmR_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_VZpFBddrmR_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_VZpFBddrmR_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_VZpFBddrmR_required = true;
		}
	}
}

// the UwmbYqe function
function UwmbYqe(add_javascript_views_footer_UwmbYqe)
{
	// set the function logic
	if (add_javascript_views_footer_UwmbYqe == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_UwmbYqeqEV_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_UwmbYqeqEV_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_UwmbYqeqEV_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_UwmbYqeqEV_required = true;
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
