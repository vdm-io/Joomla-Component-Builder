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
jform_vvvvwdlvxu_required = false;
jform_vvvvwdnvxv_required = false;
jform_vvvvwdpvxw_required = false;
jform_vvvvwdrvxx_required = false;
jform_vvvvwdsvxy_required = false;
jform_vvvvwdtvxz_required = false;
jform_vvvvwdyvya_required = false;
jform_vvvvwdyvyb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var datalenght_vvvvwdl = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwdl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdl(datalenght_vvvvwdl,has_defaults_vvvvwdl);

	var datadefault_vvvvwdn = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwdn = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdn(datadefault_vvvvwdn,has_defaults_vvvvwdn);

	var datatype_vvvvwdp = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdp(datatype_vvvvwdp,has_defaults_vvvvwdp);

	var datatype_vvvvwdr = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdr = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdr(datatype_vvvvwdr,has_defaults_vvvvwdr);

	var has_defaults_vvvvwds = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwds = jQuery("#jform_datatype").val();
	vvvvwds(has_defaults_vvvvwds,datatype_vvvvwds);

	var datatype_vvvvwdt = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdt(datatype_vvvvwdt,has_defaults_vvvvwdt);

	var store_vvvvwdv = jQuery("#jform_store").val();
	var datatype_vvvvwdv = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwdv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdv(store_vvvvwdv,datatype_vvvvwdv,has_defaults_vvvvwdv);

	var datatype_vvvvwdw = jQuery("#jform_datatype").val();
	var store_vvvvwdw = jQuery("#jform_store").val();
	var has_defaults_vvvvwdw = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdw(datatype_vvvvwdw,store_vvvvwdw,has_defaults_vvvvwdw);

	var has_defaults_vvvvwdx = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwdx = jQuery("#jform_store").val();
	var datatype_vvvvwdx = jQuery("#jform_datatype").val();
	vvvvwdx(has_defaults_vvvvwdx,store_vvvvwdx,datatype_vvvvwdx);

	var has_defaults_vvvvwdy = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwdy(has_defaults_vvvvwdy);
});

// the vvvvwdl function
function vvvvwdl(datalenght_vvvvwdl,has_defaults_vvvvwdl)
{
	if (isSet(datalenght_vvvvwdl) && datalenght_vvvvwdl.constructor !== Array)
	{
		var temp_vvvvwdl = datalenght_vvvvwdl;
		var datalenght_vvvvwdl = [];
		datalenght_vvvvwdl.push(temp_vvvvwdl);
	}
	else if (!isSet(datalenght_vvvvwdl))
	{
		var datalenght_vvvvwdl = [];
	}
	var datalenght = datalenght_vvvvwdl.some(datalenght_vvvvwdl_SomeFunc);

	if (isSet(has_defaults_vvvvwdl) && has_defaults_vvvvwdl.constructor !== Array)
	{
		var temp_vvvvwdl = has_defaults_vvvvwdl;
		var has_defaults_vvvvwdl = [];
		has_defaults_vvvvwdl.push(temp_vvvvwdl);
	}
	else if (!isSet(has_defaults_vvvvwdl))
	{
		var has_defaults_vvvvwdl = [];
	}
	var has_defaults = has_defaults_vvvvwdl.some(has_defaults_vvvvwdl_SomeFunc);


	// set this function logic
	if (datalenght && has_defaults)
	{
		jQuery('#jform_datalenght_other').closest('.control-group').show();
		// add required attribute to datalenght_other field
		if (jform_vvvvwdlvxu_required)
		{
			updateFieldRequired('datalenght_other',0);
			jQuery('#jform_datalenght_other').prop('required','required');
			jQuery('#jform_datalenght_other').attr('aria-required',true);
			jQuery('#jform_datalenght_other').addClass('required');
			jform_vvvvwdlvxu_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght_other').closest('.control-group').hide();
		// remove required attribute from datalenght_other field
		if (!jform_vvvvwdlvxu_required)
		{
			updateFieldRequired('datalenght_other',1);
			jQuery('#jform_datalenght_other').removeAttr('required');
			jQuery('#jform_datalenght_other').removeAttr('aria-required');
			jQuery('#jform_datalenght_other').removeClass('required');
			jform_vvvvwdlvxu_required = true;
		}
	}
}

// the vvvvwdl Some function
function datalenght_vvvvwdl_SomeFunc(datalenght_vvvvwdl)
{
	// set the function logic
	if (datalenght_vvvvwdl == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwdl Some function
function has_defaults_vvvvwdl_SomeFunc(has_defaults_vvvvwdl)
{
	// set the function logic
	if (has_defaults_vvvvwdl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdn function
function vvvvwdn(datadefault_vvvvwdn,has_defaults_vvvvwdn)
{
	if (isSet(datadefault_vvvvwdn) && datadefault_vvvvwdn.constructor !== Array)
	{
		var temp_vvvvwdn = datadefault_vvvvwdn;
		var datadefault_vvvvwdn = [];
		datadefault_vvvvwdn.push(temp_vvvvwdn);
	}
	else if (!isSet(datadefault_vvvvwdn))
	{
		var datadefault_vvvvwdn = [];
	}
	var datadefault = datadefault_vvvvwdn.some(datadefault_vvvvwdn_SomeFunc);

	if (isSet(has_defaults_vvvvwdn) && has_defaults_vvvvwdn.constructor !== Array)
	{
		var temp_vvvvwdn = has_defaults_vvvvwdn;
		var has_defaults_vvvvwdn = [];
		has_defaults_vvvvwdn.push(temp_vvvvwdn);
	}
	else if (!isSet(has_defaults_vvvvwdn))
	{
		var has_defaults_vvvvwdn = [];
	}
	var has_defaults = has_defaults_vvvvwdn.some(has_defaults_vvvvwdn_SomeFunc);


	// set this function logic
	if (datadefault && has_defaults)
	{
		jQuery('#jform_datadefault_other').closest('.control-group').show();
		// add required attribute to datadefault_other field
		if (jform_vvvvwdnvxv_required)
		{
			updateFieldRequired('datadefault_other',0);
			jQuery('#jform_datadefault_other').prop('required','required');
			jQuery('#jform_datadefault_other').attr('aria-required',true);
			jQuery('#jform_datadefault_other').addClass('required');
			jform_vvvvwdnvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault_other').closest('.control-group').hide();
		// remove required attribute from datadefault_other field
		if (!jform_vvvvwdnvxv_required)
		{
			updateFieldRequired('datadefault_other',1);
			jQuery('#jform_datadefault_other').removeAttr('required');
			jQuery('#jform_datadefault_other').removeAttr('aria-required');
			jQuery('#jform_datadefault_other').removeClass('required');
			jform_vvvvwdnvxv_required = true;
		}
	}
}

// the vvvvwdn Some function
function datadefault_vvvvwdn_SomeFunc(datadefault_vvvvwdn)
{
	// set the function logic
	if (datadefault_vvvvwdn == 'Other')
	{
		return true;
	}
	return false;
}

// the vvvvwdn Some function
function has_defaults_vvvvwdn_SomeFunc(has_defaults_vvvvwdn)
{
	// set the function logic
	if (has_defaults_vvvvwdn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdp function
function vvvvwdp(datatype_vvvvwdp,has_defaults_vvvvwdp)
{
	if (isSet(datatype_vvvvwdp) && datatype_vvvvwdp.constructor !== Array)
	{
		var temp_vvvvwdp = datatype_vvvvwdp;
		var datatype_vvvvwdp = [];
		datatype_vvvvwdp.push(temp_vvvvwdp);
	}
	else if (!isSet(datatype_vvvvwdp))
	{
		var datatype_vvvvwdp = [];
	}
	var datatype = datatype_vvvvwdp.some(datatype_vvvvwdp_SomeFunc);

	if (isSet(has_defaults_vvvvwdp) && has_defaults_vvvvwdp.constructor !== Array)
	{
		var temp_vvvvwdp = has_defaults_vvvvwdp;
		var has_defaults_vvvvwdp = [];
		has_defaults_vvvvwdp.push(temp_vvvvwdp);
	}
	else if (!isSet(has_defaults_vvvvwdp))
	{
		var has_defaults_vvvvwdp = [];
	}
	var has_defaults = has_defaults_vvvvwdp.some(has_defaults_vvvvwdp_SomeFunc);


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datalenght').closest('.control-group').show();
		// add required attribute to datalenght field
		if (jform_vvvvwdpvxw_required)
		{
			updateFieldRequired('datalenght',0);
			jQuery('#jform_datalenght').prop('required','required');
			jQuery('#jform_datalenght').attr('aria-required',true);
			jQuery('#jform_datalenght').addClass('required');
			jform_vvvvwdpvxw_required = false;
		}
	}
	else
	{
		jQuery('#jform_datalenght').closest('.control-group').hide();
		// remove required attribute from datalenght field
		if (!jform_vvvvwdpvxw_required)
		{
			updateFieldRequired('datalenght',1);
			jQuery('#jform_datalenght').removeAttr('required');
			jQuery('#jform_datalenght').removeAttr('aria-required');
			jQuery('#jform_datalenght').removeClass('required');
			jform_vvvvwdpvxw_required = true;
		}
	}
}

// the vvvvwdp Some function
function datatype_vvvvwdp_SomeFunc(datatype_vvvvwdp)
{
	// set the function logic
	if (datatype_vvvvwdp == 'CHAR' || datatype_vvvvwdp == 'VARCHAR' || datatype_vvvvwdp == 'INT' || datatype_vvvvwdp == 'TINYINT' || datatype_vvvvwdp == 'BIGINT' || datatype_vvvvwdp == 'FLOAT' || datatype_vvvvwdp == 'DECIMAL' || datatype_vvvvwdp == 'DOUBLE')
	{
		return true;
	}
	return false;
}

// the vvvvwdp Some function
function has_defaults_vvvvwdp_SomeFunc(has_defaults_vvvvwdp)
{
	// set the function logic
	if (has_defaults_vvvvwdp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdr function
function vvvvwdr(datatype_vvvvwdr,has_defaults_vvvvwdr)
{
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


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwdrvxx_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwdrvxx_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwdrvxx_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwdrvxx_required = true;
		}
	}
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

// the vvvvwds function
function vvvvwds(has_defaults_vvvvwds,datatype_vvvvwds)
{
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


	// set this function logic
	if (has_defaults && datatype)
	{
		jQuery('#jform_datadefault').closest('.control-group').show();
		jQuery('#jform_indexes').closest('.control-group').show();
		// add required attribute to indexes field
		if (jform_vvvvwdsvxy_required)
		{
			updateFieldRequired('indexes',0);
			jQuery('#jform_indexes').prop('required','required');
			jQuery('#jform_indexes').attr('aria-required',true);
			jQuery('#jform_indexes').addClass('required');
			jform_vvvvwdsvxy_required = false;
		}
	}
	else
	{
		jQuery('#jform_datadefault').closest('.control-group').hide();
		jQuery('#jform_indexes').closest('.control-group').hide();
		// remove required attribute from indexes field
		if (!jform_vvvvwdsvxy_required)
		{
			updateFieldRequired('indexes',1);
			jQuery('#jform_indexes').removeAttr('required');
			jQuery('#jform_indexes').removeAttr('aria-required');
			jQuery('#jform_indexes').removeClass('required');
			jform_vvvvwdsvxy_required = true;
		}
	}
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

// the vvvvwdt function
function vvvvwdt(datatype_vvvvwdt,has_defaults_vvvvwdt)
{
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


	// set this function logic
	if (datatype && has_defaults)
	{
		jQuery('#jform_store').closest('.control-group').show();
		// add required attribute to store field
		if (jform_vvvvwdtvxz_required)
		{
			updateFieldRequired('store',0);
			jQuery('#jform_store').prop('required','required');
			jQuery('#jform_store').attr('aria-required',true);
			jQuery('#jform_store').addClass('required');
			jform_vvvvwdtvxz_required = false;
		}
	}
	else
	{
		jQuery('#jform_store').closest('.control-group').hide();
		// remove required attribute from store field
		if (!jform_vvvvwdtvxz_required)
		{
			updateFieldRequired('store',1);
			jQuery('#jform_store').removeAttr('required');
			jQuery('#jform_store').removeAttr('aria-required');
			jQuery('#jform_store').removeClass('required');
			jform_vvvvwdtvxz_required = true;
		}
	}
}

// the vvvvwdt Some function
function datatype_vvvvwdt_SomeFunc(datatype_vvvvwdt)
{
	// set the function logic
	if (datatype_vvvvwdt == 'CHAR' || datatype_vvvvwdt == 'VARCHAR' || datatype_vvvvwdt == 'TEXT' || datatype_vvvvwdt == 'MEDIUMTEXT' || datatype_vvvvwdt == 'LONGTEXT' || datatype_vvvvwdt == 'BLOB' || datatype_vvvvwdt == 'TINYBLOB' || datatype_vvvvwdt == 'MEDIUMBLOB' || datatype_vvvvwdt == 'LONGBLOB')
	{
		return true;
	}
	return false;
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

// the vvvvwdv function
function vvvvwdv(store_vvvvwdv,datatype_vvvvwdv,has_defaults_vvvvwdv)
{
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
	if (store && datatype && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwdw(datatype_vvvvwdw,store_vvvvwdw,has_defaults_vvvvwdw)
{
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
	if (datatype && store && has_defaults)
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_encryption').closest('.control-group').hide();
	}
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
function vvvvwdx(has_defaults_vvvvwdx,store_vvvvwdx,datatype_vvvvwdx)
{
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
function datatype_vvvvwdx_SomeFunc(datatype_vvvvwdx)
{
	// set the function logic
	if (datatype_vvvvwdx == 'CHAR' || datatype_vvvvwdx == 'VARCHAR' || datatype_vvvvwdx == 'TEXT' || datatype_vvvvwdx == 'MEDIUMTEXT' || datatype_vvvvwdx == 'LONGTEXT' || datatype_vvvvwdx == 'BLOB' || datatype_vvvvwdx == 'TINYBLOB' || datatype_vvvvwdx == 'MEDIUMBLOB' || datatype_vvvvwdx == 'LONGBLOB')
	{
		return true;
	}
	return false;
}

// the vvvvwdy function
function vvvvwdy(has_defaults_vvvvwdy)
{
	// set the function logic
	if (has_defaults_vvvvwdy == 1)
	{
		jQuery('#jform_datatype').closest('.control-group').show();
		// add required attribute to datatype field
		if (jform_vvvvwdyvya_required)
		{
			updateFieldRequired('datatype',0);
			jQuery('#jform_datatype').prop('required','required');
			jQuery('#jform_datatype').attr('aria-required',true);
			jQuery('#jform_datatype').addClass('required');
			jform_vvvvwdyvya_required = false;
		}
		jQuery('#jform_null_switch').closest('.control-group').show();
		// add required attribute to null_switch field
		if (jform_vvvvwdyvyb_required)
		{
			updateFieldRequired('null_switch',0);
			jQuery('#jform_null_switch').prop('required','required');
			jQuery('#jform_null_switch').attr('aria-required',true);
			jQuery('#jform_null_switch').addClass('required');
			jform_vvvvwdyvyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_datatype').closest('.control-group').hide();
		// remove required attribute from datatype field
		if (!jform_vvvvwdyvya_required)
		{
			updateFieldRequired('datatype',1);
			jQuery('#jform_datatype').removeAttr('required');
			jQuery('#jform_datatype').removeAttr('aria-required');
			jQuery('#jform_datatype').removeClass('required');
			jform_vvvvwdyvya_required = true;
		}
		jQuery('#jform_null_switch').closest('.control-group').hide();
		// remove required attribute from null_switch field
		if (!jform_vvvvwdyvyb_required)
		{
			updateFieldRequired('null_switch',1);
			jQuery('#jform_null_switch').removeAttr('required');
			jQuery('#jform_null_switch').removeAttr('aria-required');
			jQuery('#jform_null_switch').removeClass('required');
			jform_vvvvwdyvyb_required = true;
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
