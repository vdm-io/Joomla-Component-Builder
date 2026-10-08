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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminView\FootableScripts as ExtendingFootableScripts;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\FootableScriptsInterface;


/**
 * Admin View Footable Scripts Class for Joomla 3
 * 
 * Joomla 3 has no web asset manager, so an inline script is declared on the
 * document directly.
 * 
 * @since 6.1.7
 */
final class FootableScripts extends ExtendingFootableScripts implements FootableScriptsInterface
{
	/**
	 * Get the call that puts the initialisation script on the document.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getInlineScript(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$this->getDocument()->addScriptDeclaration(\$footable);"
			. PHP_EOL;
	}
}

