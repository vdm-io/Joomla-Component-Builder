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

namespace VDM\Joomla\Componentbuilder\Extrusion\Interfaces;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;


/**
 * The single entry point that consumes a component source tree into JCB.
 * 
 * The implementation is resolved from the container and configured fluently, so
 * a caller never constructs a request object. Calling reset is the run
 * boundary: it clears the configuration and every registry, so two runs in one
 * request cannot leak state into each other.
 * 
 * @since 6.1.6
 */
interface ExtruderInterface
{
	/**
	 * Clear the configuration and every registry, starting a fresh run.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function reset(): self;

	/**
	 * Set the component source root to consume.
	 *
	 * @param   string  $path  Absolute path to the component source root.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function path(string $path): self;

	/**
	 * Supply a schema dump as text instead of pointing at a folder.
	 *
	 * @param   string  $sql  The schema text.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function dump(string $sql): self;

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
	 * Everything the run has to say, ready for a caller to present.
	 *
	 * @return  array<string, array<int, array{message: string, subject?: string}>>  The messages by level.
	 * @since   6.1.6
	 */
	public function messages(): array;

	/**
	 * Run the extrusion and return its report.
	 *
	 * @return  Report  What was found, resolved, written, and skipped.
	 * @since   6.1.6
	 */
	public function extrude(): Report;
}

