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

/**
 * Componentbuilder View class for the Assistant
 */
class ComponentbuilderViewAssistant extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = JComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app = JFactory::getApplication();
		// get the user object
		$this->user = JFactory::getUser();
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('assistant');
		// Initialise variables.
		$this->item = $this->get('Item');
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('builder');
			JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=assistant');
			$this->sidebar = JHtmlSidebar::render();
		}
		// load jQuery sortable
		JHtml::_('jquery.ui', array('core', 'sortable'));
		// get the views forms
		$this->viewsSubform = $this->buildViewsSubform();

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// add the tool bar
			$this->addToolBar();
		}

		// set the document
		$this->setDocument();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode(PHP_EOL, $errors), 500);
		}

		parent::display($tpl);
	}

	protected function buildViewsSubform()
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
			'required' => true,
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
			'required' => true,
			'maxlength' => '150',
			'class' => 'text_area',
			'hint' => 'COM_COMPONENTBUILDER_LIST_VIEW_NAME',
			'filter' => 'STRING'
		);
		// load the subform attributes
		ComponentbuilderHelper::xmlAddAttributes($listnameXML, $listnameAttribute);
		// now add the fields to the child form
		ComponentbuilderHelper::xmlAppend($childForm, $listnameXML);

		// view building the list name field XML
		$listnameXML = new SimpleXMLElement('<field/>');
		// subform attributes
		$listnameAttribute = array(
			'type' => 'text',
			'name' => 'short_description',
			'label' => 'COM_COMPONENTBUILDER_SHORT_DESCRIPTION',
			'size' => '100',
			'required' => false,
			'maxlength' => '150',
			'class' => 'text_area span12',
			'hint' => 'COM_COMPONENTBUILDER_YOUR_SHORT_DESCRIPTION_HERE',
			'filter' => 'HTML'
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
					<a id="button-fields-[[[VDM]]]" class="uk-button uk-button-small uk-width-1-3"  href="#modal-fields-[[[VDM]]]" data-uk-modal onclick="setJCBuilder(this, \'[[[VDM]]]\', 1)">' . JText::_('COM_COMPONENTBUILDER_FIELDS') . '</a>
					<a id="button-listview-[[[VDM]]]"  class="uk-button uk-button-small uk-width-1-3"  href="#modal-listview-[[[VDM]]]" data-uk-modal onclick="setJCBuilder(this, \'[[[VDM]]]\', 2)">' . JText::_('COM_COMPONENTBUILDER_LIST_VIEW') . '</a>
					<a id="button-display-[[[VDM]]]"  class="uk-button uk-button-small uk-width-1-3"  href="#modal-display-[[[VDM]]]" data-uk-modal onclick="setJCBuilder(this, \'[[[VDM]]]\', 3)">' . JText::_('COM_COMPONENTBUILDER_DISPLAY_VIEW') . '</a>
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
				'class' => 'text_area field_name',
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
				'type' => 'list',
				'name' => 'type',
				'label' => 'COM_COMPONENTBUILDER_FIELD_TYPE',
				'onchange' => 'setFieldTypeOptions(this)',
				'multiple' => false,
				'required' => true,
				'class' => 'list_class'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($fieldtypeXML, $fieldtypeAttribute);
			// get field types active and available to the assistant
			$field_types = ComponentbuilderHelper::getFieldTypesByGroup(array('text', 'list', 'spacer'));
			$field_types_ids = array_keys($field_types);
			// add views option
			// $field_types[1111111] = 'COM_COMPONENTBUILDER_OTHER_VIEW';
			// sort
			uasort ($field_types , function ($a, $b) {
					return strnatcmp($a,$b);
				}
			);
			// add empty
			$_empty = array(0 => 'COM_COMPONENTBUILDER_SELECT_AN_OPTION');
			$field_types = $_empty + $field_types;
			// add the options
			ComponentbuilderHelper::xmlAddOptions($fieldtypeXML, $field_types);
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $fieldtypeXML);

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			///	FIELDPROPERTIES SUBFORM START
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// make sure the layout is created
				// JLayout Helper::render('assistantsubformfieldspropertiesrepeatable', null);
				// start building the subform field XML
				$sub_sub_subformXML = new SimpleXMLElement('<field/>');
				// subform attributes
				$sub_sub_subformAttribute = array(
					'type' => 'subform',
					'name' => 'properties',
					'label' => 'COM_COMPONENTBUILDER_PROPERTIES',
					'layout' => 'joomla.form.field.subform.repeatable',
					'multiple' => 'true',
					'min' => 1,
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

				// view building the property list field XML
				$propertiesXML = new SimpleXMLElement('<field/>');
				// subform attributes
				$propertiesAttribute = array(
					'type' => 'list',
					'name' => 'property',
					'label' => 'COM_COMPONENTBUILDER_PROPERTY',
					'onchange' => 'setPropertyDefaultValue(this)',
					'multiple' => false,
					'class' => 'list_class'
				);
				// load the subform attributes
				ComponentbuilderHelper::xmlAddAttributes($propertiesXML, $propertiesAttribute);
				// get properties
				$field_properties = ComponentbuilderHelper::getFieldTypesProperties($field_types_ids, array('adjustable' => 1), array('label', 'type', 'name'));
				// add as json to document
				$this->document->addScriptDeclaration("var fieldtype_properties = " . json_encode($field_properties['types']) . ";");
				// sort
				uasort ($field_properties['properties'] , function ($a, $b) {
						return strnatcmp($a,$b);
					}
				);
				// add empty
				$field_properties['properties'] = $_empty + $field_properties['properties'];
				// add other
				$field_properties['properties']['other']  = 'COM_COMPONENTBUILDER_OTHER';
				// add the options
				ComponentbuilderHelper::xmlAddOptions($propertiesXML, $field_properties['properties']);
				// now add the fields to the child form
				ComponentbuilderHelper::xmlAppend($sub_sub_childform, $propertiesXML);

				// view building the value field XML
				$valueXML = new SimpleXMLElement('<field/>');
				// subform attributes
				$valueAttribute = array(
					'type' => 'text',
					'name' => 'other',
					'label' => 'COM_COMPONENTBUILDER_OTHER',
					'description' => 'COM_COMPONENTBUILDER_MAKE_SURE_THAT_YOU_USE_THE_BCORRECT_PROPERTY_NAMEB_THAT_EXIST_IN_JCB_FOR_THIS_FIELD_TYPE',
					'size' => '40',
					'maxlength' => '150',
					'class' => 'text_area',
					'hint' => 'COM_COMPONENTBUILDER_PROPERTY_NAME',
					'filter' => 'WORD',
					'showon' => 'property:other'
				);
				// load the subform attributes
				ComponentbuilderHelper::xmlAddAttributes($valueXML, $valueAttribute);
				// now add the fields to the child form
				ComponentbuilderHelper::xmlAppend($sub_sub_childform, $valueXML);

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
				'layout' => 'joomla.form.field.subform.repeatable',
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
				'default' => '3'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($targetXML, $targetAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($targetXML, array(3 => 'COM_COMPONENTBUILDER_BOTH', 1 => 'COM_COMPONENTBUILDER_ADMIN', 2 => 'COM_COMPONENTBUILDER_SITE'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $targetXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_1',
				'label' => 'COM_COMPONENTBUILDER_FIRSTTITLE_COLUMN',
				'multiple' => false,
				'required' => true,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_2',
				'label' => 'COM_COMPONENTBUILDER_SECOND_COLUMN',
				'multiple' => false,
				'required' => false,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_3',
				'label' => 'COM_COMPONENTBUILDER_THIRD_COLUMN',
				'multiple' => false,
				'required' => false,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_4',
				'label' => 'COM_COMPONENTBUILDER_FORTH_COLUMN',
				'multiple' => false,
				'required' => false,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_5',
				'label' => 'COM_COMPONENTBUILDER_FIFTH_COLUMN',
				'multiple' => false,
				'required' => false,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_6',
				'label' => 'COM_COMPONENTBUILDER_SITH_COLUMN',
				'multiple' => false,
				'required' => false,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_7',
				'label' => 'COM_COMPONENTBUILDER_SEVENT_COLUMN',
				'multiple' => false,
				'required' => false,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
			// now add the fields to the child form
			ComponentbuilderHelper::xmlAppend($sub_childform, $nameXML);

			// view building the name field XML
			$nameXML = new SimpleXMLElement('<field/>');
			// subform attributes
			$nameAttribute = array(
				'type' => 'list',
				'name' => 'column_8',
				'label' => 'COM_COMPONENTBUILDER_EIGHT_COLUMN',
				'multiple' => false,
				'required' => false,
				'class' => 'list_class list_view_field_option'
			);
			// load the subform attributes
			ComponentbuilderHelper::xmlAddAttributes($nameXML, $nameAttribute);
			// add the options
			ComponentbuilderHelper::xmlAddOptions($nameXML, array(0 => 'COM_COMPONENTBUILDER_INACTIVE_COLUMN', 1 => 'COM_COMPONENTBUILDER_NO_FIELDS_SET'));
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
				'label' => 'COM_COMPONENTBUILDER_SINGLE_ITEM_DISPLAY_EDITOR_OF_THE_SITE_VIEW',
				'description' => '<div id="gjs-[[[VDM]]]"></div>',
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

	/**
	 * Prepares the document
	 */
	protected function setDocument()
	{

		// always make sure jquery is loaded.
		JHtml::_('jquery.framework');
		// Load the header checker class.
		require_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/headercheck.php' );
		// Initialize the header checker.
		$HeaderCheck = new componentbuilderHeaderCheck;

		// always load these files.
		$this->document->addStyleSheet(JURI::root(true) . "/media/com_componentbuilder/grapejs/css/grapes.min.css", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/css");
		$this->document->addStyleSheet(JURI::root(true) . "/media/com_componentbuilder/grapejs/css/grapesjs-preset-webpage.min.css", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/css");
		$this->document->addScript(JURI::root(true) . "/media/com_componentbuilder/grapejs/js/grapes.min.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");
		$this->document->addScript(JURI::root(true) . "/media/com_componentbuilder/grapejs/js/grapesjs-preset-webpage.min.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");

		// Add View JavaScript File
		$this->document->addScript(JURI::root(true) . "/administrator/components/com_componentbuilder/assets/js/assistant.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/uikit'.$style.$size.'.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/uikit'.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		}

		// Load the script to find all uikit components needed.
		if ($uikit != 2)
		{
			// Set the default uikit components in this view.
			$uikitComp = array();
			$uikitComp[] = 'UIkit.notify';
			$uikitComp[] = 'data-uk-grid';
			$uikitComp[] = 'data-uk-tooltip';
		}

		// Load the needed uikit components in this view.
		if ($uikit != 2 && isset($uikitComp) && ComponentbuilderHelper::checkArray($uikitComp))
		{
			// load just in case.
			jimport('joomla.filesystem.file');
			// loading...
			foreach ($uikitComp as $class)
			{
				foreach (ComponentbuilderHelper::$uk_components[$class] as $name)
				{
					// check if the CSS file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
					}
					// check if the JavaScript file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);
					}
				}
			}
		}
		// add marked library
		$this->document->addScript(JURI::root() . "administrator/components/com_componentbuilder/custom/marked.js");
		
		// Add the JavaScript for JStore
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jquery.json.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jstorage.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/strtotime.js');
		// check if we should use browser storage
		$setBrowserStorage = $this->params->get('set_browser_storage', null);
		if ($setBrowserStorage)
		{
			// check what (Time To Live) show we use
			$storageTimeToLive = $this->params->get('storage_time_to_live', 'global');
			if ('global' == $storageTimeToLive)
			{
				// use the global session time
				$session = JFactory::getSession();
				// must have itin milliseconds
				$expire = ($session->getExpire()*60)* 1000;
			}
			else
			{
				// use the Componentbuilder Global setting
				if (0 !=  $storageTimeToLive)
				{
					// this will convert the time into milliseconds
					$storageTimeToLive =  $storageTimeToLive * 1000;
				}
				$expire = $storageTimeToLive;
			}
		}
		else
		{
			// set to use no storage
			$expire = 30000; // only 30 seconds
		}
		// Set the Time To Live To JavaScript
		$this->document->addScriptDeclaration("var expire = ". (int) $expire.";");
		// set snippet path
		$this->document->addScriptDeclaration("var planPath = '';");
		$this->document->addScriptDeclaration("var plansPath = '';");
		// $this->document->addScriptDeclaration("var planPath = '". ComponentbuilderHelper::$planPath ."';");
		// $this->document->addScriptDeclaration("var plansPath = '". ComponentbuilderHelper::$plansPath ."';");
		// token
		$this->document->addScriptDeclaration("var token = '". JSession::getFormToken() ."';");
		// add some global items buckets for bulk updating
		$this->document->addScriptDeclaration("var bulkItems = {};");
		$this->document->addScriptDeclaration("bulkItems.new = [];");
		$this->document->addScriptDeclaration("bulkItems.diverged = [];");
		$this->document->addScriptDeclaration("bulkItems.ahead = [];");
		$this->document->addScriptDeclaration("bulkItems.behind = [];");
		// set an error message if needed
		$this->document->addScriptDeclaration("var returnError = '<div class=\"uk-alert uk-alert-warning\"><h1>".JText::_('COM_COMPONENTBUILDER_AN_ERROR_HAS_OCCURRED')."!</h1><p>".JText::_('COM_COMPONENTBUILDER_PLEASE_TRY_AGAIN_LATER').".</p></div>';");
		// need to add some language strings
		JText::script('COM_COMPONENTBUILDER_JCB_COMMUNITY_PLANS');
		JText::script('COM_COMPONENTBUILDER_PLANS');
		JText::script('COM_COMPONENTBUILDER_PLAN');
		JText::script('COM_COMPONENTBUILDER_VIEW_PLAN_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_PLAN');
		JText::script('COM_COMPONENTBUILDER_LOCAL_PLAN');
		JText::script('COM_COMPONENTBUILDER_GET_THE_PLAN_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_THE_PLAN_FROM_GITHUB_AND_INSTALL_IT_LOCALLY');
		JText::script('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_USAGE');
		JText::script('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_DESCRIPTION');
		JText::script('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_VIEW_BLAME');
		JText::script('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_PLAN');
		JText::script('COM_COMPONENTBUILDER_VIEW_PLAN_REFERENCE_URL');
		JText::script('COM_COMPONENTBUILDER_PLAN_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_PLANS_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR');
		JText::script('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS');
		JText::script('COM_COMPONENTBUILDER_JCB_COMMUNITY');
		JText::script('COM_COMPONENTBUILDER_COMPANY_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_EMAIL');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_WEBSITE');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_PLANS_TO_UPDATE_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_AVAILABLE_CATEGORIES');
		JText::script('COM_COMPONENTBUILDER_OPEN_CATEGORY_PLANS');
		// for the views tab
		JText::script('COM_COMPONENTBUILDER_ERROR_FIELD_TYPE_DOES_NOT_EXIST');
		JText::script('COM_COMPONENTBUILDER_HAS_THESE_AVAILABLE_PROPERTIES');
		JText::script('COM_COMPONENTBUILDER_PROPERTY_VALUE_IS_MANDATORY');
		JText::script('COM_COMPONENTBUILDER_PROPERTY_VALUE_IS_TRANSLATABLE');
		JText::script('COM_COMPONENTBUILDER_NOT_AVAILABLE');
		JText::script('COM_COMPONENTBUILDER_INACTIVE_COLUMN');
		// Set the local plans array
		$this->document->addScriptDeclaration("var local_plans = '';");
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_componentbuilder/assets/css/assistant.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// hide the main menu
		$this->app->input->set('hidemainmenu', true);
		// set the title
		if (isset($this->item->name) && $this->item->name)
		{
			$title = $this->item->name;
		}
		// Check for empty title and add view name if param is set
		if (empty($title))
		{
			$title = JText::_('COM_COMPONENTBUILDER_ASSISTANT');
		}
		// add title to the page
		JToolbarHelper::title($title,'heart');
		// add the back button
		// JToolBarHelper::custom('assistant.back', 'undo-2', '', 'COM_COMPONENTBUILDER_BACK', false);
		// add cpanel button
		JToolBarHelper::custom('assistant.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('assistant');
		if (ComponentbuilderHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_componentbuilder');
		}
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		// use the helper htmlEscape method instead.
		return ComponentbuilderHelper::htmlEscape($var, $this->_charset);
	}
}
?>
