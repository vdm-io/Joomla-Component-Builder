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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwacvzo_required = false;
jform_vvvvwadvzp_required = false;
jform_vvvvwaevzq_required = false;
jform_vvvvwafvzr_required = false;
jform_vvvvwaivzs_required = false;
jform_vvvvwajvzt_required = false;
jform_vvvvwakvzu_required = false;
jform_vvvvwalvzv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwac = jQuery("#jform_datalenght").val();
	vvvvwac(datalenght_vvvvwac);

	var datadefault_vvvvwad = jQuery("#jform_datadefault").val();
	vvvvwad(datadefault_vvvvwad);

	var datatype_vvvvwae = jQuery("#jform_datatype").val();
	vvvvwae(datatype_vvvvwae);

	var datatype_vvvvwaf = jQuery("#jform_datatype").val();
	vvvvwaf(datatype_vvvvwaf);

	var store_vvvvwag = jQuery("#jform_store").val();
	var datatype_vvvvwag = jQuery("#jform_datatype").val();
	vvvvwag(store_vvvvwag,datatype_vvvvwag);

	var add_css_view_vvvvwai = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwai(add_css_view_vvvvwai);

	var add_css_views_vvvvwaj = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwaj(add_css_views_vvvvwaj);

	var add_javascript_view_footer_vvvvwak = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwak(add_javascript_view_footer_vvvvwak);

	var add_javascript_views_footer_vvvvwal = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwal(add_javascript_views_footer_vvvvwal);
});

// the vvvvwac function
function vvvvwac(datalenght_vvvvwac)
{
	if (isSet(datalenght_vvvvwac) && datalenght_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = datalenght_vvvvwac;
		var datalenght_vvvvwac = [];
		datalenght_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(datalenght_vvvvwac))
	{
		var datalenght_vvvvwac = [];
	}
	var datalenght = datalenght_vvvvwac.some(datalenght_vvvvwac_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwacvzo_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwacvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwacvzo_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwacvzo_required = true;
		}
	}
}

// the vvvvwac Some function
function datalenght_vvvvwac_SomeFunc(datalenght_vvvvwac)
{
	// set the function logic
	if (datalenght_vvvvwac == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwad function
function vvvvwad(datadefault_vvvvwad)
{
	if (isSet(datadefault_vvvvwad) && datadefault_vvvvwad.constructor !== Array)
	{
		var temp_vvvvwad = datadefault_vvvvwad;
		var datadefault_vvvvwad = [];
		datadefault_vvvvwad.push(temp_vvvvwad);
	}
	else if (!isSet(datadefault_vvvvwad))
	{
		var datadefault_vvvvwad = [];
	}
	var datadefault = datadefault_vvvvwad.some(datadefault_vvvvwad_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwadvzp_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwadvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwadvzp_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwadvzp_required = true;
		}
	}
}

// the vvvvwad Some function
function datadefault_vvvvwad_SomeFunc(datadefault_vvvvwad)
{
	// set the function logic
	if (datadefault_vvvvwad == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwae function
function vvvvwae(datatype_vvvvwae)
{
	if (isSet(datatype_vvvvwae) && datatype_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = datatype_vvvvwae;
		var datatype_vvvvwae = [];
		datatype_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(datatype_vvvvwae))
	{
		var datatype_vvvvwae = [];
	}
	var datatype = datatype_vvvvwae.some(datatype_vvvvwae_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwaevzq_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwaevzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwaevzq_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwaevzq_required = true;
		}
	}
}

// the vvvvwae Some function
function datatype_vvvvwae_SomeFunc(datatype_vvvvwae)
{
	// set the function logic
	if (datatype_vvvvwae == 'CHAR' || datatype_vvvvwae == 'VARCHAR' || datatype_vvvvwae == 'DATETIME' || datatype_vvvvwae == 'DATE' || datatype_vvvvwae == 'TIME' || datatype_vvvvwae == 'INT' || datatype_vvvvwae == 'TINYINT' || datatype_vvvvwae == 'BIGINT' || datatype_vvvvwae == 'FLOAT' || datatype_vvvvwae == 'DECIMAL' || datatype_vvvvwae == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwaf function
function vvvvwaf(datatype_vvvvwaf)
{
	if (isSet(datatype_vvvvwaf) && datatype_vvvvwaf.constructor !== Array)
	{
		var temp_vvvvwaf = datatype_vvvvwaf;
		var datatype_vvvvwaf = [];
		datatype_vvvvwaf.push(temp_vvvvwaf);
	}
	else if (!isSet(datatype_vvvvwaf))
	{
		var datatype_vvvvwaf = [];
	}
	var datatype = datatype_vvvvwaf.some(datatype_vvvvwaf_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwafvzr_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwafvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwafvzr_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwafvzr_required = true;
		}
	}
}

// the vvvvwaf Some function
function datatype_vvvvwaf_SomeFunc(datatype_vvvvwaf)
{
	// set the function logic
	if (datatype_vvvvwaf == 'CHAR' || datatype_vvvvwaf == 'VARCHAR' || datatype_vvvvwaf == 'TEXT' || datatype_vvvvwaf == 'MEDIUMTEXT' || datatype_vvvvwaf == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwag function
function vvvvwag(store_vvvvwag,datatype_vvvvwag)
{
	if (isSet(store_vvvvwag) && store_vvvvwag.constructor !== Array)
	{
		var temp_vvvvwag = store_vvvvwag;
		var store_vvvvwag = [];
		store_vvvvwag.push(temp_vvvvwag);
	}
	else if (!isSet(store_vvvvwag))
	{
		var store_vvvvwag = [];
	}
	var store = store_vvvvwag.some(store_vvvvwag_SomeFunc);

	if (isSet(datatype_vvvvwag) && datatype_vvvvwag.constructor !== Array)
	{
		var temp_vvvvwag = datatype_vvvvwag;
		var datatype_vvvvwag = [];
		datatype_vvvvwag.push(temp_vvvvwag);
	}
	else if (!isSet(datatype_vvvvwag))
	{
		var datatype_vvvvwag = [];
	}
	var datatype = datatype_vvvvwag.some(datatype_vvvvwag_SomeFunc);


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

// the vvvvwag Some function
function store_vvvvwag_SomeFunc(store_vvvvwag)
{
	// set the function logic
	if (store_vvvvwag == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwag Some function
function datatype_vvvvwag_SomeFunc(datatype_vvvvwag)
{
	// set the function logic
	if (datatype_vvvvwag == 'CHAR' || datatype_vvvvwag == 'VARCHAR' || datatype_vvvvwag == 'TEXT' || datatype_vvvvwag == 'MEDIUMTEXT' || datatype_vvvvwag == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwai function
function vvvvwai(add_css_view_vvvvwai)
{
	// set the function logic
	if (add_css_view_vvvvwai == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwaivzs_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwaivzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwaivzs_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwaivzs_required = true;
		}
	}
}

// the vvvvwaj function
function vvvvwaj(add_css_views_vvvvwaj)
{
	// set the function logic
	if (add_css_views_vvvvwaj == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwajvzt_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwajvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwajvzt_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwajvzt_required = true;
		}
	}
}

// the vvvvwak function
function vvvvwak(add_javascript_view_footer_vvvvwak)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwak == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwakvzu_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwakvzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwakvzu_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwakvzu_required = true;
		}
	}
}

// the vvvvwal function
function vvvvwal(add_javascript_views_footer_vvvvwal)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwal == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwalvzv_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwalvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwalvzv_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwalvzv_required = true;
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
