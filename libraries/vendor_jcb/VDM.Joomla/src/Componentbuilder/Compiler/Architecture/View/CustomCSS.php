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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\View;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Utilities\StringHelper;


/**
 * View Custom CSS Class.
 * 
 * Gives back the stylesheet a view was built with, with its placeholders
 * filled in. It is written to a file of its own, which is why it is not laid
 * out the way the inline styles are.
 * 
 * @since  6.1.7
 */
final class CustomCSS
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
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder)
	{
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the stylesheet of a view.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string  The stylesheet, or nothing when the view declared none.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string
	{
		if ($view['settings']->add_css == 1)
		{
			if (StringHelper::check($view['settings']->css))
			{
				return $this->placeholder->update_(
					$view['settings']->css
				);
			}
		}

		return '';
	}
}

