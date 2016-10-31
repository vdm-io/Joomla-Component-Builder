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

	@version		2.2.0
	@build			31st October, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzfvzd_required = false;
jform_vvvvvzgvze_required = false;
jform_vvvvvzhvzf_required = false;
jform_vvvvvzivzg_required = false;
jform_vvvvvzlvzh_required = false;
jform_vvvvvzmvzi_required = false;
jform_vvvvvznvzj_required = false;
jform_vvvvvzovzk_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvzf = jQuery("#jform_datalenght").val();
	vvvvvzf(datalenght_vvvvvzf);

	var datadefault_vvvvvzg = jQuery("#jform_datadefault").val();
	vvvvvzg(datadefault_vvvvvzg);

	var datatype_vvvvvzh = jQuery("#jform_datatype").val();
	vvvvvzh(datatype_vvvvvzh);

	var datatype_vvvvvzi = jQuery("#jform_datatype").val();
	vvvvvzi(datatype_vvvvvzi);

	var store_vvvvvzj = jQuery("#jform_store").val();
	var datatype_vvvvvzj = jQuery("#jform_datatype").val();
	vvvvvzj(store_vvvvvzj,datatype_vvvvvzj);

	var add_css_view_vvvvvzl = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzl(add_css_view_vvvvvzl);

	var add_css_views_vvvvvzm = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvzm(add_css_views_vvvvvzm);

	var add_javascript_view_footer_vvvvvzn = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzn(add_javascript_view_footer_vvvvvzn);

	var add_javascript_views_footer_vvvvvzo = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzo(add_javascript_views_footer_vvvvvzo);
});

// the vvvvvzf function
function vvvvvzf(datalenght_vvvvvzf)
{
	if (isSet(datalenght_vvvvvzf) && datalenght_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = datalenght_vvvvvzf;
		var datalenght_vvvvvzf = [];
		datalenght_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(datalenght_vvvvvzf))
	{
		var datalenght_vvvvvzf = [];
	}
	var datalenght = datalenght_vvvvvzf.some(datalenght_vvvvvzf_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvzfvzd_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvzfvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvzfvzd_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvzfvzd_required = true;
		}
	}
}

// the vvvvvzf Some function
function datalenght_vvvvvzf_SomeFunc(datalenght_vvvvvzf)
{
	// set the function logic
	if (datalenght_vvvvvzf == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzg function
function vvvvvzg(datadefault_vvvvvzg)
{
	if (isSet(datadefault_vvvvvzg) && datadefault_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = datadefault_vvvvvzg;
		var datadefault_vvvvvzg = [];
		datadefault_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(datadefault_vvvvvzg))
	{
		var datadefault_vvvvvzg = [];
	}
	var datadefault = datadefault_vvvvvzg.some(datadefault_vvvvvzg_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvzgvze_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvzgvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvzgvze_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvzgvze_required = true;
		}
	}
}

// the vvvvvzg Some function
function datadefault_vvvvvzg_SomeFunc(datadefault_vvvvvzg)
{
	// set the function logic
	if (datadefault_vvvvvzg == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzh function
function vvvvvzh(datatype_vvvvvzh)
{
	if (isSet(datatype_vvvvvzh) && datatype_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = datatype_vvvvvzh;
		var datatype_vvvvvzh = [];
		datatype_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(datatype_vvvvvzh))
	{
		var datatype_vvvvvzh = [];
	}
	var datatype = datatype_vvvvvzh.some(datatype_vvvvvzh_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzhvzf_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzhvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzhvzf_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzhvzf_required = true;
		}
	}
}

// the vvvvvzh Some function
function datatype_vvvvvzh_SomeFunc(datatype_vvvvvzh)
{
	// set the function logic
	if (datatype_vvvvvzh == 'CHAR' || datatype_vvvvvzh == 'VARCHAR' || datatype_vvvvvzh == 'DATETIME' || datatype_vvvvvzh == 'DATE' || datatype_vvvvvzh == 'TIME' || datatype_vvvvvzh == 'INT' || datatype_vvvvvzh == 'TINYINT' || datatype_vvvvvzh == 'BIGINT' || datatype_vvvvvzh == 'FLOAT' || datatype_vvvvvzh == 'DECIMAL' || datatype_vvvvvzh == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvvzi function
function vvvvvzi(datatype_vvvvvzi)
{
	if (isSet(datatype_vvvvvzi) && datatype_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = datatype_vvvvvzi;
		var datatype_vvvvvzi = [];
		datatype_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(datatype_vvvvvzi))
	{
		var datatype_vvvvvzi = [];
	}
	var datatype = datatype_vvvvvzi.some(datatype_vvvvvzi_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzivzg_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzivzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzivzg_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzivzg_required = true;
		}
	}
}

// the vvvvvzi Some function
function datatype_vvvvvzi_SomeFunc(datatype_vvvvvzi)
{
	// set the function logic
	if (datatype_vvvvvzi == 'CHAR' || datatype_vvvvvzi == 'VARCHAR' || datatype_vvvvvzi == 'TEXT' || datatype_vvvvvzi == 'MEDIUMTEXT' || datatype_vvvvvzi == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzj function
function vvvvvzj(store_vvvvvzj,datatype_vvvvvzj)
{
	if (isSet(store_vvvvvzj) && store_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = store_vvvvvzj;
		var store_vvvvvzj = [];
		store_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(store_vvvvvzj))
	{
		var store_vvvvvzj = [];
	}
	var store = store_vvvvvzj.some(store_vvvvvzj_SomeFunc);

	if (isSet(datatype_vvvvvzj) && datatype_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = datatype_vvvvvzj;
		var datatype_vvvvvzj = [];
		datatype_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(datatype_vvvvvzj))
	{
		var datatype_vvvvvzj = [];
	}
	var datatype = datatype_vvvvvzj.some(datatype_vvvvvzj_SomeFunc);


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

// the vvvvvzj Some function
function store_vvvvvzj_SomeFunc(store_vvvvvzj)
{
	// set the function logic
	if (store_vvvvvzj == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzj Some function
function datatype_vvvvvzj_SomeFunc(datatype_vvvvvzj)
{
	// set the function logic
	if (datatype_vvvvvzj == 'CHAR' || datatype_vvvvvzj == 'VARCHAR' || datatype_vvvvvzj == 'TEXT' || datatype_vvvvvzj == 'MEDIUMTEXT' || datatype_vvvvvzj == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzl function
function vvvvvzl(add_css_view_vvvvvzl)
{
	// set the function logic
	if (add_css_view_vvvvvzl == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvzlvzh_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvzlvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvzlvzh_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvzlvzh_required = true;
		}
	}
}

// the vvvvvzm function
function vvvvvzm(add_css_views_vvvvvzm)
{
	// set the function logic
	if (add_css_views_vvvvvzm == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzmvzi_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzmvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzmvzi_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzmvzi_required = true;
		}
	}
}

// the vvvvvzn function
function vvvvvzn(add_javascript_view_footer_vvvvvzn)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzn == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvznvzj_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvznvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvznvzj_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvznvzj_required = true;
		}
	}
}

// the vvvvvzo function
function vvvvvzo(add_javascript_views_footer_vvvvvzo)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzo == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzovzk_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzovzk_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzovzk_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzovzk_required = true;
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
