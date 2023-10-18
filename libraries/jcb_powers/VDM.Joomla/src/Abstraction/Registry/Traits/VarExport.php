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

namespace VDM\Joomla\Abstraction\Registry\Traits;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Var Export Values
 * 
 * @since 3.2.0
 */
trait VarExport
{
	/**
	 * Default indentation value
	 *
	 * @var    int
	 * @since  3.4.0
	 */
	protected int $indent = 2;

	/**
	 * Method to export a set of values to a PHP array
	 *
	 * @param   string|null  $path          Registry path (e.g. joomla.content.showauthor)
	 * @param   int          $indentation   The default indentation
	 *
	 * @return  ?string    The var set being exported as a PHP array
	 * @since   3.4.0
	 */
	public function varExport(?string $path = null, int $indentation = 2): ?string
	{
		// Load the data array
		if ($path === null && $this->isActive())
		{
			$data = $this->allActive();
		}
		else
		{
			$data = $this->get($path);
		}

		// check if we have data
		if ($data === null)
		{
			return null;
		}

		// set the default indentation value
		$this->indent = $indentation;

		// convert to string
		$data = var_export($data, true);

		// replace all space with system indentation
		$data = preg_replace_callback("/^(\s{2})(\s{2})?(\s{2})?(\s{2})?(\s{2})?(\s{2})?(\s{2})?(\s{2})?(\s{2})?(\s{2})?(\s{2})?(.*)/m", [$this, 'convertIndent'], $data);

		// convert all array to []
		$array = preg_split("/\r\n|\n|\r/", $data);
		$array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
		$data = implode(PHP_EOL, array_filter(["["] + $array));

		// add needed indentation to the last ]
		$data = preg_replace("/^(\])/m", Indent::_($indentation) . '$1', $data);

		return $data;
	}

	/**
	 * Method to convert found of grouped spaces to system indentation
	 *
	 * @param   array  $matches  The regex array of matching values
	 *
	 * @return  string  The resulting string.
	 * @since   3.4.0
	 */
	protected function convertIndent(array $matches): string
	{
		// set number to indent by default
		$indent = Indent::_($this->indent);

		// update each found space (group) with one indentation
		foreach (range(1, 11) as $space)
		{
			if (strlen((string) $matches[$space]) > 0)
			{
				$indent .= Indent::_(1);
			}
		}

		return $indent . $matches[12];
	}
}

