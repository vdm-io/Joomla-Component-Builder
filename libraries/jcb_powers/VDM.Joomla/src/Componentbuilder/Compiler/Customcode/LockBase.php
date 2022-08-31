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
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;


/**
 * Compiler Custom Code Base64
 * 
 * @since 3.2.0
 */
class LockBase
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
	 * Set a string as bsae64 (basic)
	 *
	 * @param   string  $script  The code string
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $script): string
	{
		if (\strpos($script, 'LOCK'.'BASE64((((') !== false)
		{
			// get the strings
			$values = GetHelper::allBetween(
				$script, 'LOCK'.'BASE64((((', '))))'
			);
			$locker = array();
			// convert them
			foreach ($values as $value)
			{
				$locker['LOCK'.'BASE64((((' . $value . '))))']
					= "base64_decode( preg_replace('/\s+/', ''," .
					PHP_EOL . Indent::_(2) . "'" .
					\wordwrap(
						\base64_encode($value), 64, PHP_EOL . Indent::_(2), true
					) .
					"'))";
			}

			// update the script
			return $this->placeholder->update($script, $locker);
		}

		return $script;
	}

}

