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
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwagvzs_required = false;
jform_vvvvwahvzt_required = false;
jform_vvvvwaivzu_required = false;
jform_vvvvwajvzv_required = false;
jform_vvvvwamvzw_required = false;
jform_vvvvwanvzx_required = false;
jform_vvvvwaovzy_required = false;
jform_vvvvwapvzz_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwag = jQuery("#jform_datalenght").val();
	vvvvwag(datalenght_vvvvwag);

	var datadefault_vvvvwah = jQuery("#jform_datadefault").val();
	vvvvwah(datadefault_vvvvwah);

	var datatype_vvvvwai = jQuery("#jform_datatype").val();
	vvvvwai(datatype_vvvvwai);

	var datatype_vvvvwaj = jQuery("#jform_datatype").val();
	vvvvwaj(datatype_vvvvwaj);

	var store_vvvvwak = jQuery("#jform_store").val();
	var datatype_vvvvwak = jQuery("#jform_datatype").val();
	vvvvwak(store_vvvvwak,datatype_vvvvwak);

	var add_css_view_vvvvwam = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwam(add_css_view_vvvvwam);

	var add_css_views_vvvvwan = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwan(add_css_views_vvvvwan);

	var add_javascript_view_footer_vvvvwao = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwao(add_javascript_view_footer_vvvvwao);

	var add_javascript_views_footer_vvvvwap = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwap(add_javascript_views_footer_vvvvwap);
});

// the vvvvwag function
function vvvvwag(datalenght_vvvvwag)
{
	if (isSet(datalenght_vvvvwag) && datalenght_vvvvwag.constructor !== Array)
	{
		var temp_vvvvwag = datalenght_vvvvwag;
		var datalenght_vvvvwag = [];
		datalenght_vvvvwag.push(temp_vvvvwag);
	}
	else if (!isSet(datalenght_vvvvwag))
	{
		var datalenght_vvvvwag = [];
	}
	var datalenght = datalenght_vvvvwag.some(datalenght_vvvvwag_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwagvzs_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwagvzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwagvzs_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwagvzs_required = true;
		}
	}
}

// the vvvvwag Some function
function datalenght_vvvvwag_SomeFunc(datalenght_vvvvwag)
{
	// set the function logic
	if (datalenght_vvvvwag == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwah function
function vvvvwah(datadefault_vvvvwah)
{
	if (isSet(datadefault_vvvvwah) && datadefault_vvvvwah.constructor !== Array)
	{
		var temp_vvvvwah = datadefault_vvvvwah;
		var datadefault_vvvvwah = [];
		datadefault_vvvvwah.push(temp_vvvvwah);
	}
	else if (!isSet(datadefault_vvvvwah))
	{
		var datadefault_vvvvwah = [];
	}
	var datadefault = datadefault_vvvvwah.some(datadefault_vvvvwah_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwahvzt_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwahvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwahvzt_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwahvzt_required = true;
		}
	}
}

// the vvvvwah Some function
function datadefault_vvvvwah_SomeFunc(datadefault_vvvvwah)
{
	// set the function logic
	if (datadefault_vvvvwah == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwai function
function vvvvwai(datatype_vvvvwai)
{
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
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwaivzu_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwaivzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwaivzu_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwaivzu_required = true;
		}
	}
}

// the vvvvwai Some function
function datatype_vvvvwai_SomeFunc(datatype_vvvvwai)
{
	// set the function logic
	if (datatype_vvvvwai == 'CHAR' || datatype_vvvvwai == 'VARCHAR' || datatype_vvvvwai == 'DATETIME' || datatype_vvvvwai == 'DATE' || datatype_vvvvwai == 'TIME' || datatype_vvvvwai == 'INT' || datatype_vvvvwai == 'TINYINT' || datatype_vvvvwai == 'BIGINT' || datatype_vvvvwai == 'FLOAT' || datatype_vvvvwai == 'DECIMAL' || datatype_vvvvwai == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwaj function
function vvvvwaj(datatype_vvvvwaj)
{
	if (isSet(datatype_vvvvwaj) && datatype_vvvvwaj.constructor !== Array)
	{
		var temp_vvvvwaj = datatype_vvvvwaj;
		var datatype_vvvvwaj = [];
		datatype_vvvvwaj.push(temp_vvvvwaj);
	}
	else if (!isSet(datatype_vvvvwaj))
	{
		var datatype_vvvvwaj = [];
	}
	var datatype = datatype_vvvvwaj.some(datatype_vvvvwaj_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwajvzv_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwajvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwajvzv_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwajvzv_required = true;
		}
	}
}

// the vvvvwaj Some function
function datatype_vvvvwaj_SomeFunc(datatype_vvvvwaj)
{
	// set the function logic
	if (datatype_vvvvwaj == 'CHAR' || datatype_vvvvwaj == 'VARCHAR' || datatype_vvvvwaj == 'TEXT' || datatype_vvvvwaj == 'MEDIUMTEXT' || datatype_vvvvwaj == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwak function
function vvvvwak(store_vvvvwak,datatype_vvvvwak)
{
	if (isSet(store_vvvvwak) && store_vvvvwak.constructor !== Array)
	{
		var temp_vvvvwak = store_vvvvwak;
		var store_vvvvwak = [];
		store_vvvvwak.push(temp_vvvvwak);
	}
	else if (!isSet(store_vvvvwak))
	{
		var store_vvvvwak = [];
	}
	var store = store_vvvvwak.some(store_vvvvwak_SomeFunc);

	if (isSet(datatype_vvvvwak) && datatype_vvvvwak.constructor !== Array)
	{
		var temp_vvvvwak = datatype_vvvvwak;
		var datatype_vvvvwak = [];
		datatype_vvvvwak.push(temp_vvvvwak);
	}
	else if (!isSet(datatype_vvvvwak))
	{
		var datatype_vvvvwak = [];
	}
	var datatype = datatype_vvvvwak.some(datatype_vvvvwak_SomeFunc);


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

// the vvvvwak Some function
function store_vvvvwak_SomeFunc(store_vvvvwak)
{
	// set the function logic
	if (store_vvvvwak == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwak Some function
function datatype_vvvvwak_SomeFunc(datatype_vvvvwak)
{
	// set the function logic
	if (datatype_vvvvwak == 'CHAR' || datatype_vvvvwak == 'VARCHAR' || datatype_vvvvwak == 'TEXT' || datatype_vvvvwak == 'MEDIUMTEXT' || datatype_vvvvwak == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwam function
function vvvvwam(add_css_view_vvvvwam)
{
	// set the function logic
	if (add_css_view_vvvvwam == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwamvzw_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwamvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwamvzw_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwamvzw_required = true;
		}
	}
}

// the vvvvwan function
function vvvvwan(add_css_views_vvvvwan)
{
	// set the function logic
	if (add_css_views_vvvvwan == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwanvzx_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwanvzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwanvzx_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwanvzx_required = true;
		}
	}
}

// the vvvvwao function
function vvvvwao(add_javascript_view_footer_vvvvwao)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwao == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwaovzy_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwaovzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwaovzy_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwaovzy_required = true;
		}
	}
}

// the vvvvwap function
function vvvvwap(add_javascript_views_footer_vvvvwap)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwap == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwapvzz_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwapvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwapvzz_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwapvzz_required = true;
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

jQuery(document).ready(function()
{
	// get the linked details
	getLinked();
});
			
function getLinked_server(type){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&vdm="+vastDevMod;
	if(token.length > 0 && type > 0){
		var request = 'token='+token+'&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
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
