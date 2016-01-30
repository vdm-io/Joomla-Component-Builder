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

	@version		2.0.8
	@build			30th January, 2016
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
jform_KMATzUTtWL_required = false;
jform_MYjuWIduYa_required = false;
jform_TCKWpDuOFC_required = false;
jform_itiIhBEdbG_required = false;
jform_JIxXiCLpUE_required = false;
jform_lPmaHxvhnh_required = false;
jform_CuvRiKzRHu_required = false;
jform_rthVyurdHn_required = false;
jform_MQfZTOwwXR_required = false;
jform_wHrYsuCQrn_required = false;
jform_mFOBHhQZoq_required = false;
jform_mWkrWeiAzi_required = false;
jform_lUNxViZEYm_required = false;
jform_QlXIHxKDwY_required = false;
jform_SRVenQhqrA_required = false;
jform_xxwqczycWx_required = false;
jform_nOCqpoOfQn_required = false;
jform_dIhaSuRZIh_required = false;
jform_AlEdvMvTNz_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_KMATzUT = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	KMATzUT(add_css_view_KMATzUT);

	var add_css_views_MYjuWId = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	MYjuWId(add_css_views_MYjuWId);

	var add_javascript_view_file_TCKWpDu = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	TCKWpDu(add_javascript_view_file_TCKWpDu);

	var add_javascript_views_file_itiIhBE = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	itiIhBE(add_javascript_views_file_itiIhBE);

	var add_javascript_view_footer_JIxXiCL = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	JIxXiCL(add_javascript_view_footer_JIxXiCL);

	var add_javascript_views_footer_lPmaHxv = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	lPmaHxv(add_javascript_views_footer_lPmaHxv);

	var add_php_ajax_CuvRiKz = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	CuvRiKz(add_php_ajax_CuvRiKz);

	var add_php_getitem_rthVyur = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	rthVyur(add_php_getitem_rthVyur);

	var add_php_getitems_MQfZTOw = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	MQfZTOw(add_php_getitems_MQfZTOw);

	var add_php_getlistquery_wHrYsuC = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	wHrYsuC(add_php_getlistquery_wHrYsuC);

	var add_php_save_mFOBHhQ = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	mFOBHhQ(add_php_save_mFOBHhQ);

	var add_php_postsavehook_mWkrWei = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	mWkrWei(add_php_postsavehook_mWkrWei);

	var add_php_allowedit_lUNxViZ = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	lUNxViZ(add_php_allowedit_lUNxViZ);

	var add_php_batchcopy_QlXIHxK = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	QlXIHxK(add_php_batchcopy_QlXIHxK);

	var add_php_batchmove_SRVenQh = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	SRVenQh(add_php_batchmove_SRVenQh);

	var add_php_before_delete_xxwqczy = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	xxwqczy(add_php_before_delete_xxwqczy);

	var add_php_after_delete_nOCqpoO = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	nOCqpoO(add_php_after_delete_nOCqpoO);

	var add_sql_dIhaSuR = jQuery("#jform_add_sql input[type='radio']:checked").val();
	dIhaSuR(add_sql_dIhaSuR);

	var source_AlEdvMv = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_AlEdvMv = jQuery("#jform_add_sql input[type='radio']:checked").val();
	AlEdvMv(source_AlEdvMv,add_sql_AlEdvMv);

	var source_gEdsNQy = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_gEdsNQy = jQuery("#jform_add_sql input[type='radio']:checked").val();
	gEdsNQy(source_gEdsNQy,add_sql_gEdsNQy);
});

// the KMATzUT function
function KMATzUT(add_css_view_KMATzUT)
{
	// set the function logic
	if (add_css_view_KMATzUT == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_KMATzUTtWL_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_KMATzUTtWL_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_KMATzUTtWL_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_KMATzUTtWL_required = true;
		}
	}
}

// the MYjuWId function
function MYjuWId(add_css_views_MYjuWId)
{
	// set the function logic
	if (add_css_views_MYjuWId == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_MYjuWIduYa_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_MYjuWIduYa_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_MYjuWIduYa_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_MYjuWIduYa_required = true;
		}
	}
}

// the TCKWpDu function
function TCKWpDu(add_javascript_view_file_TCKWpDu)
{
	// set the function logic
	if (add_javascript_view_file_TCKWpDu == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_TCKWpDuOFC_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_TCKWpDuOFC_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_TCKWpDuOFC_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_TCKWpDuOFC_required = true;
		}
	}
}

// the itiIhBE function
function itiIhBE(add_javascript_views_file_itiIhBE)
{
	// set the function logic
	if (add_javascript_views_file_itiIhBE == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_itiIhBEdbG_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_itiIhBEdbG_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_itiIhBEdbG_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_itiIhBEdbG_required = true;
		}
	}
}

// the JIxXiCL function
function JIxXiCL(add_javascript_view_footer_JIxXiCL)
{
	// set the function logic
	if (add_javascript_view_footer_JIxXiCL == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_JIxXiCLpUE_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_JIxXiCLpUE_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_JIxXiCLpUE_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_JIxXiCLpUE_required = true;
		}
	}
}

// the lPmaHxv function
function lPmaHxv(add_javascript_views_footer_lPmaHxv)
{
	// set the function logic
	if (add_javascript_views_footer_lPmaHxv == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_lPmaHxvhnh_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_lPmaHxvhnh_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_lPmaHxvhnh_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_lPmaHxvhnh_required = true;
		}
	}
}

// the CuvRiKz function
function CuvRiKz(add_php_ajax_CuvRiKz)
{
	// set the function logic
	if (add_php_ajax_CuvRiKz == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_CuvRiKzRHu_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_CuvRiKzRHu_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_CuvRiKzRHu_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_CuvRiKzRHu_required = true;
		}
	}
}

// the rthVyur function
function rthVyur(add_php_getitem_rthVyur)
{
	// set the function logic
	if (add_php_getitem_rthVyur == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_rthVyurdHn_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_rthVyurdHn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_rthVyurdHn_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_rthVyurdHn_required = true;
		}
	}
}

// the MQfZTOw function
function MQfZTOw(add_php_getitems_MQfZTOw)
{
	// set the function logic
	if (add_php_getitems_MQfZTOw == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_MQfZTOwwXR_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_MQfZTOwwXR_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_MQfZTOwwXR_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_MQfZTOwwXR_required = true;
		}
	}
}

// the wHrYsuC function
function wHrYsuC(add_php_getlistquery_wHrYsuC)
{
	// set the function logic
	if (add_php_getlistquery_wHrYsuC == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_wHrYsuCQrn_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_wHrYsuCQrn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_wHrYsuCQrn_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_wHrYsuCQrn_required = true;
		}
	}
}

// the mFOBHhQ function
function mFOBHhQ(add_php_save_mFOBHhQ)
{
	// set the function logic
	if (add_php_save_mFOBHhQ == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_mFOBHhQZoq_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_mFOBHhQZoq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_mFOBHhQZoq_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_mFOBHhQZoq_required = true;
		}
	}
}

// the mWkrWei function
function mWkrWei(add_php_postsavehook_mWkrWei)
{
	// set the function logic
	if (add_php_postsavehook_mWkrWei == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_mWkrWeiAzi_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_mWkrWeiAzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_mWkrWeiAzi_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_mWkrWeiAzi_required = true;
		}
	}
}

// the lUNxViZ function
function lUNxViZ(add_php_allowedit_lUNxViZ)
{
	// set the function logic
	if (add_php_allowedit_lUNxViZ == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_lUNxViZEYm_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_lUNxViZEYm_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_lUNxViZEYm_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_lUNxViZEYm_required = true;
		}
	}
}

// the QlXIHxK function
function QlXIHxK(add_php_batchcopy_QlXIHxK)
{
	// set the function logic
	if (add_php_batchcopy_QlXIHxK == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_QlXIHxKDwY_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_QlXIHxKDwY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_QlXIHxKDwY_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_QlXIHxKDwY_required = true;
		}
	}
}

// the SRVenQh function
function SRVenQh(add_php_batchmove_SRVenQh)
{
	// set the function logic
	if (add_php_batchmove_SRVenQh == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_SRVenQhqrA_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_SRVenQhqrA_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_SRVenQhqrA_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_SRVenQhqrA_required = true;
		}
	}
}

// the xxwqczy function
function xxwqczy(add_php_before_delete_xxwqczy)
{
	// set the function logic
	if (add_php_before_delete_xxwqczy == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_xxwqczycWx_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_xxwqczycWx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_xxwqczycWx_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_xxwqczycWx_required = true;
		}
	}
}

// the nOCqpoO function
function nOCqpoO(add_php_after_delete_nOCqpoO)
{
	// set the function logic
	if (add_php_after_delete_nOCqpoO == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_nOCqpoOfQn_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_nOCqpoOfQn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_nOCqpoOfQn_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_nOCqpoOfQn_required = true;
		}
	}
}

// the dIhaSuR function
function dIhaSuR(add_sql_dIhaSuR)
{
	// set the function logic
	if (add_sql_dIhaSuR == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_dIhaSuRZIh_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_dIhaSuRZIh_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_dIhaSuRZIh_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_dIhaSuRZIh_required = true;
		}
	}
}

// the AlEdvMv function
function AlEdvMv(source_AlEdvMv,add_sql_AlEdvMv)
{
	// set the function logic
	if (source_AlEdvMv == 2 && add_sql_AlEdvMv == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_AlEdvMvTNz_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_AlEdvMvTNz_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_AlEdvMvTNz_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_AlEdvMvTNz_required = true;
		}
	}
}

// the gEdsNQy function
function gEdsNQy(source_gEdsNQy,add_sql_gEdsNQy)
{
	// set the function logic
	if (source_gEdsNQy == 1 && add_sql_gEdsNQy == 1)
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
