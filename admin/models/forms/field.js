/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwcdvxn_required = false;
jform_vvvvwcevxo_required = false;
jform_vvvvwcfvxp_required = false;
jform_vvvvwcgvxq_required = false;
jform_vvvvwchvxr_required = false;
jform_vvvvwckvxs_required = false;
jform_vvvvwckvxt_required = false;
jform_vvvvwckvxu_required = false;
jform_vvvvwckvxv_required = false;
jform_vvvvwclvxw_required = false;
jform_vvvvwclvxx_required = false;
jform_vvvvwclvxy_required = false;
jform_vvvvwclvxz_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwcd = jQuery("#jform_datalenght").val();
	vvvvwcd(datalenght_vvvvwcd);

	var datadefault_vvvvwce = jQuery("#jform_datadefault").val();
	vvvvwce(datadefault_vvvvwce);

	var datatype_vvvvwcf = jQuery("#jform_datatype").val();
	vvvvwcf(datatype_vvvvwcf);

	var datatype_vvvvwcg = jQuery("#jform_datatype").val();
	vvvvwcg(datatype_vvvvwcg);

	var datatype_vvvvwch = jQuery("#jform_datatype").val();
	vvvvwch(datatype_vvvvwch);

	var store_vvvvwci = jQuery("#jform_store").val();
	var datatype_vvvvwci = jQuery("#jform_datatype").val();
	vvvvwci(store_vvvvwci,datatype_vvvvwci);

	var store_vvvvwck = jQuery("#jform_store").val();
	var datatype_vvvvwck = jQuery("#jform_datatype").val();
	vvvvwck(store_vvvvwck,datatype_vvvvwck);

	var datatype_vvvvwcl = jQuery("#jform_datatype").val();
	var store_vvvvwcl = jQuery("#jform_store").val();
	vvvvwcl(datatype_vvvvwcl,store_vvvvwcl);

	var add_css_view_vvvvwcm = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwcm(add_css_view_vvvvwcm);

	var add_css_views_vvvvwcn = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwcn(add_css_views_vvvvwcn);

	var add_javascript_view_footer_vvvvwco = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwco(add_javascript_view_footer_vvvvwco);

	var add_javascript_views_footer_vvvvwcp = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwcp(add_javascript_views_footer_vvvvwcp);
});

// the vvvvwcd function
function vvvvwcd(datalenght_vvvvwcd)
{
	if (isSet(datalenght_vvvvwcd) && datalenght_vvvvwcd.constructor !== Array)
	{
		var temp_vvvvwcd = datalenght_vvvvwcd;
		var datalenght_vvvvwcd = [];
		datalenght_vvvvwcd.push(temp_vvvvwcd);
	}
	else if (!isSet(datalenght_vvvvwcd))
	{
		var datalenght_vvvvwcd = [];
	}
	var datalenght = datalenght_vvvvwcd.some(datalenght_vvvvwcd_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwcdvxn_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwcdvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwcdvxn_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwcdvxn_required = true;
		}
	}
}

// the vvvvwcd Some function
function datalenght_vvvvwcd_SomeFunc(datalenght_vvvvwcd)
{
	// set the function logic
	if (datalenght_vvvvwcd == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwce function
function vvvvwce(datadefault_vvvvwce)
{
	if (isSet(datadefault_vvvvwce) && datadefault_vvvvwce.constructor !== Array)
	{
		var temp_vvvvwce = datadefault_vvvvwce;
		var datadefault_vvvvwce = [];
		datadefault_vvvvwce.push(temp_vvvvwce);
	}
	else if (!isSet(datadefault_vvvvwce))
	{
		var datadefault_vvvvwce = [];
	}
	var datadefault = datadefault_vvvvwce.some(datadefault_vvvvwce_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwcevxo_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwcevxo_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwcevxo_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwcevxo_required = true;
		}
	}
}

// the vvvvwce Some function
function datadefault_vvvvwce_SomeFunc(datadefault_vvvvwce)
{
	// set the function logic
	if (datadefault_vvvvwce == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwcf function
function vvvvwcf(datatype_vvvvwcf)
{
	if (isSet(datatype_vvvvwcf) && datatype_vvvvwcf.constructor !== Array)
	{
		var temp_vvvvwcf = datatype_vvvvwcf;
		var datatype_vvvvwcf = [];
		datatype_vvvvwcf.push(temp_vvvvwcf);
	}
	else if (!isSet(datatype_vvvvwcf))
	{
		var datatype_vvvvwcf = [];
	}
	var datatype = datatype_vvvvwcf.some(datatype_vvvvwcf_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcfvxp_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcfvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcfvxp_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcfvxp_required = true;
		}
	}
}

// the vvvvwcf Some function
function datatype_vvvvwcf_SomeFunc(datatype_vvvvwcf)
{
	// set the function logic
	if (datatype_vvvvwcf == 'CHAR' || datatype_vvvvwcf == 'VARCHAR' || datatype_vvvvwcf == 'DATETIME' || datatype_vvvvwcf == 'DATE' || datatype_vvvvwcf == 'TIME' || datatype_vvvvwcf == 'INT' || datatype_vvvvwcf == 'TINYINT' || datatype_vvvvwcf == 'BIGINT' || datatype_vvvvwcf == 'FLOAT' || datatype_vvvvwcf == 'DECIMAL' || datatype_vvvvwcf == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcg function
function vvvvwcg(datatype_vvvvwcg)
{
	if (isSet(datatype_vvvvwcg) && datatype_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = datatype_vvvvwcg;
		var datatype_vvvvwcg = [];
		datatype_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(datatype_vvvvwcg))
	{
		var datatype_vvvvwcg = [];
	}
	var datatype = datatype_vvvvwcg.some(datatype_vvvvwcg_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwcgvxq_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwcgvxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwcgvxq_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwcgvxq_required = true;
		}
	}
}

// the vvvvwcg Some function
function datatype_vvvvwcg_SomeFunc(datatype_vvvvwcg)
{
	// set the function logic
	if (datatype_vvvvwcg == 'CHAR' || datatype_vvvvwcg == 'VARCHAR' || datatype_vvvvwcg == 'INT' || datatype_vvvvwcg == 'TINYINT' || datatype_vvvvwcg == 'BIGINT' || datatype_vvvvwcg == 'FLOAT' || datatype_vvvvwcg == 'DECIMAL' || datatype_vvvvwcg == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwch function
function vvvvwch(datatype_vvvvwch)
{
	if (isSet(datatype_vvvvwch) && datatype_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = datatype_vvvvwch;
		var datatype_vvvvwch = [];
		datatype_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(datatype_vvvvwch))
	{
		var datatype_vvvvwch = [];
	}
	var datatype = datatype_vvvvwch.some(datatype_vvvvwch_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwchvxr_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwchvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwchvxr_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwchvxr_required = true;
		}
	}
}

// the vvvvwch Some function
function datatype_vvvvwch_SomeFunc(datatype_vvvvwch)
{
	// set the function logic
	if (datatype_vvvvwch == 'CHAR' || datatype_vvvvwch == 'VARCHAR' || datatype_vvvvwch == 'TEXT' || datatype_vvvvwch == 'MEDIUMTEXT' || datatype_vvvvwch == 'LONGTEXT' || datatype_vvvvwch == 'BLOB' || datatype_vvvvwch == 'TINYBLOB' || datatype_vvvvwch == 'MEDIUMBLOB' || datatype_vvvvwch == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwci function
function vvvvwci(store_vvvvwci,datatype_vvvvwci)
{
	if (isSet(store_vvvvwci) && store_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = store_vvvvwci;
		var store_vvvvwci = [];
		store_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(store_vvvvwci))
	{
		var store_vvvvwci = [];
	}
	var store = store_vvvvwci.some(store_vvvvwci_SomeFunc);

	if (isSet(datatype_vvvvwci) && datatype_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = datatype_vvvvwci;
		var datatype_vvvvwci = [];
		datatype_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(datatype_vvvvwci))
	{
		var datatype_vvvvwci = [];
	}
	var datatype = datatype_vvvvwci.some(datatype_vvvvwci_SomeFunc);


	// set this function logic
	if (store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwci Some function
function store_vvvvwci_SomeFunc(store_vvvvwci)
{
	// set the function logic
	if (store_vvvvwci == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwci Some function
function datatype_vvvvwci_SomeFunc(datatype_vvvvwci)
{
	// set the function logic
	if (datatype_vvvvwci == 'CHAR' || datatype_vvvvwci == 'VARCHAR' || datatype_vvvvwci == 'TEXT' || datatype_vvvvwci == 'MEDIUMTEXT' || datatype_vvvvwci == 'LONGTEXT' || datatype_vvvvwci == 'BLOB' || datatype_vvvvwci == 'TINYBLOB' || datatype_vvvvwci == 'MEDIUMBLOB' || datatype_vvvvwci == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwck function
function vvvvwck(store_vvvvwck,datatype_vvvvwck)
{
	if (isSet(store_vvvvwck) && store_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = store_vvvvwck;
		var store_vvvvwck = [];
		store_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(store_vvvvwck))
	{
		var store_vvvvwck = [];
	}
	var store = store_vvvvwck.some(store_vvvvwck_SomeFunc);

	if (isSet(datatype_vvvvwck) && datatype_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = datatype_vvvvwck;
		var datatype_vvvvwck = [];
		datatype_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(datatype_vvvvwck))
	{
		var datatype_vvvvwck = [];
	}
	var datatype = datatype_vvvvwck.some(datatype_vvvvwck_SomeFunc);


	// set this function logic
	if (store && datatype)
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').show();
		// add required attribute to initiator_on_get_model field
		if (jform_vvvvwckvxs_required)
		{
			updateFieldRequired('initiator_on_get_model',0);
			jQuery('#jform_initiator_on_get_model').prop('required','required');
			jQuery('#jform_initiator_on_get_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_get_model').addClass('required');
			jform_vvvvwckvxs_required = false;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').show();
		// add required attribute to initiator_on_save_model field
		if (jform_vvvvwckvxt_required)
		{
			updateFieldRequired('initiator_on_save_model',0);
			jQuery('#jform_initiator_on_save_model').prop('required','required');
			jQuery('#jform_initiator_on_save_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_save_model').addClass('required');
			jform_vvvvwckvxt_required = false;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').show();
		// add required attribute to on_save_model_field field
		if (jform_vvvvwckvxu_required)
		{
			updateFieldRequired('on_save_model_field',0);
			jQuery('#jform_on_save_model_field').prop('required','required');
			jQuery('#jform_on_save_model_field').attr('aria-required',true);
			jQuery('#jform_on_save_model_field').addClass('required');
			jform_vvvvwckvxu_required = false;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').show();
		jQuery('#jform_on_get_model_field').closest('.control-group').show();
		// add required attribute to on_get_model_field field
		if (jform_vvvvwckvxv_required)
		{
			updateFieldRequired('on_get_model_field',0);
			jQuery('#jform_on_get_model_field').prop('required','required');
			jQuery('#jform_on_get_model_field').attr('aria-required',true);
			jQuery('#jform_on_get_model_field').addClass('required');
			jform_vvvvwckvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_get_model field
		if (!jform_vvvvwckvxs_required)
		{
			updateFieldRequired('initiator_on_get_model',1);
			jQuery('#jform_initiator_on_get_model').removeAttr('required');
			jQuery('#jform_initiator_on_get_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_get_model').removeClass('required');
			jform_vvvvwckvxs_required = true;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_save_model field
		if (!jform_vvvvwckvxt_required)
		{
			updateFieldRequired('initiator_on_save_model',1);
			jQuery('#jform_initiator_on_save_model').removeAttr('required');
			jQuery('#jform_initiator_on_save_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_save_model').removeClass('required');
			jform_vvvvwckvxt_required = true;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').hide();
		// remove required attribute from on_save_model_field field
		if (!jform_vvvvwckvxu_required)
		{
			updateFieldRequired('on_save_model_field',1);
			jQuery('#jform_on_save_model_field').removeAttr('required');
			jQuery('#jform_on_save_model_field').removeAttr('aria-required');
			jQuery('#jform_on_save_model_field').removeClass('required');
			jform_vvvvwckvxu_required = true;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').hide();
		jQuery('#jform_on_get_model_field').closest('.control-group').hide();
		// remove required attribute from on_get_model_field field
		if (!jform_vvvvwckvxv_required)
		{
			updateFieldRequired('on_get_model_field',1);
			jQuery('#jform_on_get_model_field').removeAttr('required');
			jQuery('#jform_on_get_model_field').removeAttr('aria-required');
			jQuery('#jform_on_get_model_field').removeClass('required');
			jform_vvvvwckvxv_required = true;
		}
	}
}

// the vvvvwck Some function
function store_vvvvwck_SomeFunc(store_vvvvwck)
{
	// set the function logic
	if (store_vvvvwck == 6)
	{
		return true;
	}
	return false;
}

// the vvvvwck Some function
function datatype_vvvvwck_SomeFunc(datatype_vvvvwck)
{
	// set the function logic
	if (datatype_vvvvwck == 'CHAR' || datatype_vvvvwck == 'VARCHAR' || datatype_vvvvwck == 'TEXT' || datatype_vvvvwck == 'MEDIUMTEXT' || datatype_vvvvwck == 'LONGTEXT' || datatype_vvvvwck == 'BLOB' || datatype_vvvvwck == 'TINYBLOB' || datatype_vvvvwck == 'MEDIUMBLOB' || datatype_vvvvwck == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcl function
function vvvvwcl(datatype_vvvvwcl,store_vvvvwcl)
{
	if (isSet(datatype_vvvvwcl) && datatype_vvvvwcl.constructor !== Array)
	{
		var temp_vvvvwcl = datatype_vvvvwcl;
		var datatype_vvvvwcl = [];
		datatype_vvvvwcl.push(temp_vvvvwcl);
	}
	else if (!isSet(datatype_vvvvwcl))
	{
		var datatype_vvvvwcl = [];
	}
	var datatype = datatype_vvvvwcl.some(datatype_vvvvwcl_SomeFunc);

	if (isSet(store_vvvvwcl) && store_vvvvwcl.constructor !== Array)
	{
		var temp_vvvvwcl = store_vvvvwcl;
		var store_vvvvwcl = [];
		store_vvvvwcl.push(temp_vvvvwcl);
	}
	else if (!isSet(store_vvvvwcl))
	{
		var store_vvvvwcl = [];
	}
	var store = store_vvvvwcl.some(store_vvvvwcl_SomeFunc);


	// set this function logic
	if (datatype && store)
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').show();
		// add required attribute to initiator_on_get_model field
		if (jform_vvvvwclvxw_required)
		{
			updateFieldRequired('initiator_on_get_model',0);
			jQuery('#jform_initiator_on_get_model').prop('required','required');
			jQuery('#jform_initiator_on_get_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_get_model').addClass('required');
			jform_vvvvwclvxw_required = false;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').show();
		// add required attribute to initiator_on_save_model field
		if (jform_vvvvwclvxx_required)
		{
			updateFieldRequired('initiator_on_save_model',0);
			jQuery('#jform_initiator_on_save_model').prop('required','required');
			jQuery('#jform_initiator_on_save_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_save_model').addClass('required');
			jform_vvvvwclvxx_required = false;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').show();
		// add required attribute to on_save_model_field field
		if (jform_vvvvwclvxy_required)
		{
			updateFieldRequired('on_save_model_field',0);
			jQuery('#jform_on_save_model_field').prop('required','required');
			jQuery('#jform_on_save_model_field').attr('aria-required',true);
			jQuery('#jform_on_save_model_field').addClass('required');
			jform_vvvvwclvxy_required = false;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').show();
		jQuery('#jform_on_get_model_field').closest('.control-group').show();
		// add required attribute to on_get_model_field field
		if (jform_vvvvwclvxz_required)
		{
			updateFieldRequired('on_get_model_field',0);
			jQuery('#jform_on_get_model_field').prop('required','required');
			jQuery('#jform_on_get_model_field').attr('aria-required',true);
			jQuery('#jform_on_get_model_field').addClass('required');
			jform_vvvvwclvxz_required = false;
		}
	}
	else
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_get_model field
		if (!jform_vvvvwclvxw_required)
		{
			updateFieldRequired('initiator_on_get_model',1);
			jQuery('#jform_initiator_on_get_model').removeAttr('required');
			jQuery('#jform_initiator_on_get_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_get_model').removeClass('required');
			jform_vvvvwclvxw_required = true;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_save_model field
		if (!jform_vvvvwclvxx_required)
		{
			updateFieldRequired('initiator_on_save_model',1);
			jQuery('#jform_initiator_on_save_model').removeAttr('required');
			jQuery('#jform_initiator_on_save_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_save_model').removeClass('required');
			jform_vvvvwclvxx_required = true;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').hide();
		// remove required attribute from on_save_model_field field
		if (!jform_vvvvwclvxy_required)
		{
			updateFieldRequired('on_save_model_field',1);
			jQuery('#jform_on_save_model_field').removeAttr('required');
			jQuery('#jform_on_save_model_field').removeAttr('aria-required');
			jQuery('#jform_on_save_model_field').removeClass('required');
			jform_vvvvwclvxy_required = true;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').hide();
		jQuery('#jform_on_get_model_field').closest('.control-group').hide();
		// remove required attribute from on_get_model_field field
		if (!jform_vvvvwclvxz_required)
		{
			updateFieldRequired('on_get_model_field',1);
			jQuery('#jform_on_get_model_field').removeAttr('required');
			jQuery('#jform_on_get_model_field').removeAttr('aria-required');
			jQuery('#jform_on_get_model_field').removeClass('required');
			jform_vvvvwclvxz_required = true;
		}
	}
}

// the vvvvwcl Some function
function datatype_vvvvwcl_SomeFunc(datatype_vvvvwcl)
{
	// set the function logic
	if (datatype_vvvvwcl == 'CHAR' || datatype_vvvvwcl == 'VARCHAR' || datatype_vvvvwcl == 'TEXT' || datatype_vvvvwcl == 'MEDIUMTEXT' || datatype_vvvvwcl == 'LONGTEXT' || datatype_vvvvwcl == 'BLOB' || datatype_vvvvwcl == 'TINYBLOB' || datatype_vvvvwcl == 'MEDIUMBLOB' || datatype_vvvvwcl == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcl Some function
function store_vvvvwcl_SomeFunc(store_vvvvwcl)
{
	// set the function logic
	if (store_vvvvwcl == 6)
	{
		return true;
	}
	return false;
}

// the vvvvwcm function
function vvvvwcm(add_css_view_vvvvwcm)
{
	// set the function logic
	if (add_css_view_vvvvwcm == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvwcn function
function vvvvwcn(add_css_views_vvvvwcn)
{
	// set the function logic
	if (add_css_views_vvvvwcn == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
	}
}

// the vvvvwco function
function vvvvwco(add_javascript_view_footer_vvvvwco)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwco == 1)
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvwcp function
function vvvvwcp(add_javascript_views_footer_vvvvwcp)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwcp == 1)
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').hide();
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


jQuery(document).ready(function()
{
	// get type value
	var fieldtype = jQuery("#jform_fieldtype option:selected").val();
	getFieldOptions(fieldtype, false);
	// get the linked details
	getLinked();
	// get the validation rules
	getValidationRulesTable();
	// set button to create more fields
	addButton('validation_rule', 'validation_rules_header', 2);
	// get the field type text
	var fieldText = jQuery("#jform_fieldtype option:selected").text().toLowerCase();
	// now check if database input is needed
	dbChecker(fieldText);
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

// the options row id key
var rowIdKey = 'properties';

function getFieldOptions_server(fieldtype){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.fieldOptions&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && fieldtype > 0){
		var request = token+'=1&id='+fieldtype;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getFieldOptions(fieldtype, db){
	getFieldOptions_server(fieldtype).done(function(result) {
		if(result.subform){
			// load the list of properties
			propertiesArray = result.nameListOptions;
			// remove previous forms of exist
			jQuery('.prop_removal').remove();
			// hide notice
			jQuery('.note_select_field_type').closest('.control-group').remove();
			// append to note_filter_information class
			jQuery('.note_filter_information').closest('.control-group').prepend(result.extra);
			// append to note_filter_information class
			if(result.textarea){
				jQuery.each( result.textarea, function( i, tField ) {
					// append to note_filter_information class
					jQuery('.note_filter_information').closest('.control-group').prepend(tField);
				});
			}
			// append to note_filter_information class
			jQuery('.note_filter_information').closest('.control-group').prepend(result.subform);
			// add the watcher
			rowWatcher();
			// initialize the new form
			jQuery('div.subform-repeatable').subformRepeatable();
			// update all the list fields to only show items not selected already
			propertyDynamicSet();
			// set the field type info
			jQuery('#help').remove();
			jQuery('.helpNote').append('<div id="help">'+result.description+'<br />'+result.values_description+'</div>');
			// load the database properties if not set and defaults were found
			if (db && result.database){
				// update datatype
				jQuery('#jform_datatype').val(result.database.datatype);
				jQuery('#jform_datatype').trigger("liszt:updated");
				jQuery('#jform_datatype').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('datatype', 0);
				// update datalenght
				jQuery('#jform_datalenght').val(result.database.datalenght);
				jQuery('#jform_datalenght').trigger("liszt:updated");
				jQuery('#jform_datalenght').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('datalenght', 0);
				// load the datalenght_other if needed
				if ('Other' === result.database.datalenght){
					jQuery('#jform_datalenght_other').val(result.database.datalenght_other);
					// be sure to remove from no required
					updateFieldRequired('datalenght_other', 0);
				}
				// update datadefault
				jQuery('#jform_datadefault').val(result.database.datadefault);
				jQuery('#jform_datadefault').trigger("liszt:updated");
				jQuery('#jform_datadefault').trigger("change");
				// load the datadefault_other if needed
				if ('Other' === result.database.datadefault){
					jQuery('#jform_datadefault_other').val(result.database.datadefault_other);
					// be sure to remove from no required
					updateFieldRequired('datadefault_other', 0);
				}
				// update indexes
				jQuery('#jform_indexes').val(result.database.indexes);
				jQuery('#jform_indexes').trigger("liszt:updated");
				jQuery('#jform_indexes').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('indexes', 0);
				// update store
				jQuery('#jform_store').val(result.database.store);
				jQuery('#jform_store').trigger("liszt:updated");
				jQuery('#jform_store').trigger("change");
				// be sure to remove from no required
				updateFieldRequired('store', 0);
			}
		}
	})
}

function getFieldPropertyDesc(field, targetForm){
	// get the ID
	var id = jQuery(field).attr('id');
	// build the target array
	var target = id.split('__');
	// get property value
	var property = jQuery(field).val();
	// first check that there isn't any of this property type already set
	if (propertyIsSet(property, id, targetForm)) {
		// reset the selection
		jQuery('#'+id).val('');
		jQuery('#'+id).trigger("liszt:updated");
		// give out a notice
		jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_PROPERTY_ALREADY_SELECTED_TRY_ANOTHER'), timeout: 5000, status: 'warning', pos: 'top-center'});
		// update the values
		jQuery('#'+target[0]+'__desc').val('');
		jQuery('#'+target[0]+'__value').val('');
	} else {
		// do a dynamic update
		propertyDynamicSet();
		// get type value
		if (targetForm === 'properties') {
			var fieldtype = jQuery("#jform_fieldtype option:selected").val();
		} else {
			var fieldtype = 'extra';
		}
		getFieldPropertyDesc_server(fieldtype, property).done(function(result) {
			if(result.desc || result.value){
				// update the values
				jQuery('#'+target[0]+'__desc').val(result.desc);
				jQuery('#'+target[0]+'__value').val(result.value);
			} else {
				// update the values
				jQuery('#'+target[0]+'__desc').val(Joomla.JText._('COM_COMPONENTBUILDER_NO_DESCRIPTION_FOUND'));
				jQuery('#'+target[0]+'__value').val('');
			}
		});
	}
}

// set properties the options
propertiesArray = {};
var propertyIdRemoved;

function propertyDynamicSet() {
	propertiesAvailable = {};
	propertiesSelectedArray = {};
	propertiesTrackerArray = {};
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = rowIdKey+'_'+rowIdKey+i+'__name';
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length && propertyIdRemoved !== id_check) {
			// build the selected array
			var key =  jQuery("#"+id_check+" option:selected").val();
			var text =  jQuery("#"+id_check+" option:selected").text();
			propertiesSelectedArray[key] = text;
			// keep track of the value set
			propertiesTrackerArray[id_check] = key;
			// clear the options out
			jQuery("#"+id_check).find('option').remove().end();
		}
	}
	// trigger chosen on the list fields
	jQuery('.field_list_name_options').chosen({"disable_search_threshold":10,"search_contains":true,"allow_single_deselect":true,"placeholder_text_multiple":Joomla.JText._("COM_COMPONENTBUILDER_TYPE_OR_SELECT_SOME_OPTIONS"),"placeholder_text_single":Joomla.JText._("COM_COMPONENTBUILDER_SELECT_A_PROPERTY"),"no_results_text":Joomla.JText._("COM_COMPONENTBUILDER_NO_RESULTS_MATCH")});
	// now build the list to keep
	jQuery.each( propertiesArray, function( prop, name ) {
		if (!propertiesSelectedArray.hasOwnProperty(prop)) {
			propertiesAvailable[prop] = name;
		}
	});
	// now add the lists back
	jQuery.each( propertiesTrackerArray, function( tId, tKey ) {
		if (jQuery('#'+tId).length) {
			jQuery('#'+tId).append('<option value="'+tKey+'">'+propertiesSelectedArray[tKey]+'</option>');
			jQuery.each( propertiesAvailable, function( aKey, aValue ) {
				jQuery('#'+tId).append('<option value="'+aKey+'">'+aValue+'</option>');
			});
			jQuery('#'+tId).val(tKey);
			jQuery('#'+tId).trigger('liszt:updated');
		}
	});
}

function rowWatcher() {
	jQuery(document).on('subform-row-remove', function(event, row){
       		propertyIdRemoved = jQuery(row.innerHTML).find('.field_list_name_options').attr('id');
       		propertyDynamicSet();
	});
	jQuery(document).on('subform-row-add', function(event, row){
       		propertyDynamicSet();
	});
}

function propertyIsSet(prop, id, targetForm) {
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = targetForm+'_'+targetForm+i+'__name';
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length && id_check != id) {
			// get the property value
			var tmp = jQuery("#"+id_check+" option:selected").val();
			// now validate
			if (tmp === prop) {
				return true;
			}
		}
	}
	return false;
}

function getFieldPropertyDesc_server(fieldtype, property){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getFieldPropertyDesc&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && (fieldtype > 0 || fieldtype.length > 0)&& property.length > 0){
		var request = token+'=1&fieldtype='+fieldtype+'&property='+property;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}


function getValidationRulesTable_server(){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getValidationRulesTable&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0){
		var request = token+'=1&id=1';
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getValidationRulesTable(){
	getValidationRulesTable_server().done(function(result) {
		if(result){
			jQuery('#display_validation_rules').html(result);
		}
	});
}

function dbChecker(type){
	if ('note' === type || 'spacer' === type) {
		// update the datatype selection
		jQuery('#jform_datatype').val('').trigger('liszt:updated').change();
		jQuery('#jform_datalenght').val('').trigger('liszt:updated').change();
		jQuery('#jform_datadefault').val('').trigger('liszt:updated').change();
		jQuery('#jform_datadefault').val('').trigger('liszt:updated').change();
		jQuery('#jform_indexes').val(0).trigger('liszt:updated').change();
		jQuery('#jform_store').val(0).trigger('liszt:updated').change();
		// remove the datatype
		jQuery('#jform_datatype-lbl').closest('.control-group').hide();
		jQuery('#jform_datatype').closest('.control-group').hide();
		updateFieldRequired('datatype',1);
		jQuery('#jform_datatype').removeAttr('required');
		jQuery('#jform_datatype').removeAttr('aria-required');
		jQuery('#jform_datatype').removeClass('required');
		// remove the null selection
		jQuery('#jform_null_switch-lbl').closest('.control-group').hide();
		jQuery('#jform_null_switch').closest('.control-group').hide();
		updateFieldRequired('null_switch',1);
		jQuery('#jform_null_switch').removeAttr('required');
		jQuery('#jform_null_switch').removeAttr('aria-required');
		jQuery('#jform_null_switch').removeClass('required');
		// show notice
		jQuery('.note_no_database_settings_needed').closest('.control-group').show();
		jQuery('.note_database_settings_needed').closest('.control-group').hide();
	} else {
		// add the datatype
		jQuery('#jform_datatype-lbl').closest('.control-group').show();
		jQuery('#jform_datatype').closest('.control-group').show();
		updateFieldRequired('datatype',0);
		jQuery('#jform_datatype').prop('required','required');
		jQuery('#jform_datatype').attr('aria-required',true);
		jQuery('#jform_datatype').addClass('required');
		// add the null selection
		jQuery('#jform_null_switch-lbl').closest('.control-group').show();
		jQuery('#jform_null_switch').closest('.control-group').show();
		updateFieldRequired('null_switch',0);
		jQuery('#jform_null_switch').prop('required','required');
		jQuery('#jform_null_switch').attr('aria-required',true);
		jQuery('#jform_null_switch').addClass('required');
		// remove notice
		jQuery('.note_no_database_settings_needed').closest('.control-group').hide();
		jQuery('.note_database_settings_needed').closest('.control-group').show();
	}
}

function getLinked_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type > 0){
		var request = token+'=1&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
}

function addButton_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButton(type, where, size){
	// just to insure that default behaviour still works
	size = typeof size !== 'undefined' ? size : 1;
	addButton_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	})
}

function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getEditCustomCodeButtons(){
	// get the id
	id = jQuery("#jform_id").val();
	getEditCustomCodeButtons_server(id).done(function(result) {
		if(isObject(result)){
			jQuery.each(result, function( field, buttons ) {
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
				jQuery.each(buttons, function( name, button ) {
					jQuery(".control-customcode-buttons-"+field).append(button);
				});
			});
		}
	})
}

// check object is not empty
function isObject(obj) {
	for(var prop in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, prop)) {
			return true;
		}
	}
	return false;
} 
