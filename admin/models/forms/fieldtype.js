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
jform_vvvvwcpvya_required = false;
jform_vvvvwcrvyb_required = false;
jform_vvvvwctvyc_required = false;
jform_vvvvwcvvyd_required = false;
jform_vvvvwcwvye_required = false;
jform_vvvvwcxvyf_required = false;
jform_vvvvwdcvyg_required = false;
jform_vvvvwdcvyh_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwcp = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwcp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcp(datalenght_vvvvwcp,has_defaults_vvvvwcp);

	var datadefault_vvvvwcr = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwcr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcr(datadefault_vvvvwcr,has_defaults_vvvvwcr);

	var datatype_vvvvwct = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwct = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwct(datatype_vvvvwct,has_defaults_vvvvwct);

	var datatype_vvvvwcv = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcv(datatype_vvvvwcv,has_defaults_vvvvwcv);

	var has_defaults_vvvvwcw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwcw = jQuery("#jform_datatype").val();
	vvvvwcw(has_defaults_vvvvwcw,datatype_vvvvwcw);

	var datatype_vvvvwcx = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcx(datatype_vvvvwcx,has_defaults_vvvvwcx);

	var store_vvvvwcz = jQuery("#jform_store").val();
	var datatype_vvvvwcz = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcz = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcz(store_vvvvwcz,datatype_vvvvwcz,has_defaults_vvvvwcz);

	var datatype_vvvvwda = jQuery("#jform_datatype").val();
	var store_vvvvwda = jQuery("#jform_store").val();
	var has_defaults_vvvvwda = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwda(datatype_vvvvwda,store_vvvvwda,has_defaults_vvvvwda);

	var has_defaults_vvvvwdb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdb = jQuery("#jform_store").val();
	var datatype_vvvvwdb = jQuery("#jform_datatype").val();
	vvvvwdb(has_defaults_vvvvwdb,store_vvvvwdb,datatype_vvvvwdb);

	var has_defaults_vvvvwdc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdc(has_defaults_vvvvwdc);
});

// the vvvvwcp function
function vvvvwcp(datalenght_vvvvwcp,has_defaults_vvvvwcp)
{
	if (isSet(datalenght_vvvvwcp) && datalenght_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = datalenght_vvvvwcp;
		var datalenght_vvvvwcp = [];
		datalenght_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(datalenght_vvvvwcp))
	{
		var datalenght_vvvvwcp = [];
	}
	var datalenght = datalenght_vvvvwcp.some(datalenght_vvvvwcp_SomeFunc);

	if (isSet(has_defaults_vvvvwcp) && has_defaults_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = has_defaults_vvvvwcp;
		var has_defaults_vvvvwcp = [];
		has_defaults_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(has_defaults_vvvvwcp))
	{
		var has_defaults_vvvvwcp = [];
	}
	var has_defaults = has_defaults_vvvvwcp.some(has_defaults_vvvvwcp_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwcpvya_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwcpvya_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwcpvya_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwcpvya_required = true;
		}
	}
}

// the vvvvwcp Some function
function datalenght_vvvvwcp_SomeFunc(datalenght_vvvvwcp)
{
	// set the function logic
	if (datalenght_vvvvwcp == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwcp Some function
function has_defaults_vvvvwcp_SomeFunc(has_defaults_vvvvwcp)
{
	// set the function logic
	if (has_defaults_vvvvwcp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcr function
function vvvvwcr(datadefault_vvvvwcr,has_defaults_vvvvwcr)
{
	if (isSet(datadefault_vvvvwcr) && datadefault_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = datadefault_vvvvwcr;
		var datadefault_vvvvwcr = [];
		datadefault_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(datadefault_vvvvwcr))
	{
		var datadefault_vvvvwcr = [];
	}
	var datadefault = datadefault_vvvvwcr.some(datadefault_vvvvwcr_SomeFunc);

	if (isSet(has_defaults_vvvvwcr) && has_defaults_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = has_defaults_vvvvwcr;
		var has_defaults_vvvvwcr = [];
		has_defaults_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(has_defaults_vvvvwcr))
	{
		var has_defaults_vvvvwcr = [];
	}
	var has_defaults = has_defaults_vvvvwcr.some(has_defaults_vvvvwcr_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwcrvyb_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwcrvyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwcrvyb_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwcrvyb_required = true;
		}
	}
}

// the vvvvwcr Some function
function datadefault_vvvvwcr_SomeFunc(datadefault_vvvvwcr)
{
	// set the function logic
	if (datadefault_vvvvwcr == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwcr Some function
function has_defaults_vvvvwcr_SomeFunc(has_defaults_vvvvwcr)
{
	// set the function logic
	if (has_defaults_vvvvwcr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwct function
function vvvvwct(datatype_vvvvwct,has_defaults_vvvvwct)
{
	if (isSet(datatype_vvvvwct) && datatype_vvvvwct.constructor !== Array)
	{
		var temp_vvvvwct = datatype_vvvvwct;
		var datatype_vvvvwct = [];
		datatype_vvvvwct.push(temp_vvvvwct);
	}
	else if (!isSet(datatype_vvvvwct))
	{
		var datatype_vvvvwct = [];
	}
	var datatype = datatype_vvvvwct.some(datatype_vvvvwct_SomeFunc);

	if (isSet(has_defaults_vvvvwct) && has_defaults_vvvvwct.constructor !== Array)
	{
		var temp_vvvvwct = has_defaults_vvvvwct;
		var has_defaults_vvvvwct = [];
		has_defaults_vvvvwct.push(temp_vvvvwct);
	}
	else if (!isSet(has_defaults_vvvvwct))
	{
		var has_defaults_vvvvwct = [];
	}
	var has_defaults = has_defaults_vvvvwct.some(has_defaults_vvvvwct_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwctvyc_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwctvyc_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwctvyc_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwctvyc_required = true;
		}
	}
}

// the vvvvwct Some function
function datatype_vvvvwct_SomeFunc(datatype_vvvvwct)
{
	// set the function logic
	if (datatype_vvvvwct == 'CHAR' || datatype_vvvvwct == 'VARCHAR' || datatype_vvvvwct == 'INT' || datatype_vvvvwct == 'TINYINT' || datatype_vvvvwct == 'BIGINT' || datatype_vvvvwct == 'FLOAT' || datatype_vvvvwct == 'DECIMAL' || datatype_vvvvwct == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwct Some function
function has_defaults_vvvvwct_SomeFunc(has_defaults_vvvvwct)
{
	// set the function logic
	if (has_defaults_vvvvwct == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcv function
function vvvvwcv(datatype_vvvvwcv,has_defaults_vvvvwcv)
{
	if (isSet(datatype_vvvvwcv) && datatype_vvvvwcv.constructor !== Array)
	{
		var temp_vvvvwcv = datatype_vvvvwcv;
		var datatype_vvvvwcv = [];
		datatype_vvvvwcv.push(temp_vvvvwcv);
	}
	else if (!isSet(datatype_vvvvwcv))
	{
		var datatype_vvvvwcv = [];
	}
	var datatype = datatype_vvvvwcv.some(datatype_vvvvwcv_SomeFunc);

	if (isSet(has_defaults_vvvvwcv) && has_defaults_vvvvwcv.constructor !== Array)
	{
		var temp_vvvvwcv = has_defaults_vvvvwcv;
		var has_defaults_vvvvwcv = [];
		has_defaults_vvvvwcv.push(temp_vvvvwcv);
	}
	else if (!isSet(has_defaults_vvvvwcv))
	{
		var has_defaults_vvvvwcv = [];
	}
	var has_defaults = has_defaults_vvvvwcv.some(has_defaults_vvvvwcv_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcvvyd_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcvvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcvvyd_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcvvyd_required = true;
		}
	}
}

// the vvvvwcv Some function
function datatype_vvvvwcv_SomeFunc(datatype_vvvvwcv)
{
	// set the function logic
	if (datatype_vvvvwcv == 'CHAR' || datatype_vvvvwcv == 'VARCHAR' || datatype_vvvvwcv == 'DATETIME' || datatype_vvvvwcv == 'DATE' || datatype_vvvvwcv == 'TIME' || datatype_vvvvwcv == 'INT' || datatype_vvvvwcv == 'TINYINT' || datatype_vvvvwcv == 'BIGINT' || datatype_vvvvwcv == 'FLOAT' || datatype_vvvvwcv == 'DECIMAL' || datatype_vvvvwcv == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcv Some function
function has_defaults_vvvvwcv_SomeFunc(has_defaults_vvvvwcv)
{
	// set the function logic
	if (has_defaults_vvvvwcv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcw function
function vvvvwcw(has_defaults_vvvvwcw,datatype_vvvvwcw)
{
	if (isSet(has_defaults_vvvvwcw) && has_defaults_vvvvwcw.constructor !== Array)
	{
		var temp_vvvvwcw = has_defaults_vvvvwcw;
		var has_defaults_vvvvwcw = [];
		has_defaults_vvvvwcw.push(temp_vvvvwcw);
	}
	else if (!isSet(has_defaults_vvvvwcw))
	{
		var has_defaults_vvvvwcw = [];
	}
	var has_defaults = has_defaults_vvvvwcw.some(has_defaults_vvvvwcw_SomeFunc);

	if (isSet(datatype_vvvvwcw) && datatype_vvvvwcw.constructor !== Array)
	{
		var temp_vvvvwcw = datatype_vvvvwcw;
		var datatype_vvvvwcw = [];
		datatype_vvvvwcw.push(temp_vvvvwcw);
	}
	else if (!isSet(datatype_vvvvwcw))
	{
		var datatype_vvvvwcw = [];
	}
	var datatype = datatype_vvvvwcw.some(datatype_vvvvwcw_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcwvye_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcwvye_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcwvye_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcwvye_required = true;
		}
	}
}

// the vvvvwcw Some function
function has_defaults_vvvvwcw_SomeFunc(has_defaults_vvvvwcw)
{
	// set the function logic
	if (has_defaults_vvvvwcw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcw Some function
function datatype_vvvvwcw_SomeFunc(datatype_vvvvwcw)
{
	// set the function logic
	if (datatype_vvvvwcw == 'CHAR' || datatype_vvvvwcw == 'VARCHAR' || datatype_vvvvwcw == 'DATETIME' || datatype_vvvvwcw == 'DATE' || datatype_vvvvwcw == 'TIME' || datatype_vvvvwcw == 'INT' || datatype_vvvvwcw == 'TINYINT' || datatype_vvvvwcw == 'BIGINT' || datatype_vvvvwcw == 'FLOAT' || datatype_vvvvwcw == 'DECIMAL' || datatype_vvvvwcw == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcx function
function vvvvwcx(datatype_vvvvwcx,has_defaults_vvvvwcx)
{
	if (isSet(datatype_vvvvwcx) && datatype_vvvvwcx.constructor !== Array)
	{
		var temp_vvvvwcx = datatype_vvvvwcx;
		var datatype_vvvvwcx = [];
		datatype_vvvvwcx.push(temp_vvvvwcx);
	}
	else if (!isSet(datatype_vvvvwcx))
	{
		var datatype_vvvvwcx = [];
	}
	var datatype = datatype_vvvvwcx.some(datatype_vvvvwcx_SomeFunc);

	if (isSet(has_defaults_vvvvwcx) && has_defaults_vvvvwcx.constructor !== Array)
	{
		var temp_vvvvwcx = has_defaults_vvvvwcx;
		var has_defaults_vvvvwcx = [];
		has_defaults_vvvvwcx.push(temp_vvvvwcx);
	}
	else if (!isSet(has_defaults_vvvvwcx))
	{
		var has_defaults_vvvvwcx = [];
	}
	var has_defaults = has_defaults_vvvvwcx.some(has_defaults_vvvvwcx_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwcxvyf_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwcxvyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwcxvyf_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwcxvyf_required = true;
		}
	}
}

// the vvvvwcx Some function
function datatype_vvvvwcx_SomeFunc(datatype_vvvvwcx)
{
	// set the function logic
	if (datatype_vvvvwcx == 'CHAR' || datatype_vvvvwcx == 'VARCHAR' || datatype_vvvvwcx == 'TEXT' || datatype_vvvvwcx == 'MEDIUMTEXT' || datatype_vvvvwcx == 'LONGTEXT' || datatype_vvvvwcx == 'BLOB' || datatype_vvvvwcx == 'TINYBLOB' || datatype_vvvvwcx == 'MEDIUMBLOB' || datatype_vvvvwcx == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcx Some function
function has_defaults_vvvvwcx_SomeFunc(has_defaults_vvvvwcx)
{
	// set the function logic
	if (has_defaults_vvvvwcx == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcz function
function vvvvwcz(store_vvvvwcz,datatype_vvvvwcz,has_defaults_vvvvwcz)
{
	if (isSet(store_vvvvwcz) && store_vvvvwcz.constructor !== Array)
	{
		var temp_vvvvwcz = store_vvvvwcz;
		var store_vvvvwcz = [];
		store_vvvvwcz.push(temp_vvvvwcz);
	}
	else if (!isSet(store_vvvvwcz))
	{
		var store_vvvvwcz = [];
	}
	var store = store_vvvvwcz.some(store_vvvvwcz_SomeFunc);

	if (isSet(datatype_vvvvwcz) && datatype_vvvvwcz.constructor !== Array)
	{
		var temp_vvvvwcz = datatype_vvvvwcz;
		var datatype_vvvvwcz = [];
		datatype_vvvvwcz.push(temp_vvvvwcz);
	}
	else if (!isSet(datatype_vvvvwcz))
	{
		var datatype_vvvvwcz = [];
	}
	var datatype = datatype_vvvvwcz.some(datatype_vvvvwcz_SomeFunc);

	if (isSet(has_defaults_vvvvwcz) && has_defaults_vvvvwcz.constructor !== Array)
	{
		var temp_vvvvwcz = has_defaults_vvvvwcz;
		var has_defaults_vvvvwcz = [];
		has_defaults_vvvvwcz.push(temp_vvvvwcz);
	}
	else if (!isSet(has_defaults_vvvvwcz))
	{
		var has_defaults_vvvvwcz = [];
	}
	var has_defaults = has_defaults_vvvvwcz.some(has_defaults_vvvvwcz_SomeFunc);


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

// the vvvvwcz Some function
function store_vvvvwcz_SomeFunc(store_vvvvwcz)
{
	// set the function logic
	if (store_vvvvwcz == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcz Some function
function datatype_vvvvwcz_SomeFunc(datatype_vvvvwcz)
{
	// set the function logic
	if (datatype_vvvvwcz == 'CHAR' || datatype_vvvvwcz == 'VARCHAR' || datatype_vvvvwcz == 'TEXT' || datatype_vvvvwcz == 'MEDIUMTEXT' || datatype_vvvvwcz == 'LONGTEXT' || datatype_vvvvwcz == 'BLOB' || datatype_vvvvwcz == 'TINYBLOB' || datatype_vvvvwcz == 'MEDIUMBLOB' || datatype_vvvvwcz == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcz Some function
function has_defaults_vvvvwcz_SomeFunc(has_defaults_vvvvwcz)
{
	// set the function logic
	if (has_defaults_vvvvwcz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwda function
function vvvvwda(datatype_vvvvwda,store_vvvvwda,has_defaults_vvvvwda)
{
	if (isSet(datatype_vvvvwda) && datatype_vvvvwda.constructor !== Array)
	{
		var temp_vvvvwda = datatype_vvvvwda;
		var datatype_vvvvwda = [];
		datatype_vvvvwda.push(temp_vvvvwda);
	}
	else if (!isSet(datatype_vvvvwda))
	{
		var datatype_vvvvwda = [];
	}
	var datatype = datatype_vvvvwda.some(datatype_vvvvwda_SomeFunc);

	if (isSet(store_vvvvwda) && store_vvvvwda.constructor !== Array)
	{
		var temp_vvvvwda = store_vvvvwda;
		var store_vvvvwda = [];
		store_vvvvwda.push(temp_vvvvwda);
	}
	else if (!isSet(store_vvvvwda))
	{
		var store_vvvvwda = [];
	}
	var store = store_vvvvwda.some(store_vvvvwda_SomeFunc);

	if (isSet(has_defaults_vvvvwda) && has_defaults_vvvvwda.constructor !== Array)
	{
		var temp_vvvvwda = has_defaults_vvvvwda;
		var has_defaults_vvvvwda = [];
		has_defaults_vvvvwda.push(temp_vvvvwda);
	}
	else if (!isSet(has_defaults_vvvvwda))
	{
		var has_defaults_vvvvwda = [];
	}
	var has_defaults = has_defaults_vvvvwda.some(has_defaults_vvvvwda_SomeFunc);


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

// the vvvvwda Some function
function datatype_vvvvwda_SomeFunc(datatype_vvvvwda)
{
	// set the function logic
	if (datatype_vvvvwda == 'CHAR' || datatype_vvvvwda == 'VARCHAR' || datatype_vvvvwda == 'TEXT' || datatype_vvvvwda == 'MEDIUMTEXT' || datatype_vvvvwda == 'LONGTEXT' || datatype_vvvvwda == 'BLOB' || datatype_vvvvwda == 'TINYBLOB' || datatype_vvvvwda == 'MEDIUMBLOB' || datatype_vvvvwda == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwda Some function
function store_vvvvwda_SomeFunc(store_vvvvwda)
{
	// set the function logic
	if (store_vvvvwda == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwda Some function
function has_defaults_vvvvwda_SomeFunc(has_defaults_vvvvwda)
{
	// set the function logic
	if (has_defaults_vvvvwda == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdb function
function vvvvwdb(has_defaults_vvvvwdb,store_vvvvwdb,datatype_vvvvwdb)
{
	if (isSet(has_defaults_vvvvwdb) && has_defaults_vvvvwdb.constructor !== Array)
	{
		var temp_vvvvwdb = has_defaults_vvvvwdb;
		var has_defaults_vvvvwdb = [];
		has_defaults_vvvvwdb.push(temp_vvvvwdb);
	}
	else if (!isSet(has_defaults_vvvvwdb))
	{
		var has_defaults_vvvvwdb = [];
	}
	var has_defaults = has_defaults_vvvvwdb.some(has_defaults_vvvvwdb_SomeFunc);

	if (isSet(store_vvvvwdb) && store_vvvvwdb.constructor !== Array)
	{
		var temp_vvvvwdb = store_vvvvwdb;
		var store_vvvvwdb = [];
		store_vvvvwdb.push(temp_vvvvwdb);
	}
	else if (!isSet(store_vvvvwdb))
	{
		var store_vvvvwdb = [];
	}
	var store = store_vvvvwdb.some(store_vvvvwdb_SomeFunc);

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
	if (has_defaults && store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwdb Some function
function has_defaults_vvvvwdb_SomeFunc(has_defaults_vvvvwdb)
{
	// set the function logic
	if (has_defaults_vvvvwdb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdb Some function
function store_vvvvwdb_SomeFunc(store_vvvvwdb)
{
	// set the function logic
	if (store_vvvvwdb == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwdb Some function
function datatype_vvvvwdb_SomeFunc(datatype_vvvvwdb)
{
	// set the function logic
	if (datatype_vvvvwdb == 'CHAR' || datatype_vvvvwdb == 'VARCHAR' || datatype_vvvvwdb == 'TEXT' || datatype_vvvvwdb == 'MEDIUMTEXT' || datatype_vvvvwdb == 'LONGTEXT' || datatype_vvvvwdb == 'BLOB' || datatype_vvvvwdb == 'TINYBLOB' || datatype_vvvvwdb == 'MEDIUMBLOB' || datatype_vvvvwdb == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdc function
function vvvvwdc(has_defaults_vvvvwdc)
{
	// set the function logic
	if (has_defaults_vvvvwdc == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwdcvyg_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwdcvyg_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwdcvyh_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwdcvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwdcvyg_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwdcvyg_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwdcvyh_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwdcvyh_required = true;
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
