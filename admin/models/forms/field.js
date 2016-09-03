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

	@version		2.1.18
	@build			3rd September, 2016
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
jform_vvvvvyxvyu_required = false;
jform_vvvvvyyvyv_required = false;
jform_vvvvvyzvyw_required = false;
jform_vvvvvzavyx_required = false;
jform_vvvvvzdvyy_required = false;
jform_vvvvvzevyz_required = false;
jform_vvvvvzfvza_required = false;
jform_vvvvvzgvzb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvyx = jQuery("#jform_datalenght").val();
	vvvvvyx(datalenght_vvvvvyx);

	var datadefault_vvvvvyy = jQuery("#jform_datadefault").val();
	vvvvvyy(datadefault_vvvvvyy);

	var datatype_vvvvvyz = jQuery("#jform_datatype").val();
	vvvvvyz(datatype_vvvvvyz);

	var datatype_vvvvvza = jQuery("#jform_datatype").val();
	vvvvvza(datatype_vvvvvza);

	var store_vvvvvzb = jQuery("#jform_store").val();
	var datatype_vvvvvzb = jQuery("#jform_datatype").val();
	vvvvvzb(store_vvvvvzb,datatype_vvvvvzb);

	var add_css_view_vvvvvzd = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzd(add_css_view_vvvvvzd);

	var add_css_views_vvvvvze = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvze(add_css_views_vvvvvze);

	var add_javascript_view_footer_vvvvvzf = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzf(add_javascript_view_footer_vvvvvzf);

	var add_javascript_views_footer_vvvvvzg = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzg(add_javascript_views_footer_vvvvvzg);
});

// the vvvvvyx function
function vvvvvyx(datalenght_vvvvvyx)
{
	if (isSet(datalenght_vvvvvyx) && datalenght_vvvvvyx.constructor !== Array)
	{
		var temp_vvvvvyx = datalenght_vvvvvyx;
		var datalenght_vvvvvyx = [];
		datalenght_vvvvvyx.push(temp_vvvvvyx);
	}
	else if (!isSet(datalenght_vvvvvyx))
	{
		var datalenght_vvvvvyx = [];
	}
	var datalenght = datalenght_vvvvvyx.some(datalenght_vvvvvyx_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvyxvyu_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvyxvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvyxvyu_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvyxvyu_required = true;
		}
	}
}

// the vvvvvyx Some function
function datalenght_vvvvvyx_SomeFunc(datalenght_vvvvvyx)
{
	// set the function logic
	if (datalenght_vvvvvyx == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyy function
function vvvvvyy(datadefault_vvvvvyy)
{
	if (isSet(datadefault_vvvvvyy) && datadefault_vvvvvyy.constructor !== Array)
	{
		var temp_vvvvvyy = datadefault_vvvvvyy;
		var datadefault_vvvvvyy = [];
		datadefault_vvvvvyy.push(temp_vvvvvyy);
	}
	else if (!isSet(datadefault_vvvvvyy))
	{
		var datadefault_vvvvvyy = [];
	}
	var datadefault = datadefault_vvvvvyy.some(datadefault_vvvvvyy_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvyyvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvyyvyv_required = true;
		}
	}
}

// the vvvvvyy Some function
function datadefault_vvvvvyy_SomeFunc(datadefault_vvvvvyy)
{
	// set the function logic
	if (datadefault_vvvvvyy == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyz function
function vvvvvyz(datatype_vvvvvyz)
{
	if (isSet(datatype_vvvvvyz) && datatype_vvvvvyz.constructor !== Array)
	{
		var temp_vvvvvyz = datatype_vvvvvyz;
		var datatype_vvvvvyz = [];
		datatype_vvvvvyz.push(temp_vvvvvyz);
	}
	else if (!isSet(datatype_vvvvvyz))
	{
		var datatype_vvvvvyz = [];
	}
	var datatype = datatype_vvvvvyz.some(datatype_vvvvvyz_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvyzvyw_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvyzvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvyzvyw_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvyzvyw_required = true;
		}
	}
}

// the vvvvvyz Some function
function datatype_vvvvvyz_SomeFunc(datatype_vvvvvyz)
{
	// set the function logic
	if (datatype_vvvvvyz == 'CHAR' || datatype_vvvvvyz == 'VARCHAR' || datatype_vvvvvyz == 'DATETIME' || datatype_vvvvvyz == 'DATE' || datatype_vvvvvyz == 'TIME' || datatype_vvvvvyz == 'INT' || datatype_vvvvvyz == 'TINYINT' || datatype_vvvvvyz == 'BIGINT' || datatype_vvvvvyz == 'FLOAT' || datatype_vvvvvyz == 'DECIMAL' || datatype_vvvvvyz == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvvza function
function vvvvvza(datatype_vvvvvza)
{
	if (isSet(datatype_vvvvvza) && datatype_vvvvvza.constructor !== Array)
	{
		var temp_vvvvvza = datatype_vvvvvza;
		var datatype_vvvvvza = [];
		datatype_vvvvvza.push(temp_vvvvvza);
	}
	else if (!isSet(datatype_vvvvvza))
	{
		var datatype_vvvvvza = [];
	}
	var datatype = datatype_vvvvvza.some(datatype_vvvvvza_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzavyx_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzavyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzavyx_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzavyx_required = true;
		}
	}
}

// the vvvvvza Some function
function datatype_vvvvvza_SomeFunc(datatype_vvvvvza)
{
	// set the function logic
	if (datatype_vvvvvza == 'CHAR' || datatype_vvvvvza == 'VARCHAR' || datatype_vvvvvza == 'TEXT' || datatype_vvvvvza == 'MEDIUMTEXT' || datatype_vvvvvza == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzb function
function vvvvvzb(store_vvvvvzb,datatype_vvvvvzb)
{
	if (isSet(store_vvvvvzb) && store_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = store_vvvvvzb;
		var store_vvvvvzb = [];
		store_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(store_vvvvvzb))
	{
		var store_vvvvvzb = [];
	}
	var store = store_vvvvvzb.some(store_vvvvvzb_SomeFunc);

	if (isSet(datatype_vvvvvzb) && datatype_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = datatype_vvvvvzb;
		var datatype_vvvvvzb = [];
		datatype_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(datatype_vvvvvzb))
	{
		var datatype_vvvvvzb = [];
	}
	var datatype = datatype_vvvvvzb.some(datatype_vvvvvzb_SomeFunc);


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

// the vvvvvzb Some function
function store_vvvvvzb_SomeFunc(store_vvvvvzb)
{
	// set the function logic
	if (store_vvvvvzb == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzb Some function
function datatype_vvvvvzb_SomeFunc(datatype_vvvvvzb)
{
	// set the function logic
	if (datatype_vvvvvzb == 'CHAR' || datatype_vvvvvzb == 'VARCHAR' || datatype_vvvvvzb == 'TEXT' || datatype_vvvvvzb == 'MEDIUMTEXT' || datatype_vvvvvzb == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(add_css_view_vvvvvzd)
{
	// set the function logic
	if (add_css_view_vvvvvzd == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvzdvyy_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvzdvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvzdvyy_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvzdvyy_required = true;
		}
	}
}

// the vvvvvze function
function vvvvvze(add_css_views_vvvvvze)
{
	// set the function logic
	if (add_css_views_vvvvvze == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzevyz_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzevyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzevyz_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzevyz_required = true;
		}
	}
}

// the vvvvvzf function
function vvvvvzf(add_javascript_view_footer_vvvvvzf)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzf == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzfvza_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzfvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzfvza_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzfvza_required = true;
		}
	}
}

// the vvvvvzg function
function vvvvvzg(add_javascript_views_footer_vvvvvzg)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzg == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzgvzb_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzgvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzgvzb_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzgvzb_required = true;
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
