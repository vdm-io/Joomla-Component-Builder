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

namespace VDM\Joomla\Componentbuilder\JoomlaPower\Readme;


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Joomla Power Item Readme
 * @since 3.2.0
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
     ██╗ ██████╗  ██████╗ ███╗   ███╗██╗      █████╗     ██████╗  ██████╗ ██╗    ██╗███████╗██████╗ 
     ██║██╔═══██╗██╔═══██╗████╗ ████║██║     ██╔══██╗    ██╔══██╗██╔═══██╗██║    ██║██╔════╝██╔══██╗
     ██║██║   ██║██║   ██║██╔████╔██║██║     ███████║    ██████╔╝██║   ██║██║ █╗ ██║█████╗  ██████╔╝
██   ██║██║   ██║██║   ██║██║╚██╔╝██║██║     ██╔══██║    ██╔═══╝ ██║   ██║██║███╗██║██╔══╝  ██╔══██╗
╚█████╔╝╚██████╔╝╚██████╔╝██║ ╚═╝ ██║███████╗██║  ██║    ██║     ╚██████╔╝╚███╔███╔╝███████╗██║  ██║
 ╚════╝  ╚═════╝  ╚═════╝ ╚═╝     ╚═╝╚══════╝╚═╝  ╚═╝    ╚═╝      ╚═════╝  ╚══╝╚══╝ ╚══════╝╚═╝  ╚═╝
```"];
		// system name
		$readme[] = "# " . $item->system_name;

		if (!empty($item->description))
		{
			$readme[] = "\n" . $item->description;
		}

		$readme[] = "\nThe Joomla! Power feature allows you to use Joomla classes in your project without manually managing their namespaces. JCB will automatically add the correct namespaces to your files. If Joomla classes change in future versions, such as from Joomla 3 to 5, JCB will update them for you.\n\nHowever, if there are breaking changes in function names, you may need to make some manual adjustments. The Joomla Power Key (JPK) helps you easily search for these classes.\n\nBy using the JPK (Joomla Power Key) in your custom code (replacing the class name in your code with the JPK), JCB will automatically pull the Joomla! Power from the repository into your project.\n\nTo add this specific power to your project in JCB:\n\n> simply use this JPK\n```\n" . 'Joomla---' . str_replace('-', '_', $item->guid) . '---Power' . "\n```\n> remember to replace the `---` with `___` to activate this Joomla! Power in your code";

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

