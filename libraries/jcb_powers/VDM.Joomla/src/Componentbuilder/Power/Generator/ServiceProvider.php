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


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Power code Generator for the Service Provider of JCB
 * 
 * @since 3.2.0
 */
final class ServiceProvider
{
	/**
	 * The version
	 *
	 * @var    string
	 * @since 3.2.0
	 **/
	protected string $version;

	/**
	 * The register lines
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $registerlines = [];

	/**
	 * The get functions
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $getfunctions = [];

	/**
	 * Get the generated class code
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	public function getCode(): ?string
	{
		if ($this->registerlines === [])
		{
			return null;
		}

		$code = [];

		$code[] = Indent::_(1) . "/**";
		$code[] = Indent::_(1) . " * Registers the service provider with a DI container.";
		$code[] = Indent::_(1) . " *";
		$code[] = Indent::_(1) . " * @param   Container  \$container  The DI container.";
		$code[] = Indent::_(1) . " *";
		$code[] = Indent::_(1) . " * @return  void";
		$code[] = Indent::_(1) . " * @since {$this->version}";
		$code[] = Indent::_(1) . " */";
		$code[] = Indent::_(1) . "public function register(Container \$container)";
		$code[] = Indent::_(1) . "{";
		$code[] = implode(PHP_EOL . PHP_EOL, $this->registerlines);
		$code[] = Indent::_(1) . "}";
		$code[] = PHP_EOL . implode(PHP_EOL . PHP_EOL, $this->getfunctions);

		$this->registerlines = [];
		$this->getfunctions = [];

		return implode(PHP_EOL, $code);
	}

	/**
	 * Set the class since version
	 *
	 * @param string   $version    The variable version format.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setVersion(string $version): void
	{
		$this->version = $version;
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
		$this->registerlines[] = implode(PHP_EOL , [
			$this->getAlias($className, $alias),
			$this->getShare($functionName, $alias)
		]);
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
		$this->getfunctions[] = implode(PHP_EOL , [
			Indent::_(1) . "/**",
			Indent::_(1) . " * $description",
			Indent::_(1) . " *",
			Indent::_(1) . " * @param   Container  \$container  The DI container.",
			Indent::_(1) . " *",
			Indent::_(1) . " * @return  $className",
			Indent::_(1) . " * @since {$this->version}",
			Indent::_(1) . " */",
			Indent::_(1) . "public function $functionName(Container \$container): $className",
			Indent::_(1) . "{",
			$this->getDependencies($className, $dependencies),
			Indent::_(1) . "}"
		]);
	}

	/**
	 * Generates the class alias for the service provider.
	 *
	 * @param string   $className     The variable name in lowerCamelCase format.
	 * @param string   $alias         The variable alias format.
	 *
	 * @return string Generated class alias code.
	 * @since 3.2.0
	 */
	protected function getAlias(string $className, string $alias): string
	{
		return Indent::_(2) . "\$container->alias({$className}::class, '{$alias}')";
	}

	/**
	 * Generates the class share for the service provider.
	 *
	 * @param string   $functionName     The function name in lowerCamelCase format.
	 * @param string   $alias            The variable alias format.
	 *
	 * @return string Generated class share code.
	 * @since 3.2.0
	 */
	protected function getShare(string $functionName, string $alias): string
	{
		return Indent::_(3) . "->share('$alias', [\$this, '$functionName'], true);";
	}

	/**
	 * Generates the class dependencies.
	 *
	 * @param string       $className       The variable name in lowerCamelCase format.
	 * @param array|null   $dependencies    The class dependencies aliases.
	 *
	 * @return string Generated class and its dependencies code if found.
	 * @since 3.2.0
	 */
	protected function getDependencies(string $className, ?array $dependencies = null): string
	{
		$bucket = [];
		if (!empty($dependencies))
		{
			$bucket[] = Indent::_(2) . "return new $className(";
			$bucket[] = Indent::_(3) . "\$container->get('"
				. implode(
					"')," . PHP_EOL . Indent::_(3) . "\$container->get('"
					, $dependencies
				) . "')";
			$bucket[] = Indent::_(2) . ");";
		}
		else
		{
			$bucket[] = Indent::_(2) . "return new $className();";
		}

		return implode(PHP_EOL , $bucket);
	}
}

