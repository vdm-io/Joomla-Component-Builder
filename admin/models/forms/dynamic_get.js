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
jform_vvvvwaevwq_required = false;
jform_vvvvwagvwr_required = false;
jform_vvvvwahvws_required = false;
jform_vvvvwaivwt_required = false;
jform_vvvvwajvwu_required = false;
jform_vvvvwauvwv_required = false;
jform_vvvvwauvww_required = false;
jform_vvvvwazvwx_required = false;
jform_vvvvwazvwy_required = false;
jform_vvvvwazvwz_required = false;
jform_vvvvwbavxa_required = false;
jform_vvvvwbbvxb_required = false;
jform_vvvvwbcvxc_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(gettype_vvvvwae);

	var main_source_vvvvwaf = jQuery("#jform_main_source").val();
	vvvvwaf(main_source_vvvvwaf);

	var main_source_vvvvwag = jQuery("#jform_main_source").val();
	vvvvwag(main_source_vvvvwag);

	var main_source_vvvvwah = jQuery("#jform_main_source").val();
	vvvvwah(main_source_vvvvwah);

	var main_source_vvvvwai = jQuery("#jform_main_source").val();
	vvvvwai(main_source_vvvvwai);

	var main_source_vvvvwaj = jQuery("#jform_main_source").val();
	vvvvwaj(main_source_vvvvwaj);

	var addcalculation_vvvvwak = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvwak(addcalculation_vvvvwak);

	var addcalculation_vvvvwal = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwal = jQuery("#jform_gettype").val();
	vvvvwal(addcalculation_vvvvwal,gettype_vvvvwal);

	var addcalculation_vvvvwam = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwam = jQuery("#jform_gettype").val();
	vvvvwam(addcalculation_vvvvwam,gettype_vvvvwam);

	var main_source_vvvvwap = jQuery("#jform_main_source").val();
	vvvvwap(main_source_vvvvwap);

	var main_source_vvvvwaq = jQuery("#jform_main_source").val();
	vvvvwaq(main_source_vvvvwaq);

	var add_php_before_getitem_vvvvwar = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvwar = jQuery("#jform_gettype").val();
	vvvvwar(add_php_before_getitem_vvvvwar,gettype_vvvvwar);

	var add_php_after_getitem_vvvvwas = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvwas = jQuery("#jform_gettype").val();
	vvvvwas(add_php_after_getitem_vvvvwas,gettype_vvvvwas);

	var gettype_vvvvwau = jQuery("#jform_gettype").val();
	vvvvwau(gettype_vvvvwau);

	var add_php_getlistquery_vvvvwav = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwav = jQuery("#jform_gettype").val();
	vvvvwav(add_php_getlistquery_vvvvwav,gettype_vvvvwav);

	var add_php_before_getitems_vvvvwaw = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwaw = jQuery("#jform_gettype").val();
	vvvvwaw(add_php_before_getitems_vvvvwaw,gettype_vvvvwaw);

	var add_php_after_getitems_vvvvwax = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwax = jQuery("#jform_gettype").val();
	vvvvwax(add_php_after_getitems_vvvvwax,gettype_vvvvwax);

	var gettype_vvvvwaz = jQuery("#jform_gettype").val();
	vvvvwaz(gettype_vvvvwaz);

	var gettype_vvvvwba = jQuery("#jform_gettype").val();
	vvvvwba(gettype_vvvvwba);

	var gettype_vvvvwbb = jQuery("#jform_gettype").val();
	vvvvwbb(gettype_vvvvwbb);

	var gettype_vvvvwbc = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwbc = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwbc(gettype_vvvvwbc,add_php_router_parse_vvvvwbc);

	var gettype_vvvvwbe = jQuery("#jform_gettype").val();
	vvvvwbe(gettype_vvvvwbe);
});

// the vvvvwae function
function vvvvwae(gettype_vvvvwae)
{
	if (isSet(gettype_vvvvwae) && gettype_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = gettype_vvvvwae;
		var gettype_vvvvwae = [];
		gettype_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(gettype_vvvvwae))
	{
		var gettype_vvvvwae = [];
	}
	var gettype = gettype_vvvvwae.some(gettype_vvvvwae_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		// add required attribute to getcustom field
		if (jform_vvvvwaevwq_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvwaevwq_required = false;
		}
	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		// remove required attribute from getcustom field
		if (!jform_vvvvwaevwq_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvwaevwq_required = true;
		}
	}
}

// the vvvvwae Some function
function gettype_vvvvwae_SomeFunc(gettype_vvvvwae)
{
	// set the function logic
	if (gettype_vvvvwae == 3 || gettype_vvvvwae == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaf function
function vvvvwaf(main_source_vvvvwaf)
{
	if (isSet(main_source_vvvvwaf) && main_source_vvvvwaf.constructor !== Array)
	{
		var temp_vvvvwaf = main_source_vvvvwaf;
		var main_source_vvvvwaf = [];
		main_source_vvvvwaf.push(temp_vvvvwaf);
	}
	else if (!isSet(main_source_vvvvwaf))
	{
		var main_source_vvvvwaf = [];
	}
	var main_source = main_source_vvvvwaf.some(main_source_vvvvwaf_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_select_all').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_select_all').closest('.control-group').hide();
	}
}

// the vvvvwaf Some function
function main_source_vvvvwaf_SomeFunc(main_source_vvvvwaf)
{
	// set the function logic
	if (main_source_vvvvwaf == 1 || main_source_vvvvwaf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwag function
function vvvvwag(main_source_vvvvwag)
{
	if (isSet(main_source_vvvvwag) && main_source_vvvvwag.constructor !== Array)
	{
		var temp_vvvvwag = main_source_vvvvwag;
		var main_source_vvvvwag = [];
		main_source_vvvvwag.push(temp_vvvvwag);
	}
	else if (!isSet(main_source_vvvvwag))
	{
		var main_source_vvvvwag = [];
	}
	var main_source = main_source_vvvvwag.some(main_source_vvvvwag_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		// add required attribute to view_table_main field
		if (jform_vvvvwagvwr_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvwagvwr_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		// remove required attribute from view_table_main field
		if (!jform_vvvvwagvwr_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvwagvwr_required = true;
		}
	}
}

// the vvvvwag Some function
function main_source_vvvvwag_SomeFunc(main_source_vvvvwag)
{
	// set the function logic
	if (main_source_vvvvwag == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwah function
function vvvvwah(main_source_vvvvwah)
{
	if (isSet(main_source_vvvvwah) && main_source_vvvvwah.constructor !== Array)
	{
		var temp_vvvvwah = main_source_vvvvwah;
		var main_source_vvvvwah = [];
		main_source_vvvvwah.push(temp_vvvvwah);
	}
	else if (!isSet(main_source_vvvvwah))
	{
		var main_source_vvvvwah = [];
	}
	var main_source = main_source_vvvvwah.some(main_source_vvvvwah_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		// add required attribute to view_selection field
		if (jform_vvvvwahvws_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvwahvws_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		// remove required attribute from view_selection field
		if (!jform_vvvvwahvws_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvwahvws_required = true;
		}
	}
}

// the vvvvwah Some function
function main_source_vvvvwah_SomeFunc(main_source_vvvvwah)
{
	// set the function logic
	if (main_source_vvvvwah == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwai function
function vvvvwai(main_source_vvvvwai)
{
	if (isSet(main_source_vvvvwai) && main_source_vvvvwai.constructor !== Array)
	{
		var temp_vvvvwai = main_source_vvvvwai;
		var main_source_vvvvwai = [];
		main_source_vvvvwai.push(temp_vvvvwai);
	}
	else if (!isSet(main_source_vvvvwai))
	{
		var main_source_vvvvwai = [];
	}
	var main_source = main_source_vvvvwai.some(main_source_vvvvwai_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		// add required attribute to db_table_main field
		if (jform_vvvvwaivwt_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvwaivwt_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		// remove required attribute from db_table_main field
		if (!jform_vvvvwaivwt_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvwaivwt_required = true;
		}
	}
}

// the vvvvwai Some function
function main_source_vvvvwai_SomeFunc(main_source_vvvvwai)
{
	// set the function logic
	if (main_source_vvvvwai == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaj function
function vvvvwaj(main_source_vvvvwaj)
{
	if (isSet(main_source_vvvvwaj) && main_source_vvvvwaj.constructor !== Array)
	{
		var temp_vvvvwaj = main_source_vvvvwaj;
		var main_source_vvvvwaj = [];
		main_source_vvvvwaj.push(temp_vvvvwaj);
	}
	else if (!isSet(main_source_vvvvwaj))
	{
		var main_source_vvvvwaj = [];
	}
	var main_source = main_source_vvvvwaj.some(main_source_vvvvwaj_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		// add required attribute to db_selection field
		if (jform_vvvvwajvwu_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvwajvwu_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		// remove required attribute from db_selection field
		if (!jform_vvvvwajvwu_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvwajvwu_required = true;
		}
	}
}

// the vvvvwaj Some function
function main_source_vvvvwaj_SomeFunc(main_source_vvvvwaj)
{
	// set the function logic
	if (main_source_vvvvwaj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwak function
function vvvvwak(addcalculation_vvvvwak)
{
	// set the function logic
	if (addcalculation_vvvvwak == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
	}
}

// the vvvvwal function
function vvvvwal(addcalculation_vvvvwal,gettype_vvvvwal)
{
	if (isSet(addcalculation_vvvvwal) && addcalculation_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = addcalculation_vvvvwal;
		var addcalculation_vvvvwal = [];
		addcalculation_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(addcalculation_vvvvwal))
	{
		var addcalculation_vvvvwal = [];
	}
	var addcalculation = addcalculation_vvvvwal.some(addcalculation_vvvvwal_SomeFunc);

	if (isSet(gettype_vvvvwal) && gettype_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = gettype_vvvvwal;
		var gettype_vvvvwal = [];
		gettype_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(gettype_vvvvwal))
	{
		var gettype_vvvvwal = [];
	}
	var gettype = gettype_vvvvwal.some(gettype_vvvvwal_SomeFunc);


	// set this function logic
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvwal Some function
function addcalculation_vvvvwal_SomeFunc(addcalculation_vvvvwal)
{
	// set the function logic
	if (addcalculation_vvvvwal == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwal Some function
function gettype_vvvvwal_SomeFunc(gettype_vvvvwal)
{
	// set the function logic
	if (gettype_vvvvwal == 1 || gettype_vvvvwal == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwam function
function vvvvwam(addcalculation_vvvvwam,gettype_vvvvwam)
{
	if (isSet(addcalculation_vvvvwam) && addcalculation_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = addcalculation_vvvvwam;
		var addcalculation_vvvvwam = [];
		addcalculation_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(addcalculation_vvvvwam))
	{
		var addcalculation_vvvvwam = [];
	}
	var addcalculation = addcalculation_vvvvwam.some(addcalculation_vvvvwam_SomeFunc);

	if (isSet(gettype_vvvvwam) && gettype_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = gettype_vvvvwam;
		var gettype_vvvvwam = [];
		gettype_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(gettype_vvvvwam))
	{
		var gettype_vvvvwam = [];
	}
	var gettype = gettype_vvvvwam.some(gettype_vvvvwam_SomeFunc);


	// set this function logic
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
	}
}

// the vvvvwam Some function
function addcalculation_vvvvwam_SomeFunc(addcalculation_vvvvwam)
{
	// set the function logic
	if (addcalculation_vvvvwam == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwam Some function
function gettype_vvvvwam_SomeFunc(gettype_vvvvwam)
{
	// set the function logic
	if (gettype_vvvvwam == 2 || gettype_vvvvwam == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(main_source_vvvvwap)
{
	if (isSet(main_source_vvvvwap) && main_source_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = main_source_vvvvwap;
		var main_source_vvvvwap = [];
		main_source_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(main_source_vvvvwap))
	{
		var main_source_vvvvwap = [];
	}
	var main_source = main_source_vvvvwap.some(main_source_vvvvwap_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').hide();
	}
}

// the vvvvwap Some function
function main_source_vvvvwap_SomeFunc(main_source_vvvvwap)
{
	// set the function logic
	if (main_source_vvvvwap == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwaq function
function vvvvwaq(main_source_vvvvwaq)
{
	if (isSet(main_source_vvvvwaq) && main_source_vvvvwaq.constructor !== Array)
	{
		var temp_vvvvwaq = main_source_vvvvwaq;
		var main_source_vvvvwaq = [];
		main_source_vvvvwaq.push(temp_vvvvwaq);
	}
	else if (!isSet(main_source_vvvvwaq))
	{
		var main_source_vvvvwaq = [];
	}
	var main_source = main_source_vvvvwaq.some(main_source_vvvvwaq_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_filter-lbl').closest('.control-group').show();
		jQuery('#jform_global-lbl').closest('.control-group').show();
		jQuery('#jform_group-lbl').closest('.control-group').show();
		jQuery('#jform_order-lbl').closest('.control-group').show();
		jQuery('#jform_where-lbl').closest('.control-group').show();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').show();
		jQuery('#jform_join_view_table-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_filter-lbl').closest('.control-group').hide();
		jQuery('#jform_global-lbl').closest('.control-group').hide();
		jQuery('#jform_group-lbl').closest('.control-group').hide();
		jQuery('#jform_order-lbl').closest('.control-group').hide();
		jQuery('#jform_where-lbl').closest('.control-group').hide();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').hide();
		jQuery('#jform_join_view_table-lbl').closest('.control-group').hide();
	}
}

// the vvvvwaq Some function
function main_source_vvvvwaq_SomeFunc(main_source_vvvvwaq)
{
	// set the function logic
	if (main_source_vvvvwaq == 1 || main_source_vvvvwaq == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwar function
function vvvvwar(add_php_before_getitem_vvvvwar,gettype_vvvvwar)
{
	if (isSet(add_php_before_getitem_vvvvwar) && add_php_before_getitem_vvvvwar.constructor !== Array)
	{
		var temp_vvvvwar = add_php_before_getitem_vvvvwar;
		var add_php_before_getitem_vvvvwar = [];
		add_php_before_getitem_vvvvwar.push(temp_vvvvwar);
	}
	else if (!isSet(add_php_before_getitem_vvvvwar))
	{
		var add_php_before_getitem_vvvvwar = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvwar.some(add_php_before_getitem_vvvvwar_SomeFunc);

	if (isSet(gettype_vvvvwar) && gettype_vvvvwar.constructor !== Array)
	{
		var temp_vvvvwar = gettype_vvvvwar;
		var gettype_vvvvwar = [];
		gettype_vvvvwar.push(temp_vvvvwar);
	}
	else if (!isSet(gettype_vvvvwar))
	{
		var gettype_vvvvwar = [];
	}
	var gettype = gettype_vvvvwar.some(gettype_vvvvwar_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').hide();
	}
}

// the vvvvwar Some function
function add_php_before_getitem_vvvvwar_SomeFunc(add_php_before_getitem_vvvvwar)
{
	// set the function logic
	if (add_php_before_getitem_vvvvwar == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwar Some function
function gettype_vvvvwar_SomeFunc(gettype_vvvvwar)
{
	// set the function logic
	if (gettype_vvvvwar == 1 || gettype_vvvvwar == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwas function
function vvvvwas(add_php_after_getitem_vvvvwas,gettype_vvvvwas)
{
	if (isSet(add_php_after_getitem_vvvvwas) && add_php_after_getitem_vvvvwas.constructor !== Array)
	{
		var temp_vvvvwas = add_php_after_getitem_vvvvwas;
		var add_php_after_getitem_vvvvwas = [];
		add_php_after_getitem_vvvvwas.push(temp_vvvvwas);
	}
	else if (!isSet(add_php_after_getitem_vvvvwas))
	{
		var add_php_after_getitem_vvvvwas = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvwas.some(add_php_after_getitem_vvvvwas_SomeFunc);

	if (isSet(gettype_vvvvwas) && gettype_vvvvwas.constructor !== Array)
	{
		var temp_vvvvwas = gettype_vvvvwas;
		var gettype_vvvvwas = [];
		gettype_vvvvwas.push(temp_vvvvwas);
	}
	else if (!isSet(gettype_vvvvwas))
	{
		var gettype_vvvvwas = [];
	}
	var gettype = gettype_vvvvwas.some(gettype_vvvvwas_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').hide();
	}
}

// the vvvvwas Some function
function add_php_after_getitem_vvvvwas_SomeFunc(add_php_after_getitem_vvvvwas)
{
	// set the function logic
	if (add_php_after_getitem_vvvvwas == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwas Some function
function gettype_vvvvwas_SomeFunc(gettype_vvvvwas)
{
	// set the function logic
	if (gettype_vvvvwas == 1 || gettype_vvvvwas == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwau function
function vvvvwau(gettype_vvvvwau)
{
	if (isSet(gettype_vvvvwau) && gettype_vvvvwau.constructor !== Array)
	{
		var temp_vvvvwau = gettype_vvvvwau;
		var gettype_vvvvwau = [];
		gettype_vvvvwau.push(temp_vvvvwau);
	}
	else if (!isSet(gettype_vvvvwau))
	{
		var gettype_vvvvwau = [];
	}
	var gettype = gettype_vvvvwau.some(gettype_vvvvwau_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		// add required attribute to add_php_after_getitem field
		if (jform_vvvvwauvwv_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvwauvwv_required = false;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		// add required attribute to add_php_before_getitem field
		if (jform_vvvvwauvww_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvwauvww_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitem field
		if (!jform_vvvvwauvwv_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvwauvwv_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitem field
		if (!jform_vvvvwauvww_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvwauvww_required = true;
		}
	}
}

// the vvvvwau Some function
function gettype_vvvvwau_SomeFunc(gettype_vvvvwau)
{
	// set the function logic
	if (gettype_vvvvwau == 1 || gettype_vvvvwau == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwav function
function vvvvwav(add_php_getlistquery_vvvvwav,gettype_vvvvwav)
{
	if (isSet(add_php_getlistquery_vvvvwav) && add_php_getlistquery_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = add_php_getlistquery_vvvvwav;
		var add_php_getlistquery_vvvvwav = [];
		add_php_getlistquery_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(add_php_getlistquery_vvvvwav))
	{
		var add_php_getlistquery_vvvvwav = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvwav.some(add_php_getlistquery_vvvvwav_SomeFunc);

	if (isSet(gettype_vvvvwav) && gettype_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = gettype_vvvvwav;
		var gettype_vvvvwav = [];
		gettype_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(gettype_vvvvwav))
	{
		var gettype_vvvvwav = [];
	}
	var gettype = gettype_vvvvwav.some(gettype_vvvvwav_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
	}
}

// the vvvvwav Some function
function add_php_getlistquery_vvvvwav_SomeFunc(add_php_getlistquery_vvvvwav)
{
	// set the function logic
	if (add_php_getlistquery_vvvvwav == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwav Some function
function gettype_vvvvwav_SomeFunc(gettype_vvvvwav)
{
	// set the function logic
	if (gettype_vvvvwav == 2 || gettype_vvvvwav == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaw function
function vvvvwaw(add_php_before_getitems_vvvvwaw,gettype_vvvvwaw)
{
	if (isSet(add_php_before_getitems_vvvvwaw) && add_php_before_getitems_vvvvwaw.constructor !== Array)
	{
		var temp_vvvvwaw = add_php_before_getitems_vvvvwaw;
		var add_php_before_getitems_vvvvwaw = [];
		add_php_before_getitems_vvvvwaw.push(temp_vvvvwaw);
	}
	else if (!isSet(add_php_before_getitems_vvvvwaw))
	{
		var add_php_before_getitems_vvvvwaw = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvwaw.some(add_php_before_getitems_vvvvwaw_SomeFunc);

	if (isSet(gettype_vvvvwaw) && gettype_vvvvwaw.constructor !== Array)
	{
		var temp_vvvvwaw = gettype_vvvvwaw;
		var gettype_vvvvwaw = [];
		gettype_vvvvwaw.push(temp_vvvvwaw);
	}
	else if (!isSet(gettype_vvvvwaw))
	{
		var gettype_vvvvwaw = [];
	}
	var gettype = gettype_vvvvwaw.some(gettype_vvvvwaw_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvwaw Some function
function add_php_before_getitems_vvvvwaw_SomeFunc(add_php_before_getitems_vvvvwaw)
{
	// set the function logic
	if (add_php_before_getitems_vvvvwaw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwaw Some function
function gettype_vvvvwaw_SomeFunc(gettype_vvvvwaw)
{
	// set the function logic
	if (gettype_vvvvwaw == 2 || gettype_vvvvwaw == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwax function
function vvvvwax(add_php_after_getitems_vvvvwax,gettype_vvvvwax)
{
	if (isSet(add_php_after_getitems_vvvvwax) && add_php_after_getitems_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = add_php_after_getitems_vvvvwax;
		var add_php_after_getitems_vvvvwax = [];
		add_php_after_getitems_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(add_php_after_getitems_vvvvwax))
	{
		var add_php_after_getitems_vvvvwax = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvwax.some(add_php_after_getitems_vvvvwax_SomeFunc);

	if (isSet(gettype_vvvvwax) && gettype_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = gettype_vvvvwax;
		var gettype_vvvvwax = [];
		gettype_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(gettype_vvvvwax))
	{
		var gettype_vvvvwax = [];
	}
	var gettype = gettype_vvvvwax.some(gettype_vvvvwax_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvwax Some function
function add_php_after_getitems_vvvvwax_SomeFunc(add_php_after_getitems_vvvvwax)
{
	// set the function logic
	if (add_php_after_getitems_vvvvwax == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwax Some function
function gettype_vvvvwax_SomeFunc(gettype_vvvvwax)
{
	// set the function logic
	if (gettype_vvvvwax == 2 || gettype_vvvvwax == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaz function
function vvvvwaz(gettype_vvvvwaz)
{
	if (isSet(gettype_vvvvwaz) && gettype_vvvvwaz.constructor !== Array)
	{
		var temp_vvvvwaz = gettype_vvvvwaz;
		var gettype_vvvvwaz = [];
		gettype_vvvvwaz.push(temp_vvvvwaz);
	}
	else if (!isSet(gettype_vvvvwaz))
	{
		var gettype_vvvvwaz = [];
	}
	var gettype = gettype_vvvvwaz.some(gettype_vvvvwaz_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		// add required attribute to add_php_after_getitems field
		if (jform_vvvvwazvwx_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvwazvwx_required = false;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		// add required attribute to add_php_before_getitems field
		if (jform_vvvvwazvwy_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvwazvwy_required = false;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		// add required attribute to add_php_getlistquery field
		if (jform_vvvvwazvwz_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvwazvwz_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitems field
		if (!jform_vvvvwazvwx_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvwazvwx_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitems field
		if (!jform_vvvvwazvwy_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvwazvwy_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		// remove required attribute from add_php_getlistquery field
		if (!jform_vvvvwazvwz_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvwazvwz_required = true;
		}
	}
}

// the vvvvwaz Some function
function gettype_vvvvwaz_SomeFunc(gettype_vvvvwaz)
{
	// set the function logic
	if (gettype_vvvvwaz == 2 || gettype_vvvvwaz == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwba function
function vvvvwba(gettype_vvvvwba)
{
	if (isSet(gettype_vvvvwba) && gettype_vvvvwba.constructor !== Array)
	{
		var temp_vvvvwba = gettype_vvvvwba;
		var gettype_vvvvwba = [];
		gettype_vvvvwba.push(temp_vvvvwba);
	}
	else if (!isSet(gettype_vvvvwba))
	{
		var gettype_vvvvwba = [];
	}
	var gettype = gettype_vvvvwba.some(gettype_vvvvwba_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		// add required attribute to pagination field
		if (jform_vvvvwbavxa_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvwbavxa_required = false;
		}
	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		// remove required attribute from pagination field
		if (!jform_vvvvwbavxa_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvwbavxa_required = true;
		}
	}
}

// the vvvvwba Some function
function gettype_vvvvwba_SomeFunc(gettype_vvvvwba)
{
	// set the function logic
	if (gettype_vvvvwba == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbb function
function vvvvwbb(gettype_vvvvwbb)
{
	if (isSet(gettype_vvvvwbb) && gettype_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = gettype_vvvvwbb;
		var gettype_vvvvwbb = [];
		gettype_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(gettype_vvvvwbb))
	{
		var gettype_vvvvwbb = [];
	}
	var gettype = gettype_vvvvwbb.some(gettype_vvvvwbb_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		// add required attribute to add_php_router_parse field
		if (jform_vvvvwbbvxb_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvwbbvxb_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		// remove required attribute from add_php_router_parse field
		if (!jform_vvvvwbbvxb_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvwbbvxb_required = true;
		}
	}
}

// the vvvvwbb Some function
function gettype_vvvvwbb_SomeFunc(gettype_vvvvwbb)
{
	// set the function logic
	if (gettype_vvvvwbb == 1 || gettype_vvvvwbb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbc function
function vvvvwbc(gettype_vvvvwbc,add_php_router_parse_vvvvwbc)
{
	if (isSet(gettype_vvvvwbc) && gettype_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = gettype_vvvvwbc;
		var gettype_vvvvwbc = [];
		gettype_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(gettype_vvvvwbc))
	{
		var gettype_vvvvwbc = [];
	}
	var gettype = gettype_vvvvwbc.some(gettype_vvvvwbc_SomeFunc);

	if (isSet(add_php_router_parse_vvvvwbc) && add_php_router_parse_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = add_php_router_parse_vvvvwbc;
		var add_php_router_parse_vvvvwbc = [];
		add_php_router_parse_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(add_php_router_parse_vvvvwbc))
	{
		var add_php_router_parse_vvvvwbc = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvwbc.some(add_php_router_parse_vvvvwbc_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		// add required attribute to php_router_parse field
		if (jform_vvvvwbcvxc_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwbcvxc_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		// remove required attribute from php_router_parse field
		if (!jform_vvvvwbcvxc_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwbcvxc_required = true;
		}
	}
}

// the vvvvwbc Some function
function gettype_vvvvwbc_SomeFunc(gettype_vvvvwbc)
{
	// set the function logic
	if (gettype_vvvvwbc == 1 || gettype_vvvvwbc == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbc Some function
function add_php_router_parse_vvvvwbc_SomeFunc(add_php_router_parse_vvvvwbc)
{
	// set the function logic
	if (add_php_router_parse_vvvvwbc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbe function
function vvvvwbe(gettype_vvvvwbe)
{
	if (isSet(gettype_vvvvwbe) && gettype_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = gettype_vvvvwbe;
		var gettype_vvvvwbe = [];
		gettype_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(gettype_vvvvwbe))
	{
		var gettype_vvvvwbe = [];
	}
	var gettype = gettype_vvvvwbe.some(gettype_vvvvwbe_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_plugin_events').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_plugin_events').closest('.control-group').hide();
	}
}

// the vvvvwbe Some function
function gettype_vvvvwbe_SomeFunc(gettype_vvvvwbe)
{
	// set the function logic
	if (gettype_vvvvwbe == 1)
	{
		return true;
	}
	return false;
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


jQuery(document).ready(function()
{
	// get the linked details
	getLinked();
	var valueSwitch = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	getDynamicScripts(valueSwitch);
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

function setSelectAll(select_all){
	// get source type
	var main_source =  jQuery("#jform_main_source").val();
	if (1 == main_source) {
		var key = 'view';
	} else if (2 == main_source) {
		var key = 'db';
	} else {
		return true;
	}
	// only continue if set
	if (select_all == 1) {
		// set default notice
		jQuery("#jform_"+key+"_selection").val('a.*');
		// set the selection text area to read only
		jQuery("#jform_"+key+"_selection").prop("readonly", true);
	} else {
		// remove the read only from selection text area
		jQuery("#jform_"+key+"_selection").prop("readonly", false);
		// get selected options
		var value_main =  jQuery("#jform_"+key+"_table_main option:selected").val();
		// make sure that all fields are set as selected
		if (key === 'view') {
			getViewTableColumns(value_main, 'a', key, 3, true, '', '');
		} else {
			getDbTableColumns(value_main, 'a', key, 3, true, '', '');
		}
	}
}

function getViewTableColumns_server(viewId,asKey,rowType){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.viewTableColumns&format=json&raw=true");
	if (token.length > 0 && viewId > 0 && asKey.length > 0)
	{
		var request = token+'=1&as='+asKey+'&type='+rowType+'&id='+viewId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getViewTableColumns(id, asKey, key, rowType, main, table_, nr_){
	// check if this is the main view
	if (main){
		var select_all =  jQuery("#jform_select_all input[type='radio']:checked").val();
		// do not continue if set
		if (select_all == 1){
			setSelectAll(select_all);
			return true;
		}
	}
	getViewTableColumns_server(id,asKey,rowType).done(function(result) {
		if (result)
		{
			loadSelectionData(result, 'view', key, main, table_, nr_);
		}
		else
		{
			loadSelectionData(false, 'view', key, main, table_, nr_);
		}
	})
}

function getDbTableColumns_server(name,asKey,rowType)
{
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.dbTableColumns&format=json&raw=true");
	if (token.length > 0 && name.length > 0 && asKey.length > 0)
	{
		var request = token+'=1&as='+asKey+'&type='+rowType+'&name='+name;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getDbTableColumns(name, asKey, key, rowType, main, table_, nr_){
	// check if this is the main view
	if (main){
		var select_all =  jQuery("#jform_select_all input[type='radio']:checked").val();
		// do not continue if set
		if (select_all == 1){
			setSelectAll(select_all);
			return true;
		}
	}
	getDbTableColumns_server(name,asKey,rowType).done(function(result) {
		if (result)
		{
			loadSelectionData(result, 'db', key, main, table_, nr_);
		}
		else
		{
			loadSelectionData(false, 'db', key, main, table_, nr_);
		}
	})
}

function loadSelectionData(result, type, key, main, table_, nr_)
{
	if (main)
	{
		var textArea = 'textarea#jform_'+key+'_selection';
	}
	else 
	{
		var textArea = 'textarea#jform_join_'+type+'_table'+table_+'_join_'+type+'_table'+key+nr_+'_selection';
	}
	// no update the text area
	if (result)
	{
		jQuery(textArea).val(result);
	}
	else
	{
		jQuery(textArea).val('');
	}
}
function updateSubItems(fieldName, fieldNr, table_, nr_) {
	if(jQuery('#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_'+fieldName+'_table').length) {
		jQuery('#adminForm').on('change', '#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_'+fieldName+'_table',function (e) {
			e.preventDefault();
			// get options
			var value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_"+fieldName+"_table option:selected").val();
			var as_value2 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_as option:selected").val();
			var row_value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_row_type option:selected").val();
			if (fieldName === 'view') {
				getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			} else {
				getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			}
		});
		jQuery('#adminForm').on('change', '#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_as',function (e) {
			e.preventDefault();
			// get options
			var value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_"+fieldName+"_table option:selected").val();
			var as_value2 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_as option:selected").val();
			var row_value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_row_type option:selected").val();
			if (fieldName === 'view') {
				getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			} else {
				getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			}
		});
		jQuery('#adminForm').on('change', '#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_row_type',function (e) {
			e.preventDefault();
			// get options
			var value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_"+fieldName+"_table option:selected").val();
			var as_value2 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_as option:selected").val();
			var row_value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_row_type option:selected").val();
			if (fieldName === 'view') {
				getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			} else {
				getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			}
		});
	}
}

function getDynamicScripts_server(typpe){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getDynamicScripts&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && typpe.length > 0){
		var request = token+'=1&type='+typpe;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getDynamicScripts(id){
	if (1 == id) {
		// get the current values
		var current_router_parse = jQuery('textarea#jform_php_router_parse').val();
		// set the router parse method script
		if(current_router_parse.length == 0){
			getDynamicScripts_server('routerparse').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_router_parse').val(result);
				}
			});
		}
	}
}

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

function getLinked_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type > 0){
		var request = token+'=1&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
} 
