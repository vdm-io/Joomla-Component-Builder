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

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Field as CompilerField;
use VDM\Joomla\Componentbuilder\Compiler\Field\Data;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups;
use VDM\Joomla\Componentbuilder\Compiler\Field\Attributes;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name;
use VDM\Joomla\Componentbuilder\Compiler\Field\TypeName;
use VDM\Joomla\Componentbuilder\Compiler\Field\UniqueName;
use VDM\Joomla\Componentbuilder\Compiler\Field\Validation;
use VDM\Joomla\Componentbuilder\Compiler\Field\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Field\DatabaseName;
use VDM\Joomla\Componentbuilder\Compiler\Field\InputButton;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaThree\CoreValidation as J3CoreValidation;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreValidationInterface;


/**
 * Compiler Field
 * 
 * @since 3.2.0
 */
class Field implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected $targetVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(CompilerField::class, 'Field')
			->share('Field', [$this, 'getField'], true);

		$container->alias(Data::class, 'Field.Data')
			->share('Field.Data', [$this, 'getData'], true);

		$container->alias(Groups::class, 'Field.Groups')
			->share('Field.Groups', [$this, 'getGroups'], true);

		$container->alias(Attributes::class, 'Field.Attributes')
			->share('Field.Attributes', [$this, 'getAttributes'], true);

		$container->alias(Validation::class, 'Field.Validation')
			->share('Field.Validation', [$this, 'getValidation'], true);

		$container->alias(J3CoreValidation::class, 'J3.Field.Core.Validation')
			->share('J3.Field.Core.Validation', [$this, 'getJ3CoreValidation'], true);

		$container->alias(CoreValidationInterface::class, 'Field.Core.Validation')
			->share('Field.Core.Validation', [$this, 'getCoreValidation'], true);

		$container->alias(Customcode::class, 'Field.Customcode')
			->share('Field.Customcode', [$this, 'getCustomcode'], true);

		$container->alias(Name::class, 'Field.Name')
			->share('Field.Name', [$this, 'getFieldName'], true);

		$container->alias(TypeName::class, 'Field.Type.Name')
			->share('Field.Type.Name', [$this, 'getFieldTypeName'], true);

		$container->alias(UniqueName::class, 'Field.Unique.Name')
			->share('Field.Unique.Name', [$this, 'getFieldUniqueName'], true);

		$container->alias(DatabaseName::class, 'Field.Database.Name')
			->share('Field.Database.Name', [$this, 'getFieldDatabaseName'], true);

		$container->alias(InputButton::class, 'Field.Input.Button')
			->share('Field.Input.Button', [$this, 'getInputButton'], true);
	}

	/**
	 * Get the Compiler Field
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerField
	 * @since 3.2.0
	 */
	public function getField(Container $container): CompilerField
	{
		return new CompilerField(
			$container->get('Field.Data'),
			$container->get('Field.Name'),
			$container->get('Field.Type.Name'),
			$container->get('Field.Unique.Name')
		);
	}

	/**
	 * Get the Compiler Field Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Data
	 * @since 3.2.0
	 */
	public function getData(Container $container): Data
	{
		return new Data(
			$container->get('Config'),
			$container->get('Event'),
			$container->get('History'),
			$container->get('Placeholder'),
			$container->get('Customcode'),
			$container->get('Field.Customcode'),
			$container->get('Field.Validation')
		);
	}

	/**
	 * Get the Compiler Field Groups
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Groups
	 * @since 3.2.0
	 */
	public function getGroups(Container $container): Groups
	{
		return new Groups();
	}

	/**
	 * Get the Compiler Field Attributes
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Attributes
	 * @since 3.2.0
	 */
	public function getAttributes(Container $container): Attributes
	{
		return new Attributes(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Compiler.Builder.List.Field.Class'),
			$container->get('Compiler.Builder.Do.Not.Escape'),
			$container->get('Placeholder'),
			$container->get('Customcode'),
			$container->get('Language'),
			$container->get('Field.Groups')
		);
	}

	/**
	 * Get the Compiler Field Validation
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Validation
	 * @since 3.2.0
	 */
	public function getValidation(Container $container): Validation
	{
		return new Validation(
			$container->get('Registry'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Customcode'),
			$container->get('Field.Core.Validation')
		);
	}

	/**
	 * Get the Compiler Field Joomla 3 Validation
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3CoreValidation
	 * @since 3.2.0
	 */
	public function getJ3CoreValidation(Container $container): J3CoreValidation
	{
		return new J3CoreValidation();
	}

	/**
	 * Get the Compiler Field Core Validation
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CoreValidationInterface
	 * @since 3.2.0
	 */
	public function getCoreValidation(Container $container): CoreValidationInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('J' . $this->targetVersion . '.Field.Core.Validation');
	}

	/**
	 * Get the Compiler Field Customcode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Customcode
	 * @since 3.2.0
	 */
	public function getCustomcode(Container $container): Customcode
	{
		return new Customcode(
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get the Compiler Field Name
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Name
	 * @since 3.2.0
	 */
	public function getFieldName(Container $container): Name
	{
		return new Name(
			$container->get('Placeholder'),
			$container->get('Field.Unique.Name'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}

	/**
	 * Get the Compiler Field Type Name
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TypeName
	 * @since 3.2.0
	 */
	public function getFieldTypeName(Container $container): TypeName
	{
		return new TypeName();
	}

	/**
	 * Get the Compiler Field Unique Name
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  UniqueName
	 * @since 3.2.0
	 */
	public function getFieldUniqueName(Container $container): UniqueName
	{
		return new UniqueName(
			$container->get('Registry')
		);
	}

	/**
	 * Get the Compiler Field Database Name
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DatabaseName
	 * @since 3.2.0
	 */
	public function getFieldDatabaseName(Container $container): DatabaseName
	{
		return new DatabaseName(
			$container->get('Compiler.Builder.Lists'),
			$container->get('Registry')
		);
	}

	/**
	 * Get The InputButton Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  InputButton
	 * @since 3.2.0
	 */
	public function getInputButton(Container $container): InputButton
	{
		return new InputButton(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Creator.Permission')
		);
	}
}

