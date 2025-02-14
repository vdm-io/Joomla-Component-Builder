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
jform_vvvvwbovxd_required = false;
jform_vvvvwbqvxe_required = false;
jform_vvvvwbsvxf_required = false;
jform_vvvvwbuvxg_required = false;
jform_vvvvwbvvxh_required = false;
jform_vvvvwbwvxi_required = false;
jform_vvvvwcbvxj_required = false;
jform_vvvvwcbvxk_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var datalenght_vvvvwbo = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbo(datalenght_vvvvwbo,has_defaults_vvvvwbo);

	var datadefault_vvvvwbq = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datadefault_vvvvwbq,has_defaults_vvvvwbq);

	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(datatype_vvvvwbs,has_defaults_vvvvwbs);

	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbu(datatype_vvvvwbu,has_defaults_vvvvwbu);

	var has_defaults_vvvvwbv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbv = jQuery("#jform_datatype").val();
	vvvvwbv(has_defaults_vvvvwbv,datatype_vvvvwbv);

	var datatype_vvvvwbw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbw(datatype_vvvvwbw,has_defaults_vvvvwbw);

	var store_vvvvwby = jQuery("#jform_store").val();
	var datatype_vvvvwby = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwby = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwby(store_vvvvwby,datatype_vvvvwby,has_defaults_vvvvwby);

	var datatype_vvvvwbz = jQuery("#jform_datatype").val();
	var store_vvvvwbz = jQuery("#jform_store").val();
	var has_defaults_vvvvwbz = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbz(datatype_vvvvwbz,store_vvvvwbz,has_defaults_vvvvwbz);

	var has_defaults_vvvvwca = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwca = jQuery("#jform_store").val();
	var datatype_vvvvwca = jQuery("#jform_datatype").val();
	vvvvwca(has_defaults_vvvvwca,store_vvvvwca,datatype_vvvvwca);

	var has_defaults_vvvvwcb = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwcb(has_defaults_vvvvwcb);
});

// the vvvvwbo function
function vvvvwbo(datalenght_vvvvwbo,has_defaults_vvvvwbo)
{
	if (isSet(datalenght_vvvvwbo) && datalenght_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = datalenght_vvvvwbo;
		var datalenght_vvvvwbo = [];
		datalenght_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(datalenght_vvvvwbo))
	{
		var datalenght_vvvvwbo = [];
	}
	var datalenght = datalenght_vvvvwbo.some(datalenght_vvvvwbo_SomeFunc);

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
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwbovxd_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwbovxd_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwbovxd_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwbovxd_required = true;
		}
	}
}

// the vvvvwbo Some function
function datalenght_vvvvwbo_SomeFunc(datalenght_vvvvwbo)
{
	// set the function logic
	if (datalenght_vvvvwbo == 'Other')
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

// the vvvvwbq function
function vvvvwbq(datadefault_vvvvwbq,has_defaults_vvvvwbq)
{
	if (isSet(datadefault_vvvvwbq) && datadefault_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = datadefault_vvvvwbq;
		var datadefault_vvvvwbq = [];
		datadefault_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(datadefault_vvvvwbq))
	{
		var datadefault_vvvvwbq = [];
	}
	var datadefault = datadefault_vvvvwbq.some(datadefault_vvvvwbq_SomeFunc);

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
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwbqvxe_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwbqvxe_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwbqvxe_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwbqvxe_required = true;
		}
	}
}

// the vvvvwbq Some function
function datadefault_vvvvwbq_SomeFunc(datadefault_vvvvwbq)
{
	// set the function logic
	if (datadefault_vvvvwbq == 'Other')
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
function vvvvwbs(datatype_vvvvwbs,has_defaults_vvvvwbs)
{
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
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwbsvxf_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwbsvxf_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwbsvxf_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwbsvxf_required = true;
		}
	}
}

// the vvvvwbs Some function
function datatype_vvvvwbs_SomeFunc(datatype_vvvvwbs)
{
	// set the function logic
	if (datatype_vvvvwbs == 'CHAR' || datatype_vvvvwbs == 'VARCHAR' || datatype_vvvvwbs == 'INT' || datatype_vvvvwbs == 'TINYINT' || datatype_vvvvwbs == 'BIGINT' || datatype_vvvvwbs == 'FLOAT' || datatype_vvvvwbs == 'DECIMAL' || datatype_vvvvwbs == 'DOUBLE')
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
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbuvxg_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbuvxg_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbuvxg_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbuvxg_required = true;
		}
	}
}

// the vvvvwbu Some function
function datatype_vvvvwbu_SomeFunc(datatype_vvvvwbu)
{
	// set the function logic
	if (datatype_vvvvwbu == 'CHAR' || datatype_vvvvwbu == 'VARCHAR' || datatype_vvvvwbu == 'DATETIME' || datatype_vvvvwbu == 'DATE' || datatype_vvvvwbu == 'TIME' || datatype_vvvvwbu == 'INT' || datatype_vvvvwbu == 'TINYINT' || datatype_vvvvwbu == 'BIGINT' || datatype_vvvvwbu == 'FLOAT' || datatype_vvvvwbu == 'DECIMAL' || datatype_vvvvwbu == 'DOUBLE')
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

// the vvvvwbv function
function vvvvwbv(has_defaults_vvvvwbv,datatype_vvvvwbv)
{
	if (isSet(has_defaults_vvvvwbv) && has_defaults_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = has_defaults_vvvvwbv;
		var has_defaults_vvvvwbv = [];
		has_defaults_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(has_defaults_vvvvwbv))
	{
		var has_defaults_vvvvwbv = [];
	}
	var has_defaults = has_defaults_vvvvwbv.some(has_defaults_vvvvwbv_SomeFunc);

	if (isSet(datatype_vvvvwbv) && datatype_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = datatype_vvvvwbv;
		var datatype_vvvvwbv = [];
		datatype_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(datatype_vvvvwbv))
	{
		var datatype_vvvvwbv = [];
	}
	var datatype = datatype_vvvvwbv.some(datatype_vvvvwbv_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwbvvxh_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwbvvxh_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwbvvxh_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwbvvxh_required = true;
		}
	}
}

// the vvvvwbv Some function
function has_defaults_vvvvwbv_SomeFunc(has_defaults_vvvvwbv)
{
	// set the function logic
	if (has_defaults_vvvvwbv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbv Some function
function datatype_vvvvwbv_SomeFunc(datatype_vvvvwbv)
{
	// set the function logic
	if (datatype_vvvvwbv == 'CHAR' || datatype_vvvvwbv == 'VARCHAR' || datatype_vvvvwbv == 'DATETIME' || datatype_vvvvwbv == 'DATE' || datatype_vvvvwbv == 'TIME' || datatype_vvvvwbv == 'INT' || datatype_vvvvwbv == 'TINYINT' || datatype_vvvvwbv == 'BIGINT' || datatype_vvvvwbv == 'FLOAT' || datatype_vvvvwbv == 'DECIMAL' || datatype_vvvvwbv == 'DOUBLE')
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
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwbwvxi_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwbwvxi_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwbwvxi_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwbwvxi_required = true;
		}
	}
}

// the vvvvwbw Some function
function datatype_vvvvwbw_SomeFunc(datatype_vvvvwbw)
{
	// set the function logic
	if (datatype_vvvvwbw == 'CHAR' || datatype_vvvvwbw == 'VARCHAR' || datatype_vvvvwbw == 'TEXT' || datatype_vvvvwbw == 'MEDIUMTEXT' || datatype_vvvvwbw == 'LONGTEXT' || datatype_vvvvwbw == 'BLOB' || datatype_vvvvwbw == 'TINYBLOB' || datatype_vvvvwbw == 'MEDIUMBLOB' || datatype_vvvvwbw == 'LONGBLOB')
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

// the vvvvwby function
function vvvvwby(store_vvvvwby,datatype_vvvvwby,has_defaults_vvvvwby)
{
	if (isSet(store_vvvvwby) && store_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = store_vvvvwby;
		var store_vvvvwby = [];
		store_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(store_vvvvwby))
	{
		var store_vvvvwby = [];
	}
	var store = store_vvvvwby.some(store_vvvvwby_SomeFunc);

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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwby Some function
function store_vvvvwby_SomeFunc(store_vvvvwby)
{
	// set the function logic
	if (store_vvvvwby == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwbz function
function vvvvwbz(datatype_vvvvwbz,store_vvvvwbz,has_defaults_vvvvwbz)
{
	if (isSet(datatype_vvvvwbz) && datatype_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = datatype_vvvvwbz;
		var datatype_vvvvwbz = [];
		datatype_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(datatype_vvvvwbz))
	{
		var datatype_vvvvwbz = [];
	}
	var datatype = datatype_vvvvwbz.some(datatype_vvvvwbz_SomeFunc);

	if (isSet(store_vvvvwbz) && store_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = store_vvvvwbz;
		var store_vvvvwbz = [];
		store_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(store_vvvvwbz))
	{
		var store_vvvvwbz = [];
	}
	var store = store_vvvvwbz.some(store_vvvvwbz_SomeFunc);

	if (isSet(has_defaults_vvvvwbz) && has_defaults_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = has_defaults_vvvvwbz;
		var has_defaults_vvvvwbz = [];
		has_defaults_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(has_defaults_vvvvwbz))
	{
		var has_defaults_vvvvwbz = [];
	}
	var has_defaults = has_defaults_vvvvwbz.some(has_defaults_vvvvwbz_SomeFunc);


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

// the vvvvwbz Some function
function datatype_vvvvwbz_SomeFunc(datatype_vvvvwbz)
{
	// set the function logic
	if (datatype_vvvvwbz == 'CHAR' || datatype_vvvvwbz == 'VARCHAR' || datatype_vvvvwbz == 'TEXT' || datatype_vvvvwbz == 'MEDIUMTEXT' || datatype_vvvvwbz == 'LONGTEXT' || datatype_vvvvwbz == 'BLOB' || datatype_vvvvwbz == 'TINYBLOB' || datatype_vvvvwbz == 'MEDIUMBLOB' || datatype_vvvvwbz == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwbz Some function
function store_vvvvwbz_SomeFunc(store_vvvvwbz)
{
	// set the function logic
	if (store_vvvvwbz == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbz Some function
function has_defaults_vvvvwbz_SomeFunc(has_defaults_vvvvwbz)
{
	// set the function logic
	if (has_defaults_vvvvwbz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwca function
function vvvvwca(has_defaults_vvvvwca,store_vvvvwca,datatype_vvvvwca)
{
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

// the vvvvwcb function
function vvvvwcb(has_defaults_vvvvwcb)
{
	// set the function logic
	if (has_defaults_vvvvwcb == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwcbvxj_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwcbvxj_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwcbvxk_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwcbvxk_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwcbvxj_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwcbvxj_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwcbvxk_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwcbvxk_required = true;
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
