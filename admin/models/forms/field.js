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
jform_vvvvwczvxr_required = false;
jform_vvvvwdavxs_required = false;
jform_vvvvwdbvxt_required = false;
jform_vvvvwdcvxu_required = false;
jform_vvvvwddvxv_required = false;
jform_vvvvwdgvxw_required = false;
jform_vvvvwdgvxx_required = false;
jform_vvvvwdgvxy_required = false;
jform_vvvvwdgvxz_required = false;
jform_vvvvwdhvya_required = false;
jform_vvvvwdhvyb_required = false;
jform_vvvvwdhvyc_required = false;
jform_vvvvwdhvyd_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwcz = jQuery("#jform_datalenght").val();
	vvvvwcz(datalenght_vvvvwcz);

	var datadefault_vvvvwda = jQuery("#jform_datadefault").val();
	vvvvwda(datadefault_vvvvwda);

	var datatype_vvvvwdb = jQuery("#jform_datatype").val();
	vvvvwdb(datatype_vvvvwdb);

	var datatype_vvvvwdc = jQuery("#jform_datatype").val();
	vvvvwdc(datatype_vvvvwdc);

	var datatype_vvvvwdd = jQuery("#jform_datatype").val();
	vvvvwdd(datatype_vvvvwdd);

	var store_vvvvwde = jQuery("#jform_store").val();
	var datatype_vvvvwde = jQuery("#jform_datatype").val();
	vvvvwde(store_vvvvwde,datatype_vvvvwde);

	var store_vvvvwdg = jQuery("#jform_store").val();
	var datatype_vvvvwdg = jQuery("#jform_datatype").val();
	vvvvwdg(store_vvvvwdg,datatype_vvvvwdg);

	var datatype_vvvvwdh = jQuery("#jform_datatype").val();
	var store_vvvvwdh = jQuery("#jform_store").val();
	vvvvwdh(datatype_vvvvwdh,store_vvvvwdh);

	var add_css_view_vvvvwdi = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwdi(add_css_view_vvvvwdi);

	var add_css_views_vvvvwdj = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwdj(add_css_views_vvvvwdj);

	var add_javascript_view_footer_vvvvwdk = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwdk(add_javascript_view_footer_vvvvwdk);

	var add_javascript_views_footer_vvvvwdl = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwdl(add_javascript_views_footer_vvvvwdl);
});

// the vvvvwcz function
function vvvvwcz(datalenght_vvvvwcz)
{
	if (isSet(datalenght_vvvvwcz) && datalenght_vvvvwcz.constructor !== Array)
	{
		var temp_vvvvwcz = datalenght_vvvvwcz;
		var datalenght_vvvvwcz = [];
		datalenght_vvvvwcz.push(temp_vvvvwcz);
	}
	else if (!isSet(datalenght_vvvvwcz))
	{
		var datalenght_vvvvwcz = [];
	}
	var datalenght = datalenght_vvvvwcz.some(datalenght_vvvvwcz_SomeFunc);


	// set this function logic
	if (datalenght)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwczvxr_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwczvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwczvxr_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwczvxr_required = true;
		}
	}
}

// the vvvvwcz Some function
function datalenght_vvvvwcz_SomeFunc(datalenght_vvvvwcz)
{
	// set the function logic
	if (datalenght_vvvvwcz == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwda function
function vvvvwda(datadefault_vvvvwda)
{
	if (isSet(datadefault_vvvvwda) && datadefault_vvvvwda.constructor !== Array)
	{
		var temp_vvvvwda = datadefault_vvvvwda;
		var datadefault_vvvvwda = [];
		datadefault_vvvvwda.push(temp_vvvvwda);
	}
	else if (!isSet(datadefault_vvvvwda))
	{
		var datadefault_vvvvwda = [];
	}
	var datadefault = datadefault_vvvvwda.some(datadefault_vvvvwda_SomeFunc);


	// set this function logic
	if (datadefault)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwdavxs_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwdavxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwdavxs_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwdavxs_required = true;
		}
	}
}

// the vvvvwda Some function
function datadefault_vvvvwda_SomeFunc(datadefault_vvvvwda)
{
	// set the function logic
	if (datadefault_vvvvwda == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwdb function
function vvvvwdb(datatype_vvvvwdb)
{
	if (isSet(datatype_vvvvwdb) && datatype_vvvvwdb.constructor !== Array)
	{
		var temp_vvvvwdb = datatype_vvvvwdb;
		var datatype_vvvvwdb = [];
		datatype_vvvvwdb.push(temp_vvvvwdb);
	}
	else if (!isSet(datatype_vvvvwdb))
	{
		var datatype_vvvvwdb = [];
	}
	var datatype = datatype_vvvvwdb.some(datatype_vvvvwdb_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwdbvxt_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwdbvxt_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwdbvxt_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwdbvxt_required = true;
		}
	}
}

// the vvvvwdb Some function
function datatype_vvvvwdb_SomeFunc(datatype_vvvvwdb)
{
	// set the function logic
	if (datatype_vvvvwdb == 'CHAR' || datatype_vvvvwdb == 'VARCHAR' || datatype_vvvvwdb == 'DATETIME' || datatype_vvvvwdb == 'DATE' || datatype_vvvvwdb == 'TIME' || datatype_vvvvwdb == 'INT' || datatype_vvvvwdb == 'TINYINT' || datatype_vvvvwdb == 'BIGINT' || datatype_vvvvwdb == 'FLOAT' || datatype_vvvvwdb == 'DECIMAL' || datatype_vvvvwdb == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwdc function
function vvvvwdc(datatype_vvvvwdc)
{
	if (isSet(datatype_vvvvwdc) && datatype_vvvvwdc.constructor !== Array)
	{
		var temp_vvvvwdc = datatype_vvvvwdc;
		var datatype_vvvvwdc = [];
		datatype_vvvvwdc.push(temp_vvvvwdc);
	}
	else if (!isSet(datatype_vvvvwdc))
	{
		var datatype_vvvvwdc = [];
	}
	var datatype = datatype_vvvvwdc.some(datatype_vvvvwdc_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwdcvxu_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwdcvxu_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwdcvxu_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwdcvxu_required = true;
		}
	}
}

// the vvvvwdc Some function
function datatype_vvvvwdc_SomeFunc(datatype_vvvvwdc)
{
	// set the function logic
	if (datatype_vvvvwdc == 'CHAR' || datatype_vvvvwdc == 'VARCHAR' || datatype_vvvvwdc == 'INT' || datatype_vvvvwdc == 'TINYINT' || datatype_vvvvwdc == 'BIGINT' || datatype_vvvvwdc == 'FLOAT' || datatype_vvvvwdc == 'DECIMAL' || datatype_vvvvwdc == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwdd function
function vvvvwdd(datatype_vvvvwdd)
{
	if (isSet(datatype_vvvvwdd) && datatype_vvvvwdd.constructor !== Array)
	{
		var temp_vvvvwdd = datatype_vvvvwdd;
		var datatype_vvvvwdd = [];
		datatype_vvvvwdd.push(temp_vvvvwdd);
	}
	else if (!isSet(datatype_vvvvwdd))
	{
		var datatype_vvvvwdd = [];
	}
	var datatype = datatype_vvvvwdd.some(datatype_vvvvwdd_SomeFunc);


	// set this function logic
	if (datatype)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwddvxv_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwddvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwddvxv_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwddvxv_required = true;
		}
	}
}

// the vvvvwdd Some function
function datatype_vvvvwdd_SomeFunc(datatype_vvvvwdd)
{
	// set the function logic
	if (datatype_vvvvwdd == 'CHAR' || datatype_vvvvwdd == 'VARCHAR' || datatype_vvvvwdd == 'TEXT' || datatype_vvvvwdd == 'MEDIUMTEXT' || datatype_vvvvwdd == 'LONGTEXT' || datatype_vvvvwdd == 'BLOB' || datatype_vvvvwdd == 'TINYBLOB' || datatype_vvvvwdd == 'MEDIUMBLOB' || datatype_vvvvwdd == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwde function
function vvvvwde(store_vvvvwde,datatype_vvvvwde)
{
	if (isSet(store_vvvvwde) && store_vvvvwde.constructor !== Array)
	{
		var temp_vvvvwde = store_vvvvwde;
		var store_vvvvwde = [];
		store_vvvvwde.push(temp_vvvvwde);
	}
	else if (!isSet(store_vvvvwde))
	{
		var store_vvvvwde = [];
	}
	var store = store_vvvvwde.some(store_vvvvwde_SomeFunc);

	if (isSet(datatype_vvvvwde) && datatype_vvvvwde.constructor !== Array)
	{
		var temp_vvvvwde = datatype_vvvvwde;
		var datatype_vvvvwde = [];
		datatype_vvvvwde.push(temp_vvvvwde);
	}
	else if (!isSet(datatype_vvvvwde))
	{
		var datatype_vvvvwde = [];
	}
	var datatype = datatype_vvvvwde.some(datatype_vvvvwde_SomeFunc);


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

// the vvvvwde Some function
function store_vvvvwde_SomeFunc(store_vvvvwde)
{
	// set the function logic
	if (store_vvvvwde == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwde Some function
function datatype_vvvvwde_SomeFunc(datatype_vvvvwde)
{
	// set the function logic
	if (datatype_vvvvwde == 'CHAR' || datatype_vvvvwde == 'VARCHAR' || datatype_vvvvwde == 'TEXT' || datatype_vvvvwde == 'MEDIUMTEXT' || datatype_vvvvwde == 'LONGTEXT' || datatype_vvvvwde == 'BLOB' || datatype_vvvvwde == 'TINYBLOB' || datatype_vvvvwde == 'MEDIUMBLOB' || datatype_vvvvwde == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdg function
function vvvvwdg(store_vvvvwdg,datatype_vvvvwdg)
{
	if (isSet(store_vvvvwdg) && store_vvvvwdg.constructor !== Array)
	{
		var temp_vvvvwdg = store_vvvvwdg;
		var store_vvvvwdg = [];
		store_vvvvwdg.push(temp_vvvvwdg);
	}
	else if (!isSet(store_vvvvwdg))
	{
		var store_vvvvwdg = [];
	}
	var store = store_vvvvwdg.some(store_vvvvwdg_SomeFunc);

	if (isSet(datatype_vvvvwdg) && datatype_vvvvwdg.constructor !== Array)
	{
		var temp_vvvvwdg = datatype_vvvvwdg;
		var datatype_vvvvwdg = [];
		datatype_vvvvwdg.push(temp_vvvvwdg);
	}
	else if (!isSet(datatype_vvvvwdg))
	{
		var datatype_vvvvwdg = [];
	}
	var datatype = datatype_vvvvwdg.some(datatype_vvvvwdg_SomeFunc);


	// set this function logic
	if (store && datatype)
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').show();
		// add required attribute to initiator_on_get_model field
		if (jform_vvvvwdgvxw_required)
		{
			updateFieldRequired('initiator_on_get_model',0);
			jQuery('#jform_initiator_on_get_model').prop('required','required');
			jQuery('#jform_initiator_on_get_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_get_model').addClass('required');
			jform_vvvvwdgvxw_required = false;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').show();
		// add required attribute to initiator_on_save_model field
		if (jform_vvvvwdgvxx_required)
		{
			updateFieldRequired('initiator_on_save_model',0);
			jQuery('#jform_initiator_on_save_model').prop('required','required');
			jQuery('#jform_initiator_on_save_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_save_model').addClass('required');
			jform_vvvvwdgvxx_required = false;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').show();
		// add required attribute to on_save_model_field field
		if (jform_vvvvwdgvxy_required)
		{
			updateFieldRequired('on_save_model_field',0);
			jQuery('#jform_on_save_model_field').prop('required','required');
			jQuery('#jform_on_save_model_field').attr('aria-required',true);
			jQuery('#jform_on_save_model_field').addClass('required');
			jform_vvvvwdgvxy_required = false;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').show();
		jQuery('#jform_on_get_model_field').closest('.control-group').show();
		// add required attribute to on_get_model_field field
		if (jform_vvvvwdgvxz_required)
		{
			updateFieldRequired('on_get_model_field',0);
			jQuery('#jform_on_get_model_field').prop('required','required');
			jQuery('#jform_on_get_model_field').attr('aria-required',true);
			jQuery('#jform_on_get_model_field').addClass('required');
			jform_vvvvwdgvxz_required = false;
		}
	}
	else
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_get_model field
		if (!jform_vvvvwdgvxw_required)
		{
			updateFieldRequired('initiator_on_get_model',1);
			jQuery('#jform_initiator_on_get_model').removeAttr('required');
			jQuery('#jform_initiator_on_get_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_get_model').removeClass('required');
			jform_vvvvwdgvxw_required = true;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_save_model field
		if (!jform_vvvvwdgvxx_required)
		{
			updateFieldRequired('initiator_on_save_model',1);
			jQuery('#jform_initiator_on_save_model').removeAttr('required');
			jQuery('#jform_initiator_on_save_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_save_model').removeClass('required');
			jform_vvvvwdgvxx_required = true;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').hide();
		// remove required attribute from on_save_model_field field
		if (!jform_vvvvwdgvxy_required)
		{
			updateFieldRequired('on_save_model_field',1);
			jQuery('#jform_on_save_model_field').removeAttr('required');
			jQuery('#jform_on_save_model_field').removeAttr('aria-required');
			jQuery('#jform_on_save_model_field').removeClass('required');
			jform_vvvvwdgvxy_required = true;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').hide();
		jQuery('#jform_on_get_model_field').closest('.control-group').hide();
		// remove required attribute from on_get_model_field field
		if (!jform_vvvvwdgvxz_required)
		{
			updateFieldRequired('on_get_model_field',1);
			jQuery('#jform_on_get_model_field').removeAttr('required');
			jQuery('#jform_on_get_model_field').removeAttr('aria-required');
			jQuery('#jform_on_get_model_field').removeClass('required');
			jform_vvvvwdgvxz_required = true;
		}
	}
}

// the vvvvwdg Some function
function store_vvvvwdg_SomeFunc(store_vvvvwdg)
{
	// set the function logic
	if (store_vvvvwdg == 6)
	{
		return true;
	}
	return false;
}

// the vvvvwdg Some function
function datatype_vvvvwdg_SomeFunc(datatype_vvvvwdg)
{
	// set the function logic
	if (datatype_vvvvwdg == 'CHAR' || datatype_vvvvwdg == 'VARCHAR' || datatype_vvvvwdg == 'TEXT' || datatype_vvvvwdg == 'MEDIUMTEXT' || datatype_vvvvwdg == 'LONGTEXT' || datatype_vvvvwdg == 'BLOB' || datatype_vvvvwdg == 'TINYBLOB' || datatype_vvvvwdg == 'MEDIUMBLOB' || datatype_vvvvwdg == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdh function
function vvvvwdh(datatype_vvvvwdh,store_vvvvwdh)
{
	if (isSet(datatype_vvvvwdh) && datatype_vvvvwdh.constructor !== Array)
	{
		var temp_vvvvwdh = datatype_vvvvwdh;
		var datatype_vvvvwdh = [];
		datatype_vvvvwdh.push(temp_vvvvwdh);
	}
	else if (!isSet(datatype_vvvvwdh))
	{
		var datatype_vvvvwdh = [];
	}
	var datatype = datatype_vvvvwdh.some(datatype_vvvvwdh_SomeFunc);

	if (isSet(store_vvvvwdh) && store_vvvvwdh.constructor !== Array)
	{
		var temp_vvvvwdh = store_vvvvwdh;
		var store_vvvvwdh = [];
		store_vvvvwdh.push(temp_vvvvwdh);
	}
	else if (!isSet(store_vvvvwdh))
	{
		var store_vvvvwdh = [];
	}
	var store = store_vvvvwdh.some(store_vvvvwdh_SomeFunc);


	// set this function logic
	if (datatype && store)
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').show();
		// add required attribute to initiator_on_get_model field
		if (jform_vvvvwdhvya_required)
		{
			updateFieldRequired('initiator_on_get_model',0);
			jQuery('#jform_initiator_on_get_model').prop('required','required');
			jQuery('#jform_initiator_on_get_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_get_model').addClass('required');
			jform_vvvvwdhvya_required = false;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').show();
		// add required attribute to initiator_on_save_model field
		if (jform_vvvvwdhvyb_required)
		{
			updateFieldRequired('initiator_on_save_model',0);
			jQuery('#jform_initiator_on_save_model').prop('required','required');
			jQuery('#jform_initiator_on_save_model').attr('aria-required',true);
			jQuery('#jform_initiator_on_save_model').addClass('required');
			jform_vvvvwdhvyb_required = false;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').show();
		// add required attribute to on_save_model_field field
		if (jform_vvvvwdhvyc_required)
		{
			updateFieldRequired('on_save_model_field',0);
			jQuery('#jform_on_save_model_field').prop('required','required');
			jQuery('#jform_on_save_model_field').attr('aria-required',true);
			jQuery('#jform_on_save_model_field').addClass('required');
			jform_vvvvwdhvyc_required = false;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').show();
		jQuery('#jform_on_get_model_field').closest('.control-group').show();
		// add required attribute to on_get_model_field field
		if (jform_vvvvwdhvyd_required)
		{
			updateFieldRequired('on_get_model_field',0);
			jQuery('#jform_on_get_model_field').prop('required','required');
			jQuery('#jform_on_get_model_field').attr('aria-required',true);
			jQuery('#jform_on_get_model_field').addClass('required');
			jform_vvvvwdhvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_initiator_on_get_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_get_model field
		if (!jform_vvvvwdhvya_required)
		{
			updateFieldRequired('initiator_on_get_model',1);
			jQuery('#jform_initiator_on_get_model').removeAttr('required');
			jQuery('#jform_initiator_on_get_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_get_model').removeClass('required');
			jform_vvvvwdhvya_required = true;
		}
		jQuery('#jform_initiator_on_save_model').closest('.control-group').hide();
		// remove required attribute from initiator_on_save_model field
		if (!jform_vvvvwdhvyb_required)
		{
			updateFieldRequired('initiator_on_save_model',1);
			jQuery('#jform_initiator_on_save_model').removeAttr('required');
			jQuery('#jform_initiator_on_save_model').removeAttr('aria-required');
			jQuery('#jform_initiator_on_save_model').removeClass('required');
			jform_vvvvwdhvyb_required = true;
		}
		jQuery('#jform_on_save_model_field').closest('.control-group').hide();
		// remove required attribute from on_save_model_field field
		if (!jform_vvvvwdhvyc_required)
		{
			updateFieldRequired('on_save_model_field',1);
			jQuery('#jform_on_save_model_field').removeAttr('required');
			jQuery('#jform_on_save_model_field').removeAttr('aria-required');
			jQuery('#jform_on_save_model_field').removeClass('required');
			jform_vvvvwdhvyc_required = true;
		}
		jQuery('.note_expert_field_save_mode').closest('.control-group').hide();
		jQuery('#jform_on_get_model_field').closest('.control-group').hide();
		// remove required attribute from on_get_model_field field
		if (!jform_vvvvwdhvyd_required)
		{
			updateFieldRequired('on_get_model_field',1);
			jQuery('#jform_on_get_model_field').removeAttr('required');
			jQuery('#jform_on_get_model_field').removeAttr('aria-required');
			jQuery('#jform_on_get_model_field').removeClass('required');
			jform_vvvvwdhvyd_required = true;
		}
	}
}

// the vvvvwdh Some function
function datatype_vvvvwdh_SomeFunc(datatype_vvvvwdh)
{
	// set the function logic
	if (datatype_vvvvwdh == 'CHAR' || datatype_vvvvwdh == 'VARCHAR' || datatype_vvvvwdh == 'TEXT' || datatype_vvvvwdh == 'MEDIUMTEXT' || datatype_vvvvwdh == 'LONGTEXT' || datatype_vvvvwdh == 'BLOB' || datatype_vvvvwdh == 'TINYBLOB' || datatype_vvvvwdh == 'MEDIUMBLOB' || datatype_vvvvwdh == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdh Some function
function store_vvvvwdh_SomeFunc(store_vvvvwdh)
{
	// set the function logic
	if (store_vvvvwdh == 6)
	{
		return true;
	}
	return false;
}

// the vvvvwdi function
function vvvvwdi(add_css_view_vvvvwdi)
{
	// set the function logic
	if (add_css_view_vvvvwdi == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvwdj function
function vvvvwdj(add_css_views_vvvvwdj)
{
	// set the function logic
	if (add_css_views_vvvvwdj == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
	}
}

// the vvvvwdk function
function vvvvwdk(add_javascript_view_footer_vvvvwdk)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvwdk == 1)
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvwdl function
function vvvvwdl(add_javascript_views_footer_vvvvwdl)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvwdl == 1)
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

function getFieldOptions(fieldtype, db){
	getCodeFrom_server(fieldtype, 'type', 'type', 'fieldOptions').done(function(result) {
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
	if(token.length > 0 && (fieldtype > 0 || fieldtype.length > 0) && property.length > 0){
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

function getValidationRulesTable(){
	getCodeFrom_server(1,'type','type', 'getValidationRulesTable').done(function(result) {
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

function getCodeFrom_server(id, type, type_name, callingName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0 && type.length > 0) {
		var request = token + '=1&' + type_name + '=' + type + '&id=' + id;
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
	getCodeFrom_server(1, 'type', 'type', 'getLinked').done(function(result) {
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
