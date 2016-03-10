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

	@version		2.1.2
	@build			10th March, 2016
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
jform_vvvvvytvyn_required = false;
jform_vvvvvyuvyo_required = false;
jform_vvvvvyvvyp_required = false;
jform_vvvvvyyvyq_required = false;
jform_vvvvvyzvyr_required = false;
jform_vvvvvzavys_required = false;
jform_vvvvvzbvyt_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvyt = jQuery("#jform_datalenght").val();
	vvvvvyt(datalenght_vvvvvyt);

	var datadefault_vvvvvyu = jQuery("#jform_datadefault").val();
	vvvvvyu(datadefault_vvvvvyu);

	var datatype_vvvvvyv = jQuery("#jform_datatype").val();
	vvvvvyv(datatype_vvvvvyv);

	var store_vvvvvyw = jQuery("#jform_store").val();
	var datatype_vvvvvyw = jQuery("#jform_datatype").val();
	vvvvvyw(store_vvvvvyw,datatype_vvvvvyw);

	var add_css_view_vvvvvyy = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvyy(add_css_view_vvvvvyy);

	var add_css_views_vvvvvyz = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvyz(add_css_views_vvvvvyz);

	var add_javascript_view_footer_vvvvvza = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvza(add_javascript_view_footer_vvvvvza);

	var add_javascript_views_footer_vvvvvzb = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzb(add_javascript_views_footer_vvvvvzb);
});

// the vvvvvyt function
function vvvvvyt(datalenght_vvvvvyt)
{
	if (isSet(datalenght_vvvvvyt) && datalenght_vvvvvyt.constructor !== Array)
	{
		var temp_vvvvvyt = datalenght_vvvvvyt;
		var datalenght_vvvvvyt = [];
		datalenght_vvvvvyt.push(temp_vvvvvyt);
	}
	else if (!isSet(datalenght_vvvvvyt))
	{
		var datalenght_vvvvvyt = [];
	}
	var datalenght = datalenght_vvvvvyt.some(datalenght_vvvvvyt_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvytvyn_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvytvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvytvyn_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvytvyn_required = true;
		}
	}
}

// the vvvvvyt Some function
function datalenght_vvvvvyt_SomeFunc(datalenght_vvvvvyt)
{
	// set the function logic
	if (datalenght_vvvvvyt == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyu function
function vvvvvyu(datadefault_vvvvvyu)
{
	if (isSet(datadefault_vvvvvyu) && datadefault_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = datadefault_vvvvvyu;
		var datadefault_vvvvvyu = [];
		datadefault_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(datadefault_vvvvvyu))
	{
		var datadefault_vvvvvyu = [];
	}
	var datadefault = datadefault_vvvvvyu.some(datadefault_vvvvvyu_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvyuvyo_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvyuvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvyuvyo_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvyuvyo_required = true;
		}
	}
}

// the vvvvvyu Some function
function datadefault_vvvvvyu_SomeFunc(datadefault_vvvvvyu)
{
	// set the function logic
	if (datadefault_vvvvvyu == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyv function
function vvvvvyv(datatype_vvvvvyv)
{
	if (isSet(datatype_vvvvvyv) && datatype_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = datatype_vvvvvyv;
		var datatype_vvvvvyv = [];
		datatype_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(datatype_vvvvvyv))
	{
		var datatype_vvvvvyv = [];
	}
	var datatype = datatype_vvvvvyv.some(datatype_vvvvvyv_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvyvvyp_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvyvvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvyvvyp_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvyvvyp_required = true;
		}
	}
}

// the vvvvvyv Some function
function datatype_vvvvvyv_SomeFunc(datatype_vvvvvyv)
{
	// set the function logic
	if (datatype_vvvvvyv == 'CHAR' || datatype_vvvvvyv == 'VARCHAR' || datatype_vvvvvyv == 'TEXT' || datatype_vvvvvyv == 'MEDIUMTEXT' || datatype_vvvvvyv == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvyw function
function vvvvvyw(store_vvvvvyw,datatype_vvvvvyw)
{
	if (isSet(store_vvvvvyw) && store_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = store_vvvvvyw;
		var store_vvvvvyw = [];
		store_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(store_vvvvvyw))
	{
		var store_vvvvvyw = [];
	}
	var store = store_vvvvvyw.some(store_vvvvvyw_SomeFunc);

	if (isSet(datatype_vvvvvyw) && datatype_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = datatype_vvvvvyw;
		var datatype_vvvvvyw = [];
		datatype_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(datatype_vvvvvyw))
	{
		var datatype_vvvvvyw = [];
	}
	var datatype = datatype_vvvvvyw.some(datatype_vvvvvyw_SomeFunc);


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

// the vvvvvyw Some function
function store_vvvvvyw_SomeFunc(store_vvvvvyw)
{
	// set the function logic
	if (store_vvvvvyw == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyw Some function
function datatype_vvvvvyw_SomeFunc(datatype_vvvvvyw)
{
	// set the function logic
	if (datatype_vvvvvyw == 'CHAR' || datatype_vvvvvyw == 'VARCHAR' || datatype_vvvvvyw == 'TEXT' || datatype_vvvvvyw == 'MEDIUMTEXT' || datatype_vvvvvyw == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvyy function
function vvvvvyy(add_css_view_vvvvvyy)
{
	// set the function logic
	if (add_css_view_vvvvvyy == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvyyvyq_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvyyvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvyyvyq_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvyyvyq_required = true;
		}
	}
}

// the vvvvvyz function
function vvvvvyz(add_css_views_vvvvvyz)
{
	// set the function logic
	if (add_css_views_vvvvvyz == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvyzvyr_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvyzvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvyzvyr_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvyzvyr_required = true;
		}
	}
}

// the vvvvvza function
function vvvvvza(add_javascript_view_footer_vvvvvza)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvza == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzavys_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzavys_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzavys_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzavys_required = true;
		}
	}
}

// the vvvvvzb function
function vvvvvzb(add_javascript_views_footer_vvvvvzb)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzb == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzbvyt_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzbvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzbvyt_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzbvyt_required = true;
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
