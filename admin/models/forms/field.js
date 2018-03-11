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
jform_vvvvwalvzv_required = false;
jform_vvvvwamvzw_required = false;
jform_vvvvwanvzx_required = false;
jform_vvvvwaovzy_required = false;
jform_vvvvwarvzz_required = false;
jform_vvvvwaswaa_required = false;
jform_vvvvwatwab_required = false;
jform_vvvvwauwac_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwal = jQuery("#jform_datalenght").val();
	vvvvwal(datalenght_vvvvwal);

	var datadefault_vvvvwam = jQuery("#jform_datadefault").val();
	vvvvwam(datadefault_vvvvwam);

	var datatype_vvvvwan = jQuery("#jform_datatype").val();
	vvvvwan(datatype_vvvvwan);

	var datatype_vvvvwao = jQuery("#jform_datatype").val();
	vvvvwao(datatype_vvvvwao);

	var store_vvvvwap = jQuery("#jform_store").val();
	var datatype_vvvvwap = jQuery("#jform_datatype").val();
	vvvvwap(store_vvvvwap,datatype_vvvvwap);

	var add_css_view_vvvvwar = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwar(add_css_view_vvvvwar);

	var add_css_views_vvvvwas = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwas(add_css_views_vvvvwas);

	var add_javascript_view_footer_vvvvwat = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwat(add_javascript_view_footer_vvvvwat);

	var add_javascript_views_footer_vvvvwau = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwau(add_javascript_views_footer_vvvvwau);
});

// the vvvvwal function
function vvvvwal(datalenght_vvvvwal)
{
	if (isSet(datalenght_vvvvwal) && datalenght_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = datalenght_vvvvwal;
		var datalenght_vvvvwal = [];
		datalenght_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(datalenght_vvvvwal))
	{
		var datalenght_vvvvwal = [];
	}
	var datalenght = datalenght_vvvvwal.some(datalenght_vvvvwal_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwalvzv_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwalvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwalvzv_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwalvzv_required = true;
		}
	}
}

// the vvvvwal Some function
function datalenght_vvvvwal_SomeFunc(datalenght_vvvvwal)
{
	// set the function logic
	if (datalenght_vvvvwal == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwam function
function vvvvwam(datadefault_vvvvwam)
{
	if (isSet(datadefault_vvvvwam) && datadefault_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = datadefault_vvvvwam;
		var datadefault_vvvvwam = [];
		datadefault_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(datadefault_vvvvwam))
	{
		var datadefault_vvvvwam = [];
	}
	var datadefault = datadefault_vvvvwam.some(datadefault_vvvvwam_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwamvzw_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwamvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwamvzw_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwamvzw_required = true;
		}
	}
}

// the vvvvwam Some function
function datadefault_vvvvwam_SomeFunc(datadefault_vvvvwam)
{
	// set the function logic
	if (datadefault_vvvvwam == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwan function
function vvvvwan(datatype_vvvvwan)
{
	if (isSet(datatype_vvvvwan) && datatype_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = datatype_vvvvwan;
		var datatype_vvvvwan = [];
		datatype_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(datatype_vvvvwan))
	{
		var datatype_vvvvwan = [];
	}
	var datatype = datatype_vvvvwan.some(datatype_vvvvwan_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwanvzx_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwanvzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwanvzx_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwanvzx_required = true;
		}
	}
}

// the vvvvwan Some function
function datatype_vvvvwan_SomeFunc(datatype_vvvvwan)
{
	// set the function logic
	if (datatype_vvvvwan == 'CHAR' || datatype_vvvvwan == 'VARCHAR' || datatype_vvvvwan == 'DATETIME' || datatype_vvvvwan == 'DATE' || datatype_vvvvwan == 'TIME' || datatype_vvvvwan == 'INT' || datatype_vvvvwan == 'TINYINT' || datatype_vvvvwan == 'BIGINT' || datatype_vvvvwan == 'FLOAT' || datatype_vvvvwan == 'DECIMAL' || datatype_vvvvwan == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwao function
function vvvvwao(datatype_vvvvwao)
{
	if (isSet(datatype_vvvvwao) && datatype_vvvvwao.constructor !== Array)
	{
		var temp_vvvvwao = datatype_vvvvwao;
		var datatype_vvvvwao = [];
		datatype_vvvvwao.push(temp_vvvvwao);
	}
	else if (!isSet(datatype_vvvvwao))
	{
		var datatype_vvvvwao = [];
	}
	var datatype = datatype_vvvvwao.some(datatype_vvvvwao_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwaovzy_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwaovzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwaovzy_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwaovzy_required = true;
		}
	}
}

// the vvvvwao Some function
function datatype_vvvvwao_SomeFunc(datatype_vvvvwao)
{
	// set the function logic
	if (datatype_vvvvwao == 'CHAR' || datatype_vvvvwao == 'VARCHAR' || datatype_vvvvwao == 'TEXT' || datatype_vvvvwao == 'MEDIUMTEXT' || datatype_vvvvwao == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(store_vvvvwap,datatype_vvvvwap)
{
	if (isSet(store_vvvvwap) && store_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = store_vvvvwap;
		var store_vvvvwap = [];
		store_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(store_vvvvwap))
	{
		var store_vvvvwap = [];
	}
	var store = store_vvvvwap.some(store_vvvvwap_SomeFunc);

	if (isSet(datatype_vvvvwap) && datatype_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = datatype_vvvvwap;
		var datatype_vvvvwap = [];
		datatype_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(datatype_vvvvwap))
	{
		var datatype_vvvvwap = [];
	}
	var datatype = datatype_vvvvwap.some(datatype_vvvvwap_SomeFunc);


	// set this function logic
	if (store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwap Some function
function store_vvvvwap_SomeFunc(store_vvvvwap)
{
	// set the function logic
	if (store_vvvvwap == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwap Some function
function datatype_vvvvwap_SomeFunc(datatype_vvvvwap)
{
	// set the function logic
	if (datatype_vvvvwap == 'CHAR' || datatype_vvvvwap == 'VARCHAR' || datatype_vvvvwap == 'TEXT' || datatype_vvvvwap == 'MEDIUMTEXT' || datatype_vvvvwap == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwar function
function vvvvwar(add_css_view_vvvvwar)
{
	// set the function logic
	if (add_css_view_vvvvwar == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwarvzz_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwarvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwarvzz_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwarvzz_required = true;
		}
	}
}

// the vvvvwas function
function vvvvwas(add_css_views_vvvvwas)
{
	// set the function logic
	if (add_css_views_vvvvwas == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwaswaa_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwaswaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwaswaa_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwaswaa_required = true;
		}
	}
}

// the vvvvwat function
function vvvvwat(add_javascript_view_footer_vvvvwat)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwat == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwatwab_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwatwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwatwab_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwatwab_required = true;
		}
	}
}

// the vvvvwau function
function vvvvwau(add_javascript_views_footer_vvvvwau)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwau == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwauwac_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwauwac_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwauwac_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwauwac_required = true;
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
