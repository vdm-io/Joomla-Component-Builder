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
jform_vvvvwcevxq_required = false;
jform_vvvvwcgvxr_required = false;
jform_vvvvwcivxs_required = false;
jform_vvvvwckvxt_required = false;
jform_vvvvwclvxu_required = false;
jform_vvvvwcmvxv_required = false;
jform_vvvvwcrvxw_required = false;
jform_vvvvwcrvxx_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwce = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwce = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwce(datalenght_vvvvwce,has_defaults_vvvvwce);

	var datadefault_vvvvwcg = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwcg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcg(datadefault_vvvvwcg,has_defaults_vvvvwcg);

	var datatype_vvvvwci = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwci = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwci(datatype_vvvvwci,has_defaults_vvvvwci);

	var datatype_vvvvwck = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwck = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwck(datatype_vvvvwck,has_defaults_vvvvwck);

	var has_defaults_vvvvwcl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwcl = jQuery("#jform_datatype").val();
	vvvvwcl(has_defaults_vvvvwcl,datatype_vvvvwcl);

	var datatype_vvvvwcm = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwcm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcm(datatype_vvvvwcm,has_defaults_vvvvwcm);

	var store_vvvvwco = jQuery("#jform_store").val();
	var datatype_vvvvwco = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwco = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwco(store_vvvvwco,datatype_vvvvwco,has_defaults_vvvvwco);

	var datatype_vvvvwcp = jQuery("#jform_datatype").val();
	var store_vvvvwcp = jQuery("#jform_store").val();
	var has_defaults_vvvvwcp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcp(datatype_vvvvwcp,store_vvvvwcp,has_defaults_vvvvwcp);

	var has_defaults_vvvvwcq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcq = jQuery("#jform_store").val();
	var datatype_vvvvwcq = jQuery("#jform_datatype").val();
	vvvvwcq(has_defaults_vvvvwcq,store_vvvvwcq,datatype_vvvvwcq);

	var has_defaults_vvvvwcr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcr(has_defaults_vvvvwcr);
});

// the vvvvwce function
function vvvvwce(datalenght_vvvvwce,has_defaults_vvvvwce)
{
	if (isSet(datalenght_vvvvwce) && datalenght_vvvvwce.constructor !== Array)
	{
		var temp_vvvvwce = datalenght_vvvvwce;
		var datalenght_vvvvwce = [];
		datalenght_vvvvwce.push(temp_vvvvwce);
	}
	else if (!isSet(datalenght_vvvvwce))
	{
		var datalenght_vvvvwce = [];
	}
	var datalenght = datalenght_vvvvwce.some(datalenght_vvvvwce_SomeFunc);

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
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwcevxq_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwcevxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwcevxq_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwcevxq_required = true;
		}
	}
}

// the vvvvwce Some function
function datalenght_vvvvwce_SomeFunc(datalenght_vvvvwce)
{
	// set the function logic
	if (datalenght_vvvvwce == 'Other')
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
function vvvvwcg(datadefault_vvvvwcg,has_defaults_vvvvwcg)
{
	if (isSet(datadefault_vvvvwcg) && datadefault_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = datadefault_vvvvwcg;
		var datadefault_vvvvwcg = [];
		datadefault_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(datadefault_vvvvwcg))
	{
		var datadefault_vvvvwcg = [];
	}
	var datadefault = datadefault_vvvvwcg.some(datadefault_vvvvwcg_SomeFunc);

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
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwcgvxr_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwcgvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwcgvxr_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwcgvxr_required = true;
		}
	}
}

// the vvvvwcg Some function
function datadefault_vvvvwcg_SomeFunc(datadefault_vvvvwcg)
{
	// set the function logic
	if (datadefault_vvvvwcg == 'Other')
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
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwcivxs_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwcivxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwcivxs_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwcivxs_required = true;
		}
	}
}

// the vvvvwci Some function
function datatype_vvvvwci_SomeFunc(datatype_vvvvwci)
{
	// set the function logic
	if (datatype_vvvvwci == 'CHAR' || datatype_vvvvwci == 'VARCHAR' || datatype_vvvvwci == 'INT' || datatype_vvvvwci == 'TINYINT' || datatype_vvvvwci == 'BIGINT' || datatype_vvvvwci == 'FLOAT' || datatype_vvvvwci == 'DECIMAL' || datatype_vvvvwci == 'DOUBLE')
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
function vvvvwck(datatype_vvvvwck,has_defaults_vvvvwck)
{
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
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwckvxt_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwckvxt_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwckvxt_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwckvxt_required = true;
		}
	}
}

// the vvvvwck Some function
function datatype_vvvvwck_SomeFunc(datatype_vvvvwck)
{
	// set the function logic
	if (datatype_vvvvwck == 'CHAR' || datatype_vvvvwck == 'VARCHAR' || datatype_vvvvwck == 'DATETIME' || datatype_vvvvwck == 'DATE' || datatype_vvvvwck == 'TIME' || datatype_vvvvwck == 'INT' || datatype_vvvvwck == 'TINYINT' || datatype_vvvvwck == 'BIGINT' || datatype_vvvvwck == 'FLOAT' || datatype_vvvvwck == 'DECIMAL' || datatype_vvvvwck == 'DOUBLE')
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
function vvvvwcl(has_defaults_vvvvwcl,datatype_vvvvwcl)
{
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


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwclvxu_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwclvxu_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwclvxu_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwclvxu_required = true;
		}
	}
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

// the vvvvwcl Some function
function datatype_vvvvwcl_SomeFunc(datatype_vvvvwcl)
{
	// set the function logic
	if (datatype_vvvvwcl == 'CHAR' || datatype_vvvvwcl == 'VARCHAR' || datatype_vvvvwcl == 'DATETIME' || datatype_vvvvwcl == 'DATE' || datatype_vvvvwcl == 'TIME' || datatype_vvvvwcl == 'INT' || datatype_vvvvwcl == 'TINYINT' || datatype_vvvvwcl == 'BIGINT' || datatype_vvvvwcl == 'FLOAT' || datatype_vvvvwcl == 'DECIMAL' || datatype_vvvvwcl == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwcm function
function vvvvwcm(datatype_vvvvwcm,has_defaults_vvvvwcm)
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
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwcmvxv_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwcmvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwcmvxv_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwcmvxv_required = true;
		}
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
function has_defaults_vvvvwcm_SomeFunc(has_defaults_vvvvwcm)
{
	// set the function logic
	if (has_defaults_vvvvwcm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwco function
function vvvvwco(store_vvvvwco,datatype_vvvvwco,has_defaults_vvvvwco)
{
	if (isSet(store_vvvvwco) && store_vvvvwco.constructor !== Array)
	{
		var temp_vvvvwco = store_vvvvwco;
		var store_vvvvwco = [];
		store_vvvvwco.push(temp_vvvvwco);
	}
	else if (!isSet(store_vvvvwco))
	{
		var store_vvvvwco = [];
	}
	var store = store_vvvvwco.some(store_vvvvwco_SomeFunc);

	if (isSet(datatype_vvvvwco) && datatype_vvvvwco.constructor !== Array)
	{
		var temp_vvvvwco = datatype_vvvvwco;
		var datatype_vvvvwco = [];
		datatype_vvvvwco.push(temp_vvvvwco);
	}
	else if (!isSet(datatype_vvvvwco))
	{
		var datatype_vvvvwco = [];
	}
	var datatype = datatype_vvvvwco.some(datatype_vvvvwco_SomeFunc);

	if (isSet(has_defaults_vvvvwco) && has_defaults_vvvvwco.constructor !== Array)
	{
		var temp_vvvvwco = has_defaults_vvvvwco;
		var has_defaults_vvvvwco = [];
		has_defaults_vvvvwco.push(temp_vvvvwco);
	}
	else if (!isSet(has_defaults_vvvvwco))
	{
		var has_defaults_vvvvwco = [];
	}
	var has_defaults = has_defaults_vvvvwco.some(has_defaults_vvvvwco_SomeFunc);


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

// the vvvvwco Some function
function store_vvvvwco_SomeFunc(store_vvvvwco)
{
	// set the function logic
	if (store_vvvvwco == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwco Some function
function datatype_vvvvwco_SomeFunc(datatype_vvvvwco)
{
	// set the function logic
	if (datatype_vvvvwco == 'CHAR' || datatype_vvvvwco == 'VARCHAR' || datatype_vvvvwco == 'TEXT' || datatype_vvvvwco == 'MEDIUMTEXT' || datatype_vvvvwco == 'LONGTEXT' || datatype_vvvvwco == 'BLOB' || datatype_vvvvwco == 'TINYBLOB' || datatype_vvvvwco == 'MEDIUMBLOB' || datatype_vvvvwco == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwco Some function
function has_defaults_vvvvwco_SomeFunc(has_defaults_vvvvwco)
{
	// set the function logic
	if (has_defaults_vvvvwco == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcp function
function vvvvwcp(datatype_vvvvwcp,store_vvvvwcp,has_defaults_vvvvwcp)
{
	if (isSet(datatype_vvvvwcp) && datatype_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = datatype_vvvvwcp;
		var datatype_vvvvwcp = [];
		datatype_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(datatype_vvvvwcp))
	{
		var datatype_vvvvwcp = [];
	}
	var datatype = datatype_vvvvwcp.some(datatype_vvvvwcp_SomeFunc);

	if (isSet(store_vvvvwcp) && store_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = store_vvvvwcp;
		var store_vvvvwcp = [];
		store_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(store_vvvvwcp))
	{
		var store_vvvvwcp = [];
	}
	var store = store_vvvvwcp.some(store_vvvvwcp_SomeFunc);

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
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwcp Some function
function datatype_vvvvwcp_SomeFunc(datatype_vvvvwcp)
{
	// set the function logic
	if (datatype_vvvvwcp == 'CHAR' || datatype_vvvvwcp == 'VARCHAR' || datatype_vvvvwcp == 'TEXT' || datatype_vvvvwcp == 'MEDIUMTEXT' || datatype_vvvvwcp == 'LONGTEXT' || datatype_vvvvwcp == 'BLOB' || datatype_vvvvwcp == 'TINYBLOB' || datatype_vvvvwcp == 'MEDIUMBLOB' || datatype_vvvvwcp == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcp Some function
function store_vvvvwcp_SomeFunc(store_vvvvwcp)
{
	// set the function logic
	if (store_vvvvwcp == 4)
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

// the vvvvwcq function
function vvvvwcq(has_defaults_vvvvwcq,store_vvvvwcq,datatype_vvvvwcq)
{
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

	if (isSet(store_vvvvwcq) && store_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = store_vvvvwcq;
		var store_vvvvwcq = [];
		store_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(store_vvvvwcq))
	{
		var store_vvvvwcq = [];
	}
	var store = store_vvvvwcq.some(store_vvvvwcq_SomeFunc);

	if (isSet(datatype_vvvvwcq) && datatype_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = datatype_vvvvwcq;
		var datatype_vvvvwcq = [];
		datatype_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(datatype_vvvvwcq))
	{
		var datatype_vvvvwcq = [];
	}
	var datatype = datatype_vvvvwcq.some(datatype_vvvvwcq_SomeFunc);


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

// the vvvvwcq Some function
function store_vvvvwcq_SomeFunc(store_vvvvwcq)
{
	// set the function logic
	if (store_vvvvwcq == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcq Some function
function datatype_vvvvwcq_SomeFunc(datatype_vvvvwcq)
{
	// set the function logic
	if (datatype_vvvvwcq == 'CHAR' || datatype_vvvvwcq == 'VARCHAR' || datatype_vvvvwcq == 'TEXT' || datatype_vvvvwcq == 'MEDIUMTEXT' || datatype_vvvvwcq == 'LONGTEXT' || datatype_vvvvwcq == 'BLOB' || datatype_vvvvwcq == 'TINYBLOB' || datatype_vvvvwcq == 'MEDIUMBLOB' || datatype_vvvvwcq == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcr function
function vvvvwcr(has_defaults_vvvvwcr)
{
	// set the function logic
	if (has_defaults_vvvvwcr == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwcrvxw_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwcrvxw_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwcrvxx_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwcrvxx_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwcrvxw_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwcrvxw_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwcrvxx_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwcrvxx_required = true;
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
