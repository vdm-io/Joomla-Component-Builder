<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */



use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Import\Factory as ImportFactory;
use VDM\Joomla\Utilities\FormHelper;
use Joomla\CMS\Form\FormHelper as FormFormHelper;

// No direct access to this file
defined('JPATH_BASE') or die;

$headers = null;
$file = null;

// Check if 'data' exists and is an array with at least one file
if (!empty($displayData['data']) && is_array($displayData['data']))
{
	// Retrieve the first file
	$file = array_values($displayData['data'])[0];

	// Fetch the headers for the file
	if (is_object($file) && isset($file->file_path))
	{
		$headers = ImportFactory::_('Spreadsheet.Header')->get($file->file_path);
	}
}

// Helper function to append a field to a form element
function appendFieldToForm(\SimpleXMLElement $form, array $attributes, ?array $options = null) {
	// Create the field XML element
	$fieldXML = new \SimpleXMLElement('<field/>');

	// Set attributes for the field
	FormHelper::attributes($fieldXML, $attributes);

	// Set Options
	if (!empty($options))
	{
		FormHelper::options($fieldXML, $options);
	}

	// Append the field XML to the form
	FormHelper::append($form, $fieldXML);
}

// Initialize the FORM if we have headers
$map = null;
if (!empty($headers))
{
	// we update the global headers
	ComponentbuilderHelper::setSpreadsheetHeaders($headers);

	// get subform values
	$values = ComponentbuilderHelper::getItemImportSubformValues();
	$targets = ComponentbuilderHelper::getLanguageTranslationsHeaders(true);

	// get the amount of rows expected
	$rows = count($headers);

	// Add the component field prefix
	FormFormHelper::addFieldPrefix('VDM\Component\Componentbuilder\Administrator\Field');
	// Add the component rule prefix
	FormFormHelper::addRulePrefix('VDM\Component\Componentbuilder\Administrator\Rule');

	// ADD any other field HERE that needs special attention !!!

	// Load the map 'subform' field type
	$map = FormFormHelper::loadFieldType('subform', true);

	// Create the root field element for the subform XML
	$mapXML = new \SimpleXMLElement('<field/>');
	
	// Define the attributes for the subform field
	$mapAttributes = [
		'type' => 'subform',
		'name' => 'maps',
		'label' => 'COM_COMPONENTBUILDER_MAP',
		'layout' => 'joomla.form.field.subform.repeatable-table',
		'buttons' => 'false',
		'multiple' => 'true',
		'icon' => 'list',
		'min' => $rows,
		'max' => $rows
	];

	// Set the attributes for the subform field
	FormHelper::attributes($mapXML, $mapAttributes);

	// Add the child form element inside the subform
	$childForm = $mapXML->addChild('form');
	
	// Define the attributes for the child form
	$childFormAttributes = [
		'hidden' => 'true',
		'name' => 'list_maps_modal',
		'repeat' => 'true'
	];

	// Set the attributes for the child form
	FormHelper::attributes($childForm, $childFormAttributes);

	// Build and append column field XML to the child form
	appendFieldToForm($childForm, [
		'type' => 'list',
		'name' => 'column',
		'label' => 'COM_COMPONENTBUILDER_COLUMN',
		'description' => 'COM_COMPONENTBUILDER_THE_SPREADSHEET_COLUMNS',
		'class' => 'list_class',
		'readonly' => 'true',
		'layout' => 'joomla.form.field.list-fancy-select'
	], $headers);

	// Build and append target field XML to the child form
	appendFieldToForm($childForm, [
		'type' => 'list',
		'name' => 'target',
		'label' => 'COM_COMPONENTBUILDER_SYSTEM_TARGET_FIELDS',
		'description' => 'COM_COMPONENTBUILDER_THE_SYSTEM_TARGET_DATABASE_FIELDS',
		'message' => 'COM_COMPONENTBUILDER_INPUT_REQUIRED',
		'class' => 'list_class',
		'layout' => 'joomla.form.field.list-fancy-select'
	], $targets);

	// Setup the subform with the constructed XML
	$map->setup($mapXML, $values, 'vdm_import');
}

?>
<?php // echo LayoutHelper::render('filedisplay', $displayData); ?>
<?php if ($map === null): ?>
	<?php echo Text::_('COM_COMPONENTBUILDER_SPREADSHEET_SEEMS_TO_HAVE_NO_HEADERS_SET_THERE_WAS_AN_ERROR'); ?>
<?php else: ?>
	<div id="subform-display-area">

		<?php echo $map->input; ?>

		<input type="hidden" name="vdm_import[file]" value="<?php echo $displayData['entity'] ?? 'error'; ?>">

		<joomla-toolbar-button id="toolbar-download-custom-button-saveimportmap" task=" import_translations.importLanguageTranslations">
			<div class="d-grid">
				<button class="button-download custom-button-saveimportmap btn btn-primary" type="button">
					<span class="icon-download custom-button-saveimportmap" aria-hidden="true"></span>
					<?php echo Text::_('COM_COMPONENTBUILDER_IMPORT'); ?>
				</button>
			</div>
		</joomla-toolbar-button>
	</div>
<?php endif;  ?>
