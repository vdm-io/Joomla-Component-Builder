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
	@build			26th February, 2016
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
jform_olEnATZGJJ_required = false;
jform_rZwwVZXmMJ_required = false;
jform_TceEjdOgrQ_required = false;
jform_MBcuWCpVjY_required = false;
jform_KyXacUaaiI_required = false;
jform_EZNHJZQqek_required = false;
jform_kOOohMMwCT_required = false;
jform_urzsmvisCn_required = false;
jform_bhtOPXQIuT_required = false;
jform_QEGHNPmukV_required = false;
jform_sDiMRCkZOL_required = false;
jform_nPPEHIIqjW_required = false;
jform_mZvYGoQRFY_required = false;
jform_PYvXLtzUsi_required = false;
jform_xCXtlFVRWh_required = false;
jform_QkgqkLCYFh_required = false;
jform_XngtmPJHFc_required = false;
jform_UjFSwVrAPn_required = false;
jform_FzELQMpsGT_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_olEnATZ = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	olEnATZ(add_css_view_olEnATZ);

	var add_css_views_rZwwVZX = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	rZwwVZX(add_css_views_rZwwVZX);

	var add_javascript_view_file_TceEjdO = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	TceEjdO(add_javascript_view_file_TceEjdO);

	var add_javascript_views_file_MBcuWCp = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	MBcuWCp(add_javascript_views_file_MBcuWCp);

	var add_javascript_view_footer_KyXacUa = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	KyXacUa(add_javascript_view_footer_KyXacUa);

	var add_javascript_views_footer_EZNHJZQ = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	EZNHJZQ(add_javascript_views_footer_EZNHJZQ);

	var add_php_ajax_kOOohMM = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	kOOohMM(add_php_ajax_kOOohMM);

	var add_php_getitem_urzsmvi = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	urzsmvi(add_php_getitem_urzsmvi);

	var add_php_getitems_bhtOPXQ = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	bhtOPXQ(add_php_getitems_bhtOPXQ);

	var add_php_getlistquery_QEGHNPm = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	QEGHNPm(add_php_getlistquery_QEGHNPm);

	var add_php_save_sDiMRCk = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	sDiMRCk(add_php_save_sDiMRCk);

	var add_php_postsavehook_nPPEHII = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	nPPEHII(add_php_postsavehook_nPPEHII);

	var add_php_allowedit_mZvYGoQ = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	mZvYGoQ(add_php_allowedit_mZvYGoQ);

	var add_php_batchcopy_PYvXLtz = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	PYvXLtz(add_php_batchcopy_PYvXLtz);

	var add_php_batchmove_xCXtlFV = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	xCXtlFV(add_php_batchmove_xCXtlFV);

	var add_php_before_delete_QkgqkLC = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	QkgqkLC(add_php_before_delete_QkgqkLC);

	var add_php_after_delete_XngtmPJ = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	XngtmPJ(add_php_after_delete_XngtmPJ);

	var add_sql_UjFSwVr = jQuery("#jform_add_sql input[type='radio']:checked").val();
	UjFSwVr(add_sql_UjFSwVr);

	var source_FzELQMp = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_FzELQMp = jQuery("#jform_add_sql input[type='radio']:checked").val();
	FzELQMp(source_FzELQMp,add_sql_FzELQMp);

	var source_RnZUdkE = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_RnZUdkE = jQuery("#jform_add_sql input[type='radio']:checked").val();
	RnZUdkE(source_RnZUdkE,add_sql_RnZUdkE);
});

// the olEnATZ function
function olEnATZ(add_css_view_olEnATZ)
{
	// set the function logic
	if (add_css_view_olEnATZ == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_olEnATZGJJ_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_olEnATZGJJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_olEnATZGJJ_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_olEnATZGJJ_required = true;
		}
	}
}

// the rZwwVZX function
function rZwwVZX(add_css_views_rZwwVZX)
{
	// set the function logic
	if (add_css_views_rZwwVZX == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_rZwwVZXmMJ_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_rZwwVZXmMJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_rZwwVZXmMJ_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_rZwwVZXmMJ_required = true;
		}
	}
}

// the TceEjdO function
function TceEjdO(add_javascript_view_file_TceEjdO)
{
	// set the function logic
	if (add_javascript_view_file_TceEjdO == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_TceEjdOgrQ_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_TceEjdOgrQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_TceEjdOgrQ_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_TceEjdOgrQ_required = true;
		}
	}
}

// the MBcuWCp function
function MBcuWCp(add_javascript_views_file_MBcuWCp)
{
	// set the function logic
	if (add_javascript_views_file_MBcuWCp == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_MBcuWCpVjY_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_MBcuWCpVjY_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_MBcuWCpVjY_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_MBcuWCpVjY_required = true;
		}
	}
}

// the KyXacUa function
function KyXacUa(add_javascript_view_footer_KyXacUa)
{
	// set the function logic
	if (add_javascript_view_footer_KyXacUa == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_KyXacUaaiI_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_KyXacUaaiI_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_KyXacUaaiI_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_KyXacUaaiI_required = true;
		}
	}
}

// the EZNHJZQ function
function EZNHJZQ(add_javascript_views_footer_EZNHJZQ)
{
	// set the function logic
	if (add_javascript_views_footer_EZNHJZQ == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_EZNHJZQqek_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_EZNHJZQqek_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_EZNHJZQqek_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_EZNHJZQqek_required = true;
		}
	}
}

// the kOOohMM function
function kOOohMM(add_php_ajax_kOOohMM)
{
	// set the function logic
	if (add_php_ajax_kOOohMM == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_kOOohMMwCT_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_kOOohMMwCT_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_kOOohMMwCT_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_kOOohMMwCT_required = true;
		}
	}
}

// the urzsmvi function
function urzsmvi(add_php_getitem_urzsmvi)
{
	// set the function logic
	if (add_php_getitem_urzsmvi == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_urzsmvisCn_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_urzsmvisCn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_urzsmvisCn_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_urzsmvisCn_required = true;
		}
	}
}

// the bhtOPXQ function
function bhtOPXQ(add_php_getitems_bhtOPXQ)
{
	// set the function logic
	if (add_php_getitems_bhtOPXQ == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_bhtOPXQIuT_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_bhtOPXQIuT_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_bhtOPXQIuT_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_bhtOPXQIuT_required = true;
		}
	}
}

// the QEGHNPm function
function QEGHNPm(add_php_getlistquery_QEGHNPm)
{
	// set the function logic
	if (add_php_getlistquery_QEGHNPm == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_QEGHNPmukV_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_QEGHNPmukV_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_QEGHNPmukV_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_QEGHNPmukV_required = true;
		}
	}
}

// the sDiMRCk function
function sDiMRCk(add_php_save_sDiMRCk)
{
	// set the function logic
	if (add_php_save_sDiMRCk == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_sDiMRCkZOL_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_sDiMRCkZOL_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_sDiMRCkZOL_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_sDiMRCkZOL_required = true;
		}
	}
}

// the nPPEHII function
function nPPEHII(add_php_postsavehook_nPPEHII)
{
	// set the function logic
	if (add_php_postsavehook_nPPEHII == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_nPPEHIIqjW_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_nPPEHIIqjW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_nPPEHIIqjW_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_nPPEHIIqjW_required = true;
		}
	}
}

// the mZvYGoQ function
function mZvYGoQ(add_php_allowedit_mZvYGoQ)
{
	// set the function logic
	if (add_php_allowedit_mZvYGoQ == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_mZvYGoQRFY_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_mZvYGoQRFY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_mZvYGoQRFY_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_mZvYGoQRFY_required = true;
		}
	}
}

// the PYvXLtz function
function PYvXLtz(add_php_batchcopy_PYvXLtz)
{
	// set the function logic
	if (add_php_batchcopy_PYvXLtz == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_PYvXLtzUsi_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_PYvXLtzUsi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_PYvXLtzUsi_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_PYvXLtzUsi_required = true;
		}
	}
}

// the xCXtlFV function
function xCXtlFV(add_php_batchmove_xCXtlFV)
{
	// set the function logic
	if (add_php_batchmove_xCXtlFV == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_xCXtlFVRWh_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_xCXtlFVRWh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_xCXtlFVRWh_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_xCXtlFVRWh_required = true;
		}
	}
}

// the QkgqkLC function
function QkgqkLC(add_php_before_delete_QkgqkLC)
{
	// set the function logic
	if (add_php_before_delete_QkgqkLC == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_QkgqkLCYFh_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_QkgqkLCYFh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_QkgqkLCYFh_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_QkgqkLCYFh_required = true;
		}
	}
}

// the XngtmPJ function
function XngtmPJ(add_php_after_delete_XngtmPJ)
{
	// set the function logic
	if (add_php_after_delete_XngtmPJ == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_XngtmPJHFc_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_XngtmPJHFc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_XngtmPJHFc_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_XngtmPJHFc_required = true;
		}
	}
}

// the UjFSwVr function
function UjFSwVr(add_sql_UjFSwVr)
{
	// set the function logic
	if (add_sql_UjFSwVr == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_UjFSwVrAPn_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_UjFSwVrAPn_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_UjFSwVrAPn_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_UjFSwVrAPn_required = true;
		}
	}
}

// the FzELQMp function
function FzELQMp(source_FzELQMp,add_sql_FzELQMp)
{
	// set the function logic
	if (source_FzELQMp == 2 && add_sql_FzELQMp == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_FzELQMpsGT_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_FzELQMpsGT_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_FzELQMpsGT_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_FzELQMpsGT_required = true;
		}
	}
}

// the RnZUdkE function
function RnZUdkE(source_RnZUdkE,add_sql_RnZUdkE)
{
	// set the function logic
	if (source_RnZUdkE == 1 && add_sql_RnZUdkE == 1)
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
