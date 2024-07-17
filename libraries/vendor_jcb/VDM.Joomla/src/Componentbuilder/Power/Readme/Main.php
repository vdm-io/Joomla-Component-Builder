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
███████╗██╗   ██╗██████╗ ███████╗██████╗
██╔════╝██║   ██║██╔══██╗██╔════╝██╔══██╗
███████╗██║   ██║██████╔╝█████╗  ██████╔╝
╚════██║██║   ██║██╔═══╝ ██╔══╝  ██╔══██╗
███████║╚██████╔╝██║     ███████╗██║  ██║
╚══════╝ ╚═════╝ ╚═╝     ╚══════╝╚═╝  ╚═╝
██████╗  ██████╗ ██╗    ██╗███████╗██████╗ ███████╗
██╔══██╗██╔═══██╗██║    ██║██╔════╝██╔══██╗██╔════╝
██████╔╝██║   ██║██║ █╗ ██║█████╗  ██████╔╝███████╗
██╔═══╝ ██║   ██║██║███╗██║██╔══╝  ██╔══██╗╚════██║
██║     ╚██████╔╝╚███╔███╔╝███████╗██║  ██║███████║
╚═╝      ╚═════╝  ╚══╝╚══╝ ╚══════╝╚═╝  ╚═╝╚══════╝
```"];

		// default description of super powers
		$readme[] = "\n### What is JCB Super Powers?\nThe Joomla Component Builder (JCB) Super Power features are designed to enhance JCB's functionality and streamline the development process. These Super Powers enable developers to efficiently manage and share their custom powers across multiple JCB instances through repositories hosted on [https://git.vdm.dev/[username]/[repository-name]](https://git.vdm.dev). JCB Super Powers are managed using a combination of layers, events, tasks, methods, switches, and algorithms, which work together to provide powerful customization and extensibility options. More details on JCB Super Powers can be found in the [Super Powers Documentation](https://git.vdm.dev/joomla/super-powers/wiki).\n\nIn summary, JCB Super Powers offer a flexible and efficient way to manage and share functionalities between JCB instances. By utilizing a sophisticated system of layers, events, tasks, methods, switches, and algorithms, developers can seamlessly integrate JCB core powers and their custom powers. For more information on how to work with JCB Super Powers, refer to the [Super Powers User Guide](https://git.vdm.dev/joomla/super-powers/wiki).\n\n### What can I find here?\nThis repository contains an index (see below) of all the approved powers within the JCB GUI. During the compilation of a component, these powers are automatically added to the repository, ensuring a well-organized and accessible collection of functionalities.\n";

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
				'namespace' => $power['namespace'],
				'type' => $power['type'],
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
		$this->sortClasses($classes, $this->defineTypeOrder());

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
		$result = "# Index of powers\n";
		$current_namespace = null;

		foreach ($classes as $class)
		{
			if ($class['namespace'] !== $current_namespace)
			{
				$current_namespace = $class['namespace'];
				$result .= "\n- **Namespace**: [{$current_namespace}](#" .
					strtolower(str_replace('\\', '-', $current_namespace)) . ")\n";
			}

			// Add the class details
			$result .= "\n  - " . $class['link'];
		}

		$result .= "\n> remember to replace the `---` with `___` in the SPK to activate that Power in your code";

		return $result;
	}

	/**
	 * Define the order of types for sorting purposes
	 *
	 * @return array The order of types
	 * @since 3.2.0
	 */
	private function defineTypeOrder(): array
	{
		return [
			'interface' => 1,
			'abstract' => 2,
			'abstract class' => 2,
			'final' => 3,
			'final class' => 3,
			'class' => 4,
			'trait' => 5
		];
	}

	/**
	 * Sort the flattened array using a single sorting function
	 *
	 * @param array $classes The classes to sort
	 * @param array $typeOrder The order of types
	 * @since 3.2.0
	 */
	private function sortClasses(array &$classes, array $typeOrder): void
	{
		usort($classes, function ($a, $b) use ($typeOrder) {
			$namespaceDiff = $this->compareNamespace($a, $b);

			if ($namespaceDiff !== 0)
			{
				return $namespaceDiff;
			}

			$typeDiff = $this->compareType($a, $b, $typeOrder);

			if ($typeDiff !== 0)
			{
				return $typeDiff;
			}

			return $this->compareName($a, $b);
		});
	}

	/**
	 * Compare the namespace of two classes
	 *
	 * @param array $a First class
	 * @param array $b Second class
	 *
	 * @return int Comparison result
	 * @since 3.2.0
	 */
	private function compareNamespace(array $a, array $b): int
	{
		$namespaceDepthDiff = substr_count($a['namespace'], '\\') - substr_count($b['namespace'], '\\');

		if ($namespaceDepthDiff === 0)
		{
			return strcmp($a['namespace'], $b['namespace']);
		}

		return $namespaceDepthDiff;
	}

	/**
	 * Compare the type of two classes
	 *
	 * @param array $a First class
	 * @param array $b Second class
	 * @param array $typeOrder The order of types
	 *
	 * @return int Comparison result
	 * @since 3.2.0
	 */
	private function compareType(array $a, array $b, array $typeOrder): int
	{
		return $typeOrder[$a['type']] <=> $typeOrder[$b['type']];
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
		$type = $power['type'] ?? 'error';
		$name = $power['name'] ?? 'error';
		return '**' . $type . ' ' . $name . "** | "
			. $this->linkPowerRepo($power) . ' | '
			. $this->linkPowerCode($power) . ' | '
			. $this->linkPowerSettings($power) . ' | SPK: `'
			. $this->linkPowerSPK($power) .'`';
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
	private function linkPowerCode(array &$power): string
	{
		$code = $power['code'] ?? 'error';
		return '[Code](' . $code . ')';
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
	 * Get the SuperPowerKey (SPK)
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerSPK(array &$power): string
	{
		$spk = $power['spk'] ?? 'error';
		return $spk;
	}
}

