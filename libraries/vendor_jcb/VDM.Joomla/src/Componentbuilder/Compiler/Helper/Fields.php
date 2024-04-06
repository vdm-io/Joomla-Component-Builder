<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Helper;


use Joomla\CMS\Language\Text;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Helper\Structure;


/**
 * Fields class
 * 
 * @deprecated 3.3
 */
class Fields extends Structure
{
	/**
	 * Metadate Switch
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Meta.Data')->get($key);
	 */
	public $metadataBuilder = [];

	/**
	 * View access Switch
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Access.Switch')->get($key);
	 */
	public $accessBuilder = [];

	/**
	 * edit view tabs counter
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Tab.Counter')->get($key);
	 */
	public $tabCounter = [];

	/**
	 * layout builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Layout')->get($key);
	 */
	public $layoutBuilder = [];

	/**
	 * permissions builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Has.Permissions')->get($key);
	 */
	public $hasPermissions = [];

	/**
	 * used to fix the zero order
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Order.Zero')->get($key);
	 */
	private $zeroOrderFix = [];

	/**
	 * Site field data
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Site.Field.Data')->get($key);
	 */
	public $siteFieldData = [];

	/**
	 * list of fields that are not being escaped
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Do.Not.Escape')->get($key);
	 */
	public $doNotEscape = [];

	/**
	 * list of classes used in the list view for the fields
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.List.Field.Class')->set($key, true);
	 */
	public $listFieldClass = [];

	/**
	 * tags builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Tags')->get($key);
	 */
	public $tagsBuilder = [];

	/**
	 * query builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Database.Tables')->get($key);
	 */
	public $queryBuilder = [];

	/**
	 * unique keys for database field
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Database.Unique.Keys')->get($key);
	 */
	public $dbUniqueKeys = [];

	/**
	 * unique guid swtich
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Database.Unique.Guid')->get($key);
	 */
	public $dbUniqueGuid = [];

	/**
	 * keys for database field
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Database.Keys')->get($key);
	 */
	public $dbKeys = [];

	/**
	 * history builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.History')->get($key);
	 */
	public $historyBuilder = [];

	/**
	 * alias builder
	 *
	 * @var    array
	 * @deprecated 3.3 CFactory::_('Compiler.Builder.Alias')->get($key);
	 */
	public $aliasBuilder = [];

	/**
	 * title builder
	 *
	 * @var    array
	 * @deprecated 3.3 CFactory::_('Compiler.Builder.Title')->get($key);
	 */
	public $titleBuilder = [];

	/**
	 * list builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Lists')->get($key);
	 */
	public $listBuilder = [];

	/**
	 * custom Builder List
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Custom.List')->get($key);
	 */
	public $customBuilderList = [];

	/**
	 * Hidden Fields Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Hidden.Fields')->get($key);
	 */
	public $hiddenFieldsBuilder = [];

	/**
	 * INT Field Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Integer.Fields')->get($key);
	 */
	public $intFieldsBuilder = [];

	/**
	 * Dynamic Fields Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Dynamic.Fields')->get($key);
	 */
	public $dynamicfieldsBuilder = [];

	/**
	 * Main text Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Main.Text.Field')->get($key);
	 */
	public $maintextBuilder = [];

	/**
	 * Custom Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Custom.Field')->get($key);
	 */
	public $customBuilder = [];

	/**
	 * Custom Field Links Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Custom.Field.Links')->get($key);
	 */
	public $customFieldLinksBuilder = [];

	/**
	 * Set Script for User Switch
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Script.User.Switch')->get($key);
	 */
	public $setScriptUserSwitch = [];

	/**
	 * Set Script for Media Switch
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Script.Media.Switch')->get($key);
	 */
	public $setScriptMediaSwitch = [];

	/**
	 * Category builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Category')->get($key);
	 */
	public $categoryBuilder = [];

	/**
	 * Category Code builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Category.Code')->get($key);
	 */
	public $catCodeBuilder = [];

	/**
	 * Check Box builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Check.Box')->get($key);
	 */
	public $checkboxBuilder = [];

	/**
	 * Json String Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Json.String')->get($key);
	 */
	public $jsonStringBuilder = [];

	/**
	 * Json String Builder for return values to array
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Json.Item.Array')->get($key);
	 */
	public $jsonItemBuilderArray = [];

	/**
	 * Json Item Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Json.Item')->get($key);
	 */
	public $jsonItemBuilder = [];

	/**
	 * Base 64 Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Base.Six.Four')->get($key);
	 */
	public $base64Builder = [];

	/**
	 * Basic Encryption Field Modeling
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Model.Basic.Field')->get($key);
	 */
	public $basicFieldModeling = [];

	/**
	 * WHMCS Encryption Field Modeling
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Model.Whmcs.Field')->get($key);
	 */
	public $whmcsFieldModeling = [];

	/**
	 * Medium Encryption Field Modeling
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Model.Medium.Field')->get($key);
	 */
	public $mediumFieldModeling = [];

	/**
	 * Expert Field Modeling
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Model.Expert.Field')->get($key);
	 */
	public $expertFieldModeling = [];

	/**
	 * Expert Mode Initiator
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Model.Expert.Field.Initiator')->get($key);
	 */
	public $expertFieldModelInitiator = [];

	/**
	 * Get Items Method List String Fix Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Items.Method.List.String')->get($key);
	 */
	public $getItemsMethodListStringFixBuilder = [];

	/**
	 * Get Items Method Eximport String Fix Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Items.Method.Eximport.String')->get($key);
	 */
	public $getItemsMethodEximportStringFixBuilder = [];

	/**
	 * Selection Translation Fix Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Selection.Translation')->get($key);
	 */
	public $selectionTranslationFixBuilder = [];

	/**
	 * Sort Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Sort')->get($key);
	 */
	public $sortBuilder = [];

	/**
	 * Search Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Search')->get($key);
	 */
	public $searchBuilder = [];

	/**
	 * Filter Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Filter')->get($key);
	 */
	public $filterBuilder = [];

	/**
	 * Set Group Control
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Field.Group.Control')->get($key);
	 */
	public $setGroupControl = [];

	/**
	 * Set Field Names
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Field.Names')->get($key);
	 */
	public $fieldsNames = [];

	/**
	 * Default Fields set to publishing
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.New.Publishing.Fields')->set($key);
	 */
	public $newPublishingFields = [];

	/**
	 * Default Fields set to publishing
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Moved.Publishing.Fields')->set($key);
	 */
	public $movedPublishingFields = [];

	/**
	 * set the Field set of a view
	 *
	 * @param   array   $view            The view data
	 * @param   string  $component       The component name
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Fieldset')->get(...);
	 */
	public function setFieldSet(array $view, string $component, string $nameSingleCode, string $nameListCode)
	{
		return CFactory::_('Compiler.Creator.Fieldset')->
			get($view, $component, $nameSingleCode, $nameListCode);
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
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Fieldset.String')->get(...);
	 */
	protected function stringFieldSet(array $view, string $component, string $nameSingleCode, string $nameListCode,
		string $langView, string $langViews): string
	{
		return CFactory::_('Compiler.Creator.Fieldset.String')->get(
			$view,
			$component,
			$nameSingleCode,
			$nameListCode,
			$langView,
			$langViews
		);
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
	 * @return  string The fields set in string xml
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Fieldset.XML')->get(...);
	 */
	protected function simpleXMLFieldSet(array $view, string $component, string $nameSingleCode,
		string $nameListCode, string $langView, string $langViews): string
	{
		return CFactory::_('Compiler.Creator.Fieldset.XML')->get(
			$view,
			$component,
			$nameSingleCode,
			$nameListCode,
			$langView,
			$langViews
		);
	}

	/**
	 * Check to see if a view has permissions
	 *
	 * @param   array   $view            View details
	 * @param   string  $nameSingleCode  View Single Code Name
	 *
	 * @return  boolean true if it has permisssions
	 * @deprecated 3.3 Use CFactory::_('Adminview.Permission')->check($view, $nameSingleCode);
	 */
	protected function hasPermissionsSet(&$view, &$nameSingleCode)
	{
		return CFactory::_('Adminview.Permission')->check($view, $nameSingleCode);
	}

	/**
	 * set Field Names
	 *
	 * @param   string  $view  View the field belongs to
	 * @param   string  $name  The name of the field
	 *
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Field.Names')->set($view . '.' . $name, $name);
	 */
	public function setFieldsNames(&$view, &$name)
	{
		CFactory::_('Compiler.Builder.Field.Names')->set($view . '.' . $name, $name);
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
	 * @return  mixed The complete field
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Field.Names')->get(...);
	 */
	public function setDynamicField(&$field, &$view, &$viewType, &$langView,
		&$nameSingleCode, &$nameListCode, &$placeholders, &$dbkey, $build)
	{
		CFactory::_('Compiler.Creator.Field.Dynamic')->get($field, $view, $viewType, $langView,
			$nameSingleCode, $nameListCode, $placeholders, $dbkey, $build);
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
	 * @return  mixed   The complete field in string or array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Fieldset.Dynamic')->get(...);
	 */
	public function getFieldsetXML(array &$fields, string &$langView, string &$nameSingleCode,
		string &$nameListCode, array &$placeholders, string &$dbkey, bool $build = false,
		int $returnType = 1)
	{
		return CFactory::_('Compiler.Creator.Fieldset.Dynamic')->get(
			$fields, $langView, $nameSingleCode,
			$nameListCode, $placeholders, $dbkey, $build, $returnType
		);
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
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Field.As.String')->get(...);
	 */
	public function getFieldXMLString(array &$field, array &$view, int &$viewType, string &$langView,
		string &$nameSingleCode, string &$nameListCode, array &$placeholders, string &$dbkey,
		bool $build = false): string
	{
		// get field
		return CFactory::_('Compiler.Creator.Field.As.String')->get(
			$field, $view, $viewType, $langView,
			$nameSingleCode, $nameListCode, $placeholders, $dbkey, $build
		);
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
	 * @param   array|null  $optionArray      The option bucket array used to set the field options if needed.
	 * @param   array   $custom           Used when field is from config
	 * @param   string  $taber            The tabs to add in layout (only in string manipulation)
	 *
	 * @return  SimpleXMLElement The field in xml
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Field.Type')->get(...);
	 */
	private function setField($setType, &$fieldAttributes, &$name, &$typeName,
	                          &$langView, &$nameSingleCode, &$nameListCode, $placeholders,
	                          &$optionArray, $custom = null, $taber = ''
	) {
		return CFactory::_('Compiler.Creator.Field.Type')->get(
			$setType, $fieldAttributes, $name, $typeName,
			$langView, $nameSingleCode, $nameListCode, $placeholders,
			$optionArray, $custom, $taber
		);
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
	 * @param   array|null  $optionArray      The option bucket array used to set the field options if needed.
	 * @param   array   $custom           Used when field is from config
	 * @param   string  $taber            The tabs to add in layout
	 *
	 * @return  SimpleXMLElement The field in xml
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Field.String')->get(...);
	 */
	protected function stringSetField($setType, &$fieldAttributes, &$name,
		&$typeName, &$langView, &$nameSingleCode, &$nameListCode,
		$placeholders, &$optionArray, $custom = null, $taber = '')
	{
		return CFactory::_('Compiler.Creator.Field.String')->get(
			$setType, $fieldAttributes, $name,
			$typeName, $langView, $nameSingleCode, $nameListCode,
			$placeholders, $optionArray, $custom, $taber
		);
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
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Field.XML')->get(...);
	 */
	protected function simpleXMLSetField($setType, &$fieldAttributes, &$name,
		&$typeName, &$langView, &$nameSingleCode, &$nameListCode,
		$placeholders, &$optionArray, $custom = null)
	{
		return CFactory::_('Compiler.Creator.Field.XML')->get(
			$setType, $fieldAttributes, $name,
			$typeName, $langView, $nameSingleCode, $nameListCode,
			$placeholders, $optionArray, $custom
		);
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
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Layout')->set(...);
	 */
	public function setLayoutBuilder($nameSingleCode, $tabName, $name, &$field)
	{
		CFactory::_('Compiler.Creator.Layout')->set($nameSingleCode, $tabName, $name, $field);
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
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Site.Field.Data')->set(...);
	 */
	public function buildSiteFieldData($view, $field, $set, $type)
	{
		CFactory::_('Compiler.Creator.Site.Field.Data')->set($view, $field, $set, $type);
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
	 * @deprecated 3.3 Use CFactory::_('Field.Attributes')->set(...);
	 */
	private function setFieldAttributes(&$field, &$viewType, &$name, &$typeName,
		&$multiple, &$langLabel, $langView, $nameListCode, $nameSingleCode,
		$placeholders, $repeatable = false
	)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_HR_HTHREES_WARNINGHTHREE', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return false;
	}

	/**
	 * set Builders
	 *
	 * @param   string       $langLabel       The language string for field label
	 * @param   string       $langView        The language string of the view
	 * @param   string       $nameSingleCode  The single view name
	 * @param   string       $nameListCode    The list view name
	 * @param   string       $name            The field name
	 * @param   array        $view            The view data
	 * @param   array        $field           The field data
	 * @param   string       $typeName        The field type
	 * @param   bool         $multiple        The switch to set multiple selection option
	 * @param   array|null   $custom          The custom field switch
	 * @param   array|null   $options         The options switch
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Builders')->set(...);
	 */
	public function setBuilders($langLabel, $langView, $nameSingleCode,
		$nameListCode, $name, $view, $field, $typeName, $multiple,
		$custom = null, $options = null
	): void
	{
		CFactory::_('Compiler.Creator.Builders')->set($langLabel, $langView, $nameSingleCode,
			$nameListCode, $name, $view, $field, $typeName, $multiple, $custom, $options);
	}

	/**
	 * set Custom Field Type File
	 *
	 * @param   array   $data            The field complete data set
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $nameSingleCode  The single view code name
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Custom.Field.Type.File')->set(...);
	 */
	public function setCustomFieldTypeFile($data, $nameListCode,$nameSingleCode)
	{
		CFactory::_('Compiler.Creator.Custom.Field.Type.File')->set($data, $nameListCode,$nameSingleCode);
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
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			return $this->setFieldFilterSetJ3($nameSingleCode, $nameListCode);
		}
		return $this->setFieldFilterSetJ4($nameSingleCode, $nameListCode);
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
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			return $this->setFieldFilterListSetJ3($nameSingleCode, $nameListCode);
		}
		return $this->setFieldFilterListSetJ4($nameSingleCode, $nameListCode);
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
	public function setFieldFilterSetJ3(&$nameSingleCode, &$nameListCode)
	{
		// check if this is the above/new filter option
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
		{
			// we first create the file
			$target = array('admin' => 'filter_' . $nameListCode);
			CFactory::_('Utilities.Structure')->build(
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
			$field_filter_sets   = [];
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
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
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
			if (CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.extension")
				&& CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.filter", 0) >= 1)
			{
				$field_filter_sets[] = Indent::_(2) . '<field';
				$field_filter_sets[] = Indent::_(3) . 'type="category"';
				$field_filter_sets[] = Indent::_(3) . 'name="category_id"';
				$field_filter_sets[] = Indent::_(3)
					. 'label="' . CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.name", 'error')
					. '"';
				$field_filter_sets[] = Indent::_(3)
					. 'description="JOPTION_FILTER_CATEGORY_DESC"';
				$field_filter_sets[] = Indent::_(3) . 'multiple="true"';
				$field_filter_sets[] = Indent::_(3)
					. 'class="multipleCategories"';
				$field_filter_sets[] = Indent::_(3) . 'extension="'
					. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension") . '"';
				$field_filter_sets[] = Indent::_(3)
					. 'onchange="this.form.submit();"';
				// TODO NOT SURE IF THIS SHOULD BE STATIC
				$field_filter_sets[] = Indent::_(3) . 'published="0,1,2"';
				$field_filter_sets[] = Indent::_(2) . '/>';
			}
			// add the access filter if this view has access
			// and if access manually is not set
			if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode)
				&& !CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
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
			if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
			{
				foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $n => $filter)
				{
					if ($filter['type'] != 'category')
					{
						$field_filter_sets[] = Indent::_(2) . '<field';
						// if this is a custom field
						if (ArrayHelper::check($filter['custom']))
						{
							// we use the field type from the custom field
							$field_filter_sets[] = Indent::_(3) . 'type="'
								. $filter['type'] . '"';
							// set css classname of this field
							$filter_class = ucfirst((string) $filter['type']);
						}
						else
						{
							// we use the filter field type that was build
							$field_filter_sets[] = Indent::_(3) . 'type="'
								. $filter['filter_type'] . '"';
							// set css classname of this field
							$filter_class = ucfirst((string) $filter['filter_type']);
						}
						// update global data set
						CFactory::_('Compiler.Builder.Filter')->set("{$nameListCode}.{$n}.class", $filter_class);

						$field_filter_sets[] = Indent::_(3) . 'name="'
							. $filter['code'] . '"';
						$field_filter_sets[] = Indent::_(3) . 'label="'
							. $filter['label'] . '"';

						// if this is a multi field
						if ($filter['multi'] == 2)
						{
							$field_filter_sets[] = Indent::_(3) . 'class="multiple' . $filter_class . '"';
							$field_filter_sets[] = Indent::_(3) . 'multiple="true"';
						}
						else
						{
							$field_filter_sets[] = Indent::_(3) . 'multiple="false"';
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
	public function setFieldFilterListSetJ3(&$nameSingleCode, &$nameListCode)
	{
		// check if this is the above/new filter option
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
		{
			// keep track of all fields already added
			$donelist = array('ordering' => true, 'id' => true);
			// now build the XML
			$list_sets   = [];
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
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
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
			if (CFactory::_('Compiler.Builder.Sort')->exists($nameListCode))
			{
				foreach (CFactory::_('Compiler.Builder.Sort')->get($nameListCode) as $filter)
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
	 * set the Filter Field set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 */
	public function setFieldFilterSetJ4(&$nameSingleCode, &$nameListCode)
	{
		// check if this is the above/new filter option
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
		{
			// we first create the file
			$target = ['admin' => 'filter_' . $nameListCode];
			CFactory::_('Utilities.Structure')->build(
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
			$field_filter_sets   = [];
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
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
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
					. 'class="js-select-submit-on-change"';
				$field_filter_sets[] = Indent::_(2) . '>';
				$field_filter_sets[] = Indent::_(3)
					. '<option value="">JOPTION_SELECT_PUBLISHED</option>';
				$field_filter_sets[] = Indent::_(2) . '</field>';
			}
			// add the category if found
			if (CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.extension")
				&& CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.filter", 0) >= 1)
			{
				$field_filter_sets[] = Indent::_(2) . '<field';
				$field_filter_sets[] = Indent::_(3) . 'type="category"';
				$field_filter_sets[] = Indent::_(3) . 'name="category_id"';
				$field_filter_sets[] = Indent::_(3)
					. 'label="' . CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.name", 'error')
					. '"';
				$field_filter_sets[] = Indent::_(3)
					. 'description="JOPTION_FILTER_CATEGORY_DESC"';
				$field_filter_sets[] = Indent::_(3) . 'multiple="true"';
				$field_filter_sets[] = Indent::_(3)
					. 'class="js-select-submit-on-change"';
				$field_filter_sets[] = Indent::_(3) . 'extension="'
					. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension") . '"';
				$field_filter_sets[] = Indent::_(3)
					. 'layout="joomla.form.field.list-fancy-select"';
				// TODO NOT SURE IF THIS SHOULD BE STATIC
				$field_filter_sets[] = Indent::_(3) . 'published="0,1,2"';
				$field_filter_sets[] = Indent::_(2) . '/>';
			}
			// add the access filter if this view has access
			// and if access manually is not set
			if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode)
				&& !CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
			{
				$field_filter_sets[] = Indent::_(2) . '<field';
				$field_filter_sets[] = Indent::_(3) . 'type="accesslevel"';
				$field_filter_sets[] = Indent::_(3) . 'name="access"';
				$field_filter_sets[] = Indent::_(3)
					. 'label="JGRID_HEADING_ACCESS"';
				$field_filter_sets[] = Indent::_(3)
					. 'hint="JOPTION_SELECT_ACCESS"';
				$field_filter_sets[] = Indent::_(3) . 'multiple="true"';
				$field_filter_sets[] = Indent::_(3)
					. 'class="js-select-submit-on-change"';
				$field_filter_sets[] = Indent::_(3)
					. 'layout="joomla.form.field.list-fancy-select"';
				$field_filter_sets[] = Indent::_(2) . '/>';
			}
			// now add the dynamic fields
			if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
			{
				foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $n => $filter)
				{
					if ($filter['type'] != 'category')
					{
						$field_filter_sets[] = Indent::_(2) . '<field';
						// if this is a custom field
						if (ArrayHelper::check($filter['custom']))
						{
							// we use the field type from the custom field
							$field_filter_sets[] = Indent::_(3) . 'type="'
								. $filter['type'] . '"';
							// set css classname of this field
							$filter_class = ucfirst((string) $filter['type']);
						}
						else
						{
							// we use the filter field type that was build
							$field_filter_sets[] = Indent::_(3) . 'type="'
								. $filter['filter_type'] . '"';
							// set css classname of this field
							$filter_class = ucfirst((string) $filter['filter_type']);
						}

						$field_filter_sets[] = Indent::_(3) . 'name="'
							. $filter['code'] . '"';
						$field_filter_sets[] = Indent::_(3) . 'label="'
							. $filter['label'] . '"';

						// if this is a multi field
						if ($filter['multi'] == 2)
						{
							$field_filter_sets[] = Indent::_(3) . 'layout="joomla.form.field.list-fancy-select"';
							$field_filter_sets[] = Indent::_(3) . 'multiple="true"';
							if (isset($filter['lang_select']))
							{
								$field_filter_sets[] = Indent::_(3) . 'hint="' . $filter['lang_select'] . '"';
							}
						}
						else
						{
							$field_filter_sets[] = Indent::_(3) . 'multiple="false"';
						}

						// we add the on change css class
						$field_filter_sets[] = Indent::_(3) . 'class="js-select-submit-on-change"';
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
	public function setFieldFilterListSetJ4(&$nameSingleCode, &$nameListCode)
	{
		// check if this is the above/new filter option
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
		{
			// keep track of all fields already added
			$donelist = ['ordering' => true, 'id' => true];
			// now build the XML
			$list_sets   = [];
			$list_sets[] = Indent::_(1) . '<fields name="list">';
			$list_sets[] = Indent::_(2) . '<field';
			$list_sets[] = Indent::_(3) . 'name="fullordering"';
			$list_sets[] = Indent::_(3) . 'type="list"';
			$list_sets[] = Indent::_(3)
				. 'label="JGLOBAL_SORT_BY"';
			$list_sets[] = Indent::_(3) . 'class="js-select-submit-on-change"';
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
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
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
			if (CFactory::_('Compiler.Builder.Sort')->exists($nameListCode))
			{
				foreach (CFactory::_('Compiler.Builder.Sort')->get($nameListCode) as $filter)
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
			$list_sets[] = Indent::_(3) . 'label="JGLOBAL_LIST_LIMIT"';
			$list_sets[] = Indent::_(3) . 'default="25"';
			$list_sets[] = Indent::_(3) . 'class="js-select-submit-on-change"';
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
		if (!CFactory::_('Compiler.Builder.Content.Multi')->
			isArray('customfilterfield_' . $filter['filter_type']))
		{
			// start loading the field type
			// $this->fileContentDynamic['customfilterfield_'
			// . $filter['filter_type']]
			// = [];
			// JPREFIX <<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set('customfilterfield_' . $filter['filter_type'] . '|JPREFIX', 'J');
			// Type <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set('customfilterfield_' . $filter['filter_type'] . '|Type',
				StringHelper::safe(
					$filter['filter_type'], 'F'
				)
			);
			// type <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set('customfilterfield_' . $filter['filter_type'] . '|type',
				StringHelper::safe($filter['filter_type'])
			);
			// JFORM_GETOPTIONS_PHP <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set('customfilterfield_' . $filter['filter_type'] . '|JFORM_GETOPTIONS_PHP',
				$getOptions
			);
			// ADD_BUTTON <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set('customfilterfield_' . $filter['filter_type'] . '|ADD_BUTTON', '');
			// now build the custom filter field type file
			$target = array('admin' => 'customfilterfield');
			CFactory::_('Utilities.Structure')->build(
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
	 * @deprecated 3.3 Use CFactory::_('Field.Input.Button')->get($fieldData);
	 */
	protected function setAddButtonToListField($fieldData)
	{
		return CFactory::_('Field.Input.Button')->get($fieldData);
	}

	/**
	 * xmlPrettyPrint
	 *
	 * @param   SimpleXMLElement  $xml       The XML element containing a node to be output
	 * @param   string            $nodename  node name of the input xml element to print out.  this is done to omit the <?xml... tag
	 *
	 * @return  string XML output
	 * @deprecated 3.3 Use CFactory::_('Utilities.Xml')->pretty($xml, $nodename);
	 */
	public function xmlPrettyPrint($xml, $nodename)
	{
		return CFactory::_('Utilities.Xml')->pretty($xml, $nodename);
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
	 * @deprecated 3.3 Use CFactory::_('Utilities.Xml')->indent(...);
	 */
	public function xmlIndent($string, $char = ' ', $depth = 0,
	                          $skipfirst = false, $skiplast = false
	) {
		return CFactory::_('Utilities.Xml')->indent($string, $char, $depth, $skipfirst, $skiplast);
	}
}

