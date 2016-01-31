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

	@version		2.0.9
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
jform_rqQxAwMgOG_required = false;
jform_LXznLCDHLM_required = false;
jform_tsTDgamWLJ_required = false;
jform_ADKgemRFMG_required = false;
jform_cSGtKwcMme_required = false;
jform_vJDKLeEmux_required = false;
jform_vWVhbasTFi_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_rqQxAwM = jQuery("#jform_datalenght").val();
	rqQxAwM(datalenght_rqQxAwM);

	var datadefault_LXznLCD = jQuery("#jform_datadefault").val();
	LXznLCD(datadefault_LXznLCD);

	var datatype_tsTDgam = jQuery("#jform_datatype").val();
	tsTDgam(datatype_tsTDgam);

	var store_XXaQoAg = jQuery("#jform_store").val();
	var datatype_XXaQoAg = jQuery("#jform_datatype").val();
	XXaQoAg(store_XXaQoAg,datatype_XXaQoAg);

	var add_css_view_ADKgemR = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	ADKgemR(add_css_view_ADKgemR);

	var add_css_views_cSGtKwc = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	cSGtKwc(add_css_views_cSGtKwc);

	var add_javascript_view_footer_vJDKLeE = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vJDKLeE(add_javascript_view_footer_vJDKLeE);

	var add_javascript_views_footer_vWVhbas = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vWVhbas(add_javascript_views_footer_vWVhbas);
});

// the rqQxAwM function
function rqQxAwM(datalenght_rqQxAwM)
{
	if (isSet(datalenght_rqQxAwM) && datalenght_rqQxAwM.constructor !== Array)
	{
		var temp_rqQxAwM = datalenght_rqQxAwM;
		var datalenght_rqQxAwM = [];
		datalenght_rqQxAwM.push(temp_rqQxAwM);
	}
	else if (!isSet(datalenght_rqQxAwM))
	{
		var datalenght_rqQxAwM = [];
	}
	var datalenght = datalenght_rqQxAwM.some(datalenght_rqQxAwM_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_rqQxAwMgOG_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_rqQxAwMgOG_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_rqQxAwMgOG_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_rqQxAwMgOG_required = true;
		}
	}
}

// the rqQxAwM Some function
function datalenght_rqQxAwM_SomeFunc(datalenght_rqQxAwM)
{
	// set the function logic
	if (datalenght_rqQxAwM == 'Other')
	{
		return true;
	}
	return false;
}

// the LXznLCD function
function LXznLCD(datadefault_LXznLCD)
{
	if (isSet(datadefault_LXznLCD) && datadefault_LXznLCD.constructor !== Array)
	{
		var temp_LXznLCD = datadefault_LXznLCD;
		var datadefault_LXznLCD = [];
		datadefault_LXznLCD.push(temp_LXznLCD);
	}
	else if (!isSet(datadefault_LXznLCD))
	{
		var datadefault_LXznLCD = [];
	}
	var datadefault = datadefault_LXznLCD.some(datadefault_LXznLCD_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_LXznLCDHLM_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_LXznLCDHLM_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_LXznLCDHLM_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_LXznLCDHLM_required = true;
		}
	}
}

// the LXznLCD Some function
function datadefault_LXznLCD_SomeFunc(datadefault_LXznLCD)
{
	// set the function logic
	if (datadefault_LXznLCD == 'Other')
	{
		return true;
	}
	return false;
}

// the tsTDgam function
function tsTDgam(datatype_tsTDgam)
{
	if (isSet(datatype_tsTDgam) && datatype_tsTDgam.constructor !== Array)
	{
		var temp_tsTDgam = datatype_tsTDgam;
		var datatype_tsTDgam = [];
		datatype_tsTDgam.push(temp_tsTDgam);
	}
	else if (!isSet(datatype_tsTDgam))
	{
		var datatype_tsTDgam = [];
	}
	var datatype = datatype_tsTDgam.some(datatype_tsTDgam_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_tsTDgamWLJ_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_tsTDgamWLJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_tsTDgamWLJ_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_tsTDgamWLJ_required = true;
		}
	}
}

// the tsTDgam Some function
function datatype_tsTDgam_SomeFunc(datatype_tsTDgam)
{
	// set the function logic
	if (datatype_tsTDgam == 'CHAR' || datatype_tsTDgam == 'VARCHAR' || datatype_tsTDgam == 'TEXT' || datatype_tsTDgam == 'MEDIUMTEXT' || datatype_tsTDgam == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the XXaQoAg function
function XXaQoAg(store_XXaQoAg,datatype_XXaQoAg)
{
	if (isSet(store_XXaQoAg) && store_XXaQoAg.constructor !== Array)
	{
		var temp_XXaQoAg = store_XXaQoAg;
		var store_XXaQoAg = [];
		store_XXaQoAg.push(temp_XXaQoAg);
	}
	else if (!isSet(store_XXaQoAg))
	{
		var store_XXaQoAg = [];
	}
	var store = store_XXaQoAg.some(store_XXaQoAg_SomeFunc);

	if (isSet(datatype_XXaQoAg) && datatype_XXaQoAg.constructor !== Array)
	{
		var temp_XXaQoAg = datatype_XXaQoAg;
		var datatype_XXaQoAg = [];
		datatype_XXaQoAg.push(temp_XXaQoAg);
	}
	else if (!isSet(datatype_XXaQoAg))
	{
		var datatype_XXaQoAg = [];
	}
	var datatype = datatype_XXaQoAg.some(datatype_XXaQoAg_SomeFunc);


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

// the XXaQoAg Some function
function store_XXaQoAg_SomeFunc(store_XXaQoAg)
{
	// set the function logic
	if (store_XXaQoAg == 4)
	{
		return true;
	}
	return false;
}

// the XXaQoAg Some function
function datatype_XXaQoAg_SomeFunc(datatype_XXaQoAg)
{
	// set the function logic
	if (datatype_XXaQoAg == 'CHAR' || datatype_XXaQoAg == 'VARCHAR' || datatype_XXaQoAg == 'TEXT' || datatype_XXaQoAg == 'MEDIUMTEXT' || datatype_XXaQoAg == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the ADKgemR function
function ADKgemR(add_css_view_ADKgemR)
{
	// set the function logic
	if (add_css_view_ADKgemR == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_ADKgemRFMG_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_ADKgemRFMG_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_ADKgemRFMG_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_ADKgemRFMG_required = true;
		}
	}
}

// the cSGtKwc function
function cSGtKwc(add_css_views_cSGtKwc)
{
	// set the function logic
	if (add_css_views_cSGtKwc == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_cSGtKwcMme_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_cSGtKwcMme_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_cSGtKwcMme_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_cSGtKwcMme_required = true;
		}
	}
}

// the vJDKLeE function
function vJDKLeE(add_javascript_view_footer_vJDKLeE)
{
	// set the function logic
	if (add_javascript_view_footer_vJDKLeE == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vJDKLeEmux_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vJDKLeEmux_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vJDKLeEmux_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vJDKLeEmux_required = true;
		}
	}
}

// the vWVhbas function
function vWVhbas(add_javascript_views_footer_vWVhbas)
{
	// set the function logic
	if (add_javascript_views_footer_vWVhbas == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vWVhbasTFi_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vWVhbasTFi_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vWVhbasTFi_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vWVhbasTFi_required = true;
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
