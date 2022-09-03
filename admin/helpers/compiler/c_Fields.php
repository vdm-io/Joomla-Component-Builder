<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;

/**
 * Compiler class
 */
class Fields extends Structure
{


	/**
	 * Metadate Switch
	 *
	 * @var    array
	 */
	public $metadataBuilder = array();

	/**
	 * View access Switch
	 *
	 * @var    array
	 */
	public $accessBuilder = array();

	/**
	 * edit view tabs counter
	 *
	 * @var    array
	 */
	public $tabCounter = array();

	/**
	 * layout builder
	 *
	 * @var    array
	 */
	public $layoutBuilder = array();

	/**
	 * permissions builder
	 *
	 * @var    array
	 */
	public $hasPermissions = array();

	/**
	 * used to fix the zero order
	 *
	 * @var    array
	 */
	private $zeroOrderFix = array();

	/**
	 * Site field data
	 *
	 * @var    array
	 */
	public $siteFieldData = array();

	/**
	 * list of fields that are not being escaped
	 *
	 * @var    array
	 */
	public $doNotEscape = array();

	/**
	 * list of classes used in the list view for the fields
	 *
	 * @var    array
	 */
	public $listFieldClass = array();

	/**
	 * tags builder
	 *
	 * @var    array
	 */
	public $tagsBuilder = array();

	/**
	 * query builder
	 *
	 * @var    array
	 */
	public $queryBuilder = array();

	/**
	 * unique keys for database field
	 *
	 * @var    array
	 */
	public $dbUniqueKeys = array();

	/**
	 * unique guid swtich
	 *
	 * @var    array
	 */
	public $dbUniqueGuid = array();

	/**
	 * keys for database field
	 *
	 * @var    array
	 */
	public $dbKeys = array();

	/**
	 * history builder
	 *
	 * @var    array
	 */
	public $historyBuilder = array();

	/**
	 * alias builder
	 *
	 * @var    array
	 */
	public $aliasBuilder = array();

	/**
	 * title builder
	 *
	 * @var    array
	 */
	public $titleBuilder = array();

	/**
	 * list builder
	 *
	 * @var    array
	 */
	public $listBuilder = array();

	/**
	 * custom Builder List
	 *
	 * @var    array
	 */
	public $customBuilderList = array();

	/**
	 * Hidden Fields Builder
	 *
	 * @var    array
	 */
	public $hiddenFieldsBuilder = array();

	/**
	 * INT Field Builder
	 *
	 * @var    array
	 */
	public $intFieldsBuilder = array();

	/**
	 * Dynamic Fields Builder
	 *
	 * @var    array
	 */
	public $dynamicfieldsBuilder = array();

	/**
	 * Main text Builder
	 *
	 * @var    array
	 */
	public $maintextBuilder = array();

	/**
	 * Custom Builder
	 *
	 * @var    array
	 */
	public $customBuilder = array();

	/**
	 * Custom Field Links Builder
	 *
	 * @var    array
	 */
	public $customFieldLinksBuilder = array();

	/**
	 * Set Script for User Switch
	 *
	 * @var    array
	 */
	public $setScriptUserSwitch = array();

	/**
	 * Set Script for Media Switch
	 *
	 * @var    array
	 */
	public $setScriptMediaSwitch = array();

	/**
	 * Category builder
	 *
	 * @var    array
	 */
	public $categoryBuilder = array();

	/**
	 * Category Code builder
	 *
	 * @var    array
	 */
	public $catCodeBuilder = array();

	/**
	 * Check Box builder
	 *
	 * @var    array
	 */
	public $checkboxBuilder = array();

	/**
	 * Json String Builder
	 *
	 * @var    array
	 */
	public $jsonStringBuilder = array();

	/**
	 * Json String Builder for return values to array
	 *
	 * @var    array
	 */
	public $jsonItemBuilderArray = array();

	/**
	 * Json Item Builder
	 *
	 * @var    array
	 */
	public $jsonItemBuilder = array();

	/**
	 * Base 64 Builder
	 *
	 * @var    array
	 */
	public $base64Builder = array();

	/**
	 * Basic Encryption Field Modeling
	 *
	 * @var    array
	 */
	public $basicFieldModeling = array();

	/**
	 * WHMCS Encryption Field Modeling
	 *
	 * @var    array
	 */
	public $whmcsFieldModeling = array();

	/**
	 * Medium Encryption Field Modeling
	 *
	 * @var    array
	 */
	public $mediumFieldModeling = array();

	/**
	 * Expert Field Modeling
	 *
	 * @var    array
	 */
	public $expertFieldModeling = array();

	/**
	 * Expert Mode Initiator
	 *
	 * @var    array
	 */
	public $expertFieldModelInitiator = array();

	/**
	 * Get Items Method List String Fix Builder
	 *
	 * @var    array
	 */
	public $getItemsMethodListStringFixBuilder = array();

	/**
	 * Get Items Method Eximport String Fix Builder
	 *
	 * @var    array
	 */
	public $getItemsMethodEximportStringFixBuilder = array();

	/**
	 * Selection Translation Fix Builder
	 *
	 * @var    array
	 */
	public $selectionTranslationFixBuilder = array();

	/**
	 * Sort Builder
	 *
	 * @var    array
	 */
	public $sortBuilder = array();

	/**
	 * Search Builder
	 *
	 * @var    array
	 */
	public $searchBuilder = array();

	/**
	 * Filter Builder
	 *
	 * @var    array
	 */
	public $filterBuilder = array();

	/**
	 * Set Group Control
	 *
	 * @var    array
	 */
	public $setGroupControl = array();

	/**
	 * Set Field Names
	 *
	 * @var    array
	 */
	public $fieldsNames = array();

	/**
	 * Default Fields set to publishing
	 *
	 * @var    array
	 */
	public $newPublishingFields = array();

	/**
	 * Default Fields set to publishing
	 *
	 * @var    array
	 */
	public $movedPublishingFields = array();

	/**
	 * set the Field set of a view
	 *
	 * @param   array   $view            The view data
	 * @param   string  $component       The component name
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 */
	public function setFieldSet($view, $component, $nameSingleCode,
		$nameListCode
	) {
		// setup the fieldset of this view
		if (isset($view['settings']->fields)
			&& ArrayHelper::check($view['settings']->fields))
		{
			// add metadata to the view
			if (isset($view['metadata']) && $view['metadata'])
			{
				$this->metadataBuilder[$nameSingleCode] = $nameListCode;
			}
			// add access to the view
			if (isset($view['access']) && $view['access'])
			{
				$this->accessBuilder[$nameSingleCode] = $nameListCode;
			}
			// main lang prefix
			$langView  = CFactory::_('Config')->lang_prefix . '_'
				. CFactory::_('Placeholder')->active[Placefix::_h('VIEW')];
			$langViews = CFactory::_('Config')->lang_prefix . '_'
				. CFactory::_('Placeholder')->active[Placefix::_h('VIEWS')];
			// set default lang
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView, $view['settings']->name_single
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews, $view['settings']->name_list
			);
			// set global item strings
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_ARCHIVED',
				"%s " . $view['settings']->name_list . " archived."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_ARCHIVED_1',
				"%s " . $view['settings']->name_single . " archived."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_CHECKED_IN_0',
				"No " . $view['settings']->name_single
				. " successfully checked in."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_CHECKED_IN_1',
				"%d " . $view['settings']->name_single
				. " successfully checked in."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_CHECKED_IN_MORE',
				"%d " . $view['settings']->name_list
				. " successfully checked in."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_DELETED',
				"%s " . $view['settings']->name_list . " deleted."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_DELETED_1',
				"%s " . $view['settings']->name_single . " deleted."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_FEATURED',
				"%s " . $view['settings']->name_list . " featured."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_FEATURED_1',
				"%s " . $view['settings']->name_single . " featured."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_PUBLISHED',
				"%s " . $view['settings']->name_list . " published."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_PUBLISHED_1',
				"%s " . $view['settings']->name_single . " published."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_TRASHED',
				"%s " . $view['settings']->name_list . " trashed."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_TRASHED_1',
				"%s " . $view['settings']->name_single . " trashed."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_UNFEATURED',
				"%s " . $view['settings']->name_list . " unfeatured."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_UNFEATURED_1',
				"%s " . $view['settings']->name_single . " unfeatured."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_UNPUBLISHED',
				"%s " . $view['settings']->name_list . " unpublished."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_UNPUBLISHED_1',
				"%s " . $view['settings']->name_single . " unpublished."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_FAILED_PUBLISHING',
				"%s " . $view['settings']->name_list . " failed publishing."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_N_ITEMS_FAILED_PUBLISHING_1',
				"%s " . $view['settings']->name_single . " failed publishing."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_BATCH_OPTIONS',
				"Batch process the selected " . $view['settings']->name_list
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langViews . '_BATCH_TIP',
				"All changes will be applied to all selected "
				. $view['settings']->name_list
			);
			// set some basic defaults
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_ERROR_UNIQUE_ALIAS',
				"Another " . $view['settings']->name_single
				. " has the same alias."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_CREATED_DATE_LABEL', "Created Date"
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_CREATED_DATE_DESC',
				"The date this " . $view['settings']->name_single
				. " was created."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_MODIFIED_DATE_LABEL', "Modified Date"
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_MODIFIED_DATE_DESC',
				"The date this " . $view['settings']->name_single
				. " was modified."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_CREATED_BY_LABEL', "Created By"
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_CREATED_BY_DESC',
				"The user that created this " . $view['settings']->name_single
				. "."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_MODIFIED_BY_LABEL', "Modified By"
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_MODIFIED_BY_DESC',
				"The last user that modified this "
				. $view['settings']->name_single . "."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_ORDERING_LABEL', "Ordering"
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_VERSION_LABEL', "Version"
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_VERSION_DESC',
				"A count of the number of times this "
				. $view['settings']->name_single . " has been revised."
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $langView . '_SAVE_WARNING',
				"Alias already existed so a number was added at the end. You can re-edit the "
				. $view['settings']->name_single . " to customise the alias."
			);
			// check what type of field builder to use
			if (CFactory::_('Config')->get('field_builder_type', 2) == 1)
			{
				// build field set using string manipulation
				return $this->stringFieldSet(
					$view, $component, $nameSingleCode, $nameListCode,
					$langView, $langViews
				);
			}
			else
			{
				// build field set with simpleXMLElement class
				return $this->simpleXMLFieldSet(
					$view, $component, $nameSingleCode, $nameListCode,
					$langView, $langViews
				);
			}
		}

		return '';
	}

	/**
	 * build field set using string manipulation
	 *
	 * @param   array   $view            The view data
	 * @param   string  $component       The component name
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 * @param   string  $langView        The language string of the view
	 * @param   string  $langViews       The language string of the views
	 *
	 * @return  string The fields set in xml
	 *
	 */
	protected function stringFieldSet($view, $component, $nameSingleCode,
		$nameListCode, $langView, $langViews
	) {
		// set the read only
		$readOnly = false;
		if ($view['settings']->type == 2)
		{
			$readOnly = Indent::_(3) . 'readonly="true"' . PHP_EOL . Indent::_(
					3
				) . 'disabled="true"';
		}
		// start adding dynamc fields
		$dynamicFields = '';
		// set the custom table key
		$dbkey = 'g';
		// for plugin event TODO change event api signatures
		$this->placeholders = CFactory::_('Placeholder')->active;
		// Trigger Event: jcb_ce_onBeforeBuildFields
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeBuildFields',
			array(&$this->componentContext, &$dynamicFields, &$readOnly,
			      &$dbkey, &$view, &$component, &$nameSingleCode,
			      &$nameListCode, &$this->placeholders, &$langView,
			      &$langViews)
		);
		// for plugin event TODO change event api signatures
		CFactory::_('Placeholder')->active = $this->placeholders;
		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamicFields .= $this->setDynamicField(
				$field, $view, $view['settings']->type, $langView,
				$nameSingleCode, $nameListCode, CFactory::_('Placeholder')->active, $dbkey,
				true
			);
		}
		// for plugin event TODO change event api signatures
		$this->placeholders = CFactory::_('Placeholder')->active;
		// Trigger Event: jcb_ce_onAfterBuildFields
		CFactory::_J('Event')->trigger(
			'jcb_ce_onAfterBuildFields',
			array(&$this->componentContext, &$dynamicFields, &$readOnly,
			      &$dbkey, &$view, &$component, &$nameSingleCode,
			      &$nameListCode, &$this->placeholders, &$langView,
			      &$langViews)
		);
		// for plugin event TODO change event api signatures
		CFactory::_('Placeholder')->active = $this->placeholders;
		// set the default fields
		$fieldSet   = array();
		$fieldSet[] = '<fieldset name="details">';
		$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
			. " Default Fields. -->";
		$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
			. " Id Field. Type: Text (joomla) -->";
		// if id is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['id']))
		{
			$fieldSet[] = Indent::_(2) . "<field";
			$fieldSet[] = Indent::_(3) . "name=" . '"id"';
			$fieldSet[] = Indent::_(3)
				. 'type="text" class="readonly" label="JGLOBAL_FIELD_ID_LABEL"';
			$fieldSet[] = Indent::_(3)
				. 'description ="JGLOBAL_FIELD_ID_DESC" size="10" default="0"';
			$fieldSet[] = Indent::_(3) . 'readonly="true"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if created is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['created']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Date Created Field. Type: Calendar (joomla) -->";
			$fieldSet[] = Indent::_(2) . "<field";
			$fieldSet[] = Indent::_(3) . "name=" . '"created"';
			$fieldSet[] = Indent::_(3) . "type=" . '"calendar"';
			$fieldSet[] = Indent::_(3) . "label=" . '"' . $langView
				. '_CREATED_DATE_LABEL"';
			$fieldSet[] = Indent::_(3) . "description=" . '"' . $langView
				. '_CREATED_DATE_DESC"';
			$fieldSet[] = Indent::_(3) . "size=" . '"22"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = Indent::_(3) . "format=" . '"%Y-%m-%d %H:%M:%S"';
			$fieldSet[] = Indent::_(3) . "filter=" . '"user_utc"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if created_by is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['created_by']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " User Created Field. Type: User (joomla) -->";
			$fieldSet[] = Indent::_(2) . "<field";
			$fieldSet[] = Indent::_(3) . "name=" . '"created_by"';
			$fieldSet[] = Indent::_(3) . "type=" . '"user"';
			$fieldSet[] = Indent::_(3) . "label=" . '"' . $langView
				. '_CREATED_BY_LABEL"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = Indent::_(3) . "description=" . '"' . $langView
				. '_CREATED_BY_DESC"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if published is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['published']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Published Field. Type: List (joomla) -->";
			$fieldSet[] = Indent::_(2) . "<field name="
				. '"published" type="list" label="JSTATUS"';
			$fieldSet[] = Indent::_(3) . "description="
				. '"JFIELD_PUBLISHED_DESC" class="chzn-color-state"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = Indent::_(3) . "filter="
				. '"intval" size="1" default="1" >';
			$fieldSet[] = Indent::_(3) . "<option value=" . '"1">';
			$fieldSet[] = Indent::_(4) . "JPUBLISHED</option>";
			$fieldSet[] = Indent::_(3) . "<option value=" . '"0">';
			$fieldSet[] = Indent::_(4) . "JUNPUBLISHED</option>";
			$fieldSet[] = Indent::_(3) . "<option value=" . '"2">';
			$fieldSet[] = Indent::_(4) . "JARCHIVED</option>";
			$fieldSet[] = Indent::_(3) . "<option value=" . '"-2">';
			$fieldSet[] = Indent::_(4) . "JTRASHED</option>";
			$fieldSet[] = Indent::_(2) . "</field>";
			// count the static field created
			$this->fieldCount++;
		}
		// if modified is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['modified']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Date Modified Field. Type: Calendar (joomla) -->";
			$fieldSet[] = Indent::_(2)
				. '<field name="modified" type="calendar" class="readonly"';
			$fieldSet[] = Indent::_(3) . 'label="' . $langView
				. '_MODIFIED_DATE_LABEL" description="' . $langView
				. '_MODIFIED_DATE_DESC"';
			$fieldSet[] = Indent::_(3)
				. 'size="22" readonly="true" format="%Y-%m-%d %H:%M:%S" filter="user_utc" />';
			// count the static field created
			$this->fieldCount++;
		}
		// if modified_by is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['modified_by']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " User Modified Field. Type: User (joomla) -->";
			$fieldSet[] = Indent::_(2)
				. '<field name="modified_by" type="user"';
			$fieldSet[] = Indent::_(3) . 'label="' . $langView
				. '_MODIFIED_BY_LABEL"';
			$fieldSet[] = Indent::_(3) . "description=" . '"' . $langView
				. '_MODIFIED_BY_DESC"';
			$fieldSet[] = Indent::_(3) . 'class="readonly"';
			$fieldSet[] = Indent::_(3) . 'readonly="true"';
			$fieldSet[] = Indent::_(3) . 'filter="unset"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// check if view has access
		if (isset($this->accessBuilder[$nameSingleCode])
			&& StringHelper::check(
				$this->accessBuilder[$nameSingleCode]
			)
			&& !isset($this->fieldsNames[$nameSingleCode]['access']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Access Field. Type: Accesslevel (joomla) -->";
			$fieldSet[] = Indent::_(2) . '<field name="access"';
			$fieldSet[] = Indent::_(3) . 'type="accesslevel"';
			$fieldSet[] = Indent::_(3) . 'label="JFIELD_ACCESS_LABEL"';
			$fieldSet[] = Indent::_(3) . 'description="JFIELD_ACCESS_DESC"';
			$fieldSet[] = Indent::_(3) . 'default="1"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = Indent::_(3) . 'required="false"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if ordering is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['ordering']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Ordering Field. Type: Numbers (joomla) -->";
			$fieldSet[] = Indent::_(2) . "<field";
			$fieldSet[] = Indent::_(3) . 'name="ordering"';
			$fieldSet[] = Indent::_(3) . 'type="number"';
			$fieldSet[] = Indent::_(3) . 'class="inputbox validate-ordering"';
			$fieldSet[] = Indent::_(3) . 'label="' . $langView
				. '_ORDERING_LABEL' . '"';
			$fieldSet[] = Indent::_(3) . 'description=""';
			$fieldSet[] = Indent::_(3) . 'default="0"';
			$fieldSet[] = Indent::_(3) . 'size="6"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = Indent::_(3) . 'required="false"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if version is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['version']))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Version Field. Type: Text (joomla) -->";
			$fieldSet[] = Indent::_(2) . "<field";
			$fieldSet[] = Indent::_(3) . 'name="version"';
			$fieldSet[] = Indent::_(3) . 'type="text"';
			$fieldSet[] = Indent::_(3) . 'class="readonly"';
			$fieldSet[] = Indent::_(3) . 'label="' . $langView
				. '_VERSION_LABEL"';
			$fieldSet[] = Indent::_(3) . 'description="' . $langView
				. '_VERSION_DESC"';
			$fieldSet[] = Indent::_(3) . 'size="6"';
			$fieldSet[] = Indent::_(3) . 'readonly="true"';
			$fieldSet[] = Indent::_(3) . 'filter="unset"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$nameSingleCode])
			&& StringHelper::check(
				$this->metadataBuilder[$nameSingleCode]
			))
		{
			// metakey
			if (!isset($this->fieldsNames[$nameSingleCode]['metakey']))
			{
				$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
					. " Metakey Field. Type: Textarea (joomla) -->";
				$fieldSet[] = Indent::_(2) . "<field";
				$fieldSet[] = Indent::_(3) . 'name="metakey"';
				$fieldSet[] = Indent::_(3) . 'type="textarea"';
				$fieldSet[] = Indent::_(3)
					. 'label="JFIELD_META_KEYWORDS_LABEL"';
				$fieldSet[] = Indent::_(3)
					. 'description="JFIELD_META_KEYWORDS_DESC"';
				$fieldSet[] = Indent::_(3) . 'rows="3"';
				$fieldSet[] = Indent::_(3) . 'cols="30"';
				$fieldSet[] = Indent::_(2) . "/>";
				// count the static field created
				$this->fieldCount++;
			}
			// metadesc
			if (!isset($this->fieldsNames[$nameSingleCode]['metadesc']))
			{
				$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
					. " Metadesc Field. Type: Textarea (joomla) -->";
				$fieldSet[] = Indent::_(2) . "<field";
				$fieldSet[] = Indent::_(3) . 'name="metadesc"';
				$fieldSet[] = Indent::_(3) . 'type="textarea"';
				$fieldSet[] = Indent::_(3)
					. 'label="JFIELD_META_DESCRIPTION_LABEL"';
				$fieldSet[] = Indent::_(3)
					. 'description="JFIELD_META_DESCRIPTION_DESC"';
				$fieldSet[] = Indent::_(3) . 'rows="3"';
				$fieldSet[] = Indent::_(3) . 'cols="30"';
				$fieldSet[] = Indent::_(2) . "/>";
				// count the static field created
				$this->fieldCount++;
			}
		}
		// fix the permissions field "title" issue gh-629
		// check if the the title is not already set
		if (!isset($this->fieldsNames[$nameSingleCode]['title'])
			&& $this->hasPermissionsSet($view, $nameSingleCode))
		{
			// set the field/tab name
			$field_name = "title";
			$tab_name   = "publishing";
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Was added due to Permissions JS needing a Title field -->";
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Let us know at gh-629 should this change -->";
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " https://github.com/vdm-io/Joomla-Component-Builder/issues/629#issuecomment-750117235 -->";
			// at this point we know that we must add a hidden title field
			// and make sure it does not get stored to the database
			$fieldSet[] = Indent::_(2) . "<field";
			$fieldSet[] = Indent::_(3) . "name=" . '"' . $field_name . '"';
			$fieldSet[] = Indent::_(3)
				. 'type="hidden"';
			$fieldSet[] = Indent::_(3) . 'default="' . $component . ' '
				. $nameSingleCode . '"';
			$fieldSet[] = Indent::_(2) . "/>";
			// count the static field created
			$this->fieldCount++;
			// setup needed field values for layout
			$field_array               = array();
			$field_array['order_edit'] = 0;
			$field_array['tab']        = 15;
			$field_array['alignment']  = 1;
			// make sure it gets added to view
			$this->setLayoutBuilder(
				$nameSingleCode, $tab_name, $field_name, $field_array
			);
		}
		// load the dynamic fields now
		if (StringHelper::check($dynamicFields))
		{
			$fieldSet[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Dynamic Fields. -->" . $dynamicFields;
		}
		// close fieldset
		$fieldSet[] = Indent::_(1) . "</fieldset>";
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$nameSingleCode])
			&& StringHelper::check(
				$this->metadataBuilder[$nameSingleCode]
			))
		{
			if (!isset($this->fieldsNames[$nameSingleCode]['robots'])
				|| !isset($this->fieldsNames[$nameSingleCode]['rights'])
				|| !isset($this->fieldsNames[$nameSingleCode]['author']))
			{
				$fieldSet[] = PHP_EOL . Indent::_(1) . "<!--" . Line::_(
						__LINE__,__CLASS__
					) . " Metadata Fields. -->";
				$fieldSet[] = Indent::_(1) . "<fields"
					. ' name="metadata" label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				$fieldSet[] = Indent::_(2) . '<fieldset name="vdmmetadata"';
				$fieldSet[] = Indent::_(3)
					. 'label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				// robots
				if (!isset($this->fieldsNames[$nameSingleCode]['robots']))
				{
					$fieldSet[] = Indent::_(3) . "<!--" . Line::_(
							__LINE__,__CLASS__
						) . " Robots Field. Type: List (joomla) -->";
					$fieldSet[] = Indent::_(3) . '<field name="robots"';
					$fieldSet[] = Indent::_(4) . 'type="list"';
					$fieldSet[] = Indent::_(4)
						. 'label="JFIELD_METADATA_ROBOTS_LABEL"';
					$fieldSet[] = Indent::_(4)
						. 'description="JFIELD_METADATA_ROBOTS_DESC" >';
					$fieldSet[] = Indent::_(4)
						. '<option value="">JGLOBAL_USE_GLOBAL</option>';
					$fieldSet[] = Indent::_(4)
						. '<option value="index, follow">JGLOBAL_INDEX_FOLLOW</option>';
					$fieldSet[] = Indent::_(4)
						. '<option value="noindex, follow">JGLOBAL_NOINDEX_FOLLOW</option>';
					$fieldSet[] = Indent::_(4)
						. '<option value="index, nofollow">JGLOBAL_INDEX_NOFOLLOW</option>';
					$fieldSet[] = Indent::_(4)
						. '<option value="noindex, nofollow">JGLOBAL_NOINDEX_NOFOLLOW</option>';
					$fieldSet[] = Indent::_(3) . '</field>';
					// count the static field created
					$this->fieldCount++;
				}
				// author
				if (!isset($this->fieldsNames[$nameSingleCode]['author']))
				{
					$fieldSet[] = Indent::_(3) . "<!--" . Line::_(
							__LINE__,__CLASS__
						) . " Author Field. Type: Text (joomla) -->";
					$fieldSet[] = Indent::_(3) . '<field name="author"';
					$fieldSet[] = Indent::_(4) . 'type="text"';
					$fieldSet[] = Indent::_(4)
						. 'label="JAUTHOR" description="JFIELD_METADATA_AUTHOR_DESC"';
					$fieldSet[] = Indent::_(4) . 'size="20"';
					$fieldSet[] = Indent::_(3) . "/>";
					// count the static field created
					$this->fieldCount++;
				}
				// rights
				if (!isset($this->fieldsNames[$nameSingleCode]['rights']))
				{
					$fieldSet[] = Indent::_(3) . "<!--" . Line::_(
							__LINE__,__CLASS__
						) . " Rights Field. Type: Textarea (joomla) -->";
					$fieldSet[] = Indent::_(3)
						. '<field name="rights" type="textarea" label="JFIELD_META_RIGHTS_LABEL"';
					$fieldSet[] = Indent::_(4)
						. 'description="JFIELD_META_RIGHTS_DESC" required="false" filter="string"';
					$fieldSet[] = Indent::_(4) . 'cols="30" rows="2"';
					$fieldSet[] = Indent::_(3) . "/>";
					// count the static field created
					$this->fieldCount++;
				}
				$fieldSet[] = Indent::_(2) . "</fieldset>";
				$fieldSet[] = Indent::_(1) . "</fields>";
			}
		}

		// return the set
		return implode(PHP_EOL, $fieldSet);
	}

	/**
	 * build field set with simpleXMLElement class
	 *
	 * @param   array   $view            The view data
	 * @param   string  $component       The component name
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 * @param   string  $langView        The language string of the view
	 * @param   string  $langViews       The language string of the views
	 *
	 * @return  string The fields set in xml
	 *
	 */
	protected function simpleXMLFieldSet($view, $component, $nameSingleCode,
		$nameListCode, $langView, $langViews
	) {
		// set the read only
		$readOnlyXML = array();
		if ($view['settings']->type == 2)
		{
			$readOnlyXML['readonly'] = true;
			$readOnlyXML['disabled'] = true;
		}
		// start adding dynamc fields
		$dynamicFieldsXML = array();
		// set the custom table key
		$dbkey = 'g';
		// for plugin event TODO change event api signatures
		$this->placeholders = CFactory::_('Placeholder')->active;
		// Trigger Event: jcb_ce_onBeforeBuildFields
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeBuildFields',
			array(&$this->componentContext, &$dynamicFieldsXML, &$readOnlyXML,
			      &$dbkey, &$view, &$component, &$nameSingleCode,
			      &$nameListCode, &$this->placeholders, &$langView,
			      &$langViews)
		);
		// for plugin event TODO change event api signatures
		CFactory::_('Placeholder')->active = $this->placeholders;
		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamicFieldsXML[] = $this->setDynamicField(
				$field, $view, $view['settings']->type, $langView,
				$nameSingleCode, $nameListCode, CFactory::_('Placeholder')->active, $dbkey,
				true
			);
		}
		// for plugin event TODO change event api signatures
		$this->placeholders = CFactory::_('Placeholder')->active;
		// Trigger Event: jcb_ce_onAfterBuildFields
		CFactory::_J('Event')->trigger(
			'jcb_ce_onAfterBuildFields',
			array(&$this->componentContext, &$dynamicFieldsXML, &$readOnlyXML,
			      &$dbkey, &$view, &$component, &$nameSingleCode,
			      &$nameListCode, &$this->placeholders, &$langView,
			      &$langViews)
		);
		// for plugin event TODO change event api signatures
		CFactory::_('Placeholder')->active = $this->placeholders;
		// set the default fields
		$XML         = new simpleXMLElement('<a/>');
		$fieldSetXML = $XML->addChild('fieldset');
		$fieldSetXML->addAttribute('name', 'details');
		ComponentbuilderHelper::xmlComment(
			$fieldSetXML, Line::_(__Line__, __Class__) . " Default Fields."
		);
		ComponentbuilderHelper::xmlComment(
			$fieldSetXML,
			Line::_(__Line__, __Class__) . " Id Field. Type: Text (joomla)"
		);
		// if id is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['id']))
		{
			$attributes = array(
				'name'        => 'id',
				'type'        => 'text',
				'class'       => 'readonly',
				'readonly'    => "true",
				'label'       => 'JGLOBAL_FIELD_ID_LABEL',
				'description' => 'JGLOBAL_FIELD_ID_DESC',
				'size'        => 10,
				'default'     => 0
			);
			$fieldXML   = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if created is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['created']))
		{
			$attributes = array(
				'name'        => 'created',
				'type'        => 'calendar',
				'label'       => $langView . '_CREATED_DATE_LABEL',
				'description' => $langView . '_CREATED_DATE_DESC',
				'size'        => 22,
				'format'      => '%Y-%m-%d %H:%M:%S',
				'filter'      => 'user_utc'
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__)
				. " Date Created Field. Type: Calendar (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if created_by is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['created_by']))
		{
			$attributes = array(
				'name'        => 'created_by',
				'type'        => 'user',
				'label'       => $langView . '_CREATED_BY_LABEL',
				'description' => $langView . '_CREATED_BY_DESC',
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__)
				. " User Created Field. Type: User (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if published is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['published']))
		{
			$attributes = array(
				'name'  => 'published',
				'type'  => 'list',
				'label' => 'JSTATUS'
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__)
				. " Published Field. Type: List (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
			foreach (
				array('JPUBLISHED' => 1, 'JUNPUBLISHED' => 0, 'JARCHIVED' => 2,
				      'JTRASHED'   => -2) as $text => $value
			)
			{
				$optionXML = $fieldXML->addChild('option');
				$optionXML->addAttribute('value', $value);
				$optionXML[] = $text;
			}
		}
		// if modified is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['modified']))
		{
			$attributes = array(
				'name'        => 'modified',
				'type'        => 'calendar',
				'class'       => 'readonly',
				'label'       => $langView . '_MODIFIED_DATE_LABEL',
				'description' => $langView . '_MODIFIED_DATE_DESC',
				'size'        => 22,
				'readonly'    => "true",
				'format'      => '%Y-%m-%d %H:%M:%S',
				'filter'      => 'user_utc'
			);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__)
				. " Date Modified Field. Type: Calendar (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if modified_by is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['modified_by']))
		{
			$attributes = array(
				'name'        => 'modified_by',
				'type'        => 'user',
				'label'       => $langView . '_MODIFIED_BY_LABEL',
				'description' => $langView . '_MODIFIED_BY_DESC',
				'class'       => 'readonly',
				'readonly'    => 'true',
				'filter'      => 'unset'
			);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__)
				. " User Modified Field. Type: User (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// check if view has access
		if (isset($this->accessBuilder[$nameSingleCode])
			&& StringHelper::check(
				$this->accessBuilder[$nameSingleCode]
			)
			&& !isset($this->fieldsNames[$nameSingleCode]['access']))
		{
			$attributes = array(
				'name'        => 'access',
				'type'        => 'accesslevel',
				'label'       => 'JFIELD_ACCESS_LABEL',
				'description' => 'JFIELD_ACCESS_DESC',
				'default'     => 1,
				'required'    => "false"
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__)
				. " Access Field. Type: Accesslevel (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if ordering is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['ordering']))
		{
			$attributes = array(
				'name'        => 'ordering',
				'type'        => 'number',
				'class'       => 'inputbox validate-ordering',
				'label'       => $langView . '_ORDERING_LABEL',
				'description' => '',
				'default'     => 0,
				'size'        => 6,
				'required'    => "false"
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__)
				. " Ordering Field. Type: Numbers (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if version is not set
		if (!isset($this->fieldsNames[$nameSingleCode]['version']))
		{
			$attributes = array(
				'name'        => 'version',
				'type'        => 'text',
				'class'       => 'readonly',
				'label'       => $langView . '_VERSION_LABEL',
				'description' => $langView . '_VERSION_DESC',
				'size'        => 6,
				'readonly'    => "true",
				'filter'      => 'unset'
			);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML,
				Line::_(__Line__, __Class__) . " Version Field. Type: Text (joomla)"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$nameSingleCode])
			&& StringHelper::check(
				$this->metadataBuilder[$nameSingleCode]
			))
		{
			// metakey
			if (!isset($this->fieldsNames[$nameSingleCode]['metakey']))
			{
				$attributes = array(
					'name'        => 'metakey',
					'type'        => 'textarea',
					'label'       => 'JFIELD_META_KEYWORDS_LABEL',
					'description' => 'JFIELD_META_KEYWORDS_DESC',
					'rows'        => 3,
					'cols'        => 30
				);
				ComponentbuilderHelper::xmlComment(
					$fieldSetXML, Line::_(__Line__, __Class__)
					. " Metakey Field. Type: Textarea (joomla)"
				);
				$fieldXML = $fieldSetXML->addChild('field');
				ComponentbuilderHelper::xmlAddAttributes(
					$fieldXML, $attributes
				);
				// count the static field created
				$this->fieldCount++;
			}
			// metadesc
			if (!isset($this->fieldsNames[$nameSingleCode]['metadesc']))
			{
				$attributes['name']        = 'metadesc';
				$attributes['label']       = 'JFIELD_META_DESCRIPTION_LABEL';
				$attributes['description'] = 'JFIELD_META_DESCRIPTION_DESC';
				ComponentbuilderHelper::xmlComment(
					$fieldSetXML, Line::_(__Line__, __Class__)
					. " Metadesc Field. Type: Textarea (joomla)"
				);
				$fieldXML = $fieldSetXML->addChild('field');
				ComponentbuilderHelper::xmlAddAttributes(
					$fieldXML, $attributes
				);
				// count the static field created
				$this->fieldCount++;
			}
		}
		// fix the permissions field "title" issue gh-629
		// check if the the title is not already set
		if (!isset($this->fieldsNames[$nameSingleCode]['title'])
			&& $this->hasPermissionsSet($view, $nameSingleCode))
		{
			// set the field/tab name
			$field_name = "title";
			$tab_name   = "publishing";

			$attributes = array(
				'name'    => $field_name,
				'type'    => 'hidden',
				'default' => $component . ' ' . $nameSingleCode
			);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML,
				Line::_(__Line__, __Class__)
				. " Was added due to Permissions JS needing a Title field"
			);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML,
				Line::_(__Line__, __Class__)
				. " Let us know at gh-629 should this change"
			);
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML,
				Line::_(__Line__, __Class__)
				. " https://github.com/vdm-io/Joomla-Component-Builder/issues/629#issuecomment-750117235"
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
			// setup needed field values for layout
			$field_array               = array();
			$field_array['order_edit'] = 0;
			$field_array['tab']        = 15;
			$field_array['alignment']  = 1;
			// make sure it gets added to view
			$this->setLayoutBuilder(
				$nameSingleCode, $tab_name, $field_name, $field_array
			);
		}
		// load the dynamic fields now
		if (count((array) $dynamicFieldsXML))
		{
			ComponentbuilderHelper::xmlComment(
				$fieldSetXML, Line::_(__Line__, __Class__) . " Dynamic Fields."
			);
			foreach ($dynamicFieldsXML as $dynamicfield)
			{
				ComponentbuilderHelper::xmlAppend($fieldSetXML, $dynamicfield);
			}
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$nameSingleCode])
			&& StringHelper::check(
				$this->metadataBuilder[$nameSingleCode]
			))
		{
			if (!isset($this->fieldsNames[$nameSingleCode]['robots'])
				|| !isset($this->fieldsNames[$nameSingleCode]['author'])
				|| !isset($this->fieldsNames[$nameSingleCode]['rights']))
			{
				ComponentbuilderHelper::xmlComment(
					$fieldSetXML, Line::_(__Line__, __Class__) . " Metadata Fields"
				);
				$fieldsXML = $fieldSetXML->addChild('fields');
				$fieldsXML->addAttribute('name', 'metadata');
				$fieldsXML->addAttribute(
					'label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS'
				);
				$fieldsFieldSetXML = $fieldsXML->addChild('fieldset');
				$fieldsFieldSetXML->addAttribute('name', 'vdmmetadata');
				$fieldsFieldSetXML->addAttribute(
					'label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS'
				);
				// robots
				if (!isset($this->fieldsNames[$nameSingleCode]['robots']))
				{
					ComponentbuilderHelper::xmlComment(
						$fieldsFieldSetXML, Line::_(__Line__, __Class__)
						. " Robots Field. Type: List (joomla)"
					);
					$robots     = $fieldsFieldSetXML->addChild('field');
					$attributes = array(
						'name'        => 'robots',
						'type'        => 'list',
						'label'       => 'JFIELD_METADATA_ROBOTS_LABEL',
						'description' => 'JFIELD_METADATA_ROBOTS_DESC'
					);
					ComponentbuilderHelper::xmlAddAttributes(
						$robots, $attributes
					);
					// count the static field created
					$this->fieldCount++;
					$options = array(
						'JGLOBAL_USE_GLOBAL'       => '',
						'JGLOBAL_INDEX_FOLLOW'     => 'index, follow',
						'JGLOBAL_NOINDEX_FOLLOW'   => 'noindex, follow',
						'JGLOBAL_INDEX_NOFOLLOW'   => 'index, nofollow',
						'JGLOBAL_NOINDEX_NOFOLLOW' => 'noindex, nofollow',
					);
					foreach ($options as $text => $value)
					{
						$option = $robots->addChild('option');
						$option->addAttribute('value', $value);
						$option[] = $text;
					}
				}
				// author
				if (!isset($this->fieldsNames[$nameSingleCode]['author']))
				{
					ComponentbuilderHelper::xmlComment(
						$fieldsFieldSetXML, Line::_(__Line__, __Class__)
						. " Author Field. Type: Text (joomla)"
					);
					$author     = $fieldsFieldSetXML->addChild('field');
					$attributes = array(
						'name'        => 'author',
						'type'        => 'text',
						'label'       => 'JAUTHOR',
						'description' => 'JFIELD_METADATA_AUTHOR_DESC',
						'size'        => 20
					);
					ComponentbuilderHelper::xmlAddAttributes(
						$author, $attributes
					);
					// count the static field created
					$this->fieldCount++;
				}
				// rights
				if (!isset($this->fieldsNames[$nameSingleCode]['rights']))
				{
					ComponentbuilderHelper::xmlComment(
						$fieldsFieldSetXML, Line::_(__Line__, __Class__)
						. " Rights Field. Type: Textarea (joomla)"
					);
					$rights     = $fieldsFieldSetXML->addChild('field');
					$attributes = array(
						'name'        => 'rights',
						'type'        => 'textarea',
						'label'       => 'JFIELD_META_RIGHTS_LABEL',
						'description' => 'JFIELD_META_RIGHTS_DESC',
						'required'    => 'false',
						'filter'      => 'string',
						'cols'        => 30,
						'rows'        => 2
					);
					ComponentbuilderHelper::xmlAddAttributes(
						$rights, $attributes
					);
					// count the static field created
					$this->fieldCount++;
				}
			}
		}

		// return the set
		return $this->xmlPrettyPrint($XML, 'fieldset');
	}

	/**
	 * Check to see if a view has permissions
	 *
	 * @param   array   $view            View details
	 * @param   string  $nameSingleCode  View Single Code Name
	 *
	 * @return  boolean true if it has permisssions
	 *
	 */
	protected function hasPermissionsSet(&$view, &$nameSingleCode)
	{
		// first check if we have checked this already
		if (!isset($this->hasPermissions[$nameSingleCode]))
		{
			// default is false
			$this->hasPermissions[$nameSingleCode] = false;
			// when a view has history, it has permissions
			// since it tracks the version access
			if (isset($view['history']) && $view['history'] == 1)
			{
				// set the permission for later
				$this->hasPermissions[$nameSingleCode] = true;

				// break out here
				return true;
			}
			// check if the view has permissions
			if (isset($view['settings'])
				&& ArrayHelper::check(
					$view['settings']->permissions, true
				))
			{
				foreach ($view['settings']->permissions as $per)
				{
					// check if the permission targets the view
					// 1 = view
					// 3 = both view & component
					if (isset($per['implementation'])
						&& (
							$per['implementation'] == 1
							|| $per['implementation'] == 3
						))
					{
						// set the permission for later
						$this->hasPermissions[$nameSingleCode] = true;

						// break out here
						return true;
					}
				}
			}
			// check if the fields has permissions
			if (isset($view['settings'])
				&& ArrayHelper::check(
					$view['settings']->fields, true
				))
			{
				foreach ($view['settings']->fields as $field)
				{
					// if a field has any permissions
					// the a view has permissions
					if (isset($field['permission'])
						&& ArrayHelper::check(
							$field['permission'], true
						))
					{
						// set the permission for later
						$this->hasPermissions[$nameSingleCode] = true;

						// break out here
						return true;
					}
				}
			}
		}

		return $this->hasPermissions[$nameSingleCode];
	}

	/**
	 * set Field Names
	 *
	 * @param   string  $view  View the field belongs to
	 * @param   string  $name  The name of the field
	 *
	 *
	 */
	public function setFieldsNames(&$view, &$name)
	{
		$this->fieldsNames[$view][$name] = $name;
	}

	/**
	 * set Dynamic field
	 *
	 * @param   array    $field           The field data
	 * @param   array    $view            The view data
	 * @param   int      $viewType        The view type
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   array    $placeholders    The place holder and replace values
	 * @param   string   $dbkey           The the custom table key
	 * @param   boolean  $build           The switch to set the build option
	 *
	 * @return  SimpleXMLElement The complete field in xml
	 *
	 */
	public function setDynamicField(&$field, &$view, &$viewType, &$langView,
		&$nameSingleCode, &$nameListCode, &$placeholders, &$dbkey, $build
	) {
		// set default return
		if (CFactory::_('Config')->get('field_builder_type', 2) == 1)
		{
			// string manipulation
			$dynamicField = '';
		}
		else
		{
			// simpleXMLElement class
			$dynamicField = false;
		}
		// make sure we have settings
		if (isset($field['settings'])
			&& ObjectHelper::check(
				$field['settings']
			))
		{
			// reset some values
			$name            = $this->getFieldName($field, $nameListCode);
			$typeName        = $this->getFieldType($field);
			$multiple        = false;
			$langLabel       = '';
			$fieldSet        = '';
			$fieldAttributes = array();
			// set field attributes
			$fieldAttributes = $this->setFieldAttributes(
				$field, $viewType, $name, $typeName, $multiple, $langLabel,
				$langView, $nameListCode, $nameSingleCode, $placeholders
			);
			// check if values were set
			if (ArrayHelper::check($fieldAttributes))
			{
				// set the array of field names
				$this->setFieldsNames(
					$nameSingleCode, $fieldAttributes['name']
				);

				if (ComponentbuilderHelper::fieldCheck($typeName, 'option'))
				{
					//reset options array
					$optionArray = array();
					// now add to the field set
					$dynamicField = $this->setField(
						'option', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray
					);
					if ($build)
					{
						// set builders
						$this->setBuilders(
							$langLabel, $langView, $nameSingleCode,
							$nameListCode, $name, $view, $field, $typeName,
							$multiple, false, $optionArray
						);
					}
				}
				elseif (ComponentbuilderHelper::fieldCheck($typeName, 'spacer'))
				{
					if ($build)
					{
						// make sure spacers gets loaded to layout
						$tabName = '';
						if (isset($view['settings']->tabs)
							&& isset($view['settings']->tabs[(int) $field['tab']]))
						{
							$tabName
								= $view['settings']->tabs[(int) $field['tab']];
						}
						elseif ((int) $field['tab'] == 15)
						{
							// set to publishing tab
							$tabName = 'publishing';
						}
						$this->setLayoutBuilder(
							$nameSingleCode, $tabName, $name, $field
						);
					}
					// now add to the field set
					$dynamicField = $this->setField(
						'spacer', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray
					);
				}
				elseif (ComponentbuilderHelper::fieldCheck(
					$typeName, 'special'
				))
				{
					// set the repeatable field or subform field
					if ($typeName === 'repeatable' || $typeName === 'subform')
					{
						if ($build)
						{
							// set builders
							$this->setBuilders(
								$langLabel, $langView, $nameSingleCode,
								$nameListCode, $name, $view, $field,
								$typeName, $multiple, false
							);
						}
						// now add to the field set
						$dynamicField = $this->setField(
							'special', $fieldAttributes, $name, $typeName,
							$langView, $nameSingleCode, $nameListCode,
							$placeholders, $optionArray
						);
					}
				}
				elseif (isset($fieldAttributes['custom'])
					&& ArrayHelper::check(
						$fieldAttributes['custom']
					))
				{
					// set the custom array
					$custom = $fieldAttributes['custom'];
					unset($fieldAttributes['custom']);
					// set db key
					$custom['db'] = $dbkey;
					// increment the db key
					$dbkey++;
					if ($build)
					{
						// set builders
						$this->setBuilders(
							$langLabel, $langView, $nameSingleCode,
							$nameListCode, $name, $view, $field, $typeName,
							$multiple, $custom
						);
					}
					// now add to the field set
					$dynamicField = $this->setField(
						'custom', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray, $custom
					);
				}
				else
				{
					if ($build)
					{
						// set builders
						$this->setBuilders(
							$langLabel, $langView, $nameSingleCode,
							$nameListCode, $name, $view, $field, $typeName,
							$multiple
						);
					}
					// now add to the field set
					$dynamicField = $this->setField(
						'plain', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray
					);
				}
			}
		}

		return $dynamicField;
	}

	/**
	 * build field set
	 *
	 * @param   array    $fields          The fields data
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   array    $placeholders    The place holder and replace values
	 * @param   string   $dbkey           The the custom table key
	 * @param   boolean  $build           The switch to set the build option
	 * @param   int      $return_type     The return type 1 = string, 2 = array
	 *
	 * @return  mix   The complete field in xml
	 *
	 */
	public function getFieldsetXML(&$fields, &$langView, &$nameSingleCode,
		&$nameListCode, &$placeholders, &$dbkey, $build = false,
		$return_type = 1
	) {
		// set some defaults
		$view     = '';
		$viewType = 0;
		// build the fieldset
		if ($return_type == 1)
		{
			$fieldset = '';
		}
		else
		{
			$fieldset = array();
		}
		// loop over the fields to build
		if (ArrayHelper::check($fields))
		{
			foreach ($fields as $field)
			{
				// get the field
				$xmlField = $this->getFieldXMLString(
					$field, $view, $viewType, $langView,
					$nameSingleCode, $nameListCode,
					$placeholders, $dbkey, $build
				);
				// make sure the xml is set and a string
				if (isset($xmlField)
					&& StringHelper::check(
						$xmlField
					))
				{
					if ($return_type == 1)
					{
						$fieldset .= $xmlField;
					}
					else
					{
						$fieldset[] = $xmlField;
					}
				}
			}
		}

		return $fieldset;
	}

	/**
	 * build field string
	 *
	 * @param   array    $field           The field data
	 * @param   array    $view            The view data
	 * @param   int      $viewType        The view type
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   array    $placeholders    The place holder and replace values
	 * @param   string   $dbkey           The the custom table key
	 * @param   boolean  $build           The switch to set the build option
	 *
	 * @return  string  The complete field in xml-string
	 *
	 */
	public function getFieldXMLString(&$field, &$view, &$viewType, &$langView,
		&$nameSingleCode, &$nameListCode, &$placeholders, &$dbkey,
		$build = false
	) {
		// check the field builder type
		$xmlField = '';
		if (CFactory::_('Config')->get('field_builder_type', 2) == 1)
		{
			// string manipulation
			$xmlField = $this->setDynamicField(
				$field, $view, $viewType, $langView,
				$nameSingleCode, $nameListCode,
				$placeholders, $dbkey, $build
			);
		}
		else
		{
			// simpleXMLElement class
			$newxmlField = $this->setDynamicField(
				$field, $view, $viewType, $langView,
				$nameSingleCode, $nameListCode,
				$placeholders, $dbkey, $build
			);
			if (isset($newxmlField->fieldXML))
			{
				$xmlField = dom_import_simplexml(
					$newxmlField->fieldXML
				);
				$xmlField = PHP_EOL . Indent::_(2) . "<!--"
					. Line::_(__Line__, __Class__) . " "
					. $newxmlField->comment . ' -->' . PHP_EOL
					. Indent::_(1) . $this->xmlPrettyPrint(
						$xmlField, 'field'
					);
			}
		}

		// return the string
		return $xmlField;
	}

	/**
	 * set a field
	 *
	 * @param   string  $setType          The set of fields type
	 * @param   array   $fieldAttributes  The field values
	 * @param   string  $name             The field name
	 * @param   string  $typeName         The field type
	 * @param   string  $langView         The language string of the view
	 * @param   string  $nameSingleCode   The single view name
	 * @param   string  $nameListCode     The list view name
	 * @param   array   $placeholders     The place holder and replace values
	 * @param   string  $optionArray      The option bucket array used to set the field options if needed.
	 * @param   array   $custom           Used when field is from config
	 * @param   string  $taber            The tabs to add in layout (only in string manipulation)
	 *
	 * @return  SimpleXMLElement The field in xml
	 *
	 */
	private function setField($setType, &$fieldAttributes, &$name, &$typeName,
		&$langView, &$nameSingleCode, &$nameListCode, $placeholders,
		&$optionArray, $custom = null, $taber = ''
	) {
		// count the dynamic fields created
		$this->fieldCount++;
		// check what type of field builder to use
		if (CFactory::_('Config')->get('field_builder_type', 2) == 1)
		{
			// build field set using string manipulation
			return $this->stringSetField(
				$setType, $fieldAttributes, $name, $typeName, $langView,
				$nameSingleCode, $nameListCode, $placeholders, $optionArray,
				$custom, $taber
			);
		}
		else
		{
			// build field set with simpleXMLElement class
			return $this->simpleXMLSetField(
				$setType, $fieldAttributes, $name, $typeName, $langView,
				$nameSingleCode, $nameListCode, $placeholders, $optionArray,
				$custom
			);
		}
	}

	/**
	 * set a field using string manipulation
	 *
	 * @param   string  $setType          The set of fields type
	 * @param   array   $fieldAttributes  The field values
	 * @param   string  $name             The field name
	 * @param   string  $typeName         The field type
	 * @param   string  $langView         The language string of the view
	 * @param   string  $nameSingleCode   The single view name
	 * @param   string  $nameListCode     The list view name
	 * @param   array   $placeholders     The place holder and replace values
	 * @param   string  $optionArray      The option bucket array used to set the field options if needed.
	 * @param   array   $custom           Used when field is from config
	 * @param   string  $taber            The tabs to add in layout
	 *
	 * @return  SimpleXMLElement The field in xml
	 *
	 */
	protected function stringSetField($setType, &$fieldAttributes, &$name,
		&$typeName, &$langView, &$nameSingleCode, &$nameListCode,
		$placeholders, &$optionArray, $custom = null, $taber = ''
	) {
		$field = '';
		if ($setType === 'option')
		{
			// now add to the field set
			$field     .= PHP_EOL . Indent::_(1) . $taber . Indent::_(1)
				. "<!--" . Line::_(__Line__, __Class__) . " " . ucfirst($name)
				. " Field. Type: " . StringHelper::safe(
					$typeName, 'F'
				) . ". (joomla) -->";
			$field     .= PHP_EOL . Indent::_(1) . $taber . Indent::_(1)
				. "<field";
			$optionSet = '';
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
						. $property . '="' . $value . '"';
				}
				elseif ($property === 'option')
				{
					$optionSet = '';
					if (strtolower($typeName) === 'groupedlist'
						&& strpos(
							$value, ','
						) !== false
						&& strpos($value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_  = array();
						$grouped_ = array('group'  => array(),
						                  'option' => array());
						$order_   = array();
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							if (strpos($option, '@@') !== false)
							{
								// set the group label
								$valueKeyArray = explode('@@', $option);
								if (count((array) $valueKeyArray) == 2)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[0], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[0]
									);
									// now add group label
									$groups_[$valueKeyArray[1]] = PHP_EOL
										. Indent::_(1) . $taber . Indent::_(2)
										. '<group label="' . $langValue . '">';
									// set order
									$order_['group' . $valueKeyArray[1]]
										= $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(3) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(4)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]]
										= $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(2) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(3)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]]
										= $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$grouped_['option'][$option] = PHP_EOL
									. Indent::_(1) . $taber . Indent::_(2)
									. '<option value="' . $option . '">'
									. PHP_EOL . Indent::_(1) . $taber
									. Indent::_(3) . $langValue . '</option>';
								$optionArray[$option]        = $langValue;
								// set order
								$order_['option' . $option] = $option;
							}
						}
						// now build the groups
						foreach ($order_ as $pointer_ => $_id)
						{
							// load the default key
							$key_ = 'group';
							if (strpos($pointer_, 'option') !== false)
							{
								// load the option field
								$key_ = 'option';
							}
							// check if this is a group loader
							if ('group' === $key_ && isset($groups_[$_id])
								&& isset($grouped_[$key_][$_id])
								&& ArrayHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								// set group label
								$optionSet .= $groups_[$_id];
								foreach ($grouped_[$key_][$_id] as $option_)
								{
									$optionSet .= $option_;
								}
								unset($groups_[$_id]);
								unset($grouped_[$key_][$_id]);
								// close the group
								$optionSet .= PHP_EOL . Indent::_(1) . $taber
									. Indent::_(2) . '</group>';
							}
							elseif (isset($grouped_[$key_][$_id])
								&& StringHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								$optionSet .= $grouped_[$key_][$_id];
							}
						}
					}
					elseif (strpos($value, ',') !== false)
					{
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							if (strpos($option, '|') !== false)
							{
								// has other value then text
								list($v, $t) = explode('|', $option);
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$t, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $t
								);
								// now add to option set
								$optionSet       .= PHP_EOL . Indent::_(1)
									. $taber . Indent::_(2) . '<option value="'
									. $v . '">' . PHP_EOL . Indent::_(1)
									. $taber . Indent::_(3) . $langValue
									. '</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$optionSet            .= PHP_EOL . Indent::_(2)
									. $taber . Indent::_(1) . '<option value="'
									. $option . '">' . PHP_EOL . Indent::_(2)
									. $taber . Indent::_(2) . $langValue
									. '</option>';
								$optionArray[$option] = $langValue;
							}
						}
					}
					else
					{
						// one option
						if (strpos($value, '|') !== false)
						{
							// has other value then text
							list($v, $t) = explode('|', $value);
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$t, true
								);
							// add to lang array
							CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langValue, $t);
							// now add to option set
							$optionSet       .= PHP_EOL . Indent::_(2) . $taber
								. Indent::_(1) . '<option value="' . $v . '">'
								. PHP_EOL . Indent::_(2) . $taber . Indent::_(2)
								. $langValue . '</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$value, true
								);
							// add to lang array
							CFactory::_('Language')->set(
								CFactory::_('Config')->lang_target, $langValue, $value
							);
							// now add to option set
							$optionSet           .= PHP_EOL . Indent::_(2)
								. $taber . Indent::_(1) . '<option value="'
								. $value . '">' . PHP_EOL . Indent::_(2)
								. $taber . Indent::_(2) . $langValue
								. '</option>';
							$optionArray[$value] = $langValue;
						}
					}
				}
			}
			// if options were found
			if (StringHelper::check($optionSet))
			{
				$field .= '>';
				$field .= PHP_EOL . Indent::_(3) . $taber . "<!--"
					. Line::_(__Line__, __Class__) . " Option Set. -->";
				$field .= $optionSet;
				$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
			}
			// if no options found and must have a list of options
			elseif (ComponentbuilderHelper::fieldCheck($typeName, 'list'))
			{
				$optionArray = false;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
				$field       .= PHP_EOL . Indent::_(2) . $taber . "<!--"
					. Line::_(__Line__, __Class__)
					. " No Manual Options Were Added In Field Settings. -->"
					. PHP_EOL;
			}
			else
			{
				$optionArray = false;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$field .= PHP_EOL . Indent::_(2) . $taber . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " " . ucfirst($name) . " Field. Type: "
				. StringHelper::safe($typeName, 'F')
				. ". (joomla) -->";
			$field .= PHP_EOL . Indent::_(2) . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
						. $property . '="' . $value . '"';
				}
			}
			$field .= PHP_EOL . Indent::_(2) . $taber . "/>";
		}
		elseif ($setType === 'spacer')
		{
			// now add to the field set
			$field .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " " . ucfirst($name) . " Field. Type: "
				. StringHelper::safe($typeName, 'F')
				. ". A None Database Field. (joomla) -->";
			$field .= PHP_EOL . Indent::_(2) . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= " " . $property . '="' . $value . '"';
				}
			}
			$field .= " />";
		}
		elseif ($setType === 'special')
		{
			// set the repeatable field
			if ($typeName === 'repeatable')
			{
				// now add to the field set
				$field     .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(
						__LINE__,__CLASS__
					) . " " . ucfirst($name) . " Field. Type: "
					. StringHelper::safe($typeName, 'F')
					. ". (joomla) -->";
				$field     .= PHP_EOL . Indent::_(2) . "<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . Indent::_(3) . $property . '="'
							. $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . Indent::_(3) . '<fields name="'
					. $fieldAttributes['name'] . '_fields" label="">';
				$field .= PHP_EOL . Indent::_(4)
					. '<fieldset hidden="true" name="'
					. $fieldAttributes['name'] . '_modal" repeat="true">';
				if (strpos($fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(
						',', $fieldAttributes['fields']
					);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ArrayHelper::check($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(
						function ($id) use (
							$nameSingleCode, $nameListCode, $_resolverKey
						) {
							// start field
							$field          = array();
							$field['field'] = $id;
							// set the field details
							$this->setFieldDetails(
								$field, $nameSingleCode, $nameListCode,
								$_resolverKey
							);

							// return field
							return $field;
						}, array_values($fieldsSets)
					);
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ObjectHelper::check(
							$fieldData['settings']
						))
						{
							$r_name      = $this->getFieldName(
								$fieldData, $nameListCode, $_resolverKey
							);
							$r_typeName  = $this->getFieldType($fieldData);
							$r_multiple  = false;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = Indent::_(3);
							// get field values
							$r_fieldValues = $this->setFieldAttributes(
								$fieldData, $view, $r_name, $r_typeName,
								$r_multiple, $r_langLabel, $langView,
								$nameListCode, $nameSingleCode,
								$placeholders, true
							);
							// check if values were set
							if (ArrayHelper::check(
								$r_fieldValues
							))
							{
								//reset options array
								$r_optionArray = array();
								if (ComponentbuilderHelper::fieldCheck(
									$r_typeName, 'option'
								))
								{
									// now add to the field set
									$field .= $this->setField(
										'option', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
								elseif (isset($r_fieldValues['custom'])
									&& ArrayHelper::check(
										$r_fieldValues['custom']
									))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->setField(
										'custom', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
									// set lang (just incase)
									$r_listLangName = $langView . '_'
										. FieldHelper::safe(
											$r_name, true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $r_listLangName,
										StringHelper::safe(
											$r_name, 'W'
										)
									);
									// if label was set use instead
									if (StringHelper::check(
										$r_langLabel
									))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type'   => $r_typeName,
									              'code'   => $r_name,
									              'lang'   => $r_listLangName,
									              'custom' => $custom);
									// set the custom field file
									$this->setCustomFieldTypeFile(
										$data, $nameListCode,
										$nameSingleCode
									);
								}
								else
								{
									// now add to the field set
									$field .= $this->setField(
										'plain', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
							}
						}
					}
				}
				$field .= PHP_EOL . Indent::_(4) . "</fieldset>";
				$field .= PHP_EOL . Indent::_(3) . "</fields>";
				$field .= PHP_EOL . Indent::_(2) . "</field>";
			}
			// set the subform fields (it is a repeatable without the modal) 
			elseif ($typeName === 'subform')
			{
				// now add to the field set
				$field     .= PHP_EOL . Indent::_(2) . $taber . "<!--"
					. Line::_(__Line__, __Class__) . " " . ucfirst($name)
					. " Field. Type: " . StringHelper::safe(
						$typeName, 'F'
					) . ". (joomla) -->";
				$field     .= PHP_EOL . Indent::_(2) . $taber . "<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . Indent::_(3) . $taber . $property
							. '="' . $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . Indent::_(3) . $taber
					. '<form hidden="true" name="list_'
					. $fieldAttributes['name'] . '_modal" repeat="true">';
				if (strpos($fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(
						',', $fieldAttributes['fields']
					);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ArrayHelper::check($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(
						function ($id) use (
							$nameSingleCode, $nameListCode, $_resolverKey
						) {
							// start field
							$field          = array();
							$field['field'] = $id;
							// set the field details
							$this->setFieldDetails(
								$field, $nameSingleCode, $nameListCode,
								$_resolverKey
							);

							// return field
							return $field;
						}, array_values($fieldsSets)
					);
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ObjectHelper::check(
							$fieldData['settings']
						))
						{
							$r_name      = $this->getFieldName(
								$fieldData, $nameListCode, $_resolverKey
							);
							$r_typeName  = $this->getFieldType($fieldData);
							$r_multiple  = false;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = Indent::_(2) . $taber;
							// get field values
							$r_fieldValues = $this->setFieldAttributes(
								$fieldData, $view, $r_name, $r_typeName,
								$r_multiple, $r_langLabel, $langView,
								$nameListCode, $nameSingleCode,
								$placeholders, true
							);
							// check if values were set
							if (ArrayHelper::check(
								$r_fieldValues
							))
							{
								//reset options array
								$r_optionArray = array();
								if (ComponentbuilderHelper::fieldCheck(
									$r_typeName, 'option'
								))
								{
									// now add to the field set
									$field .= $this->setField(
										'option', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
								elseif ($r_typeName === 'subform')
								{
									// set nested depth
									if (isset($fieldAttributes['nested_depth']))
									{
										$r_fieldValues['nested_depth']
											= ++$fieldAttributes['nested_depth'];
									}
									else
									{
										$r_fieldValues['nested_depth'] = 1;
									}
									// only continue if nest is bellow 20 (this should be a safe limit)
									if ($r_fieldValues['nested_depth'] <= 20)
									{
										// now add to the field set
										$field .= $this->setField(
											'special', $r_fieldValues, $r_name,
											$r_typeName, $langView,
											$nameSingleCode, $nameListCode,
											$placeholders, $r_optionArray, null,
											$r_taber
										);
									}
								}
								elseif (isset($r_fieldValues['custom'])
									&& ArrayHelper::check(
										$r_fieldValues['custom']
									))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->setField(
										'custom', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
									// set lang (just incase)
									$r_listLangName = $langView . '_'
										. FieldHelper::safe(
											$r_name, true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $r_listLangName,
										StringHelper::safe(
											$r_name, 'W'
										)
									);
									// if label was set use instead
									if (StringHelper::check(
										$r_langLabel
									))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type'   => $r_typeName,
									              'code'   => $r_name,
									              'lang'   => $r_listLangName,
									              'custom' => $custom);
									// set the custom field file
									$this->setCustomFieldTypeFile(
										$data, $nameListCode,
										$nameSingleCode
									);
								}
								else
								{
									// now add to the field set
									$field .= $this->setField(
										'plain', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
							}
						}
					}
				}
				$field .= PHP_EOL . Indent::_(3) . $taber . "</form>";
				$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
			}
		}
		elseif ($setType === 'custom')
		{
			// now add to the field set
			$field     .= PHP_EOL . Indent::_(2) . $taber . "<!--"
				. Line::_(
					__LINE__,__CLASS__
				) . " " . ucfirst($name) . " Field. Type: "
				. StringHelper::safe($typeName, 'F')
				. ". (custom) -->";
			$field     .= PHP_EOL . Indent::_(2) . $taber . "<field";
			$optionSet = '';
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
						. $property . '="' . $value . '"';
				}
				elseif ($property === 'option')
				{
					$optionSet = '';
					if (strtolower($typeName) === 'groupedlist'
						&& strpos(
							$value, ','
						) !== false
						&& strpos($value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_  = array();
						$grouped_ = array('group'  => array(),
						                  'option' => array());
						$order_   = array();
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							if (strpos($option, '@@') !== false)
							{
								// set the group label
								$valueKeyArray = explode('@@', $option);
								if (count((array) $valueKeyArray) == 2)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[0], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[0]
									);
									// now add group label
									$groups_[$valueKeyArray[1]] = PHP_EOL
										. Indent::_(1) . $taber . Indent::_(2)
										. '<group label="' . $langValue . '">';
									// set order
									$order_['group' . $valueKeyArray[1]]
										= $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(3) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(4)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]]
										= $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(2) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(3)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]]
										= $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$grouped_['option'][$option] = PHP_EOL
									. Indent::_(1) . $taber . Indent::_(2)
									. '<option value="' . $option . '">'
									. PHP_EOL . Indent::_(1) . $taber
									. Indent::_(3) . $langValue . '</option>';
								$optionArray[$option]        = $langValue;
								// set order
								$order_['option' . $option] = $option;
							}
						}
						// now build the groups
						foreach ($order_ as $pointer_ => $_id)
						{
							// load the default key
							$key_ = 'group';
							if (strpos($pointer_, 'option') !== false)
							{
								// load the option field
								$key_ = 'option';
							}
							// check if this is a group loader
							if ('group' === $key_ && isset($groups_[$_id])
								&& isset($grouped_[$key_][$_id])
								&& ArrayHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								// set group label
								$optionSet .= $groups_[$_id];
								foreach ($grouped_[$key_][$_id] as $option_)
								{
									$optionSet .= $option_;
								}
								unset($groups_[$_id]);
								unset($grouped_[$key_][$_id]);
								// close the group
								$optionSet .= PHP_EOL . Indent::_(1) . $taber
									. Indent::_(2) . '</group>';
							}
							elseif (isset($grouped_[$key_][$_id])
								&& StringHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								$optionSet .= $grouped_[$key_][$_id];
							}
						}
					}
					elseif (strpos($value, ',') !== false)
					{
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							if (strpos($option, '|') !== false)
							{
								// has other value then text
								list($v, $t) = explode('|', $option);
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$t, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $t
								);
								// now add to option set
								$optionSet       .= PHP_EOL . Indent::_(1)
									. $taber . Indent::_(2) . '<option value="'
									. $v . '">' . PHP_EOL . Indent::_(1)
									. $taber . Indent::_(3) . $langValue
									. '</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$optionSet            .= PHP_EOL . Indent::_(2)
									. $taber . Indent::_(1) . '<option value="'
									. $option . '">' . PHP_EOL . Indent::_(2)
									. $taber . Indent::_(2) . $langValue
									. '</option>';
								$optionArray[$option] = $langValue;
							}
						}
					}
					else
					{
						// one option
						if (strpos($value, '|') !== false)
						{
							// has other value then text
							list($v, $t) = explode('|', $value);
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$t, true
								);
							// add to lang array
							CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langValue, $t);
							// now add to option set
							$optionSet       .= PHP_EOL . Indent::_(2) . $taber
								. Indent::_(1) . '<option value="' . $v . '">'
								. PHP_EOL . Indent::_(2) . $taber . Indent::_(2)
								. $langValue . '</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$value, true
								);
							// add to lang array
							CFactory::_('Language')->set(
								CFactory::_('Config')->lang_target, $langValue, $value
							);
							// now add to option set
							$optionSet           .= PHP_EOL . Indent::_(2)
								. $taber . Indent::_(1) . '<option value="'
								. $value . '">' . PHP_EOL . Indent::_(2)
								. $taber . Indent::_(2) . $langValue
								. '</option>';
							$optionArray[$value] = $langValue;
						}
					}
				}
			}
			// if options were found
			if (StringHelper::check($optionSet))
			{
				$field .= '>';
				$field .= PHP_EOL . Indent::_(3) . $taber . "<!--"
					. Line::_(__Line__, __Class__) . " Option Set. -->";
				$field .= $optionSet;
				$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
			}
			// if no options found and must have a list of options
			elseif (ComponentbuilderHelper::fieldCheck($typeName, 'list'))
			{
				$optionArray = false;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
				$field       .= PHP_EOL . Indent::_(2) . $taber . "<!--"
					. Line::_(__Line__, __Class__)
					. " No Manual Options Were Added In Field Settings. -->"
					. PHP_EOL;
			}
			else
			{
				$optionArray = false;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
			}
			// incase the field is in the config and has not been set
			if ('config' === $nameSingleCode && 'configs' === $nameListCode
				|| (strpos($nameSingleCode, 'P|uG!n') !== false
					|| strpos(
						$nameSingleCode, 'M0dU|3'
					) !== false))
			{
				// set lang (just incase)
				$listLangName = $langView . '_'
					. StringHelper::safe($name, 'U');
				// set the custom array
				$data = array('type' => $typeName, 'code' => $name,
				              'lang' => $listLangName, 'custom' => $custom);
				// set the custom field file
				$this->setCustomFieldTypeFile(
					$data, $nameListCode, $nameSingleCode
				);
			}
		}

		// return field
		return $field;
	}

	/**
	 * set a field with simpleXMLElement class
	 *
	 * @param   string  $setType          The set of fields type
	 * @param   array   $fieldAttributes  The field values
	 * @param   string  $name             The field name
	 * @param   string  $typeName         The field type
	 * @param   string  $langView         The language string of the view
	 * @param   string  $nameSingleCode   The single view name
	 * @param   string  $nameListCode     The list view name
	 * @param   array   $placeholders     The place holder and replace values
	 * @param   string  $optionArray      The option bucket array used to set the field options if needed.
	 * @param   array   $custom           Used when field is from config
	 *
	 * @return  SimpleXMLElement The field in xml
	 *
	 */
	protected function simpleXMLSetField($setType, &$fieldAttributes, &$name,
		&$typeName, &$langView, &$nameSingleCode, &$nameListCode,
		$placeholders, &$optionArray, $custom = null
	) {
		$field = new stdClass();
		if ($setType === 'option')
		{
			// now add to the field set
			$field->fieldXML = new SimpleXMLElement('<field/>');
			$field->comment  = Line::_(__Line__, __Class__) . " " . ucfirst($name)
				. " Field. Type: " . StringHelper::safe(
					$typeName, 'F'
				) . ". (joomla)";

			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
				elseif ($property === 'option')
				{
					ComponentbuilderHelper::xmlComment(
						$field->fieldXML,
						Line::_(__Line__, __Class__) . " Option Set."
					);
					if (strtolower($typeName) === 'groupedlist'
						&& strpos(
							$value, ','
						) !== false
						&& strpos($value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_  = array();
						$grouped_ = array('group'  => array(),
						                  'option' => array());
						$order_   = array();
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							if (strpos($option, '@@') !== false)
							{
								// set the group label
								$valueKeyArray = explode('@@', $option);
								if (count((array) $valueKeyArray) == 2)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[0], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[0]
									);
									// now add group label
									$groups_[$valueKeyArray[1]] = $langValue;
									// set order
									$order_['group' . $valueKeyArray[1]]
										= $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][]
										= array('value' => $valueKeyArray[0],
										        'text'  => $langValue);
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]]
										= $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]]
										= array('value' => $valueKeyArray[0],
										        'text'  => $langValue);
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]]
										= $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$grouped_['option'][$option]
									                  = array('value' => $option,
									                          'text'  => $langValue);
								$optionArray[$option] = $langValue;
								// set order
								$order_['option' . $option] = $option;
							}
						}
						// now build the groups
						foreach ($order_ as $pointer_ => $_id)
						{
							// load the default key
							$key_ = 'group';
							if (strpos($pointer_, 'option') !== false)
							{
								// load the option field
								$key_ = 'option';
							}
							// check if this is a group loader
							if ('group' === $key_ && isset($groups_[$_id])
								&& isset($grouped_[$key_][$_id])
								&& ArrayHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								// set group label
								$groupXML = $field->fieldXML->addChild('group');
								$groupXML->addAttribute(
									'label', $groups_[$_id]
								);

								foreach ($grouped_[$key_][$_id] as $option_)
								{
									$groupOptionXML = $groupXML->addChild(
										'option'
									);
									$groupOptionXML->addAttribute(
										'value', $option_['value']
									);
									$groupOptionXML[] = $option_['text'];
								}
								unset($groups_[$_id]);
								unset($grouped_[$key_][$_id]);
							}
							elseif (isset($grouped_[$key_][$_id])
								&& StringHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								$optionXML = $field->fieldXML->addChild(
									'option'
								);
								$optionXML->addAttribute(
									'value', $grouped_[$key_][$_id]['value']
								);
								$optionXML[] = $grouped_[$key_][$_id]['text'];
							}
						}
					}
					elseif (strpos($value, ',') !== false)
					{
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							$optionXML = $field->fieldXML->addChild('option');
							if (strpos($option, '|') !== false)
							{
								// has other value then text
								list($v, $t) = explode('|', $option);
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$t, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $t
								);
								// now add to option set
								$optionXML->addAttribute('value', $v);
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$optionXML->addAttribute('value', $option);
								$optionArray[$option] = $langValue;
							}
							$optionXML[] = $langValue;
						}
					}
					else
					{
						// one option
						$optionXML = $field->fieldXML->addChild('option');
						if (strpos($value, '|') !== false)
						{
							// has other value then text
							list($v, $t) = explode('|', $value);
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$t, true
								);
							// add to lang array
							CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langValue, $t);
							// now add to option set
							$optionXML->addAttribute('value', $v);
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$value, true
								);
							// add to lang array
							CFactory::_('Language')->set(
								CFactory::_('Config')->lang_target, $langValue, $value
							);
							// now add to option set
							$optionXML->addAttribute('value', $value);
							$optionArray[$value] = $langValue;
						}
						$optionXML[] = $langValue;
					}
				}
			}
			// if no options found and must have a list of options
			if (!$field->fieldXML->count()
				&& ComponentbuilderHelper::fieldCheck($typeName, 'list'))
			{
				ComponentbuilderHelper::xmlComment(
					$field->fieldXML, Line::_(__Line__, __Class__)
					. " No Manual Options Were Added In Field Settings."
				);
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$field->fieldXML = new SimpleXMLElement('<field/>');
			$field->comment  = Line::_(__Line__, __Class__) . " " . ucfirst($name)
				. " Field. Type: " . StringHelper::safe(
					$typeName, 'F'
				) . ". (joomla)";

			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
			}
		}
		elseif ($setType === 'spacer')
		{
			// now add to the field set
			$field->fieldXML = new SimpleXMLElement('<field/>');
			$field->comment  = Line::_(__Line__, __Class__) . " " . ucfirst($name)
				. " Field. Type: " . StringHelper::safe(
					$typeName, 'F'
				) . ". A None Database Field. (joomla)";

			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
			}
		}
		elseif ($setType === 'special')
		{
			// set the repeatable field
			if ($typeName === 'repeatable')
			{
				// now add to the field set
				$field->fieldXML = new SimpleXMLElement('<field/>');
				$field->comment  = Line::_(__Line__, __Class__) . " " . ucfirst(
						$name
					) . " Field. Type: " . StringHelper::safe(
						$typeName, 'F'
					) . ". (depreciated)";

				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field->fieldXML->addAttribute($property, $value);
					}
				}
				$fieldsXML = $field->fieldXML->addChild('fields');
				$fieldsXML->addAttribute(
					'name', $fieldAttributes['name'] . '_fields'
				);
				$fieldsXML->addAttribute('label', '');
				$fieldSetXML = $fieldsXML->addChild('fieldset');
				$fieldSetXML->addAttribute('hidden', 'true');
				$fieldSetXML->addAttribute(
					'name', $fieldAttributes['name'] . '_modal'
				);
				$fieldSetXML->addAttribute('repeat', 'true');

				if (strpos($fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(
						',', $fieldAttributes['fields']
					);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ArrayHelper::check($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(
						function ($id) use (
							$nameSingleCode, $nameListCode, $_resolverKey
						) {
							// start field
							$field          = array();
							$field['field'] = $id;
							// set the field details
							$this->setFieldDetails(
								$field, $nameSingleCode, $nameListCode,
								$_resolverKey
							);

							// return field
							return $field;
						}, array_values($fieldsSets)
					);
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ObjectHelper::check(
							$fieldData['settings']
						))
						{
							$r_name      = $this->getFieldName(
								$fieldData, $nameListCode, $_resolverKey
							);
							$r_typeName  = $this->getFieldType($fieldData);
							$r_multiple  = false;
							$r_langLabel = '';
							// get field values
							$r_fieldValues = $this->setFieldAttributes(
								$fieldData, $view, $r_name, $r_typeName,
								$r_multiple, $r_langLabel, $langView,
								$nameListCode, $nameSingleCode,
								$placeholders, true
							);
							// check if values were set
							if (ArrayHelper::check(
								$r_fieldValues
							))
							{
								//reset options array
								$r_optionArray = array();
								if (ComponentbuilderHelper::fieldCheck(
									$r_typeName, 'option'
								))
								{
									// now add to the field set
									ComponentbuilderHelper::xmlAppend(
										$fieldSetXML, $this->setField(
										'option', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray
									)
									);
								}
								elseif (isset($r_fieldValues['custom'])
									&& ArrayHelper::check(
										$r_fieldValues['custom']
									))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									ComponentbuilderHelper::xmlAppend(
										$fieldSetXML, $this->setField(
										'custom', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray
									)
									);
									// set lang (just incase)
									$r_listLangName = $langView . '_'
										. FieldHelper::safe(
											$r_name, true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $r_listLangName,
										StringHelper::safe(
											$r_name, 'W'
										)
									);
									// if label was set use instead
									if (StringHelper::check(
										$r_langLabel
									))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type'   => $r_typeName,
									              'code'   => $r_name,
									              'lang'   => $r_listLangName,
									              'custom' => $custom);
									// set the custom field file
									$this->setCustomFieldTypeFile(
										$data, $nameListCode,
										$nameSingleCode
									);
								}
								else
								{
									// now add to the field set
									ComponentbuilderHelper::xmlAppend(
										$fieldSetXML, $this->setField(
										'plain', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray
									)
									);
								}
							}
						}
					}
				}
			}
			// set the subform fields (it is a repeatable without the modal)
			elseif ($typeName === 'subform')
			{
				// now add to the field set
				$field->fieldXML = new SimpleXMLElement('<field/>');
				$field->comment  = Line::_(__Line__, __Class__) . " " . ucfirst(
						$name
					) . " Field. Type: " . StringHelper::safe(
						$typeName, 'F'
					) . ". (joomla)";
				// add all properties
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields' && $property != 'formsource')
					{
						$field->fieldXML->addAttribute($property, $value);
					}
				}
				// if we detect formsource we do not add the form
				if (isset($fieldAttributes['formsource'])
					&& StringHelper::check(
						$fieldAttributes['formsource']
					))
				{
					$field->fieldXML->addAttribute(
						'formsource', $fieldAttributes['formsource']
					);
				}
				// add the form
				else
				{
					$form       = $field->fieldXML->addChild('form');
					$attributes = array(
						'hidden' => 'true',
						'name'   => 'list_' . $fieldAttributes['name']
							. '_modal',
						'repeat' => 'true'
					);
					ComponentbuilderHelper::xmlAddAttributes(
						$form, $attributes
					);

					if (strpos($fieldAttributes['fields'], ',') !== false)
					{
						// multiple fields
						$fieldsSets = (array) explode(
							',', $fieldAttributes['fields']
						);
					}
					elseif (is_numeric($fieldAttributes['fields']))
					{
						// single field
						$fieldsSets[] = (int) $fieldAttributes['fields'];
					}
					// only continue if we have a field set
					if (ArrayHelper::check($fieldsSets))
					{
						// set the resolver
						$_resolverKey = $fieldAttributes['name'];
						// load the field data
						$fieldsSets = array_map(
							function ($id) use (
								$nameSingleCode, $nameListCode,
								$_resolverKey
							) {
								// start field
								$field          = array();
								$field['field'] = $id;
								// set the field details
								$this->setFieldDetails(
									$field, $nameSingleCode, $nameListCode,
									$_resolverKey
								);

								// return field
								return $field;
							}, array_values($fieldsSets)
						);
						// start the build
						foreach ($fieldsSets as $fieldData)
						{
							// if we have settings continue
							if (ObjectHelper::check(
								$fieldData['settings']
							))
							{
								$r_name      = $this->getFieldName(
									$fieldData, $nameListCode, $_resolverKey
								);
								$r_typeName  = $this->getFieldType($fieldData);
								$r_multiple  = false;
								$r_langLabel = '';
								// get field values
								$r_fieldValues = $this->setFieldAttributes(
									$fieldData, $view, $r_name, $r_typeName,
									$r_multiple, $r_langLabel, $langView,
									$nameListCode, $nameSingleCode,
									$placeholders, true
								);
								// check if values were set
								if (ArrayHelper::check(
									$r_fieldValues
								))
								{
									//reset options array
									$r_optionArray = array();
									if (ComponentbuilderHelper::fieldCheck(
										$r_typeName, 'option'
									))
									{
										// now add to the field set
										ComponentbuilderHelper::xmlAppend(
											$form, $this->setField(
											'option', $r_fieldValues, $r_name,
											$r_typeName, $langView,
											$nameSingleCode, $nameListCode,
											$placeholders, $r_optionArray
										)
										);
									}
									elseif ($r_typeName === 'subform')
									{
										// set nested depth
										if (isset($fieldAttributes['nested_depth']))
										{
											$r_fieldValues['nested_depth']
												= ++$fieldAttributes['nested_depth'];
										}
										else
										{
											$r_fieldValues['nested_depth'] = 1;
										}
										// only continue if nest is bellow 20 (this should be a safe limit)
										if ($r_fieldValues['nested_depth']
											<= 20)
										{
											// now add to the field set
											ComponentbuilderHelper::xmlAppend(
												$form, $this->setField(
												'special', $r_fieldValues,
												$r_name, $r_typeName, $langView,
												$nameSingleCode,
												$nameListCode, $placeholders,
												$r_optionArray
											)
											);
										}

									}
									elseif (isset($r_fieldValues['custom'])
										&& ArrayHelper::check(
											$r_fieldValues['custom']
										))
									{
										// add to custom
										$custom = $r_fieldValues['custom'];
										unset($r_fieldValues['custom']);
										// now add to the field set
										ComponentbuilderHelper::xmlAppend(
											$form, $this->setField(
											'custom', $r_fieldValues, $r_name,
											$r_typeName, $langView,
											$nameSingleCode, $nameListCode,
											$placeholders, $r_optionArray
										)
										);
										// set lang (just incase)
										$r_listLangName = $langView . '_'
											. FieldHelper::safe(
												$r_name, true
											);
										// add to lang array
										CFactory::_('Language')->set(
											CFactory::_('Config')->lang_target, $r_listLangName,
											StringHelper::safe(
												$r_name, 'W'
											)
										);
										// if label was set use instead
										if (StringHelper::check(
											$r_langLabel
										))
										{
											$r_listLangName = $r_langLabel;
										}
										// set the custom array
										$data = array('type'   => $r_typeName,
										              'code'   => $r_name,
										              'lang'   => $r_listLangName,
										              'custom' => $custom);
										// set the custom field file
										$this->setCustomFieldTypeFile(
											$data, $nameListCode,
											$nameSingleCode
										);
									}
									else
									{
										// now add to the field set
										ComponentbuilderHelper::xmlAppend(
											$form, $this->setField(
											'plain', $r_fieldValues, $r_name,
											$r_typeName, $langView,
											$nameSingleCode, $nameListCode,
											$placeholders, $r_optionArray
										)
										);
									}
								}
							}
						}
					}
				}
			}
		}
		elseif ($setType === 'custom')
		{
			// now add to the field set
			$field->fieldXML = new SimpleXMLElement('<field/>');
			$field->comment  = Line::_(__Line__, __Class__) . " " . ucfirst($name)
				. " Field. Type: " . StringHelper::safe(
					$typeName, 'F'
				) . ". (custom)";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
				elseif ($property === 'option')
				{
					ComponentbuilderHelper::xmlComment(
						$field->fieldXML,
						Line::_(__Line__, __Class__) . " Option Set."
					);
					if (strtolower($typeName) === 'groupedlist'
						&& strpos(
							$value, ','
						) !== false
						&& strpos($value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_  = array();
						$grouped_ = array('group'  => array(),
						                  'option' => array());
						$order_   = array();
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							if (strpos($option, '@@') !== false)
							{
								// set the group label
								$valueKeyArray = explode('@@', $option);
								if (count((array) $valueKeyArray) == 2)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[0], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[0]
									);
									// now add group label
									$groups_[$valueKeyArray[1]] = $langValue;
									// set order
									$order_['group' . $valueKeyArray[1]]
										= $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][]
										= array('value' => $valueKeyArray[0],
										        'text'  => $langValue);
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]]
										= $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									CFactory::_('Language')->set(
										CFactory::_('Config')->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]]
										= array('value' => $valueKeyArray[0],
										        'text'  => $langValue);
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]]
										= $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$grouped_['option'][$option]
									                  = array('value' => $option,
									                          'text'  => $langValue);
								$optionArray[$option] = $langValue;
								// set order
								$order_['option' . $option] = $option;
							}
						}
						// now build the groups
						foreach ($order_ as $pointer_ => $_id)
						{
							// load the default key
							$key_ = 'group';
							if (strpos($pointer_, 'option') !== false)
							{
								// load the option field
								$key_ = 'option';
							}
							// check if this is a group loader
							if ('group' === $key_ && isset($groups_[$_id])
								&& isset($grouped_[$key_][$_id])
								&& ArrayHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								// set group label
								$groupXML = $field->fieldXML->addChild('group');
								$groupXML->addAttribute(
									'label', $groups_[$_id]
								);

								foreach ($grouped_[$key_][$_id] as $option_)
								{
									$groupOptionXML = $groupXML->addChild(
										'option'
									);
									$groupOptionXML->addAttribute(
										'value', $option_['value']
									);
									$groupOptionXML[] = $option_['text'];
								}
								unset($groups_[$_id]);
								unset($grouped_[$key_][$_id]);
							}
							elseif (isset($grouped_[$key_][$_id])
								&& StringHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								$optionXML = $field->fieldXML->addChild(
									'option'
								);
								$optionXML->addAttribute(
									'value', $grouped_[$key_][$_id]['value']
								);
								$optionXML[] = $grouped_[$key_][$_id]['text'];
							}
						}
					}
					elseif (strpos($value, ',') !== false)
					{
						// municipal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							$optionXML = $field->fieldXML->addChild('option');
							if (strpos($option, '|') !== false)
							{
								// has other value then text
								list($v, $t) = explode('|', $option);
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$t, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $t
								);
								// now add to option set
								$optionXML->addAttribute('value', $v);
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								CFactory::_('Language')->set(
									CFactory::_('Config')->lang_target, $langValue, $option
								);
								// now add to option set
								$optionXML->addAttribute('value', $option);
								$optionArray[$option] = $langValue;
							}
							$optionXML[] = $langValue;
						}
					}
					else
					{
						// one option
						$optionXML = $field->fieldXML->addChild('option');
						if (strpos($value, '|') !== false)
						{
							// has other value then text
							list($v, $t) = explode('|', $value);
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$t, true
								);
							// add to lang array
							CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langValue, $t);
							// now add to option set
							$optionXML->addAttribute('value', $v);
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$value, true
								);
							// add to lang array
							CFactory::_('Language')->set(
								CFactory::_('Config')->lang_target, $langValue, $value
							);
							// now add to option set
							$optionXML->addAttribute('value', $value);
							$optionArray[$value] = $langValue;
						}
						$optionXML[] = $langValue;
					}
				}
			}
			// incase the field is in the config and has not been set (or is part of a plugin or module)
			if (('config' === $nameSingleCode
					&& 'configs' === $nameListCode)
				|| (strpos($nameSingleCode, 'P|uG!n') !== false
					|| strpos(
						$nameSingleCode, 'M0dU|3'
					) !== false))
			{
				// set lang (just incase)
				$listLangName = $langView . '_'
					. StringHelper::safe($name, 'U');
				// set the custom array
				$data = array('type' => $typeName, 'code' => $name,
				              'lang' => $listLangName, 'custom' => $custom);
				// set the custom field file
				$this->setCustomFieldTypeFile(
					$data, $nameListCode, $nameSingleCode
				);
			}
		}

		return $field;
	}

	/**
	 * set the layout builder
	 *
	 * @param   string  $nameSingleCode  The single edit view code name
	 * @param   string  $tabName         The tab code name
	 * @param   string  $name            The field code name
	 * @param   array   $field           The field details
	 *
	 * @return  void
	 *
	 */
	public function setLayoutBuilder(&$nameSingleCode, &$tabName, &$name,
		&$field
	) {
		// first fix the zero order
		// to insure it lands before all the other fields
		// as zero is expected to behave
		if ($field['order_edit'] == 0)
		{
			if (!isset($this->zeroOrderFix[$nameSingleCode]))
			{
				$this->zeroOrderFix[$nameSingleCode] = array();
			}
			if (!isset($this->zeroOrderFix[$nameSingleCode][(int) $field['tab']]))
			{
				$this->zeroOrderFix[$nameSingleCode][(int) $field['tab']]
					= -999;
			}
			else
			{
				$this->zeroOrderFix[$nameSingleCode][(int) $field['tab']]++;
			}
			$field['order_edit']
				= $this->zeroOrderFix[$nameSingleCode][(int) $field['tab']];
		}
		// now build the layout
		if (StringHelper::check($tabName)
			&& $tabName != 'publishing')
		{
			$this->tabCounter[$nameSingleCode][(int) $field['tab']]
				= $tabName;
			if (isset($this->layoutBuilder[$nameSingleCode][$tabName][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = (int) count(
						(array) $this->layoutBuilder[$nameSingleCode][$tabName][(int) $field['alignment']]
					) + 1;
				while (isset($this->layoutBuilder[$nameSingleCode][$tabName][(int) $field['alignment']][$size]))
				{
					$size++;
				}
				$this->layoutBuilder[$nameSingleCode][$tabName][(int) $field['alignment']][$size]
					= $name;
			}
			else
			{
				$this->layoutBuilder[$nameSingleCode][$tabName][(int) $field['alignment']][(int) $field['order_edit']]
					= $name;
			}
			// check if default fields were over written
			if (in_array($name, $this->defaultFields))
			{
				// just to eliminate
				$this->movedPublishingFields[$nameSingleCode][$name] = $name;
			}
		}
		elseif ($tabName === 'publishing' || $tabName === 'Publishing')
		{
			if (!in_array($name, $this->defaultFields))
			{
				if (isset($this->newPublishingFields[$nameSingleCode][(int) $field['alignment']][(int) $field['order_edit']]))
				{
					$size = (int) count(
							(array) $this->newPublishingFields[$nameSingleCode][(int) $field['alignment']]
						) + 1;
					while (isset($this->newPublishingFields[$nameSingleCode][(int) $field['alignment']][$size]))
					{
						$size++;
					}
					$this->newPublishingFields[$nameSingleCode][(int) $field['alignment']][$size]
						= $name;
				}
				else
				{
					$this->newPublishingFields[$nameSingleCode][(int) $field['alignment']][(int) $field['order_edit']]
						= $name;
				}
			}
		}
		else
		{
			$this->tabCounter[$nameSingleCode][1] = 'Details';
			if (isset($this->layoutBuilder[$nameSingleCode]['Details'][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = (int) count(
						(array) $this->layoutBuilder[$nameSingleCode]['Details'][(int) $field['alignment']]
					) + 1;
				while (isset($this->layoutBuilder[$nameSingleCode]['Details'][(int) $field['alignment']][$size]))
				{
					$size++;
				}
				$this->layoutBuilder[$nameSingleCode]['Details'][(int) $field['alignment']][$size]
					= $name;
			}
			else
			{
				$this->layoutBuilder[$nameSingleCode]['Details'][(int) $field['alignment']][(int) $field['order_edit']]
					= $name;
			}
			// check if default fields were over written
			if (in_array($name, $this->defaultFields))
			{
				// just to eliminate
				$this->movedPublishingFields[$nameSingleCode][$name] = $name;
			}
		}
	}

	/**
	 * build the site field data needed
	 *
	 * @param   string  $view   The single edit view code name
	 * @param   string  $field  The field name
	 * @param   string  $set    The decoding set this field belongs to
	 * @param   string  $type   The field type
	 *
	 * @return  void
	 *
	 */
	public function buildSiteFieldData($view, $field, $set, $type)
	{
		$decode    = array('json', 'base64', 'basic_encryption',
		                   'whmcs_encryption', 'medium_encryption',
		                   'expert_mode');
		$textareas = array('textarea', 'editor');
		if (isset($this->siteFields[$view][$field])
			&& ArrayHelper::check(
				$this->siteFields[$view][$field]
			))
		{
			foreach ($this->siteFields[$view][$field] as $codeString => $array)
			{
				// get the code array
				$codeArray = explode('___', $codeString);
				// set the code
				$code = trim($codeArray[0]);
				// set the decoding methods
				if (in_array($set, $decode))
				{
					if (isset($this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']])
						&& isset($this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]['decode']))
					{
						if (!in_array(
							$set,
							$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]['decode']
						))
						{
							$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]['decode'][]
								= $set;
						}
					}
					else
					{
						$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]
							= array('decode'     => array($set),
							        'type'       => $type,
							        'admin_view' => $view);
					}
				}
				// set the uikit checker
				if ((2 == $this->uikit || 1 == $this->uikit)
					&& in_array(
						$type, $textareas
					))
				{
					$this->siteFieldData['uikit'][$array['site']][$code][$array['as']][$array['key']]
						= $array;
				}
				// set the textareas checker
				if (in_array($type, $textareas))
				{
					$this->siteFieldData['textareas'][$array['site']][$code][$array['as']][$array['key']]
						= $array;
				}
			}
		}
	}

	/**
	 * set field attributes
	 *
	 * @param   array    $field           The field data
	 * @param   int      $viewType        The view type
	 * @param   string   $name            The field name
	 * @param   string   $typeName        The field type
	 * @param   boolean  $multiple        The switch to set multiple selection option
	 * @param   string   $langLabel       The language string for field label
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameListCode    The list view name
	 * @param   string   $nameSingleCode  The single view name
	 * @param   array    $placeholders    The place holder and replace values
	 * @param   boolean  $repeatable      The repeatable field switch
	 *
	 * @return  array The field attributes
	 *
	 */
	private function setFieldAttributes(&$field, &$viewType, &$name, &$typeName,
		&$multiple, &$langLabel, $langView, $nameListCode, $nameSingleCode,
		$placeholders, $repeatable = false
	) {
		// reset array
		$fieldAttributes = array();
		$setCustom       = false;
		$setReadonly     = false;
		// setup joomla default fields
		if (!ComponentbuilderHelper::fieldCheck($typeName))
		{
			$fieldAttributes['custom'] = array();
			// is this an own custom field
			if (isset($field['settings']->own_custom))
			{
				$fieldAttributes['custom']['own_custom']
					= $field['settings']->own_custom;
			}
			$setCustom = true;
		}
		// setup a default field
		if (ArrayHelper::check($field['settings']->properties))
		{
			// we need a deeper php code search tracker
			$phpTracker = array();
			foreach ($field['settings']->properties as $property)
			{
				// reset
				$xmlValue  = '';
				$langValue = '';
				if ($property['name'] === 'type')
				{
					// get type name
					$xmlValue = $typeName;

					// add to custom if it is custom
					if ($setCustom)
					{
						// set the type just to make sure.
						$fieldAttributes['custom']['type'] = $typeName;
					}
				}
				elseif ($property['name'] === 'name')
				{
					// get the actual field name
					$xmlValue = CFactory::_('Placeholder')->update($name, $placeholders);
				}
				elseif ($property['name'] === 'validate')
				{
					// check if we have validate (validation rule set)
					$xmlValue = GetHelper::between(
						$field['settings']->xml, 'validate="', '"'
					);
					if (StringHelper::check($xmlValue))
					{
						$xmlValue = StringHelper::safe(
							$xmlValue
						);
					}
				}
				elseif ($property['name'] === 'extension'
					|| $property['name'] === 'directory'
					|| $property['name'] === 'formsource')
				{
					// get value & replace the placeholders
					$xmlValue = CFactory::_('Placeholder')->update(
						GetHelper::between(
							$field['settings']->xml, $property['name'] . '="',
							'"'
						), $placeholders
					);
				}
				// catch all PHP here
				elseif (strpos($property['name'], 'type_php') !== false
					&& $setCustom)
				{
					// set the line number
					$phpLine = (int) preg_replace(
						'/[^0-9]/', '', $property['name']
					);
					// set the type key
					$phpKey = (string) trim(
						str_replace(
							'type_', '',
							preg_replace('/[0-9]+/', '', $property['name'])
						), '_'
					);
					// load the php for the custom field file
					$fieldAttributes['custom'][$phpKey][$phpLine]
						= CFactory::_('Customcode')->update(
						ComponentbuilderHelper::openValidBase64(
							GetHelper::between(
								$field['settings']->xml,
								$property['name'] . '="', '"'
							)
						)
					);
					// load tracker
					$phpTracker['type_' . $phpKey] = $phpKey;
				}
				elseif ($property['name'] === 'prime_php' && $setCustom)
				{
					// load the php for the custom field file
					$fieldAttributes['custom']['prime_php']
						= (int) GetHelper::between(
						$field['settings']->xml, $property['name'] . '="', '"'
					);
				}
				elseif ($property['name'] === 'extends' && $setCustom)
				{
					// load the class that is being extended
					$fieldAttributes['custom']['extends']
						= GetHelper::between(
						$field['settings']->xml, 'extends="', '"'
					);
				}
				elseif ($property['name'] === 'view' && $setCustom)
				{
					// load the view name & replace the placeholders
					$fieldAttributes['custom']['view']
						= StringHelper::safe(
						CFactory::_('Placeholder')->update(
							GetHelper::between(
								$field['settings']->xml, 'view="', '"'
							), $placeholders
						)
					);
				}
				elseif ($property['name'] === 'views' && $setCustom)
				{
					// load the views name & replace the placeholders
					$fieldAttributes['custom']['views']
						= StringHelper::safe(
						CFactory::_('Placeholder')->update(
							GetHelper::between(
								$field['settings']->xml, 'views="', '"'
							), $placeholders
						)
					);
				}
				elseif ($property['name'] === 'component' && $setCustom)
				{
					// load the component name & replace the placeholders
					$fieldAttributes['custom']['component']
						= CFactory::_('Placeholder')->update(
						GetHelper::between(
							$field['settings']->xml, 'component="', '"'
						), $placeholders
					);
				}
				elseif ($property['name'] === 'table' && $setCustom)
				{
					// load the main table that is queried & replace the placeholders
					$fieldAttributes['custom']['table']
						= CFactory::_('Placeholder')->update(
						GetHelper::between(
							$field['settings']->xml, 'table="', '"'
						), $placeholders
					);
				}
				elseif ($property['name'] === 'value_field' && $setCustom)
				{
					// load the text key
					$fieldAttributes['custom']['text']
						= StringHelper::safe(
						GetHelper::between(
							$field['settings']->xml, 'value_field="', '"'
						)
					);
				}
				elseif ($property['name'] === 'key_field' && $setCustom)
				{
					// load the id key
					$fieldAttributes['custom']['id']
						= StringHelper::safe(
						GetHelper::between(
							$field['settings']->xml, 'key_field="', '"'
						)
					);
				}
				elseif ($property['name'] === 'button' && $repeatable
					&& $setCustom)
				{
					// dont load the button to repeatable
					$xmlValue = 'false';
					// do not add button
					$fieldAttributes['custom']['add_button'] = 'false';
				}
				elseif ($property['name'] === 'button' && $setCustom)
				{
					// load the button string value if found
					$xmlValue = (string) StringHelper::safe(
						GetHelper::between(
							$field['settings']->xml, 'button="', '"'
						)
					);
					// add to custom values
					$fieldAttributes['custom']['add_button']
						= (StringHelper::check($xmlValue)
						|| 1 == $xmlValue) ? $xmlValue : 'false';
				}
				elseif ($property['name'] === 'required'
					&& 'repeatable' === $typeName)
				{
					// dont load the required to repeatable field type
					$xmlValue = 'false';
				}
				elseif ($viewType == 2
					&& ($property['name'] === 'readonly'
						|| $property['name'] === 'disabled'))
				{
					// set read only
					$xmlValue = 'true';
					// trip the switch for readonly
					if ($property['name'] === 'readonly')
					{
						$setReadonly = true;
					}
				}
				elseif ($property['name'] === 'multiple')
				{
					$xmlValue = (string) GetHelper::between(
						$field['settings']->xml, $property['name'] . '="', '"'
					);
					// add the multipal
					if ('true' === $xmlValue)
					{
						$multiple = true;
					}
				}
				// make sure the name is added as a cless name for use in javascript
				elseif ($property['name'] === 'class'
					&& ($typeName === 'note'
						|| $typeName === 'spacer'))
				{
					$xmlValue = GetHelper::between(
						$field['settings']->xml, 'class="', '"'
					);
					// add the type class
					if (StringHelper::check($xmlValue))
					{
						if (strpos($xmlValue, $name) === false)
						{
							$xmlValue = $xmlValue . ' ' . $name;
						}
					}
					else
					{
						$xmlValue = $name;
					}
				}
				else
				{
					// set the rest of the fields
					$xmlValue = (string) CFactory::_('Placeholder')->update(
						GetHelper::between(
							$field['settings']->xml, $property['name'] . '="',
							'"'
						), $placeholders
					);
				}

				// check if translatable
				if (StringHelper::check($xmlValue)
					&& isset($property['translatable'])
					&& $property['translatable'] == 1)
				{
					// update label if field use multiple times
					if ($property['name'] === 'label')
					{
						if (isset($fieldAttributes['name'])
							&& isset($this->uniqueNames[$nameListCode]['names'][$fieldAttributes['name']]))
						{
							$xmlValue .= ' ('
								. StringHelper::safe(
									$this->uniqueNames[$nameListCode]['names'][$fieldAttributes['name']]
								) . ')';
						}
					}
					// replace placeholders
					$xmlValue = CFactory::_('Placeholder')->update(
						$xmlValue, $placeholders
					);
					// insure custom lables dont get messed up
					if ($setCustom)
					{
						$customLabel = $xmlValue;
					}
					// set lang key
					$langValue = $langView . '_'
						. FieldHelper::safe(
							$name . ' ' . $property['name'], true
						);
					// add to lang array
					CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langValue, $xmlValue);
					// use lang value
					$xmlValue = $langValue;
				}
				elseif (isset($field['alias']) && $field['alias']
					&& isset($property['translatable'])
					&& $property['translatable'] == 1)
				{
					if ($property['name'] === 'label')
					{
						$xmlValue = 'JFIELD_ALIAS_LABEL';
					}
					elseif ($property['name'] === 'description')
					{
						$xmlValue = 'JFIELD_ALIAS_DESC';
					}
					elseif ($property['name'] === 'hint')
					{
						$xmlValue = 'JFIELD_ALIAS_PLACEHOLDER';
					}
				}
				elseif (isset($field['title']) && $field['title']
					&& isset($property['translatable'])
					&& $property['translatable'] == 1)
				{
					if ($property['name'] === 'label')
					{
						$xmlValue = 'JGLOBAL_TITLE';
					}
				}
				// only load value if found or is mandatory
				if (StringHelper::check($xmlValue)
					|| (isset($property['mandatory'])
						&& $property['mandatory'] == 1
						&& !$setCustom))
				{
					// make sure mantory fields are added
					if (!StringHelper::check($xmlValue))
					{
						if (isset($property['example'])
							&& StringHelper::check(
								$property['example']
							))
						{
							$xmlValue = $property['example'];
						}
					}
					// load to langBuilder down the line
					if ($property['name'] === 'label')
					{
						if ($setCustom)
						{
							$fieldAttributes['custom']['label'] = $customLabel;
						}
						$langLabel = $xmlValue;
					}
					// now set the value
					$fieldAttributes[$property['name']] = $xmlValue;
				}
				// validate that the default field is set
				elseif ($property['name'] === 'default'
					&& ($xmlValidateValue
						= GetHelper::between(
						$field['settings']->xml, 'default="', '"', 'none-set'
					)) !== 'none-set')
				{
					// we must allow empty defaults
					$fieldAttributes['default'] = $xmlValue;
				}
			}
			// check if all php is loaded using the tracker
			if (ArrayHelper::check($phpTracker))
			{
				// litle search validation
				$confirmation
					= '8qvZHoyuFYQqpj0YQbc6F3o5DhBlmS-_-a8pmCZfOVSfANjkmV5LG8pCdAY2JNYu6cB';
				foreach ($phpTracker as $searchKey => $phpKey)
				{
					// we must search for more code in the xml just encase
					foreach (range(2, 30) as $phpLine)
					{
						$get_ = $searchKey . '_' . $phpLine;
						if (!isset($fieldAttributes['custom'][$phpKey][$phpLine])
							&& ($value
								= ComponentbuilderHelper::getValueFromXMLstring(
								$field['settings']->xml, $get_, $confirmation
							)) !== $confirmation)
						{
							$fieldAttributes['custom'][$phpKey][$phpLine]
								= CFactory::_('Customcode')->update(
								ComponentbuilderHelper::openValidBase64($value)
							);
						}
					}
				}
			}
			// do some nice twigs beyond the default
			if (isset($fieldAttributes['name']))
			{
				// check if we have class value for the list view of this field
				$listclass = GetHelper::between(
					$field['settings']->xml, 'listclass="', '"'
				);
				if (StringHelper::check($listclass))
				{
					$this->listFieldClass[$nameListCode][$fieldAttributes['name']]
						= $listclass;
				}
				// check if we find reason to remove this field from being escaped
				$escaped = GetHelper::between(
					$field['settings']->xml, 'escape="', '"'
				);
				if (StringHelper::check($escaped))
				{
					$this->doNotEscape[$nameListCode][]
						= $fieldAttributes['name'];
				}
				// check if we have display switch for dynamic placement
				$display = GetHelper::between(
					$field['settings']->xml, 'display="', '"'
				);
				if (StringHelper::check($display))
				{
					$fieldAttributes['display'] = $display;
				}
				// make sure validation is set if found (even it not part of field properties)
				if (!isset($fieldAttributes['validate']))
				{
					// check if we have validate (validation rule set)
					$validationRule = GetHelper::between(
						$field['settings']->xml, 'validate="', '"'
					);
					if (StringHelper::check($validationRule))
					{
						$fieldAttributes['validate']
							= StringHelper::safe(
							$validationRule
						);
					}
				}
				// make sure ID is always readonly
				if ($fieldAttributes['name'] === 'id' && !$setReadonly)
				{
					$fieldAttributes['readonly'] = 'true';
				}
			}
		}

		return $fieldAttributes;
	}

	/**
	 * set Builders
	 *
	 * @param   string   $langLabel       The language string for field label
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   string   $name            The field name
	 * @param   array    $view            The view data
	 * @param   array    $field           The field data
	 * @param   string   $typeName        The field type
	 * @param   boolean  $multiple        The switch to set multiple selection option
	 * @param   boolean  $custom          The custom field switch
	 * @param   boolean  $options         The options switch
	 *
	 * @return  void
	 *
	 */
	public function setBuilders($langLabel, $langView, $nameSingleCode,
		$nameListCode, $name, $view, $field, $typeName, $multiple,
		$custom = false, $options = false
	) {
		// check if this is a tag field
		if ($typeName === 'tag')
		{
			// set tags for this view but don't load to DB
			$this->tagsBuilder[$nameSingleCode] = $nameSingleCode;
		}
		// dbSwitch
		$dbSwitch = true;
		if (isset($field['list']) && $field['list'] == 2)
		{
			// do not add this field to the database
			$dbSwitch = false;
		}
		elseif (isset($field['settings']->datatype))
		{
			// insure default not none if number type
			$numberKeys = array('INT', 'TINYINT', 'BIGINT', 'FLOAT', 'DECIMAL',
			                    'DOUBLE');
			// don't use these as index or uniqe keys
			$textKeys = array('TEXT', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT',
			                  'BLOB', 'TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB');
			// build the query values
			$this->queryBuilder[$nameSingleCode][$name]['type']
				= $field['settings']->datatype;
			// check if this is a number
			if (in_array($field['settings']->datatype, $numberKeys))
			{
				if ($field['settings']->datadefault === 'Other')
				{
					// setup the checking
					$number_check = $field['settings']->datadefault_other;
					// Decimals in SQL needs some help
					if ('DECIMAL' === $field['settings']->datatype
						&& !is_numeric($number_check))
					{
						$number_check = str_replace(
							',', '.', $field['settings']->datadefault_other
						);
					}
					// check if we have a valid number value
					if (!is_numeric($number_check))
					{
						$field['settings']->datadefault_other = '0';
					}
				}
				elseif (!is_numeric($field['settings']->datadefault))
				{
					$field['settings']->datadefault = '0';
				}
			}
			// check if this is not text
			if (!in_array($field['settings']->datatype, $textKeys))
			{
				$this->queryBuilder[$nameSingleCode][$name]['lenght']
					= $field['settings']->datalenght;
				$this->queryBuilder[$nameSingleCode][$name]['lenght_other']
					= $field['settings']->datalenght_other;
				$this->queryBuilder[$nameSingleCode][$name]['default']
					= $field['settings']->datadefault;
				$this->queryBuilder[$nameSingleCode][$name]['other']
					= $field['settings']->datadefault_other;
			}
			// fall back unto EMPTY for text
			else
			{
				$this->queryBuilder[$nameSingleCode][$name]['default']
					= 'EMPTY';
			}
			// to identify the field
			$this->queryBuilder[$nameSingleCode][$name]['ID']
				= $field['settings']->id;
			$this->queryBuilder[$nameSingleCode][$name]['null_switch']
				= $field['settings']->null_switch;
			// set index types
			$_guid = true;
			if ($field['settings']->indexes == 1
				&& !in_array(
					$field['settings']->datatype, $textKeys
				))
			{
				// build unique keys of this view for db
				$this->dbUniqueKeys[$nameSingleCode][] = $name;
				// prevent guid from being added twice
				if ('guid' === $name)
				{
					$_guid = false;
				}
			}
			elseif (($field['settings']->indexes == 2
					|| (isset($field['alias'])
						&& $field['alias'])
					|| (isset($field['title']) && $field['title'])
					|| $typeName === 'category')
				&& !in_array($field['settings']->datatype, $textKeys))
			{
				// build keys of this view for db
				$this->dbKeys[$nameSingleCode][] = $name;
			}
			// special treatment for GUID
			if ('guid' === $name && $_guid)
			{
				$this->dbUniqueGuid[$nameSingleCode] = true;
			}
		}
		// set list switch
		$listSwitch = (isset($field['list'])
			&& ($field['list'] == 1
				|| $field['list'] == 3
				|| $field['list'] == 4));
		// set list join
		$listJoin
			= (isset($this->listJoinBuilder[$nameListCode][(int) $field['field']]));
		// add history to this view
		if (isset($view['history']) && $view['history'])
		{
			$this->historyBuilder[$nameSingleCode] = $nameSingleCode;
		}
		// set Alias (only one title per view)
		if ($dbSwitch && isset($field['alias']) && $field['alias']
			&& !isset($this->aliasBuilder[$nameSingleCode]))
		{
			$this->aliasBuilder[$nameSingleCode] = $name;
		}
		// set Titles (only one title per view)
		if ($dbSwitch && isset($field['title']) && $field['title']
			&& !isset($this->titleBuilder[$nameSingleCode]))
		{
			$this->titleBuilder[$nameSingleCode] = $name;
		}
		// category name fix
		if ($typeName === 'category')
		{
			if (isset($this->catOtherName[$nameListCode])
				&& ArrayHelper::check(
					$this->catOtherName[$nameListCode]
				))
			{
				$tempName = $this->catOtherName[$nameListCode]['name'];
			}
			else
			{
				$tempName = $nameListCode . ' categories';
			}
			// set lang
			$listLangName = $langView . '_'
				. FieldHelper::safe($tempName, true);
			// set field name
			$listFieldName = StringHelper::safe($tempName, 'W');
			// add to lang array
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $listLangName, $listFieldName
			);
		}
		else
		{
			// if label was set use instead
			if (StringHelper::check($langLabel))
			{
				$listLangName = $langLabel;
				// get field label from the lang label
				if (CFactory::_('Language')->exist(CFactory::_('Config')->lang_target, $langLabel))
				{
					$listFieldName
						= CFactory::_('Language')->get(CFactory::_('Config')->lang_target, $langLabel);
				}
				else
				{
					// get it from the field xml string
					$listFieldName = (string) CFactory::_('Placeholder')->update(
						GetHelper::between(
							$field['settings']->xml, 'label="',
							'"'
						), CFactory::_('Placeholder')->active
					);
				}
				// make sure there is no html in the list field name
				$listFieldName = strip_tags($listFieldName);
			}
			else
			{
				// set lang (just in case)
				$listLangName = $langView . '_'
					. FieldHelper::safe($name, true);
				// set field name
				$listFieldName = StringHelper::safe($name, 'W');
				// add to lang array
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $listLangName, $listFieldName
				);
			}
		}
		// build the list values
		if (($listSwitch || $listJoin) && $typeName != 'repeatable'
			&& $typeName != 'subform')
		{
			// load to list builder
			if ($listSwitch)
			{
				$this->listBuilder[$nameListCode][] = array(
					'id'       => (int) $field['field'],
					'type'     => $typeName,
					'code'     => $name,
					'lang'     => $listLangName,
					'title'    => (isset($field['title']) && $field['title'])
						? true : false,
					'alias'    => (isset($field['alias']) && $field['alias'])
						? true : false,
					'link'     => (isset($field['link']) && $field['link'])
						? true : false,
					'sort'     => (isset($field['sort']) && $field['sort'])
						? true : false,
					'custom'   => $custom,
					'multiple' => $multiple,
					'options'  => $options,
					'target'   => (int) $field['list']);
			}
			// build custom builder list
			if ($listSwitch || $listJoin)
			{
				$this->customBuilderList[$nameListCode][] = $name;
			}
		}
		// load the list join builder
		if ($listJoin)
		{
			$this->listJoinBuilder[$nameListCode][(int) $field['field']]
				= array(
				'type'     => $typeName,
				'code'     => $name,
				'lang'     => $listLangName,
				'title'    => (isset($field['title']) && $field['title']) ? true
					: false,
				'alias'    => (isset($field['alias']) && $field['alias']) ? true
					: false,
				'link'     => (isset($field['link']) && $field['link']) ? true
					: false,
				'sort'     => (isset($field['sort']) && $field['sort']) ? true
					: false,
				'custom'   => $custom,
				'multiple' => $multiple,
				'options'  => $options);
		}
		// update the field relations
		if (isset($this->fieldRelations[$nameListCode])
			&& isset($this->fieldRelations[$nameListCode][(int) $field['field']])
			&& ArrayHelper::check(
				$this->fieldRelations[$nameListCode][(int) $field['field']]
			))
		{
			foreach (
				$this->fieldRelations[$nameListCode][(int) $field['field']] as
				$area => &$field_values
			)
			{
				$field_values['type']   = $typeName;
				$field_values['code']   = $name;
				$field_values['custom'] = $custom;
			}
		}
		// set the hidden field of this view
		if ($dbSwitch && $typeName === 'hidden')
		{
			if (!isset($this->hiddenFieldsBuilder[$nameSingleCode]))
			{
				$this->hiddenFieldsBuilder[$nameSingleCode] = '';
			}
			$this->hiddenFieldsBuilder[$nameSingleCode] .= ',"' . $name . '"';
		}
		// set all int fields of this view
		if ($dbSwitch && isset($field['settings']->datatype)
			&& ($field['settings']->datatype === 'INT'
				|| $field['settings']->datatype === 'TINYINT'
				|| $field['settings']->datatype === 'BIGINT'))
		{
			if (!isset($this->intFieldsBuilder[$nameSingleCode]))
			{
				$this->intFieldsBuilder[$nameSingleCode] = '';
			}
			$this->intFieldsBuilder[$nameSingleCode] .= ',"' . $name . '"';
		}
		// set all dynamic field of this view
		if ($dbSwitch && $typeName != 'category' && $typeName != 'repeatable'
			&& $typeName != 'subform'
			&& !in_array($name, $this->defaultFields))
		{
			if (!isset($this->dynamicfieldsBuilder[$nameSingleCode]))
			{
				$this->dynamicfieldsBuilder[$nameSingleCode] = '';
			}
			if (isset($this->dynamicfieldsBuilder[$nameSingleCode])
				&& StringHelper::check(
					$this->dynamicfieldsBuilder[$nameSingleCode]
				))
			{
				$this->dynamicfieldsBuilder[$nameSingleCode] .= ',"' . $name
					. '":"' . $name . '"';
			}
			else
			{
				$this->dynamicfieldsBuilder[$nameSingleCode] .= '"' . $name
					. '":"' . $name . '"';
			}
		}
		// TODO we may need to add a switch instead (since now it uses the first editor field)
		// set the main(biggest) text field of this view
		if ($dbSwitch && $typeName === 'editor')
		{
			if (!isset($this->maintextBuilder[$nameSingleCode])
				|| !StringHelper::check(
					$this->maintextBuilder[$nameSingleCode]
				))
			{
				$this->maintextBuilder[$nameSingleCode] = $name;
			}
		}
		// set the custom builder
		if (ArrayHelper::check($custom)
			&& $typeName != 'category'
			&& $typeName != 'repeatable'
			&& $typeName != 'subform')
		{
			$this->customBuilder[$nameListCode][] = array('type'   => $typeName,
			                                              'code'   => $name,
			                                              'lang'   => $listLangName,
			                                              'custom' => $custom,
			                                              'method' => $field['settings']->store);
			// set the custom fields needed in content type data
			if (!isset($this->customFieldLinksBuilder[$nameSingleCode]))
			{
				$this->customFieldLinksBuilder[$nameSingleCode] = '';
			}
			// only load this if table is set
			if (isset($custom['table'])
				&& StringHelper::check(
					$custom['table']
				))
			{
				$this->customFieldLinksBuilder[$nameSingleCode] .= ',{"sourceColumn": "'
					. $name . '","targetTable": "' . $custom['table']
					. '","targetColumn": "' . $custom['id']
					. '","displayColumn": "' . $custom['text'] . '"}';
			}
			// build script switch for user
			if ($custom['extends'] === 'user')
			{
				$this->setScriptUserSwitch[$typeName] = $typeName;
			}
		}
		if ($typeName === 'media')
		{
			$this->setScriptMediaSwitch[$typeName] = $typeName;
		}
		// setup category for this view
		if ($dbSwitch && $typeName === 'category')
		{
			if (isset($this->catOtherName[$nameListCode])
				&& ArrayHelper::check(
					$this->catOtherName[$nameListCode]
				))
			{
				$otherViews = $this->catOtherName[$nameListCode]['views'];
				$otherView  = $this->catOtherName[$nameListCode]['view'];
			}
			else
			{
				$otherViews = $nameListCode;
				$otherView  = $nameSingleCode;
			}
			// get the xml extension name
			$_extension = CFactory::_('Placeholder')->update(
				GetHelper::between(
					$field['settings']->xml, 'extension="', '"'
				), CFactory::_('Placeholder')->active
			);
			// if they left out the extension for some reason
			if (!StringHelper::check($_extension))
			{
				$_extension = 'com_' . CFactory::_('Config')->component_code_name . '.'
					. $otherView;
			}
			// check the context (does our target match)
			if (strpos($_extension, '.') !== false)
			{
				$target_view = trim(explode('.', $_extension)[1]);
				// from my understanding the target extension view and the otherView must align
				// so I will here check that it does, and if not raise an error message to fix this
				if ($target_view !== $otherView)
				{
					$target_extension = trim(explode('.', $_extension)[0]);
					$correction       = $target_extension . '.' . $otherView;
					$this->app->enqueueMessage(
						JText::sprintf(
							'<hr /><h3>Category targeting view mismatch</h3>
								<p>The <a href="index.php?option=com_componentbuilder&view=fields&task=field.edit&id=%s" target="_blank" title="open field">
								category field</a> in <b>(%s) admin view</b> has a mismatching target view.
								<br />To correct the mismatch, the <b>extension</b> value <code>%s</code> in the <a href="index.php?option=com_componentbuilder&view=fields&task=field.edit&id=%s" target="_blank" title="open category field">
								field</a> must be changed to <code>%s</code>
								for <a href="https://github.com/vdm-io/Joomla-Component-Builder/issues/561" target="_blank" title="view issue on gitHub">
								best category integration with Joomla</a>.
								<br /><b>Please watch <a href="https://youtu.be/R4WQgcu6Xns" target="_blank" title="very important info on the topic">
								this tutorial</a> before proceeding!!!</b>,
								<a href="https://gist.github.com/Llewellynvdm/e053dc39ae3b2bf769c76a3e62c75b95" target="_blank" title="first watch the tutorial to understand how to use this code">code fix</a></p>',
							$field['field'], $nameSingleCode, $_extension,
							$field['field'], $correction
						), 'Error'
					);
				}
			}
			// load the category builder - TODO must move all to single view
			$this->categoryBuilder[$nameListCode] = array('code'      => $name,
			                                              'name'      => $listLangName,
			                                              'extension' => $_extension,
			                                              'filter'    => $field['filter']);
			// also set code name for title alias fix
			$this->catCodeBuilder[$nameSingleCode] = array('code'  => $name,
			                                               'views' => $otherViews,
			                                               'view'  => $otherView);
		}
		// setup checkbox for this view
		if ($dbSwitch
			&& ($typeName === 'checkbox'
				|| (ArrayHelper::check($custom)
					&& isset($custom['extends'])
					&& $custom['extends'] === 'checkboxes')))
		{
			$this->checkboxBuilder[$nameSingleCode][] = $name;
		}
		// setup checkboxes and other json items for this view
		// if we have advance field modeling and the field is not being set in the DB
		// this could mean that field is modeled manually (so we add it)
		if (($dbSwitch || $field['settings']->store == 6)
			&& (($typeName === 'subform' || $typeName === 'checkboxes'
					|| $multiple
					|| $field['settings']->store != 0)
				&& $typeName != 'tag'))
		{
			$subformJsonSwitch = true;
			switch ($field['settings']->store)
			{
				case 1:
					// JSON_STRING_ENCODE
					$this->jsonStringBuilder[$nameSingleCode][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData(
						$nameSingleCode, $name, 'json', $typeName
					);
					break;
				case 2:
					// BASE_SIXTY_FOUR
					$this->base64Builder[$nameSingleCode][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData(
						$nameSingleCode, $name, 'base64', $typeName
					);
					break;
				case 3:
					// BASIC_ENCRYPTION_LOCALKEY
					$this->basicFieldModeling[$nameSingleCode][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData(
						$nameSingleCode, $name, 'basic_encryption', $typeName
					);
					break;
				case 4:
					// WHMCS_ENCRYPTION_VDMKEY (DUE REMOVAL)
					$this->whmcsFieldModeling[$nameSingleCode][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData(
						$nameSingleCode, $name, 'whmcs_encryption', $typeName
					);
					break;
				case 5:
					// MEDIUM_ENCRYPTION_LOCALFILE
					$this->mediumFieldModeling[$nameSingleCode][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData(
						$nameSingleCode, $name, 'medium_encryption', $typeName
					);
					break;
				case 6:
					// EXPERT_MODE
					if (isset($field['settings']->model_field))
					{
						if (isset($field['settings']->initiator_save_key))
						{
							$this->expertFieldModelInitiator[$nameSingleCode]['save'][$field['settings']->initiator_save_key]
								= $field['settings']->initiator_save;
						}
						if (isset($field['settings']->initiator_get_key))
						{
							$this->expertFieldModelInitiator[$nameSingleCode]['get'][$field['settings']->initiator_get_key]
								= $field['settings']->initiator_get;
						}
						$this->expertFieldModeling[$nameSingleCode][$name]
							= $field['settings']->model_field;
						// Site settings of each field if needed
						$this->buildSiteFieldData(
							$nameSingleCode, $name, 'expert_mode', $typeName
						);
					}
					break;
				default:
					// JSON_ARRAY_ENCODE
					$this->jsonItemBuilder[$nameSingleCode][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData(
						$nameSingleCode, $name, 'json', $typeName
					);
					// no londer add the json again (already added)
					$subformJsonSwitch = false;
					break;
			}
			// just a heads-up for usergroups set to multiple
			if ($typeName === 'usergroup')
			{
				$this->buildSiteFieldData(
					$nameSingleCode, $name, 'json', $typeName
				);
			}

			// load the model list display fix
			if (($listSwitch || $listJoin)
				&& (($typeName != 'repeatable'
						&& $typeName != 'subform')
					|| $field['settings']->store == 6))
			{
				if (ArrayHelper::check($options))
				{
					$this->getItemsMethodListStringFixBuilder[$nameSingleCode][]
						= array('name'        => $name, 'type' => $typeName,
						        'translation' => true, 'custom' => $custom,
						        'method'      => $field['settings']->store);
				}
				else
				{
					$this->getItemsMethodListStringFixBuilder[$nameSingleCode][]
						= array('name'        => $name, 'type' => $typeName,
						        'translation' => false, 'custom' => $custom,
						        'method'      => $field['settings']->store);
				}
			}

			// subform house keeping (only if not advance modeling)
			if ('subform' === $typeName && $field['settings']->store != 6)
			{
				// the values must revert to array
				$this->jsonItemBuilderArray[$nameSingleCode][] = $name;
				// should the json builder still be added
				if ($subformJsonSwitch)
				{
					// and insure the if is converted to json
					$this->jsonItemBuilder[$nameSingleCode][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData(
						$nameSingleCode, $name, 'json', $typeName
					);
				}
			}
		}
		// build the data for the export & import methods $typeName === 'repeatable' ||
		if ($dbSwitch
			&& (($typeName === 'checkboxes' || $multiple
					|| $field['settings']->store != 0)
				&& !ArrayHelper::check($options)))
		{
			$this->getItemsMethodEximportStringFixBuilder[$nameSingleCode][]
				= array('name'        => $name, 'type' => $typeName,
				        'translation' => false, 'custom' => $custom,
				        'method'      => $field['settings']->store);
		}
		// check if field should be added to uikit
		$this->buildSiteFieldData($nameSingleCode, $name, 'uikit', $typeName);
		// load the selection translation fix
		if (ArrayHelper::check($options)
			&& ($listSwitch
				|| $listJoin)
			&& $typeName != 'repeatable'
			&& $typeName != 'subform')
		{
			$this->selectionTranslationFixBuilder[$nameListCode][$name]
				= $options;
		}
		// main lang filter prefix
		$lang_filter_ = CFactory::_('Config')->lang_prefix . '_FILTER_';
		// build the sort values
		if ($dbSwitch && (isset($field['sort']) && $field['sort'] == 1)
			&& ($listSwitch || $listJoin)
			&& (!$multiple && $typeName != 'checkbox'
				&& $typeName != 'checkboxes'
				&& $typeName != 'repeatable'
				&& $typeName != 'subform'))
		{
			// add the language only for new filter option
			$filter_name_asc_lang  = '';
			$filter_name_desc_lang = '';
			if (isset($this->adminFilterType[$nameListCode])
				&& $this->adminFilterType[$nameListCode] == 2)
			{
				// set the language strings for ascending
				$filter_name_asc      = $listFieldName . ' ascending';
				$filter_name_asc_lang = $lang_filter_
					. StringHelper::safe(
						$filter_name_asc, 'U'
					);
				// and to translation
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $filter_name_asc_lang, $filter_name_asc
				);
				// set the language strings for descending
				$filter_name_desc      = $listFieldName . ' descending';
				$filter_name_desc_lang = $lang_filter_
					. StringHelper::safe(
						$filter_name_desc, 'U'
					);
				// and to translation
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $filter_name_desc_lang, $filter_name_desc
				);
			}
			$this->sortBuilder[$nameListCode][] = array('type'      => $typeName,
			                                            'code'      => $name,
			                                            'lang'      => $listLangName,
			                                            'lang_asc'  => $filter_name_asc_lang,
			                                            'lang_desc' => $filter_name_desc_lang,
			                                            'custom'    => $custom,
			                                            'options'   => $options);
		}
		// build the search values
		if ($dbSwitch && isset($field['search']) && $field['search'] == 1)
		{
			$_list                                = (isset($field['list']))
				? $field['list'] : 0;
			$this->searchBuilder[$nameListCode][] = array('type'   => $typeName,
			                                              'code'   => $name,
			                                              'custom' => $custom,
			                                              'list'   => $_list);
		}
		// build the filter values
		if ($dbSwitch && (isset($field['filter']) && $field['filter'] >= 1)
			&& ($listSwitch || $listJoin)
			&& (!$multiple && $typeName != 'checkbox'
				&& $typeName != 'checkboxes'
				&& $typeName != 'repeatable'
				&& $typeName != 'subform'))
		{
			// this pains me... but to avoid collusion
			$filter_type_code     = StringHelper::safe(
				$nameListCode . 'filter' . $name
			);
			$filter_type_code     = preg_replace('/_+/', '', $filter_type_code);
			$filter_function_name = StringHelper::safe(
				$name, 'F'
			);
			// add the language only for new filter option
			$filter_name_select_lang = '';
			if (isset($this->adminFilterType[$nameListCode])
				&& $this->adminFilterType[$nameListCode] == 2)
			{
				// set the language strings for selection
				$filter_name_select      = 'Select ' . $listFieldName;
				$filter_name_select_lang = $lang_filter_
					. StringHelper::safe(
						$filter_name_select, 'U'
					);
				// and to translation
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $filter_name_select_lang, $filter_name_select
				);
			}

			// add the filter details
			$this->filterBuilder[$nameListCode][] = array(
				'id'          => (int) $field['field'],
				'type'        => $typeName,
				'multi'       => $field['filter'],
				'code'        => $name,
				'label'       => $langLabel,
				'lang'        => $listLangName,
				'lang_select' => $filter_name_select_lang,
				'database'    => $nameSingleCode,
				'function'    => $filter_function_name,
				'custom'      => $custom,
				'options'     => $options,
				'filter_type' => $filter_type_code
			);
		}

		// build the layout
		$tabName = '';
		if (isset($view['settings']->tabs)
			&& isset($view['settings']->tabs[(int) $field['tab']]))
		{
			$tabName = $view['settings']->tabs[(int) $field['tab']];
		}
		elseif ((int) $field['tab'] == 15)
		{
			// set to publishing tab
			$tabName = 'publishing';
		}
		$this->setLayoutBuilder($nameSingleCode, $tabName, $name, $field);
	}

	/**
	 * set Custom Field Type File
	 *
	 * @param   array   $data            The field complete data set
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $nameSingleCode  The single view code name
	 *
	 * @return  void
	 *
	 */
	public function setCustomFieldTypeFile($data, $nameListCode,
		$nameSingleCode
	) {
		// make sure it is not already been build or if it is prime
		if (isset($data['custom']) && isset($data['custom']['extends'])
			&& ((isset($data['custom']['prime_php'])
					&& $data['custom']['prime_php'] == 1)
				|| !isset(
					$this->fileContentDynamic['customfield_' . $data['type']]
				)
				|| !ArrayHelper::check(
					$this->fileContentDynamic['customfield_' . $data['type']]
				)))
		{
			// set J prefix
			$jprefix = 'J';
			// check if this field has a dot in field type name
			if (strpos($data['type'], '.') !== false)
			{
				// so we have name spacing in custom field type name
				$dotTypeArray = explode('.', $data['type']);
				// set the J prefix
				if (count((array) $dotTypeArray) > 1)
				{
					$jprefix = strtoupper(array_shift($dotTypeArray));
				}
				// update the type name now
				$data['type']           = implode('', $dotTypeArray);
				$data['custom']['type'] = $data['type'];
			}
			// set tab and break replacements
			$tabBreak = array(
				'\t' => Indent::_(1),
				'\n' => PHP_EOL
			);
			// set the [[[PLACEHOLDER]]] options
			$replace = array(
				Placefix::_('JPREFIX')   => $jprefix,
				Placefix::_('TABLE')                          => (isset($data['custom']['table']))
					? $data['custom']['table'] : '',
				Placefix::_('ID')                          => (isset($data['custom']['id']))
					? $data['custom']['id'] : '',
				Placefix::_('TEXT')                          => (isset($data['custom']['text']))
					? $data['custom']['text'] : '',
				Placefix::_('CODE_TEXT')                          => (isset($data['code'], $data['custom']['text']))
					? $data['code'] . '_' . $data['custom']['text'] : '',
				Placefix::_('CODE')      => (isset($data['code']))
					? $data['code'] : '',
				Placefix::_('view_type') => $nameSingleCode
					. '_' . $data['type'],
				Placefix::_('type')      => (isset($data['type']))
					? $data['type'] : '',
				Placefix::_('com_component')                          => (isset($data['custom']['component'])
					&& StringHelper::check(
						$data['custom']['component']
					)) ? StringHelper::safe(
					$data['custom']['component']
				) : 'com_' . CFactory::_('Config')->component_code_name,
				// set the generic values
				Placefix::_('component')                          => CFactory::_('Config')->component_code_name,
				Placefix::_('Component')                          => $this->fileContentStatic[Placefix::_h('Component')],
				Placefix::_('view')                          => (isset($data['custom']['view'])
					&& StringHelper::check(
						$data['custom']['view']
					)) ? StringHelper::safe(
					$data['custom']['view']
				) : $nameSingleCode,
				Placefix::_('views')                          => (isset($data['custom']['views'])
					&& StringHelper::check(
						$data['custom']['views']
					)) ? StringHelper::safe(
					$data['custom']['views']
				) : $nameListCode
			);
			// now set the ###PLACEHOLDER### options
			foreach ($replace as $replacekey => $replacevalue)
			{
				// update the key value
				$replacekey = str_replace(
					array(Placefix::b(), Placefix::d()),
					array(Placefix::h(), Placefix::h()), $replacekey
				);
				// now set the value
				$replace[$replacekey] = $replacevalue;
			}
			// load the global placeholders
			if (ArrayHelper::check($this->globalPlaceholders))
			{
				foreach (
					$this->globalPlaceholders as $globalPlaceholder =>
					$gloabalValue
				)
				{
					$replace[$globalPlaceholder] = $gloabalValue;
				}
			}
			// start loading the field type
			$this->fileContentDynamic['customfield_' . $data['type']] = array();
			// JPREFIX <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']][Placefix::_h('JPREFIX')]
				= $jprefix;
			// Type <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']][Placefix::_h('Type')]
				= StringHelper::safe(
				$data['custom']['type'], 'F'
			);
			// type <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']][Placefix::_h('type')]
				= StringHelper::safe($data['custom']['type']);
			// is this a own custom field
			if (isset($data['custom']['own_custom']))
			{
				// make sure the button option notice is set to notify the developer that the button option is not available in own custom field types
				if (isset($data['custom']['add_button'])
					&& ($data['custom']['add_button'] === 'true'
						|| 1 == $data['custom']['add_button']))
				{
					// set error
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Dynamic Button Error</h3>'), 'Error'
					);
					$this->app->enqueueMessage(
						JText::_(
							'The option to add a dynamic button is not available in <b>own custom field types</b>, you will have to custom code it.'
						), 'Error'
					);
				}
				// load another file
				$target = array('admin' => 'customfield');
				$this->buildDynamique(
					$target, 'fieldcustom', $data['custom']['type']
				);
				// get the extends name
				$JFORM_extends = StringHelper::safe(
					$data['custom']['extends']
				);
				// JFORM_TYPE_HEADER <<<DYNAMIC>>>
				$add_default_header = true;
				$this->fileContentDynamic['customfield_'
				. $data['type']][Placefix::_h('JFORM_TYPE_HEADER')]
				                    = "//" . Line::_(
						__LINE__,__CLASS__
					) . " Import the " . $JFORM_extends
					. " field type classes needed";
				// JFORM_extens <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'
				. $data['type']][Placefix::_h('JFORM_extends')]
					= $JFORM_extends;
				// JFORM_EXTENDS <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'
				. $data['type']][Placefix::_h('JFORM_EXTENDS')]
					= StringHelper::safe(
					$data['custom']['extends'], 'F'
				);
				// JFORM_TYPE_PHP <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'
				. $data['type']][Placefix::_h('JFORM_TYPE_PHP')]
					= PHP_EOL . PHP_EOL . Indent::_(1) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " A " . $data['custom']['own_custom'] . " Field";
				// load the other PHP options
				foreach (ComponentbuilderHelper::$phpFieldArray as $x)
				{
					// reset the php bucket
					$phpBucket = '';
					// only set if available
					if (isset($data['custom']['php' . $x])
						&& ArrayHelper::check(
							$data['custom']['php' . $x]
						))
					{
						foreach ($data['custom']['php' . $x] as $line => $code)
						{
							if (StringHelper::check($code))
							{
								$phpBucket .= PHP_EOL . CFactory::_('Placeholder')->update(
										$code, $tabBreak
									);
							}
						}
						// check if this is header text
						if ('HEADER' === $x)
						{
							$this->fileContentDynamic['customfield_'
							. $data['type']][Placefix::_h('JFORM_TYPE_HEADER')]
								.= PHP_EOL . CFactory::_('Placeholder')->update(
									$phpBucket, $replace
								);
							// stop default headers from loading
							$add_default_header = false;
						}
						else
						{
							// JFORM_TYPE_PHP <<<DYNAMIC>>>
							$this->fileContentDynamic['customfield_'
							. $data['type']][Placefix::_h('JFORM_TYPE_PHP')]
								.= PHP_EOL . CFactory::_('Placeholder')->update(
									$phpBucket, $replace
								);
						}
					}
				}
				// check if we should add default header
				if ($add_default_header)
				{
					$this->fileContentDynamic['customfield_'
					. $data['type']][Placefix::_h('JFORM_TYPE_HEADER')]
						.= PHP_EOL . "jimport('joomla.form.helper');";
					$this->fileContentDynamic['customfield_'
					. $data['type']][Placefix::_h('JFORM_TYPE_HEADER')]
						.= PHP_EOL . "JFormHelper::loadFieldClass('"
						. $JFORM_extends . "');";
				}
				// check the the JFormHelper::loadFieldClass(..) was set
				elseif (strpos(
						$this->fileContentDynamic['customfield_'
						. $data['type']][Placefix::_h('JFORM_TYPE_HEADER')], 'JFormHelper::loadFieldClass('
					) === false)
				{
					$this->fileContentDynamic['customfield_'
					. $data['type']][Placefix::_h('JFORM_TYPE_HEADER')]
						.= PHP_EOL . "JFormHelper::loadFieldClass('"
						. $JFORM_extends . "');";
				}
			}
			else
			{
				// first build the custom field type file
				$target = array('admin' => 'customfield');
				$this->buildDynamique(
					$target, 'field' . $data['custom']['extends'],
					$data['custom']['type']
				);
				// make sure the value is reset
				$phpCode = '';
				// now load the php script
				if (isset($data['custom']['php'])
					&& ArrayHelper::check(
						$data['custom']['php']
					))
				{
					foreach ($data['custom']['php'] as $line => $code)
					{
						if (StringHelper::check($code))
						{
							if ($line == 1)
							{
								$phpCode .= CFactory::_('Placeholder')->update(
									$code, $tabBreak
								);
							}
							else
							{
								$phpCode .= PHP_EOL . Indent::_(2)
									. CFactory::_('Placeholder')->update($code, $tabBreak);
							}
						}
					}
					// replace the placholders
					$phpCode = CFactory::_('Placeholder')->update($phpCode, $replace);
				}
				// catch empty stuff
				if (!StringHelper::check($phpCode))
				{
					$phpCode = 'return null;';
				}
				// some house cleaning for users
				if ($data['custom']['extends'] === 'user')
				{
					// make sure the value is reset
					$phpxCode = '';
					// now load the php xclude script
					if (ArrayHelper::check(
						$data['custom']['phpx']
					))
					{
						foreach ($data['custom']['phpx'] as $line => $code)
						{
							if (StringHelper::check($code))
							{
								if ($line == 1)
								{
									$phpxCode .= CFactory::_('Placeholder')->update(
										$code, $tabBreak
									);
								}
								else
								{
									$phpxCode .= PHP_EOL . Indent::_(2)
										. CFactory::_('Placeholder')->update(
											$code, $tabBreak
										);
								}
							}
						}
						// replace the placholders
						$phpxCode = CFactory::_('Placeholder')->update($phpxCode, $replace);
					}
					// catch empty stuff
					if (!StringHelper::check($phpxCode))
					{
						$phpxCode = 'return null;';
					}
					// temp holder for name
					$tempName = $data['custom']['label'] . ' Group';
					// set lang
					$groupLangName = CFactory::_('Config')->lang_prefix . '_'
						. FieldHelper::safe(
							$tempName, true
						);
					// add to lang array
					CFactory::_('Language')->set(
						CFactory::_('Config')->lang_target, $groupLangName,
						StringHelper::safe($tempName, 'W')
					);
					// build the Group Control
					$this->setGroupControl[$data['type']] = $groupLangName;
					// JFORM_GETGROUPS_PHP <<<DYNAMIC>>>
					$this->fileContentDynamic['customfield_'
					. $data['type']][Placefix::_h('JFORM_GETGROUPS_PHP')]
						= $phpCode;
					// JFORM_GETEXCLUDED_PHP <<<DYNAMIC>>>
					$this->fileContentDynamic['customfield_'
					. $data['type']][Placefix::_h('JFORM_GETEXCLUDED_PHP')]
						= $phpxCode;
				}
				else
				{
					// JFORM_GETOPTIONS_PHP <<<DYNAMIC>>>
					$this->fileContentDynamic['customfield_'
					. $data['type']][Placefix::_h('JFORM_GETOPTIONS_PHP')]
						= $phpCode;
				}
				// type <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'
				. $data['type']][Placefix::_h('ADD_BUTTON')]
					= $this->setAddButtonToListField($data['custom']);
			}
		}
		// if this field gets used in plugin or module we should track it so if needed we can copy it over
		if ((strpos($nameSingleCode, 'P|uG!n') !== false
				|| strpos(
					$nameSingleCode, 'M0dU|3'
				) !== false)
			&& isset($data['custom'])
			&& isset($data['custom']['type']))
		{
			$this->extentionCustomfields[$data['type']]
				= $data['custom']['type'];
		}
	}

	/**
	 * This is just to get the code.
	 * Don't use this to build the field
	 *
	 * @param   array  $custom  The field complete data set
	 *
	 * @return  array with the code
	 *
	 */
	public function getCustomFieldCode($custom)
	{
		// the code bucket
		$code_bucket = array(
			'JFORM_TYPE_HEADER' => '',
			'JFORM_TYPE_PHP'    => ''
		);
		// set tab and break replacements
		$tabBreak = array(
			'\t' => Indent::_(1),
			'\n' => PHP_EOL
		);
		// load the other PHP options
		foreach (ComponentbuilderHelper::$phpFieldArray as $x)
		{
			// reset the php bucket
			$phpBucket = '';
			// only set if available
			if (isset($custom['php' . $x])
				&& ArrayHelper::check(
					$custom['php' . $x]
				))
			{
				foreach ($custom['php' . $x] as $line => $code)
				{
					if (StringHelper::check($code))
					{
						$phpBucket .= PHP_EOL . CFactory::_('Placeholder')->update(
								$code, $tabBreak
							);
					}
				}
				// check if this is header text
				if ('HEADER' === $x)
				{
					$code_bucket['JFORM_TYPE_HEADER']
						.= PHP_EOL . $phpBucket;
				}
				else
				{
					// JFORM_TYPE_PHP <<<DYNAMIC>>>
					$code_bucket['JFORM_TYPE_PHP']
						.= PHP_EOL . $phpBucket;
				}
			}
		}

		return $code_bucket;
	}

	/**
	 * set the Filter Field set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 */
	public function setFieldFilterSet(&$nameSingleCode, &$nameListCode)
	{
		// check if this is the above/new filter option
		if (isset($this->adminFilterType[$nameListCode])
			&& $this->adminFilterType[$nameListCode] == 2)
		{
			// we first create the file
			$target = array('admin' => 'filter_' . $nameListCode);
			$this->buildDynamique(
				$target, 'filter'
			);
			// the search language string
			$lang_search = CFactory::_('Config')->lang_prefix . '_FILTER_SEARCH';
			// and to translation
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $lang_search, 'Search'
				. StringHelper::safe($nameListCode, 'w')
			);
			// the search description language string
			$lang_search_desc = CFactory::_('Config')->lang_prefix . '_FILTER_SEARCH_'
				. strtoupper($nameListCode);
			// and to translation
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $lang_search_desc, 'Search the '
				. StringHelper::safe($nameSingleCode, 'w')
				. ' items. Prefix with ID: to search for an item by ID.'
			);
			// now build the XML
			$field_filter_sets   = array();
			$field_filter_sets[] = Indent::_(1) . '<fields name="filter">';
			// we first add the search
			$field_filter_sets[] = Indent::_(2) . '<field';
			$field_filter_sets[] = Indent::_(3) . 'type="text"';
			$field_filter_sets[] = Indent::_(3) . 'name="search"';
			$field_filter_sets[] = Indent::_(3) . 'inputmode="search"';
			$field_filter_sets[] = Indent::_(3)
				. 'label="' . $lang_search . '"';
			$field_filter_sets[] = Indent::_(3)
				. 'description="' . $lang_search_desc . '"';
			$field_filter_sets[] = Indent::_(3) . 'hint="JSEARCH_FILTER"';
			$field_filter_sets[] = Indent::_(2) . '/>';
			// add the published filter if published is not set
			if (!isset($this->fieldsNames[$nameSingleCode]['published']))
			{
				// the published language string
				$lang_published = CFactory::_('Config')->lang_prefix . '_FILTER_PUBLISHED';
				// and to translation
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lang_published, 'Status'
				);
				// the published description language string
				$lang_published_desc = CFactory::_('Config')->lang_prefix . '_FILTER_PUBLISHED_'
					. strtoupper($nameListCode);
				// and to translation
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lang_published_desc, 'Status options for '
					. StringHelper::safe($nameListCode, 'w')
				);
				$field_filter_sets[] = Indent::_(2) . '<field';
				$field_filter_sets[] = Indent::_(3) . 'type="status"';
				$field_filter_sets[] = Indent::_(3) . 'name="published"';
				$field_filter_sets[] = Indent::_(3)
					. 'label="' . $lang_published . '"';
				$field_filter_sets[] = Indent::_(3)
					. 'description="' . $lang_published_desc . '"';
				$field_filter_sets[] = Indent::_(3)
					. 'onchange="this.form.submit();"';
				$field_filter_sets[] = Indent::_(2) . '>';
				$field_filter_sets[] = Indent::_(3)
					. '<option value="">JOPTION_SELECT_PUBLISHED</option>';
				$field_filter_sets[] = Indent::_(2) . '</field>';
			}
			// add the category if found
			if (isset($this->categoryBuilder[$nameListCode])
				&& ArrayHelper::check(
					$this->categoryBuilder[$nameListCode]
				)
				&& isset($this->categoryBuilder[$nameListCode]['extension'])
				&& isset($this->categoryBuilder[$nameListCode]['filter'])
				&& $this->categoryBuilder[$nameListCode]['filter'] >= 1)
			{
				$field_filter_sets[] = Indent::_(2) . '<field';
				$field_filter_sets[] = Indent::_(3) . 'type="category"';
				$field_filter_sets[] = Indent::_(3) . 'name="category_id"';
				$field_filter_sets[] = Indent::_(3)
					. 'label="' . $this->categoryBuilder[$nameListCode]['name']
					. '"';
				$field_filter_sets[] = Indent::_(3)
					. 'description="JOPTION_FILTER_CATEGORY_DESC"';
				$field_filter_sets[] = Indent::_(3) . 'multiple="true"';
				$field_filter_sets[] = Indent::_(3)
					. 'class="multipleCategories"';
				$field_filter_sets[] = Indent::_(3) . 'extension="'
					. $this->categoryBuilder[$nameListCode]['extension'] . '"';
				$field_filter_sets[] = Indent::_(3)
					. 'onchange="this.form.submit();"';
				// TODO NOT SURE IF THIS SHOULD BE STATIC
				$field_filter_sets[] = Indent::_(3) . 'published="0,1,2"';
				$field_filter_sets[] = Indent::_(2) . '/>';
			}
			// add the access filter if this view has access
			// and if access manually is not set
			if (isset($this->accessBuilder[$nameSingleCode])
				&& StringHelper::check(
					$this->accessBuilder[$nameSingleCode]
				)
				&& !isset($this->fieldsNames[$nameSingleCode]['access']))
			{
				$field_filter_sets[] = Indent::_(2) . '<field';
				$field_filter_sets[] = Indent::_(3) . 'type="accesslevel"';
				$field_filter_sets[] = Indent::_(3) . 'name="access"';
				$field_filter_sets[] = Indent::_(3)
					. 'label="JFIELD_ACCESS_LABEL"';
				$field_filter_sets[] = Indent::_(3)
					. 'description="JFIELD_ACCESS_DESC"';
				$field_filter_sets[] = Indent::_(3) . 'multiple="true"';
				$field_filter_sets[] = Indent::_(3)
					. 'class="multipleAccessLevels"';
				$field_filter_sets[] = Indent::_(3)
					. 'onchange="this.form.submit();"';
				$field_filter_sets[] = Indent::_(2) . '/>';
			}
			// now add the dynamic fields
			if (isset($this->filterBuilder[$nameListCode])
				&& ArrayHelper::check(
					$this->filterBuilder[$nameListCode]
				))
			{
				foreach ($this->filterBuilder[$nameListCode] as $r => &$filter)
				{
					if ($filter['type'] != 'category')
					{
						$field_filter_sets[] = Indent::_(2) . '<field';
						// if this is a custom field
						if (ArrayHelper::check(
							$filter['custom']
						))
						{
							// we use the field type from the custom field
							$field_filter_sets[] = Indent::_(3) . 'type="'
								. $filter['type'] . '"';
							// set css classname of this field
							$filter['class'] = ucfirst($filter['type']);
						}
						else
						{
							// we use the filter field type that was build
							$field_filter_sets[] = Indent::_(3) . 'type="'
								. $filter['filter_type'] . '"';
							// set css classname of this field
							$filter['class'] = ucfirst($filter['filter_type']);
						}
						$field_filter_sets[] = Indent::_(3) . 'name="'
							. $filter['code'] . '"';
						$field_filter_sets[] = Indent::_(3) . 'label="'
							. $filter['label'] . '"';
						// if this is a multi field
						if ($filter['multi'] == 2)
						{
							$field_filter_sets[] = Indent::_(3)
								. 'class="multiple'
								. $filter['class'] . '"';
							$field_filter_sets[] = Indent::_(3)
								. 'multiple="true"';
						}
						else
						{
							$field_filter_sets[] = Indent::_(3)
								. 'multiple="false"';
						}
						$field_filter_sets[] = Indent::_(3)
							. 'onchange="this.form.submit();"';
						$field_filter_sets[] = Indent::_(2) . '/>';
					}
				}
			}
			$field_filter_sets[] = Indent::_(2)
				. '<input type="hidden" name="form_submited" value="1"/>';
			$field_filter_sets[] = Indent::_(1) . '</fields>';

			// now update the file
			return implode(PHP_EOL, $field_filter_sets);
		}

		return '';
	}

	/**
	 * set the Filter List set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 */
	public function setFieldFilterListSet(&$nameSingleCode, &$nameListCode)
	{
		// check if this is the above/new filter option
		if (isset($this->adminFilterType[$nameListCode])
			&& $this->adminFilterType[$nameListCode] == 2)
		{
			// keep track of all fields already added
			$donelist = array('ordering' => true, 'id' => true);
			// now build the XML
			$list_sets   = array();
			$list_sets[] = Indent::_(1) . '<fields name="list">';
			$list_sets[] = Indent::_(2) . '<field';
			$list_sets[] = Indent::_(3) . 'name="fullordering"';
			$list_sets[] = Indent::_(3) . 'type="list"';
			$list_sets[] = Indent::_(3)
				. 'label="COM_CONTENT_LIST_FULL_ORDERING"';
			$list_sets[] = Indent::_(3)
				. 'description="COM_CONTENT_LIST_FULL_ORDERING_DESC"';
			$list_sets[] = Indent::_(3) . 'onchange="this.form.submit();"';
			// add dynamic ordering (Admin view)
			$default_ordering = $this->getListViewDefaultOrdering(
				$nameListCode
			);
			// set the default ordering
			$list_sets[] = Indent::_(3) . 'default="'
				. $default_ordering['name'] . ' '
				. $default_ordering['direction'] . '"';
			$list_sets[] = Indent::_(3) . 'validate="options"';
			$list_sets[] = Indent::_(2) . '>';
			$list_sets[] = Indent::_(3)
				. '<option value="">JGLOBAL_SORT_BY</option>';
			$list_sets[] = Indent::_(3)
				. '<option value="a.ordering ASC">JGRID_HEADING_ORDERING_ASC</option>';
			$list_sets[] = Indent::_(3)
				. '<option value="a.ordering DESC">JGRID_HEADING_ORDERING_DESC</option>';
			// add the published filter if published is not set
			if (!isset($this->fieldsNames[$nameSingleCode]['published']))
			{
				// add to done list
				$donelist['published'] = true;
				// add to xml :)
				$list_sets[] = Indent::_(3)
					. '<option value="a.published ASC">JSTATUS_ASC</option>';
				$list_sets[] = Indent::_(3)
					. '<option value="a.published DESC">JSTATUS_DESC</option>';
			}

			// add the rest of the set filters
			if (isset($this->sortBuilder[$nameListCode])
				&& ArrayHelper::check(
					$this->sortBuilder[$nameListCode]
				))
			{
				foreach ($this->sortBuilder[$nameListCode] as $filter)
				{
					if (!isset($donelist[$filter['code']]))
					{
						if ($filter['type'] === 'category')
						{
							$list_sets[] = Indent::_(3)
								. '<option value="category_title ASC">'
								. $filter['lang_asc'] . '</option>';
							$list_sets[] = Indent::_(3)
								. '<option value="category_title DESC">'
								. $filter['lang_desc'] . '</option>';
						}
						elseif (ArrayHelper::check(
							$filter['custom']
						))
						{
							$list_sets[] = Indent::_(3) . '<option value="'
								. $filter['custom']['db'] . '.'
								. $filter['custom']['text'] . ' ASC">'
								. $filter['lang_asc'] . '</option>';
							$list_sets[] = Indent::_(3) . '<option value="'
								. $filter['custom']['db'] . '.'
								. $filter['custom']['text'] . ' DESC">'
								. $filter['lang_desc'] . '</option>';
						}
						else
						{
							$list_sets[] = Indent::_(3) . '<option value="a.'
								. $filter['code'] . ' ASC">'
								. $filter['lang_asc'] . '</option>';
							$list_sets[] = Indent::_(3) . '<option value="a.'
								. $filter['code'] . ' DESC">'
								. $filter['lang_desc'] . '</option>';
						}
						// do not add again
						$donelist[$filter['code']] = true;
					}
				}
			}

			$list_sets[] = Indent::_(3)
				. '<option value="a.id ASC">JGRID_HEADING_ID_ASC</option>';
			$list_sets[] = Indent::_(3)
				. '<option value="a.id DESC">JGRID_HEADING_ID_DESC</option>';
			$list_sets[] = Indent::_(2) . '</field>' . PHP_EOL;

			$list_sets[] = Indent::_(2) . '<field';
			$list_sets[] = Indent::_(3) . 'name="limit"';
			$list_sets[] = Indent::_(3) . 'type="limitbox"';
			$list_sets[] = Indent::_(3) . 'label="COM_CONTENT_LIST_LIMIT"';
			$list_sets[] = Indent::_(3)
				. 'description="COM_CONTENT_LIST_LIMIT_DESC"';
			$list_sets[] = Indent::_(3) . 'class="input-mini"';
			$list_sets[] = Indent::_(3) . 'default="25"';
			$list_sets[] = Indent::_(3) . 'onchange="this.form.submit();"';
			$list_sets[] = Indent::_(2) . '/>';
			$list_sets[] = Indent::_(1) . '</fields>';

			return implode(PHP_EOL, $list_sets);
		}

		return '';
	}

	/**
	 * set Custom Field for Filter
	 *
	 * @param   string  $getOptions  The get options php string/code
	 * @param   array   $filter      The filter details
	 *
	 * @return  void
	 *
	 */
	public function setFilterFieldFile($getOptions, $filter)
	{
		// make sure it is not already been build
		if (!isset(
				$this->fileContentDynamic['customfilterfield_'
				. $filter['filter_type']]
			)
			|| !ArrayHelper::check(
				$this->fileContentDynamic['customfilterfield_'
				. $filter['filter_type']]
			)
		)
		{
			// start loading the field type
			$this->fileContentDynamic['customfilterfield_'
			. $filter['filter_type']]
				= array();
			// JPREFIX <<DYNAMIC>>>
			$this->fileContentDynamic['customfilterfield_'
			. $filter['filter_type']][Placefix::_h('JPREFIX')]
				= 'J';
			// Type <<<DYNAMIC>>>
			$this->fileContentDynamic['customfilterfield_'
			. $filter['filter_type']][Placefix::_h('Type')]
				= StringHelper::safe(
				$filter['filter_type'], 'F'
			);
			// type <<<DYNAMIC>>>
			$this->fileContentDynamic['customfilterfield_'
			. $filter['filter_type']][Placefix::_h('type')]
				= StringHelper::safe($filter['filter_type']);
			// JFORM_GETOPTIONS_PHP <<<DYNAMIC>>>
			$this->fileContentDynamic['customfilterfield_'
			. $filter['filter_type']][Placefix::_h('JFORM_GETOPTIONS_PHP')]
				= $getOptions;
			// ADD_BUTTON <<<DYNAMIC>>>
			$this->fileContentDynamic['customfilterfield_'
			. $filter['filter_type']][Placefix::_h('ADD_BUTTON')]
				= '';
			// now build the custom filter field type file
			$target = array('admin' => 'customfilterfield');
			$this->buildDynamique(
				$target, 'fieldlist',
				$filter['filter_type']
			);
		}
	}

	/**
	 * set Add Button To List Field (getInput tweak)
	 *
	 * @param   array  $fieldData  The field custom data
	 *
	 * @return  string of getInput class on success empty string otherwise
	 *
	 */
	protected function setAddButtonToListField($fieldData)
	{
		// make sure hte view values are set
		if (isset($fieldData['add_button'])
			&& ($fieldData['add_button'] === 'true'
				|| 1 == $fieldData['add_button'])
			&& isset($fieldData['view'])
			&& isset($fieldData['views'])
			&& StringHelper::check($fieldData['view'])
			&& StringHelper::check($fieldData['views']))
		{
			// set local component
			$local_component = "com_" . CFactory::_('Config')->component_code_name;
			// check that the component value is set
			if (!isset($fieldData['component'])
				|| !StringHelper::check(
					$fieldData['component']
				))
			{
				$fieldData['component'] = $local_component;
			}
			// check that the component has the com_ value in it
			if (strpos($fieldData['component'], 'com_') === false
				|| strpos(
					$fieldData['component'], '='
				) !== false)
			{
				$fieldData['component'] = "com_" . $fieldData['component'];
			}
			// make sure the component is update if # # # or [ [ [ component placeholder is used
			if (strpos($fieldData['component'], Placefix::h()) !== false
				|| strpos(
					$fieldData['component'], Placefix::b()
				) !== false) // should not be needed... but
			{
				$fieldData['component'] = CFactory::_('Placeholder')->update(
					$fieldData['component'], CFactory::_('Placeholder')->active
				);
			}
			// get core permissions
			$coreLoad = false;
			// add ref tags
			$refLoad = true;
			// fall back on the field component
			$component = $fieldData['component'];
			// check if we should add ref tags (since it only works well on local views)
			if ($local_component !== $component)
			{
				// do not add ref tags
				$refLoad = false;
			}
			// get core permisssions
			if (isset($this->permissionCore[$fieldData['view']]))
			{
				// get the core permission naming array
				$core = $this->permissionCore[$fieldData['view']];
				// set switch to activate easy update
				$coreLoad = true;
			}
			// start building the add buttons/s
			$addButton   = array();
			$addButton[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$addButton[] = Indent::_(1) . " * Override to add new button";
			$addButton[] = Indent::_(1) . " *";
			$addButton[] = Indent::_(1)
				. " * @return  string  The field input markup.";
			$addButton[] = Indent::_(1) . " *";
			$addButton[] = Indent::_(1) . " * @since   3.2";
			$addButton[] = Indent::_(1) . " */";
			$addButton[] = Indent::_(1) . "protected function getInput()";
			$addButton[] = Indent::_(1) . "{";
			$addButton[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " see if we should add buttons";
			$addButton[] = Indent::_(2)
				. "\$set_button = \$this->getAttribute('button');";
			$addButton[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get html";
			$addButton[] = Indent::_(2) . "\$html = parent::getInput();";
			$addButton[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " if true set button";
			$addButton[] = Indent::_(2) . "if (\$set_button === 'true')";
			$addButton[] = Indent::_(2) . "{";
			$addButton[] = Indent::_(3) . "\$button = array();";
			$addButton[] = Indent::_(3) . "\$script = array();";
			$addButton[] = Indent::_(3)
				. "\$button_code_name = \$this->getAttribute('name');";
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " get the input from url";
			$addButton[] = Indent::_(3) . "\$app = JFactory::getApplication();";
			$addButton[] = Indent::_(3) . "\$jinput = \$app->input;";
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " get the view name & id";
			$addButton[] = Indent::_(3)
				. "\$values = \$jinput->getArray(array(";
			$addButton[] = Indent::_(4) . "'id' => 'int',";
			$addButton[] = Indent::_(4) . "'view' => 'word'";
			$addButton[] = Indent::_(3) . "));";
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " check if new item";
			$addButton[] = Indent::_(3) . "\$ref = '';";
			$addButton[] = Indent::_(3) . "\$refJ = '';";
			if ($refLoad)
			{
				$addButton[] = Indent::_(3)
					. "if (!is_null(\$values['id']) && strlen(\$values['view']))";
				$addButton[] = Indent::_(3) . "{";
				$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " only load referral if not new item.";
				$addButton[] = Indent::_(4)
					. "\$ref = '&amp;ref=' . \$values['view'] . '&amp;refid=' . \$values['id'];";
				$addButton[] = Indent::_(4)
					. "\$refJ = '&ref=' . \$values['view'] . '&refid=' . \$values['id'];";
				$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " get the return value.";
				$addButton[] = Indent::_(4)
					. "\$_uri = (string) JUri::getInstance();";
				$addButton[] = Indent::_(4)
					. "\$_return = urlencode(base64_encode(\$_uri));";
				$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " load return value.";
				$addButton[] = Indent::_(4)
					. "\$ref .= '&amp;return=' . \$_return;";
				$addButton[] = Indent::_(4)
					. "\$refJ .= '&return=' . \$_return;";
				$addButton[] = Indent::_(3) . "}";
			}
			else
			{
				$addButton[] = Indent::_(3)
					. "if (!is_null(\$values['id']) && strlen(\$values['view']))";
				$addButton[] = Indent::_(3) . "{";
				$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " only load field details if not new item.";
				$addButton[] = Indent::_(4)
					. "\$ref = '&amp;field=' . \$values['view'] . '&amp;field_id=' . \$values['id'];";
				$addButton[] = Indent::_(4)
					. "\$refJ = '&field=' . \$values['view'] . '&field_id=' . \$values['id'];";
				$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " get the return value.";
				$addButton[] = Indent::_(4)
					. "\$_uri = (string) JUri::getInstance();";
				$addButton[] = Indent::_(4)
					. "\$_return = urlencode(base64_encode(\$_uri));";
				$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " load return value.";
				$addButton[] = Indent::_(4)
					. "\$ref = '&amp;return=' . \$_return;";
				$addButton[] = Indent::_(4)
					. "\$refJ = '&return=' . \$_return;";
				$addButton[] = Indent::_(3) . "}";
			}
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " get button label";
			$addButton[] = Indent::_(3)
				. "\$button_label = trim(\$button_code_name);";
			$addButton[] = Indent::_(3)
				. "\$button_label = preg_replace('/_+/', ' ', \$button_label);";
			$addButton[] = Indent::_(3)
				. "\$button_label = preg_replace('/\s+/', ' ', \$button_label);";
			$addButton[] = Indent::_(3)
				. "\$button_label = preg_replace(\"/[^A-Za-z ]/\", '', \$button_label);";
			$addButton[] = Indent::_(3)
				. "\$button_label = ucfirst(strtolower(\$button_label));";
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " get user object";
			$addButton[] = Indent::_(3) . "\$user = JFactory::getUser();";
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " only add if user allowed to create " . $fieldData['view'];
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create'])
				&& isset($this->permissionBuilder['global'][$core['core.create']])
				&& ArrayHelper::check(
					$this->permissionBuilder['global'][$core['core.create']]
				)
				&& in_array(
					$fieldData['view'],
					$this->permissionBuilder['global'][$core['core.create']]
				))
			{
				$addButton[] = Indent::_(3) . "if (\$user->authorise('"
					. $core['core.create'] . "', '" . $component
					. "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			else
			{
				$addButton[] = Indent::_(3)
					. "if (\$user->authorise('core.create', '" . $component
					. "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			$addButton[] = Indent::_(3) . "{";
			$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " build Create button";
			$addButton[] = Indent::_(4)
				. "\$button[] = '<a id=\"'.\$button_code_name.'Create\" class=\"btn btn-small btn-success hasTooltip\" title=\"'.JText:"
				. ":sprintf('" . CFactory::_('Config')->lang_prefix
				. "_CREATE_NEW_S', \$button_label).'\" style=\"border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;\"";
			$addButton[] = Indent::_(5) . "href=\"index.php?option="
				. $fieldData['component'] . "&amp;view=" . $fieldData['view']
				. "&amp;layout=edit'.\$ref.'\" >";
			$addButton[] = Indent::_(5)
				. "<span class=\"icon-new icon-white\"></span></a>';";
			$addButton[] = Indent::_(3) . "}";
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " only add if user allowed to edit " . $fieldData['view'];
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit'])
				&& isset($this->permissionBuilder['global'][$core['core.edit']])
				&& ArrayHelper::check(
					$this->permissionBuilder['global'][$core['core.edit']]
				)
				&& in_array(
					$fieldData['view'],
					$this->permissionBuilder['global'][$core['core.edit']]
				))
			{
				$addButton[] = Indent::_(3) . "if (\$user->authorise('"
					. $core['core.edit'] . "', '" . $component
					. "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			else
			{
				$addButton[] = Indent::_(3)
					. "if (\$user->authorise('core.edit', '" . $component
					. "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			$addButton[] = Indent::_(3) . "{";
			$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " build edit button";
			$addButton[] = Indent::_(4)
				. "\$button[] = '<a id=\"'.\$button_code_name.'Edit\" class=\"btn btn-small hasTooltip\" title=\"'.JText:"
				. ":sprintf('" . CFactory::_('Config')->lang_prefix
				. "_EDIT_S', \$button_label).'\" style=\"display: none; padding: 4px 4px 4px 7px;\" href=\"#\" >";
			$addButton[] = Indent::_(5)
				. "<span class=\"icon-edit\"></span></a>';";
			$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " build script";
			$addButton[] = Indent::_(4) . "\$script[] = \"";
			$addButton[] = Indent::_(5) . "jQuery(document).ready(function() {";
			$addButton[] = Indent::_(6)
				. "jQuery('#adminForm').on('change', '#jform_\".\$button_code_name.\"',function (e) {";
			$addButton[] = Indent::_(7) . "e.preventDefault();";
			$addButton[] = Indent::_(7)
				. "var \".\$button_code_name.\"Value = jQuery('#jform_\".\$button_code_name.\"').val();";
			$addButton[] = Indent::_(7)
				. "\".\$button_code_name.\"Button(\".\$button_code_name.\"Value);";
			$addButton[] = Indent::_(6) . "});";
			$addButton[] = Indent::_(6)
				. "var \".\$button_code_name.\"Value = jQuery('#jform_\".\$button_code_name.\"').val();";
			$addButton[] = Indent::_(6)
				. "\".\$button_code_name.\"Button(\".\$button_code_name.\"Value);";
			$addButton[] = Indent::_(5) . "});";
			$addButton[] = Indent::_(5)
				. "function \".\$button_code_name.\"Button(value) {";
			$addButton[] = Indent::_(6)
				. "if (value > 0) {"; // TODO not ideal since value may not be an (int)
			$addButton[] = Indent::_(7) . "// hide the create button";
			$addButton[] = Indent::_(7)
				. "jQuery('#\".\$button_code_name.\"Create').hide();";
			$addButton[] = Indent::_(7) . "// show edit button";
			$addButton[] = Indent::_(7)
				. "jQuery('#\".\$button_code_name.\"Edit').show();";
			$addButton[] = Indent::_(7) . "var url = 'index.php?option="
				. $fieldData['component'] . "&view=" . $fieldData['views']
				. "&task=" . $fieldData['view']
				. ".edit&id='+value+'\".\$refJ.\"';"; // TODO this value may not be the ID
			$addButton[] = Indent::_(7)
				. "jQuery('#\".\$button_code_name.\"Edit').attr('href', url);";
			$addButton[] = Indent::_(6) . "} else {";
			$addButton[] = Indent::_(7) . "// show the create button";
			$addButton[] = Indent::_(7)
				. "jQuery('#\".\$button_code_name.\"Create').show();";
			$addButton[] = Indent::_(7) . "// hide edit button";
			$addButton[] = Indent::_(7)
				. "jQuery('#\".\$button_code_name.\"Edit').hide();";
			$addButton[] = Indent::_(6) . "}";
			$addButton[] = Indent::_(5) . "}\";";
			$addButton[] = Indent::_(3) . "}";
			$addButton[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " check if button was created for " . $fieldData['view']
				. " field.";
			$addButton[] = Indent::_(3)
				. "if (is_array(\$button) && count(\$button) > 0)";
			$addButton[] = Indent::_(3) . "{";
			$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Load the needed script.";
			$addButton[] = Indent::_(4)
				. "\$document = JFactory::getDocument();";
			$addButton[] = Indent::_(4)
				. "\$document->addScriptDeclaration(implode(' ',\$script));";
			$addButton[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " return the button attached to input field.";
			$addButton[] = Indent::_(4)
				. "return '<div class=\"input-append\">' .\$html . implode('',\$button).'</div>';";
			$addButton[] = Indent::_(3) . "}";
			$addButton[] = Indent::_(2) . "}";
			$addButton[] = Indent::_(2) . "return \$html;";
			$addButton[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $addButton);
		}

		return '';
	}

	/**
	 * xmlPrettyPrint
	 *
	 * @param   SimpleXMLElement  $xml       The XML element containing a node to be output
	 * @param   string            $nodename  node name of the input xml element to print out.  this is done to omit the <?xml... tag
	 *
	 * @return  string XML output
	 *
	 */
	public function xmlPrettyPrint($xml, $nodename)
	{
		$dom               = dom_import_simplexml($xml)->ownerDocument;
		$dom->formatOutput = true;
		$xmlString         = $dom->saveXML(
			$dom->getElementsByTagName($nodename)->item(0)
		);
		// make sure Tidy is enabled
		if (CFactory::_('Config')->get('tidy', false))
		{
			$tidy = new Tidy();
			$tidy->parseString(
				$xmlString, array('indent'            => true,
				                  'indent-spaces'     => 8, 'input-xml' => true,
				                  'output-xml'        => true,
				                  'indent-attributes' => true,
				                  'wrap-attributes'   => true, 'wrap' => false)
			);
			$tidy->cleanRepair();

			return $this->xmlIndent((string) $tidy, ' ', 8, true, false);
		}
		// set tidy waring atleast once
		elseif (!$this->setTidyWarning)
		{
			// set the warning only once
			$this->setTidyWarning = true;
			// now set the warning
			$this->app->enqueueMessage(
				JText::_('<hr /><h3>Tidy Error</h3>'), 'Error'
			);
			$this->app->enqueueMessage(
				JText::_(
					'You must enable the <b>Tidy</b> extension in your php.ini file so we can tidy up your xml! If you need help please <a href="https://github.com/vdm-io/Joomla-Component-Builder/issues/197#issuecomment-351181754" target="_blank">start here</a>!'
				), 'Error'
			);
		}

		return $xmlString;
	}

	/**
	 * xmlIndent
	 *
	 * @param   string   $string     The XML input
	 * @param   string   $char       Character or characters to use as the repeated indent
	 * @param   integer  $depth      number of times to repeat the indent character
	 * @param   boolean  $skipfirst  Skip the first line of the input.
	 * @param   boolean  $skiplast   Skip the last line of the input;
	 *
	 * @return  string XML output
	 *
	 */
	public function xmlIndent($string, $char = ' ', $depth = 0,
		$skipfirst = false, $skiplast = false
	) {
		$output = array();
		$lines  = explode("\n", $string);
		$first  = true;
		$last   = count($lines) - 1;
		foreach ($lines as $i => $line)
		{
			$output[] = (($first && $skipfirst) || $i === $last && $skiplast)
				? $line : str_repeat($char, $depth) . $line;
			$first    = false;
		}

		return implode("\n", $output);
	}

}
