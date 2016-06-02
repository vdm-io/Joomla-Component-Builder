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

	@version		2.1.11
	@build			2nd June, 2016
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
jform_vvvvvywvyt_required = false;
jform_vvvvvyxvyu_required = false;
jform_vvvvvyyvyv_required = false;
jform_vvvvvzbvyw_required = false;
jform_vvvvvzcvyx_required = false;
jform_vvvvvzdvyy_required = false;
jform_vvvvvzevyz_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvyw = jQuery("#jform_datalenght").val();
	vvvvvyw(datalenght_vvvvvyw);

	var datadefault_vvvvvyx = jQuery("#jform_datadefault").val();
	vvvvvyx(datadefault_vvvvvyx);

	var datatype_vvvvvyy = jQuery("#jform_datatype").val();
	vvvvvyy(datatype_vvvvvyy);

	var store_vvvvvyz = jQuery("#jform_store").val();
	var datatype_vvvvvyz = jQuery("#jform_datatype").val();
	vvvvvyz(store_vvvvvyz,datatype_vvvvvyz);

	var add_css_view_vvvvvzb = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzb(add_css_view_vvvvvzb);

	var add_css_views_vvvvvzc = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvzc(add_css_views_vvvvvzc);

	var add_javascript_view_footer_vvvvvzd = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzd(add_javascript_view_footer_vvvvvzd);

	var add_javascript_views_footer_vvvvvze = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvze(add_javascript_views_footer_vvvvvze);
});

// the vvvvvyw function
function vvvvvyw(datalenght_vvvvvyw)
{
	if (isSet(datalenght_vvvvvyw) && datalenght_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = datalenght_vvvvvyw;
		var datalenght_vvvvvyw = [];
		datalenght_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(datalenght_vvvvvyw))
	{
		var datalenght_vvvvvyw = [];
	}
	var datalenght = datalenght_vvvvvyw.some(datalenght_vvvvvyw_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvywvyt_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvywvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvywvyt_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvywvyt_required = true;
		}
	}
}

// the vvvvvyw Some function
function datalenght_vvvvvyw_SomeFunc(datalenght_vvvvvyw)
{
	// set the function logic
	if (datalenght_vvvvvyw == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyx function
function vvvvvyx(datadefault_vvvvvyx)
{
	if (isSet(datadefault_vvvvvyx) && datadefault_vvvvvyx.constructor !== Array)
	{
		var temp_vvvvvyx = datadefault_vvvvvyx;
		var datadefault_vvvvvyx = [];
		datadefault_vvvvvyx.push(temp_vvvvvyx);
	}
	else if (!isSet(datadefault_vvvvvyx))
	{
		var datadefault_vvvvvyx = [];
	}
	var datadefault = datadefault_vvvvvyx.some(datadefault_vvvvvyx_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvyxvyu_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvyxvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvyxvyu_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvyxvyu_required = true;
		}
	}
}

// the vvvvvyx Some function
function datadefault_vvvvvyx_SomeFunc(datadefault_vvvvvyx)
{
	// set the function logic
	if (datadefault_vvvvvyx == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyy function
function vvvvvyy(datatype_vvvvvyy)
{
	if (isSet(datatype_vvvvvyy) && datatype_vvvvvyy.constructor !== Array)
	{
		var temp_vvvvvyy = datatype_vvvvvyy;
		var datatype_vvvvvyy = [];
		datatype_vvvvvyy.push(temp_vvvvvyy);
	}
	else if (!isSet(datatype_vvvvvyy))
	{
		var datatype_vvvvvyy = [];
	}
	var datatype = datatype_vvvvvyy.some(datatype_vvvvvyy_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvyyvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvyyvyv_required = true;
		}
	}
}

// the vvvvvyy Some function
function datatype_vvvvvyy_SomeFunc(datatype_vvvvvyy)
{
	// set the function logic
	if (datatype_vvvvvyy == 'CHAR' || datatype_vvvvvyy == 'VARCHAR' || datatype_vvvvvyy == 'TEXT' || datatype_vvvvvyy == 'MEDIUMTEXT' || datatype_vvvvvyy == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvyz function
function vvvvvyz(store_vvvvvyz,datatype_vvvvvyz)
{
	if (isSet(store_vvvvvyz) && store_vvvvvyz.constructor !== Array)
	{
		var temp_vvvvvyz = store_vvvvvyz;
		var store_vvvvvyz = [];
		store_vvvvvyz.push(temp_vvvvvyz);
	}
	else if (!isSet(store_vvvvvyz))
	{
		var store_vvvvvyz = [];
	}
	var store = store_vvvvvyz.some(store_vvvvvyz_SomeFunc);

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
	if (store && datatype)
	{
		jQuery('.note_vdm_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_vdm_encryption').closest('.control-group').hide();
	}
}

// the vvvvvyz Some function
function store_vvvvvyz_SomeFunc(store_vvvvvyz)
{
	// set the function logic
	if (store_vvvvvyz == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyz Some function
function datatype_vvvvvyz_SomeFunc(datatype_vvvvvyz)
{
	// set the function logic
	if (datatype_vvvvvyz == 'CHAR' || datatype_vvvvvyz == 'VARCHAR' || datatype_vvvvvyz == 'TEXT' || datatype_vvvvvyz == 'MEDIUMTEXT' || datatype_vvvvvyz == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzb function
function vvvvvzb(add_css_view_vvvvvzb)
{
	// set the function logic
	if (add_css_view_vvvvvzb == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvzbvyw_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvzbvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvzbvyw_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvzbvyw_required = true;
		}
	}
}

// the vvvvvzc function
function vvvvvzc(add_css_views_vvvvvzc)
{
	// set the function logic
	if (add_css_views_vvvvvzc == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzcvyx_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzcvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzcvyx_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzcvyx_required = true;
		}
	}
}

// the vvvvvzd function
function vvvvvzd(add_javascript_view_footer_vvvvvzd)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzd == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzdvyy_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzdvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzdvyy_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzdvyy_required = true;
		}
	}
}

// the vvvvvze function
function vvvvvze(add_javascript_views_footer_vvvvvze)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvze == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzevyz_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzevyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzevyz_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzevyz_required = true;
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
