/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwbvvxb_required = false;
jform_vvvvwbxvxc_required = false;
jform_vvvvwbzvxd_required = false;
jform_vvvvwcbvxe_required = false;
jform_vvvvwccvxf_required = false;
jform_vvvvwcdvxg_required = false;
jform_vvvvwcivxh_required = false;
jform_vvvvwcivxi_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var datalenght_vvvvwbv = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbv(datalenght_vvvvwbv,has_defaults_vvvvwbv);

	var datadefault_vvvvwbx = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbx(datadefault_vvvvwbx,has_defaults_vvvvwbx);

	var datatype_vvvvwbz = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbz = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbz(datatype_vvvvwbz,has_defaults_vvvvwbz);

	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,has_defaults_vvvvwcb);

	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,datatype_vvvvwcc);

	var datatype_vvvvwcd = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcd(datatype_vvvvwcd,has_defaults_vvvvwcd);

	var store_vvvvwcf = jQuery("#jform_store").val();
	var datatype_vvvvwcf = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcf(store_vvvvwcf,datatype_vvvvwcf,has_defaults_vvvvwcf);

	var datatype_vvvvwcg = jQuery("#jform_datatype").val();
	var store_vvvvwcg = jQuery("#jform_store").val();
	var has_defaults_vvvvwcg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcg(datatype_vvvvwcg,store_vvvvwcg,has_defaults_vvvvwcg);

	var has_defaults_vvvvwch = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwch = jQuery("#jform_store").val();
	var datatype_vvvvwch = jQuery("#jform_datatype").val();
	vvvvwch(has_defaults_vvvvwch,store_vvvvwch,datatype_vvvvwch);

	var has_defaults_vvvvwci = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwci(has_defaults_vvvvwci);
});

// the vvvvwbv function
function vvvvwbv(datalenght_vvvvwbv,has_defaults_vvvvwbv)
{
	if (isSet(datalenght_vvvvwbv) && datalenght_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = datalenght_vvvvwbv;
		var datalenght_vvvvwbv = [];
		datalenght_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(datalenght_vvvvwbv))
	{
		var datalenght_vvvvwbv = [];
	}
	var datalenght = datalenght_vvvvwbv.some(datalenght_vvvvwbv_SomeFunc);

	if (isSet(has_defaults_vvvvwbv) && has_defaults_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = has_defaults_vvvvwbv;
		var has_defaults_vvvvwbv = [];
		has_defaults_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(has_defaults_vvvvwbv))
	{
		var has_defaults_vvvvwbv = [];
	}
	var has_defaults = has_defaults_vvvvwbv.some(has_defaults_vvvvwbv_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbvvxb_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbvvxb_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbvvxb_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbvvxb_required = true;
		}
	}
}

// the vvvvwbv Some function
function datalenght_vvvvwbv_SomeFunc(datalenght_vvvvwbv)
{
	// set the function logic
	if (datalenght_vvvvwbv == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbv Some function
function has_defaults_vvvvwbv_SomeFunc(has_defaults_vvvvwbv)
{
	// set the function logic
	if (has_defaults_vvvvwbv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbx function
function vvvvwbx(datadefault_vvvvwbx,has_defaults_vvvvwbx)
{
	if (isSet(datadefault_vvvvwbx) && datadefault_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = datadefault_vvvvwbx;
		var datadefault_vvvvwbx = [];
		datadefault_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(datadefault_vvvvwbx))
	{
		var datadefault_vvvvwbx = [];
	}
	var datadefault = datadefault_vvvvwbx.some(datadefault_vvvvwbx_SomeFunc);

	if (isSet(has_defaults_vvvvwbx) && has_defaults_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = has_defaults_vvvvwbx;
		var has_defaults_vvvvwbx = [];
		has_defaults_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(has_defaults_vvvvwbx))
	{
		var has_defaults_vvvvwbx = [];
	}
	var has_defaults = has_defaults_vvvvwbx.some(has_defaults_vvvvwbx_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbxvxc_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbxvxc_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbxvxc_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbxvxc_required = true;
		}
	}
}

// the vvvvwbx Some function
function datadefault_vvvvwbx_SomeFunc(datadefault_vvvvwbx)
{
	// set the function logic
	if (datadefault_vvvvwbx == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbx Some function
function has_defaults_vvvvwbx_SomeFunc(has_defaults_vvvvwbx)
{
	// set the function logic
	if (has_defaults_vvvvwbx == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbz function
function vvvvwbz(datatype_vvvvwbz,has_defaults_vvvvwbz)
{
	if (isSet(datatype_vvvvwbz) && datatype_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = datatype_vvvvwbz;
		var datatype_vvvvwbz = [];
		datatype_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(datatype_vvvvwbz))
	{
		var datatype_vvvvwbz = [];
	}
	var datatype = datatype_vvvvwbz.some(datatype_vvvvwbz_SomeFunc);

	if (isSet(has_defaults_vvvvwbz) && has_defaults_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = has_defaults_vvvvwbz;
		var has_defaults_vvvvwbz = [];
		has_defaults_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(has_defaults_vvvvwbz))
	{
		var has_defaults_vvvvwbz = [];
	}
	var has_defaults = has_defaults_vvvvwbz.some(has_defaults_vvvvwbz_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwbzvxd_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwbzvxd_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwbzvxd_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwbzvxd_required = true;
		}
	}
}

// the vvvvwbz Some function
function datatype_vvvvwbz_SomeFunc(datatype_vvvvwbz)
{
	// set the function logic
	if (datatype_vvvvwbz == 'CHAR' || datatype_vvvvwbz == 'VARCHAR' || datatype_vvvvwbz == 'INT' || datatype_vvvvwbz == 'TINYINT' || datatype_vvvvwbz == 'BIGINT' || datatype_vvvvwbz == 'FLOAT' || datatype_vvvvwbz == 'DECIMAL' || datatype_vvvvwbz == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbz Some function
function has_defaults_vvvvwbz_SomeFunc(has_defaults_vvvvwbz)
{
	// set the function logic
	if (has_defaults_vvvvwbz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcb function
function vvvvwcb(datatype_vvvvwcb,has_defaults_vvvvwcb)
{
	if (isSet(datatype_vvvvwcb) && datatype_vvvvwcb.constructor !== Array)
	{
		var temp_vvvvwcb = datatype_vvvvwcb;
		var datatype_vvvvwcb = [];
		datatype_vvvvwcb.push(temp_vvvvwcb);
	}
	else if (!isSet(datatype_vvvvwcb))
	{
		var datatype_vvvvwcb = [];
	}
	var datatype = datatype_vvvvwcb.some(datatype_vvvvwcb_SomeFunc);

	if (isSet(has_defaults_vvvvwcb) && has_defaults_vvvvwcb.constructor !== Array)
	{
		var temp_vvvvwcb = has_defaults_vvvvwcb;
		var has_defaults_vvvvwcb = [];
		has_defaults_vvvvwcb.push(temp_vvvvwcb);
	}
	else if (!isSet(has_defaults_vvvvwcb))
	{
		var has_defaults_vvvvwcb = [];
	}
	var has_defaults = has_defaults_vvvvwcb.some(has_defaults_vvvvwcb_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcbvxe_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcbvxe_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcbvxe_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcbvxe_required = true;
		}
	}
}

// the vvvvwcb Some function
function datatype_vvvvwcb_SomeFunc(datatype_vvvvwcb)
{
	// set the function logic
	if (datatype_vvvvwcb == 'CHAR' || datatype_vvvvwcb == 'VARCHAR' || datatype_vvvvwcb == 'DATETIME' || datatype_vvvvwcb == 'DATE' || datatype_vvvvwcb == 'TIME' || datatype_vvvvwcb == 'INT' || datatype_vvvvwcb == 'TINYINT' || datatype_vvvvwcb == 'BIGINT' || datatype_vvvvwcb == 'FLOAT' || datatype_vvvvwcb == 'DECIMAL' || datatype_vvvvwcb == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcb Some function
function has_defaults_vvvvwcb_SomeFunc(has_defaults_vvvvwcb)
{
	// set the function logic
	if (has_defaults_vvvvwcb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcc function
function vvvvwcc(has_defaults_vvvvwcc,datatype_vvvvwcc)
{
	if (isSet(has_defaults_vvvvwcc) && has_defaults_vvvvwcc.constructor !== Array)
	{
		var temp_vvvvwcc = has_defaults_vvvvwcc;
		var has_defaults_vvvvwcc = [];
		has_defaults_vvvvwcc.push(temp_vvvvwcc);
	}
	else if (!isSet(has_defaults_vvvvwcc))
	{
		var has_defaults_vvvvwcc = [];
	}
	var has_defaults = has_defaults_vvvvwcc.some(has_defaults_vvvvwcc_SomeFunc);

	if (isSet(datatype_vvvvwcc) && datatype_vvvvwcc.constructor !== Array)
	{
		var temp_vvvvwcc = datatype_vvvvwcc;
		var datatype_vvvvwcc = [];
		datatype_vvvvwcc.push(temp_vvvvwcc);
	}
	else if (!isSet(datatype_vvvvwcc))
	{
		var datatype_vvvvwcc = [];
	}
	var datatype = datatype_vvvvwcc.some(datatype_vvvvwcc_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwccvxf_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwccvxf_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwccvxf_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwccvxf_required = true;
		}
	}
}

// the vvvvwcc Some function
function has_defaults_vvvvwcc_SomeFunc(has_defaults_vvvvwcc)
{
	// set the function logic
	if (has_defaults_vvvvwcc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcc Some function
function datatype_vvvvwcc_SomeFunc(datatype_vvvvwcc)
{
	// set the function logic
	if (datatype_vvvvwcc == 'CHAR' || datatype_vvvvwcc == 'VARCHAR' || datatype_vvvvwcc == 'DATETIME' || datatype_vvvvwcc == 'DATE' || datatype_vvvvwcc == 'TIME' || datatype_vvvvwcc == 'INT' || datatype_vvvvwcc == 'TINYINT' || datatype_vvvvwcc == 'BIGINT' || datatype_vvvvwcc == 'FLOAT' || datatype_vvvvwcc == 'DECIMAL' || datatype_vvvvwcc == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcd function
function vvvvwcd(datatype_vvvvwcd,has_defaults_vvvvwcd)
{
	if (isSet(datatype_vvvvwcd) && datatype_vvvvwcd.constructor !== Array)
	{
		var temp_vvvvwcd = datatype_vvvvwcd;
		var datatype_vvvvwcd = [];
		datatype_vvvvwcd.push(temp_vvvvwcd);
	}
	else if (!isSet(datatype_vvvvwcd))
	{
		var datatype_vvvvwcd = [];
	}
	var datatype = datatype_vvvvwcd.some(datatype_vvvvwcd_SomeFunc);

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
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwcdvxg_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwcdvxg_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwcdvxg_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwcdvxg_required = true;
		}
	}
}

// the vvvvwcd Some function
function datatype_vvvvwcd_SomeFunc(datatype_vvvvwcd)
{
	// set the function logic
	if (datatype_vvvvwcd == 'CHAR' || datatype_vvvvwcd == 'VARCHAR' || datatype_vvvvwcd == 'TEXT' || datatype_vvvvwcd == 'MEDIUMTEXT' || datatype_vvvvwcd == 'LONGTEXT' || datatype_vvvvwcd == 'BLOB' || datatype_vvvvwcd == 'TINYBLOB' || datatype_vvvvwcd == 'MEDIUMBLOB' || datatype_vvvvwcd == 'LONGBLOB')
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
function vvvvwcf(store_vvvvwcf,datatype_vvvvwcf,has_defaults_vvvvwcf)
{
	if (isSet(store_vvvvwcf) && store_vvvvwcf.constructor !== Array)
	{
		var temp_vvvvwcf = store_vvvvwcf;
		var store_vvvvwcf = [];
		store_vvvvwcf.push(temp_vvvvwcf);
	}
	else if (!isSet(store_vvvvwcf))
	{
		var store_vvvvwcf = [];
	}
	var store = store_vvvvwcf.some(store_vvvvwcf_SomeFunc);

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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwcf Some function
function store_vvvvwcf_SomeFunc(store_vvvvwcf)
{
	// set the function logic
	if (store_vvvvwcf == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcf Some function
function datatype_vvvvwcf_SomeFunc(datatype_vvvvwcf)
{
	// set the function logic
	if (datatype_vvvvwcf == 'CHAR' || datatype_vvvvwcf == 'VARCHAR' || datatype_vvvvwcf == 'TEXT' || datatype_vvvvwcf == 'MEDIUMTEXT' || datatype_vvvvwcf == 'LONGTEXT' || datatype_vvvvwcf == 'BLOB' || datatype_vvvvwcf == 'TINYBLOB' || datatype_vvvvwcf == 'MEDIUMBLOB' || datatype_vvvvwcf == 'LONGBLOB')
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

// the vvvvwcg function
function vvvvwcg(datatype_vvvvwcg,store_vvvvwcg,has_defaults_vvvvwcg)
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

	if (isSet(store_vvvvwcg) && store_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = store_vvvvwcg;
		var store_vvvvwcg = [];
		store_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(store_vvvvwcg))
	{
		var store_vvvvwcg = [];
	}
	var store = store_vvvvwcg.some(store_vvvvwcg_SomeFunc);

	if (isSet(has_defaults_vvvvwcg) && has_defaults_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = has_defaults_vvvvwcg;
		var has_defaults_vvvvwcg = [];
		has_defaults_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(has_defaults_vvvvwcg))
	{
		var has_defaults_vvvvwcg = [];
	}
	var has_defaults = has_defaults_vvvvwcg.some(has_defaults_vvvvwcg_SomeFunc);


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

// the vvvvwcg Some function
function datatype_vvvvwcg_SomeFunc(datatype_vvvvwcg)
{
	// set the function logic
	if (datatype_vvvvwcg == 'CHAR' || datatype_vvvvwcg == 'VARCHAR' || datatype_vvvvwcg == 'TEXT' || datatype_vvvvwcg == 'MEDIUMTEXT' || datatype_vvvvwcg == 'LONGTEXT' || datatype_vvvvwcg == 'BLOB' || datatype_vvvvwcg == 'TINYBLOB' || datatype_vvvvwcg == 'MEDIUMBLOB' || datatype_vvvvwcg == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcg Some function
function store_vvvvwcg_SomeFunc(store_vvvvwcg)
{
	// set the function logic
	if (store_vvvvwcg == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcg Some function
function has_defaults_vvvvwcg_SomeFunc(has_defaults_vvvvwcg)
{
	// set the function logic
	if (has_defaults_vvvvwcg == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwch function
function vvvvwch(has_defaults_vvvvwch,store_vvvvwch,datatype_vvvvwch)
{
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

	if (isSet(store_vvvvwch) && store_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = store_vvvvwch;
		var store_vvvvwch = [];
		store_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(store_vvvvwch))
	{
		var store_vvvvwch = [];
	}
	var store = store_vvvvwch.some(store_vvvvwch_SomeFunc);

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
	if (has_defaults && store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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

// the vvvvwch Some function
function store_vvvvwch_SomeFunc(store_vvvvwch)
{
	// set the function logic
	if (store_vvvvwch == 4)
	{
		return true;
	}
	return false;
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
function vvvvwci(has_defaults_vvvvwci)
{
	// set the function logic
	if (has_defaults_vvvvwci == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwcivxh_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwcivxh_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwcivxi_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwcivxi_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwcivxh_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwcivxh_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwcivxi_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwcivxi_required = true;
		}
	}
}

/**
 * Update the "not required" field list by adding or removing a field name.
 *
 * Mirrors the original jQuery logic exactly but uses pure JavaScript.
 *
 * @param  {string}  name    The field name to add or remove.
 * @param  {number}  status  1 to add as not required, 0 to remove.
 *
 * @return {void}
 * @since  3.1.3
 */
function updateFieldRequired(name, status) {
	// Check if #jform_not_required exists
	const notRequiredField = document.getElementById('jform_not_required');
	if (!notRequiredField) {
		return;
	}

	// Split the comma-separated list into an array
	let not_required = notRequiredField.value ? notRequiredField.value.split(',') : [];

	// Add or remove the field name from the list
	if (status == 1) {
		not_required.push(name);
	} else {
		not_required = removeFieldFromNotRequired(not_required, name);
	}

	// Clean and deduplicate the list
	const fixedList = fixNotRequiredArray(not_required);

	// Write back the updated comma-separated list
	notRequiredField.value = fixedList.toString();
}

/**
 * Remove a specific field name from the "not required" array.
 *
 * @param  {Array<string>} array  The list of not-required field names.
 * @param  {string}        what   The field name to remove.
 *
 * @return {Array<string>}        The updated array.
 * @since  3.1.3
 */
function removeFieldFromNotRequired(array, what) {
	return array.filter(function (element) {
		return element !== what;
	});
}

/**
 * Deduplicate and clean a "not required" array.
 *
 * @param  {Array<string>} array  The array to fix.
 *
 * @return {Array<string>}        A cleaned, unique array.
 * @since  3.1.3
 */
function fixNotRequiredArray(array) {
	const seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function (item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

/**
 * Remove empty or invalid entries from a "not required" array.
 *
 * Also removes the literal '一_一' token (legacy quirk preserved for compatibility).
 *
 * @param  {Array<string>} array  The array to process.
 *
 * @return {Array<string>}        The cleaned array.
 * @since  3.1.3
 */
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		return el && el.length > 0 && el !== '一_一';
	});
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

/**
 * Retrieve the Edit Custom Code buttons from the server.
 *
 * @param  {number} id  The record ID to load custom code buttons for.
 *
 * @return {Promise<object|null>}  Returns JSON object of buttons or null on failure.
 * @since  3.1.3
 */
async function getEditCustomCodeButtons_server(id) {
	try {
		// --- Validation ---
		if (typeof token !== 'string' || !token.trim()) {
			console.error('[getEditCustomCodeButtons_server] Missing or invalid CSRF token.');
			return null;
		}
		if (typeof id !== 'number' || id <= 0) {
			console.error('[getEditCustomCodeButtons_server] Invalid ID provided:', id);
			return null;
		}
		if (typeof return_here !== 'string' || !return_here.trim()) {
			console.warn('[getEditCustomCodeButtons_server] "return_here" not set; continuing without it.');
		}

		// --- Build URL safely ---
		const baseUrl = 'index.php';
		const params = new URLSearchParams({
			option: 'com_componentbuilder',
			task: 'ajax.getEditCustomCodeButtons',
			format: 'json',
			raw: 'true',
			[token]: '1',
			id: id,
			return_here: return_here || ''
		});
		if (typeof vastDevMod === 'string' && vastDevMod.length > 0) {
			params.append('vdm', vastDevMod);
		}

		const urlWithParams = JRouter(`${baseUrl}?${params.toString()}`);

		// --- Execute request ---
		const response = await fetch(urlWithParams, {
			method: 'GET',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			cache: 'no-store',
			credentials: 'same-origin'
		});

		// --- Handle network errors ---
		if (!response.ok) {
			console.error(`[getEditCustomCodeButtons_server] HTTP ${response.status}: ${response.statusText}`);
			return null;
		}

		// --- Parse JSON result ---
		const data = await response.json();
		return data ?? null;

	} catch (error) {
		console.error('[getEditCustomCodeButtons_server] Fetch failed:', error);
		return null;
	}
}

/**
 * Load and inject Edit Custom Code buttons into the DOM.
 *
 * @return {Promise<void>}
 * @since  3.1.3
 */
async function getEditCustomCodeButtons() {
	try {
		// --- Get record ID from the form ---
		const idField = document.querySelector('#jform_id');
		if (!idField) {
			console.error('[getEditCustomCodeButtons] #jform_id not found.');
			return;
		}

		const idValue = parseInt(idField.value, 10);
		if (isNaN(idValue) || idValue <= 0) {
			console.warn('[getEditCustomCodeButtons] Invalid or empty ID; skipping button load.');
			return;
		}

		// --- Request data from server ---
		const result = await getEditCustomCodeButtons_server(idValue);
		if (!result || typeof result !== 'object') {
			console.warn('[getEditCustomCodeButtons] No result returned or invalid format.');
			return;
		}

		// --- Inject returned button groups ---
		Object.entries(result).forEach(([field, buttons]) => {
			// Create the container div
			const div = document.createElement('div');
			div.className = 'control-group';
			div.innerHTML = `
<div class="control-label">
	<label>Add/Edit Customcode</label>
</div>
<div class="controls control-customcode-buttons-${field}"></div>
			`;

			// Find where to insert (before .control-wrapper-{field})
			const insertBeforeElement = document.querySelector(`.control-wrapper-${field}`);
			if (insertBeforeElement && insertBeforeElement.parentNode) {
				insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);
			}

			// Append buttons to the new container
			const controlsDiv = div.querySelector(`.control-customcode-buttons-${field}`);
			if (controlsDiv && typeof buttons === 'object') {
				Object.entries(buttons).forEach(([name, buttonHtml]) => {
					if (typeof buttonHtml === 'string') {
						const wrapper = document.createElement('div');
						wrapper.innerHTML = buttonHtml.trim();
						const buttonNode = wrapper.firstElementChild;
						if (buttonNode) {
							controlsDiv.appendChild(buttonNode);
						}
					}
				});
			}
		});
	} catch (error) {
		console.error('[getEditCustomCodeButtons] Error rendering buttons:', error);
	}
}
