/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwdkvxu_required = false;
jform_vvvvwdmvxv_required = false;
jform_vvvvwdovxw_required = false;
jform_vvvvwdqvxx_required = false;
jform_vvvvwdrvxy_required = false;
jform_vvvvwdsvxz_required = false;
jform_vvvvwdxvya_required = false;
jform_vvvvwdxvyb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwdk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwdk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdk(datalenght_vvvvwdk,has_defaults_vvvvwdk);

	var datadefault_vvvvwdm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwdm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdm(datadefault_vvvvwdm,has_defaults_vvvvwdm);

	var datatype_vvvvwdo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdo(datatype_vvvvwdo,has_defaults_vvvvwdo);

	var datatype_vvvvwdq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdq(datatype_vvvvwdq,has_defaults_vvvvwdq);

	var has_defaults_vvvvwdr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwdr = jQuery("#jform_datatype").val();
	vvvvwdr(has_defaults_vvvvwdr,datatype_vvvvwdr);

	var datatype_vvvvwds = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwds = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwds(datatype_vvvvwds,has_defaults_vvvvwds);

	var store_vvvvwdu = jQuery("#jform_store").val();
	var datatype_vvvvwdu = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu);

	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var store_vvvvwdv = jQuery("#jform_store").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv);

	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw);

	var has_defaults_vvvvwdx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdx(has_defaults_vvvvwdx);
});

// the vvvvwdk function
function vvvvwdk(datalenght_vvvvwdk,has_defaults_vvvvwdk)
{
	if (isSet(datalenght_vvvvwdk) && datalenght_vvvvwdk.constructor !== Array)
	{
		var temp_vvvvwdk = datalenght_vvvvwdk;
		var datalenght_vvvvwdk = [];
		datalenght_vvvvwdk.push(temp_vvvvwdk);
	}
	else if (!isSet(datalenght_vvvvwdk))
	{
		var datalenght_vvvvwdk = [];
	}
	var datalenght = datalenght_vvvvwdk.some(datalenght_vvvvwdk_SomeFunc);

	if (isSet(has_defaults_vvvvwdk) && has_defaults_vvvvwdk.constructor !== Array)
	{
		var temp_vvvvwdk = has_defaults_vvvvwdk;
		var has_defaults_vvvvwdk = [];
		has_defaults_vvvvwdk.push(temp_vvvvwdk);
	}
	else if (!isSet(has_defaults_vvvvwdk))
	{
		var has_defaults_vvvvwdk = [];
	}
	var has_defaults = has_defaults_vvvvwdk.some(has_defaults_vvvvwdk_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwdkvxu_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwdkvxu_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwdkvxu_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwdkvxu_required = true;
		}
	}
}

// the vvvvwdk Some function
function datalenght_vvvvwdk_SomeFunc(datalenght_vvvvwdk)
{
	// set the function logic
	if (datalenght_vvvvwdk == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwdk Some function
function has_defaults_vvvvwdk_SomeFunc(has_defaults_vvvvwdk)
{
	// set the function logic
	if (has_defaults_vvvvwdk == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdm function
function vvvvwdm(datadefault_vvvvwdm,has_defaults_vvvvwdm)
{
	if (isSet(datadefault_vvvvwdm) && datadefault_vvvvwdm.constructor !== Array)
	{
		var temp_vvvvwdm = datadefault_vvvvwdm;
		var datadefault_vvvvwdm = [];
		datadefault_vvvvwdm.push(temp_vvvvwdm);
	}
	else if (!isSet(datadefault_vvvvwdm))
	{
		var datadefault_vvvvwdm = [];
	}
	var datadefault = datadefault_vvvvwdm.some(datadefault_vvvvwdm_SomeFunc);

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
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwdmvxv_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwdmvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwdmvxv_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwdmvxv_required = true;
		}
	}
}

// the vvvvwdm Some function
function datadefault_vvvvwdm_SomeFunc(datadefault_vvvvwdm)
{
	// set the function logic
	if (datadefault_vvvvwdm == 'Other')
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
function vvvvwdo(datatype_vvvvwdo,has_defaults_vvvvwdo)
{
	if (isSet(datatype_vvvvwdo) && datatype_vvvvwdo.constructor !== Array)
	{
		var temp_vvvvwdo = datatype_vvvvwdo;
		var datatype_vvvvwdo = [];
		datatype_vvvvwdo.push(temp_vvvvwdo);
	}
	else if (!isSet(datatype_vvvvwdo))
	{
		var datatype_vvvvwdo = [];
	}
	var datatype = datatype_vvvvwdo.some(datatype_vvvvwdo_SomeFunc);

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
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwdovxw_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwdovxw_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwdovxw_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwdovxw_required = true;
		}
	}
}

// the vvvvwdo Some function
function datatype_vvvvwdo_SomeFunc(datatype_vvvvwdo)
{
	// set the function logic
	if (datatype_vvvvwdo == 'CHAR' || datatype_vvvvwdo == 'VARCHAR' || datatype_vvvvwdo == 'INT' || datatype_vvvvwdo == 'TINYINT' || datatype_vvvvwdo == 'BIGINT' || datatype_vvvvwdo == 'FLOAT' || datatype_vvvvwdo == 'DECIMAL' || datatype_vvvvwdo == 'DOUBLE')
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
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwdqvxx_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwdqvxx_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwdqvxx_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwdqvxx_required = true;
		}
	}
}

// the vvvvwdq Some function
function datatype_vvvvwdq_SomeFunc(datatype_vvvvwdq)
{
	// set the function logic
	if (datatype_vvvvwdq == 'CHAR' || datatype_vvvvwdq == 'VARCHAR' || datatype_vvvvwdq == 'DATETIME' || datatype_vvvvwdq == 'DATE' || datatype_vvvvwdq == 'TIME' || datatype_vvvvwdq == 'INT' || datatype_vvvvwdq == 'TINYINT' || datatype_vvvvwdq == 'BIGINT' || datatype_vvvvwdq == 'FLOAT' || datatype_vvvvwdq == 'DECIMAL' || datatype_vvvvwdq == 'DOUBLE')
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

// the vvvvwdr function
function vvvvwdr(has_defaults_vvvvwdr,datatype_vvvvwdr)
{
	if (isSet(has_defaults_vvvvwdr) && has_defaults_vvvvwdr.constructor !== Array)
	{
		var temp_vvvvwdr = has_defaults_vvvvwdr;
		var has_defaults_vvvvwdr = [];
		has_defaults_vvvvwdr.push(temp_vvvvwdr);
	}
	else if (!isSet(has_defaults_vvvvwdr))
	{
		var has_defaults_vvvvwdr = [];
	}
	var has_defaults = has_defaults_vvvvwdr.some(has_defaults_vvvvwdr_SomeFunc);

	if (isSet(datatype_vvvvwdr) && datatype_vvvvwdr.constructor !== Array)
	{
		var temp_vvvvwdr = datatype_vvvvwdr;
		var datatype_vvvvwdr = [];
		datatype_vvvvwdr.push(temp_vvvvwdr);
	}
	else if (!isSet(datatype_vvvvwdr))
	{
		var datatype_vvvvwdr = [];
	}
	var datatype = datatype_vvvvwdr.some(datatype_vvvvwdr_SomeFunc);


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwdrvxy_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwdrvxy_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwdrvxy_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwdrvxy_required = true;
		}
	}
}

// the vvvvwdr Some function
function has_defaults_vvvvwdr_SomeFunc(has_defaults_vvvvwdr)
{
	// set the function logic
	if (has_defaults_vvvvwdr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdr Some function
function datatype_vvvvwdr_SomeFunc(datatype_vvvvwdr)
{
	// set the function logic
	if (datatype_vvvvwdr == 'CHAR' || datatype_vvvvwdr == 'VARCHAR' || datatype_vvvvwdr == 'DATETIME' || datatype_vvvvwdr == 'DATE' || datatype_vvvvwdr == 'TIME' || datatype_vvvvwdr == 'INT' || datatype_vvvvwdr == 'TINYINT' || datatype_vvvvwdr == 'BIGINT' || datatype_vvvvwdr == 'FLOAT' || datatype_vvvvwdr == 'DECIMAL' || datatype_vvvvwdr == 'DOUBLE')
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
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwdsvxz_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwdsvxz_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwdsvxz_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwdsvxz_required = true;
		}
	}
}

// the vvvvwds Some function
function datatype_vvvvwds_SomeFunc(datatype_vvvvwds)
{
	// set the function logic
	if (datatype_vvvvwds == 'CHAR' || datatype_vvvvwds == 'VARCHAR' || datatype_vvvvwds == 'TEXT' || datatype_vvvvwds == 'MEDIUMTEXT' || datatype_vvvvwds == 'LONGTEXT' || datatype_vvvvwds == 'BLOB' || datatype_vvvvwds == 'TINYBLOB' || datatype_vvvvwds == 'MEDIUMBLOB' || datatype_vvvvwds == 'LONGBLOB')
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

// the vvvvwdu function
function vvvvwdu(store_vvvvwdu,datatype_vvvvwdu,has_defaults_vvvvwdu)
{
	if (isSet(store_vvvvwdu) && store_vvvvwdu.constructor !== Array)
	{
		var temp_vvvvwdu = store_vvvvwdu;
		var store_vvvvwdu = [];
		store_vvvvwdu.push(temp_vvvvwdu);
	}
	else if (!isSet(store_vvvvwdu))
	{
		var store_vvvvwdu = [];
	}
	var store = store_vvvvwdu.some(store_vvvvwdu_SomeFunc);

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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
}

// the vvvvwdu Some function
function store_vvvvwdu_SomeFunc(store_vvvvwdu)
{
	// set the function logic
	if (store_vvvvwdu == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwdv function
function vvvvwdv(datatype_vvvvwdv,store_vvvvwdv,has_defaults_vvvvwdv)
{
	if (isSet(datatype_vvvvwdv) && datatype_vvvvwdv.constructor !== Array)
	{
		var temp_vvvvwdv = datatype_vvvvwdv;
		var datatype_vvvvwdv = [];
		datatype_vvvvwdv.push(temp_vvvvwdv);
	}
	else if (!isSet(datatype_vvvvwdv))
	{
		var datatype_vvvvwdv = [];
	}
	var datatype = datatype_vvvvwdv.some(datatype_vvvvwdv_SomeFunc);

	if (isSet(store_vvvvwdv) && store_vvvvwdv.constructor !== Array)
	{
		var temp_vvvvwdv = store_vvvvwdv;
		var store_vvvvwdv = [];
		store_vvvvwdv.push(temp_vvvvwdv);
	}
	else if (!isSet(store_vvvvwdv))
	{
		var store_vvvvwdv = [];
	}
	var store = store_vvvvwdv.some(store_vvvvwdv_SomeFunc);

	if (isSet(has_defaults_vvvvwdv) && has_defaults_vvvvwdv.constructor !== Array)
	{
		var temp_vvvvwdv = has_defaults_vvvvwdv;
		var has_defaults_vvvvwdv = [];
		has_defaults_vvvvwdv.push(temp_vvvvwdv);
	}
	else if (!isSet(has_defaults_vvvvwdv))
	{
		var has_defaults_vvvvwdv = [];
	}
	var has_defaults = has_defaults_vvvvwdv.some(has_defaults_vvvvwdv_SomeFunc);


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

// the vvvvwdv Some function
function datatype_vvvvwdv_SomeFunc(datatype_vvvvwdv)
{
	// set the function logic
	if (datatype_vvvvwdv == 'CHAR' || datatype_vvvvwdv == 'VARCHAR' || datatype_vvvvwdv == 'TEXT' || datatype_vvvvwdv == 'MEDIUMTEXT' || datatype_vvvvwdv == 'LONGTEXT' || datatype_vvvvwdv == 'BLOB' || datatype_vvvvwdv == 'TINYBLOB' || datatype_vvvvwdv == 'MEDIUMBLOB' || datatype_vvvvwdv == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdv Some function
function store_vvvvwdv_SomeFunc(store_vvvvwdv)
{
	// set the function logic
	if (store_vvvvwdv == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwdv Some function
function has_defaults_vvvvwdv_SomeFunc(has_defaults_vvvvwdv)
{
	// set the function logic
	if (has_defaults_vvvvwdv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdw function
function vvvvwdw(has_defaults_vvvvwdw,store_vvvvwdw,datatype_vvvvwdw)
{
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

// the vvvvwdx function
function vvvvwdx(has_defaults_vvvvwdx)
{
	// set the function logic
	if (has_defaults_vvvvwdx == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwdxvya_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwdxvya_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwdxvyb_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwdxvyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwdxvya_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwdxvya_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwdxvyb_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwdxvyb_required = true;
		}
	}
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (jQuery('#jform_not_required').length > 0) {
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
