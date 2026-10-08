<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    20th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;


/**
 * Custom View Extra Display Methods Class.
 * 
 * A custom view the component was given extra view methods for carries them,
 * with whatever placeholders they were written with filled in.
 * 
 * @since 6.1.7
 */
final class ExtraDisplayMethods
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param Placeholder $placeholder The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder)
	{
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the extra methods a custom view was given.
	 *
	 * A view that was given none gets nothing.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The methods.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view): string
	{
		if ($view['settings']->add_php_jview == 1)
		{
			return PHP_EOL . PHP_EOL . $this->placeholder->update_(
					$view['settings']->php_jview
				);
		}

		return '';
	}
}

