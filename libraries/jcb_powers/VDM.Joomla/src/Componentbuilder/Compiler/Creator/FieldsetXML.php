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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language\Fieldset as Language;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Adminview\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldDynamic;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MetaData;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Layout;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Xml;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\Fieldsetinterface;


/**
 * Fieldset XML Creator Class
 * 
 * @since 3.2.0
 */
final class FieldsetXML implements Fieldsetinterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Fieldset Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 3.2.0
	 */
	protected Permission $permission;

	/**
	 * The FieldDynamic Class.
	 *
	 * @var   FieldDynamic
	 * @since 3.2.0
	 */
	protected FieldDynamic $fielddynamic;

	/**
	 * The FieldNames Class.
	 *
	 * @var   FieldNames
	 * @since 3.2.0
	 */
	protected FieldNames $fieldnames;

	/**
	 * The AccessSwitch Class.
	 *
	 * @var   AccessSwitch
	 * @since 3.2.0
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The MetaData Class.
	 *
	 * @var   MetaData
	 * @since 3.2.0
	 */
	protected MetaData $metadata;

	/**
	 * The Layout Class.
	 *
	 * @var   Layout
	 * @since 3.2.0
	 */
	protected Layout $layout;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * The Xml Class.
	 *
	 * @var   Xml
	 * @since 3.2.0
	 */
	protected Xml $xml;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param Placeholder    $placeholder    The Placeholder Class.
	 * @param Language       $language       The Fieldset Class.
	 * @param Event          $event          The EventInterface Class.
	 * @param Permission     $permission     The Permission Class.
	 * @param FieldDynamic   $fielddynamic   The FieldDynamic Class.
	 * @param FieldNames     $fieldnames     The FieldNames Class.
	 * @param AccessSwitch   $accessswitch   The AccessSwitch Class.
	 * @param MetaData       $metadata       The MetaData Class.
	 * @param Layout         $layout         The Layout Class.
	 * @param Counter        $counter        The Counter Class.
	 * @param Xml            $xml            The Xml Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		Language $language, Event $event, Permission $permission,
		FieldDynamic $fielddynamic, FieldNames $fieldnames,
		AccessSwitch $accessswitch, MetaData $metadata,
		Layout $layout, Counter $counter, Xml $xml)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->language = $language;
		$this->event = $event;
		$this->permission = $permission;
		$this->fielddynamic = $fielddynamic;
		$this->fieldnames = $fieldnames;
		$this->accessswitch = $accessswitch;
		$this->metadata = $metadata;
		$this->layout = $layout;
		$this->counter = $counter;
		$this->xml = $xml;
	}

	/**
	 * Get a fieldset
	 *
	 * @param   array   $view            The view data
	 * @param   string  $component       The component name
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set as a string or empty string if no field found.
	 * @since 3.2.0
	 */
	public function get(array $view, string $component, string $nameSingleCode,
		string $nameListCode): string
	{
		// setup the fieldset language values of this view
		if (!isset($view['settings']->fields)
			|| !ArrayHelper::check($view['settings']->fields))
		{
			return '';
		}

		// add metadata to the view
		$metadata = false;
		if (isset($view['metadata']) && $view['metadata'])
		{
			$metadata = true;
		}

		// add access to the view
		$access = false;
		if (isset($view['access']) && $view['access'])
		{
			$access = true;
		}

		// main lang prefix
		$lang_view  = $this->config->lang_prefix . '_'
			. $this->placeholder->get('VIEW');
		$lang_views = $this->config->lang_prefix . '_'
			. $this->placeholder->get('VIEWS');

		$name_single = $view['settings']->name_single ?? 'Error';
		$name_list = $view['settings']->name_list ?? 'Error';
		$lang_target = $this->config->lang_target ?? 'both';

		// load the language values
		$this->language->set(
			$access,
			$metadata,
			$lang_target,
			$lang_view,
			$lang_views,
			$name_single,
			$name_list,
			$nameSingleCode,
			$nameListCode
		);

		// set the read only
		$read_only_xml = [];
		if ($view['settings']->type == 2)
		{
			$read_only_xml['readonly'] = true;
			$read_only_xml['disabled'] = true;
		}
		// start adding dynamc fields
		$dynamic_fields_xml = [];
		// set the custom table key
		$dbkey = 'g';

		// Trigger Event: jcb_ce_onBeforeBuildFields
		$this->event->trigger(
			'jcb_ce_onBeforeBuildFields',
			[&$dynamic_fields_xml, &$read_only_xml,
				&$dbkey, &$view, &$component, &$nameSingleCode,
				&$nameListCode, &$lang_view,
				&$lang_views]
		);

		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamic_fields_xml[] = $this->fielddynamic->get(
				$field, $view, $view['settings']->type, $lang_view,
				$nameSingleCode, $nameListCode, $this->placeholder->active, $dbkey,
				true
			);
		}

		// Trigger Event: jcb_ce_onAfterBuildFields
		$this->event->trigger(
			'jcb_ce_onAfterBuildFields',
			[&$dynamic_fields_xml, &$read_only_xml,
				&$dbkey, &$view, &$component, &$nameSingleCode,
				&$nameListCode, &$lang_view,
				&$lang_views]
		);

		// set the default fields
		$main_xml         = new \simpleXMLElement('<a/>');
		$field_set_xml = $main_xml->addChild('fieldset');
		$field_set_xml->addAttribute('name', 'details');
		$this->xml->comment(
			$field_set_xml, Line::_(__Line__, __Class__) . " Default Fields."
		);
		$this->xml->comment(
			$field_set_xml,
			Line::_(__Line__, __Class__) . " Id Field. Type: Text (joomla)"
		);
		// if id is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.id'))
		{
			$attributes = [
				'name'        => 'id',
				'type'        => 'text',
				'class'       => 'readonly',
				'readonly'    => "true",
				'label'       => 'JGLOBAL_FIELD_ID_LABEL',
				'description' => 'JGLOBAL_FIELD_ID_DESC',
				'size'        => 10,
				'default'     => 0
			];
			$field_xml   = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// if created is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.created'))
		{
			$attributes = [
				'name'        => 'created',
				'type'        => 'calendar',
				'label'       => $lang_view . '_CREATED_DATE_LABEL',
				'description' => $lang_view . '_CREATED_DATE_DESC',
				'size'        => 22,
				'format'      => '%Y-%m-%d %H:%M:%S',
				'filter'      => 'user_utc'
			];
			$attributes = array_merge($attributes, $read_only_xml);
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " Date Created Field. Type: Calendar (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// if created_by is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.created_by'))
		{
			$attributes = [
				'name'        => 'created_by',
				'type'        => 'user',
				'label'       => $lang_view . '_CREATED_BY_LABEL',
				'description' => $lang_view . '_CREATED_BY_DESC',
			];
			$attributes = array_merge($attributes, $read_only_xml);
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " User Created Field. Type: User (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// if published is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.published'))
		{
			$attributes = [
				'name'  => 'published',
				'type'  => 'list',
				'label' => 'JSTATUS'
			];
			$attributes = array_merge($attributes, $read_only_xml);
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " Published Field. Type: List (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
			foreach (['JPUBLISHED' => 1, 'JUNPUBLISHED' => 0,
				'JARCHIVED' => 2, 'JTRASHED'   => -2] as $text => $value
			)
			{
				$optionXML = $field_xml->addChild('option');
				$optionXML->addAttribute('value', $value);
				$optionXML[] = $text;
			}
		}
		// if modified is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.modified'))
		{
			$attributes = [
				'name'        => 'modified',
				'type'        => 'calendar',
				'class'       => 'readonly',
				'label'       => $lang_view . '_MODIFIED_DATE_LABEL',
				'description' => $lang_view . '_MODIFIED_DATE_DESC',
				'size'        => 22,
				'readonly'    => "true",
				'format'      => '%Y-%m-%d %H:%M:%S',
				'filter'      => 'user_utc'
			];
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " Date Modified Field. Type: Calendar (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// if modified_by is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.modified_by'))
		{
			$attributes = [
				'name'        => 'modified_by',
				'type'        => 'user',
				'label'       => $lang_view . '_MODIFIED_BY_LABEL',
				'description' => $lang_view . '_MODIFIED_BY_DESC',
				'class'       => 'readonly',
				'readonly'    => 'true',
				'filter'      => 'unset'
			];
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " User Modified Field. Type: User (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// check if view has access
		if ($this->accessswitch->exists($nameSingleCode)
			&& !$this->fieldnames->isString($nameSingleCode . '.access'))
		{
			$attributes = [
				'name'        => 'access',
				'type'        => 'accesslevel',
				'label'       => 'JFIELD_ACCESS_LABEL',
				'description' => 'JFIELD_ACCESS_DESC',
				'default'     => 1,
				'required'    => "false"
			];
			$attributes = array_merge($attributes, $read_only_xml);
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " Access Field. Type: Accesslevel (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// if ordering is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.ordering'))
		{
			$attributes = [
				'name'        => 'ordering',
				'type'        => 'number',
				'class'       => 'inputbox validate-ordering',
				'label'       => $lang_view . '_ORDERING_LABEL',
				'description' => '',
				'default'     => 0,
				'size'        => 6,
				'required'    => "false"
			];
			$attributes = array_merge($attributes, $read_only_xml);
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " Ordering Field. Type: Numbers (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// if version is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.version'))
		{
			$attributes = [
				'name'        => 'version',
				'type'        => 'text',
				'class'       => 'readonly',
				'label'       => $lang_view . '_VERSION_LABEL',
				'description' => $lang_view . '_VERSION_DESC',
				'size'        => 6,
				'default'    => 1,
				'readonly'    => "true",
				'filter'      => 'unset'
			];
			$this->xml->comment(
				$field_set_xml,
				Line::_(__Line__, __Class__) . " Version Field. Type: Text (joomla)"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
		}
		// check if metadata is added to this view
		if ($this->metadata->isString($nameSingleCode))
		{
			// metakey
			if (!$this->fieldnames->isString($nameSingleCode . '.metakey'))
			{
				$attributes = [
					'name'        => 'metakey',
					'type'        => 'textarea',
					'label'       => 'JFIELD_META_KEYWORDS_LABEL',
					'description' => 'JFIELD_META_KEYWORDS_DESC',
					'rows'        => 3,
					'cols'        => 30
				];
				$this->xml->comment(
					$field_set_xml, Line::_(__Line__, __Class__)
					. " Metakey Field. Type: Textarea (joomla)"
				);
				$field_xml = $field_set_xml->addChild('field');
				$this->xml->attributes(
					$field_xml, $attributes
				);
				// count the static field created
				$this->counter->field++;
			}
			// metadesc
			if (!$this->fieldnames->isString($nameSingleCode . '.metadesc'))
			{
				$attributes['name']        = 'metadesc';
				$attributes['label']       = 'JFIELD_META_DESCRIPTION_LABEL';
				$attributes['description'] = 'JFIELD_META_DESCRIPTION_DESC';
				$this->xml->comment(
					$field_set_xml, Line::_(__Line__, __Class__)
					. " Metadesc Field. Type: Textarea (joomla)"
				);
				$field_xml = $field_set_xml->addChild('field');
				$this->xml->attributes(
					$field_xml, $attributes
				);
				// count the static field created
				$this->counter->field++;
			}
		}
		// fix the permissions field "title" issue gh-629
		// check if the title is not already set
		if (!$this->fieldnames->isString($nameSingleCode . '.title')
			&& $this->permission->check($view, $nameSingleCode))
		{
			// set the field/tab name
			$field_name = "title";
			$tab_name   = "publishing";

			$attributes = [
				'name'    => $field_name,
				'type'    => 'hidden',
				'default' => $component . ' ' . $nameSingleCode
			];
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " Was added due to Permissions JS needing a Title field"
			);
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " Let us know at gh-629 should this change"
			);
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__)
				. " https://github.com/vdm-io/Joomla-Component-Builder/issues/629#issuecomment-750117235"
			);
			$field_xml = $field_set_xml->addChild('field');
			$this->xml->attributes($field_xml, $attributes);
			// count the static field created
			$this->counter->field++;
			// setup needed field values for layout
			$field_array = [];
			$field_array['order_edit'] = 0;
			$field_array['tab'] = 15;
			$field_array['alignment'] = 1;
			// make sure it gets added to view
			$this->layout->set(
				$nameSingleCode, $tab_name, $field_name, $field_array
			);
		}
		// load the dynamic fields now
		if (count((array) $dynamic_fields_xml))
		{
			$this->xml->comment(
				$field_set_xml, Line::_(__Line__, __Class__) . " Dynamic Fields."
			);
			foreach ($dynamic_fields_xml as $dynamicfield)
			{
				$this->xml->append($field_set_xml, $dynamicfield);
			}
		}
		// check if metadata is added to this view
		if ($this->metadata->isString($nameSingleCode))
		{
			if (!$this->fieldnames->isString($nameSingleCode . '.robots')
				|| !$this->fieldnames->isString($nameSingleCode . '.author')
				|| !$this->fieldnames->isString($nameSingleCode . '.rights'))
			{
				$this->xml->comment(
					$field_set_xml, Line::_(__Line__, __Class__) . " Metadata Fields"
				);
				$fields_xml = $field_set_xml->addChild('fields');
				$fields_xml->addAttribute('name', 'metadata');
				$fields_xml->addAttribute(
					'label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS'
				);
				$fields_field_set_xml = $fields_xml->addChild('fieldset');
				$fields_field_set_xml->addAttribute('name', 'vdmmetadata');
				$fields_field_set_xml->addAttribute(
					'label', 'JGLOBAL_FIELDSET_METADATA_OPTIONS'
				);
				// robots
				if (!$this->fieldnames->isString($nameSingleCode . '.robots'))
				{
					$this->xml->comment(
						$fields_field_set_xml, Line::_(__Line__, __Class__)
						. " Robots Field. Type: List (joomla)"
					);
					$robots     = $fields_field_set_xml->addChild('field');
					$attributes = [
						'name'        => 'robots',
						'type'        => 'list',
						'label'       => 'JFIELD_METADATA_ROBOTS_LABEL',
						'description' => 'JFIELD_METADATA_ROBOTS_DESC'
					];
					$this->xml->attributes(
						$robots, $attributes
					);
					// count the static field created
					$this->counter->field++;
					$options = [
						'JGLOBAL_USE_GLOBAL'       => '',
						'JGLOBAL_INDEX_FOLLOW'     => 'index, follow',
						'JGLOBAL_NOINDEX_FOLLOW'   => 'noindex, follow',
						'JGLOBAL_INDEX_NOFOLLOW'   => 'index, nofollow',
						'JGLOBAL_NOINDEX_NOFOLLOW' => 'noindex, nofollow',
					];
					foreach ($options as $text => $value)
					{
						$option = $robots->addChild('option');
						$option->addAttribute('value', $value);
						$option[] = $text;
					}
				}
				// author
				if (!$this->fieldnames->isString($nameSingleCode . '.author'))
				{
					$this->xml->comment(
						$fields_field_set_xml, Line::_(__Line__, __Class__)
						. " Author Field. Type: Text (joomla)"
					);
					$author     = $fields_field_set_xml->addChild('field');
					$attributes = [
						'name'        => 'author',
						'type'        => 'text',
						'label'       => 'JAUTHOR',
						'description' => 'JFIELD_METADATA_AUTHOR_DESC',
						'size'        => 20
					];
					$this->xml->attributes(
						$author, $attributes
					);
					// count the static field created
					$this->counter->field++;
				}
				// rights
				if (!$this->fieldnames->isString($nameSingleCode . '.rights'))
				{
					$this->xml->comment(
						$fields_field_set_xml, Line::_(__Line__, __Class__)
						. " Rights Field. Type: Textarea (joomla)"
					);
					$rights     = $fields_field_set_xml->addChild('field');
					$attributes = [
						'name'        => 'rights',
						'type'        => 'textarea',
						'label'       => 'JFIELD_META_RIGHTS_LABEL',
						'description' => 'JFIELD_META_RIGHTS_DESC',
						'required'    => 'false',
						'filter'      => 'string',
						'cols'        => 30,
						'rows'        => 2
					];
					$this->xml->attributes(
						$rights, $attributes
					);
					// count the static field created
					$this->counter->field++;
				}
			}
		}

		// return the set
		return $this->xml->pretty($main_xml, 'fieldset');
	}
}

