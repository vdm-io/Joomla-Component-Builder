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

	@version		2.2.3
	@build			22nd November, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzmvze_required = false;
jform_vvvvvznvzf_required = false;
jform_vvvvvzovzg_required = false;
jform_vvvvvzpvzh_required = false;
jform_vvvvvzsvzi_required = false;
jform_vvvvvztvzj_required = false;
jform_vvvvvzuvzk_required = false;
jform_vvvvvzvvzl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvzm = jQuery("#jform_datalenght").val();
	vvvvvzm(datalenght_vvvvvzm);

	var datadefault_vvvvvzn = jQuery("#jform_datadefault").val();
	vvvvvzn(datadefault_vvvvvzn);

	var datatype_vvvvvzo = jQuery("#jform_datatype").val();
	vvvvvzo(datatype_vvvvvzo);

	var datatype_vvvvvzp = jQuery("#jform_datatype").val();
	vvvvvzp(datatype_vvvvvzp);

	var store_vvvvvzq = jQuery("#jform_store").val();
	var datatype_vvvvvzq = jQuery("#jform_datatype").val();
	vvvvvzq(store_vvvvvzq,datatype_vvvvvzq);

	var add_css_view_vvvvvzs = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzs(add_css_view_vvvvvzs);

	var add_css_views_vvvvvzt = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvzt(add_css_views_vvvvvzt);

	var add_javascript_view_footer_vvvvvzu = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzu(add_javascript_view_footer_vvvvvzu);

	var add_javascript_views_footer_vvvvvzv = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzv(add_javascript_views_footer_vvvvvzv);
});

// the vvvvvzm function
function vvvvvzm(datalenght_vvvvvzm)
{
	if (isSet(datalenght_vvvvvzm) && datalenght_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = datalenght_vvvvvzm;
		var datalenght_vvvvvzm = [];
		datalenght_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(datalenght_vvvvvzm))
	{
		var datalenght_vvvvvzm = [];
	}
	var datalenght = datalenght_vvvvvzm.some(datalenght_vvvvvzm_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvzmvze_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvzmvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvzmvze_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvzmvze_required = true;
		}
	}
}

// the vvvvvzm Some function
function datalenght_vvvvvzm_SomeFunc(datalenght_vvvvvzm)
{
	// set the function logic
	if (datalenght_vvvvvzm == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzn function
function vvvvvzn(datadefault_vvvvvzn)
{
	if (isSet(datadefault_vvvvvzn) && datadefault_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = datadefault_vvvvvzn;
		var datadefault_vvvvvzn = [];
		datadefault_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(datadefault_vvvvvzn))
	{
		var datadefault_vvvvvzn = [];
	}
	var datadefault = datadefault_vvvvvzn.some(datadefault_vvvvvzn_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvznvzf_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvznvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvznvzf_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvznvzf_required = true;
		}
	}
}

// the vvvvvzn Some function
function datadefault_vvvvvzn_SomeFunc(datadefault_vvvvvzn)
{
	// set the function logic
	if (datadefault_vvvvvzn == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(datatype_vvvvvzo)
{
	if (isSet(datatype_vvvvvzo) && datatype_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = datatype_vvvvvzo;
		var datatype_vvvvvzo = [];
		datatype_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(datatype_vvvvvzo))
	{
		var datatype_vvvvvzo = [];
	}
	var datatype = datatype_vvvvvzo.some(datatype_vvvvvzo_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzovzg_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzovzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzovzg_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzovzg_required = true;
		}
	}
}

// the vvvvvzo Some function
function datatype_vvvvvzo_SomeFunc(datatype_vvvvvzo)
{
	// set the function logic
	if (datatype_vvvvvzo == 'CHAR' || datatype_vvvvvzo == 'VARCHAR' || datatype_vvvvvzo == 'DATETIME' || datatype_vvvvvzo == 'DATE' || datatype_vvvvvzo == 'TIME' || datatype_vvvvvzo == 'INT' || datatype_vvvvvzo == 'TINYINT' || datatype_vvvvvzo == 'BIGINT' || datatype_vvvvvzo == 'FLOAT' || datatype_vvvvvzo == 'DECIMAL' || datatype_vvvvvzo == 'DOUBLE')
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
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzpvzh_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzpvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzpvzh_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzpvzh_required = true;
		}
	}
}

// the vvvvvzp Some function
function datatype_vvvvvzp_SomeFunc(datatype_vvvvvzp)
{
	// set the function logic
	if (datatype_vvvvvzp == 'CHAR' || datatype_vvvvvzp == 'VARCHAR' || datatype_vvvvvzp == 'TEXT' || datatype_vvvvvzp == 'MEDIUMTEXT' || datatype_vvvvvzp == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzq function
function vvvvvzq(store_vvvvvzq,datatype_vvvvvzq)
{
	if (isSet(store_vvvvvzq) && store_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = store_vvvvvzq;
		var store_vvvvvzq = [];
		store_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(store_vvvvvzq))
	{
		var store_vvvvvzq = [];
	}
	var store = store_vvvvvzq.some(store_vvvvvzq_SomeFunc);

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
	if (store && datatype)
	{
		jQuery('.note_vdm_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_vdm_encryption').closest('.control-group').hide();
	}
}

// the vvvvvzq Some function
function store_vvvvvzq_SomeFunc(store_vvvvvzq)
{
	// set the function logic
	if (store_vvvvvzq == 4)
	{
		return true;
	}
	return false;
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

// the vvvvvzs function
function vvvvvzs(add_css_view_vvvvvzs)
{
	// set the function logic
	if (add_css_view_vvvvvzs == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvzsvzi_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvzsvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvzsvzi_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvzsvzi_required = true;
		}
	}
}

// the vvvvvzt function
function vvvvvzt(add_css_views_vvvvvzt)
{
	// set the function logic
	if (add_css_views_vvvvvzt == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvztvzj_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvztvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvztvzj_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvztvzj_required = true;
		}
	}
}

// the vvvvvzu function
function vvvvvzu(add_javascript_view_footer_vvvvvzu)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzu == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzuvzk_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzuvzk_required = true;
		}
	}
}

// the vvvvvzv function
function vvvvvzv(add_javascript_views_footer_vvvvvzv)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzv == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzvvzl_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzvvzl_required = true;
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
