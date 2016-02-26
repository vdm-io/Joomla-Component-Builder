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
jform_EQnxXbVtkr_required = false;
jform_CHsmoNXHCz_required = false;
jform_GiQeINOPXr_required = false;
jform_gHdtYboSvF_required = false;
jform_jXgAkqpjdQ_required = false;
jform_JEaFHNtvFm_required = false;
jform_NLSTYSVsMw_required = false;
jform_TVsaCxqQGB_required = false;
jform_FtfLYOtsmY_required = false;
jform_zdJuWBsSUb_required = false;
jform_iOUvPyajpM_required = false;
jform_JUhMHfDbxP_required = false;
jform_ZXVJsSpHFi_required = false;
jform_MTVKuGbpRm_required = false;
jform_cCijiNqHOK_required = false;
jform_wOHyAalLHV_required = false;
jform_QAJHdergsl_required = false;
jform_qvIGCVuTIi_required = false;
jform_EhWfEwfKbS_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_EQnxXbV = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	EQnxXbV(add_css_view_EQnxXbV);

	var add_css_views_CHsmoNX = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	CHsmoNX(add_css_views_CHsmoNX);

	var add_javascript_view_file_GiQeINO = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	GiQeINO(add_javascript_view_file_GiQeINO);

	var add_javascript_views_file_gHdtYbo = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	gHdtYbo(add_javascript_views_file_gHdtYbo);

	var add_javascript_view_footer_jXgAkqp = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	jXgAkqp(add_javascript_view_footer_jXgAkqp);

	var add_javascript_views_footer_JEaFHNt = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	JEaFHNt(add_javascript_views_footer_JEaFHNt);

	var add_php_ajax_NLSTYSV = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	NLSTYSV(add_php_ajax_NLSTYSV);

	var add_php_getitem_TVsaCxq = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	TVsaCxq(add_php_getitem_TVsaCxq);

	var add_php_getitems_FtfLYOt = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	FtfLYOt(add_php_getitems_FtfLYOt);

	var add_php_getlistquery_zdJuWBs = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	zdJuWBs(add_php_getlistquery_zdJuWBs);

	var add_php_save_iOUvPya = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	iOUvPya(add_php_save_iOUvPya);

	var add_php_postsavehook_JUhMHfD = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	JUhMHfD(add_php_postsavehook_JUhMHfD);

	var add_php_allowedit_ZXVJsSp = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	ZXVJsSp(add_php_allowedit_ZXVJsSp);

	var add_php_batchcopy_MTVKuGb = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	MTVKuGb(add_php_batchcopy_MTVKuGb);

	var add_php_batchmove_cCijiNq = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	cCijiNq(add_php_batchmove_cCijiNq);

	var add_php_before_delete_wOHyAal = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	wOHyAal(add_php_before_delete_wOHyAal);

	var add_php_after_delete_QAJHder = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	QAJHder(add_php_after_delete_QAJHder);

	var add_sql_qvIGCVu = jQuery("#jform_add_sql input[type='radio']:checked").val();
	qvIGCVu(add_sql_qvIGCVu);

	var source_EhWfEwf = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_EhWfEwf = jQuery("#jform_add_sql input[type='radio']:checked").val();
	EhWfEwf(source_EhWfEwf,add_sql_EhWfEwf);

	var source_WATkPpT = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_WATkPpT = jQuery("#jform_add_sql input[type='radio']:checked").val();
	WATkPpT(source_WATkPpT,add_sql_WATkPpT);
});

// the EQnxXbV function
function EQnxXbV(add_css_view_EQnxXbV)
{
	// set the function logic
	if (add_css_view_EQnxXbV == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_EQnxXbVtkr_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_EQnxXbVtkr_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_EQnxXbVtkr_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_EQnxXbVtkr_required = true;
		}
	}
}

// the CHsmoNX function
function CHsmoNX(add_css_views_CHsmoNX)
{
	// set the function logic
	if (add_css_views_CHsmoNX == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_CHsmoNXHCz_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_CHsmoNXHCz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_CHsmoNXHCz_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_CHsmoNXHCz_required = true;
		}
	}
}

// the GiQeINO function
function GiQeINO(add_javascript_view_file_GiQeINO)
{
	// set the function logic
	if (add_javascript_view_file_GiQeINO == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_GiQeINOPXr_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_GiQeINOPXr_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_GiQeINOPXr_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_GiQeINOPXr_required = true;
		}
	}
}

// the gHdtYbo function
function gHdtYbo(add_javascript_views_file_gHdtYbo)
{
	// set the function logic
	if (add_javascript_views_file_gHdtYbo == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_gHdtYboSvF_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_gHdtYboSvF_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_gHdtYboSvF_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_gHdtYboSvF_required = true;
		}
	}
}

// the jXgAkqp function
function jXgAkqp(add_javascript_view_footer_jXgAkqp)
{
	// set the function logic
	if (add_javascript_view_footer_jXgAkqp == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_jXgAkqpjdQ_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_jXgAkqpjdQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_jXgAkqpjdQ_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_jXgAkqpjdQ_required = true;
		}
	}
}

// the JEaFHNt function
function JEaFHNt(add_javascript_views_footer_JEaFHNt)
{
	// set the function logic
	if (add_javascript_views_footer_JEaFHNt == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_JEaFHNtvFm_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_JEaFHNtvFm_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_JEaFHNtvFm_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_JEaFHNtvFm_required = true;
		}
	}
}

// the NLSTYSV function
function NLSTYSV(add_php_ajax_NLSTYSV)
{
	// set the function logic
	if (add_php_ajax_NLSTYSV == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_NLSTYSVsMw_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_NLSTYSVsMw_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_NLSTYSVsMw_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_NLSTYSVsMw_required = true;
		}
	}
}

// the TVsaCxq function
function TVsaCxq(add_php_getitem_TVsaCxq)
{
	// set the function logic
	if (add_php_getitem_TVsaCxq == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_TVsaCxqQGB_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_TVsaCxqQGB_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_TVsaCxqQGB_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_TVsaCxqQGB_required = true;
		}
	}
}

// the FtfLYOt function
function FtfLYOt(add_php_getitems_FtfLYOt)
{
	// set the function logic
	if (add_php_getitems_FtfLYOt == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_FtfLYOtsmY_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_FtfLYOtsmY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_FtfLYOtsmY_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_FtfLYOtsmY_required = true;
		}
	}
}

// the zdJuWBs function
function zdJuWBs(add_php_getlistquery_zdJuWBs)
{
	// set the function logic
	if (add_php_getlistquery_zdJuWBs == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_zdJuWBsSUb_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_zdJuWBsSUb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_zdJuWBsSUb_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_zdJuWBsSUb_required = true;
		}
	}
}

// the iOUvPya function
function iOUvPya(add_php_save_iOUvPya)
{
	// set the function logic
	if (add_php_save_iOUvPya == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_iOUvPyajpM_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_iOUvPyajpM_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_iOUvPyajpM_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_iOUvPyajpM_required = true;
		}
	}
}

// the JUhMHfD function
function JUhMHfD(add_php_postsavehook_JUhMHfD)
{
	// set the function logic
	if (add_php_postsavehook_JUhMHfD == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_JUhMHfDbxP_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_JUhMHfDbxP_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_JUhMHfDbxP_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_JUhMHfDbxP_required = true;
		}
	}
}

// the ZXVJsSp function
function ZXVJsSp(add_php_allowedit_ZXVJsSp)
{
	// set the function logic
	if (add_php_allowedit_ZXVJsSp == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_ZXVJsSpHFi_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_ZXVJsSpHFi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_ZXVJsSpHFi_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_ZXVJsSpHFi_required = true;
		}
	}
}

// the MTVKuGb function
function MTVKuGb(add_php_batchcopy_MTVKuGb)
{
	// set the function logic
	if (add_php_batchcopy_MTVKuGb == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_MTVKuGbpRm_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_MTVKuGbpRm_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_MTVKuGbpRm_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_MTVKuGbpRm_required = true;
		}
	}
}

// the cCijiNq function
function cCijiNq(add_php_batchmove_cCijiNq)
{
	// set the function logic
	if (add_php_batchmove_cCijiNq == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_cCijiNqHOK_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_cCijiNqHOK_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_cCijiNqHOK_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_cCijiNqHOK_required = true;
		}
	}
}

// the wOHyAal function
function wOHyAal(add_php_before_delete_wOHyAal)
{
	// set the function logic
	if (add_php_before_delete_wOHyAal == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_wOHyAalLHV_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_wOHyAalLHV_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_wOHyAalLHV_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_wOHyAalLHV_required = true;
		}
	}
}

// the QAJHder function
function QAJHder(add_php_after_delete_QAJHder)
{
	// set the function logic
	if (add_php_after_delete_QAJHder == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_QAJHdergsl_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_QAJHdergsl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_QAJHdergsl_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_QAJHdergsl_required = true;
		}
	}
}

// the qvIGCVu function
function qvIGCVu(add_sql_qvIGCVu)
{
	// set the function logic
	if (add_sql_qvIGCVu == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_qvIGCVuTIi_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_qvIGCVuTIi_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_qvIGCVuTIi_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_qvIGCVuTIi_required = true;
		}
	}
}

// the EhWfEwf function
function EhWfEwf(source_EhWfEwf,add_sql_EhWfEwf)
{
	// set the function logic
	if (source_EhWfEwf == 2 && add_sql_EhWfEwf == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_EhWfEwfKbS_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_EhWfEwfKbS_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_EhWfEwfKbS_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_EhWfEwfKbS_required = true;
		}
	}
}

// the WATkPpT function
function WATkPpT(source_WATkPpT,add_sql_WATkPpT)
{
	// set the function logic
	if (source_WATkPpT == 1 && add_sql_WATkPpT == 1)
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
