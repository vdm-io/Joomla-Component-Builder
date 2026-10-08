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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Field;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Field Set Access Control Class.
 * 
 * Builds the access control fieldset a view is given, which decides who may
 * see and change what the view holds.
 * 
 * @since 6.1.7
 */
final class SetAccessControl
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param Config $config The Config Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Build the access control fieldset of a view.
	 *
	 * A view without access control of its own gets nothing.
	 *
	 * @param   string  $view  The single view name.
	 *
	 * @return  string  The fieldset, or nothing when the view has no access control.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view): string
	{
		$access = '';
		if ($view != 'component')
		{
			// set component name
			$component = $this->config->component_code_name;
			// set label
			$label = 'Permissions in relation to this ' . $view;
			// set the access fieldset
			$access = "<!--" . Line::_(__Line__, __Class__)
				. " Access Control Fields. -->";
			$access .= PHP_EOL . Indent::_(1)
				. '<fieldset name="accesscontrol">';
			$access .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Asset Id Field. Type: Hidden (joomla) -->";
			$access .= PHP_EOL . Indent::_(2) . '<field';
			$access .= PHP_EOL . Indent::_(3) . 'name="asset_id"';
			$access .= PHP_EOL . Indent::_(3) . 'type="hidden"';
			$access .= PHP_EOL . Indent::_(3) . 'filter="unset"';
			$access .= PHP_EOL . Indent::_(2) . '/>';
			$access .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Rules Field. Type: Rules (joomla) -->";
			$access .= PHP_EOL . Indent::_(2) . '<field';
			$access .= PHP_EOL . Indent::_(3) . 'name="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'type="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'label="' . $label . '"';
			$access .= PHP_EOL . Indent::_(3) . 'translate_label="false"';
			$access .= PHP_EOL . Indent::_(3) . 'filter="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'validate="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'class="inputbox"';
			$access .= PHP_EOL . Indent::_(3) . 'component="com_' . $component
				. '"';
			$access .= PHP_EOL . Indent::_(3) . 'section="' . $view . '"';
			$access .= PHP_EOL . Indent::_(2) . '/>';
			$access .= PHP_EOL . Indent::_(1) . '</fieldset>';
		}

		// return access field set
		return $access;
	}
}

