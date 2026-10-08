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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\FilterSetInterface;


/**
 * Admin Views Filter Set Class.
 * 
 * Builds the filter fields the list view of a component is searched with: the
 * search box, whatever of the status, category and access filters the view was
 * given, and every filter the component declared for it.
 * 
 * Which attributes each of those fields carries is what the compile target
 * decides, and they are the extension points below.
 * 
 * @since 6.1.7
 */
class FilterSet implements FilterSetInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * The Admin Filter Type Builder Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The Field Names Builder Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * The Category Builder Class.
	 *
	 * @var   Category
	 * @since 6.1.7
	 */
	protected Category $category;

	/**
	 * The Access Switch Builder Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The Filter Builder Class.
	 *
	 * @var   Filter
	 * @since 6.1.7
	 */
	protected Filter $filter;

	/**
	 * Constructor.
	 *
	 * @param Config          $config          The Config Class.
	 * @param Language        $language        The Language Class.
	 * @param Structure       $structure       The Structure Class.
	 * @param AdminFilterType $adminfiltertype The Admin Filter Type Builder Class.
	 * @param FieldNames      $fieldnames      The Field Names Builder Class.
	 * @param Category        $category        The Category Builder Class.
	 * @param AccessSwitch    $accessswitch    The Access Switch Builder Class.
	 * @param Filter          $filter          The Filter Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Language $language,
		Structure $structure,
		AdminFilterType $adminfiltertype,
		FieldNames $fieldnames,
		Category $category,
		AccessSwitch $accessswitch,
		Filter $filter)
	{
		$this->config = $config;
		$this->language = $language;
		$this->structure = $structure;
		$this->adminfiltertype = $adminfiltertype;
		$this->fieldnames = $fieldnames;
		$this->category = $category;
		$this->accessswitch = $accessswitch;
		$this->filter = $filter;
	}

	/**
	 * Build the filter fields of a list view.
	 *
	 * Only a view the component was given the searchable filter for gets any.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The fields, in xml.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		// check if this is the above/new filter option
		if ($this->adminfiltertype->get($nameListCode, 1) == 2)
		{
			// we first create the file
			$target = ['admin' => 'filter_' . $nameListCode];
			$this->structure->build(
				$target, 'filter'
			);
			// the search language string
			$lang_search = $this->config->lang_prefix . '_FILTER_SEARCH';
			// and to translation
			$this->language->set(
				$this->config->lang_target, $lang_search, 'Search'
				. StringHelper::safe($nameListCode, 'w')
			);
			// the search description language string
			$lang_search_desc = $this->config->lang_prefix . '_FILTER_SEARCH_'
				. strtoupper($nameListCode);
			// and to translation
			$this->language->set(
				$this->config->lang_target, $lang_search_desc, 'Search the '
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
			if (!$this->fieldnames->isString($nameSingleCode . '.published'))
			{
				$field_filter_sets = array_merge(
					$field_filter_sets, $this->publishedField($nameListCode)
				);
			}
			// add the category if found
			if ($this->category->exists("{$nameListCode}.extension")
				&& $this->category->get("{$nameListCode}.filter", 0) >= 1)
			{
				$field_filter_sets = array_merge(
					$field_filter_sets, $this->categoryField($nameListCode)
				);
			}
			// add the access filter if this view has access
			// and if access manually is not set
			if ($this->accessswitch->exists($nameSingleCode)
				&& !$this->fieldnames->isString($nameSingleCode . '.access'))
			{
				$field_filter_sets = array_merge(
					$field_filter_sets, $this->accessField()
				);
			}
			// now add the dynamic fields
			if ($this->filter->exists($nameListCode))
			{
				foreach ($this->filter->get($nameListCode) as $n => $filter)
				{
					if ($filter['type'] != 'category')
					{
						$field_filter_sets = array_merge(
							$field_filter_sets,
							$this->dynamicField($nameListCode, $n, $filter)
						);
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
	 * The status filter of a view that was not given one of its own.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function publishedField($nameListCode): array
	{
		// the published language string
		$lang_published = $this->config->lang_prefix . '_FILTER_PUBLISHED';
		// and to translation
		$this->language->set(
			$this->config->lang_target, $lang_published, 'Status'
		);
		// the published description language string
		$lang_published_desc = $this->config->lang_prefix . '_FILTER_PUBLISHED_'
			. strtoupper($nameListCode);
		// and to translation
		$this->language->set(
			$this->config->lang_target, $lang_published_desc, 'Status options for '
			. StringHelper::safe($nameListCode, 'w')
		);
		$lines   = [];
		$lines[] = Indent::_(2) . '<field';
		$lines[] = Indent::_(3) . 'type="status"';
		$lines[] = Indent::_(3) . 'name="published"';
		$lines[] = Indent::_(3)
			. 'label="' . $lang_published . '"';
		$lines[] = Indent::_(3)
			. 'description="' . $lang_published_desc . '"';
		$lines[] = Indent::_(3)
			. 'class="js-select-submit-on-change"';
		$lines[] = Indent::_(2) . '>';
		$lines[] = Indent::_(3)
			. '<option value="">JOPTION_SELECT_PUBLISHED</option>';
		$lines[] = Indent::_(2) . '</field>';

		return $lines;
	}

	/**
	 * The category filter of a view the compiler found a category for.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function categoryField($nameListCode): array
	{
		$lines   = [];
		$lines[] = Indent::_(2) . '<field';
		$lines[] = Indent::_(3) . 'type="category"';
		$lines[] = Indent::_(3) . 'name="category_id"';
		$lines[] = Indent::_(3)
			. 'label="' . $this->category->get("{$nameListCode}.name", 'error')
			. '"';
		$lines[] = Indent::_(3)
			. 'description="JOPTION_FILTER_CATEGORY_DESC"';
		$lines[] = Indent::_(3) . 'multiple="true"';
		$lines[] = Indent::_(3)
			. 'class="js-select-submit-on-change"';
		$lines[] = Indent::_(3) . 'extension="'
			. $this->category->get("{$nameListCode}.extension") . '"';
		$lines[] = Indent::_(3)
			. 'layout="joomla.form.field.list-fancy-select"';
		// TODO NOT SURE IF THIS SHOULD BE STATIC
		$lines[] = Indent::_(3) . 'published="0,1,2"';
		$lines[] = Indent::_(2) . '/>';

		return $lines;
	}

	/**
	 * The access filter of a view that has access and was not given one.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function accessField(): array
	{
		$lines   = [];
		$lines[] = Indent::_(2) . '<field';
		$lines[] = Indent::_(3) . 'type="accesslevel"';
		$lines[] = Indent::_(3) . 'name="access"';
		$lines[] = Indent::_(3)
			. 'label="JGRID_HEADING_ACCESS"';
		$lines[] = Indent::_(3)
			. 'hint="JOPTION_SELECT_ACCESS"';
		$lines[] = Indent::_(3) . 'multiple="true"';
		$lines[] = Indent::_(3)
			. 'class="js-select-submit-on-change"';
		$lines[] = Indent::_(3)
			. 'layout="joomla.form.field.list-fancy-select"';
		$lines[] = Indent::_(2) . '/>';

		return $lines;
	}

	/**
	 * One filter the component declared for this view.
	 *
	 * @param   string  $nameListCode  The list view name.
	 * @param   int     $n             Where the filter sits in the set.
	 * @param   array   $filter        The filter details.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function dynamicField($nameListCode, $n, $filter): array
	{
		$lines   = [];
		$lines[] = Indent::_(2) . '<field';
		// if this is a custom field
		if (ArrayHelper::check($filter['custom']))
		{
			// we use the field type from the custom field
			$lines[] = Indent::_(3) . 'type="'
				. $filter['type'] . '"';
			// set css classname of this field
			$filter_class = ucfirst((string) $filter['type']);

			// if this is a modal_select field
			$modal_select = $filter['custom']['modal_select'] ?? null;
			if ($modal_select)
			{
				$lines[] = Indent::_(3) . 'sql_title_table="'
					. $filter['custom']['table'] . '"';
				$lines[] = Indent::_(3) . 'sql_title_column="'
					. $filter['custom']['text'] . '"';
				$lines[] = Indent::_(3) . 'sql_title_key="'
					. $filter['custom']['id'] . '"';
				$lines[] = Indent::_(3) . 'urlSelect="'
					. $filter['custom']['urlSelect'] . '"';
				$lines[] = Indent::_(3) . 'hint="'
					. $filter['custom']['hint'] . '"';
				$lines[] = Indent::_(3) . 'titleSelect="'
					. $filter['custom']['titleSelect'] . '"';
				$lines[] = Indent::_(3) . 'iconSelect="'
					. $filter['custom']['iconSelect'] . '"';
				$lines[] = Indent::_(3) . 'select="true"';
				$lines[] = Indent::_(3) . 'edit="false"';
				$lines[] = Indent::_(3) . 'clear="true"';
				$lines[] = Indent::_(3) . 'onchange="form.submit()"';
			}
		}
		else
		{
			// we use the filter field type that was build
			$lines[] = Indent::_(3) . 'type="'
				. $filter['filter_type'] . '"';
			// set css classname of this field
			$filter_class = ucfirst((string) $filter['filter_type']);
		}

		$lines[] = Indent::_(3) . 'name="'
			. $filter['code'] . '"';
		$lines[] = Indent::_(3) . 'label="'
			. $filter['label'] . '"';

		// if this is a multi field
		if ($filter['multi'] == 2)
		{
			$lines[] = Indent::_(3) . 'layout="joomla.form.field.list-fancy-select"';
			$lines[] = Indent::_(3) . 'multiple="true"';
			if (isset($filter['lang_select']))
			{
				$lines[] = Indent::_(3) . 'hint="' . $filter['lang_select'] . '"';
			}
		}
		else
		{
			$lines[] = Indent::_(3) . 'multiple="false"';
		}

		// we add the on change css class
		$lines[] = Indent::_(3) . 'class="js-select-submit-on-change"';
		$lines[] = Indent::_(2) . '/>';

		return $lines;
	}
}

