<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Alias;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryCode;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomFieldLinks;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DynamicFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HiddenFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\History;
use VDM\Joomla\Componentbuilder\Compiler\Builder\IntegerFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MainTextField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MetaData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Title;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UninstallScriptContent;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UninstallScriptContext;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\ContentTypesInterface;


/**
 * Component Content Types Class.
 * 
 * Declares every admin view that keeps history or carries tags to Joomla's
 * content type table, so the core services that read a content type — history,
 * tags, workflow and the router — can find the component's own items.
 * 
 * The declaration a target writes is its own: Joomla 3 assembles the rows and
 * inserts them itself, and later targets hand each one to the script.php
 * helper. What goes into a row also differs by target, so the pieces that do
 * are the extension points below; everything a row says about the view itself
 * is decided once, here.
 * 
 * @since  6.1.7
 */
class ContentTypes implements ContentTypesInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Access Switch Builder Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The Alias Builder Class.
	 *
	 * @var   Alias
	 * @since 6.1.7
	 */
	protected Alias $alias;

	/**
	 * The Category Code Builder Class.
	 *
	 * @var   CategoryCode
	 * @since 6.1.7
	 */
	protected CategoryCode $categorycode;

	/**
	 * The Custom Field Links Builder Class.
	 *
	 * @var   CustomFieldLinks
	 * @since 6.1.7
	 */
	protected CustomFieldLinks $customfieldlinks;

	/**
	 * The Dynamic Fields Builder Class.
	 *
	 * @var   DynamicFields
	 * @since 6.1.7
	 */
	protected DynamicFields $dynamicfields;

	/**
	 * The Hidden Fields Builder Class.
	 *
	 * @var   HiddenFields
	 * @since 6.1.7
	 */
	protected HiddenFields $hiddenfields;

	/**
	 * The History Builder Class.
	 *
	 * @var   History
	 * @since 6.1.7
	 */
	protected History $history;

	/**
	 * The Integer Fields Builder Class.
	 *
	 * @var   IntegerFields
	 * @since 6.1.7
	 */
	protected IntegerFields $integerfields;

	/**
	 * The Main Text Field Builder Class.
	 *
	 * @var   MainTextField
	 * @since 6.1.7
	 */
	protected MainTextField $maintextfield;

	/**
	 * The Meta Data Builder Class.
	 *
	 * @var   MetaData
	 * @since 6.1.7
	 */
	protected MetaData $metadata;

	/**
	 * The Tags Builder Class.
	 *
	 * @var   Tags
	 * @since 6.1.7
	 */
	protected Tags $tags;

	/**
	 * The Title Builder Class.
	 *
	 * @var   Title
	 * @since 6.1.7
	 */
	protected Title $title;

	/**
	 * The Uninstall Script Context Builder Class.
	 *
	 * @var   UninstallScriptContext
	 * @since 6.1.7
	 */
	protected UninstallScriptContext $uninstallcontext;

	/**
	 * The Uninstall Script Content Builder Class.
	 *
	 * @var   UninstallScriptContent
	 * @since 6.1.7
	 */
	protected UninstallScriptContent $uninstallcontent;

	/**
	 * Constructor.
	 *
	 * @param Config                  $config            The Config Class.
	 * @param Component               $component         The Component Class.
	 * @param ContentOne              $contentone        The Content One Builder Class.
	 * @param AccessSwitch            $accessswitch      The Access Switch Builder Class.
	 * @param Alias                   $alias             The Alias Builder Class.
	 * @param CategoryCode            $categorycode      The Category Code Builder Class.
	 * @param CustomFieldLinks        $customfieldlinks  The Custom Field Links Builder Class.
	 * @param DynamicFields           $dynamicfields     The Dynamic Fields Builder Class.
	 * @param HiddenFields            $hiddenfields      The Hidden Fields Builder Class.
	 * @param History                 $history           The History Builder Class.
	 * @param IntegerFields           $integerfields     The Integer Fields Builder Class.
	 * @param MainTextField           $maintextfield     The Main Text Field Builder Class.
	 * @param MetaData                $metadata          The Meta Data Builder Class.
	 * @param Tags                    $tags              The Tags Builder Class.
	 * @param Title                   $title             The Title Builder Class.
	 * @param UninstallScriptContext  $uninstallcontext  The Uninstall Script Context Builder Class.
	 * @param UninstallScriptContent  $uninstallcontent  The Uninstall Script Content Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Component $component,
		ContentOne $contentone,
		AccessSwitch $accessswitch,
		Alias $alias,
		CategoryCode $categorycode,
		CustomFieldLinks $customfieldlinks,
		DynamicFields $dynamicfields,
		HiddenFields $hiddenfields,
		History $history,
		IntegerFields $integerfields,
		MainTextField $maintextfield,
		MetaData $metadata,
		Tags $tags,
		Title $title,
		UninstallScriptContext $uninstallcontext,
		UninstallScriptContent $uninstallcontent)
	{
		$this->config = $config;
		$this->component = $component;
		$this->contentone = $contentone;
		$this->accessswitch = $accessswitch;
		$this->alias = $alias;
		$this->categorycode = $categorycode;
		$this->customfieldlinks = $customfieldlinks;
		$this->dynamicfields = $dynamicfields;
		$this->hiddenfields = $hiddenfields;
		$this->history = $history;
		$this->integerfields = $integerfields;
		$this->maintextfield = $maintextfield;
		$this->metadata = $metadata;
		$this->tags = $tags;
		$this->title = $title;
		$this->uninstallcontext = $uninstallcontext;
		$this->uninstallcontent = $uninstallcontent;
	}
	/**
	 * Build the content type declarations of every admin view that needs one.
	 *
	 * @param   string  $action  Whether the component is installing or updating.
	 *
	 * @return  string  The generated declarations, or nothing when no view keeps history or carries tags.
	 *
	 * @since   6.1.7
	 */
	public function get(string $action): string
	{
		if ($this->component->isArray('admin_views'))
		{
			// set component name
			$component = $this->config->component_code_name;
			// reset
			$dbStuff = [];
			// start loading the content type data
			foreach ($this->component->get('admin_views') as $viewData)
			{
				// set main keys
				$view = StringHelper::safe(
					$viewData['settings']->name_single
				);
				// set list view keys
				$views = StringHelper::safe(
					$viewData['settings']->name_list
				);
				// get this views content type data
				$dbStuff[$view] = $this->contentType($view, $component);
				// get the correct views name
				$checkViews = $this->categorycode->getString("{$view}.views", $views);
				if (ArrayHelper::check($dbStuff[$view])
					&& $this->categorycode->exists($view)
					&& ($checkViews == $views))
				{
					$dbStuff[$view . ' category']
						= $this->categoryContentType(
						$view, $views, $component
					);
				}
				elseif (!isset($dbStuff[$view])
					|| !ArrayHelper::check($dbStuff[$view]))
				{
					// remove if not array
					unset($dbStuff[$view]);
				}
			}

			return $this->script($action, $dbStuff);
		}

		return '';
	}

	/**
	 * Build one admin view's content type declaration.
	 *
	 * A view that neither keeps history nor carries tags declares no content
	 * type, and says so with false rather than an empty declaration.
	 *
	 * @param   string  $view       The single view code name.
	 * @param   string  $component  The component code name.
	 *
	 * @return  array|false  The declaration, or false when the view needs none.
	 *
	 * @since   6.1.7
	 */
	public function contentType(string $view, string $component)
	{
		// add if history is to be kept or if tags is added
		if ($this->history->exists($view)
			|| $this->tags->exists($view))
		{
			// reset array
			$array = [];
			// set needed defaults
			$alias            = $this->alias->get($view, 'null');
			$title            = $this->title->get($view, 'null');
			$category         = $this->categorycode->getString("{$view}.code", 'null');
			$categoryHistory  = ($this->categorycode->exists($view))
				?
				'{"sourceColumn": "' . $category
				. '","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},'
				: '';
			$Component        = StringHelper::safe(
				$component, 'F'
			);
			$View             = StringHelper::safe($view, 'F');
			$maintext         = $this->maintextfield->get($view, 'null');
			$hiddenFields     = $this->hiddenfields->pathToString($view, '');
			$dynamicfields    = $this->dynamicfields->pathToString($view, ',');
			$intFields        = $this->integerfields->pathToString($view, '');
			$customfieldlinks = $this->customfieldlinks->pathToString($view, '');
			// build uninstall script for content types
			$this->uninstallcontext->set($View, 'com_' . $component . '.' . $view);
			$this->uninstallcontent->set($view, $view);
			// check if this view has metadata
			if ($this->metadata->isString($view))
			{
				$core_metadata = 'metadata';
				$core_metakey  = 'metakey';
				$core_metadesc = 'metadesc';
			}
			else
			{
				$core_metadata = 'null';
				$core_metakey  = 'null';
				$core_metadesc = 'null';
			}
			// check if view has access
			if ($this->accessswitch->exists($view))
			{
				$core_access = 'access';
				$accessHistory
					= ',{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"}';
			}
			else
			{
				$core_access   = 'null';
				$accessHistory = '';
			}
			// set the title
			$array['type_title'] = $Component . ' ' . $View;
			// set the alias
			$array['type_alias'] = 'com_' . $component . '.' . $view;
			$array = $this->tableColumns($array, $component, $view, $View);

			// set field map
			$array['field_mappings']
				= '{"common": {"core_content_item_id": "id","core_title": "'
				. $title . '","core_state": "published","core_alias": "'
				. $alias
				. '","core_created_time": "created","core_modified_time": "modified","core_body": "'
				. $maintext
				. '","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "'
				. $core_access
				. '","core_params": "params","core_featured": "null","core_metadata": "'
				. $core_metadata
				. '","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "'
				. $core_metakey . '","core_metadesc": "' . $core_metadesc
				. '","core_catid": "' . $category
				. '","core_xreference": "null","asset_id": "asset_id"},"special": {'
				. $dynamicfields . '}}';

			// set the router class method
			$array['router'] = $this->router($Component, $View);

			// set content history
			$array['content_history_options']
				= $this->historyHead($component, $view)
				. $hiddenFields
				. '],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"'
				. $intFields . '],"displayLookup": [' . $categoryHistory
				. '{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'
				. $accessHistory
				. ',{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'
				. $customfieldlinks . ']}';

			return $array;
		}

		return false;
	}

	/**
	 * Build the content type declaration of one view's own category.
	 *
	 * @param   string  $view       The single view code name.
	 * @param   string  $views      The list view code name, which the declaration does not use.
	 * @param   string  $component  The component code name.
	 *
	 * @return  array  The declaration.
	 *
	 * @since   6.1.7
	 */
	public function categoryContentType(string $view, string $views, string $component): array
	{
		// get the other view
		$otherView = $this->categorycode->getString("{$view}.view", 'error');
		$category  = $this->categorycode->getString("{$view}.code", 'error');
		$Component = StringHelper::safe($component, 'F');
		$View      = StringHelper::safe($view, 'F');
		// build uninstall script for content types
		$this->uninstallcontext->set($View . ' ' . $category, 'com_'
			. $component . '.' . $otherView . '.category');
		$this->uninstallcontent->set($View . ' ' . $category, $View . ' '
			. $category);
		// set the title
		$array['type_title'] = $Component . ' ' . $View . ' '
			. StringHelper::safe($category, 'F');
		// set the alias
		$array['type_alias'] = 'com_' . $component . '.' . $otherView
			. '.category';
		// set the table
		$array['table']
			= '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
		$array = $this->categoryTableColumns($array);
		// set field map
		$array['field_mappings']
			= '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';

		// set the router class method
		$array['router'] = $this->categoryRouter($Component);
		// set content history
		$array['content_history_options'] = $this->categoryHistory();

		return $array;
	}

	/**
	 * Build the generated code that declares the collected content types.
	 *
	 * @param   string  $action   Whether the component is installing or updating.
	 * @param   array   $dbStuff  The declarations, keyed by what they declare.
	 *
	 * @return  string  The generated code, or nothing when nothing was collected.
	 *
	 * @since   6.1.7
	 */
	protected function script(string $action, array $dbStuff): string
	{
		// build the db insert query
		if (ArrayHelper::check($dbStuff))
		{
			$script = PHP_EOL;
			foreach ($dbStuff as $name => $columns)
			{
				if (ArrayHelper::check($columns))
				{
					$script .= PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " "
						. StringHelper::safe($action, 'Ww') . " "
						. StringHelper::safe($name, 'Ww') . " Content Types.";

					$script .= PHP_EOL . Indent::_(3) .
						'$this->setContentType(';
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " typeTitle";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['type_title']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " typeAlias";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['type_alias']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " table";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['table']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " rules";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['rules']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " fieldMappings";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['field_mappings']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " router";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['router']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " contentHistoryOptions";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['content_history_options']}'";
					$script .= PHP_EOL . Indent::_(3) .
						');';

				}
			}
			$script .= PHP_EOL . PHP_EOL;
			return $script;
		}

		return '';
	}

	/**
	 * Add the table declaration, and whatever a target says beside it.
	 *
	 * @param   array   $array      The declaration being built.
	 * @param   string  $component  The component code name.
	 * @param   string  $view       The single view code name.
	 * @param   string  $View       The single view code name, capitalised.
	 *
	 * @return  array  The declaration, with the table added in its own place.
	 *
	 * @since   6.1.7
	 */
	protected function tableColumns(array $array, string $component, string $view,
		string $View): array
	{
		// set the table
		$array['table'] = '{"special": {"dbtable": "#__' . $component . '_'
			. $view . '","key": "id","type": "' . $View . 'Table","prefix": "' . $this->config->namespace_prefix
			. '\\Component\\' . $this->contentone->get('ComponentNamespace')
			. '\\Administrator\\Table"}}';

		// set rules field
		$array['rules'] = '';

		return $array;
	}

	/**
	 * Build the route this content type is reached by.
	 *
	 * @param   string  $Component  The component code name, capitalised.
	 * @param   string  $View       The single view code name, capitalised.
	 *
	 * @return  string  The route, which later targets leave to their own router.
	 *
	 * @since   6.1.7
	 */
	protected function router(string $Component, string $View): string
	{
		return '';
	}

	/**
	 * Build the head of the content history options, up to the hidden fields.
	 *
	 * @param   string  $component  The component code name.
	 * @param   string  $view       The single view code name.
	 *
	 * @return  string  The form file this view's history reads, and the fields it always hides.
	 *
	 * @since   6.1.7
	 */
	protected function historyHead(string $component, string $view): string
	{
		return '{"formFile": "administrator/components/com_' . $component
			. '/forms/' . $view
			. '.xml","hideFields": ["asset_id","checked_out","checked_out_time"';
	}

	/**
	 * Add whatever a target says beside the category table declaration.
	 *
	 * @param   array  $array  The declaration being built.
	 *
	 * @return  array  The declaration.
	 *
	 * @since   6.1.7
	 */
	protected function categoryTableColumns(array $array): array
	{
		// set rules field
		$array['rules'] = '';

		return $array;
	}

	/**
	 * Build the route a category content type is reached by.
	 *
	 * @param   string  $Component  The component code name, capitalised.
	 *
	 * @return  string  The route, which later targets leave to their own router.
	 *
	 * @since   6.1.7
	 */
	protected function categoryRouter(string $Component): string
	{
		return '';
	}

	/**
	 * Build the content history options of a category content type.
	 *
	 * @return  string  The options, which name the core category form.
	 *
	 * @since   6.1.7
	 */
	protected function categoryHistory(): string
	{
		return '{"formFile":"administrator\/components\/com_categories\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';
	}
}

