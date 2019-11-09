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
jform_vvvvwcqvya_required = false;
jform_vvvvwcsvyb_required = false;
jform_vvvvwcuvyc_required = false;
jform_vvvvwcwvyd_required = false;
jform_vvvvwcxvye_required = false;
jform_vvvvwcyvyf_required = false;
jform_vvvvwddvyg_required = false;
jform_vvvvwddvyh_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwcq = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwcq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcq(datalenght_vvvvwcq,has_defaults_vvvvwcq);

	var datadefault_vvvvwcs = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwcs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcs(datadefault_vvvvwcs,has_defaults_vvvvwcs);

	var datatype_vvvvwcu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcu(datatype_vvvvwcu,has_defaults_vvvvwcu);

	var datatype_vvvvwcw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcw(datatype_vvvvwcw,has_defaults_vvvvwcw);

	var has_defaults_vvvvwcx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwcx = jQuery("#jform_datatype").val();
	vvvvwcx(has_defaults_vvvvwcx,datatype_vvvvwcx);

	var datatype_vvvvwcy = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcy = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcy(datatype_vvvvwcy,has_defaults_vvvvwcy);

	var store_vvvvwda = jQuery("#jform_store").val();
	var datatype_vvvvwda = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwda = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwda(store_vvvvwda,datatype_vvvvwda,has_defaults_vvvvwda);

	var datatype_vvvvwdb = jQuery("#jform_datatype").val();
	var store_vvvvwdb = jQuery("#jform_store").val();
	var has_defaults_vvvvwdb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdb(datatype_vvvvwdb,store_vvvvwdb,has_defaults_vvvvwdb);

	var has_defaults_vvvvwdc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdc = jQuery("#jform_store").val();
	var datatype_vvvvwdc = jQuery("#jform_datatype").val();
	vvvvwdc(has_defaults_vvvvwdc,store_vvvvwdc,datatype_vvvvwdc);

	var has_defaults_vvvvwdd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdd(has_defaults_vvvvwdd);
});

// the vvvvwcq function
function vvvvwcq(datalenght_vvvvwcq,has_defaults_vvvvwcq)
{
	if (isSet(datalenght_vvvvwcq) && datalenght_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = datalenght_vvvvwcq;
		var datalenght_vvvvwcq = [];
		datalenght_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(datalenght_vvvvwcq))
	{
		var datalenght_vvvvwcq = [];
	}
	var datalenght = datalenght_vvvvwcq.some(datalenght_vvvvwcq_SomeFunc);

	if (isSet(has_defaults_vvvvwcq) && has_defaults_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = has_defaults_vvvvwcq;
		var has_defaults_vvvvwcq = [];
		has_defaults_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(has_defaults_vvvvwcq))
	{
		var has_defaults_vvvvwcq = [];
	}
	var has_defaults = has_defaults_vvvvwcq.some(has_defaults_vvvvwcq_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwcqvya_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwcqvya_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwcqvya_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwcqvya_required = true;
		}
	}
}

// the vvvvwcq Some function
function datalenght_vvvvwcq_SomeFunc(datalenght_vvvvwcq)
{
	// set the function logic
	if (datalenght_vvvvwcq == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwcq Some function
function has_defaults_vvvvwcq_SomeFunc(has_defaults_vvvvwcq)
{
	// set the function logic
	if (has_defaults_vvvvwcq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcs function
function vvvvwcs(datadefault_vvvvwcs,has_defaults_vvvvwcs)
{
	if (isSet(datadefault_vvvvwcs) && datadefault_vvvvwcs.constructor !== Array)
	{
		var temp_vvvvwcs = datadefault_vvvvwcs;
		var datadefault_vvvvwcs = [];
		datadefault_vvvvwcs.push(temp_vvvvwcs);
	}
	else if (!isSet(datadefault_vvvvwcs))
	{
		var datadefault_vvvvwcs = [];
	}
	var datadefault = datadefault_vvvvwcs.some(datadefault_vvvvwcs_SomeFunc);

	if (isSet(has_defaults_vvvvwcs) && has_defaults_vvvvwcs.constructor !== Array)
	{
		var temp_vvvvwcs = has_defaults_vvvvwcs;
		var has_defaults_vvvvwcs = [];
		has_defaults_vvvvwcs.push(temp_vvvvwcs);
	}
	else if (!isSet(has_defaults_vvvvwcs))
	{
		var has_defaults_vvvvwcs = [];
	}
	var has_defaults = has_defaults_vvvvwcs.some(has_defaults_vvvvwcs_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwcsvyb_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwcsvyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwcsvyb_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwcsvyb_required = true;
		}
	}
}

// the vvvvwcs Some function
function datadefault_vvvvwcs_SomeFunc(datadefault_vvvvwcs)
{
	// set the function logic
	if (datadefault_vvvvwcs == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwcs Some function
function has_defaults_vvvvwcs_SomeFunc(has_defaults_vvvvwcs)
{
	// set the function logic
	if (has_defaults_vvvvwcs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcu function
function vvvvwcu(datatype_vvvvwcu,has_defaults_vvvvwcu)
{
	if (isSet(datatype_vvvvwcu) && datatype_vvvvwcu.constructor !== Array)
	{
		var temp_vvvvwcu = datatype_vvvvwcu;
		var datatype_vvvvwcu = [];
		datatype_vvvvwcu.push(temp_vvvvwcu);
	}
	else if (!isSet(datatype_vvvvwcu))
	{
		var datatype_vvvvwcu = [];
	}
	var datatype = datatype_vvvvwcu.some(datatype_vvvvwcu_SomeFunc);

	if (isSet(has_defaults_vvvvwcu) && has_defaults_vvvvwcu.constructor !== Array)
	{
		var temp_vvvvwcu = has_defaults_vvvvwcu;
		var has_defaults_vvvvwcu = [];
		has_defaults_vvvvwcu.push(temp_vvvvwcu);
	}
	else if (!isSet(has_defaults_vvvvwcu))
	{
		var has_defaults_vvvvwcu = [];
	}
	var has_defaults = has_defaults_vvvvwcu.some(has_defaults_vvvvwcu_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwcuvyc_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwcuvyc_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwcuvyc_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwcuvyc_required = true;
		}
	}
}

// the vvvvwcu Some function
function datatype_vvvvwcu_SomeFunc(datatype_vvvvwcu)
{
	// set the function logic
	if (datatype_vvvvwcu == 'CHAR' || datatype_vvvvwcu == 'VARCHAR' || datatype_vvvvwcu == 'INT' || datatype_vvvvwcu == 'TINYINT' || datatype_vvvvwcu == 'BIGINT' || datatype_vvvvwcu == 'FLOAT' || datatype_vvvvwcu == 'DECIMAL' || datatype_vvvvwcu == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcu Some function
function has_defaults_vvvvwcu_SomeFunc(has_defaults_vvvvwcu)
{
	// set the function logic
	if (has_defaults_vvvvwcu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcw function
function vvvvwcw(datatype_vvvvwcw,has_defaults_vvvvwcw)
{
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


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcwvyd_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcwvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcwvyd_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcwvyd_required = true;
		}
	}
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

// the vvvvwcx function
function vvvvwcx(has_defaults_vvvvwcx,datatype_vvvvwcx)
{
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


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcxvye_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcxvye_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcxvye_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcxvye_required = true;
		}
	}
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

// the vvvvwcx Some function
function datatype_vvvvwcx_SomeFunc(datatype_vvvvwcx)
{
	// set the function logic
	if (datatype_vvvvwcx == 'CHAR' || datatype_vvvvwcx == 'VARCHAR' || datatype_vvvvwcx == 'DATETIME' || datatype_vvvvwcx == 'DATE' || datatype_vvvvwcx == 'TIME' || datatype_vvvvwcx == 'INT' || datatype_vvvvwcx == 'TINYINT' || datatype_vvvvwcx == 'BIGINT' || datatype_vvvvwcx == 'FLOAT' || datatype_vvvvwcx == 'DECIMAL' || datatype_vvvvwcx == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcy function
function vvvvwcy(datatype_vvvvwcy,has_defaults_vvvvwcy)
{
	if (isSet(datatype_vvvvwcy) && datatype_vvvvwcy.constructor !== Array)
	{
		var temp_vvvvwcy = datatype_vvvvwcy;
		var datatype_vvvvwcy = [];
		datatype_vvvvwcy.push(temp_vvvvwcy);
	}
	else if (!isSet(datatype_vvvvwcy))
	{
		var datatype_vvvvwcy = [];
	}
	var datatype = datatype_vvvvwcy.some(datatype_vvvvwcy_SomeFunc);

	if (isSet(has_defaults_vvvvwcy) && has_defaults_vvvvwcy.constructor !== Array)
	{
		var temp_vvvvwcy = has_defaults_vvvvwcy;
		var has_defaults_vvvvwcy = [];
		has_defaults_vvvvwcy.push(temp_vvvvwcy);
	}
	else if (!isSet(has_defaults_vvvvwcy))
	{
		var has_defaults_vvvvwcy = [];
	}
	var has_defaults = has_defaults_vvvvwcy.some(has_defaults_vvvvwcy_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwcyvyf_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwcyvyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwcyvyf_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwcyvyf_required = true;
		}
	}
}

// the vvvvwcy Some function
function datatype_vvvvwcy_SomeFunc(datatype_vvvvwcy)
{
	// set the function logic
	if (datatype_vvvvwcy == 'CHAR' || datatype_vvvvwcy == 'VARCHAR' || datatype_vvvvwcy == 'TEXT' || datatype_vvvvwcy == 'MEDIUMTEXT' || datatype_vvvvwcy == 'LONGTEXT' || datatype_vvvvwcy == 'BLOB' || datatype_vvvvwcy == 'TINYBLOB' || datatype_vvvvwcy == 'MEDIUMBLOB' || datatype_vvvvwcy == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcy Some function
function has_defaults_vvvvwcy_SomeFunc(has_defaults_vvvvwcy)
{
	// set the function logic
	if (has_defaults_vvvvwcy == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwda function
function vvvvwda(store_vvvvwda,datatype_vvvvwda,has_defaults_vvvvwda)
{
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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwdb(datatype_vvvvwdb,store_vvvvwdb,has_defaults_vvvvwdb)
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
function has_defaults_vvvvwdb_SomeFunc(has_defaults_vvvvwdb)
{
	// set the function logic
	if (has_defaults_vvvvwdb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdc function
function vvvvwdc(has_defaults_vvvvwdc,store_vvvvwdc,datatype_vvvvwdc)
{
	if (isSet(has_defaults_vvvvwdc) && has_defaults_vvvvwdc.constructor !== Array)
	{
		var temp_vvvvwdc = has_defaults_vvvvwdc;
		var has_defaults_vvvvwdc = [];
		has_defaults_vvvvwdc.push(temp_vvvvwdc);
	}
	else if (!isSet(has_defaults_vvvvwdc))
	{
		var has_defaults_vvvvwdc = [];
	}
	var has_defaults = has_defaults_vvvvwdc.some(has_defaults_vvvvwdc_SomeFunc);

	if (isSet(store_vvvvwdc) && store_vvvvwdc.constructor !== Array)
	{
		var temp_vvvvwdc = store_vvvvwdc;
		var store_vvvvwdc = [];
		store_vvvvwdc.push(temp_vvvvwdc);
	}
	else if (!isSet(store_vvvvwdc))
	{
		var store_vvvvwdc = [];
	}
	var store = store_vvvvwdc.some(store_vvvvwdc_SomeFunc);

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
	if (has_defaults && store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwdc Some function
function has_defaults_vvvvwdc_SomeFunc(has_defaults_vvvvwdc)
{
	// set the function logic
	if (has_defaults_vvvvwdc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdc Some function
function store_vvvvwdc_SomeFunc(store_vvvvwdc)
{
	// set the function logic
	if (store_vvvvwdc == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwdc Some function
function datatype_vvvvwdc_SomeFunc(datatype_vvvvwdc)
{
	// set the function logic
	if (datatype_vvvvwdc == 'CHAR' || datatype_vvvvwdc == 'VARCHAR' || datatype_vvvvwdc == 'TEXT' || datatype_vvvvwdc == 'MEDIUMTEXT' || datatype_vvvvwdc == 'LONGTEXT' || datatype_vvvvwdc == 'BLOB' || datatype_vvvvwdc == 'TINYBLOB' || datatype_vvvvwdc == 'MEDIUMBLOB' || datatype_vvvvwdc == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdd function
function vvvvwdd(has_defaults_vvvvwdd)
{
	// set the function logic
	if (has_defaults_vvvvwdd == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwddvyg_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwddvyg_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwddvyh_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwddvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwddvyg_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwddvyg_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwddvyh_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwddvyh_required = true;
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
