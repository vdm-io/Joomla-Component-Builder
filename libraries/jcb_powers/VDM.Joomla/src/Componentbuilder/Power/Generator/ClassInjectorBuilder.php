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

namespace VDM\Joomla\Componentbuilder\Power\Generator;


use VDM\Joomla\Componentbuilder\Power\Generator\Search;
use VDM\Joomla\Componentbuilder\Power\Generator\ClassInjector;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Power Class Injector Builder of JCB
 * 
 * @since 3.2.0
 */
final class ClassInjectorBuilder
{
	/**
	 * The Search Class.
	 *
	 * @var   Search
	 * @since 3.2.0
	 */
	protected Search $search;

	/**
	 * The Class Injector Class.
	 *
	 * @var   ClassInjector
	 * @since 3.2.0
	 */
	protected ClassInjector $classinjector;

	/**
	 * Constructor.
	 *
	 * @param Search          $search          The Search Class.
	 * @param ClassInjector   $classinjector   The Class Injector Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Search $search, ClassInjector $classinjector)
	{
		$this->search = $search;
		$this->classinjector = $classinjector;
	}

	/**
	 * Get the injection code.
	 *
	 * @param array        $power    The power being saved
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	public function getCode(array $power): ?string
	{
		$this->setVersion($this->extractSinceVersion($power['description']) ?? $power['power_version'] ?? '1.0.0');

		foreach ($power['use_selection'] as $use_selection)
		{
			if (!$this->valid($use_selection['use']))
			{
				continue;
			}

			if (($name = $this->getName($use_selection['use'], $use_selection['as'])) === null)
			{
				continue;
			}

			if (($description = $this->getDescription($use_selection['use'])) === null)
			{
				continue;
			}

			$this->setProperty($name, $description);
			$this->setComment($name, $description);
			$this->setArgument($name);
			$this->setAssignment($name);
		}

		return $this->getDependencyInjectionCode();
	}

	/**
	 * Check that this is a valid injection class.
	 *
	 * @param string      $guid     The class GUID of the power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	private function valid(string $guid): bool
	{
		return $this->search->validInject($guid);
	}

	/**
	 * Get the class name.
	 *
	 * @param string      $guid     The class GUID of the power
	 * @param string      $as     The as name
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	private function getName(string $guid, string $as = 'default'): ?string
	{
		return $this->search->name($guid, $as);
	}

	/**
	 * Get the class description.
	 *
	 * @param string      $guid     The class GUID of the power
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	private function getDescription(string $guid): ?string
	{
		return $this->search->description($guid);
	}

	/**
	 * Get the dependency injection code.
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	private function getDependencyInjectionCode(): ?string
	{
		return $this->classinjector->getCode();
	}

	/**
	 * Set the class since version.
	 *
	 * @param string   $version  The class since version
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setVersion(string $version): void
	{
		$this->classinjector->setVersion($version);
	}

	/**
	 * Set the class property.
	 *
	 * @param string      $name          The class name
	 * @param string      $description   The class description
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setProperty(string $name, string $description): void
	{
		$this->classinjector->setProperty(
			strtolower($name),
			$name,
			$description
		);
	}

	/**
	 * Set the class comment for the constructor parameter.
	 *
	 * @param string      $name          The class name
	 * @param string      $description   The class description
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setComment(string $name, string $description): void
	{
		$this->classinjector->setComment(
			strtolower($name),
			$name,
			$description
		);
	}

	/**
	 * Set the class constructor argument.
	 *
	 * @param string      $name   The class name
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setArgument(string $name): void
	{
		$this->classinjector->setArgument(
			strtolower($name),
			$name
		);
	}

	/**
	 * Get the assignment code inside the constructor.
	 *
	 * @param string      $name   The class name
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setAssignment(string $name): void
	{
		$this->classinjector->setAssignment(
			strtolower($name)
		);
	}

	/**
	 * Extract the '@since' version number from a given string.
	 *
	 * This function checks the provided string for a '@since' annotation 
	 * and retrieves the subsequent version number. If no '@since' 
	 * annotation is found or no version number is provided after the 
	 * annotation, the function will return null.
	 *
	 * @param string $inputString The input string to search.
	 *
	 * @return string|null The version number if found, or null if not.
	 * @since 3.2.0
	 */
	private function extractSinceVersion(string $inputString): ?string
	{
		// Use regex to match the @since pattern and capture the version number
		if (preg_match('/@since\s+([\d\.]+)/', $inputString, $matches))
		{
			return $matches[1];
		}

		// If no match is found, return null
		return null;
	}
}

