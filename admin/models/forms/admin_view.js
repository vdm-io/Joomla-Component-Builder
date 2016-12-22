/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.2.5
	@build			22nd December, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		admin_view.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvwvvwn_required = false;
jform_vvvvvwwvwo_required = false;
jform_vvvvvwxvwp_required = false;
jform_vvvvvwyvwq_required = false;
jform_vvvvvwzvwr_required = false;
jform_vvvvvxavws_required = false;
jform_vvvvvxbvwt_required = false;
jform_vvvvvxcvwu_required = false;
jform_vvvvvxdvwv_required = false;
jform_vvvvvxevww_required = false;
jform_vvvvvxfvwx_required = false;
jform_vvvvvxgvwy_required = false;
jform_vvvvvxhvwz_required = false;
jform_vvvvvxivxa_required = false;
jform_vvvvvxjvxb_required = false;
jform_vvvvvxkvxc_required = false;
jform_vvvvvxlvxd_required = false;
jform_vvvvvxmvxe_required = false;
jform_vvvvvxnvxf_required = false;
jform_vvvvvxovxg_required = false;
jform_vvvvvxpvxh_required = false;
jform_vvvvvxqvxi_required = false;
jform_vvvvvxrvxj_required = false;
jform_vvvvvxvvxk_required = false;
jform_vvvvvxvvxl_required = false;
jform_vvvvvxvvxm_required = false;
jform_vvvvvxvvxn_required = false;
jform_vvvvvxvvxo_required = false;
jform_vvvvvxxvxp_required = false;
jform_vvvvvxxvxq_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vvvvvwv = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvwv(add_css_view_vvvvvwv);

	var add_css_views_vvvvvww = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvww(add_css_views_vvvvvww);

	var add_javascript_view_file_vvvvvwx = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	vvvvvwx(add_javascript_view_file_vvvvvwx);

	var add_javascript_views_file_vvvvvwy = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	vvvvvwy(add_javascript_views_file_vvvvvwy);

	var add_javascript_view_footer_vvvvvwz = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvwz(add_javascript_view_footer_vvvvvwz);

	var add_javascript_views_footer_vvvvvxa = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvxa(add_javascript_views_footer_vvvvvxa);

	var add_php_ajax_vvvvvxb = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvxb(add_php_ajax_vvvvvxb);

	var add_php_getitem_vvvvvxc = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	vvvvvxc(add_php_getitem_vvvvvxc);

	var add_php_getitems_vvvvvxd = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	vvvvvxd(add_php_getitems_vvvvvxd);

	var add_php_getitems_after_all_vvvvvxe = jQuery("#jform_add_php_getitems_after_all input[type='radio']:checked").val();
	vvvvvxe(add_php_getitems_after_all_vvvvvxe);

	var add_php_getlistquery_vvvvvxf = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	vvvvvxf(add_php_getlistquery_vvvvvxf);

	var add_php_save_vvvvvxg = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvxg(add_php_save_vvvvvxg);

	var add_php_postsavehook_vvvvvxh = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvxh(add_php_postsavehook_vvvvvxh);

	var add_php_allowedit_vvvvvxi = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvxi(add_php_allowedit_vvvvvxi);

	var add_php_batchcopy_vvvvvxj = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvxj(add_php_batchcopy_vvvvvxj);

	var add_php_batchmove_vvvvvxk = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvxk(add_php_batchmove_vvvvvxk);

	var add_php_before_publish_vvvvvxl = jQuery("#jform_add_php_before_publish input[type='radio']:checked").val();
	vvvvvxl(add_php_before_publish_vvvvvxl);

	var add_php_after_publish_vvvvvxm = jQuery("#jform_add_php_after_publish input[type='radio']:checked").val();
	vvvvvxm(add_php_after_publish_vvvvvxm);

	var add_php_before_delete_vvvvvxn = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvxn(add_php_before_delete_vvvvvxn);

	var add_php_after_delete_vvvvvxo = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvxo(add_php_after_delete_vvvvvxo);

	var add_php_document_vvvvvxp = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvxp(add_php_document_vvvvvxp);

	var add_sql_vvvvvxq = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxq(add_sql_vvvvvxq);

	var source_vvvvvxr = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxr = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxr(source_vvvvvxr,add_sql_vvvvvxr);

	var source_vvvvvxt = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxt = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxt(source_vvvvvxt,add_sql_vvvvvxt);

	var add_custom_import_vvvvvxv = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxv(add_custom_import_vvvvvxv);

	var add_custom_import_vvvvvxw = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxw(add_custom_import_vvvvvxw);

	var add_custom_button_vvvvvxx = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvxx(add_custom_button_vvvvvxx);
});

// the vvvvvwv function
function vvvvvwv(add_css_view_vvvvvwv)
{
	// set the function logic
	if (add_css_view_vvvvvwv == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvwvvwn_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvwvvwn_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvwvvwn_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvwvvwn_required = true;
		}
	}
}

// the vvvvvww function
function vvvvvww(add_css_views_vvvvvww)
{
	// set the function logic
	if (add_css_views_vvvvvww == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvwwvwo_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvwwvwo_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvwwvwo_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvwwvwo_required = true;
		}
	}
}

// the vvvvvwx function
function vvvvvwx(add_javascript_view_file_vvvvvwx)
{
	// set the function logic
	if (add_javascript_view_file_vvvvvwx == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_vvvvvwxvwp_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_vvvvvwxvwp_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_vvvvvwxvwp_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_vvvvvwxvwp_required = true;
		}
	}
}

// the vvvvvwy function
function vvvvvwy(add_javascript_views_file_vvvvvwy)
{
	// set the function logic
	if (add_javascript_views_file_vvvvvwy == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_vvvvvwyvwq_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_vvvvvwyvwq_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_vvvvvwyvwq_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_vvvvvwyvwq_required = true;
		}
	}
}

// the vvvvvwz function
function vvvvvwz(add_javascript_view_footer_vvvvvwz)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvwz == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvwzvwr_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvwzvwr_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvwzvwr_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvwzvwr_required = true;
		}
	}
}

// the vvvvvxa function
function vvvvvxa(add_javascript_views_footer_vvvvvxa)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvxa == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvxavws_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvxavws_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvxavws_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvxavws_required = true;
		}
	}
}

// the vvvvvxb function
function vvvvvxb(add_php_ajax_vvvvvxb)
{
	// set the function logic
	if (add_php_ajax_vvvvvxb == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvxbvwt_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvxbvwt_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvxbvwt_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvxbvwt_required = true;
		}
	}
}

// the vvvvvxc function
function vvvvvxc(add_php_getitem_vvvvvxc)
{
	// set the function logic
	if (add_php_getitem_vvvvvxc == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_vvvvvxcvwu_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_vvvvvxcvwu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_vvvvvxcvwu_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_vvvvvxcvwu_required = true;
		}
	}
}

// the vvvvvxd function
function vvvvvxd(add_php_getitems_vvvvvxd)
{
	// set the function logic
	if (add_php_getitems_vvvvvxd == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_vvvvvxdvwv_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_vvvvvxdvwv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_vvvvvxdvwv_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_vvvvvxdvwv_required = true;
		}
	}
}

// the vvvvvxe function
function vvvvvxe(add_php_getitems_after_all_vvvvvxe)
{
	// set the function logic
	if (add_php_getitems_after_all_vvvvvxe == 1)
	{
		jQuery('#jform_php_getitems_after_all').closest('.control-group').show();
		if (jform_vvvvvxevww_required)
		{
			updateFieldRequired('php_getitems_after_all',0);
			jQuery('#jform_php_getitems_after_all').prop('required','required');
			jQuery('#jform_php_getitems_after_all').attr('aria-required',true);
			jQuery('#jform_php_getitems_after_all').addClass('required');
			jform_vvvvvxevww_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems_after_all').closest('.control-group').hide();
		if (!jform_vvvvvxevww_required)
		{
			updateFieldRequired('php_getitems_after_all',1);
			jQuery('#jform_php_getitems_after_all').removeAttr('required');
			jQuery('#jform_php_getitems_after_all').removeAttr('aria-required');
			jQuery('#jform_php_getitems_after_all').removeClass('required');
			jform_vvvvvxevww_required = true;
		}
	}
}

// the vvvvvxf function
function vvvvvxf(add_php_getlistquery_vvvvvxf)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvxf == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvxfvwx_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvxfvwx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvxfvwx_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvxfvwx_required = true;
		}
	}
}

// the vvvvvxg function
function vvvvvxg(add_php_save_vvvvvxg)
{
	// set the function logic
	if (add_php_save_vvvvvxg == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_vvvvvxgvwy_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_vvvvvxgvwy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_vvvvvxgvwy_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_vvvvvxgvwy_required = true;
		}
	}
}

// the vvvvvxh function
function vvvvvxh(add_php_postsavehook_vvvvvxh)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvxh == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_vvvvvxhvwz_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_vvvvvxhvwz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_vvvvvxhvwz_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_vvvvvxhvwz_required = true;
		}
	}
}

// the vvvvvxi function
function vvvvvxi(add_php_allowedit_vvvvvxi)
{
	// set the function logic
	if (add_php_allowedit_vvvvvxi == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_vvvvvxivxa_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_vvvvvxivxa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_vvvvvxivxa_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_vvvvvxivxa_required = true;
		}
	}
}

// the vvvvvxj function
function vvvvvxj(add_php_batchcopy_vvvvvxj)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvxj == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_vvvvvxjvxb_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_vvvvvxjvxb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_vvvvvxjvxb_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_vvvvvxjvxb_required = true;
		}
	}
}

// the vvvvvxk function
function vvvvvxk(add_php_batchmove_vvvvvxk)
{
	// set the function logic
	if (add_php_batchmove_vvvvvxk == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_vvvvvxkvxc_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_vvvvvxkvxc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_vvvvvxkvxc_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_vvvvvxkvxc_required = true;
		}
	}
}

// the vvvvvxl function
function vvvvvxl(add_php_before_publish_vvvvvxl)
{
	// set the function logic
	if (add_php_before_publish_vvvvvxl == 1)
	{
		jQuery('#jform_php_before_publish').closest('.control-group').show();
		if (jform_vvvvvxlvxd_required)
		{
			updateFieldRequired('php_before_publish',0);
			jQuery('#jform_php_before_publish').prop('required','required');
			jQuery('#jform_php_before_publish').attr('aria-required',true);
			jQuery('#jform_php_before_publish').addClass('required');
			jform_vvvvvxlvxd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_publish').closest('.control-group').hide();
		if (!jform_vvvvvxlvxd_required)
		{
			updateFieldRequired('php_before_publish',1);
			jQuery('#jform_php_before_publish').removeAttr('required');
			jQuery('#jform_php_before_publish').removeAttr('aria-required');
			jQuery('#jform_php_before_publish').removeClass('required');
			jform_vvvvvxlvxd_required = true;
		}
	}
}

// the vvvvvxm function
function vvvvvxm(add_php_after_publish_vvvvvxm)
{
	// set the function logic
	if (add_php_after_publish_vvvvvxm == 1)
	{
		jQuery('#jform_php_after_publish').closest('.control-group').show();
		if (jform_vvvvvxmvxe_required)
		{
			updateFieldRequired('php_after_publish',0);
			jQuery('#jform_php_after_publish').prop('required','required');
			jQuery('#jform_php_after_publish').attr('aria-required',true);
			jQuery('#jform_php_after_publish').addClass('required');
			jform_vvvvvxmvxe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_publish').closest('.control-group').hide();
		if (!jform_vvvvvxmvxe_required)
		{
			updateFieldRequired('php_after_publish',1);
			jQuery('#jform_php_after_publish').removeAttr('required');
			jQuery('#jform_php_after_publish').removeAttr('aria-required');
			jQuery('#jform_php_after_publish').removeClass('required');
			jform_vvvvvxmvxe_required = true;
		}
	}
}

// the vvvvvxn function
function vvvvvxn(add_php_before_delete_vvvvvxn)
{
	// set the function logic
	if (add_php_before_delete_vvvvvxn == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_vvvvvxnvxf_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_vvvvvxnvxf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_vvvvvxnvxf_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_vvvvvxnvxf_required = true;
		}
	}
}

// the vvvvvxo function
function vvvvvxo(add_php_after_delete_vvvvvxo)
{
	// set the function logic
	if (add_php_after_delete_vvvvvxo == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_vvvvvxovxg_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_vvvvvxovxg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_vvvvvxovxg_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_vvvvvxovxg_required = true;
		}
	}
}

// the vvvvvxp function
function vvvvvxp(add_php_document_vvvvvxp)
{
	// set the function logic
	if (add_php_document_vvvvvxp == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_vvvvvxpvxh_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_vvvvvxpvxh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_vvvvvxpvxh_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_vvvvvxpvxh_required = true;
		}
	}
}

// the vvvvvxq function
function vvvvvxq(add_sql_vvvvvxq)
{
	// set the function logic
	if (add_sql_vvvvvxq == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_vvvvvxqvxi_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvxqvxi_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_vvvvvxqvxi_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvxqvxi_required = true;
		}
	}
}

// the vvvvvxr function
function vvvvvxr(source_vvvvvxr,add_sql_vvvvvxr)
{
	// set the function logic
	if (source_vvvvvxr == 2 && add_sql_vvvvvxr == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvxrvxj_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvxrvxj_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvxrvxj_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvxrvxj_required = true;
		}
	}
}

// the vvvvvxt function
function vvvvvxt(source_vvvvvxt,add_sql_vvvvvxt)
{
	// set the function logic
	if (source_vvvvvxt == 1 && add_sql_vvvvvxt == 1)
	{
		jQuery('#jform_addtables').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables').closest('.control-group').hide();
	}
}

// the vvvvvxv function
function vvvvvxv(add_custom_import_vvvvvxv)
{
	// set the function logic
	if (add_custom_import_vvvvvxv == 1)
	{
		jQuery('#jform_html_import_view').closest('.control-group').show();
		if (jform_vvvvvxvvxk_required)
		{
			updateFieldRequired('html_import_view',0);
			jQuery('#jform_html_import_view').prop('required','required');
			jQuery('#jform_html_import_view').attr('aria-required',true);
			jQuery('#jform_html_import_view').addClass('required');
			jform_vvvvvxvvxk_required = false;
		}

		jQuery('.note_advanced_import').closest('.control-group').show();
		jQuery('#jform_php_import_display').closest('.control-group').show();
		if (jform_vvvvvxvvxl_required)
		{
			updateFieldRequired('php_import_display',0);
			jQuery('#jform_php_import_display').prop('required','required');
			jQuery('#jform_php_import_display').attr('aria-required',true);
			jQuery('#jform_php_import_display').addClass('required');
			jform_vvvvvxvvxl_required = false;
		}

		jQuery('#jform_php_import').closest('.control-group').show();
		if (jform_vvvvvxvvxm_required)
		{
			updateFieldRequired('php_import',0);
			jQuery('#jform_php_import').prop('required','required');
			jQuery('#jform_php_import').attr('aria-required',true);
			jQuery('#jform_php_import').addClass('required');
			jform_vvvvvxvvxm_required = false;
		}

		jQuery('#jform_php_import_save').closest('.control-group').show();
		if (jform_vvvvvxvvxn_required)
		{
			updateFieldRequired('php_import_save',0);
			jQuery('#jform_php_import_save').prop('required','required');
			jQuery('#jform_php_import_save').attr('aria-required',true);
			jQuery('#jform_php_import_save').addClass('required');
			jform_vvvvvxvvxn_required = false;
		}

		jQuery('#jform_php_import_setdata').closest('.control-group').show();
		if (jform_vvvvvxvvxo_required)
		{
			updateFieldRequired('php_import_setdata',0);
			jQuery('#jform_php_import_setdata').prop('required','required');
			jQuery('#jform_php_import_setdata').attr('aria-required',true);
			jQuery('#jform_php_import_setdata').addClass('required');
			jform_vvvvvxvvxo_required = false;
		}

	}
	else
	{
		jQuery('#jform_html_import_view').closest('.control-group').hide();
		if (!jform_vvvvvxvvxk_required)
		{
			updateFieldRequired('html_import_view',1);
			jQuery('#jform_html_import_view').removeAttr('required');
			jQuery('#jform_html_import_view').removeAttr('aria-required');
			jQuery('#jform_html_import_view').removeClass('required');
			jform_vvvvvxvvxk_required = true;
		}
		jQuery('.note_advanced_import').closest('.control-group').hide();
		jQuery('#jform_php_import_display').closest('.control-group').hide();
		if (!jform_vvvvvxvvxl_required)
		{
			updateFieldRequired('php_import_display',1);
			jQuery('#jform_php_import_display').removeAttr('required');
			jQuery('#jform_php_import_display').removeAttr('aria-required');
			jQuery('#jform_php_import_display').removeClass('required');
			jform_vvvvvxvvxl_required = true;
		}
		jQuery('#jform_php_import').closest('.control-group').hide();
		if (!jform_vvvvvxvvxm_required)
		{
			updateFieldRequired('php_import',1);
			jQuery('#jform_php_import').removeAttr('required');
			jQuery('#jform_php_import').removeAttr('aria-required');
			jQuery('#jform_php_import').removeClass('required');
			jform_vvvvvxvvxm_required = true;
		}
		jQuery('#jform_php_import_save').closest('.control-group').hide();
		if (!jform_vvvvvxvvxn_required)
		{
			updateFieldRequired('php_import_save',1);
			jQuery('#jform_php_import_save').removeAttr('required');
			jQuery('#jform_php_import_save').removeAttr('aria-required');
			jQuery('#jform_php_import_save').removeClass('required');
			jform_vvvvvxvvxn_required = true;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').hide();
		if (!jform_vvvvvxvvxo_required)
		{
			updateFieldRequired('php_import_setdata',1);
			jQuery('#jform_php_import_setdata').removeAttr('required');
			jQuery('#jform_php_import_setdata').removeAttr('aria-required');
			jQuery('#jform_php_import_setdata').removeClass('required');
			jform_vvvvvxvvxo_required = true;
		}
	}
}

// the vvvvvxw function
function vvvvvxw(add_custom_import_vvvvvxw)
{
	// set the function logic
	if (add_custom_import_vvvvvxw == 0)
	{
		jQuery('.note_beginner_import').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_beginner_import').closest('.control-group').hide();
	}
}

// the vvvvvxx function
function vvvvvxx(add_custom_button_vvvvvxx)
{
	// set the function logic
	if (add_custom_button_vvvvvxx == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_vvvvvxxvxp_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_vvvvvxxvxp_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_vvvvvxxvxq_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_vvvvvxxvxq_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_vvvvvxxvxp_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_vvvvvxxvxp_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_vvvvvxxvxq_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_vvvvvxxvxq_required = true;
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

jQuery(document).ready(function()
{    
	var valueSwitch = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	getImportScripts(valueSwitch);
});

function getFieldSelectOptions_server(fieldId){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.fieldSelectOptions&format=json";
	if(token.length > 0 && fieldId > 0){
		var request = 'token='+token+'&id='+fieldId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getFieldSelectOptions(id,fieldKey){
	getFieldSelectOptions_server(id).done(function(result) {
		if(result){
			jQuery('textarea#jform_addconditions_fields_match_options-'+fieldKey).val(result);
		}
		else
		{
			jQuery('textarea#jform_addconditions_fields_match_options-'+fieldKey).val('');
		}
	})
}

function getTableColumns_server(tableName){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.tableColumns&format=json";
	if(token.length > 0 && tableName.length > 0){
		var request = 'token='+token+'&table='+tableName;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getTableColumns(tableName,fieldKey){
	getTableColumns_server(tableName).done(function(result) {
		if(result){
			jQuery('textarea#jform_addtables_fields_sourcemap-'+fieldKey).val(result);
		}
		else
		{
			jQuery('textarea#jform_addtables_fields_sourcemap-'+fieldKey).val('');
		}
	})
}

function getImportScripts_server(typpe){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getImportScripts&format=json";
	if(token.length > 0 && typpe.length > 0){
		var request = 'token='+token+'&type='+typpe;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getImportScripts(id){
	if (1 == id) {
		// get the current values
		var current_import_display = jQuery('textarea#jform_php_import_display').val();
		var current_import = jQuery('textarea#jform_php_import').val();
		var current_setdata = jQuery('textarea#jform_php_import_setdata').val();
		var current_save = jQuery('textarea#jform_php_import_save').val();
		var current_view = jQuery('textarea#jform_html_import_view').val();
		// set the display method script
		if(current_import_display.length == 0){
			getImportScripts_server('display').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_display').val(result);
				}
			});
		}
		// set the import method script
		if(current_import.length == 0){
			getImportScripts_server('import').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import').val(result);
				}
			});
		}
		// set the setData method script
		if(current_setdata.length == 0){
			getImportScripts_server('setdata').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_setdata').val(result);
				}
			});
		}
		// set the save method script
		if(current_save.length == 0){
			getImportScripts_server('save').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_save').val(result);
				}
			});
		}
		// set the view script
		if(current_view.length == 0){
			getImportScripts_server('view').done(function(result) {
				if(result){
					jQuery('textarea#jform_html_import_view').val(result);
				}
			});
		}
	}
} 
