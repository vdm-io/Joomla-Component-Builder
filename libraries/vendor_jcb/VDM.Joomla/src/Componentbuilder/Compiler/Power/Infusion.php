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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Content;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti as Contents;
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
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Power Class.
	 *
	 * @var   Power
	 * @since 3.2.0
	 */
	protected Power $power;

	/**
	 * The ContentOne Class.
	 *
	 * @var   Content
	 * @since 3.2.0
	 */
	protected Content $content;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   Contents
	 * @since 3.2.0
	 */
	protected Contents $contents;

	/**
	 * The Parser Class.
	 *
	 * @var   Parser
	 * @since 3.2.0
	 */
	protected Parser $parser;

	/**
	 * The Readme Class.
	 *
	 * @var   RepoReadme
	 * @since 3.2.0
	 */
	protected RepoReadme $reporeadme;

	/**
	 * The Readme Class.
	 *
	 * @var   ReposReadme
	 * @since 3.2.0
	 */
	protected ReposReadme $reposreadme;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * Power linker values
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $linker = [
		'add_head' => 'add_head',
		'unchanged_description' => 'description',
		'extends' => 'extends',
		'unchanged_extends_custom' => 'extends_custom',
		'extendsinterfaces' => 'extendsinterfaces',
		'unchanged_extendsinterfaces_custom' => 'extendsinterfaces_custom',
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
	 * Power Infusion Tracker
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $done = [];

	/**
	 * Power Content Infusion Tracker
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $content_done = [];

	/**
	 * Path Infusion Tracker
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $path_done = [];

	/**
	 * Constructor.
	 *
	 * @param Config        $config        The Config Class.
	 * @param Power         $power         The Power Class.
	 * @param Content       $content       The ContentOne Class.
	 * @param Contents      $contents      The ContentMulti Class.
	 * @param Parser        $parser        The Parser Class.
	 * @param RepoReadme    $reporeadme    The Readme Class.
	 * @param ReposReadme   $reposreadme   The Readme Class.
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param Event         $event         The EventInterface Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Power $power, Content $content,
		Contents $contents, Parser $parser, RepoReadme $reporeadme,
		ReposReadme $reposreadme, Placeholder $placeholder,
		Event $event)
	{
		$this->config = $config;
		$this->power = $power;
		$this->content = $content;
		$this->contents = $contents;
		$this->parser = $parser;
		$this->reporeadme = $reporeadme;
		$this->reposreadme = $reposreadme;
		$this->placeholder = $placeholder;
		$this->event = $event;
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
			foreach ($this->power->active as $guid => &$power)
			{
				if (isset($this->done[$guid]))
				{
					continue;
				}

				if (ObjectHelper::check($power) && isset($power->main_class_code) &&
					StringHelper::check($power->main_class_code))
				{
					// only parse those approved
					if ($power->approved == 1)
					{
						$power->main_class_code = $this->placeholder->update($power->main_class_code, $this->content->allActive());
						$power->parsed_class_code = $this->parser->code($power->main_class_code);
					}
				}

				// do each power just once
				$this->done[$guid] = true;
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
			foreach ($this->power->superpowers as $path => $powers)
			{
				if (isset($this->path_done[$path]))
				{
					continue;
				}

				$key = StringHelper::safe($path);

				// Trigger Event: jcb_ce_onBeforeInfuseSuperPowerDetails
				$this->event->trigger(
					'jcb_ce_onBeforeInfuseSuperPowerDetails', [&$path, &$key, &$powers]
				);

				// we add and all missing powers
				if (isset($this->power->old_superpowers[$path]))
				{
					$this->mergePowers($powers, $this->power->old_superpowers[$path]);
				}

				// POWERREADME
				$this->contents->set("{$key}|POWERREADME", $this->reposreadme->get($powers));

				// sort all powers
				$this->sortPowers($powers);

				// POWERINDEX
				$this->contents->set("{$key}|POWERINDEX", $this->index($powers));

				// Trigger Event: jcb_ce_onAfterInfuseSuperPowerDetails
				$this->event->trigger(
					'jcb_ce_onAfterInfuseSuperPowerDetails', [&$path, &$key, &$powers]
				);

				// do each path just once
				$this->path_done[$path] = true;
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
			foreach ($this->power->active as $guid => $power)
			{
				if (isset($this->content_done[$guid]))
				{
					continue;
				}

				if (ObjectHelper::check($power))
				{
					// Trigger Event: jcb_ce_onBeforeInfusePowerData
					$this->event->trigger(
						'jcb_ce_onBeforeInfusePowerData', [&$power]
					);

					// POWERCODE
					$this->contents->set("{$power->key}|POWERCODE", $this->code($power));

					// CODEPOWER
					$this->contents->set("{$power->key}|CODEPOWER", $this->raw($power));

					// POWERLINKER
					$this->contents->set("{$power->key}|POWERLINKER", $this->linker($power));

					// POWERLINKER
					$this->contents->set("{$power->key}|POWERREADME", $this->reporeadme->get($power));

					// Trigger Event: jcb_ce_onAfterInfusePowerData
					$this->event->trigger(
						'jcb_ce_onAfterInfusePowerData', [&$power]
					);
				}

				// do each power just once
				$this->content_done[$guid] = true;
			}
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

		return $this->placeholder->update(implode(PHP_EOL, $code), $this->content->allActive());
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

