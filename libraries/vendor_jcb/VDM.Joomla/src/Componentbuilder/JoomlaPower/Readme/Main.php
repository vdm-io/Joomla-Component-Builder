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


use VDM\Joomla\Interfaces\Readme\MainInterface;


/**
 * Compiler Power Main Readme
 * @since 3.2.0
 */
final class Main implements MainInterface
{
	/**
	 * Get Main Readme
	 *
	 * @param array    $items  All items of this repository.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function get(array $items): string
	{
		// build readme
		$readme = ["```
     ██╗ ██████╗  ██████╗ ███╗   ███╗██╗      █████╗ 
     ██║██╔═══██╗██╔═══██╗████╗ ████║██║     ██╔══██╗
     ██║██║   ██║██║   ██║██╔████╔██║██║     ███████║
██   ██║██║   ██║██║   ██║██║╚██╔╝██║██║     ██╔══██║
╚█████╔╝╚██████╔╝╚██████╔╝██║ ╚═╝ ██║███████╗██║  ██║
 ╚════╝  ╚═════╝  ╚═════╝ ╚═╝     ╚═╝╚══════╝╚═╝  ╚═╝
██████╗  ██████╗ ██╗    ██╗███████╗██████╗ ███████╗  
██╔══██╗██╔═══██╗██║    ██║██╔════╝██╔══██╗██╔════╝  
██████╔╝██║   ██║██║ █╗ ██║█████╗  ██████╔╝███████╗  
██╔═══╝ ██║   ██║██║███╗██║██╔══╝  ██╔══██╗╚════██║  
██║     ╚██████╔╝╚███╔███╔╝███████╗██║  ██║███████║  
╚═╝      ╚═════╝  ╚══╝╚══╝ ╚══════╝╚═╝  ╚═╝╚══════╝
```"];

		// default description of super powers
		$readme[] = "\n### What is JCB Joomla Powers?\nThe Joomla Component Builder (JCB) Joomla Power features are designed to enhance JCB's functionality and streamline the development process. The Joomla powers enable developers to effectively leverage Joomla classes in their custom code without needing to manually add the `use` statements for those classes to the file headers. JCB automatically updates these `use` statements in the necessary headers when it detects a Joomla power key in the custom code.\n
\n
By doing this, we can control the `use` statements dynamically from a central point. This is particularly beneficial when transitioning from Joomla 3 to Joomla 4, as it allows us to seamlessly switch from certain classes to their respective Joomla framework classes and vice versa. Maintaining these `use` statements in the Joomla Power area ensures that JCB handles the inclusion and updating of class names to prevent conflicts with other classes.\n
\n
This approach is convenient and allows developers to focus on the bespoke parts of their application logic without worrying about class declarations.\n
\nThis repository contains an index (see below) of all the Joomla! Powers within the JCB core GUI. These Joomla! Powers are automatically added to the repository by our maintainers, ensuring a well-organized and accessible collection of Joomla Classes are maintained.\n";

		// get the readme body
		$readme[] = $this->readmeBuilder($items);

		// yes you can remove this, but why?
		$readme[] = "\n---\n```
     ██╗ ██████╗  ██████╗ ███╗   ███╗██╗      █████╗
     ██║██╔═══██╗██╔═══██╗████╗ ████║██║     ██╔══██╗
     ██║██║   ██║██║   ██║██╔████╔██║██║     ███████║
██   ██║██║   ██║██║   ██║██║╚██╔╝██║██║     ██╔══██║
╚█████╔╝╚██████╔╝╚██████╔╝██║ ╚═╝ ██║███████╗██║  ██║
 ╚════╝  ╚═════╝  ╚═════╝ ╚═╝     ╚═╝╚══════╝╚═╝  ╚═╝
 ██████╗ ██████╗ ███╗   ███╗██████╗  ██████╗ ███╗   ██╗███████╗███╗   ██╗████████╗
██╔════╝██╔═══██╗████╗ ████║██╔══██╗██╔═══██╗████╗  ██║██╔════╝████╗  ██║╚══██╔══╝
██║     ██║   ██║██╔████╔██║██████╔╝██║   ██║██╔██╗ ██║█████╗  ██╔██╗ ██║   ██║
██║     ██║   ██║██║╚██╔╝██║██╔═══╝ ██║   ██║██║╚██╗██║██╔══╝  ██║╚██╗██║   ██║
╚██████╗╚██████╔╝██║ ╚═╝ ██║██║     ╚██████╔╝██║ ╚████║███████╗██║ ╚████║   ██║
 ╚═════╝ ╚═════╝ ╚═╝     ╚═╝╚═╝      ╚═════╝ ╚═╝  ╚═══╝╚══════╝╚═╝  ╚═══╝   ╚═╝
██████╗ ██╗   ██╗██╗██╗     ██████╗ ███████╗██████╗
██╔══██╗██║   ██║██║██║     ██╔══██╗██╔════╝██╔══██╗
██████╔╝██║   ██║██║██║     ██║  ██║█████╗  ██████╔╝
██╔══██╗██║   ██║██║██║     ██║  ██║██╔══╝  ██╔══██╗
██████╔╝╚██████╔╝██║███████╗██████╔╝███████╗██║  ██║
╚═════╝  ╚═════╝ ╚═╝╚══════╝╚═════╝ ╚══════╝╚═╝  ╚═╝
```\n> Build with [Joomla Component Builder](https://git.vdm.dev/joomla/Component-Builder)\n\n";

		return implode("\n", $readme);
	}

	/**
	 * The readme builder
	 *
	 * @param array    $classes  The powers.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function readmeBuilder(array &$items): string
	{
		$classes = [];
		foreach ($items as $guid => $power)
		{
			// add to the sort bucket
			$classes[] = [
				'name' => $power['name'],
				'link' => $this->indexLinkPower($power)
			];
		}

		return $this->readmeModel($classes);
	}

	/**
	 * Sort and model the readme classes
	 *
	 * @param array $classes The powers.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function readmeModel(array &$classes): string
	{
		$this->sortClasses($classes);

		return $this->generateIndex($classes);
	}

	/**
	 * Generate the index string for classes
	 *
	 * @param array $classes The sorted classes
	 *
	 * @return string The index string
	 */
	private function generateIndex(array &$classes): string
	{
		$result = "# Index of Joomla! Powers\n";

		foreach ($classes as $class)
		{
			// Add the class details
			$result .= "\n - " . $class['link'];
		}

		$result .= "\n> remember to replace the `---` with `___` in the JPK to activate that Joomla! Power in your code";


		return $result;
	}

	/**
	 * Sort the flattened array using a single sorting function
	 *
	 * @param array $classes The classes to sort
	 *
	 * @since 3.2.0
	 */
	private function sortClasses(array &$classes): void
	{
		usort($classes, function ($a, $b) {
			return $this->compareName($a, $b);
		});
	}

	/**
	 * Compare the name of two classes
	 *
	 * @param array $a First class
	 * @param array $b Second class
	 *
	 * @return int Comparison result
	 * @since 3.2.0
	 */
	private function compareName(array $a, array $b): int
	{
		return strcmp($a['name'], $b['name']);
	}

	/**
	 * Build the Link to the power in this repository
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function indexLinkPower(array &$power): string
	{
		$name = $power['name'] ?? 'error';
		return '**' . $name . "** | "
			. $this->linkPowerRepo($power) . ' | '
			. $this->linkPowerSettings($power) . ' | JPK: `'
			. $this->linkPowerJPK($power) .'`';
	}

	/**
	 * Build the Link to the power in this repository
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerRepo(array &$power): string
	{
		$path = $power['path'] ?? 'error';
		return '[Details](' . $path . ')';
	}

	/**
	 * Build the Link to the power settings in this repository
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerSettings(array &$power): string
	{
		$settings = $power['settings'] ?? 'error';
		return '[Settings](' . $settings . ')';
	}

	/**
	 * Get the JoomlaPowerKey (JPK)
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerJPK(array &$power): string
	{
		$jpk = $power['jpk'] ?? 'error';
		return $jpk;
	}
}

