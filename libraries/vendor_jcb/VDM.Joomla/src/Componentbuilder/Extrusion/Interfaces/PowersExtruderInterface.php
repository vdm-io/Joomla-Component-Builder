<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    22nd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Interfaces;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;


/**
 * The Powers Extrusion Entry Contract
 * 
 * The two-step pipeline that consumes PHP library classes into JCB powers:
 * harvest first, so a caller can present what was found and collect approval,
 * then extrude what was approved.
 * 
 * @since 6.1.7
 */
interface PowersExtruderInterface
{
	/**
	 * Clear the configuration and every registry, starting a fresh run.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function reset(): self;

	/**
	 * Add one library folder to harvest classes from.
	 *
	 * @param   string  $path  Absolute path to the library folder.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function library(string $path): self;

	/**
	 * Set the JCB component whose namespace placeholders apply.
	 *
	 * @param   int  $id  The component id, or zero for none.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function component(int $id): self;

	/**
	 * Restrict the operation to namespace repairs of identified existing Powers.
	 *
	 * @param   bool  $repair  Whether to enable namespace-only repair.
	 *
	 * @return  self  For method chaining.
	 * @since   6.2.2
	 */
	public function repairNamespaces(bool $repair = true): self;

	/**
	 * Harvest every class the library folders hold, without writing anything.
	 *
	 * @return  Report  What was found, and what each candidate would become.
	 * @since   6.1.7
	 */
	public function harvest(): Report;

	/**
	 * Extrude the harvested classes into JCB powers.
	 *
	 * @return  Report  What was found, resolved, written, and skipped.
	 * @since   6.1.7
	 */
	public function extrude(): Report;

	/**
	 * Everything the run has to say, ready for a caller to present.
	 *
	 * @return  array<string, array<int, array{message: string, subject?: string}>>  The messages by level.
	 * @since   6.1.7
	 */
	public function messages(): array;
}

