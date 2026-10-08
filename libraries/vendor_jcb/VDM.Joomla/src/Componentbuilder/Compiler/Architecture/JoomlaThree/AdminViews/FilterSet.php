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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\FilterSet as ExtendingFilterSet;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\FilterSetInterface;


/**
 * Joomla 3 Admin Views Filter Set Class.
 * 
 * A Joomla 3 filter field submits its form from an onchange attribute of its
 * own rather than the class every later target gives it, is styled by a class
 * named after what it holds, and knows nothing of the fancy select layout or
 * of picking a value through a modal.
 * 
 * @since 6.1.7
 */
final class FilterSet extends ExtendingFilterSet implements FilterSetInterface
{
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
			. 'onchange="this.form.submit();"';
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
			. 'class="multipleCategories"';
		$lines[] = Indent::_(3) . 'extension="'
			. $this->category->get("{$nameListCode}.extension") . '"';
		$lines[] = Indent::_(3)
			. 'onchange="this.form.submit();"';
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
			. 'label="JFIELD_ACCESS_LABEL"';
		$lines[] = Indent::_(3)
			. 'description="JFIELD_ACCESS_DESC"';
		$lines[] = Indent::_(3) . 'multiple="true"';
		$lines[] = Indent::_(3)
			. 'class="multipleAccessLevels"';
		$lines[] = Indent::_(3)
			. 'onchange="this.form.submit();"';
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
		}
		else
		{
			// we use the filter field type that was build
			$lines[] = Indent::_(3) . 'type="'
				. $filter['filter_type'] . '"';
			// set css classname of this field
			$filter_class = ucfirst((string) $filter['filter_type']);
		}
		// update global data set
		$this->filter->set("{$nameListCode}.{$n}.class", $filter_class);

		$lines[] = Indent::_(3) . 'name="'
			. $filter['code'] . '"';
		$lines[] = Indent::_(3) . 'label="'
			. $filter['label'] . '"';

		// if this is a multi field
		if ($filter['multi'] == 2)
		{
			$lines[] = Indent::_(3) . 'class="multiple' . $filter_class . '"';
			$lines[] = Indent::_(3) . 'multiple="true"';
		}
		else
		{
			$lines[] = Indent::_(3) . 'multiple="false"';
		}

		$lines[] = Indent::_(3)
			. 'onchange="this.form.submit();"';
		$lines[] = Indent::_(2) . '/>';

		return $lines;
	}
}

