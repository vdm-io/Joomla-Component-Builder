<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Customcode;


use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;


/**
 * Compiler Custom Code MD5
 * 
 * @since 3.2.0
 */
class Hash
{
	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param Placeholder|null        $placeholder  The compiler placeholder object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Placeholder $placeholder = null)
	{
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
	}

	/**
	 * Set the MD5 hashed string or file or string
	 *
	 * @param   string  $script  The code string
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $script): string
	{
		// check if we should hash a string
		if (\strpos($script, 'HASH' . 'STRING((((') !== false)
		{
			// get the strings
			$values = GetHelper::allBetween(
				$script, 'HASH' . 'STRING((((', '))))'
			);
			$locker = array();
			// convert them
			foreach ($values as $value)
			{
				$locker['HASH' . 'STRING((((' . $value . '))))']
					= \md5($value);
			}

			// update the script
			return $this->placeholder->update($script, $locker);
		}
		// check if we should hash a file
		if (\strpos($script, 'HASH' . 'FILE((((') !== false)
		{
			// get the strings
			$values = GetHelper::allBetween(
				$script, 'HASH' . 'FILE((((', '))))'
			);
			$locker = array();
			// convert them
			foreach ($values as $path)
			{
				// we first get the file if it exist
				if ($value = FileHelper::getContent($path))
				{
					// now we hash the file content
					$locker['HASH' . 'FILE((((' . $path . '))))']
						= \md5($value);
				}
				else
				{
					// could not retrieve the file so we show error
					$locker['HASH' . 'FILE((((' . $path . '))))']
						= 'ERROR';
				}
			}

			// update the script
			return $this->placeholder->update($script, $locker);
		}

		return $script;
	}

}

