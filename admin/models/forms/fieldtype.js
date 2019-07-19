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
jform_vvvvwbkvxm_required = false;
jform_vvvvwbmvxn_required = false;
jform_vvvvwbovxo_required = false;
jform_vvvvwbpvxp_required = false;
jform_vvvvwbqvxq_required = false;
jform_vvvvwbvvxr_required = false;
jform_vvvvwbvvxs_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwbk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbk(datalenght_vvvvwbk,has_defaults_vvvvwbk);

	var datadefault_vvvvwbm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbm(datadefault_vvvvwbm,has_defaults_vvvvwbm);

	var datatype_vvvvwbo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbo(datatype_vvvvwbo,has_defaults_vvvvwbo);

	var has_defaults_vvvvwbp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbp = jQuery("#jform_datatype").val();
	vvvvwbp(has_defaults_vvvvwbp,datatype_vvvvwbp);

	var datatype_vvvvwbq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datatype_vvvvwbq,has_defaults_vvvvwbq);

	var store_vvvvwbs = jQuery("#jform_store").val();
	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs);

	var datatype_vvvvwbt = jQuery("#jform_datatype").val();
	var store_vvvvwbt = jQuery("#jform_store").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt);

	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbu = jQuery("#jform_store").val();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu);

	var has_defaults_vvvvwbv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbv(has_defaults_vvvvwbv);
});

// the vvvvwbk function
function vvvvwbk(datalenght_vvvvwbk,has_defaults_vvvvwbk)
{
	if (isSet(datalenght_vvvvwbk) && datalenght_vvvvwbk.constructor !== Array)
	{
		var temp_vvvvwbk = datalenght_vvvvwbk;
		var datalenght_vvvvwbk = [];
		datalenght_vvvvwbk.push(temp_vvvvwbk);
	}
	else if (!isSet(datalenght_vvvvwbk))
	{
		var datalenght_vvvvwbk = [];
	}
	var datalenght = datalenght_vvvvwbk.some(datalenght_vvvvwbk_SomeFunc);

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
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbkvxm_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbkvxm_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbkvxm_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbkvxm_required = true;
		}
	}
}

// the vvvvwbk Some function
function datalenght_vvvvwbk_SomeFunc(datalenght_vvvvwbk)
{
	// set the function logic
	if (datalenght_vvvvwbk == 'Other')
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

// the vvvvwbm function
function vvvvwbm(datadefault_vvvvwbm,has_defaults_vvvvwbm)
{
	if (isSet(datadefault_vvvvwbm) && datadefault_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = datadefault_vvvvwbm;
		var datadefault_vvvvwbm = [];
		datadefault_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(datadefault_vvvvwbm))
	{
		var datadefault_vvvvwbm = [];
	}
	var datadefault = datadefault_vvvvwbm.some(datadefault_vvvvwbm_SomeFunc);

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
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbmvxn_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbmvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbmvxn_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbmvxn_required = true;
		}
	}
}

// the vvvvwbm Some function
function datadefault_vvvvwbm_SomeFunc(datadefault_vvvvwbm)
{
	// set the function logic
	if (datadefault_vvvvwbm == 'Other')
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

// the vvvvwbo function
function vvvvwbo(datatype_vvvvwbo,has_defaults_vvvvwbo)
{
	if (isSet(datatype_vvvvwbo) && datatype_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = datatype_vvvvwbo;
		var datatype_vvvvwbo = [];
		datatype_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(datatype_vvvvwbo))
	{
		var datatype_vvvvwbo = [];
	}
	var datatype = datatype_vvvvwbo.some(datatype_vvvvwbo_SomeFunc);

	if (isSet(has_defaults_vvvvwbo) && has_defaults_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = has_defaults_vvvvwbo;
		var has_defaults_vvvvwbo = [];
		has_defaults_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(has_defaults_vvvvwbo))
	{
		var has_defaults_vvvvwbo = [];
	}
	var has_defaults = has_defaults_vvvvwbo.some(has_defaults_vvvvwbo_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbovxo_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbovxo_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbovxo_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbovxo_required = true;
		}
	}
}

// the vvvvwbo Some function
function datatype_vvvvwbo_SomeFunc(datatype_vvvvwbo)
{
	// set the function logic
	if (datatype_vvvvwbo == 'CHAR' || datatype_vvvvwbo == 'VARCHAR' || datatype_vvvvwbo == 'DATETIME' || datatype_vvvvwbo == 'DATE' || datatype_vvvvwbo == 'TIME' || datatype_vvvvwbo == 'INT' || datatype_vvvvwbo == 'TINYINT' || datatype_vvvvwbo == 'BIGINT' || datatype_vvvvwbo == 'FLOAT' || datatype_vvvvwbo == 'DECIMAL' || datatype_vvvvwbo == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbo Some function
function has_defaults_vvvvwbo_SomeFunc(has_defaults_vvvvwbo)
{
	// set the function logic
	if (has_defaults_vvvvwbo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbp function
function vvvvwbp(has_defaults_vvvvwbp,datatype_vvvvwbp)
{
	if (isSet(has_defaults_vvvvwbp) && has_defaults_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = has_defaults_vvvvwbp;
		var has_defaults_vvvvwbp = [];
		has_defaults_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(has_defaults_vvvvwbp))
	{
		var has_defaults_vvvvwbp = [];
	}
	var has_defaults = has_defaults_vvvvwbp.some(has_defaults_vvvvwbp_SomeFunc);

	if (isSet(datatype_vvvvwbp) && datatype_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = datatype_vvvvwbp;
		var datatype_vvvvwbp = [];
		datatype_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(datatype_vvvvwbp))
	{
		var datatype_vvvvwbp = [];
	}
	var datatype = datatype_vvvvwbp.some(datatype_vvvvwbp_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_datalenght').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbpvxp_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbpvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_datalenght').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbpvxp_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbpvxp_required = true;
		}
	}
}

// the vvvvwbp Some function
function has_defaults_vvvvwbp_SomeFunc(has_defaults_vvvvwbp)
{
	// set the function logic
	if (has_defaults_vvvvwbp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbp Some function
function datatype_vvvvwbp_SomeFunc(datatype_vvvvwbp)
{
	// set the function logic
	if (datatype_vvvvwbp == 'CHAR' || datatype_vvvvwbp == 'VARCHAR' || datatype_vvvvwbp == 'DATETIME' || datatype_vvvvwbp == 'DATE' || datatype_vvvvwbp == 'TIME' || datatype_vvvvwbp == 'INT' || datatype_vvvvwbp == 'TINYINT' || datatype_vvvvwbp == 'BIGINT' || datatype_vvvvwbp == 'FLOAT' || datatype_vvvvwbp == 'DECIMAL' || datatype_vvvvwbp == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbq function
function vvvvwbq(datatype_vvvvwbq,has_defaults_vvvvwbq)
{
	if (isSet(datatype_vvvvwbq) && datatype_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = datatype_vvvvwbq;
		var datatype_vvvvwbq = [];
		datatype_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(datatype_vvvvwbq))
	{
		var datatype_vvvvwbq = [];
	}
	var datatype = datatype_vvvvwbq.some(datatype_vvvvwbq_SomeFunc);

	if (isSet(has_defaults_vvvvwbq) && has_defaults_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = has_defaults_vvvvwbq;
		var has_defaults_vvvvwbq = [];
		has_defaults_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(has_defaults_vvvvwbq))
	{
		var has_defaults_vvvvwbq = [];
	}
	var has_defaults = has_defaults_vvvvwbq.some(has_defaults_vvvvwbq_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbqvxq_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbqvxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbqvxq_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbqvxq_required = true;
		}
	}
}

// the vvvvwbq Some function
function datatype_vvvvwbq_SomeFunc(datatype_vvvvwbq)
{
	// set the function logic
	if (datatype_vvvvwbq == 'CHAR' || datatype_vvvvwbq == 'VARCHAR' || datatype_vvvvwbq == 'TEXT' || datatype_vvvvwbq == 'MEDIUMTEXT' || datatype_vvvvwbq == 'LONGTEXT' || datatype_vvvvwbq == 'BLOB' || datatype_vvvvwbq == 'TINYBLOB' || datatype_vvvvwbq == 'MEDIUMBLOB' || datatype_vvvvwbq == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbq Some function
function has_defaults_vvvvwbq_SomeFunc(has_defaults_vvvvwbq)
{
	// set the function logic
	if (has_defaults_vvvvwbq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbs function
function vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs)
{
	if (isSet(store_vvvvwbs) && store_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = store_vvvvwbs;
		var store_vvvvwbs = [];
		store_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(store_vvvvwbs))
	{
		var store_vvvvwbs = [];
	}
	var store = store_vvvvwbs.some(store_vvvvwbs_SomeFunc);

	if (isSet(datatype_vvvvwbs) && datatype_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = datatype_vvvvwbs;
		var datatype_vvvvwbs = [];
		datatype_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(datatype_vvvvwbs))
	{
		var datatype_vvvvwbs = [];
	}
	var datatype = datatype_vvvvwbs.some(datatype_vvvvwbs_SomeFunc);

	if (isSet(has_defaults_vvvvwbs) && has_defaults_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = has_defaults_vvvvwbs;
		var has_defaults_vvvvwbs = [];
		has_defaults_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(has_defaults_vvvvwbs))
	{
		var has_defaults_vvvvwbs = [];
	}
	var has_defaults = has_defaults_vvvvwbs.some(has_defaults_vvvvwbs_SomeFunc);


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

// the vvvvwbs Some function
function store_vvvvwbs_SomeFunc(store_vvvvwbs)
{
	// set the function logic
	if (store_vvvvwbs == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbs Some function
function datatype_vvvvwbs_SomeFunc(datatype_vvvvwbs)
{
	// set the function logic
	if (datatype_vvvvwbs == 'CHAR' || datatype_vvvvwbs == 'VARCHAR' || datatype_vvvvwbs == 'TEXT' || datatype_vvvvwbs == 'MEDIUMTEXT' || datatype_vvvvwbs == 'LONGTEXT' || datatype_vvvvwbs == 'BLOB' || datatype_vvvvwbs == 'TINYBLOB' || datatype_vvvvwbs == 'MEDIUMBLOB' || datatype_vvvvwbs == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbs Some function
function has_defaults_vvvvwbs_SomeFunc(has_defaults_vvvvwbs)
{
	// set the function logic
	if (has_defaults_vvvvwbs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbt function
function vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt)
{
	if (isSet(datatype_vvvvwbt) && datatype_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = datatype_vvvvwbt;
		var datatype_vvvvwbt = [];
		datatype_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(datatype_vvvvwbt))
	{
		var datatype_vvvvwbt = [];
	}
	var datatype = datatype_vvvvwbt.some(datatype_vvvvwbt_SomeFunc);

	if (isSet(store_vvvvwbt) && store_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = store_vvvvwbt;
		var store_vvvvwbt = [];
		store_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(store_vvvvwbt))
	{
		var store_vvvvwbt = [];
	}
	var store = store_vvvvwbt.some(store_vvvvwbt_SomeFunc);

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
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwbt Some function
function datatype_vvvvwbt_SomeFunc(datatype_vvvvwbt)
{
	// set the function logic
	if (datatype_vvvvwbt == 'CHAR' || datatype_vvvvwbt == 'VARCHAR' || datatype_vvvvwbt == 'TEXT' || datatype_vvvvwbt == 'MEDIUMTEXT' || datatype_vvvvwbt == 'LONGTEXT' || datatype_vvvvwbt == 'BLOB' || datatype_vvvvwbt == 'TINYBLOB' || datatype_vvvvwbt == 'MEDIUMBLOB' || datatype_vvvvwbt == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbt Some function
function store_vvvvwbt_SomeFunc(store_vvvvwbt)
{
	// set the function logic
	if (store_vvvvwbt == 4)
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

// the vvvvwbu function
function vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu)
{
	if (isSet(has_defaults_vvvvwbu) && has_defaults_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = has_defaults_vvvvwbu;
		var has_defaults_vvvvwbu = [];
		has_defaults_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(has_defaults_vvvvwbu))
	{
		var has_defaults_vvvvwbu = [];
	}
	var has_defaults = has_defaults_vvvvwbu.some(has_defaults_vvvvwbu_SomeFunc);

	if (isSet(store_vvvvwbu) && store_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = store_vvvvwbu;
		var store_vvvvwbu = [];
		store_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(store_vvvvwbu))
	{
		var store_vvvvwbu = [];
	}
	var store = store_vvvvwbu.some(store_vvvvwbu_SomeFunc);

	if (isSet(datatype_vvvvwbu) && datatype_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = datatype_vvvvwbu;
		var datatype_vvvvwbu = [];
		datatype_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(datatype_vvvvwbu))
	{
		var datatype_vvvvwbu = [];
	}
	var datatype = datatype_vvvvwbu.some(datatype_vvvvwbu_SomeFunc);


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

// the vvvvwbu Some function
function has_defaults_vvvvwbu_SomeFunc(has_defaults_vvvvwbu)
{
	// set the function logic
	if (has_defaults_vvvvwbu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbu Some function
function store_vvvvwbu_SomeFunc(store_vvvvwbu)
{
	// set the function logic
	if (store_vvvvwbu == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbu Some function
function datatype_vvvvwbu_SomeFunc(datatype_vvvvwbu)
{
	// set the function logic
	if (datatype_vvvvwbu == 'CHAR' || datatype_vvvvwbu == 'VARCHAR' || datatype_vvvvwbu == 'TEXT' || datatype_vvvvwbu == 'MEDIUMTEXT' || datatype_vvvvwbu == 'LONGTEXT' || datatype_vvvvwbu == 'BLOB' || datatype_vvvvwbu == 'TINYBLOB' || datatype_vvvvwbu == 'MEDIUMBLOB' || datatype_vvvvwbu == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbv function
function vvvvwbv(has_defaults_vvvvwbv)
{
	// set the function logic
	if (has_defaults_vvvvwbv == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwbvvxr_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwbvvxr_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwbvvxs_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwbvvxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwbvvxr_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwbvvxr_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwbvvxs_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwbvvxs_required = true;
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
