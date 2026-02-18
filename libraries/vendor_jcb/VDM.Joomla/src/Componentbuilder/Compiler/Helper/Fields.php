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


use Joomla\CMS\Factory;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Fields class
 * 
 * @deprecated 3.3
 */
class Fields
{
	/**
	 * The app
	 *
	 * @var     object
	 */
	protected $app;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// load application
		$this->app = Factory::getApplication();

		return true;
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
			$default_ordering = CFactory::_('Adminview.DefaultOrdering')->get(
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

							// if this is a modal_select field
							$modal_select = $filter['custom']['modal_select'] ?? null;
							if ($modal_select)
							{
								$field_filter_sets[] = Indent::_(3) . 'sql_title_table="'
									. $filter['custom']['table'] . '"';
								$field_filter_sets[] = Indent::_(3) . 'sql_title_column="'
									. $filter['custom']['text'] . '"';
								$field_filter_sets[] = Indent::_(3) . 'sql_title_key="'
									. $filter['custom']['id'] . '"';
								$field_filter_sets[] = Indent::_(3) . 'urlSelect="'
									. $filter['custom']['urlSelect'] . '"';
								$field_filter_sets[] = Indent::_(3) . 'hint="'
									. $filter['custom']['hint'] . '"';
								$field_filter_sets[] = Indent::_(3) . 'titleSelect="'
									. $filter['custom']['titleSelect'] . '"';
								$field_filter_sets[] = Indent::_(3) . 'iconSelect="'
									. $filter['custom']['iconSelect'] . '"';
								$field_filter_sets[] = Indent::_(3) . 'select="true"';
								$field_filter_sets[] = Indent::_(3) . 'edit="false"';
								$field_filter_sets[] = Indent::_(3) . 'clear="true"';
								$field_filter_sets[] = Indent::_(3) . 'onchange="form.submit()"';
							}
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
			$default_ordering = CFactory::_('Adminview.DefaultOrdering')->get(
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
}

