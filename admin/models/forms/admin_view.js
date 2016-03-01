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

	@version		2.1.1
	@build			1st March, 2016
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
jform_vvvvvwgvwg_required = false;
jform_vvvvvwhvwh_required = false;
jform_vvvvvwivwi_required = false;
jform_vvvvvwjvwj_required = false;
jform_vvvvvwkvwk_required = false;
jform_vvvvvwlvwl_required = false;
jform_vvvvvwmvwm_required = false;
jform_vvvvvwnvwn_required = false;
jform_vvvvvwovwo_required = false;
jform_vvvvvwpvwp_required = false;
jform_vvvvvwqvwq_required = false;
jform_vvvvvwrvwr_required = false;
jform_vvvvvwsvws_required = false;
jform_vvvvvwtvwt_required = false;
jform_vvvvvwuvwu_required = false;
jform_vvvvvwvvwv_required = false;
jform_vvvvvwwvww_required = false;
jform_vvvvvwxvwx_required = false;
jform_vvvvvwyvwy_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vvvvvwg = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvvwg(add_css_view_vvvvvwg);

	var add_css_views_vvvvvwh = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvvwh(add_css_views_vvvvvwh);

	var add_javascript_view_file_vvvvvwi = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	vvvvvwi(add_javascript_view_file_vvvvvwi);

	var add_javascript_views_file_vvvvvwj = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	vvvvvwj(add_javascript_views_file_vvvvvwj);

	var add_javascript_view_footer_vvvvvwk = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvvwk(add_javascript_view_footer_vvvvvwk);

	var add_javascript_views_footer_vvvvvwl = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvvwl(add_javascript_views_footer_vvvvvwl);

	var add_php_ajax_vvvvvwm = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvwm(add_php_ajax_vvvvvwm);

	var add_php_getitem_vvvvvwn = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	vvvvvwn(add_php_getitem_vvvvvwn);

	var add_php_getitems_vvvvvwo = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	vvvvvwo(add_php_getitems_vvvvvwo);

	var add_php_getlistquery_vvvvvwp = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	vvvvvwp(add_php_getlistquery_vvvvvwp);

	var add_php_save_vvvvvwq = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	vvvvvwq(add_php_save_vvvvvwq);

	var add_php_postsavehook_vvvvvwr = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	vvvvvwr(add_php_postsavehook_vvvvvwr);

	var add_php_allowedit_vvvvvws = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	vvvvvws(add_php_allowedit_vvvvvws);

	var add_php_batchcopy_vvvvvwt = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vvvvvwt(add_php_batchcopy_vvvvvwt);

	var add_php_batchmove_vvvvvwu = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	vvvvvwu(add_php_batchmove_vvvvvwu);

	var add_php_before_delete_vvvvvwv = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	vvvvvwv(add_php_before_delete_vvvvvwv);

	var add_php_after_delete_vvvvvww = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vvvvvww(add_php_after_delete_vvvvvww);

	var add_sql_vvvvvwx = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvwx(add_sql_vvvvvwx);

	var source_vvvvvwy = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvwy = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvwy(source_vvvvvwy,add_sql_vvvvvwy);

	var source_vvvvvxa = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_vvvvvxa = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxa(source_vvvvvxa,add_sql_vvvvvxa);
});

// the vvvvvwg function
function vvvvvwg(add_css_view_vvvvvwg)
{
	// set the function logic
	if (add_css_view_vvvvvwg == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vvvvvwgvwg_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vvvvvwgvwg_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vvvvvwgvwg_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vvvvvwgvwg_required = true;
		}
	}
}

// the vvvvvwh function
function vvvvvwh(add_css_views_vvvvvwh)
{
	// set the function logic
	if (add_css_views_vvvvvwh == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_vvvvvwhvwh_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_vvvvvwhvwh_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_vvvvvwhvwh_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_vvvvvwhvwh_required = true;
		}
	}
}

// the vvvvvwi function
function vvvvvwi(add_javascript_view_file_vvvvvwi)
{
	// set the function logic
	if (add_javascript_view_file_vvvvvwi == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_vvvvvwivwi_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_vvvvvwivwi_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_vvvvvwivwi_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_vvvvvwivwi_required = true;
		}
	}
}

// the vvvvvwj function
function vvvvvwj(add_javascript_views_file_vvvvvwj)
{
	// set the function logic
	if (add_javascript_views_file_vvvvvwj == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_vvvvvwjvwj_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_vvvvvwjvwj_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_vvvvvwjvwj_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_vvvvvwjvwj_required = true;
		}
	}
}

// the vvvvvwk function
function vvvvvwk(add_javascript_view_footer_vvvvvwk)
{
	// set the function logic
	if (add_javascript_view_footer_vvvvvwk == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_vvvvvwkvwk_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_vvvvvwkvwk_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_vvvvvwkvwk_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_vvvvvwkvwk_required = true;
		}
	}
}

// the vvvvvwl function
function vvvvvwl(add_javascript_views_footer_vvvvvwl)
{
	// set the function logic
	if (add_javascript_views_footer_vvvvvwl == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_vvvvvwlvwl_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_vvvvvwlvwl_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_vvvvvwlvwl_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_vvvvvwlvwl_required = true;
		}
	}
}

// the vvvvvwm function
function vvvvvwm(add_php_ajax_vvvvvwm)
{
	// set the function logic
	if (add_php_ajax_vvvvvwm == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_vvvvvwmvwm_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_vvvvvwmvwm_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_vvvvvwmvwm_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_vvvvvwmvwm_required = true;
		}
	}
}

// the vvvvvwn function
function vvvvvwn(add_php_getitem_vvvvvwn)
{
	// set the function logic
	if (add_php_getitem_vvvvvwn == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_vvvvvwnvwn_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_vvvvvwnvwn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_vvvvvwnvwn_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_vvvvvwnvwn_required = true;
		}
	}
}

// the vvvvvwo function
function vvvvvwo(add_php_getitems_vvvvvwo)
{
	// set the function logic
	if (add_php_getitems_vvvvvwo == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_vvvvvwovwo_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_vvvvvwovwo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_vvvvvwovwo_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_vvvvvwovwo_required = true;
		}
	}
}

// the vvvvvwp function
function vvvvvwp(add_php_getlistquery_vvvvvwp)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvwp == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvwpvwp_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvwpvwp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvwpvwp_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvwpvwp_required = true;
		}
	}
}

// the vvvvvwq function
function vvvvvwq(add_php_save_vvvvvwq)
{
	// set the function logic
	if (add_php_save_vvvvvwq == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_vvvvvwqvwq_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_vvvvvwqvwq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_vvvvvwqvwq_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_vvvvvwqvwq_required = true;
		}
	}
}

// the vvvvvwr function
function vvvvvwr(add_php_postsavehook_vvvvvwr)
{
	// set the function logic
	if (add_php_postsavehook_vvvvvwr == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_vvvvvwrvwr_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_vvvvvwrvwr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_vvvvvwrvwr_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_vvvvvwrvwr_required = true;
		}
	}
}

// the vvvvvws function
function vvvvvws(add_php_allowedit_vvvvvws)
{
	// set the function logic
	if (add_php_allowedit_vvvvvws == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_vvvvvwsvws_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_vvvvvwsvws_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_vvvvvwsvws_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_vvvvvwsvws_required = true;
		}
	}
}

// the vvvvvwt function
function vvvvvwt(add_php_batchcopy_vvvvvwt)
{
	// set the function logic
	if (add_php_batchcopy_vvvvvwt == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_vvvvvwtvwt_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_vvvvvwtvwt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_vvvvvwtvwt_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_vvvvvwtvwt_required = true;
		}
	}
}

// the vvvvvwu function
function vvvvvwu(add_php_batchmove_vvvvvwu)
{
	// set the function logic
	if (add_php_batchmove_vvvvvwu == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_vvvvvwuvwu_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_vvvvvwuvwu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_vvvvvwuvwu_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_vvvvvwuvwu_required = true;
		}
	}
}

// the vvvvvwv function
function vvvvvwv(add_php_before_delete_vvvvvwv)
{
	// set the function logic
	if (add_php_before_delete_vvvvvwv == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_vvvvvwvvwv_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_vvvvvwvvwv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_vvvvvwvvwv_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_vvvvvwvvwv_required = true;
		}
	}
}

// the vvvvvww function
function vvvvvww(add_php_after_delete_vvvvvww)
{
	// set the function logic
	if (add_php_after_delete_vvvvvww == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_vvvvvwwvww_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_vvvvvwwvww_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_vvvvvwwvww_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_vvvvvwwvww_required = true;
		}
	}
}

// the vvvvvwx function
function vvvvvwx(add_sql_vvvvvwx)
{
	// set the function logic
	if (add_sql_vvvvvwx == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_vvvvvwxvwx_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_vvvvvwxvwx_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_vvvvvwxvwx_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_vvvvvwxvwx_required = true;
		}
	}
}

// the vvvvvwy function
function vvvvvwy(source_vvvvvwy,add_sql_vvvvvwy)
{
	// set the function logic
	if (source_vvvvvwy == 2 && add_sql_vvvvvwy == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvwyvwy_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvwyvwy_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvwyvwy_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvwyvwy_required = true;
		}
	}
}

// the vvvvvxa function
function vvvvvxa(source_vvvvvxa,add_sql_vvvvvxa)
{
	// set the function logic
	if (source_vvvvvxa == 1 && add_sql_vvvvvxa == 1)
	{
		jQuery('#jform_addtables').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addtables').closest('.control-group').hide();
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
