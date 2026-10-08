<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Builder\SelectionTranslation as SelectionTranslationData;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Model Selection Translation Class.
 * 
 * Generates the loop a list model runs over its loaded items to turn every
 * selection value that has a translation into its translatable form.
 * 
 * @since  6.1.7
 */
final class SelectionTranslation
{
	/**
	 * The Selection Translation Class.
	 *
	 * @var   SelectionTranslationData
	 * @since 6.1.7
	 */
	protected SelectionTranslationData $selectiontranslation;

	/**
	 * Constructor.
	 *
	 * @param SelectionTranslationData   $selectiontranslation   The Selection Translation Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(SelectionTranslationData $selectiontranslation)
	{
		$this->selectiontranslation = $selectiontranslation;
	}

	/**
	 * Get the selection translation loop of a list model.
	 *
	 * @param   string  $views  The list view code name.
	 * @param   string  $tab    Extra indentation of the generated lines.
	 *
	 * @return  string  The generated loop, empty when the view has no selections.
	 *
	 * @since   6.1.7
	 */
	public function get(string $views, string $tab = ''): string
	{
		// add the fix if this view has the need for it
		$fix = '';
		if ($this->selectiontranslation->exists($views))
		{
			$fix .= PHP_EOL . PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. "//" . Line::_(__Line__, __Class__)
				. " set selection value to a translatable value";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items))";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "{";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
				. "foreach (\$items as \$nr => &\$item)";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "{";
			foreach ($this->selectiontranslation->
				get($views) as $name => $values)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " convert " . $name;
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "\$item->" . $name
					. " = \$this->selectionTranslation(\$item->" . $name . ", '"
					. $name . "');";
			}
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "}";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}"
				. PHP_EOL;
		}

		return $fix;
	}
}

