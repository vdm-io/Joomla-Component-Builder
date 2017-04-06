<?php

/**--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version			2.3.0
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		compiler.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

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
	 * Site field data
	 * 
	 * @var    array
	 */
	public $siteFieldData = array();
	
	/**
	 * Category other name bucket
	 * 
	 * @var    array
	 */
	public $catOtherName = array();
	
	/**
	 * list of fields that are not being escaped
	 * 
	 * @var    array
	 */
	public $doNotEscape = array();
	
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
	 * Advnaced Encryption Builder
	 * 
	 * @var    array
	 */
	public $advancedEncryptionBuilder = array();
	
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
	public $selectionTranslationFixBuilder	= array();
	
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
	 * Set unique Names
	 * 
	 * @var    array
	 */
	public $uniqueNames = array();
	
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
			return ' [Fields '.$nr.']';	
		}
		return '';
	}

	/**
	 * set the Field set of a view
	 * 
	 * @param   array    $view  The view data
	 * @param   string   $component The component name
	 *
	 * @return  string The fields set in xml
	 * 
	 */
	public function setFieldSet($view, $component)
	{
		// setup the fieldset of this view
		if (isset($view['settings']->fields) && ComponentbuilderHelper::checkArray($view['settings']->fields))
		{
			// setup the list view and single view name
			$listViewName = ComponentbuilderHelper::safeString($view['settings']->name_list);
			$viewName = ComponentbuilderHelper::safeString($view['settings']->name_single);
			// set some place holder for this view
			$this->placeholders['###view###'] = $viewName;
			$this->placeholders['###VIEW###'] = strtoupper($viewName);
			$this->placeholders['###View###'] = ucfirst($viewName);
			$this->placeholders['[[[view]]]'] = $this->placeholders['###view###'];
			$this->placeholders['[[[VIEW]]]'] = $this->placeholders['###VIEW###'];
			$this->placeholders['[[[View]]]'] = $this->placeholders['###View###'];			
			$this->placeholders['###views###'] = $listViewName;
			$this->placeholders['###VIEWS###'] = strtoupper($listViewName);
			$this->placeholders['###Views###'] = ucfirst($listViewName);
			$this->placeholders['[[[views]]]'] = $this->placeholders['###views###'];
			$this->placeholders['[[[VIEWS]]]'] = $this->placeholders['###VIEWS###'];
			$this->placeholders['[[[Views]]]'] = $this->placeholders['###Views###'];
			// add metadata to the view
			if ($view['metadata'])
			{
				$this->metadataBuilder[$viewName] = $viewName;
			}
			// add access to the view
			if ($view['access'])
			{
				$this->accessBuilder[$viewName] = $viewName;
			}
			// set the read only
			$readOnly = "";
			if ($view['settings']->type == 2)
			{
				$readOnly = "\t\t\t" . 'readonly="true"' . PHP_EOL."\t\t\t" . 'disabled="true"';
			}
			// main lang prefix
			$langView = $this->langPrefix . '_' . $this->placeholders['###VIEW###'];
			$langViews = $this->langPrefix . '_' . $this->placeholders['###VIEWS###'];
			// set default lang
			$this->langContent[$this->lang][$langView] = $view['settings']->name_single;
			$this->langContent[$this->lang][$langViews] = $view['settings']->name_list;
			// set the single name
			$viewSingleName = ComponentbuilderHelper::safeString($view['settings']->name_single, 'W');
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
			
			// check if the same field is added multiple times
			foreach ($view['settings']->fields as $field)
			{
				$name = ComponentbuilderHelper::safeString($field['settings']->name);
				$this->setUniqueNameKeeper($field, $view['settings']->type, $name, $viewName);
			}
			// start adding dynamc fields
			$dynamcfields = '';
			$spacerCounter = 'a';
			// set the custom table key
			$dbkey = 'g';
			// TODO we should add the global and local view switch if field for front end
			foreach ($view['settings']->fields as $field)
			{
				$dynamcfields .= $this->setDynamicField($field, $view, $view['settings']->type, $langView, $viewName, $listViewName, $spacerCounter, $this->placeholders, $dbkey, true);
			}
			
			// set the defautl fields
			$fieldSet = array();
			$fieldSet[] = '<fieldset name="details">';
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Default Fields. -->";
			$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Id Field. Type: Text (joomla) -->";
			// if id is not set
			if (!isset($this->fieldsNames[$viewName]['id']))
			{
				$fieldSet[] = "\t\t<field";
				$fieldSet[] = "\t\t\tname=" . '"id"';
				$fieldSet[] = "\t\t\t" . 'type="text" class="readonly" label="JGLOBAL_FIELD_ID_LABEL"';
				$fieldSet[] = "\t\t\t" . 'description ="JGLOBAL_FIELD_ID_DESC" size="10" default="0"';
				$fieldSet[] = "\t\t\t" . 'readonly="true"';
				$fieldSet[] = "\t\t/>";
			}
			// if created is not set
			if (!isset($this->fieldsNames[$viewName]['created']))
			{
				$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Date Created Field. Type: Calendar (joomla) -->";
				$fieldSet[] = "\t\t<field";
				$fieldSet[] = "\t\t\tname=" . '"created"';
				$fieldSet[] = "\t\t\ttype=" . '"calendar"';
				$fieldSet[] = "\t\t\tlabel=" . '"' . $langView . '_CREATED_DATE_LABEL"';
				$fieldSet[] = "\t\t\tdescription=" . '"' . $langView . '_CREATED_DATE_DESC"';
				$fieldSet[] = "\t\t\tsize=" . '"22"';
				$fieldSet[] = $readOnly;
				$fieldSet[] = "\t\t\tformat=" . '"%Y-%m-%d %H:%M:%S"';
				$fieldSet[] = "\t\t\tfilter=" . '"user_utc"';
				$fieldSet[] = "\t\t/>";
			}
			// if created_by is not set
			if (!isset($this->fieldsNames[$viewName]['created_by']))
			{
				$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " User Created Field. Type: User (joomla) -->";
				$fieldSet[] = "\t\t<field";
				$fieldSet[] = "\t\t\tname=" . '"created_by"';
				$fieldSet[] = "\t\t\ttype=" . '"user"';
				$fieldSet[] = "\t\t\tlabel=" . '"' . $langView . '_CREATED_BY_LABEL"';
				$fieldSet[] = $readOnly;
				$fieldSet[] = "\t\t\tdescription=" . '"' . $langView . '_CREATED_BY_DESC"';
				$fieldSet[] = "\t\t/>";
			}
			// if published is not set
			if (!isset($this->fieldsNames[$viewName]['published']))
			{
				$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Published Field. Type: List (joomla) -->";
				$fieldSet[] = "\t\t<field name=" . '"published" type="list" label="JSTATUS"';
				$fieldSet[] = "\t\t\tdescription=" . '"JFIELD_PUBLISHED_DESC" class="chzn-color-state"';
				$fieldSet[] = $readOnly;
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
			}
			// if modified is not set
			if (!isset($this->fieldsNames[$viewName]['modified']))
			{
				$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Date Modified Field. Type: Calendar (joomla) -->";
				$fieldSet[] = "\t\t" . '<field name="modified" type="calendar" class="readonly"';
				$fieldSet[] = "\t\t\t" . 'label="' . $langView . '_MODIFIED_DATE_LABEL" description="' . $langView . '_MODIFIED_DATE_DESC"';
				$fieldSet[] = "\t\t\t" . 'size="22" readonly="true" format="%Y-%m-%d %H:%M:%S" filter="user_utc" />';
			}
			// if modified_by is not set
			if (!isset($this->fieldsNames[$viewName]['modified_by']))
			{
				$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " User Modified Field. Type: User (joomla) -->";
				$fieldSet[] = "\t\t" . '<field name="modified_by" type="user"';
				$fieldSet[] = "\t\t\t" . 'label="' . $langView . '_MODIFIED_BY_LABEL"';
				$fieldSet[] = "\t\t\tdescription=" . '"' . $langView . '_MODIFIED_BY_DESC"';
				$fieldSet[] = "\t\t\t" . 'class="readonly"';
				$fieldSet[] = "\t\t\t" . 'readonly="true"';
				$fieldSet[] = "\t\t\t" . 'filter="unset"';
				$fieldSet[] = "\t\t/>";
			}
			// check if view has access
			if (isset($this->accessBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName]) && !isset($this->fieldsNames[$viewName]['access']))
			{
				$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Access Field. Type: Accesslevel (joomla) -->";
				$fieldSet[] = "\t\t" . '<field name="access"';
				$fieldSet[] = "\t\t\t" . 'type="accesslevel"';
				$fieldSet[] = "\t\t\t" . 'label="JFIELD_ACCESS_LABEL"';
				$fieldSet[] = "\t\t\t" . 'description="JFIELD_ACCESS_DESC"';
				$fieldSet[] = "\t\t\t" . 'default="1"';
				$fieldSet[] = $readOnly;
				$fieldSet[] = "\t\t\t" . 'required="false"';
				$fieldSet[] = "\t\t/>";
			}
			// if ordering is not set
			if (!isset($this->fieldsNames[$viewName]['ordering']))
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
				$fieldSet[] = $readOnly;
				$fieldSet[] = "\t\t\t" . 'required="false"';
				$fieldSet[] = "\t\t/>";
			}
			// if version is not set
			if (!isset($this->fieldsNames[$viewName]['version']))
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
			}
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName]))
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
			}
			// load the dynamic fields now
			if (ComponentbuilderHelper::checkString($dynamcfields))
			{
				$fieldSet[] = "\t\t<!--" . $this->setLine(__LINE__) . " Dynamic Fields. -->" . $dynamcfields;
			}
			// close fieldset
			$fieldSet[] = "\t</fieldset>";
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName]))
			{
				$fieldSet[] = PHP_EOL."\t<!--" . $this->setLine(__LINE__) . " Metadata Fields. -->";
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
				// author
				$fieldSet[] = "\t\t\t<!--" . $this->setLine(__LINE__) . " Author Field. Type: Text (joomla) -->";
				$fieldSet[] = "\t\t\t" . '<field name="author"';
				$fieldSet[] = "\t\t\t\t" . 'type="text"';
				$fieldSet[] = "\t\t\t\t" . 'label="JAUTHOR" description="JFIELD_METADATA_AUTHOR_DESC"';
				$fieldSet[] = "\t\t\t\t" . 'size="20"';
				$fieldSet[] = "\t\t\t/>";
				// rights
				$fieldSet[] = "\t\t\t<!--" . $this->setLine(__LINE__) . " Rights Field. Type: Textarea (joomla) -->";
				$fieldSet[] = "\t\t\t" . '<field name="rights" type="textarea" label="JFIELD_META_RIGHTS_LABEL"';
				$fieldSet[] = "\t\t\t\t" . 'description="JFIELD_META_RIGHTS_DESC" required="false" filter="string"';
				$fieldSet[] = "\t\t\t\t" . 'cols="30" rows="2"';
				$fieldSet[] = "\t\t\t/>";
				$fieldSet[] = "\t\t</fieldset>";
				$fieldSet[] = "\t</fields>";
			}
			// just to be safe, lets clear the view placeholders
			$this->clearFromPlaceHolders('view');
			// retunr the set
			return implode(PHP_EOL, $fieldSet);
		}
		return '';
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
	 * @param   array    $field  The field data
	 * @param   array    $view The view data
	 * @param   int      $viewType The view type
	 * @param   string   $langView The language string of the view
	 * @param   string   $viewName The singel view name
	 * @param   string   $listViewName The list view name
	 * @param   string   $spacerCounter The space counter value
	 * @param   array    $placeholders The place holder and replace values
	 * @param   string   $dbkey The the custom table key
	 * @param   boolean  $build The switch to set the build option
	 *
	 * @return  string The complete field in xml
	 * 
	 */
	public function setDynamicField(&$field, &$view, &$viewType, &$langView, &$viewName, &$listViewName, &$spacerCounter, &$placeholders, &$dbkey, $build)
	{
		if (isset($field['settings']) && ComponentbuilderHelper::checkObject($field['settings']))
		{
                        // reset some values
			$name = ComponentbuilderHelper::safeString($field['settings']->name);
			$typeName = ComponentbuilderHelper::safeString($field['settings']->type_name);
			$multiple = false;
			$langLabel = '';
			$taber = '';
			$fieldSet = '';
                        $fieldAttributes = array();
			// set field attributes
			$fieldAttributes = $this->setFieldAttributes($field, $viewType, $name, $typeName, $multiple, $langLabel, $langView, $spacerCounter, $listViewName, $viewName, $placeholders);
			// check if values were set
			if (ComponentbuilderHelper::checkArray($fieldAttributes))
			{
				// set the array of field names
				$this->setFieldsNames($viewName,$fieldAttributes['name']);

				if ($this->defaultField($typeName, 'option'))
				{
					//reset options array
					$optionArray = array();
					// now add to the field set
					$fieldSet .= $this->setField('option', $taber, $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
					if ($build)
					{
						// set builders
						$this->setBuilders($langLabel, $langView, $viewName, $listViewName, $name, $view, $field, $typeName, $multiple, false, $optionArray);
					}
				}
				elseif ($this->defaultField($typeName, 'plain'))
				{
					if ($build)
					{
						// set builders
						$this->setBuilders($langLabel, $langView, $viewName, $listViewName, $name, $view, $field, $typeName, $multiple);
					}
					// now add to the field set
					$fieldSet .= $this->setField('plain', $taber, $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
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
						$this->setLayoutBuilder($viewName, $tabName, $name, $field);
					}
					// now add to the field set
					$fieldSet .= $this->setField('spacer', $taber, $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
					// increment spacer counter
					if ($typeName === 'spacer')
					{
						$spacerCounter++;
					}
				}
				elseif ($this->defaultField($typeName, 'special'))
				{
					// set the repeatable field
					if ($typeName === 'repeatable')
					{
						if ($build)
						{
							// set builders
							$this->setBuilders($langLabel, $langView, $viewName, $listViewName, $name, $view, $field, $typeName, $multiple, false);
						}
						// now add to the field set
						$fieldSet .= $this->setField('special', $taber, $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
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
						$this->setBuilders($langLabel, $langView, $viewName, $listViewName, $name, $view, $field, $typeName, $multiple, $custom);
					}
					// now add to the field set
					$fieldSet .= $this->setField('custom', $taber, $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray, $custom);
				}
			}
			return $fieldSet;
		}
		return '';
	}

	/**
	 * set a field
	 * 
	 * @param   string   $setType  The set of fields type
	 * @param   string   $taber The tabs to add in layout
	 * @param   array    $fieldAttributes The field values
	 * @param   string   $name The field name
	 * @param   string   $typeName The field type
	 * @param   string   $langView The language string of the view
	 * @param   string   $viewName The singel view name
	 * @param   string   $listViewName The list view name
	 * @param   array    $placeholders The place holder and replace values
	 * @param   string   $optionArray The option bucket array used to set the field options if needed.
	 * @param   arra	     $custom Used when field is from config
	 *
	 * @return  string The field in xml
	 * 
	 */
	private function setField($setType, $taber, &$fieldAttributes, &$name, &$typeName, &$langView, &$viewName, &$listViewName, $placeholders, &$optionArray, $custom = null)
	{
		$fieldSet = '';
		if ($setType === 'option')
		{
			// now add to the field set
			$fieldSet .= PHP_EOL."\t" . $taber . "\t<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
			$fieldSet .= PHP_EOL."\t" . $taber . "\t<field";
			$optionSet = '';
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= PHP_EOL."\t\t" . $taber . "\t" . $property . '="' . $value . '"';
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
								$optionSet .= PHP_EOL."\t" . $taber . "\t\t" . '<option value="' . $v . '">' . PHP_EOL."\t" . $taber . "\t\t\t" . $langValue . '</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_' . ComponentbuilderHelper::safeString($option, 'U');
								// add to lang array
								$this->langContent[$this->lang][$langValue] = $option;
								// no add to option set
								$optionSet .= PHP_EOL."\t\t" . $taber . "\t" . '<option value="' . $option . '">' . PHP_EOL."\t\t" . $taber . "\t\t" . $langValue . '</option>';
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
							$optionSet .= PHP_EOL."\t\t" . $taber . "\t" . '<option value="' . $v . '">' . PHP_EOL."\t\t" . $taber . "\t\t" . $langValue . '</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_' . ComponentbuilderHelper::safeString($value, 'U');
							// add to lang array
							$this->langContent[$this->lang][$langValue] = $value;
							// no add to option set
							$optionSet .= PHP_EOL."\t\t" . $taber . "\t" . '<option value="' . $value . '">' . PHP_EOL."\t\t" . $taber . "\t\t" . $langValue . '</option>';
							$optionArray[$value] = $langValue;
						}
					}
				}
			}
			if (ComponentbuilderHelper::checkString($optionSet))
			{
				$fieldSet .= '>';
				$fieldSet .= PHP_EOL."\t\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$fieldSet .= $optionSet;
				$fieldSet .= PHP_EOL."\t\t" . $taber . "</field>";
			}
			elseif ($typeName === 'sql')
			{
				$optionArray = false;
				$fieldSet .= PHP_EOL."\t\t" . $taber . "/>";
			}
			else
			{
				$optionArray = false;
				$fieldSet .= PHP_EOL."\t\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " No Manual Options Were Added In Field Settings. -->";
				$fieldSet .= PHP_EOL."\t\t" . $taber . "/>";
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$fieldSet .= PHP_EOL."\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
			$fieldSet .= PHP_EOL."\t\t" . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= PHP_EOL."\t\t" . $taber . "\t" . $property . '="' . $value . '"';
				}
			}
			$fieldSet .= PHP_EOL."\t\t" . $taber . "/>";
		}
		elseif ($setType === 'spacer')
		{
			// now add to the field set
			$fieldSet .= PHP_EOL."\t\t<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". A None Database Field. (joomla) -->";
			$fieldSet .= PHP_EOL."\t\t<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= " " . $property . '="' . $value . '"';
				}
			}
			$fieldSet .= " />";
		}
		elseif ($setType === 'special')
		{
			// set the repeatable field
			if ($typeName === 'repeatable')
			{
				// now add to the field set
				$fieldSet .= PHP_EOL."\t\t<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (joomla) -->";
				$fieldSet .= PHP_EOL."\t\t<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$fieldSet .= PHP_EOL."\t\t\t" . $property . '="' . $value . '"';
					}
				}
				$fieldSet .= ">";
				$fieldSet .= PHP_EOL."\t\t\t" . '<fields name="' . $fieldAttributes['name'] . '_fields" label="">';
				$fieldSet .= PHP_EOL."\t\t\t\t" . '<fieldset hidden="true" name="' . $fieldAttributes['name'] . '_modal" repeat="true">';
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
						$fieldData['settings'] = $this->getFieldData($fieldId, $viewName);
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = ComponentbuilderHelper::safeString($fieldData['settings']->name);
							$r_typeName = ComponentbuilderHelper::safeString($fieldData['settings']->type_name);
							$r_multiple = false;
							$r_langLabel = '';
							// add the tabs needed
							$taber = "\t\t\t";
							// get field values
							$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $spacerCounter, $listViewName, $viewName, $placeholders, true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if ($this->defaultField($r_typeName, 'option'))
								{
									// now add to the field set
									$fieldSet .= $this->setField('option', $taber, $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray);
								}
								elseif ($this->defaultField($r_typeName, 'plain'))
								{
									// now add to the field set
									$fieldSet .= $this->setField('plain', $taber, $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray);
								}
								elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$fieldSet .= $this->setField('custom', $taber, $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray);
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
									$this->setCustomFieldTypeFile($data, $listViewName, $viewName);
								}
							}
						}
					}
				}
				$fieldSet .= PHP_EOL."\t\t\t\t</fieldset>";
				$fieldSet .= PHP_EOL."\t\t\t</fields>";
				$fieldSet .= PHP_EOL."\t\t</field>";
			}
		}
		elseif ($setType === 'custom')
		{
			// now add to the field set
			$fieldSet .= PHP_EOL."\t\t" . $taber . "<!--" . $this->setLine(__LINE__) . " " . ComponentbuilderHelper::safeString($name, 'F') . " Field. Type: " . ComponentbuilderHelper::safeString($typeName, 'F') . ". (custom) -->";
			$fieldSet .= PHP_EOL."\t\t" . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= PHP_EOL."\t\t" . $taber . "\t" . $property . '="' . $value . '"';
				}
			}
			$fieldSet .= PHP_EOL."\t\t" . $taber . "/>";
			// incase the field is in the config and has not been set
			if ('config' === $viewName && 'configs' === $listViewName)
			{
				// set lang (just incase)
				$listLangName = $langView . '_' . ComponentbuilderHelper::safeString($name, 'U');
				// set the custom array
				$data = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom);
				// set the custom field file
				$this->setCustomFieldTypeFile($data, $listViewName, $viewName);
			}
		}
		return $fieldSet;
	}

	/**
	 * set the layout builder
	 * 
	 * @param   string   $viewName  The single edit view code name
	 * @param   string   $tabName The tab code name
	 * @param   string   $name The field code name
	 * @param   array    $field The field details
	 *
	 * @return  void
	 * 
	 */
	public function setLayoutBuilder(&$viewName,&$tabName,&$name,&$field)
	{
		if (ComponentbuilderHelper::checkString($tabName) && $tabName != 'publishing')
		{
			$this->tabCounter[$viewName][(int) $field['tab']] = $tabName;
			if (isset($this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = count($this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][(int) $field['order_edit']]) + 1;
				$this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][$size] = $name;
			}
			else
			{
				$this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][(int) $field['order_edit']] = $name;
			}
			// check if publishing fields were over written
			if (in_array($name, $this->defaultFields))
			{
				// just to eliminate
				$this->movedPublishingFields[$viewName][$name] = $name;
			}
		}
		elseif ($tabName === 'publishing')
		{
			if (!in_array($name, $this->defaultFields))
			{
				if (isset($this->newPublishingFields[$viewName][(int) $field['alignment']][(int) $field['order_edit']]))
				{
					$size = count($this->newPublishingFields[$viewName][(int) $field['alignment']][(int) $field['order_edit']]) + 1;
					$this->newPublishingFields[$viewName][(int) $field['alignment']][$size] = $name;
				}
				else
				{
					$this->newPublishingFields[$viewName][(int) $field['alignment']][(int) $field['order_edit']] = $name;
				}
			}
		}
		else
		{
			$this->tabCounter[$viewName][1] = 'Details';
			if (isset($this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = count($this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][(int) $field['order_edit']]) + 1;
				$this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][$size] = $name;
			}
			else
			{
				$this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][(int) $field['order_edit']] = $name;
			}
			// check if publishing fields were over written
			if (in_array($name, $this->defaultFields))
			{
				// just to eliminate
				$this->movedPublishingFields[$viewName][$name] = $name;
			}
		}
	}

	/**
	 * build the site field data needed
	 * 
	 * @param   string   $view  The single edit view code name
	 * @param   string   $field The field name
	 * @param   string   $set The decoding set this field belongs to
	 * @param   string   $type The field type
	 *
	 * @return  void
	 * 
	 */
	public function buildSiteFieldData($view,$field,$set,$type)
	{
		$decode = array('json','base64','basic_encryption','advance_encryption');
		$uikit = array('textarea','editor');
		if (isset($this->siteFields[$view][$field]) && ComponentbuilderHelper::checkArray($this->siteFields[$view][$field]))
		{
			foreach ($this->siteFields[$view][$field] as $code => $array)
			{
				// set the decoding methods
				if (in_array($set,$decode))
				{
					$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']] = array('decode' => $set, 'type' => $type);
				}
				// set the uikit checker
				if (in_array($type,$uikit))
				{
					$this->siteFieldData['uikit'][$array['site']][$code][$array['as']][$array['key']] = $array;
				}
			}
		}
	}

	/**
	 * set field attributes
	 * 
	 * @param   array    $field         The field data
	 * @param   int      $viewType      The view type
	 * @param   string   $name          The field name
	 * @param   string   $typeName      The field type
	 * @param   boolean  $multiple      The switch to set multiple selection option
	 * @param   string   $langLabel     The language string for field label
	 * @param   string   $langView      The language string of the view
	 * @param   string   $spacerCounter The space counter value
	 * @param   string   $listViewName  The list view name
	 * @param   string   $viewName      The singel view name
	 * @param   array    $placeholders  The place holder and replace values
	 * @param   boolean  $repeatable    The repeatable field switch
	 *
	 * @return  array The field attributes
	 * 
	 */
	private function setFieldAttributes(&$field, &$viewType, &$name, &$typeName, &$multiple, &$langLabel, $langView, &$spacerCounter, $listViewName, $viewName, $placeholders, $repeatable = false)
	{
		// reset array`
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
					if ($typeName === 'custom' || $typeName === 'customuser')
					{
						$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'type="', '"'));
					}
					// use field core type only if not found
					elseif (ComponentbuilderHelper::checkString($typeName))
					{
						$xmlValue = $typeName;
					}
					// make sure none adjustable fields are set
					elseif (isset($property['example']) && ComponentbuilderHelper::checkString($property['example']) && $property['adjustable'] == 0)
					{
						$xmlValue = $property['example'];
					}
					// fall back on the xml settings
					else
					{
						$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'type="', '"'));
					}

					// check if the value is set
					if (ComponentbuilderHelper::checkString($xmlValue))
					{
						// add the value
						$typeName = $xmlValue;
					}
					else
					{
						// fall back to text
						$xmlValue = 'text';
						$typeName = $xmlValue;
					}

					// add to custom if it is custom
					if ($setCustom)
					{
						// set the type just to make sure.
						$fieldAttributes['custom']['type'] = $typeName;
					}
				}
				elseif ($property['name'] === 'name')
				{
					// if category then name must be catid (only one per view)
					if ($typeName === 'category')
					{
						// quick check if this is a category linked to view page
						$requeSt_id = ComponentbuilderHelper::getBetween($field['settings']->xml, 'name="', '"');
						if (strpos($requeSt_id, '_request_id') !== false || strpos($requeSt_id, '_request_catid') !== false)
						{
							// keep it then, don't change
							$xmlValue = $requeSt_id;
						}
						else
						{
							$xmlValue = 'catid';
						}
						// check if we should use another Text Name as this views name
						$otherName = ComponentbuilderHelper::getBetween($field['settings']->xml, 'othername="', '"');
						$otherViews = ComponentbuilderHelper::getBetween($field['settings']->xml, 'views="', '"');
						$otherView = ComponentbuilderHelper::getBetween($field['settings']->xml, 'view="', '"');
						if (ComponentbuilderHelper::checkString($otherName) && ComponentbuilderHelper::checkString($otherViews) && ComponentbuilderHelper::checkString($otherView))
						{
							$this->catOtherName[$listViewName] = array(
							    'name' => ComponentbuilderHelper::safeString($otherName),
							    'views' => ComponentbuilderHelper::safeString($otherViews),
							    'view' => ComponentbuilderHelper::safeString($otherView)
							);
						}
					}
					// if tag is set then enable all tag options for this view (only one per view)
					elseif ($typeName === 'tag')
					{
						$xmlValue = 'tags';
					}
					// if the field is set as alias it must be called alias
					elseif (isset($field['alias']) && $field['alias'])
					{
						$xmlValue = 'alias';
					}
					elseif ($typeName === 'spacer')
					{
						// make sure the name is unique
						$xmlValue = $name . '_' . $spacerCounter;
					}
					else
					{
						$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'name="', '"'));
					}

					// use field core name only if not found in xml
					if (!ComponentbuilderHelper::checkString($xmlValue))
					{
						// make sure the XML name is uniqe, so we can add one field multiple times
						$name = $this->uniqueName($name, $viewName);
						$xmlValue = $name;
					}
					// set the name if found
					else
					{
						// make sure the XML name is uniqe, so we can add one field multiple times
						$xmlValue = $this->uniqueName($xmlValue, $viewName);
						$name = $this->setPlaceholders($xmlValue, $placeholders);
					}
				}
				elseif ($property['name'] === 'extension' || $property['name'] === 'directory')
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
				if (ComponentbuilderHelper::checkString($xmlValue) && $property['translatable'] == 1)
				{
					// update lable if field use multiple times
					if ($property['name'] === 'label')
					{
						if (isset($fieldAttributes['name']) && isset($this->uniqueNames[$viewName]['names'][$fieldAttributes['name']]))
						{
							$xmlValue .= ' (' . ComponentbuilderHelper::safeString($this->uniqueNames[$viewName]['names'][$fieldAttributes['name']]) . ')';
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
				elseif (isset($field['alias']) && $field['alias'] && $property['translatable'] == 1)
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
				elseif (isset($field['title']) && $field['title'] && $property['translatable'] == 1)
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
				if (ComponentbuilderHelper::checkString($xmlValue) || ($property['mandatory'] == 1 && !$setCustom))
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
				// check if we find reason to remove this field from being escaped
				$escaped = ComponentbuilderHelper::getBetween($field['settings']->xml, 'escape="', '"');
				if (ComponentbuilderHelper::checkString($escaped))
				{
					$this->doNotEscape[$listViewName][] = $fieldAttributes['name'];
				}
			}
		}
		return $fieldAttributes;
	}

	/**
	 * Keep track of the field names, to see if it used multiple times
	 * 
	 * @param   array    $field     The field data
	 * @param   string   $typeName  The field type
	 * @param   string   $name      The field name
	 * @param   string   $viewName  The singel view name
	 *
	 * @return  void
	 * 
	 */
	protected function setUniqueNameKeeper(&$field, &$typeName, &$name, $viewName)
	{
		// setup a default field
		if (ComponentbuilderHelper::checkArray($field['settings']->properties))
		{
			foreach ($field['settings']->properties as $property)
			{
				// reset
				$xmlValue = '';
				if ($property['name'] === 'name')
				{
					// if category then name must be catid (only one per view)
					if ($typeName === 'category')
					{
						// only one allowed
						return;
					}
					// if tag is set then enable all tag options for this view (only one per view)
					elseif ($typeName === 'tag')
					{
						// only one allowed
						return;
					}
					// if the field is set as alias it must be called alias
					elseif (isset($field['alias']) && $field['alias'])
					{
						// only one allowed
						return;
					}
					elseif ($typeName === 'spacer')
					{
						// not needed here
						return;
					}
					else
					{
						$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'name="', '"'));
					}

					// use field core name only if not found in xml
					if (!ComponentbuilderHelper::checkString($xmlValue))
					{
						$xmlValue = $name;
					}
					// make sure the XML name is uniqe, so we can add one field multiple times
					return $this->setUniqueNameCounter($xmlValue, $viewName);
				}
			}
		}
	}
	
	/**
	 * Count how many times the same field is used per view
	 * 
	 * @param   string   $name The name of the field
	 * @param   string   $view The name of the view
	 *
	 * @return  void
	 * 
	 */
	protected function setUniqueNameCounter($name, $view)
	{
		if (!isset($this->uniqueNames[$view]))
		{
			$this->uniqueNames[$view] = array();
			$this->uniqueNames[$view]['counter'] = array();
			$this->uniqueNames[$view]['names'] = array();
		}
		if (!isset($this->uniqueNames[$view]['counter'][$name]))
		{
			$this->uniqueNames[$view]['counter'][$name] = 1;
			return;
		}
		// count how many times the field is used
		$this->uniqueNames[$view]['counter'][$name]++;
		return;
	}
	
	/**
	 * Naming each field with an unique name
	 * 
	 * @param   string   $name The name of the field
	 * @param   string   $view The name of the view
	 *
	 * @return  string   the name
	 * 
	 */
	protected function uniqueName($name, $view)
	{
		// only increment if the field name is used multiple times
		if (isset($this->uniqueNames[$view]['counter'][$name]) && $this->uniqueNames[$view]['counter'][$name] > 1)
		{
			$counter = $this->uniqueNames[$view]['counter'][$name];
			$uniqueName = ComponentbuilderHelper::safeString($name . '_' . $counter);
			while (isset($this->uniqueNames[$view]['names'][$uniqueName]))
			{
				$counter--;
				$uniqueName = ComponentbuilderHelper::safeString($name . '_' . $counter);
			}
			// set the new name
			$this->uniqueNames[$view]['names'][$uniqueName] = $counter;
			return $uniqueName;
		}
		return $name;
	}


	/**
	 * set Builders
	 * 
	 * @param   string   $langLabel The language string for field label
	 * @param   string   $langView The language string of the view
	 * @param   string   $viewName The singel view name
	 * @param   string   $listViewName The list view name
	 * @param   string   $name The field name
	 * @param   array    $view  The view data
	 * @param   array    $field  The field data
	 * @param   string   $typeName The field type
	 * @param   boolean  $multiple The switch to set multiple selection option
	 * @param   boolean  $custom The custom field switch
	 * @param   boolean  $options The options switch
	 *
	 * @return  void
	 * 
	 */
	public function setBuilders($langLabel, $langView, $viewName, $listViewName, $name, $view, $field, $typeName, $multiple, $custom = false, $options = false)
	{
		if ($typeName === 'tag')
		{
			// set tags for this view but don't load to DB
			$this->tagsBuilder[$viewName] = $viewName;
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
			$this->queryBuilder[$viewName][$name]['type']           = $field['settings']->datatype;
                        if (!in_array($field['settings']->datatype, $textKeys))
			{
                                $this->queryBuilder[$viewName][$name]['lenght']         = $field['settings']->datalenght;
                                $this->queryBuilder[$viewName][$name]['lenght_other']   = $field['settings']->datalenght_other;
                                $this->queryBuilder[$viewName][$name]['default']        = $field['settings']->datadefault;
                                $this->queryBuilder[$viewName][$name]['other']          = $field['settings']->datadefault_other;
                        }
                        else
                        {
                                $this->queryBuilder[$viewName][$name]['default']        = 'EMPTY';
                        }
                        $this->queryBuilder[$viewName][$name]['null_switch']    = $field['settings']->null_switch;
			// set index types
			if ($field['settings']->indexes == 1 && !in_array($field['settings']->datatype, $textKeys))
			{
				// build unique keys of this view for db
				$this->dbUniqueKeys[$viewName][] = $name;
			}
			elseif (($field['settings']->indexes == 2 || $field['alias'] || $field['title'] || $typeName === 'category') && !in_array($field['settings']->datatype, $textKeys))
			{
				// build keys of this view for db
				$this->dbKeys[$viewName][] = $name;
			}
		}
		// add history to this view
		if ($view['history'])
		{
			$this->historyBuilder[$viewName] = $viewName;
		}
		// set Alias (only one title per view)
		if ($field['alias'])
		{
			$this->aliasBuilder[$viewName] = $name;
		}
		// set Titles (only one title per view)
		if ($field['title'])
		{
			$this->titleBuilder[$viewName] = $name;
		}
		// category name fix
		if ($typeName === 'category')
		{
			if (isset($this->catOtherName[$listViewName]) && ComponentbuilderHelper::checkArray($this->catOtherName[$listViewName]))
			{
				$tempName = $this->catOtherName[$listViewName]['name'];
			}
			else
			{
				$tempName = $viewName . ' category';
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
		if ($field['list'] == 1 && $typeName != 'repeatable')
		{
			// load to list builder
			$this->listBuilder[$listViewName][] = array(
			    'type' => $typeName,
			    'code' => $name,
			    'lang' => $listLangName,
			    'title' => ($field['title']) ? true : false,
			    'alias' => ($field['alias']) ? true : false,
			    'link' => ($field['link']) ? true : false,
			    'sort' => ($field['sort']) ? true : false,
			    'custom' => $custom,
			    'multiple' => $multiple,
			    'options' => $options);

			$this->customBuilderList[$listViewName][] = $name;
		}
		// set the hidden field of this view
		if ($typeName === 'hidden')
		{
			if (!isset($this->hiddenFieldsBuilder[$viewName]))
			{
				$this->hiddenFieldsBuilder[$viewName] = '';
			}
			$this->hiddenFieldsBuilder[$viewName] .= ',"' . $name . '"';
		}
		// set all int fields of this view
		if ($field['settings']->datatype === 'INT' || $field['settings']->datatype === 'TINYINT' || $field['settings']->datatype === 'BIGINT')
		{
			if (!isset($this->intFieldsBuilder[$viewName]))
			{
				$this->intFieldsBuilder[$viewName] = '';
			}
			$this->intFieldsBuilder[$viewName] .= ',"' . $name . '"';
		}
		// set all dynamic field of this view
		if ($typeName != 'category' && $typeName != 'repeatable' && !in_array($name, $this->defaultFields))
		{
			if (!isset($this->dynamicfieldsBuilder[$viewName]))
			{
				$this->dynamicfieldsBuilder[$viewName] = '';
			}
			if (isset($this->dynamicfieldsBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->dynamicfieldsBuilder[$viewName]))
			{
				$this->dynamicfieldsBuilder[$viewName] .= ',"' . $name . '":"' . $name . '"';
			}
			else
			{
				$this->dynamicfieldsBuilder[$viewName] .= '"' . $name . '":"' . $name . '"';
			}
		}
		// TODO we may need to add a switch instead (since now it uses the first editor field)
		// set the main(biggest) text field of this view
		if ($typeName === 'editor')
		{
			if (!isset($this->maintextBuilder[$viewName]) || !ComponentbuilderHelper::checkString($this->maintextBuilder[$viewName]))
			{
				$this->maintextBuilder[$viewName] = $name;
			}
		}
		// set the custom builder
		if (ComponentbuilderHelper::checkArray($custom) && $typeName != 'category' && $typeName != 'repeatable')
		{
			$this->customBuilder[$listViewName][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom, 'method' => $field['settings']->store);
			// set the custom fields needed in content type data
			if (!isset($this->customFieldLinksBuilder[$viewName]))
			{
				$this->customFieldLinksBuilder[$viewName] = '';
			}
			// only load this if table is set
			if (isset($custom['table']) && ComponentbuilderHelper::checkString($custom['table']))
			{
				$this->customFieldLinksBuilder[$viewName] .= ',{"sourceColumn": "' . $name . '","targetTable": "' . $custom['table'] . '","targetColumn": "' . $custom['id'] . '","displayColumn": "' . $custom['text'] . '"}';
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
			if (isset($this->catOtherName[$listViewName]) && ComponentbuilderHelper::checkArray($this->catOtherName[$listViewName]))
			{
				$otherViews = $this->catOtherName[$listViewName]['views'];
				$otherView = $this->catOtherName[$listViewName]['view'];
			}
			else
			{
				$otherViews = $listViewName;
				$otherView = $viewName;
			}
			$this->categoryBuilder[$listViewName] = array('code' => $name, 'name' => $listLangName);
			// also set code name for title alias fix
			$this->catCodeBuilder[$viewName] = array('code' => $name, 'views' => $otherViews, 'view' => $otherView);
		}
		// setup checkbox for this view
		if ($typeName === 'checkbox' || (ComponentbuilderHelper::checkArray($custom) && isset($custom['extends']) && $custom['extends'] === 'checkboxes'))
		{
			$this->checkboxBuilder[$viewName][] = $name;
		}
		// setup checkboxes and other json items for this view
		if (($typeName === 'checkboxes' || $multiple || $field['settings']->store != 0) && $typeName != 'tag')
		{
			switch ($field['settings']->store)
			{
				case 1:
					// JSON_STRING_ENCODE
					$this->jsonStringBuilder[$viewName][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($viewName, $name, 'json', $typeName);
					break;
				case 2:
					// BASE_SIXTY_FOUR
					$this->base64Builder[$viewName][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($viewName, $name, 'base64', $typeName);
					break;
				case 3:
					// BASIC_ENCRYPTION_LOCALKEY
					$this->basicEncryptionBuilder[$viewName][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($viewName, $name, 'basic_encryption', $typeName);
					break;
				case 4:
					// ADVANCE_ENCRYPTION_VDMKEY
					$this->advancedEncryptionBuilder[$viewName][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($viewName, $name, 'advance_encryption', $typeName);
					break;
				default:
					// JSON_ARRAY_ENCODE
					$this->jsonItemBuilder[$viewName][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($viewName, $name, 'json', $typeName);
					break;
			}
			// just a heads-up for usergroups set to multiple
			if ($typeName === 'usergroup')
			{
				$this->buildSiteFieldData($viewName, $name, 'json', $typeName);
			}

			// load the json list display fix
			if ($field['list'] == 1 && $typeName != 'repeatable')
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					$this->getItemsMethodListStringFixBuilder[$viewName][] = array('name' => $name, 'type' => $typeName, 'translation' => true, 'custom' => $custom, 'method' => $field['settings']->store);
				}
				else
				{
					$this->getItemsMethodListStringFixBuilder[$viewName][] = array('name' => $name, 'type' => $typeName, 'translation' => false, 'custom' => $custom, 'method' => $field['settings']->store);
				}
			}
		}
		// build the data for the export & import methods $typeName === 'repeatable' ||
		if (($typeName === 'checkboxes' || $multiple || $field['settings']->store != 0) && !ComponentbuilderHelper::checkArray($options))
		{
			$this->getItemsMethodEximportStringFixBuilder[$viewName][] = array('name' => $name, 'type' => $typeName, 'translation' => false, 'custom' => $custom, 'method' => $field['settings']->store);
		}

		// check if field should be added to uikit
		$this->buildSiteFieldData($viewName, $name, 'uikit', $typeName);
		// load the selection translation fix
		if (ComponentbuilderHelper::checkArray($options) && $field['list'] == 1 && $typeName != 'repeatable')
		{
			$this->selectionTranslationFixBuilder[$listViewName][$name] = $options;
		}
		// build the sort values
		if ($field['sort'] == 1 && $field['list'] == 1 && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable'))
		{
			$this->sortBuilder[$listViewName][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom, 'options' => $options);
		}
		// build the search values
		if ($field['search'] == 1)
		{
			$this->searchBuilder[$listViewName][] = array('type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $field['list']);
		}
		// build the filter values
		if ($field['filter'] == 1 && $field['list'] == 1 && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable'))
		{
			$this->filterBuilder[$listViewName][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'database' => $viewName, 'function' => ComponentbuilderHelper::safeString($name, 'F'), 'custom' => $custom, 'options' => $options);
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
		$this->setLayoutBuilder($viewName, $tabName, $name, $field);
	}
	
	public function setCustomFieldTypeFile($data, $viewName_list, $viewName_single)
	{
		// make sure it is not already been build
		if (!isset($this->fileContentDynamic['customfield_'.$data['type']]) || !ComponentbuilderHelper::checkArray($this->fileContentDynamic['customfield_'.$data['type']]))
		{
			// first build the custom field type file
			$target = array('admin' => 'customfield');
			$this->buildDynamique($target,'field'.$data['custom']['extends'],$data['custom']['type']);
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
				'###CODE_TEXT###' => $data['code'].'_'.$data['custom']['text'],
				'###CODE###' => $data['code'],
				'###component###' => $this->fileContentStatic['###component###'],
				'###Component###' => $this->fileContentStatic['###Component###'],
				'###view_type###' => $viewName_single.'_'.$data['type'],
				'###type###' => $data['type'],
				'###view###' => $viewName_single,
				'###views###' => $viewName_list
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
							$phpCode .= PHP_EOL."\t\t".$this->setPlaceholders($code, $tabBreak);
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
			if (!ComponentbuilderHelper::checkString($phpCode))
			{
				$phpCode = 'return null;';
			}

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
								$phpxCode .= PHP_EOL."\t\t".$this->setPlaceholders($code, $tabBreak);
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
				$tempName = $data['custom']['label'].' Group';
				// set lang
				$groupLangName = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($tempName,'U');
				// add to lang array
				$this->langContent[$this->lang][$groupLangName] = ComponentbuilderHelper::safeString($tempName,'W');
				// build the Group Control
				$this->setGroupControl[$data['type']] = $groupLangName;
				// ###JFORM_GETGROUPS_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'.$data['type']]['###JFORM_GETGROUPS_PHP###'] = $phpCode;

				// ###JFORM_GETEXCLUDED_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'.$data['type']]['###JFORM_GETEXCLUDED_PHP###'] = $phpxCode;
			}
			else
			{
				// ###JFORM_GETOPTIONS_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'.$data['type']]['###JFORM_GETOPTIONS_PHP###'] = $phpCode;
			}
			// ###Type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_'.$data['type']]['###Type###'] = ComponentbuilderHelper::safeString($data['custom']['type'],'F');
			// ###type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_'.$data['type']]['###type###'] = $data['custom']['type'];
			// ###type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_'.$data['type']]['###ADD_BUTTON###'] = $this->setAddButttonToListField($data['custom']['view'],$data['custom']['views']);
		}
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
			'plugins', 'radio', 'repeatable', 'range', 'rules', 'sessionhandler', 'spacer', 'sql', 'tag',
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
			'repeatable', 'templatestyle'
		    )
		);

		if (in_array($type, $defaults[$option]))
		{
			return true;
		}
		return false;
	}

}
