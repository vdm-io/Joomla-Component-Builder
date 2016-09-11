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

	@version		2.1.21
	@build			11th September, 2016
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
jform_vvvvvzavyy_required = false;
jform_vvvvvzbvyz_required = false;
jform_vvvvvzcvza_required = false;
jform_vvvvvzdvzb_required = false;
jform_vvvvvzgvzc_required = false;
jform_vvvvvzhvzd_required = false;
jform_vvvvvzivze_required = false;
jform_vvvvvzjvzf_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvza = jQuery("#jform_datalenght").val();
	vvvvvza(datalenght_vvvvvza);

	var datadefault_vvvvvzb = jQuery("#jform_datadefault").val();
	vvvvvzb(datadefault_vvvvvzb);

	var datatype_vvvvvzc = jQuery("#jform_datatype").val();
	vvvvvzc(datatype_vvvvvzc);

	var datatype_vvvvvzd = jQuery("#jform_datatype").val();
	vvvvvzd(datatype_vvvvvzd);

	var store_vvvvvze = jQuery("#jform_store").val();
	var datatype_vvvvvze = jQuery("#jform_datatype").val();
	vvvvvze(store_vvvvvze,datatype_vvvvvze);

	var add_css_view_vvvvvzg = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzg(add_css_view_vvvvvzg);

	var add_css_views_vvvvvzh = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvzh(add_css_views_vvvvvzh);

	var add_javascript_view_footer_vvvvvzi = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzi(add_javascript_view_footer_vvvvvzi);

	var add_javascript_views_footer_vvvvvzj = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzj(add_javascript_views_footer_vvvvvzj);
});

// the vvvvvza function
function vvvvvza(datalenght_vvvvvza)
{
	if (isSet(datalenght_vvvvvza) && datalenght_vvvvvza.constructor !== Array)
	{
		var temp_vvvvvza = datalenght_vvvvvza;
		var datalenght_vvvvvza = [];
		datalenght_vvvvvza.push(temp_vvvvvza);
	}
	else if (!isSet(datalenght_vvvvvza))
	{
		var datalenght_vvvvvza = [];
	}
	var datalenght = datalenght_vvvvvza.some(datalenght_vvvvvza_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvzavyy_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvzavyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvzavyy_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvzavyy_required = true;
		}
	}
}

// the vvvvvza Some function
function datalenght_vvvvvza_SomeFunc(datalenght_vvvvvza)
{
	// set the function logic
	if (datalenght_vvvvvza == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzb function
function vvvvvzb(datadefault_vvvvvzb)
{
	if (isSet(datadefault_vvvvvzb) && datadefault_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = datadefault_vvvvvzb;
		var datadefault_vvvvvzb = [];
		datadefault_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(datadefault_vvvvvzb))
	{
		var datadefault_vvvvvzb = [];
	}
	var datadefault = datadefault_vvvvvzb.some(datadefault_vvvvvzb_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvzbvyz_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvzbvyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvzbvyz_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvzbvyz_required = true;
		}
	}
}

// the vvvvvzb Some function
function datadefault_vvvvvzb_SomeFunc(datadefault_vvvvvzb)
{
	// set the function logic
	if (datadefault_vvvvvzb == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzc function
function vvvvvzc(datatype_vvvvvzc)
{
	if (isSet(datatype_vvvvvzc) && datatype_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = datatype_vvvvvzc;
		var datatype_vvvvvzc = [];
		datatype_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(datatype_vvvvvzc))
	{
		var datatype_vvvvvzc = [];
	}
	var datatype = datatype_vvvvvzc.some(datatype_vvvvvzc_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzcvza_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzcvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzcvza_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzcvza_required = true;
		}
	}
}

// the vvvvvzc Some function
function datatype_vvvvvzc_SomeFunc(datatype_vvvvvzc)
{
	// set the function logic
	if (datatype_vvvvvzc == 'CHAR' || datatype_vvvvvzc == 'VARCHAR' || datatype_vvvvvzc == 'DATETIME' || datatype_vvvvvzc == 'DATE' || datatype_vvvvvzc == 'TIME' || datatype_vvvvvzc == 'INT' || datatype_vvvvvzc == 'TINYINT' || datatype_vvvvvzc == 'BIGINT' || datatype_vvvvvzc == 'FLOAT' || datatype_vvvvvzc == 'DECIMAL' || datatype_vvvvvzc == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(datatype_vvvvvzd)
{
	if (isSet(datatype_vvvvvzd) && datatype_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = datatype_vvvvvzd;
		var datatype_vvvvvzd = [];
		datatype_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(datatype_vvvvvzd))
	{
		var datatype_vvvvvzd = [];
	}
	var datatype = datatype_vvvvvzd.some(datatype_vvvvvzd_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzdvzb_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzdvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzdvzb_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzdvzb_required = true;
		}
	}
}

// the vvvvvzd Some function
function datatype_vvvvvzd_SomeFunc(datatype_vvvvvzd)
{
	// set the function logic
	if (datatype_vvvvvzd == 'CHAR' || datatype_vvvvvzd == 'VARCHAR' || datatype_vvvvvzd == 'TEXT' || datatype_vvvvvzd == 'MEDIUMTEXT' || datatype_vvvvvzd == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvze function
function vvvvvze(store_vvvvvze,datatype_vvvvvze)
{
	if (isSet(store_vvvvvze) && store_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = store_vvvvvze;
		var store_vvvvvze = [];
		store_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(store_vvvvvze))
	{
		var store_vvvvvze = [];
	}
	var store = store_vvvvvze.some(store_vvvvvze_SomeFunc);

	if (isSet(datatype_vvvvvze) && datatype_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = datatype_vvvvvze;
		var datatype_vvvvvze = [];
		datatype_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(datatype_vvvvvze))
	{
		var datatype_vvvvvze = [];
	}
	var datatype = datatype_vvvvvze.some(datatype_vvvvvze_SomeFunc);


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

// the vvvvvze Some function
function store_vvvvvze_SomeFunc(store_vvvvvze)
{
	// set the function logic
	if (store_vvvvvze == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvze Some function
function datatype_vvvvvze_SomeFunc(datatype_vvvvvze)
{
	// set the function logic
	if (datatype_vvvvvze == 'CHAR' || datatype_vvvvvze == 'VARCHAR' || datatype_vvvvvze == 'TEXT' || datatype_vvvvvze == 'MEDIUMTEXT' || datatype_vvvvvze == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzg function
function vvvvvzg(add_css_view_vvvvvzg)
{
	// set the function logic
	if (add_css_view_vvvvvzg == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvzgvzc_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvzgvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvzgvzc_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvzgvzc_required = true;
		}
	}
}

// the vvvvvzh function
function vvvvvzh(add_css_views_vvvvvzh)
{
	// set the function logic
	if (add_css_views_vvvvvzh == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzhvzd_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzhvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzhvzd_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzhvzd_required = true;
		}
	}
}

// the vvvvvzi function
function vvvvvzi(add_javascript_view_footer_vvvvvzi)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzi == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzivze_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzivze_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzivze_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzivze_required = true;
		}
	}
}

// the vvvvvzj function
function vvvvvzj(add_javascript_views_footer_vvvvvzj)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzj == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzjvzf_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzjvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzjvzf_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzjvzf_required = true;
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
