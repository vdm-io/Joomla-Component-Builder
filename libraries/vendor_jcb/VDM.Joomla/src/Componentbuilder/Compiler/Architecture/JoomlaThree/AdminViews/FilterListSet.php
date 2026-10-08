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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\FilterListSet as ExtendingFilterListSet;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\FilterListSetInterface;


/**
 * Joomla 3 Admin Views Filter List Set Class.
 * 
 * A Joomla 3 list borrows the content component's own strings for the two
 * fields, and submits its form from an onchange attribute rather than the
 * class every later target gives it.
 * 
 * @since 6.1.7
 */
final class FilterListSet extends ExtendingFilterListSet implements FilterListSetInterface
{
	/**
	 * How the ordering field is labelled and told to submit.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function orderingAttributes(): array
	{
		return [
			Indent::_(3) . 'label="COM_CONTENT_LIST_FULL_ORDERING"',
			Indent::_(3) . 'description="COM_CONTENT_LIST_FULL_ORDERING_DESC"',
			Indent::_(3) . 'onchange="this.form.submit();"'
		];
	}

	/**
	 * The field that says how many rows the list shows at a time.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function limitField(): array
	{
		$lines   = [];
		$lines[] = Indent::_(2) . '<field';
		$lines[] = Indent::_(3) . 'name="limit"';
		$lines[] = Indent::_(3) . 'type="limitbox"';
		$lines[] = Indent::_(3) . 'label="COM_CONTENT_LIST_LIMIT"';
		$lines[] = Indent::_(3)
			. 'description="COM_CONTENT_LIST_LIMIT_DESC"';
		$lines[] = Indent::_(3) . 'class="input-mini"';
		$lines[] = Indent::_(3) . 'default="25"';
		$lines[] = Indent::_(3) . 'onchange="this.form.submit();"';
		$lines[] = Indent::_(2) . '/>';

		return $lines;
	}
}

