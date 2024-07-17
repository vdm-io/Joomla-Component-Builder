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


use VDM\Joomla\Data\Action\Load as Database;
use VDM\Joomla\Componentbuilder\Power\Parser;
use VDM\Joomla\Componentbuilder\Power\Generator\Bucket;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;


/**
 * Power code Generator Search of JCB
 * 
 * @since 3.2.0
 */
final class Search
{
	/**
	 * The Database Class
	 *
	 * @var    Database
	 * @since 3.2.0
	 **/
	protected Database $database;

	/**
	 * The Code Parser Class
	 *
	 * @var    Parser
	 * @since 3.2.0
	 **/
	protected Parser $parser;

	/**
	 * The found powers
	 *
	 * @var    Bucket
	 * @since 3.2.0
	 **/
	protected Bucket $bucket;

	/**
	 * Constructor.
	 *
	 * @param Database   $database   The Database object.
	 * @param Parser     $parser     The parser object.
	 * @param Bucket     $bucket     The bucket object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Database $database, Parser $parser, Bucket $bucket)
	{
		$this->database = $database;
		$this->parser = $parser;
		$this->bucket = $bucket;
	}

	/**
	 * Get the power object
	 *
	 * @param string        $guid     The global unique id of the power
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function power(string $guid): ?object
	{
		if (($power = $this->bucket->get("power.{$guid}")) === null)
		{
			if (($power = $this->database->table('power')->item(['guid' => $guid])) === null)
			{
				return null;
			}

			$this->bucket->set("power.{$guid}", $power);
		}

		return $power;
	}

	/**
	 * Get the power alias to use in container calls
	 *
	 * @param string   $guid         The global unique id of the power
	 * @param string   $className    The current class name
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function alias(string $guid, string $className): string
	{
		if (($alias = $this->bucket->get("alias.{$guid}")) !== null)
		{
			return $alias;
		}

		// load the service providers where its already linked
		if (($service_providers = $this->serviceProviders($guid)) !== null)
		{
			foreach ($service_providers as $service_provider)
			{
				$dependency_name = $this->getServiceProviderDependencyName($service_provider, $guid) ?? $className;

				if (($alias = $this->getAliasFromServiceProvider($service_provider, $dependency_name)) === null)
				{
					continue;
				}

				break;
			}
		}

		if (empty($alias))
		{
			// build it based on the class name and namespace of this power
			$alias = $this->getAliasFromPower($guid);
		}

		// finally we set the alias for later use
		$alias = $alias ?? "Set.Me.$className";
		$alias = trim($alias);
		$this->bucket->set("alias.{$guid}", $alias);

		return $alias;
	}

	/**
	 * Check if a power class is valid to inject into another class
	 *
	 * @param string        $guid      The global unique id of the power
	 *
	 * @return bool  True if class can (should) be injected
	 * @since 3.2.0
	 */
	public function validInject(string $guid): bool
	{
		if (($valid_inject = $this->bucket->get("valid_inject.{$guid}")) !== null)
		{
			return $valid_inject;
		}

		if (($power = $this->power($guid)) === null)
		{
			return false;
		}

		// Types: [class, abstract class, final class, interface, trait]
		// Allowed: [class, final class, interface]
		if ($power->type === 'class' || $power->type === 'final class' || $power->type === 'interface')
		{
			$this->bucket->set("valid_inject.{$guid}", true);

			return true;
		}

		$this->bucket->set("valid_inject.{$guid}", false);

		return false;
	}

	/**
	 * Get the power class name
	 *
	 * @param string        $guid       The global unique id of the power
	 * @param string        $as          The use AS value
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	public function name(string $guid, string $as = 'default'): ?string
	{
		if ($as !== 'default')
		{
			return $as;
		}

		if (($name = $this->bucket->get("name.{$guid}")) !== null)
		{
			return $name;
		}

		if (($power = $this->power($guid)) === null)
		{
			return null;
		}

		if (strpos($power->name, '[') !== false)
		{
			$name = 'DynamicClassName';
		}
		else
		{
			$name = ClassfunctionHelper::safe($power->name);
		}

		$name = trim($name);
		$this->bucket->set("name.{$guid}", $name);

		return $name;
	}

	/**
	 * Get the power class description
	 *
	 * @param string   $guid    The global unique id of the power
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	public function description(string $guid): ?string
	{
		if (($description = $this->bucket->get("description.{$guid}")) !== null)
		{
			return $description;
		}

		if (($power = $this->power($guid)) === null)
		{
			return null;
		}

		if (strpos($power->name, '[') !== false)
		{
			$description = 'The Dynamic {$power->name} Name';
		}
		else
		{
			$description = "The {$power->name} Class.";
		}

		$this->bucket->set("description.{$guid}", $description);

		return $description;
	}

	/**
	 * Get all service providers where this power is linked
	 *
	 * @param string   $guid    The global unique id of the power
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function serviceProviders(string $guid): ?array
	{
		if (($service_providers = $this->bucket->get("service_providers.{$guid}")) === null)
		{
			if (($powers = $this->database->table('power')->items([
				'use_selection' => [
					'operator' => 'LIKE',
					'value' => "'%{$guid}%'",
					'quote' => false
				],
				'implements_custom' => [
					'operator' => 'LIKE',
					'value' => "'%ServiceProviderInterface%'",
					'quote' => false
				]
			])) === null)
			{
				return null;
			}

			$service_providers = [];
			foreach ($powers as $power)
			{
				$this->bucket->set("power.{$power->guid}", $power);
				$service_providers[] = $power->guid;
			}

			$this->bucket->set("service_providers.{$guid}", $service_providers);
		}

		return $service_providers;
	}

	/**
	 * Get all the power dependencies
	 *
	 * @param string   $guid    The global unique id of the power
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function dependencies(string $guid): ?array
	{
		if (($dependencies = $this->bucket->get("dependencies.{$guid}")) !== null)
		{
			return $dependencies;
		}

		if (($power = $this->power($guid)) === null)
		{
			return null;
		}

		if (empty($power->use_selection) || !is_object($power->use_selection))
		{
			return null;
		}

		$dependencies = [];
		foreach ($power->use_selection as $use_selection)
		{
			if (!$this->validInject($use_selection->use))
			{
				continue;
			}

			if (($name = $this->name($use_selection->use, $use_selection->as)) === null)
			{
				continue;
			}

			$dependencies[] = $this->alias($use_selection->use, $name);
		}

		if ($dependencies === [])
		{
			return null;
		}

		$this->bucket->set("dependencies.{$guid}", $dependencies);

		return $dependencies;
	}

	/**
	 * Retrieves the alias form linked service provider.
	 *
	 * @param string   $guid         The global unique id of the power
	 * @param string   $className    The current class name
	 *
	 * @return string|null Returns the alias if found, otherwise returns null.
	 * @since 3.2.0
	 */
	private function getAliasFromServiceProvider(string $guid, string $className): ?string
	{
		if (($power = $this->power($guid)) === null || empty($power->main_class_code))
		{
			return null;
		}

		$code = $this->parser->code($power->main_class_code);

		if (empty($code['methods']))
		{
			return null;
		}

		$method = null;

		foreach ($code['methods'] as $_method)
		{
			if ($_method['name'] === 'register' && strlen($_method['body']) > 5)
			{
				$method = $_method['body'];
				break;
			}
		}

		if (empty($method))
		{
			return null;
		}

		return $this->getAliasFromRegisterMethod($method, $className);
	}

	/**
	 * Retrieves the alias for a given class from a provided string.
	 *
	 * @param string $content   The string to search.
	 * @param string $className The name of the class whose alias is to be retrieved.
	 *
	 * @return string|null Returns the alias if found, otherwise returns null.
	 * @since 3.2.0
	 */
	private function getAliasFromRegisterMethod(string $content, string $className): ?string
	{

		// Escaping any special characters in the class name to use in regex
		$escapedClassName = preg_quote($className, '/');

		// Regular expression to match the pattern where class name and its alias are specified
		$pattern = "/\\\$container->alias\s*\(\s*{$escapedClassName}::class\s*,\s*['\"](.*?)['\"]\s*\)\s*->/s";

		if (preg_match($pattern, $content, $matches))
		{
			return $matches[1];
		}

		return null;
	}

	/**
	 * Retrieves the alias form linked service provider.
	 *
	 * @param string   $guid         The global unique id of the power
	 *
	 * @return string|null  Returns the alias if found, otherwise returns null.
	 * @since 3.2.0
	 */
	private function getAliasFromPower(string $guid): ?string
	{
		if (($power = $this->power($guid)) === null || empty($power->namespace))
		{
			return null;
		}

		return $this->getAliasFromNamespace($power->namespace);
	}

	/**
	 * Converts the namespace of a power into an class alias
	 *
	 * @param string  $input  The namespaced string to process.
	 *
	 * @return string The modified string.
	 * @since 3.2.0
	 */
	private function getAliasFromNamespace(string $input): string
	{
		// 1. Split on backslash to get the components of the namespace path.
		$parts = explode('\\', $input);

		// 2. Consider only the last part after the final backslash for further processing.
		$lastSegment = end($parts);

		// 3. Get the part after the first dot.
		$target = (strpos($lastSegment, '.') !== false)
		? substr($lastSegment, strpos($lastSegment, '.') + 1)
		: $lastSegment;

		// 4. Split on dots.
		$dotParts = explode('.', $target);

		// 5. Modify segments with camel case words.
		$modifiedDotParts = array_map(function ($part) {
			return preg_replace('/(?<=[a-z])(?=[A-Z])/', '.', $part);
		}, $dotParts);

		// 6. Implode the array with dots and return.
		return implode('.', $modifiedDotParts);
	}

	/**
	 * Get dependency name linked to service provider
	 *
	 * @param string   $serviceProvider    The global unique id of the (service provider) power
	 * @param string   $dependency         The global unique id of the (dependency) power
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	private function getServiceProviderDependencyName(string $serviceProvider, string $dependency): ?string
	{
		if (($power = $this->power($serviceProvider)) === null)
		{
			return null;
		}

		if (empty($power->use_selection) || !is_object($power->use_selection))
		{
			return null;
		}

		foreach ($power->use_selection as $use_selection)
		{
			if ($use_selection->use !== $dependency)
			{
				continue;
			}

			if (($name = $this->name($use_selection->use, $use_selection->as)) === null)
			{
				continue;
			}

			return $name;
		}

		return null;
	}
}

