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
jform_vvvvvydvwd_required = false;
jform_vvvvvyevwe_required = false;
jform_vvvvvyivwf_required = false;
jform_vvvvvyivwg_required = false;
jform_vvvvvyivwh_required = false;
jform_vvvvvyivwi_required = false;
jform_vvvvvyivwj_required = false;
jform_vvvvvyivwk_required = false;
jform_vvvvvyivwl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vvvvvxd = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvxd(add_css_view_vvvvvxd);

	var add_css_views_vvvvvxe = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvxe(add_css_views_vvvvvxe);

	var add_javascript_view_file_vvvvvxf = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	vvvvvxf(add_javascript_view_file_vvvvvxf);

	var add_javascript_views_file_vvvvvxg = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	vvvvvxg(add_javascript_views_file_vvvvvxg);

	var add_javascript_view_footer_vvvvvxh = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvxh(add_javascript_view_footer_vvvvvxh);

	var add_javascript_views_footer_vvvvvxi = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvxi(add_javascript_views_footer_vvvvvxi);

	var add_php_ajax_vvvvvxj = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvxj(add_php_ajax_vvvvvxj);

	var add_php_getitem_vvvvvxk = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	vvvvvxk(add_php_getitem_vvvvvxk);

	var add_php_getitems_vvvvvxl = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	vvvvvxl(add_php_getitems_vvvvvxl);

	var add_php_getitems_after_all_vvvvvxm = jQuery("#jform_add_php_getitems_after_all input[type='radio']:checked").val();
	vvvvvxm(add_php_getitems_after_all_vvvvvxm);

	var add_php_getlistquery_vvvvvxn = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	vvvvvxn(add_php_getlistquery_vvvvvxn);

	var add_php_getform_vvvvvxo = jQuery("#jform_add_php_getform input[type='radio']:checked").val();
	vvvvvxo(add_php_getform_vvvvvxo);

	var add_php_before_save_vvvvvxp = jQuery("#jform_add_php_before_save input[type='radio']:checked").val();
	vvvvvxp(add_php_before_save_vvvvvxp);

	var add_php_save_vvvvvxq = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvxq(add_php_save_vvvvvxq);

	var add_php_postsavehook_vvvvvxr = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvxr(add_php_postsavehook_vvvvvxr);

	var add_php_allowadd_vvvvvxs = jQuery("#jform_add_php_allowadd input[type='radio']:checked").val();
	vvvvvxs(add_php_allowadd_vvvvvxs);

	var add_php_allowedit_vvvvvxt = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvxt(add_php_allowedit_vvvvvxt);

	var add_php_before_cancel_vvvvvxu = jQuery("#jform_add_php_before_cancel input[type='radio']:checked").val();
	vvvvvxu(add_php_before_cancel_vvvvvxu);

	var add_php_after_cancel_vvvvvxv = jQuery("#jform_add_php_after_cancel input[type='radio']:checked").val();
	vvvvvxv(add_php_after_cancel_vvvvvxv);

	var add_php_batchcopy_vvvvvxw = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvxw(add_php_batchcopy_vvvvvxw);

	var add_php_batchmove_vvvvvxx = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvxx(add_php_batchmove_vvvvvxx);

	var add_php_before_publish_vvvvvxy = jQuery("#jform_add_php_before_publish input[type='radio']:checked").val();
	vvvvvxy(add_php_before_publish_vvvvvxy);

	var add_php_after_publish_vvvvvxz = jQuery("#jform_add_php_after_publish input[type='radio']:checked").val();
	vvvvvxz(add_php_after_publish_vvvvvxz);

	var add_php_before_delete_vvvvvya = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvya(add_php_before_delete_vvvvvya);

	var add_php_after_delete_vvvvvyb = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvyb(add_php_after_delete_vvvvvyb);

	var add_php_document_vvvvvyc = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvyc(add_php_document_vvvvvyc);

	var add_sql_vvvvvyd = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvyd(add_sql_vvvvvyd);

	var source_vvvvvye = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvye = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvye(source_vvvvvye,add_sql_vvvvvye);

	var source_vvvvvyg = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvyg = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvyg(source_vvvvvyg,add_sql_vvvvvyg);

	var add_custom_import_vvvvvyi = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvyi(add_custom_import_vvvvvyi);

	var add_custom_import_vvvvvyj = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvyj(add_custom_import_vvvvvyj);

	var add_custom_button_vvvvvyk = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvyk(add_custom_button_vvvvvyk);
});

// the vvvvvxd function
function vvvvvxd(add_css_view_vvvvvxd)
{
	// set the function logic
	if (add_css_view_vvvvvxd == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxe function
function vvvvvxe(add_css_views_vvvvvxe)
{
	// set the function logic
	if (add_css_views_vvvvvxe == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxf function
function vvvvvxf(add_javascript_view_file_vvvvvxf)
{
	// set the function logic
	if (add_javascript_view_file_vvvvvxf == 1)
	{
		jQuery('#jform_javascript_view_file-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_file-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxg function
function vvvvvxg(add_javascript_views_file_vvvvvxg)
{
	// set the function logic
	if (add_javascript_views_file_vvvvvxg == 1)
	{
		jQuery('#jform_javascript_views_file-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_file-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxh function
function vvvvvxh(add_javascript_view_footer_vvvvvxh)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvxh == 1)
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxi function
function vvvvvxi(add_javascript_views_footer_vvvvvxi)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvxi == 1)
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxj function
function vvvvvxj(add_php_ajax_vvvvvxj)
{
	// set the function logic
	if (add_php_ajax_vvvvvxj == 1)
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxk function
function vvvvvxk(add_php_getitem_vvvvvxk)
{
	// set the function logic
	if (add_php_getitem_vvvvvxk == 1)
	{
		jQuery('#jform_php_getitem-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getitem-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxl function
function vvvvvxl(add_php_getitems_vvvvvxl)
{
	// set the function logic
	if (add_php_getitems_vvvvvxl == 1)
	{
		jQuery('#jform_php_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxm function
function vvvvvxm(add_php_getitems_after_all_vvvvvxm)
{
	// set the function logic
	if (add_php_getitems_after_all_vvvvvxm == 1)
	{
		jQuery('#jform_php_getitems_after_all-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getitems_after_all-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxn function
function vvvvvxn(add_php_getlistquery_vvvvvxn)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvxn == 1)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxo function
function vvvvvxo(add_php_getform_vvvvvxo)
{
	// set the function logic
	if (add_php_getform_vvvvvxo == 1)
	{
		jQuery('#jform_php_getform-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getform-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxp function
function vvvvvxp(add_php_before_save_vvvvvxp)
{
	// set the function logic
	if (add_php_before_save_vvvvvxp == 1)
	{
		jQuery('#jform_php_before_save-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_save-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxq function
function vvvvvxq(add_php_save_vvvvvxq)
{
	// set the function logic
	if (add_php_save_vvvvvxq == 1)
	{
		jQuery('#jform_php_save-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_save-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxr function
function vvvvvxr(add_php_postsavehook_vvvvvxr)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvxr == 1)
	{
		jQuery('#jform_php_postsavehook-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postsavehook-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxs function
function vvvvvxs(add_php_allowadd_vvvvvxs)
{
	// set the function logic
	if (add_php_allowadd_vvvvvxs == 1)
	{
		jQuery('#jform_php_allowadd-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_allowadd-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxt function
function vvvvvxt(add_php_allowedit_vvvvvxt)
{
	// set the function logic
	if (add_php_allowedit_vvvvvxt == 1)
	{
		jQuery('#jform_php_allowedit-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_allowedit-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxu function
function vvvvvxu(add_php_before_cancel_vvvvvxu)
{
	// set the function logic
	if (add_php_before_cancel_vvvvvxu == 1)
	{
		jQuery('#jform_php_before_cancel-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_cancel-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxv function
function vvvvvxv(add_php_after_cancel_vvvvvxv)
{
	// set the function logic
	if (add_php_after_cancel_vvvvvxv == 1)
	{
		jQuery('#jform_php_after_cancel-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_cancel-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxw function
function vvvvvxw(add_php_batchcopy_vvvvvxw)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvxw == 1)
	{
		jQuery('#jform_php_batchcopy-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_batchcopy-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxx function
function vvvvvxx(add_php_batchmove_vvvvvxx)
{
	// set the function logic
	if (add_php_batchmove_vvvvvxx == 1)
	{
		jQuery('#jform_php_batchmove-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_batchmove-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxy function
function vvvvvxy(add_php_before_publish_vvvvvxy)
{
	// set the function logic
	if (add_php_before_publish_vvvvvxy == 1)
	{
		jQuery('#jform_php_before_publish-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_publish-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxz function
function vvvvvxz(add_php_after_publish_vvvvvxz)
{
	// set the function logic
	if (add_php_after_publish_vvvvvxz == 1)
	{
		jQuery('#jform_php_after_publish-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_publish-lbl').closest('.control-group').hide();
	}
}

// the vvvvvya function
function vvvvvya(add_php_before_delete_vvvvvya)
{
	// set the function logic
	if (add_php_before_delete_vvvvvya == 1)
	{
		jQuery('#jform_php_before_delete-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_delete-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyb function
function vvvvvyb(add_php_after_delete_vvvvvyb)
{
	// set the function logic
	if (add_php_after_delete_vvvvvyb == 1)
	{
		jQuery('#jform_php_after_delete-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_delete-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyc function
function vvvvvyc(add_php_document_vvvvvyc)
{
	// set the function logic
	if (add_php_document_vvvvvyc == 1)
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyd function
function vvvvvyd(add_sql_vvvvvyd)
{
	// set the function logic
	if (add_sql_vvvvvyd == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		// add required attribute to source field
		if (jform_vvvvvydvwd_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvydvwd_required = false;
		}
	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		// remove required attribute from source field
		if (!jform_vvvvvydvwd_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvydvwd_required = true;
		}
	}
}

// the vvvvvye function
function vvvvvye(source_vvvvvye,add_sql_vvvvvye)
{
	// set the function logic
	if (source_vvvvvye == 2 && add_sql_vvvvvye == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		// add required attribute to sql field
		if (jform_vvvvvyevwe_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvyevwe_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		// remove required attribute from sql field
		if (!jform_vvvvvyevwe_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvyevwe_required = true;
		}
	}
}

// the vvvvvyg function
function vvvvvyg(source_vvvvvyg,add_sql_vvvvvyg)
{
	// set the function logic
	if (source_vvvvvyg == 1 && add_sql_vvvvvyg == 1)
	{
		jQuery('#jform_addtables-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyi function
function vvvvvyi(add_custom_import_vvvvvyi)
{
	// set the function logic
	if (add_custom_import_vvvvvyi == 1)
	{
		jQuery('#jform_html_import_view').closest('.control-group').show();
		// add required attribute to html_import_view field
		if (jform_vvvvvyivwf_required)
		{
			updateFieldRequired('html_import_view',0);
			jQuery('#jform_html_import_view').prop('required','required');
			jQuery('#jform_html_import_view').attr('aria-required',true);
			jQuery('#jform_html_import_view').addClass('required');
			jform_vvvvvyivwf_required = false;
		}
		jQuery('.note_advanced_import').closest('.control-group').show();
		jQuery('#jform_php_import_display').closest('.control-group').show();
		// add required attribute to php_import_display field
		if (jform_vvvvvyivwg_required)
		{
			updateFieldRequired('php_import_display',0);
			jQuery('#jform_php_import_display').prop('required','required');
			jQuery('#jform_php_import_display').attr('aria-required',true);
			jQuery('#jform_php_import_display').addClass('required');
			jform_vvvvvyivwg_required = false;
		}
		jQuery('#jform_php_import_ext').closest('.control-group').show();
		// add required attribute to php_import_ext field
		if (jform_vvvvvyivwh_required)
		{
			updateFieldRequired('php_import_ext',0);
			jQuery('#jform_php_import_ext').prop('required','required');
			jQuery('#jform_php_import_ext').attr('aria-required',true);
			jQuery('#jform_php_import_ext').addClass('required');
			jform_vvvvvyivwh_required = false;
		}
		jQuery('#jform_php_import_headers').closest('.control-group').show();
		// add required attribute to php_import_headers field
		if (jform_vvvvvyivwi_required)
		{
			updateFieldRequired('php_import_headers',0);
			jQuery('#jform_php_import_headers').prop('required','required');
			jQuery('#jform_php_import_headers').attr('aria-required',true);
			jQuery('#jform_php_import_headers').addClass('required');
			jform_vvvvvyivwi_required = false;
		}
		jQuery('#jform_php_import').closest('.control-group').show();
		// add required attribute to php_import field
		if (jform_vvvvvyivwj_required)
		{
			updateFieldRequired('php_import',0);
			jQuery('#jform_php_import').prop('required','required');
			jQuery('#jform_php_import').attr('aria-required',true);
			jQuery('#jform_php_import').addClass('required');
			jform_vvvvvyivwj_required = false;
		}
		jQuery('#jform_php_import_save').closest('.control-group').show();
		// add required attribute to php_import_save field
		if (jform_vvvvvyivwk_required)
		{
			updateFieldRequired('php_import_save',0);
			jQuery('#jform_php_import_save').prop('required','required');
			jQuery('#jform_php_import_save').attr('aria-required',true);
			jQuery('#jform_php_import_save').addClass('required');
			jform_vvvvvyivwk_required = false;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').show();
		// add required attribute to php_import_setdata field
		if (jform_vvvvvyivwl_required)
		{
			updateFieldRequired('php_import_setdata',0);
			jQuery('#jform_php_import_setdata').prop('required','required');
			jQuery('#jform_php_import_setdata').attr('aria-required',true);
			jQuery('#jform_php_import_setdata').addClass('required');
			jform_vvvvvyivwl_required = false;
		}
	}
	else
	{
		jQuery('#jform_html_import_view').closest('.control-group').hide();
		// remove required attribute from html_import_view field
		if (!jform_vvvvvyivwf_required)
		{
			updateFieldRequired('html_import_view',1);
			jQuery('#jform_html_import_view').removeAttr('required');
			jQuery('#jform_html_import_view').removeAttr('aria-required');
			jQuery('#jform_html_import_view').removeClass('required');
			jform_vvvvvyivwf_required = true;
		}
		jQuery('.note_advanced_import').closest('.control-group').hide();
		jQuery('#jform_php_import_display').closest('.control-group').hide();
		// remove required attribute from php_import_display field
		if (!jform_vvvvvyivwg_required)
		{
			updateFieldRequired('php_import_display',1);
			jQuery('#jform_php_import_display').removeAttr('required');
			jQuery('#jform_php_import_display').removeAttr('aria-required');
			jQuery('#jform_php_import_display').removeClass('required');
			jform_vvvvvyivwg_required = true;
		}
		jQuery('#jform_php_import_ext').closest('.control-group').hide();
		// remove required attribute from php_import_ext field
		if (!jform_vvvvvyivwh_required)
		{
			updateFieldRequired('php_import_ext',1);
			jQuery('#jform_php_import_ext').removeAttr('required');
			jQuery('#jform_php_import_ext').removeAttr('aria-required');
			jQuery('#jform_php_import_ext').removeClass('required');
			jform_vvvvvyivwh_required = true;
		}
		jQuery('#jform_php_import_headers').closest('.control-group').hide();
		// remove required attribute from php_import_headers field
		if (!jform_vvvvvyivwi_required)
		{
			updateFieldRequired('php_import_headers',1);
			jQuery('#jform_php_import_headers').removeAttr('required');
			jQuery('#jform_php_import_headers').removeAttr('aria-required');
			jQuery('#jform_php_import_headers').removeClass('required');
			jform_vvvvvyivwi_required = true;
		}
		jQuery('#jform_php_import').closest('.control-group').hide();
		// remove required attribute from php_import field
		if (!jform_vvvvvyivwj_required)
		{
			updateFieldRequired('php_import',1);
			jQuery('#jform_php_import').removeAttr('required');
			jQuery('#jform_php_import').removeAttr('aria-required');
			jQuery('#jform_php_import').removeClass('required');
			jform_vvvvvyivwj_required = true;
		}
		jQuery('#jform_php_import_save').closest('.control-group').hide();
		// remove required attribute from php_import_save field
		if (!jform_vvvvvyivwk_required)
		{
			updateFieldRequired('php_import_save',1);
			jQuery('#jform_php_import_save').removeAttr('required');
			jQuery('#jform_php_import_save').removeAttr('aria-required');
			jQuery('#jform_php_import_save').removeClass('required');
			jform_vvvvvyivwk_required = true;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').hide();
		// remove required attribute from php_import_setdata field
		if (!jform_vvvvvyivwl_required)
		{
			updateFieldRequired('php_import_setdata',1);
			jQuery('#jform_php_import_setdata').removeAttr('required');
			jQuery('#jform_php_import_setdata').removeAttr('aria-required');
			jQuery('#jform_php_import_setdata').removeClass('required');
			jform_vvvvvyivwl_required = true;
		}
	}
}

// the vvvvvyj function
function vvvvvyj(add_custom_import_vvvvvyj)
{
	// set the function logic
	if (add_custom_import_vvvvvyj == 0)
	{
		jQuery('.note_beginner_import').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_beginner_import').closest('.control-group').hide();
	}
}

// the vvvvvyk function
function vvvvvyk(add_custom_button_vvvvvyk)
{
	// set the function logic
	if (add_custom_button_vvvvvyk == 1)
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').show();
		jQuery('#jform_php_controller-lbl').closest('.control-group').show();
		jQuery('#jform_php_controller_list-lbl').closest('.control-group').show();
		jQuery('#jform_php_model-lbl').closest('.control-group').show();
		jQuery('#jform_php_model_list-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').hide();
		jQuery('#jform_php_controller-lbl').closest('.control-group').hide();
		jQuery('#jform_php_controller_list-lbl').closest('.control-group').hide();
		jQuery('#jform_php_model-lbl').closest('.control-group').hide();
		jQuery('#jform_php_model_list-lbl').closest('.control-group').hide();
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


jQuery(document).ready(function()
{
	// check if this view has alias field
	checkAliasField();
	// get the linked details
	getLinked();
	// set button
	addButtonID('admin_fields','create_edit_buttons', 1); // <-- first
	var valueSwitch = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	getDynamicScripts(valueSwitch);
	// now load the fields
	getAjaxDisplay('admin_fields');
	getAjaxDisplay('admin_fields_conditions');
	getAjaxDisplay('admin_fields_relations');
	// set button
	addButtonID('admin_fields_conditions','create_edit_buttons', 1); // <-- second
	// set button to create more fields
	addButton('field','create_edit_buttons'); // <-- third
	// set button
	addButtonID('admin_fields_relations','create_edit_buttons', 1); // <-- forth
	// set button
	addButtonID('admin_custom_tabs','addtabs-lbl', 1); // <-- fifth
	// check and load all the customcode edit buttons
	getEditCustomCodeButtons();
});

function checkAliasField() {
	checkAliasField_server(1).done(function(result) {
		if(result){
			// remove the notice
			jQuery('.note_create_edit_notice_p').remove();
		} else {
			// hide everything about alias management
			jQuery('#jform_alias_builder_type').closest('.control-group').remove();
			jQuery('#jform_alias_builder').closest('.control-group').remove();
			jQuery('.note_alias_builder_default').closest('.control-group').remove();
			jQuery('.note_alias_builder_custom').closest('.control-group').remove();
		}
	});
}

function checkAliasField_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.checkAliasField&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type > 0){
		var request = token+'=1&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getAjaxDisplay(type){
	getAjaxDisplay_server(type).done(function(result) {
		if(result){
			jQuery('#display_'+type).html(result);
		}
		// set button
		addButtonID(type,'header_'+type+'_buttons', 2); // <-- little edit button
	});
}

function getAjaxDisplay_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function addData(result,where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}

function getTableColumns_server(tableName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.tableColumns&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && tableName.length > 0){
		var request = token+'=1&table='+tableName;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getTableColumns(fieldKey, table_, nr_){
	// first check if the field is set
	if(jQuery("#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_table").length) {
		// get options
		var tableName = jQuery("#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_table option:selected").val();
		getTableColumns_server(tableName).done(function(result) {
			if(result){
				jQuery("textarea#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_sourcemap").val(result);
			}
			else
			{
				jQuery("textarea#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_sourcemap").val('');
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
		var current_import_display = jQuery('textarea#jform_php_import_display').val();
		var current_import = jQuery('textarea#jform_php_import').val();
		var current_headers = jQuery('textarea#jform_php_import_headers').val();
		var current_setdata = jQuery('textarea#jform_php_import_setdata').val();
		var current_save = jQuery('textarea#jform_php_import_save').val();
		var current_view = jQuery('textarea#jform_html_import_view').val();
		var current_ext = jQuery('textarea#jform_php_import_ext').val();
		// set the display method script
		if(current_import_display.length == 0){
			getDynamicScripts_server('display').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_display').val(result);
				}
			});
		}
		// set the import method script
		if(current_import.length == 0){
			getDynamicScripts_server('import').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import').val(result);
				}
			});
		}
		// set the headers method script
		if(current_headers.length == 0){
			getDynamicScripts_server('headers').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_headers').val(result);
				}
			});
		}
		// set the setData method script
		if(current_setdata.length == 0){
			getDynamicScripts_server('setdata').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_setdata').val(result);
				}
			});
		}
		// set the save method script
		if(current_save.length == 0){
			getDynamicScripts_server('save').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_save').val(result);
				}
			});
		}
		// set the view script
		if(current_view.length == 0){
			getDynamicScripts_server('view').done(function(result) {
				if(result){
					jQuery('textarea#jform_html_import_view').val(result);
				}
			});
		}
		// set the import ext script
		if(current_ext.length == 0){
			getDynamicScripts_server('ext').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_ext').val(result);
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

function addButtonID_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButtonID&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0 && size > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButtonID(type, where, size){
	addButtonID_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	});
}

function addButton_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButton(type, where, size){
	// just to insure that default behaviour still works
	size = typeof size !== 'undefined' ? size : 1;
	addButton_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	})
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
