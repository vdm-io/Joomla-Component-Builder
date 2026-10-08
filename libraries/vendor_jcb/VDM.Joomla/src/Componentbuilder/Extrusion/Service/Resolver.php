<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Assembler;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Condition;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Commit;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Diff;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\FieldXml;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Fieldtype;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Candidates;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Constants;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Placeholder;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Actions;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Pairing;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Reuse;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Language as LanguageResolver;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Precedence;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Prefix;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Record;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Relation;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Role;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Sharing;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Standing;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Tab;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Text;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\ViewName;


/**
 * Extrusion Resolver Service Provider
 * 
 * @since 6.1.6
 */
class Resolver implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	public function register(Container $container)
	{
		$container->alias(Actions::class, 'Extrusion.Resolver.Actions')
			->share('Extrusion.Resolver.Actions', [$this, 'getActions'], true);

		$container->alias(Guid::class, 'Extrusion.Resolver.Guid')
			->share('Extrusion.Resolver.Guid', [$this, 'getGuid'], true);

		$container->alias(Text::class, 'Extrusion.Resolver.Text')
			->share('Extrusion.Resolver.Text', [$this, 'getText'], true);

		$container->alias(LanguageResolver::class, 'Extrusion.Resolver.Language')
			->share('Extrusion.Resolver.Language', [$this, 'getLanguage'], true);

		$container->alias(ViewName::class, 'Extrusion.Resolver.ViewName')
			->share('Extrusion.Resolver.ViewName', [$this, 'getViewName'], true);

		$container->alias(Prefix::class, 'Extrusion.Resolver.Prefix')
			->share('Extrusion.Resolver.Prefix', [$this, 'getPrefix'], true);

		$container->alias(Fieldtype::class, 'Extrusion.Resolver.Fieldtype')
			->share('Extrusion.Resolver.Fieldtype', [$this, 'getFieldtype'], true);

		$container->alias(Precedence::class, 'Extrusion.Resolver.Precedence')
			->share('Extrusion.Resolver.Precedence', [$this, 'getPrecedence'], true);

		$container->alias(Role::class, 'Extrusion.Resolver.Role')
			->share('Extrusion.Resolver.Role', [$this, 'getRole'], true);

		$container->alias(Record::class, 'Extrusion.Resolver.Record')
			->share('Extrusion.Resolver.Record', [$this, 'getRecord'], true);

		$container->alias(Standing::class, 'Extrusion.Resolver.Standing')
			->share('Extrusion.Resolver.Standing', [$this, 'getStanding'], true);

		$container->alias(Sharing::class, 'Extrusion.Resolver.Sharing')
			->share('Extrusion.Resolver.Sharing', [$this, 'getSharing'], true);

		$container->alias(Diff::class, 'Extrusion.Resolver.Diff')
			->share('Extrusion.Resolver.Diff', [$this, 'getDiff'], true);

		$container->alias(Commit::class, 'Extrusion.Resolver.Commit')
			->share('Extrusion.Resolver.Commit', [$this, 'getCommit'], true);

		$container->alias(Delta::class, 'Extrusion.Resolver.Delta')
			->share('Extrusion.Resolver.Delta', [$this, 'getDelta'], true);

		$container->alias(Tab::class, 'Extrusion.Resolver.Tab')
			->share('Extrusion.Resolver.Tab', [$this, 'getTab'], true);

		$container->alias(Condition::class, 'Extrusion.Resolver.Condition')
			->share('Extrusion.Resolver.Condition', [$this, 'getCondition'], true);

		$container->alias(Relation::class, 'Extrusion.Resolver.Relation')
			->share('Extrusion.Resolver.Relation', [$this, 'getRelation'], true);

		$container->alias(Pairing::class, 'Extrusion.Resolver.Pairing')
			->share('Extrusion.Resolver.Pairing', [$this, 'getPairing'], true);

		$container->alias(Candidates::class, 'Extrusion.Resolver.Candidates')
			->share('Extrusion.Resolver.Candidates', [$this, 'getCandidates'], true);

		$container->alias(Reuse::class, 'Extrusion.Resolver.Reuse')
			->share('Extrusion.Resolver.Reuse', [$this, 'getReuse'], true);

		$container->alias(Constants::class, 'Extrusion.Resolver.Constants')
			->share('Extrusion.Resolver.Constants', [$this, 'getConstants'], true);

		$container->alias(Placeholder::class, 'Extrusion.Resolver.Placeholder')
			->share('Extrusion.Resolver.Placeholder', [$this, 'getPlaceholder'], true);

		$container->alias(FieldXml::class, 'Extrusion.Resolver.FieldXml')
			->share('Extrusion.Resolver.FieldXml', [$this, 'getFieldXml'], true);

		$container->alias(Assembler::class, 'Extrusion.Assembler')
			->share('Extrusion.Assembler', [$this, 'getAssembler'], true);
	}

	/**
	 * Get the permission actions resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Actions
	 * @since   6.1.8
	 */
	public function getActions(Container $container): Actions
	{
		return new Actions(
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the identity resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Guid
	 * @since   6.1.6
	 */
	public function getGuid(Container $container): Guid
	{
		return new Guid();
	}

	/**
	 * Get the readable text resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Text
	 * @since   6.1.6
	 */
	public function getText(Container $container): Text
	{
		return new Text();
	}

	/**
	 * Get the language resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LanguageResolver
	 * @since   6.1.6
	 */
	public function getLanguage(Container $container): LanguageResolver
	{
		return new LanguageResolver(
			$container->get('Extrusion.Registry.Language'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Registry.Source')
		);
	}

	/**
	 * Get the view name resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewName
	 * @since   6.1.6
	 */
	public function getViewName(Container $container): ViewName
	{
		return new ViewName(
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Text')
		);
	}

	/**
	 * Get the table-name prefix resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Prefix
	 * @since   6.1.6
	 */
	public function getPrefix(Container $container): Prefix
	{
		return new Prefix(
			$container->get('Extrusion.Registry.Schema'),
			$container->get('Extrusion.Registry.Table'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the field type resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Fieldtype
	 * @since   6.1.6
	 */
	public function getFieldtype(Container $container): Fieldtype
	{
		return new Fieldtype(
			$container->get('Load'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the precedence engine.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Precedence
	 * @since   6.1.6
	 */
	public function getPrecedence(Container $container): Precedence
	{
		return new Precedence(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Table'),
			$container->get('Extrusion.Registry.Schema'),
			$container->get('Extrusion.Registry.Form'),
			$container->get('Extrusion.Resolver.Language'),
			$container->get('Extrusion.Resolver.Text'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the display role resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Role
	 * @since   6.1.6
	 */
	public function getRole(Container $container): Role
	{
		return new Role(
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the record resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Record
	 * @since   6.1.9
	 */
	public function getRecord(Container $container): Record
	{
		return new Record(
			$container->get('Extrusion.Resolver.Fieldtype'),
			$container->get('Extrusion.Resolver.FieldXml'),
			$container->get('Table')
		);
	}

	/**
	 * Get the standing recognition resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Standing
	 * @since   6.1.9
	 */
	public function getStanding(Container $container): Standing
	{
		return new Standing(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Candidates'),
			$container->get('Extrusion.Resolver.Record'),
			$container->get('Extrusion.Resolver.Guid')
		);
	}

	/**
	 * Get the sharing resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Sharing
	 * @since   6.1.9
	 */
	public function getSharing(Container $container): Sharing
	{
		return new Sharing(
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Pairing'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Resolver.FieldXml'),
			$container->get('Extrusion.Resolver.Standing'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the tab resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Tab
	 * @since   6.1.6
	 */
	public function getTab(Container $container): Tab
	{
		return new Tab(
			$container->get('Extrusion.Registry.Form'),
			$container->get('Extrusion.Resolver.Language'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Registry.Source')
		);
	}

	/**
	 * Get the condition resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Condition
	 * @since   6.1.6
	 */
	public function getCondition(Container $container): Condition
	{
		return new Condition(
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the relationship resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Relation
	 * @since   6.1.6
	 */
	public function getRelation(Container $container): Relation
	{
		return new Relation(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Resolver.ViewName'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the field XML composer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldXml
	 * @since   6.1.6
	 */
	public function getFieldXml(Container $container): FieldXml
	{
		return new FieldXml(
			$container->get('Extrusion.Resolver.Fieldtype'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the resolution assembler.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Assembler
	 * @since   6.1.6
	 */
	public function getAssembler(Container $container): Assembler
	{
		return new Assembler(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Schema'),
			$container->get('Extrusion.Registry.Table'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Precedence'),
			$container->get('Extrusion.Resolver.ViewName'),
			$container->get('Extrusion.Resolver.Role'),
			$container->get('Extrusion.Resolver.Tab'),
			$container->get('Extrusion.Resolver.Condition'),
			$container->get('Extrusion.Resolver.Relation'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Language')
		);
	}

	/**
	 * Get the Constants Resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Constants
	 * @since   6.1.8
	 */
	public function getConstants(Container $container): Constants
	{
		return new Constants(
			$container->get('Extrusion.Resolver.Language'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Placeholder Resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Placeholder
	 * @since   6.2.0
	 */
	public function getPlaceholder(Container $container): Placeholder
	{
		return new Placeholder(
			$container->get('Extrusion.Powers.Resolver.Placeholders')
		);
	}

	/**
	 * Get the Reuse Resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Reuse
	 * @since   6.1.8
	 */
	public function getReuse(Container $container): Reuse
	{
		return new Reuse(
			$container->get('Extrusion.Resolver.Candidates'),
			$container->get('Extrusion.Resolver.Pairing'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Config')
		);
	}

	/**
	 * Get the Pairing Resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Pairing
	 * @since   6.1.7
	 */
	public function getPairing(Container $container): Pairing
	{
		return new Pairing(
			$container->get('Extrusion.Registry.Decision'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Candidates Resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Candidates
	 * @since   6.1.7
	 */
	public function getCandidates(Container $container): Candidates
	{
		return new Candidates(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.View'),
			$container->get('Load'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Powers.Resolver.References')
		);
	}

	/**
	 * Get the diff resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Diff
	 * @since   6.2.0
	 */
	public function getDiff(Container $container): Diff
	{
		return new Diff();
	}

	/**
	 * Get the delta resolver.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Delta
	 * @since   6.2.0
	 */
	public function getDelta(Container $container): Delta
	{
		return new Delta(
			$container->get('Data.Item'),
			$container->get('Table'),
			$container->get('Extrusion.Resolver.Diff'),
			$container->get('Extrusion.Registry.Proposal'),
			$container->get('Extrusion.Powers.Resolver.Placeholders'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Registry.Plan')
		);
	}

	/**
	 * Get the validated operation commit boundary.
	 *
	 * @param   Container  $container  The service container.
	 *
	 * @return  Commit  The shared commit service.
	 * @since   6.2.0
	 */
	public function getCommit(Container $container): Commit
	{
		return new Commit(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Plan'),
			$container->get('Data.Item'),
			$container->get('Joomla.Database'),
			$container->get('Extrusion.Powers.Resolver.Identity'),
			$container->get('Extrusion.Registry.Harvest'),
			$container->get('Extrusion.Registry.Decision'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Scanner')
		);
	}
}

