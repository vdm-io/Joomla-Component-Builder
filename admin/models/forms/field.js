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
jform_vvvvwaavzo_required = false;
jform_vvvvwabvzp_required = false;
jform_vvvvwacvzq_required = false;
jform_vvvvwadvzr_required = false;
jform_vvvvwagvzs_required = false;
jform_vvvvwahvzt_required = false;
jform_vvvvwaivzu_required = false;
jform_vvvvwajvzv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwaa = jQuery("#jform_datalenght").val();
	vvvvwaa(datalenght_vvvvwaa);

	var datadefault_vvvvwab = jQuery("#jform_datadefault").val();
	vvvvwab(datadefault_vvvvwab);

	var datatype_vvvvwac = jQuery("#jform_datatype").val();
	vvvvwac(datatype_vvvvwac);

	var datatype_vvvvwad = jQuery("#jform_datatype").val();
	vvvvwad(datatype_vvvvwad);

	var store_vvvvwae = jQuery("#jform_store").val();
	var datatype_vvvvwae = jQuery("#jform_datatype").val();
	vvvvwae(store_vvvvwae,datatype_vvvvwae);

	var add_css_view_vvvvwag = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwag(add_css_view_vvvvwag);

	var add_css_views_vvvvwah = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwah(add_css_views_vvvvwah);

	var add_javascript_view_footer_vvvvwai = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwai(add_javascript_view_footer_vvvvwai);

	var add_javascript_views_footer_vvvvwaj = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwaj(add_javascript_views_footer_vvvvwaj);
});

// the vvvvwaa function
function vvvvwaa(datalenght_vvvvwaa)
{
	if (isSet(datalenght_vvvvwaa) && datalenght_vvvvwaa.constructor !== Array)
	{
		var temp_vvvvwaa = datalenght_vvvvwaa;
		var datalenght_vvvvwaa = [];
		datalenght_vvvvwaa.push(temp_vvvvwaa);
	}
	else if (!isSet(datalenght_vvvvwaa))
	{
		var datalenght_vvvvwaa = [];
	}
	var datalenght = datalenght_vvvvwaa.some(datalenght_vvvvwaa_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwaavzo_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwaavzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwaavzo_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwaavzo_required = true;
		}
	}
}

// the vvvvwaa Some function
function datalenght_vvvvwaa_SomeFunc(datalenght_vvvvwaa)
{
	// set the function logic
	if (datalenght_vvvvwaa == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwab function
function vvvvwab(datadefault_vvvvwab)
{
	if (isSet(datadefault_vvvvwab) && datadefault_vvvvwab.constructor !== Array)
	{
		var temp_vvvvwab = datadefault_vvvvwab;
		var datadefault_vvvvwab = [];
		datadefault_vvvvwab.push(temp_vvvvwab);
	}
	else if (!isSet(datadefault_vvvvwab))
	{
		var datadefault_vvvvwab = [];
	}
	var datadefault = datadefault_vvvvwab.some(datadefault_vvvvwab_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwabvzp_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwabvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwabvzp_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwabvzp_required = true;
		}
	}
}

// the vvvvwab Some function
function datadefault_vvvvwab_SomeFunc(datadefault_vvvvwab)
{
	// set the function logic
	if (datadefault_vvvvwab == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwac function
function vvvvwac(datatype_vvvvwac)
{
	if (isSet(datatype_vvvvwac) && datatype_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = datatype_vvvvwac;
		var datatype_vvvvwac = [];
		datatype_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(datatype_vvvvwac))
	{
		var datatype_vvvvwac = [];
	}
	var datatype = datatype_vvvvwac.some(datatype_vvvvwac_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwacvzq_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwacvzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwacvzq_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwacvzq_required = true;
		}
	}
}

// the vvvvwac Some function
function datatype_vvvvwac_SomeFunc(datatype_vvvvwac)
{
	// set the function logic
	if (datatype_vvvvwac == 'CHAR' || datatype_vvvvwac == 'VARCHAR' || datatype_vvvvwac == 'DATETIME' || datatype_vvvvwac == 'DATE' || datatype_vvvvwac == 'TIME' || datatype_vvvvwac == 'INT' || datatype_vvvvwac == 'TINYINT' || datatype_vvvvwac == 'BIGINT' || datatype_vvvvwac == 'FLOAT' || datatype_vvvvwac == 'DECIMAL' || datatype_vvvvwac == 'DOUBLE')
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
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwadvzr_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwadvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwadvzr_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwadvzr_required = true;
		}
	}
}

// the vvvvwad Some function
function datatype_vvvvwad_SomeFunc(datatype_vvvvwad)
{
	// set the function logic
	if (datatype_vvvvwad == 'CHAR' || datatype_vvvvwad == 'VARCHAR' || datatype_vvvvwad == 'TEXT' || datatype_vvvvwad == 'MEDIUMTEXT' || datatype_vvvvwad == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwae function
function vvvvwae(store_vvvvwae,datatype_vvvvwae)
{
	if (isSet(store_vvvvwae) && store_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = store_vvvvwae;
		var store_vvvvwae = [];
		store_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(store_vvvvwae))
	{
		var store_vvvvwae = [];
	}
	var store = store_vvvvwae.some(store_vvvvwae_SomeFunc);

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
	if (store && datatype)
	{
		jQuery('.note_vdm_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_vdm_encryption').closest('.control-group').hide();
	}
}

// the vvvvwae Some function
function store_vvvvwae_SomeFunc(store_vvvvwae)
{
	// set the function logic
	if (store_vvvvwae == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwag function
function vvvvwag(add_css_view_vvvvwag)
{
	// set the function logic
	if (add_css_view_vvvvwag == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwagvzs_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwagvzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwagvzs_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwagvzs_required = true;
		}
	}
}

// the vvvvwah function
function vvvvwah(add_css_views_vvvvwah)
{
	// set the function logic
	if (add_css_views_vvvvwah == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwahvzt_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwahvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwahvzt_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwahvzt_required = true;
		}
	}
}

// the vvvvwai function
function vvvvwai(add_javascript_view_footer_vvvvwai)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwai == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwaivzu_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwaivzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwaivzu_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwaivzu_required = true;
		}
	}
}

// the vvvvwaj function
function vvvvwaj(add_javascript_views_footer_vvvvwaj)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwaj == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwajvzv_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwajvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwajvzv_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwajvzv_required = true;
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
