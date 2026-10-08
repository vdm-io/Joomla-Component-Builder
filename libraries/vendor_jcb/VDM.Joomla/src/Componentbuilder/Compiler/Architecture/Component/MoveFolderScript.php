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


use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\MoveFolderScriptInterface;


/**
 * Component Move Folder Script Class.
 * 
 * The install script of a component that has folders to copy calls the method
 * that copies them, and this is the call.
 * 
 * What that method is named, and what the target hands it, is what the compile
 * target decides, and it is the one extension point below.
 * 
 * @since 6.1.7
 */
class MoveFolderScript implements MoveFolderScriptInterface
{
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
	 * @param Registry $registry The Compiler Registry Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
	}

	/**
	 * Build the folder moving code the install script needs.
	 *
	 * Only a component that was found to have folders to move gets any.
	 *
	 * @return  string  The call, or nothing when there are no folders to move.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		if ($this->registry->get('set_move_folders_install_script'))
		{
			$function = $this->call();
			// reset script
			$script   = [];
			$script[] = Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " We check if we have dynamic folders to copy";
			$script[] = Indent::_(2)
				. "\$this->{$function};";

			// done
			return PHP_EOL . implode(PHP_EOL, $script);
		}

		return '';
	}

	/**
	 * The method the generated install script calls, and what it is handed.
	 *
	 * @return  string  The call.
	 *
	 * @since   6.1.7
	 */
	protected function call(): string
	{
		return 'moveFolders($adapter)';
	}
}

