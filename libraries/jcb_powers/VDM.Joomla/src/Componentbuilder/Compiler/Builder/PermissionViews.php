<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Abstraction\Registry;


/**
 * Permission Views Builder Class
 * 
 * @since 3.2.0
 */
final class PermissionViews extends Registry
{
	/**
	 * Constructor.
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		$this->setSeparator('|');
	}

	/**
	 * Get the build view content
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function build(): string
	{
		if ($this->isActive())
		{
			$bucket = [];
			foreach ($this->active as $views_code_name => $actions)
			{
				$bucket[] = Indent::_(1) . '<section name="' . $views_code_name . '">';

				foreach ($actions as $action)
				{
					$bucket[] = Indent::_(2) . '<action name="'
						. $action['name'] . '" title="'
						. $action['title'] . '" description="'
						. $action['description'] . '" />';
				}

				$bucket[] = Indent::_(1) . "</section>";
			}

			// reset memory
			$this->active = [];

			return PHP_EOL . implode(PHP_EOL, $bucket);
		}

		return '';
	}
}

