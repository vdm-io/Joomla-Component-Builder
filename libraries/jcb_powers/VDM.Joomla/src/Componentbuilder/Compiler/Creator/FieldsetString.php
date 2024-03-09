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
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\Fieldsetinterface;


/**
 * Fieldset String Creator Class
 * 
 * @since 3.2.0
 */
final class FieldsetString implements Fieldsetinterface
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
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		Language $language, Event $event, Permission $permission,
		FieldDynamic $fielddynamic, FieldNames $fieldnames,
		AccessSwitch $accessswitch, MetaData $metadata,
		Layout $layout, Counter $counter)
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
		$read_only = false;
		if ($view['settings']->type == 2)
		{
			$read_only = Indent::_(3) . 'readonly="true"' . PHP_EOL . Indent::_(
					3
				) . 'disabled="true"';
		}
		// start adding dynamic fields
		$dynamic_fields = '';
		// set the custom table key
		$dbkey = 'g';

		// Trigger Event: jcb_ce_onBeforeBuildFields
		$this->event->trigger(
			'jcb_ce_onBeforeBuildFields',
			[&$dynamic_fields, &$read_only,
				&$dbkey, &$view, &$component, &$nameSingleCode,
				&$nameListCode, &$lang_view,
				&$lang_views]
		);

		// TODO we should add the global and local view switch if field for front end
		foreach ($view['settings']->fields as $field)
		{
			$dynamic_fields .= $this->fielddynamic->get(
				$field, $view, $view['settings']->type, $lang_view,
				$nameSingleCode, $nameListCode, $this->placeholder->active, $dbkey,
				true
			);
		}

		// Trigger Event: jcb_ce_onAfterBuildFields
		$this->event->trigger(
			'jcb_ce_onAfterBuildFields',
			[&$dynamic_fields, &$read_only,
				&$dbkey, &$view, &$component, &$nameSingleCode,
				&$nameListCode, &$lang_view,
				&$lang_views]
		);

		// set the default fields
		$field_set   = array();
		$field_set[] = '<fieldset name="details">';
		$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
			. " Default Fields. -->";
		$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
			. " Id Field. Type: Text (joomla) -->";
		// if id is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.id'))
		{
			$field_set[] = Indent::_(2) . "<field";
			$field_set[] = Indent::_(3) . "name=" . '"id"';
			$field_set[] = Indent::_(3)
				. 'type="text" class="readonly" label="JGLOBAL_FIELD_ID_LABEL"';
			$field_set[] = Indent::_(3)
				. 'description ="JGLOBAL_FIELD_ID_DESC" size="10" default="0"';
			$field_set[] = Indent::_(3) . 'readonly="true"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
		}
		// if created is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.created'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Date Created Field. Type: Calendar (joomla) -->";
			$field_set[] = Indent::_(2) . "<field";
			$field_set[] = Indent::_(3) . "name=" . '"created"';
			$field_set[] = Indent::_(3) . "type=" . '"calendar"';
			$field_set[] = Indent::_(3) . "label=" . '"' . $lang_view
				. '_CREATED_DATE_LABEL"';
			$field_set[] = Indent::_(3) . "description=" . '"' . $lang_view
				. '_CREATED_DATE_DESC"';
			$field_set[] = Indent::_(3) . "size=" . '"22"';
			if ($read_only)
			{
				$field_set[] = $read_only;
			}
			$field_set[] = Indent::_(3) . "format=" . '"%Y-%m-%d %H:%M:%S"';
			$field_set[] = Indent::_(3) . "filter=" . '"user_utc"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
		}
		// if created_by is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.created_by'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " User Created Field. Type: User (joomla) -->";
			$field_set[] = Indent::_(2) . "<field";
			$field_set[] = Indent::_(3) . "name=" . '"created_by"';
			$field_set[] = Indent::_(3) . "type=" . '"user"';
			$field_set[] = Indent::_(3) . "label=" . '"' . $lang_view
				. '_CREATED_BY_LABEL"';
			if ($read_only)
			{
				$field_set[] = $read_only;
			}
			$field_set[] = Indent::_(3) . "description=" . '"' . $lang_view
				. '_CREATED_BY_DESC"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
		}
		// if published is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.published'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Published Field. Type: List (joomla) -->";
			$field_set[] = Indent::_(2) . "<field name="
				. '"published" type="list" label="JSTATUS"';
			$field_set[] = Indent::_(3) . "description="
				. '"JFIELD_PUBLISHED_DESC" class="chzn-color-state"';
			if ($read_only)
			{
				$field_set[] = $read_only;
			}
			$field_set[] = Indent::_(3) . "filter="
				. '"intval" size="1" default="1" >';
			$field_set[] = Indent::_(3) . "<option value=" . '"1">';
			$field_set[] = Indent::_(4) . "JPUBLISHED</option>";
			$field_set[] = Indent::_(3) . "<option value=" . '"0">';
			$field_set[] = Indent::_(4) . "JUNPUBLISHED</option>";
			$field_set[] = Indent::_(3) . "<option value=" . '"2">';
			$field_set[] = Indent::_(4) . "JARCHIVED</option>";
			$field_set[] = Indent::_(3) . "<option value=" . '"-2">';
			$field_set[] = Indent::_(4) . "JTRASHED</option>";
			$field_set[] = Indent::_(2) . "</field>";
			// count the static field created
			$this->counter->field++;
		}
		// if modified is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.modified'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Date Modified Field. Type: Calendar (joomla) -->";
			$field_set[] = Indent::_(2)
				. '<field name="modified" type="calendar" class="readonly"';
			$field_set[] = Indent::_(3) . 'label="' . $lang_view
				. '_MODIFIED_DATE_LABEL" description="' . $lang_view
				. '_MODIFIED_DATE_DESC"';
			$field_set[] = Indent::_(3)
				. 'size="22" readonly="true" format="%Y-%m-%d %H:%M:%S" filter="user_utc" />';
			// count the static field created
			$this->counter->field++;
		}
		// if modified_by is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.modified_by'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " User Modified Field. Type: User (joomla) -->";
			$field_set[] = Indent::_(2)
				. '<field name="modified_by" type="user"';
			$field_set[] = Indent::_(3) . 'label="' . $lang_view
				. '_MODIFIED_BY_LABEL"';
			$field_set[] = Indent::_(3) . "description=" . '"' . $lang_view
				. '_MODIFIED_BY_DESC"';
			$field_set[] = Indent::_(3) . 'class="readonly"';
			$field_set[] = Indent::_(3) . 'readonly="true"';
			$field_set[] = Indent::_(3) . 'filter="unset"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
		}
		// check if view has access
		if ($this->accessswitch->exists($nameSingleCode)
			&& !$this->fieldnames->isString($nameSingleCode . '.access'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Access Field. Type: Accesslevel (joomla) -->";
			$field_set[] = Indent::_(2) . '<field name="access"';
			$field_set[] = Indent::_(3) . 'type="accesslevel"';
			$field_set[] = Indent::_(3) . 'label="JFIELD_ACCESS_LABEL"';
			$field_set[] = Indent::_(3) . 'description="JFIELD_ACCESS_DESC"';
			$field_set[] = Indent::_(3) . 'default="1"';
			if ($read_only)
			{
				$field_set[] = $read_only;
			}
			$field_set[] = Indent::_(3) . 'required="false"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
		}
		// if ordering is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.ordering'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Ordering Field. Type: Numbers (joomla) -->";
			$field_set[] = Indent::_(2) . "<field";
			$field_set[] = Indent::_(3) . 'name="ordering"';
			$field_set[] = Indent::_(3) . 'type="number"';
			$field_set[] = Indent::_(3) . 'class="inputbox validate-ordering"';
			$field_set[] = Indent::_(3) . 'label="' . $lang_view
				. '_ORDERING_LABEL' . '"';
			$field_set[] = Indent::_(3) . 'description=""';
			$field_set[] = Indent::_(3) . 'default="0"';
			$field_set[] = Indent::_(3) . 'size="6"';
			if ($read_only)
			{
				$field_set[] = $read_only;
			}
			$field_set[] = Indent::_(3) . 'required="false"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
		}
		// if version is not set
		if (!$this->fieldnames->isString($nameSingleCode . '.version'))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Version Field. Type: Text (joomla) -->";
			$field_set[] = Indent::_(2) . "<field";
			$field_set[] = Indent::_(3) . 'name="version"';
			$field_set[] = Indent::_(3) . 'type="text"';
			$field_set[] = Indent::_(3) . 'class="readonly"';
			$field_set[] = Indent::_(3) . 'label="' . $lang_view
				. '_VERSION_LABEL"';
			$field_set[] = Indent::_(3) . 'description="' . $lang_view
				. '_VERSION_DESC"';
			$field_set[] = Indent::_(3) . 'size="6"';
			$field_set[] = Indent::_(3) . 'default="1"';
			$field_set[] = Indent::_(3) . 'readonly="true"';
			$field_set[] = Indent::_(3) . 'filter="unset"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
		}
		// check if metadata is added to this view
		if ($this->metadata->isString($nameSingleCode))
		{
			// metakey
			if (!$this->fieldnames->isString($nameSingleCode . '.metakey'))
			{
				$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
					. " Metakey Field. Type: Textarea (joomla) -->";
				$field_set[] = Indent::_(2) . "<field";
				$field_set[] = Indent::_(3) . 'name="metakey"';
				$field_set[] = Indent::_(3) . 'type="textarea"';
				$field_set[] = Indent::_(3)
					. 'label="JFIELD_META_KEYWORDS_LABEL"';
				$field_set[] = Indent::_(3)
					. 'description="JFIELD_META_KEYWORDS_DESC"';
				$field_set[] = Indent::_(3) . 'rows="3"';
				$field_set[] = Indent::_(3) . 'cols="30"';
				$field_set[] = Indent::_(2) . "/>";
				// count the static field created
				$this->counter->field++;
			}
			// metadesc
			if (!$this->fieldnames->isString($nameSingleCode . '.metadesc'))
			{
				$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
					. " Metadesc Field. Type: Textarea (joomla) -->";
				$field_set[] = Indent::_(2) . "<field";
				$field_set[] = Indent::_(3) . 'name="metadesc"';
				$field_set[] = Indent::_(3) . 'type="textarea"';
				$field_set[] = Indent::_(3)
					. 'label="JFIELD_META_DESCRIPTION_LABEL"';
				$field_set[] = Indent::_(3)
					. 'description="JFIELD_META_DESCRIPTION_DESC"';
				$field_set[] = Indent::_(3) . 'rows="3"';
				$field_set[] = Indent::_(3) . 'cols="30"';
				$field_set[] = Indent::_(2) . "/>";
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
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Was added due to Permissions JS needing a Title field -->";
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Let us know at gh-629 should this change -->";
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " https://github.com/vdm-io/Joomla-Component-Builder/issues/629#issuecomment-750117235 -->";
			// at this point we know that we must add a hidden title field
			// and make sure it does not get stored to the database
			$field_set[] = Indent::_(2) . "<field";
			$field_set[] = Indent::_(3) . "name=" . '"' . $field_name . '"';
			$field_set[] = Indent::_(3)
				. 'type="hidden"';
			$field_set[] = Indent::_(3) . 'default="' . $component . ' '
				. $nameSingleCode . '"';
			$field_set[] = Indent::_(2) . "/>";
			// count the static field created
			$this->counter->field++;
			// setup needed field values for layout
			$field_array               = array();
			$field_array['order_edit'] = 0;
			$field_array['tab']        = 15;
			$field_array['alignment']  = 1;
			// make sure it gets added to view
			$this->layout->set(
				$nameSingleCode, $tab_name, $field_name, $field_array
			);
		}
		// load the dynamic fields now
		if (StringHelper::check($dynamic_fields))
		{
			$field_set[] = Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " Dynamic Fields. -->" . $dynamic_fields;
		}
		// close fieldset
		$field_set[] = Indent::_(1) . "</fieldset>";
		// check if metadata is added to this view
		if ($this->metadata->isString($nameSingleCode))
		{
			if (!$this->fieldnames->isString($nameSingleCode . '.robots')
				|| !$this->fieldnames->isString($nameSingleCode . '.rights')
				|| !$this->fieldnames->isString($nameSingleCode . '.author'))
			{
				$field_set[] = PHP_EOL . Indent::_(1) . "<!--" . Line::_(
						__LINE__,__CLASS__
					) . " Metadata Fields. -->";
				$field_set[] = Indent::_(1) . "<fields"
					. ' name="metadata" label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				$field_set[] = Indent::_(2) . '<fieldset name="vdmmetadata"';
				$field_set[] = Indent::_(3)
					. 'label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				// robots
				if (!$this->fieldnames->isString($nameSingleCode . '.robots'))
				{
					$field_set[] = Indent::_(3) . "<!--" . Line::_(
							__LINE__,__CLASS__
						) . " Robots Field. Type: List (joomla) -->";
					$field_set[] = Indent::_(3) . '<field name="robots"';
					$field_set[] = Indent::_(4) . 'type="list"';
					$field_set[] = Indent::_(4)
						. 'label="JFIELD_METADATA_ROBOTS_LABEL"';
					$field_set[] = Indent::_(4)
						. 'description="JFIELD_METADATA_ROBOTS_DESC" >';
					$field_set[] = Indent::_(4)
						. '<option value="">JGLOBAL_USE_GLOBAL</option>';
					$field_set[] = Indent::_(4)
						. '<option value="index, follow">JGLOBAL_INDEX_FOLLOW</option>';
					$field_set[] = Indent::_(4)
						. '<option value="noindex, follow">JGLOBAL_NOINDEX_FOLLOW</option>';
					$field_set[] = Indent::_(4)
						. '<option value="index, nofollow">JGLOBAL_INDEX_NOFOLLOW</option>';
					$field_set[] = Indent::_(4)
						. '<option value="noindex, nofollow">JGLOBAL_NOINDEX_NOFOLLOW</option>';
					$field_set[] = Indent::_(3) . '</field>';
					// count the static field created
					$this->counter->field++;
				}
				// author
				if (!$this->fieldnames->isString($nameSingleCode . '.author'))
				{
					$field_set[] = Indent::_(3) . "<!--" . Line::_(
							__LINE__,__CLASS__
						) . " Author Field. Type: Text (joomla) -->";
					$field_set[] = Indent::_(3) . '<field name="author"';
					$field_set[] = Indent::_(4) . 'type="text"';
					$field_set[] = Indent::_(4)
						. 'label="JAUTHOR" description="JFIELD_METADATA_AUTHOR_DESC"';
					$field_set[] = Indent::_(4) . 'size="20"';
					$field_set[] = Indent::_(3) . "/>";
					// count the static field created
					$this->counter->field++;
				}
				// rights
				if (!$this->fieldnames->isString($nameSingleCode . '.rights'))
				{
					$field_set[] = Indent::_(3) . "<!--" . Line::_(
							__LINE__,__CLASS__
						) . " Rights Field. Type: Textarea (joomla) -->";
					$field_set[] = Indent::_(3)
						. '<field name="rights" type="textarea" label="JFIELD_META_RIGHTS_LABEL"';
					$field_set[] = Indent::_(4)
						. 'description="JFIELD_META_RIGHTS_DESC" required="false" filter="string"';
					$field_set[] = Indent::_(4) . 'cols="30" rows="2"';
					$field_set[] = Indent::_(3) . "/>";
					// count the static field created
					$this->counter->field++;
				}
				$field_set[] = Indent::_(2) . "</fieldset>";
				$field_set[] = Indent::_(1) . "</fields>";
			}
		}

		// return the set
		return implode(PHP_EOL, $field_set);
	}
}

