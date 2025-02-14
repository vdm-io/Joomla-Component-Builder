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
jform_vvvvwbqvxk_required = false;
jform_vvvvwbsvxl_required = false;
jform_vvvvwbuvxm_required = false;
jform_vvvvwbwvxn_required = false;
jform_vvvvwbxvxo_required = false;
jform_vvvvwbyvxp_required = false;
jform_vvvvwcdvxq_required = false;
jform_vvvvwcdvxr_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var datalenght_vvvvwbq = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datalenght_vvvvwbq,has_defaults_vvvvwbq);

	var datadefault_vvvvwbs = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(datadefault_vvvvwbs,has_defaults_vvvvwbs);

	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbu(datatype_vvvvwbu,has_defaults_vvvvwbu);

	var datatype_vvvvwbw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbw(datatype_vvvvwbw,has_defaults_vvvvwbw);

	var has_defaults_vvvvwbx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbx = jQuery("#jform_datatype").val();
	vvvvwbx(has_defaults_vvvvwbx,datatype_vvvvwbx);

	var datatype_vvvvwby = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwby = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwby(datatype_vvvvwby,has_defaults_vvvvwby);

	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca);

	var datatype_vvvvwcb = jQuery("#jform_datatype").val();
	var store_vvvvwcb = jQuery("#jform_store").val();
	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb);

	var has_defaults_vvvvwcc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwcc = jQuery("#jform_store").val();
	var datatype_vvvvwcc = jQuery("#jform_datatype").val();
	vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc);

	var has_defaults_vvvvwcd = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcd(has_defaults_vvvvwcd);
});

// the vvvvwbq function
function vvvvwbq(datalenght_vvvvwbq,has_defaults_vvvvwbq)
{
	if (isSet(datalenght_vvvvwbq) && datalenght_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = datalenght_vvvvwbq;
		var datalenght_vvvvwbq = [];
		datalenght_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(datalenght_vvvvwbq))
	{
		var datalenght_vvvvwbq = [];
	}
	var datalenght = datalenght_vvvvwbq.some(datalenght_vvvvwbq_SomeFunc);

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
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbqvxk_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbqvxk_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbqvxk_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbqvxk_required = true;
		}
	}
}

// the vvvvwbq Some function
function datalenght_vvvvwbq_SomeFunc(datalenght_vvvvwbq)
{
	// set the function logic
	if (datalenght_vvvvwbq == 'Other')
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
function vvvvwbs(datadefault_vvvvwbs,has_defaults_vvvvwbs)
{
	if (isSet(datadefault_vvvvwbs) && datadefault_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = datadefault_vvvvwbs;
		var datadefault_vvvvwbs = [];
		datadefault_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(datadefault_vvvvwbs))
	{
		var datadefault_vvvvwbs = [];
	}
	var datadefault = datadefault_vvvvwbs.some(datadefault_vvvvwbs_SomeFunc);

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
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbsvxl_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbsvxl_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbsvxl_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbsvxl_required = true;
		}
	}
}

// the vvvvwbs Some function
function datadefault_vvvvwbs_SomeFunc(datadefault_vvvvwbs)
{
	// set the function logic
	if (datadefault_vvvvwbs == 'Other')
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

// the vvvvwbu function
function vvvvwbu(datatype_vvvvwbu,has_defaults_vvvvwbu)
{
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


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwbuvxm_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwbuvxm_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwbuvxm_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwbuvxm_required = true;
		}
	}
}

// the vvvvwbu Some function
function datatype_vvvvwbu_SomeFunc(datatype_vvvvwbu)
{
	// set the function logic
	if (datatype_vvvvwbu == 'CHAR' || datatype_vvvvwbu == 'VARCHAR' || datatype_vvvvwbu == 'INT' || datatype_vvvvwbu == 'TINYINT' || datatype_vvvvwbu == 'BIGINT' || datatype_vvvvwbu == 'FLOAT' || datatype_vvvvwbu == 'DECIMAL' || datatype_vvvvwbu == 'DOUBLE')
	{
		return true;
	}
	return false;
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

// the vvvvwbw function
function vvvvwbw(datatype_vvvvwbw,has_defaults_vvvvwbw)
{
	if (isSet(datatype_vvvvwbw) && datatype_vvvvwbw.constructor !== Array)
	{
		var temp_vvvvwbw = datatype_vvvvwbw;
		var datatype_vvvvwbw = [];
		datatype_vvvvwbw.push(temp_vvvvwbw);
	}
	else if (!isSet(datatype_vvvvwbw))
	{
		var datatype_vvvvwbw = [];
	}
	var datatype = datatype_vvvvwbw.some(datatype_vvvvwbw_SomeFunc);

	if (isSet(has_defaults_vvvvwbw) && has_defaults_vvvvwbw.constructor !== Array)
	{
		var temp_vvvvwbw = has_defaults_vvvvwbw;
		var has_defaults_vvvvwbw = [];
		has_defaults_vvvvwbw.push(temp_vvvvwbw);
	}
	else if (!isSet(has_defaults_vvvvwbw))
	{
		var has_defaults_vvvvwbw = [];
	}
	var has_defaults = has_defaults_vvvvwbw.some(has_defaults_vvvvwbw_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbwvxn_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbwvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbwvxn_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbwvxn_required = true;
		}
	}
}

// the vvvvwbw Some function
function datatype_vvvvwbw_SomeFunc(datatype_vvvvwbw)
{
	// set the function logic
	if (datatype_vvvvwbw == 'CHAR' || datatype_vvvvwbw == 'VARCHAR' || datatype_vvvvwbw == 'DATETIME' || datatype_vvvvwbw == 'DATE' || datatype_vvvvwbw == 'TIME' || datatype_vvvvwbw == 'INT' || datatype_vvvvwbw == 'TINYINT' || datatype_vvvvwbw == 'BIGINT' || datatype_vvvvwbw == 'FLOAT' || datatype_vvvvwbw == 'DECIMAL' || datatype_vvvvwbw == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwbw Some function
function has_defaults_vvvvwbw_SomeFunc(has_defaults_vvvvwbw)
{
	// set the function logic
	if (has_defaults_vvvvwbw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbx function
function vvvvwbx(has_defaults_vvvvwbx,datatype_vvvvwbx)
{
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


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbxvxo_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbxvxo_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbxvxo_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbxvxo_required = true;
		}
	}
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

// the vvvvwby function
function vvvvwby(datatype_vvvvwby,has_defaults_vvvvwby)
{
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


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbyvxp_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbyvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbyvxp_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbyvxp_required = true;
		}
	}
}

// the vvvvwby Some function
function datatype_vvvvwby_SomeFunc(datatype_vvvvwby)
{
	// set the function logic
	if (datatype_vvvvwby == 'CHAR' || datatype_vvvvwby == 'VARCHAR' || datatype_vvvvwby == 'TEXT' || datatype_vvvvwby == 'MEDIUMTEXT' || datatype_vvvvwby == 'LONGTEXT' || datatype_vvvvwby == 'BLOB' || datatype_vvvvwby == 'TINYBLOB' || datatype_vvvvwby == 'MEDIUMBLOB' || datatype_vvvvwby == 'LONGBLOB')
	{
		return true;
	}
	return false;
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

// the vvvvwca function
function vvvvwca(store_vvvvwca,datatype_vvvvwca,has_defaults_vvvvwca)
{
	if (isSet(store_vvvvwca) && store_vvvvwca.constructor !== Array)
	{
		var temp_vvvvwca = store_vvvvwca;
		var store_vvvvwca = [];
		store_vvvvwca.push(temp_vvvvwca);
	}
	else if (!isSet(store_vvvvwca))
	{
		var store_vvvvwca = [];
	}
	var store = store_vvvvwca.some(store_vvvvwca_SomeFunc);

	if (isSet(datatype_vvvvwca) && datatype_vvvvwca.constructor !== Array)
	{
		var temp_vvvvwca = datatype_vvvvwca;
		var datatype_vvvvwca = [];
		datatype_vvvvwca.push(temp_vvvvwca);
	}
	else if (!isSet(datatype_vvvvwca))
	{
		var datatype_vvvvwca = [];
	}
	var datatype = datatype_vvvvwca.some(datatype_vvvvwca_SomeFunc);

	if (isSet(has_defaults_vvvvwca) && has_defaults_vvvvwca.constructor !== Array)
	{
		var temp_vvvvwca = has_defaults_vvvvwca;
		var has_defaults_vvvvwca = [];
		has_defaults_vvvvwca.push(temp_vvvvwca);
	}
	else if (!isSet(has_defaults_vvvvwca))
	{
		var has_defaults_vvvvwca = [];
	}
	var has_defaults = has_defaults_vvvvwca.some(has_defaults_vvvvwca_SomeFunc);


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

// the vvvvwca Some function
function store_vvvvwca_SomeFunc(store_vvvvwca)
{
	// set the function logic
	if (store_vvvvwca == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwca Some function
function datatype_vvvvwca_SomeFunc(datatype_vvvvwca)
{
	// set the function logic
	if (datatype_vvvvwca == 'CHAR' || datatype_vvvvwca == 'VARCHAR' || datatype_vvvvwca == 'TEXT' || datatype_vvvvwca == 'MEDIUMTEXT' || datatype_vvvvwca == 'LONGTEXT' || datatype_vvvvwca == 'BLOB' || datatype_vvvvwca == 'TINYBLOB' || datatype_vvvvwca == 'MEDIUMBLOB' || datatype_vvvvwca == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwca Some function
function has_defaults_vvvvwca_SomeFunc(has_defaults_vvvvwca)
{
	// set the function logic
	if (has_defaults_vvvvwca == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcb function
function vvvvwcb(datatype_vvvvwcb,store_vvvvwcb,has_defaults_vvvvwcb)
{
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
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwcc(has_defaults_vvvvwcc,store_vvvvwcc,datatype_vvvvwcc)
{
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
function datatype_vvvvwcc_SomeFunc(datatype_vvvvwcc)
{
	// set the function logic
	if (datatype_vvvvwcc == 'CHAR' || datatype_vvvvwcc == 'VARCHAR' || datatype_vvvvwcc == 'TEXT' || datatype_vvvvwcc == 'MEDIUMTEXT' || datatype_vvvvwcc == 'LONGTEXT' || datatype_vvvvwcc == 'BLOB' || datatype_vvvvwcc == 'TINYBLOB' || datatype_vvvvwcc == 'MEDIUMBLOB' || datatype_vvvvwcc == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwcd function
function vvvvwcd(has_defaults_vvvvwcd)
{
	// set the function logic
	if (has_defaults_vvvvwcd == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwcdvxq_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwcdvxq_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwcdvxr_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwcdvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwcdvxq_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwcdvxq_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwcdvxr_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwcdvxr_required = true;
		}
	}
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (document.getElementById('jform_not_required')) {
		var not_required = jQuery('#jform_not_required').val().split(",");

		if(status == 1)
		{
			not_required.push(name);
		}
		else
		{
			not_required = removeFieldFromNotRequired(not_required, name);
		}

		jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());
	}
}

// remove field from not_required
function removeFieldFromNotRequired(array, what) {
	return array.filter(function(element){
		return element !== what;
	});
}

// fix not required array
function fixNotRequiredArray(array) {
	var seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function(item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

// remove empty from not_required array
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		// remove ( 一_一) as well - lol
		return (el.length > 0 && '一_一' !== el);
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

function getEditCustomCodeButtons_server(id) {
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	let requestParams = '';
	if (token.length > 0 && id > 0) {
		requestParams = token+'=1&id='+id+'&return_here='+return_here;
	}
	// Construct URL with parameters for GET request
	const urlWithParams = getUrl + '&' + requestParams;

	// Using the Fetch API for the GET request
	return fetch(urlWithParams, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		return response.json();
	});
}

function getEditCustomCodeButtons() {
	// Get the id using pure JavaScript
	const id = document.querySelector("#jform_id").value;
	getEditCustomCodeButtons_server(id).then(function(result) {
		if (typeof result === 'object') {
			Object.entries(result).forEach(([field, buttons]) => {
				// Creating the div element for buttons
				const div = document.createElement('div');
				div.className = 'control-group';
				div.innerHTML = '<div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div>';

				// Insert the div before .control-wrapper-{field}
				const insertBeforeElement = document.querySelector(".control-wrapper-"+field);
				if (insertBeforeElement) {
					insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);
				}

				// Adding buttons to the div
				Object.entries(buttons).forEach(([name, button]) => {
					const controlsDiv = document.querySelector(".control-customcode-buttons-"+field);
					if (controlsDiv) {
						controlsDiv.innerHTML += button;
					}
				});
			});
		}
	}).catch(error => {
		console.error('Error:', error);
	});
}
