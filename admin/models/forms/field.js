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

	@version		@update number 38 of this MVC
	@build			28th May, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzvvzt_required = false;
jform_vvvvvzwvzu_required = false;
jform_vvvvvzxvzv_required = false;
jform_vvvvvzyvzw_required = false;
jform_vvvvwabvzx_required = false;
jform_vvvvwacvzy_required = false;
jform_vvvvwadvzz_required = false;
jform_vvvvwaewaa_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvzv = jQuery("#jform_datalenght").val();
	vvvvvzv(datalenght_vvvvvzv);

	var datadefault_vvvvvzw = jQuery("#jform_datadefault").val();
	vvvvvzw(datadefault_vvvvvzw);

	var datatype_vvvvvzx = jQuery("#jform_datatype").val();
	vvvvvzx(datatype_vvvvvzx);

	var datatype_vvvvvzy = jQuery("#jform_datatype").val();
	vvvvvzy(datatype_vvvvvzy);

	var store_vvvvvzz = jQuery("#jform_store").val();
	var datatype_vvvvvzz = jQuery("#jform_datatype").val();
	vvvvvzz(store_vvvvvzz,datatype_vvvvvzz);

	var add_css_view_vvvvwab = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwab(add_css_view_vvvvwab);

	var add_css_views_vvvvwac = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwac(add_css_views_vvvvwac);

	var add_javascript_view_footer_vvvvwad = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwad(add_javascript_view_footer_vvvvwad);

	var add_javascript_views_footer_vvvvwae = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwae(add_javascript_views_footer_vvvvwae);
});

// the vvvvvzv function
function vvvvvzv(datalenght_vvvvvzv)
{
	if (isSet(datalenght_vvvvvzv) && datalenght_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = datalenght_vvvvvzv;
		var datalenght_vvvvvzv = [];
		datalenght_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(datalenght_vvvvvzv))
	{
		var datalenght_vvvvvzv = [];
	}
	var datalenght = datalenght_vvvvvzv.some(datalenght_vvvvvzv_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvzvvzt_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvzvvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvzvvzt_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvzvvzt_required = true;
		}
	}
}

// the vvvvvzv Some function
function datalenght_vvvvvzv_SomeFunc(datalenght_vvvvvzv)
{
	// set the function logic
	if (datalenght_vvvvvzv == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzw function
function vvvvvzw(datadefault_vvvvvzw)
{
	if (isSet(datadefault_vvvvvzw) && datadefault_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = datadefault_vvvvvzw;
		var datadefault_vvvvvzw = [];
		datadefault_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(datadefault_vvvvvzw))
	{
		var datadefault_vvvvvzw = [];
	}
	var datadefault = datadefault_vvvvvzw.some(datadefault_vvvvvzw_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvzwvzu_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvzwvzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvzwvzu_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvzwvzu_required = true;
		}
	}
}

// the vvvvvzw Some function
function datadefault_vvvvvzw_SomeFunc(datadefault_vvvvvzw)
{
	// set the function logic
	if (datadefault_vvvvvzw == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzx function
function vvvvvzx(datatype_vvvvvzx)
{
	if (isSet(datatype_vvvvvzx) && datatype_vvvvvzx.constructor !== Array)
	{
		var temp_vvvvvzx = datatype_vvvvvzx;
		var datatype_vvvvvzx = [];
		datatype_vvvvvzx.push(temp_vvvvvzx);
	}
	else if (!isSet(datatype_vvvvvzx))
	{
		var datatype_vvvvvzx = [];
	}
	var datatype = datatype_vvvvvzx.some(datatype_vvvvvzx_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzxvzv_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzxvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzxvzv_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzxvzv_required = true;
		}
	}
}

// the vvvvvzx Some function
function datatype_vvvvvzx_SomeFunc(datatype_vvvvvzx)
{
	// set the function logic
	if (datatype_vvvvvzx == 'CHAR' || datatype_vvvvvzx == 'VARCHAR' || datatype_vvvvvzx == 'DATETIME' || datatype_vvvvvzx == 'DATE' || datatype_vvvvvzx == 'TIME' || datatype_vvvvvzx == 'INT' || datatype_vvvvvzx == 'TINYINT' || datatype_vvvvvzx == 'BIGINT' || datatype_vvvvvzx == 'FLOAT' || datatype_vvvvvzx == 'DECIMAL' || datatype_vvvvvzx == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvvzy function
function vvvvvzy(datatype_vvvvvzy)
{
	if (isSet(datatype_vvvvvzy) && datatype_vvvvvzy.constructor !== Array)
	{
		var temp_vvvvvzy = datatype_vvvvvzy;
		var datatype_vvvvvzy = [];
		datatype_vvvvvzy.push(temp_vvvvvzy);
	}
	else if (!isSet(datatype_vvvvvzy))
	{
		var datatype_vvvvvzy = [];
	}
	var datatype = datatype_vvvvvzy.some(datatype_vvvvvzy_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzyvzw_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzyvzw_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzyvzw_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzyvzw_required = true;
		}
	}
}

// the vvvvvzy Some function
function datatype_vvvvvzy_SomeFunc(datatype_vvvvvzy)
{
	// set the function logic
	if (datatype_vvvvvzy == 'CHAR' || datatype_vvvvvzy == 'VARCHAR' || datatype_vvvvvzy == 'TEXT' || datatype_vvvvvzy == 'MEDIUMTEXT' || datatype_vvvvvzy == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzz function
function vvvvvzz(store_vvvvvzz,datatype_vvvvvzz)
{
	if (isSet(store_vvvvvzz) && store_vvvvvzz.constructor !== Array)
	{
		var temp_vvvvvzz = store_vvvvvzz;
		var store_vvvvvzz = [];
		store_vvvvvzz.push(temp_vvvvvzz);
	}
	else if (!isSet(store_vvvvvzz))
	{
		var store_vvvvvzz = [];
	}
	var store = store_vvvvvzz.some(store_vvvvvzz_SomeFunc);

	if (isSet(datatype_vvvvvzz) && datatype_vvvvvzz.constructor !== Array)
	{
		var temp_vvvvvzz = datatype_vvvvvzz;
		var datatype_vvvvvzz = [];
		datatype_vvvvvzz.push(temp_vvvvvzz);
	}
	else if (!isSet(datatype_vvvvvzz))
	{
		var datatype_vvvvvzz = [];
	}
	var datatype = datatype_vvvvvzz.some(datatype_vvvvvzz_SomeFunc);


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

// the vvvvvzz Some function
function store_vvvvvzz_SomeFunc(store_vvvvvzz)
{
	// set the function logic
	if (store_vvvvvzz == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzz Some function
function datatype_vvvvvzz_SomeFunc(datatype_vvvvvzz)
{
	// set the function logic
	if (datatype_vvvvvzz == 'CHAR' || datatype_vvvvvzz == 'VARCHAR' || datatype_vvvvvzz == 'TEXT' || datatype_vvvvvzz == 'MEDIUMTEXT' || datatype_vvvvvzz == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvwab function
function vvvvwab(add_css_view_vvvvwab)
{
	// set the function logic
	if (add_css_view_vvvvwab == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwabvzx_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwabvzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwabvzx_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwabvzx_required = true;
		}
	}
}

// the vvvvwac function
function vvvvwac(add_css_views_vvvvwac)
{
	// set the function logic
	if (add_css_views_vvvvwac == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwacvzy_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwacvzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwacvzy_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwacvzy_required = true;
		}
	}
}

// the vvvvwad function
function vvvvwad(add_javascript_view_footer_vvvvwad)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwad == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwadvzz_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwadvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwadvzz_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwadvzz_required = true;
		}
	}
}

// the vvvvwae function
function vvvvwae(add_javascript_views_footer_vvvvwae)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwae == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwaewaa_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwaewaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwaewaa_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwaewaa_required = true;
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
