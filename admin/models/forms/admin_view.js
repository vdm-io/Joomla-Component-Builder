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
	@build			20th February, 2016
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
jform_aASEiTHQRn_required = false;
jform_OWnFevaaQZ_required = false;
jform_IvKaMNyDSP_required = false;
jform_nTwfxyZkuQ_required = false;
jform_FeONESoKUc_required = false;
jform_EIyrCriaQc_required = false;
jform_PZWgdCMcHc_required = false;
jform_VpiFYNyiAz_required = false;
jform_lfbQvKdLLR_required = false;
jform_IuTLHWfmYR_required = false;
jform_uSdCybpdkL_required = false;
jform_wCOElqiuVQ_required = false;
jform_nJmcmSYyhX_required = false;
jform_kvPrXqtnBx_required = false;
jform_UXaEDlTFBR_required = false;
jform_wOtPSMKOfP_required = false;
jform_KumAJlXWur_required = false;
jform_CupCYRJSxp_required = false;
jform_LbggPZSCOX_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_aASEiTH = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	aASEiTH(add_css_view_aASEiTH);

	var add_css_views_OWnFeva = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	OWnFeva(add_css_views_OWnFeva);

	var add_javascript_view_file_IvKaMNy = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	IvKaMNy(add_javascript_view_file_IvKaMNy);

	var add_javascript_views_file_nTwfxyZ = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	nTwfxyZ(add_javascript_views_file_nTwfxyZ);

	var add_javascript_view_footer_FeONESo = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	FeONESo(add_javascript_view_footer_FeONESo);

	var add_javascript_views_footer_EIyrCri = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	EIyrCri(add_javascript_views_footer_EIyrCri);

	var add_php_ajax_PZWgdCM = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	PZWgdCM(add_php_ajax_PZWgdCM);

	var add_php_getitem_VpiFYNy = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	VpiFYNy(add_php_getitem_VpiFYNy);

	var add_php_getitems_lfbQvKd = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	lfbQvKd(add_php_getitems_lfbQvKd);

	var add_php_getlistquery_IuTLHWf = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	IuTLHWf(add_php_getlistquery_IuTLHWf);

	var add_php_save_uSdCybp = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	uSdCybp(add_php_save_uSdCybp);

	var add_php_postsavehook_wCOElqi = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	wCOElqi(add_php_postsavehook_wCOElqi);

	var add_php_allowedit_nJmcmSY = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	nJmcmSY(add_php_allowedit_nJmcmSY);

	var add_php_batchcopy_kvPrXqt = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	kvPrXqt(add_php_batchcopy_kvPrXqt);

	var add_php_batchmove_UXaEDlT = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	UXaEDlT(add_php_batchmove_UXaEDlT);

	var add_php_before_delete_wOtPSMK = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	wOtPSMK(add_php_before_delete_wOtPSMK);

	var add_php_after_delete_KumAJlX = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	KumAJlX(add_php_after_delete_KumAJlX);

	var add_sql_CupCYRJ = jQuery("#jform_add_sql input[type='radio']:checked").val();
	CupCYRJ(add_sql_CupCYRJ);

	var source_LbggPZS = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_LbggPZS = jQuery("#jform_add_sql input[type='radio']:checked").val();
	LbggPZS(source_LbggPZS,add_sql_LbggPZS);

	var source_eRrvtIS = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_eRrvtIS = jQuery("#jform_add_sql input[type='radio']:checked").val();
	eRrvtIS(source_eRrvtIS,add_sql_eRrvtIS);
});

// the aASEiTH function
function aASEiTH(add_css_view_aASEiTH)
{
	// set the function logic
	if (add_css_view_aASEiTH == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_aASEiTHQRn_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_aASEiTHQRn_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_aASEiTHQRn_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_aASEiTHQRn_required = true;
		}
	}
}

// the OWnFeva function
function OWnFeva(add_css_views_OWnFeva)
{
	// set the function logic
	if (add_css_views_OWnFeva == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_OWnFevaaQZ_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_OWnFevaaQZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_OWnFevaaQZ_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_OWnFevaaQZ_required = true;
		}
	}
}

// the IvKaMNy function
function IvKaMNy(add_javascript_view_file_IvKaMNy)
{
	// set the function logic
	if (add_javascript_view_file_IvKaMNy == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_IvKaMNyDSP_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_IvKaMNyDSP_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_IvKaMNyDSP_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_IvKaMNyDSP_required = true;
		}
	}
}

// the nTwfxyZ function
function nTwfxyZ(add_javascript_views_file_nTwfxyZ)
{
	// set the function logic
	if (add_javascript_views_file_nTwfxyZ == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_nTwfxyZkuQ_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_nTwfxyZkuQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_nTwfxyZkuQ_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_nTwfxyZkuQ_required = true;
		}
	}
}

// the FeONESo function
function FeONESo(add_javascript_view_footer_FeONESo)
{
	// set the function logic
	if (add_javascript_view_footer_FeONESo == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_FeONESoKUc_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_FeONESoKUc_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_FeONESoKUc_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_FeONESoKUc_required = true;
		}
	}
}

// the EIyrCri function
function EIyrCri(add_javascript_views_footer_EIyrCri)
{
	// set the function logic
	if (add_javascript_views_footer_EIyrCri == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_EIyrCriaQc_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_EIyrCriaQc_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_EIyrCriaQc_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_EIyrCriaQc_required = true;
		}
	}
}

// the PZWgdCM function
function PZWgdCM(add_php_ajax_PZWgdCM)
{
	// set the function logic
	if (add_php_ajax_PZWgdCM == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_PZWgdCMcHc_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_PZWgdCMcHc_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_PZWgdCMcHc_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_PZWgdCMcHc_required = true;
		}
	}
}

// the VpiFYNy function
function VpiFYNy(add_php_getitem_VpiFYNy)
{
	// set the function logic
	if (add_php_getitem_VpiFYNy == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_VpiFYNyiAz_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_VpiFYNyiAz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_VpiFYNyiAz_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_VpiFYNyiAz_required = true;
		}
	}
}

// the lfbQvKd function
function lfbQvKd(add_php_getitems_lfbQvKd)
{
	// set the function logic
	if (add_php_getitems_lfbQvKd == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_lfbQvKdLLR_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_lfbQvKdLLR_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_lfbQvKdLLR_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_lfbQvKdLLR_required = true;
		}
	}
}

// the IuTLHWf function
function IuTLHWf(add_php_getlistquery_IuTLHWf)
{
	// set the function logic
	if (add_php_getlistquery_IuTLHWf == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_IuTLHWfmYR_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_IuTLHWfmYR_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_IuTLHWfmYR_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_IuTLHWfmYR_required = true;
		}
	}
}

// the uSdCybp function
function uSdCybp(add_php_save_uSdCybp)
{
	// set the function logic
	if (add_php_save_uSdCybp == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_uSdCybpdkL_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_uSdCybpdkL_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_uSdCybpdkL_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_uSdCybpdkL_required = true;
		}
	}
}

// the wCOElqi function
function wCOElqi(add_php_postsavehook_wCOElqi)
{
	// set the function logic
	if (add_php_postsavehook_wCOElqi == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_wCOElqiuVQ_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_wCOElqiuVQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_wCOElqiuVQ_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_wCOElqiuVQ_required = true;
		}
	}
}

// the nJmcmSY function
function nJmcmSY(add_php_allowedit_nJmcmSY)
{
	// set the function logic
	if (add_php_allowedit_nJmcmSY == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_nJmcmSYyhX_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_nJmcmSYyhX_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_nJmcmSYyhX_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_nJmcmSYyhX_required = true;
		}
	}
}

// the kvPrXqt function
function kvPrXqt(add_php_batchcopy_kvPrXqt)
{
	// set the function logic
	if (add_php_batchcopy_kvPrXqt == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_kvPrXqtnBx_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_kvPrXqtnBx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_kvPrXqtnBx_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_kvPrXqtnBx_required = true;
		}
	}
}

// the UXaEDlT function
function UXaEDlT(add_php_batchmove_UXaEDlT)
{
	// set the function logic
	if (add_php_batchmove_UXaEDlT == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_UXaEDlTFBR_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_UXaEDlTFBR_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_UXaEDlTFBR_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_UXaEDlTFBR_required = true;
		}
	}
}

// the wOtPSMK function
function wOtPSMK(add_php_before_delete_wOtPSMK)
{
	// set the function logic
	if (add_php_before_delete_wOtPSMK == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_wOtPSMKOfP_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_wOtPSMKOfP_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_wOtPSMKOfP_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_wOtPSMKOfP_required = true;
		}
	}
}

// the KumAJlX function
function KumAJlX(add_php_after_delete_KumAJlX)
{
	// set the function logic
	if (add_php_after_delete_KumAJlX == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_KumAJlXWur_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_KumAJlXWur_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_KumAJlXWur_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_KumAJlXWur_required = true;
		}
	}
}

// the CupCYRJ function
function CupCYRJ(add_sql_CupCYRJ)
{
	// set the function logic
	if (add_sql_CupCYRJ == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_CupCYRJSxp_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_CupCYRJSxp_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_CupCYRJSxp_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_CupCYRJSxp_required = true;
		}
	}
}

// the LbggPZS function
function LbggPZS(source_LbggPZS,add_sql_LbggPZS)
{
	// set the function logic
	if (source_LbggPZS == 2 && add_sql_LbggPZS == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_LbggPZSCOX_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_LbggPZSCOX_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_LbggPZSCOX_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_LbggPZSCOX_required = true;
		}
	}
}

// the eRrvtIS function
function eRrvtIS(source_eRrvtIS,add_sql_eRrvtIS)
{
	// set the function logic
	if (source_eRrvtIS == 1 && add_sql_eRrvtIS == 1)
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
