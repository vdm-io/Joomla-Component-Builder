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
jform_vvvvvzsvzn_required = false;
jform_vvvvvztvzo_required = false;
jform_vvvvvzuvzp_required = false;
jform_vvvvvzvvzq_required = false;
jform_vvvvvzyvzr_required = false;
jform_vvvvvzzvzs_required = false;
jform_vvvvwaavzt_required = false;
jform_vvvvwabvzu_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvvzs = jQuery("#jform_datalenght").val();
	vvvvvzs(datalenght_vvvvvzs);

	var datadefault_vvvvvzt = jQuery("#jform_datadefault").val();
	vvvvvzt(datadefault_vvvvvzt);

	var datatype_vvvvvzu = jQuery("#jform_datatype").val();
	vvvvvzu(datatype_vvvvvzu);

	var datatype_vvvvvzv = jQuery("#jform_datatype").val();
	vvvvvzv(datatype_vvvvvzv);

	var store_vvvvvzw = jQuery("#jform_store").val();
	var datatype_vvvvvzw = jQuery("#jform_datatype").val();
	vvvvvzw(store_vvvvvzw,datatype_vvvvvzw);

	var add_css_view_vvvvvzy = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvzy(add_css_view_vvvvvzy);

	var add_css_views_vvvvvzz = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvzz(add_css_views_vvvvvzz);

	var add_javascript_view_footer_vvvvwaa = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwaa(add_javascript_view_footer_vvvvwaa);

	var add_javascript_views_footer_vvvvwab = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwab(add_javascript_views_footer_vvvvwab);
});

// the vvvvvzs function
function vvvvvzs(datalenght_vvvvvzs)
{
	if (isSet(datalenght_vvvvvzs) && datalenght_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = datalenght_vvvvvzs;
		var datalenght_vvvvvzs = [];
		datalenght_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(datalenght_vvvvvzs))
	{
		var datalenght_vvvvvzs = [];
	}
	var datalenght = datalenght_vvvvvzs.some(datalenght_vvvvvzs_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_vvvvvzsvzn_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvvzsvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_vvvvvzsvzn_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvvzsvzn_required = true;
		}
	}
}

// the vvvvvzs Some function
function datalenght_vvvvvzs_SomeFunc(datalenght_vvvvvzs)
{
	// set the function logic
	if (datalenght_vvvvvzs == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(datadefault_vvvvvzt)
{
	if (isSet(datadefault_vvvvvzt) && datadefault_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = datadefault_vvvvvzt;
		var datadefault_vvvvvzt = [];
		datadefault_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(datadefault_vvvvvzt))
	{
		var datadefault_vvvvvzt = [];
	}
	var datadefault = datadefault_vvvvvzt.some(datadefault_vvvvvzt_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_vvvvvztvzo_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvvztvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_vvvvvztvzo_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvvztvzo_required = true;
		}
	}
}

// the vvvvvzt Some function
function datadefault_vvvvvzt_SomeFunc(datadefault_vvvvvzt)
{
	// set the function logic
	if (datadefault_vvvvvzt == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvvzu function
function vvvvvzu(datatype_vvvvvzu)
{
	if (isSet(datatype_vvvvvzu) && datatype_vvvvvzu.constructor !== Array)
	{
		var temp_vvvvvzu = datatype_vvvvvzu;
		var datatype_vvvvvzu = [];
		datatype_vvvvvzu.push(temp_vvvvvzu);
	}
	else if (!isSet(datatype_vvvvvzu))
	{
		var datatype_vvvvvzu = [];
	}
	var datatype = datatype_vvvvvzu.some(datatype_vvvvvzu_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		if (jform_vvvvvzuvzp_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvvzuvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		if (!jform_vvvvvzuvzp_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvvzuvzp_required = true;
		}
	}
}

// the vvvvvzu Some function
function datatype_vvvvvzu_SomeFunc(datatype_vvvvvzu)
{
	// set the function logic
	if (datatype_vvvvvzu == 'CHAR' || datatype_vvvvvzu == 'VARCHAR' || datatype_vvvvvzu == 'DATETIME' || datatype_vvvvvzu == 'DATE' || datatype_vvvvvzu == 'TIME' || datatype_vvvvvzu == 'INT' || datatype_vvvvvzu == 'TINYINT' || datatype_vvvvvzu == 'BIGINT' || datatype_vvvvvzu == 'FLOAT' || datatype_vvvvvzu == 'DECIMAL' || datatype_vvvvvzu == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvvzv function
function vvvvvzv(datatype_vvvvvzv)
{
	if (isSet(datatype_vvvvvzv) && datatype_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = datatype_vvvvvzv;
		var datatype_vvvvvzv = [];
		datatype_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(datatype_vvvvvzv))
	{
		var datatype_vvvvvzv = [];
	}
	var datatype = datatype_vvvvvzv.some(datatype_vvvvvzv_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_vvvvvzvvzq_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvvzvvzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_vvvvvzvvzq_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvvzvvzq_required = true;
		}
	}
}

// the vvvvvzv Some function
function datatype_vvvvvzv_SomeFunc(datatype_vvvvvzv)
{
	// set the function logic
	if (datatype_vvvvvzv == 'CHAR' || datatype_vvvvvzv == 'VARCHAR' || datatype_vvvvvzv == 'TEXT' || datatype_vvvvvzv == 'MEDIUMTEXT' || datatype_vvvvvzv == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzw function
function vvvvvzw(store_vvvvvzw,datatype_vvvvvzw)
{
	if (isSet(store_vvvvvzw) && store_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = store_vvvvvzw;
		var store_vvvvvzw = [];
		store_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(store_vvvvvzw))
	{
		var store_vvvvvzw = [];
	}
	var store = store_vvvvvzw.some(store_vvvvvzw_SomeFunc);

	if (isSet(datatype_vvvvvzw) && datatype_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = datatype_vvvvvzw;
		var datatype_vvvvvzw = [];
		datatype_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(datatype_vvvvvzw))
	{
		var datatype_vvvvvzw = [];
	}
	var datatype = datatype_vvvvvzw.some(datatype_vvvvvzw_SomeFunc);


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

// the vvvvvzw Some function
function store_vvvvvzw_SomeFunc(store_vvvvvzw)
{
	// set the function logic
	if (store_vvvvvzw == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzw Some function
function datatype_vvvvvzw_SomeFunc(datatype_vvvvvzw)
{
	// set the function logic
	if (datatype_vvvvvzw == 'CHAR' || datatype_vvvvvzw == 'VARCHAR' || datatype_vvvvvzw == 'TEXT' || datatype_vvvvvzw == 'MEDIUMTEXT' || datatype_vvvvvzw == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the vvvvvzy function
function vvvvvzy(add_css_view_vvvvvzy)
{
	// set the function logic
	if (add_css_view_vvvvvzy == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvzyvzr_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvzyvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvzyvzr_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvzyvzr_required = true;
		}
	}
}

// the vvvvvzz function
function vvvvvzz(add_css_views_vvvvvzz)
{
	// set the function logic
	if (add_css_views_vvvvvzz == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvzzvzs_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvzzvzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvzzvzs_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvzzvzs_required = true;
		}
	}
}

// the vvvvwaa function
function vvvvwaa(add_javascript_view_footer_vvvvwaa)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwaa == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvwaavzt_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvwaavzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvwaavzt_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvwaavzt_required = true;
		}
	}
}

// the vvvvwab function
function vvvvwab(add_javascript_views_footer_vvvvwab)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwab == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvwabvzu_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvwabvzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvwabvzu_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvwabvzu_required = true;
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
