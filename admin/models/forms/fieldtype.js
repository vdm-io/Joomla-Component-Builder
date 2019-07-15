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
jform_vvvvwbhvxl_required = false;
jform_vvvvwbjvxm_required = false;
jform_vvvvwblvxn_required = false;
jform_vvvvwbmvxo_required = false;
jform_vvvvwbnvxp_required = false;
jform_vvvvwbsvxq_required = false;
jform_vvvvwbsvxr_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwbh = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbh = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbh(datalenght_vvvvwbh,has_defaults_vvvvwbh);

	var datadefault_vvvvwbj = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datadefault_vvvvwbj,has_defaults_vvvvwbj);

	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbl(datatype_vvvvwbl,has_defaults_vvvvwbl);

	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbm = jQuery("#jform_datatype").val();
	vvvvwbm(has_defaults_vvvvwbm,datatype_vvvvwbm);

	var datatype_vvvvwbn = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbn = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbn(datatype_vvvvwbn,has_defaults_vvvvwbn);

	var store_vvvvwbp = jQuery("#jform_store").val();
	var datatype_vvvvwbp = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbp(store_vvvvwbp,datatype_vvvvwbp,has_defaults_vvvvwbp);

	var datatype_vvvvwbq = jQuery("#jform_datatype").val();
	var store_vvvvwbq = jQuery("#jform_store").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datatype_vvvvwbq,store_vvvvwbq,has_defaults_vvvvwbq);

	var has_defaults_vvvvwbr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbr = jQuery("#jform_store").val();
	var datatype_vvvvwbr = jQuery("#jform_datatype").val();
	vvvvwbr(has_defaults_vvvvwbr,store_vvvvwbr,datatype_vvvvwbr);

	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(has_defaults_vvvvwbs);
});

// the vvvvwbh function
function vvvvwbh(datalenght_vvvvwbh,has_defaults_vvvvwbh)
{
	if (isSet(datalenght_vvvvwbh) && datalenght_vvvvwbh.constructor !== Array)
	{
		var temp_vvvvwbh = datalenght_vvvvwbh;
		var datalenght_vvvvwbh = [];
		datalenght_vvvvwbh.push(temp_vvvvwbh);
	}
	else if (!isSet(datalenght_vvvvwbh))
	{
		var datalenght_vvvvwbh = [];
	}
	var datalenght = datalenght_vvvvwbh.some(datalenght_vvvvwbh_SomeFunc);

	if (isSet(has_defaults_vvvvwbh) && has_defaults_vvvvwbh.constructor !== Array)
	{
		var temp_vvvvwbh = has_defaults_vvvvwbh;
		var has_defaults_vvvvwbh = [];
		has_defaults_vvvvwbh.push(temp_vvvvwbh);
	}
	else if (!isSet(has_defaults_vvvvwbh))
	{
		var has_defaults_vvvvwbh = [];
	}
	var has_defaults = has_defaults_vvvvwbh.some(has_defaults_vvvvwbh_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbhvxl_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbhvxl_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbhvxl_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbhvxl_required = true;
		}
	}
}

// the vvvvwbh Some function
function datalenght_vvvvwbh_SomeFunc(datalenght_vvvvwbh)
{
	// set the function logic
	if (datalenght_vvvvwbh == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbh Some function
function has_defaults_vvvvwbh_SomeFunc(has_defaults_vvvvwbh)
{
	// set the function logic
	if (has_defaults_vvvvwbh == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbj function
function vvvvwbj(datadefault_vvvvwbj,has_defaults_vvvvwbj)
{
	if (isSet(datadefault_vvvvwbj) && datadefault_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = datadefault_vvvvwbj;
		var datadefault_vvvvwbj = [];
		datadefault_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(datadefault_vvvvwbj))
	{
		var datadefault_vvvvwbj = [];
	}
	var datadefault = datadefault_vvvvwbj.some(datadefault_vvvvwbj_SomeFunc);

	if (isSet(has_defaults_vvvvwbj) && has_defaults_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = has_defaults_vvvvwbj;
		var has_defaults_vvvvwbj = [];
		has_defaults_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(has_defaults_vvvvwbj))
	{
		var has_defaults_vvvvwbj = [];
	}
	var has_defaults = has_defaults_vvvvwbj.some(has_defaults_vvvvwbj_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbjvxm_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbjvxm_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbjvxm_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbjvxm_required = true;
		}
	}
}

// the vvvvwbj Some function
function datadefault_vvvvwbj_SomeFunc(datadefault_vvvvwbj)
{
	// set the function logic
	if (datadefault_vvvvwbj == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbj Some function
function has_defaults_vvvvwbj_SomeFunc(has_defaults_vvvvwbj)
{
	// set the function logic
	if (has_defaults_vvvvwbj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbl function
function vvvvwbl(datatype_vvvvwbl,has_defaults_vvvvwbl)
{
	if (isSet(datatype_vvvvwbl) && datatype_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = datatype_vvvvwbl;
		var datatype_vvvvwbl = [];
		datatype_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(datatype_vvvvwbl))
	{
		var datatype_vvvvwbl = [];
	}
	var datatype = datatype_vvvvwbl.some(datatype_vvvvwbl_SomeFunc);

	if (isSet(has_defaults_vvvvwbl) && has_defaults_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = has_defaults_vvvvwbl;
		var has_defaults_vvvvwbl = [];
		has_defaults_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(has_defaults_vvvvwbl))
	{
		var has_defaults_vvvvwbl = [];
	}
	var has_defaults = has_defaults_vvvvwbl.some(has_defaults_vvvvwbl_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwblvxn_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwblvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwblvxn_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwblvxn_required = true;
		}
	}
}

// the vvvvwbl Some function
function datatype_vvvvwbl_SomeFunc(datatype_vvvvwbl)
{
	// set the function logic
	if (datatype_vvvvwbl == 'CHAR' || datatype_vvvvwbl == 'VARCHAR' || datatype_vvvvwbl == 'DATETIME' || datatype_vvvvwbl == 'DATE' || datatype_vvvvwbl == 'TIME' || datatype_vvvvwbl == 'INT' || datatype_vvvvwbl == 'TINYINT' || datatype_vvvvwbl == 'BIGINT' || datatype_vvvvwbl == 'FLOAT' || datatype_vvvvwbl == 'DECIMAL' || datatype_vvvvwbl == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbl Some function
function has_defaults_vvvvwbl_SomeFunc(has_defaults_vvvvwbl)
{
	// set the function logic
	if (has_defaults_vvvvwbl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbm function
function vvvvwbm(has_defaults_vvvvwbm,datatype_vvvvwbm)
{
	if (isSet(has_defaults_vvvvwbm) && has_defaults_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = has_defaults_vvvvwbm;
		var has_defaults_vvvvwbm = [];
		has_defaults_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(has_defaults_vvvvwbm))
	{
		var has_defaults_vvvvwbm = [];
	}
	var has_defaults = has_defaults_vvvvwbm.some(has_defaults_vvvvwbm_SomeFunc);

	if (isSet(datatype_vvvvwbm) && datatype_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = datatype_vvvvwbm;
		var datatype_vvvvwbm = [];
		datatype_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(datatype_vvvvwbm))
	{
		var datatype_vvvvwbm = [];
	}
	var datatype = datatype_vvvvwbm.some(datatype_vvvvwbm_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbmvxo_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbmvxo_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbmvxo_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbmvxo_required = true;
		}
	}
}

// the vvvvwbm Some function
function has_defaults_vvvvwbm_SomeFunc(has_defaults_vvvvwbm)
{
	// set the function logic
	if (has_defaults_vvvvwbm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbm Some function
function datatype_vvvvwbm_SomeFunc(datatype_vvvvwbm)
{
	// set the function logic
	if (datatype_vvvvwbm == 'CHAR' || datatype_vvvvwbm == 'VARCHAR' || datatype_vvvvwbm == 'DATETIME' || datatype_vvvvwbm == 'DATE' || datatype_vvvvwbm == 'TIME' || datatype_vvvvwbm == 'INT' || datatype_vvvvwbm == 'TINYINT' || datatype_vvvvwbm == 'BIGINT' || datatype_vvvvwbm == 'FLOAT' || datatype_vvvvwbm == 'DECIMAL' || datatype_vvvvwbm == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(datatype_vvvvwbn,has_defaults_vvvvwbn)
{
	if (isSet(datatype_vvvvwbn) && datatype_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = datatype_vvvvwbn;
		var datatype_vvvvwbn = [];
		datatype_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(datatype_vvvvwbn))
	{
		var datatype_vvvvwbn = [];
	}
	var datatype = datatype_vvvvwbn.some(datatype_vvvvwbn_SomeFunc);

	if (isSet(has_defaults_vvvvwbn) && has_defaults_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = has_defaults_vvvvwbn;
		var has_defaults_vvvvwbn = [];
		has_defaults_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(has_defaults_vvvvwbn))
	{
		var has_defaults_vvvvwbn = [];
	}
	var has_defaults = has_defaults_vvvvwbn.some(has_defaults_vvvvwbn_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbnvxp_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbnvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbnvxp_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbnvxp_required = true;
		}
	}
}

// the vvvvwbn Some function
function datatype_vvvvwbn_SomeFunc(datatype_vvvvwbn)
{
	// set the function logic
	if (datatype_vvvvwbn == 'CHAR' || datatype_vvvvwbn == 'VARCHAR' || datatype_vvvvwbn == 'TEXT' || datatype_vvvvwbn == 'MEDIUMTEXT' || datatype_vvvvwbn == 'LONGTEXT' || datatype_vvvvwbn == 'BLOB' || datatype_vvvvwbn == 'TINYBLOB' || datatype_vvvvwbn == 'MEDIUMBLOB' || datatype_vvvvwbn == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbn Some function
function has_defaults_vvvvwbn_SomeFunc(has_defaults_vvvvwbn)
{
	// set the function logic
	if (has_defaults_vvvvwbn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbp function
function vvvvwbp(store_vvvvwbp,datatype_vvvvwbp,has_defaults_vvvvwbp)
{
	if (isSet(store_vvvvwbp) && store_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = store_vvvvwbp;
		var store_vvvvwbp = [];
		store_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(store_vvvvwbp))
	{
		var store_vvvvwbp = [];
	}
	var store = store_vvvvwbp.some(store_vvvvwbp_SomeFunc);

	if (isSet(datatype_vvvvwbp) && datatype_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = datatype_vvvvwbp;
		var datatype_vvvvwbp = [];
		datatype_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(datatype_vvvvwbp))
	{
		var datatype_vvvvwbp = [];
	}
	var datatype = datatype_vvvvwbp.some(datatype_vvvvwbp_SomeFunc);

	if (isSet(has_defaults_vvvvwbp) && has_defaults_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = has_defaults_vvvvwbp;
		var has_defaults_vvvvwbp = [];
		has_defaults_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(has_defaults_vvvvwbp))
	{
		var has_defaults_vvvvwbp = [];
	}
	var has_defaults = has_defaults_vvvvwbp.some(has_defaults_vvvvwbp_SomeFunc);


	// set this function logic
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwbp Some function
function store_vvvvwbp_SomeFunc(store_vvvvwbp)
{
	// set the function logic
	if (store_vvvvwbp == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbp Some function
function datatype_vvvvwbp_SomeFunc(datatype_vvvvwbp)
{
	// set the function logic
	if (datatype_vvvvwbp == 'CHAR' || datatype_vvvvwbp == 'VARCHAR' || datatype_vvvvwbp == 'TEXT' || datatype_vvvvwbp == 'MEDIUMTEXT' || datatype_vvvvwbp == 'LONGTEXT' || datatype_vvvvwbp == 'BLOB' || datatype_vvvvwbp == 'TINYBLOB' || datatype_vvvvwbp == 'MEDIUMBLOB' || datatype_vvvvwbp == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbp Some function
function has_defaults_vvvvwbp_SomeFunc(has_defaults_vvvvwbp)
{
	// set the function logic
	if (has_defaults_vvvvwbp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbq function
function vvvvwbq(datatype_vvvvwbq,store_vvvvwbq,has_defaults_vvvvwbq)
{
	if (isSet(datatype_vvvvwbq) && datatype_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = datatype_vvvvwbq;
		var datatype_vvvvwbq = [];
		datatype_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(datatype_vvvvwbq))
	{
		var datatype_vvvvwbq = [];
	}
	var datatype = datatype_vvvvwbq.some(datatype_vvvvwbq_SomeFunc);

	if (isSet(store_vvvvwbq) && store_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = store_vvvvwbq;
		var store_vvvvwbq = [];
		store_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(store_vvvvwbq))
	{
		var store_vvvvwbq = [];
	}
	var store = store_vvvvwbq.some(store_vvvvwbq_SomeFunc);

	if (isSet(has_defaults_vvvvwbq) && has_defaults_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = has_defaults_vvvvwbq;
		var has_defaults_vvvvwbq = [];
		has_defaults_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(has_defaults_vvvvwbq))
	{
		var has_defaults_vvvvwbq = [];
	}
	var has_defaults = has_defaults_vvvvwbq.some(has_defaults_vvvvwbq_SomeFunc);


	// set this function logic
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwbq Some function
function datatype_vvvvwbq_SomeFunc(datatype_vvvvwbq)
{
	// set the function logic
	if (datatype_vvvvwbq == 'CHAR' || datatype_vvvvwbq == 'VARCHAR' || datatype_vvvvwbq == 'TEXT' || datatype_vvvvwbq == 'MEDIUMTEXT' || datatype_vvvvwbq == 'LONGTEXT' || datatype_vvvvwbq == 'BLOB' || datatype_vvvvwbq == 'TINYBLOB' || datatype_vvvvwbq == 'MEDIUMBLOB' || datatype_vvvvwbq == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbq Some function
function store_vvvvwbq_SomeFunc(store_vvvvwbq)
{
	// set the function logic
	if (store_vvvvwbq == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbq Some function
function has_defaults_vvvvwbq_SomeFunc(has_defaults_vvvvwbq)
{
	// set the function logic
	if (has_defaults_vvvvwbq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbr function
function vvvvwbr(has_defaults_vvvvwbr,store_vvvvwbr,datatype_vvvvwbr)
{
	if (isSet(has_defaults_vvvvwbr) && has_defaults_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = has_defaults_vvvvwbr;
		var has_defaults_vvvvwbr = [];
		has_defaults_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(has_defaults_vvvvwbr))
	{
		var has_defaults_vvvvwbr = [];
	}
	var has_defaults = has_defaults_vvvvwbr.some(has_defaults_vvvvwbr_SomeFunc);

	if (isSet(store_vvvvwbr) && store_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = store_vvvvwbr;
		var store_vvvvwbr = [];
		store_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(store_vvvvwbr))
	{
		var store_vvvvwbr = [];
	}
	var store = store_vvvvwbr.some(store_vvvvwbr_SomeFunc);

	if (isSet(datatype_vvvvwbr) && datatype_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = datatype_vvvvwbr;
		var datatype_vvvvwbr = [];
		datatype_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(datatype_vvvvwbr))
	{
		var datatype_vvvvwbr = [];
	}
	var datatype = datatype_vvvvwbr.some(datatype_vvvvwbr_SomeFunc);


	// set this function logic
	if (has_defaults && store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwbr Some function
function has_defaults_vvvvwbr_SomeFunc(has_defaults_vvvvwbr)
{
	// set the function logic
	if (has_defaults_vvvvwbr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbr Some function
function store_vvvvwbr_SomeFunc(store_vvvvwbr)
{
	// set the function logic
	if (store_vvvvwbr == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbr Some function
function datatype_vvvvwbr_SomeFunc(datatype_vvvvwbr)
{
	// set the function logic
	if (datatype_vvvvwbr == 'CHAR' || datatype_vvvvwbr == 'VARCHAR' || datatype_vvvvwbr == 'TEXT' || datatype_vvvvwbr == 'MEDIUMTEXT' || datatype_vvvvwbr == 'LONGTEXT' || datatype_vvvvwbr == 'BLOB' || datatype_vvvvwbr == 'TINYBLOB' || datatype_vvvvwbr == 'MEDIUMBLOB' || datatype_vvvvwbr == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbs function
function vvvvwbs(has_defaults_vvvvwbs)
{
	// set the function logic
	if (has_defaults_vvvvwbs == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwbsvxq_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwbsvxq_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwbsvxr_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwbsvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwbsvxq_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwbsvxq_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwbsvxr_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwbsvxr_required = true;
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


jQuery(document).ready(function($)
{
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

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
