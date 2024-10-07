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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplication;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Layout;
use VDM\Joomla\Componentbuilder\Compiler\Creator\SiteFieldData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseTables;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueKeys;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseKeys;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueGuid;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListJoin;
use VDM\Joomla\Componentbuilder\Compiler\Builder\History;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Alias;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Title;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryOtherName;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Lists;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomList;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldRelations;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HiddenFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\IntegerFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DynamicFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MainTextField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomFieldLinks;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ScriptUserSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ScriptMediaSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryCode;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CheckBox;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\BaseSixFour;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelBasicField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelWhmcsField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelMediumField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertFieldInitiator;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItem;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ItemsMethodListString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItemArray;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ItemsMethodEximportString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SelectionTranslation;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Search;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ComponentFields;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Compiler Creator Builders
 * 
 * @since 3.2.0
 */
final class Builders
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Power Class.
	 *
	 * @var   Power
	 * @since 3.2.0
	 */
	protected Power $power;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Layout Class.
	 *
	 * @var   Layout
	 * @since 3.2.0
	 */
	protected Layout $layout;

	/**
	 * The SiteFieldData Class.
	 *
	 * @var   SiteFieldData
	 * @since 3.2.0
	 */
	protected SiteFieldData $sitefielddata;

	/**
	 * The Tags Class.
	 *
	 * @var   Tags
	 * @since 3.2.0
	 */
	protected Tags $tags;

	/**
	 * The DatabaseTables Class.
	 *
	 * @var   DatabaseTables
	 * @since 3.2.0
	 */
	protected DatabaseTables $databasetables;

	/**
	 * The DatabaseUniqueKeys Class.
	 *
	 * @var   DatabaseUniqueKeys
	 * @since 3.2.0
	 */
	protected DatabaseUniqueKeys $databaseuniquekeys;

	/**
	 * The DatabaseKeys Class.
	 *
	 * @var   DatabaseKeys
	 * @since 3.2.0
	 */
	protected DatabaseKeys $databasekeys;

	/**
	 * The DatabaseUniqueGuid Class.
	 *
	 * @var   DatabaseUniqueGuid
	 * @since 3.2.0
	 */
	protected DatabaseUniqueGuid $databaseuniqueguid;

	/**
	 * The ListJoin Class.
	 *
	 * @var   ListJoin
	 * @since 3.2.0
	 */
	protected ListJoin $listjoin;

	/**
	 * The History Class.
	 *
	 * @var   History
	 * @since 3.2.0
	 */
	protected History $history;

	/**
	 * The Alias Class.
	 *
	 * @var   Alias
	 * @since 3.2.0
	 */
	protected Alias $alias;

	/**
	 * The Title Class.
	 *
	 * @var   Title
	 * @since 3.2.0
	 */
	protected Title $title;

	/**
	 * The CategoryOtherName Class.
	 *
	 * @var   CategoryOtherName
	 * @since 3.2.0
	 */
	protected CategoryOtherName $categoryothername;

	/**
	 * The Lists Class.
	 *
	 * @var   Lists
	 * @since 3.2.0
	 */
	protected Lists $lists;

	/**
	 * The CustomList Class.
	 *
	 * @var   CustomList
	 * @since 3.2.0
	 */
	protected CustomList $customlist;

	/**
	 * The FieldRelations Class.
	 *
	 * @var   FieldRelations
	 * @since 3.2.0
	 */
	protected FieldRelations $fieldrelations;

	/**
	 * The HiddenFields Class.
	 *
	 * @var   HiddenFields
	 * @since 3.2.0
	 */
	protected HiddenFields $hiddenfields;

	/**
	 * The IntegerFields Class.
	 *
	 * @var   IntegerFields
	 * @since 3.2.0
	 */
	protected IntegerFields $integerfields;

	/**
	 * The DynamicFields Class.
	 *
	 * @var   DynamicFields
	 * @since 3.2.0
	 */
	protected DynamicFields $dynamicfields;

	/**
	 * The MainTextField Class.
	 *
	 * @var   MainTextField
	 * @since 3.2.0
	 */
	protected MainTextField $maintextfield;

	/**
	 * The CustomField Class.
	 *
	 * @var   CustomField
	 * @since 3.2.0
	 */
	protected CustomField $customfield;

	/**
	 * The CustomFieldLinks Class.
	 *
	 * @var   CustomFieldLinks
	 * @since 3.2.0
	 */
	protected CustomFieldLinks $customfieldlinks;

	/**
	 * The ScriptUserSwitch Class.
	 *
	 * @var   ScriptUserSwitch
	 * @since 3.2.0
	 */
	protected ScriptUserSwitch $scriptuserswitch;

	/**
	 * The ScriptMediaSwitch Class.
	 *
	 * @var   ScriptMediaSwitch
	 * @since 3.2.0
	 */
	protected ScriptMediaSwitch $scriptmediaswitch;

	/**
	 * The Category Class.
	 *
	 * @var   Category
	 * @since 3.2.0
	 */
	protected Category $category;

	/**
	 * The CategoryCode Class.
	 *
	 * @var   CategoryCode
	 * @since 3.2.0
	 */
	protected CategoryCode $categorycode;

	/**
	 * The CheckBox Class.
	 *
	 * @var   CheckBox
	 * @since 3.2.0
	 */
	protected CheckBox $checkbox;

	/**
	 * The JsonString Class.
	 *
	 * @var   JsonString
	 * @since 3.2.0
	 */
	protected JsonString $jsonstring;

	/**
	 * The BaseSixFour Class.
	 *
	 * @var   BaseSixFour
	 * @since 3.2.0
	 */
	protected BaseSixFour $basesixfour;

	/**
	 * The ModelBasicField Class.
	 *
	 * @var   ModelBasicField
	 * @since 3.2.0
	 */
	protected ModelBasicField $modelbasicfield;

	/**
	 * The ModelWhmcsField Class.
	 *
	 * @var   ModelWhmcsField
	 * @since 3.2.0
	 */
	protected ModelWhmcsField $modelwhmcsfield;

	/**
	 * The ModelMediumField Class.
	 *
	 * @var   ModelMediumField
	 * @since 3.2.0
	 */
	protected ModelMediumField $modelmediumfield;

	/**
	 * The ModelExpertFieldInitiator Class.
	 *
	 * @var   ModelExpertFieldInitiator
	 * @since 3.2.0
	 */
	protected ModelExpertFieldInitiator $modelexpertfieldinitiator;

	/**
	 * The ModelExpertField Class.
	 *
	 * @var   ModelExpertField
	 * @since 3.2.0
	 */
	protected ModelExpertField $modelexpertfield;

	/**
	 * The JsonItem Class.
	 *
	 * @var   JsonItem
	 * @since 3.2.0
	 */
	protected JsonItem $jsonitem;

	/**
	 * The ItemsMethodListString Class.
	 *
	 * @var   ItemsMethodListString
	 * @since 3.2.0
	 */
	protected ItemsMethodListString $itemsmethodliststring;

	/**
	 * The JsonItemArray Class.
	 *
	 * @var   JsonItemArray
	 * @since 3.2.0
	 */
	protected JsonItemArray $jsonitemarray;

	/**
	 * The ItemsMethodEximportString Class.
	 *
	 * @var   ItemsMethodEximportString
	 * @since 3.2.0
	 */
	protected ItemsMethodEximportString $itemsmethodeximportstring;

	/**
	 * The SelectionTranslation Class.
	 *
	 * @var   SelectionTranslation
	 * @since 3.2.0
	 */
	protected SelectionTranslation $selectiontranslation;

	/**
	 * The AdminFilterType Class.
	 *
	 * @var   AdminFilterType
	 * @since 3.2.0
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The Sort Class.
	 *
	 * @var   Sort
	 * @since 3.2.0
	 */
	protected Sort $sort;

	/**
	 * The Search Class.
	 *
	 * @var   Search
	 * @since 3.2.0
	 */
	protected Search $search;

	/**
	 * The Filter Class.
	 *
	 * @var   Filter
	 * @since 3.2.0
	 */
	protected Filter $filter;

	/**
	 * The ComponentFields Class.
	 *
	 * @var   ComponentFields
	 * @since 3.2.0
	 */
	protected ComponentFields $componentfields;

	/**
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor.
	 *
	 * @param Config                      $config                      The Config Class.
	 * @param Power                       $power                       The Power Class.
	 * @param Language                    $language                    The Language Class.
	 * @param Placeholder                 $placeholder                 The Placeholder Class.
	 * @param Layout                      $layout                      The Layout Class.
	 * @param SiteFieldData               $sitefielddata               The SiteFieldData Class.
	 * @param Tags                        $tags                        The Tags Class.
	 * @param DatabaseTables              $databasetables              The DatabaseTables Class.
	 * @param DatabaseUniqueKeys          $databaseuniquekeys          The DatabaseUniqueKeys Class.
	 * @param DatabaseKeys                $databasekeys                The DatabaseKeys Class.
	 * @param DatabaseUniqueGuid          $databaseuniqueguid          The DatabaseUniqueGuid Class.
	 * @param ListJoin                    $listjoin                    The ListJoin Class.
	 * @param History                     $history                     The History Class.
	 * @param Alias                       $alias                       The Alias Class.
	 * @param Title                       $title                       The Title Class.
	 * @param CategoryOtherName           $categoryothername           The CategoryOtherName Class.
	 * @param Lists                       $lists                       The Lists Class.
	 * @param CustomList                  $customlist                  The CustomList Class.
	 * @param FieldRelations              $fieldrelations              The FieldRelations Class.
	 * @param HiddenFields                $hiddenfields                The HiddenFields Class.
	 * @param IntegerFields               $integerfields               The IntegerFields Class.
	 * @param DynamicFields               $dynamicfields               The DynamicFields Class.
	 * @param MainTextField               $maintextfield               The MainTextField Class.
	 * @param CustomField                 $customfield                 The CustomField Class.
	 * @param CustomFieldLinks            $customfieldlinks            The CustomFieldLinks Class.
	 * @param ScriptUserSwitch            $scriptuserswitch            The ScriptUserSwitch Class.
	 * @param ScriptMediaSwitch           $scriptmediaswitch           The ScriptMediaSwitch Class.
	 * @param Category                    $category                    The Category Class.
	 * @param CategoryCode                $categorycode                The CategoryCode Class.
	 * @param CheckBox                    $checkbox                    The CheckBox Class.
	 * @param JsonString                  $jsonstring                  The JsonString Class.
	 * @param BaseSixFour                 $basesixfour                 The BaseSixFour Class.
	 * @param ModelBasicField             $modelbasicfield             The ModelBasicField Class.
	 * @param ModelWhmcsField             $modelwhmcsfield             The ModelWhmcsField Class.
	 * @param ModelMediumField            $modelmediumfield            The ModelMediumField Class.
	 * @param ModelExpertFieldInitiator   $modelexpertfieldinitiator   The ModelExpertFieldInitiator Class.
	 * @param ModelExpertField            $modelexpertfield            The ModelExpertField Class.
	 * @param JsonItem                    $jsonitem                    The JsonItem Class.
	 * @param ItemsMethodListString       $itemsmethodliststring       The ItemsMethodListString Class.
	 * @param JsonItemArray               $jsonitemarray               The JsonItemArray Class.
	 * @param ItemsMethodEximportString   $itemsmethodeximportstring   The ItemsMethodEximportString Class.
	 * @param SelectionTranslation        $selectiontranslation        The SelectionTranslation Class.
	 * @param AdminFilterType             $adminfiltertype             The AdminFilterType Class.
	 * @param Sort                        $sort                        The Sort Class.
	 * @param Search                      $search                      The Search Class.
	 * @param Filter                      $filter                      The Filter Class.
	 * @param ComponentFields             $componentfields             The ComponentFields Class.
	 * @param CMSApplication|null         $app                         The app object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Power $power, Language $language,
		Placeholder $placeholder, Layout $layout,
		SiteFieldData $sitefielddata, Tags $tags,
		DatabaseTables $databasetables,
		DatabaseUniqueKeys $databaseuniquekeys,
		DatabaseKeys $databasekeys,
		DatabaseUniqueGuid $databaseuniqueguid,
		ListJoin $listjoin, History $history, Alias $alias,
		Title $title, CategoryOtherName $categoryothername,
		Lists $lists, CustomList $customlist,
		FieldRelations $fieldrelations,
		HiddenFields $hiddenfields, IntegerFields $integerfields,
		DynamicFields $dynamicfields,
		MainTextField $maintextfield, CustomField $customfield,
		CustomFieldLinks $customfieldlinks,
		ScriptUserSwitch $scriptuserswitch,
		ScriptMediaSwitch $scriptmediaswitch, Category $category,
		CategoryCode $categorycode, CheckBox $checkbox,
		JsonString $jsonstring, BaseSixFour $basesixfour,
		ModelBasicField $modelbasicfield,
		ModelWhmcsField $modelwhmcsfield,
		ModelMediumField $modelmediumfield,
		ModelExpertFieldInitiator $modelexpertfieldinitiator,
		ModelExpertField $modelexpertfield, JsonItem $jsonitem,
		ItemsMethodListString $itemsmethodliststring,
		JsonItemArray $jsonitemarray,
		ItemsMethodEximportString $itemsmethodeximportstring,
		SelectionTranslation $selectiontranslation,
		AdminFilterType $adminfiltertype, Sort $sort,
		Search $search, Filter $filter,
		ComponentFields $componentfields, ?CMSApplication $app = null)
	{
		$this->config = $config;
		$this->power = $power;
		$this->language = $language;
		$this->placeholder = $placeholder;
		$this->layout = $layout;
		$this->sitefielddata = $sitefielddata;
		$this->tags = $tags;
		$this->databasetables = $databasetables;
		$this->databaseuniquekeys = $databaseuniquekeys;
		$this->databasekeys = $databasekeys;
		$this->databaseuniqueguid = $databaseuniqueguid;
		$this->listjoin = $listjoin;
		$this->history = $history;
		$this->alias = $alias;
		$this->title = $title;
		$this->categoryothername = $categoryothername;
		$this->lists = $lists;
		$this->customlist = $customlist;
		$this->fieldrelations = $fieldrelations;
		$this->hiddenfields = $hiddenfields;
		$this->integerfields = $integerfields;
		$this->dynamicfields = $dynamicfields;
		$this->maintextfield = $maintextfield;
		$this->customfield = $customfield;
		$this->customfieldlinks = $customfieldlinks;
		$this->scriptuserswitch = $scriptuserswitch;
		$this->scriptmediaswitch = $scriptmediaswitch;
		$this->category = $category;
		$this->categorycode = $categorycode;
		$this->checkbox = $checkbox;
		$this->jsonstring = $jsonstring;
		$this->basesixfour = $basesixfour;
		$this->modelbasicfield = $modelbasicfield;
		$this->modelwhmcsfield = $modelwhmcsfield;
		$this->modelmediumfield = $modelmediumfield;
		$this->modelexpertfieldinitiator = $modelexpertfieldinitiator;
		$this->modelexpertfield = $modelexpertfield;
		$this->jsonitem = $jsonitem;
		$this->itemsmethodliststring = $itemsmethodliststring;
		$this->jsonitemarray = $jsonitemarray;
		$this->itemsmethodeximportstring = $itemsmethodeximportstring;
		$this->selectiontranslation = $selectiontranslation;
		$this->adminfiltertype = $adminfiltertype;
		$this->sort = $sort;
		$this->search = $search;
		$this->filter = $filter;
		$this->componentfields = $componentfields;
		$this->app = $app ?: Factory::getApplication();
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
	 * @since 3.2.0
	 */
	public function set(string $langLabel, string $langView, string $nameSingleCode,
		string $nameListCode, string $name, array $view, array $field,
		string $typeName, bool $multiple, ?array $custom = null,
		?array $options = null): void
	{
		// check if this is a tag field
		if ($typeName === 'tag')
		{
			// set tags for this view but don't load to DB
			$this->tags->set($nameSingleCode, true);
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
			$this->databasetables->set($nameSingleCode . '.' . $name . '.type',
				$field['settings']->datatype);
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
							',', '.', (string) $field['settings']->datadefault_other
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
				$this->databasetables->set($nameSingleCode . '.' . $name . '.lenght',
					$field['settings']->datalenght);
				$this->databasetables->set($nameSingleCode . '.' . $name . '.lenght_other',
					$field['settings']->datalenght_other);
				$this->databasetables->set($nameSingleCode . '.' . $name . '.default',
					$field['settings']->datadefault);
				$this->databasetables->set($nameSingleCode . '.' . $name . '.other',
					$field['settings']->datadefault_other);
			}
			// fall back unto EMPTY for text
			else
			{
				$this->databasetables->set($nameSingleCode . '.' . $name . '.default',
					'EMPTY');
			}
			// to identify the field
			$this->databasetables->set($nameSingleCode . '.' . $name . '.ID',
				$field['settings']->id);
			$this->databasetables->set($nameSingleCode . '.' . $name . '.null_switch',
				$field['settings']->null_switch);
			// set index types
			$_guid = true;
			$databaseuniquekey = false;
			$databasekey = false;
			if ($field['settings']->indexes == 1
				&& !in_array(
					$field['settings']->datatype, $textKeys
				))
			{
				// build unique keys of this view for db
				$this->databaseuniquekeys->add($nameSingleCode, $name, true);
				$databaseuniquekey = true;
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
				$this->databasekeys->add($nameSingleCode, $name, true);
				$databasekey = true;
			}
			// special treatment for GUID
			if ('guid' === $name && $_guid)
			{
				$this->databaseuniqueguid->set($nameSingleCode, true);
			}
		}
		// set list switch
		$listSwitch = (isset($field['list'])
			&& ($field['list'] == 1
				|| $field['list'] == 3
				|| $field['list'] == 4));
		// set list join
		$listJoin
			= $this->listjoin->exists($nameListCode . '.' . (int) $field['field']);
		// add history to this view
		if (isset($view['history']) && $view['history'])
		{
			$this->history->set($nameSingleCode, true);
		}
		// set Alias (only one title per view)
		if ($dbSwitch && isset($field['alias']) && $field['alias']
			&& !$this->alias->get($nameSingleCode))
		{
			$this->alias->set($nameSingleCode, $name);
		}
		// set Titles (only one title per view)
		if ($dbSwitch && isset($field['title']) && $field['title']
			&& !$this->title->get($nameSingleCode))
		{
			$this->title->set($nameSingleCode, $name);
		}
		// category name fix
		if ($typeName === 'category')
		{
			$tempName = $this->categoryothername->
				get($nameListCode . '.name', $nameListCode . ' categories');
			// set lang
			$listLangName = $langView . '_'
				. FieldHelper::safe($tempName, true);
			// set field name
			$listFieldName = StringHelper::safe($tempName, 'W');
			// add to lang array
			$this->language->set(
				$this->config->lang_target, $listLangName, $listFieldName
			);
		}
		else
		{
			// if label was set use instead
			if (StringHelper::check($langLabel))
			{
				$listLangName = $langLabel;
				// get field label from the lang label
				if ($this->language->exist($this->config->lang_target, $langLabel))
				{
					$listFieldName
						= $this->language->get($this->config->lang_target, $langLabel);
				}
				else
				{
					// get it from the field xml string
					$listFieldName = (string) $this->placeholder->update_(
						GetHelper::between(
							$field['settings']->xml, 'label="',
							'"'
						)
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
				$this->language->set(
					$this->config->lang_target, $listLangName, $listFieldName
				);
			}
		}
		// extends value
		$extends_field = $custom['extends'] ?? '';
		// build the list values
		if (($listSwitch || $listJoin) && $typeName != 'repeatable'
			&& $typeName != 'subform')
		{
			// load to list builder
			if ($listSwitch)
			{
				// append values
				$this->lists->add($nameListCode, [
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
					'target'   => (int) $field['list']
				], true);
			}
			// build custom builder list
			if ($listSwitch || $listJoin)
			{
				$this->customlist->set($nameSingleCode . '.' . $name, true);
			}
		}
		// load the list join builder
		if ($listJoin)
		{
			$this->listjoin->set($nameListCode . '.' . (int) $field['field'], [
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
				'options'  => $options
			]);
		}
		// update the field relations
		if (($field_relations =
				$this->fieldrelations->get($nameListCode . '.' . (int) $field['field'])) !== null)
		{
			$field_relations = (array) $field_relations;
			foreach ($field_relations as $area => &$field_values)
			{
				$field_values['type']   = $typeName;
				$field_values['code']   = $name;
				$field_values['custom'] = $custom;
			}
			$this->fieldrelations->set($nameListCode . '.' . (int) $field['field'], $field_relations);
		}
		// set the hidden field of this view
		if ($dbSwitch && $typeName === 'hidden')
		{
			$this->hiddenfields->add($nameSingleCode, ',"' . $name . '"', true);
		}
		// set all int fields of this view
		if ($dbSwitch && isset($field['settings']->datatype)
			&& ($field['settings']->datatype === 'INT'
				|| $field['settings']->datatype === 'TINYINT'
				|| $field['settings']->datatype === 'BIGINT'))
		{
			$this->integerfields->add($nameSingleCode, ',"' . $name . '"', true);
		}
		// Get the default fields
		$default_fields = $this->config->default_fields;
		// set all dynamic field of this view
		if ($dbSwitch && $typeName != 'category' && $typeName != 'repeatable'
			&& $typeName != 'subform' && !in_array($name, $default_fields))
		{
			$this->dynamicfields->add($nameSingleCode, '"' . $name . '":"' . $name . '"', true);
		}
		// TODO we may need to add a switch instead (since now it uses the first editor field)
		// set the main(biggest) text field of this view
		if ($dbSwitch && $typeName === 'editor')
		{
			if (!$this->maintextfield->exists($nameSingleCode))
			{
				$this->maintextfield->set($nameSingleCode, $name);
			}
		}
		// set the custom builder
		if (ArrayHelper::check($custom)
			&& $typeName != 'category'
			&& $typeName != 'repeatable'
			&& $typeName != 'subform')
		{
			$this->customfield->add($nameListCode, [
				'type'   => $typeName,
				'code'   => $name,
				'lang'   => $listLangName,
				'custom' => $custom,
				'method' => $field['settings']->store
			], true);

			// only load this if table is set
			if (isset($custom['table'])
				&& StringHelper::check(
					$custom['table']
				))
			{
				// set the custom fields needed in content type data
				$this->customfieldlinks->add(
					$nameSingleCode,
					',{"sourceColumn": "' . $name . '","targetTable": "' . $custom['table']
					. '","targetColumn": "' . $custom['id'] . '","displayColumn": "' . $custom['text'] . '"}',
					true
				);
			}
			// build script switch for user
			if ($extends_field === 'user')
			{
				$this->scriptuserswitch->set($typeName, $typeName);
			}
		}
		if ($typeName === 'media')
		{
			$this->scriptmediaswitch->set($typeName, $typeName);
		}
		// setup category for this view
		if ($dbSwitch && $typeName === 'category')
		{
			$otherViews = $this->categoryothername->
				get($nameListCode . '.views', $nameListCode);
			$otherView  = $this->categoryothername->
				get($nameListCode . '.view', $nameSingleCode);
			// get the xml extension name
			$_extension = $this->placeholder->update_(
				GetHelper::between(
					$field['settings']->xml, 'extension="', '"'
				)
			);
			// if they left out the extension for some reason
			if (!StringHelper::check($_extension))
			{
				$_extension = 'com_' . $this->config->component_code_name . '.'
					. $otherView;
			}
			// check the context (does our target match)
			if (strpos((string) $_extension, '.') !== false)
			{
				$target_view = trim(explode('.', (string) $_extension)[1]);
				// from my understanding the target extension view and the otherView must align
				// so I will here check that it does, and if not raise an error message to fix this
				if ($target_view !== $otherView)
				{
					$target_extension = trim(explode('.', (string) $_extension)[0]);
					$correction       = $target_extension . '.' . $otherView;
					$this->app->enqueueMessage(
						Text::sprintf(
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
			$this->category->set($nameListCode, [
				'code'      => $name,
				'name'      => $listLangName,
				'extension' => $_extension,
				'filter'    => $field['filter'],
				'add_icon'  => StringHelper::check($view['settings']->icon_category)
			]);
			// also set code name for title alias fix
			$this->categorycode->set($nameSingleCode, [
				'code'  => $name,
				'views' => $otherViews,
				'view'  => $otherView
			]);
		}
		// setup checkbox for this view
		if ($dbSwitch && ($typeName === 'checkbox' ||
				(ArrayHelper::check($custom) && $extends_field === 'checkboxes')))
		{
			$this->checkbox->add($nameSingleCode, $name, true);
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
					$this->jsonstring->add($nameSingleCode, $name, true);
					// Site settings of each field if needed
					$this->sitefielddata->set(
						$nameSingleCode, $name, 'json', $typeName
					);
					// add open close method to field data
					$field['store'] = 'json';
					break;
				case 2:
					// BASE_SIXTY_FOUR
					$this->basesixfour->add($nameSingleCode, $name, true);
					// Site settings of each field if needed
					$this->sitefielddata->set(
						$nameSingleCode, $name, 'base64', $typeName
					);
					// add open close method to field data
					$field['store'] = 'base64';
					break;
				case 3:
					// BASIC_ENCRYPTION_LOCALKEY
					$this->modelbasicfield->add($nameSingleCode, $name, true);
					// Site settings of each field if needed
					$this->sitefielddata->set(
						$nameSingleCode, $name, 'basic_encryption', $typeName
					);
					// make sure to load FOF encryption (power)
					$this->power->get('99175f6d-dba8-4086-8a65-5c4ec175e61d', 1);
					// add open close method to field data
					$field['store'] = 'basic_encryption';
					break;
				case 4:
					// WHMCS_ENCRYPTION_VDMKEY (DUE REMOVAL)
					$this->modelwhmcsfield->add($nameSingleCode, $name, true);
					// Site settings of each field if needed
					$this->sitefielddata->set(
						$nameSingleCode, $name, 'whmcs_encryption', $typeName
					);
					// make sure to load FOF encryption (power)
					$this->power->get('99175f6d-dba8-4086-8a65-5c4ec175e61d', 1);
					// add open close method to field data
					$field['store'] = 'whmcs_encryption';
					break;
				case 5:
					// MEDIUM_ENCRYPTION_LOCALFILE
					$this->modelmediumfield->add($nameSingleCode, $name, true);
					// Site settings of each field if needed
					$this->sitefielddata->set(
						$nameSingleCode, $name, 'medium_encryption', $typeName
					);
					// make sure to load FOF encryption (power)
					$this->power->get('99175f6d-dba8-4086-8a65-5c4ec175e61d', 1);
					// add open close method to field data
					$field['store'] = 'medium_encryption';
					break;
				case 6:
					// EXPERT_MODE
					if (isset($field['settings']->model_field))
					{
						if (isset($field['settings']->initiator_save_key))
						{
							$this->modelexpertfieldinitiator->set(
								$nameSingleCode . '.save.' . $field['settings']->initiator_save_key
								, $field['settings']->initiator_save
							);
						}
						if (isset($field['settings']->initiator_get_key))
						{
							$this->modelexpertfieldinitiator->set(
								$nameSingleCode . '.get.' . $field['settings']->initiator_get_key
								, $field['settings']->initiator_get
							);
						}
						$this->modelexpertfield->set(
							$nameSingleCode . '.' . $name, $field['settings']->model_field
						);
						// Site settings of each field if needed
						$this->sitefielddata->set(
							$nameSingleCode, $name, 'expert_mode', $typeName
						);
					}
					break;
				default:
					// JSON_ARRAY_ENCODE
					$this->jsonitem->add($nameSingleCode, $name, true);
					// Site settings of each field if needed
					$this->sitefielddata->set(
						$nameSingleCode, $name, 'json', $typeName
					);
					// no londer add the json again (already added)
					$subformJsonSwitch = false;
					// add open close method to field data
					$field['store'] = 'json';
					break;
			}
			// just a heads-up for usergroups set to multiple
			if ($typeName === 'usergroup' || $typeName === 'usergrouplist')
			{
				$this->sitefielddata->set(
					$nameSingleCode, $name, 'json', $typeName
				);
			}

			// load the model list display fix
			if (($listSwitch || $listJoin)
				&& (($typeName != 'repeatable' && $typeName != 'subform') || $field['settings']->store == 6))
			{
				$this->itemsmethodliststring->add($nameSingleCode, [
					'name' => $name,
					'type' => $typeName,
					'translation' => (bool) ArrayHelper::check($options),
					'custom' => $custom,
					'method' => $field['settings']->store
				], true);
			}

			// subform housekeeping (only if not advance modeling)
			if ('subform' === $typeName && $field['settings']->store != 6)
			{
				// the values must revert to array
				$this->jsonitemarray->add($nameSingleCode, $name, true);
				// should the json builder still be added
				if ($subformJsonSwitch)
				{
					// and insure the if is converted to json
					$this->jsonitem->add($nameSingleCode, $name, true);
					// Site settings of each field if needed
					$this->sitefielddata->set(
						$nameSingleCode, $name, 'json', $typeName
					);
				}
			}
		}
		// build the data for the export & import methods $typeName === 'repeatable' ||
		if ($dbSwitch && (($typeName === 'checkboxes' || $multiple || $field['settings']->store != 0)
				&& !ArrayHelper::check($options)))
		{
			$this->itemsmethodeximportstring->add($nameSingleCode, [
				'name' => $name,
				'type' => $typeName,
				'translation' => false,
				'custom' => $custom,
				'method' => $field['settings']->store
			], true);
		}
		// check if field should be added to uikit
		$this->sitefielddata->set($nameSingleCode, $name, 'uikit', $typeName);
		// load the selection translation fix
		if (ArrayHelper::check($options) && ($listSwitch || $listJoin)
			&& $typeName != 'repeatable' && $typeName != 'subform')
		{
			$this->selectiontranslation->set($nameListCode . '.' . $name, $options);
		}
		// main lang filter prefix
		$lang_filter_ = $this->config->lang_prefix . '_FILTER_';
		// build the sort values
		if ($dbSwitch && (isset($field['sort']) && $field['sort'] == 1)
			&& ($listSwitch || $listJoin)
			&& (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes'
				&& $typeName != 'repeatable' && $typeName != 'subform'))
		{
			// add the language only for new filter option
			$filter_name_asc_lang  = '';
			$filter_name_desc_lang = '';
			if ($this->adminfiltertype->get($nameListCode, 1) == 2)
			{
				// set the language strings for ascending
				$filter_name_asc      = $listFieldName . ' ascending';
				$filter_name_asc_lang = $lang_filter_
					. StringHelper::safe(
						$filter_name_asc, 'U'
					);
				// and to translation
				$this->language->set(
					$this->config->lang_target, $filter_name_asc_lang, $filter_name_asc
				);
				// set the language strings for descending
				$filter_name_desc      = $listFieldName . ' descending';
				$filter_name_desc_lang = $lang_filter_
					. StringHelper::safe(
						$filter_name_desc, 'U'
					);
				// and to translation
				$this->language->set(
					$this->config->lang_target, $filter_name_desc_lang, $filter_name_desc
				);
			}
			$this->sort->add($nameListCode, [
				'type'      => $typeName,
				'code'      => $name,
				'lang'      => $listLangName,
				'lang_asc'  => $filter_name_asc_lang,
				'lang_desc' => $filter_name_desc_lang,
				'custom'    => $custom,
				'options'   => $options
			], true);
		}
		// build the search values
		if ($dbSwitch && isset($field['search']) && $field['search'] == 1)
		{
			$_list = (isset($field['list'])) ? $field['list'] : 0;
			$this->search->add($nameListCode, [
				'type'   => $typeName,
				'code'   => $name,
				'custom' => $custom,
				'list'   => $_list
			], true);
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
			$filter_type_code     = preg_replace('/_+/', '', (string) $filter_type_code);
			$filter_function_name = StringHelper::safe(
				$name, 'F'
			);
			// add the language only for new filter option
			$filter_name_select_lang = '';
			if ($this->adminfiltertype->get($nameListCode, 1) == 2)
			{
				// set the language strings for selection
				$filter_name_select      = 'Select ' . $listFieldName;
				$filter_name_select_lang = $lang_filter_
					. StringHelper::safe(
						$filter_name_select, 'U'
					);
				// and to translation
				$this->language->set(
					$this->config->lang_target, $filter_name_select_lang, $filter_name_select
				);
			}

			// add the filter details
			$this->filter->add($nameListCode, [
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
			], true);
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
		$this->layout->set($nameSingleCode, $tabName, $name, $field);

		// load all fields that are in the database
		if ($dbSwitch)
		{
			// load array of view, field, and [encryption, type, tab]
			$title_ = $this->title->get($nameSingleCode);
			$this->componentfields->set($nameSingleCode . '.' . $name,
				[
					'name' => $name,
					'label' => $langLabel,
					'type' => $typeName,
					'title' => (is_string($title_) && $name === $title_) ? true : false,
					'list' => $nameListCode,
					'store' => (isset($field['store'])) ? $field['store'] : null,
					'tab_name' => $tabName,
					'db' => $this->normalizeDatabaseValues($nameSingleCode, $name, $databaseuniquekey, $databasekey),
					'link' => $this->setLinkerRelations($custom ?? [])
				]
			);
		}
	}

	/**
	 * Normalizes database values by adjusting the 'length' and 'default' fields based on specific conditions.
	 * This function modifies the database values by replacing placeholder texts and appending specifications
	 * to types based on the 'length' field. It removes unnecessary fields from the result array.
	 *
	 * @param string  $nameSingleCode  The code for naming single entries.
	 * @param string  $name             The name of the database entry.
	 * @param string  $uniquekey      Is this field a uniquekey
	 * @param string  $iskey              Is this field a key
	 *
	 * @return array|null Returns the modified database values array or null if no values are found.
	 * @since 3.2.1
	 */
	private function normalizeDatabaseValues($nameSingleCode, $name, $uniquekey, $iskey): ?array
	{
		$db_values = $this->databasetables->get($nameSingleCode . '.' . $name, null);
		if ($db_values === null)
		{
			return null;
		}

		if (isset($db_values['lenght']))
		{
			if ($db_values['lenght'] === 'Other' && isset($db_values['lenght_other']))
			{
				$db_values['lenght'] = $db_values['lenght_other'];
			}
			$db_values['lenght'] = trim($db_values['lenght']);
			if (strlen($db_values['lenght']))
			{
				$db_values['type'] .= '(' . $db_values['lenght'] . ')';
			}
		}

		if (isset($db_values['default']))
		{
			if ($db_values['default'] === 'Other' && isset($db_values['other']))
			{
				$db_values['default'] = $db_values['other'];
			}
		}

		$db_values['unique_key'] = $uniquekey;
		$db_values['key'] = $iskey;

		unset($db_values['ID'], $db_values['lenght'], $db_values['lenght_other'], $db_values['other']);

		return $db_values;
	}

	/**
	 * Sets the linker relations for a field based on the provided link data.
	 *
	 * The method determines the type of link relation based on the presence of a table.
	 * If no table is provided, it assigns a type 2 with a null table, otherwise it assigns type 1.
	 * It also extracts additional values from the input array, such as component, entity, value, and key.
	 *
	 * @param array  $link  The link data which may contain 'table', 'component', 'view', 'text', and 'id'.
	 *
	 * @return array|null The structured linker relation array, or null if input is an empty array.
	 * @since 5.0.3
	 */
	private function setLinkerRelations(array $link): ?array
	{
		if ($link === [])
		{
			return null;
		}

		$linker = [
			'type' => empty($link['table']) ? 2 : 1,
			'table' => $link['table'] ?? null,
			'component' => $link['component'] ?? null,
			'entity' => $link['view'] ?? null,
			'value' => $link['text'] ?? null,
			'key' => $link['id'] ?? null
		];

		return $linker;
	}
}

