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
use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Permission Component Builder Class
 * 
 * @since 3.2.0
 */
final class PermissionComponent extends Registry implements Registryinterface
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
	 * Get the build component content
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function build(): string
	{
		if ($this->isActive())
		{
			$bucket = ['<section name="component">'];

			// get the header
			if ($this->exists('->HEAD<-'))
			{
				$headers = $this->get('->HEAD<-');

				// remove from active values
				$this->remove('->HEAD<-');

				foreach ($headers as $action)
				{
					$bucket[] = Indent::_(2) . '<action name="'
						. $action['name'] . '" title="'
						. $action['title'] . '" description="'
						. $action['description'] . '" />';
				}
			}

			if ($this->isActive())
			{
				ksort($this->active, SORT_STRING);

				foreach ($this->active as $active)
				{
					$bucket[] = Indent::_(2) . '<action name="'
						. $active['name'] . '" title="'
						. $active['title'] . '" description="'
						. $active['description'] . '" />';
				}
			}

			// reset memory
			$this->active = [];

			return implode(PHP_EOL, $bucket) . PHP_EOL . Indent::_(1) . "</section>";
		}

		return '';
	}
}

