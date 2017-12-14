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
jform_vvvvwaevzq_required = false;
jform_vvvvwafvzr_required = false;
jform_vvvvwagvzs_required = false;
jform_vvvvwahvzt_required = false;
jform_vvvvwakvzu_required = false;
jform_vvvvwalvzv_required = false;
jform_vvvvwamvzw_required = false;
jform_vvvvwanvzx_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwae = jQuery("#jform_datalenght").val();
	vvvvwae(datalenght_vvvvwae);

	var datadefault_vvvvwaf = jQuery("#jform_datadefault").val();
	vvvvwaf(datadefault_vvvvwaf);

	var datatype_vvvvwag = jQuery("#jform_datatype").val();
	vvvvwag(datatype_vvvvwag);

	var datatype_vvvvwah = jQuery("#jform_datatype").val();
	vvvvwah(datatype_vvvvwah);

	var store_vvvvwai = jQuery("#jform_store").val();
	var datatype_vvvvwai = jQuery("#jform_datatype").val();
	vvvvwai(store_vvvvwai,datatype_vvvvwai);

	var add_css_view_vvvvwak = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwak(add_css_view_vvvvwak);

	var add_css_views_vvvvwal = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwal(add_css_views_vvvvwal);

	var add_javascript_view_footer_vvvvwam = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwam(add_javascript_view_footer_vvvvwam);

	var add_javascript_views_footer_vvvvwan = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwan(add_javascript_views_footer_vvvvwan);
});

// the vvvvwae function
function vvvvwae(datalenght_vvvvwae)
{
	if (isSet(datalenght_vvvvwae) && datalenght_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = datalenght_vvvvwae;
		var datalenght_vvvvwae = [];
		datalenght_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(datalenght_vvvvwae))
	{
		var datalenght_vvvvwae = [];
	}
	var datalenght = datalenght_vvvvwae.some(datalenght_vvvvwae_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwaevzq_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwaevzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwaevzq_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwaevzq_required = true;
		}
	}
}

// the vvvvwae Some function
function datalenght_vvvvwae_SomeFunc(datalenght_vvvvwae)
{
	// set the function logic
	if (datalenght_vvvvwae == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwaf function
function vvvvwaf(datadefault_vvvvwaf)
{
	if (isSet(datadefault_vvvvwaf) && datadefault_vvvvwaf.constructor !== Array)
	{
		var temp_vvvvwaf = datadefault_vvvvwaf;
		var datadefault_vvvvwaf = [];
		datadefault_vvvvwaf.push(temp_vvvvwaf);
	}
	else if (!isSet(datadefault_vvvvwaf))
	{
		var datadefault_vvvvwaf = [];
	}
	var datadefault = datadefault_vvvvwaf.some(datadefault_vvvvwaf_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwafvzr_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwafvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwafvzr_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwafvzr_required = true;
		}
	}
}

// the vvvvwaf Some function
function datadefault_vvvvwaf_SomeFunc(datadefault_vvvvwaf)
{
	// set the function logic
	if (datadefault_vvvvwaf == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwag function
function vvvvwag(datatype_vvvvwag)
{
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
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwagvzs_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwagvzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwagvzs_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwagvzs_required = true;
		}
	}
}

// the vvvvwag Some function
function datatype_vvvvwag_SomeFunc(datatype_vvvvwag)
{
	// set the function logic
	if (datatype_vvvvwag == 'CHAR' || datatype_vvvvwag == 'VARCHAR' || datatype_vvvvwag == 'DATETIME' || datatype_vvvvwag == 'DATE' || datatype_vvvvwag == 'TIME' || datatype_vvvvwag == 'INT' || datatype_vvvvwag == 'TINYINT' || datatype_vvvvwag == 'BIGINT' || datatype_vvvvwag == 'FLOAT' || datatype_vvvvwag == 'DECIMAL' || datatype_vvvvwag == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwah function
function vvvvwah(datatype_vvvvwah)
{
	if (isSet(datatype_vvvvwah) && datatype_vvvvwah.constructor !== Array)
	{
		var temp_vvvvwah = datatype_vvvvwah;
		var datatype_vvvvwah = [];
		datatype_vvvvwah.push(temp_vvvvwah);
	}
	else if (!isSet(datatype_vvvvwah))
	{
		var datatype_vvvvwah = [];
	}
	var datatype = datatype_vvvvwah.some(datatype_vvvvwah_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwahvzt_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwahvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwahvzt_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwahvzt_required = true;
		}
	}
}

// the vvvvwah Some function
function datatype_vvvvwah_SomeFunc(datatype_vvvvwah)
{
	// set the function logic
	if (datatype_vvvvwah == 'CHAR' || datatype_vvvvwah == 'VARCHAR' || datatype_vvvvwah == 'TEXT' || datatype_vvvvwah == 'MEDIUMTEXT' || datatype_vvvvwah == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwai function
function vvvvwai(store_vvvvwai,datatype_vvvvwai)
{
	if (isSet(store_vvvvwai) && store_vvvvwai.constructor !== Array)
	{
		var temp_vvvvwai = store_vvvvwai;
		var store_vvvvwai = [];
		store_vvvvwai.push(temp_vvvvwai);
	}
	else if (!isSet(store_vvvvwai))
	{
		var store_vvvvwai = [];
	}
	var store = store_vvvvwai.some(store_vvvvwai_SomeFunc);

	if (isSet(datatype_vvvvwai) && datatype_vvvvwai.constructor !== Array)
	{
		var temp_vvvvwai = datatype_vvvvwai;
		var datatype_vvvvwai = [];
		datatype_vvvvwai.push(temp_vvvvwai);
	}
	else if (!isSet(datatype_vvvvwai))
	{
		var datatype_vvvvwai = [];
	}
	var datatype = datatype_vvvvwai.some(datatype_vvvvwai_SomeFunc);


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

// the vvvvwai Some function
function store_vvvvwai_SomeFunc(store_vvvvwai)
{
	// set the function logic
	if (store_vvvvwai == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwai Some function
function datatype_vvvvwai_SomeFunc(datatype_vvvvwai)
{
	// set the function logic
	if (datatype_vvvvwai == 'CHAR' || datatype_vvvvwai == 'VARCHAR' || datatype_vvvvwai == 'TEXT' || datatype_vvvvwai == 'MEDIUMTEXT' || datatype_vvvvwai == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwak function
function vvvvwak(add_css_view_vvvvwak)
{
	// set the function logic
	if (add_css_view_vvvvwak == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwakvzu_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwakvzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwakvzu_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwakvzu_required = true;
		}
	}
}

// the vvvvwal function
function vvvvwal(add_css_views_vvvvwal)
{
	// set the function logic
	if (add_css_views_vvvvwal == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwalvzv_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwalvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwalvzv_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwalvzv_required = true;
		}
	}
}

// the vvvvwam function
function vvvvwam(add_javascript_view_footer_vvvvwam)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwam == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwamvzw_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwamvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwamvzw_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwamvzw_required = true;
		}
	}
}

// the vvvvwan function
function vvvvwan(add_javascript_views_footer_vvvvwan)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwan == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwanvzx_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwanvzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwanvzx_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwanvzx_required = true;
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
