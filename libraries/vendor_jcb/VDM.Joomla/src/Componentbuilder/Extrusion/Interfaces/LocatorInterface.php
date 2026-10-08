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
 * Finds one kind of source artifact inside a component source tree.
 * 
 * A locator never interprets what it finds. It records located paths and the
 * discovery tier that produced them, so a low confidence match stays visible.
 * 
 * @since 6.1.6
 */
interface LocatorInterface
{
	/**
	 * The artifact kind this locator is responsible for.
	 *
	 * @return  string  The artifact kind key.
	 * @since   6.1.6
	 */
	public function kind(): string;

	/**
	 * Locate every artifact of this kind below a source root.
	 *
	 * @param   string  $root  The absolute, contained source root.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  Located artifacts.
	 * @since   6.1.6
	 */
	public function locate(string $root): array;
}

