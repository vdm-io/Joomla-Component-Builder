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
use VDM\Joomla\Componentbuilder\Power\Generator\ServiceProvider;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Power Service Provider Builder of JCB
 * 
 * @since 3.2.0
 */
final class ServiceProviderBuilder
{
	/**
	 * The Search Class.
	 *
	 * @var   Search
	 * @since 3.2.0
	 */
	protected Search $search;

	/**
	 * The Service Provider Class.
	 *
	 * @var   ServiceProvider
	 * @since 3.2.0
	 */
	protected ServiceProvider $serviceprovider;

	/**
	 * Constructor.
	 *
	 * @param Search            $search            The Search Class.
	 * @param ServiceProvider   $serviceprovider   The Service Provider Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Search $search, ServiceProvider $serviceprovider)
	{
		$this->search = $search;
		$this->serviceprovider = $serviceprovider;
	}

	/**
	 * Get the service provider code.
	 *
	 * @param array        $power    The power being saved
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	public function getCode(array $power): ?string
	{
		$this->setVersion($this->extractSinceVersion($power['description'] ?? '') ?? $power['power_version'] ?? '1.0.0');

		if (!empty($power['use_selection']))
		{
			$this->setRegisterLines($power['use_selection']);
			$this->setGetFunctions($power['use_selection']);
		}

		return $this->getServiceProviderCode();
	}

	/**
	 * Set the class alias and share code for the service provider register.
	 *
	 * @param array   $useSelections       The use (in class) selections
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setRegisterLines(array $useSelections): void
	{
		foreach ($useSelections as $use_selection)
		{
			if (!$this->valid($use_selection['use']))
			{
				continue;
			}

			if (($name = $this->getName($use_selection['use'], $use_selection['as'])) === null)
			{
				continue;
			}

			$function_name = $this->getFunctionName($name);
			$alias = $this->getAlias($use_selection['use'], $name);

			$this->setRegisterLine($name, $function_name, $alias);
		}
	}

	/**
	 * Set the class get function for the service provider.
	 *
	 * @param array   $useSelections       The use (in class) selections
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setGetFunctions(array $useSelections): void
	{
		foreach ($useSelections as $use_selection)
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

			$function_name = $this->getFunctionName($name);
			$dependencies = $this->getDependencies($use_selection['use']);

			$this->setGetFunction($name, $function_name, "Get $description", $dependencies);
		}
	}

	/**
	 * Check that this is a valid injection class.
	 *
	 * @param string    $guid   The class GUID of the power
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
	 * Get the function name.
	 *
	 * @param string      $name     The class name
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function getFunctionName(string $name): string
	{
		return "get{$name}";
	}

	/**
	 * Get the dependencies of a class
	 *
	 * @param string      $guid     The class GUID of the power
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	private function getDependencies(string $guid): ?array
	{
		return $this->search->dependencies($guid);
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
	 * Get the class alias
	 *
	 * @param string     $guid        The class GUID of the power
	 * @param string     $className   The class name
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function getAlias(string $guid, string $className): string
	{
		return $this->search->alias($guid, $className);
	}

	/**
	 * Get the service provider code.
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	private function getServiceProviderCode(): ?string
	{
		return $this->serviceprovider->getCode();
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
		$this->serviceprovider->setVersion($version);
	}

	/**
	 * Set the class alias and share code for the service provider register.
	 *
	 * @param string   $className       The variable name in lowerCamelCase format.
	 * @param string   $functionName    The function name in lowerCamelCase format.
	 * @param string   $alias           The variable alias format.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setRegisterLine(string $className, string $functionName, string $alias): void
	{
		$this->serviceprovider->setRegisterLine($className, $functionName, $alias);
	}

	/**
	 * Set the class get function for the service provider.
	 *
	 * @param string       $className       The variable name in lowerCamelCase format.
	 * @param string       $functionName    The function name in lowerCamelCase format.
	 * @param string       $description     The function description.
	 * @param array|null   $dependencies    The class dependencies aliases.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setGetFunction(string $className, string $functionName,
		string $description, ?array $dependencies = null): void
	{
		$this->serviceprovider->setGetFunction($className, $functionName,
			$description, $dependencies);
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

