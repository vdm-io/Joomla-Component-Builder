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

	@version		2.1.8
	@build			10th May, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		admin_view.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvwivwg_required = false;
jform_vvvvvwjvwh_required = false;
jform_vvvvvwkvwi_required = false;
jform_vvvvvwlvwj_required = false;
jform_vvvvvwmvwk_required = false;
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
jform_vvvvvxfvxa_required = false;
jform_vvvvvxfvxb_required = false;
jform_vvvvvxfvxc_required = false;
jform_vvvvvxfvxd_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vvvvvwi = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvwi(add_css_view_vvvvvwi);

	var add_css_views_vvvvvwj = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvwj(add_css_views_vvvvvwj);

	var add_javascript_view_file_vvvvvwk = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	vvvvvwk(add_javascript_view_file_vvvvvwk);

	var add_javascript_views_file_vvvvvwl = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	vvvvvwl(add_javascript_views_file_vvvvvwl);

	var add_javascript_view_footer_vvvvvwm = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvwm(add_javascript_view_footer_vvvvvwm);

	var add_javascript_views_footer_vvvvvwn = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvwn(add_javascript_views_footer_vvvvvwn);

	var add_php_ajax_vvvvvwo = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvwo(add_php_ajax_vvvvvwo);

	var add_php_getitem_vvvvvwp = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	vvvvvwp(add_php_getitem_vvvvvwp);

	var add_php_getitems_vvvvvwq = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	vvvvvwq(add_php_getitems_vvvvvwq);

	var add_php_getlistquery_vvvvvwr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	vvvvvwr(add_php_getlistquery_vvvvvwr);

	var add_php_save_vvvvvws = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvws(add_php_save_vvvvvws);

	var add_php_postsavehook_vvvvvwt = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvwt(add_php_postsavehook_vvvvvwt);

	var add_php_allowedit_vvvvvwu = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvwu(add_php_allowedit_vvvvvwu);

	var add_php_batchcopy_vvvvvwv = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvwv(add_php_batchcopy_vvvvvwv);

	var add_php_batchmove_vvvvvww = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvww(add_php_batchmove_vvvvvww);

	var add_php_before_delete_vvvvvwx = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvwx(add_php_before_delete_vvvvvwx);

	var add_php_after_delete_vvvvvwy = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvwy(add_php_after_delete_vvvvvwy);

	var add_php_document_vvvvvwz = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvwz(add_php_document_vvvvvwz);

	var add_sql_vvvvvxa = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxa(add_sql_vvvvvxa);

	var source_vvvvvxb = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxb = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxb(source_vvvvvxb,add_sql_vvvvvxb);

	var source_vvvvvxd = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxd = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxd(source_vvvvvxd,add_sql_vvvvvxd);

	var add_custom_import_vvvvvxf = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxf(add_custom_import_vvvvvxf);

	var add_custom_import_vvvvvxg = jQuery("#jform_add_custom_import input[type='radio']:checked").val();
	vvvvvxg(add_custom_import_vvvvvxg);
});

// the vvvvvwi function
function vvvvvwi(add_css_view_vvvvvwi)
{
	// set the function logic
	if (add_css_view_vvvvvwi == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvwivwg_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvwivwg_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvwivwg_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvwivwg_required = true;
		}
	}
}

// the vvvvvwj function
function vvvvvwj(add_css_views_vvvvvwj)
{
	// set the function logic
	if (add_css_views_vvvvvwj == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvwjvwh_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvwjvwh_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvwjvwh_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvwjvwh_required = true;
		}
	}
}

// the vvvvvwk function
function vvvvvwk(add_javascript_view_file_vvvvvwk)
{
	// set the function logic
	if (add_javascript_view_file_vvvvvwk == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_vvvvvwkvwi_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_vvvvvwkvwi_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_vvvvvwkvwi_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_vvvvvwkvwi_required = true;
		}
	}
}

// the vvvvvwl function
function vvvvvwl(add_javascript_views_file_vvvvvwl)
{
	// set the function logic
	if (add_javascript_views_file_vvvvvwl == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_vvvvvwlvwj_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_vvvvvwlvwj_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_vvvvvwlvwj_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_vvvvvwlvwj_required = true;
		}
	}
}

// the vvvvvwm function
function vvvvvwm(add_javascript_view_footer_vvvvvwm)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvwm == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvwmvwk_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvwmvwk_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvwmvwk_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvwmvwk_required = true;
		}
	}
}

// the vvvvvwn function
function vvvvvwn(add_javascript_views_footer_vvvvvwn)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvwn == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvwnvwl_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvwnvwl_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvwnvwl_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvwnvwl_required = true;
		}
	}
}

// the vvvvvwo function
function vvvvvwo(add_php_ajax_vvvvvwo)
{
	// set the function logic
	if (add_php_ajax_vvvvvwo == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvwovwm_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvwovwm_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvwovwm_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvwovwm_required = true;
		}
	}
}

// the vvvvvwp function
function vvvvvwp(add_php_getitem_vvvvvwp)
{
	// set the function logic
	if (add_php_getitem_vvvvvwp == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_vvvvvwpvwn_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_vvvvvwpvwn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_vvvvvwpvwn_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_vvvvvwpvwn_required = true;
		}
	}
}

// the vvvvvwq function
function vvvvvwq(add_php_getitems_vvvvvwq)
{
	// set the function logic
	if (add_php_getitems_vvvvvwq == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_vvvvvwqvwo_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_vvvvvwqvwo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_vvvvvwqvwo_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_vvvvvwqvwo_required = true;
		}
	}
}

// the vvvvvwr function
function vvvvvwr(add_php_getlistquery_vvvvvwr)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvwr == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvwrvwp_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvwrvwp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvwrvwp_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvwrvwp_required = true;
		}
	}
}

// the vvvvvws function
function vvvvvws(add_php_save_vvvvvws)
{
	// set the function logic
	if (add_php_save_vvvvvws == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_vvvvvwsvwq_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_vvvvvwsvwq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_vvvvvwsvwq_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_vvvvvwsvwq_required = true;
		}
	}
}

// the vvvvvwt function
function vvvvvwt(add_php_postsavehook_vvvvvwt)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvwt == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_vvvvvwtvwr_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_vvvvvwtvwr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_vvvvvwtvwr_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_vvvvvwtvwr_required = true;
		}
	}
}

// the vvvvvwu function
function vvvvvwu(add_php_allowedit_vvvvvwu)
{
	// set the function logic
	if (add_php_allowedit_vvvvvwu == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_vvvvvwuvws_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_vvvvvwuvws_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_vvvvvwuvws_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_vvvvvwuvws_required = true;
		}
	}
}

// the vvvvvwv function
function vvvvvwv(add_php_batchcopy_vvvvvwv)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvwv == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_vvvvvwvvwt_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_vvvvvwvvwt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_vvvvvwvvwt_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_vvvvvwvvwt_required = true;
		}
	}
}

// the vvvvvww function
function vvvvvww(add_php_batchmove_vvvvvww)
{
	// set the function logic
	if (add_php_batchmove_vvvvvww == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_vvvvvwwvwu_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_vvvvvwwvwu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_vvvvvwwvwu_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_vvvvvwwvwu_required = true;
		}
	}
}

// the vvvvvwx function
function vvvvvwx(add_php_before_delete_vvvvvwx)
{
	// set the function logic
	if (add_php_before_delete_vvvvvwx == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_vvvvvwxvwv_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_vvvvvwxvwv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_vvvvvwxvwv_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_vvvvvwxvwv_required = true;
		}
	}
}

// the vvvvvwy function
function vvvvvwy(add_php_after_delete_vvvvvwy)
{
	// set the function logic
	if (add_php_after_delete_vvvvvwy == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_vvvvvwyvww_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_vvvvvwyvww_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_vvvvvwyvww_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_vvvvvwyvww_required = true;
		}
	}
}

// the vvvvvwz function
function vvvvvwz(add_php_document_vvvvvwz)
{
	// set the function logic
	if (add_php_document_vvvvvwz == 1)
	{
		jQuery('#jform_php_document').closest('.control-group').show();
		if (jform_vvvvvwzvwx_required)
		{
			updateFieldRequired('php_document',0);
			jQuery('#jform_php_document').prop('required','required');
			jQuery('#jform_php_document').attr('aria-required',true);
			jQuery('#jform_php_document').addClass('required');
			jform_vvvvvwzvwx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_document').closest('.control-group').hide();
		if (!jform_vvvvvwzvwx_required)
		{
			updateFieldRequired('php_document',1);
			jQuery('#jform_php_document').removeAttr('required');
			jQuery('#jform_php_document').removeAttr('aria-required');
			jQuery('#jform_php_document').removeClass('required');
			jform_vvvvvwzvwx_required = true;
		}
	}
}

// the vvvvvxa function
function vvvvvxa(add_sql_vvvvvxa)
{
	// set the function logic
	if (add_sql_vvvvvxa == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_vvvvvxavwy_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvxavwy_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_vvvvvxavwy_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvxavwy_required = true;
		}
	}
}

// the vvvvvxb function
function vvvvvxb(source_vvvvvxb,add_sql_vvvvvxb)
{
	// set the function logic
	if (source_vvvvvxb == 2 && add_sql_vvvvvxb == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvxbvwz_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvxbvwz_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvxbvwz_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvxbvwz_required = true;
		}
	}
}

// the vvvvvxd function
function vvvvvxd(source_vvvvvxd,add_sql_vvvvvxd)
{
	// set the function logic
	if (source_vvvvvxd == 1 && add_sql_vvvvvxd == 1)
	{
		jQuery('#jform_addtables').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables').closest('.control-group').hide();
	}
}

// the vvvvvxf function
function vvvvvxf(add_custom_import_vvvvvxf)
{
	// set the function logic
	if (add_custom_import_vvvvvxf == 1)
	{
		jQuery('#jform_html_import_view').closest('.control-group').show();
		if (jform_vvvvvxfvxa_required)
		{
			updateFieldRequired('html_import_view',0);
			jQuery('#jform_html_import_view').prop('required','required');
			jQuery('#jform_html_import_view').attr('aria-required',true);
			jQuery('#jform_html_import_view').addClass('required');
			jform_vvvvvxfvxa_required = false;
		}

		jQuery('.note_advanced_import').closest('.control-group').show();
		jQuery('#jform_php_import').closest('.control-group').show();
		if (jform_vvvvvxfvxb_required)
		{
			updateFieldRequired('php_import',0);
			jQuery('#jform_php_import').prop('required','required');
			jQuery('#jform_php_import').attr('aria-required',true);
			jQuery('#jform_php_import').addClass('required');
			jform_vvvvvxfvxb_required = false;
		}

		jQuery('#jform_php_import_save').closest('.control-group').show();
		if (jform_vvvvvxfvxc_required)
		{
			updateFieldRequired('php_import_save',0);
			jQuery('#jform_php_import_save').prop('required','required');
			jQuery('#jform_php_import_save').attr('aria-required',true);
			jQuery('#jform_php_import_save').addClass('required');
			jform_vvvvvxfvxc_required = false;
		}

		jQuery('#jform_php_import_setdata').closest('.control-group').show();
		if (jform_vvvvvxfvxd_required)
		{
			updateFieldRequired('php_import_setdata',0);
			jQuery('#jform_php_import_setdata').prop('required','required');
			jQuery('#jform_php_import_setdata').attr('aria-required',true);
			jQuery('#jform_php_import_setdata').addClass('required');
			jform_vvvvvxfvxd_required = false;
		}

	}
	else
	{
		jQuery('#jform_html_import_view').closest('.control-group').hide();
		if (!jform_vvvvvxfvxa_required)
		{
			updateFieldRequired('html_import_view',1);
			jQuery('#jform_html_import_view').removeAttr('required');
			jQuery('#jform_html_import_view').removeAttr('aria-required');
			jQuery('#jform_html_import_view').removeClass('required');
			jform_vvvvvxfvxa_required = true;
		}
		jQuery('.note_advanced_import').closest('.control-group').hide();
		jQuery('#jform_php_import').closest('.control-group').hide();
		if (!jform_vvvvvxfvxb_required)
		{
			updateFieldRequired('php_import',1);
			jQuery('#jform_php_import').removeAttr('required');
			jQuery('#jform_php_import').removeAttr('aria-required');
			jQuery('#jform_php_import').removeClass('required');
			jform_vvvvvxfvxb_required = true;
		}
		jQuery('#jform_php_import_save').closest('.control-group').hide();
		if (!jform_vvvvvxfvxc_required)
		{
			updateFieldRequired('php_import_save',1);
			jQuery('#jform_php_import_save').removeAttr('required');
			jQuery('#jform_php_import_save').removeAttr('aria-required');
			jQuery('#jform_php_import_save').removeClass('required');
			jform_vvvvvxfvxc_required = true;
		}
		jQuery('#jform_php_import_setdata').closest('.control-group').hide();
		if (!jform_vvvvvxfvxd_required)
		{
			updateFieldRequired('php_import_setdata',1);
			jQuery('#jform_php_import_setdata').removeAttr('required');
			jQuery('#jform_php_import_setdata').removeAttr('aria-required');
			jQuery('#jform_php_import_setdata').removeClass('required');
			jform_vvvvvxfvxd_required = true;
		}
	}
}

// the vvvvvxg function
function vvvvvxg(add_custom_import_vvvvvxg)
{
	// set the function logic
	if (add_custom_import_vvvvvxg == 0)
	{
		jQuery('.note_beginner_import').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_beginner_import').closest('.control-group').hide();
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
		var current_import = jQuery('textarea#jform_php_import').val();
		var current_setdata = jQuery('textarea#jform_php_import_setdata').val();
		var current_save = jQuery('textarea#jform_php_import_save').val();
		var current_view = jQuery('textarea#jform_html_import_view').val();
		// set the setData method script
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
