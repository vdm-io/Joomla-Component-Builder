<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<div class="control-label">
	<?php echo $this->viewsSubform->label; ?>
</div>
<div class="controls">
	<?php echo $this->viewsSubform->input; ?>
</div>
<script type="text/javascript">
var active_view = 'view0';
var active_editors = {};
var last_editors = {};
var created_fields = {};
jQuery(document).on('subform-row-add', function(event, row){
	setFieldNames();
	setListViewFieldOptions();
});
function setJCBuilder(area, view, target){
	// set the active view 
	active_view = view;
	// build fields
	if (target == 2){
		setFieldNames();
		setListViewFieldOptions();
	} else if (target == 3 && !active_editors.hasOwnProperty(view)) {
		// update the editor (let grape js know)
		initializeGrapesjs();
	}
}
function initializeGrapesjs(){
	active_editors[active_view] = grapesjs.init({
		// Indicate where to init the editor. You can also pass an HTMLElement
		container: '#gjs-'+active_view,
		// Get the content for the canvas directly from the element
		fromElement: true,
		// Size of the editor
		height: '500px',
		width: 'auto',
		// Default configurations
		storageManager: { autoload: 1 },
		// basic block manager
		plugins: ['gjs-preset-webpage'],
	});
}
function setListViewFieldOptions(){
	// build fields
	if (created_fields.hasOwnProperty(active_view)){
		jQuery('#modal-listview-' + active_view).find('.list_view_field_option').each(function( i, field ) {
			// get field ID
			var field_id = jQuery(field).attr('id');
			// get the value selected
			var selected_value =  jQuery("#" + field_id + " option:selected").val();
			// clear the options out
			jQuery("#" + field_id).find('option').remove().end();
			// add inactive value
			jQuery('#' + field_id).append('<option value="0">' + Joomla.JText._('COM_COMPONENTBUILDER_INACTIVE_COLUMN') + '</option>');
			// add fields available
			jQuery.each( created_fields[active_view], function( id, name ) {
				jQuery('#'+ field_id).append('<option value="' + name + '">' + name + '</option>');
			});
			jQuery('#' + field_id).val(selected_value);
			jQuery('#' + field_id).trigger('liszt:updated');
		});
	}
}
function setFieldNames(){
	// always reset
	created_fields[active_view] = {};
	// build fields
	jQuery('#modal-fields-' + active_view).find('.field_name').each(function( i, field ) {
		// get field name  ID
		var field_name_id = jQuery(field).attr('id');
		// get the value selected
		var field_name_value =  jQuery("#" + field_name_id).val();
		// add/update field
		created_fields[active_view][field_name_id] = field_name_value;
	});
}
function setFieldTypeOptions(obj){
	// get type id
	var type_id = jQuery(obj).attr('id');
	// setup help ID
	var help_id = 'help_' + type_id;
	// clear past help messages
	jQuery('#' + help_id).remove();
	// get the type value
	var type_value = jQuery('#' + type_id).val();
	var type_text = jQuery('#' + type_id + ' option:selected').text();
	// show what is available
	if (typeof fieldtype_properties[type_value] === "undefined"){
		var help_note = '<div id="' + help_id + '">' + Joomla.JText._('COM_COMPONENTBUILDER_ERROR_FIELD_TYPE_DOES_NOT_EXIST') + '</div>';
	} else {
		var help_note = '<div id="' + help_id + '" data-uk-check-display>' + type_text + ' ' + Joomla.JText._('COM_COMPONENTBUILDER_HAS_THESE_AVAILABLE_PROPERTIES') + ':<ul class="uk-list">';
		for (var key in fieldtype_properties[type_value]) {
			if (fieldtype_properties[type_value].hasOwnProperty(key)) {
				if (fieldtype_properties[type_value][key].mandatory){
					var mandatory = '<span style="color:red" data-uk-tooltip title="' + Joomla.JText._('COM_COMPONENTBUILDER_PROPERTY_VALUE_IS_MANDATORY') + '"><i class="uk-icon-asterisk"></i></span>&nbsp;';
				} else {
					var mandatory = '<i class="uk-icon-angle-right"></i>&nbsp;&nbsp;&nbsp;';
				}
				if (fieldtype_properties[type_value][key].translatable){
					var translatable = '&nbsp;&nbsp;<span data-uk-tooltip title="' + Joomla.JText._('COM_COMPONENTBUILDER_PROPERTY_VALUE_IS_TRANSLATABLE') + '"><i class="uk-icon-language uk-icon-small"></i></span>';
				} else {
					var translatable = '';
				}
				help_note += '<li>' + mandatory + '<span data-uk-tooltip title="' + fieldtype_properties[type_value][key].description + '">' + fieldtype_properties[type_value][key].name + '</span>' + translatable + '</li>';
			}
		}
		help_note += '</ul></div>';
	}
	// add help note
	jQuery(help_note).insertAfter(jQuery('#' + type_id).closest('.control-group'));
}
function setPropertyDefaultValue(obj){
	// get property id
	var property_id = jQuery(obj).attr('id');
	// get the property value
	var property_value = jQuery('#' + property_id).val();
	// get base line
	var base = property_id.split('__properties__properties');
	// get the type id
	var type_id = base[0] + '__type';
	// get the type value
	var type_value = jQuery('#' + type_id).val();
	var type_text = jQuery('#' + type_id + ' option:selected').text();
	// get property value id
	var value_id =  jQuery.string_replace('__property', '__value', property_id);
	// get the example/default value
	if (typeof fieldtype_properties[type_value] === "undefined" ||
	typeof fieldtype_properties[type_value][property_value] === "undefined"){
		var value = Joomla.JText._('COM_COMPONENTBUILDER_NOT_AVAILABLE');
		var readonly = true;
	} else {
		var value = fieldtype_properties[type_value][property_value].example;
		var readonly = false;
	}
	// set the property default value
	jQuery('#' + value_id).val(value);
	// make read only or not as needed
	document.getElementById(value_id).readOnly = readonly;
}
</script>
