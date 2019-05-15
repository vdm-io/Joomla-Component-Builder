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
jform_vvvvwbbwai_required = false;
jform_vvvvwbdwaj_required = false;
jform_vvvvwbfwak_required = false;
jform_vvvvwbgwal_required = false;
jform_vvvvwbhwam_required = false;
jform_vvvvwbmwan_required = false;
jform_vvvvwbmwao_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwbb = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbb(datalenght_vvvvwbb,has_defaults_vvvvwbb);

	var datadefault_vvvvwbd = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbd(datadefault_vvvvwbd,has_defaults_vvvvwbd);

	var datatype_vvvvwbf = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbf(datatype_vvvvwbf,has_defaults_vvvvwbf);

	var has_defaults_vvvvwbg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	vvvvwbg(has_defaults_vvvvwbg,datatype_vvvvwbg);

	var datatype_vvvvwbh = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbh = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbh(datatype_vvvvwbh,has_defaults_vvvvwbh);

	var store_vvvvwbj = jQuery("#jform_store").val();
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(store_vvvvwbj,datatype_vvvvwbj,has_defaults_vvvvwbj);

	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbk(datatype_vvvvwbk,store_vvvvwbk,has_defaults_vvvvwbk);

	var has_defaults_vvvvwbl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbl = jQuery("#jform_store").val();
	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	vvvvwbl(has_defaults_vvvvwbl,store_vvvvwbl,datatype_vvvvwbl);

	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbm(has_defaults_vvvvwbm);
});

// the vvvvwbb function
function vvvvwbb(datalenght_vvvvwbb,has_defaults_vvvvwbb)
{
	if (isSet(datalenght_vvvvwbb) && datalenght_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = datalenght_vvvvwbb;
		var datalenght_vvvvwbb = [];
		datalenght_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(datalenght_vvvvwbb))
	{
		var datalenght_vvvvwbb = [];
	}
	var datalenght = datalenght_vvvvwbb.some(datalenght_vvvvwbb_SomeFunc);

	if (isSet(has_defaults_vvvvwbb) && has_defaults_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = has_defaults_vvvvwbb;
		var has_defaults_vvvvwbb = [];
		has_defaults_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(has_defaults_vvvvwbb))
	{
		var has_defaults_vvvvwbb = [];
	}
	var has_defaults = has_defaults_vvvvwbb.some(has_defaults_vvvvwbb_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbbwai_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbbwai_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbbwai_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbbwai_required = true;
		}
	}
}

// the vvvvwbb Some function
function datalenght_vvvvwbb_SomeFunc(datalenght_vvvvwbb)
{
	// set the function logic
	if (datalenght_vvvvwbb == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbb Some function
function has_defaults_vvvvwbb_SomeFunc(has_defaults_vvvvwbb)
{
	// set the function logic
	if (has_defaults_vvvvwbb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbd function
function vvvvwbd(datadefault_vvvvwbd,has_defaults_vvvvwbd)
{
	if (isSet(datadefault_vvvvwbd) && datadefault_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = datadefault_vvvvwbd;
		var datadefault_vvvvwbd = [];
		datadefault_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(datadefault_vvvvwbd))
	{
		var datadefault_vvvvwbd = [];
	}
	var datadefault = datadefault_vvvvwbd.some(datadefault_vvvvwbd_SomeFunc);

	if (isSet(has_defaults_vvvvwbd) && has_defaults_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = has_defaults_vvvvwbd;
		var has_defaults_vvvvwbd = [];
		has_defaults_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(has_defaults_vvvvwbd))
	{
		var has_defaults_vvvvwbd = [];
	}
	var has_defaults = has_defaults_vvvvwbd.some(has_defaults_vvvvwbd_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbdwaj_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbdwaj_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbdwaj_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbdwaj_required = true;
		}
	}
}

// the vvvvwbd Some function
function datadefault_vvvvwbd_SomeFunc(datadefault_vvvvwbd)
{
	// set the function logic
	if (datadefault_vvvvwbd == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbd Some function
function has_defaults_vvvvwbd_SomeFunc(has_defaults_vvvvwbd)
{
	// set the function logic
	if (has_defaults_vvvvwbd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbf function
function vvvvwbf(datatype_vvvvwbf,has_defaults_vvvvwbf)
{
	if (isSet(datatype_vvvvwbf) && datatype_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = datatype_vvvvwbf;
		var datatype_vvvvwbf = [];
		datatype_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(datatype_vvvvwbf))
	{
		var datatype_vvvvwbf = [];
	}
	var datatype = datatype_vvvvwbf.some(datatype_vvvvwbf_SomeFunc);

	if (isSet(has_defaults_vvvvwbf) && has_defaults_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = has_defaults_vvvvwbf;
		var has_defaults_vvvvwbf = [];
		has_defaults_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(has_defaults_vvvvwbf))
	{
		var has_defaults_vvvvwbf = [];
	}
	var has_defaults = has_defaults_vvvvwbf.some(has_defaults_vvvvwbf_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbfwak_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbfwak_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbfwak_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbfwak_required = true;
		}
	}
}

// the vvvvwbf Some function
function datatype_vvvvwbf_SomeFunc(datatype_vvvvwbf)
{
	// set the function logic
	if (datatype_vvvvwbf == 'CHAR' || datatype_vvvvwbf == 'VARCHAR' || datatype_vvvvwbf == 'DATETIME' || datatype_vvvvwbf == 'DATE' || datatype_vvvvwbf == 'TIME' || datatype_vvvvwbf == 'INT' || datatype_vvvvwbf == 'TINYINT' || datatype_vvvvwbf == 'BIGINT' || datatype_vvvvwbf == 'FLOAT' || datatype_vvvvwbf == 'DECIMAL' || datatype_vvvvwbf == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbf Some function
function has_defaults_vvvvwbf_SomeFunc(has_defaults_vvvvwbf)
{
	// set the function logic
	if (has_defaults_vvvvwbf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbg function
function vvvvwbg(has_defaults_vvvvwbg,datatype_vvvvwbg)
{
	if (isSet(has_defaults_vvvvwbg) && has_defaults_vvvvwbg.constructor !== Array)
	{
		var temp_vvvvwbg = has_defaults_vvvvwbg;
		var has_defaults_vvvvwbg = [];
		has_defaults_vvvvwbg.push(temp_vvvvwbg);
	}
	else if (!isSet(has_defaults_vvvvwbg))
	{
		var has_defaults_vvvvwbg = [];
	}
	var has_defaults = has_defaults_vvvvwbg.some(has_defaults_vvvvwbg_SomeFunc);

	if (isSet(datatype_vvvvwbg) && datatype_vvvvwbg.constructor !== Array)
	{
		var temp_vvvvwbg = datatype_vvvvwbg;
		var datatype_vvvvwbg = [];
		datatype_vvvvwbg.push(temp_vvvvwbg);
	}
	else if (!isSet(datatype_vvvvwbg))
	{
		var datatype_vvvvwbg = [];
	}
	var datatype = datatype_vvvvwbg.some(datatype_vvvvwbg_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbgwal_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbgwal_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbgwal_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbgwal_required = true;
		}
	}
}

// the vvvvwbg Some function
function has_defaults_vvvvwbg_SomeFunc(has_defaults_vvvvwbg)
{
	// set the function logic
	if (has_defaults_vvvvwbg == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbg Some function
function datatype_vvvvwbg_SomeFunc(datatype_vvvvwbg)
{
	// set the function logic
	if (datatype_vvvvwbg == 'CHAR' || datatype_vvvvwbg == 'VARCHAR' || datatype_vvvvwbg == 'DATETIME' || datatype_vvvvwbg == 'DATE' || datatype_vvvvwbg == 'TIME' || datatype_vvvvwbg == 'INT' || datatype_vvvvwbg == 'TINYINT' || datatype_vvvvwbg == 'BIGINT' || datatype_vvvvwbg == 'FLOAT' || datatype_vvvvwbg == 'DECIMAL' || datatype_vvvvwbg == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbh function
function vvvvwbh(datatype_vvvvwbh,has_defaults_vvvvwbh)
{
	if (isSet(datatype_vvvvwbh) && datatype_vvvvwbh.constructor !== Array)
	{
		var temp_vvvvwbh = datatype_vvvvwbh;
		var datatype_vvvvwbh = [];
		datatype_vvvvwbh.push(temp_vvvvwbh);
	}
	else if (!isSet(datatype_vvvvwbh))
	{
		var datatype_vvvvwbh = [];
	}
	var datatype = datatype_vvvvwbh.some(datatype_vvvvwbh_SomeFunc);

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
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbhwam_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbhwam_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbhwam_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbhwam_required = true;
		}
	}
}

// the vvvvwbh Some function
function datatype_vvvvwbh_SomeFunc(datatype_vvvvwbh)
{
	// set the function logic
	if (datatype_vvvvwbh == 'CHAR' || datatype_vvvvwbh == 'VARCHAR' || datatype_vvvvwbh == 'TEXT' || datatype_vvvvwbh == 'MEDIUMTEXT' || datatype_vvvvwbh == 'LONGTEXT' || datatype_vvvvwbh == 'BLOB' || datatype_vvvvwbh == 'TINYBLOB' || datatype_vvvvwbh == 'MEDIUMBLOB' || datatype_vvvvwbh == 'LONGBLOB')
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
function vvvvwbj(store_vvvvwbj,datatype_vvvvwbj,has_defaults_vvvvwbj)
{
	if (isSet(store_vvvvwbj) && store_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = store_vvvvwbj;
		var store_vvvvwbj = [];
		store_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(store_vvvvwbj))
	{
		var store_vvvvwbj = [];
	}
	var store = store_vvvvwbj.some(store_vvvvwbj_SomeFunc);

	if (isSet(datatype_vvvvwbj) && datatype_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = datatype_vvvvwbj;
		var datatype_vvvvwbj = [];
		datatype_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(datatype_vvvvwbj))
	{
		var datatype_vvvvwbj = [];
	}
	var datatype = datatype_vvvvwbj.some(datatype_vvvvwbj_SomeFunc);

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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwbj Some function
function store_vvvvwbj_SomeFunc(store_vvvvwbj)
{
	// set the function logic
	if (store_vvvvwbj == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbj Some function
function datatype_vvvvwbj_SomeFunc(datatype_vvvvwbj)
{
	// set the function logic
	if (datatype_vvvvwbj == 'CHAR' || datatype_vvvvwbj == 'VARCHAR' || datatype_vvvvwbj == 'TEXT' || datatype_vvvvwbj == 'MEDIUMTEXT' || datatype_vvvvwbj == 'LONGTEXT' || datatype_vvvvwbj == 'BLOB' || datatype_vvvvwbj == 'TINYBLOB' || datatype_vvvvwbj == 'MEDIUMBLOB' || datatype_vvvvwbj == 'LONGBLOB')
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

// the vvvvwbk function
function vvvvwbk(datatype_vvvvwbk,store_vvvvwbk,has_defaults_vvvvwbk)
{
	if (isSet(datatype_vvvvwbk) && datatype_vvvvwbk.constructor !== Array)
	{
		var temp_vvvvwbk = datatype_vvvvwbk;
		var datatype_vvvvwbk = [];
		datatype_vvvvwbk.push(temp_vvvvwbk);
	}
	else if (!isSet(datatype_vvvvwbk))
	{
		var datatype_vvvvwbk = [];
	}
	var datatype = datatype_vvvvwbk.some(datatype_vvvvwbk_SomeFunc);

	if (isSet(store_vvvvwbk) && store_vvvvwbk.constructor !== Array)
	{
		var temp_vvvvwbk = store_vvvvwbk;
		var store_vvvvwbk = [];
		store_vvvvwbk.push(temp_vvvvwbk);
	}
	else if (!isSet(store_vvvvwbk))
	{
		var store_vvvvwbk = [];
	}
	var store = store_vvvvwbk.some(store_vvvvwbk_SomeFunc);

	if (isSet(has_defaults_vvvvwbk) && has_defaults_vvvvwbk.constructor !== Array)
	{
		var temp_vvvvwbk = has_defaults_vvvvwbk;
		var has_defaults_vvvvwbk = [];
		has_defaults_vvvvwbk.push(temp_vvvvwbk);
	}
	else if (!isSet(has_defaults_vvvvwbk))
	{
		var has_defaults_vvvvwbk = [];
	}
	var has_defaults = has_defaults_vvvvwbk.some(has_defaults_vvvvwbk_SomeFunc);


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

// the vvvvwbk Some function
function datatype_vvvvwbk_SomeFunc(datatype_vvvvwbk)
{
	// set the function logic
	if (datatype_vvvvwbk == 'CHAR' || datatype_vvvvwbk == 'VARCHAR' || datatype_vvvvwbk == 'TEXT' || datatype_vvvvwbk == 'MEDIUMTEXT' || datatype_vvvvwbk == 'LONGTEXT' || datatype_vvvvwbk == 'BLOB' || datatype_vvvvwbk == 'TINYBLOB' || datatype_vvvvwbk == 'MEDIUMBLOB' || datatype_vvvvwbk == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbk Some function
function store_vvvvwbk_SomeFunc(store_vvvvwbk)
{
	// set the function logic
	if (store_vvvvwbk == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbk Some function
function has_defaults_vvvvwbk_SomeFunc(has_defaults_vvvvwbk)
{
	// set the function logic
	if (has_defaults_vvvvwbk == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbl function
function vvvvwbl(has_defaults_vvvvwbl,store_vvvvwbl,datatype_vvvvwbl)
{
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

	if (isSet(store_vvvvwbl) && store_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = store_vvvvwbl;
		var store_vvvvwbl = [];
		store_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(store_vvvvwbl))
	{
		var store_vvvvwbl = [];
	}
	var store = store_vvvvwbl.some(store_vvvvwbl_SomeFunc);

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

// the vvvvwbl Some function
function store_vvvvwbl_SomeFunc(store_vvvvwbl)
{
	// set the function logic
	if (store_vvvvwbl == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbl Some function
function datatype_vvvvwbl_SomeFunc(datatype_vvvvwbl)
{
	// set the function logic
	if (datatype_vvvvwbl == 'CHAR' || datatype_vvvvwbl == 'VARCHAR' || datatype_vvvvwbl == 'TEXT' || datatype_vvvvwbl == 'MEDIUMTEXT' || datatype_vvvvwbl == 'LONGTEXT' || datatype_vvvvwbl == 'BLOB' || datatype_vvvvwbl == 'TINYBLOB' || datatype_vvvvwbl == 'MEDIUMBLOB' || datatype_vvvvwbl == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbm function
function vvvvwbm(has_defaults_vvvvwbm)
{
	// set the function logic
	if (has_defaults_vvvvwbm == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwbmwan_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwbmwan_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwbmwao_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwbmwao_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwbmwan_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwbmwan_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwbmwao_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwbmwao_required = true;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod;
	if(token.length > 0 && id > 0){
		var request = 'token='+token+'&id='+id+'&return_here='+return_here;
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
