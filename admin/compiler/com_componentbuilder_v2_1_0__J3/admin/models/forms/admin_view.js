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
jform_tKvLPytvkT_required = false;
jform_wgyuFZCBod_required = false;
jform_SHLEEpZeLY_required = false;
jform_EfCfOzxnTH_required = false;
jform_frTDIrvkRG_required = false;
jform_lLrWkRmjUX_required = false;
jform_kzcOMQnoZf_required = false;
jform_UdvPAikcqb_required = false;
jform_NJMbGWQRgJ_required = false;
jform_PnnReaLnoF_required = false;
jform_riOUVueert_required = false;
jform_fieRhKOZDW_required = false;
jform_NtqckpeSLr_required = false;
jform_DfzlXoBaAa_required = false;
jform_BzgEtthknF_required = false;
jform_jcZzgjNkZB_required = false;
jform_BwEUOvnxDK_required = false;
jform_qXoDvESLUi_required = false;
jform_ucntutCkDv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_tKvLPyt = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	tKvLPyt(add_css_view_tKvLPyt);

	var add_css_views_wgyuFZC = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	wgyuFZC(add_css_views_wgyuFZC);

	var add_javascript_view_file_SHLEEpZ = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	SHLEEpZ(add_javascript_view_file_SHLEEpZ);

	var add_javascript_views_file_EfCfOzx = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	EfCfOzx(add_javascript_views_file_EfCfOzx);

	var add_javascript_view_footer_frTDIrv = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	frTDIrv(add_javascript_view_footer_frTDIrv);

	var add_javascript_views_footer_lLrWkRm = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	lLrWkRm(add_javascript_views_footer_lLrWkRm);

	var add_php_ajax_kzcOMQn = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	kzcOMQn(add_php_ajax_kzcOMQn);

	var add_php_getitem_UdvPAik = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	UdvPAik(add_php_getitem_UdvPAik);

	var add_php_getitems_NJMbGWQ = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	NJMbGWQ(add_php_getitems_NJMbGWQ);

	var add_php_getlistquery_PnnReaL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	PnnReaL(add_php_getlistquery_PnnReaL);

	var add_php_save_riOUVue = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	riOUVue(add_php_save_riOUVue);

	var add_php_postsavehook_fieRhKO = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	fieRhKO(add_php_postsavehook_fieRhKO);

	var add_php_allowedit_Ntqckpe = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	Ntqckpe(add_php_allowedit_Ntqckpe);

	var add_php_batchcopy_DfzlXoB = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	DfzlXoB(add_php_batchcopy_DfzlXoB);

	var add_php_batchmove_BzgEtth = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	BzgEtth(add_php_batchmove_BzgEtth);

	var add_php_before_delete_jcZzgjN = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	jcZzgjN(add_php_before_delete_jcZzgjN);

	var add_php_after_delete_BwEUOvn = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	BwEUOvn(add_php_after_delete_BwEUOvn);

	var add_sql_qXoDvES = jQuery("#jform_add_sql input[type='radio']:checked").val();
	qXoDvES(add_sql_qXoDvES);

	var source_ucntutC = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_ucntutC = jQuery("#jform_add_sql input[type='radio']:checked").val();
	ucntutC(source_ucntutC,add_sql_ucntutC);

	var source_agkLvgV = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_agkLvgV = jQuery("#jform_add_sql input[type='radio']:checked").val();
	agkLvgV(source_agkLvgV,add_sql_agkLvgV);
});

// the tKvLPyt function
function tKvLPyt(add_css_view_tKvLPyt)
{
	// set the function logic
	if (add_css_view_tKvLPyt == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_tKvLPytvkT_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_tKvLPytvkT_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_tKvLPytvkT_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_tKvLPytvkT_required = true;
		}
	}
}

// the wgyuFZC function
function wgyuFZC(add_css_views_wgyuFZC)
{
	// set the function logic
	if (add_css_views_wgyuFZC == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_wgyuFZCBod_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_wgyuFZCBod_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_wgyuFZCBod_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_wgyuFZCBod_required = true;
		}
	}
}

// the SHLEEpZ function
function SHLEEpZ(add_javascript_view_file_SHLEEpZ)
{
	// set the function logic
	if (add_javascript_view_file_SHLEEpZ == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_SHLEEpZeLY_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_SHLEEpZeLY_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_SHLEEpZeLY_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_SHLEEpZeLY_required = true;
		}
	}
}

// the EfCfOzx function
function EfCfOzx(add_javascript_views_file_EfCfOzx)
{
	// set the function logic
	if (add_javascript_views_file_EfCfOzx == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_EfCfOzxnTH_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_EfCfOzxnTH_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_EfCfOzxnTH_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_EfCfOzxnTH_required = true;
		}
	}
}

// the frTDIrv function
function frTDIrv(add_javascript_view_footer_frTDIrv)
{
	// set the function logic
	if (add_javascript_view_footer_frTDIrv == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_frTDIrvkRG_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_frTDIrvkRG_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_frTDIrvkRG_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_frTDIrvkRG_required = true;
		}
	}
}

// the lLrWkRm function
function lLrWkRm(add_javascript_views_footer_lLrWkRm)
{
	// set the function logic
	if (add_javascript_views_footer_lLrWkRm == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_lLrWkRmjUX_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_lLrWkRmjUX_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_lLrWkRmjUX_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_lLrWkRmjUX_required = true;
		}
	}
}

// the kzcOMQn function
function kzcOMQn(add_php_ajax_kzcOMQn)
{
	// set the function logic
	if (add_php_ajax_kzcOMQn == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_kzcOMQnoZf_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_kzcOMQnoZf_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_kzcOMQnoZf_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_kzcOMQnoZf_required = true;
		}
	}
}

// the UdvPAik function
function UdvPAik(add_php_getitem_UdvPAik)
{
	// set the function logic
	if (add_php_getitem_UdvPAik == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_UdvPAikcqb_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_UdvPAikcqb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_UdvPAikcqb_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_UdvPAikcqb_required = true;
		}
	}
}

// the NJMbGWQ function
function NJMbGWQ(add_php_getitems_NJMbGWQ)
{
	// set the function logic
	if (add_php_getitems_NJMbGWQ == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_NJMbGWQRgJ_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_NJMbGWQRgJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_NJMbGWQRgJ_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_NJMbGWQRgJ_required = true;
		}
	}
}

// the PnnReaL function
function PnnReaL(add_php_getlistquery_PnnReaL)
{
	// set the function logic
	if (add_php_getlistquery_PnnReaL == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_PnnReaLnoF_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_PnnReaLnoF_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_PnnReaLnoF_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_PnnReaLnoF_required = true;
		}
	}
}

// the riOUVue function
function riOUVue(add_php_save_riOUVue)
{
	// set the function logic
	if (add_php_save_riOUVue == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_riOUVueert_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_riOUVueert_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_riOUVueert_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_riOUVueert_required = true;
		}
	}
}

// the fieRhKO function
function fieRhKO(add_php_postsavehook_fieRhKO)
{
	// set the function logic
	if (add_php_postsavehook_fieRhKO == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_fieRhKOZDW_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_fieRhKOZDW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_fieRhKOZDW_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_fieRhKOZDW_required = true;
		}
	}
}

// the Ntqckpe function
function Ntqckpe(add_php_allowedit_Ntqckpe)
{
	// set the function logic
	if (add_php_allowedit_Ntqckpe == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_NtqckpeSLr_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_NtqckpeSLr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_NtqckpeSLr_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_NtqckpeSLr_required = true;
		}
	}
}

// the DfzlXoB function
function DfzlXoB(add_php_batchcopy_DfzlXoB)
{
	// set the function logic
	if (add_php_batchcopy_DfzlXoB == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_DfzlXoBaAa_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_DfzlXoBaAa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_DfzlXoBaAa_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_DfzlXoBaAa_required = true;
		}
	}
}

// the BzgEtth function
function BzgEtth(add_php_batchmove_BzgEtth)
{
	// set the function logic
	if (add_php_batchmove_BzgEtth == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_BzgEtthknF_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_BzgEtthknF_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_BzgEtthknF_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_BzgEtthknF_required = true;
		}
	}
}

// the jcZzgjN function
function jcZzgjN(add_php_before_delete_jcZzgjN)
{
	// set the function logic
	if (add_php_before_delete_jcZzgjN == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_jcZzgjNkZB_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_jcZzgjNkZB_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_jcZzgjNkZB_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_jcZzgjNkZB_required = true;
		}
	}
}

// the BwEUOvn function
function BwEUOvn(add_php_after_delete_BwEUOvn)
{
	// set the function logic
	if (add_php_after_delete_BwEUOvn == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_BwEUOvnxDK_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_BwEUOvnxDK_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_BwEUOvnxDK_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_BwEUOvnxDK_required = true;
		}
	}
}

// the qXoDvES function
function qXoDvES(add_sql_qXoDvES)
{
	// set the function logic
	if (add_sql_qXoDvES == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_qXoDvESLUi_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_qXoDvESLUi_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_qXoDvESLUi_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_qXoDvESLUi_required = true;
		}
	}
}

// the ucntutC function
function ucntutC(source_ucntutC,add_sql_ucntutC)
{
	// set the function logic
	if (source_ucntutC == 2 && add_sql_ucntutC == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_ucntutCkDv_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_ucntutCkDv_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_ucntutCkDv_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_ucntutCkDv_required = true;
		}
	}
}

// the agkLvgV function
function agkLvgV(source_agkLvgV,add_sql_agkLvgV)
{
	// set the function logic
	if (source_agkLvgV == 1 && add_sql_agkLvgV == 1)
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
