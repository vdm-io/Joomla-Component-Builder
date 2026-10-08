<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    15th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Menu;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Menu\CustomView as ExtendingCustomView;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Menu\CustomViewInterface;


/**
 * Custom View Menu Class for Joomla 3.
 * 
 * @since  6.1.7
 */
final class CustomView extends ExtendingCustomView implements CustomViewInterface
{
	/**
	 * Get the fieldset rule and field lookup attributes.
	 *
	 * Joomla 3 uses administrator model rule and field paths.
	 *
	 * @param   string  $targetArea  The application area of the build target.
	 *
	 * @return  string  The fieldset lookup attribute XML.
	 *
	 * @since   6.1.7
	 */
	protected function getPathAttributes(string $targetArea): string
	{
		$xml = PHP_EOL . Indent::_(3)
			. 'addrulepath="/administrator/components/com_'
			. $this->config->component_code_name . '/models/rules"';
		$xml .= PHP_EOL . Indent::_(3)
			. 'addfieldpath="/administrator/components/com_'
			. $this->config->component_code_name . '/models/fields">';

		return $xml;
	}
}

