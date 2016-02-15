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

	@version		2.0.9
	@build			15th February, 2016
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
jform_uMjrcWnNVv_required = false;
jform_SmEDllwKnM_required = false;
jform_QwkGzbbeVr_required = false;
jform_muYtJbqcOq_required = false;
jform_EKydgRtLuE_required = false;
jform_pqUGWBIYDw_required = false;
jform_qOQklAlIJc_required = false;
jform_ThHzoTkFwL_required = false;
jform_dUVWuTycSV_required = false;
jform_ydLrtUYzEB_required = false;
jform_JqOuNZjZxM_required = false;
jform_FIAHFbuWdr_required = false;
jform_PJqDbHAalX_required = false;
jform_ITuqphwteT_required = false;
jform_iPDIqbNRXP_required = false;
jform_eNBCsCkNvu_required = false;
jform_HfobuziPZl_required = false;
jform_HfcnTskApi_required = false;
jform_soYRPluZaO_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_uMjrcWn = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	uMjrcWn(add_css_view_uMjrcWn);

	var add_css_views_SmEDllw = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	SmEDllw(add_css_views_SmEDllw);

	var add_javascript_view_file_QwkGzbb = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	QwkGzbb(add_javascript_view_file_QwkGzbb);

	var add_javascript_views_file_muYtJbq = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	muYtJbq(add_javascript_views_file_muYtJbq);

	var add_javascript_view_footer_EKydgRt = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	EKydgRt(add_javascript_view_footer_EKydgRt);

	var add_javascript_views_footer_pqUGWBI = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	pqUGWBI(add_javascript_views_footer_pqUGWBI);

	var add_php_ajax_qOQklAl = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	qOQklAl(add_php_ajax_qOQklAl);

	var add_php_getitem_ThHzoTk = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	ThHzoTk(add_php_getitem_ThHzoTk);

	var add_php_getitems_dUVWuTy = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	dUVWuTy(add_php_getitems_dUVWuTy);

	var add_php_getlistquery_ydLrtUY = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	ydLrtUY(add_php_getlistquery_ydLrtUY);

	var add_php_save_JqOuNZj = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	JqOuNZj(add_php_save_JqOuNZj);

	var add_php_postsavehook_FIAHFbu = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	FIAHFbu(add_php_postsavehook_FIAHFbu);

	var add_php_allowedit_PJqDbHA = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	PJqDbHA(add_php_allowedit_PJqDbHA);

	var add_php_batchcopy_ITuqphw = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	ITuqphw(add_php_batchcopy_ITuqphw);

	var add_php_batchmove_iPDIqbN = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	iPDIqbN(add_php_batchmove_iPDIqbN);

	var add_php_before_delete_eNBCsCk = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	eNBCsCk(add_php_before_delete_eNBCsCk);

	var add_php_after_delete_Hfobuzi = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	Hfobuzi(add_php_after_delete_Hfobuzi);

	var add_sql_HfcnTsk = jQuery("#jform_add_sql input[type='radio']:checked").val();
	HfcnTsk(add_sql_HfcnTsk);

	var source_soYRPlu = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_soYRPlu = jQuery("#jform_add_sql input[type='radio']:checked").val();
	soYRPlu(source_soYRPlu,add_sql_soYRPlu);

	var source_SgpgTDi = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_SgpgTDi = jQuery("#jform_add_sql input[type='radio']:checked").val();
	SgpgTDi(source_SgpgTDi,add_sql_SgpgTDi);
});

// the uMjrcWn function
function uMjrcWn(add_css_view_uMjrcWn)
{
	// set the function logic
	if (add_css_view_uMjrcWn == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_uMjrcWnNVv_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_uMjrcWnNVv_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_uMjrcWnNVv_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_uMjrcWnNVv_required = true;
		}
	}
}

// the SmEDllw function
function SmEDllw(add_css_views_SmEDllw)
{
	// set the function logic
	if (add_css_views_SmEDllw == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_SmEDllwKnM_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_SmEDllwKnM_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_SmEDllwKnM_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_SmEDllwKnM_required = true;
		}
	}
}

// the QwkGzbb function
function QwkGzbb(add_javascript_view_file_QwkGzbb)
{
	// set the function logic
	if (add_javascript_view_file_QwkGzbb == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_QwkGzbbeVr_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_QwkGzbbeVr_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_QwkGzbbeVr_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_QwkGzbbeVr_required = true;
		}
	}
}

// the muYtJbq function
function muYtJbq(add_javascript_views_file_muYtJbq)
{
	// set the function logic
	if (add_javascript_views_file_muYtJbq == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_muYtJbqcOq_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_muYtJbqcOq_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_muYtJbqcOq_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_muYtJbqcOq_required = true;
		}
	}
}

// the EKydgRt function
function EKydgRt(add_javascript_view_footer_EKydgRt)
{
	// set the function logic
	if (add_javascript_view_footer_EKydgRt == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_EKydgRtLuE_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_EKydgRtLuE_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_EKydgRtLuE_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_EKydgRtLuE_required = true;
		}
	}
}

// the pqUGWBI function
function pqUGWBI(add_javascript_views_footer_pqUGWBI)
{
	// set the function logic
	if (add_javascript_views_footer_pqUGWBI == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_pqUGWBIYDw_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_pqUGWBIYDw_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_pqUGWBIYDw_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_pqUGWBIYDw_required = true;
		}
	}
}

// the qOQklAl function
function qOQklAl(add_php_ajax_qOQklAl)
{
	// set the function logic
	if (add_php_ajax_qOQklAl == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_qOQklAlIJc_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_qOQklAlIJc_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_qOQklAlIJc_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_qOQklAlIJc_required = true;
		}
	}
}

// the ThHzoTk function
function ThHzoTk(add_php_getitem_ThHzoTk)
{
	// set the function logic
	if (add_php_getitem_ThHzoTk == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_ThHzoTkFwL_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_ThHzoTkFwL_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_ThHzoTkFwL_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_ThHzoTkFwL_required = true;
		}
	}
}

// the dUVWuTy function
function dUVWuTy(add_php_getitems_dUVWuTy)
{
	// set the function logic
	if (add_php_getitems_dUVWuTy == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_dUVWuTycSV_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_dUVWuTycSV_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_dUVWuTycSV_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_dUVWuTycSV_required = true;
		}
	}
}

// the ydLrtUY function
function ydLrtUY(add_php_getlistquery_ydLrtUY)
{
	// set the function logic
	if (add_php_getlistquery_ydLrtUY == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_ydLrtUYzEB_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_ydLrtUYzEB_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_ydLrtUYzEB_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_ydLrtUYzEB_required = true;
		}
	}
}

// the JqOuNZj function
function JqOuNZj(add_php_save_JqOuNZj)
{
	// set the function logic
	if (add_php_save_JqOuNZj == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_JqOuNZjZxM_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_JqOuNZjZxM_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_JqOuNZjZxM_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_JqOuNZjZxM_required = true;
		}
	}
}

// the FIAHFbu function
function FIAHFbu(add_php_postsavehook_FIAHFbu)
{
	// set the function logic
	if (add_php_postsavehook_FIAHFbu == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_FIAHFbuWdr_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_FIAHFbuWdr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_FIAHFbuWdr_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_FIAHFbuWdr_required = true;
		}
	}
}

// the PJqDbHA function
function PJqDbHA(add_php_allowedit_PJqDbHA)
{
	// set the function logic
	if (add_php_allowedit_PJqDbHA == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_PJqDbHAalX_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_PJqDbHAalX_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_PJqDbHAalX_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_PJqDbHAalX_required = true;
		}
	}
}

// the ITuqphw function
function ITuqphw(add_php_batchcopy_ITuqphw)
{
	// set the function logic
	if (add_php_batchcopy_ITuqphw == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_ITuqphwteT_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_ITuqphwteT_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_ITuqphwteT_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_ITuqphwteT_required = true;
		}
	}
}

// the iPDIqbN function
function iPDIqbN(add_php_batchmove_iPDIqbN)
{
	// set the function logic
	if (add_php_batchmove_iPDIqbN == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_iPDIqbNRXP_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_iPDIqbNRXP_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_iPDIqbNRXP_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_iPDIqbNRXP_required = true;
		}
	}
}

// the eNBCsCk function
function eNBCsCk(add_php_before_delete_eNBCsCk)
{
	// set the function logic
	if (add_php_before_delete_eNBCsCk == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_eNBCsCkNvu_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_eNBCsCkNvu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_eNBCsCkNvu_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_eNBCsCkNvu_required = true;
		}
	}
}

// the Hfobuzi function
function Hfobuzi(add_php_after_delete_Hfobuzi)
{
	// set the function logic
	if (add_php_after_delete_Hfobuzi == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_HfobuziPZl_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_HfobuziPZl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_HfobuziPZl_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_HfobuziPZl_required = true;
		}
	}
}

// the HfcnTsk function
function HfcnTsk(add_sql_HfcnTsk)
{
	// set the function logic
	if (add_sql_HfcnTsk == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_HfcnTskApi_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_HfcnTskApi_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_HfcnTskApi_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_HfcnTskApi_required = true;
		}
	}
}

// the soYRPlu function
function soYRPlu(source_soYRPlu,add_sql_soYRPlu)
{
	// set the function logic
	if (source_soYRPlu == 2 && add_sql_soYRPlu == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_soYRPluZaO_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_soYRPluZaO_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_soYRPluZaO_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_soYRPluZaO_required = true;
		}
	}
}

// the SgpgTDi function
function SgpgTDi(source_SgpgTDi,add_sql_SgpgTDi)
{
	// set the function logic
	if (source_SgpgTDi == 1 && add_sql_SgpgTDi == 1)
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
