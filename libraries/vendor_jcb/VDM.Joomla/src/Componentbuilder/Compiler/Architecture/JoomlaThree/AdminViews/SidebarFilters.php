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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\SidebarFiltersInterface;


/**
 * Joomla 3 Admin Views Sidebar Filters Class.
 * 
 * Builds the statements a Joomla 3 list view runs to put its filters in the
 * sidebar: the published and access filters every view has, the category
 * filter of a view that has categories, and one for every other filter field
 * the view was given.
 * 
 * @since 6.1.7
 */
final class SidebarFilters implements SidebarFiltersInterface
{
	/**
	 * The Admin Filter Type Builder Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The Filter Builder Class.
	 *
	 * @var   Filter
	 * @since 6.1.7
	 */
	protected Filter $filter;

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
	 * Constructor.
	 *
	 * @param AdminFilterType $adminfiltertype The Admin Filter Type Builder Class.
	 * @param Filter          $filter          The Filter Builder Class.
	 * @param ContentOne      $contentone      The Content One Builder Class.
	 * @param AccessSwitch    $accessswitch    The Access Switch Builder Class.
	 * @param FieldNames      $fieldnames      The Field Names Builder Class.
	 * @param Category        $category        The Category Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(AdminFilterType $adminfiltertype,
		Filter $filter,
		ContentOne $contentone,
		AccessSwitch $accessswitch,
		FieldNames $fieldnames,
		Category $category)
	{
		$this->adminfiltertype = $adminfiltertype;
		$this->filter = $filter;
		$this->contentone = $contentone;
		$this->accessswitch = $accessswitch;
		$this->fieldnames = $fieldnames;
		$this->category = $category;
	}

	/**
	 * Build the statements a list view runs to put its filters in the sidebar.
	 *
	 * The published filter every view has, the access filter of a view that
	 * carries one, the category filter of a view with categories, and one for
	 * every other filter field the view was given.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The statements, or nothing when the view asks for none.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		// start the filter bucket
		$fieldFilters = [];
		// add the default filter
		$this->addDefaultFilters(
			$fieldFilters, $nameSingleCode, $nameListCode
		);
		// add the category filter stuff
		$this->addCategoryFilter($fieldFilters, $nameListCode);
		// check if filter fields are added (1 = sidebar)
		if ($this->adminfiltertype->get($nameListCode, 1) == 1
			&& $this->filter->exists($nameListCode))
		{
			// get component name
			$Component = $this->contentone->get('Component');
			// load the rest of the filters
			foreach ($this->filter->get($nameListCode) as $filter)
			{
				if ($filter['type'] != 'category'
					&& ArrayHelper::check($filter['custom'])
					&& $filter['custom']['extends'] !== 'user')
				{
					$CodeName       = StringHelper::safe(
						$filter['code'] . ' ' . $filter['custom']['text'], 'W'
					);
					$codeName       = $filter['code']
						. StringHelper::safe(
							$filter['custom']['text'], 'F'
						);
					$type           = StringHelper::safe(
						$filter['custom']['type'], 'F'
					);
					$fieldFilters[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Set " . $CodeName
						. " Selection";
					$fieldFilters[] = Indent::_(2) . "\$this->" . $codeName
						. "Options = FormHelper::loadFieldType('" . $type
						. "')->options;";
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " We do some sanitation for " . $CodeName
						. " filter";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $codeName
						. "Options) &&";
					$fieldFilters[] = Indent::_(3) . "isset(\$this->"
						. $codeName
						. "Options[0]->value) &&";
					$fieldFilters[] = Indent::_(3) . "!"
						. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $codeName
						. "Options[0]->value))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "unset(\$this->"
						. $codeName
						. "Options[0]);";
					$fieldFilters[] = Indent::_(2) . "}";
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Only load " . $CodeName
						. " filter if it has values";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $codeName
						. "Options))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $CodeName . " Filter";
					$fieldFilters[] = Indent::_(3) . "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addFilter(";
					$fieldFilters[] = Indent::_(4) . "'- Select ' . Text:"
						. ":_('" . $filter['lang'] . "') . ' -',";
					$fieldFilters[] = Indent::_(4) . "'filter_"
						. $filter['code']
						. "',";
					$fieldFilters[] = Indent::_(4)
						. "Html::_('select.options', \$this->" . $codeName
						. "Options, 'value', 'text', \$this->state->get('filter."
						. $filter['code'] . "'))";
					$fieldFilters[] = Indent::_(3) . ");";
					$fieldFilters[] = Indent::_(2) . "}";
				}
				elseif ($filter['type'] != 'category')
				{
					$Codename = StringHelper::safe(
						$filter['code'], 'W'
					);
					if (isset($filter['custom'])
						&& ArrayHelper::check($filter['custom'])
						&& $filter['custom']['extends'] === 'user')
					{
						$functionName = "\$this->getThe" . $filter['function']
							. StringHelper::safe(
								$filter['custom']['text'], 'F'
							) . "Selections();";
					}
					else
					{
						$functionName = "\$this->getThe" . $filter['function']
							. "Selections();";
					}
					$fieldFilters[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Set " . $Codename
						. " Selection";
					$fieldFilters[] = Indent::_(2) . "\$this->"
						. $filter['code']
						. "Options = " . $functionName;
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " We do some sanitation for " . $Codename
						. " filter";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $filter['code']
						. "Options) &&";
					$fieldFilters[] = Indent::_(3) . "isset(\$this->"
						. $filter['code'] . "Options[0]->value) &&";
					$fieldFilters[] = Indent::_(3) . "!"
						. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $filter['code']
						. "Options[0]->value))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "unset(\$this->"
						. $filter['code'] . "Options[0]);";
					$fieldFilters[] = Indent::_(2) . "}";
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Only load " . $Codename
						. " filter if it has values";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $filter['code']
						. "Options))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $Codename . " Filter";
					$fieldFilters[] = Indent::_(3) . "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addFilter(";
					$fieldFilters[] = Indent::_(4) . "'- Select '.Text:"
						. ":_('" . $filter['lang'] . "').' -',";
					$fieldFilters[] = Indent::_(4) . "'filter_"
						. $filter['code']
						. "',";
					$fieldFilters[] = Indent::_(4)
						. "Html::_('select.options', \$this->"
						. $filter['code']
						. "Options, 'value', 'text', \$this->state->get('filter."
						. $filter['code'] . "'))";
					$fieldFilters[] = Indent::_(3) . ");";

					$fieldFilters[] = Indent::_(2) . "}";
				}
			}
		}
		// did we find filters
		if (ArrayHelper::check($fieldFilters))
		{
			// return the filter
			return PHP_EOL . implode(PHP_EOL, $fieldFilters);
		}

		return '';
	}
	/**
	 * add default filter helper
	 *
	 * @param   array   $filter          The batch code array
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 */
	protected function addDefaultFilters(&$filter, &$nameSingleCode,
		&$nameListCode
	)
	{
		// add the default filters if we are on the old filter paths (1 = sidebar)
		if ($this->adminfiltertype->get($nameListCode, 1) == 1)
		{
			// set batch
			$filter[] = PHP_EOL . Indent::_(2)
				. "//" . Line::_(__Line__, __Class__)
				. " Only load publish filter if state change is allowed";
			$filter[] = Indent::_(2)
				. "if (\$this->canState)";
			$filter[] = Indent::_(2) . "{";
			$filter[] = Indent::_(3) . "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addFilter(";
			$filter[] = Indent::_(4) . "Text:"
				. ":_('JOPTION_SELECT_PUBLISHED'),";
			$filter[] = Indent::_(4) . "'filter_published',";
			$filter[] = Indent::_(4)
				. "Html::_('select.options', Html::_('jgrid.publishedOptions'), 'value', 'text', \$this->state->get('filter.published'), true)";
			$filter[] = Indent::_(3) . ");";
			$filter[] = Indent::_(2) . "}";
			// check if view has access
			if ($this->accessswitch->exists($nameSingleCode)
				&& !$this->fieldnames->isString($nameSingleCode . '.access'))
			{
				$filter[] = PHP_EOL . Indent::_(2) . "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addFilter(";
				$filter[] = Indent::_(3) . "Text:"
					. ":_('JOPTION_SELECT_ACCESS'),";
				$filter[] = Indent::_(3) . "'filter_access',";
				$filter[] = Indent::_(3)
					. "Html::_('select.options', Html::_('access.assetgroups'), 'value', 'text', \$this->state->get('filter.access'))";
				$filter[] = Indent::_(2) . ");";
			}
		}
	}
	/**
	 * build category sidebar display filter helper
	 *
	 * @param   array   $filter        The filter code array
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  void
	 *
	 *
	 * @since   3.2.0
	 */
	protected function addCategoryFilter(&$filter, &$nameListCode)
	{
		// add the category filter if we are on the old filter paths (1 = sidebar)
		if ($this->adminfiltertype->get($nameListCode, 1) == 1
			&& $this->category->exists("{$nameListCode}.extension")
			&& $this->category->get("{$nameListCode}.filter", 0) >= 1)
		{
			// set filter
			$filter[] = PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Category Filter.";
			$filter[] = Indent::_(2) . "Joomla__"."_ca5456e1_552c_45fb_bf4c_b751ba6e9fa1___Power::addFilter(";
			$filter[] = Indent::_(3) . "Text:"
				. ":_('JOPTION_SELECT_CATEGORY'),";
			$filter[] = Indent::_(3) . "'filter_category_id',";
			$filter[] = Indent::_(3)
				. "Html::_('select.options', Html::_('category.options', '"
				. $this->category->get("{$nameListCode}.extension")
				. "'), 'value', 'text', \$this->state->get('filter.category_id'))";
			$filter[] = Indent::_(2) . ");";
		}
	}
}

