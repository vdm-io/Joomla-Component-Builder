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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView;


/**
 * Linked View Builder Interface
 * 
 * @since  6.1.7
 */
interface BuilderInterface
{
	/**
	 * Build one linked view of a parent view.
	 *
	 * @param   array  $args  The linked view definition queued by the edit body.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set($args);
}

