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
	 * Extention Custom Fields
	 * 
	 * @var    array
	 */
	public $extentionCustomfields = array();

	/**
	 * Set the line number in comments
	 * 
	 * @param   int   $nr  The line number
	 * 
	 * @return  void
	 * 
	 */
	private function setLine($nr)
	{
		if ($this->debugLinenr)
		{
			return ' [Fields ' . $nr . ']';
		}
		return '';
	}

	/**
	 * set the Field set of a view
	 * 
	 * @param   array    $view              The view data
	 * @param   string   $component         The component name
	 * @param   string   $view_name_single  The single view name
	 * @param   string   $view_name_list     The list view name
	 *
	 * @return  string The fields set in xml
	 * 
	 */
	public function setFieldSet($view, $component, $view_name_single, $view_name_list)
	{
		// setup the fieldset of this view
		if (isset($view['settings']->fields) && ComponentbuilderHelper::checkArray($view['settings']->fields))
		{
			// add metadata to the view
			if (isset($view['metadata']) && $view['metadata'])
			{
				$this->metadataBuilder[$view_name_single] = $view_name_single;
			}
			// add access to the view
			if (isset($view['access']) && $view['access'])
			{
				$this->accessBuilder[$view_name_single] = $view_name_single;
			}
			// main lang prefix
			$langView = $this->langPrefix . '_' . $this->placeholders[$this->hhh . 'VIEW' . $this->hhh];
			$langViews = $this->langPrefix . '_' . $this->placeholders[$this->hhh . 'VIEWS' . $this->hhh];
			// set default lang
			$this->setLangContent($this->lang, $langView, $view['settings']->name_single);
			$this->setLangContent($this->lang, $langViews, $view['settings']->name_list);
			// set global item strings
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_ARCHIVED', "%s " . $view['settings']->name_list . " archived.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_ARCHIVED_1', "%s " . $view['settings']->name_single . " archived.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_CHECKED_IN_0', "No " . $view['settings']->name_single . " successfully checked in.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_CHECKED_IN_1', "%d " . $view['settings']->name_single . " successfully checked in.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_CHECKED_IN_MORE', "%d " . $view['settings']->name_list . " successfully checked in.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_DELETED', "%s " . $view['settings']->name_list . " deleted.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_DELETED_1', "%s " . $view['settings']->name_single . " deleted.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_FEATURED', "%s " . $view['settings']->name_list . " featured.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_FEATURED_1', "%s " . $view['settings']->name_single . " featured.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_PUBLISHED', "%s " . $view['settings']->name_list . " published.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_PUBLISHED_1', "%s " . $view['settings']->name_single . " published.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_TRASHED', "%s " . $view['settings']->name_list . " trashed.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_TRASHED_1', "%s " . $view['settings']->name_single . " trashed.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_UNFEATURED', "%s " . $view['settings']->name_list . " unfeatured.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_UNFEATURED_1', "%s " . $view['settings']->name_single . " unfeatured.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_UNPUBLISHED', "%s " . $view['settings']->name_list . " unpublished.");
			$this->setLangContent($this->lang, $langViews . '_N_ITEMS_UNPUBLISHED_1', "%s " . $view['settings']->name_single . " unpublished.");
			$this->setLangContent($this->lang, $langViews . '_BATCH_OPTIONS', "Batch process the selected " . $view['settings']->name_list);
			$this->setLangContent($this->lang, $langViews . '_BATCH_TIP', "All changes will be applied to all selected " . $view['settings']->name_list);
			// set some basic defaults
			$this->setLangContent($this->lang, $langView . '_ERROR_UNIQUE_ALIAS', "Another " . $view['settings']->name_single . " has the same alias.");
			$this->setLangContent($this->lang, $langView . '_CREATED_DATE_LABEL', "Created Date");
			$this->setLangContent($this->lang, $langView . '_CREATED_DATE_DESC', "The date this " . $view['settings']->name_single . " was created.");
			$this->setLangContent($this->lang, $langView . '_MODIFIED_DATE_LABEL', "Modified Date");
			$this->setLangContent($this->lang, $langView . '_MODIFIED_DATE_DESC', "The date this " . $view['settings']->name_single . " was modified.");
			$this->setLangContent($this->lang, $langView . '_CREATED_BY_LABEL', "Created By");
			$this->setLangContent($this->lang, $langView . '_CREATED_BY_DESC', "The user that created this " . $view['settings']->name_single . ".");
			$this->setLangContent($this->lang, $langView . '_MODIFIED_BY_LABEL', "Modified By");
			$this->setLangContent($this->lang, $langView . '_MODIFIED_BY_DESC', "The last user that modified this " . $view['settings']->name_single . ".");
			$this->setLangContent($this->lang, $langView . '_ORDERING_LABEL', "Ordering");
			$this->setLangContent($this->lang, $langView . '_VERSION_LABEL', "Version");
			$this->setLangContent($this->lang, $langView . '_VERSION_DESC', "A count of the number of times this " . $view['settings']->name_single . " has been revised.");
			$this->setLangContent($this->lang, $langView . '_SAVE_WARNING', "Alias already existed so a number was added at the end. You can re-edit the " . $view['settings']->name_single . " to customise the alias.");
			// check what type of field builder to use
			if ($this->fieldBuilderType == 1)
			{
				// build field set using string manipulation
				return $this->stringFieldSet($view, $component, $view_name_single, $view_name_list, $langView, $langViews);
			}
			else
			{
				// build field set with simpleXMLElement class
				return $this->simpleXMLFieldSet($view, $component, $view_name_single, $view_name_list, $langView, $langViews);
			}
		}
		return '';
	}

	/**
	 * build field set using string manipulation
	 *
	 * @param   array    $view             The view data
	 * @param   string   $component        The component name
	 * @param   string   $view_name_single The single view name
	 * @param   string   $view_name_list   The list view name
	 * @param   string   $langView         The language string of the view
	 * @param   string   $langViews        The language string of the views
	 *
	 * @return  string The fields set in xml
	 *
	 */
	protected function stringFieldSet($view, $component, $view_name_single, $view_name_list, $langView, $langViews)
	{
		// set the read only
		$readOnly = false;
		if ($view['settings']->type == 2)
		{
			$readOnly = $this->_t(3) . 'readonly="true"' . PHP_EOL . $this->_t(3) . 'disabled="true"';
		}
		// start adding dynamc fields
		$dynamicFields = '';
		// set the custom table key
		$dbkey = 'g';
		// Trigger Event: jcb_ce_onBeforeBuildFields
		$this->triggerEvent('jcb_ce_onBeforeBuildFields', array(&$this->componentContext, &$dynamicFields, &$readOnly, &$dbkey, &$view, &$component, &$view_name_single, &$view_name_list, &$this->placeholders, &$langView, &$langViews));
		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamicFields .= $this->setDynamicField($field, $view, $view['settings']->type, $langView, $view_name_single, $view_name_list, $this->placeholders, $dbkey, true);
		}
		// Trigger Event: jcb_ce_onAfterBuildFields
		$this->triggerEvent('jcb_ce_onAfterBuildFields', array(&$this->componentContext, &$dynamicFields, &$readOnly, &$dbkey, &$view, &$component, &$view_name_single, &$view_name_list, &$this->placeholders, &$langView, &$langViews));
		// set the default fields
		$fieldSet = array();
		$fieldSet[] = '<fieldset name="details">';
		$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Default Fields. -->";
		$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Id Field. Type: Text (joomla) -->";
		// if id is not set
		if (!isset($this->fieldsNames[$view_name_single]['id']))
		{
			$fieldSet[] = $this->_t(2) . "<field";
			$fieldSet[] = $this->_t(3) . "name=" . '"id"';
			$fieldSet[] = $this->_t(3) . 'type="text" class="readonly" label="JGLOBAL_FIELD_ID_LABEL"';
			$fieldSet[] = $this->_t(3) . 'description ="JGLOBAL_FIELD_ID_DESC" size="10" default="0"';
			$fieldSet[] = $this->_t(3) . 'readonly="true"';
			$fieldSet[] = $this->_t(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if created is not set
		if (!isset($this->fieldsNames[$view_name_single]['created']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Date Created Field. Type: Calendar (joomla) -->";
			$fieldSet[] = $this->_t(2) . "<field";
			$fieldSet[] = $this->_t(3) . "name=" . '"created"';
			$fieldSet[] = $this->_t(3) . "type=" . '"calendar"';
			$fieldSet[] = $this->_t(3) . "label=" . '"' . $langView . '_CREATED_DATE_LABEL"';
			$fieldSet[] = $this->_t(3) . "description=" . '"' . $langView . '_CREATED_DATE_DESC"';
			$fieldSet[] = $this->_t(3) . "size=" . '"22"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = $this->_t(3) . "format=" . '"%Y-%m-%d %H:%M:%S"';
			$fieldSet[] = $this->_t(3) . "filter=" . '"user_utc"';
			$fieldSet[] = $this->_t(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if created_by is not set
		if (!isset($this->fieldsNames[$view_name_single]['created_by']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " User Created Field. Type: User (joomla) -->";
			$fieldSet[] = $this->_t(2) . "<field";
			$fieldSet[] = $this->_t(3) . "name=" . '"created_by"';
			$fieldSet[] = $this->_t(3) . "type=" . '"user"';
			$fieldSet[] = $this->_t(3) . "label=" . '"' . $langView . '_CREATED_BY_LABEL"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = $this->_t(3) . "description=" . '"' . $langView . '_CREATED_BY_DESC"';
			$fieldSet[] = $this->_t(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if published is not set
		if (!isset($this->fieldsNames[$view_name_single]['published']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Published Field. Type: List (joomla) -->";
			$fieldSet[] = $this->_t(2) . "<field name=" . '"published" type="list" label="JSTATUS"';
			$fieldSet[] = $this->_t(3) . "description=" . '"JFIELD_PUBLISHED_DESC" class="chzn-color-state"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = $this->_t(3) . "filter=" . '"intval" size="1" default="1" >';
			$fieldSet[] = $this->_t(3) . "<option value=" . '"1">';
			$fieldSet[] = $this->_t(4) . "JPUBLISHED</option>";
			$fieldSet[] = $this->_t(3) . "<option value=" . '"0">';
			$fieldSet[] = $this->_t(4) . "JUNPUBLISHED</option>";
			$fieldSet[] = $this->_t(3) . "<option value=" . '"2">';
			$fieldSet[] = $this->_t(4) . "JARCHIVED</option>";
			$fieldSet[] = $this->_t(3) . "<option value=" . '"-2">';
			$fieldSet[] = $this->_t(4) . "JTRASHED</option>";
			$fieldSet[] = $this->_t(2) . "</field>";
			// count the static field created
			$this->fieldCount++;
		}
		// if modified is not set
		if (!isset($this->fieldsNames[$view_name_single]['modified']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Date Modified Field. Type: Calendar (joomla) -->";
			$fieldSet[] = $this->_t(2) . '<field name="modified" type="calendar" class="readonly"';
			$fieldSet[] = $this->_t(3) . 'label="' . $langView . '_MODIFIED_DATE_LABEL" description="' . $langView . '_MODIFIED_DATE_DESC"';
			$fieldSet[] = $this->_t(3) . 'size="22" readonly="true" format="%Y-%m-%d %H:%M:%S" filter="user_utc" />';
			// count the static field created
			$this->fieldCount++;
		}
		// if modified_by is not set
		if (!isset($this->fieldsNames[$view_name_single]['modified_by']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " User Modified Field. Type: User (joomla) -->";
			$fieldSet[] = $this->_t(2) . '<field name="modified_by" type="user"';
			$fieldSet[] = $this->_t(3) . 'label="' . $langView . '_MODIFIED_BY_LABEL"';
			$fieldSet[] = $this->_t(3) . "description=" . '"' . $langView . '_MODIFIED_BY_DESC"';
			$fieldSet[] = $this->_t(3) . 'class="readonly"';
			$fieldSet[] = $this->_t(3) . 'readonly="true"';
			$fieldSet[] = $this->_t(3) . 'filter="unset"';
			$fieldSet[] = $this->_t(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// check if view has access
		if (isset($this->accessBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view_name_single]) && !isset($this->fieldsNames[$view_name_single]['access']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Access Field. Type: Accesslevel (joomla) -->";
			$fieldSet[] = $this->_t(2) . '<field name="access"';
			$fieldSet[] = $this->_t(3) . 'type="accesslevel"';
			$fieldSet[] = $this->_t(3) . 'label="JFIELD_ACCESS_LABEL"';
			$fieldSet[] = $this->_t(3) . 'description="JFIELD_ACCESS_DESC"';
			$fieldSet[] = $this->_t(3) . 'default="1"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = $this->_t(3) . 'required="false"';
			$fieldSet[] = $this->_t(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if ordering is not set
		if (!isset($this->fieldsNames[$view_name_single]['ordering']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Ordering Field. Type: Numbers (joomla) -->";
			$fieldSet[] = $this->_t(2) . "<field";
			$fieldSet[] = $this->_t(3) . 'name="ordering"';
			$fieldSet[] = $this->_t(3) . 'type="number"';
			$fieldSet[] = $this->_t(3) . 'class="inputbox validate-ordering"';
			$fieldSet[] = $this->_t(3) . 'label="' . $langView . '_ORDERING_LABEL' . '"';
			$fieldSet[] = $this->_t(3) . 'description=""';
			$fieldSet[] = $this->_t(3) . 'default="0"';
			$fieldSet[] = $this->_t(3) . 'size="6"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = $this->_t(3) . 'required="false"';
			$fieldSet[] = $this->_t(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if version is not set
		if (!isset($this->fieldsNames[$view_name_single]['version']))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Version Field. Type: Text (joomla) -->";
			$fieldSet[] = $this->_t(2) . "<field";
			$fieldSet[] = $this->_t(3) . 'name="version"';
			$fieldSet[] = $this->_t(3) . 'type="text"';
			$fieldSet[] = $this->_t(3) . 'class="readonly"';
			$fieldSet[] = $this->_t(3) . 'label="' . $langView . '_VERSION_LABEL"';
			$fieldSet[] = $this->_t(3) . 'description="' . $langView . '_VERSION_DESC"';
			$fieldSet[] = $this->_t(3) . 'size="6"';
			$fieldSet[] = $this->_t(3) . 'readonly="true"';
			$fieldSet[] = $this->_t(3) . 'filter="unset"';
			$fieldSet[] = $this->_t(2) . "/>";
			// count the static field created
			$this->fieldCount++;
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view_name_single]))
		{
			// metakey
			if (!isset($this->fieldsNames[$view_name_single]['metakey']))
			{
				$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Metakey Field. Type: Textarea (joomla) -->";
				$fieldSet[] = $this->_t(2) . "<field";
				$fieldSet[] = $this->_t(3) . 'name="metakey"';
				$fieldSet[] = $this->_t(3) . 'type="textarea"';
				$fieldSet[] = $this->_t(3) . 'label="JFIELD_META_KEYWORDS_LABEL"';
				$fieldSet[] = $this->_t(3) . 'description="JFIELD_META_KEYWORDS_DESC"';
				$fieldSet[] = $this->_t(3) . 'rows="3"';
				$fieldSet[] = $this->_t(3) . 'cols="30"';
				$fieldSet[] = $this->_t(2) . "/>";
				// count the static field created
				$this->fieldCount++;
			}
			// metadesc
			if (!isset($this->fieldsNames[$view_name_single]['metadesc']))
			{
				$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Metadesc Field. Type: Textarea (joomla) -->";
				$fieldSet[] = $this->_t(2) . "<field";
				$fieldSet[] = $this->_t(3) . 'name="metadesc"';
				$fieldSet[] = $this->_t(3) . 'type="textarea"';
				$fieldSet[] = $this->_t(3) . 'label="JFIELD_META_DESCRIPTION_LABEL"';
				$fieldSet[] = $this->_t(3) . 'description="JFIELD_META_DESCRIPTION_DESC"';
				$fieldSet[] = $this->_t(3) . 'rows="3"';
				$fieldSet[] = $this->_t(3) . 'cols="30"';
				$fieldSet[] = $this->_t(2) . "/>";
				// count the static field created
				$this->fieldCount++;
			}
		}
		// load the dynamic fields now
		if (ComponentbuilderHelper::checkString($dynamicFields))
		{
			$fieldSet[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dynamic Fields. -->" . $dynamicFields;
		}
		// close fieldset
		$fieldSet[] = $this->_t(1) . "</fieldset>";
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view_name_single]))
		{
			if (!isset($this->fieldsNames[$view_name_single]['robots'])
				|| !isset($this->fieldsNames[$view_name_single]['rights'])
				|| !isset($this->fieldsNames[$view_name_single]['author']))
			{
				$fieldSet[] = PHP_EOL . $this->_t(1) . "<!--" . $this->setLine(__LINE__) . " Metadata Fields. -->";
				$fieldSet[] = $this->_t(1) . "<fields" . ' name="metadata" label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				$fieldSet[] = $this->_t(2) . '<fieldset name="vdmmetadata"';
				$fieldSet[] = $this->_t(3) . 'label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				// robots
				if (!isset($this->fieldsNames[$view_name_single]['robots']))
				{
					$fieldSet[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Robots Field. Type: List (joomla) -->";
					$fieldSet[] = $this->_t(3) . '<field name="robots"';
					$fieldSet[] = $this->_t(4) . 'type="list"';
					$fieldSet[] = $this->_t(4) . 'label="JFIELD_METADATA_ROBOTS_LABEL"';
					$fieldSet[] = $this->_t(4) . 'description="JFIELD_METADATA_ROBOTS_DESC" >';
					$fieldSet[] = $this->_t(4) . '<option value="">JGLOBAL_USE_GLOBAL</option>';
					$fieldSet[] = $this->_t(4) . '<option value="index, follow">JGLOBAL_INDEX_FOLLOW</option>';
					$fieldSet[] = $this->_t(4) . '<option value="noindex, follow">JGLOBAL_NOINDEX_FOLLOW</option>';
					$fieldSet[] = $this->_t(4) . '<option value="index, nofollow">JGLOBAL_INDEX_NOFOLLOW</option>';
					$fieldSet[] = $this->_t(4) . '<option value="noindex, nofollow">JGLOBAL_NOINDEX_NOFOLLOW</option>';
					$fieldSet[] = $this->_t(3) . '</field>';
					// count the static field created
					$this->fieldCount++;
				}
				// author
				if (!isset($this->fieldsNames[$view_name_single]['author']))
				{
					$fieldSet[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Author Field. Type: Text (joomla) -->";
					$fieldSet[] = $this->_t(3) . '<field name="author"';
					$fieldSet[] = $this->_t(4) . 'type="text"';
					$fieldSet[] = $this->_t(4) . 'label="JAUTHOR" description="JFIELD_METADATA_AUTHOR_DESC"';
					$fieldSet[] = $this->_t(4) . 'size="20"';
					$fieldSet[] = $this->_t(3) . "/>";
					// count the static field created
					$this->fieldCount++;
				}
				// rights
				if (!isset($this->fieldsNames[$view_name_single]['rights']))
				{
					$fieldSet[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Rights Field. Type: Textarea (joomla) -->";
					$fieldSet[] = $this->_t(3) . '<field name="rights" type="textarea" label="JFIELD_META_RIGHTS_LABEL"';
					$fieldSet[] = $this->_t(4) . 'description="JFIELD_META_RIGHTS_DESC" required="false" filter="string"';
					$fieldSet[] = $this->_t(4) . 'cols="30" rows="2"';
					$fieldSet[] = $this->_t(3) . "/>";
					// count the static field created
					$this->fieldCount++;
				}
				$fieldSet[] = $this->_t(2) . "</fieldset>";
				$fieldSet[] = $this->_t(1) . "</fields>";
			}
		}
		// retunr the set
		return implode(PHP_EOL, $fieldSet);
	}

	/**
	 * build field set with simpleXMLElement class
	 *
	 * @param   array    $view             The view data
	 * @param   string   $component        The component name
	 * @param   string   $view_name_single The single view name
	 * @param   string   $view_name_list   The list view name
	 * @param   string   $langView         The language string of the view
	 * @param   string   $langViews        The language string of the views
	 *
	 * @return  string The fields set in xml
	 *
	 */
	protected function simpleXMLFieldSet($view, $component, $view_name_single, $view_name_list, $langView, $langViews)
	{
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
		// Trigger Event: jcb_ce_onBeforeBuildFields
		$this->triggerEvent('jcb_ce_onBeforeBuildFields', array(&$this->componentContext, &$dynamicFieldsXML, &$readOnlyXML, &$dbkey, &$view, &$component, &$view_name_single, &$view_name_list, &$this->placeholders, &$langView, &$langViews));
		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamicFieldsXML[] = $this->setDynamicField($field, $view, $view['settings']->type, $langView, $view_name_single, $view_name_list, $this->placeholders, $dbkey, true);
		}
		// Trigger Event: jcb_ce_onAfterBuildFields
		$this->triggerEvent('jcb_ce_onAfterBuildFields', array(&$this->componentContext, &$dynamicFieldsXML, &$readOnlyXML, &$dbkey, &$view, &$component, &$view_name_single, &$view_name_list, &$this->placeholders, &$langView, &$langViews));
		// set the default fields
		$XML = new simpleXMLElement('<a/>');
		$fieldSetXML = $XML->addChild('fieldset');
		$fieldSetXML->addAttribute('name', 'details');
		ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Default Fields.");
		ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Id Field. Type: Text (joomla)");
		// if id is not set
		if (!isset($this->fieldsNames[$view_name_single]['id']))
		{
			$attributes = array(
				'name' => 'id',
				'type' => 'text',
				'class' => 'readonly',
				'readonly' => "true",
				'label' => 'JGLOBAL_FIELD_ID_LABEL',
				'description' => 'JGLOBAL_FIELD_ID_DESC',
				'size' => 10,
				'default' => 0
			);
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if created is not set
		if (!isset($this->fieldsNames[$view_name_single]['created']))
		{
			$attributes = array(
				'name' => 'created',
				'type' => 'calendar',
				'label' => $langView . '_CREATED_DATE_LABEL',
				'description' => $langView . '_CREATED_DATE_DESC',
				'size' => 22,
				'format' => '%Y-%m-%d %H:%M:%S',
				'filter' => 'user_utc'
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Date Created Field. Type: Calendar (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if created_by is not set
		if (!isset($this->fieldsNames[$view_name_single]['created_by']))
		{
			$attributes = array(
				'name' => 'created_by',
				'type' => 'user',
				'label' => $langView . '_CREATED_BY_LABEL',
				'description' => $langView . '_CREATED_BY_DESC',
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " User Created Field. Type: User (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if published is not set
		if (!isset($this->fieldsNames[$view_name_single]['published']))
		{
			$attributes = array(
				'name' => 'published',
				'type' => 'list',
				'label' => 'JSTATUS'
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Published Field. Type: List (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
			foreach (array('JPUBLISHED' => 1, 'JUNPUBLISHED' => 0, 'JARCHIVED' => 2, 'JTRASHED' => -2) as $text => $value)
			{
				$optionXML = $fieldXML->addChild('option');
				$optionXML->addAttribute('value', $value);
				$optionXML[] = $text;
			}
		}
		// if modified is not set
		if (!isset($this->fieldsNames[$view_name_single]['modified']))
		{
			$attributes = array(
				'name' => 'modified',
				'type' => 'calendar',
				'class' => 'readonly',
				'label' => $langView . '_MODIFIED_DATE_LABEL',
				'description' => $langView . '_MODIFIED_DATE_DESC',
				'size' => 22,
				'readonly' => "true",
				'format' => '%Y-%m-%d %H:%M:%S',
				'filter' => 'user_utc'
			);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Date Modified Field. Type: Calendar (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if modified_by is not set
		if (!isset($this->fieldsNames[$view_name_single]['modified_by']))
		{
			$attributes = array(
				'name' => 'modified_by',
				'type' => 'user',
				'label' => $langView . '_MODIFIED_BY_LABEL',
				'description' => $langView . '_MODIFIED_BY_DESC',
				'class' => 'readonly',
				'readonly' => 'true',
				'filter' => 'unset'
			);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " User Modified Field. Type: User (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// check if view has access
		if (isset($this->accessBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view_name_single]) && !isset($this->fieldsNames[$view_name_single]['access']))
		{
			$attributes = array(
				'name' => 'access',
				'type' => 'accesslevel',
				'label' => 'JFIELD_ACCESS_LABEL',
				'description' => 'JFIELD_ACCESS_DESC',
				'default' => 1,
				'required' => "false"
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Access Field. Type: Accesslevel (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if ordering is not set
		if (!isset($this->fieldsNames[$view_name_single]['ordering']))
		{
			$attributes = array(
				'name' => 'ordering',
				'type' => 'number',
				'class' => 'inputbox validate-ordering',
				'label' => $langView . '_ORDERING_LABEL',
				'description' => '',
				'default' => 0,
				'size' => 6,
				'required' => "false"
			);
			$attributes = array_merge($attributes, $readOnlyXML);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Ordering Field. Type: Numbers (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// if version is not set
		if (!isset($this->fieldsNames[$view_name_single]['version']))
		{
			$attributes = array(
				'name' => 'version',
				'type' => 'text',
				'class' => 'readonly',
				'label' => $langView . '_VERSION_LABEL',
				'description' => $langView . '_VERSION_DESC',
				'size' => 6,
				'readonly' => "true",
				'filter' => 'unset'
			);
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Version Field. Type: Text (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view_name_single]))
		{
			// metakey
			if (!isset($this->fieldsNames[$view_name_single]['metakey']))
			{
				$attributes = array(
					'name' => 'metakey',
					'type' => 'textarea',
					'label' => 'JFIELD_META_KEYWORDS_LABEL',
					'description' => 'JFIELD_META_KEYWORDS_DESC',
					'rows' => 3,
					'cols' => 30
				);
				ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metakey Field. Type: Textarea (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// metadesc
			if (!isset($this->fieldsNames[$view_name_single]['metadesc']))
			{
				$attributes['name'] = 'metadesc';
				$attributes['label'] = 'JFIELD_META_DESCRIPTION_LABEL';
				$attributes['description'] = 'JFIELD_META_DESCRIPTION_DESC';
				ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metadesc Field. Type: Textarea (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
		}
		// load the dynamic fields now
		if (count((array) $dynamicFieldsXML))
		{
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Dynamic Fields.");
			foreach ($dynamicFieldsXML as $dynamicfield)
			{
				ComponentbuilderHelper::xmlAppend($fieldSetXML, $dynamicfield);
			}
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view_name_single]))
		{
			if (!isset($this->fieldsNames[$view_name_single]['robots'])
				|| !isset($this->fieldsNames[$view_name_single]['author'])
				|| !isset($this->fieldsNames[$view_name_single]['rights']))
			{
				ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metadata Fields");
				$fieldsXML = $fieldSetXML->addChild('fields');
				$fieldsXML->addAttribute('name', 'metadata');
				$fieldsXML->addAttribute('label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS');
				$fieldsFieldSetXML = $fieldsXML->addChild('fieldset');
				$fieldsFieldSetXML->addAttribute('name', 'vdmmetadata');
				$fieldsFieldSetXML->addAttribute('label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS');
				// robots
				if (!isset($this->fieldsNames[$view_name_single]['robots']))
				{
					ComponentbuilderHelper::xmlComment($fieldsFieldSetXML, $this->setLine(__LINE__) . " Robots Field. Type: List (joomla)");
					$robots = $fieldsFieldSetXML->addChild('field');
					$attributes = array(
						'name' => 'robots',
						'type' => 'list',
						'label' => 'JFIELD_METADATA_ROBOTS_LABEL',
						'description' => 'JFIELD_METADATA_ROBOTS_DESC'
					);
					ComponentbuilderHelper::xmlAddAttributes($robots, $attributes);
					// count the static field created
					$this->fieldCount++;
					$options = array(
						'JGLOBAL_USE_GLOBAL' => '',
						'JGLOBAL_INDEX_FOLLOW' => 'index, follow',
						'JGLOBAL_NOINDEX_FOLLOW' => 'noindex, follow',
						'JGLOBAL_INDEX_NOFOLLOW' => 'index, nofollow',
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
				if (!isset($this->fieldsNames[$view_name_single]['author']))
				{
					ComponentbuilderHelper::xmlComment($fieldsFieldSetXML, $this->setLine(__LINE__) . " Author Field. Type: Text (joomla)");
					$author = $fieldsFieldSetXML->addChild('field');
					$attributes = array(
						'name' => 'author',
						'type' => 'text',
						'label' => 'JAUTHOR',
						'description' => 'JFIELD_METADATA_AUTHOR_DESC',
						'size' => 20
					);
					ComponentbuilderHelper::xmlAddAttributes($author, $attributes);
					// count the static field created
					$this->fieldCount++;
				}
				// rights
				if (!isset($this->fieldsNames[$view_name_single]['rights']))
				{
					ComponentbuilderHelper::xmlComment($fieldsFieldSetXML, $this->setLine(__LINE__) . " Rights Field. Type: Textarea (joomla)");
					$rights = $fieldsFieldSetXML->addChild('field');
					$attributes = array(
						'name' => 'rights',
						'type' => 'textarea',
						'label' => 'JFIELD_META_RIGHTS_LABEL',
						'description' => 'JFIELD_META_RIGHTS_DESC',
						'required' => 'false',
						'filter' => 'string',
						'cols' => 30,
						'rows' => 2
					);
					ComponentbuilderHelper::xmlAddAttributes($rights, $attributes);
					// count the static field created
					$this->fieldCount++;
				}
			}
		}
		// return the set
		return $this->xmlPrettyPrint($XML, 'fieldset');
	}

	/**
	 * set Field Names
	 *
	 * @param   string   $view    View the field belongs to
	 * @param   string    $name    The name of the field
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
	 * @param   array    $field             The field data
	 * @param   array    $view              The view data
	 * @param   int      $viewType          The view type
	 * @param   string   $langView          The language string of the view
	 * @param   string   $view_name_single  The single view name
	 * @param   string   $view_name_list    The list view name
	 * @param   array    $placeholders      The place holder and replace values
	 * @param   string   $dbkey             The the custom table key
	 * @param   boolean  $build             The switch to set the build option
	 *
	 * @return  SimpleXMLElement The complete field in xml
	 *
	 */
	public function setDynamicField(&$field, &$view, &$viewType, &$langView, &$view_name_single, &$view_name_list, &$placeholders, &$dbkey, $build)
	{
		// set default return
		if ($this->fieldBuilderType == 1)
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
		if (isset($field['settings']) && ComponentbuilderHelper::checkObject($field['settings']))
		{
			// reset some values
			$name = $this->getFieldName($field, $view_name_list);
			$typeName = $this->getFieldType($field);
			$multiple = false;
			$langLabel = '';
			$fieldSet = '';
			$fieldAttributes = array();
			// set field attributes
			$fieldAttributes = $this->setFieldAttributes($field, $viewType, $name, $typeName, $multiple, $langLabel, $langView, $view_name_list, $view_name_single, $placeholders);
			// check if values were set
			if (ComponentbuilderHelper::checkArray($fieldAttributes))
			{
				// set the array of field names
				$this->setFieldsNames($view_name_single, $fieldAttributes['name']);

				if (ComponentbuilderHelper::fieldCheck($typeName, 'option'))
				{
					//reset options array
					$optionArray = array();
					// now add to the field set
					$dynamicField = $this->setField('option', $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray);
					if ($build)
					{
						// set builders
						$this->setBuilders($langLabel, $langView, $view_name_single, $view_name_list, $name, $view, $field, $typeName, $multiple, false, $optionArray);
					}
				}
				elseif (ComponentbuilderHelper::fieldCheck($typeName, 'spacer'))
				{
					if ($build)
					{
						// make sure spacers gets loaded to layout
						$tabName = '';
						if (isset($view['settings']->tabs) && isset($view['settings']->tabs[(int) $field['tab']]))
						{
							$tabName = $view['settings']->tabs[(int) $field['tab']];
						}
						elseif ((int) $field['tab'] == 15)
						{
							// set to publishing tab
							$tabName = 'publishing';
						}
						$this->setLayoutBuilder($view_name_single, $tabName, $name, $field);
					}
					// now add to the field set
					$dynamicField = $this->setField('spacer', $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray);
				}
				elseif (ComponentbuilderHelper::fieldCheck($typeName, 'special'))
				{
					// set the repeatable field or subform field
					if ($typeName === 'repeatable' || $typeName === 'subform')
					{
						if ($build)
						{
							// set builders
							$this->setBuilders($langLabel, $langView, $view_name_single, $view_name_list, $name, $view, $field, $typeName, $multiple, false);
						}
						// now add to the field set
						$dynamicField = $this->setField('special', $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray);
					}
				}
				elseif (isset($fieldAttributes['custom']) && ComponentbuilderHelper::checkArray($fieldAttributes['custom']))
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
						$this->setBuilders($langLabel, $langView, $view_name_single, $view_name_list, $name, $view, $field, $typeName, $multiple, $custom);
					}
					// now add to the field set
					$dynamicField = $this->setField('custom', $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray, $custom);
				}
				else
				{
					if ($build)
					{
						// set builders
						$this->setBuilders($langLabel, $langView, $view_name_single, $view_name_list, $name, $view, $field, $typeName, $multiple);
					}
					// now add to the field set
					$dynamicField = $this->setField('plain', $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray);
				}
			}
		}
		return $dynamicField;
	}

	/**
	 * set a field
	 *
	 * @param   string   $setType           The set of fields type
	 * @param   array    $fieldAttributes   The field values
	 * @param   string   $name              The field name
	 * @param   string   $typeName          The field type
	 * @param   string   $langView          The language string of the view
	 * @param   string   $view_name_single  The single view name
	 * @param   string   $view_name_list    The list view name
	 * @param   array    $placeholders      The place holder and replace values
	 * @param   string   $optionArray       The option bucket array used to set the field options if needed.
	 * @param   array    $custom            Used when field is from config
	 * @param   string   $taber             The tabs to add in layout (only in string manipulation)
	 *
	 * @return  SimpleXMLElement The field in xml
	 *
	 */
	private function setField($setType, &$fieldAttributes, &$name, &$typeName, &$langView, &$view_name_single, &$view_name_list, $placeholders, &$optionArray, $custom = null, $taber = '')
	{
		// count the dynamic fields created
		$this->fieldCount++;
		// check what type of field builder to use
		if ($this->fieldBuilderType == 1)
		{
			// build field set using string manipulation
			return $this->stringSetField($setType, $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray, $custom, $taber);
		}
		else
		{
			// build field set with simpleXMLElement class
			return $this->simpleXMLSetField($setType, $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray, $custom);
		}
	}

	/**
	 * set a field using string manipulation
	 *
	 * @param   string   $setType           The set of fields type
	 * @param   array    $fieldAttributes   The field values
	 * @param   string   $name              The field name
	 * @param   string   $typeName          The field type
	 * @param   string   $langView          The language string of the view
	 * @param   string   $view_name_single  The single view name
	 * @param   string   $view_name_list    The list view name
	 * @param   array    $placeholders      The place holder and replace values
	 * @param   string   $optionArray       The option bucket array used to set the field options if needed.
	 * @param   array    $custom            Used when field is from config
	 * @param   string   $taber             The tabs to add in layout
	 *
	 * @return  SimpleXMLElement The field in xml
	 *
	 */
	protected function stringSetField($setType, &$fieldAttributes, &$name, &$typeName, &$langView, &$view_name_single, &$view_name_list, $placeholders, &$optionArray, $custom = null, $taber = '')
	{
		$field = '';
		if ($setType === 'option')
		{
			// now add to the field set
			$field .= PHP_EOL . $this->_t(1) . $taber . $this->_t(1) . "<!--" . $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
			$field .= PHP_EOL . $this->_t(1) . $taber . $this->_t(1) . "<field";
			$optionSet = '';
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . $this->_t(2) . $taber . $this->_t(1) . $property . '="' . $value . '"';
				}
				elseif ($property === 'option')
				{
					$optionSet = '';
					if (strtolower($typeName) === 'groupedlist' && strpos($value, ',') !== false && strpos($value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_ = array();
						$grouped_ = array('group' => array(), 'option' => array());
						$order_ = array();
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
									$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($valueKeyArray[0], true);
									// add to lang array
									$this->setLangContent($this->lang, $langValue, $valueKeyArray[0]);
									// now add group label
									$groups_[$valueKeyArray[1]] = PHP_EOL . $this->_t(1) . $taber . $this->_t(2) . '<group label="' .  $langValue . '">';
									// set order
									$order_['group' . $valueKeyArray[1]] = $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($valueKeyArray[1], true);
									// add to lang array
									$this->setLangContent($this->lang, $langValue, $valueKeyArray[1]);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][] = PHP_EOL . $this->_t(1) . $taber . $this->_t(3) . '<option value="' . $valueKeyArray[0] . '">' . PHP_EOL . $this->_t(1) . $taber . $this->_t(4) . $langValue . '</option>';
									$optionArray[$valueKeyArray[0]] = $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]] = $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($valueKeyArray[1], true);
									// add to lang array
									$this->setLangContent($this->lang, $langValue, $valueKeyArray[1]);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]] = PHP_EOL . $this->_t(1) . $taber . $this->_t(2) . '<option value="' . $valueKeyArray[0] . '">' . PHP_EOL . $this->_t(1) . $taber . $this->_t(3) . $langValue . '</option>';
									$optionArray[$valueKeyArray[0]] = $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]] = $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($option, true);
								// add to lang array
								$this->setLangContent($this->lang, $langValue, $option);
								// now add to option set
								$grouped_['option'][$option] = PHP_EOL . $this->_t(1) . $taber . $this->_t(2) . '<option value="' . $option . '">' . PHP_EOL . $this->_t(1) . $taber . $this->_t(3) . $langValue . '</option>';
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
							if ('group' === $key_ && isset($groups_[$_id]) && isset($grouped_[$key_][$_id]) && ComponentbuilderHelper::checkArray($grouped_[$key_][$_id]))
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
								$optionSet .= PHP_EOL . $this->_t(1) . $taber . $this->_t(2) . '</group>';
							}
							elseif (isset($grouped_[$key_][$_id]) && ComponentbuilderHelper::checkString($grouped_[$key_][$_id]))
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
								$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($t, true);
								// add to lang array
								$this->setLangContent($this->lang, $langValue, $t);
								// now add to option set
								$optionSet .= PHP_EOL . $this->_t(1) . $taber . $this->_t(2) . '<option value="' . $v . '">' . PHP_EOL . $this->_t(1) . $taber . $this->_t(3) . $langValue . '</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($option, true);
								// add to lang array
								$this->setLangContent($this->lang, $langValue, $option);
								// now add to option set
								$optionSet .= PHP_EOL . $this->_t(2) . $taber . $this->_t(1) . '<option value="' . $option . '">' . PHP_EOL . $this->_t(2) . $taber . $this->_t(2) . $langValue . '</option>';
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
							$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($t, true);
							// add to lang array
							$this->setLangContent($this->lang, $langValue, $t);
							// now add to option set
							$optionSet .= PHP_EOL . $this->_t(2) . $taber . $this->_t(1) . '<option value="' . $v . '">' . PHP_EOL . $this->_t(2) . $taber . $this->_t(2) . $langValue . '</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($value, true);
							// add to lang array
							$this->setLangContent($this->lang, $langValue, $value);
							// now add to option set
							$optionSet .= PHP_EOL . $this->_t(2) . $taber . $this->_t(1) . '<option value="' . $value . '">' . PHP_EOL . $this->_t(2) . $taber . $this->_t(2) . $langValue . '</option>';
							$optionArray[$value] = $langValue;
						}
					}
				}
			}
			// if options were found
			if (ComponentbuilderHelper::checkString($optionSet))
			{
				$field .= '>';
				$field .= PHP_EOL . $this->_t(3) . $taber . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$field .= $optionSet;
				$field .= PHP_EOL . $this->_t(2) . $taber . "</field>";
			}
			// if no options found and must have a list of options
			elseif (ComponentbuilderHelper::fieldCheck($typeName, 'list'))
			{
				$optionArray = false;
				$field .= PHP_EOL . $this->_t(2) . $taber . "/>";
				$field .= PHP_EOL . $this->_t(2) . $taber . "<!--" . $this->setLine(__LINE__) . " No Manual Options Were Added In Field Settings. -->" . PHP_EOL;
			}
			else
			{
				$optionArray = false;
				$field .= PHP_EOL . $this->_t(2) . $taber . "/>";
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$field .= PHP_EOL . $this->_t(2) . $taber . "<!--" . $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
			$field .= PHP_EOL . $this->_t(2) . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . $this->_t(2) . $taber . $this->_t(1) . $property . '="' . $value . '"';
				}
			}
			$field .= PHP_EOL . $this->_t(2) . $taber . "/>";
		}
		elseif ($setType === 'spacer')
		{
			// now add to the field set
			$field .= PHP_EOL . $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". A None Database Field. (joomla) -->";
			$field .= PHP_EOL . $this->_t(2) . "<field";
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
				$field .= PHP_EOL . $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
				$field .= PHP_EOL . $this->_t(2) . "<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . $this->_t(3) . $property . '="' . $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . $this->_t(3) . '<fields name="' . $fieldAttributes['name'] . '_fields" label="">';
				$field .= PHP_EOL . $this->_t(4) . '<fieldset hidden="true" name="' . $fieldAttributes['name'] . '_modal" repeat="true">';
				if (strpos($fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(',', $fieldAttributes['fields']);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ComponentbuilderHelper::checkArray($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(function($id) use($view_name_single, $view_name_list, $_resolverKey) {
						// start field
						$field = array();
						$field['field'] = $id;
						// set the field details
						$this->setFieldDetails($field, $view_name_single, $view_name_list, $_resolverKey);
						// return field
						return $field;
					}, array_values($fieldsSets));
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = $this->getFieldName($fieldData, $view_name_list, $_resolverKey);
							$r_typeName = $this->getFieldType($fieldData);
							$r_multiple = false;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = $this->_t(3);
							// get field values
							$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $view_name_list, $view_name_single, $placeholders, true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if (ComponentbuilderHelper::fieldCheck($r_typeName, 'option'))
								{
									// now add to the field set
									$field .= $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
								elseif (isset($r_fieldValues['custom']) && ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
									// set lang (just incase)
									$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeFieldName($r_name, true);
									// add to lang array
									$this->setLangContent($this->lang, $r_listLangName, ComponentbuilderHelper::safeString($r_name, 'W'));
									// if label was set use instead
									if (ComponentbuilderHelper::checkString($r_langLabel))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type' => $r_typeName, 'code' => $r_name, 'lang' => $r_listLangName, 'custom' => $custom);
									// set the custom field file
									$this->setCustomFieldTypeFile($data, $view_name_list, $view_name_single);
								}
								else
								{
									// now add to the field set
									$field .= $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
							}
						}
					}
				}
				$field .= PHP_EOL . $this->_t(4) . "</fieldset>";
				$field .= PHP_EOL . $this->_t(3) . "</fields>";
				$field .= PHP_EOL . $this->_t(2) . "</field>";
			}
			// set the subform fields (it is a repeatable without the modal) 
			elseif ($typeName === 'subform')
			{
				// now add to the field set
				$field .= PHP_EOL . $this->_t(2) . $taber . "<!--" . $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
				$field .= PHP_EOL . $this->_t(2) . $taber . "<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . $this->_t(3) . $taber . $property . '="' . $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . $this->_t(3) . $taber . '<form hidden="true" name="list_' . $fieldAttributes['name'] . '_modal" repeat="true">';
				if (strpos($fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(',', $fieldAttributes['fields']);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ComponentbuilderHelper::checkArray($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(function($id) use($view_name_single, $view_name_list, $_resolverKey) {
						// start field
						$field = array();
						$field['field'] = $id;
						// set the field details
						$this->setFieldDetails($field, $view_name_single, $view_name_list, $_resolverKey);
						// return field
						return $field;
					}, array_values($fieldsSets));
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = $this->getFieldName($fieldData, $view_name_list, $_resolverKey);
							$r_typeName = $this->getFieldType($fieldData);
							$r_multiple = false;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = $this->_t(2) . $taber;
							// get field values
							$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $view_name_list, $view_name_single, $placeholders, true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if (ComponentbuilderHelper::fieldCheck($r_typeName, 'option'))
								{
									// now add to the field set
									$field .= $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
								elseif ($r_typeName === 'subform')
								{
									// set nested depth
									if (isset($fieldAttributes['nested_depth']))
									{
										$r_fieldValues['nested_depth'] = ++$fieldAttributes['nested_depth'];
									}
									else
									{
										$r_fieldValues['nested_depth'] = 1;
									}
									// only continue if nest is bellow 20 (this should be a safe limit)
									if ($r_fieldValues['nested_depth'] <= 20)
									{
										// now add to the field set
										$field .= $this->setField('special', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
									}
								}
								elseif (isset($r_fieldValues['custom']) && ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
									// set lang (just incase)
									$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeFieldName($r_name, true);
									// add to lang array
									$this->setLangContent($this->lang, $r_listLangName, ComponentbuilderHelper::safeString($r_name, 'W'));
									// if label was set use instead
									if (ComponentbuilderHelper::checkString($r_langLabel))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type' => $r_typeName, 'code' => $r_name, 'lang' => $r_listLangName, 'custom' => $custom);
									// set the custom field file
									$this->setCustomFieldTypeFile($data, $view_name_list, $view_name_single);
								}
								else
								{
									// now add to the field set
									$field .= $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
							}
						}
					}
				}
				$field .= PHP_EOL . $this->_t(3) . $taber . "</form>";
				$field .= PHP_EOL . $this->_t(2) . $taber . "</field>";
			}
		}
		elseif ($setType === 'custom')
		{
			// now add to the field set
			$field .= PHP_EOL . $this->_t(2) . $taber . "<!--" . $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (custom) -->";
			$field .= PHP_EOL . $this->_t(2) . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . $this->_t(2) . $taber . $this->_t(1) . $property . '="' . $value . '"';
				}
			}
			$field .= PHP_EOL . $this->_t(2) . $taber . "/>";
			// incase the field is in the config and has not been set
			if ('config' === $view_name_single && 'configs' === $view_name_list||
				strpos($view_name_single, 'P|uG!n') !== false)
			{
				// set lang (just incase)
				$listLangName = $langView . '_' . ComponentbuilderHelper::safeString($name, 'U');
				// set the custom array
				$data = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom);
				// set the custom field file
				$this->setCustomFieldTypeFile($data, $view_name_list, $view_name_single);
			}
		}
		// return field
		return $field;
	}

	/**
	 * set a field with simpleXMLElement class
	 *
	 * @param   string   $setType           The set of fields type
	 * @param   array    $fieldAttributes   The field values
	 * @param   string   $name              The field name
	 * @param   string   $typeName          The field type
	 * @param   string   $langView          The language string of the view
	 * @param   string   $view_name_single  The single view name
	 * @param   string   $view_name_list    The list view name
	 * @param   array    $placeholders      The place holder and replace values
	 * @param   string   $optionArray       The option bucket array used to set the field options if needed.
	 * @param   array    $custom            Used when field is from config
	 *
	 * @return  SimpleXMLElement The field in xml
	 *
	 */
	protected function simpleXMLSetField($setType, &$fieldAttributes, &$name, &$typeName, &$langView, &$view_name_single, &$view_name_list, $placeholders, &$optionArray, $custom = null)
	{
		$field = new stdClass();
		if ($setType === 'option')
		{
			// now add to the field set
			$field->fieldXML = new SimpleXMLElement('<field/>');
			$field->comment = $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla)";

			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
				elseif ($property === 'option')
				{
					ComponentbuilderHelper::xmlComment($field->fieldXML, $this->setLine(__LINE__) . " Option Set.");
					if (strtolower($typeName) === 'groupedlist' && strpos($value, ',') !== false && strpos($value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_ = array();
						$grouped_ = array('group' => array(), 'option' => array());
						$order_ = array();
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
									$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($valueKeyArray[0], true);
									// add to lang array
									$this->setLangContent($this->lang, $langValue, $valueKeyArray[0]);
									// now add group label
									$groups_[$valueKeyArray[1]] = $langValue;
									// set order
									$order_['group' . $valueKeyArray[1]] = $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($valueKeyArray[1], true);
									// add to lang array
									$this->setLangContent($this->lang, $langValue, $valueKeyArray[1]);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][] = array('value' => $valueKeyArray[0], 'text' => $langValue);
									$optionArray[$valueKeyArray[0]] = $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]] = $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($valueKeyArray[1], true);
									// add to lang array
									$this->setLangContent($this->lang, $langValue, $valueKeyArray[1]);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]] = array('value' => $valueKeyArray[0], 'text' => $langValue);
									$optionArray[$valueKeyArray[0]] = $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]] = $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($option, true);
								// add to lang array
								$this->setLangContent($this->lang, $langValue, $option);
								// now add to option set
								$grouped_['option'][$option] = array('value' => $option, 'text' => $langValue);
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
							if ('group' === $key_ && isset($groups_[$_id]) && isset($grouped_[$key_][$_id]) && ComponentbuilderHelper::checkArray($grouped_[$key_][$_id]))
							{
								// set group label
								$groupXML = $field->fieldXML->addChild('group');
								$groupXML->addAttribute('label', $groups_[$_id]);

								foreach ($grouped_[$key_][$_id] as $option_)
								{
									$groupOptionXML = $groupXML->addChild('option');
									$groupOptionXML->addAttribute('value', $option_['value']);
									$groupOptionXML[] = $option_['text'];
								}
								unset($groups_[$_id]);
								unset($grouped_[$key_][$_id]);
							}
							elseif (isset($grouped_[$key_][$_id]) && ComponentbuilderHelper::checkString($grouped_[$key_][$_id]))
							{
								$optionXML = $field->fieldXML->addChild('option');
								$optionXML->addAttribute('value', $grouped_[$key_][$_id]['value']);
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
								$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($t, true);
								// add to lang array
								$this->setLangContent($this->lang, $langValue, $t);
								// now add to option set
								$optionXML->addAttribute('value', $v);
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($option, true);
								// add to lang array
								$this->setLangContent($this->lang, $langValue, $option);
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
							$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($t, true);
							// add to lang array
							$this->setLangContent($this->lang, $langValue, $t);
							// now add to option set
							$optionXML->addAttribute('value', $v);
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($value, true);
							// add to lang array
							$this->setLangContent($this->lang, $langValue, $value);
							// now add to option set
							$optionXML->addAttribute('value', $value);
							$optionArray[$value] = $langValue;
						}
						$optionXML[] = $langValue;
					}
				}
			}
			// if no options found and must have a list of options
			if (!$field->fieldXML->count() && ComponentbuilderHelper::fieldCheck($typeName, 'list'))
			{
				ComponentbuilderHelper::xmlComment($field->fieldXML, $this->setLine(__LINE__) . " No Manual Options Were Added In Field Settings.");
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$field->fieldXML = new SimpleXMLElement('<field/>');
			$field->comment = $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla)";

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
			$field->comment = $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". A None Database Field. (joomla)";

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
				$field->comment = $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (depreciated)";

				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field->fieldXML->addAttribute($property, $value);
					}
				}
				$fieldsXML = $field->fieldXML->addChild('fields');
				$fieldsXML->addAttribute('name', $fieldAttributes['name'] . '_fields');
				$fieldsXML->addAttribute('label', '');
				$fieldSetXML = $fieldsXML->addChild('fieldset');
				$fieldSetXML->addAttribute('hidden', 'true');
				$fieldSetXML->addAttribute('name', $fieldAttributes['name'] . '_modal');
				$fieldSetXML->addAttribute('repeat', 'true');

				if (strpos($fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(',', $fieldAttributes['fields']);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ComponentbuilderHelper::checkArray($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(function($id) use($view_name_single, $view_name_list, $_resolverKey) {
						// start field
						$field = array();
						$field['field'] = $id;
						// set the field details
						$this->setFieldDetails($field, $view_name_single, $view_name_list, $_resolverKey);
						// return field
						return $field;
					}, array_values($fieldsSets));
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = $this->getFieldName($fieldData, $view_name_list, $_resolverKey);
							$r_typeName = $this->getFieldType($fieldData);
							$r_multiple = false;
							$r_langLabel = '';
							// get field values
							$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $view_name_list, $view_name_single, $placeholders, true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if (ComponentbuilderHelper::fieldCheck($r_typeName, 'option'))
								{
									// now add to the field set
									ComponentbuilderHelper::xmlAppend($fieldSetXML, $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
								}
								elseif (isset($r_fieldValues['custom']) && ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									ComponentbuilderHelper::xmlAppend($fieldSetXML, $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
									// set lang (just incase)
									$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeFieldName($r_name, true);
									// add to lang array
									$this->setLangContent($this->lang, $r_listLangName, ComponentbuilderHelper::safeString($r_name, 'W'));
									// if label was set use instead
									if (ComponentbuilderHelper::checkString($r_langLabel))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type' => $r_typeName, 'code' => $r_name, 'lang' => $r_listLangName, 'custom' => $custom);
									// set the custom field file
									$this->setCustomFieldTypeFile($data, $view_name_list, $view_name_single);
								}
								else
								{
									// now add to the field set
									ComponentbuilderHelper::xmlAppend($fieldSetXML, $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
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
				$field->comment = $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla)";
				// add all properties
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields' && $property != 'formsource')
					{
						$field->fieldXML->addAttribute($property, $value);
					}
				}
				// if we detect formsource we do not add the form
				if (isset($fieldAttributes['formsource']) && ComponentbuilderHelper::checkString($fieldAttributes['formsource']))
				{
					$field->fieldXML->addAttribute('formsource', $fieldAttributes['formsource']);
				}
				// add the form
				else
				{
					$form = $field->fieldXML->addChild('form');
					$attributes = array(
						'hidden' => 'true',
						'name' => 'list_' . $fieldAttributes['name'] . '_modal',
						'repeat' => 'true'
					);
					ComponentbuilderHelper::xmlAddAttributes($form, $attributes);

					if (strpos($fieldAttributes['fields'], ',') !== false)
					{
						// multiple fields
						$fieldsSets = (array) explode(',', $fieldAttributes['fields']);
					}
					elseif (is_numeric($fieldAttributes['fields']))
					{
						// single field
						$fieldsSets[] = (int) $fieldAttributes['fields'];
					}
					// only continue if we have a field set
					if (ComponentbuilderHelper::checkArray($fieldsSets))
					{
						// set the resolver
						$_resolverKey = $fieldAttributes['name'];
						// load the field data
						$fieldsSets = array_map(function($id) use($view_name_single, $view_name_list, $_resolverKey) {
							// start field
							$field = array();
							$field['field'] = $id;
							// set the field details
							$this->setFieldDetails($field, $view_name_single, $view_name_list, $_resolverKey);
							// return field
							return $field;
						}, array_values($fieldsSets));
						// start the build
						foreach ($fieldsSets as $fieldData)
						{
							// if we have settings continue
							if (ComponentbuilderHelper::checkObject($fieldData['settings']))
							{
								$r_name = $this->getFieldName($fieldData, $view_name_list, $_resolverKey);
								$r_typeName = $this->getFieldType($fieldData);
								$r_multiple = false;
								$r_langLabel = '';
								// get field values
								$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $view_name_list, $view_name_single, $placeholders, true);
								// check if values were set
								if (ComponentbuilderHelper::checkArray($r_fieldValues))
								{
									//reset options array
									$r_optionArray = array();
									if (ComponentbuilderHelper::fieldCheck($r_typeName, 'option'))
									{
										// now add to the field set
										ComponentbuilderHelper::xmlAppend($form, $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
									}
									elseif ($r_typeName === 'subform')
									{
										// set nested depth
										if (isset($fieldAttributes['nested_depth']))
										{
											$r_fieldValues['nested_depth'] = ++$fieldAttributes['nested_depth'];
										}
										else
										{
											$r_fieldValues['nested_depth'] = 1;
										}
										// only continue if nest is bellow 20 (this should be a safe limit)
										if ($r_fieldValues['nested_depth'] <= 20)
										{
											// now add to the field set
											ComponentbuilderHelper::xmlAppend($form, $this->setField('special', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
										}
										
									}
									elseif (isset($r_fieldValues['custom']) && ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
									{
										// add to custom
										$custom = $r_fieldValues['custom'];
										unset($r_fieldValues['custom']);
										// now add to the field set
										ComponentbuilderHelper::xmlAppend($form, $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
										// set lang (just incase)
										$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeFieldName($r_name, true);
										// add to lang array
										$this->setLangContent($this->lang, $r_listLangName, ComponentbuilderHelper::safeString($r_name, 'W'));
										// if label was set use instead
										if (ComponentbuilderHelper::checkString($r_langLabel))
										{
											$r_listLangName = $r_langLabel;
										}
										// set the custom array
										$data = array('type' => $r_typeName, 'code' => $r_name, 'lang' => $r_listLangName, 'custom' => $custom);
										// set the custom field file
										$this->setCustomFieldTypeFile($data, $view_name_list, $view_name_single);
									}
									else
									{
										// now add to the field set
										ComponentbuilderHelper::xmlAppend($form, $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
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
			$field->comment = $this->setLine(__LINE__) . " " . ucfirst($name) . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (custom)";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
			}
			// incase the field is in the config and has not been set (or is part of a plugin or module)
			if (('config' === $view_name_single && 'configs' === $view_name_list) ||
				strpos($view_name_single, 'P|uG!n') !== false)
			{
				// set lang (just incase)
				$listLangName = $langView . '_' . ComponentbuilderHelper::safeString($name, 'U');
				// set the custom array
				$data = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom);
				// set the custom field file
				$this->setCustomFieldTypeFile($data, $view_name_list, $view_name_single);
			}
		}
		return $field;
	}

	/**
	 * set the layout builder
	 *
	 * @param   string   $view_name_single  The single edit view code name
	 * @param   string   $tabName           The tab code name
	 * @param   string   $name              The field code name
	 * @param   array    $field             The field details
	 *
	 * @return  void
	 *
	 */
	public function setLayoutBuilder(&$view_name_single, &$tabName, &$name, &$field)
	{
		// first fix the zero order
		// to insure it lands before all the other fields
		// as zero is expected to behave
		if ($field['order_edit'] == 0)
		{
			if (!isset($this->zeroOrderFix[$view_name_single]))
			{
				$this->zeroOrderFix[$view_name_single] = array();
			}
			if (!isset($this->zeroOrderFix[$view_name_single][(int) $field['tab']]))
			{
				$this->zeroOrderFix[$view_name_single][(int) $field['tab']] = -999;
			}
			else
			{
				$this->zeroOrderFix[$view_name_single][(int) $field['tab']] ++;
			}
			$field['order_edit'] = $this->zeroOrderFix[$view_name_single][(int) $field['tab']];
		}
		// now build the layout
		if (ComponentbuilderHelper::checkString($tabName) && $tabName != 'publishing')
		{
			$this->tabCounter[$view_name_single][(int) $field['tab']] = $tabName;
			if (isset($this->layoutBuilder[$view_name_single][$tabName][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = (int) count((array) $this->layoutBuilder[$view_name_single][$tabName][(int) $field['alignment']]) + 1;
				while (isset($this->layoutBuilder[$view_name_single][$tabName][(int) $field['alignment']][$size]))
				{
					$size++;
				}
				$this->layoutBuilder[$view_name_single][$tabName][(int) $field['alignment']][$size] = $name;
			}
			else
			{
				$this->layoutBuilder[$view_name_single][$tabName][(int) $field['alignment']][(int) $field['order_edit']] = $name;
			}
			// check if default fields were over written
			if (in_array($name, $this->defaultFields))
			{
				// just to eliminate
				$this->movedPublishingFields[$view_name_single][$name] = $name;
			}
		}
		elseif ($tabName === 'publishing' || $tabName === 'Publishing')
		{
			if (!in_array($name, $this->defaultFields))
			{
				if (isset($this->newPublishingFields[$view_name_single][(int) $field['alignment']][(int) $field['order_edit']]))
				{
					$size = (int) count((array) $this->newPublishingFields[$view_name_single][(int) $field['alignment']]) + 1;
					while (isset($this->newPublishingFields[$view_name_single][(int) $field['alignment']][$size]))
					{
						$size++;
					}
					$this->newPublishingFields[$view_name_single][(int) $field['alignment']][$size] = $name;
				}
				else
				{
					$this->newPublishingFields[$view_name_single][(int) $field['alignment']][(int) $field['order_edit']] = $name;
				}
			}
		}
		else
		{
			$this->tabCounter[$view_name_single][1] = 'Details';
			if (isset($this->layoutBuilder[$view_name_single]['Details'][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = (int) count((array) $this->layoutBuilder[$view_name_single]['Details'][(int) $field['alignment']]) + 1;
				while (isset($this->layoutBuilder[$view_name_single]['Details'][(int) $field['alignment']][$size]))
				{
					$size++;
				}
				$this->layoutBuilder[$view_name_single]['Details'][(int) $field['alignment']][$size] = $name;
			}
			else
			{
				$this->layoutBuilder[$view_name_single]['Details'][(int) $field['alignment']][(int) $field['order_edit']] = $name;
			}
			// check if default fields were over written
			if (in_array($name, $this->defaultFields))
			{
				// just to eliminate
				$this->movedPublishingFields[$view_name_single][$name] = $name;
			}
		}
	}

	/**
	 * build the site field data needed
	 *
	 * @param   string   $view   The single edit view code name
	 * @param   string   $field  The field name
	 * @param   string   $set    The decoding set this field belongs to
	 * @param   string   $type   The field type
	 *
	 * @return  void
	 *
	 */
	public function buildSiteFieldData($view, $field, $set, $type)
	{
		$decode = array('json', 'base64', 'basic_encryption', 'whmcs_encryption', 'medium_encryption', 'expert_mode');
		$textareas = array('textarea', 'editor');
		if (isset($this->siteFields[$view][$field]) && ComponentbuilderHelper::checkArray($this->siteFields[$view][$field]))
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
					if (isset($this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]) &&
						isset($this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]['decode']))
					{
						if (!in_array($set, $this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]['decode']))
						{
							$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']]['decode'][] = $set;
						}
					}
					else
					{
						$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']] = array('decode' => array($set), 'type' => $type, 'admin_view' => $view);
					}
				}
				// set the uikit checker
				if ((2 == $this->uikit || 1 == $this->uikit) && in_array($type, $textareas))
				{
					$this->siteFieldData['uikit'][$array['site']][$code][$array['as']][$array['key']] = $array;
				}
				// set the textareas checker
				if (in_array($type, $textareas))
				{
					$this->siteFieldData['textareas'][$array['site']][$code][$array['as']][$array['key']] = $array;
				}
			}
		}
	}

	/**
	 * set field attributes
	 *
	 * @param   array    $field             The field data
	 * @param   int      $viewType          The view type
	 * @param   string   $name              The field name
	 * @param   string   $typeName          The field type
	 * @param   boolean  $multiple          The switch to set multiple selection option
	 * @param   string   $langLabel         The language string for field label
	 * @param   string   $langView          The language string of the view
	 * @param   string   $view_name_list    The list view name
	 * @param   string   $view_name_single  The single view name
	 * @param   array    $placeholders      The place holder and replace values
	 * @param   boolean  $repeatable        The repeatable field switch
	 *
	 * @return  array The field attributes
	 *
	 */
	private function setFieldAttributes(&$field, &$viewType, &$name, &$typeName, &$multiple, &$langLabel, $langView, $view_name_list, $view_name_single, $placeholders, $repeatable = false)
	{
		// reset array
		$fieldAttributes = array();
		$setCustom = false;
		$setReadonly = false;
		// setup joomla default fields
		if (!ComponentbuilderHelper::fieldCheck($typeName))
		{
			$fieldAttributes['custom'] = array();
			// is this an own custom field
			if (isset($field['settings']->own_custom))
			{
				$fieldAttributes['custom']['own_custom'] = $field['settings']->own_custom;
			}
			$setCustom = true;
		}
		// setup a default field
		if (ComponentbuilderHelper::checkArray($field['settings']->properties))
		{
			// we need a deeper php code search tracker
			$phpTracker = array();
			foreach ($field['settings']->properties as $property)
			{
				// reset
				$xmlValue = '';
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
					$xmlValue = $this->setPlaceholders($name, $placeholders);
				}
				elseif ($property['name'] === 'validate')
				{
					// check if we have validate (validation rule set)
					$xmlValue = ComponentbuilderHelper::getBetween($field['settings']->xml, 'validate="', '"');
					if (ComponentbuilderHelper::checkString($xmlValue))
					{
						$xmlValue = ComponentbuilderHelper::safeString($xmlValue);
					}
				}
				elseif ($property['name'] === 'extension' || $property['name'] === 'directory' || $property['name'] === 'formsource')
				{
					// get value & replace the placeholders
					$xmlValue = $this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"'), $placeholders);
				}
				// catch all PHP here
				elseif (strpos($property['name'], 'type_php') !== false && $setCustom)
				{
					// set the line number
					$phpLine = (int) preg_replace('/[^0-9]/', '', $property['name']);
					// set the type key
					$phpKey = (string) trim( str_replace('type_', '', preg_replace('/[0-9]+/', '', $property['name'])), '_');
					// load the php for the custom field file
					$fieldAttributes['custom'][$phpKey][$phpLine] =
						$this->setDynamicValues(ComponentbuilderHelper::openValidBase64(
							ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"')
						));
					// load tracker
					$phpTracker['type_' . $phpKey] = $phpKey;
				}
				elseif ($property['name'] === 'prime_php' && $setCustom)
				{
					// load the php for the custom field file
					$fieldAttributes['custom']['prime_php'] = (int) ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"');
				}
				elseif ($property['name'] === 'extends' && $setCustom)
				{
					// load the class that is being extended
					$fieldAttributes['custom']['extends'] = ComponentbuilderHelper::getBetween($field['settings']->xml, 'extends="', '"');
				}
				elseif ($property['name'] === 'view' && $setCustom)
				{
					// load the view name & replace the placeholders
					$fieldAttributes['custom']['view'] = ComponentbuilderHelper::safeString($this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, 'view="', '"'), $placeholders));
				}
				elseif ($property['name'] === 'views' && $setCustom)
				{
					// load the views name & replace the placeholders
					$fieldAttributes['custom']['views'] = ComponentbuilderHelper::safeString($this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, 'views="', '"'), $placeholders));
				}
				elseif ($property['name'] === 'component' && $setCustom)
				{
					// load the component name & replace the placeholders
					$fieldAttributes['custom']['component'] = $this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, 'component="', '"'), $placeholders);
				}
				elseif ($property['name'] === 'table' && $setCustom)
				{
					// load the main table that is queried & replace the placeholders
					$fieldAttributes['custom']['table'] = $this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, 'table="', '"'), $placeholders);
				}
				elseif ($property['name'] === 'value_field' && $setCustom)
				{
					// load the text key
					$fieldAttributes['custom']['text'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'value_field="', '"'));
				}
				elseif ($property['name'] === 'key_field' && $setCustom)
				{
					// load the id key
					$fieldAttributes['custom']['id'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'key_field="', '"'));
				}
				elseif ($property['name'] === 'button' && $repeatable && $setCustom)
				{
					// dont load the button to repeatable
					$xmlValue = 'false';
					// do not add button
					$fieldAttributes['custom']['add_button'] = 'false';
				}
				elseif ($property['name'] === 'button' && $setCustom)
				{
					// load the button string value if found
					$xmlValue = (string) ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'button="', '"'));
					// add to custom values
					$fieldAttributes['custom']['add_button'] = (ComponentbuilderHelper::checkString($xmlValue) || 1 == $xmlValue) ? $xmlValue : 'false';
				}
				elseif ($property['name'] === 'required' && 'repeatable' === $typeName)
				{
					// dont load the required to repeatable field type
					$xmlValue = 'false';
				}
				elseif ($viewType == 2 && ($property['name'] === 'readonly' || $property['name'] === 'disabled'))
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
					$xmlValue = (string) ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"');
					// add the multipal
					if ('true' === $xmlValue)
					{
						$multiple = true;
					}
				}
				// make sure the name is added as a cless name for use in javascript
				elseif ($property['name'] === 'class' && ($typeName === 'note' || $typeName === 'spacer'))
				{
					$xmlValue = ComponentbuilderHelper::getBetween($field['settings']->xml, 'class="', '"');
					// add the type class
					if (ComponentbuilderHelper::checkString($xmlValue))
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
					$xmlValue = (string) $this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"'), $placeholders);
				}

				// check if translatable
				if (ComponentbuilderHelper::checkString($xmlValue) && isset($property['translatable']) && $property['translatable'] == 1)
				{
					// update label if field use multiple times
					if ($property['name'] === 'label')
					{
						if (isset($fieldAttributes['name']) && isset($this->uniqueNames[$view_name_list]['names'][$fieldAttributes['name']]))
						{
							$xmlValue .= ' (' . ComponentbuilderHelper::safeString($this->uniqueNames[$view_name_list]['names'][$fieldAttributes['name']]) . ')';
						}
					}
					// replace placeholders
					$xmlValue = $this->setPlaceholders($xmlValue, $placeholders);
					// insure custom lables dont get messed up
					if ($setCustom)
					{
						$customLabel = $xmlValue;
					}
					// set lang key
					$langValue = $langView . '_' . ComponentbuilderHelper::safeFieldName($name . ' ' . $property['name'], true);
					// add to lang array
					$this->setLangContent($this->lang, $langValue, $xmlValue);
					// use lang value
					$xmlValue = $langValue;
				}
				elseif (isset($field['alias']) && $field['alias'] && isset($property['translatable']) && $property['translatable'] == 1)
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
				elseif (isset($field['title']) && $field['title'] && isset($property['translatable']) && $property['translatable'] == 1)
				{
					if ($property['name'] === 'label')
					{
						$xmlValue = 'JGLOBAL_TITLE';
					}
					elseif ($property['name'] === 'description')
					{
						$xmlValue = 'JFIELD_TITLE_DESC';
					}
				}
				// only load value if found or is mandatory
				if (ComponentbuilderHelper::checkString($xmlValue) || (isset($property['mandatory']) && $property['mandatory'] == 1 && !$setCustom))
				{
					// make sure mantory fields are added
					if (!ComponentbuilderHelper::checkString($xmlValue))
					{
						if (isset($property['example']) && ComponentbuilderHelper::checkString($property['example']))
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
				elseif ($property['name'] === 'default' && ($xmlValidateValue = ComponentbuilderHelper::getBetween($field['settings']->xml, 'default="', '"', 'none-set')) !== 'none-set')
				{
					// we must allow empty defaults
					$fieldAttributes['default'] = $xmlValue;
				}
			}
			// check if all php is loaded using the tracker
			if (ComponentbuilderHelper::checkArray($phpTracker))
			{
				// litle search validation
				$confirmation = '8qvZHoyuFYQqpj0YQbc6F3o5DhBlmS-_-a8pmCZfOVSfANjkmV5LG8pCdAY2JNYu6cB';
				foreach ($phpTracker as $searchKey => $phpKey)
				{
					// we must search for more code in the xml just incase
					foreach(range(2, 30) as $phpLine)
					{
						$get_ = $searchKey . '_' . $phpLine;
						if (!isset($fieldAttributes['custom'][$phpKey][$phpLine]) && ($value = ComponentbuilderHelper::getValueFromXMLstring($field['settings']->xml, $get_, $confirmation)) !== $confirmation)
						{
							$fieldAttributes['custom'][$phpKey][$phpLine] = $this->setDynamicValues(ComponentbuilderHelper::openValidBase64($value));
						}
					}
				}
			}
			// do some nice twigs beyond the default
			if (isset($fieldAttributes['name']))
			{
				// check if we have class value for the list view of this field
				$listclass = ComponentbuilderHelper::getBetween($field['settings']->xml, 'listclass="', '"');
				if (ComponentbuilderHelper::checkString($listclass))
				{
					$this->listFieldClass[$view_name_list][$fieldAttributes['name']] = $listclass;
				}
				// check if we find reason to remove this field from being escaped
				$escaped = ComponentbuilderHelper::getBetween($field['settings']->xml, 'escape="', '"');
				if (ComponentbuilderHelper::checkString($escaped))
				{
					$this->doNotEscape[$view_name_list][] = $fieldAttributes['name'];
				}
				// check if we have display switch for dynamic placment
				$display = ComponentbuilderHelper::getBetween($field['settings']->xml, 'display="', '"');
				if (ComponentbuilderHelper::checkString($display))
				{
					$fieldAttributes['display'] = $display;
				}
				// make sure validation is set if found (even it not part of field properties)
				if (!isset($fieldAttributes['validate']))
				{
					// check if we have validate (validation rule set)
					$validationRule = ComponentbuilderHelper::getBetween($field['settings']->xml, 'validate="', '"');
					if (ComponentbuilderHelper::checkString($validationRule))
					{
						$fieldAttributes['validate'] = ComponentbuilderHelper::safeString($validationRule);
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
	 * @param   string   $langLabel         The language string for field label
	 * @param   string   $langView          The language string of the view
	 * @param   string   $view_name_single  The single view name
	 * @param   string   $view_name_list    The list view name
	 * @param   string   $name              The field name
	 * @param   array    $view              The view data
	 * @param   array    $field             The field data
	 * @param   string   $typeName          The field type
	 * @param   boolean  $multiple          The switch to set multiple selection option
	 * @param   boolean  $custom            The custom field switch
	 * @param   boolean  $options           The options switch
	 *
	 * @return  void
	 *
	 */
	public function setBuilders($langLabel, $langView, $view_name_single, $view_name_list, $name, $view, $field, $typeName, $multiple, $custom = false, $options = false)
	{
		// dbSwitch
		$dbSwitch = true;
		if (isset($field['list']) && $field['list'] == 2)
		{
			// do not add this field to the database
			$dbSwitch = false;
		}
		elseif ($typeName === 'tag')
		{
			// set tags for this view but don't load to DB
			$this->tagsBuilder[$view_name_single] = $view_name_single;
		}
		elseif (isset($field['settings']->datatype))
		{
			// insure default not none if number type
			$intKeys = array('INT', 'TINYINT', 'BIGINT', 'FLOAT', 'DECIMAL', 'DOUBLE');
			if (in_array($field['settings']->datatype, $intKeys))
			{
				if ($field['settings']->datadefault === 'Other')
				{
					if (!is_numeric($field['settings']->datadefault_other) || $field['settings']->datadefault_other !== '0000-00-00 00:00:00')
					{
						$field['settings']->datadefault_other = '0';
					}
				}
				elseif (!is_numeric($field['settings']->datadefault))
				{
					$field['settings']->datadefault = '0';
				}
			}
			// don't use these as index or uniqe keys
			$textKeys = array('TEXT', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT', 'BLOB', 'TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB');
			// build the query values
			$this->queryBuilder[$view_name_single][$name]['type'] = $field['settings']->datatype;
			if (!in_array($field['settings']->datatype, $textKeys))
			{
				$this->queryBuilder[$view_name_single][$name]['lenght'] = $field['settings']->datalenght;
				$this->queryBuilder[$view_name_single][$name]['lenght_other'] = $field['settings']->datalenght_other;
				$this->queryBuilder[$view_name_single][$name]['default'] = $field['settings']->datadefault;
				$this->queryBuilder[$view_name_single][$name]['other'] = $field['settings']->datadefault_other;
			}
			else
			{
				$this->queryBuilder[$view_name_single][$name]['default'] = 'EMPTY';
			}
			// to identify the field
			$this->queryBuilder[$view_name_single][$name]['ID'] = $field['settings']->id;
			$this->queryBuilder[$view_name_single][$name]['null_switch'] = $field['settings']->null_switch;
			// set index types
			if ($field['settings']->indexes == 1 && !in_array($field['settings']->datatype, $textKeys))
			{
				// build unique keys of this view for db
				$this->dbUniqueKeys[$view_name_single][] = $name;
			}
			elseif (($field['settings']->indexes == 2 || (isset($field['alias']) && $field['alias']) || (isset($field['title']) && $field['title']) || $typeName === 'category') && !in_array($field['settings']->datatype, $textKeys))
			{
				// build keys of this view for db
				$this->dbKeys[$view_name_single][] = $name;
			}
		}
		// set list switch
		$listSwitch = (isset($field['list']) && ($field['list'] == 1 || $field['list'] == 3 || $field['list'] == 4 ));
		// set list join
		$listJoin = (isset($this->listJoinBuilder[$view_name_list][(int) $field['field']]));
		// add history to this view
		if (isset($view['history']) && $view['history'])
		{
			$this->historyBuilder[$view_name_single] = $view_name_single;
		}
		// set Alias (only one title per view)
		if ($dbSwitch && isset($field['alias']) && $field['alias'] && !isset($this->aliasBuilder[$view_name_single]))
		{
			$this->aliasBuilder[$view_name_single] = $name;
		}
		// set Titles (only one title per view)
		if ($dbSwitch && isset($field['title']) && $field['title'] && !isset($this->titleBuilder[$view_name_single]))
		{
			$this->titleBuilder[$view_name_single] = $name;
		}
		// category name fix
		if ($typeName === 'category')
		{
			if (isset($this->catOtherName[$view_name_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$view_name_list]))
			{
				$tempName = $this->catOtherName[$view_name_list]['name'];
			}
			else
			{
				$tempName = $view_name_list . ' categories';
			}
			// set lang
			$listLangName = $langView . '_' . ComponentbuilderHelper::safeFieldName($tempName, true);
			// add to lang array
			$this->setLangContent($this->lang, $listLangName, ComponentbuilderHelper::safeString($tempName, 'W'));
		}
		else
		{
			// set lang (just incase)
			$listLangName = $langView . '_' .ComponentbuilderHelper::safeFieldName($name, true);
			// add to lang array
			$this->setLangContent($this->lang, $listLangName, ComponentbuilderHelper::safeString($name, 'W'));
			// if label was set use instead
			if (ComponentbuilderHelper::checkString($langLabel))
			{
				$listLangName = $langLabel;
			}
		}
		// build the list values
		if (($listSwitch || $listJoin) && $typeName != 'repeatable' && $typeName != 'subform')
		{
			// load to list builder
			if ($listSwitch)
			{
				$this->listBuilder[$view_name_list][] = array(
					'id' => (int) $field['field'],
					'type' => $typeName,
					'code' => $name,
					'lang' => $listLangName,
					'title' => (isset($field['title']) && $field['title']) ? true : false,
					'alias' => (isset($field['alias']) && $field['alias']) ? true : false,
					'link' => (isset($field['link']) && $field['link']) ? true : false,
					'sort' => (isset($field['sort']) && $field['sort']) ? true : false,
					'custom' => $custom,
					'multiple' => $multiple,
					'options' => $options,
					'target' => (int) $field['list']);
			}
			// build custom builder list
			if ($listSwitch || $listJoin)
			{
				$this->customBuilderList[$view_name_list][] = $name;
			}
		}
		// load the list join builder
		if ($listJoin)
		{
			$this->listJoinBuilder[$view_name_list][(int) $field['field']] = array(
				'type' => $typeName,
				'code' => $name,
				'lang' => $listLangName,
				'title' => (isset($field['title']) && $field['title']) ? true : false,
				'alias' => (isset($field['alias']) && $field['alias']) ? true : false,
				'link' => (isset($field['link']) && $field['link']) ? true : false,
				'sort' => (isset($field['sort']) && $field['sort']) ? true : false,
				'custom' => $custom,
				'multiple' => $multiple,
				'options' => $options);
		}
		// update the field relations
		if (isset($this->fieldRelations[$view_name_list]) && isset($this->fieldRelations[$view_name_list][(int) $field['field']]) 
			&& ComponentbuilderHelper::checkArray($this->fieldRelations[$view_name_list][(int) $field['field']]))
		{
			foreach ($this->fieldRelations[$view_name_list][(int) $field['field']] as $area => &$field_values)
			{
				$field_values['type'] = $typeName;
				$field_values['code'] = $name;
				$field_values['custom'] = $custom;
			}
		}
		// set the hidden field of this view
		if ($typeName === 'hidden')
		{
			if (!isset($this->hiddenFieldsBuilder[$view_name_single]))
			{
				$this->hiddenFieldsBuilder[$view_name_single] = '';
			}
			$this->hiddenFieldsBuilder[$view_name_single] .= ',"' . $name . '"';
		}
		// set all int fields of this view
		if ($dbSwitch && isset($field['settings']->datatype) && ($field['settings']->datatype === 'INT' || $field['settings']->datatype === 'TINYINT' || $field['settings']->datatype === 'BIGINT'))
		{
			if (!isset($this->intFieldsBuilder[$view_name_single]))
			{
				$this->intFieldsBuilder[$view_name_single] = '';
			}
			$this->intFieldsBuilder[$view_name_single] .= ',"' . $name . '"';
		}
		// set all dynamic field of this view
		if ($typeName != 'category' && $typeName != 'repeatable' && $typeName != 'subform' && !in_array($name, $this->defaultFields))
		{
			if (!isset($this->dynamicfieldsBuilder[$view_name_single]))
			{
				$this->dynamicfieldsBuilder[$view_name_single] = '';
			}
			if (isset($this->dynamicfieldsBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->dynamicfieldsBuilder[$view_name_single]))
			{
				$this->dynamicfieldsBuilder[$view_name_single] .= ',"' . $name . '":"' . $name . '"';
			}
			else
			{
				$this->dynamicfieldsBuilder[$view_name_single] .= '"' . $name . '":"' . $name . '"';
			}
		}
		// TODO we may need to add a switch instead (since now it uses the first editor field)
		// set the main(biggest) text field of this view
		if ($dbSwitch && $typeName === 'editor')
		{
			if (!isset($this->maintextBuilder[$view_name_single]) || !ComponentbuilderHelper::checkString($this->maintextBuilder[$view_name_single]))
			{
				$this->maintextBuilder[$view_name_single] = $name;
			}
		}
		// set the custom builder
		if (ComponentbuilderHelper::checkArray($custom) && $typeName != 'category' && $typeName != 'repeatable' && $typeName != 'subform')
		{
			$this->customBuilder[$view_name_list][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom, 'method' => $field['settings']->store);
			// set the custom fields needed in content type data
			if (!isset($this->customFieldLinksBuilder[$view_name_single]))
			{
				$this->customFieldLinksBuilder[$view_name_single] = '';
			}
			// only load this if table is set
			if (isset($custom['table']) && ComponentbuilderHelper::checkString($custom['table']))
			{
				$this->customFieldLinksBuilder[$view_name_single] .= ',{"sourceColumn": "' . $name . '","targetTable": "' . $custom['table'] . '","targetColumn": "' . $custom['id'] . '","displayColumn": "' . $custom['text'] . '"}';
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
		// setup gategory for this view
		if ($dbSwitch && $typeName === 'category')
		{
			if (isset($this->catOtherName[$view_name_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$view_name_list]))
			{
				$otherViews = $this->catOtherName[$view_name_list]['views'];
				$otherView = $this->catOtherName[$view_name_list]['view'];
			}
			else
			{
				$otherViews = $view_name_list;
				$otherView = $view_name_single;
			}
			// get the xml extension name
			$_extension = $this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, 'extension="', '"'), $this->placeholders);
			// if they left out the extention for some reason
			if (!ComponentbuilderHelper::checkString($_extension))
			{
				$_extension = 'com_' . $this->componentCodeName . '.' . $otherView;
			}
			// load the category builder
			$this->categoryBuilder[$view_name_list] = array('code' => $name, 'name' => $listLangName, 'extension' => $_extension);
			// also set code name for title alias fix
			$this->catCodeBuilder[$view_name_single] = array('code' => $name, 'views' => $otherViews, 'view' => $otherView);
		}
		// setup checkbox for this view
		if ($dbSwitch && ($typeName === 'checkbox' || (ComponentbuilderHelper::checkArray($custom) && isset($custom['extends']) && $custom['extends'] === 'checkboxes')))
		{
			$this->checkboxBuilder[$view_name_single][] = $name;
		}
		// setup checkboxes and other json items for this view
		if ($dbSwitch && (($typeName === 'subform' || $typeName === 'checkboxes' || $multiple || $field['settings']->store != 0) && $typeName != 'tag'))
		{
			$subformJsonSwitch = true;
			switch ($field['settings']->store)
			{
				case 1:
					// JSON_STRING_ENCODE
					$this->jsonStringBuilder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'json', $typeName);
					break;
				case 2:
					// BASE_SIXTY_FOUR
					$this->base64Builder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'base64', $typeName);
					break;
				case 3:
					// BASIC_ENCRYPTION_LOCALKEY
					$this->basicFieldModeling[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'basic_encryption', $typeName);
					break;
				case 4:
					// WHMCS_ENCRYPTION_VDMKEY
					$this->whmcsFieldModeling[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'whmcs_encryption', $typeName);
					break;
				case 5:
					// MEDIUM_ENCRYPTION_LOCALFILE
					$this->mediumFieldModeling[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'medium_encryption', $typeName);
					break;
				case 6:
					// EXPERT_MODE
					if(isset($field['settings']->model_field))
					{
						if (isset($field['settings']->initiator_save_key))
						{
							$this->expertFieldModelInitiator[$view_name_single]['save'][$field['settings']->initiator_save_key]
								= $field['settings']->initiator_save;
						}
						if (isset($field['settings']->initiator_get_key))
						{
							$this->expertFieldModelInitiator[$view_name_single]['get'][$field['settings']->initiator_get_key]
								= $field['settings']->initiator_get;
						}
						$this->expertFieldModeling[$view_name_single][$name] = $field['settings']->model_field;
						// Site settings of each field if needed
						$this->buildSiteFieldData($view_name_single, $name, 'expert_mode', $typeName);
					}
					break;
				default:
					// JSON_ARRAY_ENCODE
					$this->jsonItemBuilder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'json', $typeName);
					// no londer add the json again (already added)
					$subformJsonSwitch = false;
					break;
			}
			// just a heads-up for usergroups set to multiple
			if ($typeName === 'usergroup')
			{
				$this->buildSiteFieldData($view_name_single, $name, 'json', $typeName);
			}

			// load the model list display fix
			if (($listSwitch || $listJoin) && (($typeName != 'repeatable' && $typeName != 'subform') || $field['settings']->store == 6))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					$this->getItemsMethodListStringFixBuilder[$view_name_single][] = array('name' => $name, 'type' => $typeName, 'translation' => true, 'custom' => $custom, 'method' => $field['settings']->store);
				}
				else
				{
					$this->getItemsMethodListStringFixBuilder[$view_name_single][] = array('name' => $name, 'type' => $typeName, 'translation' => false, 'custom' => $custom, 'method' => $field['settings']->store);
				}
			}

			// subform house keeping
			if ('subform' === $typeName)
			{
				// the values must revert to array
				$this->jsonItemBuilderArray[$view_name_single][] = $name;
				// should the json builder still be added
				if ($subformJsonSwitch)
				{
					// and insure the if is converted to json
					$this->jsonItemBuilder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'json', $typeName);
				}
			}
		}
		// build the data for the export & import methods $typeName === 'repeatable' ||
		if ($dbSwitch && (($typeName === 'checkboxes' || $multiple || $field['settings']->store != 0) && !ComponentbuilderHelper::checkArray($options)))
		{
			$this->getItemsMethodEximportStringFixBuilder[$view_name_single][] = array('name' => $name, 'type' => $typeName, 'translation' => false, 'custom' => $custom, 'method' => $field['settings']->store);
		}
		// check if field should be added to uikit
		$this->buildSiteFieldData($view_name_single, $name, 'uikit', $typeName);
		// load the selection translation fix
		if (ComponentbuilderHelper::checkArray($options) && ($listSwitch || $listJoin) && $typeName != 'repeatable' && $typeName != 'subform')
		{
			$this->selectionTranslationFixBuilder[$view_name_list][$name] = $options;
		}
		// build the sort values
		if ($dbSwitch && (isset($field['sort']) && $field['sort'] == 1) && ($listSwitch || $listJoin) && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable' && $typeName != 'subform'))
		{
			$this->sortBuilder[$view_name_list][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom, 'options' => $options);
		}
		// build the search values
		if ($dbSwitch && isset($field['search']) && $field['search'] == 1)
		{
			$_list = (isset($field['list'])) ? $field['list'] : 0;
			$this->searchBuilder[$view_name_list][] = array('type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $_list);
		}
		// build the filter values
		if ($dbSwitch && (isset($field['filter']) && $field['filter'] == 1) && ($listSwitch || $listJoin) && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable' && $typeName != 'subform'))
		{
			$this->filterBuilder[$view_name_list][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'database' => $view_name_single, 'function' => ComponentbuilderHelper::safeString($name, 'F'), 'custom' => $custom, 'options' => $options);
		}

		// build the layout
		$tabName = '';
		if (isset($view['settings']->tabs) && isset($view['settings']->tabs[(int) $field['tab']]))
		{
			$tabName = $view['settings']->tabs[(int) $field['tab']];
		}
		elseif ((int) $field['tab'] == 15)
		{
			// set to publishing tab
			$tabName = 'publishing';
		}
		$this->setLayoutBuilder($view_name_single, $tabName, $name, $field);
	}

	/**
	 * set Custom Field Type File
	 *
	 * @param   array   $data              The field complete data set
	 * @param   string  $view_name_list    The list view code name
	 * @param   string  $view_name_single  The single view code name
	 *
	 * @return  void
	 *
	 */
	public function setCustomFieldTypeFile($data, $view_name_list, $view_name_single)
	{
		// make sure it is not already been build or if it is prime
		if (isset($data['custom']) && isset($data['custom']['extends']) && ((isset($data['custom']['prime_php']) && $data['custom']['prime_php'] == 1) || !isset($this->fileContentDynamic['customfield_' . $data['type']]) || !ComponentbuilderHelper::checkArray($this->fileContentDynamic['customfield_' . $data['type']])))
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
				$data['type'] = implode('', $dotTypeArray);
				$data['custom']['type'] = $data['type'];
			}
			// set tab and break replacements
			$tabBreak = array(
				'\t' => $this->_t(1),
				'\n' => PHP_EOL
			);
			// set the [[[PLACEHOLDER]]] options
			$replace = array(
				$this->bbb . 'JPREFIX' . $this->ddd => $jprefix,
				$this->bbb . 'TABLE' . $this->ddd => $data['custom']['table'],
				$this->bbb . 'ID' . $this->ddd => $data['custom']['id'],
				$this->bbb . 'TEXT' . $this->ddd => $data['custom']['text'],
				$this->bbb . 'CODE_TEXT' . $this->ddd => $data['code'] . '_' . $data['custom']['text'],
				$this->bbb . 'CODE' . $this->ddd => $data['code'],
				$this->bbb . 'view_type' . $this->ddd => $view_name_single . '_' . $data['type'],
				$this->bbb . 'type' . $this->ddd => $data['type'],
				$this->bbb . 'com_component' . $this->ddd => (isset($data['custom']['component']) && ComponentbuilderHelper::checkString($data['custom']['component'])) ? ComponentbuilderHelper::safeString($data['custom']['component']) : 'com_' . $this->componentCodeName,
				// set the generic values
				$this->bbb . 'component' . $this->ddd => $this->componentCodeName,
				$this->bbb . 'Component' . $this->ddd => $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh],
				$this->bbb . 'view' . $this->ddd => (isset($data['custom']['view']) && ComponentbuilderHelper::checkString($data['custom']['view'])) ? ComponentbuilderHelper::safeString($data['custom']['view']) : $view_name_single,
				$this->bbb . 'views' . $this->ddd => (isset($data['custom']['views']) && ComponentbuilderHelper::checkString($data['custom']['views'])) ? ComponentbuilderHelper::safeString($data['custom']['views']) : $view_name_list
			);
			// now set the ###PLACEHOLDER### options
			foreach ($replace as $replacekey => $replacevalue)
			{
				// update the key value
				$replacekey = str_replace(array($this->bbb, $this->ddd), array($this->hhh, $this->hhh), $replacekey);
				// now set the value
				$replace[$replacekey] = $replacevalue;
			}
			// load the global placeholders
			if (ComponentbuilderHelper::checkArray($this->globalPlaceholders))
			{
				foreach ($this->globalPlaceholders as $globalPlaceholder => $gloabalValue)
				{
					$replace[$globalPlaceholder] = $gloabalValue;
				}
			}
			// start loading the field type
			$this->fileContentDynamic['customfield_' . $data['type']] = array();
			// JPREFIX <<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JPREFIX' . $this->hhh] = $jprefix;
			// Type <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'Type' . $this->hhh] = ComponentbuilderHelper::safeString($data['custom']['type'], 'F');
			// type <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'type' . $this->hhh] = ComponentbuilderHelper::safeString($data['custom']['type']);
			// is this a own custom field
			if (isset($data['custom']['own_custom']))
			{
				// make sure the button option notice is set to notify the developer that the button option is not available in own custom field types
				if (isset($data['custom']['add_button']) && ($data['custom']['add_button'] === 'true' || 1 == $data['custom']['add_button']))
				{
					// set error
					$this->app->enqueueMessage(JText::_('<hr /><h3>Dynamic Button Error</h3>'), 'Error');
					$this->app->enqueueMessage(JText::_('The option to add a dynamic button is not available in <b>own custom field types</b>, you will have to custom code it.'), 'Error');
				}
				// load another file
				$target = array('admin' => 'customfield');
				$this->buildDynamique($target, 'fieldcustom', $data['custom']['type']);
				// JFORM_extens <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JFORM_extends' . $this->hhh] = ComponentbuilderHelper::safeString($data['custom']['extends']);
				// JFORM_EXTENDS <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JFORM_EXTENDS' . $this->hhh] = ComponentbuilderHelper::safeString($data['custom']['extends'], 'F');
				// JFORM_TYPE_PHP <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JFORM_TYPE_PHP' . $this->hhh] = PHP_EOL . PHP_EOL . $this->_t(1) . "//" . $this->setLine(__LINE__) . " A " . $data['custom']['own_custom'] . " Field";
				// load the other PHP options
				foreach (ComponentbuilderHelper::$phpFieldArray as $x)
				{
					// reset the php bucket
					$phpBucket = '';
					// only set if avaliable
					if (isset($data['custom']['php' . $x]) && ComponentbuilderHelper::checkArray($data['custom']['php' . $x]))
					{
						foreach ($data['custom']['php' . $x] as $line => $code)
						{
							if (ComponentbuilderHelper::checkString($code))
							{
								$phpBucket .= PHP_EOL . $this->setPlaceholders($code, $tabBreak);
							}
						}
						// JFORM_TYPE_PHP <<<DYNAMIC>>>
						$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JFORM_TYPE_PHP' . $this->hhh] .= PHP_EOL . $this->setPlaceholders($phpBucket, $replace);
					}
				}
			}
			else
			{
				// first build the custom field type file
				$target = array('admin' => 'customfield');
				$this->buildDynamique($target, 'field' . $data['custom']['extends'], $data['custom']['type']);
				// make sure the value is reset
				$phpCode = '';
				// now load the php script
				if (isset($data['custom']['php']) && ComponentbuilderHelper::checkArray($data['custom']['php']))
				{
					foreach ($data['custom']['php'] as $line => $code)
					{
						if (ComponentbuilderHelper::checkString($code))
						{
							if ($line == 1)
							{
								$phpCode .= $this->setPlaceholders($code, $tabBreak);
							}
							else
							{
								$phpCode .= PHP_EOL . $this->_t(2) . $this->setPlaceholders($code, $tabBreak);
							}
						}
					}
					// replace the placholders
					$phpCode = $this->setPlaceholders($phpCode, $replace);
				}
				// catch empty stuff
				if (!ComponentbuilderHelper::checkString($phpCode))
				{
					$phpCode = 'return null;';
				}
				// some house cleaning for users
				if ($data['custom']['extends'] === 'user')
				{
					// make sure the value is reset
					$phpxCode = '';
					// now load the php xclude script
					if (ComponentbuilderHelper::checkArray($data['custom']['phpx']))
					{
						foreach ($data['custom']['phpx'] as $line => $code)
						{
							if (ComponentbuilderHelper::checkString($code))
							{
								if ($line == 1)
								{
									$phpxCode .= $this->setPlaceholders($code, $tabBreak);
								}
								else
								{
									$phpxCode .= PHP_EOL . $this->_t(2) . $this->setPlaceholders($code, $tabBreak);
								}
							}
						}
						// replace the placholders
						$phpxCode = $this->setPlaceholders($phpxCode, $replace);
					}
					// catch empty stuff
					if (!ComponentbuilderHelper::checkString($phpxCode))
					{
						$phpxCode = 'return null;';
					}
					// temp holder for name
					$tempName = $data['custom']['label'] . ' Group';
					// set lang
					$groupLangName = $this->langPrefix . '_' . ComponentbuilderHelper::safeFieldName($tempName, true);
					// add to lang array
					$this->setLangContent($this->lang, $groupLangName, ComponentbuilderHelper::safeString($tempName, 'W'));
					// build the Group Control
					$this->setGroupControl[$data['type']] = $groupLangName;
					// JFORM_GETGROUPS_PHP <<<DYNAMIC>>>
					$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JFORM_GETGROUPS_PHP' . $this->hhh] = $phpCode;
					// JFORM_GETEXCLUDED_PHP <<<DYNAMIC>>>
					$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JFORM_GETEXCLUDED_PHP' . $this->hhh] = $phpxCode;
				}
				else
				{
					// JFORM_GETOPTIONS_PHP <<<DYNAMIC>>>
					$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'JFORM_GETOPTIONS_PHP' . $this->hhh] = $phpCode;
				}
				// type <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_' . $data['type']][$this->hhh . 'ADD_BUTTON' . $this->hhh] = $this->setAddButtonToListField($data['custom']);
			}
		}
		// if this field gets used in plugin or module we should track it so if needed we can copy it over
		if (strpos($view_name_single, 'P|uG!n') !== false &&
			isset($data['custom']) && isset($data['custom']['type']))
		{
			$this->extentionCustomfields[$data['type']] = $data['custom']['type'];
		}
	}

	/**
	 * set Add Button To List Field (getInput tweak)
	 *
	 * @param   array  $fieldData   The field custom data
	 *
	 * @return  string of getInput class on success empty string otherwise
	 *
	 */
	protected function setAddButtonToListField($fieldData)
	{
		// make sure hte view values are set
		if (isset($fieldData['add_button']) && ($fieldData['add_button'] === 'true' || 1 == $fieldData['add_button']) &&
			isset($fieldData['view']) && isset($fieldData['views']) &&
			ComponentbuilderHelper::checkString($fieldData['view']) && ComponentbuilderHelper::checkString($fieldData['views']))
		{
			// set local component
			$local_component = "com_" . $this->componentCodeName;
			// check that the component value is set
			if (!isset($fieldData['component']) || !ComponentbuilderHelper::checkString($fieldData['component']))
			{
				$fieldData['component'] = $local_component;
			}
			// check that the componet has the com_ value in it
			if (strpos($fieldData['component'], 'com_') === false || strpos($fieldData['component'], '=') !== false)
			{
				$fieldData['component'] = "com_" . $fieldData['component'];
			}
			// make sure the component is update if # # # or [ [ [ component placeholder is used
			if (strpos($fieldData['component'], $this->hhh) !== false || strpos($fieldData['component'], $this->bbb) !== false) // should not be needed... but
			{
				$fieldData['component'] = $this->setPlaceholders($fieldData['component'], $this->placeholders);
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
			$addButton = array();
			$addButton[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$addButton[] = $this->_t(1) . " * Override to add new button";
			$addButton[] = $this->_t(1) . " *";
			$addButton[] = $this->_t(1) . " * @return  string  The field input markup.";
			$addButton[] = $this->_t(1) . " *";
			$addButton[] = $this->_t(1) . " * @since   3.2";
			$addButton[] = $this->_t(1) . " */";
			$addButton[] = $this->_t(1) . "protected function getInput()";
			$addButton[] = $this->_t(1) . "{";
			$addButton[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " see if we should add buttons";
			$addButton[] = $this->_t(2) . "\$set_button = \$this->getAttribute('button');";
			$addButton[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get html";
			$addButton[] = $this->_t(2) . "\$html = parent::getInput();";
			$addButton[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " if true set button";
			$addButton[] = $this->_t(2) . "if (\$set_button === 'true')";
			$addButton[] = $this->_t(2) . "{";
			$addButton[] = $this->_t(3) . "\$button = array();";
			$addButton[] = $this->_t(3) . "\$script = array();";
			$addButton[] = $this->_t(3) . "\$button_code_name = \$this->getAttribute('name');";
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get the input from url";
			$addButton[] = $this->_t(3) . "\$app = JFactory::getApplication();";
			$addButton[] = $this->_t(3) . "\$jinput = \$app->input;";
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get the view name & id";
			$addButton[] = $this->_t(3) . "\$values = \$jinput->getArray(array(";
			$addButton[] = $this->_t(4) . "'id' => 'int',";
			$addButton[] = $this->_t(4) . "'view' => 'word'";
			$addButton[] = $this->_t(3) . "));";
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " check if new item";
			$addButton[] = $this->_t(3) . "\$ref = '';";
			$addButton[] = $this->_t(3) . "\$refJ = '';";
			if ($refLoad)
			{
				$addButton[] = $this->_t(3) . "if (!is_null(\$values['id']) && strlen(\$values['view']))";
				$addButton[] = $this->_t(3) . "{";
				$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " only load referral if not new item.";
				$addButton[] = $this->_t(4) . "\$ref = '&amp;ref=' . \$values['view'] . '&amp;refid=' . \$values['id'];";
				$addButton[] = $this->_t(4) . "\$refJ = '&ref=' . \$values['view'] . '&refid=' . \$values['id'];";
				$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " get the return value.";
				$addButton[] = $this->_t(4) . "\$_uri = (string) JUri::getInstance();";
				$addButton[] = $this->_t(4) . "\$_return = urlencode(base64_encode(\$_uri));";
				$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " load return value.";
				$addButton[] = $this->_t(4) . "\$ref .= '&amp;return=' . \$_return;";
				$addButton[] = $this->_t(4) . "\$refJ .= '&return=' . \$_return;";
				$addButton[] = $this->_t(3) . "}";
			}
			else
			{
				$addButton[] = $this->_t(3) . "if (!is_null(\$values['id']) && strlen(\$values['view']))";
				$addButton[] = $this->_t(3) . "{";
				$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " only load field details if not new item.";
				$addButton[] = $this->_t(4) . "\$ref = '&amp;field=' . \$values['view'] . '&amp;field_id=' . \$values['id'];";
				$addButton[] = $this->_t(4) . "\$refJ = '&field=' . \$values['view'] . '&field_id=' . \$values['id'];";
				$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " get the return value.";
				$addButton[] = $this->_t(4) . "\$_uri = (string) JUri::getInstance();";
				$addButton[] = $this->_t(4) . "\$_return = urlencode(base64_encode(\$_uri));";
				$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " load return value.";
				$addButton[] = $this->_t(4) . "\$ref = '&amp;return=' . \$_return;";
				$addButton[] = $this->_t(4) . "\$refJ = '&return=' . \$_return;";
				$addButton[] = $this->_t(3) . "}";
			}
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get button label";
			$addButton[] = $this->_t(3) . "\$button_label = trim(\$button_code_name);";
			$addButton[] = $this->_t(3) . "\$button_label = preg_replace('/_+/', ' ', \$button_label);";
			$addButton[] = $this->_t(3) . "\$button_label = preg_replace('/\s+/', ' ', \$button_label);";
			$addButton[] = $this->_t(3) . "\$button_label = preg_replace(\"/[^A-Za-z ]/\", '', \$button_label);";
			$addButton[] = $this->_t(3) . "\$button_label = ucfirst(strtolower(\$button_label));";
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get user object";
			$addButton[] = $this->_t(3) . "\$user = JFactory::getUser();";
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " only add if user allowed to create " . $fieldData['view'];
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($fieldData['view'], $this->permissionBuilder['global'][$core['core.create']]))
			{
				$addButton[] = $this->_t(3) . "if (\$user->authorise('" . $core['core.create'] . "', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			else
			{
				$addButton[] = $this->_t(3) . "if (\$user->authorise('core.create', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			$addButton[] = $this->_t(3) . "{";
			$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " build Create button";
			$addButton[] = $this->_t(4) . "\$button[] = '<a id=\"'.\$button_code_name.'Create\" class=\"btn btn-small btn-success hasTooltip\" title=\"'.JText:" . ":sprintf('" . $this->langPrefix . "_CREATE_NEW_S', \$button_label).'\" style=\"border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;\"";
			$addButton[] = $this->_t(5) . "href=\"index.php?option=" . $fieldData['component'] . "&amp;view=" . $fieldData['view'] . "&amp;layout=edit'.\$ref.'\" >";
			$addButton[] = $this->_t(5) . "<span class=\"icon-new icon-white\"></span></a>';";
			$addButton[] = $this->_t(3) . "}";
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " only add if user allowed to edit " . $fieldData['view'];
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($fieldData['view'], $this->permissionBuilder['global'][$core['core.edit']]))
			{
				$addButton[] = $this->_t(3) . "if (\$user->authorise('" . $core['core.edit'] . "', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			else
			{
				$addButton[] = $this->_t(3) . "if (\$user->authorise('core.edit', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			$addButton[] = $this->_t(3) . "{";
			$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " build edit button";
			$addButton[] = $this->_t(4) . "\$button[] = '<a id=\"'.\$button_code_name.'Edit\" class=\"btn btn-small hasTooltip\" title=\"'.JText:" . ":sprintf('" . $this->langPrefix . "_EDIT_S', \$button_label).'\" style=\"display: none; padding: 4px 4px 4px 7px;\" href=\"#\" >";
			$addButton[] = $this->_t(5) . "<span class=\"icon-edit\"></span></a>';";
			$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " build script";
			$addButton[] = $this->_t(4) . "\$script[] = \"";
			$addButton[] = $this->_t(5) . "jQuery(document).ready(function() {";
			$addButton[] = $this->_t(6) . "jQuery('#adminForm').on('change', '#jform_\".\$button_code_name.\"',function (e) {";
			$addButton[] = $this->_t(7) . "e.preventDefault();";
			$addButton[] = $this->_t(7) . "var \".\$button_code_name.\"Value = jQuery('#jform_\".\$button_code_name.\"').val();";
			$addButton[] = $this->_t(7) . "\".\$button_code_name.\"Button(\".\$button_code_name.\"Value);";
			$addButton[] = $this->_t(6) . "});";
			$addButton[] = $this->_t(6) . "var \".\$button_code_name.\"Value = jQuery('#jform_\".\$button_code_name.\"').val();";
			$addButton[] = $this->_t(6) . "\".\$button_code_name.\"Button(\".\$button_code_name.\"Value);";
			$addButton[] = $this->_t(5) . "});";
			$addButton[] = $this->_t(5) . "function \".\$button_code_name.\"Button(value) {";
			$addButton[] = $this->_t(6) . "if (value > 0) {"; // TODO not ideal since value may not be an (int)
			$addButton[] = $this->_t(7) . "// hide the create button";
			$addButton[] = $this->_t(7) . "jQuery('#\".\$button_code_name.\"Create').hide();";
			$addButton[] = $this->_t(7) . "// show edit button";
			$addButton[] = $this->_t(7) . "jQuery('#\".\$button_code_name.\"Edit').show();";
			$addButton[] = $this->_t(7) . "var url = 'index.php?option=" . $fieldData['component'] . "&view=" . $fieldData['views'] . "&task=" . $fieldData['view'] . ".edit&id='+value+'\".\$refJ.\"';"; // TODO this value may not be the ID
			$addButton[] = $this->_t(7) . "jQuery('#\".\$button_code_name.\"Edit').attr('href', url);";
			$addButton[] = $this->_t(6) . "} else {";
			$addButton[] = $this->_t(7) . "// show the create button";
			$addButton[] = $this->_t(7) . "jQuery('#\".\$button_code_name.\"Create').show();";
			$addButton[] = $this->_t(7) . "// hide edit button";
			$addButton[] = $this->_t(7) . "jQuery('#\".\$button_code_name.\"Edit').hide();";
			$addButton[] = $this->_t(6) . "}";
			$addButton[] = $this->_t(5) . "}\";";
			$addButton[] = $this->_t(3) . "}";
			$addButton[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " check if button was created for " . $fieldData['view'] . " field.";
			$addButton[] = $this->_t(3) . "if (is_array(\$button) && count(\$button) > 0)";
			$addButton[] = $this->_t(3) . "{";
			$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Load the needed script.";
			$addButton[] = $this->_t(4) . "\$document = JFactory::getDocument();";
			$addButton[] = $this->_t(4) . "\$document->addScriptDeclaration(implode(' ',\$script));";
			$addButton[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " return the button attached to input field.";
			$addButton[] = $this->_t(4) . "return '<div class=\"input-append\">' .\$html . implode('',\$button).'</div>';";
			$addButton[] = $this->_t(3) . "}";
			$addButton[] = $this->_t(2) . "}";
			$addButton[] = $this->_t(2) . "return \$html;";
			$addButton[] = $this->_t(1) . "}";

			return implode(PHP_EOL, $addButton);
		}
		return '';
	}

	/**
	 * xmlPrettyPrint
	 *
	 * @param   SimpleXMLElement   $xml The XML element containing a node to be output
	 * @param   string  $nodename node name of the input xml element to print out.  this is done to omit the <?xml... tag
	 *
	 * @return  string XML output
	 *
	 */
	public function xmlPrettyPrint($xml, $nodename)
	{
		$dom = dom_import_simplexml($xml)->ownerDocument;
		$dom->formatOutput = true;
		$xmlString = $dom->saveXML($dom->getElementsByTagName($nodename)->item(0));
		// make sure Tidy is enabled
		if ($this->tidy)
		{
			$tidy = new Tidy();
			$tidy->parseString($xmlString, array('indent' => true, 'indent-spaces' => 8, 'input-xml' => true, 'output-xml' => true, 'indent-attributes' => true, 'wrap-attributes' => true, 'wrap' => false));
			$tidy->cleanRepair();
			return $this->xmlIndent((string) $tidy, ' ', 8, true, false);
		}
		// set tidy waring atleast once
		elseif (!$this->setTidyWarning)
		{
			// set the warning only once
			$this->setTidyWarning = true;
			// now set the warning
			$this->app->enqueueMessage(JText::_('<hr /><h3>Tidy Error</h3>'), 'Error');
			$this->app->enqueueMessage(JText::_('You must enable the <b>Tidy</b> extension in your php.ini file so we can tidy up your xml! If you need help please <a href="https://github.com/vdm-io/Joomla-Component-Builder/issues/197#issuecomment-351181754" target="_blank">start here</a>!'), 'Error');
		}
		return $xmlString;
	}

	/**
	 * xmlIndent
	 *
	 * @param   string  $string The XML input
	 * @param   string  $char  Character or characters to use as the repeated indent
	 * @param   integer $depth number of times to repeat the indent character
	 * @param   boolean $skipfirst Skip the first line of the input.
	 * @param   boolean $skiplast Skip the last line of the input;
	 *
	 * @return  string XML output
	 *
	 */
	public function xmlIndent($string, $char = ' ', $depth = 0, $skipfirst = false, $skiplast = false)
	{
		$output = array();
		$lines = explode("\n", $string);
		$first = true;
		$last = count($lines) - 1;
		foreach ($lines as $i => $line)
		{
			$output[] = (($first && $skipfirst) || $i === $last && $skiplast) ? $line : str_repeat($char, $depth) . $line;
			$first = false;
		}
		return implode("\n", $output);
	}

}
