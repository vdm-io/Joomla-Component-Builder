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

	@version		@update number 244 of this MVC
	@build			29th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		admin_view.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvwwvwn_required = false;
jform_vvvvvwxvwo_required = false;
jform_vvvvvwyvwp_required = false;
jform_vvvvvwzvwq_required = false;
jform_vvvvvxavwr_required = false;
jform_vvvvvxbvws_required = false;
jform_vvvvvxcvwt_required = false;
jform_vvvvvxdvwu_required = false;
jform_vvvvvxevwv_required = false;
jform_vvvvvxfvww_required = false;
jform_vvvvvxgvwx_required = false;
jform_vvvvvxhvwy_required = false;
jform_vvvvvxivwz_required = false;
jform_vvvvvxjvxa_required = false;
jform_vvvvvxkvxb_required = false;
jform_vvvvvxlvxc_required = false;
jform_vvvvvxmvxd_required = false;
jform_vvvvvxnvxe_required = false;
jform_vvvvvxovxf_required = false;
jform_vvvvvxpvxg_required = false;
jform_vvvvvxqvxh_required = false;
jform_vvvvvxrvxi_required = false;
jform_vvvvvxsvxj_required = false;
jform_vvvvvxtvxk_required = false;
jform_vvvvvxxvxl_required = false;
jform_vvvvvxxvxm_required = false;
jform_vvvvvxxvxn_required = false;
jform_vvvvvxxvxo_required = false;
jform_vvvvvxxvxp_required = false;
jform_vvvvvxxvxq_required = false;
jform_vvvvvxzvxr_required = false;
jform_vvvvvxzvxs_required = false;
jform_vvvvvxzvxt_required = false;
jform_vvvvvxzvxu_required = false;

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

	var add_php_before_save_vvvvvxh = jQuery("#jform_add_php_before_save input[type='radio']:checked").val();
	vvvvvxh(add_php_before_save_vvvvvxh);

	var add_php_save_vvvvvxi = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvxi(add_php_save_vvvvvxi);

	var add_php_postsavehook_vvvvvxj = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvxj(add_php_postsavehook_vvvvvxj);

	var add_php_allowedit_vvvvvxk = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvxk(add_php_allowedit_vvvvvxk);

	var add_php_batchcopy_vvvvvxl = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvxl(add_php_batchcopy_vvvvvxl);

	var add_php_batchmove_vvvvvxm = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvxm(add_php_batchmove_vvvvvxm);

	var add_php_before_publish_vvvvvxn = jQuery("#jform_add_php_before_publish input[type='radio']:checked").val();
	vvvvvxn(add_php_before_publish_vvvvvxn);

	var add_php_after_publish_vvvvvxo = jQuery("#jform_add_php_after_publish input[type='radio']:checked").val();
	vvvvvxo(add_php_after_publish_vvvvvxo);

	var add_php_before_delete_vvvvvxp = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvxp(add_php_before_delete_vvvvvxp);

	var add_php_after_delete_vvvvvxq = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvxq(add_php_after_delete_vvvvvxq);

	var add_php_document_vvvvvxr = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvxr(add_php_document_vvvvvxr);

	var add_sql_vvvvvxs = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxs(add_sql_vvvvvxs);

	var source_vvvvvxt = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxt = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxt(source_vvvvvxt,add_sql_vvvvvxt);

	var source_vvvvvxv = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxv = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxv(source_vvvvvxv,add_sql_vvvvvxv);

	var add_custom_import_vvvvvxx = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxx(add_custom_import_vvvvvxx);

	var add_custom_import_vvvvvxy = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxy(add_custom_import_vvvvvxy);

	var add_custom_button_vvvvvxz = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvxz(add_custom_button_vvvvvxz);
});

// the vvvvvww function
function vvvvvww(add_css_view_vvvvvww)
{
	// set the function logic
	if (add_css_view_vvvvvww == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvwwvwn_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvwwvwn_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvwwvwn_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvwwvwn_required = true;
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
		if (jform_vvvvvwxvwo_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvwxvwo_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvwxvwo_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvwxvwo_required = true;
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
		if (jform_vvvvvwyvwp_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_vvvvvwyvwp_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_vvvvvwyvwp_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_vvvvvwyvwp_required = true;
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
		if (jform_vvvvvwzvwq_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_vvvvvwzvwq_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_vvvvvwzvwq_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_vvvvvwzvwq_required = true;
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
		if (jform_vvvvvxavwr_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvxavwr_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvxavwr_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvxavwr_required = true;
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
		if (jform_vvvvvxbvws_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvxbvws_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvxbvws_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvxbvws_required = true;
		}
	}
}

// the vvvvvxc function
function vvvvvxc(add_php_ajax_vvvvvxc)
{
	// set the function logic
	if (add_php_ajax_vvvvvxc == 1)
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvxcvwt_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvxcvwt_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvxcvwt_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvxcvwt_required = true;
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
		if (jform_vvvvvxdvwu_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_vvvvvxdvwu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_vvvvvxdvwu_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_vvvvvxdvwu_required = true;
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
		if (jform_vvvvvxevwv_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_vvvvvxevwv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_vvvvvxevwv_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_vvvvvxevwv_required = true;
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
		if (jform_vvvvvxfvww_required)
		{
			updateFieldRequired('php_getitems_after_all',0);
			jQuery('#jform_php_getitems_after_all').prop('required','required');
			jQuery('#jform_php_getitems_after_all').attr('aria-required',true);
			jQuery('#jform_php_getitems_after_all').addClass('required');
			jform_vvvvvxfvww_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems_after_all').closest('.control-group').hide();
		if (!jform_vvvvvxfvww_required)
		{
			updateFieldRequired('php_getitems_after_all',1);
			jQuery('#jform_php_getitems_after_all').removeAttr('required');
			jQuery('#jform_php_getitems_after_all').removeAttr('aria-required');
			jQuery('#jform_php_getitems_after_all').removeClass('required');
			jform_vvvvvxfvww_required = true;
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
		if (jform_vvvvvxgvwx_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvxgvwx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvxgvwx_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvxgvwx_required = true;
		}
	}
}

// the vvvvvxh function
function vvvvvxh(add_php_before_save_vvvvvxh)
{
	// set the function logic
	if (add_php_before_save_vvvvvxh == 1)
	{
		jQuery('#jform_php_before_save').closest('.control-group').show();
		if (jform_vvvvvxhvwy_required)
		{
			updateFieldRequired('php_before_save',0);
			jQuery('#jform_php_before_save').prop('required','required');
			jQuery('#jform_php_before_save').attr('aria-required',true);
			jQuery('#jform_php_before_save').addClass('required');
			jform_vvvvvxhvwy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_save').closest('.control-group').hide();
		if (!jform_vvvvvxhvwy_required)
		{
			updateFieldRequired('php_before_save',1);
			jQuery('#jform_php_before_save').removeAttr('required');
			jQuery('#jform_php_before_save').removeAttr('aria-required');
			jQuery('#jform_php_before_save').removeClass('required');
			jform_vvvvvxhvwy_required = true;
		}
	}
}

// the vvvvvxi function
function vvvvvxi(add_php_save_vvvvvxi)
{
	// set the function logic
	if (add_php_save_vvvvvxi == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_vvvvvxivwz_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_vvvvvxivwz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_vvvvvxivwz_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_vvvvvxivwz_required = true;
		}
	}
}

// the vvvvvxj function
function vvvvvxj(add_php_postsavehook_vvvvvxj)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvxj == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_vvvvvxjvxa_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_vvvvvxjvxa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_vvvvvxjvxa_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_vvvvvxjvxa_required = true;
		}
	}
}

// the vvvvvxk function
function vvvvvxk(add_php_allowedit_vvvvvxk)
{
	// set the function logic
	if (add_php_allowedit_vvvvvxk == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_vvvvvxkvxb_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_vvvvvxkvxb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_vvvvvxkvxb_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_vvvvvxkvxb_required = true;
		}
	}
}

// the vvvvvxl function
function vvvvvxl(add_php_batchcopy_vvvvvxl)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvxl == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_vvvvvxlvxc_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_vvvvvxlvxc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_vvvvvxlvxc_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_vvvvvxlvxc_required = true;
		}
	}
}

// the vvvvvxm function
function vvvvvxm(add_php_batchmove_vvvvvxm)
{
	// set the function logic
	if (add_php_batchmove_vvvvvxm == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_vvvvvxmvxd_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_vvvvvxmvxd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_vvvvvxmvxd_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_vvvvvxmvxd_required = true;
		}
	}
}

// the vvvvvxn function
function vvvvvxn(add_php_before_publish_vvvvvxn)
{
	// set the function logic
	if (add_php_before_publish_vvvvvxn == 1)
	{
		jQuery('#jform_php_before_publish').closest('.control-group').show();
		if (jform_vvvvvxnvxe_required)
		{
			updateFieldRequired('php_before_publish',0);
			jQuery('#jform_php_before_publish').prop('required','required');
			jQuery('#jform_php_before_publish').attr('aria-required',true);
			jQuery('#jform_php_before_publish').addClass('required');
			jform_vvvvvxnvxe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_publish').closest('.control-group').hide();
		if (!jform_vvvvvxnvxe_required)
		{
			updateFieldRequired('php_before_publish',1);
			jQuery('#jform_php_before_publish').removeAttr('required');
			jQuery('#jform_php_before_publish').removeAttr('aria-required');
			jQuery('#jform_php_before_publish').removeClass('required');
			jform_vvvvvxnvxe_required = true;
		}
	}
}

// the vvvvvxo function
function vvvvvxo(add_php_after_publish_vvvvvxo)
{
	// set the function logic
	if (add_php_after_publish_vvvvvxo == 1)
	{
		jQuery('#jform_php_after_publish').closest('.control-group').show();
		if (jform_vvvvvxovxf_required)
		{
			updateFieldRequired('php_after_publish',0);
			jQuery('#jform_php_after_publish').prop('required','required');
			jQuery('#jform_php_after_publish').attr('aria-required',true);
			jQuery('#jform_php_after_publish').addClass('required');
			jform_vvvvvxovxf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_publish').closest('.control-group').hide();
		if (!jform_vvvvvxovxf_required)
		{
			updateFieldRequired('php_after_publish',1);
			jQuery('#jform_php_after_publish').removeAttr('required');
			jQuery('#jform_php_after_publish').removeAttr('aria-required');
			jQuery('#jform_php_after_publish').removeClass('required');
			jform_vvvvvxovxf_required = true;
		}
	}
}

// the vvvvvxp function
function vvvvvxp(add_php_before_delete_vvvvvxp)
{
	// set the function logic
	if (add_php_before_delete_vvvvvxp == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_vvvvvxpvxg_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_vvvvvxpvxg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_vvvvvxpvxg_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_vvvvvxpvxg_required = true;
		}
	}
}

// the vvvvvxq function
function vvvvvxq(add_php_after_delete_vvvvvxq)
{
	// set the function logic
	if (add_php_after_delete_vvvvvxq == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_vvvvvxqvxh_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_vvvvvxqvxh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_vvvvvxqvxh_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_vvvvvxqvxh_required = true;
		}
	}
}

// the vvvvvxr function
function vvvvvxr(add_php_document_vvvvvxr)
{
	// set the function logic
	if (add_php_document_vvvvvxr == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_vvvvvxrvxi_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_vvvvvxrvxi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_vvvvvxrvxi_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_vvvvvxrvxi_required = true;
		}
	}
}

// the vvvvvxs function
function vvvvvxs(add_sql_vvvvvxs)
{
	// set the function logic
	if (add_sql_vvvvvxs == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_vvvvvxsvxj_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvxsvxj_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_vvvvvxsvxj_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvxsvxj_required = true;
		}
	}
}

// the vvvvvxt function
function vvvvvxt(source_vvvvvxt,add_sql_vvvvvxt)
{
	// set the function logic
	if (source_vvvvvxt == 2 && add_sql_vvvvvxt == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvxtvxk_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvxtvxk_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvxtvxk_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvxtvxk_required = true;
		}
	}
}

// the vvvvvxv function
function vvvvvxv(source_vvvvvxv,add_sql_vvvvvxv)
{
	// set the function logic
	if (source_vvvvvxv == 1 && add_sql_vvvvvxv == 1)
	{
		jQuery('#jform_addtables-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxx function
function vvvvvxx(add_custom_import_vvvvvxx)
{
	// set the function logic
	if (add_custom_import_vvvvvxx == 1)
	{
		jQuery('#jform_html_import_view').closest('.control-group').show();
		if (jform_vvvvvxxvxl_required)
		{
			updateFieldRequired('html_import_view',0);
			jQuery('#jform_html_import_view').prop('required','required');
			jQuery('#jform_html_import_view').attr('aria-required',true);
			jQuery('#jform_html_import_view').addClass('required');
			jform_vvvvvxxvxl_required = false;
		}

		jQuery('.note_advanced_import').closest('.control-group').show();
		jQuery('#jform_php_import_display').closest('.control-group').show();
		if (jform_vvvvvxxvxm_required)
		{
			updateFieldRequired('php_import_display',0);
			jQuery('#jform_php_import_display').prop('required','required');
			jQuery('#jform_php_import_display').attr('aria-required',true);
			jQuery('#jform_php_import_display').addClass('required');
			jform_vvvvvxxvxm_required = false;
		}

		jQuery('#jform_php_import_ext').closest('.control-group').show();
		if (jform_vvvvvxxvxn_required)
		{
			updateFieldRequired('php_import_ext',0);
			jQuery('#jform_php_import_ext').prop('required','required');
			jQuery('#jform_php_import_ext').attr('aria-required',true);
			jQuery('#jform_php_import_ext').addClass('required');
			jform_vvvvvxxvxn_required = false;
		}

		jQuery('#jform_php_import').closest('.control-group').show();
		if (jform_vvvvvxxvxo_required)
		{
			updateFieldRequired('php_import',0);
			jQuery('#jform_php_import').prop('required','required');
			jQuery('#jform_php_import').attr('aria-required',true);
			jQuery('#jform_php_import').addClass('required');
			jform_vvvvvxxvxo_required = false;
		}

		jQuery('#jform_php_import_save').closest('.control-group').show();
		if (jform_vvvvvxxvxp_required)
		{
			updateFieldRequired('php_import_save',0);
			jQuery('#jform_php_import_save').prop('required','required');
			jQuery('#jform_php_import_save').attr('aria-required',true);
			jQuery('#jform_php_import_save').addClass('required');
			jform_vvvvvxxvxp_required = false;
		}

		jQuery('#jform_php_import_setdata').closest('.control-group').show();
		if (jform_vvvvvxxvxq_required)
		{
			updateFieldRequired('php_import_setdata',0);
			jQuery('#jform_php_import_setdata').prop('required','required');
			jQuery('#jform_php_import_setdata').attr('aria-required',true);
			jQuery('#jform_php_import_setdata').addClass('required');
			jform_vvvvvxxvxq_required = false;
		}

	}
	else
	{
		jQuery('#jform_html_import_view').closest('.control-group').hide();
		if (!jform_vvvvvxxvxl_required)
		{
			updateFieldRequired('html_import_view',1);
			jQuery('#jform_html_import_view').removeAttr('required');
			jQuery('#jform_html_import_view').removeAttr('aria-required');
			jQuery('#jform_html_import_view').removeClass('required');
			jform_vvvvvxxvxl_required = true;
		}
		jQuery('.note_advanced_import').closest('.control-group').hide();
		jQuery('#jform_php_import_display').closest('.control-group').hide();
		if (!jform_vvvvvxxvxm_required)
		{
			updateFieldRequired('php_import_display',1);
			jQuery('#jform_php_import_display').removeAttr('required');
			jQuery('#jform_php_import_display').removeAttr('aria-required');
			jQuery('#jform_php_import_display').removeClass('required');
			jform_vvvvvxxvxm_required = true;
		}
		jQuery('#jform_php_import_ext').closest('.control-group').hide();
		if (!jform_vvvvvxxvxn_required)
		{
			updateFieldRequired('php_import_ext',1);
			jQuery('#jform_php_import_ext').removeAttr('required');
			jQuery('#jform_php_import_ext').removeAttr('aria-required');
			jQuery('#jform_php_import_ext').removeClass('required');
			jform_vvvvvxxvxn_required = true;
		}
		jQuery('#jform_php_import').closest('.control-group').hide();
		if (!jform_vvvvvxxvxo_required)
		{
			updateFieldRequired('php_import',1);
			jQuery('#jform_php_import').removeAttr('required');
			jQuery('#jform_php_import').removeAttr('aria-required');
			jQuery('#jform_php_import').removeClass('required');
			jform_vvvvvxxvxo_required = true;
		}
		jQuery('#jform_php_import_save').closest('.control-group').hide();
		if (!jform_vvvvvxxvxp_required)
		{
			updateFieldRequired('php_import_save',1);
			jQuery('#jform_php_import_save').removeAttr('required');
			jQuery('#jform_php_import_save').removeAttr('aria-required');
			jQuery('#jform_php_import_save').removeClass('required');
			jform_vvvvvxxvxp_required = true;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').hide();
		if (!jform_vvvvvxxvxq_required)
		{
			updateFieldRequired('php_import_setdata',1);
			jQuery('#jform_php_import_setdata').removeAttr('required');
			jQuery('#jform_php_import_setdata').removeAttr('aria-required');
			jQuery('#jform_php_import_setdata').removeClass('required');
			jform_vvvvvxxvxq_required = true;
		}
	}
}

// the vvvvvxy function
function vvvvvxy(add_custom_import_vvvvvxy)
{
	// set the function logic
	if (add_custom_import_vvvvvxy == 0)
	{
		jQuery('.note_beginner_import').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_beginner_import').closest('.control-group').hide();
	}
}

// the vvvvvxz function
function vvvvvxz(add_custom_button_vvvvvxz)
{
	// set the function logic
	if (add_custom_button_vvvvvxz == 1)
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_vvvvvxzvxr_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_vvvvvxzvxr_required = false;
		}

		jQuery('#jform_php_controller_list').closest('.control-group').show();
		if (jform_vvvvvxzvxs_required)
		{
			updateFieldRequired('php_controller_list',0);
			jQuery('#jform_php_controller_list').prop('required','required');
			jQuery('#jform_php_controller_list').attr('aria-required',true);
			jQuery('#jform_php_controller_list').addClass('required');
			jform_vvvvvxzvxs_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_vvvvvxzvxt_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_vvvvvxzvxt_required = false;
		}

		jQuery('#jform_php_model_list').closest('.control-group').show();
		if (jform_vvvvvxzvxu_required)
		{
			updateFieldRequired('php_model_list',0);
			jQuery('#jform_php_model_list').prop('required','required');
			jQuery('#jform_php_model_list').attr('aria-required',true);
			jQuery('#jform_php_model_list').addClass('required');
			jform_vvvvvxzvxu_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_vvvvvxzvxr_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_vvvvvxzvxr_required = true;
		}
		jQuery('#jform_php_controller_list').closest('.control-group').hide();
		if (!jform_vvvvvxzvxs_required)
		{
			updateFieldRequired('php_controller_list',1);
			jQuery('#jform_php_controller_list').removeAttr('required');
			jQuery('#jform_php_controller_list').removeAttr('aria-required');
			jQuery('#jform_php_controller_list').removeClass('required');
			jform_vvvvvxzvxs_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_vvvvvxzvxt_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_vvvvvxzvxt_required = true;
		}
		jQuery('#jform_php_model_list').closest('.control-group').hide();
		if (!jform_vvvvvxzvxu_required)
		{
			updateFieldRequired('php_model_list',1);
			jQuery('#jform_php_model_list').removeAttr('required');
			jQuery('#jform_php_model_list').removeAttr('aria-required');
			jQuery('#jform_php_model_list').removeClass('required');
			jform_vvvvvxzvxu_required = true;
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
	// set button
	addButtonID('admin_fields','create_edit_buttons', 1); // <-- first
	var valueSwitch = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	getImportScripts(valueSwitch);
	// now load the fields
	getAjaxDisplay('admin_fields');
	getAjaxDisplay('admin_fields_conditions');
	// set button
	addButtonID('admin_fields_conditions','create_edit_buttons', 1); // <-- second
	// set button to create more fields
	addButton('field','create_edit_buttons'); // <-- third
});

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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&vdm="+vastDevMod;
	if(token.length > 0 && type.length > 0){
		var request = 'token='+token+'&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function addData(result,where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}
			
function addButtonID_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButtonID&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0 && size > 0){
		var request = 'token='+token+'&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
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
			
function addButton_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = 'token='+token+'&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}
function addButton(type,where){
	addButton_server(type).done(function(result) {
		if(result){
			addData(result,'#jform_'+where);
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
