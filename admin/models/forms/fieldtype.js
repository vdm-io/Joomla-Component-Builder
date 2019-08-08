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
jform_vvvvwcdvxp_required = false;
jform_vvvvwcfvxq_required = false;
jform_vvvvwchvxr_required = false;
jform_vvvvwcivxs_required = false;
jform_vvvvwcjvxt_required = false;
jform_vvvvwcovxu_required = false;
jform_vvvvwcovxv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwcd = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwcd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcd(datalenght_vvvvwcd,has_defaults_vvvvwcd);

	var datadefault_vvvvwcf = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwcf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcf(datadefault_vvvvwcf,has_defaults_vvvvwcf);

	var datatype_vvvvwch = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwch = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwch(datatype_vvvvwch,has_defaults_vvvvwch);

	var has_defaults_vvvvwci = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwci = jQuery("#jform_datatype").val();
	vvvvwci(has_defaults_vvvvwci,datatype_vvvvwci);

	var datatype_vvvvwcj = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcj(datatype_vvvvwcj,has_defaults_vvvvwcj);

	var store_vvvvwcl = jQuery("#jform_store").val();
	var datatype_vvvvwcl = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcl(store_vvvvwcl,datatype_vvvvwcl,has_defaults_vvvvwcl);

	var datatype_vvvvwcm = jQuery("#jform_datatype").val();
	var store_vvvvwcm = jQuery("#jform_store").val();
	var has_defaults_vvvvwcm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcm(datatype_vvvvwcm,store_vvvvwcm,has_defaults_vvvvwcm);

	var has_defaults_vvvvwcn = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcn = jQuery("#jform_store").val();
	var datatype_vvvvwcn = jQuery("#jform_datatype").val();
	vvvvwcn(has_defaults_vvvvwcn,store_vvvvwcn,datatype_vvvvwcn);

	var has_defaults_vvvvwco = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwco(has_defaults_vvvvwco);
});

// the vvvvwcd function
function vvvvwcd(datalenght_vvvvwcd,has_defaults_vvvvwcd)
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

	if (isSet(has_defaults_vvvvwcd) && has_defaults_vvvvwcd.constructor !== Array)
	{
		var temp_vvvvwcd = has_defaults_vvvvwcd;
		var has_defaults_vvvvwcd = [];
		has_defaults_vvvvwcd.push(temp_vvvvwcd);
	}
	else if (!isSet(has_defaults_vvvvwcd))
	{
		var has_defaults_vvvvwcd = [];
	}
	var has_defaults = has_defaults_vvvvwcd.some(has_defaults_vvvvwcd_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwcdvxp_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwcdvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwcdvxp_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwcdvxp_required = true;
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

// the vvvvwcd Some function
function has_defaults_vvvvwcd_SomeFunc(has_defaults_vvvvwcd)
{
	// set the function logic
	if (has_defaults_vvvvwcd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcf function
function vvvvwcf(datadefault_vvvvwcf,has_defaults_vvvvwcf)
{
	if (isSet(datadefault_vvvvwcf) && datadefault_vvvvwcf.constructor !== Array)
	{
		var temp_vvvvwcf = datadefault_vvvvwcf;
		var datadefault_vvvvwcf = [];
		datadefault_vvvvwcf.push(temp_vvvvwcf);
	}
	else if (!isSet(datadefault_vvvvwcf))
	{
		var datadefault_vvvvwcf = [];
	}
	var datadefault = datadefault_vvvvwcf.some(datadefault_vvvvwcf_SomeFunc);

	if (isSet(has_defaults_vvvvwcf) && has_defaults_vvvvwcf.constructor !== Array)
	{
		var temp_vvvvwcf = has_defaults_vvvvwcf;
		var has_defaults_vvvvwcf = [];
		has_defaults_vvvvwcf.push(temp_vvvvwcf);
	}
	else if (!isSet(has_defaults_vvvvwcf))
	{
		var has_defaults_vvvvwcf = [];
	}
	var has_defaults = has_defaults_vvvvwcf.some(has_defaults_vvvvwcf_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwcfvxq_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwcfvxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwcfvxq_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwcfvxq_required = true;
		}
	}
}

// the vvvvwcf Some function
function datadefault_vvvvwcf_SomeFunc(datadefault_vvvvwcf)
{
	// set the function logic
	if (datadefault_vvvvwcf == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwcf Some function
function has_defaults_vvvvwcf_SomeFunc(has_defaults_vvvvwcf)
{
	// set the function logic
	if (has_defaults_vvvvwcf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwch function
function vvvvwch(datatype_vvvvwch,has_defaults_vvvvwch)
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

	if (isSet(has_defaults_vvvvwch) && has_defaults_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = has_defaults_vvvvwch;
		var has_defaults_vvvvwch = [];
		has_defaults_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(has_defaults_vvvvwch))
	{
		var has_defaults_vvvvwch = [];
	}
	var has_defaults = has_defaults_vvvvwch.some(has_defaults_vvvvwch_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwchvxr_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwchvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwchvxr_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwchvxr_required = true;
		}
	}
}

// the vvvvwch Some function
function datatype_vvvvwch_SomeFunc(datatype_vvvvwch)
{
	// set the function logic
	if (datatype_vvvvwch == 'CHAR' || datatype_vvvvwch == 'VARCHAR' || datatype_vvvvwch == 'DATETIME' || datatype_vvvvwch == 'DATE' || datatype_vvvvwch == 'TIME' || datatype_vvvvwch == 'INT' || datatype_vvvvwch == 'TINYINT' || datatype_vvvvwch == 'BIGINT' || datatype_vvvvwch == 'FLOAT' || datatype_vvvvwch == 'DECIMAL' || datatype_vvvvwch == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwch Some function
function has_defaults_vvvvwch_SomeFunc(has_defaults_vvvvwch)
{
	// set the function logic
	if (has_defaults_vvvvwch == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwci function
function vvvvwci(has_defaults_vvvvwci,datatype_vvvvwci)
{
	if (isSet(has_defaults_vvvvwci) && has_defaults_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = has_defaults_vvvvwci;
		var has_defaults_vvvvwci = [];
		has_defaults_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(has_defaults_vvvvwci))
	{
		var has_defaults_vvvvwci = [];
	}
	var has_defaults = has_defaults_vvvvwci.some(has_defaults_vvvvwci_SomeFunc);

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
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcivxs_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcivxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcivxs_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcivxs_required = true;
		}
	}
}

// the vvvvwci Some function
function has_defaults_vvvvwci_SomeFunc(has_defaults_vvvvwci)
{
	// set the function logic
	if (has_defaults_vvvvwci == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwci Some function
function datatype_vvvvwci_SomeFunc(datatype_vvvvwci)
{
	// set the function logic
	if (datatype_vvvvwci == 'CHAR' || datatype_vvvvwci == 'VARCHAR' || datatype_vvvvwci == 'DATETIME' || datatype_vvvvwci == 'DATE' || datatype_vvvvwci == 'TIME' || datatype_vvvvwci == 'INT' || datatype_vvvvwci == 'TINYINT' || datatype_vvvvwci == 'BIGINT' || datatype_vvvvwci == 'FLOAT' || datatype_vvvvwci == 'DECIMAL' || datatype_vvvvwci == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcj function
function vvvvwcj(datatype_vvvvwcj,has_defaults_vvvvwcj)
{
	if (isSet(datatype_vvvvwcj) && datatype_vvvvwcj.constructor !== Array)
	{
		var temp_vvvvwcj = datatype_vvvvwcj;
		var datatype_vvvvwcj = [];
		datatype_vvvvwcj.push(temp_vvvvwcj);
	}
	else if (!isSet(datatype_vvvvwcj))
	{
		var datatype_vvvvwcj = [];
	}
	var datatype = datatype_vvvvwcj.some(datatype_vvvvwcj_SomeFunc);

	if (isSet(has_defaults_vvvvwcj) && has_defaults_vvvvwcj.constructor !== Array)
	{
		var temp_vvvvwcj = has_defaults_vvvvwcj;
		var has_defaults_vvvvwcj = [];
		has_defaults_vvvvwcj.push(temp_vvvvwcj);
	}
	else if (!isSet(has_defaults_vvvvwcj))
	{
		var has_defaults_vvvvwcj = [];
	}
	var has_defaults = has_defaults_vvvvwcj.some(has_defaults_vvvvwcj_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwcjvxt_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwcjvxt_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwcjvxt_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwcjvxt_required = true;
		}
	}
}

// the vvvvwcj Some function
function datatype_vvvvwcj_SomeFunc(datatype_vvvvwcj)
{
	// set the function logic
	if (datatype_vvvvwcj == 'CHAR' || datatype_vvvvwcj == 'VARCHAR' || datatype_vvvvwcj == 'TEXT' || datatype_vvvvwcj == 'MEDIUMTEXT' || datatype_vvvvwcj == 'LONGTEXT' || datatype_vvvvwcj == 'BLOB' || datatype_vvvvwcj == 'TINYBLOB' || datatype_vvvvwcj == 'MEDIUMBLOB' || datatype_vvvvwcj == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcj Some function
function has_defaults_vvvvwcj_SomeFunc(has_defaults_vvvvwcj)
{
	// set the function logic
	if (has_defaults_vvvvwcj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcl function
function vvvvwcl(store_vvvvwcl,datatype_vvvvwcl,has_defaults_vvvvwcl)
{
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

	if (isSet(has_defaults_vvvvwcl) && has_defaults_vvvvwcl.constructor !== Array)
	{
		var temp_vvvvwcl = has_defaults_vvvvwcl;
		var has_defaults_vvvvwcl = [];
		has_defaults_vvvvwcl.push(temp_vvvvwcl);
	}
	else if (!isSet(has_defaults_vvvvwcl))
	{
		var has_defaults_vvvvwcl = [];
	}
	var has_defaults = has_defaults_vvvvwcl.some(has_defaults_vvvvwcl_SomeFunc);


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

// the vvvvwcl Some function
function store_vvvvwcl_SomeFunc(store_vvvvwcl)
{
	// set the function logic
	if (store_vvvvwcl == 4)
	{
		return true;
	}
	return false;
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
function has_defaults_vvvvwcl_SomeFunc(has_defaults_vvvvwcl)
{
	// set the function logic
	if (has_defaults_vvvvwcl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcm function
function vvvvwcm(datatype_vvvvwcm,store_vvvvwcm,has_defaults_vvvvwcm)
{
	if (isSet(datatype_vvvvwcm) && datatype_vvvvwcm.constructor !== Array)
	{
		var temp_vvvvwcm = datatype_vvvvwcm;
		var datatype_vvvvwcm = [];
		datatype_vvvvwcm.push(temp_vvvvwcm);
	}
	else if (!isSet(datatype_vvvvwcm))
	{
		var datatype_vvvvwcm = [];
	}
	var datatype = datatype_vvvvwcm.some(datatype_vvvvwcm_SomeFunc);

	if (isSet(store_vvvvwcm) && store_vvvvwcm.constructor !== Array)
	{
		var temp_vvvvwcm = store_vvvvwcm;
		var store_vvvvwcm = [];
		store_vvvvwcm.push(temp_vvvvwcm);
	}
	else if (!isSet(store_vvvvwcm))
	{
		var store_vvvvwcm = [];
	}
	var store = store_vvvvwcm.some(store_vvvvwcm_SomeFunc);

	if (isSet(has_defaults_vvvvwcm) && has_defaults_vvvvwcm.constructor !== Array)
	{
		var temp_vvvvwcm = has_defaults_vvvvwcm;
		var has_defaults_vvvvwcm = [];
		has_defaults_vvvvwcm.push(temp_vvvvwcm);
	}
	else if (!isSet(has_defaults_vvvvwcm))
	{
		var has_defaults_vvvvwcm = [];
	}
	var has_defaults = has_defaults_vvvvwcm.some(has_defaults_vvvvwcm_SomeFunc);


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

// the vvvvwcm Some function
function datatype_vvvvwcm_SomeFunc(datatype_vvvvwcm)
{
	// set the function logic
	if (datatype_vvvvwcm == 'CHAR' || datatype_vvvvwcm == 'VARCHAR' || datatype_vvvvwcm == 'TEXT' || datatype_vvvvwcm == 'MEDIUMTEXT' || datatype_vvvvwcm == 'LONGTEXT' || datatype_vvvvwcm == 'BLOB' || datatype_vvvvwcm == 'TINYBLOB' || datatype_vvvvwcm == 'MEDIUMBLOB' || datatype_vvvvwcm == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcm Some function
function store_vvvvwcm_SomeFunc(store_vvvvwcm)
{
	// set the function logic
	if (store_vvvvwcm == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcm Some function
function has_defaults_vvvvwcm_SomeFunc(has_defaults_vvvvwcm)
{
	// set the function logic
	if (has_defaults_vvvvwcm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcn function
function vvvvwcn(has_defaults_vvvvwcn,store_vvvvwcn,datatype_vvvvwcn)
{
	if (isSet(has_defaults_vvvvwcn) && has_defaults_vvvvwcn.constructor !== Array)
	{
		var temp_vvvvwcn = has_defaults_vvvvwcn;
		var has_defaults_vvvvwcn = [];
		has_defaults_vvvvwcn.push(temp_vvvvwcn);
	}
	else if (!isSet(has_defaults_vvvvwcn))
	{
		var has_defaults_vvvvwcn = [];
	}
	var has_defaults = has_defaults_vvvvwcn.some(has_defaults_vvvvwcn_SomeFunc);

	if (isSet(store_vvvvwcn) && store_vvvvwcn.constructor !== Array)
	{
		var temp_vvvvwcn = store_vvvvwcn;
		var store_vvvvwcn = [];
		store_vvvvwcn.push(temp_vvvvwcn);
	}
	else if (!isSet(store_vvvvwcn))
	{
		var store_vvvvwcn = [];
	}
	var store = store_vvvvwcn.some(store_vvvvwcn_SomeFunc);

	if (isSet(datatype_vvvvwcn) && datatype_vvvvwcn.constructor !== Array)
	{
		var temp_vvvvwcn = datatype_vvvvwcn;
		var datatype_vvvvwcn = [];
		datatype_vvvvwcn.push(temp_vvvvwcn);
	}
	else if (!isSet(datatype_vvvvwcn))
	{
		var datatype_vvvvwcn = [];
	}
	var datatype = datatype_vvvvwcn.some(datatype_vvvvwcn_SomeFunc);


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

// the vvvvwcn Some function
function has_defaults_vvvvwcn_SomeFunc(has_defaults_vvvvwcn)
{
	// set the function logic
	if (has_defaults_vvvvwcn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcn Some function
function store_vvvvwcn_SomeFunc(store_vvvvwcn)
{
	// set the function logic
	if (store_vvvvwcn == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcn Some function
function datatype_vvvvwcn_SomeFunc(datatype_vvvvwcn)
{
	// set the function logic
	if (datatype_vvvvwcn == 'CHAR' || datatype_vvvvwcn == 'VARCHAR' || datatype_vvvvwcn == 'TEXT' || datatype_vvvvwcn == 'MEDIUMTEXT' || datatype_vvvvwcn == 'LONGTEXT' || datatype_vvvvwcn == 'BLOB' || datatype_vvvvwcn == 'TINYBLOB' || datatype_vvvvwcn == 'MEDIUMBLOB' || datatype_vvvvwcn == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwco function
function vvvvwco(has_defaults_vvvvwco)
{
	// set the function logic
	if (has_defaults_vvvvwco == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwcovxu_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwcovxu_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwcovxv_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwcovxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwcovxu_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwcovxu_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwcovxv_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwcovxv_required = true;
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
