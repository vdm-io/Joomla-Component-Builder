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

	@version		2.0.8
	@build			31st January, 2016
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
jform_dKiaBQAyeW_required = false;
jform_yiGBlYuPqv_required = false;
jform_LtJifKzdLA_required = false;
jform_WJQqrdJfqv_required = false;
jform_pDhKzQdLFj_required = false;
jform_WtScFWqWrB_required = false;
jform_OnpzACKnHb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_dKiaBQA = jQuery("#jform_datalenght").val();
	dKiaBQA(datalenght_dKiaBQA);

	var datadefault_yiGBlYu = jQuery("#jform_datadefault").val();
	yiGBlYu(datadefault_yiGBlYu);

	var datatype_LtJifKz = jQuery("#jform_datatype").val();
	LtJifKz(datatype_LtJifKz);

	var store_eKdrKLg = jQuery("#jform_store").val();
	var datatype_eKdrKLg = jQuery("#jform_datatype").val();
	eKdrKLg(store_eKdrKLg,datatype_eKdrKLg);

	var add_css_view_WJQqrdJ = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	WJQqrdJ(add_css_view_WJQqrdJ);

	var add_css_views_pDhKzQd = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	pDhKzQd(add_css_views_pDhKzQd);

	var add_javascript_view_footer_WtScFWq = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	WtScFWq(add_javascript_view_footer_WtScFWq);

	var add_javascript_views_footer_OnpzACK = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	OnpzACK(add_javascript_views_footer_OnpzACK);
});

// the dKiaBQA function
function dKiaBQA(datalenght_dKiaBQA)
{
	if (isSet(datalenght_dKiaBQA) && datalenght_dKiaBQA.constructor !== Array)
	{
		var temp_dKiaBQA = datalenght_dKiaBQA;
		var datalenght_dKiaBQA = [];
		datalenght_dKiaBQA.push(temp_dKiaBQA);
	}
	else if (!isSet(datalenght_dKiaBQA))
	{
		var datalenght_dKiaBQA = [];
	}
	var datalenght = datalenght_dKiaBQA.some(datalenght_dKiaBQA_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_dKiaBQAyeW_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_dKiaBQAyeW_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_dKiaBQAyeW_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_dKiaBQAyeW_required = true;
		}
	}
}

// the dKiaBQA Some function
function datalenght_dKiaBQA_SomeFunc(datalenght_dKiaBQA)
{
	// set the function logic
	if (datalenght_dKiaBQA == 'Other')
	{
		return true;
	}
	return false;
}

// the yiGBlYu function
function yiGBlYu(datadefault_yiGBlYu)
{
	if (isSet(datadefault_yiGBlYu) && datadefault_yiGBlYu.constructor !== Array)
	{
		var temp_yiGBlYu = datadefault_yiGBlYu;
		var datadefault_yiGBlYu = [];
		datadefault_yiGBlYu.push(temp_yiGBlYu);
	}
	else if (!isSet(datadefault_yiGBlYu))
	{
		var datadefault_yiGBlYu = [];
	}
	var datadefault = datadefault_yiGBlYu.some(datadefault_yiGBlYu_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_yiGBlYuPqv_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_yiGBlYuPqv_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_yiGBlYuPqv_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_yiGBlYuPqv_required = true;
		}
	}
}

// the yiGBlYu Some function
function datadefault_yiGBlYu_SomeFunc(datadefault_yiGBlYu)
{
	// set the function logic
	if (datadefault_yiGBlYu == 'Other')
	{
		return true;
	}
	return false;
}

// the LtJifKz function
function LtJifKz(datatype_LtJifKz)
{
	if (isSet(datatype_LtJifKz) && datatype_LtJifKz.constructor !== Array)
	{
		var temp_LtJifKz = datatype_LtJifKz;
		var datatype_LtJifKz = [];
		datatype_LtJifKz.push(temp_LtJifKz);
	}
	else if (!isSet(datatype_LtJifKz))
	{
		var datatype_LtJifKz = [];
	}
	var datatype = datatype_LtJifKz.some(datatype_LtJifKz_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_LtJifKzdLA_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_LtJifKzdLA_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_LtJifKzdLA_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_LtJifKzdLA_required = true;
		}
	}
}

// the LtJifKz Some function
function datatype_LtJifKz_SomeFunc(datatype_LtJifKz)
{
	// set the function logic
	if (datatype_LtJifKz == 'CHAR' || datatype_LtJifKz == 'VARCHAR' || datatype_LtJifKz == 'TEXT' || datatype_LtJifKz == 'MEDIUMTEXT' || datatype_LtJifKz == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the eKdrKLg function
function eKdrKLg(store_eKdrKLg,datatype_eKdrKLg)
{
	if (isSet(store_eKdrKLg) && store_eKdrKLg.constructor !== Array)
	{
		var temp_eKdrKLg = store_eKdrKLg;
		var store_eKdrKLg = [];
		store_eKdrKLg.push(temp_eKdrKLg);
	}
	else if (!isSet(store_eKdrKLg))
	{
		var store_eKdrKLg = [];
	}
	var store = store_eKdrKLg.some(store_eKdrKLg_SomeFunc);

	if (isSet(datatype_eKdrKLg) && datatype_eKdrKLg.constructor !== Array)
	{
		var temp_eKdrKLg = datatype_eKdrKLg;
		var datatype_eKdrKLg = [];
		datatype_eKdrKLg.push(temp_eKdrKLg);
	}
	else if (!isSet(datatype_eKdrKLg))
	{
		var datatype_eKdrKLg = [];
	}
	var datatype = datatype_eKdrKLg.some(datatype_eKdrKLg_SomeFunc);


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

// the eKdrKLg Some function
function store_eKdrKLg_SomeFunc(store_eKdrKLg)
{
	// set the function logic
	if (store_eKdrKLg == 4)
	{
		return true;
	}
	return false;
}

// the eKdrKLg Some function
function datatype_eKdrKLg_SomeFunc(datatype_eKdrKLg)
{
	// set the function logic
	if (datatype_eKdrKLg == 'CHAR' || datatype_eKdrKLg == 'VARCHAR' || datatype_eKdrKLg == 'TEXT' || datatype_eKdrKLg == 'MEDIUMTEXT' || datatype_eKdrKLg == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the WJQqrdJ function
function WJQqrdJ(add_css_view_WJQqrdJ)
{
	// set the function logic
	if (add_css_view_WJQqrdJ == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_WJQqrdJfqv_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_WJQqrdJfqv_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_WJQqrdJfqv_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_WJQqrdJfqv_required = true;
		}
	}
}

// the pDhKzQd function
function pDhKzQd(add_css_views_pDhKzQd)
{
	// set the function logic
	if (add_css_views_pDhKzQd == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_pDhKzQdLFj_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_pDhKzQdLFj_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_pDhKzQdLFj_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_pDhKzQdLFj_required = true;
		}
	}
}

// the WtScFWq function
function WtScFWq(add_javascript_view_footer_WtScFWq)
{
	// set the function logic
	if (add_javascript_view_footer_WtScFWq == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_WtScFWqWrB_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_WtScFWqWrB_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_WtScFWqWrB_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_WtScFWqWrB_required = true;
		}
	}
}

// the OnpzACK function
function OnpzACK(add_javascript_views_footer_OnpzACK)
{
	// set the function logic
	if (add_javascript_views_footer_OnpzACK == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_OnpzACKnHb_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_OnpzACKnHb_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_OnpzACKnHb_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_OnpzACKnHb_required = true;
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
