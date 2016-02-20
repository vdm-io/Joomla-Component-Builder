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
jform_ExCMVvbuzU_required = false;
jform_dfOStolxhg_required = false;
jform_sldbrZQaHq_required = false;
jform_gsZyLjyYsJ_required = false;
jform_ZRJPPuceGS_required = false;
jform_axzxDJgwZa_required = false;
jform_bhsaEYheWH_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_ExCMVvb = jQuery("#jform_datalenght").val();
	ExCMVvb(datalenght_ExCMVvb);

	var datadefault_dfOStol = jQuery("#jform_datadefault").val();
	dfOStol(datadefault_dfOStol);

	var datatype_sldbrZQ = jQuery("#jform_datatype").val();
	sldbrZQ(datatype_sldbrZQ);

	var store_mpOVXMx = jQuery("#jform_store").val();
	var datatype_mpOVXMx = jQuery("#jform_datatype").val();
	mpOVXMx(store_mpOVXMx,datatype_mpOVXMx);

	var add_css_view_gsZyLjy = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	gsZyLjy(add_css_view_gsZyLjy);

	var add_css_views_ZRJPPuc = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	ZRJPPuc(add_css_views_ZRJPPuc);

	var add_javascript_view_footer_axzxDJg = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	axzxDJg(add_javascript_view_footer_axzxDJg);

	var add_javascript_views_footer_bhsaEYh = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	bhsaEYh(add_javascript_views_footer_bhsaEYh);
});

// the ExCMVvb function
function ExCMVvb(datalenght_ExCMVvb)
{
	if (isSet(datalenght_ExCMVvb) && datalenght_ExCMVvb.constructor !== Array)
	{
		var temp_ExCMVvb = datalenght_ExCMVvb;
		var datalenght_ExCMVvb = [];
		datalenght_ExCMVvb.push(temp_ExCMVvb);
	}
	else if (!isSet(datalenght_ExCMVvb))
	{
		var datalenght_ExCMVvb = [];
	}
	var datalenght = datalenght_ExCMVvb.some(datalenght_ExCMVvb_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_ExCMVvbuzU_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_ExCMVvbuzU_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_ExCMVvbuzU_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_ExCMVvbuzU_required = true;
		}
	}
}

// the ExCMVvb Some function
function datalenght_ExCMVvb_SomeFunc(datalenght_ExCMVvb)
{
	// set the function logic
	if (datalenght_ExCMVvb == 'Other')
	{
		return true;
	}
	return false;
}

// the dfOStol function
function dfOStol(datadefault_dfOStol)
{
	if (isSet(datadefault_dfOStol) && datadefault_dfOStol.constructor !== Array)
	{
		var temp_dfOStol = datadefault_dfOStol;
		var datadefault_dfOStol = [];
		datadefault_dfOStol.push(temp_dfOStol);
	}
	else if (!isSet(datadefault_dfOStol))
	{
		var datadefault_dfOStol = [];
	}
	var datadefault = datadefault_dfOStol.some(datadefault_dfOStol_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_dfOStolxhg_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_dfOStolxhg_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_dfOStolxhg_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_dfOStolxhg_required = true;
		}
	}
}

// the dfOStol Some function
function datadefault_dfOStol_SomeFunc(datadefault_dfOStol)
{
	// set the function logic
	if (datadefault_dfOStol == 'Other')
	{
		return true;
	}
	return false;
}

// the sldbrZQ function
function sldbrZQ(datatype_sldbrZQ)
{
	if (isSet(datatype_sldbrZQ) && datatype_sldbrZQ.constructor !== Array)
	{
		var temp_sldbrZQ = datatype_sldbrZQ;
		var datatype_sldbrZQ = [];
		datatype_sldbrZQ.push(temp_sldbrZQ);
	}
	else if (!isSet(datatype_sldbrZQ))
	{
		var datatype_sldbrZQ = [];
	}
	var datatype = datatype_sldbrZQ.some(datatype_sldbrZQ_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_sldbrZQaHq_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_sldbrZQaHq_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_sldbrZQaHq_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_sldbrZQaHq_required = true;
		}
	}
}

// the sldbrZQ Some function
function datatype_sldbrZQ_SomeFunc(datatype_sldbrZQ)
{
	// set the function logic
	if (datatype_sldbrZQ == 'CHAR' || datatype_sldbrZQ == 'VARCHAR' || datatype_sldbrZQ == 'TEXT' || datatype_sldbrZQ == 'MEDIUMTEXT' || datatype_sldbrZQ == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the mpOVXMx function
function mpOVXMx(store_mpOVXMx,datatype_mpOVXMx)
{
	if (isSet(store_mpOVXMx) && store_mpOVXMx.constructor !== Array)
	{
		var temp_mpOVXMx = store_mpOVXMx;
		var store_mpOVXMx = [];
		store_mpOVXMx.push(temp_mpOVXMx);
	}
	else if (!isSet(store_mpOVXMx))
	{
		var store_mpOVXMx = [];
	}
	var store = store_mpOVXMx.some(store_mpOVXMx_SomeFunc);

	if (isSet(datatype_mpOVXMx) && datatype_mpOVXMx.constructor !== Array)
	{
		var temp_mpOVXMx = datatype_mpOVXMx;
		var datatype_mpOVXMx = [];
		datatype_mpOVXMx.push(temp_mpOVXMx);
	}
	else if (!isSet(datatype_mpOVXMx))
	{
		var datatype_mpOVXMx = [];
	}
	var datatype = datatype_mpOVXMx.some(datatype_mpOVXMx_SomeFunc);


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

// the mpOVXMx Some function
function store_mpOVXMx_SomeFunc(store_mpOVXMx)
{
	// set the function logic
	if (store_mpOVXMx == 4)
	{
		return true;
	}
	return false;
}

// the mpOVXMx Some function
function datatype_mpOVXMx_SomeFunc(datatype_mpOVXMx)
{
	// set the function logic
	if (datatype_mpOVXMx == 'CHAR' || datatype_mpOVXMx == 'VARCHAR' || datatype_mpOVXMx == 'TEXT' || datatype_mpOVXMx == 'MEDIUMTEXT' || datatype_mpOVXMx == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the gsZyLjy function
function gsZyLjy(add_css_view_gsZyLjy)
{
	// set the function logic
	if (add_css_view_gsZyLjy == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_gsZyLjyYsJ_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_gsZyLjyYsJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_gsZyLjyYsJ_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_gsZyLjyYsJ_required = true;
		}
	}
}

// the ZRJPPuc function
function ZRJPPuc(add_css_views_ZRJPPuc)
{
	// set the function logic
	if (add_css_views_ZRJPPuc == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_ZRJPPuceGS_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_ZRJPPuceGS_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_ZRJPPuceGS_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_ZRJPPuceGS_required = true;
		}
	}
}

// the axzxDJg function
function axzxDJg(add_javascript_view_footer_axzxDJg)
{
	// set the function logic
	if (add_javascript_view_footer_axzxDJg == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_axzxDJgwZa_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_axzxDJgwZa_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_axzxDJgwZa_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_axzxDJgwZa_required = true;
		}
	}
}

// the bhsaEYh function
function bhsaEYh(add_javascript_views_footer_bhsaEYh)
{
	// set the function logic
	if (add_javascript_views_footer_bhsaEYh == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_bhsaEYheWH_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_bhsaEYheWH_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_bhsaEYheWH_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_bhsaEYheWH_required = true;
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
