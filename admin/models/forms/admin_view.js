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

	@version		@update number 108 of this MVC
	@build			24th March, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		admin_view.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvwwvwp_required = false;
jform_vvvvvwxvwq_required = false;
jform_vvvvvwyvwr_required = false;
jform_vvvvvwzvws_required = false;
jform_vvvvvxavwt_required = false;
jform_vvvvvxbvwu_required = false;
jform_vvvvvxcvwv_required = false;
jform_vvvvvxdvww_required = false;
jform_vvvvvxevwx_required = false;
jform_vvvvvxfvwy_required = false;
jform_vvvvvxgvwz_required = false;
jform_vvvvvxhvxa_required = false;
jform_vvvvvxivxb_required = false;
jform_vvvvvxjvxc_required = false;
jform_vvvvvxkvxd_required = false;
jform_vvvvvxlvxe_required = false;
jform_vvvvvxmvxf_required = false;
jform_vvvvvxnvxg_required = false;
jform_vvvvvxovxh_required = false;
jform_vvvvvxpvxi_required = false;
jform_vvvvvxqvxj_required = false;
jform_vvvvvxrvxk_required = false;
jform_vvvvvxsvxl_required = false;
jform_vvvvvxwvxm_required = false;
jform_vvvvvxwvxn_required = false;
jform_vvvvvxwvxo_required = false;
jform_vvvvvxwvxp_required = false;
jform_vvvvvxwvxq_required = false;
jform_vvvvvxwvxr_required = false;
jform_vvvvvxyvxs_required = false;
jform_vvvvvxyvxt_required = false;
jform_vvvvvxyvxu_required = false;
jform_vvvvvxyvxv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vvvvvww = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvww(add_css_view_vvvvvww);

	var add_css_views_vvvvvwx = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvwx(add_css_views_vvvvvwx);

	var add_javascript_view_file_vvvvvwy = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	vvvvvwy(add_javascript_view_file_vvvvvwy);

	var add_javascript_views_file_vvvvvwz = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	vvvvvwz(add_javascript_views_file_vvvvvwz);

	var add_javascript_view_footer_vvvvvxa = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvxa(add_javascript_view_footer_vvvvvxa);

	var add_javascript_views_footer_vvvvvxb = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvxb(add_javascript_views_footer_vvvvvxb);

	var add_php_ajax_vvvvvxc = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvxc(add_php_ajax_vvvvvxc);

	var add_php_getitem_vvvvvxd = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	vvvvvxd(add_php_getitem_vvvvvxd);

	var add_php_getitems_vvvvvxe = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	vvvvvxe(add_php_getitems_vvvvvxe);

	var add_php_getitems_after_all_vvvvvxf = jQuery("#jform_add_php_getitems_after_all input[type='radio']:checked").val();
	vvvvvxf(add_php_getitems_after_all_vvvvvxf);

	var add_php_getlistquery_vvvvvxg = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	vvvvvxg(add_php_getlistquery_vvvvvxg);

	var add_php_save_vvvvvxh = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvxh(add_php_save_vvvvvxh);

	var add_php_postsavehook_vvvvvxi = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvxi(add_php_postsavehook_vvvvvxi);

	var add_php_allowedit_vvvvvxj = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvxj(add_php_allowedit_vvvvvxj);

	var add_php_batchcopy_vvvvvxk = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvxk(add_php_batchcopy_vvvvvxk);

	var add_php_batchmove_vvvvvxl = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvxl(add_php_batchmove_vvvvvxl);

	var add_php_before_publish_vvvvvxm = jQuery("#jform_add_php_before_publish input[type='radio']:checked").val();
	vvvvvxm(add_php_before_publish_vvvvvxm);

	var add_php_after_publish_vvvvvxn = jQuery("#jform_add_php_after_publish input[type='radio']:checked").val();
	vvvvvxn(add_php_after_publish_vvvvvxn);

	var add_php_before_delete_vvvvvxo = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvxo(add_php_before_delete_vvvvvxo);

	var add_php_after_delete_vvvvvxp = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvxp(add_php_after_delete_vvvvvxp);

	var add_php_document_vvvvvxq = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvxq(add_php_document_vvvvvxq);

	var add_sql_vvvvvxr = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxr(add_sql_vvvvvxr);

	var source_vvvvvxs = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxs = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxs(source_vvvvvxs,add_sql_vvvvvxs);

	var source_vvvvvxu = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxu = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxu(source_vvvvvxu,add_sql_vvvvvxu);

	var add_custom_import_vvvvvxw = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxw(add_custom_import_vvvvvxw);

	var add_custom_import_vvvvvxx = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxx(add_custom_import_vvvvvxx);

	var add_custom_button_vvvvvxy = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvxy(add_custom_button_vvvvvxy);
});

// the vvvvvww function
function vvvvvww(add_css_view_vvvvvww)
{
	// set the function logic
	if (add_css_view_vvvvvww == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvwwvwp_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvwwvwp_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvwwvwp_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvwwvwp_required = true;
		}
	}
}

// the vvvvvwx function
function vvvvvwx(add_css_views_vvvvvwx)
{
	// set the function logic
	if (add_css_views_vvvvvwx == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvwxvwq_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvwxvwq_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvwxvwq_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvwxvwq_required = true;
		}
	}
}

// the vvvvvwy function
function vvvvvwy(add_javascript_view_file_vvvvvwy)
{
	// set the function logic
	if (add_javascript_view_file_vvvvvwy == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_vvvvvwyvwr_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_vvvvvwyvwr_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_vvvvvwyvwr_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_vvvvvwyvwr_required = true;
		}
	}
}

// the vvvvvwz function
function vvvvvwz(add_javascript_views_file_vvvvvwz)
{
	// set the function logic
	if (add_javascript_views_file_vvvvvwz == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_vvvvvwzvws_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_vvvvvwzvws_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_vvvvvwzvws_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_vvvvvwzvws_required = true;
		}
	}
}

// the vvvvvxa function
function vvvvvxa(add_javascript_view_footer_vvvvvxa)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvxa == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvxavwt_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvxavwt_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvxavwt_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvxavwt_required = true;
		}
	}
}

// the vvvvvxb function
function vvvvvxb(add_javascript_views_footer_vvvvvxb)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvxb == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvxbvwu_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvxbvwu_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvxbvwu_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvxbvwu_required = true;
		}
	}
}

// the vvvvvxc function
function vvvvvxc(add_php_ajax_vvvvvxc)
{
	// set the function logic
	if (add_php_ajax_vvvvvxc == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvxcvwv_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvxcvwv_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvxcvwv_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvxcvwv_required = true;
		}
	}
}

// the vvvvvxd function
function vvvvvxd(add_php_getitem_vvvvvxd)
{
	// set the function logic
	if (add_php_getitem_vvvvvxd == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_vvvvvxdvww_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_vvvvvxdvww_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_vvvvvxdvww_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_vvvvvxdvww_required = true;
		}
	}
}

// the vvvvvxe function
function vvvvvxe(add_php_getitems_vvvvvxe)
{
	// set the function logic
	if (add_php_getitems_vvvvvxe == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_vvvvvxevwx_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_vvvvvxevwx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_vvvvvxevwx_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_vvvvvxevwx_required = true;
		}
	}
}

// the vvvvvxf function
function vvvvvxf(add_php_getitems_after_all_vvvvvxf)
{
	// set the function logic
	if (add_php_getitems_after_all_vvvvvxf == 1)
	{
		jQuery('#jform_php_getitems_after_all').closest('.control-group').show();
		if (jform_vvvvvxfvwy_required)
		{
			updateFieldRequired('php_getitems_after_all',0);
			jQuery('#jform_php_getitems_after_all').prop('required','required');
			jQuery('#jform_php_getitems_after_all').attr('aria-required',true);
			jQuery('#jform_php_getitems_after_all').addClass('required');
			jform_vvvvvxfvwy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems_after_all').closest('.control-group').hide();
		if (!jform_vvvvvxfvwy_required)
		{
			updateFieldRequired('php_getitems_after_all',1);
			jQuery('#jform_php_getitems_after_all').removeAttr('required');
			jQuery('#jform_php_getitems_after_all').removeAttr('aria-required');
			jQuery('#jform_php_getitems_after_all').removeClass('required');
			jform_vvvvvxfvwy_required = true;
		}
	}
}

// the vvvvvxg function
function vvvvvxg(add_php_getlistquery_vvvvvxg)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvxg == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvxgvwz_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvxgvwz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvxgvwz_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvxgvwz_required = true;
		}
	}
}

// the vvvvvxh function
function vvvvvxh(add_php_save_vvvvvxh)
{
	// set the function logic
	if (add_php_save_vvvvvxh == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_vvvvvxhvxa_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_vvvvvxhvxa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_vvvvvxhvxa_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_vvvvvxhvxa_required = true;
		}
	}
}

// the vvvvvxi function
function vvvvvxi(add_php_postsavehook_vvvvvxi)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvxi == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_vvvvvxivxb_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_vvvvvxivxb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_vvvvvxivxb_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_vvvvvxivxb_required = true;
		}
	}
}

// the vvvvvxj function
function vvvvvxj(add_php_allowedit_vvvvvxj)
{
	// set the function logic
	if (add_php_allowedit_vvvvvxj == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_vvvvvxjvxc_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_vvvvvxjvxc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_vvvvvxjvxc_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_vvvvvxjvxc_required = true;
		}
	}
}

// the vvvvvxk function
function vvvvvxk(add_php_batchcopy_vvvvvxk)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvxk == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_vvvvvxkvxd_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_vvvvvxkvxd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_vvvvvxkvxd_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_vvvvvxkvxd_required = true;
		}
	}
}

// the vvvvvxl function
function vvvvvxl(add_php_batchmove_vvvvvxl)
{
	// set the function logic
	if (add_php_batchmove_vvvvvxl == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_vvvvvxlvxe_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_vvvvvxlvxe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_vvvvvxlvxe_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_vvvvvxlvxe_required = true;
		}
	}
}

// the vvvvvxm function
function vvvvvxm(add_php_before_publish_vvvvvxm)
{
	// set the function logic
	if (add_php_before_publish_vvvvvxm == 1)
	{
		jQuery('#jform_php_before_publish').closest('.control-group').show();
		if (jform_vvvvvxmvxf_required)
		{
			updateFieldRequired('php_before_publish',0);
			jQuery('#jform_php_before_publish').prop('required','required');
			jQuery('#jform_php_before_publish').attr('aria-required',true);
			jQuery('#jform_php_before_publish').addClass('required');
			jform_vvvvvxmvxf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_publish').closest('.control-group').hide();
		if (!jform_vvvvvxmvxf_required)
		{
			updateFieldRequired('php_before_publish',1);
			jQuery('#jform_php_before_publish').removeAttr('required');
			jQuery('#jform_php_before_publish').removeAttr('aria-required');
			jQuery('#jform_php_before_publish').removeClass('required');
			jform_vvvvvxmvxf_required = true;
		}
	}
}

// the vvvvvxn function
function vvvvvxn(add_php_after_publish_vvvvvxn)
{
	// set the function logic
	if (add_php_after_publish_vvvvvxn == 1)
	{
		jQuery('#jform_php_after_publish').closest('.control-group').show();
		if (jform_vvvvvxnvxg_required)
		{
			updateFieldRequired('php_after_publish',0);
			jQuery('#jform_php_after_publish').prop('required','required');
			jQuery('#jform_php_after_publish').attr('aria-required',true);
			jQuery('#jform_php_after_publish').addClass('required');
			jform_vvvvvxnvxg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_publish').closest('.control-group').hide();
		if (!jform_vvvvvxnvxg_required)
		{
			updateFieldRequired('php_after_publish',1);
			jQuery('#jform_php_after_publish').removeAttr('required');
			jQuery('#jform_php_after_publish').removeAttr('aria-required');
			jQuery('#jform_php_after_publish').removeClass('required');
			jform_vvvvvxnvxg_required = true;
		}
	}
}

// the vvvvvxo function
function vvvvvxo(add_php_before_delete_vvvvvxo)
{
	// set the function logic
	if (add_php_before_delete_vvvvvxo == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_vvvvvxovxh_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_vvvvvxovxh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_vvvvvxovxh_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_vvvvvxovxh_required = true;
		}
	}
}

// the vvvvvxp function
function vvvvvxp(add_php_after_delete_vvvvvxp)
{
	// set the function logic
	if (add_php_after_delete_vvvvvxp == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_vvvvvxpvxi_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_vvvvvxpvxi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_vvvvvxpvxi_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_vvvvvxpvxi_required = true;
		}
	}
}

// the vvvvvxq function
function vvvvvxq(add_php_document_vvvvvxq)
{
	// set the function logic
	if (add_php_document_vvvvvxq == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_vvvvvxqvxj_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_vvvvvxqvxj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_vvvvvxqvxj_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_vvvvvxqvxj_required = true;
		}
	}
}

// the vvvvvxr function
function vvvvvxr(add_sql_vvvvvxr)
{
	// set the function logic
	if (add_sql_vvvvvxr == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_vvvvvxrvxk_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvxrvxk_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_vvvvvxrvxk_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvxrvxk_required = true;
		}
	}
}

// the vvvvvxs function
function vvvvvxs(source_vvvvvxs,add_sql_vvvvvxs)
{
	// set the function logic
	if (source_vvvvvxs == 2 && add_sql_vvvvvxs == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvxsvxl_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvxsvxl_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvxsvxl_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvxsvxl_required = true;
		}
	}
}

// the vvvvvxu function
function vvvvvxu(source_vvvvvxu,add_sql_vvvvvxu)
{
	// set the function logic
	if (source_vvvvvxu == 1 && add_sql_vvvvvxu == 1)
	{
		jQuery('#jform_addtables').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables').closest('.control-group').hide();
	}
}

// the vvvvvxw function
function vvvvvxw(add_custom_import_vvvvvxw)
{
	// set the function logic
	if (add_custom_import_vvvvvxw == 1)
	{
		jQuery('#jform_html_import_view').closest('.control-group').show();
		if (jform_vvvvvxwvxm_required)
		{
			updateFieldRequired('html_import_view',0);
			jQuery('#jform_html_import_view').prop('required','required');
			jQuery('#jform_html_import_view').attr('aria-required',true);
			jQuery('#jform_html_import_view').addClass('required');
			jform_vvvvvxwvxm_required = false;
		}

		jQuery('.note_advanced_import').closest('.control-group').show();
		jQuery('#jform_php_import_display').closest('.control-group').show();
		if (jform_vvvvvxwvxn_required)
		{
			updateFieldRequired('php_import_display',0);
			jQuery('#jform_php_import_display').prop('required','required');
			jQuery('#jform_php_import_display').attr('aria-required',true);
			jQuery('#jform_php_import_display').addClass('required');
			jform_vvvvvxwvxn_required = false;
		}

		jQuery('#jform_php_import_ext').closest('.control-group').show();
		if (jform_vvvvvxwvxo_required)
		{
			updateFieldRequired('php_import_ext',0);
			jQuery('#jform_php_import_ext').prop('required','required');
			jQuery('#jform_php_import_ext').attr('aria-required',true);
			jQuery('#jform_php_import_ext').addClass('required');
			jform_vvvvvxwvxo_required = false;
		}

		jQuery('#jform_php_import').closest('.control-group').show();
		if (jform_vvvvvxwvxp_required)
		{
			updateFieldRequired('php_import',0);
			jQuery('#jform_php_import').prop('required','required');
			jQuery('#jform_php_import').attr('aria-required',true);
			jQuery('#jform_php_import').addClass('required');
			jform_vvvvvxwvxp_required = false;
		}

		jQuery('#jform_php_import_save').closest('.control-group').show();
		if (jform_vvvvvxwvxq_required)
		{
			updateFieldRequired('php_import_save',0);
			jQuery('#jform_php_import_save').prop('required','required');
			jQuery('#jform_php_import_save').attr('aria-required',true);
			jQuery('#jform_php_import_save').addClass('required');
			jform_vvvvvxwvxq_required = false;
		}

		jQuery('#jform_php_import_setdata').closest('.control-group').show();
		if (jform_vvvvvxwvxr_required)
		{
			updateFieldRequired('php_import_setdata',0);
			jQuery('#jform_php_import_setdata').prop('required','required');
			jQuery('#jform_php_import_setdata').attr('aria-required',true);
			jQuery('#jform_php_import_setdata').addClass('required');
			jform_vvvvvxwvxr_required = false;
		}

	}
	else
	{
		jQuery('#jform_html_import_view').closest('.control-group').hide();
		if (!jform_vvvvvxwvxm_required)
		{
			updateFieldRequired('html_import_view',1);
			jQuery('#jform_html_import_view').removeAttr('required');
			jQuery('#jform_html_import_view').removeAttr('aria-required');
			jQuery('#jform_html_import_view').removeClass('required');
			jform_vvvvvxwvxm_required = true;
		}
		jQuery('.note_advanced_import').closest('.control-group').hide();
		jQuery('#jform_php_import_display').closest('.control-group').hide();
		if (!jform_vvvvvxwvxn_required)
		{
			updateFieldRequired('php_import_display',1);
			jQuery('#jform_php_import_display').removeAttr('required');
			jQuery('#jform_php_import_display').removeAttr('aria-required');
			jQuery('#jform_php_import_display').removeClass('required');
			jform_vvvvvxwvxn_required = true;
		}
		jQuery('#jform_php_import_ext').closest('.control-group').hide();
		if (!jform_vvvvvxwvxo_required)
		{
			updateFieldRequired('php_import_ext',1);
			jQuery('#jform_php_import_ext').removeAttr('required');
			jQuery('#jform_php_import_ext').removeAttr('aria-required');
			jQuery('#jform_php_import_ext').removeClass('required');
			jform_vvvvvxwvxo_required = true;
		}
		jQuery('#jform_php_import').closest('.control-group').hide();
		if (!jform_vvvvvxwvxp_required)
		{
			updateFieldRequired('php_import',1);
			jQuery('#jform_php_import').removeAttr('required');
			jQuery('#jform_php_import').removeAttr('aria-required');
			jQuery('#jform_php_import').removeClass('required');
			jform_vvvvvxwvxp_required = true;
		}
		jQuery('#jform_php_import_save').closest('.control-group').hide();
		if (!jform_vvvvvxwvxq_required)
		{
			updateFieldRequired('php_import_save',1);
			jQuery('#jform_php_import_save').removeAttr('required');
			jQuery('#jform_php_import_save').removeAttr('aria-required');
			jQuery('#jform_php_import_save').removeClass('required');
			jform_vvvvvxwvxq_required = true;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').hide();
		if (!jform_vvvvvxwvxr_required)
		{
			updateFieldRequired('php_import_setdata',1);
			jQuery('#jform_php_import_setdata').removeAttr('required');
			jQuery('#jform_php_import_setdata').removeAttr('aria-required');
			jQuery('#jform_php_import_setdata').removeClass('required');
			jform_vvvvvxwvxr_required = true;
		}
	}
}

// the vvvvvxx function
function vvvvvxx(add_custom_import_vvvvvxx)
{
	// set the function logic
	if (add_custom_import_vvvvvxx == 0)
	{
		jQuery('.note_beginner_import').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_beginner_import').closest('.control-group').hide();
	}
}

// the vvvvvxy function
function vvvvvxy(add_custom_button_vvvvvxy)
{
	// set the function logic
	if (add_custom_button_vvvvvxy == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_vvvvvxyvxs_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_vvvvvxyvxs_required = false;
		}

		jQuery('#jform_php_controller_list').closest('.control-group').show();
		if (jform_vvvvvxyvxt_required)
		{
			updateFieldRequired('php_controller_list',0);
			jQuery('#jform_php_controller_list').prop('required','required');
			jQuery('#jform_php_controller_list').attr('aria-required',true);
			jQuery('#jform_php_controller_list').addClass('required');
			jform_vvvvvxyvxt_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_vvvvvxyvxu_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_vvvvvxyvxu_required = false;
		}

		jQuery('#jform_php_model_list').closest('.control-group').show();
		if (jform_vvvvvxyvxv_required)
		{
			updateFieldRequired('php_model_list',0);
			jQuery('#jform_php_model_list').prop('required','required');
			jQuery('#jform_php_model_list').attr('aria-required',true);
			jQuery('#jform_php_model_list').addClass('required');
			jform_vvvvvxyvxv_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_vvvvvxyvxs_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_vvvvvxyvxs_required = true;
		}
		jQuery('#jform_php_controller_list').closest('.control-group').hide();
		if (!jform_vvvvvxyvxt_required)
		{
			updateFieldRequired('php_controller_list',1);
			jQuery('#jform_php_controller_list').removeAttr('required');
			jQuery('#jform_php_controller_list').removeAttr('aria-required');
			jQuery('#jform_php_controller_list').removeClass('required');
			jform_vvvvvxyvxt_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_vvvvvxyvxu_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_vvvvvxyvxu_required = true;
		}
		jQuery('#jform_php_model_list').closest('.control-group').hide();
		if (!jform_vvvvvxyvxv_required)
		{
			updateFieldRequired('php_model_list',1);
			jQuery('#jform_php_model_list').removeAttr('required');
			jQuery('#jform_php_model_list').removeAttr('aria-required');
			jQuery('#jform_php_model_list').removeClass('required');
			jform_vvvvvxyvxv_required = true;
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
		var current_ext = jQuery('textarea#jform_php_import_ext').val();
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
		// set the import ext script
		if(current_ext.length == 0){
			getImportScripts_server('ext').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_import_ext').val(result);
				}
			});
		}
	}
} 
