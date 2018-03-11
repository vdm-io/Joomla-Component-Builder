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
	 * @param   array    $view             The view data
	 * @param   string   $component        The component name
	 * @param   string   $viewName         The single view name
	 * @param   string   $listViewName     The list view name
	 *
	 * @return  string The fields set in xml
	 * 
	 */
	public function setFieldSet($view, $component, $viewName, $listViewName)
	{
		// setup the fieldset of this view
		if (isset($view['settings']->fields) && ComponentbuilderHelper::checkArray($view['settings']->fields))
		{
			// add metadata to the view
			if (isset($view['metadata']) && $view['metadata'])
			{
				$this->metadataBuilder[$viewName] = $viewName;
			}
			// add access to the view
			if (isset($view['access']) && $view['access'])
			{
				$this->accessBuilder[$viewName] = $viewName;
			}
			// set the read only
			$readOnlyXML = array();
			if ($view['settings']->type == 2)
			{
				$readOnlyXML['readonly'] = true;
				$readOnlyXML['disabled'] = true;
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
			// start adding dynamc fields
			$dynamicFieldsXML = array();
			// set the custom table key
			$dbkey = 'g';
			// TODO we should add the global and local view switch if field for front end
			foreach ($view['settings']->fields as $field)
			{
				$dynamicFieldsXML[] = $this->setDynamicField($field, $view, $view['settings']->type, $langView, $viewName, $listViewName, $this->placeholders, $dbkey, true);
			}
			// set the default fields
			$XML = new simpleXMLElement('<a/>');
			$fieldSetXML = $XML->addChild('fieldset');
			$fieldSetXML->addAttribute('name', 'details');
			$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Default Fields.");
			$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Id Field. Type: Text (joomla)");
			// if id is not set
			if (!isset($this->fieldsNames[$viewName]['id']))
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
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// if created is not set
			if (!isset($this->fieldsNames[$viewName]['created']))
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
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Date Created Field. Type: Calendar (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// if created_by is not set
			if (!isset($this->fieldsNames[$viewName]['created_by']))
			{
				$attributes = array(
					'name' => 'created_by',
					'type' => 'user',
					'label' => $langView . '_CREATED_BY_LABEL',
					'description' => $langView . '_CREATED_BY_DESC',
				);
				$attributes = array_merge($attributes, $readOnlyXML);
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " User Created Field. Type: User (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// if published is not set
			if (!isset($this->fieldsNames[$viewName]['published']))
			{
				$attributes = array(
					'name' => 'published',
					'type' => 'list',
					'label' => 'JSTATUS'
				);
				$attributes = array_merge($attributes, $readOnlyXML);
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Published Field. Type: List (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
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
			if (!isset($this->fieldsNames[$viewName]['modified']))
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
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Date Modified Field. Type: Calendar (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// if modified_by is not set
			if (!isset($this->fieldsNames[$viewName]['modified_by']))
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
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " User Modified Field. Type: User (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// check if view has access
			if (isset($this->accessBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName]) && !isset($this->fieldsNames[$viewName]['access']))
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
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Access Field. Type: Accesslevel (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// if ordering is not set
			if (!isset($this->fieldsNames[$viewName]['ordering']))
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
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Ordering Field. Type: Numbers (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// if version is not set
			if (!isset($this->fieldsNames[$viewName]['version']))
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
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Version Field. Type: Text (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName]))
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
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metakey Field. Type: Textarea (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
				// metadesc
				$attributes['name'] = 'metadesc';
				$attributes['label'] = 'JFIELD_META_DESCRIPTION_LABEL';
				$attributes['description'] = 'JFIELD_META_DESCRIPTION_DESC';
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metadesc Field. Type: Textarea (joomla)");
				$fieldXML = $fieldSetXML->addChild('field');
				$this->xmlAddAttributes($fieldXML, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// load the dynamic fields now
			if (count($dynamicFieldsXML))
			{
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Dynamic Fields.");
				foreach ($dynamicFieldsXML as $dynamicfield)
				{
					$this->xmlAppend($fieldSetXML, $dynamicfield);
				}
			}
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName]))
			{
				$this->xmlComment($fieldSetXML, $this->setLine(__LINE__) . " Metadata Fields");
				$fieldsXML = $fieldSetXML->addChild('fields');
				$fieldsXML->addAttribute('name', 'metadata');
				$fieldsXML->addAttribute('label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS');
				$fieldsFieldSetXML = $fieldsXML->addChild('fieldset');
				$fieldsFieldSetXML->addAttribute('name', 'vdmmetadata');
				$fieldsFieldSetXML->addAttribute('label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS');
				// robots
				$this->xmlComment($fieldsFieldSetXML, $this->setLine(__LINE__) . " Robots Field. Type: List (joomla)");
				$robots = $fieldsFieldSetXML->addChild('field');
				$attributes = array(
					'name' => 'robots',
					'type' => 'list',
					'label' => 'JFIELD_METADATA_ROBOTS_LABEL',
					'description' => 'JFIELD_METADATA_ROBOTS_DESC'
				);
				$this->xmlAddAttributes($robots, $attributes);
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
				$this->xmlComment($fieldsFieldSetXML, $this->setLine(__LINE__) . " Author Field. Type: Text (joomla)");
				$author = $fieldsFieldSetXML->addChild('field');
				$attributes = array(
					'name' => 'author',
					'type' => 'text',
					'label' => 'JAUTHOR',
					'description' => 'JFIELD_METADATA_AUTHOR_DESC',
					'size' => 20
				);
				$this->xmlAddAttributes($author, $attributes);
				// count the static field created
				$this->fieldCount++;
				// rights
				$this->xmlComment($fieldsFieldSetXML, $this->setLine(__LINE__) . " Rights Field. Type: Textarea (joomla)");
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
				$this->xmlAddAttributes($rights, $attributes);
				// count the static field created
				$this->fieldCount++;
			}
			// return the set
			return $this->xmlPrettyPrint($XML, 'fieldset');
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
	 * @param   array    $placeholders The place holder and replace values
	 * @param   string   $dbkey The the custom table key
	 * @param   boolean  $build The switch to set the build option
	 *
	 * @return  SimpleXMLElement The complete field in xml
	 *
	 */
	public function setDynamicField(&$field, &$view, &$viewType, &$langView, &$viewName, &$listViewName, &$placeholders, &$dbkey, $build)
	{
		if (isset($field['settings']) && ComponentbuilderHelper::checkObject($field['settings']))
		{
			// reset some values
			$name = $this->getFieldName($field, $listViewName);
			$typeName = $this->getFieldType($field);
			$multiple = false;
			$langLabel = '';
			$fieldSet = '';
			$fieldAttributes = array();
			// set field attributes
			$fieldAttributes = $this->setFieldAttributes($field, $viewType, $name, $typeName, $multiple, $langLabel, $langView, $listViewName, $viewName, $placeholders);
			// check if values were set
			if (ComponentbuilderHelper::checkArray($fieldAttributes))
			{
				// set the array of field names
				$this->setFieldsNames($viewName, $fieldAttributes['name']);

				if ($this->defaultField($typeName, 'option'))
				{
					//reset options array
					$optionArray = array();
					// now add to the field set
					$xmlElement = $this->setField('option', $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
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
					$xmlElement = $this->setField('plain', $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
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
					$xmlElement = $this->setField('spacer', $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
				}
				elseif ($this->defaultField($typeName, 'special'))
				{
					// set the repeatable field or subform field
					if ($typeName === 'repeatable' || $typeName === 'subform')
					{
						if ($build)
						{
							// set builders
							$this->setBuilders($langLabel, $langView, $viewName, $listViewName, $name, $view, $field, $typeName, $multiple, false);
						}
						// now add to the field set
						$xmlElement = $this->setField('special', $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray);
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
					$xmlElement = $this->setField('custom', $fieldAttributes, $name, $typeName, $langView, $viewName, $listViewName, $placeholders, $optionArray, $custom);
				}
			}
			return $xmlElement;
		}
		return false;
	}

	/**
	 * set a field
	 *
	 * @param   string   $setType          The set of fields type
	 * @param   array    $fieldAttributes  The field values
	 * @param   string   $name             The field name
	 * @param   string   $typeName         The field type
	 * @param   string   $langView         The language string of the view
	 * @param   string   $viewName         The single view name
	 * @param   string   $listViewName     The list view name
	 * @param   array    $placeholders     The place holder and replace values
	 * @param   string   $optionArray      The option bucket array used to set the field options if needed.
	 * @param   array    $custom           Used when field is from config
	 *
	 * @return  SimpleXMLElement The field in xml
	 *
	 */
	private function setField($setType, &$fieldAttributes, &$name, &$typeName, &$langView, &$viewName, &$listViewName, $placeholders, &$optionArray, $custom = null)
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
					$this->xmlComment($field->fieldXML, $this->setLine(__LINE__) . " Option Set.");
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
				$this->xmlComment($field->fieldXML, $this->setLine(__LINE__) . " No Manual Options Were Added In Field Settings.");
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
						$fieldData['settings'] = $this->getFieldData($fieldId, $viewName);
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name = $this->getFieldName($fieldData);
							$r_typeName = $this->getFieldType($fieldData);
							$r_multiple = false;
							$r_langLabel = '';
							// get field values
							$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $listViewName, $viewName, $placeholders, true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if ($this->defaultField($r_typeName, 'option'))
								{
									// now add to the field set
									$this->xmlAppend($fieldSetXML, $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray));
								}
								elseif ($this->defaultField($r_typeName, 'plain'))
								{
									// now add to the field set
									$this->xmlAppend($fieldSetXML, $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray));
								}
								elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$this->xmlAppend($fieldSetXML, $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray));
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
					$this->xmlAddAttributes($form, $attributes);

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
							$fieldData['settings'] = $this->getFieldData($fieldId, $viewName);
							if (ComponentbuilderHelper::checkObject($fieldData['settings']))
							{
								$r_name = $this->getFieldName($fieldData);
								$r_typeName = $this->getFieldType($fieldData);
								$r_multiple = false;
								$r_langLabel = '';
								// get field values
								$r_fieldValues = $this->setFieldAttributes($fieldData, $view, $r_name, $r_typeName, $r_multiple, $r_langLabel, $langView, $listViewName, $viewName, $placeholders, true);
								// check if values were set
								if (ComponentbuilderHelper::checkArray($r_fieldValues))
								{
									//reset options array
									$r_optionArray = array();
									if ($this->defaultField($r_typeName, 'option'))
									{
										// now add to the field set
										$this->xmlAppend($form, $this->setField('option', $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray));
									}
									elseif ($this->defaultField($r_typeName, 'plain'))
									{
										// now add to the field set
										$this->xmlAppend($form, $this->setField('plain', $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray));
									}
									elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
									{
										// add to custom
										$custom = $r_fieldValues['custom'];
										unset($r_fieldValues['custom']);
										// now add to the field set
										$this->xmlAppend($form, $this->setField('custom', $r_fieldValues, $r_name, $r_typeName, $langView, $viewName, $listViewName, $placeholders, $r_optionArray));
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
		return $field;
	}

	/**
	 * set the layout builder
	 *
	 * @param   string   $viewName  The single edit view code name
	 * @param   string   $tabName   The tab code name
	 * @param   string   $name      The field code name
	 * @param   array    $field     The field details
	 *
	 * @return  void
	 *
	 */
	public function setLayoutBuilder(&$viewName, &$tabName, &$name, &$field)
	{
		// first fix the zero order
		// to insure it lands before all the other fields
		// as zero is expected to behave
		if ($field['order_edit'] == 0)
		{
			if (!isset($this->zeroOrderFix[$viewName]))
			{
				$this->zeroOrderFix[$viewName] = array();
			}
			if (!isset($this->zeroOrderFix[$viewName][(int) $field['tab']]))
			{
				$this->zeroOrderFix[$viewName][(int) $field['tab']] = -999;
			}
			else
			{
				$this->zeroOrderFix[$viewName][(int) $field['tab']] ++;
			}
			$field['order_edit'] = $this->zeroOrderFix[$viewName][(int) $field['tab']];
		}
		// now build the layout
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
		elseif ($tabName === 'publishing' || $tabName === 'Publishing')
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
	 * @param   array    $field         The field data
	 * @param   int      $viewType      The view type
	 * @param   string   $name          The field name
	 * @param   string   $typeName      The field type
	 * @param   boolean  $multiple      The switch to set multiple selection option
	 * @param   string   $langLabel     The language string for field label
	 * @param   string   $langView      The language string of the view
	 * @param   string   $listViewName  The list view name
	 * @param   string   $viewName      The singel view name
	 * @param   array    $placeholders  The place holder and replace values
	 * @param   boolean  $repeatable    The repeatable field switch
	 *
	 * @return  array The field attributes
	 *
	 */
	private function setFieldAttributes(&$field, &$viewType, &$name, &$typeName, &$multiple, &$langLabel, $langView, $listViewName, $viewName, $placeholders, $repeatable = false)
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
						if (isset($fieldAttributes['name']) && isset($this->uniqueNames[$listViewName]['names'][$fieldAttributes['name']]))
						{
							$xmlValue .= ' (' . ComponentbuilderHelper::safeString($this->uniqueNames[$listViewName]['names'][$fieldAttributes['name']]) . ')';
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
					$this->listFieldClass[$listViewName][$fieldAttributes['name']] = $listclass;
				}
				// check if we find reason to remove this field from being escaped
				$escaped = ComponentbuilderHelper::getBetween($field['settings']->xml, 'escape="', '"');
				if (ComponentbuilderHelper::checkString($escaped))
				{
					$this->doNotEscape[$listViewName][] = $fieldAttributes['name'];
				}
				// check if we have display switch for dynamic placment
				$display = ComponentbuilderHelper::getBetween($field['settings']->xml, 'display="', '"');
				if (ComponentbuilderHelper::checkString($display))
				{
					$fieldAttributes['display'] = $display;
				}
			}
		}
		return $fieldAttributes;
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
			$this->queryBuilder[$viewName][$name]['type'] = $field['settings']->datatype;
			if (!in_array($field['settings']->datatype, $textKeys))
			{
				$this->queryBuilder[$viewName][$name]['lenght'] = $field['settings']->datalenght;
				$this->queryBuilder[$viewName][$name]['lenght_other'] = $field['settings']->datalenght_other;
				$this->queryBuilder[$viewName][$name]['default'] = $field['settings']->datadefault;
				$this->queryBuilder[$viewName][$name]['other'] = $field['settings']->datadefault_other;
			}
			else
			{
				$this->queryBuilder[$viewName][$name]['default'] = 'EMPTY';
			}
			// to identify the field
			$this->queryBuilder[$viewName][$name]['ID'] = $field['settings']->id;
			$this->queryBuilder[$viewName][$name]['null_switch'] = $field['settings']->null_switch;
			// set index types
			if ($field['settings']->indexes == 1 && !in_array($field['settings']->datatype, $textKeys))
			{
				// build unique keys of this view for db
				$this->dbUniqueKeys[$viewName][] = $name;
			}
			elseif (($field['settings']->indexes == 2 || (isset($field['alias']) && $field['alias']) || (isset($field['title']) && $field['title']) || $typeName === 'category') && !in_array($field['settings']->datatype, $textKeys))
			{
				// build keys of this view for db
				$this->dbKeys[$viewName][] = $name;
			}
		}
		// add history to this view
		if (isset($view['history']) && $view['history'])
		{
			$this->historyBuilder[$viewName] = $viewName;
		}
		// set Alias (only one title per view)
		if (isset($field['alias']) && $field['alias'])
		{
			$this->aliasBuilder[$viewName] = $name;
		}
		// set Titles (only one title per view)
		if (isset($field['title']) && $field['title'])
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
		if ((isset($field['list']) && $field['list'] == 1) && $typeName != 'repeatable' && $typeName != 'subform')
		{
			// load to list builder
			$this->listBuilder[$listViewName][] = array(
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
		if ($typeName != 'category' && $typeName != 'repeatable' && $typeName != 'subform' && !in_array($name, $this->defaultFields))
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
		if (ComponentbuilderHelper::checkArray($custom) && $typeName != 'category' && $typeName != 'repeatable' && $typeName != 'subform')
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
		if (($typeName === 'subform' || $typeName === 'checkboxes' || $multiple || $field['settings']->store != 0) && $typeName != 'tag')
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
					// WHMCS_ENCRYPTION_VDMKEY
					$this->whmcsEncryptionBuilder[$viewName][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($viewName, $name, 'whmcs_encryption', $typeName);
					break;
				case 5:
					// MEDIUM_ENCRYPTION_LOCALFILE
					$this->mediumEncryptionBuilder[$viewName][] = $name;
					// Site settings of each field if needed
					$this->buildSiteFieldData($viewName, $name, 'medium_encryption', $typeName);
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
			if ((isset($field['list']) && $field['list'] == 1) && $typeName != 'repeatable' && $typeName != 'subform')
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

			// if subform the values must revert to array
			if ('subform' === $typeName)
			{
				$this->jsonItemBuilderArray[$viewName][] = $name;
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
		if (ComponentbuilderHelper::checkArray($options) && (isset($field['list']) && $field['list'] == 1) && $typeName != 'repeatable' && $typeName != 'subform')
		{
			$this->selectionTranslationFixBuilder[$listViewName][$name] = $options;
		}
		// build the sort values
		if ((isset($field['sort']) && $field['sort'] == 1) && (isset($field['list']) && $field['list'] == 1) && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable' && $typeName != 'subform'))
		{
			$this->sortBuilder[$listViewName][] = array('type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom, 'options' => $options);
		}
		// build the search values
		if (isset($field['search']) && $field['search'] == 1)
		{
			$_list = (isset($field['list'])) ? $field['list'] : 0;
			$this->searchBuilder[$listViewName][] = array('type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $_list);
		}
		// build the filter values
		if ((isset($field['filter']) && $field['filter'] == 1) && (isset($field['list']) && $field['list'] == 1) && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable' && $typeName != 'subform'))
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
				'###view_type###' => $viewName_single . '_' . $data['type'],
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
			$this->fileContentDynamic['customfield_' . $data['type']]['###ADD_BUTTON###'] = $this->setAddButttonToListField($data['custom']['view'], $data['custom']['views']);
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
	 * xmlComment
	 *
	 * @param   SimpleXMLElement   $xml The XML element reference in which to inject a comment
	 * @param   string  $comment The comment to inject
	 *
	 * @return  null
	 *
	 */
	public function xmlComment(&$xml, $comment)
	{
		$domXML = dom_import_simplexml($xml);
		$domComment = new DOMComment($comment);
		$nodeTarget = $domXML->ownerDocument->importNode($domComment, true);
		$domXML->appendChild($nodeTarget);
		$xml = simplexml_import_dom($domXML);
	}

	/**
	 * xmlAddAttributes
	 *
	 * @param   SimpleXMLElement   $xml The XML element reference in which to inject a comment
	 * @param   array  $attributes The attributes to apply to the XML element
	 *
	 * @return  null
	 *
	 */
	public function xmlAddAttributes(&$xml, $attributes = array())
	{
		foreach ($attributes as $key => $value)
		{
			$xml->addAttribute($key, $value);
		}
	}

	/**
	 * xmlAppend
	 *
	 * @param   SimpleXMLElement   $xml The XML element reference in which to inject a comment
	 * @param   mixed  $node A SimpleXMLElement node to append to the XML element reference, or a stdClass object containing a comment attribute to be injected before the XML node and a fieldXML attribute containing a SimpleXMLElement
	 *
	 * @return  null
	 *
	 */
	public function xmlAppend(&$xml, $node)
	{
		if (!$node)
		{
			// element was not returned
			return;
		}
		switch (get_class($node))
		{
			case 'stdClass':
				if (property_exists($node, 'comment'))
				{
					$this->xmlComment($xml, $node->comment);
				}
				if (property_exists($node, 'fieldXML'))
				{
					$this->xmlAppend($xml, $node->fieldXML);
				}
				break;
			case 'SimpleXMLElement':
				$domXML = dom_import_simplexml($xml);
				$domNode = dom_import_simplexml($node);
				$domXML->appendChild($domXML->ownerDocument->importNode($domNode, true));
				$xml = simplexml_import_dom($domXML);
				break;
		}
		// count the dynamic fields created
		$this->fieldCount++;
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
