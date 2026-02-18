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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Componentbuilder\Compiler\Component\Data as Data;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Abstraction\BaseRegistry;


/**
 * Compiler Component
 * 
 * @since 3.2.0
 */
final class Component extends BaseRegistry
{
	/**
	 * The Data Class.
	 *
	 * @var   Data
	 * @since 5.1.4
	 */
	private Data $_data;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 5.1.4
	 */
	private Event $_event;

	/**
	 * Constructor.
	 *
	 * @param Data    $data    The Data Class.
	 * @param Event   $event   The Event Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Data $data, Event $event)
	{
		$this->_data = $data;
		$this->_event = $event;

		parent::__construct();
	}

	/**
	 * Trigger the build of the component and all its data.
	 *
	 * @return  void
	 * @since 5.1.4
	 * @throws \RuntimeException
	 */
	public function build(): void
	{
		// allow the build only once!
		if ($this->initialized)
		{
			return;
		}

		// Trigger Event: jcb_ce_onBeforeGetComponentData
		$this->_event->trigger(
			'jcb_ce_onBeforeGetComponentData'
		);

		$component = $this->_data->get();
		if ($component === null)
		{
			throw new \RuntimeException('Failed to load the component data.');
		}

		$this->loadObject($component); // activate component = initialized = true

		$this->initialized = true;

		// Trigger Event: jcb_ce_onAfterGetComponentData
		$this->_event->trigger(
			'jcb_ce_onAfterGetComponentData'
		);
	}

	/**
	 * getting any valid value
	 *
	 * @param   string       $path     The value's key/path name
	 *
	 * @since 3.2.0
	 */
	public function __get($path)
	{
		// check if it has been set
		if (($value = $this->get($path, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}

		return null;
	}
}

