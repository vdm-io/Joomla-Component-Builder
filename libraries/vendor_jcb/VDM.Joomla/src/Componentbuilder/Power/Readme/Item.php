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

namespace VDM\Joomla\Componentbuilder\Power\Readme;


use VDM\Joomla\Componentbuilder\Power\Plantuml;
use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Power Item Readme
 * 
 * @since 3.2.0
 */
final class Item implements ItemInterface
{
	/**
	 * Compiler Powers Plantuml Builder
	 *
	 * @var    Plantuml
	 * @since 3.2.0
	 **/
	protected Plantuml $plantuml;

	/**
	 * Constructor.
	 *
	 * @param Plantuml     $plantuml     The powers plantuml builder object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Plantuml $plantuml)
	{
		$this->plantuml = $plantuml;
	}

	/**
	 * Generate a README for a JCB Power class in Markdown format.
	 *
	 * Includes class details, namespace info, inheritance, UML diagram, and usage guide.
	 *
	 * @param  object  $item  The power class definition.
	 *
	 * @return string  The generated README.
	 * @since  3.2.2
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title
		$readme[] = '### JCB! Power';
		$type      = $item->type ?? 'UnknownType';
		$codeName  = $item->code_name ?? 'UnnamedClass';
		$namespace = $item->_namespace ?? 'Unknown\\Namespace';
		$extends   = $item->extends_name ?? null;
		$guid      = $item->guid ?? 'error_missing_guid';
		$parsed    = (is_array($item->parsed_class_code) ? $item->parsed_class_code : []);

		$readme[] = "# {$type} {$codeName} (Details)";
		$readme[] = "> namespace: **{$namespace}**";
		if (!empty($extends))
		{
			$readme[] = "> extends: **{$extends}**";
		}
		$readme[] = '';

		// UML Diagram
		$readme[] = '```uml';
		$readme[] = '@startuml';
		$readme[] = $this->plantuml->classDetailedDiagram(
			['name' => $codeName, 'type' => $type],
			$parsed
		);
		$readme[] = '@enduml';
		$readme[] = '```';
		$readme[] = '';

		// Description block
		$readme[] = <<<MD
The **Power** feature in JCB allows you to write PHP classes and their implementations,
making it easy to include them in your Joomla project. JCB handles linking, autoloading,
namespacing, and folder structure creation for you.

By using the **SPK** (Super Power Key) in your custom code (replacing the class name
in your code with the SPK), JCB will automatically pull the Power from the repository
into your project. This makes it available in your JCB instance, allowing you to edit
and include the class in your generated Joomla component.

JCB uses placeholders like [[[`NamespacePrefix`]]] and [[[`ComponentNamespace`]]] in
namespacing to prevent collisions and improve reusability across different JCB systems.

You can also set the **JCB powers path** globally or per component under the
**Dynamic Integration** tab, providing flexibility and maintainability.
MD;

		$readme[] = '';
		$readme[] = 'To add this specific Power to your project in JCB:';
		$readme[] = '';
		$readme[] = '> Simply use this SPK:';
		$readme[] = '```';
		$readme[] = 'Super---' . str_replace('-', '_', $guid) . '---Power';
		$readme[] = '```';
		$readme[] = '> Remember to replace the `---` with `___` to activate this Power in your code.';
		$readme[] = '';

		// Footer

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}
}

