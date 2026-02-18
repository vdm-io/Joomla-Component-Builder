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

namespace VDM\Joomla\Abstraction;


use Joomla\Console\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Console
 * 
 * @since  5.1.4
 */
abstract class Console extends AbstractCommand
{
	/**
	 * Configure the command.
	 *
	 * @return  void
	 *
	 * @since   2.0.0
	 */
	protected function configure(): void
	{
	}

	/**
	 * Internal function to execute the command.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  integer  The command exit code
	 *
	 * @since   2.0.0
	 */
	abstract protected function doExecute(InputInterface $input, OutputInterface $output): int;

	/**
	 * Internal hook to initialise the command after the input has been bound and before the input is validated.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  void
	 *
	 * @since   2.0.0
	 */
	protected function initialise(InputInterface $input, OutputInterface $output): void
	{
	}
}

