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
	 * Get an item readme
	 *
	 * @param object  $item  An item details.
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function get(object $item): string
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
		if (isset($item->parsed_class_code) && is_array($item->parsed_class_code))
		{
			$parsed_class_code = $item->parsed_class_code;
		}

		$readme[] = "# " . $item->type . " " . $item->code_name . " (Details)";
		$readme[] = "> namespace: **" . $item->_namespace . "**";
		if (!empty($item->extends_name))
		{
			$readme[] = "> extends: **" . $item->extends_name . "**";
		}
		$readme[] = "\n```uml\n@startuml" . $this->plantuml->classDetailedDiagram(
			['name' => $item->code_name, 'type' => $item->type],
			$parsed_class_code
		) . " \n@enduml\n```";

		$readme[] = "\nThe Power feature in JCB allows you to write PHP classes and their implementations, making it easy to include them in your Joomla project. JCB handles linking, autoloading, namespacing, and folder structure creation for you.\n\nBy using the SPK (Super Power Key) in your custom code (replacing the class name in your code with the SPK), JCB will automatically pull the power from the repository into your project. This makes it available in your JCB instance, allowing you to edit it and include the class in your generated Joomla component.\n\nJCB uses placeholders like [[[`NamespacePrefix`]]] and [[[`ComponentNamespace`]]] in namespacing to prevent collisions and improve reusability across different JCB systems. You can also set the **JCB powers path** globally or per component under the **Dynamic Integration** tab, providing flexibility and easy maintainability.\n\nTo add this specific Power to your project in JCB:\n\n> simply use this SPK\n```\n" . 'Super---' . str_replace('-', '_', $item->guid) . '---Power' . "\n```\n> remember to replace the `---` with `___` to activate this Power in your code";

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

