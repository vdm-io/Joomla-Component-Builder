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

function buildSubform()
{
	// get the subform
	$subform = JFormHelper::loadFieldType('subform', true);
	// make sure the layout is created
	// JLayoutHelper::render('assistantsubformrepeatable', null);
	// start building the subform field XML
	$subformXML = new SimpleXMLElement('<field/>');
	// subform attributes
	$subformAttribute = array(
		'type' => 'subform',
		'name' => 'views',
		'label' => 'COM_COMPONENTBUILDER_VIEW_BUILDER',
		'layout' => 'assistantsubformrepeatable',
		'multiple' => 'true',
		'icon' => 'list',
		'max' =>  20,
		'min' =>  1
	);
	// load the subform attributes
	ComponentbuilderHelper::xmlAddAttributes($subformXML, $subformAttribute);
	// now add the subform child form
	$childForm = $subformXML->addChild('form');
	// child form attributes
	$childFormAttribute = array(
		'hidden' => 'true',
		'name' => 'list_properties',
		'repeat' => 'true');
	// load the child form attributes
	ComponentbuilderHelper::xmlAddAttributes($childForm, $childFormAttribute);

	// view building the name field XML
	$nameXML = new SimpleXMLElement('<field/>');
	// subform attributes
	$nameAttribute = array(
		'type' => 'text',
		'name' => 'name',
		'label' => 'COM_COMPONENTBUILDER_VIEW_NAME',
		'size' => '40',
		'maxlength' => '150',
		'class' => 'text_area',
		'hint' => 'COM_COMPONENTBUILDER_VIEW_NAME',
		'filter' => 'STRING'
	);
	// load the subform attributes
	ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
	// now add the fields to the child form
	ComponentbuilderHelper::xmlAppend($childForm, $nameXML);

	// view building the list name field XML
	$listnameXML = new SimpleXMLElement('<field/>');
	// subform attributes
	$listnameAttribute = array(
		'type' => 'text',
		'name' => 'list_name',
		'label' => 'COM_COMPONENTBUILDER_LIST_VIEW_NAME',
		'size' => '40',
		'maxlength' => '150',
		'class' => 'text_area',
		'hint' => 'COM_COMPONENTBUILDER_LIST_VIEW_NAME',
		'filter' => 'STRING'
	);
	// load the subform attributes
	ComponentbuilderHelper::xmlAddAttributes($listnameXML, $listnameAttribute);
	// now add the fields to the child form
	ComponentbuilderHelper::xmlAppend($childForm, $listnameXML);

	// start building the builder area XML
	$noteXML = new SimpleXMLElement('<field/>');
	// subform attributes
	$noteAttribute = array(
		'type' => 'note',
		'name' => 'builder',
		'label' => 'COM_COMPONENTBUILDER_BUILDER',
		'description' => '
			<div class="uk-button-group uk-width-1-1">
				<a id="button-fields-[[[VDM]]]" class="uk-button uk-button-small uk-width-1-3"  href="#modal-fields-[[[VDM]]]" data-uk-modal onclick="setJCBuilder(this, 1)">' . JText::_('COM_COMPONENTBUILDER_FIELDS') . '</a>
				<a id="button-listview-[[[VDM]]]"  class="uk-button uk-button-small uk-width-1-3"  href="#modal-listview-[[[VDM]]]" data-uk-modal onclick="setJCBuilder(this, 2)">' . JText::_('COM_COMPONENTBUILDER_LIST_VIEW') . '</a>
				<a id="button-display-[[[VDM]]]"  class="uk-button uk-button-small uk-width-1-3"  href="#modal-display-[[[VDM]]]" data-uk-modal onclick="setJCBuilder(this, 3)">' . JText::_('COM_COMPONENTBUILDER_DISPLAY_VIEW') . '</a>
			</div><div class="builder"></div><br />',
		'heading' => 'h5'
	);
	// load the subform attributes
	ComponentbuilderHelper::xmlAddAttributes($noteXML, $noteAttribute);
	// now add the fields to the child form
	ComponentbuilderHelper::xmlAppend($childForm, $noteXML);

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///	FIELDS SUBFORM START
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// start building the subform field XML
		$sub_subformXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$sub_subformAttribute = array(
			'type' => 'subform',
			'name' => 'fields',
			'label' => 'COM_COMPONENTBUILDER_FIELD_BUILDER',
			'layout' => 'joomla.form.field.subform.repeatable-table',
			'multiple' => 'true',
			'icon' => 'list',
			'max' =>  20,
			'min' =>  1
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($sub_subformXML, $sub_subformAttribute);
		// now add the subform child form
		$sub_childform = $sub_subformXML->addChild('form');
		// child form attributes
		$sub_childformAttribute = array(
			'hidden' => 'true',
			'name' => 'list_properties',
			'repeat' => 'true');
		// load the child form attributes
		ComponentbuilderHelper::xmlAddAttributes($sub_childform, $sub_childformAttribute);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'text',
			'name' => 'name',
			'label' => 'COM_COMPONENTBUILDER_FIELD_NAME',
			'size' => '40',
			'maxlength' => '150',
			'class' => 'text_area',
			'hint' => 'COM_COMPONENTBUILDER_FIELD_NAME',
			'filter' => 'STRING'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the field type XML
		$fieldtypeXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$fieldtypeAttribute = array(
			'type' => 'fieldtypes',
			'name' => 'fieldtype',
			'label' => 'COM_COMPONENTBUILDER_FIELD_TYPE',
			'multiple' => false,
			'required' => true,
			'class' => 'btn-group',
			'addfieldpath' => '/administrator/components/com_componentbuilder/models/fields'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($fieldtypeXML, $fieldtypeAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $fieldtypeXML);

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///	FIELDPROPERTIES SUBFORM START
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// start building the subform field XML
			$sub_sub_subformXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$sub_sub_subformAttribute = array(
				'type' => 'subform',
				'name' => 'properties',
				'label' => 'COM_COMPONENTBUILDER_PROPERTIES',
				'layout' => 'joomla.form.field.subform.repeatable',
				'multiple' => 'true',
				'icon' => 'list'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($sub_sub_subformXML, $sub_sub_subformAttribute);
			// now add the subform child form
			$sub_sub_childform = $sub_sub_subformXML->addChild('form');
			// child form attributes
			$sub_sub_childformAttribute = array(
				'hidden' => 'true',
				'name' => 'list_properties',
				'repeat' => 'true');
			// load the child form attributes
			ComponentbuilderHelper::xmlAddAttributes($sub_sub_childform, $sub_sub_childformAttribute);

			// view building the list name field XML
			$propertiesXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$propertiesAttribute = array(
				'type' => 'text',
				'name' => 'property',
				'label' => 'COM_COMPONENTBUILDER_PROPERTY',
				'size' => '100',
				'maxlength' => '150',
				'class' => 'text_area',
				'hint' => 'COM_COMPONENTBUILDER_PROPERTY_NAME',
				'filter' => 'STRING'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($propertiesXML, $propertiesAttribute);
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_sub_childform, $propertiesXML);

			// view building the value field XML
			$valueXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$valueAttribute = array(
				'type' => 'text',
				'name' => 'value',
				'label' => 'COM_COMPONENTBUILDER_VALUE',
				'size' => '40',
				'maxlength' => '150',
				'class' => 'text_area',
				'hint' => 'COM_COMPONENTBUILDER_PROPERTY_VALUE',
				'filter' => 'STRING'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($valueXML, $valueAttribute);
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_sub_childform, $valueXML);

			// no add to main sub from
			ComponentbuilderHelper::xmlAppend($sub_childform, $sub_sub_subformXML);
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///	FIELDPROPERTIES SUBFORM END
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// no add to main sub from
		ComponentbuilderHelper::xmlAppend($childForm, $sub_subformXML);
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///	FIELDS SUBFORM END
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///	LISTVIEW SUBFORM END
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// start building the subform field XML
		$sub_subformXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$sub_subformAttribute = array(
			'type' => 'subform',
			'name' => 'columns',
			'label' => 'COM_COMPONENTBUILDER_LIST_VIEW_COLUMNS',
			'layout' => 'joomla.form.field.subform.repeatable-table',
			'multiple' => 'true',
			'icon' => 'list',
			'max' =>  2,
			'min' =>  1
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($sub_subformXML, $sub_subformAttribute);
		// now add the subform child form
		$sub_childform = $sub_subformXML->addChild('form');
		// child form attributes
		$sub_childformAttribute = array(
			'hidden' => 'true',
			'name' => 'list_properties',
			'repeat' => 'true');
		// load the child form attributes
		ComponentbuilderHelper::xmlAddAttributes($sub_childform, $sub_childformAttribute);

		// view building the name field XML
		$targetXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$targetAttribute = array(
			'type' => 'list',
			'name' => 'target',
			'label' => 'COM_COMPONENTBUILDER_TARGET',
			'description' => 'COM_COMPONENTBUILDER_AREA',
			'required' => true,
			'class' => 'list_class',
			'default' => '1'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($targetXML, $targetAttribute);
		// add the options
		ComponentbuilderHelper::xmlAddOptions($targetXML, array(1 => 'COM_COMPONENTBUILDER_ADMIN', 2 => 'COM_COMPONENTBUILDER_SITE'));
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $targetXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_0',
			'label' => 'COM_COMPONENTBUILDER_TITLE_COLUMN',
			'multiple' => false,
			'required' => true,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_1',
			'label' => 'COM_COMPONENTBUILDER_COLUMN',
			'multiple' => false,
			'required' => false,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_2',
			'label' => 'COM_COMPONENTBUILDER_COLUMN',
			'multiple' => false,
			'required' => false,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_3',
			'label' => 'COM_COMPONENTBUILDER_COLUMN',
			'multiple' => false,
			'required' => false,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_4',
			'label' => 'COM_COMPONENTBUILDER_COLUMN',
			'multiple' => false,
			'required' => false,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_5',
			'label' => 'COM_COMPONENTBUILDER_COLUMN',
			'multiple' => false,
			'required' => false,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_6',
			'label' => 'COM_COMPONENTBUILDER_COLUMN',
			'multiple' => false,
			'required' => false,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

		// view building the name field XML
		$nameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => 'viewfields',
			'name' => 'column_7',
			'label' => 'COM_COMPONENTBUILDER_COLUMN',
			'multiple' => false,
			'required' => false,
			'class' => 'list_class'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);


		// no add to main sub from
		ComponentbuilderHelper::xmlAppend($childForm, $sub_subformXML);
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///	LISTVIEW SUBFORM END
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///	DISPLAY START
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// start building the display area XML
		$displayXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$displayAttribute = array(
			'type' => 'note',
			'name' => 'display',
			'label' => 'COM_COMPONENTBUILDER_ITEM_DISPLAY',
			'description' => '
				<b>More details soon, to help build the site/front display of a single item.</b>',
			'heading' => 'h5'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($displayXML, $displayAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($childForm, $displayXML);
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///	DISPLAY END
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// setup subform with values
	$subform->setup($subformXML, null, 'jcbform');

	// return subfrom object
	return $subform;
}
// get the subform
$subform = buildSubform();

?>
<div class="control-label">
	<?php echo $subform->label; ?>
</div>
<div class="controls">
	<?php echo $subform->input; ?>
</div>
<script type="text/javascript">
function setJCBuilder(area, target){
	console.log(jQuery(area).attr('id'));
	console.log(target);
}
</script>
