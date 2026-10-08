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


/**
 * Turns one located source artifact into registry state.
 * 
 * A reader is pure with respect to JCB: it reads a file from the source tree
 * and writes what it understood into a focused registry. It never touches the
 * database and never includes or evaluates a file from the source tree.
 * 
 * @since 6.1.6
 */
interface ReaderInterface
{
	/**
	 * Read one artifact into the reader's registry.
	 *
	 * @param   string       $path  Absolute path to the artifact.
	 * @param   string|null  $name  Optional artifact name, such as a view name.
	 *
	 * @return  bool  True when the artifact was understood and stored.
	 * @since   6.1.6
	 */
	public function read(string $path, ?string $name = null): bool;
}

