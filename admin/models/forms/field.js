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

	@version		2.2.5
	@build			22nd December, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvznvzf_required = false;
jform_vvvvvzovzg_required = false;
jform_vvvvvzpvzh_required = false;
jform_vvvvvzqvzi_required = false;
jform_vvvvvztvzj_required = false;
jform_vvvvvzuvzk_required = false;
jform_vvvvvzvvzl_required = false;
jform_vvvvvzwvzm_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvzn = jQuery("#jform_datalenght").val();
	vvvvvzn(datalenght_vvvvvzn);

	var datadefault_vvvvvzo = jQuery("#jform_datadefault").val();
	vvvvvzo(datadefault_vvvvvzo);

	var datatype_vvvvvzp = jQuery("#jform_datatype").val();
	vvvvvzp(datatype_vvvvvzp);

	var datatype_vvvvvzq = jQuery("#jform_datatype").val();
	vvvvvzq(datatype_vvvvvzq);

	var store_vvvvvzr = jQuery("#jform_store").val();
	var datatype_vvvvvzr = jQuery("#jform_datatype").val();
	vvvvvzr(store_vvvvvzr,datatype_vvvvvzr);

	var add_css_view_vvvvvzt = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzt(add_css_view_vvvvvzt);

	var add_css_views_vvvvvzu = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvzu(add_css_views_vvvvvzu);

	var add_javascript_view_footer_vvvvvzv = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzv(add_javascript_view_footer_vvvvvzv);

	var add_javascript_views_footer_vvvvvzw = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzw(add_javascript_views_footer_vvvvvzw);
});

// the vvvvvzn function
function vvvvvzn(datalenght_vvvvvzn)
{
	if (isSet(datalenght_vvvvvzn) && datalenght_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = datalenght_vvvvvzn;
		var datalenght_vvvvvzn = [];
		datalenght_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(datalenght_vvvvvzn))
	{
		var datalenght_vvvvvzn = [];
	}
	var datalenght = datalenght_vvvvvzn.some(datalenght_vvvvvzn_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvznvzf_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvznvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvznvzf_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvznvzf_required = true;
		}
	}
}

// the vvvvvzn Some function
function datalenght_vvvvvzn_SomeFunc(datalenght_vvvvvzn)
{
	// set the function logic
	if (datalenght_vvvvvzn == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(datadefault_vvvvvzo)
{
	if (isSet(datadefault_vvvvvzo) && datadefault_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = datadefault_vvvvvzo;
		var datadefault_vvvvvzo = [];
		datadefault_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(datadefault_vvvvvzo))
	{
		var datadefault_vvvvvzo = [];
	}
	var datadefault = datadefault_vvvvvzo.some(datadefault_vvvvvzo_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvzovzg_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvzovzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvzovzg_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvzovzg_required = true;
		}
	}
}

// the vvvvvzo Some function
function datadefault_vvvvvzo_SomeFunc(datadefault_vvvvvzo)
{
	// set the function logic
	if (datadefault_vvvvvzo == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzp function
function vvvvvzp(datatype_vvvvvzp)
{
	if (isSet(datatype_vvvvvzp) && datatype_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = datatype_vvvvvzp;
		var datatype_vvvvvzp = [];
		datatype_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(datatype_vvvvvzp))
	{
		var datatype_vvvvvzp = [];
	}
	var datatype = datatype_vvvvvzp.some(datatype_vvvvvzp_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzpvzh_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzpvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzpvzh_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzpvzh_required = true;
		}
	}
}

// the vvvvvzp Some function
function datatype_vvvvvzp_SomeFunc(datatype_vvvvvzp)
{
	// set the function logic
	if (datatype_vvvvvzp == 'CHAR' || datatype_vvvvvzp == 'VARCHAR' || datatype_vvvvvzp == 'DATETIME' || datatype_vvvvvzp == 'DATE' || datatype_vvvvvzp == 'TIME' || datatype_vvvvvzp == 'INT' || datatype_vvvvvzp == 'TINYINT' || datatype_vvvvvzp == 'BIGINT' || datatype_vvvvvzp == 'FLOAT' || datatype_vvvvvzp == 'DECIMAL' || datatype_vvvvvzp == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvvzq function
function vvvvvzq(datatype_vvvvvzq)
{
	if (isSet(datatype_vvvvvzq) && datatype_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = datatype_vvvvvzq;
		var datatype_vvvvvzq = [];
		datatype_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(datatype_vvvvvzq))
	{
		var datatype_vvvvvzq = [];
	}
	var datatype = datatype_vvvvvzq.some(datatype_vvvvvzq_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzqvzi_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzqvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzqvzi_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzqvzi_required = true;
		}
	}
}

// the vvvvvzq Some function
function datatype_vvvvvzq_SomeFunc(datatype_vvvvvzq)
{
	// set the function logic
	if (datatype_vvvvvzq == 'CHAR' || datatype_vvvvvzq == 'VARCHAR' || datatype_vvvvvzq == 'TEXT' || datatype_vvvvvzq == 'MEDIUMTEXT' || datatype_vvvvvzq == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzr function
function vvvvvzr(store_vvvvvzr,datatype_vvvvvzr)
{
	if (isSet(store_vvvvvzr) && store_vvvvvzr.constructor !== Array)
	{
		var temp_vvvvvzr = store_vvvvvzr;
		var store_vvvvvzr = [];
		store_vvvvvzr.push(temp_vvvvvzr);
	}
	else if (!isSet(store_vvvvvzr))
	{
		var store_vvvvvzr = [];
	}
	var store = store_vvvvvzr.some(store_vvvvvzr_SomeFunc);

	if (isSet(datatype_vvvvvzr) && datatype_vvvvvzr.constructor !== Array)
	{
		var temp_vvvvvzr = datatype_vvvvvzr;
		var datatype_vvvvvzr = [];
		datatype_vvvvvzr.push(temp_vvvvvzr);
	}
	else if (!isSet(datatype_vvvvvzr))
	{
		var datatype_vvvvvzr = [];
	}
	var datatype = datatype_vvvvvzr.some(datatype_vvvvvzr_SomeFunc);


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

// the vvvvvzr Some function
function store_vvvvvzr_SomeFunc(store_vvvvvzr)
{
	// set the function logic
	if (store_vvvvvzr == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzr Some function
function datatype_vvvvvzr_SomeFunc(datatype_vvvvvzr)
{
	// set the function logic
	if (datatype_vvvvvzr == 'CHAR' || datatype_vvvvvzr == 'VARCHAR' || datatype_vvvvvzr == 'TEXT' || datatype_vvvvvzr == 'MEDIUMTEXT' || datatype_vvvvvzr == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(add_css_view_vvvvvzt)
{
	// set the function logic
	if (add_css_view_vvvvvzt == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvztvzj_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvztvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvztvzj_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvztvzj_required = true;
		}
	}
}

// the vvvvvzu function
function vvvvvzu(add_css_views_vvvvvzu)
{
	// set the function logic
	if (add_css_views_vvvvvzu == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzuvzk_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzuvzk_required = true;
		}
	}
}

// the vvvvvzv function
function vvvvvzv(add_javascript_view_footer_vvvvvzv)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzv == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzvvzl_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzvvzl_required = true;
		}
	}
}

// the vvvvvzw function
function vvvvvzw(add_javascript_views_footer_vvvvvzw)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzw == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzwvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzwvzm_required = true;
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
