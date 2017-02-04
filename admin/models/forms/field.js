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

	@version		@update number 37 of this MVC
	@build			3rd February, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		field.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzpvzk_required = false;
jform_vvvvvzqvzl_required = false;
jform_vvvvvzrvzm_required = false;
jform_vvvvvzsvzn_required = false;
jform_vvvvvzvvzo_required = false;
jform_vvvvvzwvzp_required = false;
jform_vvvvvzxvzq_required = false;
jform_vvvvvzyvzr_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvzp = jQuery("#jform_datalenght").val();
	vvvvvzp(datalenght_vvvvvzp);

	var datadefault_vvvvvzq = jQuery("#jform_datadefault").val();
	vvvvvzq(datadefault_vvvvvzq);

	var datatype_vvvvvzr = jQuery("#jform_datatype").val();
	vvvvvzr(datatype_vvvvvzr);

	var datatype_vvvvvzs = jQuery("#jform_datatype").val();
	vvvvvzs(datatype_vvvvvzs);

	var store_vvvvvzt = jQuery("#jform_store").val();
	var datatype_vvvvvzt = jQuery("#jform_datatype").val();
	vvvvvzt(store_vvvvvzt,datatype_vvvvvzt);

	var add_css_view_vvvvvzv = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzv(add_css_view_vvvvvzv);

	var add_css_views_vvvvvzw = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvzw(add_css_views_vvvvvzw);

	var add_javascript_view_footer_vvvvvzx = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvzx(add_javascript_view_footer_vvvvvzx);

	var add_javascript_views_footer_vvvvvzy = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvzy(add_javascript_views_footer_vvvvvzy);
});

// the vvvvvzp function
function vvvvvzp(datalenght_vvvvvzp)
{
	if (isSet(datalenght_vvvvvzp) && datalenght_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = datalenght_vvvvvzp;
		var datalenght_vvvvvzp = [];
		datalenght_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(datalenght_vvvvvzp))
	{
		var datalenght_vvvvvzp = [];
	}
	var datalenght = datalenght_vvvvvzp.some(datalenght_vvvvvzp_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvzpvzk_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvzpvzk_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvzpvzk_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvzpvzk_required = true;
		}
	}
}

// the vvvvvzp Some function
function datalenght_vvvvvzp_SomeFunc(datalenght_vvvvvzp)
{
	// set the function logic
	if (datalenght_vvvvvzp == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzq function
function vvvvvzq(datadefault_vvvvvzq)
{
	if (isSet(datadefault_vvvvvzq) && datadefault_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = datadefault_vvvvvzq;
		var datadefault_vvvvvzq = [];
		datadefault_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(datadefault_vvvvvzq))
	{
		var datadefault_vvvvvzq = [];
	}
	var datadefault = datadefault_vvvvvzq.some(datadefault_vvvvvzq_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvzqvzl_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvzqvzl_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvzqvzl_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvzqvzl_required = true;
		}
	}
}

// the vvvvvzq Some function
function datadefault_vvvvvzq_SomeFunc(datadefault_vvvvvzq)
{
	// set the function logic
	if (datadefault_vvvvvzq == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzr function
function vvvvvzr(datatype_vvvvvzr)
{
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
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzrvzm_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzrvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzrvzm_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzrvzm_required = true;
		}
	}
}

// the vvvvvzr Some function
function datatype_vvvvvzr_SomeFunc(datatype_vvvvvzr)
{
	// set the function logic
	if (datatype_vvvvvzr == 'CHAR' || datatype_vvvvvzr == 'VARCHAR' || datatype_vvvvvzr == 'DATETIME' || datatype_vvvvvzr == 'DATE' || datatype_vvvvvzr == 'TIME' || datatype_vvvvvzr == 'INT' || datatype_vvvvvzr == 'TINYINT' || datatype_vvvvvzr == 'BIGINT' || datatype_vvvvvzr == 'FLOAT' || datatype_vvvvvzr == 'DECIMAL' || datatype_vvvvvzr == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvvzs function
function vvvvvzs(datatype_vvvvvzs)
{
	if (isSet(datatype_vvvvvzs) && datatype_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = datatype_vvvvvzs;
		var datatype_vvvvvzs = [];
		datatype_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(datatype_vvvvvzs))
	{
		var datatype_vvvvvzs = [];
	}
	var datatype = datatype_vvvvvzs.some(datatype_vvvvvzs_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzsvzn_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzsvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzsvzn_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzsvzn_required = true;
		}
	}
}

// the vvvvvzs Some function
function datatype_vvvvvzs_SomeFunc(datatype_vvvvvzs)
{
	// set the function logic
	if (datatype_vvvvvzs == 'CHAR' || datatype_vvvvvzs == 'VARCHAR' || datatype_vvvvvzs == 'TEXT' || datatype_vvvvvzs == 'MEDIUMTEXT' || datatype_vvvvvzs == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(store_vvvvvzt,datatype_vvvvvzt)
{
	if (isSet(store_vvvvvzt) && store_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = store_vvvvvzt;
		var store_vvvvvzt = [];
		store_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(store_vvvvvzt))
	{
		var store_vvvvvzt = [];
	}
	var store = store_vvvvvzt.some(store_vvvvvzt_SomeFunc);

	if (isSet(datatype_vvvvvzt) && datatype_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = datatype_vvvvvzt;
		var datatype_vvvvvzt = [];
		datatype_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(datatype_vvvvvzt))
	{
		var datatype_vvvvvzt = [];
	}
	var datatype = datatype_vvvvvzt.some(datatype_vvvvvzt_SomeFunc);


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

// the vvvvvzt Some function
function store_vvvvvzt_SomeFunc(store_vvvvvzt)
{
	// set the function logic
	if (store_vvvvvzt == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzt Some function
function datatype_vvvvvzt_SomeFunc(datatype_vvvvvzt)
{
	// set the function logic
	if (datatype_vvvvvzt == 'CHAR' || datatype_vvvvvzt == 'VARCHAR' || datatype_vvvvvzt == 'TEXT' || datatype_vvvvvzt == 'MEDIUMTEXT' || datatype_vvvvvzt == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzv function
function vvvvvzv(add_css_view_vvvvvzv)
{
	// set the function logic
	if (add_css_view_vvvvvzv == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvzvvzo_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvzvvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvzvvzo_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvzvvzo_required = true;
		}
	}
}

// the vvvvvzw function
function vvvvvzw(add_css_views_vvvvvzw)
{
	// set the function logic
	if (add_css_views_vvvvvzw == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzwvzp_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzwvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzwvzp_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzwvzp_required = true;
		}
	}
}

// the vvvvvzx function
function vvvvvzx(add_javascript_view_footer_vvvvvzx)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvzx == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvzxvzq_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvzxvzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvzxvzq_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvzxvzq_required = true;
		}
	}
}

// the vvvvvzy function
function vvvvvzy(add_javascript_views_footer_vvvvvzy)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvzy == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvzyvzr_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvzyvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvzyvzr_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvzyvzr_required = true;
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
