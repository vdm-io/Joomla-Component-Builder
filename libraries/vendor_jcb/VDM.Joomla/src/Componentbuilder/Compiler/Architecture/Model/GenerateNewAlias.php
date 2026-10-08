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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Builder\Alias;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomAlias;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Title;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Generate New Alias Class.
 * 
 * Builds the method an admin model runs when an item is copied, to give the
 * copy an alias of its own rather than the one it was copied from.
 * 
 * @since 6.1.7
 */
final class GenerateNewAlias
{
	/**
	 * The Alias Builder Class.
	 *
	 * @var   Alias
	 * @since 6.1.7
	 */
	protected Alias $alias;

	/**
	 * The Custom Alias Builder Class.
	 *
	 * @var   CustomAlias
	 * @since 6.1.7
	 */
	protected CustomAlias $customalias;

	/**
	 * The Title Builder Class.
	 *
	 * @var   Title
	 * @since 6.1.7
	 */
	protected Title $title;

	/**
	 * Constructor.
	 *
	 * @param Alias       $alias       The Alias Builder Class.
	 * @param CustomAlias $customalias The Custom Alias Builder Class.
	 * @param Title       $title       The Title Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Alias $alias,
		CustomAlias $customalias,
		Title $title)
	{
		$this->alias = $alias;
		$this->customalias = $customalias;
		$this->title = $title;
	}

	/**
	 * Build the generate new alias method of an admin model.
	 *
	 * Only a view with an alias to make unique gets one.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 *
	 * @return  string  The method, or nothing when the view has no alias of its own.
	 *
	 * @since   6.1.7
	 */
	public function get($nameSingleCode): string
	{
		// make sure this view has an alias
		if ($this->alias->exists($nameSingleCode))
		{
			// set the title stuff
			if (($customAliasBuilder = $this->customalias->get($nameSingleCode)) !== null)
			{
				$titles = array_values(
					$customAliasBuilder
				);
			}
			elseif ($this->title->exists($nameSingleCode))
			{
				$titles = [$this->title->get($nameSingleCode)];
			}
			// reset the bucket
			$titleData = [];
			// load the dynamic title builder
			if (isset($titles) && ArrayHelper::check($titles))
			{
				foreach ($titles as $title)
				{
					$titleData[] = "\$this->" . $title;
				}
			}
			else
			{
				$titleData
					= array("'-'"); // just encase some mad man does not set a title/customAlias (we fall back on the date)
			}
			// rest the new function
			$newFunction   = [];
			$newFunction[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$newFunction[] = Indent::_(1)
				. " * Generate a valid alias from title / date.";
			$newFunction[] = Indent::_(1)
				. " * Remains public to be able to check for duplicated alias before saving";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1) . " * @return  string";
			$newFunction[] = Indent::_(1) . " */";
			$newFunction[] = Indent::_(1) . "public function generateAlias()";
			$newFunction[] = Indent::_(1) . "{";
			$newFunction[] = Indent::_(2) . "if (empty(\$this->alias))";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3) . "\$this->alias = " . implode(
					".' '.", $titleData
				) . ';';
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = PHP_EOL . Indent::_(2)
				. "\$this->alias = ApplicationHelper::stringURLSafe(\$this->alias);";
			$newFunction[] = PHP_EOL . Indent::_(2)
				. "if (trim(str_replace('-', '', \$this->alias)) == '')";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3)
				. "\$this->alias = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDate()->format('Y-m-d-H-i-s');";
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = PHP_EOL . Indent::_(2) . "return \$this->alias;";
			$newFunction[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $newFunction);
		}
		// rest the new function
		$newFunction   = [];
		$newFunction[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$newFunction[] = Indent::_(1)
			. " * This view does not actually have an alias";
		$newFunction[] = Indent::_(1) . " *";
		$newFunction[] = Indent::_(1) . " * @return  bool";
		$newFunction[] = Indent::_(1) . " */";
		$newFunction[] = Indent::_(1) . "public function generateAlias()";
		$newFunction[] = Indent::_(1) . "{";
		$newFunction[] = Indent::_(2) . "return false;";
		$newFunction[] = Indent::_(1) . "}";

		return implode(PHP_EOL, $newFunction);
	}
}

