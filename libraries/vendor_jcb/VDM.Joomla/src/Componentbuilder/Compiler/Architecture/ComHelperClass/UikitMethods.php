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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\ComHelperClass;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Component Helper Class UIkit Methods Class.
 * 
 * Generates the component helper's UIkit component map and the
 * `getUikitComp()` detection method used when the component ships with
 * UIkit version 2 support.
 * 
 * @since  6.1.7
 */
final class UikitMethods
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
	 * @param Config   $config   The Config Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Get the helper UIkit method code.
	 *
	 * When the component does not use UIkit version 2 (or the version 1
	 * compatibility switch) an empty string is returned.
	 *
	 * @return  string  The generated helper methods, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		// only load for uikit version 2
		if (2 == $this->config->uikit || 1 == $this->config->uikit)
		{
			// build uikit get method
			$ukit   = [];
			$ukit[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$ukit[] = Indent::_(1) . " *  UIKIT Component Classes";
			$ukit[] = Indent::_(1) . " **/";
			$ukit[] = Indent::_(1) . "public static \$uk_components = array(";
			$ukit[] = Indent::_(3) . "'data-uk-grid' => array(";
			$ukit[] = Indent::_(4) . "'grid' ),";
			$ukit[] = Indent::_(3) . "'uk-accordion' => array(";
			$ukit[] = Indent::_(4) . "'accordion' ),";
			$ukit[] = Indent::_(3) . "'uk-autocomplete' => array(";
			$ukit[] = Indent::_(4) . "'autocomplete' ),";
			$ukit[] = Indent::_(3) . "'data-uk-datepicker' => array(";
			$ukit[] = Indent::_(4) . "'datepicker' ),";
			$ukit[] = Indent::_(3) . "'uk-form-password' => array(";
			$ukit[] = Indent::_(4) . "'form-password' ),";
			$ukit[] = Indent::_(3) . "'uk-form-select' => array(";
			$ukit[] = Indent::_(4) . "'form-select' ),";
			$ukit[] = Indent::_(3) . "'data-uk-htmleditor' => array(";
			$ukit[] = Indent::_(4) . "'htmleditor' ),";
			$ukit[] = Indent::_(3) . "'data-uk-lightbox' => array(";
			$ukit[] = Indent::_(4) . "'lightbox' ),";
			$ukit[] = Indent::_(3) . "'uk-nestable' => array(";
			$ukit[] = Indent::_(4) . "'nestable' ),";
			$ukit[] = Indent::_(3) . "'UIkit.notify' => array(";
			$ukit[] = Indent::_(4) . "'notify' ),";
			$ukit[] = Indent::_(3) . "'data-uk-parallax' => array(";
			$ukit[] = Indent::_(4) . "'parallax' ),";
			$ukit[] = Indent::_(3) . "'uk-search' => array(";
			$ukit[] = Indent::_(4) . "'search' ),";
			$ukit[] = Indent::_(3) . "'uk-slider' => array(";
			$ukit[] = Indent::_(4) . "'slider' ),";
			$ukit[] = Indent::_(3) . "'uk-slideset' => array(";
			$ukit[] = Indent::_(4) . "'slideset' ),";
			$ukit[] = Indent::_(3) . "'uk-slideshow' => array(";
			$ukit[] = Indent::_(4) . "'slideshow',";
			$ukit[] = Indent::_(4) . "'slideshow-fx' ),";
			$ukit[] = Indent::_(3) . "'uk-sortable' => array(";
			$ukit[] = Indent::_(4) . "'sortable' ),";
			$ukit[] = Indent::_(3) . "'data-uk-sticky' => array(";
			$ukit[] = Indent::_(4) . "'sticky' ),";
			$ukit[] = Indent::_(3) . "'data-uk-timepicker' => array(";
			$ukit[] = Indent::_(4) . "'timepicker' ),";
			$ukit[] = Indent::_(3) . "'data-uk-tooltip' => array(";
			$ukit[] = Indent::_(4) . "'tooltip' ),";
			$ukit[] = Indent::_(3) . "'uk-placeholder' => array(";
			$ukit[] = Indent::_(4) . "'placeholder' ),";
			$ukit[] = Indent::_(3) . "'uk-dotnav' => array(";
			$ukit[] = Indent::_(4) . "'dotnav' ),";
			$ukit[] = Indent::_(3) . "'uk-slidenav' => array(";
			$ukit[] = Indent::_(4) . "'slidenav' ),";
			$ukit[] = Indent::_(3) . "'uk-form' => array(";
			$ukit[] = Indent::_(4) . "'form-advanced' ),";
			$ukit[] = Indent::_(3) . "'uk-progress' => array(";
			$ukit[] = Indent::_(4) . "'progress' ),";
			$ukit[] = Indent::_(3) . "'upload-drop' => array(";
			$ukit[] = Indent::_(4) . "'upload', 'form-file' )";
			$ukit[] = Indent::_(3) . ");";
			$ukit[] = PHP_EOL . Indent::_(1) . "/**";
			$ukit[] = Indent::_(1) . " *  Add UIKIT Components";
			$ukit[] = Indent::_(1) . " **/";
			$ukit[] = Indent::_(1) . "public static \$uikit = false;";
			$ukit[] = "";
			$ukit[] = Indent::_(1) . "/**";
			$ukit[] = Indent::_(1) . " *  Get UIKIT Components";
			$ukit[] = Indent::_(1) . " **/";
			$ukit[] = Indent::_(1)
				. "public static function getUikitComp(\$content,\$classes = array())";
			$ukit[] = Indent::_(1) . "{";
			$ukit[] = Indent::_(2)
				. "if (strpos(\$content ?? '','class=\"uk-') !== false)";
			$ukit[] = Indent::_(2) . "{";
			$ukit[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__) . " reset";
			$ukit[] = Indent::_(3) . "\$temp = [];";
			$ukit[] = Indent::_(3)
				. "foreach (self::\$uk_components as \$looking => \$add)";
			$ukit[] = Indent::_(3) . "{";
			$ukit[] = Indent::_(4)
				. "if (strpos(\$content,\$looking) !== false)";
			$ukit[] = Indent::_(4) . "{";
			$ukit[] = Indent::_(5) . "\$temp[] = \$looking;";
			$ukit[] = Indent::_(4) . "}";
			$ukit[] = Indent::_(3) . "}";
			$ukit[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " make sure uikit is loaded to config";
			$ukit[] = Indent::_(3)
				. "if (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = Indent::_(3) . "{";
			$ukit[] = Indent::_(4) . "self::\$uikit = true;";
			$ukit[] = Indent::_(3) . "}";
			$ukit[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " sorter";
			$ukit[] = Indent::_(3) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$temp))";
			$ukit[] = Indent::_(3) . "{";
			$ukit[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " merger";
			$ukit[] = Indent::_(4) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$classes))";
			$ukit[] = Indent::_(4) . "{";
			$ukit[] = Indent::_(5)
				. "\$newTemp = array_merge(\$temp,\$classes);";
			$ukit[] = Indent::_(5) . "\$temp = array_unique(\$newTemp);";
			$ukit[] = Indent::_(4) . "}";
			$ukit[] = Indent::_(4) . "return \$temp;";
			$ukit[] = Indent::_(3) . "}";
			$ukit[] = Indent::_(2) . "}";
			$ukit[] = Indent::_(2) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$classes))";
			$ukit[] = Indent::_(2) . "{";
			$ukit[] = Indent::_(3) . "return \$classes;";
			$ukit[] = Indent::_(2) . "}";
			$ukit[] = Indent::_(2) . "return false;";
			$ukit[] = Indent::_(1) . "}";

			// return the help methods
			return implode(PHP_EOL, $ukit);
		}

		return '';
	}
}

