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
jform_vvvvwbawaf_required = false;
jform_vvvvwbcwag_required = false;
jform_vvvvwbewah_required = false;
jform_vvvvwbfwai_required = false;
jform_vvvvwbgwaj_required = false;
jform_vvvvwblwak_required = false;
jform_vvvvwblwal_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwba = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwba = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwba(datalenght_vvvvwba,has_defaults_vvvvwba);

	var datadefault_vvvvwbc = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbc(datadefault_vvvvwbc,has_defaults_vvvvwbc);

	var datatype_vvvvwbe = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbe = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbe(datatype_vvvvwbe,has_defaults_vvvvwbe);

	var has_defaults_vvvvwbf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbf = jQuery("#jform_datatype").val();
	vvvvwbf(has_defaults_vvvvwbf,datatype_vvvvwbf);

	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbg(datatype_vvvvwbg,has_defaults_vvvvwbg);

	var store_vvvvwbi = jQuery("#jform_store").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi);

	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var store_vvvvwbj = jQuery("#jform_store").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj);

	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk);

	var has_defaults_vvvvwbl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbl(has_defaults_vvvvwbl);
});

// the vvvvwba function
function vvvvwba(datalenght_vvvvwba,has_defaults_vvvvwba)
{
	if (isSet(datalenght_vvvvwba) && datalenght_vvvvwba.constructor !== Array)
	{
		var temp_vvvvwba = datalenght_vvvvwba;
		var datalenght_vvvvwba = [];
		datalenght_vvvvwba.push(temp_vvvvwba);
	}
	else if (!isSet(datalenght_vvvvwba))
	{
		var datalenght_vvvvwba = [];
	}
	var datalenght = datalenght_vvvvwba.some(datalenght_vvvvwba_SomeFunc);

	if (isSet(has_defaults_vvvvwba) && has_defaults_vvvvwba.constructor !== Array)
	{
		var temp_vvvvwba = has_defaults_vvvvwba;
		var has_defaults_vvvvwba = [];
		has_defaults_vvvvwba.push(temp_vvvvwba);
	}
	else if (!isSet(has_defaults_vvvvwba))
	{
		var has_defaults_vvvvwba = [];
	}
	var has_defaults = has_defaults_vvvvwba.some(has_defaults_vvvvwba_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbawaf_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbawaf_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbawaf_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbawaf_required = true;
		}
	}
}

// the vvvvwba Some function
function datalenght_vvvvwba_SomeFunc(datalenght_vvvvwba)
{
	// set the function logic
	if (datalenght_vvvvwba == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwba Some function
function has_defaults_vvvvwba_SomeFunc(has_defaults_vvvvwba)
{
	// set the function logic
	if (has_defaults_vvvvwba == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbc function
function vvvvwbc(datadefault_vvvvwbc,has_defaults_vvvvwbc)
{
	if (isSet(datadefault_vvvvwbc) && datadefault_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = datadefault_vvvvwbc;
		var datadefault_vvvvwbc = [];
		datadefault_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(datadefault_vvvvwbc))
	{
		var datadefault_vvvvwbc = [];
	}
	var datadefault = datadefault_vvvvwbc.some(datadefault_vvvvwbc_SomeFunc);

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
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbcwag_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbcwag_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbcwag_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbcwag_required = true;
		}
	}
}

// the vvvvwbc Some function
function datadefault_vvvvwbc_SomeFunc(datadefault_vvvvwbc)
{
	// set the function logic
	if (datadefault_vvvvwbc == 'Other')
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
function vvvvwbe(datatype_vvvvwbe,has_defaults_vvvvwbe)
{
	if (isSet(datatype_vvvvwbe) && datatype_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = datatype_vvvvwbe;
		var datatype_vvvvwbe = [];
		datatype_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(datatype_vvvvwbe))
	{
		var datatype_vvvvwbe = [];
	}
	var datatype = datatype_vvvvwbe.some(datatype_vvvvwbe_SomeFunc);

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
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbewah_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbewah_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbewah_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbewah_required = true;
		}
	}
}

// the vvvvwbe Some function
function datatype_vvvvwbe_SomeFunc(datatype_vvvvwbe)
{
	// set the function logic
	if (datatype_vvvvwbe == 'CHAR' || datatype_vvvvwbe == 'VARCHAR' || datatype_vvvvwbe == 'DATETIME' || datatype_vvvvwbe == 'DATE' || datatype_vvvvwbe == 'TIME' || datatype_vvvvwbe == 'INT' || datatype_vvvvwbe == 'TINYINT' || datatype_vvvvwbe == 'BIGINT' || datatype_vvvvwbe == 'FLOAT' || datatype_vvvvwbe == 'DECIMAL' || datatype_vvvvwbe == 'DOUBLE')
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

// the vvvvwbf function
function vvvvwbf(has_defaults_vvvvwbf,datatype_vvvvwbf)
{
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


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbfwai_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbfwai_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbfwai_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbfwai_required = true;
		}
	}
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
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbgwaj_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbgwaj_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbgwaj_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbgwaj_required = true;
		}
	}
}

// the vvvvwbg Some function
function datatype_vvvvwbg_SomeFunc(datatype_vvvvwbg)
{
	// set the function logic
	if (datatype_vvvvwbg == 'CHAR' || datatype_vvvvwbg == 'VARCHAR' || datatype_vvvvwbg == 'TEXT' || datatype_vvvvwbg == 'MEDIUMTEXT' || datatype_vvvvwbg == 'LONGTEXT' || datatype_vvvvwbg == 'BLOB' || datatype_vvvvwbg == 'TINYBLOB' || datatype_vvvvwbg == 'MEDIUMBLOB' || datatype_vvvvwbg == 'LONGBLOB')
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

// the vvvvwbi function
function vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi)
{
	if (isSet(store_vvvvwbi) && store_vvvvwbi.constructor !== Array)
	{
		var temp_vvvvwbi = store_vvvvwbi;
		var store_vvvvwbi = [];
		store_vvvvwbi.push(temp_vvvvwbi);
	}
	else if (!isSet(store_vvvvwbi))
	{
		var store_vvvvwbi = [];
	}
	var store = store_vvvvwbi.some(store_vvvvwbi_SomeFunc);

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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwbi Some function
function store_vvvvwbi_SomeFunc(store_vvvvwbi)
{
	// set the function logic
	if (store_vvvvwbi == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwbj function
function vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj)
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
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
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
function vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk)
{
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

// the vvvvwbl function
function vvvvwbl(has_defaults_vvvvwbl)
{
	// set the function logic
	if (has_defaults_vvvvwbl == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwblwak_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwblwak_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwblwal_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwblwal_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwblwak_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwblwak_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwblwal_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwblwal_required = true;
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
				jQuery('<div class="control-group"><div class="control-label"><label>Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
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
