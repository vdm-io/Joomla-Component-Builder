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
	@build			30th January, 2016
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
jform_odulURejbt_required = false;
jform_DJPbqmGjIL_required = false;
jform_LpOkvnXoNS_required = false;
jform_wrNjHBTlMG_required = false;
jform_tkSrzJlrAk_required = false;
jform_QOZdfZqODr_required = false;
jform_oaPXjpsdHg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_odulURe = jQuery("#jform_datalenght").val();
	odulURe(datalenght_odulURe);

	var datadefault_DJPbqmG = jQuery("#jform_datadefault").val();
	DJPbqmG(datadefault_DJPbqmG);

	var datatype_LpOkvnX = jQuery("#jform_datatype").val();
	LpOkvnX(datatype_LpOkvnX);

	var store_ZXWBoOl = jQuery("#jform_store").val();
	var datatype_ZXWBoOl = jQuery("#jform_datatype").val();
	ZXWBoOl(store_ZXWBoOl,datatype_ZXWBoOl);

	var add_css_view_wrNjHBT = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	wrNjHBT(add_css_view_wrNjHBT);

	var add_css_views_tkSrzJl = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	tkSrzJl(add_css_views_tkSrzJl);

	var add_javascript_view_footer_QOZdfZq = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	QOZdfZq(add_javascript_view_footer_QOZdfZq);

	var add_javascript_views_footer_oaPXjps = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	oaPXjps(add_javascript_views_footer_oaPXjps);
});

// the odulURe function
function odulURe(datalenght_odulURe)
{
	if (isSet(datalenght_odulURe) && datalenght_odulURe.constructor !== Array)
	{
		var temp_odulURe = datalenght_odulURe;
		var datalenght_odulURe = [];
		datalenght_odulURe.push(temp_odulURe);
	}
	else if (!isSet(datalenght_odulURe))
	{
		var datalenght_odulURe = [];
	}
	var datalenght = datalenght_odulURe.some(datalenght_odulURe_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_odulURejbt_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_odulURejbt_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_odulURejbt_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_odulURejbt_required = true;
		}
	}
}

// the odulURe Some function
function datalenght_odulURe_SomeFunc(datalenght_odulURe)
{
	// set the function logic
	if (datalenght_odulURe == 'Other')
	{
		return true;
	}
	return false;
}

// the DJPbqmG function
function DJPbqmG(datadefault_DJPbqmG)
{
	if (isSet(datadefault_DJPbqmG) && datadefault_DJPbqmG.constructor !== Array)
	{
		var temp_DJPbqmG = datadefault_DJPbqmG;
		var datadefault_DJPbqmG = [];
		datadefault_DJPbqmG.push(temp_DJPbqmG);
	}
	else if (!isSet(datadefault_DJPbqmG))
	{
		var datadefault_DJPbqmG = [];
	}
	var datadefault = datadefault_DJPbqmG.some(datadefault_DJPbqmG_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_DJPbqmGjIL_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_DJPbqmGjIL_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_DJPbqmGjIL_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_DJPbqmGjIL_required = true;
		}
	}
}

// the DJPbqmG Some function
function datadefault_DJPbqmG_SomeFunc(datadefault_DJPbqmG)
{
	// set the function logic
	if (datadefault_DJPbqmG == 'Other')
	{
		return true;
	}
	return false;
}

// the LpOkvnX function
function LpOkvnX(datatype_LpOkvnX)
{
	if (isSet(datatype_LpOkvnX) && datatype_LpOkvnX.constructor !== Array)
	{
		var temp_LpOkvnX = datatype_LpOkvnX;
		var datatype_LpOkvnX = [];
		datatype_LpOkvnX.push(temp_LpOkvnX);
	}
	else if (!isSet(datatype_LpOkvnX))
	{
		var datatype_LpOkvnX = [];
	}
	var datatype = datatype_LpOkvnX.some(datatype_LpOkvnX_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_LpOkvnXoNS_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_LpOkvnXoNS_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_LpOkvnXoNS_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_LpOkvnXoNS_required = true;
		}
	}
}

// the LpOkvnX Some function
function datatype_LpOkvnX_SomeFunc(datatype_LpOkvnX)
{
	// set the function logic
	if (datatype_LpOkvnX == 'CHAR' || datatype_LpOkvnX == 'VARCHAR' || datatype_LpOkvnX == 'TEXT' || datatype_LpOkvnX == 'MEDIUMTEXT' || datatype_LpOkvnX == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the ZXWBoOl function
function ZXWBoOl(store_ZXWBoOl,datatype_ZXWBoOl)
{
	if (isSet(store_ZXWBoOl) && store_ZXWBoOl.constructor !== Array)
	{
		var temp_ZXWBoOl = store_ZXWBoOl;
		var store_ZXWBoOl = [];
		store_ZXWBoOl.push(temp_ZXWBoOl);
	}
	else if (!isSet(store_ZXWBoOl))
	{
		var store_ZXWBoOl = [];
	}
	var store = store_ZXWBoOl.some(store_ZXWBoOl_SomeFunc);

	if (isSet(datatype_ZXWBoOl) && datatype_ZXWBoOl.constructor !== Array)
	{
		var temp_ZXWBoOl = datatype_ZXWBoOl;
		var datatype_ZXWBoOl = [];
		datatype_ZXWBoOl.push(temp_ZXWBoOl);
	}
	else if (!isSet(datatype_ZXWBoOl))
	{
		var datatype_ZXWBoOl = [];
	}
	var datatype = datatype_ZXWBoOl.some(datatype_ZXWBoOl_SomeFunc);


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

// the ZXWBoOl Some function
function store_ZXWBoOl_SomeFunc(store_ZXWBoOl)
{
	// set the function logic
	if (store_ZXWBoOl == 4)
	{
		return true;
	}
	return false;
}

// the ZXWBoOl Some function
function datatype_ZXWBoOl_SomeFunc(datatype_ZXWBoOl)
{
	// set the function logic
	if (datatype_ZXWBoOl == 'CHAR' || datatype_ZXWBoOl == 'VARCHAR' || datatype_ZXWBoOl == 'TEXT' || datatype_ZXWBoOl == 'MEDIUMTEXT' || datatype_ZXWBoOl == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the wrNjHBT function
function wrNjHBT(add_css_view_wrNjHBT)
{
	// set the function logic
	if (add_css_view_wrNjHBT == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_wrNjHBTlMG_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_wrNjHBTlMG_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_wrNjHBTlMG_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_wrNjHBTlMG_required = true;
		}
	}
}

// the tkSrzJl function
function tkSrzJl(add_css_views_tkSrzJl)
{
	// set the function logic
	if (add_css_views_tkSrzJl == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_tkSrzJlrAk_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_tkSrzJlrAk_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_tkSrzJlrAk_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_tkSrzJlrAk_required = true;
		}
	}
}

// the QOZdfZq function
function QOZdfZq(add_javascript_view_footer_QOZdfZq)
{
	// set the function logic
	if (add_javascript_view_footer_QOZdfZq == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_QOZdfZqODr_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_QOZdfZqODr_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_QOZdfZqODr_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_QOZdfZqODr_required = true;
		}
	}
}

// the oaPXjps function
function oaPXjps(add_javascript_views_footer_oaPXjps)
{
	// set the function logic
	if (add_javascript_views_footer_oaPXjps == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_oaPXjpsdHg_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_oaPXjpsdHg_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_oaPXjpsdHg_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_oaPXjpsdHg_required = true;
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
