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
jform_vvvvwajvzv_required = false;
jform_vvvvwakvzw_required = false;
jform_vvvvwalvzx_required = false;
jform_vvvvwamvzy_required = false;
jform_vvvvwapvzz_required = false;
jform_vvvvwaqwaa_required = false;
jform_vvvvwarwab_required = false;
jform_vvvvwaswac_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwaj = jQuery("#jform_datalenght").val();
	vvvvwaj(datalenght_vvvvwaj);

	var datadefault_vvvvwak = jQuery("#jform_datadefault").val();
	vvvvwak(datadefault_vvvvwak);

	var datatype_vvvvwal = jQuery("#jform_datatype").val();
	vvvvwal(datatype_vvvvwal);

	var datatype_vvvvwam = jQuery("#jform_datatype").val();
	vvvvwam(datatype_vvvvwam);

	var store_vvvvwan = jQuery("#jform_store").val();
	var datatype_vvvvwan = jQuery("#jform_datatype").val();
	vvvvwan(store_vvvvwan,datatype_vvvvwan);

	var add_css_view_vvvvwap = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwap(add_css_view_vvvvwap);

	var add_css_views_vvvvwaq = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwaq(add_css_views_vvvvwaq);

	var add_javascript_view_footer_vvvvwar = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwar(add_javascript_view_footer_vvvvwar);

	var add_javascript_views_footer_vvvvwas = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwas(add_javascript_views_footer_vvvvwas);
});

// the vvvvwaj function
function vvvvwaj(datalenght_vvvvwaj)
{
	if (isSet(datalenght_vvvvwaj) && datalenght_vvvvwaj.constructor !== Array)
	{
		var temp_vvvvwaj = datalenght_vvvvwaj;
		var datalenght_vvvvwaj = [];
		datalenght_vvvvwaj.push(temp_vvvvwaj);
	}
	else if (!isSet(datalenght_vvvvwaj))
	{
		var datalenght_vvvvwaj = [];
	}
	var datalenght = datalenght_vvvvwaj.some(datalenght_vvvvwaj_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvwajvzv_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwajvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvwajvzv_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwajvzv_required = true;
		}
	}
}

// the vvvvwaj Some function
function datalenght_vvvvwaj_SomeFunc(datalenght_vvvvwaj)
{
	// set the function logic
	if (datalenght_vvvvwaj == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwak function
function vvvvwak(datadefault_vvvvwak)
{
	if (isSet(datadefault_vvvvwak) && datadefault_vvvvwak.constructor !== Array)
	{
		var temp_vvvvwak = datadefault_vvvvwak;
		var datadefault_vvvvwak = [];
		datadefault_vvvvwak.push(temp_vvvvwak);
	}
	else if (!isSet(datadefault_vvvvwak))
	{
		var datadefault_vvvvwak = [];
	}
	var datadefault = datadefault_vvvvwak.some(datadefault_vvvvwak_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvwakvzw_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwakvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvwakvzw_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwakvzw_required = true;
		}
	}
}

// the vvvvwak Some function
function datadefault_vvvvwak_SomeFunc(datadefault_vvvvwak)
{
	// set the function logic
	if (datadefault_vvvvwak == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwal function
function vvvvwal(datatype_vvvvwal)
{
	if (isSet(datatype_vvvvwal) && datatype_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = datatype_vvvvwal;
		var datatype_vvvvwal = [];
		datatype_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(datatype_vvvvwal))
	{
		var datatype_vvvvwal = [];
	}
	var datatype = datatype_vvvvwal.some(datatype_vvvvwal_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvwalvzx_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwalvzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvwalvzx_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwalvzx_required = true;
		}
	}
}

// the vvvvwal Some function
function datatype_vvvvwal_SomeFunc(datatype_vvvvwal)
{
	// set the function logic
	if (datatype_vvvvwal == 'CHAR' || datatype_vvvvwal == 'VARCHAR' || datatype_vvvvwal == 'DATETIME' || datatype_vvvvwal == 'DATE' || datatype_vvvvwal == 'TIME' || datatype_vvvvwal == 'INT' || datatype_vvvvwal == 'TINYINT' || datatype_vvvvwal == 'BIGINT' || datatype_vvvvwal == 'FLOAT' || datatype_vvvvwal == 'DECIMAL' || datatype_vvvvwal == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwam function
function vvvvwam(datatype_vvvvwam)
{
	if (isSet(datatype_vvvvwam) && datatype_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = datatype_vvvvwam;
		var datatype_vvvvwam = [];
		datatype_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(datatype_vvvvwam))
	{
		var datatype_vvvvwam = [];
	}
	var datatype = datatype_vvvvwam.some(datatype_vvvvwam_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvwamvzy_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwamvzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvwamvzy_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwamvzy_required = true;
		}
	}
}

// the vvvvwam Some function
function datatype_vvvvwam_SomeFunc(datatype_vvvvwam)
{
	// set the function logic
	if (datatype_vvvvwam == 'CHAR' || datatype_vvvvwam == 'VARCHAR' || datatype_vvvvwam == 'TEXT' || datatype_vvvvwam == 'MEDIUMTEXT' || datatype_vvvvwam == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwan function
function vvvvwan(store_vvvvwan,datatype_vvvvwan)
{
	if (isSet(store_vvvvwan) && store_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = store_vvvvwan;
		var store_vvvvwan = [];
		store_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(store_vvvvwan))
	{
		var store_vvvvwan = [];
	}
	var store = store_vvvvwan.some(store_vvvvwan_SomeFunc);

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
	if (store && datatype)
	{
		jQuery('.note_vdm_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_vdm_encryption').closest('.control-group').hide();
	}
}

// the vvvvwan Some function
function store_vvvvwan_SomeFunc(store_vvvvwan)
{
	// set the function logic
	if (store_vvvvwan == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwan Some function
function datatype_vvvvwan_SomeFunc(datatype_vvvvwan)
{
	// set the function logic
	if (datatype_vvvvwan == 'CHAR' || datatype_vvvvwan == 'VARCHAR' || datatype_vvvvwan == 'TEXT' || datatype_vvvvwan == 'MEDIUMTEXT' || datatype_vvvvwan == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(add_css_view_vvvvwap)
{
	// set the function logic
	if (add_css_view_vvvvwap == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwapvzz_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwapvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwapvzz_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwapvzz_required = true;
		}
	}
}

// the vvvvwaq function
function vvvvwaq(add_css_views_vvvvwaq)
{
	// set the function logic
	if (add_css_views_vvvvwaq == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwaqwaa_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwaqwaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwaqwaa_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwaqwaa_required = true;
		}
	}
}

// the vvvvwar function
function vvvvwar(add_javascript_view_footer_vvvvwar)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwar == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwarwab_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwarwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwarwab_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwarwab_required = true;
		}
	}
}

// the vvvvwas function
function vvvvwas(add_javascript_views_footer_vvvvwas)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwas == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwaswac_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwaswac_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwaswac_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwaswac_required = true;
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
