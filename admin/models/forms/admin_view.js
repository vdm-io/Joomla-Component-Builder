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

	@version		2.2.0
	@build			31st October, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		admin_view.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvwnvwl_required = false;
jform_vvvvvwovwm_required = false;
jform_vvvvvwpvwn_required = false;
jform_vvvvvwqvwo_required = false;
jform_vvvvvwrvwp_required = false;
jform_vvvvvwsvwq_required = false;
jform_vvvvvwtvwr_required = false;
jform_vvvvvwuvws_required = false;
jform_vvvvvwvvwt_required = false;
jform_vvvvvwwvwu_required = false;
jform_vvvvvwxvwv_required = false;
jform_vvvvvwyvww_required = false;
jform_vvvvvwzvwx_required = false;
jform_vvvvvxavwy_required = false;
jform_vvvvvxbvwz_required = false;
jform_vvvvvxcvxa_required = false;
jform_vvvvvxdvxb_required = false;
jform_vvvvvxevxc_required = false;
jform_vvvvvxfvxd_required = false;
jform_vvvvvxgvxe_required = false;
jform_vvvvvxhvxf_required = false;
jform_vvvvvxivxg_required = false;
jform_vvvvvxjvxh_required = false;
jform_vvvvvxnvxi_required = false;
jform_vvvvvxnvxj_required = false;
jform_vvvvvxnvxk_required = false;
jform_vvvvvxnvxl_required = false;
jform_vvvvvxnvxm_required = false;
jform_vvvvvxpvxn_required = false;
jform_vvvvvxpvxo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vvvvvwn = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvwn(add_css_view_vvvvvwn);

	var add_css_views_vvvvvwo = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvwo(add_css_views_vvvvvwo);

	var add_javascript_view_file_vvvvvwp = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	vvvvvwp(add_javascript_view_file_vvvvvwp);

	var add_javascript_views_file_vvvvvwq = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	vvvvvwq(add_javascript_views_file_vvvvvwq);

	var add_javascript_view_footer_vvvvvwr = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvwr(add_javascript_view_footer_vvvvvwr);

	var add_javascript_views_footer_vvvvvws = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvws(add_javascript_views_footer_vvvvvws);

	var add_php_ajax_vvvvvwt = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvwt(add_php_ajax_vvvvvwt);

	var add_php_getitem_vvvvvwu = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	vvvvvwu(add_php_getitem_vvvvvwu);

	var add_php_getitems_vvvvvwv = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	vvvvvwv(add_php_getitems_vvvvvwv);

	var add_php_getitems_after_all_vvvvvww = jQuery("#jform_add_php_getitems_after_all input[type='radio']:checked").val();
	vvvvvww(add_php_getitems_after_all_vvvvvww);

	var add_php_getlistquery_vvvvvwx = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	vvvvvwx(add_php_getlistquery_vvvvvwx);

	var add_php_save_vvvvvwy = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvwy(add_php_save_vvvvvwy);

	var add_php_postsavehook_vvvvvwz = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvwz(add_php_postsavehook_vvvvvwz);

	var add_php_allowedit_vvvvvxa = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvxa(add_php_allowedit_vvvvvxa);

	var add_php_batchcopy_vvvvvxb = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvxb(add_php_batchcopy_vvvvvxb);

	var add_php_batchmove_vvvvvxc = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvxc(add_php_batchmove_vvvvvxc);

	var add_php_before_publish_vvvvvxd = jQuery("#jform_add_php_before_publish input[type='radio']:checked").val();
	vvvvvxd(add_php_before_publish_vvvvvxd);

	var add_php_after_publish_vvvvvxe = jQuery("#jform_add_php_after_publish input[type='radio']:checked").val();
	vvvvvxe(add_php_after_publish_vvvvvxe);

	var add_php_before_delete_vvvvvxf = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvxf(add_php_before_delete_vvvvvxf);

	var add_php_after_delete_vvvvvxg = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvxg(add_php_after_delete_vvvvvxg);

	var add_php_document_vvvvvxh = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvxh(add_php_document_vvvvvxh);

	var add_sql_vvvvvxi = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxi(add_sql_vvvvvxi);

	var source_vvvvvxj = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxj = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxj(source_vvvvvxj,add_sql_vvvvvxj);

	var source_vvvvvxl = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxl = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxl(source_vvvvvxl,add_sql_vvvvvxl);

	var add_custom_import_vvvvvxn = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxn(add_custom_import_vvvvvxn);

	var add_custom_import_vvvvvxo = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxo(add_custom_import_vvvvvxo);

	var add_custom_button_vvvvvxp = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvxp(add_custom_button_vvvvvxp);
});

// the vvvvvwn function
function vvvvvwn(add_css_view_vvvvvwn)
{
	// set the function logic
	if (add_css_view_vvvvvwn == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvwnvwl_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvwnvwl_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvwnvwl_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvwnvwl_required = true;
		}
	}
}

// the vvvvvwo function
function vvvvvwo(add_css_views_vvvvvwo)
{
	// set the function logic
	if (add_css_views_vvvvvwo == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvwovwm_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvwovwm_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvwovwm_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvwovwm_required = true;
		}
	}
}

// the vvvvvwp function
function vvvvvwp(add_javascript_view_file_vvvvvwp)
{
	// set the function logic
	if (add_javascript_view_file_vvvvvwp == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_vvvvvwpvwn_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_vvvvvwpvwn_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_vvvvvwpvwn_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_vvvvvwpvwn_required = true;
		}
	}
}

// the vvvvvwq function
function vvvvvwq(add_javascript_views_file_vvvvvwq)
{
	// set the function logic
	if (add_javascript_views_file_vvvvvwq == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_vvvvvwqvwo_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_vvvvvwqvwo_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_vvvvvwqvwo_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_vvvvvwqvwo_required = true;
		}
	}
}

// the vvvvvwr function
function vvvvvwr(add_javascript_view_footer_vvvvvwr)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvwr == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvwrvwp_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvwrvwp_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvwrvwp_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvwrvwp_required = true;
		}
	}
}

// the vvvvvws function
function vvvvvws(add_javascript_views_footer_vvvvvws)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvws == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvwsvwq_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvwsvwq_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvwsvwq_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvwsvwq_required = true;
		}
	}
}

// the vvvvvwt function
function vvvvvwt(add_php_ajax_vvvvvwt)
{
	// set the function logic
	if (add_php_ajax_vvvvvwt == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvwtvwr_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvwtvwr_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvwtvwr_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvwtvwr_required = true;
		}
	}
}

// the vvvvvwu function
function vvvvvwu(add_php_getitem_vvvvvwu)
{
	// set the function logic
	if (add_php_getitem_vvvvvwu == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_vvvvvwuvws_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_vvvvvwuvws_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_vvvvvwuvws_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_vvvvvwuvws_required = true;
		}
	}
}

// the vvvvvwv function
function vvvvvwv(add_php_getitems_vvvvvwv)
{
	// set the function logic
	if (add_php_getitems_vvvvvwv == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_vvvvvwvvwt_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_vvvvvwvvwt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_vvvvvwvvwt_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_vvvvvwvvwt_required = true;
		}
	}
}

// the vvvvvww function
function vvvvvww(add_php_getitems_after_all_vvvvvww)
{
	// set the function logic
	if (add_php_getitems_after_all_vvvvvww == 1)
	{
		jQuery('#jform_php_getitems_after_all').closest('.control-group').show();
		if (jform_vvvvvwwvwu_required)
		{
			updateFieldRequired('php_getitems_after_all',0);
			jQuery('#jform_php_getitems_after_all').prop('required','required');
			jQuery('#jform_php_getitems_after_all').attr('aria-required',true);
			jQuery('#jform_php_getitems_after_all').addClass('required');
			jform_vvvvvwwvwu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems_after_all').closest('.control-group').hide();
		if (!jform_vvvvvwwvwu_required)
		{
			updateFieldRequired('php_getitems_after_all',1);
			jQuery('#jform_php_getitems_after_all').removeAttr('required');
			jQuery('#jform_php_getitems_after_all').removeAttr('aria-required');
			jQuery('#jform_php_getitems_after_all').removeClass('required');
			jform_vvvvvwwvwu_required = true;
		}
	}
}

// the vvvvvwx function
function vvvvvwx(add_php_getlistquery_vvvvvwx)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvwx == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvwxvwv_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvwxvwv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvwxvwv_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvwxvwv_required = true;
		}
	}
}

// the vvvvvwy function
function vvvvvwy(add_php_save_vvvvvwy)
{
	// set the function logic
	if (add_php_save_vvvvvwy == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_vvvvvwyvww_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_vvvvvwyvww_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_vvvvvwyvww_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_vvvvvwyvww_required = true;
		}
	}
}

// the vvvvvwz function
function vvvvvwz(add_php_postsavehook_vvvvvwz)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvwz == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_vvvvvwzvwx_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_vvvvvwzvwx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_vvvvvwzvwx_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_vvvvvwzvwx_required = true;
		}
	}
}

// the vvvvvxa function
function vvvvvxa(add_php_allowedit_vvvvvxa)
{
	// set the function logic
	if (add_php_allowedit_vvvvvxa == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_vvvvvxavwy_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_vvvvvxavwy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_vvvvvxavwy_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_vvvvvxavwy_required = true;
		}
	}
}

// the vvvvvxb function
function vvvvvxb(add_php_batchcopy_vvvvvxb)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvxb == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_vvvvvxbvwz_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_vvvvvxbvwz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_vvvvvxbvwz_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_vvvvvxbvwz_required = true;
		}
	}
}

// the vvvvvxc function
function vvvvvxc(add_php_batchmove_vvvvvxc)
{
	// set the function logic
	if (add_php_batchmove_vvvvvxc == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_vvvvvxcvxa_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_vvvvvxcvxa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_vvvvvxcvxa_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_vvvvvxcvxa_required = true;
		}
	}
}

// the vvvvvxd function
function vvvvvxd(add_php_before_publish_vvvvvxd)
{
	// set the function logic
	if (add_php_before_publish_vvvvvxd == 1)
	{
		jQuery('#jform_php_before_publish').closest('.control-group').show();
		if (jform_vvvvvxdvxb_required)
		{
			updateFieldRequired('php_before_publish',0);
			jQuery('#jform_php_before_publish').prop('required','required');
			jQuery('#jform_php_before_publish').attr('aria-required',true);
			jQuery('#jform_php_before_publish').addClass('required');
			jform_vvvvvxdvxb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_publish').closest('.control-group').hide();
		if (!jform_vvvvvxdvxb_required)
		{
			updateFieldRequired('php_before_publish',1);
			jQuery('#jform_php_before_publish').removeAttr('required');
			jQuery('#jform_php_before_publish').removeAttr('aria-required');
			jQuery('#jform_php_before_publish').removeClass('required');
			jform_vvvvvxdvxb_required = true;
		}
	}
}

// the vvvvvxe function
function vvvvvxe(add_php_after_publish_vvvvvxe)
{
	// set the function logic
	if (add_php_after_publish_vvvvvxe == 1)
	{
		jQuery('#jform_php_after_publish').closest('.control-group').show();
		if (jform_vvvvvxevxc_required)
		{
			updateFieldRequired('php_after_publish',0);
			jQuery('#jform_php_after_publish').prop('required','required');
			jQuery('#jform_php_after_publish').attr('aria-required',true);
			jQuery('#jform_php_after_publish').addClass('required');
			jform_vvvvvxevxc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_publish').closest('.control-group').hide();
		if (!jform_vvvvvxevxc_required)
		{
			updateFieldRequired('php_after_publish',1);
			jQuery('#jform_php_after_publish').removeAttr('required');
			jQuery('#jform_php_after_publish').removeAttr('aria-required');
			jQuery('#jform_php_after_publish').removeClass('required');
			jform_vvvvvxevxc_required = true;
		}
	}
}

// the vvvvvxf function
function vvvvvxf(add_php_before_delete_vvvvvxf)
{
	// set the function logic
	if (add_php_before_delete_vvvvvxf == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_vvvvvxfvxd_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_vvvvvxfvxd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_vvvvvxfvxd_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_vvvvvxfvxd_required = true;
		}
	}
}

// the vvvvvxg function
function vvvvvxg(add_php_after_delete_vvvvvxg)
{
	// set the function logic
	if (add_php_after_delete_vvvvvxg == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_vvvvvxgvxe_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_vvvvvxgvxe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_vvvvvxgvxe_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_vvvvvxgvxe_required = true;
		}
	}
}

// the vvvvvxh function
function vvvvvxh(add_php_document_vvvvvxh)
{
	// set the function logic
	if (add_php_document_vvvvvxh == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_vvvvvxhvxf_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_vvvvvxhvxf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_vvvvvxhvxf_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_vvvvvxhvxf_required = true;
		}
	}
}

// the vvvvvxi function
function vvvvvxi(add_sql_vvvvvxi)
{
	// set the function logic
	if (add_sql_vvvvvxi == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_vvvvvxivxg_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvxivxg_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_vvvvvxivxg_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvxivxg_required = true;
		}
	}
}

// the vvvvvxj function
function vvvvvxj(source_vvvvvxj,add_sql_vvvvvxj)
{
	// set the function logic
	if (source_vvvvvxj == 2 && add_sql_vvvvvxj == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvxjvxh_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvxjvxh_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvxjvxh_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvxjvxh_required = true;
		}
	}
}

// the vvvvvxl function
function vvvvvxl(source_vvvvvxl,add_sql_vvvvvxl)
{
	// set the function logic
	if (source_vvvvvxl == 1 && add_sql_vvvvvxl == 1)
	{
		jQuery('#jform_addtables').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables').closest('.control-group').hide();
	}
}

// the vvvvvxn function
function vvvvvxn(add_custom_import_vvvvvxn)
{
	// set the function logic
	if (add_custom_import_vvvvvxn == 1)
	{
		jQuery('#jform_html_import_view').closest('.control-group').show();
		if (jform_vvvvvxnvxi_required)
		{
			updateFieldRequired('html_import_view',0);
			jQuery('#jform_html_import_view').prop('required','required');
			jQuery('#jform_html_import_view').attr('aria-required',true);
			jQuery('#jform_html_import_view').addClass('required');
			jform_vvvvvxnvxi_required = false;
		}

		jQuery('.note_advanced_import').closest('.control-group').show();
		jQuery('#jform_php_import_display').closest('.control-group').show();
		if (jform_vvvvvxnvxj_required)
		{
			updateFieldRequired('php_import_display',0);
			jQuery('#jform_php_import_display').prop('required','required');
			jQuery('#jform_php_import_display').attr('aria-required',true);
			jQuery('#jform_php_import_display').addClass('required');
			jform_vvvvvxnvxj_required = false;
		}

		jQuery('#jform_php_import').closest('.control-group').show();
		if (jform_vvvvvxnvxk_required)
		{
			updateFieldRequired('php_import',0);
			jQuery('#jform_php_import').prop('required','required');
			jQuery('#jform_php_import').attr('aria-required',true);
			jQuery('#jform_php_import').addClass('required');
			jform_vvvvvxnvxk_required = false;
		}

		jQuery('#jform_php_import_save').closest('.control-group').show();
		if (jform_vvvvvxnvxl_required)
		{
			updateFieldRequired('php_import_save',0);
			jQuery('#jform_php_import_save').prop('required','required');
			jQuery('#jform_php_import_save').attr('aria-required',true);
			jQuery('#jform_php_import_save').addClass('required');
			jform_vvvvvxnvxl_required = false;
		}

		jQuery('#jform_php_import_setdata').closest('.control-group').show();
		if (jform_vvvvvxnvxm_required)
		{
			updateFieldRequired('php_import_setdata',0);
			jQuery('#jform_php_import_setdata').prop('required','required');
			jQuery('#jform_php_import_setdata').attr('aria-required',true);
			jQuery('#jform_php_import_setdata').addClass('required');
			jform_vvvvvxnvxm_required = false;
		}

	}
	else
	{
		jQuery('#jform_html_import_view').closest('.control-group').hide();
		if (!jform_vvvvvxnvxi_required)
		{
			updateFieldRequired('html_import_view',1);
			jQuery('#jform_html_import_view').removeAttr('required');
			jQuery('#jform_html_import_view').removeAttr('aria-required');
			jQuery('#jform_html_import_view').removeClass('required');
			jform_vvvvvxnvxi_required = true;
		}
		jQuery('.note_advanced_import').closest('.control-group').hide();
		jQuery('#jform_php_import_display').closest('.control-group').hide();
		if (!jform_vvvvvxnvxj_required)
		{
			updateFieldRequired('php_import_display',1);
			jQuery('#jform_php_import_display').removeAttr('required');
			jQuery('#jform_php_import_display').removeAttr('aria-required');
			jQuery('#jform_php_import_display').removeClass('required');
			jform_vvvvvxnvxj_required = true;
		}
		jQuery('#jform_php_import').closest('.control-group').hide();
		if (!jform_vvvvvxnvxk_required)
		{
			updateFieldRequired('php_import',1);
			jQuery('#jform_php_import').removeAttr('required');
			jQuery('#jform_php_import').removeAttr('aria-required');
			jQuery('#jform_php_import').removeClass('required');
			jform_vvvvvxnvxk_required = true;
		}
		jQuery('#jform_php_import_save').closest('.control-group').hide();
		if (!jform_vvvvvxnvxl_required)
		{
			updateFieldRequired('php_import_save',1);
			jQuery('#jform_php_import_save').removeAttr('required');
			jQuery('#jform_php_import_save').removeAttr('aria-required');
			jQuery('#jform_php_import_save').removeClass('required');
			jform_vvvvvxnvxl_required = true;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').hide();
		if (!jform_vvvvvxnvxm_required)
		{
			updateFieldRequired('php_import_setdata',1);
			jQuery('#jform_php_import_setdata').removeAttr('required');
			jQuery('#jform_php_import_setdata').removeAttr('aria-required');
			jQuery('#jform_php_import_setdata').removeClass('required');
			jform_vvvvvxnvxm_required = true;
		}
	}
}

// the vvvvvxo function
function vvvvvxo(add_custom_import_vvvvvxo)
{
	// set the function logic
	if (add_custom_import_vvvvvxo == 0)
	{
		jQuery('.note_beginner_import').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_beginner_import').closest('.control-group').hide();
	}
}

// the vvvvvxp function
function vvvvvxp(add_custom_button_vvvvvxp)
{
	// set the function logic
	if (add_custom_button_vvvvvxp == 1)
	{
		jQuery('#jform_custom_button').closest('.control-group').show();
		jQuery('#jform_php_controller').closest('.control-group').show();
		if (jform_vvvvvxpvxn_required)
		{
			updateFieldRequired('php_controller',0);
			jQuery('#jform_php_controller').prop('required','required');
			jQuery('#jform_php_controller').attr('aria-required',true);
			jQuery('#jform_php_controller').addClass('required');
			jform_vvvvvxpvxn_required = false;
		}

		jQuery('#jform_php_model').closest('.control-group').show();
		if (jform_vvvvvxpvxo_required)
		{
			updateFieldRequired('php_model',0);
			jQuery('#jform_php_model').prop('required','required');
			jQuery('#jform_php_model').attr('aria-required',true);
			jQuery('#jform_php_model').addClass('required');
			jform_vvvvvxpvxo_required = false;
		}

	}
	else
	{
		jQuery('#jform_custom_button').closest('.control-group').hide();
		jQuery('#jform_php_controller').closest('.control-group').hide();
		if (!jform_vvvvvxpvxn_required)
		{
			updateFieldRequired('php_controller',1);
			jQuery('#jform_php_controller').removeAttr('required');
			jQuery('#jform_php_controller').removeAttr('aria-required');
			jQuery('#jform_php_controller').removeClass('required');
			jform_vvvvvxpvxn_required = true;
		}
		jQuery('#jform_php_model').closest('.control-group').hide();
		if (!jform_vvvvvxpvxo_required)
		{
			updateFieldRequired('php_model',1);
			jQuery('#jform_php_model').removeAttr('required');
			jQuery('#jform_php_model').removeAttr('aria-required');
			jQuery('#jform_php_model').removeClass('required');
			jform_vvvvvxpvxo_required = true;
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
