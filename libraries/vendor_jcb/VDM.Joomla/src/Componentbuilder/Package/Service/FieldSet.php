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

namespace VDM\Joomla\Componentbuilder\Package\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\Field\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\Field\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Package\ValidationRule\Readme\Item as ValidationRuleItemReadme;
use VDM\Joomla\Componentbuilder\Package\ValidationRule\Readme\Main as ValidationRuleMainReadme;


/**
 * Field Service Set Provider
 * 
 * @since 5.1.1
 */
class FieldSet implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	public function register(Container $container)
	{

/// MAIN ENTITY //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('Field.Resolver', [$this, 'getResolver'], true);
		$container->share('Field.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('Field.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('Field.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('ValidationRule.Resolver', [$this, 'getValidationRuleResolver'], true);
		$container->share('ValidationRule.Remote.Set', [$this, 'getValidationRuleRemoteSet'], true);
		$container->share('ValidationRule.Readme.Item', [$this, 'getValidationRuleItemReadme'], true);
		$container->share('ValidationRule.Readme.Main', [$this, 'getValidationRuleMainReadme'], true);
	}

/// MAIN ENTITY //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Get The Resolver Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resolver
	 * @since 5.1.1
	 */
	public function getResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('Field.Remote.Config'),
			$container->get('Utilities.Normalize'),
			$container->get('Package.Tracker'),
			$container->get('Power.Table'),
			$container->get('Load'),
			$container->get('Data.Items')
		);
	}

	/**
	 * Get The Remote Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since   5.1.1
	 */
	public function getRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('Field.Grep'),
			$container->get('Field.Resolver'),
			$container->get('Field.Remote.Config'),
			$container->get('Field.Readme.Item'),
			$container->get('Field.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Item Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemReadme
	 * @since   5.1.1
	 */
	public function getItemReadme(Container $container): ItemReadme
	{
		return new ItemReadme();
	}

	/**
	 * Get The Main Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MainReadme
	 * @since   5.1.1
	 */
	public function getMainReadme(Container $container): MainReadme
	{
		return new MainReadme();
	}

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Get The Resolver Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resolver
	 * @since 5.1.4
	 */
	public function getValidationRuleResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ValidationRule.Remote.Config'),
			$container->get('Utilities.Normalize'),
			$container->get('Package.Tracker'),
			$container->get('Power.Table'),
			$container->get('Load'),
			$container->get('Data.Items')
		);
	}

	/**
	 * Get The Remote Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since   5.1.4
	 */
	public function getValidationRuleRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ValidationRule.Grep'),
			$container->get('ValidationRule.Resolver'),
			$container->get('ValidationRule.Remote.Config'),
			$container->get('ValidationRule.Readme.Item'),
			$container->get('ValidationRule.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Item Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemReadme
	 * @since   5.1.4
	 */
	public function getValidationRuleItemReadme(Container $container): ValidationRuleItemReadme
	{
		return new ValidationRuleItemReadme();
	}

	/**
	 * Get The Main Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ValidationRuleMainReadme
	 * @since   5.1.4
	 */
	public function getValidationRuleMainReadme(Container $container): ValidationRuleMainReadme
	{
		return new ValidationRuleMainReadme();
	}
}

