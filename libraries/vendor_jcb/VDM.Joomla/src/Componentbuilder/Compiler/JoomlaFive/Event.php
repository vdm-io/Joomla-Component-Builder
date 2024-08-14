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

namespace VDM\Joomla\Componentbuilder\Compiler\JoomlaFive;


use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Event\DispatcherInterface;
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
	 * event plug-in trigger switch
	 *
	 * @var    boolean
	 * @since 3.2.0
	 */
	protected $activePlugins = false;

	/**
	 * The dispatcher to get events
	 *
	 * @since 5.0.2
	 */
	protected $dispatcher;

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
				if (PluginHelper::isEnabled('extension', $plugin))
				{
					// Import the appropriate plugin group.
					PluginHelper::importPlugin('extension', $plugin);
					// activate events
					$this->activePlugins = true;
				}
			}
		}

		$this->dispatcher = Factory::getContainer()->get(DispatcherInterface::class);
	}

	/**
	 * Trigger an event
	 *
	 * @param   string  $event  The event to trigger
	 * @param   mixed   $data   The values to pass to the event/plugin
	 *
	 * @return  void
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function trigger(string $event, $data = null)
	{
		// only execute if plugins were loaded (active)
		if ($this->activePlugins)
		{
			try
			{
				$data ??= [];
				$listeners = $this->dispatcher->getListeners($event);
				foreach ($listeners as $listener)
				{
					// Call the listener with the unpacked arguments
					$listener(...$data);
				}
			}
			catch (\Exception $e)
			{
				throw new \Exception("Error processing event '$event': " . $e->getMessage());
			}
		}
	}
}

