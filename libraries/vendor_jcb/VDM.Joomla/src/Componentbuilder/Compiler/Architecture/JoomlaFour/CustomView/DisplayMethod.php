<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\CustomView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\DisplayMethod as ExtendingDisplayMethod;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView\DisplayMethodInterface;


/**
 * Custom View Display Method Class for Joomla 4.
 * 
 * Joomla 4 keeps the legacy global event dispatcher while already using
 * the model-based retrieval of the later targets.
 * 
 * @since  6.1.7
 */
final class DisplayMethod extends ExtendingDisplayMethod implements DisplayMethodInterface
{
	/**
	 * Get the generated event-dispatcher initialization lines.
	 *
	 * @return  string  The generated dispatcher lines.
	 *
	 * @since   6.1.7
	 */
	protected function getDispatcherInit(): string
	{
		return $this->getLegacyDispatcherInit();
	}

	/**
	 * Get the generated content plugin event trigger lines.
	 *
	 * @param   string  $pluginEvent  The plugin event name.
	 * @param   string  $context      The view context.
	 *
	 * @return  string  The generated event trigger lines.
	 *
	 * @since   6.1.7
	 */
	protected function getPluginEvent(string $pluginEvent, string $context): string
	{
		return $this->getLegacyPluginEvent($pluginEvent, $context);
	}
}

