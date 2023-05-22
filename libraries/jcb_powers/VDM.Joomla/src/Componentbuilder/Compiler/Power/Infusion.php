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
use VDM\Joomla\Componentbuilder\Compiler\Power\Parser;
use VDM\Joomla\Componentbuilder\Compiler\Power\Repo\Readme as RepoReadme;
use VDM\Joomla\Componentbuilder\Compiler\Power\Repos\Readme as ReposReadme;
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
	 * Compiler Powers Parser
	 *
	 * @var    Parser
	 * @since 3.2.0
	 **/
	protected Parser $parser;

	/**
	 * Compiler Powers Repo Readme Builder
	 *
	 * @var    RepoReadme
	 * @since 3.2.0
	 **/
	protected RepoReadme $reporeadme;

	/**
	 * Compiler Powers Repos Readme Builder
	 *
	 * @var    ReposReadme
	 * @since 3.2.0
	 **/
	protected ReposReadme $reposreadme;

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
	 * Power linker values
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $linker = [
		'add_head' => 'add_head',
		'unchanged_composer' => 'composer',
		'unchanged_description' => 'description',
		'extends' => 'extends',
		'unchanged_extends_custom' => 'extends_custom',
		'guid' => 'guid',
		'unchanged_head' => 'head',
		'use_selection' => 'use_selection',
		'implements' => 'implements',
		'unchanged_implements_custom' => 'implements_custom',
		'load_selection' => 'load_selection',
		'name' => 'name',
		'power_version' => 'power_version',
		'system_name' => 'system_name',
		'type' => 'type',
		'unchanged_namespace' => 'namespace',
		'unchanged_composer' => 'composer',
		'add_licensing_template' => 'add_licensing_template',
		'unchanged_licensing_template' => 'licensing_template'
	];

	/**
	 * Constructor.
	 *
	 * @param Config|null        $config       The Config object.
	 * @param Power|null         $power        The power object.
	 * @param Content|null       $content      The compiler content object.
	 * @param Autoloader|null    $autoloader   The powers autoloader object.
	 * @param Parser|null        $parser       The powers parser object.
	 * @param RepoReadme|null    $reporeadme   The powers repo readme builder object.
	 * @param ReposReadme|null   $reposreadme  The powers repos readme builder object.
	 * @param Placeholder|null   $placeholder  The placeholder object.
	 * @param Event|null         $event        The events object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Power $power = null, ?Content $content = null,
		?Autoloader $autoloader = null, ?Parser $parser = null, ?RepoReadme $reporeadme = null,
		?ReposReadme $reposreadme = null, ?Placeholder $placeholder = null, ?Event $event = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->power = $power ?: Compiler::_('Power');
		$this->content = $content ?: Compiler::_('Content');
		$this->autoloader = $autoloader ?: Compiler::_('Power.Autoloader');
		$this->parser = $parser ?: Compiler::_('Power.Parser');
		$this->reporeadme = $reporeadme ?: Compiler::_('Power.Repo.Readme');
		$this->reposreadme = $reposreadme ?: Compiler::_('Power.Repos.Readme');
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
		// parse all powers main code
		$this->parsePowers();

		// set the powers
		$this->setSuperPowers();

		// set the powers
		$this->setPowers();
	}

	/**
	 * We parse the powers to get the class map of all methods
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function parsePowers()
	{
		// we only do this if super powers are active
		if ($this->config->add_super_powers && ArrayHelper::check($this->power->superpowers))
		{
			foreach ($this->power->active as $n => &$power)
			{
				if (ObjectHelper::check($power) && isset($power->main_class_code) &&
					StringHelper::check($power->main_class_code))
				{
					// only parse those approved
					if ($power->approved == 1)
					{
						$power->main_class_code = $this->placeholder->update($power->main_class_code, $this->content->active);
						$power->parsed_class_code = $this->parser->code($power->main_class_code);
					}
				}
			}
		}
	}

	/**
	 * Set the Super Powers details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setSuperPowers()
	{
		// infuse super powers details if set
		if ($this->config->add_super_powers && ArrayHelper::check($this->power->superpowers))
		{
			// TODO we need to update the event signatures
			$context = $this->config->component_context;

			foreach ($this->power->superpowers as $path => $powers)
			{
				$key = StringHelper::safe($path);

				// Trigger Event: jcb_ce_onBeforeInfuseSuperPowerDetails
				$this->event->trigger(
					'jcb_ce_onBeforeInfuseSuperPowerDetails',
					array(&$context, &$path, &$key, &$powers)
				);

				// we add and all missing powers
				if (isset($this->power->old_superpowers[$path]))
				{
					$this->mergePowers($powers, $this->power->old_superpowers[$path]);
				}

				// POWERREADME
				$this->content->set_($key, 'POWERREADME', $this->reposreadme->get($powers));

				// sort all powers
				$this->sortPowers($powers);

				// POWERINDEX
				$this->content->set_($key, 'POWERINDEX', $this->index($powers));

				// Trigger Event: jcb_ce_onAfterInfuseSuperPowerDetails
				$this->event->trigger(
					'jcb_ce_onAfterInfuseSuperPowerDetails',
					array(&$context, &$path, &$key, &$powers)
				);
			}
		}
	}

	/**
	 * Merge the old missing powers found in local repository back into the index
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function mergePowers(array &$powers, array &$old)
	{
		foreach ($old as $guid => $values)
		{
			if (!isset($powers[$guid]))
			{
				$powers[$guid] = $values;
			}
		}
	}

	/**
	 * Sort Powers
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function sortPowers(array &$powers)
	{
		ksort($powers, SORT_STRING);
	}

	/**
	 * Set the Powers code
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setPowers()
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
					$this->content->set_($power->key, 'POWERCODE', $this->code($power));

					// CODEPOWER
					$this->content->set_($power->key, 'CODEPOWER', $this->raw($power));

					// POWERLINKER
					$this->content->set_($power->key, 'POWERLINKER', $this->linker($power));

					// POWERLINKER
					$this->content->set_($power->key, 'POWERREADME', $this->reporeadme->get($power));

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
	 * Build the Super Power Index
	 *
	 * @param array    $powers All powers of this super power.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function index(array &$powers): string
	{
		return json_encode($powers, JSON_PRETTY_PRINT);
	}

	/**
	 * Get the Power code
	 *
	 * @param object    $power A power object.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function code(object &$power): string
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
			if (strpos((string) $power->description, '/*') === false)
			{
				// make this description escaped
				$power->description = '/**' . PHP_EOL . ' * ' . implode(PHP_EOL . ' * ', explode(PHP_EOL, (string) $power->description)) . PHP_EOL . ' */';
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

		$code[] = '}' . PHP_EOL;

		return $this->placeholder->update(implode(PHP_EOL, $code), $this->content->active);
	}

	/**
	 * Get the Raw (unchanged) Power code
	 *
	 * @param object    $power A power object.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function raw(object &$power): string
	{
		// add the raw main code if set
		if (isset($power->unchanged_main_class_code) && StringHelper::check($power->unchanged_main_class_code))
		{
			return $power->unchanged_main_class_code;
		}
		return '';
	}

	/**
	 * Get the Power Linker
	 *
	 * @param object    $power A power object.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linker(object &$power): string
	{
		$linker = [];

		// set the linking values
		foreach ($power as $key => $value)
		{
			if (isset($this->linker[$key]))
			{
				$linker[$this->linker[$key]] = $value;
			}
		}

		return json_encode($linker, JSON_PRETTY_PRINT);
	}

}

