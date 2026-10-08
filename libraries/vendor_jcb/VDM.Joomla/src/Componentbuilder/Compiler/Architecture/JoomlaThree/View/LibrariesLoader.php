<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\View;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\LibrariesLoader as SharedLibrariesLoader;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Joomla 3 View Libraries Loader Class.
 * 
 * A Joomla 3 view has no autoloader to find the header checker with, so the
 * file is required from where the build target put it and the class is named
 * after the component.
 * 
 * @since  6.1.7
 */
final class LibrariesLoader extends SharedLibrariesLoader
{
	/**
	 * Build the statements that make the header checker available.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	protected function headerChecker(): string
	{
		if ($this->config->build_target === 'site')
		{
			$setter = PHP_EOL . Indent::_(2)
				. "require_once( JPATH_SITE . '/components/com_" . $this->config->component_code_name . "/helpers/headercheck.php' );";
		}
		else
		{
			$setter = PHP_EOL . Indent::_(2)
				. "require_once( JPATH_ADMINISTRATOR . '/components/com_" . $this->config->component_code_name . "/helpers/headercheck.php' );";
		}
		$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Initialize the header checker.";
		$setter .= PHP_EOL . Indent::_(2) . "\$HeaderCheck = new "
			. $this->config->component_code_name . "HeaderCheck();";

		return $setter;
	}
}

