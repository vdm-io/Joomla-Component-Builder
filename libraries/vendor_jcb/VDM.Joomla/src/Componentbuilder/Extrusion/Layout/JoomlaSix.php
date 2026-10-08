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

namespace VDM\Joomla\Componentbuilder\Extrusion\Layout;


use VDM\Joomla\Componentbuilder\Extrusion\Layout\JoomlaFour;


/**
 * Joomla 6 component placement.
 * 
 * The Joomla 6 administrator tree is structurally identical to Joomla 4, so this
 * is a thin version identity over the shared map rather than a second copy of
 * it. The distinct service key is retained so a future divergence has a place
 * to land without touching a consumer.
 * 
 * @since 6.1.6
 */
final class JoomlaSix extends JoomlaFour
{
	/**
	 * The target Joomla major version identity this layout describes.
	 *
	 * @return  string  The version identity.
	 * @since   6.1.6
	 */
	public function version(): string
	{
		return 'J6';
	}
}

