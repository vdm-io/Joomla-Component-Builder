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
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Selection Translation Method Class.
 * 
 * Generates the selectionTranslation() method a list model carries, which
 * maps a stored selection value onto its language string. Each translatable
 * field contributes one lookup array; a value with no entry is returned
 * unchanged.
 * 
 * @since  6.1.7
 */
final class SelectionTranslationMethod
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
	 * Get the selection translation method of a list model.
	 *
	 * @param   string  $views  The list view code name.
	 *
	 * @return  string  The generated method, empty when the view has no selections.
	 *
	 * @since   6.1.7
	 */
	public function get(string $views): string
	{
		// add the fix if this view has the need for it
		$fix = '';
		if ($this->selectiontranslation->exists($views))
		{
			$fix .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$fix .= PHP_EOL . Indent::_(1)
				. " * Method to convert selection values to translatable string.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1) . " * @return  string   The translatable string.";
			$fix .= PHP_EOL . Indent::_(1) . " */";
			$fix .= PHP_EOL . Indent::_(1)
				. "public function selectionTranslation(\$value,\$name)";
			$fix .= PHP_EOL . Indent::_(1) . "{";
			foreach ($this->selectiontranslation->
				get($views) as $name => $values)
			{
				if (ArrayHelper::check($values))
				{
					$fix     .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Array of " . $name . " language strings";
					$fix     .= PHP_EOL . Indent::_(2) . "if (\$name === '"
						. $name . "')";
					$fix     .= PHP_EOL . Indent::_(2) . "{";
					$fix     .= PHP_EOL . Indent::_(3) . "\$" . $name
						. "Array = array(";
					$counter = 0;
					foreach ($values as $value => $translang)
					{
						// only add quotes to strings
						if (StringHelper::check($value))
						{
							$key = "'" . $value . "'";
						}
						else
						{
							if ($value == '')
							{
								$value = 0;
							}
							$key = $value;
						}
						if ($counter == 0)
						{
							$fix .= PHP_EOL . Indent::_(4) . $key . " => '"
								. $translang . "'";
						}
						else
						{
							$fix .= "," . PHP_EOL . Indent::_(4) . $key
								. " => '" . $translang . "'";
						}
						$counter++;
					}
					$fix .= PHP_EOL . Indent::_(3) . ");";
					$fix .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Now check if value is found in this array";
					$fix .= PHP_EOL . Indent::_(3) . "if (isset(\$" . $name
						. "Array[\$value]) && "
						. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$" . $name . "Array[\$value]))";
					$fix .= PHP_EOL . Indent::_(3) . "{";
					$fix .= PHP_EOL . Indent::_(4) . "return \$" . $name
						. "Array[\$value];";
					$fix .= PHP_EOL . Indent::_(3) . "}";
					$fix .= PHP_EOL . Indent::_(2) . "}";
				}
			}
			$fix .= PHP_EOL . Indent::_(2) . "return \$value;";
			$fix .= PHP_EOL . Indent::_(1) . "}";
		}

		return $fix;
	}
}

