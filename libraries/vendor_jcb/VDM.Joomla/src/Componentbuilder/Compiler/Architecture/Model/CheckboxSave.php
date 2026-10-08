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


use VDM\Joomla\Componentbuilder\Compiler\Builder\CheckBox;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Model Checkbox Save Class.
 * 
 * A checkbox a user leaves untouched is not posted at all, so the save method
 * of a view that has any is given the statements that put an empty value back
 * for each of them.
 * 
 * @since 6.1.7
 */
final class CheckboxSave
{
	/**
	 * The Check Box Builder Class.
	 *
	 * @var   CheckBox
	 * @since 6.1.7
	 */
	protected CheckBox $checkbox;

	/**
	 * Constructor.
	 *
	 * @param CheckBox $checkbox The Check Box Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(CheckBox $checkbox)
	{
		$this->checkbox = $checkbox;
	}

	/**
	 * Build the check box handling of the save method of a view.
	 *
	 * A view with no check boxes is given nothing.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view): string
	{
		$script = '';
		if ($this->checkbox->exists($view))
		{
			foreach ($this->checkbox->get($view) as $checkbox)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__LINE__, __CLASS__) . " Set the empty " . $checkbox
					. " item to data";
				$script .= PHP_EOL . Indent::_(2) . "if (!isset(\$data['"
					. $checkbox . "']) && !(\$input->getMethod() === 'PATCH'"
					. " && Joomla__" . "_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->isClient('api')))";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "\$data['" . $checkbox
					. "'] = '';";
				$script .= PHP_EOL . Indent::_(2) . "}";
			}
		}

		return $script;
	}
}

