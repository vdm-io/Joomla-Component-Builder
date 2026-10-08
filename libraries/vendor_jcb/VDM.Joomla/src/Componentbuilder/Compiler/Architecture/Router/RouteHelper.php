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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Router;


use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryCode;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HasMenuGlobal;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Router\RouteHelperInterface;


/**
 * Route Helper Class.
 * 
 * Builds the route method a site view offers the rest of the generated
 * component, so anything that links to one of its items asks for the link
 * rather than assembling it. A view gets one when it carries tags, or when it
 * is a front item view, and only ever gets one.
 * 
 * How the link finds its menu item is the part that differs by target: Joomla
 * 3 gathers needles for the core menu lookup as it goes, and later targets ask
 * the router for the item directly. Those pieces are the extension points
 * below.
 * 
 * @since  6.1.7
 */
class RouteHelper implements RouteHelperInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Category Code Builder Class.
	 *
	 * @var   CategoryCode
	 * @since 6.1.7
	 */
	protected CategoryCode $categorycode;

	/**
	 * The Has Menu Global Builder Class.
	 *
	 * @var   HasMenuGlobal
	 * @since 6.1.7
	 */
	protected HasMenuGlobal $hasmenuglobal;

	/**
	 * The Tags Builder Class.
	 *
	 * @var   Tags
	 * @since 6.1.7
	 */
	protected Tags $tags;

	/**
	 * The views that already have a route method, so none gets a second.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $done = [];

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param CategoryCode   $categorycode   The Category Code Builder Class.
	 * @param HasMenuGlobal  $hasmenuglobal  The Has Menu Global Builder Class.
	 * @param Tags           $tags           The Tags Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, CategoryCode $categorycode,
		HasMenuGlobal $hasmenuglobal, Tags $tags)
	{
		$this->config = $config;
		$this->categorycode = $categorycode;
		$this->hasmenuglobal = $hasmenuglobal;
		$this->tags = $tags;
	}

	/**
	 * Build the route method one site view offers.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   bool    $front           Whether this is a front item view, which always gets one.
	 *
	 * @return  string  The method, or nothing when the view needs none or already has one.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode, bool $front = false): string
	{
		// add if tags is added, also for all front item views
		if (($this->tags->exists($nameSingleCode) || $front)
			&& (!in_array($nameSingleCode, $this->done)))
		{
			// insure we load a view only once
			$this->done[] = $nameSingleCode;
			// build view route helper
			$View = StringHelper::safe(
				$nameSingleCode, 'F'
			);

			$hasCategory = ($this->categorycode->exists($nameSingleCode) &&
				'category' !== $nameSingleCode && 'categories' !== $nameSingleCode);

			$routeHelper   = [];
			$routeHelper[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$routeHelper[] = Indent::_(1) . " * Get the URL route for {$nameSingleCode}";
			$routeHelper[] = Indent::_(1) . " *";
			$routeHelper[] = Indent::_(1) . " * @param   integer  \$id     The id of the {$nameSingleCode}";

			if ($hasCategory)
			{
				$routeHelper[] = Indent::_(1) . " * @param   integer  \$catid  The id of the {$nameSingleCode}'s category";
				$routeHelper[] = Indent::_(1) . " *";
				$routeHelper[] = Indent::_(1) . " * @return  string  The link to the {$nameSingleCode}";
				$routeHelper[] = Indent::_(1) . " *";
				$routeHelper[] = Indent::_(1) . " * @since   1.5";
				$routeHelper[] = Indent::_(1) . " */";
				$routeHelper[] = Indent::_(1) . "public static function get" . $View . "Route(\$id = 0, \$catid = 0): string";
			}
			else
			{
				$routeHelper[] = Indent::_(1) . " *";
				$routeHelper[] = Indent::_(1) . " * @return  string  The link to the {$nameSingleCode}";
				$routeHelper[] = Indent::_(1) . " *";
				$routeHelper[] = Indent::_(1) . " * @since   1.5";
				$routeHelper[] = Indent::_(1) . " */";
				$routeHelper[] = Indent::_(1) . "public static function get" . $View . "Route(\$id = 0): string";
			}

			$routeHelper[] = Indent::_(1) . "{";
			$routeHelper[] = Indent::_(2) . "if (\$id > 0)";
			$routeHelper[] = Indent::_(2) . "{";

			$routeHelper = array_merge(
				$routeHelper, $this->needles($nameSingleCode, '(int) $id')
			);

			$routeHelper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Create the link";
			$routeHelper[] = Indent::_(3) . "\$link = 'index.php?option=com_"
				. $this->config->component_code_name . "&view=" . $nameSingleCode
				. "&id='. \$id;";
			$routeHelper[] = Indent::_(2) . "}";
			$routeHelper[] = Indent::_(2) . "else";
			$routeHelper[] = Indent::_(2) . "{";

			$routeHelper = array_merge(
				$routeHelper, $this->needles($nameSingleCode, '')
			);

			$routeHelper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Create the link but don't add the id.";
			$routeHelper[] = Indent::_(3) . "\$link = 'index.php?option=com_"
				. $this->config->component_code_name . "&view=" . $nameSingleCode . "';";
			$routeHelper[] = Indent::_(2) . "}";

			if ($hasCategory)
			{
				$routeHelper[] = Indent::_(2) . "if (\$catid > 1)";
				$routeHelper[] = Indent::_(2) . "{";

				$routeHelper = array_merge($routeHelper, $this->categoryLink($nameListCode));

				$routeHelper[] = Indent::_(2) . "}";
			}

			if ($this->hasmenuglobal->exists($nameSingleCode))
			{
				$routeHelper[] = $this->findItem($nameSingleCode);
				$routeHelper[] = Indent::_(2) . "{";
				$routeHelper[] = Indent::_(3) . "\$link .= '&Itemid='.\$item;";
				$routeHelper[] = Indent::_(2) . "}";
			}
			else
			{
				$routeHelper = array_merge($routeHelper, $this->findAnyItem());
			}

			$routeHelper[] = PHP_EOL . Indent::_(2) . "return \$link;";
			$routeHelper[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $routeHelper);
		}

		return '';
	}

	/**
	 * Build the needles the core menu lookup is given.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $id              The generated expression of the item id, if the link carries one.
	 *
	 * @return  array  The lines, which later targets do not need at all.
	 *
	 * @since   6.1.7
	 */
	protected function needles(string $nameSingleCode, string $id): array
	{
		return [];
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
		return [Indent::_(3) . "\$link .= '&catid='.\$catid;"];
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
			. "if ((\$item = self::_findItem('" . $nameSingleCode . "')) !== null)";
	}

	/**
	 * Build the fallback that finds any menu item the needles reach.
	 *
	 * @return  array  The lines, which only Joomla 3 has anything to look up with.
	 *
	 * @since   6.1.7
	 */
	protected function findAnyItem(): array
	{
		return [];
	}
}

