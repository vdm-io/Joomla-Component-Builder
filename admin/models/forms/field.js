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
	@build			18th February, 2016
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
jform_IZiskifsgd_required = false;
jform_eTPWHSvdeZ_required = false;
jform_UOyjMHfqBP_required = false;
jform_qFDUBGTxwl_required = false;
jform_MdXQoFJTSz_required = false;
jform_DxyulOmcli_required = false;
jform_LJMivtJwQf_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_IZiskif = jQuery("#jform_datalenght").val();
	IZiskif(datalenght_IZiskif);

	var datadefault_eTPWHSv = jQuery("#jform_datadefault").val();
	eTPWHSv(datadefault_eTPWHSv);

	var datatype_UOyjMHf = jQuery("#jform_datatype").val();
	UOyjMHf(datatype_UOyjMHf);

	var store_woOFEZP = jQuery("#jform_store").val();
	var datatype_woOFEZP = jQuery("#jform_datatype").val();
	woOFEZP(store_woOFEZP,datatype_woOFEZP);

	var add_css_view_qFDUBGT = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	qFDUBGT(add_css_view_qFDUBGT);

	var add_css_views_MdXQoFJ = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	MdXQoFJ(add_css_views_MdXQoFJ);

	var add_javascript_view_footer_DxyulOm = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	DxyulOm(add_javascript_view_footer_DxyulOm);

	var add_javascript_views_footer_LJMivtJ = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	LJMivtJ(add_javascript_views_footer_LJMivtJ);
});

// the IZiskif function
function IZiskif(datalenght_IZiskif)
{
	if (isSet(datalenght_IZiskif) && datalenght_IZiskif.constructor !== Array)
	{
		var temp_IZiskif = datalenght_IZiskif;
		var datalenght_IZiskif = [];
		datalenght_IZiskif.push(temp_IZiskif);
	}
	else if (!isSet(datalenght_IZiskif))
	{
		var datalenght_IZiskif = [];
	}
	var datalenght = datalenght_IZiskif.some(datalenght_IZiskif_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		if (jform_IZiskifsgd_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_IZiskifsgd_required = false;
		}

	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		if (!jform_IZiskifsgd_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_IZiskifsgd_required = true;
		}
	}
}

// the IZiskif Some function
function datalenght_IZiskif_SomeFunc(datalenght_IZiskif)
{
	// set the function logic
	if (datalenght_IZiskif == 'Other')
	{
		return true;
	}
	return false;
}

// the eTPWHSv function
function eTPWHSv(datadefault_eTPWHSv)
{
	if (isSet(datadefault_eTPWHSv) && datadefault_eTPWHSv.constructor !== Array)
	{
		var temp_eTPWHSv = datadefault_eTPWHSv;
		var datadefault_eTPWHSv = [];
		datadefault_eTPWHSv.push(temp_eTPWHSv);
	}
	else if (!isSet(datadefault_eTPWHSv))
	{
		var datadefault_eTPWHSv = [];
	}
	var datadefault = datadefault_eTPWHSv.some(datadefault_eTPWHSv_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		if (jform_eTPWHSvdeZ_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_eTPWHSvdeZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		if (!jform_eTPWHSvdeZ_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_eTPWHSvdeZ_required = true;
		}
	}
}

// the eTPWHSv Some function
function datadefault_eTPWHSv_SomeFunc(datadefault_eTPWHSv)
{
	// set the function logic
	if (datadefault_eTPWHSv == 'Other')
	{
		return true;
	}
	return false;
}

// the UOyjMHf function
function UOyjMHf(datatype_UOyjMHf)
{
	if (isSet(datatype_UOyjMHf) && datatype_UOyjMHf.constructor !== Array)
	{
		var temp_UOyjMHf = datatype_UOyjMHf;
		var datatype_UOyjMHf = [];
		datatype_UOyjMHf.push(temp_UOyjMHf);
	}
	else if (!isSet(datatype_UOyjMHf))
	{
		var datatype_UOyjMHf = [];
	}
	var datatype = datatype_UOyjMHf.some(datatype_UOyjMHf_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		if (jform_UOyjMHfqBP_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_UOyjMHfqBP_required = false;
		}

	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		if (!jform_UOyjMHfqBP_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_UOyjMHfqBP_required = true;
		}
	}
}

// the UOyjMHf Some function
function datatype_UOyjMHf_SomeFunc(datatype_UOyjMHf)
{
	// set the function logic
	if (datatype_UOyjMHf == 'CHAR' || datatype_UOyjMHf == 'VARCHAR' || datatype_UOyjMHf == 'TEXT' || datatype_UOyjMHf == 'MEDIUMTEXT' || datatype_UOyjMHf == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the woOFEZP function
function woOFEZP(store_woOFEZP,datatype_woOFEZP)
{
	if (isSet(store_woOFEZP) && store_woOFEZP.constructor !== Array)
	{
		var temp_woOFEZP = store_woOFEZP;
		var store_woOFEZP = [];
		store_woOFEZP.push(temp_woOFEZP);
	}
	else if (!isSet(store_woOFEZP))
	{
		var store_woOFEZP = [];
	}
	var store = store_woOFEZP.some(store_woOFEZP_SomeFunc);

	if (isSet(datatype_woOFEZP) && datatype_woOFEZP.constructor !== Array)
	{
		var temp_woOFEZP = datatype_woOFEZP;
		var datatype_woOFEZP = [];
		datatype_woOFEZP.push(temp_woOFEZP);
	}
	else if (!isSet(datatype_woOFEZP))
	{
		var datatype_woOFEZP = [];
	}
	var datatype = datatype_woOFEZP.some(datatype_woOFEZP_SomeFunc);


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

// the woOFEZP Some function
function store_woOFEZP_SomeFunc(store_woOFEZP)
{
	// set the function logic
	if (store_woOFEZP == 4)
	{
		return true;
	}
	return false;
}

// the woOFEZP Some function
function datatype_woOFEZP_SomeFunc(datatype_woOFEZP)
{
	// set the function logic
	if (datatype_woOFEZP == 'CHAR' || datatype_woOFEZP == 'VARCHAR' || datatype_woOFEZP == 'TEXT' || datatype_woOFEZP == 'MEDIUMTEXT' || datatype_woOFEZP == 'LONGTEXT')
	{
		return true;
	}
	return false;
}

// the qFDUBGT function
function qFDUBGT(add_css_view_qFDUBGT)
{
	// set the function logic
	if (add_css_view_qFDUBGT == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_qFDUBGTxwl_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_qFDUBGTxwl_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_qFDUBGTxwl_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_qFDUBGTxwl_required = true;
		}
	}
}

// the MdXQoFJ function
function MdXQoFJ(add_css_views_MdXQoFJ)
{
	// set the function logic
	if (add_css_views_MdXQoFJ == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_MdXQoFJTSz_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_MdXQoFJTSz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_MdXQoFJTSz_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_MdXQoFJTSz_required = true;
		}
	}
}

// the DxyulOm function
function DxyulOm(add_javascript_view_footer_DxyulOm)
{
	// set the function logic
	if (add_javascript_view_footer_DxyulOm == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_DxyulOmcli_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_DxyulOmcli_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_DxyulOmcli_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_DxyulOmcli_required = true;
		}
	}
}

// the LJMivtJ function
function LJMivtJ(add_javascript_views_footer_LJMivtJ)
{
	// set the function logic
	if (add_javascript_views_footer_LJMivtJ == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_LJMivtJwQf_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_LJMivtJwQf_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_LJMivtJwQf_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_LJMivtJwQf_required = true;
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
