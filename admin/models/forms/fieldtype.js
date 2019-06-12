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
jform_vvvvwbcwaj_required = false;
jform_vvvvwbewak_required = false;
jform_vvvvwbgwal_required = false;
jform_vvvvwbhwam_required = false;
jform_vvvvwbiwan_required = false;
jform_vvvvwbnwao_required = false;
jform_vvvvwbnwap_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwbc = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbc(datalenght_vvvvwbc,has_defaults_vvvvwbc);

	var datadefault_vvvvwbe = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbe = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbe(datadefault_vvvvwbe,has_defaults_vvvvwbe);

	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbg(datatype_vvvvwbg,has_defaults_vvvvwbg);

	var has_defaults_vvvvwbh = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbh = jQuery("#jform_datatype").val();
	vvvvwbh(has_defaults_vvvvwbh,datatype_vvvvwbh);

	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(datatype_vvvvwbi,has_defaults_vvvvwbi);

	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbk(store_vvvvwbk,datatype_vvvvwbk,has_defaults_vvvvwbk);

	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	var store_vvvvwbl = jQuery("#jform_store").val();
	var has_defaults_vvvvwbl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbl(datatype_vvvvwbl,store_vvvvwbl,has_defaults_vvvvwbl);

	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbm = jQuery("#jform_store").val();
	var datatype_vvvvwbm = jQuery("#jform_datatype").val();
	vvvvwbm(has_defaults_vvvvwbm,store_vvvvwbm,datatype_vvvvwbm);

	var has_defaults_vvvvwbn = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbn(has_defaults_vvvvwbn);
});

// the vvvvwbc function
function vvvvwbc(datalenght_vvvvwbc,has_defaults_vvvvwbc)
{
	if (isSet(datalenght_vvvvwbc) && datalenght_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = datalenght_vvvvwbc;
		var datalenght_vvvvwbc = [];
		datalenght_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(datalenght_vvvvwbc))
	{
		var datalenght_vvvvwbc = [];
	}
	var datalenght = datalenght_vvvvwbc.some(datalenght_vvvvwbc_SomeFunc);

	if (isSet(has_defaults_vvvvwbc) && has_defaults_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = has_defaults_vvvvwbc;
		var has_defaults_vvvvwbc = [];
		has_defaults_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(has_defaults_vvvvwbc))
	{
		var has_defaults_vvvvwbc = [];
	}
	var has_defaults = has_defaults_vvvvwbc.some(has_defaults_vvvvwbc_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbcwaj_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbcwaj_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbcwaj_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbcwaj_required = true;
		}
	}
}

// the vvvvwbc Some function
function datalenght_vvvvwbc_SomeFunc(datalenght_vvvvwbc)
{
	// set the function logic
	if (datalenght_vvvvwbc == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbc Some function
function has_defaults_vvvvwbc_SomeFunc(has_defaults_vvvvwbc)
{
	// set the function logic
	if (has_defaults_vvvvwbc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbe function
function vvvvwbe(datadefault_vvvvwbe,has_defaults_vvvvwbe)
{
	if (isSet(datadefault_vvvvwbe) && datadefault_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = datadefault_vvvvwbe;
		var datadefault_vvvvwbe = [];
		datadefault_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(datadefault_vvvvwbe))
	{
		var datadefault_vvvvwbe = [];
	}
	var datadefault = datadefault_vvvvwbe.some(datadefault_vvvvwbe_SomeFunc);

	if (isSet(has_defaults_vvvvwbe) && has_defaults_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = has_defaults_vvvvwbe;
		var has_defaults_vvvvwbe = [];
		has_defaults_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(has_defaults_vvvvwbe))
	{
		var has_defaults_vvvvwbe = [];
	}
	var has_defaults = has_defaults_vvvvwbe.some(has_defaults_vvvvwbe_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbewak_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbewak_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbewak_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbewak_required = true;
		}
	}
}

// the vvvvwbe Some function
function datadefault_vvvvwbe_SomeFunc(datadefault_vvvvwbe)
{
	// set the function logic
	if (datadefault_vvvvwbe == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwbe Some function
function has_defaults_vvvvwbe_SomeFunc(has_defaults_vvvvwbe)
{
	// set the function logic
	if (has_defaults_vvvvwbe == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbg function
function vvvvwbg(datatype_vvvvwbg,has_defaults_vvvvwbg)
{
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


	// set this function logic
	if (datatype && has_defaults)
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
function datatype_vvvvwbg_SomeFunc(datatype_vvvvwbg)
{
	// set the function logic
	if (datatype_vvvvwbg == 'CHAR' || datatype_vvvvwbg == 'VARCHAR' || datatype_vvvvwbg == 'DATETIME' || datatype_vvvvwbg == 'DATE' || datatype_vvvvwbg == 'TIME' || datatype_vvvvwbg == 'INT' || datatype_vvvvwbg == 'TINYINT' || datatype_vvvvwbg == 'BIGINT' || datatype_vvvvwbg == 'FLOAT' || datatype_vvvvwbg == 'DECIMAL' || datatype_vvvvwbg == 'DOUBLE')
	{
		return true;
	}
	return false;
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

// the vvvvwbh function
function vvvvwbh(has_defaults_vvvvwbh,datatype_vvvvwbh)
{
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


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbhwam_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbhwam_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbhwam_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbhwam_required = true;
		}
	}
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

// the vvvvwbh Some function
function datatype_vvvvwbh_SomeFunc(datatype_vvvvwbh)
{
	// set the function logic
	if (datatype_vvvvwbh == 'CHAR' || datatype_vvvvwbh == 'VARCHAR' || datatype_vvvvwbh == 'DATETIME' || datatype_vvvvwbh == 'DATE' || datatype_vvvvwbh == 'TIME' || datatype_vvvvwbh == 'INT' || datatype_vvvvwbh == 'TINYINT' || datatype_vvvvwbh == 'BIGINT' || datatype_vvvvwbh == 'FLOAT' || datatype_vvvvwbh == 'DECIMAL' || datatype_vvvvwbh == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbi function
function vvvvwbi(datatype_vvvvwbi,has_defaults_vvvvwbi)
{
	if (isSet(datatype_vvvvwbi) && datatype_vvvvwbi.constructor !== Array)
	{
		var temp_vvvvwbi = datatype_vvvvwbi;
		var datatype_vvvvwbi = [];
		datatype_vvvvwbi.push(temp_vvvvwbi);
	}
	else if (!isSet(datatype_vvvvwbi))
	{
		var datatype_vvvvwbi = [];
	}
	var datatype = datatype_vvvvwbi.some(datatype_vvvvwbi_SomeFunc);

	if (isSet(has_defaults_vvvvwbi) && has_defaults_vvvvwbi.constructor !== Array)
	{
		var temp_vvvvwbi = has_defaults_vvvvwbi;
		var has_defaults_vvvvwbi = [];
		has_defaults_vvvvwbi.push(temp_vvvvwbi);
	}
	else if (!isSet(has_defaults_vvvvwbi))
	{
		var has_defaults_vvvvwbi = [];
	}
	var has_defaults = has_defaults_vvvvwbi.some(has_defaults_vvvvwbi_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbiwan_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbiwan_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbiwan_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbiwan_required = true;
		}
	}
}

// the vvvvwbi Some function
function datatype_vvvvwbi_SomeFunc(datatype_vvvvwbi)
{
	// set the function logic
	if (datatype_vvvvwbi == 'CHAR' || datatype_vvvvwbi == 'VARCHAR' || datatype_vvvvwbi == 'TEXT' || datatype_vvvvwbi == 'MEDIUMTEXT' || datatype_vvvvwbi == 'LONGTEXT' || datatype_vvvvwbi == 'BLOB' || datatype_vvvvwbi == 'TINYBLOB' || datatype_vvvvwbi == 'MEDIUMBLOB' || datatype_vvvvwbi == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbi Some function
function has_defaults_vvvvwbi_SomeFunc(has_defaults_vvvvwbi)
{
	// set the function logic
	if (has_defaults_vvvvwbi == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbk function
function vvvvwbk(store_vvvvwbk,datatype_vvvvwbk,has_defaults_vvvvwbk)
{
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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwbl(datatype_vvvvwbl,store_vvvvwbl,has_defaults_vvvvwbl)
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
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwbm(has_defaults_vvvvwbm,store_vvvvwbm,datatype_vvvvwbm)
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

	if (isSet(store_vvvvwbm) && store_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = store_vvvvwbm;
		var store_vvvvwbm = [];
		store_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(store_vvvvwbm))
	{
		var store_vvvvwbm = [];
	}
	var store = store_vvvvwbm.some(store_vvvvwbm_SomeFunc);

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
	if (has_defaults && store && datatype)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
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
function store_vvvvwbm_SomeFunc(store_vvvvwbm)
{
	// set the function logic
	if (store_vvvvwbm == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbm Some function
function datatype_vvvvwbm_SomeFunc(datatype_vvvvwbm)
{
	// set the function logic
	if (datatype_vvvvwbm == 'CHAR' || datatype_vvvvwbm == 'VARCHAR' || datatype_vvvvwbm == 'TEXT' || datatype_vvvvwbm == 'MEDIUMTEXT' || datatype_vvvvwbm == 'LONGTEXT' || datatype_vvvvwbm == 'BLOB' || datatype_vvvvwbm == 'TINYBLOB' || datatype_vvvvwbm == 'MEDIUMBLOB' || datatype_vvvvwbm == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(has_defaults_vvvvwbn)
{
	// set the function logic
	if (has_defaults_vvvvwbn == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwbnwao_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwbnwao_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwbnwap_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwbnwap_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwbnwao_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwbnwao_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwbnwap_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwbnwap_required = true;
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
