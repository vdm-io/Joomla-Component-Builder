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
jform_vvvvwdmvye_required = false;
jform_vvvvwdovyf_required = false;
jform_vvvvwdqvyg_required = false;
jform_vvvvwdsvyh_required = false;
jform_vvvvwdtvyi_required = false;
jform_vvvvwduvyj_required = false;
jform_vvvvwdzvyk_required = false;
jform_vvvvwdzvyl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwdm = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwdm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdm(datalenght_vvvvwdm,has_defaults_vvvvwdm);

	var datadefault_vvvvwdo = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwdo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdo(datadefault_vvvvwdo,has_defaults_vvvvwdo);

	var datatype_vvvvwdq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdq(datatype_vvvvwdq,has_defaults_vvvvwdq);

	var datatype_vvvvwds = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwds = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwds(datatype_vvvvwds,has_defaults_vvvvwds);

	var has_defaults_vvvvwdt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwdt = jQuery("#jform_datatype").val();
	vvvvwdt(has_defaults_vvvvwdt,datatype_vvvvwdt);

	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(datatype_vvvvwdu,has_defaults_vvvvwdu);

	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdw(store_vvvvwdw,datatype_vvvvwdw,has_defaults_vvvvwdw);

	var datatype_vvvvwdx = jQuery("#jform_datatype").val();
	var store_vvvvwdx = jQuery("#jform_store").val();
	var has_defaults_vvvvwdx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdx(datatype_vvvvwdx,store_vvvvwdx,has_defaults_vvvvwdx);

	var has_defaults_vvvvwdy = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdy = jQuery("#jform_store").val();
	var datatype_vvvvwdy = jQuery("#jform_datatype").val();
	vvvvwdy(has_defaults_vvvvwdy,store_vvvvwdy,datatype_vvvvwdy);

	var has_defaults_vvvvwdz = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdz(has_defaults_vvvvwdz);
});

// the vvvvwdm function
function vvvvwdm(datalenght_vvvvwdm,has_defaults_vvvvwdm)
{
	if (isSet(datalenght_vvvvwdm) && datalenght_vvvvwdm.constructor !== Array)
	{
		var temp_vvvvwdm = datalenght_vvvvwdm;
		var datalenght_vvvvwdm = [];
		datalenght_vvvvwdm.push(temp_vvvvwdm);
	}
	else if (!isSet(datalenght_vvvvwdm))
	{
		var datalenght_vvvvwdm = [];
	}
	var datalenght = datalenght_vvvvwdm.some(datalenght_vvvvwdm_SomeFunc);

	if (isSet(has_defaults_vvvvwdm) && has_defaults_vvvvwdm.constructor !== Array)
	{
		var temp_vvvvwdm = has_defaults_vvvvwdm;
		var has_defaults_vvvvwdm = [];
		has_defaults_vvvvwdm.push(temp_vvvvwdm);
	}
	else if (!isSet(has_defaults_vvvvwdm))
	{
		var has_defaults_vvvvwdm = [];
	}
	var has_defaults = has_defaults_vvvvwdm.some(has_defaults_vvvvwdm_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwdmvye_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwdmvye_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwdmvye_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwdmvye_required = true;
		}
	}
}

// the vvvvwdm Some function
function datalenght_vvvvwdm_SomeFunc(datalenght_vvvvwdm)
{
	// set the function logic
	if (datalenght_vvvvwdm == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwdm Some function
function has_defaults_vvvvwdm_SomeFunc(has_defaults_vvvvwdm)
{
	// set the function logic
	if (has_defaults_vvvvwdm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdo function
function vvvvwdo(datadefault_vvvvwdo,has_defaults_vvvvwdo)
{
	if (isSet(datadefault_vvvvwdo) && datadefault_vvvvwdo.constructor !== Array)
	{
		var temp_vvvvwdo = datadefault_vvvvwdo;
		var datadefault_vvvvwdo = [];
		datadefault_vvvvwdo.push(temp_vvvvwdo);
	}
	else if (!isSet(datadefault_vvvvwdo))
	{
		var datadefault_vvvvwdo = [];
	}
	var datadefault = datadefault_vvvvwdo.some(datadefault_vvvvwdo_SomeFunc);

	if (isSet(has_defaults_vvvvwdo) && has_defaults_vvvvwdo.constructor !== Array)
	{
		var temp_vvvvwdo = has_defaults_vvvvwdo;
		var has_defaults_vvvvwdo = [];
		has_defaults_vvvvwdo.push(temp_vvvvwdo);
	}
	else if (!isSet(has_defaults_vvvvwdo))
	{
		var has_defaults_vvvvwdo = [];
	}
	var has_defaults = has_defaults_vvvvwdo.some(has_defaults_vvvvwdo_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwdovyf_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwdovyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwdovyf_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwdovyf_required = true;
		}
	}
}

// the vvvvwdo Some function
function datadefault_vvvvwdo_SomeFunc(datadefault_vvvvwdo)
{
	// set the function logic
	if (datadefault_vvvvwdo == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwdo Some function
function has_defaults_vvvvwdo_SomeFunc(has_defaults_vvvvwdo)
{
	// set the function logic
	if (has_defaults_vvvvwdo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdq function
function vvvvwdq(datatype_vvvvwdq,has_defaults_vvvvwdq)
{
	if (isSet(datatype_vvvvwdq) && datatype_vvvvwdq.constructor !== Array)
	{
		var temp_vvvvwdq = datatype_vvvvwdq;
		var datatype_vvvvwdq = [];
		datatype_vvvvwdq.push(temp_vvvvwdq);
	}
	else if (!isSet(datatype_vvvvwdq))
	{
		var datatype_vvvvwdq = [];
	}
	var datatype = datatype_vvvvwdq.some(datatype_vvvvwdq_SomeFunc);

	if (isSet(has_defaults_vvvvwdq) && has_defaults_vvvvwdq.constructor !== Array)
	{
		var temp_vvvvwdq = has_defaults_vvvvwdq;
		var has_defaults_vvvvwdq = [];
		has_defaults_vvvvwdq.push(temp_vvvvwdq);
	}
	else if (!isSet(has_defaults_vvvvwdq))
	{
		var has_defaults_vvvvwdq = [];
	}
	var has_defaults = has_defaults_vvvvwdq.some(has_defaults_vvvvwdq_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwdqvyg_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwdqvyg_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwdqvyg_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwdqvyg_required = true;
		}
	}
}

// the vvvvwdq Some function
function datatype_vvvvwdq_SomeFunc(datatype_vvvvwdq)
{
	// set the function logic
	if (datatype_vvvvwdq == 'CHAR' || datatype_vvvvwdq == 'VARCHAR' || datatype_vvvvwdq == 'INT' || datatype_vvvvwdq == 'TINYINT' || datatype_vvvvwdq == 'BIGINT' || datatype_vvvvwdq == 'FLOAT' || datatype_vvvvwdq == 'DECIMAL' || datatype_vvvvwdq == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwdq Some function
function has_defaults_vvvvwdq_SomeFunc(has_defaults_vvvvwdq)
{
	// set the function logic
	if (has_defaults_vvvvwdq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwds function
function vvvvwds(datatype_vvvvwds,has_defaults_vvvvwds)
{
	if (isSet(datatype_vvvvwds) && datatype_vvvvwds.constructor !== Array)
	{
		var temp_vvvvwds = datatype_vvvvwds;
		var datatype_vvvvwds = [];
		datatype_vvvvwds.push(temp_vvvvwds);
	}
	else if (!isSet(datatype_vvvvwds))
	{
		var datatype_vvvvwds = [];
	}
	var datatype = datatype_vvvvwds.some(datatype_vvvvwds_SomeFunc);

	if (isSet(has_defaults_vvvvwds) && has_defaults_vvvvwds.constructor !== Array)
	{
		var temp_vvvvwds = has_defaults_vvvvwds;
		var has_defaults_vvvvwds = [];
		has_defaults_vvvvwds.push(temp_vvvvwds);
	}
	else if (!isSet(has_defaults_vvvvwds))
	{
		var has_defaults_vvvvwds = [];
	}
	var has_defaults = has_defaults_vvvvwds.some(has_defaults_vvvvwds_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwdsvyh_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwdsvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwdsvyh_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwdsvyh_required = true;
		}
	}
}

// the vvvvwds Some function
function datatype_vvvvwds_SomeFunc(datatype_vvvvwds)
{
	// set the function logic
	if (datatype_vvvvwds == 'CHAR' || datatype_vvvvwds == 'VARCHAR' || datatype_vvvvwds == 'DATETIME' || datatype_vvvvwds == 'DATE' || datatype_vvvvwds == 'TIME' || datatype_vvvvwds == 'INT' || datatype_vvvvwds == 'TINYINT' || datatype_vvvvwds == 'BIGINT' || datatype_vvvvwds == 'FLOAT' || datatype_vvvvwds == 'DECIMAL' || datatype_vvvvwds == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwds Some function
function has_defaults_vvvvwds_SomeFunc(has_defaults_vvvvwds)
{
	// set the function logic
	if (has_defaults_vvvvwds == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdt function
function vvvvwdt(has_defaults_vvvvwdt,datatype_vvvvwdt)
{
	if (isSet(has_defaults_vvvvwdt) && has_defaults_vvvvwdt.constructor !== Array)
	{
		var temp_vvvvwdt = has_defaults_vvvvwdt;
		var has_defaults_vvvvwdt = [];
		has_defaults_vvvvwdt.push(temp_vvvvwdt);
	}
	else if (!isSet(has_defaults_vvvvwdt))
	{
		var has_defaults_vvvvwdt = [];
	}
	var has_defaults = has_defaults_vvvvwdt.some(has_defaults_vvvvwdt_SomeFunc);

	if (isSet(datatype_vvvvwdt) && datatype_vvvvwdt.constructor !== Array)
	{
		var temp_vvvvwdt = datatype_vvvvwdt;
		var datatype_vvvvwdt = [];
		datatype_vvvvwdt.push(temp_vvvvwdt);
	}
	else if (!isSet(datatype_vvvvwdt))
	{
		var datatype_vvvvwdt = [];
	}
	var datatype = datatype_vvvvwdt.some(datatype_vvvvwdt_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwdtvyi_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwdtvyi_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwdtvyi_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwdtvyi_required = true;
		}
	}
}

// the vvvvwdt Some function
function has_defaults_vvvvwdt_SomeFunc(has_defaults_vvvvwdt)
{
	// set the function logic
	if (has_defaults_vvvvwdt == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdt Some function
function datatype_vvvvwdt_SomeFunc(datatype_vvvvwdt)
{
	// set the function logic
	if (datatype_vvvvwdt == 'CHAR' || datatype_vvvvwdt == 'VARCHAR' || datatype_vvvvwdt == 'DATETIME' || datatype_vvvvwdt == 'DATE' || datatype_vvvvwdt == 'TIME' || datatype_vvvvwdt == 'INT' || datatype_vvvvwdt == 'TINYINT' || datatype_vvvvwdt == 'BIGINT' || datatype_vvvvwdt == 'FLOAT' || datatype_vvvvwdt == 'DECIMAL' || datatype_vvvvwdt == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwdu function
function vvvvwdu(datatype_vvvvwdu,has_defaults_vvvvwdu)
{
	if (isSet(datatype_vvvvwdu) && datatype_vvvvwdu.constructor !== Array)
	{
		var temp_vvvvwdu = datatype_vvvvwdu;
		var datatype_vvvvwdu = [];
		datatype_vvvvwdu.push(temp_vvvvwdu);
	}
	else if (!isSet(datatype_vvvvwdu))
	{
		var datatype_vvvvwdu = [];
	}
	var datatype = datatype_vvvvwdu.some(datatype_vvvvwdu_SomeFunc);

	if (isSet(has_defaults_vvvvwdu) && has_defaults_vvvvwdu.constructor !== Array)
	{
		var temp_vvvvwdu = has_defaults_vvvvwdu;
		var has_defaults_vvvvwdu = [];
		has_defaults_vvvvwdu.push(temp_vvvvwdu);
	}
	else if (!isSet(has_defaults_vvvvwdu))
	{
		var has_defaults_vvvvwdu = [];
	}
	var has_defaults = has_defaults_vvvvwdu.some(has_defaults_vvvvwdu_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwduvyj_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwduvyj_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwduvyj_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwduvyj_required = true;
		}
	}
}

// the vvvvwdu Some function
function datatype_vvvvwdu_SomeFunc(datatype_vvvvwdu)
{
	// set the function logic
	if (datatype_vvvvwdu == 'CHAR' || datatype_vvvvwdu == 'VARCHAR' || datatype_vvvvwdu == 'TEXT' || datatype_vvvvwdu == 'MEDIUMTEXT' || datatype_vvvvwdu == 'LONGTEXT' || datatype_vvvvwdu == 'BLOB' || datatype_vvvvwdu == 'TINYBLOB' || datatype_vvvvwdu == 'MEDIUMBLOB' || datatype_vvvvwdu == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdu Some function
function has_defaults_vvvvwdu_SomeFunc(has_defaults_vvvvwdu)
{
	// set the function logic
	if (has_defaults_vvvvwdu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdw function
function vvvvwdw(store_vvvvwdw,datatype_vvvvwdw,has_defaults_vvvvwdw)
{
	if (isSet(store_vvvvwdw) && store_vvvvwdw.constructor !== Array)
	{
		var temp_vvvvwdw = store_vvvvwdw;
		var store_vvvvwdw = [];
		store_vvvvwdw.push(temp_vvvvwdw);
	}
	else if (!isSet(store_vvvvwdw))
	{
		var store_vvvvwdw = [];
	}
	var store = store_vvvvwdw.some(store_vvvvwdw_SomeFunc);

	if (isSet(datatype_vvvvwdw) && datatype_vvvvwdw.constructor !== Array)
	{
		var temp_vvvvwdw = datatype_vvvvwdw;
		var datatype_vvvvwdw = [];
		datatype_vvvvwdw.push(temp_vvvvwdw);
	}
	else if (!isSet(datatype_vvvvwdw))
	{
		var datatype_vvvvwdw = [];
	}
	var datatype = datatype_vvvvwdw.some(datatype_vvvvwdw_SomeFunc);

	if (isSet(has_defaults_vvvvwdw) && has_defaults_vvvvwdw.constructor !== Array)
	{
		var temp_vvvvwdw = has_defaults_vvvvwdw;
		var has_defaults_vvvvwdw = [];
		has_defaults_vvvvwdw.push(temp_vvvvwdw);
	}
	else if (!isSet(has_defaults_vvvvwdw))
	{
		var has_defaults_vvvvwdw = [];
	}
	var has_defaults = has_defaults_vvvvwdw.some(has_defaults_vvvvwdw_SomeFunc);


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

// the vvvvwdw Some function
function store_vvvvwdw_SomeFunc(store_vvvvwdw)
{
	// set the function logic
	if (store_vvvvwdw == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwdw Some function
function datatype_vvvvwdw_SomeFunc(datatype_vvvvwdw)
{
	// set the function logic
	if (datatype_vvvvwdw == 'CHAR' || datatype_vvvvwdw == 'VARCHAR' || datatype_vvvvwdw == 'TEXT' || datatype_vvvvwdw == 'MEDIUMTEXT' || datatype_vvvvwdw == 'LONGTEXT' || datatype_vvvvwdw == 'BLOB' || datatype_vvvvwdw == 'TINYBLOB' || datatype_vvvvwdw == 'MEDIUMBLOB' || datatype_vvvvwdw == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdw Some function
function has_defaults_vvvvwdw_SomeFunc(has_defaults_vvvvwdw)
{
	// set the function logic
	if (has_defaults_vvvvwdw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdx function
function vvvvwdx(datatype_vvvvwdx,store_vvvvwdx,has_defaults_vvvvwdx)
{
	if (isSet(datatype_vvvvwdx) && datatype_vvvvwdx.constructor !== Array)
	{
		var temp_vvvvwdx = datatype_vvvvwdx;
		var datatype_vvvvwdx = [];
		datatype_vvvvwdx.push(temp_vvvvwdx);
	}
	else if (!isSet(datatype_vvvvwdx))
	{
		var datatype_vvvvwdx = [];
	}
	var datatype = datatype_vvvvwdx.some(datatype_vvvvwdx_SomeFunc);

	if (isSet(store_vvvvwdx) && store_vvvvwdx.constructor !== Array)
	{
		var temp_vvvvwdx = store_vvvvwdx;
		var store_vvvvwdx = [];
		store_vvvvwdx.push(temp_vvvvwdx);
	}
	else if (!isSet(store_vvvvwdx))
	{
		var store_vvvvwdx = [];
	}
	var store = store_vvvvwdx.some(store_vvvvwdx_SomeFunc);

	if (isSet(has_defaults_vvvvwdx) && has_defaults_vvvvwdx.constructor !== Array)
	{
		var temp_vvvvwdx = has_defaults_vvvvwdx;
		var has_defaults_vvvvwdx = [];
		has_defaults_vvvvwdx.push(temp_vvvvwdx);
	}
	else if (!isSet(has_defaults_vvvvwdx))
	{
		var has_defaults_vvvvwdx = [];
	}
	var has_defaults = has_defaults_vvvvwdx.some(has_defaults_vvvvwdx_SomeFunc);


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

// the vvvvwdx Some function
function datatype_vvvvwdx_SomeFunc(datatype_vvvvwdx)
{
	// set the function logic
	if (datatype_vvvvwdx == 'CHAR' || datatype_vvvvwdx == 'VARCHAR' || datatype_vvvvwdx == 'TEXT' || datatype_vvvvwdx == 'MEDIUMTEXT' || datatype_vvvvwdx == 'LONGTEXT' || datatype_vvvvwdx == 'BLOB' || datatype_vvvvwdx == 'TINYBLOB' || datatype_vvvvwdx == 'MEDIUMBLOB' || datatype_vvvvwdx == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdx Some function
function store_vvvvwdx_SomeFunc(store_vvvvwdx)
{
	// set the function logic
	if (store_vvvvwdx == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwdx Some function
function has_defaults_vvvvwdx_SomeFunc(has_defaults_vvvvwdx)
{
	// set the function logic
	if (has_defaults_vvvvwdx == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdy function
function vvvvwdy(has_defaults_vvvvwdy,store_vvvvwdy,datatype_vvvvwdy)
{
	if (isSet(has_defaults_vvvvwdy) && has_defaults_vvvvwdy.constructor !== Array)
	{
		var temp_vvvvwdy = has_defaults_vvvvwdy;
		var has_defaults_vvvvwdy = [];
		has_defaults_vvvvwdy.push(temp_vvvvwdy);
	}
	else if (!isSet(has_defaults_vvvvwdy))
	{
		var has_defaults_vvvvwdy = [];
	}
	var has_defaults = has_defaults_vvvvwdy.some(has_defaults_vvvvwdy_SomeFunc);

	if (isSet(store_vvvvwdy) && store_vvvvwdy.constructor !== Array)
	{
		var temp_vvvvwdy = store_vvvvwdy;
		var store_vvvvwdy = [];
		store_vvvvwdy.push(temp_vvvvwdy);
	}
	else if (!isSet(store_vvvvwdy))
	{
		var store_vvvvwdy = [];
	}
	var store = store_vvvvwdy.some(store_vvvvwdy_SomeFunc);

	if (isSet(datatype_vvvvwdy) && datatype_vvvvwdy.constructor !== Array)
	{
		var temp_vvvvwdy = datatype_vvvvwdy;
		var datatype_vvvvwdy = [];
		datatype_vvvvwdy.push(temp_vvvvwdy);
	}
	else if (!isSet(datatype_vvvvwdy))
	{
		var datatype_vvvvwdy = [];
	}
	var datatype = datatype_vvvvwdy.some(datatype_vvvvwdy_SomeFunc);


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

// the vvvvwdy Some function
function has_defaults_vvvvwdy_SomeFunc(has_defaults_vvvvwdy)
{
	// set the function logic
	if (has_defaults_vvvvwdy == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdy Some function
function store_vvvvwdy_SomeFunc(store_vvvvwdy)
{
	// set the function logic
	if (store_vvvvwdy == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwdy Some function
function datatype_vvvvwdy_SomeFunc(datatype_vvvvwdy)
{
	// set the function logic
	if (datatype_vvvvwdy == 'CHAR' || datatype_vvvvwdy == 'VARCHAR' || datatype_vvvvwdy == 'TEXT' || datatype_vvvvwdy == 'MEDIUMTEXT' || datatype_vvvvwdy == 'LONGTEXT' || datatype_vvvvwdy == 'BLOB' || datatype_vvvvwdy == 'TINYBLOB' || datatype_vvvvwdy == 'MEDIUMBLOB' || datatype_vvvvwdy == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdz function
function vvvvwdz(has_defaults_vvvvwdz)
{
	// set the function logic
	if (has_defaults_vvvvwdz == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwdzvyk_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwdzvyk_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwdzvyl_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwdzvyl_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwdzvyk_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwdzvyk_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwdzvyl_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwdzvyl_required = true;
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
