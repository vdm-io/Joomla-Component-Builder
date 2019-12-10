/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvvxcvwd_required = false;
jform_vvvvvxrvwe_required = false;
jform_vvvvvxsvwf_required = false;
jform_vvvvvxtvwg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_class_helper_vvvvvxb = jQuery("#jform_add_class_helper").val();
	vvvvvxb(add_class_helper_vvvvvxb);

	var add_class_helper_header_vvvvvxc = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvxc = jQuery("#jform_add_class_helper").val();
	vvvvvxc(add_class_helper_header_vvvvvxc,add_class_helper_vvvvvxc);

	var add_php_script_construct_vvvvvxe = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvxe(add_php_script_construct_vvvvvxe);

	var add_php_preflight_install_vvvvvxf = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvxf(add_php_preflight_install_vvvvvxf);

	var add_php_preflight_update_vvvvvxg = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvxg(add_php_preflight_update_vvvvvxg);

	var add_php_preflight_uninstall_vvvvvxh = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvxh(add_php_preflight_uninstall_vvvvvxh);

	var add_php_postflight_install_vvvvvxi = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvxi(add_php_postflight_install_vvvvvxi);

	var add_php_postflight_update_vvvvvxj = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvxj(add_php_postflight_update_vvvvvxj);

	var add_php_method_uninstall_vvvvvxk = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvxk(add_php_method_uninstall_vvvvvxk);

	var update_server_target_vvvvvxl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxl(update_server_target_vvvvvxl,add_update_server_vvvvvxl);

	var add_update_server_vvvvvxm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxm(add_update_server_vvvvvxm,update_server_target_vvvvvxm);

	var update_server_target_vvvvvxn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn);

	var update_server_target_vvvvvxp = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp);

	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(add_update_server_vvvvvxr);

	var add_sql_vvvvvxs = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxs(add_sql_vvvvvxs);

	var add_sql_uninstall_vvvvvxt = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvxt(add_sql_uninstall_vvvvvxt);

	var add_update_server_vvvvvxu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxu(add_update_server_vvvvvxu);

	var add_sales_server_vvvvvxv = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvxv(add_sales_server_vvvvvxv);

	var addreadme_vvvvvxw = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvxw(addreadme_vvvvvxw);
});

// the vvvvvxb function
function vvvvvxb(add_class_helper_vvvvvxb)
{
	if (isSet(add_class_helper_vvvvvxb) && add_class_helper_vvvvvxb.constructor !== Array)
	{
		var temp_vvvvvxb = add_class_helper_vvvvvxb;
		var add_class_helper_vvvvvxb = [];
		add_class_helper_vvvvvxb.push(temp_vvvvvxb);
	}
	else if (!isSet(add_class_helper_vvvvvxb))
	{
		var add_class_helper_vvvvvxb = [];
	}
	var add_class_helper = add_class_helper_vvvvvxb.some(add_class_helper_vvvvvxb_SomeFunc);


	// set this function logic
	if (add_class_helper)
	{
		jQuery('#jform_add_class_helper_header').closest('.control-group').show();
		jQuery('#jform_class_helper_code-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_add_class_helper_header').closest('.control-group').hide();
		jQuery('#jform_class_helper_code-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxb Some function
function add_class_helper_vvvvvxb_SomeFunc(add_class_helper_vvvvvxb)
{
	// set the function logic
	if (add_class_helper_vvvvvxb == 1 || add_class_helper_vvvvvxb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvxc function
function vvvvvxc(add_class_helper_header_vvvvvxc,add_class_helper_vvvvvxc)
{
	if (isSet(add_class_helper_header_vvvvvxc) && add_class_helper_header_vvvvvxc.constructor !== Array)
	{
		var temp_vvvvvxc = add_class_helper_header_vvvvvxc;
		var add_class_helper_header_vvvvvxc = [];
		add_class_helper_header_vvvvvxc.push(temp_vvvvvxc);
	}
	else if (!isSet(add_class_helper_header_vvvvvxc))
	{
		var add_class_helper_header_vvvvvxc = [];
	}
	var add_class_helper_header = add_class_helper_header_vvvvvxc.some(add_class_helper_header_vvvvvxc_SomeFunc);

	if (isSet(add_class_helper_vvvvvxc) && add_class_helper_vvvvvxc.constructor !== Array)
	{
		var temp_vvvvvxc = add_class_helper_vvvvvxc;
		var add_class_helper_vvvvvxc = [];
		add_class_helper_vvvvvxc.push(temp_vvvvvxc);
	}
	else if (!isSet(add_class_helper_vvvvvxc))
	{
		var add_class_helper_vvvvvxc = [];
	}
	var add_class_helper = add_class_helper_vvvvvxc.some(add_class_helper_vvvvvxc_SomeFunc);


	// set this function logic
	if (add_class_helper_header && add_class_helper)
	{
		jQuery('#jform_class_helper_header-lbl').closest('.control-group').show();
		// add required attribute to class_helper_header field
		if (jform_vvvvvxcvwd_required)
		{
			updateFieldRequired('class_helper_header',0);
			jQuery('#jform_class_helper_header').prop('required','required');
			jQuery('#jform_class_helper_header').attr('aria-required',true);
			jQuery('#jform_class_helper_header').addClass('required');
			jform_vvvvvxcvwd_required = false;
		}
	}
	else
	{
		jQuery('#jform_class_helper_header-lbl').closest('.control-group').hide();
		// remove required attribute from class_helper_header field
		if (!jform_vvvvvxcvwd_required)
		{
			updateFieldRequired('class_helper_header',1);
			jQuery('#jform_class_helper_header').removeAttr('required');
			jQuery('#jform_class_helper_header').removeAttr('aria-required');
			jQuery('#jform_class_helper_header').removeClass('required');
			jform_vvvvvxcvwd_required = true;
		}
	}
}

// the vvvvvxc Some function
function add_class_helper_header_vvvvvxc_SomeFunc(add_class_helper_header_vvvvvxc)
{
	// set the function logic
	if (add_class_helper_header_vvvvvxc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvxc Some function
function add_class_helper_vvvvvxc_SomeFunc(add_class_helper_vvvvvxc)
{
	// set the function logic
	if (add_class_helper_vvvvvxc == 1 || add_class_helper_vvvvvxc == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvxe function
function vvvvvxe(add_php_script_construct_vvvvvxe)
{
	// set the function logic
	if (add_php_script_construct_vvvvvxe == 1)
	{
		jQuery('#jform_php_script_construct-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_script_construct-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxf function
function vvvvvxf(add_php_preflight_install_vvvvvxf)
{
	// set the function logic
	if (add_php_preflight_install_vvvvvxf == 1)
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxg function
function vvvvvxg(add_php_preflight_update_vvvvvxg)
{
	// set the function logic
	if (add_php_preflight_update_vvvvvxg == 1)
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxh function
function vvvvvxh(add_php_preflight_uninstall_vvvvvxh)
{
	// set the function logic
	if (add_php_preflight_uninstall_vvvvvxh == 1)
	{
		jQuery('#jform_php_preflight_uninstall-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_uninstall-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxi function
function vvvvvxi(add_php_postflight_install_vvvvvxi)
{
	// set the function logic
	if (add_php_postflight_install_vvvvvxi == 1)
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxj function
function vvvvvxj(add_php_postflight_update_vvvvvxj)
{
	// set the function logic
	if (add_php_postflight_update_vvvvvxj == 1)
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxk function
function vvvvvxk(add_php_method_uninstall_vvvvvxk)
{
	// set the function logic
	if (add_php_method_uninstall_vvvvvxk == 1)
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxl function
function vvvvvxl(update_server_target_vvvvvxl,add_update_server_vvvvvxl)
{
	// set the function logic
	if (update_server_target_vvvvvxl == 1 && add_update_server_vvvvvxl == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvxm function
function vvvvvxm(add_update_server_vvvvvxm,update_server_target_vvvvvxm)
{
	// set the function logic
	if (add_update_server_vvvvvxm == 1 && update_server_target_vvvvvxm == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvxn function
function vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn)
{
	// set the function logic
	if (update_server_target_vvvvvxn == 2 && add_update_server_vvvvvxn == 1)
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').hide();
	}
}

// the vvvvvxp function
function vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp)
{
	// set the function logic
	if (update_server_target_vvvvvxp == 3 && add_update_server_vvvvvxp == 1)
	{
		jQuery('.note_update_server_note_other').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_other').closest('.control-group').hide();
	}
}

// the vvvvvxr function
function vvvvvxr(add_update_server_vvvvvxr)
{
	// set the function logic
	if (add_update_server_vvvvvxr == 1)
	{
		jQuery('#jform_update_server_target').closest('.control-group').show();
		// add required attribute to update_server_target field
		if (jform_vvvvvxrvwe_required)
		{
			updateFieldRequired('update_server_target',0);
			jQuery('#jform_update_server_target').prop('required','required');
			jQuery('#jform_update_server_target').attr('aria-required',true);
			jQuery('#jform_update_server_target').addClass('required');
			jform_vvvvvxrvwe_required = false;
		}
	}
	else
	{
		jQuery('#jform_update_server_target').closest('.control-group').hide();
		// remove required attribute from update_server_target field
		if (!jform_vvvvvxrvwe_required)
		{
			updateFieldRequired('update_server_target',1);
			jQuery('#jform_update_server_target').removeAttr('required');
			jQuery('#jform_update_server_target').removeAttr('aria-required');
			jQuery('#jform_update_server_target').removeClass('required');
			jform_vvvvvxrvwe_required = true;
		}
	}
}

// the vvvvvxs function
function vvvvvxs(add_sql_vvvvvxs)
{
	// set the function logic
	if (add_sql_vvvvvxs == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		// add required attribute to sql field
		if (jform_vvvvvxsvwf_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvxsvwf_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		// remove required attribute from sql field
		if (!jform_vvvvvxsvwf_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvxsvwf_required = true;
		}
	}
}

// the vvvvvxt function
function vvvvvxt(add_sql_uninstall_vvvvvxt)
{
	// set the function logic
	if (add_sql_uninstall_vvvvvxt == 1)
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').show();
		// add required attribute to sql_uninstall field
		if (jform_vvvvvxtvwg_required)
		{
			updateFieldRequired('sql_uninstall',0);
			jQuery('#jform_sql_uninstall').prop('required','required');
			jQuery('#jform_sql_uninstall').attr('aria-required',true);
			jQuery('#jform_sql_uninstall').addClass('required');
			jform_vvvvvxtvwg_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').hide();
		// remove required attribute from sql_uninstall field
		if (!jform_vvvvvxtvwg_required)
		{
			updateFieldRequired('sql_uninstall',1);
			jQuery('#jform_sql_uninstall').removeAttr('required');
			jQuery('#jform_sql_uninstall').removeAttr('aria-required');
			jQuery('#jform_sql_uninstall').removeClass('required');
			jform_vvvvvxtvwg_required = true;
		}
	}
}

// the vvvvvxu function
function vvvvvxu(add_update_server_vvvvvxu)
{
	// set the function logic
	if (add_update_server_vvvvvxu == 1)
	{
		jQuery('#jform_update_server_url').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server_url').closest('.control-group').hide();
	}
}

// the vvvvvxv function
function vvvvvxv(add_sales_server_vvvvvxv)
{
	// set the function logic
	if (add_sales_server_vvvvvxv == 1)
	{
		jQuery('#jform_sales_server').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_sales_server').closest('.control-group').hide();
	}
}

// the vvvvvxw function
function vvvvvxw(addreadme_vvvvvxw)
{
	// set the function logic
	if (addreadme_vvvvvxw == 1)
	{
		jQuery('#jform_readme-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
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


jQuery(document).ready(function() {
	// get the linked details
	getLinked();
	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
});

function setModuleCode() {
	var selected_get =  jQuery("#jform_add_class_helper  option:selected").val();
	var custom_gets =  jQuery("#jform_custom_get").val();
	var libraries =  jQuery("#jform_libraries").val();
	var values = {'class': selected_get, 'get': custom_gets, 'lib': libraries};
	var editor_id = 'jform_mod_code';
	getCodeFrom_server(1, JSON.stringify(values), 'data', 'getModuleCode').done(function(result) {
		if(result.tmpl){
			 addCodeToEditor(result.tmpl.code, editor_id, result.tmpl.merge, result.tmpl.merge_target);
		}
		if(result.css){
			 addCodeToEditor(result.css.code, editor_id, result.css.merge, result.css.merge_target);
		}
		if(result.class){
			 addCodeToEditor(result.class.code, editor_id, result.class.merge, result.class.merge_target);
		}
		if(result.get){
			 addCodeToEditor(result.get.code, editor_id, result.get.merge, result.get.merge_target);
		}
		if(result.lib){
			 addCodeToEditor(result.lib.code, editor_id, result.lib.merge, result.lib.merge_target);
		}
	});
}

function getLinked(){
	getCodeFrom_server(1, 'type', 'type', 'getLinked').done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
}

function getCodeFrom_server(id, type, type_name, callingName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0 && type.length > 0) {
		var request = token + '=1&' + type_name + '=' + type + '&id=' + id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}


function addCodeToEditor(code_string, editor_id, merge, merge_target){
	if (Joomla.editors.instances.hasOwnProperty(editor_id)) {
		var old_code_string = Joomla.editors.instances[editor_id].getValue();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1)  {
				if ('prepend' === merge_target) {
					var _string = code_string + "\n\n" + old_code_string;
				} else if (merge_target && 'append' !== merge_target) {
					var old_code_array = old_code_string.split(merge_target);
					if (old_code_array.length > 1) {
						var _string = old_code_array.shift() + "\n\n" + code_string + "\n\n" + merge_target + old_code_array.join(merge_target);
					} else {
						var _string = code_string + "\n\n" + merge_target + old_code_array.join('');
					}
				} else {
					var _string = old_code_string + "\n\n" + code_string;
				}
				Joomla.editors.instances[editor_id].setValue(_string.trim());
				return true;
			}
		} else {
			Joomla.editors.instances[editor_id].setValue(code_string.trim());
			return true;
		}
	} else {
		var old_code_string = jQuery('textarea#'+editor_id).val();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1) {
				if ('prepend' === merge_target) {
					var _string = code_string + "\n\n" + old_code_string;
				} else if (merge_target && 'append' !== merge_target) {
					var old_code_array = old_code_string.split(merge_target);
					if (old_code_array.length > 1) {
						var _string = old_code_array.shift() + "\n\n" + code_string + "\n\n" + merge_target + old_code_array.join(merge_target);
					} else {
						var _string = code_string + "\n\n" + merge_target + old_code_array.join('');
					}
				} else {
					var _string = old_code_string + "\n\n" + code_string;
				}
				jQuery('textarea#'+editor_id).val(_string.trim());
				return true;
			}
		} else {
			jQuery('textarea#'+editor_id).val(code_string.trim());
			return true;
		}
	}
	return false;
}


function removeCodeFromEditor(code_string, editor_id){
	if (Joomla.editors.instances.hasOwnProperty(editor_id)) {
		var old_code_string = Joomla.editors.instances[editor_id].getValue();
		if (old_code_string.length > 0) {
			// make sure string is found
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				Joomla.editors.instances[editor_id].setValue(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	} else {
		var old_code_string = jQuery('textarea#'+editor_id).val();
		if (old_code_string.length > 0) {
			// make sure string is found
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				jQuery('textarea#'+editor_id).val(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	}
	return false;
}


function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getEditCustomCodeButtons(){
	// get the id
	id = jQuery("#jform_id").val();
	getEditCustomCodeButtons_server(id).done(function(result) {
		if(isObject(result)){
			jQuery.each(result, function( field, buttons ) {
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
				jQuery.each(buttons, function( name, button ) {
					jQuery(".control-customcode-buttons-"+field).append(button);
				});
			});
		}
	})
}

// check object is not empty
function isObject(obj) {
	for(var prop in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, prop)) {
			return true;
		}
	}
	return false;
}

function getSnippetDetails(id){
	getCodeFrom_server(id, '_type', '_type', 'snippetDetails').done(function(result) {
		if(result.snippet){
			var description = '';
			if (result.description.length > 0) {
				description = '<p>'+result.description+'</p>';
			}
			var library = '';
			if (result.library.length > 0) {
				library = ' <b>('+result.library+')</b>';
			}
			var code = '<div id="snippet-code"><b>'+result.name+' ('+result.type+')</b> <a href="'+result.url+'" target="_blank" >see more details'+library+'</a><br /><em>'+result.heading+'</em><br /><textarea  id="snippet" class="span12" rows="11">'+result.snippet+'</textarea></div>';
			jQuery('#snippet-code').remove();
			jQuery('.snippet-code').append(code);
			// make sure the code block is active
			jQuery("#snippet").focus(function() {
				var jQuerythis = jQuery(this);
				jQuerythis.select();
			
				// Work around Chrome's little problem
				jQuerythis.mouseup(function() {
					// Prevent further mouseup intervention
					jQuerythis.unbind("mouseup");
					return false;
				});
			});
		}
		if(result.usage){
			var usage = '<div id="snippet-usage"><p>'+result.usage+'</p></div>';
			jQuery('#snippet-usage').remove();
			jQuery('.snippet-usage').append(usage);
		}
	})
}

// set snippets that are on the page
var snippetIds = [];
var snippets = {};
var snippet = 0;
jQuery(document).ready(function($)
{
	jQuery("#jform_snippet option").each(function()
	{
		var key =  jQuery(this).val();
		var text =  jQuery(this).text();
		snippets[key] = text;
		snippetIds.push(key);
	});
	snippet = jQuery("#jform_snippet").val();
	getSnippets();
});

function getSnippets(){
	jQuery("#loading").show();
	// clear the selection
	jQuery('#jform_snippet').find('option').remove().end();
	jQuery('#jform_snippet').trigger('liszt:updated');
	// get libraries value if set
	var libraries = jQuery("#jform_libraries").val();
	if (libraries) {
		getCodeFrom_server(1, JSON.stringify(libraries), 'libraries', 'getSnippets').done(function(result) {
			setSnippets(result);
			jQuery("#loading").hide();
			if (typeof snippetButton !== 'undefined') {
				// ensure button is correct
				var snippet = jQuery('#jform_snippet').val();
				snippetButton(snippet);
			}
		});
	}
	else
	{
		// load all snippets in none is selected
		setSnippets(snippetIds);
		jQuery("#loading").hide();
	}
}
function setSnippets(array){
	if (array) {
		jQuery('#jform_snippet').append('<option value="">'+select_a_snippet+'</option>');
		jQuery.each( array, function( i, id ) {
			if (id in snippets) {
				jQuery('#jform_snippet').append('<option value="'+id+'">'+snippets[id]+'</option>');
			}
			if (id == snippet) {
				jQuery('#jform_snippet').val(id);
			}
		});
	} else {
		jQuery('#jform_snippet').append('<option value="">'+create_a_snippet+'</option>');
	}
	jQuery('#jform_snippet').trigger('liszt:updated');
} 
