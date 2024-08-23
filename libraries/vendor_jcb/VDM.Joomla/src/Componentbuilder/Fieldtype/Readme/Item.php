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

namespace VDM\Joomla\Componentbuilder\Fieldtype\Readme;


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Field Type Item Readme
 * 
 * @since  5.0.3
 */
final class Item implements ItemInterface
{
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
     ██╗ ██████╗  ██████╗ ███╗   ███╗██╗      █████╗     ███████╗██╗███████╗██╗     ██████╗     ████████╗██╗   ██╗██████╗ ███████╗
     ██║██╔═══██╗██╔═══██╗████╗ ████║██║     ██╔══██╗    ██╔════╝██║██╔════╝██║     ██╔══██╗    ╚══██╔══╝╚██╗ ██╔╝██╔══██╗██╔════╝
     ██║██║   ██║██║   ██║██╔████╔██║██║     ███████║    █████╗  ██║█████╗  ██║     ██║  ██║       ██║    ╚████╔╝ ██████╔╝█████╗  
██   ██║██║   ██║██║   ██║██║╚██╔╝██║██║     ██╔══██║    ██╔══╝  ██║██╔══╝  ██║     ██║  ██║       ██║     ╚██╔╝  ██╔═══╝ ██╔══╝  
╚█████╔╝╚██████╔╝╚██████╔╝██║ ╚═╝ ██║███████╗██║  ██║    ██║     ██║███████╗███████╗██████╔╝       ██║      ██║   ██║     ███████╗
 ╚════╝  ╚═════╝  ╚═════╝ ╚═╝     ╚═╝╚══════╝╚═╝  ╚═╝    ╚═╝     ╚═╝╚══════╝╚══════╝╚═════╝        ╚═╝      ╚═╝   ╚═╝     ╚══════╝
```"];
		// system name
		$readme[] = "# " . $item->name;

		if (!empty($item->description))
		{
			$readme[] = "\n" . $item->description;
		}
		elseif (!empty($item->short_description))
		{
			$readme[] = "\n" . $item->short_description;
		}

		$readme[] = "\nThe Joomla! field types within this repository provide an essential mechanism for integrating Joomla-related field type into the Joomla Component Builder (JCB). Each field type is meticulously designed to ensure compatibility and ease of use within the JCB framework, allowing developers to effortlessly incorporate and manage custom fields in their components. By utilizing the reset functionality, users can seamlessly update individual field types to align with the latest versions maintained in our core repository, ensuring that their projects benefit from the most up-to-date features and fixes. Additionally, for those who prefer a more personalized approach, the repository can be forked, enabling developers to maintain and distribute their customized field types independently from the broader JCB community. This level of flexibility underscores the open-source nature of JCB, offering you the freedom to adapt and extend your components according to your specific needs, while still benefiting from a robust, community-driven ecosystem.";

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

