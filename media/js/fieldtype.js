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
jform_vvvvwbrvwy_required = false;
jform_vvvvwbtvwz_required = false;
jform_vvvvwbvvxa_required = false;
jform_vvvvwbxvxb_required = false;
jform_vvvvwbyvxc_required = false;
jform_vvvvwbzvxd_required = false;
jform_vvvvwcevxe_required = false;
jform_vvvvwcevxf_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var datalenght_vvvvwbr = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbr(datalenght_vvvvwbr,has_defaults_vvvvwbr);

	var datadefault_vvvvwbt = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datadefault_vvvvwbt,has_defaults_vvvvwbt);

	var datatype_vvvvwbv = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbv(datatype_vvvvwbv,has_defaults_vvvvwbv);

	var datatype_vvvvwbx = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbx(datatype_vvvvwbx,has_defaults_vvvvwbx);

	var has_defaults_vvvvwby = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwby = jQuery("#jform_datatype").val();
	vvvvwby(has_defaults_vvvvwby,datatype_vvvvwby);

	var datatype_vvvvwbz = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbz = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbz(datatype_vvvvwbz,has_defaults_vvvvwbz);

	var store_vvvvwcb = jQuery("#jform_store").val();
	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(store_vvvvwcb,datatype_vvvvwcb,has_defaults_vvvvwcb);

	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcc(datatype_vvvvwcc,store_vvvvwcc,has_defaults_vvvvwcc);

	var has_defaults_vvvvwcd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcd = jQuery("#jform_store").val();
	var datatype_vvvvwcd = jQuery("#jform_datatype").val();
	vvvvwcd(has_defaults_vvvvwcd,store_vvvvwcd,datatype_vvvvwcd);

	var has_defaults_vvvvwce = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwce(has_defaults_vvvvwce);
});

// the vvvvwbr function
function vvvvwbr(datalenght_vvvvwbr,has_defaults_vvvvwbr)
{
	if (isSet(datalenght_vvvvwbr) && datalenght_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = datalenght_vvvvwbr;
		var datalenght_vvvvwbr = [];
		datalenght_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(datalenght_vvvvwbr))
	{
		var datalenght_vvvvwbr = [];
	}
	var datalenght = datalenght_vvvvwbr.some(datalenght_vvvvwbr_SomeFunc);

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


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbrvwy_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbrvwy_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbrvwy_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbrvwy_required = true;
		}
	}
}

// the vvvvwbr Some function
function datalenght_vvvvwbr_SomeFunc(datalenght_vvvvwbr)
{
	// set the function logic
	if (datalenght_vvvvwbr == 'Other')
	{
		return true;
	}
	return false;
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

// the vvvvwbt function
function vvvvwbt(datadefault_vvvvwbt,has_defaults_vvvvwbt)
{
	if (isSet(datadefault_vvvvwbt) && datadefault_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = datadefault_vvvvwbt;
		var datadefault_vvvvwbt = [];
		datadefault_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(datadefault_vvvvwbt))
	{
		var datadefault_vvvvwbt = [];
	}
	var datadefault = datadefault_vvvvwbt.some(datadefault_vvvvwbt_SomeFunc);

	if (isSet(has_defaults_vvvvwbt) && has_defaults_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = has_defaults_vvvvwbt;
		var has_defaults_vvvvwbt = [];
		has_defaults_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(has_defaults_vvvvwbt))
	{
		var has_defaults_vvvvwbt = [];
	}
	var has_defaults = has_defaults_vvvvwbt.some(has_defaults_vvvvwbt_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbtvwz_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbtvwz_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbtvwz_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbtvwz_required = true;
		}
	}
}

// the vvvvwbt Some function
function datadefault_vvvvwbt_SomeFunc(datadefault_vvvvwbt)
{
	// set the function logic
	if (datadefault_vvvvwbt == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbt Some function
function has_defaults_vvvvwbt_SomeFunc(has_defaults_vvvvwbt)
{
	// set the function logic
	if (has_defaults_vvvvwbt == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbv function
function vvvvwbv(datatype_vvvvwbv,has_defaults_vvvvwbv)
{
	if (isSet(datatype_vvvvwbv) && datatype_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = datatype_vvvvwbv;
		var datatype_vvvvwbv = [];
		datatype_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(datatype_vvvvwbv))
	{
		var datatype_vvvvwbv = [];
	}
	var datatype = datatype_vvvvwbv.some(datatype_vvvvwbv_SomeFunc);

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
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwbvvxa_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwbvvxa_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwbvvxa_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwbvvxa_required = true;
		}
	}
}

// the vvvvwbv Some function
function datatype_vvvvwbv_SomeFunc(datatype_vvvvwbv)
{
	// set the function logic
	if (datatype_vvvvwbv == 'CHAR' || datatype_vvvvwbv == 'VARCHAR' || datatype_vvvvwbv == 'INT' || datatype_vvvvwbv == 'TINYINT' || datatype_vvvvwbv == 'BIGINT' || datatype_vvvvwbv == 'FLOAT' || datatype_vvvvwbv == 'DECIMAL' || datatype_vvvvwbv == 'DOUBLE')
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
function vvvvwbx(datatype_vvvvwbx,has_defaults_vvvvwbx)
{
	if (isSet(datatype_vvvvwbx) && datatype_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = datatype_vvvvwbx;
		var datatype_vvvvwbx = [];
		datatype_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(datatype_vvvvwbx))
	{
		var datatype_vvvvwbx = [];
	}
	var datatype = datatype_vvvvwbx.some(datatype_vvvvwbx_SomeFunc);

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
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbxvxb_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbxvxb_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbxvxb_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbxvxb_required = true;
		}
	}
}

// the vvvvwbx Some function
function datatype_vvvvwbx_SomeFunc(datatype_vvvvwbx)
{
	// set the function logic
	if (datatype_vvvvwbx == 'CHAR' || datatype_vvvvwbx == 'VARCHAR' || datatype_vvvvwbx == 'DATETIME' || datatype_vvvvwbx == 'DATE' || datatype_vvvvwbx == 'TIME' || datatype_vvvvwbx == 'INT' || datatype_vvvvwbx == 'TINYINT' || datatype_vvvvwbx == 'BIGINT' || datatype_vvvvwbx == 'FLOAT' || datatype_vvvvwbx == 'DECIMAL' || datatype_vvvvwbx == 'DOUBLE')
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

// the vvvvwby function
function vvvvwby(has_defaults_vvvvwby,datatype_vvvvwby)
{
	if (isSet(has_defaults_vvvvwby) && has_defaults_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = has_defaults_vvvvwby;
		var has_defaults_vvvvwby = [];
		has_defaults_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(has_defaults_vvvvwby))
	{
		var has_defaults_vvvvwby = [];
	}
	var has_defaults = has_defaults_vvvvwby.some(has_defaults_vvvvwby_SomeFunc);

	if (isSet(datatype_vvvvwby) && datatype_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = datatype_vvvvwby;
		var datatype_vvvvwby = [];
		datatype_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(datatype_vvvvwby))
	{
		var datatype_vvvvwby = [];
	}
	var datatype = datatype_vvvvwby.some(datatype_vvvvwby_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbyvxc_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbyvxc_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbyvxc_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbyvxc_required = true;
		}
	}
}

// the vvvvwby Some function
function has_defaults_vvvvwby_SomeFunc(has_defaults_vvvvwby)
{
	// set the function logic
	if (has_defaults_vvvvwby == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwby Some function
function datatype_vvvvwby_SomeFunc(datatype_vvvvwby)
{
	// set the function logic
	if (datatype_vvvvwby == 'CHAR' || datatype_vvvvwby == 'VARCHAR' || datatype_vvvvwby == 'DATETIME' || datatype_vvvvwby == 'DATE' || datatype_vvvvwby == 'TIME' || datatype_vvvvwby == 'INT' || datatype_vvvvwby == 'TINYINT' || datatype_vvvvwby == 'BIGINT' || datatype_vvvvwby == 'FLOAT' || datatype_vvvvwby == 'DECIMAL' || datatype_vvvvwby == 'DOUBLE')
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
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbzvxd_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbzvxd_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbzvxd_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbzvxd_required = true;
		}
	}
}

// the vvvvwbz Some function
function datatype_vvvvwbz_SomeFunc(datatype_vvvvwbz)
{
	// set the function logic
	if (datatype_vvvvwbz == 'CHAR' || datatype_vvvvwbz == 'VARCHAR' || datatype_vvvvwbz == 'TEXT' || datatype_vvvvwbz == 'MEDIUMTEXT' || datatype_vvvvwbz == 'LONGTEXT' || datatype_vvvvwbz == 'BLOB' || datatype_vvvvwbz == 'TINYBLOB' || datatype_vvvvwbz == 'MEDIUMBLOB' || datatype_vvvvwbz == 'LONGBLOB')
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
function vvvvwcb(store_vvvvwcb,datatype_vvvvwcb,has_defaults_vvvvwcb)
{
	if (isSet(store_vvvvwcb) && store_vvvvwcb.constructor !== Array)
	{
		var temp_vvvvwcb = store_vvvvwcb;
		var store_vvvvwcb = [];
		store_vvvvwcb.push(temp_vvvvwcb);
	}
	else if (!isSet(store_vvvvwcb))
	{
		var store_vvvvwcb = [];
	}
	var store = store_vvvvwcb.some(store_vvvvwcb_SomeFunc);

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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwcb Some function
function store_vvvvwcb_SomeFunc(store_vvvvwcb)
{
	// set the function logic
	if (store_vvvvwcb == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcb Some function
function datatype_vvvvwcb_SomeFunc(datatype_vvvvwcb)
{
	// set the function logic
	if (datatype_vvvvwcb == 'CHAR' || datatype_vvvvwcb == 'VARCHAR' || datatype_vvvvwcb == 'TEXT' || datatype_vvvvwcb == 'MEDIUMTEXT' || datatype_vvvvwcb == 'LONGTEXT' || datatype_vvvvwcb == 'BLOB' || datatype_vvvvwcb == 'TINYBLOB' || datatype_vvvvwcb == 'MEDIUMBLOB' || datatype_vvvvwcb == 'LONGBLOB')
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
function vvvvwcc(datatype_vvvvwcc,store_vvvvwcc,has_defaults_vvvvwcc)
{
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

	if (isSet(store_vvvvwcc) && store_vvvvwcc.constructor !== Array)
	{
		var temp_vvvvwcc = store_vvvvwcc;
		var store_vvvvwcc = [];
		store_vvvvwcc.push(temp_vvvvwcc);
	}
	else if (!isSet(store_vvvvwcc))
	{
		var store_vvvvwcc = [];
	}
	var store = store_vvvvwcc.some(store_vvvvwcc_SomeFunc);

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

// the vvvvwcc Some function
function datatype_vvvvwcc_SomeFunc(datatype_vvvvwcc)
{
	// set the function logic
	if (datatype_vvvvwcc == 'CHAR' || datatype_vvvvwcc == 'VARCHAR' || datatype_vvvvwcc == 'TEXT' || datatype_vvvvwcc == 'MEDIUMTEXT' || datatype_vvvvwcc == 'LONGTEXT' || datatype_vvvvwcc == 'BLOB' || datatype_vvvvwcc == 'TINYBLOB' || datatype_vvvvwcc == 'MEDIUMBLOB' || datatype_vvvvwcc == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcc Some function
function store_vvvvwcc_SomeFunc(store_vvvvwcc)
{
	// set the function logic
	if (store_vvvvwcc == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwcd function
function vvvvwcd(has_defaults_vvvvwcd,store_vvvvwcd,datatype_vvvvwcd)
{
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

	if (isSet(store_vvvvwcd) && store_vvvvwcd.constructor !== Array)
	{
		var temp_vvvvwcd = store_vvvvwcd;
		var store_vvvvwcd = [];
		store_vvvvwcd.push(temp_vvvvwcd);
	}
	else if (!isSet(store_vvvvwcd))
	{
		var store_vvvvwcd = [];
	}
	var store = store_vvvvwcd.some(store_vvvvwcd_SomeFunc);

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

// the vvvvwcd Some function
function store_vvvvwcd_SomeFunc(store_vvvvwcd)
{
	// set the function logic
	if (store_vvvvwcd == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwce function
function vvvvwce(has_defaults_vvvvwce)
{
	// set the function logic
	if (has_defaults_vvvvwce == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwcevxe_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwcevxe_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwcevxf_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwcevxf_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwcevxe_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwcevxe_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwcevxf_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwcevxf_required = true;
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
