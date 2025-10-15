<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Dynamic Get Uikit Loader
 * 
 * @since 5.1.2
 */
final class UikitLoader
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.2
	 */
	protected ContentOne $contentone;

	/**
	 * The load tracker to prevent duplicate UIKit component loading.
	 *
	 * @var   array
	 * @since 5.1.2
	 */
	protected array $loadTracker = [];

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param ContentOne   $contentone   The ContentOne Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, ContentOne $contentone)
	{
		$this->config = $config;
		$this->contentone = $contentone;
	}

	/**
	 * Check if custom view fields contain UIKit components that must be loaded.
	 *
	 * This method iterates through the given checker array, determines whether the
	 * field should have UIKit components loaded based on the selection criteria,
	 * and appends the relevant code for inclusion.
	 *
	 * @param  array   $get      The "get" array containing view configuration data.
	 * @param  array   $checker  The array of fields and their configurations to check.
	 * @param  string  $string   The string variable name or object reference in the generated code.
	 * @param  string  $code     The code identifier used for generating unique load keys.
	 * @param  string  $tab      Optional indentation tab for formatting generated code.
	 *
	 * @return string  The generated PHP code string for UIKit component inclusion.
	 * @since  5.1.2
	 */
	public function get(array $get, array $checker, string $string, string $code, string $tab = ''): string
	{
		if (empty($get) || empty($get['key']) || empty($checker) || empty($string) || empty($code))
		{
			return '';
		}

		$fieldUikit = '';

		foreach ($checker as $field => $array)
		{
			// Build load counter key
			$key = md5($code . $get['key'] . $string . $field);

			// Check if this field needs UIKit components loaded and hasn't been processed
			if (
				strpos((string) $get['selection']['select'], (string) $field) !== false
				&& !isset($this->loadTracker[$key])
			)
			{
				// Mark this field as processed
				$this->loadTracker[$key] = $key;

				// Only load for UIKit version 1 or 2
				if (2 == $this->config->uikit || 1 == $this->config->uikit)
				{
					$fieldUikit .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "//" . Line::_(__LINE__, __CLASS__) . " Checking if "
						. $field . " has UIKit components that must be loaded.";

					$fieldUikit .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$this->uikitComp = "
						. $this->contentone->get('Component')
						. "Helper::getUikitComp(" . $string . "->" . $field . ",\$this->uikitComp);";
				}
			}
		}

		return $fieldUikit;
	}

	/**
	 * Build and return the PHP method definition for retrieving the UIkit components.
	 *
	 * This method dynamically generates the source code for a `getUikitComp()` method
	 * if the configured UIkit version is either `1` or `2`. The generated method
	 * checks if the `$this->uikitComp` property is set and valid, and returns it;
	 * otherwise, it returns `false`.
	 *
	 * @return string  The generated PHP code for the `getUikitComp()` method, or an
	 *                 empty string if the UIkit version is not 1 or 2.
	 * @since  5.1.2
	 */
	public function getUikitComp(): string
	{
		$method = '';
		// only load for uikit version 2
		if (2 == $this->config->uikit || 1 == $this->config->uikit)
		{
			// build uikit get method
			$method .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$method .= PHP_EOL . Indent::_(1)
				. " * Get the uikit needed components";
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1)
				. " * @return mixed  An array of objects on success.";
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1) . " */";
			$method .= PHP_EOL . Indent::_(1)
				. "public function getUikitComp()";
			$method .= PHP_EOL . Indent::_(1) . "{";
			$method .= PHP_EOL . Indent::_(2)
				. "if (isset(\$this->uikitComp) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->uikitComp))";
			$method .= PHP_EOL . Indent::_(2) . "{";
			$method .= PHP_EOL . Indent::_(3) . "return \$this->uikitComp;";
			$method .= PHP_EOL . Indent::_(2) . "}";
			$method .= PHP_EOL . Indent::_(2) . "return false;";
			$method .= PHP_EOL . Indent::_(1) . "}";
		}

		return $method;
	}
}

