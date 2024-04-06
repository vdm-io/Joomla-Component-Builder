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
use Joomla\CMS\Version;
use VDM\Joomla\Componentbuilder\Compiler\Field as CompilerField;
use VDM\Joomla\Componentbuilder\Compiler\Field\Data;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups;
use VDM\Joomla\Componentbuilder\Compiler\Field\Attributes;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name;
use VDM\Joomla\Componentbuilder\Compiler\Field\TypeName;
use VDM\Joomla\Componentbuilder\Compiler\Field\UniqueName;
use VDM\Joomla\Componentbuilder\Compiler\Field\Rule;
use VDM\Joomla\Componentbuilder\Compiler\Field\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Field\DatabaseName;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaThree\CoreField as J3CoreField;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFour\CoreField as J4CoreField;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFive\CoreField as J5CoreField;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaThree\InputButton as J3InputButton;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFour\InputButton as J4InputButton;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFive\InputButton as J5InputButton;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreFieldInterface as CoreField;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\InputButtonInterface as InputButton;


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
	 * Current Joomla Version We are IN
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected $currentVersion;

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
			->share('Field', [$this, 'getCompilerField'], true);

		$container->alias(Data::class, 'Field.Data')
			->share('Field.Data', [$this, 'getData'], true);

		$container->alias(Groups::class, 'Field.Groups')
			->share('Field.Groups', [$this, 'getGroups'], true);

		$container->alias(Attributes::class, 'Field.Attributes')
			->share('Field.Attributes', [$this, 'getAttributes'], true);

		$container->alias(Name::class, 'Field.Name')
			->share('Field.Name', [$this, 'getName'], true);

		$container->alias(TypeName::class, 'Field.Type.Name')
			->share('Field.Type.Name', [$this, 'getTypeName'], true);

		$container->alias(UniqueName::class, 'Field.Unique.Name')
			->share('Field.Unique.Name', [$this, 'getUniqueName'], true);

		$container->alias(Rule::class, 'Field.Rule')
			->share('Field.Rule', [$this, 'getRule'], true);

		$container->alias(Customcode::class, 'Field.Customcode')
			->share('Field.Customcode', [$this, 'getCustomcode'], true);

		$container->alias(DatabaseName::class, 'Field.Database.Name')
			->share('Field.Database.Name', [$this, 'getDatabaseName'], true);

		$container->alias(J3CoreField::class, 'J3.Field.Core.Field')
			->share('J3.Field.Core.Field', [$this, 'getJ3CoreField'], true);

		$container->alias(J4CoreField::class, 'J4.Field.Core.Field')
			->share('J4.Field.Core.Field', [$this, 'getJ4CoreField'], true);

		$container->alias(J5CoreField::class, 'J5.Field.Core.Field')
			->share('J5.Field.Core.Field', [$this, 'getJ5CoreField'], true);

		$container->alias(J3InputButton::class, 'J3.Field.Input.Button')
			->share('J3.Field.Input.Button', [$this, 'getJ3InputButton'], true);

		$container->alias(J4InputButton::class, 'J4.Field.Input.Button')
			->share('J4.Field.Input.Button', [$this, 'getJ4InputButton'], true);

		$container->alias(J5InputButton::class, 'J5.Field.Input.Button')
			->share('J5.Field.Input.Button', [$this, 'getJ5InputButton'], true);

		$container->alias(CoreField::class, 'Field.Core.Field')
			->share('Field.Core.Field', [$this, 'getCoreField'], true);

		$container->alias(InputButton::class, 'Field.Input.Button')
			->share('Field.Input.Button', [$this, 'getInputButton'], true);
	}

	/**
	 * Get The Field Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerField
	 * @since 3.2.0
	 */
	public function getCompilerField(Container $container): CompilerField
	{
		return new CompilerField(
			$container->get('Field.Data'),
			$container->get('Field.Name'),
			$container->get('Field.Type.Name'),
			$container->get('Field.Unique.Name')
		);
	}

	/**
	 * Get The Data Class.
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
			$container->get('Field.Rule')
		);
	}

	/**
	 * Get The Groups Class.
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
	 * Get The Attributes Class.
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
	 * Get The Name Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Name
	 * @since 3.2.0
	 */
	public function getName(Container $container): Name
	{
		return new Name(
			$container->get('Placeholder'),
			$container->get('Field.Unique.Name'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}

	/**
	 * Get The TypeName Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TypeName
	 * @since 3.2.0
	 */
	public function getTypeName(Container $container): TypeName
	{
		return new TypeName();
	}

	/**
	 * Get The UniqueName Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  UniqueName
	 * @since 3.2.0
	 */
	public function getUniqueName(Container $container): UniqueName
	{
		return new UniqueName(
			$container->get('Registry')
		);
	}

	/**
	 * Get The Rule Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rule
	 * @since 3.2.0
	 */
	public function getRule(Container $container): Rule
	{
		return new Rule(
			$container->get('Registry'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Field.Core.Rule')
		);
	}

	/**
	 * Get The Customcode Class.
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
	 * Get The DatabaseName Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DatabaseName
	 * @since 3.2.0
	 */
	public function getDatabaseName(Container $container): DatabaseName
	{
		return new DatabaseName(
			$container->get('Compiler.Builder.Lists'),
			$container->get('Registry')
		);
	}

	/**
	 * Get The CoreField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3CoreField
	 * @since 3.2.0
	 */
	public function getJ3CoreField(Container $container): J3CoreField
	{
		return new J3CoreField();
	}

	/**
	 * Get The CoreField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4CoreField
	 * @since 3.2.0
	 */
	public function getJ4CoreField(Container $container): J4CoreField
	{
		return new J4CoreField();
	}

	/**
	 * Get The CoreField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5CoreField
	 * @since 3.2.0
	 */
	public function getJ5CoreField(Container $container): J5CoreField
	{
		return new J5CoreField();
	}

	/**
	 * Get The J3InputButton Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3InputButton
	 * @since 3.2.0
	 */
	public function getJ3InputButton(Container $container): J3InputButton
	{
		return new J3InputButton(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The J4InputButton Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4InputButton
	 * @since 3.2.0
	 */
	public function getJ4InputButton(Container $container): J4InputButton
	{
		return new J4InputButton(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The J5InputButton Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5InputButton
	 * @since 3.2.0
	 */
	public function getJ5InputButton(Container $container): J5InputButton
	{
		return new J5InputButton(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The CoreFieldInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CoreField
	 * @since 3.2.0
	 */
	public function getCoreField(Container $container): CoreField
	{
		if (empty($this->currentVersion))
		{
			$this->currentVersion = Version::MAJOR_VERSION;
		}

		return $container->get('J' . $this->currentVersion . '.Field.Core.Field');
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
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('J' . $this->targetVersion . '.Field.Input.Button');
	}
}

