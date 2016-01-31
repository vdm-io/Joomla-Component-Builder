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
jform_rYESdUBZnI_required = false;
jform_iNVlcQTEbb_required = false;
jform_kxOntxkHaQ_required = false;
jform_esPNqQLMSU_required = false;
jform_nZBopEedkd_required = false;
jform_hrvUMNrVxs_required = false;
jform_HvICoYsVLg_required = false;
jform_KZhpoxarvj_required = false;
jform_pAIRwnIOnZ_required = false;
jform_gTCPxLOLzC_required = false;
jform_PoBXLLtGXN_required = false;
jform_VtqvgVQKMa_required = false;
jform_NQVjJmTzXv_required = false;
jform_VNQpIvbbhY_required = false;
jform_PcmjyzgukQ_required = false;
jform_oVBqhpxaKv_required = false;
jform_vylrVYKVaV_required = false;
jform_SSYhcEAiTK_required = false;
jform_XnLGBPQZQu_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_rYESdUB = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	rYESdUB(add_css_view_rYESdUB);

	var add_css_views_iNVlcQT = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	iNVlcQT(add_css_views_iNVlcQT);

	var add_javascript_view_file_kxOntxk = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	kxOntxk(add_javascript_view_file_kxOntxk);

	var add_javascript_views_file_esPNqQL = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	esPNqQL(add_javascript_views_file_esPNqQL);

	var add_javascript_view_footer_nZBopEe = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	nZBopEe(add_javascript_view_footer_nZBopEe);

	var add_javascript_views_footer_hrvUMNr = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	hrvUMNr(add_javascript_views_footer_hrvUMNr);

	var add_php_ajax_HvICoYs = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	HvICoYs(add_php_ajax_HvICoYs);

	var add_php_getitem_KZhpoxa = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	KZhpoxa(add_php_getitem_KZhpoxa);

	var add_php_getitems_pAIRwnI = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	pAIRwnI(add_php_getitems_pAIRwnI);

	var add_php_getlistquery_gTCPxLO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	gTCPxLO(add_php_getlistquery_gTCPxLO);

	var add_php_save_PoBXLLt = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	PoBXLLt(add_php_save_PoBXLLt);

	var add_php_postsavehook_VtqvgVQ = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	VtqvgVQ(add_php_postsavehook_VtqvgVQ);

	var add_php_allowedit_NQVjJmT = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	NQVjJmT(add_php_allowedit_NQVjJmT);

	var add_php_batchcopy_VNQpIvb = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	VNQpIvb(add_php_batchcopy_VNQpIvb);

	var add_php_batchmove_Pcmjyzg = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	Pcmjyzg(add_php_batchmove_Pcmjyzg);

	var add_php_before_delete_oVBqhpx = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	oVBqhpx(add_php_before_delete_oVBqhpx);

	var add_php_after_delete_vylrVYK = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	vylrVYK(add_php_after_delete_vylrVYK);

	var add_sql_SSYhcEA = jQuery("#jform_add_sql input[type='radio']:checked").val();
	SSYhcEA(add_sql_SSYhcEA);

	var source_XnLGBPQ = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_XnLGBPQ = jQuery("#jform_add_sql input[type='radio']:checked").val();
	XnLGBPQ(source_XnLGBPQ,add_sql_XnLGBPQ);

	var source_sPMkLyn = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_sPMkLyn = jQuery("#jform_add_sql input[type='radio']:checked").val();
	sPMkLyn(source_sPMkLyn,add_sql_sPMkLyn);
});

// the rYESdUB function
function rYESdUB(add_css_view_rYESdUB)
{
	// set the function logic
	if (add_css_view_rYESdUB == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_rYESdUBZnI_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_rYESdUBZnI_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_rYESdUBZnI_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_rYESdUBZnI_required = true;
		}
	}
}

// the iNVlcQT function
function iNVlcQT(add_css_views_iNVlcQT)
{
	// set the function logic
	if (add_css_views_iNVlcQT == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_iNVlcQTEbb_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_iNVlcQTEbb_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_iNVlcQTEbb_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_iNVlcQTEbb_required = true;
		}
	}
}

// the kxOntxk function
function kxOntxk(add_javascript_view_file_kxOntxk)
{
	// set the function logic
	if (add_javascript_view_file_kxOntxk == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_kxOntxkHaQ_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_kxOntxkHaQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_kxOntxkHaQ_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_kxOntxkHaQ_required = true;
		}
	}
}

// the esPNqQL function
function esPNqQL(add_javascript_views_file_esPNqQL)
{
	// set the function logic
	if (add_javascript_views_file_esPNqQL == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_esPNqQLMSU_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_esPNqQLMSU_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_esPNqQLMSU_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_esPNqQLMSU_required = true;
		}
	}
}

// the nZBopEe function
function nZBopEe(add_javascript_view_footer_nZBopEe)
{
	// set the function logic
	if (add_javascript_view_footer_nZBopEe == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_nZBopEedkd_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_nZBopEedkd_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_nZBopEedkd_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_nZBopEedkd_required = true;
		}
	}
}

// the hrvUMNr function
function hrvUMNr(add_javascript_views_footer_hrvUMNr)
{
	// set the function logic
	if (add_javascript_views_footer_hrvUMNr == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_hrvUMNrVxs_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_hrvUMNrVxs_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_hrvUMNrVxs_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_hrvUMNrVxs_required = true;
		}
	}
}

// the HvICoYs function
function HvICoYs(add_php_ajax_HvICoYs)
{
	// set the function logic
	if (add_php_ajax_HvICoYs == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_HvICoYsVLg_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_HvICoYsVLg_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_HvICoYsVLg_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_HvICoYsVLg_required = true;
		}
	}
}

// the KZhpoxa function
function KZhpoxa(add_php_getitem_KZhpoxa)
{
	// set the function logic
	if (add_php_getitem_KZhpoxa == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_KZhpoxarvj_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_KZhpoxarvj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_KZhpoxarvj_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_KZhpoxarvj_required = true;
		}
	}
}

// the pAIRwnI function
function pAIRwnI(add_php_getitems_pAIRwnI)
{
	// set the function logic
	if (add_php_getitems_pAIRwnI == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_pAIRwnIOnZ_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_pAIRwnIOnZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_pAIRwnIOnZ_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_pAIRwnIOnZ_required = true;
		}
	}
}

// the gTCPxLO function
function gTCPxLO(add_php_getlistquery_gTCPxLO)
{
	// set the function logic
	if (add_php_getlistquery_gTCPxLO == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_gTCPxLOLzC_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_gTCPxLOLzC_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_gTCPxLOLzC_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_gTCPxLOLzC_required = true;
		}
	}
}

// the PoBXLLt function
function PoBXLLt(add_php_save_PoBXLLt)
{
	// set the function logic
	if (add_php_save_PoBXLLt == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_PoBXLLtGXN_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_PoBXLLtGXN_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_PoBXLLtGXN_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_PoBXLLtGXN_required = true;
		}
	}
}

// the VtqvgVQ function
function VtqvgVQ(add_php_postsavehook_VtqvgVQ)
{
	// set the function logic
	if (add_php_postsavehook_VtqvgVQ == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_VtqvgVQKMa_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_VtqvgVQKMa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_VtqvgVQKMa_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_VtqvgVQKMa_required = true;
		}
	}
}

// the NQVjJmT function
function NQVjJmT(add_php_allowedit_NQVjJmT)
{
	// set the function logic
	if (add_php_allowedit_NQVjJmT == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_NQVjJmTzXv_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_NQVjJmTzXv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_NQVjJmTzXv_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_NQVjJmTzXv_required = true;
		}
	}
}

// the VNQpIvb function
function VNQpIvb(add_php_batchcopy_VNQpIvb)
{
	// set the function logic
	if (add_php_batchcopy_VNQpIvb == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_VNQpIvbbhY_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_VNQpIvbbhY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_VNQpIvbbhY_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_VNQpIvbbhY_required = true;
		}
	}
}

// the Pcmjyzg function
function Pcmjyzg(add_php_batchmove_Pcmjyzg)
{
	// set the function logic
	if (add_php_batchmove_Pcmjyzg == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_PcmjyzgukQ_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_PcmjyzgukQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_PcmjyzgukQ_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_PcmjyzgukQ_required = true;
		}
	}
}

// the oVBqhpx function
function oVBqhpx(add_php_before_delete_oVBqhpx)
{
	// set the function logic
	if (add_php_before_delete_oVBqhpx == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_oVBqhpxaKv_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_oVBqhpxaKv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_oVBqhpxaKv_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_oVBqhpxaKv_required = true;
		}
	}
}

// the vylrVYK function
function vylrVYK(add_php_after_delete_vylrVYK)
{
	// set the function logic
	if (add_php_after_delete_vylrVYK == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_vylrVYKVaV_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_vylrVYKVaV_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_vylrVYKVaV_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_vylrVYKVaV_required = true;
		}
	}
}

// the SSYhcEA function
function SSYhcEA(add_sql_SSYhcEA)
{
	// set the function logic
	if (add_sql_SSYhcEA == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_SSYhcEAiTK_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_SSYhcEAiTK_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_SSYhcEAiTK_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_SSYhcEAiTK_required = true;
		}
	}
}

// the XnLGBPQ function
function XnLGBPQ(source_XnLGBPQ,add_sql_XnLGBPQ)
{
	// set the function logic
	if (source_XnLGBPQ == 2 && add_sql_XnLGBPQ == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_XnLGBPQZQu_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_XnLGBPQZQu_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_XnLGBPQZQu_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_XnLGBPQZQu_required = true;
		}
	}
}

// the sPMkLyn function
function sPMkLyn(source_sPMkLyn,add_sql_sPMkLyn)
{
	// set the function logic
	if (source_sPMkLyn == 1 && add_sql_sPMkLyn == 1)
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
