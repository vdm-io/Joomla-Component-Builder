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

	@version		@update number 40 of this MVC
	@build			25th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzuvzo_required = false;
jform_vvvvvzvvzp_required = false;
jform_vvvvvzwvzq_required = false;
jform_vvvvvzxvzr_required = false;
jform_vvvvwaavzs_required = false;
jform_vvvvwabvzt_required = false;
jform_vvvvwacvzu_required = false;
jform_vvvvwadvzv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvzu = jQuery("#jform_datalenght").val();
	vvvvvzu(datalenght_vvvvvzu);

	var datadefault_vvvvvzv = jQuery("#jform_datadefault").val();
	vvvvvzv(datadefault_vvvvvzv);

	var datatype_vvvvvzw = jQuery("#jform_datatype").val();
	vvvvvzw(datatype_vvvvvzw);

	var datatype_vvvvvzx = jQuery("#jform_datatype").val();
	vvvvvzx(datatype_vvvvvzx);

	var store_vvvvvzy = jQuery("#jform_store").val();
	var datatype_vvvvvzy = jQuery("#jform_datatype").val();
	vvvvvzy(store_vvvvvzy,datatype_vvvvvzy);

	var add_css_view_vvvvwaa = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwaa(add_css_view_vvvvwaa);

	var add_css_views_vvvvwab = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwab(add_css_views_vvvvwab);

	var add_javascript_view_footer_vvvvwac = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwac(add_javascript_view_footer_vvvvwac);

	var add_javascript_views_footer_vvvvwad = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwad(add_javascript_views_footer_vvvvwad);
});

// the vvvvvzu function
function vvvvvzu(datalenght_vvvvvzu)
{
	if (isSet(datalenght_vvvvvzu) && datalenght_vvvvvzu.constructor !== Array)
	{
		var temp_vvvvvzu = datalenght_vvvvvzu;
		var datalenght_vvvvvzu = [];
		datalenght_vvvvvzu.push(temp_vvvvvzu);
	}
	else if (!isSet(datalenght_vvvvvzu))
	{
		var datalenght_vvvvvzu = [];
	}
	var datalenght = datalenght_vvvvvzu.some(datalenght_vvvvvzu_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvzuvzo_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvzuvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvzuvzo_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvzuvzo_required = true;
		}
	}
}

// the vvvvvzu Some function
function datalenght_vvvvvzu_SomeFunc(datalenght_vvvvvzu)
{
	// set the function logic
	if (datalenght_vvvvvzu == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzv function
function vvvvvzv(datadefault_vvvvvzv)
{
	if (isSet(datadefault_vvvvvzv) && datadefault_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = datadefault_vvvvvzv;
		var datadefault_vvvvvzv = [];
		datadefault_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(datadefault_vvvvvzv))
	{
		var datadefault_vvvvvzv = [];
	}
	var datadefault = datadefault_vvvvvzv.some(datadefault_vvvvvzv_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvzvvzp_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvzvvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvzvvzp_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvzvvzp_required = true;
		}
	}
}

// the vvvvvzv Some function
function datadefault_vvvvvzv_SomeFunc(datadefault_vvvvvzv)
{
	// set the function logic
	if (datadefault_vvvvvzv == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzw function
function vvvvvzw(datatype_vvvvvzw)
{
	if (isSet(datatype_vvvvvzw) && datatype_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = datatype_vvvvvzw;
		var datatype_vvvvvzw = [];
		datatype_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(datatype_vvvvvzw))
	{
		var datatype_vvvvvzw = [];
	}
	var datatype = datatype_vvvvvzw.some(datatype_vvvvvzw_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzwvzq_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzwvzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzwvzq_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzwvzq_required = true;
		}
	}
}

// the vvvvvzw Some function
function datatype_vvvvvzw_SomeFunc(datatype_vvvvvzw)
{
	// set the function logic
	if (datatype_vvvvvzw == 'CHAR' || datatype_vvvvvzw == 'VARCHAR' || datatype_vvvvvzw == 'DATETIME' || datatype_vvvvvzw == 'DATE' || datatype_vvvvvzw == 'TIME' || datatype_vvvvvzw == 'INT' || datatype_vvvvvzw == 'TINYINT' || datatype_vvvvvzw == 'BIGINT' || datatype_vvvvvzw == 'FLOAT' || datatype_vvvvvzw == 'DECIMAL' || datatype_vvvvvzw == 'DOUBLE')
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
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzxvzr_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzxvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzxvzr_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzxvzr_required = true;
		}
	}
}

// the vvvvvzx Some function
function datatype_vvvvvzx_SomeFunc(datatype_vvvvvzx)
{
	// set the function logic
	if (datatype_vvvvvzx == 'CHAR' || datatype_vvvvvzx == 'VARCHAR' || datatype_vvvvvzx == 'TEXT' || datatype_vvvvvzx == 'MEDIUMTEXT' || datatype_vvvvvzx == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzy function
function vvvvvzy(store_vvvvvzy,datatype_vvvvvzy)
{
	if (isSet(store_vvvvvzy) && store_vvvvvzy.constructor !== Array)
	{
		var temp_vvvvvzy = store_vvvvvzy;
		var store_vvvvvzy = [];
		store_vvvvvzy.push(temp_vvvvvzy);
	}
	else if (!isSet(store_vvvvvzy))
	{
		var store_vvvvvzy = [];
	}
	var store = store_vvvvvzy.some(store_vvvvvzy_SomeFunc);

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
	if (store && datatype)
	{
		jQuery('.note_vdm_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_vdm_encryption').closest('.control-group').hide();
	}
}

// the vvvvvzy Some function
function store_vvvvvzy_SomeFunc(store_vvvvvzy)
{
	// set the function logic
	if (store_vvvvvzy == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwaa function
function vvvvwaa(add_css_view_vvvvwaa)
{
	// set the function logic
	if (add_css_view_vvvvwaa == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvwaavzs_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvwaavzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvwaavzs_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvwaavzs_required = true;
		}
	}
}

// the vvvvwab function
function vvvvwab(add_css_views_vvvvwab)
{
	// set the function logic
	if (add_css_views_vvvvwab == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvwabvzt_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvwabvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvwabvzt_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvwabvzt_required = true;
		}
	}
}

// the vvvvwac function
function vvvvwac(add_javascript_view_footer_vvvvwac)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwac == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwacvzu_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwacvzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwacvzu_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwacvzu_required = true;
		}
	}
}

// the vvvvwad function
function vvvvwad(add_javascript_views_footer_vvvvwad)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwad == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwadvzv_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwadvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwadvzv_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwadvzv_required = true;
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
