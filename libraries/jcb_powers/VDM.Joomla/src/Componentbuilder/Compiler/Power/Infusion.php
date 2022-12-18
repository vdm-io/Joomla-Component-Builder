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

namespace VDM\Joomla\Componentbuilder\Compiler\Power;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Content;
use VDM\Joomla\Componentbuilder\Compiler\Power\Autoloader;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;


/**
 * Compiler Power Infusion
 * @since 3.2.0
 */
class Infusion
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Power Objects
	 *
	 * @var    Power
	 * @since 3.2.0
	 **/
	protected Power $power;

	/**
	 * Compiler Content
	 *
	 * @var    Content
	 * @since 3.2.0
	 **/
	protected Content $content;

	/**
	 * Compiler Powers Autoloader
	 *
	 * @var    Autoloader
	 * @since 3.2.0
	 **/
	protected Autoloader $autoloader;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Compiler Event
	 *
	 * @var    Event
	 * @since 3.2.0
	 **/
	protected Event $event;

	/**
	 * Constructor.
	 *
	 * @param Config|null        $config       The Config object.
	 * @param Power|null         $power        The power object.
	 * @param Content|null       $content      The compiler content object.
	 * @param Autoloader|null    $autoloader   The powers autoloader object.
	 * @param Placeholder|null   $placeholder  The placeholder object.
	 * @param Event|null         $event        The events object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Power $power = null, ?Content $content = null,
		?Autoloader $autoloader = null, ?Placeholder $placeholder = null, ?Event $event = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->power = $power ?: Compiler::_('Power');
		$this->content = $content ?: Compiler::_('Content');
		$this->autoloader = $autoloader ?: Compiler::_('Power.Autoloader');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->event = $event ?: Compiler::_('Event');
	}

	/**
	 * Infuse the powers data with the content
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function set()
	{
		// infuse powers data if set
		if (ArrayHelper::check($this->power->active))
		{
			// TODO we need to update the event signatures
			$context = $this->config->component_context;

			foreach ($this->power->active as $power)
			{
				if (ObjectHelper::check($power))
				{
					// Trigger Event: jcb_ce_onBeforeInfusePowerData
					$this->event->trigger(
						'jcb_ce_onBeforeInfusePowerData',
						array(&$context, &$power)
					);

					// POWERCODE
					$this->content->set_($power->key, 'POWERCODE', $this->get($power));

					// Trigger Event: jcb_ce_onAfterInfusePowerData
					$this->event->trigger(
						'jcb_ce_onAfterInfusePowerData',
						array(&$context, &$power)
					);
				}
			}

			// now set the power autoloader
			$this->autoloader->set();
		}
	}

	/**
	 * Get the Power code
	 *
	 * @param object    $power A power object.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	protected function get(object &$power): string
	{
		$code = [];

		// set the name space
		$code[] = 'namespace ' . $power->_namespace . ';' . PHP_EOL;

		// check if we have header data
		if (StringHelper::check($power->head))
		{
			$code[] = PHP_EOL . $power->head;
		}

		// add description if set
		if (StringHelper::check($power->description))
		{
			// check if this is escaped
			if (strpos($power->description, '/*') === false)
			{
				// make this description escaped
				$power->description = '/**' . PHP_EOL . ' * ' . implode(PHP_EOL . ' * ', explode(PHP_EOL, $power->description)) . PHP_EOL . ' */';
			}
			$code[] = PHP_EOL . $power->description;
		}

		// build power declaration
		$declaration = $power->type . ' ' . $power->class_name;

		// check if we have extends
		if (StringHelper::check($power->extends_name))
		{
			$declaration .= ' extends ' . $power->extends_name;
		}

		// check if we have implements
		if (ArrayHelper::check($power->implement_names))
		{
			$declaration .= ' implements ' . implode(', ', $power->implement_names);
		}

		$code[] = $declaration;
		$code[] = '{';

		// add the main code if set
		if (StringHelper::check($power->main_class_code))
		{
			$code[] = $power->main_class_code;
		}

		$code[] = '}' . PHP_EOL . PHP_EOL;

		return $this->placeholder->update(implode(PHP_EOL, $code), $this->content->active);
	}

}

