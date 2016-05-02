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

	@version		2.1.4
	@build			2nd May, 2016
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
jform_vvvvvyuvyo_required = false;
jform_vvvvvyvvyp_required = false;
jform_vvvvvywvyq_required = false;
jform_vvvvvyzvyr_required = false;
jform_vvvvvzavys_required = false;
jform_vvvvvzbvyt_required = false;
jform_vvvvvzcvyu_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvyu = jQuery("#jform_datalenght").val();
	vvvvvyu(datalenght_vvvvvyu);

	var datadefault_vvvvvyv = jQuery("#jform_datadefault").val();
	vvvvvyv(datadefault_vvvvvyv);

	var datatype_vvvvvyw = jQuery("#jform_datatype").val();
	vvvvvyw(datatype_vvvvvyw);

	var store_vvvvvyx = jQuery("#jform_store").val();
	var datatype_vvvvvyx = jQuery("#jform_datatype").val();
	vvvvvyx(store_vvvvvyx,datatype_vvvvvyx);

	var add_css_view_vvvvvyz = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvyz(add_css_view_vvvvvyz);

	var add_css_views_vvvvvza = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvza(add_css_views_vvvvvza);

	var add_javascript_view_footer_vvvvvzb = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzb(add_javascript_view_footer_vvvvvzb);

	var add_javascript_views_footer_vvvvvzc = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzc(add_javascript_views_footer_vvvvvzc);
});

// the vvvvvyu function
function vvvvvyu(datalenght_vvvvvyu)
{
	if (isSet(datalenght_vvvvvyu) && datalenght_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = datalenght_vvvvvyu;
		var datalenght_vvvvvyu = [];
		datalenght_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(datalenght_vvvvvyu))
	{
		var datalenght_vvvvvyu = [];
	}
	var datalenght = datalenght_vvvvvyu.some(datalenght_vvvvvyu_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvyuvyo_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvyuvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvyuvyo_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvyuvyo_required = true;
		}
	}
}

// the vvvvvyu Some function
function datalenght_vvvvvyu_SomeFunc(datalenght_vvvvvyu)
{
	// set the function logic
	if (datalenght_vvvvvyu == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyv function
function vvvvvyv(datadefault_vvvvvyv)
{
	if (isSet(datadefault_vvvvvyv) && datadefault_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = datadefault_vvvvvyv;
		var datadefault_vvvvvyv = [];
		datadefault_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(datadefault_vvvvvyv))
	{
		var datadefault_vvvvvyv = [];
	}
	var datadefault = datadefault_vvvvvyv.some(datadefault_vvvvvyv_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvyvvyp_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvyvvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvyvvyp_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvyvvyp_required = true;
		}
	}
}

// the vvvvvyv Some function
function datadefault_vvvvvyv_SomeFunc(datadefault_vvvvvyv)
{
	// set the function logic
	if (datadefault_vvvvvyv == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvyw function
function vvvvvyw(datatype_vvvvvyw)
{
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
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvywvyq_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvywvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvywvyq_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvywvyq_required = true;
		}
	}
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

// the vvvvvyx function
function vvvvvyx(store_vvvvvyx,datatype_vvvvvyx)
{
	if (isSet(store_vvvvvyx) && store_vvvvvyx.constructor !== Array)
	{
		var temp_vvvvvyx = store_vvvvvyx;
		var store_vvvvvyx = [];
		store_vvvvvyx.push(temp_vvvvvyx);
	}
	else if (!isSet(store_vvvvvyx))
	{
		var store_vvvvvyx = [];
	}
	var store = store_vvvvvyx.some(store_vvvvvyx_SomeFunc);

	if (isSet(datatype_vvvvvyx) && datatype_vvvvvyx.constructor !== Array)
	{
		var temp_vvvvvyx = datatype_vvvvvyx;
		var datatype_vvvvvyx = [];
		datatype_vvvvvyx.push(temp_vvvvvyx);
	}
	else if (!isSet(datatype_vvvvvyx))
	{
		var datatype_vvvvvyx = [];
	}
	var datatype = datatype_vvvvvyx.some(datatype_vvvvvyx_SomeFunc);


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

// the vvvvvyx Some function
function store_vvvvvyx_SomeFunc(store_vvvvvyx)
{
	// set the function logic
	if (store_vvvvvyx == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyx Some function
function datatype_vvvvvyx_SomeFunc(datatype_vvvvvyx)
{
	// set the function logic
	if (datatype_vvvvvyx == 'CHAR' || datatype_vvvvvyx == 'VARCHAR' || datatype_vvvvvyx == 'TEXT' || datatype_vvvvvyx == 'MEDIUMTEXT' || datatype_vvvvvyx == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvyz function
function vvvvvyz(add_css_view_vvvvvyz)
{
	// set the function logic
	if (add_css_view_vvvvvyz == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvyzvyr_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvyzvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvyzvyr_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvyzvyr_required = true;
		}
	}
}

// the vvvvvza function
function vvvvvza(add_css_views_vvvvvza)
{
	// set the function logic
	if (add_css_views_vvvvvza == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzavys_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzavys_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzavys_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzavys_required = true;
		}
	}
}

// the vvvvvzb function
function vvvvvzb(add_javascript_view_footer_vvvvvzb)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzb == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzbvyt_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzbvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzbvyt_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzbvyt_required = true;
		}
	}
}

// the vvvvvzc function
function vvvvvzc(add_javascript_views_footer_vvvvvzc)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzc == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzcvyu_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzcvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzcvyu_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzcvyu_required = true;
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
