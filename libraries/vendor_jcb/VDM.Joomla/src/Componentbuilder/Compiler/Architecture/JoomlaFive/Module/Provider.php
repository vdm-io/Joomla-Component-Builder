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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Builder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\ProviderInterface;


/**
 * Module Provider Class for Joomla 5
 * 
 * @since 5.1.2
 */
final class Provider implements ProviderInterface
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentOne Class.
	 *
	 * @var   Builder
	 * @since 5.1.2
	 */
	protected Builder $builder;

	/**
	 * The Namespace Prefix
	 *
	 * @var    string
	 * @since 5.1.2
	 */
	protected string $NamespacePrefix;

	/**
	 * Constructor.
	 *
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param Builder       $builder       The Content One Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Placeholder $placeholder, Builder $builder)
	{
		$this->placeholder = $placeholder;
		$this->builder = $builder;

		// set some global values
		$this->NamespacePrefix = $this->placeholder->get('NamespacePrefix');
	}

	/**
	 * Get the updated provider for the given module.
	 *
	 * @param  object  $module   The module object containing the necessary data.
	 *
	 * @return string  The provider content.
	 *
	 * @since 5.1.2
	 */
	public function get(object $module): string
	{
		$provider = [];
		$provider[] =  "/**";
		$provider[] = " *" . Line::_(__Line__, __Class__) . " The {$module->official_name} module service provider";
		$provider[] = " *";
		$provider[] = " * @since   5.4.0";
		$provider[] = " */";
		$provider[] = "return new class () implements ServiceProviderInterface {";
		$provider[] = Indent::_(1) . "/**";
		$provider[] = Indent::_(1) . " *" . Line::_(__Line__, __Class__) . " Registers the service provider with a DI container.";
		$provider[] = Indent::_(1) . " *";
		$provider[] = Indent::_(1) . " * @param   Container  \$container  The DI container.";
		$provider[] = Indent::_(1) . " *";
		$provider[] = Indent::_(1) . " * @return  void";
		$provider[] = Indent::_(1) . " * @since   5.4.0";
		$provider[] = Indent::_(1) . " */";
		$provider[] = Indent::_(1) . "public function register(Container \$container)";
		$provider[] = Indent::_(1) . "{";
		$provider[] = Indent::_(2) . "\$container->registerServiceProvider(new ModuleDispatcherFactory('\\\\{$this->NamespacePrefix}\\\\Module\\\\{$module->namespace}'));";
		if ($module->add_class_helper == 1 || $module->custom_get)
		{
			$provider[] = Indent::_(2) . "\$container->registerServiceProvider(new HelperFactory('\\\\{$this->NamespacePrefix}\\\\Module\\\\{$module->namespace}\\\\{$module->target_client_namespace}\\\\Helper'));";
		}
		$provider[] = '';
		$provider[] = Indent::_(2) . "\$container->registerServiceProvider(new Module());";
		$provider[] = Indent::_(1) . "}";
		$provider[] = "};";

		return $this->placeholder->update(
			implode(PHP_EOL, $provider). PHP_EOL,
			$this->builder->allActive()
		);
	}
}

