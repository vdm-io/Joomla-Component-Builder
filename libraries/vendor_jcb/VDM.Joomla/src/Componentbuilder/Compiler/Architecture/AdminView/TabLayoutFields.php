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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminView;


use VDM\Joomla\Componentbuilder\Compiler\Builder\Layout;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Edit View Tab Layout Fields Class.
 * 
 * Generates the PHP array literal a view's edit template uses to look up
 * which fields belong to each alignment of each tab. Tabs, alignments and
 * fields are each emitted in key order so the generated array is stable
 * between compiles.
 * 
 * @since  6.1.7
 */
final class TabLayoutFields
{
	/**
	 * The alignment names, keyed by their stored position.
	 *
	 * @var   array<int, string>
	 * @since 6.1.7
	 */
	protected array $alignmentOptions = [
		1 => 'left', 2 => 'right', 3 => 'fullwidth', 4 => 'above',
		5 => 'under', 6 => 'leftside', 7 => 'rightside'
	];

	/**
	 * The Layout Class.
	 *
	 * @var   Layout
	 * @since 6.1.7
	 */
	protected Layout $layout;

	/**
	 * Constructor.
	 *
	 * @param Layout   $layout   The Layout Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Layout $layout)
	{
		$this->layout = $layout;
	}

	/**
	 * Get the tab and alignment field array of a view.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 *
	 * @return  string  The generated PHP array literal.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode): string
	{
		// check if the load build is set for this view
		if ($this->layout->exists($nameSingleCode))
		{
			$layout_builder = $this->layout->get($nameSingleCode);
			$layoutArray = [];
			foreach ($layout_builder as $layout => $alignments)
			{
				$alignments = (array) $alignments;
				// sort the alignments
				ksort($alignments);
				$alignmentArray = [];
				foreach ($alignments as $alignment => $fields)
				{
					$fields = (array) $fields;
					// sort the fields
					ksort($fields);
					$fieldArray = [];
					foreach ($fields as $field)
					{
						// add each field
						$fieldArray[] = PHP_EOL . Indent::_(4) . "'" . $field
							. "'";
					}
					// add the alignemnt key
					$alignmentArray[] = PHP_EOL . Indent::_(3) . "'"
						. $this->alignmentOptions[$alignment] . "' => array("
						. implode(',', $fieldArray) . PHP_EOL . Indent::_(3) . ")";
				}
				// add the layout key
				$layoutArray[] = PHP_EOL . Indent::_(2) . "'"
					. StringHelper::safe($layout)
					. "' => array(" . implode(',', $alignmentArray) . PHP_EOL
					. Indent::_(2) . ")";
			}

			return 'array(' . implode(',', $layoutArray) . PHP_EOL . Indent::_(
					1
				) . ")";
		}

		return 'array()';
	}
}

