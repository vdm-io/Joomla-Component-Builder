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


/**
 * Compiler Power Plantuml Builder
 * @since 3.2.0
 */
class Plantuml
{
	/**
	 * Get a namespace diagram of a group of class
	 *
	 * @param string $namespace  the namespace name
	 * @param string $classes    the ready build class uml
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function namespaceDiagram(string $namespace, string $classes): string
	{
		$namespace_depth = substr_count($namespace, '\\');
		$namespace_color = $this->getNamespaceColor($namespace_depth);

		// Set the scale of the diagram
		// $plant_uml = "scale 0.8\n\n";

		// Add namespace
		$plant_uml = "namespace $namespace #$namespace_color {\n\n";

		// Add class
		$plant_uml .= $classes;

		$plant_uml .= "}\n";

		return $plant_uml;
	}

	/**
	 * Get a class basic diagram of a class
	 *
	 * @param array $power  the class being built
	 * @param array $code   the class code being built
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function classBasicDiagram(array $power, array $code): string
	{
		// Set some global values
		$class_name = $power['name'];
		$class_type = $power['type'];

		// set the class color
		$class_color = $this->getClassColor($class_type);

		// set the class type label
		$type_label = $this->getClassTypeLable($class_type);

		// set the class type tag
		$type_tag = $this->getClassTypeTag($class_type);

		// Add class
		$plant_uml = "\n  $type_label $class_name $type_tag #$class_color {\n";

		// Add properties
		if ($code['properties'])
		{
			$plant_uml .= $this->generatePropertiesPlantUML($code['properties'], '    ');
		}

		// Add methods
		if ($code['methods'])
		{
			$plant_uml .= $this->generateBasicMethodsPlantUML($code['methods']);
		}

		$plant_uml .= "  }\n";

		return $plant_uml;
	}

	/**
	 * Get a class detailed diagram of a class
	 *
	 * @param array $power  the class being built
	 * @param array $code   the class code being built
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function classDetailedDiagram(array $power, array $code): string
	{
		// Set some global values
		$class_name = $power['name'];
		$class_type = $power['type'];

		// set the class color
		$class_color = $this->getClassColor($class_type);

		// set the class type label
		$type_label = $this->getClassTypeLable($class_type);

		// set the class type tag
		$type_tag = $this->getClassTypeTag($class_type);

		// Add class
		$plant_uml = "\n$type_label $class_name $type_tag #$class_color {\n";

		// Add properties
		if ($code['properties'])
		{
			$plant_uml .= $this->generatePropertiesPlantUML($code['properties'], '  ');
		}

		// Add methods
		if ($code['methods'])
		{
			list($methods_plant_uml, $notes) = $this->generateDetailedMethodsPlantUML($code['methods'], $class_name);
			$plant_uml .= $methods_plant_uml;
		}

		$plant_uml .= "}\n";

		if (!empty($notes))
		{
			$plant_uml .= $this->generateNotesPlantUML($notes);
		}

		return $plant_uml;
	}

	/**
	 * Generate properties PlantUML
	 *
	 * @param array $properties
	 * @param string $space
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function generatePropertiesPlantUML(array $properties, string $space): string
	{
		$plant_uml = "";

		foreach ($properties as $property)
		{
			$access_sign = $this->getAccessSign($property['access']);
			$static = $property['static'] ? '{static} ' : '';
			$type = $property['type'] ? $property['type'] . ' ' : '';
			$plant_uml .= "{$space}$access_sign $static{$type}{$property['name']}\n";
		}

		return $plant_uml;
	}

	/**
	 * Generate detailed methods PlantUML
	 *
	 * @param array $methods
	 * @param string $class_name
	 *
	 * @return array
	 * @since 3.2.0
	 */
	private function generateDetailedMethodsPlantUML(array $methods, string $class_name): array
	{
		$plant_uml = "";
		$notes = [];

		foreach ($methods as $method)
		{
			$notes = $this->generateMethodNotes($method, $class_name, $notes);

			$access_sign = $this->getAccessSign($method['access']);

			$arguments = '';
			if ($method['arguments'])
			{
				$arguments = $this->generateMethodArgumentsAndNotes(
					$method['arguments'], $class_name, $method['name'], $notes);

				$arguments = implode(', ', $arguments);
			}

			$static = $method['static'] ? '{static} ' : '';
			$abstract = $method['abstract'] ? '{abstract} ' : '';
			$return_type = $method['return_type'] ? " : {$method['return_type']}" : '';

			$plant_uml .= "  $access_sign {$abstract}$static{$method['name']}({$arguments})$return_type\n";
		}

		return [$plant_uml, $notes];
	}

	/**
	 * Generate basic methods PlantUML
	 *
	 * @param array $properties
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function generateBasicMethodsPlantUML(array $methods): string
	{
		$plant_uml = "";

		foreach ($methods as $method)
		{
			$access_sign = $this->getAccessSign($method['access']);
			$static = $method['static'] ? '{static} ' : '';
			$abstract = $method['abstract'] ? '{abstract} ' : '';
			$return_type = $method['return_type'] ? " : {$method['return_type']}" : '';
			$plant_uml .= "    $access_sign {$abstract}$static{$method['name']}()$return_type\n";
		}

		return $plant_uml;
	}

	/**
	 * Generate method arguments and notes
	 *
	 * @param array $arguments
	 * @param string $class_name
	 * @param string $method_name
	 * @param array $notes
	 *
	 * @return array
	 * @since 3.2.0
	 */
	private function generateMethodArgumentsAndNotes(array $arguments, string $class_name,
		string $method_name, array &$notes): array
	{
		$formatted_arguments = [];
		$notes_bucket = [];
		$limit = 2;

		foreach ($arguments as $name => $arg)
		{
			$arg_type = $arg['type'] ? "{$arg['type']} " : '';
			$arg_default = $arg['default'] ? " = {$arg['default']}" : '';
			$arg_statment = "{$arg_type}$name{$arg_default}";

			if ($limit == 0)
			{
				$formatted_arguments[] = "...";
				$limit = -1;
			}
			elseif ($limit > 0)
			{
				$formatted_arguments[] = $arg_statment;
				$limit--;
			}

			$notes_bucket[] = $arg_statment;
		}

		if ($limit == -1)
		{
			$notes["{$class_name}::{$method_name}"][] = "\n  arguments:\n    " . implode("\n    ", $notes_bucket);
		}

		return $formatted_arguments;
	}

	/**
	 * Generate method notes
	 *
	 * @param array $method
	 * @param string $class_name
	 * @param array $notes
	 *
	 * @return array
	 */
	private function generateMethodNotes(array $method, string $class_name, array &$notes): array
	{
		$notes_key = "{$class_name}::{$method['name']}";

		if (is_string($method['comment']) && strlen($method['comment']) > 4)
		{
			$notes[$notes_key][] = trim(preg_replace("/^@.*[\r\n]*/m", '', $method['comment'])) . "\n";
		}

		if (is_string($method['since']) && strlen($method['since']) > 3)
		{
			$notes[$notes_key][] = "since: {$method['since']}";
		}

		if (is_string($method['return_type']) && strlen($method['return_type']) > 1)
		{
			$notes[$notes_key][] = "return: {$method['return_type']}";
		}

		if (is_string($method['deprecated']) && strlen($method['deprecated']) > 3)
		{
			$notes[$notes_key][] = "deprecated: {$method['deprecated']}";
		}

		return $notes;
	}

	/**
	 * Generate notes PlantUML
	 *
	 * @param array $notes
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function generateNotesPlantUML(array $notes): string
	{
		$plant_uml = "";
		$note_count = count($notes);

		$positions = ['right', 'left'];
		$position_index = 0;

		foreach ($notes as $area => $note)
		{
			if ($note_count <= 7)
			{
				$position = 'right';
			}
			else
			{
				$position = $positions[$position_index % 2];
				$position_index++;
			}

			$plant_uml .= "\nnote $position of {$area}\n";
			$plant_uml .= "  " . implode("\n  ", $note) . "\n";
			$plant_uml .= "end note\n";
		}

		return $plant_uml;
	}

	/**
	 * Get the access sign based on the access level.
	 *
	 * @param string $access The access level.
	 *
	 * @return string The corresponding access sign.
	 * @since 3.2.0
	 */
	private function getAccessSign(string $access): string
	{
		switch ($access)
		{
			case 'private':
				return '-';
			case 'protected':
				return '#';
			case 'public':
				return '+';
			case 'var':
				return '+';
			default:
				return '';
		}
	}

	/**
	 * Get the correct class type.
	 *
	 * @param string $type The class type.
	 *
	 * @return string The correct class type label.
	 * @since 3.2.0
	 */
	private function getClassTypeLable(string $type): string
	{
		$class_type_updater = [
			'final class' => 'class',
			'abstract class' => 'abstract',
			'trait' => 'class'
		];

		return $class_type_updater[$type] ?? $type;
	}

	/**
	 * Get the extra class type tag.
	 *
	 * @param string $type The class type.
	 *
	 * @return string The correct class type label.
	 * @since 3.2.0
	 */
	private function getClassTypeTag(string $type): string
	{
		$class_type_updater = [
			'final class' => '<< (F,LightGreen) >>',
			'trait' => '<< (T,Orange) >>'
		];

		return $class_type_updater[$type] ?? '';
	}

	/**
	 * Get class color based on class type.
	 *
	 * @param string $classType The class type.
	 *
	 * @return string The corresponding color.
	 * @since 3.2.0
	 */
	private function getClassColor(string $classType): string
	{
		$class_colors = [
			'class' => 'Gold',
			'final' => 'RoyalBlue',
			'abstract class' => 'Orange',
			'interface' => 'Lavender',
			'trait' => 'Turquoise'
		];

		return $class_colors[$classType] ?? 'Green';
	}

	/**
	 * Get namespace color based on namespace depth.
	 *
	 * @param int $namespaceDepth The depth of the namespace.
	 *
	 * @return string The corresponding color.
	 * @since 3.2.0
	 */
	private function getNamespaceColor(int $namespaceDepth): string
	{
		$namespace_colors = [
			'lightgrey',
			'Azure',
			'DarkCyan',
			'Olive',
			'LightGreen',
			'DeepSkyBlue',
			'Wheat',
			'Coral',
			'Beige',
			'DeepPink',
			'DeepSkyBlue'
		];

		return $namespace_colors[$namespaceDepth % count($namespace_colors)] ?? 'lightgrey';
	}

}

