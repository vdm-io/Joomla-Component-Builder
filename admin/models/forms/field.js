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
	@build			20th February, 2016
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
jform_lnskspQwLr_required = false;
jform_WHhBHvQTFL_required = false;
jform_FTvOiCegSU_required = false;
jform_nUdhOEPnDr_required = false;
jform_fKUiNOeVVl_required = false;
jform_slFmuASUBi_required = false;
jform_xKbJSNqLeO_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_lnskspQ = jQuery("#jform_datalenght").val();
	lnskspQ(datalenght_lnskspQ);

	var datadefault_WHhBHvQ = jQuery("#jform_datadefault").val();
	WHhBHvQ(datadefault_WHhBHvQ);

	var datatype_FTvOiCe = jQuery("#jform_datatype").val();
	FTvOiCe(datatype_FTvOiCe);

	var store_efhEwAS = jQuery("#jform_store").val();
	var datatype_efhEwAS = jQuery("#jform_datatype").val();
	efhEwAS(store_efhEwAS,datatype_efhEwAS);

	var add_css_view_nUdhOEP = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	nUdhOEP(add_css_view_nUdhOEP);

	var add_css_views_fKUiNOe = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	fKUiNOe(add_css_views_fKUiNOe);

	var add_javascript_view_footer_slFmuAS = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	slFmuAS(add_javascript_view_footer_slFmuAS);

	var add_javascript_views_footer_xKbJSNq = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	xKbJSNq(add_javascript_views_footer_xKbJSNq);
});

// the lnskspQ function
function lnskspQ(datalenght_lnskspQ)
{
	if (isSet(datalenght_lnskspQ) && datalenght_lnskspQ.constructor !== Array)
	{
		var temp_lnskspQ = datalenght_lnskspQ;
		var datalenght_lnskspQ = [];
		datalenght_lnskspQ.push(temp_lnskspQ);
	}
	else if (!isSet(datalenght_lnskspQ))
	{
		var datalenght_lnskspQ = [];
	}
	var datalenght = datalenght_lnskspQ.some(datalenght_lnskspQ_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_lnskspQwLr_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_lnskspQwLr_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_lnskspQwLr_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_lnskspQwLr_required = true;
		}
	}
}

// the lnskspQ Some function
function datalenght_lnskspQ_SomeFunc(datalenght_lnskspQ)
{
	// set the function logic
	if (datalenght_lnskspQ == 'Other')
	{
		return true;
	}
	return false;
}

// the WHhBHvQ function
function WHhBHvQ(datadefault_WHhBHvQ)
{
	if (isSet(datadefault_WHhBHvQ) && datadefault_WHhBHvQ.constructor !== Array)
	{
		var temp_WHhBHvQ = datadefault_WHhBHvQ;
		var datadefault_WHhBHvQ = [];
		datadefault_WHhBHvQ.push(temp_WHhBHvQ);
	}
	else if (!isSet(datadefault_WHhBHvQ))
	{
		var datadefault_WHhBHvQ = [];
	}
	var datadefault = datadefault_WHhBHvQ.some(datadefault_WHhBHvQ_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_WHhBHvQTFL_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_WHhBHvQTFL_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_WHhBHvQTFL_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_WHhBHvQTFL_required = true;
		}
	}
}

// the WHhBHvQ Some function
function datadefault_WHhBHvQ_SomeFunc(datadefault_WHhBHvQ)
{
	// set the function logic
	if (datadefault_WHhBHvQ == 'Other')
	{
		return true;
	}
	return false;
}

// the FTvOiCe function
function FTvOiCe(datatype_FTvOiCe)
{
	if (isSet(datatype_FTvOiCe) && datatype_FTvOiCe.constructor !== Array)
	{
		var temp_FTvOiCe = datatype_FTvOiCe;
		var datatype_FTvOiCe = [];
		datatype_FTvOiCe.push(temp_FTvOiCe);
	}
	else if (!isSet(datatype_FTvOiCe))
	{
		var datatype_FTvOiCe = [];
	}
	var datatype = datatype_FTvOiCe.some(datatype_FTvOiCe_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_FTvOiCegSU_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_FTvOiCegSU_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_FTvOiCegSU_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_FTvOiCegSU_required = true;
		}
	}
}

// the FTvOiCe Some function
function datatype_FTvOiCe_SomeFunc(datatype_FTvOiCe)
{
	// set the function logic
	if (datatype_FTvOiCe == 'CHAR' || datatype_FTvOiCe == 'VARCHAR' || datatype_FTvOiCe == 'TEXT' || datatype_FTvOiCe == 'MEDIUMTEXT' || datatype_FTvOiCe == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the efhEwAS function
function efhEwAS(store_efhEwAS,datatype_efhEwAS)
{
	if (isSet(store_efhEwAS) && store_efhEwAS.constructor !== Array)
	{
		var temp_efhEwAS = store_efhEwAS;
		var store_efhEwAS = [];
		store_efhEwAS.push(temp_efhEwAS);
	}
	else if (!isSet(store_efhEwAS))
	{
		var store_efhEwAS = [];
	}
	var store = store_efhEwAS.some(store_efhEwAS_SomeFunc);

	if (isSet(datatype_efhEwAS) && datatype_efhEwAS.constructor !== Array)
	{
		var temp_efhEwAS = datatype_efhEwAS;
		var datatype_efhEwAS = [];
		datatype_efhEwAS.push(temp_efhEwAS);
	}
	else if (!isSet(datatype_efhEwAS))
	{
		var datatype_efhEwAS = [];
	}
	var datatype = datatype_efhEwAS.some(datatype_efhEwAS_SomeFunc);


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

// the efhEwAS Some function
function store_efhEwAS_SomeFunc(store_efhEwAS)
{
	// set the function logic
	if (store_efhEwAS == 4)
	{
		return true;
	}
	return false;
}

// the efhEwAS Some function
function datatype_efhEwAS_SomeFunc(datatype_efhEwAS)
{
	// set the function logic
	if (datatype_efhEwAS == 'CHAR' || datatype_efhEwAS == 'VARCHAR' || datatype_efhEwAS == 'TEXT' || datatype_efhEwAS == 'MEDIUMTEXT' || datatype_efhEwAS == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the nUdhOEP function
function nUdhOEP(add_css_view_nUdhOEP)
{
	// set the function logic
	if (add_css_view_nUdhOEP == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_nUdhOEPnDr_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_nUdhOEPnDr_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_nUdhOEPnDr_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_nUdhOEPnDr_required = true;
		}
	}
}

// the fKUiNOe function
function fKUiNOe(add_css_views_fKUiNOe)
{
	// set the function logic
	if (add_css_views_fKUiNOe == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_fKUiNOeVVl_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_fKUiNOeVVl_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_fKUiNOeVVl_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_fKUiNOeVVl_required = true;
		}
	}
}

// the slFmuAS function
function slFmuAS(add_javascript_view_footer_slFmuAS)
{
	// set the function logic
	if (add_javascript_view_footer_slFmuAS == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_slFmuASUBi_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_slFmuASUBi_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_slFmuASUBi_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_slFmuASUBi_required = true;
		}
	}
}

// the xKbJSNq function
function xKbJSNq(add_javascript_views_footer_xKbJSNq)
{
	// set the function logic
	if (add_javascript_views_footer_xKbJSNq == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_xKbJSNqLeO_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_xKbJSNqLeO_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_xKbJSNqLeO_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_xKbJSNqLeO_required = true;
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
