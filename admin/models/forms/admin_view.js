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
jform_WSwrvIgGkS_required = false;
jform_tJmAmneNIy_required = false;
jform_MCmDrfEzwh_required = false;
jform_FmbVzDwFjN_required = false;
jform_DADObKafDI_required = false;
jform_LkoWIBbpbx_required = false;
jform_rHFzvkVaUd_required = false;
jform_JqKoiLYiND_required = false;
jform_OBHaxtCzFF_required = false;
jform_QcpBvJGxNG_required = false;
jform_tCXfMfOLtF_required = false;
jform_hhZUiqsKNY_required = false;
jform_tGbGbDsMUj_required = false;
jform_ltKkyowgbL_required = false;
jform_HiQLeWcxMQ_required = false;
jform_uhypOtRkhM_required = false;
jform_rrcbItqYHr_required = false;
jform_CrHzYLpabc_required = false;
jform_SpjlMYLHjQ_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_css_view_WSwrvIg = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	WSwrvIg(add_css_view_WSwrvIg);

	var add_css_views_tJmAmne = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	tJmAmne(add_css_views_tJmAmne);

	var add_javascript_view_file_MCmDrfE = jQuery("#jform_add_javascript_view_file input[type='radio']:checked").val();
	MCmDrfE(add_javascript_view_file_MCmDrfE);

	var add_javascript_views_file_FmbVzDw = jQuery("#jform_add_javascript_views_file input[type='radio']:checked").val();
	FmbVzDw(add_javascript_views_file_FmbVzDw);

	var add_javascript_view_footer_DADObKa = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	DADObKa(add_javascript_view_footer_DADObKa);

	var add_javascript_views_footer_LkoWIBb = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	LkoWIBb(add_javascript_views_footer_LkoWIBb);

	var add_php_ajax_rHFzvkV = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	rHFzvkV(add_php_ajax_rHFzvkV);

	var add_php_getitem_JqKoiLY = jQuery("#jform_add_php_getitem input[type='radio']:checked").val();
	JqKoiLY(add_php_getitem_JqKoiLY);

	var add_php_getitems_OBHaxtC = jQuery("#jform_add_php_getitems input[type='radio']:checked").val();
	OBHaxtC(add_php_getitems_OBHaxtC);

	var add_php_getlistquery_QcpBvJG = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	QcpBvJG(add_php_getlistquery_QcpBvJG);

	var add_php_save_tCXfMfO = jQuery("#jform_add_php_save input[type='radio']:checked").val();
	tCXfMfO(add_php_save_tCXfMfO);

	var add_php_postsavehook_hhZUiqs = jQuery("#jform_add_php_postsavehook input[type='radio']:checked").val();
	hhZUiqs(add_php_postsavehook_hhZUiqs);

	var add_php_allowedit_tGbGbDs = jQuery("#jform_add_php_allowedit input[type='radio']:checked").val();
	tGbGbDs(add_php_allowedit_tGbGbDs);

	var add_php_batchcopy_ltKkyow = jQuery("#jform_add_php_batchcopy input[type='radio']:checked").val();
	ltKkyow(add_php_batchcopy_ltKkyow);

	var add_php_batchmove_HiQLeWc = jQuery("#jform_add_php_batchmove input[type='radio']:checked").val();
	HiQLeWc(add_php_batchmove_HiQLeWc);

	var add_php_before_delete_uhypOtR = jQuery("#jform_add_php_before_delete input[type='radio']:checked").val();
	uhypOtR(add_php_before_delete_uhypOtR);

	var add_php_after_delete_rrcbItq = jQuery("#jform_add_php_after_delete input[type='radio']:checked").val();
	rrcbItq(add_php_after_delete_rrcbItq);

	var add_sql_CrHzYLp = jQuery("#jform_add_sql input[type='radio']:checked").val();
	CrHzYLp(add_sql_CrHzYLp);

	var source_SpjlMYL = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_SpjlMYL = jQuery("#jform_add_sql input[type='radio']:checked").val();
	SpjlMYL(source_SpjlMYL,add_sql_SpjlMYL);

	var source_ZNxrsLZ = jQuery("#jform_source input[type='radio']:checked").val();
	var add_sql_ZNxrsLZ = jQuery("#jform_add_sql input[type='radio']:checked").val();
	ZNxrsLZ(source_ZNxrsLZ,add_sql_ZNxrsLZ);
});

// the WSwrvIg function
function WSwrvIg(add_css_view_WSwrvIg)
{
	// set the function logic
	if (add_css_view_WSwrvIg == 1)
	{
		jQuery('#jform_css_view').closest('.control-group').show();
		if (jform_WSwrvIgGkS_required)
		{
			updateFieldRequired('css_view',0);
			jQuery('#jform_css_view').prop('required','required');
			jQuery('#jform_css_view').attr('aria-required',true);
			jQuery('#jform_css_view').addClass('required');
			jform_WSwrvIgGkS_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_view').closest('.control-group').hide();
		if (!jform_WSwrvIgGkS_required)
		{
			updateFieldRequired('css_view',1);
			jQuery('#jform_css_view').removeAttr('required');
			jQuery('#jform_css_view').removeAttr('aria-required');
			jQuery('#jform_css_view').removeClass('required');
			jform_WSwrvIgGkS_required = true;
		}
	}
}

// the tJmAmne function
function tJmAmne(add_css_views_tJmAmne)
{
	// set the function logic
	if (add_css_views_tJmAmne == 1)
	{
		jQuery('#jform_css_views').closest('.control-group').show();
		if (jform_tJmAmneNIy_required)
		{
			updateFieldRequired('css_views',0);
			jQuery('#jform_css_views').prop('required','required');
			jQuery('#jform_css_views').attr('aria-required',true);
			jQuery('#jform_css_views').addClass('required');
			jform_tJmAmneNIy_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_views').closest('.control-group').hide();
		if (!jform_tJmAmneNIy_required)
		{
			updateFieldRequired('css_views',1);
			jQuery('#jform_css_views').removeAttr('required');
			jQuery('#jform_css_views').removeAttr('aria-required');
			jQuery('#jform_css_views').removeClass('required');
			jform_tJmAmneNIy_required = true;
		}
	}
}

// the MCmDrfE function
function MCmDrfE(add_javascript_view_file_MCmDrfE)
{
	// set the function logic
	if (add_javascript_view_file_MCmDrfE == 1)
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').show();
		if (jform_MCmDrfEzwh_required)
		{
			updateFieldRequired('javascript_view_file',0);
			jQuery('#jform_javascript_view_file').prop('required','required');
			jQuery('#jform_javascript_view_file').attr('aria-required',true);
			jQuery('#jform_javascript_view_file').addClass('required');
			jform_MCmDrfEzwh_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_file').closest('.control-group').hide();
		if (!jform_MCmDrfEzwh_required)
		{
			updateFieldRequired('javascript_view_file',1);
			jQuery('#jform_javascript_view_file').removeAttr('required');
			jQuery('#jform_javascript_view_file').removeAttr('aria-required');
			jQuery('#jform_javascript_view_file').removeClass('required');
			jform_MCmDrfEzwh_required = true;
		}
	}
}

// the FmbVzDw function
function FmbVzDw(add_javascript_views_file_FmbVzDw)
{
	// set the function logic
	if (add_javascript_views_file_FmbVzDw == 1)
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').show();
		if (jform_FmbVzDwFjN_required)
		{
			updateFieldRequired('javascript_views_file',0);
			jQuery('#jform_javascript_views_file').prop('required','required');
			jQuery('#jform_javascript_views_file').attr('aria-required',true);
			jQuery('#jform_javascript_views_file').addClass('required');
			jform_FmbVzDwFjN_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_file').closest('.control-group').hide();
		if (!jform_FmbVzDwFjN_required)
		{
			updateFieldRequired('javascript_views_file',1);
			jQuery('#jform_javascript_views_file').removeAttr('required');
			jQuery('#jform_javascript_views_file').removeAttr('aria-required');
			jQuery('#jform_javascript_views_file').removeClass('required');
			jform_FmbVzDwFjN_required = true;
		}
	}
}

// the DADObKa function
function DADObKa(add_javascript_view_footer_DADObKa)
{
	// set the function logic
	if (add_javascript_view_footer_DADObKa == 1)
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').show();
		if (jform_DADObKafDI_required)
		{
			updateFieldRequired('javascript_view_footer',0);
			jQuery('#jform_javascript_view_footer').prop('required','required');
			jQuery('#jform_javascript_view_footer').attr('aria-required',true);
			jQuery('#jform_javascript_view_footer').addClass('required');
			jform_DADObKafDI_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_view_footer').closest('.control-group').hide();
		if (!jform_DADObKafDI_required)
		{
			updateFieldRequired('javascript_view_footer',1);
			jQuery('#jform_javascript_view_footer').removeAttr('required');
			jQuery('#jform_javascript_view_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_view_footer').removeClass('required');
			jform_DADObKafDI_required = true;
		}
	}
}

// the LkoWIBb function
function LkoWIBb(add_javascript_views_footer_LkoWIBb)
{
	// set the function logic
	if (add_javascript_views_footer_LkoWIBb == 1)
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').show();
		if (jform_LkoWIBbpbx_required)
		{
			updateFieldRequired('javascript_views_footer',0);
			jQuery('#jform_javascript_views_footer').prop('required','required');
			jQuery('#jform_javascript_views_footer').attr('aria-required',true);
			jQuery('#jform_javascript_views_footer').addClass('required');
			jform_LkoWIBbpbx_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript_views_footer').closest('.control-group').hide();
		if (!jform_LkoWIBbpbx_required)
		{
			updateFieldRequired('javascript_views_footer',1);
			jQuery('#jform_javascript_views_footer').removeAttr('required');
			jQuery('#jform_javascript_views_footer').removeAttr('aria-required');
			jQuery('#jform_javascript_views_footer').removeClass('required');
			jform_LkoWIBbpbx_required = true;
		}
	}
}

// the rHFzvkV function
function rHFzvkV(add_php_ajax_rHFzvkV)
{
	// set the function logic
	if (add_php_ajax_rHFzvkV == 1)
	{
		jQuery('#jform_ajax_input').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').show();
		if (jform_rHFzvkVaUd_required)
		{
			updateFieldRequired('php_ajaxmethod',0);
			jQuery('#jform_php_ajaxmethod').prop('required','required');
			jQuery('#jform_php_ajaxmethod').attr('aria-required',true);
			jQuery('#jform_php_ajaxmethod').addClass('required');
			jform_rHFzvkVaUd_required = false;
		}

	}
	else
	{
		jQuery('#jform_ajax_input').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod').closest('.control-group').hide();
		if (!jform_rHFzvkVaUd_required)
		{
			updateFieldRequired('php_ajaxmethod',1);
			jQuery('#jform_php_ajaxmethod').removeAttr('required');
			jQuery('#jform_php_ajaxmethod').removeAttr('aria-required');
			jQuery('#jform_php_ajaxmethod').removeClass('required');
			jform_rHFzvkVaUd_required = true;
		}
	}
}

// the JqKoiLY function
function JqKoiLY(add_php_getitem_JqKoiLY)
{
	// set the function logic
	if (add_php_getitem_JqKoiLY == 1)
	{
		jQuery('#jform_php_getitem').closest('.control-group').show();
		if (jform_JqKoiLYiND_required)
		{
			updateFieldRequired('php_getitem',0);
			jQuery('#jform_php_getitem').prop('required','required');
			jQuery('#jform_php_getitem').attr('aria-required',true);
			jQuery('#jform_php_getitem').addClass('required');
			jform_JqKoiLYiND_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitem').closest('.control-group').hide();
		if (!jform_JqKoiLYiND_required)
		{
			updateFieldRequired('php_getitem',1);
			jQuery('#jform_php_getitem').removeAttr('required');
			jQuery('#jform_php_getitem').removeAttr('aria-required');
			jQuery('#jform_php_getitem').removeClass('required');
			jform_JqKoiLYiND_required = true;
		}
	}
}

// the OBHaxtC function
function OBHaxtC(add_php_getitems_OBHaxtC)
{
	// set the function logic
	if (add_php_getitems_OBHaxtC == 1)
	{
		jQuery('#jform_php_getitems').closest('.control-group').show();
		if (jform_OBHaxtCzFF_required)
		{
			updateFieldRequired('php_getitems',0);
			jQuery('#jform_php_getitems').prop('required','required');
			jQuery('#jform_php_getitems').attr('aria-required',true);
			jQuery('#jform_php_getitems').addClass('required');
			jform_OBHaxtCzFF_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getitems').closest('.control-group').hide();
		if (!jform_OBHaxtCzFF_required)
		{
			updateFieldRequired('php_getitems',1);
			jQuery('#jform_php_getitems').removeAttr('required');
			jQuery('#jform_php_getitems').removeAttr('aria-required');
			jQuery('#jform_php_getitems').removeClass('required');
			jform_OBHaxtCzFF_required = true;
		}
	}
}

// the QcpBvJG function
function QcpBvJG(add_php_getlistquery_QcpBvJG)
{
	// set the function logic
	if (add_php_getlistquery_QcpBvJG == 1)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_QcpBvJGxNG_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_QcpBvJGxNG_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_QcpBvJGxNG_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_QcpBvJGxNG_required = true;
		}
	}
}

// the tCXfMfO function
function tCXfMfO(add_php_save_tCXfMfO)
{
	// set the function logic
	if (add_php_save_tCXfMfO == 1)
	{
		jQuery('#jform_php_save').closest('.control-group').show();
		if (jform_tCXfMfOLtF_required)
		{
			updateFieldRequired('php_save',0);
			jQuery('#jform_php_save').prop('required','required');
			jQuery('#jform_php_save').attr('aria-required',true);
			jQuery('#jform_php_save').addClass('required');
			jform_tCXfMfOLtF_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_save').closest('.control-group').hide();
		if (!jform_tCXfMfOLtF_required)
		{
			updateFieldRequired('php_save',1);
			jQuery('#jform_php_save').removeAttr('required');
			jQuery('#jform_php_save').removeAttr('aria-required');
			jQuery('#jform_php_save').removeClass('required');
			jform_tCXfMfOLtF_required = true;
		}
	}
}

// the hhZUiqs function
function hhZUiqs(add_php_postsavehook_hhZUiqs)
{
	// set the function logic
	if (add_php_postsavehook_hhZUiqs == 1)
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').show();
		if (jform_hhZUiqsKNY_required)
		{
			updateFieldRequired('php_postsavehook',0);
			jQuery('#jform_php_postsavehook').prop('required','required');
			jQuery('#jform_php_postsavehook').attr('aria-required',true);
			jQuery('#jform_php_postsavehook').addClass('required');
			jform_hhZUiqsKNY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postsavehook').closest('.control-group').hide();
		if (!jform_hhZUiqsKNY_required)
		{
			updateFieldRequired('php_postsavehook',1);
			jQuery('#jform_php_postsavehook').removeAttr('required');
			jQuery('#jform_php_postsavehook').removeAttr('aria-required');
			jQuery('#jform_php_postsavehook').removeClass('required');
			jform_hhZUiqsKNY_required = true;
		}
	}
}

// the tGbGbDs function
function tGbGbDs(add_php_allowedit_tGbGbDs)
{
	// set the function logic
	if (add_php_allowedit_tGbGbDs == 1)
	{
		jQuery('#jform_php_allowedit').closest('.control-group').show();
		if (jform_tGbGbDsMUj_required)
		{
			updateFieldRequired('php_allowedit',0);
			jQuery('#jform_php_allowedit').prop('required','required');
			jQuery('#jform_php_allowedit').attr('aria-required',true);
			jQuery('#jform_php_allowedit').addClass('required');
			jform_tGbGbDsMUj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_allowedit').closest('.control-group').hide();
		if (!jform_tGbGbDsMUj_required)
		{
			updateFieldRequired('php_allowedit',1);
			jQuery('#jform_php_allowedit').removeAttr('required');
			jQuery('#jform_php_allowedit').removeAttr('aria-required');
			jQuery('#jform_php_allowedit').removeClass('required');
			jform_tGbGbDsMUj_required = true;
		}
	}
}

// the ltKkyow function
function ltKkyow(add_php_batchcopy_ltKkyow)
{
	// set the function logic
	if (add_php_batchcopy_ltKkyow == 1)
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').show();
		if (jform_ltKkyowgbL_required)
		{
			updateFieldRequired('php_batchcopy',0);
			jQuery('#jform_php_batchcopy').prop('required','required');
			jQuery('#jform_php_batchcopy').attr('aria-required',true);
			jQuery('#jform_php_batchcopy').addClass('required');
			jform_ltKkyowgbL_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchcopy').closest('.control-group').hide();
		if (!jform_ltKkyowgbL_required)
		{
			updateFieldRequired('php_batchcopy',1);
			jQuery('#jform_php_batchcopy').removeAttr('required');
			jQuery('#jform_php_batchcopy').removeAttr('aria-required');
			jQuery('#jform_php_batchcopy').removeClass('required');
			jform_ltKkyowgbL_required = true;
		}
	}
}

// the HiQLeWc function
function HiQLeWc(add_php_batchmove_HiQLeWc)
{
	// set the function logic
	if (add_php_batchmove_HiQLeWc == 1)
	{
		jQuery('#jform_php_batchmove').closest('.control-group').show();
		if (jform_HiQLeWcxMQ_required)
		{
			updateFieldRequired('php_batchmove',0);
			jQuery('#jform_php_batchmove').prop('required','required');
			jQuery('#jform_php_batchmove').attr('aria-required',true);
			jQuery('#jform_php_batchmove').addClass('required');
			jform_HiQLeWcxMQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_batchmove').closest('.control-group').hide();
		if (!jform_HiQLeWcxMQ_required)
		{
			updateFieldRequired('php_batchmove',1);
			jQuery('#jform_php_batchmove').removeAttr('required');
			jQuery('#jform_php_batchmove').removeAttr('aria-required');
			jQuery('#jform_php_batchmove').removeClass('required');
			jform_HiQLeWcxMQ_required = true;
		}
	}
}

// the uhypOtR function
function uhypOtR(add_php_before_delete_uhypOtR)
{
	// set the function logic
	if (add_php_before_delete_uhypOtR == 1)
	{
		jQuery('#jform_php_before_delete').closest('.control-group').show();
		if (jform_uhypOtRkhM_required)
		{
			updateFieldRequired('php_before_delete',0);
			jQuery('#jform_php_before_delete').prop('required','required');
			jQuery('#jform_php_before_delete').attr('aria-required',true);
			jQuery('#jform_php_before_delete').addClass('required');
			jform_uhypOtRkhM_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_delete').closest('.control-group').hide();
		if (!jform_uhypOtRkhM_required)
		{
			updateFieldRequired('php_before_delete',1);
			jQuery('#jform_php_before_delete').removeAttr('required');
			jQuery('#jform_php_before_delete').removeAttr('aria-required');
			jQuery('#jform_php_before_delete').removeClass('required');
			jform_uhypOtRkhM_required = true;
		}
	}
}

// the rrcbItq function
function rrcbItq(add_php_after_delete_rrcbItq)
{
	// set the function logic
	if (add_php_after_delete_rrcbItq == 1)
	{
		jQuery('#jform_php_after_delete').closest('.control-group').show();
		if (jform_rrcbItqYHr_required)
		{
			updateFieldRequired('php_after_delete',0);
			jQuery('#jform_php_after_delete').prop('required','required');
			jQuery('#jform_php_after_delete').attr('aria-required',true);
			jQuery('#jform_php_after_delete').addClass('required');
			jform_rrcbItqYHr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_delete').closest('.control-group').hide();
		if (!jform_rrcbItqYHr_required)
		{
			updateFieldRequired('php_after_delete',1);
			jQuery('#jform_php_after_delete').removeAttr('required');
			jQuery('#jform_php_after_delete').removeAttr('aria-required');
			jQuery('#jform_php_after_delete').removeClass('required');
			jform_rrcbItqYHr_required = true;
		}
	}
}

// the CrHzYLp function
function CrHzYLp(add_sql_CrHzYLp)
{
	// set the function logic
	if (add_sql_CrHzYLp == 1)
	{
		jQuery('#jform_source').closest('.control-group').show();
		if (jform_CrHzYLpabc_required)
		{
			updateFieldRequired('source',0);
			jQuery('#jform_source').prop('required','required');
			jQuery('#jform_source').attr('aria-required',true);
			jQuery('#jform_source').addClass('required');
			jform_CrHzYLpabc_required = false;
		}

	}
	else
	{
		jQuery('#jform_source').closest('.control-group').hide();
		if (!jform_CrHzYLpabc_required)
		{
			updateFieldRequired('source',1);
			jQuery('#jform_source').removeAttr('required');
			jQuery('#jform_source').removeAttr('aria-required');
			jQuery('#jform_source').removeClass('required');
			jform_CrHzYLpabc_required = true;
		}
	}
}

// the SpjlMYL function
function SpjlMYL(source_SpjlMYL,add_sql_SpjlMYL)
{
	// set the function logic
	if (source_SpjlMYL == 2 && add_sql_SpjlMYL == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_SpjlMYLHjQ_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_SpjlMYLHjQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_SpjlMYLHjQ_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_SpjlMYLHjQ_required = true;
		}
	}
}

// the ZNxrsLZ function
function ZNxrsLZ(source_ZNxrsLZ,add_sql_ZNxrsLZ)
{
	// set the function logic
	if (source_ZNxrsLZ == 1 && add_sql_ZNxrsLZ == 1)
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
