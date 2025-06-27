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
	 * The current field id.
	 *
	 * @var    int
	 * @since  5.1.1
	 **/
	protected int $id;

	/**
	 * The current field guid.
	 *
	 * @var    string
	 * @since  5.1.1
	 **/
	protected string $guid;

	/**
	 * The current field.
	 *
	 * @var    array
	 * @since  5.1.1
	 **/
	protected array $field;

	/**
	 * The current field settings.
	 *
	 * @var    object
	 * @since  5.1.1
	 **/
	protected object $settings;

	/**
	 * The current view.
	 *
	 * @var    object
	 * @since  5.1.1
	 **/
	protected array $view;

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
	 * Configure a field, its database schema, list/view behaviour,
	 * multilingual labels and every other builder that depends on the
	 * field definition.
	 *
	 * @param     string        $langLabel         Language key for the field label
	 * @param     string        $langView          Language key for the view
	 * @param     string        $nameSingleCode    Code-name of the single-item view / DB table
	 * @param     string        $nameListCode      Code-name of the list view
	 * @param     string        $name              Field code (column name)
	 * @param     array         $view              View meta-data
	 * @param     array         $field             Field meta-data (includes $field['settings'] object)
	 * @param     string        $typeName          JCB field-type identifier
	 * @param     bool          $multiple          True if multiple/array values are allowed
	 * @param     array|null    $custom            Custom-field definition (extends, table …)
	 * @param     array|null    $options           <option> set for list/choice fields
	 *
	 * @return   void
	 * @since   3.2.0
	 */
	public function set(
		string	$langLabel,
		string	$langView,
		string	$nameSingleCode,
		string	$nameListCode,
		string	$name,
		array	$view,
		array	$field,
		string	$typeName,
		bool	$multiple,
		?array	$custom = null,
		?array	$options = null
	): void
	{
		/* ───────────────────────────────────────────────────────────────
		 * STEP 1: basic pre-processing & guard-clauses
		 * ───────────────────────────────────────────────────────────── */
		$this->init($view, $field);

		/* ───────────────────────────────────────────────────────────────
		 * STEP 2: tag behaviour, DB-switch & schema configuration
		 * ───────────────────────────────────────────────────────────── */
		$this->applyTagBehaviour($typeName, $nameSingleCode);

		$dbSwitch = $this->determineDbPersistence();

		[$databaseUniqueKey, $databaseKey] = $dbSwitch
			? $this->configureDatabaseSchema(
				$nameSingleCode, $name, $typeName
			)
			: [false, false];

		/* ───────────────────────────────────────────────────────────────
		 * STEP 3: list switch, joins, history, alias & title
		 * ───────────────────────────────────────────────────────────── */
		$listSwitch = $this->appearsInList();
		$listJoin   = $this->listjoin->exists($nameListCode . '.' . $this->guid);

		$this->applyHistoryFlag($nameSingleCode);
		$this->applyAliasAndTitleFlags(
			$dbSwitch, $nameSingleCode, $name
		);

		/* ───────────────────────────────────────────────────────────────
		 * STEP 4: language strings (category special-case included)
		 * ───────────────────────────────────────────────────────────── */
		[$listLangName, $listFieldName] = $this->resolveLangAndFieldNames(
			$langLabel,
			$langView,
			$name,
			$nameListCode,
			$nameSingleCode,
			$typeName
		);

		/* ───────────────────────────────────────────────────────────────
		 * STEP 5: list builders, custom-list, list-join
		 * ───────────────────────────────────────────────────────────── */
		$this->configureListsAndJoins(
			$typeName,
			$listSwitch,
			$listJoin,
			$nameListCode,
			$nameSingleCode,
			$name,
			$listLangName,
			$multiple,
			$custom,
			$options
		);

		/* ───────────────────────────────────────────────────────────────
		 * STEP 6: field-relation sync
		 * ───────────────────────────────────────────────────────────── */
		$this->synchroniseFieldRelations(
			$nameListCode,
			$typeName,
			$name,
			$custom
		);

		/* ───────────────────────────────────────────────────────────────
		 * STEP 7: type-specific builders (hidden/int/dynamic/custom/…)
		 * ───────────────────────────────────────────────────────────── */
		$storeString = $this->applyTypeSpecificBuilders(
			$dbSwitch,
			$typeName,
	 		$listLangName,
			$nameListCode,
			$nameSingleCode,
			$name,
			$custom,
			$multiple,
			$listSwitch,
			$listJoin,
			$options
		);

		/* ───────────────────────────────────────────────────────────────
		 * STEP 8: category builder (order preserved from original)
		 * ───────────────────────────────────────────────────────────── */
		if ($dbSwitch && $typeName === 'category')
		{
			$this->configureCategoryField(
				$nameListCode,
				$nameSingleCode,
				$name,
				$listLangName
			);
		}

		/* ───────────────────────────────────────────────────────────────
		 * STEP 9: sort / search / filter
		 * ───────────────────────────────────────────────────────────── */
		$this->configureSortSearchFilter(
			$dbSwitch,
			$typeName,
			$multiple,
			$listSwitch,
			$listJoin,
			$langLabel,
			$listLangName,
			$listFieldName,
			$nameSingleCode,
			$nameListCode,
			$name,
			$custom,
			$options
		);

		/* ───────────────────────────────────────────────────────────────
		 * STEP 10: layout + final component-field map
		 * ───────────────────────────────────────────────────────────── */
		$this->configureLayoutAndComponentField(
			$dbSwitch,
			$nameSingleCode,
			$name,
			$typeName,
			$databaseUniqueKey,
			$databaseKey,
			$langLabel,
			$nameListCode,
			$storeString,
			$custom
		);
	}

	/* ========================================================================
	 *                       ───  PRIVATE HELPERS  ───
	 *   (All helpers strictly preserve side-effect order of the legacy code)
	 * ===================================================================== */

	/**
	 * Add Tags-builder entry if the field type is “tag”.
	 *
	 * @param string $typeName         Field type
	 * @param string $nameSingleCode   Single-item view / DB table code
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function applyTagBehaviour(string $typeName, string $nameSingleCode): void
	{
		if ($typeName === 'tag')
		{
			$this->tags->set($nameSingleCode, true);
		}
	}

	/**
	 * Decide whether the field should be persisted to the database table.
	 *
	 * Fields explicitly marked with 'list' = 2 are excluded from persistence.
	 * All other cases (including when 'list' is not set) result in persistence.
	 *
	 * @return bool  True if the column must exist in the database, false otherwise.
	 * @since  5.1.1
	 */
	private function determineDbPersistence(): bool
	{
		if (isset($this->field['list']) && $this->field['list'] == 2)
		{
		   return false;
		}
		return true;
	}

	/**
	 * Populate $this->databasetables, unique/key builders and numeric defaults.
	 *
	 * @param string    $table     DB table code
	 * @param string    $column    Column name
	 * @param string    $typeName  Field type
	 *
	 * @return array{0:bool,1:bool} [isUniqueKey, isKey]
	 * @since  5.1.1
	 */
	private function configureDatabaseSchema(
		string    $table,
		string    $column,
		string    $typeName
	): array
	{
		static $NUMBER = ['INT','TINYINT','BIGINT','FLOAT','DECIMAL','DOUBLE'];
		static $TEXT   = ['TEXT','TINYTEXT','MEDIUMTEXT','LONGTEXT', 'BLOB','TINYBLOB','MEDIUMBLOB','LONGBLOB'];

		$this->databasetables->set("{$table}.{$column}.type", $this->settings->datatype);

		if (in_array($this->settings->datatype, $NUMBER))
		{
			if ($this->settings->datadefault === 'Other')
			{
				$n = $this->settings->datadefault_other;
				if ($this->settings->datatype === 'DECIMAL' && !is_numeric($n))
				{
					$n = str_replace(',', '.', (string) $n);
				}
				$this->settings->datadefault_other = is_numeric($n) ? $n : '0';
			}
			elseif (!is_numeric($this->settings->datadefault))
			{
				$this->settings->datadefault = '0';
			}
		}

		$isText = in_array($this->settings->datatype, $TEXT);
		if (!$isText)
		{
			$this->databasetables->set("{$table}.{$column}.lenght", $this->settings->datalenght);
			$this->databasetables->set("{$table}.{$column}.lenght_other", $this->settings->datalenght_other);
			$this->databasetables->set("{$table}.{$column}.default", $this->settings->datadefault);
			$this->databasetables->set("{$table}.{$column}.other", $this->settings->datadefault_other);
		}
		else
		{
			$this->databasetables->set("{$table}.{$column}.default", 'EMPTY');
		}

		$this->databasetables->set("{$table}.{$column}.ID", $this->id);
		$this->databasetables->set("{$table}.{$column}.GUID", $this->guid);
		$this->databasetables->set("{$table}.{$column}.null_switch", $this->settings->null_switch);

		$addGuid = true;
		$databaseUniqueKey = false;
		$databaseKey = false;

		if ($this->settings->indexes == 1 && !$isText)
		{
			$this->databaseuniquekeys->add($table, $column, true);
			$databaseUniqueKey = true;

		        // prevent guid from being added twice
		        if ('guid' === $column)
		        {
		            $addGuid = false;
		        }
		}
		elseif (
			(($this->settings->indexes == 2) ||
			 ($this->field['alias'] ?? false) ||
			 ($this->field['title'] ?? false) ||
			 $typeName === 'category') && !$isText
		)
		{
			$this->databasekeys->add($table, $column, true);
			$databaseKey = true;
		}

		if ($column === 'guid' && $addGuid)
		{
			$this->databaseuniqueguid->set($table, true);
		}

		return [$databaseUniqueKey, $databaseKey];
	}

	/**
	 * Check whether a field should appear in the list view.
	 *
	 * @return bool True if field is shown in list
	 * @since  5.1.1
	 */
	private function appearsInList(): bool
	{
		return isset($this->field['list']) && in_array($this->field['list'], [1,3,4]);
	}

	/**
	 * Activate history tracking for a view when enabled.
	 *
	 * @param string $table Single-item view / DB table code
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function applyHistoryFlag(string $table): void
	{
		if (!empty($this->view['history']))
		{
			$this->history->set($table, true);
		}
	}

	/**
	 * Ensure view-singleton alias/title markers are registered once.
	 *
	 * @param bool   $dbSwitch       True if column exists in DB
	 * @param string $table          DB table code
	 * @param string $column         Column name
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function applyAliasAndTitleFlags(
		bool	$dbSwitch,
		string	$table,
		string	$column
	): void
	{
		if (!$dbSwitch)
		{
			return;
		}

		if (!empty($this->field['alias']) && !$this->alias->get($table))
		{
			$this->alias->set($table, $column);
		}

		if (!empty($this->field['title']) && !$this->title->get($table))
		{
			$this->title->set($table, $column);
		}
	}

	/**
	 * Resolve list-language key and human-readable field name, inserting
	 * translation entries when necessary.
	 *
	 * @param string $langLabel      Explicit language key for the label
	 * @param string $langView       Language key for the view
	 * @param string $name           Raw field code
	 * @param string $nameListCode   List view code
	 * @param string $nameSingleCode Single-item view code
	 * @param string $typeName       Field type
	 *
	 * @return array{0:string,1:string} [$listLangName,$listFieldName]
	 * @since  5.1.1
	 */
	private function resolveLangAndFieldNames(
		string	$langLabel,
		string	$langView,
		string	$name,
		string	$nameListCode,
		string	$nameSingleCode,
		string	$typeName
	): array
	{
		if ($typeName === 'category')
		{
			$tmp = $this->categoryothername->get(
				"{$nameListCode}.name", $nameListCode . ' categories'
			);
			$listLangName	 = $langView . '_' . FieldHelper::safe($tmp, true);
			$listFieldName	 = StringHelper::safe($tmp, 'W');
			$this->language->set($this->config->lang_target, $listLangName, $listFieldName);

			return [$listLangName, $listFieldName];
		}

		if (StringHelper::check($langLabel))
		{
			$listLangName = $langLabel;

			if ($this->language->exist($this->config->lang_target, $langLabel))
			{
				$listFieldName = $this->language->get($this->config->lang_target, $langLabel);
			}
			else
			{
				$listFieldName = (string) $this->placeholder->update_(
					GetHelper::between($this->settings->xml, 'label="', '"')
				);
			}

			return [strip_tags($listLangName), strip_tags($listFieldName)];
		}

		$listLangName  = $langView . '_' . FieldHelper::safe($name, true);
		$listFieldName = StringHelper::safe($name, 'W');
		$this->language->set($this->config->lang_target, $listLangName, $listFieldName);

		return [$listLangName, $listFieldName];
	}

	/**
	 * Populate list-, customlist- and listjoin-builders.
	 *
	 * @param string     $typeName
	 * @param bool       $listSwitch
	 * @param bool       $listJoin
	 * @param string     $nameListCode
	 * @param string     $nameSingleCode
	 * @param string     $name
	 * @param string     $listLangName
	 * @param bool       $multiple
	 * @param array|null $custom
	 * @param array|null $options
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function configureListsAndJoins(
		string	$typeName,
		bool	$listSwitch,
		bool	$listJoin,
		string	$nameListCode,
		string	$nameSingleCode,
		string	$name,
		string	$listLangName,
		bool	$multiple,
		?array	$custom,
		?array	$options
	): void
	{
		if (in_array($typeName, ['repeatable','subform']))
		{
			return;
		}

		$title = !empty($this->field['title']);
		$alias = !empty($this->field['alias']);
		$link = !empty($this->field['link']);
		$sort = !empty($this->field['sort']);

		if ($listSwitch)
		{
			$this->lists->add($nameListCode, [
				'id' => $this->id,
				'guid' => $this->guid,
				'type' => $typeName,
				'code' => $name,
				'lang' => $listLangName,
				'title' => $title,
				'alias' => $alias,
				'link' => $link,
				'sort' => $sort,
				'custom' => $custom,
				'multiple' => $multiple,
				'options' => $options,
				'target' => (int) ($this->field['list'] ?? 0)
			], true);
		}

		if ($listSwitch || $listJoin)
		{
			$this->customlist->set("{$nameSingleCode}.{$name}", true);
		}

		if ($listJoin)
		{
			$this->listjoin->set($nameListCode . '.' . $this->guid, [
				'type' => $typeName,
				'id' => $this->id,
				'code' => $name,
				'lang' => $listLangName,
				'title' => $title,
				'alias' => $alias,
				'link' => $link,
				'sort' => $sort,
				'custom' => $custom,
				'multiple' => $multiple,
				'options' => $options
			]);
		}
	}

	/**
	 * Update $this->fieldrelations after full meta is known.
	 *
	 * @param string     $nameListCode List view code
	 * @param string     $typeName     Field type
	 * @param string     $name         Column name
	 * @param array|null $custom       Custom meta
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function synchroniseFieldRelations(
		string	$nameListCode,
		string	$typeName,
		string	$name,
		?array	$custom
	): void
	{
		$key = $nameListCode . '.' . $this->guid;

		if (($relations = $this->fieldrelations->get($key)) !== null)
		{
			$relations = (array) $relations;
			foreach ($relations as &$v)
			{
				$v['id'] = $this->id;
				$v['guid'] = $this->guid;
				$v['type'] = $typeName;
				$v['code'] = $name;
				$v['custom'] = $custom;
			}
			$this->fieldrelations->set($key, $relations);
		}
	}

	/**
	 * Register hidden/int/dynamic/editor/media/checkbox/custom/JSON/encryption
	 * builders and ItemMethods housekeeping.
	 *
	 * @param bool       $dbSwitch
	 * @param string     $typeName
	 * @param string     $listLangName
	 * @param string     $nameListCode
	 * @param string     $nameSingleCode
	 * @param string     $column
	 * @param array|null $custom
	 * @param bool       $multiple
	 * @param bool       $listSwitch
	 * @param bool       $listJoin
	 * @param array|null $options
	 *
	 * @return string|null  The store string name of this field (null if none set)
	 * @since  5.1.1
	 */
	private function applyTypeSpecificBuilders(
		bool	  $dbSwitch,
		string	  $typeName,
		string	  $listLangName,
		string	  $nameListCode,
		string	  $nameSingleCode,
		string	  $column,
		?array	  $custom,
		bool	  $multiple,
		bool	  $listSwitch,
		bool	  $listJoin,
		?array	  $options
	): ?string
	{
		$defaultFields = $this->config->default_fields;
		$storeString = null;

		if ($dbSwitch)
		{
			if ($typeName === 'hidden')
			{
				$this->hiddenfields->add($nameSingleCode, ',"' . $column . '"', true);
			}

			if (in_array($this->settings->datatype, ['INT','TINYINT','BIGINT']))
			{
				$this->integerfields->add($nameSingleCode, ',"' . $column . '"', true);
			}

			if (
				$typeName !== 'category' &&
				!in_array($column, $defaultFields) &&
				!in_array($typeName, ['repeatable','subform'])
			)
			{
				$this->dynamicfields->add($nameSingleCode, '"' . $column . '":"' . $column . '"', true);
			}

			if ($typeName === 'editor' && !$this->maintextfield->exists($nameSingleCode))
			{
				$this->maintextfield->set($nameSingleCode, $column);
			}

			if (
				$typeName === 'checkbox' ||
				(ArrayHelper::check($custom) && ($custom['extends'] ?? '') === 'checkboxes')
			)
			{
				$this->checkbox->add($nameSingleCode, $column, true);
			}
		}

		if (ArrayHelper::check($custom) && !in_array($typeName, ['category','repeatable','subform']))
		{
			$this->customfield->add($nameListCode, [
				'type' => $typeName,
				'code' => $column,
				'lang' => $listLangName ?? '',
				'custom' => $custom,
				'method' => $this->settings->store
			], true);

			if (!empty($custom['table']))
			{
				$this->customfieldlinks->add(
					$nameSingleCode,
					',{"sourceColumn": "' . $column . '","targetTable": "' . $custom['table']
					. '","targetColumn": "' . $custom['id'] . '","displayColumn": "' . $custom['text'] . '"}',
					true
				);
			}

			// build script switch for user
			if (($custom['extends'] ?? '') === 'user')
			{
				$this->scriptuserswitch->set($typeName, $typeName);
			}
		}

		if ($typeName === 'media')
		{
			$this->scriptmediaswitch->set($typeName, $typeName);
		}

		if (
			($dbSwitch || $this->settings->store == 6) &&
			(
				$typeName === 'subform'  ||
				$typeName === 'checkboxes' ||
				$multiple || $this->settings->store != 0
			)
			&& $typeName !== 'tag'
		)
		{
			$storeString = $this->handleStoreBehaviour(
				$typeName,
				$nameSingleCode,
				$column,
				$custom,
				$listSwitch || $listJoin,
				$options
			);
		}

		if (
			$dbSwitch &&
			(
				($typeName === 'checkboxes' || $multiple || $this->settings->store != 0)
				&& !ArrayHelper::check($options)
			)
		)
		{
			$this->itemsmethodeximportstring->add($nameSingleCode, [
				'name' => $column,
				'type' => $typeName,
				'translation' => false,
				'custom' => $custom,
				'method' => $this->settings->store
			], true);
		}

		$this->sitefielddata->set($nameSingleCode, $column, 'uikit', $typeName);

		if (
			ArrayHelper::check($options) && ($listSwitch || $listJoin) &&
			!in_array($typeName, ['repeatable','subform'])
		)
		{
			$this->selectiontranslation->set($nameListCode . '.' . $column, $options);
		}

		return $storeString;
	}

	/**
	 * Handle storage-mode specific behaviour (JSON, Base64, encryption, expert).
	 *
	 * @param string      $typeName
	 * @param string      $table
	 * @param string      $column
	 * @param array|null  $custom
	 * @param bool        $inList
	 * @param array|null  $options
	 *
	 * @return string|null  The store string name of this field (null if none set)
	 * @since  5.1.1
	 */
	private function handleStoreBehaviour(
		string    $typeName,
		string    $table,
		string    $column,
		?array    $custom,
		bool      $inList,
		?array    $options
	): ?string
	{
		$subformJsonSwitch = true;
		$storeString = null;

		switch ((int) $this->settings->store)
		{
			case 1:	// JSON_STRING_ENCODE
				$this->jsonstring->add($table, $column, true);
				$this->sitefielddata->set($table, $column, 'json', $typeName);
				$storeString = 'json';
				break;

			case 2:	// BASE_SIXTY_FOUR
				$this->basesixfour->add($table, $column, true);
				$this->sitefielddata->set($table, $column, 'base64', $typeName);
				$storeString = 'base64';
				break;

			case 3:	// BASIC_ENCRYPTION_LOCALKEY
				$this->modelbasicfield->add($table, $column, true);
				$this->sitefielddata->set($table, $column, 'basic_encryption', $typeName);
				$this->power->get('99175f6d-dba8-4086-8a65-5c4ec175e61d', 1);
				$storeString = 'basic_encryption';
				break;

			case 4:	// WHMCS_ENCRYPTION_VDMKEY
				$this->modelwhmcsfield->add($table, $column, true);
				$this->sitefielddata->set($table, $column, 'whmcs_encryption', $typeName);
				$this->power->get('99175f6d-dba8-4086-8a65-5c4ec175e61d', 1);
				$storeString = 'whmcs_encryption';
				break;

			case 5:	// MEDIUM_ENCRYPTION_LOCALFILE
				$this->modelmediumfield->add($table, $column, true);
				$this->sitefielddata->set($table, $column, 'medium_encryption', $typeName);
				$this->power->get('99175f6d-dba8-4086-8a65-5c4ec175e61d', 1);
				$storeString = 'medium_encryption';
				break;

			case 6:	// EXPERT_MODE
				if (isset($this->settings->model_field))
				{
					if (isset($this->settings->initiator_save_key))
					{
						$this->modelexpertfieldinitiator->set(
							$table . '.save.' . $this->settings->initiator_save_key,
							$this->settings->initiator_save
						);
					}
					if (isset($this->settings->initiator_get_key))
					{
						$this->modelexpertfieldinitiator->set(
							$table . '.get.' . $this->settings->initiator_get_key,
							$this->settings->initiator_get
						);
					}
					$this->modelexpertfield->set("$table.$column", $this->settings->model_field);
					$this->sitefielddata->set($table, $column, 'expert_mode', $typeName);
				}
				break;

			default: // JSON_ARRAY_ENCODE
				$this->jsonitem->add($table, $column, true);
				$this->sitefielddata->set($table, $column, 'json', $typeName);
				$storeString = 'json';
				$subformJsonSwitch = false;
				break;
		}

		// just a heads-up for usergroups set to multiple
		if ($typeName === 'usergroup' || $typeName === 'usergrouplist')
		{
			$this->sitefielddata->set($table, $column, 'json', $typeName);
		}

		if ($inList && (!in_array($typeName, ['repeatable','subform']) || $this->settings->store == 6))
		{
			$this->itemsmethodliststring->add($table, [
				'name' => $column,
				'type' => $typeName,
				'translation' => (bool) ArrayHelper::check($options),
				'custom' => $custom,
				'method' => $this->settings->store
			], true);
		}

		if ($typeName === 'subform' && $this->settings->store != 6)
		{
			$this->jsonitemarray->add($table, $column, true);
			if ($subformJsonSwitch)
			{
				$this->jsonitem->add($table, $column, true);
				$this->sitefielddata->set($table, $column, 'json', $typeName);
				$storeString = 'json';
			}
		}

		return $storeString;
	}

	/**
	 * Validate category field attributes, show mismatch warning and
	 * populate category builders.
	 *
	 * @param string $nameListCode
	 * @param string $nameSingleCode
	 * @param string $column
	 * @param string $listLangName
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function configureCategoryField(
		string	$nameListCode,
		string	$nameSingleCode,
		string	$column,
		string	$listLangName
	): void
	{
		$otherViews = $this->categoryothername->get("{$nameListCode}.views", $nameListCode);
		$otherView = $this->categoryothername->get("{$nameListCode}.view",  $nameSingleCode);

		$_extension = $this->placeholder->update_(
			GetHelper::between($this->settings->xml, 'extension="', '"')
		);

		if (!StringHelper::check($_extension))
		{
			$_extension = 'com_' . $this->config->component_code_name . '.' . $otherView;
		}

		if (str_contains($_extension, '.'))
		{
			[$targetExtension, $targetView] = array_map('trim', explode('.', $_extension, 2));
			if ($targetView !== $otherView)
			{
				$correction = $targetExtension . '.' . $otherView;
				$this->app->enqueueMessage(
					Text::sprintf(
						'<hr /><h3>Category targeting view mismatch</h3>
						 <p>The <a href="index.php?option=com_componentbuilder&view=fields&task=field.edit&id=%s"
						 target="_blank">category field</a> in <b>(%s) admin view</b>
						 has a mismatching target view.<br />
						 Change <code>%s</code> to <code>%s</code> for best practice.</p>',
						$this->id,
						$nameSingleCode,
						$_extension,
						$correction
					),
					'Error'
				);
			}
		}

		$this->category->set($nameListCode, [
			'code' => $column,
			'name' => $listLangName,
			'extension' => $_extension,
			'filter' => $this->field['filter'],
			'add_icon' => StringHelper::check($this->view['settings']->icon_category)
		]);

		$this->categorycode->set($nameSingleCode, [
			'code' => $column,
			'views' => $otherViews,
			'view' => $otherView
		]);
	}

	/**
	 * Build sort, search, filter options and associated language strings.
	 *
	 * @param bool       $dbSwitch
	 * @param string     $typeName
	 * @param bool       $multiple
	 * @param bool       $listSwitch
	 * @param bool       $listJoin
	 * @param string     $langLabel
	 * @param string     $listLangName
	 * @param string     $listFieldName
	 * @param string     $nameSingleCode
	 * @param string     $nameListCode
	 * @param string     $column
	 * @param array|null $custom
	 * @param array|null $options
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function configureSortSearchFilter(
		bool	$dbSwitch,
		string	$typeName,
		bool	$multiple,
		bool	$listSwitch,
		bool	$listJoin,
		string	$langLabel,
		string	$listLangName,
		string	$listFieldName,
		string	$nameSingleCode,
		string	$nameListCode,
		string	$column,
		?array	$custom,
		?array	$options
	): void
	{
		$langFilterPrefix = $this->config->lang_prefix . '_FILTER_';

		$isSortable = $dbSwitch && !empty($this->field['sort']) &&
			!$multiple && !in_array($typeName, ['checkbox','checkboxes','repeatable','subform']) &&
			($listSwitch || $listJoin);

		if ($isSortable)
		{
			$filterAscLang  = '';
			$filterDescLang = '';

			if ($this->adminfiltertype->get($nameListCode, 1) == 2)
			{
				$asc = $listFieldName . ' ascending';
				$desc = $listFieldName . ' descending';

				$filterAscLang = $langFilterPrefix . StringHelper::safe($asc, 'U');
				$filterDescLang = $langFilterPrefix . StringHelper::safe($desc, 'U');

				$this->language->set($this->config->lang_target, $filterAscLang, $asc);
				$this->language->set($this->config->lang_target, $filterDescLang, $desc);
			}

			$this->sort->add($nameListCode, [
				'type' => $typeName,
				'code' => $column,
				'lang' => $listLangName,
				'lang_asc' => $filterAscLang,
				'lang_desc' => $filterDescLang,
				'custom' => $custom,
				'options' => $options
			], true);
		}

		if ($dbSwitch && !empty($this->field['search']))
		{
			$this->search->add($nameListCode, [
				'type' => $typeName,
				'code' => $column,
				'custom'=> $custom,
				'list' => (int) ($this->field['list'] ?? 0)
			], true);
		}

		$isFilterable = $dbSwitch && !empty($this->field['filter']) && $this->field['filter'] >= 1 && ($listSwitch || $listJoin) &&
			!$multiple && !in_array($typeName, ['checkbox','checkboxes','repeatable','subform']);

		if ($isFilterable)
		{
			$filterTypeCode = preg_replace('/_+/', '',
				StringHelper::safe($nameListCode . 'filter' . $column)
			);
			$functionName = StringHelper::safe($column, 'F');
			$filterSelectLang = '';

			if ($this->adminfiltertype->get($nameListCode, 1) == 2)
			{
				$txt = 'Select ' . $listFieldName;
				$filterSelectLang = $langFilterPrefix . StringHelper::safe($txt, 'U');
				$this->language->set($this->config->lang_target, $filterSelectLang, $txt);
			}

			$this->filter->add($nameListCode, [
				'id' => $this->id,
				'guid' => $this->guid,
				'type' => $typeName,
				'multi' => $this->field['filter'],
				'code' => $column,
				'label' => $langLabel,
				'lang' => $listLangName,
				'lang_select' => $filterSelectLang,
				'database' => $nameSingleCode,
				'function' => $functionName,
				'custom' => $custom,
				'options' => $options,
				'filter_type' => $filterTypeCode
			], true);
		}
	}

	/**
	 * Decide tab placement, push data into $this->layout and finalise
	 * $this->componentfields map.
	 *
	 * @param bool        $dbSwitch
	 * @param string      $nameSingleCode
	 * @param string      $column
	 * @param string      $typeName
	 * @param bool        $uniqueKey
	 * @param bool        $key
	 * @param string      $langLabel
	 * @param string      $nameListCode
	 * @param string|null $storeString
	 * @param array|null  $custom
	 *
	 * @return void
	 * @since  5.1.1
	 */
	private function configureLayoutAndComponentField(
		bool	$dbSwitch,
		string	$nameSingleCode,
		string	$column,
		string	$typeName,
		bool	$uniqueKey,
		bool	$key,
		string	$langLabel,
		string	$nameListCode,
		?string $storeString,
		?array	$custom
	): void
	{
		$tabName = '';
		if (isset($this->view['settings']->tabs[$this->field['tab']]))
		{
			$tabName = $this->view['settings']->tabs[$this->field['tab']];
		}
		elseif ((int) $this->field['tab'] === 15)
		{
			$tabName = 'publishing';
		}

		$this->layout->set($nameSingleCode, $tabName, $column, $this->field);

		if ($dbSwitch)
		{
			$this->componentfields->set("$nameSingleCode.$column", [
				'name' => $column,
				'label' => $langLabel,
				'type' => $typeName,
				'title' => $column === $this->title->get($nameSingleCode),
				'list' => $nameListCode,
				'store' => $storeString,
				'tab_name' => $tabName,
				'db' => $this->normalizeDatabaseValues(
					$nameSingleCode,
					$column,
					$uniqueKey,
					$key
				),
				'link' => $this->setLinkerRelations($custom ?? [])
			]);
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

	/**
	 * Initialise this field
	 *
	 * @param array  $view   View meta-data
	 * @param array  $field  Field meta-data (includes $field['settings'] object)
	 *
	 * @return   void
	 * @since    5.1.1
	 */
	private function init(array &$view, array &$field): void
	{
		$this->field = $field;
		$this->settings = $this->field['settings'];
		$this->id = $field['settings']->id;
		$this->guid = $field['field'] ?? $field['settings']->guid;
		$this->view = $view;
	}
}

