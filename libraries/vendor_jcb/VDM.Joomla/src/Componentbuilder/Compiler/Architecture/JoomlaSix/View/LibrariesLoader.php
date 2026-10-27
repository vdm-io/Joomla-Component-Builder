<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    23rd October, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\View;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\LibrariesLoader as SharedLibrariesLoader;


/**
 * Joomla six LibrariesLoader renderer.
 * 
 * @since 6.2.0
 */
final class LibrariesLoader extends SharedLibrariesLoader
{
	/**
	 * Activate Joomla's registered jQuery assets.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	protected function jquery(): string
	{
		return "\$this->getDocument()->getWebAssetManager()->useScript('jquery')->useScript('jquery-noconflict');";
	}
}

