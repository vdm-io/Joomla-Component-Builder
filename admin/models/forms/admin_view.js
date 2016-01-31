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
	@build			31st January, 2016
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
jform_vXpHmsaUQj_required = false;
jform_rAcLjOXrHG_required = false;
jform_AsPSzKAJWc_required = false;
jform_ltZwgmViiI_required = false;
jform_pxjrnqihOU_required = false;
jform_IwhDjAgCod_required = false;
jform_FvDFaFWUPd_required = false;
jform_EhJPFRiJYX_required = false;
jform_IHsNnwqofA_required = false;
jform_AQdWCfIsaz_required = false;
jform_DEzevgWKQU_required = false;
jform_HBBVpPyBhx_required = false;
jform_iAurEQwfow_required = false;
jform_xMaePvkJhd_required = false;
jform_EMwlAJdZpp_required = false;
jform_wFPRRwLhvU_required = false;
jform_wbAxhrZofe_required = false;
jform_yOPUasFdra_required = false;
jform_oVyhOwwtwZ_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_vXpHmsa = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vXpHmsa(add_css_view_vXpHmsa);

	var add_css_views_rAcLjOX = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	rAcLjOX(add_css_views_rAcLjOX);

	var add_javascript_view_file_AsPSzKA = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	AsPSzKA(add_javascript_view_file_AsPSzKA);

	var add_javascript_views_file_ltZwgmV = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	ltZwgmV(add_javascript_views_file_ltZwgmV);

	var add_javascript_view_footer_pxjrnqi = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	pxjrnqi(add_javascript_view_footer_pxjrnqi);

	var add_javascript_views_footer_IwhDjAg = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	IwhDjAg(add_javascript_views_footer_IwhDjAg);

	var add_php_ajax_FvDFaFW = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	FvDFaFW(add_php_ajax_FvDFaFW);

	var add_php_getitem_EhJPFRi = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	EhJPFRi(add_php_getitem_EhJPFRi);

	var add_php_getitems_IHsNnwq = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	IHsNnwq(add_php_getitems_IHsNnwq);

	var add_php_getlistquery_AQdWCfI = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	AQdWCfI(add_php_getlistquery_AQdWCfI);

	var add_php_save_DEzevgW = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	DEzevgW(add_php_save_DEzevgW);

	var add_php_postsavehook_HBBVpPy = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	HBBVpPy(add_php_postsavehook_HBBVpPy);

	var add_php_allowedit_iAurEQw = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	iAurEQw(add_php_allowedit_iAurEQw);

	var add_php_batchcopy_xMaePvk = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	xMaePvk(add_php_batchcopy_xMaePvk);

	var add_php_batchmove_EMwlAJd = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	EMwlAJd(add_php_batchmove_EMwlAJd);

	var add_php_before_delete_wFPRRwL = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	wFPRRwL(add_php_before_delete_wFPRRwL);

	var add_php_after_delete_wbAxhrZ = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	wbAxhrZ(add_php_after_delete_wbAxhrZ);

	var add_sql_yOPUasF = jQuery("#jform_add_sql input[type='radio']:checked").val();
	yOPUasF(add_sql_yOPUasF);

	var source_oVyhOww = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_oVyhOww = jQuery("#jform_add_sql input[type='radio']:checked").val();
	oVyhOww(source_oVyhOww,add_sql_oVyhOww);

	var source_yvyLShD = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_yvyLShD = jQuery("#jform_add_sql input[type='radio']:checked").val();
	yvyLShD(source_yvyLShD,add_sql_yvyLShD);
});

// the vXpHmsa function
function vXpHmsa(add_css_view_vXpHmsa)
{
	// set the function logic
	if (add_css_view_vXpHmsa == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_vXpHmsaUQj_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_vXpHmsaUQj_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_vXpHmsaUQj_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_vXpHmsaUQj_required = true;
		}
	}
}

// the rAcLjOX function
function rAcLjOX(add_css_views_rAcLjOX)
{
	// set the function logic
	if (add_css_views_rAcLjOX == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_rAcLjOXrHG_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_rAcLjOXrHG_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_rAcLjOXrHG_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_rAcLjOXrHG_required = true;
		}
	}
}

// the AsPSzKA function
function AsPSzKA(add_javascript_view_file_AsPSzKA)
{
	// set the function logic
	if (add_javascript_view_file_AsPSzKA == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_AsPSzKAJWc_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_AsPSzKAJWc_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_AsPSzKAJWc_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_AsPSzKAJWc_required = true;
		}
	}
}

// the ltZwgmV function
function ltZwgmV(add_javascript_views_file_ltZwgmV)
{
	// set the function logic
	if (add_javascript_views_file_ltZwgmV == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_ltZwgmViiI_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_ltZwgmViiI_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_ltZwgmViiI_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_ltZwgmViiI_required = true;
		}
	}
}

// the pxjrnqi function
function pxjrnqi(add_javascript_view_footer_pxjrnqi)
{
	// set the function logic
	if (add_javascript_view_footer_pxjrnqi == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_pxjrnqihOU_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_pxjrnqihOU_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_pxjrnqihOU_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_pxjrnqihOU_required = true;
		}
	}
}

// the IwhDjAg function
function IwhDjAg(add_javascript_views_footer_IwhDjAg)
{
	// set the function logic
	if (add_javascript_views_footer_IwhDjAg == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_IwhDjAgCod_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_IwhDjAgCod_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_IwhDjAgCod_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_IwhDjAgCod_required = true;
		}
	}
}

// the FvDFaFW function
function FvDFaFW(add_php_ajax_FvDFaFW)
{
	// set the function logic
	if (add_php_ajax_FvDFaFW == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_FvDFaFWUPd_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_FvDFaFWUPd_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_FvDFaFWUPd_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_FvDFaFWUPd_required = true;
		}
	}
}

// the EhJPFRi function
function EhJPFRi(add_php_getitem_EhJPFRi)
{
	// set the function logic
	if (add_php_getitem_EhJPFRi == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_EhJPFRiJYX_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_EhJPFRiJYX_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_EhJPFRiJYX_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_EhJPFRiJYX_required = true;
		}
	}
}

// the IHsNnwq function
function IHsNnwq(add_php_getitems_IHsNnwq)
{
	// set the function logic
	if (add_php_getitems_IHsNnwq == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_IHsNnwqofA_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_IHsNnwqofA_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_IHsNnwqofA_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_IHsNnwqofA_required = true;
		}
	}
}

// the AQdWCfI function
function AQdWCfI(add_php_getlistquery_AQdWCfI)
{
	// set the function logic
	if (add_php_getlistquery_AQdWCfI == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_AQdWCfIsaz_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_AQdWCfIsaz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_AQdWCfIsaz_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_AQdWCfIsaz_required = true;
		}
	}
}

// the DEzevgW function
function DEzevgW(add_php_save_DEzevgW)
{
	// set the function logic
	if (add_php_save_DEzevgW == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_DEzevgWKQU_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_DEzevgWKQU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_DEzevgWKQU_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_DEzevgWKQU_required = true;
		}
	}
}

// the HBBVpPy function
function HBBVpPy(add_php_postsavehook_HBBVpPy)
{
	// set the function logic
	if (add_php_postsavehook_HBBVpPy == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_HBBVpPyBhx_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_HBBVpPyBhx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_HBBVpPyBhx_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_HBBVpPyBhx_required = true;
		}
	}
}

// the iAurEQw function
function iAurEQw(add_php_allowedit_iAurEQw)
{
	// set the function logic
	if (add_php_allowedit_iAurEQw == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_iAurEQwfow_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_iAurEQwfow_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_iAurEQwfow_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_iAurEQwfow_required = true;
		}
	}
}

// the xMaePvk function
function xMaePvk(add_php_batchcopy_xMaePvk)
{
	// set the function logic
	if (add_php_batchcopy_xMaePvk == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_xMaePvkJhd_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_xMaePvkJhd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_xMaePvkJhd_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_xMaePvkJhd_required = true;
		}
	}
}

// the EMwlAJd function
function EMwlAJd(add_php_batchmove_EMwlAJd)
{
	// set the function logic
	if (add_php_batchmove_EMwlAJd == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_EMwlAJdZpp_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_EMwlAJdZpp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_EMwlAJdZpp_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_EMwlAJdZpp_required = true;
		}
	}
}

// the wFPRRwL function
function wFPRRwL(add_php_before_delete_wFPRRwL)
{
	// set the function logic
	if (add_php_before_delete_wFPRRwL == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_wFPRRwLhvU_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_wFPRRwLhvU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_wFPRRwLhvU_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_wFPRRwLhvU_required = true;
		}
	}
}

// the wbAxhrZ function
function wbAxhrZ(add_php_after_delete_wbAxhrZ)
{
	// set the function logic
	if (add_php_after_delete_wbAxhrZ == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_wbAxhrZofe_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_wbAxhrZofe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_wbAxhrZofe_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_wbAxhrZofe_required = true;
		}
	}
}

// the yOPUasF function
function yOPUasF(add_sql_yOPUasF)
{
	// set the function logic
	if (add_sql_yOPUasF == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_yOPUasFdra_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_yOPUasFdra_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_yOPUasFdra_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_yOPUasFdra_required = true;
		}
	}
}

// the oVyhOww function
function oVyhOww(source_oVyhOww,add_sql_oVyhOww)
{
	// set the function logic
	if (source_oVyhOww == 2 && add_sql_oVyhOww == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_oVyhOwwtwZ_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_oVyhOwwtwZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_oVyhOwwtwZ_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_oVyhOwwtwZ_required = true;
		}
	}
}

// the yvyLShD function
function yvyLShD(source_yvyLShD,add_sql_yvyLShD)
{
	// set the function logic
	if (source_yvyLShD == 1 && add_sql_yvyLShD == 1)
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
