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
jform_WRLqLteMhn_required = false;
jform_sHxpEfigHv_required = false;
jform_MkhkJDyCir_required = false;
jform_uvpCAcXsrf_required = false;
jform_xVHdqKCxVJ_required = false;
jform_erGiOwzvnp_required = false;
jform_HEJchnffCw_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_WRLqLte = jQuery("#jform_datalenght").val();
	WRLqLte(datalenght_WRLqLte);

	var datadefault_sHxpEfi = jQuery("#jform_datadefault").val();
	sHxpEfi(datadefault_sHxpEfi);

	var datatype_MkhkJDy = jQuery("#jform_datatype").val();
	MkhkJDy(datatype_MkhkJDy);

	var store_aflGrXf = jQuery("#jform_store").val();
	var datatype_aflGrXf = jQuery("#jform_datatype").val();
	aflGrXf(store_aflGrXf,datatype_aflGrXf);

	var add_css_view_uvpCAcX = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	uvpCAcX(add_css_view_uvpCAcX);

	var add_css_views_xVHdqKC = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	xVHdqKC(add_css_views_xVHdqKC);

	var add_javascript_view_footer_erGiOwz = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	erGiOwz(add_javascript_view_footer_erGiOwz);

	var add_javascript_views_footer_HEJchnf = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	HEJchnf(add_javascript_views_footer_HEJchnf);
});

// the WRLqLte function
function WRLqLte(datalenght_WRLqLte)
{
	if (isSet(datalenght_WRLqLte) && datalenght_WRLqLte.constructor !== Array)
	{
		var temp_WRLqLte = datalenght_WRLqLte;
		var datalenght_WRLqLte = [];
		datalenght_WRLqLte.push(temp_WRLqLte);
	}
	else if (!isSet(datalenght_WRLqLte))
	{
		var datalenght_WRLqLte = [];
	}
	var datalenght = datalenght_WRLqLte.some(datalenght_WRLqLte_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_WRLqLteMhn_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_WRLqLteMhn_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_WRLqLteMhn_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_WRLqLteMhn_required = true;
		}
	}
}

// the WRLqLte Some function
function datalenght_WRLqLte_SomeFunc(datalenght_WRLqLte)
{
	// set the function logic
	if (datalenght_WRLqLte == 'Other')
	{
		return true;
	}
	return false;
}

// the sHxpEfi function
function sHxpEfi(datadefault_sHxpEfi)
{
	if (isSet(datadefault_sHxpEfi) && datadefault_sHxpEfi.constructor !== Array)
	{
		var temp_sHxpEfi = datadefault_sHxpEfi;
		var datadefault_sHxpEfi = [];
		datadefault_sHxpEfi.push(temp_sHxpEfi);
	}
	else if (!isSet(datadefault_sHxpEfi))
	{
		var datadefault_sHxpEfi = [];
	}
	var datadefault = datadefault_sHxpEfi.some(datadefault_sHxpEfi_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_sHxpEfigHv_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_sHxpEfigHv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_sHxpEfigHv_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_sHxpEfigHv_required = true;
		}
	}
}

// the sHxpEfi Some function
function datadefault_sHxpEfi_SomeFunc(datadefault_sHxpEfi)
{
	// set the function logic
	if (datadefault_sHxpEfi == 'Other')
	{
		return true;
	}
	return false;
}

// the MkhkJDy function
function MkhkJDy(datatype_MkhkJDy)
{
	if (isSet(datatype_MkhkJDy) && datatype_MkhkJDy.constructor !== Array)
	{
		var temp_MkhkJDy = datatype_MkhkJDy;
		var datatype_MkhkJDy = [];
		datatype_MkhkJDy.push(temp_MkhkJDy);
	}
	else if (!isSet(datatype_MkhkJDy))
	{
		var datatype_MkhkJDy = [];
	}
	var datatype = datatype_MkhkJDy.some(datatype_MkhkJDy_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_MkhkJDyCir_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_MkhkJDyCir_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_MkhkJDyCir_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_MkhkJDyCir_required = true;
		}
	}
}

// the MkhkJDy Some function
function datatype_MkhkJDy_SomeFunc(datatype_MkhkJDy)
{
	// set the function logic
	if (datatype_MkhkJDy == 'CHAR' || datatype_MkhkJDy == 'VARCHAR' || datatype_MkhkJDy == 'TEXT' || datatype_MkhkJDy == 'MEDIUMTEXT' || datatype_MkhkJDy == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the aflGrXf function
function aflGrXf(store_aflGrXf,datatype_aflGrXf)
{
	if (isSet(store_aflGrXf) && store_aflGrXf.constructor !== Array)
	{
		var temp_aflGrXf = store_aflGrXf;
		var store_aflGrXf = [];
		store_aflGrXf.push(temp_aflGrXf);
	}
	else if (!isSet(store_aflGrXf))
	{
		var store_aflGrXf = [];
	}
	var store = store_aflGrXf.some(store_aflGrXf_SomeFunc);

	if (isSet(datatype_aflGrXf) && datatype_aflGrXf.constructor !== Array)
	{
		var temp_aflGrXf = datatype_aflGrXf;
		var datatype_aflGrXf = [];
		datatype_aflGrXf.push(temp_aflGrXf);
	}
	else if (!isSet(datatype_aflGrXf))
	{
		var datatype_aflGrXf = [];
	}
	var datatype = datatype_aflGrXf.some(datatype_aflGrXf_SomeFunc);


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

// the aflGrXf Some function
function store_aflGrXf_SomeFunc(store_aflGrXf)
{
	// set the function logic
	if (store_aflGrXf == 4)
	{
		return true;
	}
	return false;
}

// the aflGrXf Some function
function datatype_aflGrXf_SomeFunc(datatype_aflGrXf)
{
	// set the function logic
	if (datatype_aflGrXf == 'CHAR' || datatype_aflGrXf == 'VARCHAR' || datatype_aflGrXf == 'TEXT' || datatype_aflGrXf == 'MEDIUMTEXT' || datatype_aflGrXf == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the uvpCAcX function
function uvpCAcX(add_css_view_uvpCAcX)
{
	// set the function logic
	if (add_css_view_uvpCAcX == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_uvpCAcXsrf_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_uvpCAcXsrf_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_uvpCAcXsrf_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_uvpCAcXsrf_required = true;
		}
	}
}

// the xVHdqKC function
function xVHdqKC(add_css_views_xVHdqKC)
{
	// set the function logic
	if (add_css_views_xVHdqKC == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_xVHdqKCxVJ_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_xVHdqKCxVJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_xVHdqKCxVJ_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_xVHdqKCxVJ_required = true;
		}
	}
}

// the erGiOwz function
function erGiOwz(add_javascript_view_footer_erGiOwz)
{
	// set the function logic
	if (add_javascript_view_footer_erGiOwz == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_erGiOwzvnp_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_erGiOwzvnp_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_erGiOwzvnp_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_erGiOwzvnp_required = true;
		}
	}
}

// the HEJchnf function
function HEJchnf(add_javascript_views_footer_HEJchnf)
{
	// set the function logic
	if (add_javascript_views_footer_HEJchnf == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_HEJchnffCw_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_HEJchnffCw_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_HEJchnffCw_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_HEJchnffCw_required = true;
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
