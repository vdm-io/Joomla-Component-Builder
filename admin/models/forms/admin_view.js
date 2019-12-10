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
jform_vvvvvzvvwl_required = false;
jform_vvvvvzwvwm_required = false;
jform_vvvvwaavwn_required = false;
jform_vvvvwaavwo_required = false;
jform_vvvvwaavwp_required = false;
jform_vvvvwaavwq_required = false;
jform_vvvvwaavwr_required = false;
jform_vvvvwaavws_required = false;
jform_vvvvwaavwt_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vvvvvyv = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvyv(add_css_view_vvvvvyv);

	var add_css_views_vvvvvyw = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvyw(add_css_views_vvvvvyw);

	var add_javascript_view_file_vvvvvyx = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	vvvvvyx(add_javascript_view_file_vvvvvyx);

	var add_javascript_views_file_vvvvvyy = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	vvvvvyy(add_javascript_views_file_vvvvvyy);

	var add_javascript_view_footer_vvvvvyz = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvyz(add_javascript_view_footer_vvvvvyz);

	var add_javascript_views_footer_vvvvvza = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvza(add_javascript_views_footer_vvvvvza);

	var add_php_ajax_vvvvvzb = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvzb(add_php_ajax_vvvvvzb);

	var add_php_getitem_vvvvvzc = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	vvvvvzc(add_php_getitem_vvvvvzc);

	var add_php_getitems_vvvvvzd = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	vvvvvzd(add_php_getitems_vvvvvzd);

	var add_php_getitems_after_all_vvvvvze = jQuery("#jform_add_php_getitems_after_all input[type='radio']:checked").val();
	vvvvvze(add_php_getitems_after_all_vvvvvze);

	var add_php_getlistquery_vvvvvzf = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	vvvvvzf(add_php_getlistquery_vvvvvzf);

	var add_php_getform_vvvvvzg = jQuery("#jform_add_php_getform input[type='radio']:checked").val();
	vvvvvzg(add_php_getform_vvvvvzg);

	var add_php_before_save_vvvvvzh = jQuery("#jform_add_php_before_save input[type='radio']:checked").val();
	vvvvvzh(add_php_before_save_vvvvvzh);

	var add_php_save_vvvvvzi = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvzi(add_php_save_vvvvvzi);

	var add_php_postsavehook_vvvvvzj = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvzj(add_php_postsavehook_vvvvvzj);

	var add_php_allowadd_vvvvvzk = jQuery("#jform_add_php_allowadd input[type='radio']:checked").val();
	vvvvvzk(add_php_allowadd_vvvvvzk);

	var add_php_allowedit_vvvvvzl = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvzl(add_php_allowedit_vvvvvzl);

	var add_php_before_cancel_vvvvvzm = jQuery("#jform_add_php_before_cancel input[type='radio']:checked").val();
	vvvvvzm(add_php_before_cancel_vvvvvzm);

	var add_php_after_cancel_vvvvvzn = jQuery("#jform_add_php_after_cancel input[type='radio']:checked").val();
	vvvvvzn(add_php_after_cancel_vvvvvzn);

	var add_php_batchcopy_vvvvvzo = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvzo(add_php_batchcopy_vvvvvzo);

	var add_php_batchmove_vvvvvzp = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvzp(add_php_batchmove_vvvvvzp);

	var add_php_before_publish_vvvvvzq = jQuery("#jform_add_php_before_publish input[type='radio']:checked").val();
	vvvvvzq(add_php_before_publish_vvvvvzq);

	var add_php_after_publish_vvvvvzr = jQuery("#jform_add_php_after_publish input[type='radio']:checked").val();
	vvvvvzr(add_php_after_publish_vvvvvzr);

	var add_php_before_delete_vvvvvzs = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvzs(add_php_before_delete_vvvvvzs);

	var add_php_after_delete_vvvvvzt = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvzt(add_php_after_delete_vvvvvzt);

	var add_php_document_vvvvvzu = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvzu(add_php_document_vvvvvzu);

	var add_sql_vvvvvzv = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvzv(add_sql_vvvvvzv);

	var source_vvvvvzw = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvzw = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvzw(source_vvvvvzw,add_sql_vvvvvzw);

	var source_vvvvvzy = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvzy = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvzy(source_vvvvvzy,add_sql_vvvvvzy);

	var add_custom_import_vvvvwaa = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvwaa(add_custom_import_vvvvwaa);

	var add_custom_import_vvvvwab = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvwab(add_custom_import_vvvvwab);

	var add_custom_button_vvvvwac = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvwac(add_custom_button_vvvvwac);
});

// the vvvvvyv function
function vvvvvyv(add_css_view_vvvvvyv)
{
	// set the function logic
	if (add_css_view_vvvvvyv == 1)
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyw function
function vvvvvyw(add_css_views_vvvvvyw)
{
	// set the function logic
	if (add_css_views_vvvvvyw == 1)
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_views-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyx function
function vvvvvyx(add_javascript_view_file_vvvvvyx)
{
	// set the function logic
	if (add_javascript_view_file_vvvvvyx == 1)
	{
		jQuery('#jform_javascript_view_file-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_file-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyy function
function vvvvvyy(add_javascript_views_file_vvvvvyy)
{
	// set the function logic
	if (add_javascript_views_file_vvvvvyy == 1)
	{
		jQuery('#jform_javascript_views_file-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_file-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyz function
function vvvvvyz(add_javascript_view_footer_vvvvvyz)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvyz == 1)
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_view_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvvza function
function vvvvvza(add_javascript_views_footer_vvvvvza)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvza == 1)
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_views_footer-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzb function
function vvvvvzb(add_php_ajax_vvvvvzb)
{
	// set the function logic
	if (add_php_ajax_vvvvvzb == 1)
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

// the vvvvvzc function
function vvvvvzc(add_php_getitem_vvvvvzc)
{
	// set the function logic
	if (add_php_getitem_vvvvvzc == 1)
	{
		jQuery('#jform_php_getitem-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getitem-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzd function
function vvvvvzd(add_php_getitems_vvvvvzd)
{
	// set the function logic
	if (add_php_getitems_vvvvvzd == 1)
	{
		jQuery('#jform_php_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvvze function
function vvvvvze(add_php_getitems_after_all_vvvvvze)
{
	// set the function logic
	if (add_php_getitems_after_all_vvvvvze == 1)
	{
		jQuery('#jform_php_getitems_after_all-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getitems_after_all-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzf function
function vvvvvzf(add_php_getlistquery_vvvvvzf)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzf == 1)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzg function
function vvvvvzg(add_php_getform_vvvvvzg)
{
	// set the function logic
	if (add_php_getform_vvvvvzg == 1)
	{
		jQuery('#jform_php_getform-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getform-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzh function
function vvvvvzh(add_php_before_save_vvvvvzh)
{
	// set the function logic
	if (add_php_before_save_vvvvvzh == 1)
	{
		jQuery('#jform_php_before_save-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_save-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzi function
function vvvvvzi(add_php_save_vvvvvzi)
{
	// set the function logic
	if (add_php_save_vvvvvzi == 1)
	{
		jQuery('#jform_php_save-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_save-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzj function
function vvvvvzj(add_php_postsavehook_vvvvvzj)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvzj == 1)
	{
		jQuery('#jform_php_postsavehook-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postsavehook-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzk function
function vvvvvzk(add_php_allowadd_vvvvvzk)
{
	// set the function logic
	if (add_php_allowadd_vvvvvzk == 1)
	{
		jQuery('#jform_php_allowadd-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_allowadd-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzl function
function vvvvvzl(add_php_allowedit_vvvvvzl)
{
	// set the function logic
	if (add_php_allowedit_vvvvvzl == 1)
	{
		jQuery('#jform_php_allowedit-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_allowedit-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzm function
function vvvvvzm(add_php_before_cancel_vvvvvzm)
{
	// set the function logic
	if (add_php_before_cancel_vvvvvzm == 1)
	{
		jQuery('#jform_php_before_cancel-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_cancel-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzn function
function vvvvvzn(add_php_after_cancel_vvvvvzn)
{
	// set the function logic
	if (add_php_after_cancel_vvvvvzn == 1)
	{
		jQuery('#jform_php_after_cancel-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_cancel-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzo function
function vvvvvzo(add_php_batchcopy_vvvvvzo)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvzo == 1)
	{
		jQuery('#jform_php_batchcopy-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_batchcopy-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzp function
function vvvvvzp(add_php_batchmove_vvvvvzp)
{
	// set the function logic
	if (add_php_batchmove_vvvvvzp == 1)
	{
		jQuery('#jform_php_batchmove-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_batchmove-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzq function
function vvvvvzq(add_php_before_publish_vvvvvzq)
{
	// set the function logic
	if (add_php_before_publish_vvvvvzq == 1)
	{
		jQuery('#jform_php_before_publish-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_publish-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzr function
function vvvvvzr(add_php_after_publish_vvvvvzr)
{
	// set the function logic
	if (add_php_after_publish_vvvvvzr == 1)
	{
		jQuery('#jform_php_after_publish-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_publish-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzs function
function vvvvvzs(add_php_before_delete_vvvvvzs)
{
	// set the function logic
	if (add_php_before_delete_vvvvvzs == 1)
	{
		jQuery('#jform_php_before_delete-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_delete-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzt function
function vvvvvzt(add_php_after_delete_vvvvvzt)
{
	// set the function logic
	if (add_php_after_delete_vvvvvzt == 1)
	{
		jQuery('#jform_php_after_delete-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_delete-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzu function
function vvvvvzu(add_php_document_vvvvvzu)
{
	// set the function logic
	if (add_php_document_vvvvvzu == 1)
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzv function
function vvvvvzv(add_sql_vvvvvzv)
{
	// set the function logic
	if (add_sql_vvvvvzv == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		// add required attribute to source field
		if (jform_vvvvvzvvwl_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvzvvwl_required = false;
		}
	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		// remove required attribute from source field
		if (!jform_vvvvvzvvwl_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvzvvwl_required = true;
		}
	}
}

// the vvvvvzw function
function vvvvvzw(source_vvvvvzw,add_sql_vvvvvzw)
{
	// set the function logic
	if (source_vvvvvzw == 2 && add_sql_vvvvvzw == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		// add required attribute to sql field
		if (jform_vvvvvzwvwm_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvzwvwm_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		// remove required attribute from sql field
		if (!jform_vvvvvzwvwm_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvzwvwm_required = true;
		}
	}
}

// the vvvvvzy function
function vvvvvzy(source_vvvvvzy,add_sql_vvvvvzy)
{
	// set the function logic
	if (source_vvvvvzy == 1 && add_sql_vvvvvzy == 1)
	{
		jQuery('#jform_addtables-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables-lbl').closest('.control-group').hide();
	}
}

// the vvvvwaa function
function vvvvwaa(add_custom_import_vvvvwaa)
{
	// set the function logic
	if (add_custom_import_vvvvwaa == 1)
	{
		jQuery('#jform_html_import_view').closest('.control-group').show();
		// add required attribute to html_import_view field
		if (jform_vvvvwaavwn_required)
		{
			updateFieldRequired('html_import_view',0);
			jQuery('#jform_html_import_view').prop('required','required');
			jQuery('#jform_html_import_view').attr('aria-required',true);
			jQuery('#jform_html_import_view').addClass('required');
			jform_vvvvwaavwn_required = false;
		}
		jQuery('.note_advanced_import').closest('.control-group').show();
		jQuery('#jform_php_import_display').closest('.control-group').show();
		// add required attribute to php_import_display field
		if (jform_vvvvwaavwo_required)
		{
			updateFieldRequired('php_import_display',0);
			jQuery('#jform_php_import_display').prop('required','required');
			jQuery('#jform_php_import_display').attr('aria-required',true);
			jQuery('#jform_php_import_display').addClass('required');
			jform_vvvvwaavwo_required = false;
		}
		jQuery('#jform_php_import_ext').closest('.control-group').show();
		// add required attribute to php_import_ext field
		if (jform_vvvvwaavwp_required)
		{
			updateFieldRequired('php_import_ext',0);
			jQuery('#jform_php_import_ext').prop('required','required');
			jQuery('#jform_php_import_ext').attr('aria-required',true);
			jQuery('#jform_php_import_ext').addClass('required');
			jform_vvvvwaavwp_required = false;
		}
		jQuery('#jform_php_import_headers').closest('.control-group').show();
		// add required attribute to php_import_headers field
		if (jform_vvvvwaavwq_required)
		{
			updateFieldRequired('php_import_headers',0);
			jQuery('#jform_php_import_headers').prop('required','required');
			jQuery('#jform_php_import_headers').attr('aria-required',true);
			jQuery('#jform_php_import_headers').addClass('required');
			jform_vvvvwaavwq_required = false;
		}
		jQuery('#jform_php_import').closest('.control-group').show();
		// add required attribute to php_import field
		if (jform_vvvvwaavwr_required)
		{
			updateFieldRequired('php_import',0);
			jQuery('#jform_php_import').prop('required','required');
			jQuery('#jform_php_import').attr('aria-required',true);
			jQuery('#jform_php_import').addClass('required');
			jform_vvvvwaavwr_required = false;
		}
		jQuery('#jform_php_import_save').closest('.control-group').show();
		// add required attribute to php_import_save field
		if (jform_vvvvwaavws_required)
		{
			updateFieldRequired('php_import_save',0);
			jQuery('#jform_php_import_save').prop('required','required');
			jQuery('#jform_php_import_save').attr('aria-required',true);
			jQuery('#jform_php_import_save').addClass('required');
			jform_vvvvwaavws_required = false;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').show();
		// add required attribute to php_import_setdata field
		if (jform_vvvvwaavwt_required)
		{
			updateFieldRequired('php_import_setdata',0);
			jQuery('#jform_php_import_setdata').prop('required','required');
			jQuery('#jform_php_import_setdata').attr('aria-required',true);
			jQuery('#jform_php_import_setdata').addClass('required');
			jform_vvvvwaavwt_required = false;
		}
	}
	else
	{
		jQuery('#jform_html_import_view').closest('.control-group').hide();
		// remove required attribute from html_import_view field
		if (!jform_vvvvwaavwn_required)
		{
			updateFieldRequired('html_import_view',1);
			jQuery('#jform_html_import_view').removeAttr('required');
			jQuery('#jform_html_import_view').removeAttr('aria-required');
			jQuery('#jform_html_import_view').removeClass('required');
			jform_vvvvwaavwn_required = true;
		}
		jQuery('.note_advanced_import').closest('.control-group').hide();
		jQuery('#jform_php_import_display').closest('.control-group').hide();
		// remove required attribute from php_import_display field
		if (!jform_vvvvwaavwo_required)
		{
			updateFieldRequired('php_import_display',1);
			jQuery('#jform_php_import_display').removeAttr('required');
			jQuery('#jform_php_import_display').removeAttr('aria-required');
			jQuery('#jform_php_import_display').removeClass('required');
			jform_vvvvwaavwo_required = true;
		}
		jQuery('#jform_php_import_ext').closest('.control-group').hide();
		// remove required attribute from php_import_ext field
		if (!jform_vvvvwaavwp_required)
		{
			updateFieldRequired('php_import_ext',1);
			jQuery('#jform_php_import_ext').removeAttr('required');
			jQuery('#jform_php_import_ext').removeAttr('aria-required');
			jQuery('#jform_php_import_ext').removeClass('required');
			jform_vvvvwaavwp_required = true;
		}
		jQuery('#jform_php_import_headers').closest('.control-group').hide();
		// remove required attribute from php_import_headers field
		if (!jform_vvvvwaavwq_required)
		{
			updateFieldRequired('php_import_headers',1);
			jQuery('#jform_php_import_headers').removeAttr('required');
			jQuery('#jform_php_import_headers').removeAttr('aria-required');
			jQuery('#jform_php_import_headers').removeClass('required');
			jform_vvvvwaavwq_required = true;
		}
		jQuery('#jform_php_import').closest('.control-group').hide();
		// remove required attribute from php_import field
		if (!jform_vvvvwaavwr_required)
		{
			updateFieldRequired('php_import',1);
			jQuery('#jform_php_import').removeAttr('required');
			jQuery('#jform_php_import').removeAttr('aria-required');
			jQuery('#jform_php_import').removeClass('required');
			jform_vvvvwaavwr_required = true;
		}
		jQuery('#jform_php_import_save').closest('.control-group').hide();
		// remove required attribute from php_import_save field
		if (!jform_vvvvwaavws_required)
		{
			updateFieldRequired('php_import_save',1);
			jQuery('#jform_php_import_save').removeAttr('required');
			jQuery('#jform_php_import_save').removeAttr('aria-required');
			jQuery('#jform_php_import_save').removeClass('required');
			jform_vvvvwaavws_required = true;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').hide();
		// remove required attribute from php_import_setdata field
		if (!jform_vvvvwaavwt_required)
		{
			updateFieldRequired('php_import_setdata',1);
			jQuery('#jform_php_import_setdata').removeAttr('required');
			jQuery('#jform_php_import_setdata').removeAttr('aria-required');
			jQuery('#jform_php_import_setdata').removeClass('required');
			jform_vvvvwaavwt_required = true;
		}
	}
}

// the vvvvwab function
function vvvvwab(add_custom_import_vvvvwab)
{
	// set the function logic
	if (add_custom_import_vvvvwab == 0)
	{
		jQuery('.note_beginner_import').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_beginner_import').closest('.control-group').hide();
	}
}

// the vvvvwac function
function vvvvwac(add_custom_button_vvvvwac)
{
	// set the function logic
	if (add_custom_button_vvvvwac == 1)
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
	getCodeFrom_server(1, 'type', 'type', 'checkAliasField').done(function(result) {
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
	getCodeFrom_server(1, type, 'type', 'getAjaxDisplay').done(function(result) {
		if(result){
			jQuery('#display_'+type).html(result);
		}
		// set button
		addButtonID(type,'header_'+type+'_buttons', 2); // <-- little edit button
	});
}

function addData(result,where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}

function getTableColumns(fieldKey, table_, nr_){
	// first check if the field is set
	if(jQuery("#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_table").length) {
		// get options
		var tableName = jQuery("#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_table option:selected").val();
		getCodeFrom_server(1, tableName, 'table', 'tableColumns').done(function(result) {
			if(result){
				jQuery("textarea#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_sourcemap").val(result);
			} else {
				jQuery("textarea#jform_addtables_"+table_+"addtables"+fieldKey+nr_+"_sourcemap").val('');
			}
		});
	}
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
			getCodeFrom_server(1, 'display', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_display').val(result);
				}
			});
		}
		// set the import method script
		if(current_import.length == 0){
			getCodeFrom_server(1, 'import', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import').val(result);
				}
			});
		}
		// set the headers method script
		if(current_headers.length == 0){
			getCodeFrom_server(1, 'headers', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_headers').val(result);
				}
			});
		}
		// set the setData method script
		if(current_setdata.length == 0){
			getCodeFrom_server(1, 'setdata', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_setdata').val(result);
				}
			});
		}
		// set the save method script
		if(current_save.length == 0){
			getCodeFrom_server(1, 'save', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_save').val(result);
				}
			});
		}
		// set the view script
		if(current_view.length == 0){
			getCodeFrom_server(1, 'view', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_html_import_view').val(result);
				}
			});
		}
		// set the import ext script
		if(current_ext.length == 0){
			getCodeFrom_server(1, 'ext', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_ext').val(result);
				}
			});
		}
	}
}

function getCodeFrom_server(id, type, type_name, callingName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0 && type.length > 0) {
		var request = token + '=1&' + type_name + '=' + type + '&id=' + id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
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

function getLinked(){
	getCodeFrom_server(1, 'type', 'type', 'getLinked').done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
} 
