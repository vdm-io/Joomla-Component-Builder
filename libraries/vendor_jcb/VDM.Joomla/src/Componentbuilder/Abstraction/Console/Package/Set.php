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

namespace VDM\Joomla\Componentbuilder\Abstraction\Console\Package;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VDM\Joomla\Componentbuilder\Package\Builder\Set as Superpower;
use VDM\Joomla\Componentbuilder\Abstraction\Console\Package;


/**
 * Base class for SET-direction package builder CLI commands.
 * 
 * This class provides the shared runtime setup for all commands that
 * push local entities and their dependencies to a remote package repository.
 * 
 * Responsibilities:
 * - Extends the common CLI base infrastructure.
 * - Initializes the Package Builder SET service.
 * - Initializes the MessageBus for collecting runtime feedback.
 * - Provides a stable foundation for push-oriented commands.
 * 
 * The SET service performs synchronous remote operations. While the
 * underlying methods return void, execution blocks until all items,
 * dependencies, files, and folders have been fully processed.
 * 
 * Runtime feedback (success, warning, error messages) is collected via
 * the MessageBus during execution and is intended to be rendered by
 * concrete command implementations.
 * 
 * This class does not implement any execution logic itself. Concrete
 * commands (such as Push commands) are responsible for:
 * - Resolving and validating input items.
 * - Invoking SET operations on the builder.
 * - Rendering MessageBus output to the CLI.
 * 
 * @since  5.1.4
 */
abstract class Set extends Package
{
	/**
	 * The Set service.
	 *
	 * @var   Superpower|null
	 * @since 5.1.4
	 */
	protected ?Superpower $set = null;

	/**
	 * Get the main super power SET class
	 *
	 * @return Superpower
	 * @since  5.1.4
	 *
	 * @throws \InvalidArgumentException  If the entity is missing or its factory cannot be resolved.
	 * @throws \RuntimeException          If required services cannot be created from the factory.
	 */
	protected function set(): Superpower
	{
		if ($this->set !== null)
		{
			return $this->set;
		}

		$this->set = $this->getEntityClass('Package.Builder.Set');

		if ($this->set === null)
		{
			throw new \RuntimeException(
				'Failed to initialize builder set class.'
			);
		}

		return $this->set;
	}
}

