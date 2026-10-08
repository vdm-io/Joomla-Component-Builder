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
 * Describes where one Joomla major version places a component's artifacts.
 * 
 * An implementation is the inverse of the compiler's own settings.json move
 * map. It answers "where would this component keep its schema, forms, models,
 * language, templates and layouts", relative to a source root, for every
 * plausible shape of that root.
 * 
 * @since 6.1.6
 */
interface LayoutInterface
{
	/**
	 * The target Joomla major version identity this layout describes.
	 *
	 * @return  string  A version identity such as J3, J4, J5, or J6.
	 * @since   6.1.6
	 */
	public function version(): string;

	/**
	 * Every artifact kind this layout can locate.
	 *
	 * @return  array<string>  The supported artifact kind keys.
	 * @since   6.1.6
	 */
	public function kinds(): array;

	/**
	 * Relative candidate paths for one artifact kind.
	 *
	 * @param   string                $kind    The artifact kind key.
	 * @param   array<string,string>  $tokens  Replacement tokens such as option or view.
	 *
	 * @return  array<string>  Ordered relative candidate paths, most likely first.
	 * @since   6.1.6
	 */
	public function candidates(string $kind, array $tokens = []): array;

	/**
	 * The build root to source root prefix candidates.
	 *
	 * @return  array<string, array<string>>  Build root keyed to its relative prefixes.
	 * @since   6.1.6
	 */
	public function roots(): array;
}

