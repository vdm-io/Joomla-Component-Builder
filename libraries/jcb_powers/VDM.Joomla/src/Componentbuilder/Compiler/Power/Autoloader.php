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

namespace VDM\Joomla\Componentbuilder\Compiler\Power;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Content;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Compiler Autoloader
 * 
 * @since 3.2.0
 */
class Autoloader
{
	/**
	 * Power Objects
	 *
	 * @var    Power
	 * @since 3.2.0
	 **/
	protected Power $power;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Compiler Content
	 *
	 * @var    Content
	 * @since 3.2.0
	 **/
	protected Content $content;

	/**
	 * Constructor.
	 *
	 * @param Power|null       $power      The power object.
	 * @param Config|null      $config     The compiler config object.
	 * @param Content|null     $content    The compiler content object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Power $power = null, ?Config $config = null, ?Content $content = null)
	{
		$this->power = $power ?: Compiler::_('Power');
		$this->config = $config ?: Compiler::_('Config');
		$this->content = $content ?: Compiler::_('Content');

		// reset all autoloaders power placeholders
		$this->content->set('ADMIN_POWER_HELPER', '');
		$this->content->set('SITE_POWER_HELPER', '');
		$this->content->set('CUSTOM_POWER_AUTOLOADER', '');
	}

	/**
	 * Set the autoloader into the active content array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function set()
	{
		if (($size = ArrayHelper::check($this->power->namespace)) > 0)
		{
			// set if we should load the autoloader on the site area
			$loadSite = (!$this->config->remove_site_folder || !$this->config->remove_site_edit_folder);

			// check if we are using a plugin
			$use_plugin = $this->content->exist('PLUGIN_POWER_AUTOLOADER');

			// build the methods
			$autoload_not_site_method = [];
			$autoload_method = [];

			// add only if we are not using a plugin
			$tab_space = 2;
			if (!$use_plugin)
			{
				$autoload_not_site_method[] = PHP_EOL . PHP_EOL;
				$tab_space = 0;
			}
			elseif (!$loadSite)
			{
				// we add code to prevent this plugin from triggering on the site area
				$autoload_not_site_method[] = PHP_EOL . Indent::_(2) . '//'
					. Line::_(__Line__, __Class__) . ' do not run the autoloader in the site area';
				$autoload_not_site_method[] = Indent::_(2) . 'if ($this->app->isClient(\'site\'))';
				$autoload_not_site_method[] = Indent::_(2) . '{';
				$autoload_not_site_method[] = Indent::_(3) . 'return;';
				$autoload_not_site_method[] = Indent::_(2) . '}' . PHP_EOL;
			}

			// we start building the spl_autoload_register function call
			$autoload_method[] = Indent::_($tab_space) . '//'
				. Line::_(__Line__, __Class__) . ' register this component namespace';
			$autoload_method[] = Indent::_($tab_space) . 'spl_autoload_register(function ($class) {';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '//'
				. Line::_(__Line__, __Class__) . ' project-specific base directories and namespace prefix';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '$search = [';

			// ==== IMPORTANT NOTICE =====
			// make sure the name space values are sorted from the longest string to the shortest
			// so that the search do not mistakenly match a shorter namespace before a longer one
			// that has the same short namespace for example:
			//      NameSpace\SubName\Sub <- will always match first
			//      NameSpace\SubName\SubSubName
			// Should the shorter namespace be listed [first] it will match both of these:
			//      NameSpace\SubName\Sub\ClassName
			//      ^^^^^^^^^^^^^^^^^^^^^
			//      NameSpace\SubName\SubSubName\ClassName
			//      ^^^^^^^^^^^^^^^^^^^^^

			uksort($this->power->namespace, function ($a, $b) {
				return strlen($b) - strlen($a);
			});

			// counter to manage the comma in the actual array
			$counter = 1;
			foreach ($this->power->namespace as $base_dir => $prefix)
			{
				// don't add the ending comma on last value
				if ($size == $counter)
				{
					$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . "'" . $this->config->get('jcb_powers_path', 'libraries/jcb_powers') . "/$base_dir' => '" . implode('\\\\', $prefix) . "'";
				}
				else
				{
					$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . "'" . $this->config->get('jcb_powers_path', 'libraries/jcb_powers') . "/$base_dir' => '" . implode('\\\\', $prefix) . "',";
				}
				$counter++;
			}
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '];';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '// Start the search and load if found';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '$found = false;';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '$found_base_dir = "";';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '$found_len = 0;';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . 'foreach ($search as $base_dir => $prefix)';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '{';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . '//'
				. Line::_(__Line__, __Class__) . ' does the class use the namespace prefix?';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . '$len = strlen($prefix);';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . 'if (strncmp($prefix, $class, $len) === 0)';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . '{';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(3) . '//'
				. Line::_(__Line__, __Class__) . ' we have a match so load the values';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(3) . '$found = true;';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(3) . '$found_base_dir = $base_dir;';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(3) . '$found_len = $len;';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(3) . '//'
				. Line::_(__Line__, __Class__) . ' done here';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(3) . 'break;';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . '}';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '}';

			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '//'
				. Line::_(__Line__, __Class__) . ' check if we found a match';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . 'if (!$found)';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '{';

			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . '//'
				. Line::_(__Line__, __Class__) . ' not found so move to the next registered autoloader';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . 'return;';

			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '}';

			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '//'
				. Line::_(__Line__, __Class__) . ' get the relative class name';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '$relative_class = substr($class, $found_len);';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '//'
				. Line::_(__Line__, __Class__) . ' replace the namespace prefix with the base directory, replace namespace';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '// separators with directory separators in the relative class name, append';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '// with .php';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . "\$file = JPATH_ROOT . '/' . \$found_base_dir . '/src' . str_replace('\\\\', '/', \$relative_class) . '.php';";
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '//'
				. Line::_(__Line__, __Class__) . ' if the file exists, require it';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . 'if (file_exists($file))';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '{';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(2) . 'require $file;';
			$autoload_method[] = Indent::_($tab_space) . Indent::_(1) . '}';
			$autoload_method[] = Indent::_($tab_space) . '});';

			// add the composer stuff here
			$autoload_composer = '';
			if (ArrayHelper::check($this->power->composer))
			{
				$autoload_composer = $this->getComposer($tab_space);
			}

			// create the method string
			$autoloader = $autoload_composer . implode(PHP_EOL, $autoload_not_site_method) . implode(PHP_EOL, $autoload_method);

			// check if we are using a plugin
			if ($use_plugin)
			{
				$this->content->set('PLUGIN_POWER_AUTOLOADER', PHP_EOL . $autoloader);
			}
			else
			{
				// load to events placeholders
				$this->content->add('ADMIN_POWER_HELPER', $autoloader);
				// load to site if needed
				if ($loadSite)
				{
					$this->content->add('SITE_POWER_HELPER', $autoloader);
				}
			}

			// to add to custom files
			$this->content->add('CUSTOM_POWER_AUTOLOADER', PHP_EOL . implode(PHP_EOL, $autoload_method));
		}
	}

	/**
	 * Get the composer autoloader routine
	 *
	 * @param string    $tabSpace    The dynamic tab spacer
	 *
	 * @return string
	 * @since 3.2.0
	 */
	protected function getComposer(string $tabSpace): string
	{
		// load the composer routine
		$composer_routine = [];

		// counter to manage the comma in the actual array
		$add_once = [];
		foreach ($this->power->composer as $access_point)
		{
			// don't add the ending comma on last value
			if (empty($add_once[$access_point]))
			{
				$composer_routine[] = Indent::_($tabSpace) . "\$composer_autoloader = JPATH_LIBRARIES . '/$access_point';";
				$composer_routine[] = Indent::_($tabSpace) . 'if (file_exists($composer_autoloader))';
				$composer_routine[] = Indent::_($tabSpace) . "{";
				$composer_routine[] = Indent::_($tabSpace) . Indent::_(1) . 'require_once $composer_autoloader;';
				$composer_routine[] = Indent::_($tabSpace) . "}";

				$add_once[$access_point] = true;
			}
		}

		if (count($add_once) == 1)
		{
			array_unshift($composer_routine, PHP_EOL . PHP_EOL . Indent::_($tabSpace) . '//'
				. Line::_(__Line__, __Class__) . ' add the autoloader for the composer classes');
		}
		else
		{
			array_unshift($composer_routine, PHP_EOL . PHP_EOL . Indent::_($tabSpace) . '//'
				. Line::_(__Line__, __Class__) . ' add the autoloaders for the composer classes');
		}

		return implode(PHP_EOL, $composer_routine);
	}

}

