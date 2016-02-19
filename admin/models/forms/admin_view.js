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

	@version		2.1.0
	@build			18th February, 2016
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
jform_zQvhtybktu_required = false;
jform_TidwsqhyGK_required = false;
jform_huJXNiLsWT_required = false;
jform_WvIyCcPKoo_required = false;
jform_ghwiCNtPka_required = false;
jform_FovimnnYDl_required = false;
jform_RtOzQyBJbQ_required = false;
jform_SgXitAYKxg_required = false;
jform_NVDlfNvsJY_required = false;
jform_LBruhlQPRU_required = false;
jform_JLaGSuiSgE_required = false;
jform_ZTtCgwqIVZ_required = false;
jform_GAAYbOjUyd_required = false;
jform_JjJJNCfVCk_required = false;
jform_sBeSWkwjPl_required = false;
jform_iyTPwTyzPe_required = false;
jform_JDlxqZauVC_required = false;
jform_EsWIgSPvdE_required = false;
jform_OqbCbyxHXs_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_zQvhtyb = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	zQvhtyb(add_css_view_zQvhtyb);

	var add_css_views_Tidwsqh = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	Tidwsqh(add_css_views_Tidwsqh);

	var add_javascript_view_file_huJXNiL = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	huJXNiL(add_javascript_view_file_huJXNiL);

	var add_javascript_views_file_WvIyCcP = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	WvIyCcP(add_javascript_views_file_WvIyCcP);

	var add_javascript_view_footer_ghwiCNt = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	ghwiCNt(add_javascript_view_footer_ghwiCNt);

	var add_javascript_views_footer_Fovimnn = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	Fovimnn(add_javascript_views_footer_Fovimnn);

	var add_php_ajax_RtOzQyB = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	RtOzQyB(add_php_ajax_RtOzQyB);

	var add_php_getitem_SgXitAY = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	SgXitAY(add_php_getitem_SgXitAY);

	var add_php_getitems_NVDlfNv = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	NVDlfNv(add_php_getitems_NVDlfNv);

	var add_php_getlistquery_LBruhlQ = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	LBruhlQ(add_php_getlistquery_LBruhlQ);

	var add_php_save_JLaGSui = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	JLaGSui(add_php_save_JLaGSui);

	var add_php_postsavehook_ZTtCgwq = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	ZTtCgwq(add_php_postsavehook_ZTtCgwq);

	var add_php_allowedit_GAAYbOj = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	GAAYbOj(add_php_allowedit_GAAYbOj);

	var add_php_batchcopy_JjJJNCf = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	JjJJNCf(add_php_batchcopy_JjJJNCf);

	var add_php_batchmove_sBeSWkw = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	sBeSWkw(add_php_batchmove_sBeSWkw);

	var add_php_before_delete_iyTPwTy = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	iyTPwTy(add_php_before_delete_iyTPwTy);

	var add_php_after_delete_JDlxqZa = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	JDlxqZa(add_php_after_delete_JDlxqZa);

	var add_sql_EsWIgSP = jQuery("#jform_add_sql input[type='radio']:checked").val();
	EsWIgSP(add_sql_EsWIgSP);

	var source_OqbCbyx = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_OqbCbyx = jQuery("#jform_add_sql input[type='radio']:checked").val();
	OqbCbyx(source_OqbCbyx,add_sql_OqbCbyx);

	var source_YrQtUhw = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_YrQtUhw = jQuery("#jform_add_sql input[type='radio']:checked").val();
	YrQtUhw(source_YrQtUhw,add_sql_YrQtUhw);
});

// the zQvhtyb function
function zQvhtyb(add_css_view_zQvhtyb)
{
	// set the function logic
	if (add_css_view_zQvhtyb == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_zQvhtybktu_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_zQvhtybktu_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_zQvhtybktu_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_zQvhtybktu_required = true;
		}
	}
}

// the Tidwsqh function
function Tidwsqh(add_css_views_Tidwsqh)
{
	// set the function logic
	if (add_css_views_Tidwsqh == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_TidwsqhyGK_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_TidwsqhyGK_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_TidwsqhyGK_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_TidwsqhyGK_required = true;
		}
	}
}

// the huJXNiL function
function huJXNiL(add_javascript_view_file_huJXNiL)
{
	// set the function logic
	if (add_javascript_view_file_huJXNiL == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_huJXNiLsWT_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_huJXNiLsWT_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_huJXNiLsWT_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_huJXNiLsWT_required = true;
		}
	}
}

// the WvIyCcP function
function WvIyCcP(add_javascript_views_file_WvIyCcP)
{
	// set the function logic
	if (add_javascript_views_file_WvIyCcP == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_WvIyCcPKoo_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_WvIyCcPKoo_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_WvIyCcPKoo_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_WvIyCcPKoo_required = true;
		}
	}
}

// the ghwiCNt function
function ghwiCNt(add_javascript_view_footer_ghwiCNt)
{
	// set the function logic
	if (add_javascript_view_footer_ghwiCNt == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_ghwiCNtPka_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_ghwiCNtPka_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_ghwiCNtPka_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_ghwiCNtPka_required = true;
		}
	}
}

// the Fovimnn function
function Fovimnn(add_javascript_views_footer_Fovimnn)
{
	// set the function logic
	if (add_javascript_views_footer_Fovimnn == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_FovimnnYDl_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_FovimnnYDl_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_FovimnnYDl_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_FovimnnYDl_required = true;
		}
	}
}

// the RtOzQyB function
function RtOzQyB(add_php_ajax_RtOzQyB)
{
	// set the function logic
	if (add_php_ajax_RtOzQyB == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_RtOzQyBJbQ_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_RtOzQyBJbQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_RtOzQyBJbQ_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_RtOzQyBJbQ_required = true;
		}
	}
}

// the SgXitAY function
function SgXitAY(add_php_getitem_SgXitAY)
{
	// set the function logic
	if (add_php_getitem_SgXitAY == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_SgXitAYKxg_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_SgXitAYKxg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_SgXitAYKxg_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_SgXitAYKxg_required = true;
		}
	}
}

// the NVDlfNv function
function NVDlfNv(add_php_getitems_NVDlfNv)
{
	// set the function logic
	if (add_php_getitems_NVDlfNv == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_NVDlfNvsJY_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_NVDlfNvsJY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_NVDlfNvsJY_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_NVDlfNvsJY_required = true;
		}
	}
}

// the LBruhlQ function
function LBruhlQ(add_php_getlistquery_LBruhlQ)
{
	// set the function logic
	if (add_php_getlistquery_LBruhlQ == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_LBruhlQPRU_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_LBruhlQPRU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_LBruhlQPRU_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_LBruhlQPRU_required = true;
		}
	}
}

// the JLaGSui function
function JLaGSui(add_php_save_JLaGSui)
{
	// set the function logic
	if (add_php_save_JLaGSui == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_JLaGSuiSgE_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_JLaGSuiSgE_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_JLaGSuiSgE_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_JLaGSuiSgE_required = true;
		}
	}
}

// the ZTtCgwq function
function ZTtCgwq(add_php_postsavehook_ZTtCgwq)
{
	// set the function logic
	if (add_php_postsavehook_ZTtCgwq == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_ZTtCgwqIVZ_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_ZTtCgwqIVZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_ZTtCgwqIVZ_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_ZTtCgwqIVZ_required = true;
		}
	}
}

// the GAAYbOj function
function GAAYbOj(add_php_allowedit_GAAYbOj)
{
	// set the function logic
	if (add_php_allowedit_GAAYbOj == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_GAAYbOjUyd_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_GAAYbOjUyd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_GAAYbOjUyd_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_GAAYbOjUyd_required = true;
		}
	}
}

// the JjJJNCf function
function JjJJNCf(add_php_batchcopy_JjJJNCf)
{
	// set the function logic
	if (add_php_batchcopy_JjJJNCf == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_JjJJNCfVCk_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_JjJJNCfVCk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_JjJJNCfVCk_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_JjJJNCfVCk_required = true;
		}
	}
}

// the sBeSWkw function
function sBeSWkw(add_php_batchmove_sBeSWkw)
{
	// set the function logic
	if (add_php_batchmove_sBeSWkw == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_sBeSWkwjPl_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_sBeSWkwjPl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_sBeSWkwjPl_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_sBeSWkwjPl_required = true;
		}
	}
}

// the iyTPwTy function
function iyTPwTy(add_php_before_delete_iyTPwTy)
{
	// set the function logic
	if (add_php_before_delete_iyTPwTy == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_iyTPwTyzPe_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_iyTPwTyzPe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_iyTPwTyzPe_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_iyTPwTyzPe_required = true;
		}
	}
}

// the JDlxqZa function
function JDlxqZa(add_php_after_delete_JDlxqZa)
{
	// set the function logic
	if (add_php_after_delete_JDlxqZa == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_JDlxqZauVC_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_JDlxqZauVC_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_JDlxqZauVC_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_JDlxqZauVC_required = true;
		}
	}
}

// the EsWIgSP function
function EsWIgSP(add_sql_EsWIgSP)
{
	// set the function logic
	if (add_sql_EsWIgSP == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_EsWIgSPvdE_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_EsWIgSPvdE_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_EsWIgSPvdE_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_EsWIgSPvdE_required = true;
		}
	}
}

// the OqbCbyx function
function OqbCbyx(source_OqbCbyx,add_sql_OqbCbyx)
{
	// set the function logic
	if (source_OqbCbyx == 2 && add_sql_OqbCbyx == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_OqbCbyxHXs_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_OqbCbyxHXs_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_OqbCbyxHXs_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_OqbCbyxHXs_required = true;
		}
	}
}

// the YrQtUhw function
function YrQtUhw(source_YrQtUhw,add_sql_YrQtUhw)
{
	// set the function logic
	if (source_YrQtUhw == 1 && add_sql_YrQtUhw == 1)
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
