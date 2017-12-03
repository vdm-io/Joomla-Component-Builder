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
jform_vvvvwabvzp_required = false;
jform_vvvvwacvzq_required = false;
jform_vvvvwadvzr_required = false;
jform_vvvvwaevzs_required = false;
jform_vvvvwahvzt_required = false;
jform_vvvvwaivzu_required = false;
jform_vvvvwajvzv_required = false;
jform_vvvvwakvzw_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwab = jQuery("#jform_datalenght").val();
	vvvvwab(datalenght_vvvvwab);

	var datadefault_vvvvwac = jQuery("#jform_datadefault").val();
	vvvvwac(datadefault_vvvvwac);

	var datatype_vvvvwad = jQuery("#jform_datatype").val();
	vvvvwad(datatype_vvvvwad);

	var datatype_vvvvwae = jQuery("#jform_datatype").val();
	vvvvwae(datatype_vvvvwae);

	var store_vvvvwaf = jQuery("#jform_store").val();
	var datatype_vvvvwaf = jQuery("#jform_datatype").val();
	vvvvwaf(store_vvvvwaf,datatype_vvvvwaf);

	var add_css_view_vvvvwah = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwah(add_css_view_vvvvwah);

	var add_css_views_vvvvwai = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwai(add_css_views_vvvvwai);

	var add_javascript_view_footer_vvvvwaj = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwaj(add_javascript_view_footer_vvvvwaj);

	var add_javascript_views_footer_vvvvwak = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwak(add_javascript_views_footer_vvvvwak);
});

// the vvvvwab function
function vvvvwab(datalenght_vvvvwab)
{
	if (isSet(datalenght_vvvvwab) && datalenght_vvvvwab.constructor !== Array)
	{
		var temp_vvvvwab = datalenght_vvvvwab;
		var datalenght_vvvvwab = [];
		datalenght_vvvvwab.push(temp_vvvvwab);
	}
	else if (!isSet(datalenght_vvvvwab))
	{
		var datalenght_vvvvwab = [];
	}
	var datalenght = datalenght_vvvvwab.some(datalenght_vvvvwab_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwabvzp_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwabvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwabvzp_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwabvzp_required = true;
		}
	}
}

// the vvvvwab Some function
function datalenght_vvvvwab_SomeFunc(datalenght_vvvvwab)
{
	// set the function logic
	if (datalenght_vvvvwab == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwac function
function vvvvwac(datadefault_vvvvwac)
{
	if (isSet(datadefault_vvvvwac) && datadefault_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = datadefault_vvvvwac;
		var datadefault_vvvvwac = [];
		datadefault_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(datadefault_vvvvwac))
	{
		var datadefault_vvvvwac = [];
	}
	var datadefault = datadefault_vvvvwac.some(datadefault_vvvvwac_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwacvzq_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwacvzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwacvzq_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwacvzq_required = true;
		}
	}
}

// the vvvvwac Some function
function datadefault_vvvvwac_SomeFunc(datadefault_vvvvwac)
{
	// set the function logic
	if (datadefault_vvvvwac == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwad function
function vvvvwad(datatype_vvvvwad)
{
	if (isSet(datatype_vvvvwad) && datatype_vvvvwad.constructor !== Array)
	{
		var temp_vvvvwad = datatype_vvvvwad;
		var datatype_vvvvwad = [];
		datatype_vvvvwad.push(temp_vvvvwad);
	}
	else if (!isSet(datatype_vvvvwad))
	{
		var datatype_vvvvwad = [];
	}
	var datatype = datatype_vvvvwad.some(datatype_vvvvwad_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwadvzr_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwadvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwadvzr_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwadvzr_required = true;
		}
	}
}

// the vvvvwad Some function
function datatype_vvvvwad_SomeFunc(datatype_vvvvwad)
{
	// set the function logic
	if (datatype_vvvvwad == 'CHAR' || datatype_vvvvwad == 'VARCHAR' || datatype_vvvvwad == 'DATETIME' || datatype_vvvvwad == 'DATE' || datatype_vvvvwad == 'TIME' || datatype_vvvvwad == 'INT' || datatype_vvvvwad == 'TINYINT' || datatype_vvvvwad == 'BIGINT' || datatype_vvvvwad == 'FLOAT' || datatype_vvvvwad == 'DECIMAL' || datatype_vvvvwad == 'DOUBLE')
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
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwaevzs_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwaevzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwaevzs_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwaevzs_required = true;
		}
	}
}

// the vvvvwae Some function
function datatype_vvvvwae_SomeFunc(datatype_vvvvwae)
{
	// set the function logic
	if (datatype_vvvvwae == 'CHAR' || datatype_vvvvwae == 'VARCHAR' || datatype_vvvvwae == 'TEXT' || datatype_vvvvwae == 'MEDIUMTEXT' || datatype_vvvvwae == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwaf function
function vvvvwaf(store_vvvvwaf,datatype_vvvvwaf)
{
	if (isSet(store_vvvvwaf) && store_vvvvwaf.constructor !== Array)
	{
		var temp_vvvvwaf = store_vvvvwaf;
		var store_vvvvwaf = [];
		store_vvvvwaf.push(temp_vvvvwaf);
	}
	else if (!isSet(store_vvvvwaf))
	{
		var store_vvvvwaf = [];
	}
	var store = store_vvvvwaf.some(store_vvvvwaf_SomeFunc);

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
	if (store && datatype)
	{
		jQuery('.note_vdm_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_vdm_encryption').closest('.control-group').hide();
	}
}

// the vvvvwaf Some function
function store_vvvvwaf_SomeFunc(store_vvvvwaf)
{
	// set the function logic
	if (store_vvvvwaf == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwah function
function vvvvwah(add_css_view_vvvvwah)
{
	// set the function logic
	if (add_css_view_vvvvwah == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwahvzt_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwahvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwahvzt_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwahvzt_required = true;
		}
	}
}

// the vvvvwai function
function vvvvwai(add_css_views_vvvvwai)
{
	// set the function logic
	if (add_css_views_vvvvwai == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwaivzu_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwaivzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwaivzu_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwaivzu_required = true;
		}
	}
}

// the vvvvwaj function
function vvvvwaj(add_javascript_view_footer_vvvvwaj)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwaj == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwajvzv_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwajvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwajvzv_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwajvzv_required = true;
		}
	}
}

// the vvvvwak function
function vvvvwak(add_javascript_views_footer_vvvvwak)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwak == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwakvzw_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwakvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwakvzw_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwakvzw_required = true;
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
