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
jform_vvvvwccvxp_required = false;
jform_vvvvwcevxq_required = false;
jform_vvvvwcgvxr_required = false;
jform_vvvvwchvxs_required = false;
jform_vvvvwcivxt_required = false;
jform_vvvvwcnvxu_required = false;
jform_vvvvwcnvxv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwcc = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcc(datalenght_vvvvwcc,has_defaults_vvvvwcc);

	var datadefault_vvvvwce = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwce = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwce(datadefault_vvvvwce,has_defaults_vvvvwce);

	var datatype_vvvvwcg = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcg(datatype_vvvvwcg,has_defaults_vvvvwcg);

	var has_defaults_vvvvwch = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwch = jQuery("#jform_datatype").val();
	vvvvwch(has_defaults_vvvvwch,datatype_vvvvwch);

	var datatype_vvvvwci = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwci = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwci(datatype_vvvvwci,has_defaults_vvvvwci);

	var store_vvvvwck = jQuery("#jform_store").val();
	var datatype_vvvvwck = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwck = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwck(store_vvvvwck,datatype_vvvvwck,has_defaults_vvvvwck);

	var datatype_vvvvwcl = jQuery("#jform_datatype").val();
	var store_vvvvwcl = jQuery("#jform_store").val();
	var has_defaults_vvvvwcl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcl(datatype_vvvvwcl,store_vvvvwcl,has_defaults_vvvvwcl);

	var has_defaults_vvvvwcm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcm = jQuery("#jform_store").val();
	var datatype_vvvvwcm = jQuery("#jform_datatype").val();
	vvvvwcm(has_defaults_vvvvwcm,store_vvvvwcm,datatype_vvvvwcm);

	var has_defaults_vvvvwcn = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcn(has_defaults_vvvvwcn);
});

// the vvvvwcc function
function vvvvwcc(datalenght_vvvvwcc,has_defaults_vvvvwcc)
{
	if (isSet(datalenght_vvvvwcc) && datalenght_vvvvwcc.constructor !== Array)
	{
		var temp_vvvvwcc = datalenght_vvvvwcc;
		var datalenght_vvvvwcc = [];
		datalenght_vvvvwcc.push(temp_vvvvwcc);
	}
	else if (!isSet(datalenght_vvvvwcc))
	{
		var datalenght_vvvvwcc = [];
	}
	var datalenght = datalenght_vvvvwcc.some(datalenght_vvvvwcc_SomeFunc);

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
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwccvxp_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwccvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwccvxp_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwccvxp_required = true;
		}
	}
}

// the vvvvwcc Some function
function datalenght_vvvvwcc_SomeFunc(datalenght_vvvvwcc)
{
	// set the function logic
	if (datalenght_vvvvwcc == 'Other')
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

// the vvvvwce function
function vvvvwce(datadefault_vvvvwce,has_defaults_vvvvwce)
{
	if (isSet(datadefault_vvvvwce) && datadefault_vvvvwce.constructor !== Array)
	{
		var temp_vvvvwce = datadefault_vvvvwce;
		var datadefault_vvvvwce = [];
		datadefault_vvvvwce.push(temp_vvvvwce);
	}
	else if (!isSet(datadefault_vvvvwce))
	{
		var datadefault_vvvvwce = [];
	}
	var datadefault = datadefault_vvvvwce.some(datadefault_vvvvwce_SomeFunc);

	if (isSet(has_defaults_vvvvwce) && has_defaults_vvvvwce.constructor !== Array)
	{
		var temp_vvvvwce = has_defaults_vvvvwce;
		var has_defaults_vvvvwce = [];
		has_defaults_vvvvwce.push(temp_vvvvwce);
	}
	else if (!isSet(has_defaults_vvvvwce))
	{
		var has_defaults_vvvvwce = [];
	}
	var has_defaults = has_defaults_vvvvwce.some(has_defaults_vvvvwce_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwcevxq_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwcevxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwcevxq_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwcevxq_required = true;
		}
	}
}

// the vvvvwce Some function
function datadefault_vvvvwce_SomeFunc(datadefault_vvvvwce)
{
	// set the function logic
	if (datadefault_vvvvwce == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwce Some function
function has_defaults_vvvvwce_SomeFunc(has_defaults_vvvvwce)
{
	// set the function logic
	if (has_defaults_vvvvwce == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcg function
function vvvvwcg(datatype_vvvvwcg,has_defaults_vvvvwcg)
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
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwcgvxr_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwcgvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwcgvxr_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwcgvxr_required = true;
		}
	}
}

// the vvvvwcg Some function
function datatype_vvvvwcg_SomeFunc(datatype_vvvvwcg)
{
	// set the function logic
	if (datatype_vvvvwcg == 'CHAR' || datatype_vvvvwcg == 'VARCHAR' || datatype_vvvvwcg == 'DATETIME' || datatype_vvvvwcg == 'DATE' || datatype_vvvvwcg == 'TIME' || datatype_vvvvwcg == 'INT' || datatype_vvvvwcg == 'TINYINT' || datatype_vvvvwcg == 'BIGINT' || datatype_vvvvwcg == 'FLOAT' || datatype_vvvvwcg == 'DECIMAL' || datatype_vvvvwcg == 'DOUBLE')
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
function vvvvwch(has_defaults_vvvvwch,datatype_vvvvwch)
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
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwchvxs_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwchvxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwchvxs_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwchvxs_required = true;
		}
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
function datatype_vvvvwch_SomeFunc(datatype_vvvvwch)
{
	// set the function logic
	if (datatype_vvvvwch == 'CHAR' || datatype_vvvvwch == 'VARCHAR' || datatype_vvvvwch == 'DATETIME' || datatype_vvvvwch == 'DATE' || datatype_vvvvwch == 'TIME' || datatype_vvvvwch == 'INT' || datatype_vvvvwch == 'TINYINT' || datatype_vvvvwch == 'BIGINT' || datatype_vvvvwch == 'FLOAT' || datatype_vvvvwch == 'DECIMAL' || datatype_vvvvwch == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwci function
function vvvvwci(datatype_vvvvwci,has_defaults_vvvvwci)
{
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


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwcivxt_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwcivxt_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwcivxt_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwcivxt_required = true;
		}
	}
}

// the vvvvwci Some function
function datatype_vvvvwci_SomeFunc(datatype_vvvvwci)
{
	// set the function logic
	if (datatype_vvvvwci == 'CHAR' || datatype_vvvvwci == 'VARCHAR' || datatype_vvvvwci == 'TEXT' || datatype_vvvvwci == 'MEDIUMTEXT' || datatype_vvvvwci == 'LONGTEXT' || datatype_vvvvwci == 'BLOB' || datatype_vvvvwci == 'TINYBLOB' || datatype_vvvvwci == 'MEDIUMBLOB' || datatype_vvvvwci == 'LONGBLOB')
	{
		return true;
	}
	return false;
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

// the vvvvwck function
function vvvvwck(store_vvvvwck,datatype_vvvvwck,has_defaults_vvvvwck)
{
	if (isSet(store_vvvvwck) && store_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = store_vvvvwck;
		var store_vvvvwck = [];
		store_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(store_vvvvwck))
	{
		var store_vvvvwck = [];
	}
	var store = store_vvvvwck.some(store_vvvvwck_SomeFunc);

	if (isSet(datatype_vvvvwck) && datatype_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = datatype_vvvvwck;
		var datatype_vvvvwck = [];
		datatype_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(datatype_vvvvwck))
	{
		var datatype_vvvvwck = [];
	}
	var datatype = datatype_vvvvwck.some(datatype_vvvvwck_SomeFunc);

	if (isSet(has_defaults_vvvvwck) && has_defaults_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = has_defaults_vvvvwck;
		var has_defaults_vvvvwck = [];
		has_defaults_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(has_defaults_vvvvwck))
	{
		var has_defaults_vvvvwck = [];
	}
	var has_defaults = has_defaults_vvvvwck.some(has_defaults_vvvvwck_SomeFunc);


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

// the vvvvwck Some function
function store_vvvvwck_SomeFunc(store_vvvvwck)
{
	// set the function logic
	if (store_vvvvwck == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwck Some function
function datatype_vvvvwck_SomeFunc(datatype_vvvvwck)
{
	// set the function logic
	if (datatype_vvvvwck == 'CHAR' || datatype_vvvvwck == 'VARCHAR' || datatype_vvvvwck == 'TEXT' || datatype_vvvvwck == 'MEDIUMTEXT' || datatype_vvvvwck == 'LONGTEXT' || datatype_vvvvwck == 'BLOB' || datatype_vvvvwck == 'TINYBLOB' || datatype_vvvvwck == 'MEDIUMBLOB' || datatype_vvvvwck == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwck Some function
function has_defaults_vvvvwck_SomeFunc(has_defaults_vvvvwck)
{
	// set the function logic
	if (has_defaults_vvvvwck == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcl function
function vvvvwcl(datatype_vvvvwcl,store_vvvvwcl,has_defaults_vvvvwcl)
{
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
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwcm(has_defaults_vvvvwcm,store_vvvvwcm,datatype_vvvvwcm)
{
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
function datatype_vvvvwcm_SomeFunc(datatype_vvvvwcm)
{
	// set the function logic
	if (datatype_vvvvwcm == 'CHAR' || datatype_vvvvwcm == 'VARCHAR' || datatype_vvvvwcm == 'TEXT' || datatype_vvvvwcm == 'MEDIUMTEXT' || datatype_vvvvwcm == 'LONGTEXT' || datatype_vvvvwcm == 'BLOB' || datatype_vvvvwcm == 'TINYBLOB' || datatype_vvvvwcm == 'MEDIUMBLOB' || datatype_vvvvwcm == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcn function
function vvvvwcn(has_defaults_vvvvwcn)
{
	// set the function logic
	if (has_defaults_vvvvwcn == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwcnvxu_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwcnvxu_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwcnvxv_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwcnvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwcnvxu_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwcnvxu_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwcnvxv_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwcnvxv_required = true;
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
