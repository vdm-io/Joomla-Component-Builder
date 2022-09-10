<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\JoomlaThree;


use Joomla\Registry\Registry;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;


/**
 * Compiler Events
 * 
 * @since 3.2.0
 */
class Event implements EventInterface
{
	/**
	 * event plugin trigger switch
	 *
	 * @var    boolean
	 * @since 3.2.0
	 */
	protected $activePlugins = false;

	/**
	 * Constructor
	 *
	 * @param Registry|null     $params    The component parameters
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Registry $params = null)
	{
		// Set the params
		$params = $params ?: Helper::getParams('com_componentbuilder');
		// get active plugins
		if (($plugins = $params->get('compiler_plugin', false))
			!== false)
		{
			foreach ($plugins as $plugin)
			{
				// get possible plugins
				if (\JPluginHelper::isEnabled('extension', $plugin))
				{
					// Import the appropriate plugin group.
					\JPluginHelper::importPlugin('extension', $plugin);
					// activate events
					$this->activePlugins = true;
				}
			}
		}
	}

	/**
	 * Trigger and event
	 *
	 * @param   string  $event  The event to trigger
	 * @param   mixed   $data   The values to pass to the event/plugin
	 *
	 * @return  void
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function trigger(string $event, $data)
	{
		// only execute if plugins were loaded (active)
		if ($this->activePlugins)
		{
			// Get the dispatcher.
			$dispatcher = \JEventDispatcher::getInstance();

			// Trigger this compiler event.
			$results = $dispatcher->trigger($event, $data);

			// Check for errors encountered while trigger the event
			if (count((array) $results) && in_array(false, $results, true))
			{
				// Get the last error.
				$error = $dispatcher->getError();

				if (!($error instanceof \Exception))
				{
					throw new \Exception($error);
				}
			}
		}
	}

}

