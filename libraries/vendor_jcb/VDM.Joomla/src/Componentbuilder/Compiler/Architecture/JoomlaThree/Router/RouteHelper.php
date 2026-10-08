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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Router;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Router\RouteHelper as SharedRouteHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Joomla 3 Route Helper Class.
 * 
 * Joomla 3 finds a link's menu item through the core needle lookup, so the
 * generated method gathers needles as it builds the link — one for the view
 * itself, and the whole category path when the link carries a category — and
 * hands them to `_findItem`. A view with no menu item of its own still asks,
 * with only the needles to go on.
 * 
 * @since  6.1.7
 */
final class RouteHelper extends SharedRouteHelper
{
	/**
	 * Build the needles the core menu lookup is given.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $id              The generated expression of the item id, if the link carries one.
	 *
	 * @return  array  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function needles(string $nameSingleCode, string $id): array
	{
		return [
			Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Initialize the needel array.",
			Indent::_(3) . "\$needles = array(",
			Indent::_(4) . "'" . $nameSingleCode . "'  => array(" . $id . ")",
			Indent::_(3) . ");",
		];
	}

	/**
	 * Build what a category adds to the link.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 *
	 * @return  array  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function categoryLink(string $nameListCode): array
	{
		return [
			Indent::_(3) . "\$categories = Categories::getInstance('"
				. $this->config->component_code_name . "." . $nameListCode . "');",
			Indent::_(3) . "\$category = \$categories->get(\$catid);",
			Indent::_(3) . "if (\$category)",
			Indent::_(3) . "{",
			Indent::_(4) . "\$needles['category'] = array_reverse(\$category->getPath());",
			Indent::_(4) . "\$needles['categories'] = \$needles['category'];",
			Indent::_(4) . "\$link .= '&catid='.\$catid;",
			Indent::_(3) . "}",
		];
	}

	/**
	 * Build the test that finds this view's own menu item.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  string  The line.
	 *
	 * @since   6.1.7
	 */
	protected function findItem(string $nameSingleCode): string
	{
		return PHP_EOL . Indent::_(2)
			. "if (\$item = self::_findItem(\$needles, '" . $nameSingleCode . "'))";
	}

	/**
	 * Build the fallback that finds any menu item the needles reach.
	 *
	 * @return  array  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function findAnyItem(): array
	{
		return [
			PHP_EOL . Indent::_(2) . "if (\$item = self::_findItem(\$needles))",
			Indent::_(2) . "{",
			Indent::_(3) . "\$link .= '&Itemid='.\$item;",
			Indent::_(2) . "}",
		];
	}
}

