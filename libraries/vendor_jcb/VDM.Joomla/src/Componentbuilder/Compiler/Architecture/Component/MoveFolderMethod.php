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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\MoveFolderMethodInterface;


/**
 * Component Move Folder Method Class.
 * 
 * Builds the method the install script runs to copy the folders a component
 * was built to carry into the places it wants them.
 * 
 * How the installer is reached, and how a failure is reported, are what the
 * compile target decides, and they are the two extension points below.
 * 
 * @since 6.1.7
 */
class MoveFolderMethod implements MoveFolderMethodInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Compiler Registry Class.
	 *
	 * @var   Registry
	 * @since 6.1.7
	 */
	protected Registry $registry;

	/**
	 * Constructor.
	 *
	 * @param Config   $config   The Config Class.
	 * @param Registry $registry The Compiler Registry Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Registry $registry)
	{
		$this->config = $config;
		$this->registry = $registry;
	}

	/**
	 * Build the folder moving method the install script calls.
	 *
	 * Only a component that was found to have folders to move gets one.
	 *
	 * @return  string  The method, or nothing when there are no folders to move.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		if ($this->registry->get('set_move_folders_install_script'))
		{
			// reset script
			$script   = [];
			$script = array_merge($script, $this->opening());

			$script[] = Indent::_(2)
				. "\$installPath = \$installer->getPath('source');";
			$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get all the folders";
			$script[] = Indent::_(2)
				. "\$folders = Folder::folders(\$installPath);";
			$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if we have folders we may want to copy";
			$script[] = Indent::_(2)
				. "\$doNotCopy = ['media','admin','site']; // Joomla already deals with these";
			$script[] = Indent::_(2) . "if (count((array) \$folders) > 1)";
			$script[] = Indent::_(2) . "{";
			$script[] = Indent::_(3) . "foreach (\$folders as \$folder)";
			$script[] = Indent::_(3) . "{";
			$script[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Only copy if not a standard folders";
			$script[] = Indent::_(4) . "if (!in_array(\$folder, \$doNotCopy))";
			$script[] = Indent::_(4) . "{";
			$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " set the source path";
			$script[] = Indent::_(5) . "\$src = \$installPath.'/'.\$folder;";
			$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " set the destination path";
			$script[] = Indent::_(5) . "\$dest = JPATH_ROOT.'/'.\$folder;";
			$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " now try to copy the folder";
			$script[] = Indent::_(5)
				. "if (!Folder::copy(\$src, \$dest, '', true))";
			$script[] = Indent::_(5) . "{";

			$script[] = $this->failureMessage();

			$script[] = Indent::_(5) . "}";
			$script[] = Indent::_(4) . "}";
			$script[] = Indent::_(3) . "}";
			$script[] = Indent::_(2) . "}";
			$script[] = Indent::_(1) . "}";

			// done
			return PHP_EOL . PHP_EOL . implode(PHP_EOL, $script);
		}

		return '';
	}
	/**
	 * The lines the generated method opens with.
	 *
	 * @return  array  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function opening(): array
	{
		$lines = [];
$lines[] = Indent::_(1) . "/**";
$lines[] = Indent::_(1)
	. " * Method to move folders into place.";
$lines[] = Indent::_(1) . " *";
$lines[] = Indent::_(1) . " * @param   InstallerAdapter  \$adapter  The adapter calling this method";
$lines[] = Indent::_(1) . " *";
$lines[] = Indent::_(1) . " * @return void";
$lines[] = Indent::_(1) . " * @since 4.4.2";
$lines[] = Indent::_(1) . " */";
$lines[] = Indent::_(1)
	. "protected function moveFolders(InstallerAdapter \$adapter): void";
$lines[] = Indent::_(1) . "{";
$lines[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
	. " get the installation path";
$lines[] = Indent::_(2) . "\$installer = \$adapter->getParent();";

		return $lines;
	}

	/**
	 * The line the generated method reports a failed copy with.
	 *
	 * @return  string  The line.
	 *
	 * @since   6.1.7
	 */
	protected function failureMessage(): string
	{
		return Indent::_(6)
. "\$this->app->enqueueMessage('Could not copy '.\$folder.' folder into place, please make sure destination is writable!', 'error');";
	}
}

