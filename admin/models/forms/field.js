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
jform_vvvvvyrvyn_required = false;
jform_vvvvvysvyo_required = false;
jform_vvvvvytvyp_required = false;
jform_vvvvvywvyq_required = false;
jform_vvvvvyxvyr_required = false;
jform_vvvvvyyvys_required = false;
jform_vvvvvyzvyt_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvyr = jQuery("#jform_datalenght").val();
	vvvvvyr(datalenght_vvvvvyr);

	var datadefault_vvvvvys = jQuery("#jform_datadefault").val();
	vvvvvys(datadefault_vvvvvys);

	var datatype_vvvvvyt = jQuery("#jform_datatype").val();
	vvvvvyt(datatype_vvvvvyt);

	var store_vvvvvyu = jQuery("#jform_store").val();
	var datatype_vvvvvyu = jQuery("#jform_datatype").val();
	vvvvvyu(store_vvvvvyu,datatype_vvvvvyu);

	var add_css_view_vvvvvyw = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvyw(add_css_view_vvvvvyw);

	var add_css_views_vvvvvyx = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvyx(add_css_views_vvvvvyx);

	var add_javascript_view_footer_vvvvvyy = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvyy(add_javascript_view_footer_vvvvvyy);

	var add_javascript_views_footer_vvvvvyz = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvyz(add_javascript_views_footer_vvvvvyz);
});

// the vvvvvyr function
function vvvvvyr(datalenght_vvvvvyr)
{
	if (isSet(datalenght_vvvvvyr) && datalenght_vvvvvyr.constructor !== Array)
	{
		var temp_vvvvvyr = datalenght_vvvvvyr;
		var datalenght_vvvvvyr = [];
		datalenght_vvvvvyr.push(temp_vvvvvyr);
	}
	else if (!isSet(datalenght_vvvvvyr))
	{
		var datalenght_vvvvvyr = [];
	}
	var datalenght = datalenght_vvvvvyr.some(datalenght_vvvvvyr_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvyrvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvyrvyn_required = true;
		}
	}
}

// the vvvvvyr Some function
function datalenght_vvvvvyr_SomeFunc(datalenght_vvvvvyr)
{
	// set the function logic
	if (datalenght_vvvvvyr == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvys function
function vvvvvys(datadefault_vvvvvys)
{
	if (isSet(datadefault_vvvvvys) && datadefault_vvvvvys.constructor !== Array)
	{
		var temp_vvvvvys = datadefault_vvvvvys;
		var datadefault_vvvvvys = [];
		datadefault_vvvvvys.push(temp_vvvvvys);
	}
	else if (!isSet(datadefault_vvvvvys))
	{
		var datadefault_vvvvvys = [];
	}
	var datadefault = datadefault_vvvvvys.some(datadefault_vvvvvys_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvysvyo_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvysvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvysvyo_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvysvyo_required = true;
		}
	}
}

// the vvvvvys Some function
function datadefault_vvvvvys_SomeFunc(datadefault_vvvvvys)
{
	// set the function logic
	if (datadefault_vvvvvys == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyt function
function vvvvvyt(datatype_vvvvvyt)
{
	if (isSet(datatype_vvvvvyt) && datatype_vvvvvyt.constructor !== Array)
	{
		var temp_vvvvvyt = datatype_vvvvvyt;
		var datatype_vvvvvyt = [];
		datatype_vvvvvyt.push(temp_vvvvvyt);
	}
	else if (!isSet(datatype_vvvvvyt))
	{
		var datatype_vvvvvyt = [];
	}
	var datatype = datatype_vvvvvyt.some(datatype_vvvvvyt_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvytvyp_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvytvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvytvyp_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvytvyp_required = true;
		}
	}
}

// the vvvvvyt Some function
function datatype_vvvvvyt_SomeFunc(datatype_vvvvvyt)
{
	// set the function logic
	if (datatype_vvvvvyt == 'CHAR' || datatype_vvvvvyt == 'VARCHAR' || datatype_vvvvvyt == 'TEXT' || datatype_vvvvvyt == 'MEDIUMTEXT' || datatype_vvvvvyt == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvyu function
function vvvvvyu(store_vvvvvyu,datatype_vvvvvyu)
{
	if (isSet(store_vvvvvyu) && store_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = store_vvvvvyu;
		var store_vvvvvyu = [];
		store_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(store_vvvvvyu))
	{
		var store_vvvvvyu = [];
	}
	var store = store_vvvvvyu.some(store_vvvvvyu_SomeFunc);

	if (isSet(datatype_vvvvvyu) && datatype_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = datatype_vvvvvyu;
		var datatype_vvvvvyu = [];
		datatype_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(datatype_vvvvvyu))
	{
		var datatype_vvvvvyu = [];
	}
	var datatype = datatype_vvvvvyu.some(datatype_vvvvvyu_SomeFunc);


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

// the vvvvvyu Some function
function store_vvvvvyu_SomeFunc(store_vvvvvyu)
{
	// set the function logic
	if (store_vvvvvyu == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyu Some function
function datatype_vvvvvyu_SomeFunc(datatype_vvvvvyu)
{
	// set the function logic
	if (datatype_vvvvvyu == 'CHAR' || datatype_vvvvvyu == 'VARCHAR' || datatype_vvvvvyu == 'TEXT' || datatype_vvvvvyu == 'MEDIUMTEXT' || datatype_vvvvvyu == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvyw function
function vvvvvyw(add_css_view_vvvvvyw)
{
	// set the function logic
	if (add_css_view_vvvvvyw == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvywvyq_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvywvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvywvyq_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvywvyq_required = true;
		}
	}
}

// the vvvvvyx function
function vvvvvyx(add_css_views_vvvvvyx)
{
	// set the function logic
	if (add_css_views_vvvvvyx == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvyxvyr_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvyxvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvyxvyr_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvyxvyr_required = true;
		}
	}
}

// the vvvvvyy function
function vvvvvyy(add_javascript_view_footer_vvvvvyy)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvyy == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvyyvys_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvyyvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvyyvys_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvyyvys_required = true;
		}
	}
}

// the vvvvvyz function
function vvvvvyz(add_javascript_views_footer_vvvvvyz)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvyz == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvyzvyt_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvyzvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvyzvyt_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvyzvyt_required = true;
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
