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

namespace VDM\Joomla\Componentbuilder\Compiler\Power\Repo;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Power\Plantuml;


/**
 * Compiler Power Repo Readme
 * @since 3.2.0
 */
class Readme
{
	/**
	 * Power Objects
	 *
	 * @var    Power
	 * @since 3.2.0
	 **/
	protected Power $power;

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
	 * @param Power|null         $power        The power object.
	 * @param Plantuml|null      $plantuml     The powers plantuml builder object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Power $power = null, ?Plantuml $plantuml = null)
	{
		$this->power = $power ?: Compiler::_('Power');
		$this->plantuml = $plantuml ?: Compiler::_('Power.Plantuml');
	}

	/**
	 * Get a Power Readme
	 *
	 * @param object  $power A power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function get(object $power): string
	{
		// build readme
		$readme = ["```
██████╗  ██████╗ ██╗    ██╗███████╗██████╗
██╔══██╗██╔═══██╗██║    ██║██╔════╝██╔══██╗
██████╔╝██║   ██║██║ █╗ ██║█████╗  ██████╔╝
██╔═══╝ ██║   ██║██║███╗██║██╔══╝  ██╔══██╗
██║     ╚██████╔╝╚███╔███╔╝███████╗██║  ██║
╚═╝      ╚═════╝  ╚══╝╚══╝ ╚══════╝╚═╝  ╚═╝
```"];
		// add the class diagram
		$parsed_class_code = [];
		if (isset($power->parsed_class_code) && is_array($power->parsed_class_code))
		{
			$parsed_class_code = $power->parsed_class_code;
		}

		$readme[] = "# " . $power->type . " " . $power->code_name . " (Details)";
		$readme[] = "> namespace: **" . $power->_namespace . "**";
		if ($power->extends != 0)
		{
			$readme[] = "> extends: **" . $power->extends_name . "**";
		}
		$readme[] = "```uml\n@startuml" . $this->plantuml->classDetailedDiagram(
			['name' => $power->code_name, 'type' => $power->type],
			$parsed_class_code
		) . " \n@enduml\n```";

		// yes you can remove this, but why?
		$readme[] = "\n---\n```
     ██╗ ██████╗██████╗
     ██║██╔════╝██╔══██╗
     ██║██║     ██████╔╝
██   ██║██║     ██╔══██╗
╚█████╔╝╚██████╗██████╔╝
 ╚════╝  ╚═════╝╚═════╝
```\n> Build with [Joomla Component Builder](https://git.vdm.dev/joomla/Component-Builder)\n\n";

		return implode("\n", $readme);
	}

}

