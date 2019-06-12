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
jform_vvvvwbdwak_required = false;
jform_vvvvwbfwal_required = false;
jform_vvvvwbhwam_required = false;
jform_vvvvwbiwan_required = false;
jform_vvvvwbjwao_required = false;
jform_vvvvwbowap_required = false;
jform_vvvvwbowaq_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwbd = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbd(datalenght_vvvvwbd,has_defaults_vvvvwbd);

	var datadefault_vvvvwbf = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbf(datadefault_vvvvwbf,has_defaults_vvvvwbf);

	var datatype_vvvvwbh = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbh = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbh(datatype_vvvvwbh,has_defaults_vvvvwbh);

	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	vvvvwbi(has_defaults_vvvvwbi,datatype_vvvvwbi);

	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,has_defaults_vvvvwbj);

	var store_vvvvwbl = jQuery("#jform_store").val();
	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbl(store_vvvvwbl,datatype_vvvvwbl,has_defaults_vvvvwbl);

	var datatype_vvvvwbm = jQuery("#jform_datatype").val();
	var store_vvvvwbm = jQuery("#jform_store").val();
	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbm(datatype_vvvvwbm,store_vvvvwbm,has_defaults_vvvvwbm);

	var has_defaults_vvvvwbn = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbn = jQuery("#jform_store").val();
	var datatype_vvvvwbn = jQuery("#jform_datatype").val();
	vvvvwbn(has_defaults_vvvvwbn,store_vvvvwbn,datatype_vvvvwbn);

	var has_defaults_vvvvwbo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbo(has_defaults_vvvvwbo);
});

// the vvvvwbd function
function vvvvwbd(datalenght_vvvvwbd,has_defaults_vvvvwbd)
{
	if (isSet(datalenght_vvvvwbd) && datalenght_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = datalenght_vvvvwbd;
		var datalenght_vvvvwbd = [];
		datalenght_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(datalenght_vvvvwbd))
	{
		var datalenght_vvvvwbd = [];
	}
	var datalenght = datalenght_vvvvwbd.some(datalenght_vvvvwbd_SomeFunc);

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
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbdwak_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbdwak_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbdwak_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbdwak_required = true;
		}
	}
}

// the vvvvwbd Some function
function datalenght_vvvvwbd_SomeFunc(datalenght_vvvvwbd)
{
	// set the function logic
	if (datalenght_vvvvwbd == 'Other')
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
function vvvvwbf(datadefault_vvvvwbf,has_defaults_vvvvwbf)
{
	if (isSet(datadefault_vvvvwbf) && datadefault_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = datadefault_vvvvwbf;
		var datadefault_vvvvwbf = [];
		datadefault_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(datadefault_vvvvwbf))
	{
		var datadefault_vvvvwbf = [];
	}
	var datadefault = datadefault_vvvvwbf.some(datadefault_vvvvwbf_SomeFunc);

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
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbfwal_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbfwal_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbfwal_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbfwal_required = true;
		}
	}
}

// the vvvvwbf Some function
function datadefault_vvvvwbf_SomeFunc(datadefault_vvvvwbf)
{
	// set the function logic
	if (datadefault_vvvvwbf == 'Other')
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
function datatype_vvvvwbh_SomeFunc(datatype_vvvvwbh)
{
	// set the function logic
	if (datatype_vvvvwbh == 'CHAR' || datatype_vvvvwbh == 'VARCHAR' || datatype_vvvvwbh == 'DATETIME' || datatype_vvvvwbh == 'DATE' || datatype_vvvvwbh == 'TIME' || datatype_vvvvwbh == 'INT' || datatype_vvvvwbh == 'TINYINT' || datatype_vvvvwbh == 'BIGINT' || datatype_vvvvwbh == 'FLOAT' || datatype_vvvvwbh == 'DECIMAL' || datatype_vvvvwbh == 'DOUBLE')
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

// the vvvvwbi function
function vvvvwbi(has_defaults_vvvvwbi,datatype_vvvvwbi)
{
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


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbiwan_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbiwan_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbiwan_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbiwan_required = true;
		}
	}
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

// the vvvvwbi Some function
function datatype_vvvvwbi_SomeFunc(datatype_vvvvwbi)
{
	// set the function logic
	if (datatype_vvvvwbi == 'CHAR' || datatype_vvvvwbi == 'VARCHAR' || datatype_vvvvwbi == 'DATETIME' || datatype_vvvvwbi == 'DATE' || datatype_vvvvwbi == 'TIME' || datatype_vvvvwbi == 'INT' || datatype_vvvvwbi == 'TINYINT' || datatype_vvvvwbi == 'BIGINT' || datatype_vvvvwbi == 'FLOAT' || datatype_vvvvwbi == 'DECIMAL' || datatype_vvvvwbi == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbj function
function vvvvwbj(datatype_vvvvwbj,has_defaults_vvvvwbj)
{
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
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbjwao_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbjwao_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbjwao_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbjwao_required = true;
		}
	}
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

// the vvvvwbl function
function vvvvwbl(store_vvvvwbl,datatype_vvvvwbl,has_defaults_vvvvwbl)
{
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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwbm(datatype_vvvvwbm,store_vvvvwbm,has_defaults_vvvvwbm)
{
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
function has_defaults_vvvvwbm_SomeFunc(has_defaults_vvvvwbm)
{
	// set the function logic
	if (has_defaults_vvvvwbm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(has_defaults_vvvvwbn,store_vvvvwbn,datatype_vvvvwbn)
{
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

	if (isSet(store_vvvvwbn) && store_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = store_vvvvwbn;
		var store_vvvvwbn = [];
		store_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(store_vvvvwbn))
	{
		var store_vvvvwbn = [];
	}
	var store = store_vvvvwbn.some(store_vvvvwbn_SomeFunc);

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

// the vvvvwbn Some function
function store_vvvvwbn_SomeFunc(store_vvvvwbn)
{
	// set the function logic
	if (store_vvvvwbn == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwbo function
function vvvvwbo(has_defaults_vvvvwbo)
{
	// set the function logic
	if (has_defaults_vvvvwbo == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwbowap_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwbowap_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwbowaq_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwbowaq_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwbowap_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwbowap_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwbowaq_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwbowaq_required = true;
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
