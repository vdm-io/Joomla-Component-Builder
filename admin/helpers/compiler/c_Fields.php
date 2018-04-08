<?php

/* --------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
  __      __       _     _____                 _                                  _     __  __      _   _               _
  \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
   \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
    \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
     \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
      \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                      | |
                                                      |_|
  /-------------------------------------------------------------------------------------------------------------------------------/

  @version		2.6.x
  @created		30th April, 2015
  @package		Component Builder
  @subpackage	compiler.php
  @author		Llewellyn van der Merwe <http://www.vdm.io>
  @my wife		Roline van der Merwe <http://www.vdm.io/>
  @copyright	Copyright (C) 2015. All Rights Reserved
  @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html

  Builds Complex Joomla Components

  /----------------------------------------------------------------------------------------------------------------------------- */

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
	 * Basic Encryption Builder
	 * 
	 * @var    array
	 */
	public $basicEncryptionBuilder = array();

	/**
	 * WHMCS Encryption Builder
	 * 
	 * @var    array
	 */
	public $whmcsEncryptionBuilder = array();

	/**
	 * Medium Encryption Builder
	 * 
	 * @var    array
	 */
	public $mediumEncryptionBuilder = array();

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
	 * Default Fields
	 * 
	 * @var    array
	 */
	public $defaultFields = array('created', 'created_by', 'modified', 'modified_by', 'published', 'ordering', 'access', 'version', 'hits', 'id');

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
			$langView = $this->langPrefix . '_' . $this->placeholders['###VIEW###'];
			$langViews = $this->langPrefix . '_' . $this->placeholders['###VIEWS###'];
			// set default lang
			$this->langContent[$this->lang][$langView] = $view['settings']->name_single;
			$this->langContent[$this->lang][$langViews] = $view['settings']->name_list;
			// set global item strings
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_ARCHIVED'] = "%s " . $view['settings']->name_list . " archived.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_ARCHIVED_1'] = "%s " . $view['settings']->name_single . " archived.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_CHECKED_IN_0'] = "No " . $view['settings']->name_single . " successfully checked in.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_CHECKED_IN_1'] = "%d " . $view['settings']->name_single . " successfully checked in.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_CHECKED_IN_MORE'] = "%d " . $view['settings']->name_list . " successfully checked in.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_DELETED'] = "%s " . $view['settings']->name_list . " deleted.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_DELETED_1'] = "%s " . $view['settings']->name_single . " deleted.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_FEATURED'] = "%s " . $view['settings']->name_list . " featured.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_FEATURED_1'] = "%s " . $view['settings']->name_single . " featured.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_PUBLISHED'] = "%s " . $view['settings']->name_list . " published.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_PUBLISHED_1'] = "%s " . $view['settings']->name_single . " published.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_TRASHED'] = "%s " . $view['settings']->name_list . " trashed.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_TRASHED_1'] = "%s " . $view['settings']->name_single . " trashed.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_UNFEATURED'] = "%s " . $view['settings']->name_list . " unfeatured.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_UNFEATURED_1'] = "%s " . $view['settings']->name_single . " unfeatured.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_UNPUBLISHED'] = "%s " . $view['settings']->name_list . " unpublished.";
			$this->langContent[$this->lang][$langViews . '_N_ITEMS_UNPUBLISHED_1'] = "%s " . $view['settings']->name_single . " unpublished.";
			$this->langContent[$this->lang][$langViews . '_BATCH_OPTIONS'] = "Batch process the selected " . $view['settings']->name_list;
			$this->langContent[$this->lang][$langViews . '_BATCH_TIP'] = "All changes will be applied to all selected " . $view['settings']->name_list;
			// set some basic defaults
			$this->langContent[$this->lang][$langView . '_ERROR_UNIQUE_ALIAS'] = "Another " . $view['settings']->name_single . " has the same alias.";
			$this->langContent[$this->lang][$langView . '_CREATED_DATE_LABEL'] = "Created Date";
			$this->langContent[$this->lang][$langView . '_CREATED_DATE_DESC'] = "The date this " . $view['settings']->name_single . " was created.";
			$this->langContent[$this->lang][$langView . '_MODIFIED_DATE_LABEL'] = "Modified Date";
			$this->langContent[$this->lang][$langView . '_MODIFIED_DATE_DESC'] = "The date this " . $view['settings']->name_single . " was modified.";
			$this->langContent[$this->lang][$langView . '_CREATED_BY_LABEL'] = "Created By";
			$this->langContent[$this->lang][$langView . '_CREATED_BY_DESC'] = "The user that created this " . $view['settings']->name_single . ".";
			$this->langContent[$this->lang][$langView . '_MODIFIED_BY_LABEL'] = "Modified By";
			$this->langContent[$this->lang][$langView . '_MODIFIED_BY_DESC'] = "The last user that modified this " . $view['settings']->name_single . ".";
			$this->langContent[$this->lang][$langView . '_ORDERING_LABEL'] = "Ordering";
			$this->langContent[$this->lang][$langView . '_VERSION_LABEL'] = "Revision";
			$this->langContent[$this->lang][$langView . '_VERSION_DESC'] = "A count of the number of times this " . $view['settings']->name_single . " has been revised.";
			$this->langContent[$this->lang][$langView . '_SAVE_WARNING'] = "Alias already existed so a number was added at the end. You can re-edit the " . $view['settings']->name_single . " to customise the alias.";
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
			$readOnly = "\t\t\t" . 'readonly="true"' . PHP_EOL . "\t\t\t" . 'disabled="true"';
		}
		// start adding dynamc fields
		$dynamicFields = '';
		// set the custom table key
		$dbkey = 'g';
		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamicFields .= $this->setDynamicField($field, $view, $view['settings']->type, $langView, $view_name_single, $view_name_list, $this->placeholders, $dbkey, true);
		}
		// set the default fields
		$fieldSet = array();
		$fieldSet[] = '<fieldset name="details">';
		$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Default Fields. -->";
		$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Id Field. Type: Text (joomla) -->";
		// if id is not set
		if (!isset($this->fieldsNames[$view_name_single]['id']))
		{
			$fieldSet[] = "\t\t<field";
			$fieldSet[] = "\t\t\tname=" . '"id"';
			$fieldSet[] = "\t\t\t" . 'type="text" class="readonly" label="JGLOBAL_FIELD_ID_LABEL"';
			$fieldSet[] = "\t\t\t" . 'description ="JGLOBAL_FIELD_ID_DESC" size="10" default="0"';
			$fieldSet[] = "\t\t\t" . 'readonly="true"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if created is not set
		if (!isset($this->fieldsNames[$view_name_single]['created']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Date Created Field. Type: Calendar (joomla) -->";
			$fieldSet[] = "\t\t<field";
			$fieldSet[] = "\t\t\tname=" . '"created"';
			$fieldSet[] = "\t\t\ttype=" . '"calendar"';
			$fieldSet[] = "\t\t\tlabel=" . '"' . $langView . '_CREATED_DATE_LABEL"';
			$fieldSet[] = "\t\t\tdescription=" . '"' . $langView . '_CREATED_DATE_DESC"';
			$fieldSet[] = "\t\t\tsize=" . '"22"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = "\t\t\tformat=" . '"%Y-%m-%d %H:%M:%S"';
			$fieldSet[] = "\t\t\tfilter=" . '"user_utc"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if created_by is not set
		if (!isset($this->fieldsNames[$view_name_single]['created_by']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " User Created Field. Type: User (joomla) -->";
			$fieldSet[] = "\t\t<field";
			$fieldSet[] = "\t\t\tname=" . '"created_by"';
			$fieldSet[] = "\t\t\ttype=" . '"user"';
			$fieldSet[] = "\t\t\tlabel=" . '"' . $langView . '_CREATED_BY_LABEL"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = "\t\t\tdescription=" . '"' . $langView . '_CREATED_BY_DESC"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if published is not set
		if (!isset($this->fieldsNames[$view_name_single]['published']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Published Field. Type: List (joomla) -->";
			$fieldSet[] = "\t\t<field name=" . '"published" type="list" label="JSTATUS"';
			$fieldSet[] = "\t\t\tdescription=" . '"JFIELD_PUBLISHED_DESC" class="chzn-color-state"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = "\t\t\tfilter=" . '"intval" size="1" default="1" >';
			$fieldSet[] = "\t\t\t<option value=" . '"1">';
			$fieldSet[] = "\t\t\t\tJPUBLISHED</option>";
			$fieldSet[] = "\t\t\t<option value=" . '"0">';
			$fieldSet[] = "\t\t\t\tJUNPUBLISHED</option>";
			$fieldSet[] = "\t\t\t<option value=" . '"2">';
			$fieldSet[] = "\t\t\t\tJARCHIVED</option>";
			$fieldSet[] = "\t\t\t<option value=" . '"-2">';
			$fieldSet[] = "\t\t\t\tJTRASHED</option>";
			$fieldSet[] = "\t\t</field>";
			// count the static field created
			$this->fieldCount++;
		}
		// if modified is not set
		if (!isset($this->fieldsNames[$view_name_single]['modified']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Date Modified Field. Type: Calendar (joomla) -->";
			$fieldSet[] = "\t\t" . '<field name="modified" type="calendar" class="readonly"';
			$fieldSet[] = "\t\t\t" . 'label="' . $langView . '_MODIFIED_DATE_LABEL" description="' . $langView . '_MODIFIED_DATE_DESC"';
			$fieldSet[] = "\t\t\t" . 'size="22" readonly="true" format="%Y-%m-%d %H:%M:%S" filter="user_utc" />';
			// count the static field created
			$this->fieldCount++;
		}
		// if modified_by is not set
		if (!isset($this->fieldsNames[$view_name_single]['modified_by']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " User Modified Field. Type: User (joomla) -->";
			$fieldSet[] = "\t\t" . '<field name="modified_by" type="user"';
			$fieldSet[] = "\t\t\t" . 'label="' . $langView . '_MODIFIED_BY_LABEL"';
			$fieldSet[] = "\t\t\tdescription=" . '"' . $langView . '_MODIFIED_BY_DESC"';
			$fieldSet[] = "\t\t\t" . 'class="readonly"';
			$fieldSet[] = "\t\t\t" . 'readonly="true"';
			$fieldSet[] = "\t\t\t" . 'filter="unset"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// check if view has access
		if (isset($this->accessBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view_name_single]) && !isset($this->fieldsNames[$view_name_single]['access']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Access Field. Type: Accesslevel (joomla) -->";
			$fieldSet[] = "\t\t" . '<field name="access"';
			$fieldSet[] = "\t\t\t" . 'type="accesslevel"';
			$fieldSet[] = "\t\t\t" . 'label="JFIELD_ACCESS_LABEL"';
			$fieldSet[] = "\t\t\t" . 'description="JFIELD_ACCESS_DESC"';
			$fieldSet[] = "\t\t\t" . 'default="1"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = "\t\t\t" . 'required="false"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if ordering is not set
		if (!isset($this->fieldsNames[$view_name_single]['ordering']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Ordering Field. Type: Numbers (joomla) -->";
			$fieldSet[] = "\t\t<field";
			$fieldSet[] = "\t\t\t" . 'name="ordering"';
			$fieldSet[] = "\t\t\t" . 'type="number"';
			$fieldSet[] = "\t\t\t" . 'class="inputbox validate-ordering"';
			$fieldSet[] = "\t\t\t" . 'label="' . $langView . '_ORDERING_LABEL' . '"';
			$fieldSet[] = "\t\t\t" . 'description=""';
			$fieldSet[] = "\t\t\t" . 'default="0"';
			$fieldSet[] = "\t\t\t" . 'size="6"';
			if ($readOnly)
			{
				$fieldSet[] = $readOnly;
			}
			$fieldSet[] = "\t\t\t" . 'required="false"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// if version is not set
		if (!isset($this->fieldsNames[$view_name_single]['version']))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Version Field. Type: Text (joomla) -->";
			$fieldSet[] = "\t\t<field";
			$fieldSet[] = "\t\t\t" . 'name="version"';
			$fieldSet[] = "\t\t\t" . 'type="text"';
			$fieldSet[] = "\t\t\t" . 'class="readonly"';
			$fieldSet[] = "\t\t\t" . 'label="' . $langView . '_VERSION_LABEL"';
			$fieldSet[] = "\t\t\t" . 'description="' . $langView . '_VERSION_DESC"';
			$fieldSet[] = "\t\t\t" . 'size="6"';
			$fieldSet[] = "\t\t\t" . 'readonly="true"';
			$fieldSet[] = "\t\t\t" . 'filter="unset"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view_name_single]))
		{
			// metakey
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Metakey Field. Type: Textarea (joomla) -->";
			$fieldSet[] = "\t\t<field";
			$fieldSet[] = "\t\t\t" . 'name="metakey"';
			$fieldSet[] = "\t\t\t" . 'type="textarea"';
			$fieldSet[] = "\t\t\t" . 'label="JFIELD_META_KEYWORDS_LABEL"';
			$fieldSet[] = "\t\t\t" . 'description="JFIELD_META_KEYWORDS_DESC"';
			$fieldSet[] = "\t\t\t" . 'rows="3"';
			$fieldSet[] = "\t\t\t" . 'cols="30"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
			// metadesc
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Metadesc Field. Type: Textarea (joomla) -->";
			$fieldSet[] = "\t\t<field";
			$fieldSet[] = "\t\t\t" . 'name="metadesc"';
			$fieldSet[] = "\t\t\t" . 'type="textarea"';
			$fieldSet[] = "\t\t\t" . 'label="JFIELD_META_DESCRIPTION_LABEL"';
			$fieldSet[] = "\t\t\t" . 'description="JFIELD_META_DESCRIPTION_DESC"';
			$fieldSet[] = "\t\t\t" . 'rows="3"';
			$fieldSet[] = "\t\t\t" . 'cols="30"';
			$fieldSet[] = "\t\t/>";
			// count the static field created
			$this->fieldCount++;
		}
		// load the dynamic fields now
		if (ComponentbuilderHelper::checkString($dynamicFields))
		{
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Dynamic Fields. -->" . $dynamicFields;
		}
		// close fieldset
		$fieldSet[] = "\t</fieldset>";
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view_name_single]))
		{
			$fieldSet[] = PHP_EOL . "\t<!--" . $this->setLine(__LINE__) . " Metadata Fields. -->";
			$fieldSet[] = "\t<fields" . ' name="metadata" label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
			$fieldSet[] = "\t\t" . '<fieldset name="vdmmetadata"';
			$fieldSet[] = "\t\t\t" . 'label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
			// robots
			$fieldSet[] = "\t\t\t<!--" . $this->setLine(__LINE__) . " Robots Field. Type: List (joomla) -->";
			$fieldSet[] = "\t\t\t" . '<field name="robots"';
			$fieldSet[] = "\t\t\t\t" . 'type="list"';
			$fieldSet[] = "\t\t\t\t" . 'label="JFIELD_METADATA_ROBOTS_LABEL"';
			$fieldSet[] = "\t\t\t\t" . 'description="JFIELD_METADATA_ROBOTS_DESC" >';
			$fieldSet[] = "\t\t\t\t" . '<option value="">JGLOBAL_USE_GLOBAL</option>';
			$fieldSet[] = "\t\t\t\t" . '<option value="index, follow">JGLOBAL_INDEX_FOLLOW</option>';
			$fieldSet[] = "\t\t\t\t" . '<option value="noindex, follow">JGLOBAL_NOINDEX_FOLLOW</option>';
			$fieldSet[] = "\t\t\t\t" . '<option value="index, nofollow">JGLOBAL_INDEX_NOFOLLOW</option>';
			$fieldSet[] = "\t\t\t\t" . '<option value="noindex, nofollow">JGLOBAL_NOINDEX_NOFOLLOW</option>';
			$fieldSet[] = "\t\t\t" . '</field>';
			// count the static field created
			$this->fieldCount++;
			// author
			$fieldSet[] = "\t\t\t<!--" . $this->setLine(__LINE__) . " Author Field. Type: Text (joomla) -->";
			$fieldSet[] = "\t\t\t" . '<field name="author"';
			$fieldSet[] = "\t\t\t\t" . 'type="text"';
			$fieldSet[] = "\t\t\t\t" . 'label="JAUTHOR" description="JFIELD_METADATA_AUTHOR_DESC"';
			$fieldSet[] = "\t\t\t\t" . 'size="20"';
			$fieldSet[] = "\t\t\t/>";
			// count the static field created
			$this->fieldCount++;
			// rights
			$fieldSet[] = "\t\t\t<!--" . $this->setLine(__LINE__) . " Rights Field. Type: Textarea (joomla) -->";
			$fieldSet[] = "\t\t\t" . '<field name="rights" type="textarea" label="JFIELD_META_RIGHTS_LABEL"';
			$fieldSet[] = "\t\t\t\t" . 'description="JFIELD_META_RIGHTS_DESC" required="false" filter="string"';
			$fieldSet[] = "\t\t\t\t" . 'cols="30" rows="2"';
			$fieldSet[] = "\t\t\t/>";
			// count the static field created
			$this->fieldCount++;
			$fieldSet[] = "\t\t</fieldset>";
			$fieldSet[] = "\t</fields>";
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
		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamicFieldsXML[] = $this->setDynamicField($field, $view, $view['settings']->type, $langView, $view_name_single, $view_name_list, $this->placeholders, $dbkey, true);
		}
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
			// metadesc
			$attributes['name'] = 'metadesc';
			$attributes['label'] = 'JFIELD_META_DESCRIPTION_LABEL';
			$attributes['description'] = 'JFIELD_META_DESCRIPTION_DESC';
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metadesc Field. Type: Textarea (joomla)");
			$fieldXML = $fieldSetXML->addChild('field');
			ComponentbuilderHelper::xmlAddAttributes($fieldXML, $attributes);
			// count the static field created
			$this->fieldCount++;
		}
		// load the dynamic fields now
		if (count($dynamicFieldsXML))
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
			ComponentbuilderHelper::xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metadata Fields");
			$fieldsXML = $fieldSetXML->addChild('fields');
			$fieldsXML->addAttribute('name', 'metadata');
			$fieldsXML->addAttribute('label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS');
			$fieldsFieldSetXML = $fieldsXML->addChild('fieldset');
			$fieldsFieldSetXML->addAttribute('name', 'vdmmetadata');
			$fieldsFieldSetXML->addAttribute('label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS');
			// robots
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
			// author
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
			// rights
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

				if ($this->defaultField($typeName, 'option'))
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
				elseif ($this->defaultField($typeName, 'plain'))
				{
					if ($build)
					{
						// set builders
						$this->setBuilders($langLabel, $langView, $view_name_single, $view_name_list, $name, $view, $field, $typeName, $multiple);
					}
					// now add to the field set
					$dynamicField = $this->setField('plain', $fieldAttributes, $name, $typeName, $langView, $view_name_single, $view_name_list, $placeholders, $optionArray);
				}
				elseif ($this->defaultField($typeName, 'spacer'))
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
				elseif ($this->defaultField($typeName, 'special'))
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
				elseif (ComponentbuilderHelper::checkArray($fieldAttributes['custom']))
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
			$field .= PHP_EOL . "\t" . $taber . "\t<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
			$field .= PHP_EOL . "\t" . $taber . "\t<field";
			$optionSet = '';
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . "\t\t" . $taber . "\t" . $property . '="' . $value . '"';
				}
				elseif ($property === 'option')
				{
					$optionSet = '';
					if (strpos($value, ',') !== false)
					{
						// mulitpal options
						$options = explode(',', $value);
						foreach ($options as $option)
						{
							if (strpos($option, '|') !== false)
							{
								// has other value then text
								list($v, $t) = explode('|', $option);
								$langValue = $langView . '_' . ComponentbuilderHelper::safeString($t, 'U');
								// add to lang array
								$this->langContent[$this->lang][$langValue] = $t;
								// no add to option set
								$optionSet .= PHP_EOL . "\t" . $taber . "\t\t" . '<option value="' . $v . '">' . PHP_EOL . "\t" . $taber . "\t\t\t" . $langValue . '</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_' . ComponentbuilderHelper::safeString($option, 'U');
								// add to lang array
								$this->langContent[$this->lang][$langValue] = $option;
								// no add to option set
								$optionSet .= PHP_EOL . "\t\t" . $taber . "\t" . '<option value="' . $option . '">' . PHP_EOL . "\t\t" . $taber . "\t\t" . $langValue . '</option>';
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
							$langValue = $langView . '_' . ComponentbuilderHelper::safeString($t, 'U');
							// add to lang array
							$this->langContent[$this->lang][$langValue] = $t;
							// no add to option set
							$optionSet .= PHP_EOL . "\t\t" . $taber . "\t" . '<option value="' . $v . '">' . PHP_EOL . "\t\t" . $taber . "\t\t" . $langValue . '</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_' . ComponentbuilderHelper::safeString($value, 'U');
							// add to lang array
							$this->langContent[$this->lang][$langValue] = $value;
							// no add to option set
							$optionSet .= PHP_EOL . "\t\t" . $taber . "\t" . '<option value="' . $value . '">' . PHP_EOL . "\t\t" . $taber . "\t\t" . $langValue . '</option>';
							$optionArray[$value] = $langValue;
						}
					}
				}
			}
			if (ComponentbuilderHelper::checkString($optionSet))
			{
				$field .= '>';
				$field .= PHP_EOL . "\t\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$field .= $optionSet;
				$field .= PHP_EOL . "\t\t" . $taber . "</field>";
			}
			elseif ($typeName === 'sql')
			{
				$optionArray = false;
				$field .= PHP_EOL . "\t\t" . $taber . "/>";
			}
			else
			{
				$optionArray = false;
				$field .= PHP_EOL . "\t\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " No Manual Options Were Added In Field Settings. -->";
				$field .= PHP_EOL . "\t\t" . $taber . "/>";
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$field .= PHP_EOL . "\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
			$field .= PHP_EOL . "\t\t" . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . "\t\t" . $taber . "\t" . $property . '="' . $value . '"';
				}
			}
			$field .= PHP_EOL . "\t\t" . $taber . "/>";
		}
		elseif ($setType === 'spacer')
		{
			// now add to the field set
			$field .= PHP_EOL . "\t\t<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". A None Database Field. (joomla) -->";
			$field .= PHP_EOL . "\t\t<field";
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
				$field .= PHP_EOL . "\t\t<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
				$field .= PHP_EOL . "\t\t<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . "\t\t\t" . $property . '="' . $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . "\t\t\t" . '<fields name="' . $fieldAttributes['name'] . '_fields" label="">';
				$field .= PHP_EOL . "\t\t\t\t" . '<fieldset hidden="true" name="' . $fieldAttributes['name'] . '_modal" repeat="true">';
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
					foreach ($fieldsSets as $fieldId)
					{
						// get the field data
						$fieldData['settings'] = $this->getFieldData($fieldId, $view_name_single);
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = $this->getFieldName($fieldData);
							$r_typeName = $this->getFieldType($fieldData);
							$r_multiple = false;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = "\t\t\t";
							// get field values
							$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $view_name_list, $view_name_single, $placeholders, true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if ($this->defaultField($r_typeName, 'option'))
								{
									// now add to the field set
									$field .= $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
								elseif ($this->defaultField($r_typeName, 'plain'))
								{
									// now add to the field set
									$field .= $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
								elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
									// set lang (just incase)
									$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeString($r_name, 'U');
									// add to lang array
									$this->langContent[$this->lang][$r_listLangName] = ComponentbuilderHelper::safeString($r_name, 'W');
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
							}
						}
					}
				}
				$field .= PHP_EOL . "\t\t\t\t</fieldset>";
				$field .= PHP_EOL . "\t\t\t</fields>";
				$field .= PHP_EOL . "\t\t</field>";
			}
			// set the subform fields (it is a repeatable without the modal) 
			elseif ($typeName === 'subform')
			{
				// now add to the field set
				$field .= PHP_EOL . "\t\t<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
				$field .= PHP_EOL . "\t\t<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . "\t\t\t" . $property . '="' . $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . "\t\t\t" . '<form hidden="true" name="list_' . $fieldAttributes['name'] . '_modal" repeat="true">';
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
					foreach ($fieldsSets as $fieldId)
					{
						// get the field data
						$fieldData['settings'] = $this->getFieldData($fieldId, $view_name_single);
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = $this->getFieldName($fieldData);
							$r_typeName = $this->getFieldType($fieldData);
							$r_multiple = false;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = "\t\t";
							// get field values
							$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $view_name_list, $view_name_single, $placeholders, true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if ($this->defaultField($r_typeName, 'option'))
								{
									// now add to the field set
									$field .= $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
								elseif ($this->defaultField($r_typeName, 'plain'))
								{
									// now add to the field set
									$field .= $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
								}
								elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray, null, $r_taber);
									// set lang (just incase)
									$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeString($r_name, 'U');
									// add to lang array
									$this->langContent[$this->lang][$r_listLangName] = ComponentbuilderHelper::safeString($r_name, 'W');
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
							}
						}
					}
				}
				$field .= PHP_EOL . "\t\t\t</form>";
				$field .= PHP_EOL . "\t\t</field>";
			}
		}
		elseif ($setType === 'custom')
		{
			// now add to the field set
			$field .= PHP_EOL . "\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (custom) -->";
			$field .= PHP_EOL . "\t\t" . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . "\t\t" . $taber . "\t" . $property . '="' . $value . '"';
				}
			}
			$field .= PHP_EOL . "\t\t" . $taber . "/>";
			// incase the field is in the config and has not been set
			if ('config' === $view_name_single && 'configs' === $view_name_list)
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
			$field->comment = $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla)";

			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
				elseif ($property === 'option')
				{
					ComponentbuilderHelper::xmlComment($field->fieldXML, $this->setLine(__LINE__) . " Option Set.");
					if (strpos($value, ',') !== false)
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
								$langValue = $langView . '_' . ComponentbuilderHelper::safeString($t, 'U');
								// add to lang array
								$this->langContent[$this->lang][$langValue] = $t;
								// no add to option set
								$optionXML->addAttribute('value', $v);
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_' . ComponentbuilderHelper::safeString($option, 'U');
								// add to lang array
								$this->langContent[$this->lang][$langValue] = $option;
								// no add to option set
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
							$langValue = $langView . '_' . ComponentbuilderHelper::safeString($t, 'U');
							// add to lang array
							$this->langContent[$this->lang][$langValue] = $t;
							// no add to option set
							$optionXML->addAttribute('value', $v);
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_' . ComponentbuilderHelper::safeString($value, 'U');
							// add to lang array
							$this->langContent[$this->lang][$langValue] = $value;
							// no add to option set
							$optionXML->addAttribute('value', $value);
							$optionArray[$value] = $langValue;
						}
						$optionXML[] = $langValue;
					}
				}
			}
			if (!$field->fieldXML->count())
			{
				ComponentbuilderHelper::xmlComment($field->fieldXML, $this->setLine(__LINE__) . " No Manual Options Were Added In Field Settings.");
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$field->fieldXML = new SimpleXMLElement('<field/>');
			$field->comment = $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla)";

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
			$field->comment = $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". A None Database Field. (joomla)";

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
				$field->comment = $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (depreciated)";

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
					foreach ($fieldsSets as $fieldId)
					{
						// get the field data
						$fieldData = array();
						$fieldData['settings'] = $this->getFieldData($fieldId, $view_name_single);
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = $this->getFieldName($fieldData);
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
								if ($this->defaultField($r_typeName, 'option'))
								{
									// now add to the field set
									ComponentbuilderHelper::xmlAppend($fieldSetXML, $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
								}
								elseif ($this->defaultField($r_typeName, 'plain'))
								{
									// now add to the field set
									ComponentbuilderHelper::xmlAppend($fieldSetXML, $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
								}
								elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									ComponentbuilderHelper::xmlAppend($fieldSetXML, $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
									// set lang (just incase)
									$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeString($r_name, 'U');
									// add to lang array
									$this->langContent[$this->lang][$r_listLangName] = ComponentbuilderHelper::safeString($r_name, 'W');
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
				$field->comment = $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla)";
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
						foreach ($fieldsSets as $fieldId)
						{
							// get the field data
							$fieldData = array();
							$fieldData['settings'] = $this->getFieldData($fieldId, $view_name_single);
							if (ComponentbuilderHelper::checkObject($fieldData['settings']))
							{
								$r_name = $this->getFieldName($fieldData);
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
									if ($this->defaultField($r_typeName, 'option'))
									{
										// now add to the field set
										ComponentbuilderHelper::xmlAppend($form, $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
									}
									elseif ($this->defaultField($r_typeName, 'plain'))
									{
										// now add to the field set
										ComponentbuilderHelper::xmlAppend($form, $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
									}
									elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
									{
										// add to custom
										$custom = $r_fieldValues['custom'];
										unset($r_fieldValues['custom']);
										// now add to the field set
										ComponentbuilderHelper::xmlAppend($form, $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $view_name_single, $view_name_list, $placeholders, $r_optionArray));
										// set lang (just incase)
										$r_listLangName = $langView . '_' . ComponentbuilderHelper::safeString($r_name, 'U');
										// add to lang array
										$this->langContent[$this->lang][$r_listLangName] = ComponentbuilderHelper::safeString($r_name, 'W');
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
			$field->comment = $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (custom)";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field->fieldXML->addAttribute($property, $value);
				}
			}
			// incase the field is in the config and has not been set
			if ('config' === $view_name_single && 'configs' === $view_name_list)
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
			// check if publishing fields were over written
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
			// check if publishing fields were over written
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
		$decode = array('json', 'base64', 'basic_encryption', 'whmcs_encryption', 'medium_encryption');
		$textareas = array('textarea', 'editor');
		if (isset($this->siteFields[$view][$field]) && ComponentbuilderHelper::checkArray($this->siteFields[$view][$field]))
		{
			foreach ($this->siteFields[$view][$field] as $code => $array)
			{
				// set the decoding methods
				if (in_array($set, $decode))
				{
					$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']] = array('decode' => $set, 'type' => $type);
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
	 * @param   string   $view_name_single  The singel view name
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
		// setup joomla default fields
		if (!$this->defaultField($typeName))
		{
			$fieldAttributes['custom'] = array();
			$setCustom = true;
		}
		// setup a default field
		if (ComponentbuilderHelper::checkArray($field['settings']->properties))
		{
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
					$xmlValue = ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"');
					// replace the placeholders
					$xmlValue = $this->setPlaceholders($xmlValue, $placeholders);
				}
				elseif (strpos($property['name'], 'type_php_') !== false && $setCustom)
				{
					// set the line number
					$phpLine = (int) str_replace('type_php_', '', $property['name']);
					// load the php for the custom field file
					$fieldAttributes['custom']['php'][$phpLine] = ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"');
				}
				elseif (strpos($property['name'], 'type_phpx_') !== false && $setCustom)
				{
					// set the line number
					$phpLine = (int) str_replace('type_phpx_', '', $property['name']);
					// load the php for the custom field file
					$fieldAttributes['custom']['phpx'][$phpLine] = ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"');
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
					// load the view name
					$fieldAttributes['custom']['view'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'view="', '"'));
				}
				elseif ($property['name'] === 'views' && $setCustom)
				{
					// load the views name
					$fieldAttributes['custom']['views'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'views="', '"'));
				}
				elseif ($property['name'] === 'component' && $setCustom)
				{
					// load the component name
					$fieldAttributes['custom']['component'] = ComponentbuilderHelper::getBetween($field['settings']->xml, 'component="', '"');
					// replace the placeholders
					$fieldAttributes['custom']['component'] = $this->setPlaceholders($fieldAttributes['custom']['component'], $placeholders);
				}
				elseif ($property['name'] === 'table' && $setCustom)
				{
					// load the main table that is queried
					$fieldAttributes['custom']['table'] = ComponentbuilderHelper::getBetween($field['settings']->xml, 'table="', '"');
					// replace the placeholders
					$fieldAttributes['custom']['table'] = $this->setPlaceholders($fieldAttributes['custom']['table'], $placeholders);
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
					// dont load the button to repeatable
					$xmlValue = (string) ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'button="', '"'));
					// add to custom values
					$fieldAttributes['custom']['add_button'] = (ComponentbuilderHelper::checkString($xmlValue) || 1 == $xmlValue) ? $xmlValue: 'false';
				}
				elseif ($property['name'] === 'required' && $repeatable)
				{
					// dont load the required to repeatable
					$xmlValue = 'false';
				}
				elseif ($viewType == 2 && ($property['name'] === 'readonly' || $property['name'] === 'disabled'))
				{
					// set read only
					$xmlValue = 'true';
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
					$xmlValue = (string) ComponentbuilderHelper::getBetween($field['settings']->xml, $property['name'] . '="', '"');
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
					$langValue = $langView . '_' . ComponentbuilderHelper::safeString($name . ' ' . $property['name'], 'U');
					// add to lang array
					$this->langContent[$this->lang][$langValue] = $xmlValue;
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
			}
		}
		return $fieldAttributes;
	}

	/**
	 * set Builders
	 *
	 * @param   string   $langLabel         The language string for field label
	 * @param   string   $langView          The language string of the view
	 * @param   string   $view_name_single  The singel view name
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
		if ($typeName === 'tag')
		{
			// set tags for this view but don't load to DB
			$this->tagsBuilder[$view_name_single] = $view_name_single;
		}
		else
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
		// add history to this view
		if (isset($view['history']) && $view['history'])
		{
			$this->historyBuilder[$view_name_single] = $view_name_single;
		}
		// set Alias (only one title per view)
		if (isset($field['alias']) && $field['alias'] && !isset($this->aliasBuilder[$view_name_single]))
		{
			$this->aliasBuilder[$view_name_single] = $name;
		}
		// set Titles (only one title per view)
		if (isset($field['title']) && $field['title'] && !isset($this->titleBuilder[$view_name_single]))
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
				$tempName = $view_name_single . ' category';
			}
			// set lang
			$listLangName = $langView . '_' . ComponentbuilderHelper::safeString($tempName, 'U');
			// add to lang array
			$this->langContent[$this->lang][$listLangName] = ComponentbuilderHelper::safeString($tempName, 'W');
		}
		else
		{
			// set lang (just incase)
			$listLangName = $langView . '_' . ComponentbuilderHelper::safeString($name, 'U');
			// add to lang array
			$this->langContent[$this->lang][$listLangName] = ComponentbuilderHelper::safeString($name, 'W');
			// if label was set use instead
			if (ComponentbuilderHelper::checkString($langLabel))
			{
				$listLangName = $langLabel;
			}
		}
		// build the list values
		if ((isset($field['list']) && $field['list'] == 1) && $typeName != 'repeatable' && $typeName != 'subform')
		{
			// load to list builder
			$this->listBuilder[$view_name_list][] = array(
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

			$this->customBuilderList[$view_name_list][] = $name;
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
		if ($field['settings']->datatype === 'INT' || $field['settings']->datatype === 'TINYINT' || $field['settings']->datatype === 'BIGINT')
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
		if ($typeName === 'editor')
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
		if ($typeName === 'category')
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
			$this->categoryBuilder[$view_name_list] = array('code' => $name, 'name' => $listLangName);
			// also set code name for title alias fix
			$this->catCodeBuilder[$view_name_single] = array('code' => $name, 'views' => $otherViews, 'view' => $otherView);
		}
		// setup checkbox for this view
		if ($typeName === 'checkbox' || (ComponentbuilderHelper::checkArray($custom) && isset($custom['extends']) && $custom['extends'] === 'checkboxes'))
		{
			$this->checkboxBuilder[$view_name_single][] = $name;
		}
		// setup checkboxes and other json items for this view
		if (($typeName === 'subform' || $typeName === 'checkboxes' || $multiple || $field['settings']->store != 0) && $typeName != 'tag')
		{
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
					$this->basicEncryptionBuilder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'basic_encryption', $typeName);
					break;
				case 4:
					// WHMCS_ENCRYPTION_VDMKEY
					$this->whmcsEncryptionBuilder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'whmcs_encryption', $typeName);
					break;
				case 5:
					// MEDIUM_ENCRYPTION_LOCALFILE
					$this->mediumEncryptionBuilder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'medium_encryption', $typeName);
					break;
				default:
					// JSON_ARRAY_ENCODE
					$this->jsonItemBuilder[$view_name_single][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($view_name_single, $name, 'json', $typeName);
					break;
			}
			// just a heads-up for usergroups set to multiple
			if ($typeName === 'usergroup')
			{
				$this->buildSiteFieldData($view_name_single, $name, 'json', $typeName);
			}

			// load the json list display fix
			if ((isset($field['list']) && $field['list'] == 1) && $typeName != 'repeatable' && $typeName != 'subform')
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

			// if subform the values must revert to array
			if ('subform' === $typeName)
			{
				$this->jsonItemBuilderArray[$view_name_single][] = $name;
			}
		}
		// build the data for the export & import methods $typeName === 'repeatable' ||
		if (($typeName === 'checkboxes' || $multiple || $field['settings']->store != 0) && !ComponentbuilderHelper::checkArray($options))
		{
			$this->getItemsMethodEximportStringFixBuilder[$view_name_single][] = array('name' => $name, 'type' => $typeName, 'translation' => false, 'custom' => $custom, 'method' => $field['settings']->store);
		}
		// check if field should be added to uikit
		$this->buildSiteFieldData($view_name_single, $name, 'uikit', $typeName);
		// load the selection translation fix
		if (ComponentbuilderHelper::checkArray($options) && (isset($field['list']) && $field['list'] == 1) && $typeName != 'repeatable' && $typeName != 'subform')
		{
			$this->selectionTranslationFixBuilder[$view_name_list][$name] = $options;
		}
		// build the sort values
		if ((isset($field['sort']) && $field['sort'] == 1) && (isset($field['list']) && $field['list'] == 1) && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable' && $typeName != 'subform'))
		{
			$this->sortBuilder[$view_name_list][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom, 'options' => $options);
		}
		// build the search values
		if (isset($field['search']) && $field['search'] == 1)
		{
			$_list = (isset($field['list'])) ? $field['list'] : 0;
			$this->searchBuilder[$view_name_list][] = array('type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $_list);
		}
		// build the filter values
		if ((isset($field['filter']) && $field['filter'] == 1) && (isset($field['list']) && $field['list'] == 1) && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable' && $typeName != 'subform'))
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
		if ((isset($data['custom']['prime_php']) && $data['custom']['prime_php'] == 1) || !isset($this->fileContentDynamic['customfield_' . $data['type']]) || !ComponentbuilderHelper::checkArray($this->fileContentDynamic['customfield_' . $data['type']]))
		{
			// first build the custom field type file
			$target = array('admin' => 'customfield');
			$this->buildDynamique($target, 'field' . $data['custom']['extends'], $data['custom']['type']);
			// set tab and break replacements
			$tabBreak = array(
				'\t' => "\t",
				'\n' => PHP_EOL
			);
			// make field dynamic
			$replace = array(
				'###TABLE###' => $data['custom']['table'],
				'###ID###' => $data['custom']['id'],
				'###TEXT###' => $data['custom']['text'],
				'###CODE_TEXT###' => $data['code'] . '_' . $data['custom']['text'],
				'###CODE###' => $data['code'],
				'###component###' => $this->fileContentStatic['###component###'],
				'###Component###' => $this->fileContentStatic['###Component###'],
				'###view_type###' => $view_name_single . '_' . $data['type'],
				'###type###' => $data['type'],
				'###view###' => $view_name_single,
				'###views###' => $view_name_list
			);
			// now load the php script
			if (isset($data['custom']['php']) && ComponentbuilderHelper::checkArray($data['custom']['php']))
			{
				// make sure the ar is reset
				$phpCode = '';
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
							$phpCode .= PHP_EOL . "\t\t" . $this->setPlaceholders($code, $tabBreak);
						}
					}
				}
				// replace the placholders
				$phpCode = $this->setPlaceholders($phpCode, $replace);
			}
			else
			{
				$phpCode = 'return null;';
			}
			// catch empty stuff
			if (!ComponentbuilderHelper::checkString($phpCode))
			{
				$phpCode = 'return null;';
			}
			// some house cleaning for users
			if ($data['custom']['extends'] === 'user')
			{
				// now load the php xclude script
				if (ComponentbuilderHelper::checkArray($data['custom']['phpx']))
				{
					// make sure the ar is reset
					$phpxCode = '';
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
								$phpxCode .= PHP_EOL . "\t\t" . $this->setPlaceholders($code, $tabBreak);
							}
						}
					}
					// replace the placholders
					$phpxCode = $this->setPlaceholders($phpxCode, $replace);
				}
				else
				{
					$phpxCode = 'return null;';
				}
				if (!ComponentbuilderHelper::checkString($phpxCode))
				{
					$phpxCode = 'return null;';
				}
				// temp holder for name
				$tempName = $data['custom']['label'] . ' Group';
				// set lang
				$groupLangName = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($tempName, 'U');
				// add to lang array
				$this->langContent[$this->lang][$groupLangName] = ComponentbuilderHelper::safeString($tempName, 'W');
				// build the Group Control
				$this->setGroupControl[$data['type']] = $groupLangName;
				// ###JFORM_GETGROUPS_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_' . $data['type']]['###JFORM_GETGROUPS_PHP###'] = $phpCode;

				// ###JFORM_GETEXCLUDED_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_' . $data['type']]['###JFORM_GETEXCLUDED_PHP###'] = $phpxCode;
			}
			else
			{
				// ###JFORM_GETOPTIONS_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_' . $data['type']]['###JFORM_GETOPTIONS_PHP###'] = $phpCode;
			}
			// ###Type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']]['###Type###'] = ComponentbuilderHelper::safeString($data['custom']['type'], 'F');
			// ###type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']]['###type###'] = $data['custom']['type'];
			// ###type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_' . $data['type']]['###ADD_BUTTON###'] = $this->setAddButtonToListField($data['custom']);
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
			// check that the component value is set
			if (!isset($fieldData['component']) || !ComponentbuilderHelper::checkString($fieldData['component']))
			{
				$fieldData['component'] = "com_" . $this->fileContentStatic['###component###'];
			}
			// check that the componet has the com_ value in it
			if (strpos($fieldData['component'], 'com_') === false || strpos($fieldData['component'], '=') !== false)
			{
				$fieldData['component'] = "com_" . $fieldData['component'];
			}
			// make sure the component is update if ### or [[[ component placeholder is used
			if (strpos($fieldData['component'], '###') !== false || strpos($fieldData['component'], '[[[') !== false ) // should not be needed... but
			{
				$fieldData['component'] = $this->setPlaceholders($fieldData['component'], $this->placeholders);
			}
			// get core permissions
			$coreLoad = false;
			// add ref tags
			$refLoad = true;
			if (isset($this->permissionCore[$fieldData['view']]))
			{
				// get the core permission naming array
				$core = $this->permissionCore[$fieldData['view']];
				// set switch to activate easy update
				$coreLoad = true;
				// since the view is local to the component use this component name
				$component = "com_" . $this->fileContentStatic['###component###'];
			}
			else
			{
				// fall back on the field component
				$component = $fieldData['component'];
			}
			// check if we should add ref tags
			if ($fieldData['component'] !== $component)
			{
				// do not add ref tags
				$refLoad = false;
			}
			// start building the add buttons/s
			$addButton = array();
			$addButton[] = PHP_EOL . PHP_EOL . "\t/**";
			$addButton[] = "\t * Override to add new button";
			$addButton[] = "\t *";
			$addButton[] = "\t * @return  string  The field input markup.";
			$addButton[] = "\t *";
			$addButton[] = "\t * @since   3.2";
			$addButton[] = "\t */";
			$addButton[] = "\tprotected function getInput()";
			$addButton[] = "\t{";
			$addButton[] = "\t\t//" . $this->setLine(__LINE__) . " see if we should add buttons";
			$addButton[] = "\t\t\$setButton = \$this->getAttribute('button');";
			$addButton[] = "\t\t//" . $this->setLine(__LINE__) . " get html";
			$addButton[] = "\t\t\$html = parent::getInput();";
			$addButton[] = "\t\t//" . $this->setLine(__LINE__) . " if true set button";
			$addButton[] = "\t\tif (\$setButton === 'true')";
			$addButton[] = "\t\t{";
			$addButton[] = "\t\t\t\$button = array();";
			$addButton[] = "\t\t\t\$script = array();";
			$addButton[] = "\t\t\t\$buttonName = \$this->getAttribute('name');";
			$addButton[] = "\t\t\t//" . $this->setLine(__LINE__) . " get the input from url";
			$addButton[] = "\t\t\t\$app = JFactory::getApplication();";
			$addButton[] = "\t\t\t\$jinput = \$app->input;";
			$addButton[] = "\t\t\t//" . $this->setLine(__LINE__) . " get the view name & id";
			$addButton[] = "\t\t\t\$values = \$jinput->getArray(array(";
			$addButton[] = "\t\t\t\t'id' => 'int',";
			$addButton[] = "\t\t\t\t'view' => 'word'";
			$addButton[] = "\t\t\t));";
			$addButton[] = "\t\t\t//" . $this->setLine(__LINE__) . " check if new item";
			$addButton[] = "\t\t\t\$ref = '';";
			$addButton[] = "\t\t\t\$refJ = '';";
			if ($refLoad)
			{
				$addButton[] = "\t\t\tif (!is_null(\$values['id']) && strlen(\$values['view']))";
				$addButton[] = "\t\t\t{";
				$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " only load referal if not new item.";
				$addButton[] = "\t\t\t\t\$ref = '&amp;ref=' . \$values['view'] . '&amp;refid=' . \$values['id'];";
				$addButton[] = "\t\t\t\t\$refJ = '&ref=' . \$values['view'] . '&refid=' . \$values['id'];";
				$addButton[] = "\t\t\t}";
			}
			else
			{
				$addButton[] = "\t\t\tif (!is_null(\$values['id']) && strlen(\$values['view']))";
				$addButton[] = "\t\t\t{";
				$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " get the return value.";
				$addButton[] = "\t\t\t\t\$_uri = (string) JUri::getInstance();";
				$addButton[] = "\t\t\t\t\$_return = urlencode(base64_encode(\$_uri));";
				$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " load return value.";
				$addButton[] = "\t\t\t\t\$ref = '&amp;return=' . \$_return;";
				$addButton[] = "\t\t\t\t\$refJ = '&return=' . \$_return;";
				$addButton[] = "\t\t\t}";
			}
			$addButton[] = "\t\t\t\$user = JFactory::getUser();";
			$addButton[] = "\t\t\t//" . $this->setLine(__LINE__) . " only add if user allowed to create " . $fieldData['view'];	
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($fieldData['view'], $this->permissionBuilder['global'][$core['core.create']]))
			{
				$addButton[] = "\t\t\tif (\$user->authorise('" . $core['core.create'] . "', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			else
			{
				$addButton[] = "\t\t\tif (\$user->authorise('core.create', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			$addButton[] = "\t\t\t{";
			$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " build Create button";
			$addButton[] = "\t\t\t\t\$buttonNamee = trim(\$buttonName);";
			$addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/_+/', ' ', \$buttonNamee);";
			$addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/\s+/', ' ', \$buttonNamee);";
			$addButton[] = "\t\t\t\t\$buttonNamee = preg_replace(\"/[^A-Za-z ]/\", '', \$buttonNamee);";
			$addButton[] = "\t\t\t\t\$buttonNamee = ucfirst(strtolower(\$buttonNamee));";
			$addButton[] = "\t\t\t\t\$button[] = '<a id=\"'.\$buttonName.'Create\" class=\"btn btn-small btn-success hasTooltip\" title=\"'.JText:" . ":sprintf('" . $this->langPrefix . "_CREATE_NEW_S', \$buttonNamee).'\" style=\"border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;\"";
			$addButton[] = "\t\t\t\t\thref=\"index.php?option=" . $fieldData['component'] . "&amp;view=" . $fieldData['view'] . "&amp;layout=edit'.\$ref.'\" >";
			$addButton[] = "\t\t\t\t\t<span class=\"icon-new icon-white\"></span></a>';";
			$addButton[] = "\t\t\t}";
			$addButton[] = "\t\t\t//" . $this->setLine(__LINE__) . " only add if user allowed to edit " . $fieldData['view'];
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($fieldData['view'], $this->permissionBuilder['global'][$core['core.edit']]))
			{
				$addButton[] = "\t\t\tif ((\$buttonName === '" . $fieldData['view'] . "' || \$buttonName === '" . $fieldData['views'] . "') && \$user->authorise('" . $core['core.edit'] . "', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			else
			{
				$addButton[] = "\t\t\tif ((\$buttonName === '" . $fieldData['view'] . "' || \$buttonName === '" . $fieldData['views'] . "')  && \$user->authorise('core.edit', '" . $component . "') && \$app->isAdmin()) // TODO for now only in admin area.";
			}
			$addButton[] = "\t\t\t{";
			$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " build edit button";
			$addButton[] = "\t\t\t\t\$buttonNamee = trim(\$buttonName);";
			$addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/_+/', ' ', \$buttonNamee);";
			$addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/\s+/', ' ', \$buttonNamee);";
			$addButton[] = "\t\t\t\t\$buttonNamee = preg_replace(\"/[^A-Za-z ]/\", '', \$buttonNamee);";
			$addButton[] = "\t\t\t\t\$buttonNamee = ucfirst(strtolower(\$buttonNamee));";
			$addButton[] = "\t\t\t\t\$button[] = '<a id=\"'.\$buttonName.'Edit\" class=\"btn btn-small hasTooltip\" title=\"'.JText:" . ":sprintf('" . $this->langPrefix . "_EDIT_S', \$buttonNamee).'\" style=\"display: none; padding: 4px 4px 4px 7px;\" href=\"#\" >";
			$addButton[] = "\t\t\t\t\t<span class=\"icon-edit\"></span></a>';";
			$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " build script";
			$addButton[] = "\t\t\t\t\$script[] = \"";
			$addButton[] = "\t\t\t\t\tjQuery(document).ready(function() {";
			$addButton[] = "\t\t\t\t\t\tjQuery('#adminForm').on('change', '#jform_\".\$buttonName.\"',function (e) {";
			$addButton[] = "\t\t\t\t\t\t\te.preventDefault();";
			$addButton[] = "\t\t\t\t\t\t\tvar \".\$buttonName.\"Value = jQuery('#jform_\".\$buttonName.\"').val();";
			$addButton[] = "\t\t\t\t\t\t\t\".\$buttonName.\"Button(\".\$buttonName.\"Value);";
			$addButton[] = "\t\t\t\t\t\t});";
			$addButton[] = "\t\t\t\t\t\tvar \".\$buttonName.\"Value = jQuery('#jform_\".\$buttonName.\"').val();";
			$addButton[] = "\t\t\t\t\t\t\".\$buttonName.\"Button(\".\$buttonName.\"Value);";
			$addButton[] = "\t\t\t\t\t});";
			$addButton[] = "\t\t\t\t\tfunction \".\$buttonName.\"Button(value) {";
			$addButton[] = "\t\t\t\t\t\tif (value > 0) {"; // TODO not ideal since value may not be an (int)
			$addButton[] = "\t\t\t\t\t\t\t// hide the create button";
			$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Create').hide();";
			$addButton[] = "\t\t\t\t\t\t\t// show edit button";
			$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Edit').show();";
			$addButton[] = "\t\t\t\t\t\t\tvar url = 'index.php?option=" . $fieldData['component'] . "&view=" . $fieldData['views'] . "&task=" . $fieldData['view'] . ".edit&id='+value+'\".\$refJ.\"';"; // TODO this value may not be the ID
			$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Edit').attr('href', url);";
			$addButton[] = "\t\t\t\t\t\t} else {";
			$addButton[] = "\t\t\t\t\t\t\t// show the create button";
			$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Create').show();";
			$addButton[] = "\t\t\t\t\t\t\t// hide edit button";
			$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Edit').hide();";
			$addButton[] = "\t\t\t\t\t\t}";
			$addButton[] = "\t\t\t\t\t}\";";
			$addButton[] = "\t\t\t}";
			$addButton[] = "\t\t\t//" . $this->setLine(__LINE__) . " check if button was created for " . $fieldData['view'] . " field.";
			$addButton[] = "\t\t\tif (is_array(\$button) && count(\$button) > 0)";
			$addButton[] = "\t\t\t{";
			$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " Load the needed script.";
			$addButton[] = "\t\t\t\t\$document = JFactory::getDocument();";
			$addButton[] = "\t\t\t\t\$document->addScriptDeclaration(implode(' ',\$script));";
			$addButton[] = "\t\t\t\t//" . $this->setLine(__LINE__) . " return the button attached to input field.";
			$addButton[] = "\t\t\t\treturn '<div class=\"input-append\">' .\$html . implode('',\$button).'</div>';";
			$addButton[] = "\t\t\t}";
			$addButton[] = "\t\t}";
			$addButton[] = "\t\treturn \$html;";
			$addButton[] = "\t}";

			return implode(PHP_EOL, $addButton);
		}
		return '';
	}

	/**
	 * default Fields
	 *
	 * @param   string   $type The field type
	 * @param   boolean  $option The field grouping
	 *
	 * @return  boolean if the field was found
	 *
	 */
	public function defaultField($type, $option = 'default')
	{
		// list of default fields
		// https://docs.joomla.org/Form_field
		$defaults = array(
			'default' => array(
				'accesslevel', 'cachehandler', 'calendar', 'captcha', 'category', 'checkbox',
				'checkboxes', 'color', 'combo', 'componentlayout', 'contentlanguage', 'editor',
				'chromestyle', 'contenttype', 'databaseconnection', 'editors', 'email', 'file',
				'filelist', 'folderlist', 'groupedlist', 'hidden', 'file', 'headertag', 'helpsite',
				'imagelist', 'integer', 'language', 'list', 'media', 'menu', 'note', 'number', 'password',
				'plugins', 'radio', 'repeatable', 'range', 'rules', 'subform', 'sessionhandler', 'spacer', 'sql', 'tag',
				'tel', 'menuitem', 'meter', 'modulelayout', 'moduleorder', 'moduleposition', 'moduletag',
				'templatestyle', 'text', 'textarea', 'timezone', 'url', 'user', 'usergroup'
			),
			'plain' => array(
				'accesslevel', 'checkbox', 'cachehandler', 'calendar', 'category', 'chromestyle', 'color',
				'contenttype', 'combo', 'componentlayout', 'databaseconnection', 'editor', 'editors',
				'email', 'file', 'filelist', 'folderlist', 'headertag', 'helpsite',
				'hidden', 'imagelist', 'integer', 'language', 'media', 'menu',
				'menuitem', 'meter', 'modulelayout', 'moduleorder', 'moduletag', 'number', 'password', 'range', 'rules',
				'sessionhandler', 'tag', 'tel', 'text', 'textarea',
				'timezone', 'url', 'user', 'usergroup'
			),
			'spacer' => array(
				'note', 'spacer'
			),
			'option' => array(
				'plugins', 'checkboxes', 'contentlanguage', 'list', 'radio', 'sql'
			),
			'special' => array(
				'contentlanguage', 'groupedlist', 'moduleposition', 'plugin',
				'repeatable', 'templatestyle', 'subform'
			)
		);

		if (in_array($type, $defaults[$option]))
		{
			return true;
		}
		return false;
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
			$this->app->enqueueMessage(JText::_('You must enable the <b>Tidy</b> extension in your php.ini file so we can tidy up your xml! If you need help please <a href="https://github.com/vdm-io/Joomla-Component-Builder/issues/197#issuecomment-351181754" target="_blank">start here</a>!'), 'error');
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
