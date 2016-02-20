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
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_SrsFadKCNO_required = false;
jform_BPqNOIeMXk_required = false;
jform_cLiMKqTJyw_required = false;
jform_jtOIeOFJqz_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_VogwNXE = jQuery("#jform_location input[type='radio']:checked").val();
	VogwNXE(location_VogwNXE);

	var location_XdiemBu = jQuery("#jform_location input[type='radio']:checked").val();
	XdiemBu(location_XdiemBu);

	var type_SrsFadK = jQuery("#jform_type").val();
	SrsFadK(type_SrsFadK);

	var type_BPqNOIe = jQuery("#jform_type").val();
	BPqNOIe(type_BPqNOIe);

	var type_cLiMKqT = jQuery("#jform_type").val();
	cLiMKqT(type_cLiMKqT);

	var target_jtOIeOF = jQuery("#jform_target input[type='radio']:checked").val();
	jtOIeOF(target_jtOIeOF);
});

// the VogwNXE function
function VogwNXE(location_VogwNXE)
{
	// set the function logic
	if (location_VogwNXE == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the XdiemBu function
function XdiemBu(location_XdiemBu)
{
	// set the function logic
	if (location_XdiemBu == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the SrsFadK function
function SrsFadK(type_SrsFadK)
{
	if (isSet(type_SrsFadK) && type_SrsFadK.constructor !== Array)
	{
		var temp_SrsFadK = type_SrsFadK;
		var type_SrsFadK = [];
		type_SrsFadK.push(temp_SrsFadK);
	}
	else if (!isSet(type_SrsFadK))
	{
		var type_SrsFadK = [];
	}
	var type = type_SrsFadK.some(type_SrsFadK_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_SrsFadKCNO_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_SrsFadKCNO_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_SrsFadKCNO_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_SrsFadKCNO_required = true;
		}
	}
}

// the SrsFadK Some function
function type_SrsFadK_SomeFunc(type_SrsFadK)
{
	// set the function logic
	if (type_SrsFadK == 3)
	{
		return true;
	}
	return false;
}

// the BPqNOIe function
function BPqNOIe(type_BPqNOIe)
{
	if (isSet(type_BPqNOIe) && type_BPqNOIe.constructor !== Array)
	{
		var temp_BPqNOIe = type_BPqNOIe;
		var type_BPqNOIe = [];
		type_BPqNOIe.push(temp_BPqNOIe);
	}
	else if (!isSet(type_BPqNOIe))
	{
		var type_BPqNOIe = [];
	}
	var type = type_BPqNOIe.some(type_BPqNOIe_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_BPqNOIeMXk_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_BPqNOIeMXk_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_BPqNOIeMXk_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_BPqNOIeMXk_required = true;
		}
	}
}

// the BPqNOIe Some function
function type_BPqNOIe_SomeFunc(type_BPqNOIe)
{
	// set the function logic
	if (type_BPqNOIe == 1)
	{
		return true;
	}
	return false;
}

// the cLiMKqT function
function cLiMKqT(type_cLiMKqT)
{
	if (isSet(type_cLiMKqT) && type_cLiMKqT.constructor !== Array)
	{
		var temp_cLiMKqT = type_cLiMKqT;
		var type_cLiMKqT = [];
		type_cLiMKqT.push(temp_cLiMKqT);
	}
	else if (!isSet(type_cLiMKqT))
	{
		var type_cLiMKqT = [];
	}
	var type = type_cLiMKqT.some(type_cLiMKqT_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_cLiMKqTJyw_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_cLiMKqTJyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_cLiMKqTJyw_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_cLiMKqTJyw_required = true;
		}
	}
}

// the cLiMKqT Some function
function type_cLiMKqT_SomeFunc(type_cLiMKqT)
{
	// set the function logic
	if (type_cLiMKqT == 2)
	{
		return true;
	}
	return false;
}

// the jtOIeOF function
function jtOIeOF(target_jtOIeOF)
{
	// set the function logic
	if (target_jtOIeOF == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_jtOIeOFJqz_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_jtOIeOFJqz_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_jtOIeOFJqz_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_jtOIeOFJqz_required = true;
		}
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
