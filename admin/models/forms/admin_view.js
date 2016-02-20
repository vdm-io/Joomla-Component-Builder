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
jform_rQzycJDxsP_required = false;
jform_NVyUjxPKTz_required = false;
jform_tgVPzLIizq_required = false;
jform_dRcvpehNvz_required = false;
jform_FmmXiuCWgx_required = false;
jform_DxxstegWlF_required = false;
jform_jtxpPKpWDT_required = false;
jform_uchCardCki_required = false;
jform_THMxfbvkXM_required = false;
jform_VgczrTkOPL_required = false;
jform_CeJJNJbQol_required = false;
jform_adWJueOWmM_required = false;
jform_FkSMImyPct_required = false;
jform_vFtjrkXsah_required = false;
jform_KbpAOHFxKW_required = false;
jform_psfhZIrFDt_required = false;
jform_TYdsiDChUD_required = false;
jform_mGwyirlOOT_required = false;
jform_NcnSjiBzJg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_rQzycJD = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	rQzycJD(add_css_view_rQzycJD);

	var add_css_views_NVyUjxP = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	NVyUjxP(add_css_views_NVyUjxP);

	var add_javascript_view_file_tgVPzLI = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	tgVPzLI(add_javascript_view_file_tgVPzLI);

	var add_javascript_views_file_dRcvpeh = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	dRcvpeh(add_javascript_views_file_dRcvpeh);

	var add_javascript_view_footer_FmmXiuC = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	FmmXiuC(add_javascript_view_footer_FmmXiuC);

	var add_javascript_views_footer_Dxxsteg = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	Dxxsteg(add_javascript_views_footer_Dxxsteg);

	var add_php_ajax_jtxpPKp = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	jtxpPKp(add_php_ajax_jtxpPKp);

	var add_php_getitem_uchCard = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	uchCard(add_php_getitem_uchCard);

	var add_php_getitems_THMxfbv = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	THMxfbv(add_php_getitems_THMxfbv);

	var add_php_getlistquery_VgczrTk = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	VgczrTk(add_php_getlistquery_VgczrTk);

	var add_php_save_CeJJNJb = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	CeJJNJb(add_php_save_CeJJNJb);

	var add_php_postsavehook_adWJueO = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	adWJueO(add_php_postsavehook_adWJueO);

	var add_php_allowedit_FkSMImy = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	FkSMImy(add_php_allowedit_FkSMImy);

	var add_php_batchcopy_vFtjrkX = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	vFtjrkX(add_php_batchcopy_vFtjrkX);

	var add_php_batchmove_KbpAOHF = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	KbpAOHF(add_php_batchmove_KbpAOHF);

	var add_php_before_delete_psfhZIr = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	psfhZIr(add_php_before_delete_psfhZIr);

	var add_php_after_delete_TYdsiDC = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	TYdsiDC(add_php_after_delete_TYdsiDC);

	var add_sql_mGwyirl = jQuery("#jform_add_sql input[type='radio']:checked").val();
	mGwyirl(add_sql_mGwyirl);

	var source_NcnSjiB = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_NcnSjiB = jQuery("#jform_add_sql input[type='radio']:checked").val();
	NcnSjiB(source_NcnSjiB,add_sql_NcnSjiB);

	var source_qrDRMdq = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_qrDRMdq = jQuery("#jform_add_sql input[type='radio']:checked").val();
	qrDRMdq(source_qrDRMdq,add_sql_qrDRMdq);
});

// the rQzycJD function
function rQzycJD(add_css_view_rQzycJD)
{
	// set the function logic
	if (add_css_view_rQzycJD == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_rQzycJDxsP_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_rQzycJDxsP_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_rQzycJDxsP_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_rQzycJDxsP_required = true;
		}
	}
}

// the NVyUjxP function
function NVyUjxP(add_css_views_NVyUjxP)
{
	// set the function logic
	if (add_css_views_NVyUjxP == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_NVyUjxPKTz_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_NVyUjxPKTz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_NVyUjxPKTz_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_NVyUjxPKTz_required = true;
		}
	}
}

// the tgVPzLI function
function tgVPzLI(add_javascript_view_file_tgVPzLI)
{
	// set the function logic
	if (add_javascript_view_file_tgVPzLI == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_tgVPzLIizq_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_tgVPzLIizq_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_tgVPzLIizq_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_tgVPzLIizq_required = true;
		}
	}
}

// the dRcvpeh function
function dRcvpeh(add_javascript_views_file_dRcvpeh)
{
	// set the function logic
	if (add_javascript_views_file_dRcvpeh == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_dRcvpehNvz_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_dRcvpehNvz_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_dRcvpehNvz_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_dRcvpehNvz_required = true;
		}
	}
}

// the FmmXiuC function
function FmmXiuC(add_javascript_view_footer_FmmXiuC)
{
	// set the function logic
	if (add_javascript_view_footer_FmmXiuC == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_FmmXiuCWgx_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_FmmXiuCWgx_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_FmmXiuCWgx_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_FmmXiuCWgx_required = true;
		}
	}
}

// the Dxxsteg function
function Dxxsteg(add_javascript_views_footer_Dxxsteg)
{
	// set the function logic
	if (add_javascript_views_footer_Dxxsteg == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_DxxstegWlF_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_DxxstegWlF_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_DxxstegWlF_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_DxxstegWlF_required = true;
		}
	}
}

// the jtxpPKp function
function jtxpPKp(add_php_ajax_jtxpPKp)
{
	// set the function logic
	if (add_php_ajax_jtxpPKp == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_jtxpPKpWDT_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_jtxpPKpWDT_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_jtxpPKpWDT_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_jtxpPKpWDT_required = true;
		}
	}
}

// the uchCard function
function uchCard(add_php_getitem_uchCard)
{
	// set the function logic
	if (add_php_getitem_uchCard == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_uchCardCki_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_uchCardCki_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_uchCardCki_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_uchCardCki_required = true;
		}
	}
}

// the THMxfbv function
function THMxfbv(add_php_getitems_THMxfbv)
{
	// set the function logic
	if (add_php_getitems_THMxfbv == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_THMxfbvkXM_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_THMxfbvkXM_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_THMxfbvkXM_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_THMxfbvkXM_required = true;
		}
	}
}

// the VgczrTk function
function VgczrTk(add_php_getlistquery_VgczrTk)
{
	// set the function logic
	if (add_php_getlistquery_VgczrTk == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_VgczrTkOPL_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_VgczrTkOPL_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_VgczrTkOPL_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_VgczrTkOPL_required = true;
		}
	}
}

// the CeJJNJb function
function CeJJNJb(add_php_save_CeJJNJb)
{
	// set the function logic
	if (add_php_save_CeJJNJb == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_CeJJNJbQol_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_CeJJNJbQol_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_CeJJNJbQol_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_CeJJNJbQol_required = true;
		}
	}
}

// the adWJueO function
function adWJueO(add_php_postsavehook_adWJueO)
{
	// set the function logic
	if (add_php_postsavehook_adWJueO == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_adWJueOWmM_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_adWJueOWmM_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_adWJueOWmM_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_adWJueOWmM_required = true;
		}
	}
}

// the FkSMImy function
function FkSMImy(add_php_allowedit_FkSMImy)
{
	// set the function logic
	if (add_php_allowedit_FkSMImy == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_FkSMImyPct_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_FkSMImyPct_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_FkSMImyPct_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_FkSMImyPct_required = true;
		}
	}
}

// the vFtjrkX function
function vFtjrkX(add_php_batchcopy_vFtjrkX)
{
	// set the function logic
	if (add_php_batchcopy_vFtjrkX == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_vFtjrkXsah_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_vFtjrkXsah_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_vFtjrkXsah_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_vFtjrkXsah_required = true;
		}
	}
}

// the KbpAOHF function
function KbpAOHF(add_php_batchmove_KbpAOHF)
{
	// set the function logic
	if (add_php_batchmove_KbpAOHF == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_KbpAOHFxKW_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_KbpAOHFxKW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_KbpAOHFxKW_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_KbpAOHFxKW_required = true;
		}
	}
}

// the psfhZIr function
function psfhZIr(add_php_before_delete_psfhZIr)
{
	// set the function logic
	if (add_php_before_delete_psfhZIr == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_psfhZIrFDt_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_psfhZIrFDt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_psfhZIrFDt_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_psfhZIrFDt_required = true;
		}
	}
}

// the TYdsiDC function
function TYdsiDC(add_php_after_delete_TYdsiDC)
{
	// set the function logic
	if (add_php_after_delete_TYdsiDC == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_TYdsiDChUD_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_TYdsiDChUD_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_TYdsiDChUD_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_TYdsiDChUD_required = true;
		}
	}
}

// the mGwyirl function
function mGwyirl(add_sql_mGwyirl)
{
	// set the function logic
	if (add_sql_mGwyirl == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_mGwyirlOOT_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_mGwyirlOOT_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_mGwyirlOOT_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_mGwyirlOOT_required = true;
		}
	}
}

// the NcnSjiB function
function NcnSjiB(source_NcnSjiB,add_sql_NcnSjiB)
{
	// set the function logic
	if (source_NcnSjiB == 2 && add_sql_NcnSjiB == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_NcnSjiBzJg_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_NcnSjiBzJg_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_NcnSjiBzJg_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_NcnSjiBzJg_required = true;
		}
	}
}

// the qrDRMdq function
function qrDRMdq(source_qrDRMdq,add_sql_qrDRMdq)
{
	// set the function logic
	if (source_qrDRMdq == 1 && add_sql_qrDRMdq == 1)
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
