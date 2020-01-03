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
		'max' =>  5,
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
				<a class="uk-button uk-button-small uk-width-1-3"  href="#jcbuilder" data-uk-modal="{center:true}" onclick="setJCBuilder(this, 1)">' . JText::_('COM_COMPONENTBUILDER_FIELDS') . '</a>
				<a class="uk-button uk-button-small uk-width-1-3"  href="#jcbuilder" data-uk-modal="{center:true}" onclick="setJCBuilder(this, 2)">' . JText::_('COM_COMPONENTBUILDER_LIST_VIEW') . '</a>
				<a class="uk-button uk-button-small uk-width-1-3"  href="#jcbuilder" data-uk-modal="{center:true}" onclick="setJCBuilder(this, 3)">' . JText::_('COM_COMPONENTBUILDER_DISPLAY_VIEW') . '</a>
			</div><div class="builder"></div><br />',
		'heading' => 'h5'
	);
	// load the subform attributes
	ComponentbuilderHelper::xmlAddAttributes($noteXML, $noteAttribute);
	// now add the fields to the child form
	ComponentbuilderHelper::xmlAppend($childForm, $noteXML);

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
<div id="jcbuilder" class="uk-modal">
	<div class="uk-modal-dialog uk-modal-dialog-large">
		<button class="uk-modal-close uk-close" type="button"></button>
		<div class="loading">loading..<span class="loading-dots"></span></div>
		<div id="jcbbuilder-display" class="uk-panel">
		</div>
	</div>
</div>
<script type="text/javascript">
function setJCBuilder(area, target){
	console.log(area);
	console.log(target);
}
</script>
