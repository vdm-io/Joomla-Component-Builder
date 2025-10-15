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


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Dynamic Get Globals
 * 
 * @since 5.1.2
 */
final class Globals
{
	/**
	 * Generate PHP code for setting dynamic get global values.
	 *
	 * @param  array   $global  The list of global configuration items.
	 * @param  string  $string  The base string reference to the data source.
	 * @param  array   $as      The list of aliases to process.
	 * @param  string  $tab     The tab indentation string (optional).
	 *
	 * @return string  The generated PHP code for setting global values.
	 * @since  5.1.2
	 */
	public function get(array $global, string $string, array $as, string $tab = ''): string
	{
		if (empty($global) || empty($string) || empty($as))
		{
			return '';
		}

		$as = array_unique($as);

		$globals = '';

		foreach ($global as $glo)
		{
			if (!isset($glo['as']) ||
				!in_array($glo['as'], $as) ||
				!isset($glo['type']) ||
				!is_numeric($glo['type'])
			)
			{
				continue;
			}

			switch ($glo['type'])
			{
				case 1:
					// SET STATE
					$value = "\$this->setState('" . $glo['as'] . "."
						. $glo['name'] . "', " . $string . "->"
						. $glo['key'] . ");";
					break;

				case 2:
					// SET THIS
					$value = "\$this->" . $glo['as'] . "_"
						. $glo['name'] . " = " . $string . "->"
						. $glo['key'] . ";";
					break;

				default:
					$value = '';
					break;
			}

			// Only add if the filter is set
			if (StringHelper::check($value))
			{
				$globals .= PHP_EOL
					. Indent::_(1) . $tab . Indent::_(1)
					. "//" . Line::_(__LINE__, __CLASS__)
					. " set the global " . $glo['name'] . " value."
					. PHP_EOL
					. Indent::_(1) . $tab . Indent::_(1)
					. $value;
			}
		}

		return $globals;
	}
}

