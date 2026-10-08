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

namespace VDM\Joomla\Componentbuilder\Compiler\Placeholder;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\FileHelper;


/**
 * Placeholder Replacement Names Class.
 * 
 * Reads every file the compiler has written so far and reports the placeholder
 * names still standing in them, which is how a developer finds the name of one
 * they want to fill.
 * 
 * @since 6.1.7
 */
final class ReplacementNames
{
	/**
	 * The Files Class.
	 *
	 * @var   Files
	 * @since 6.1.7
	 */
	protected Files $files;

	/**
	 * Constructor.
	 *
	 * @param Files $files The Files Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Files $files)
	{
		$this->files = $files;
	}

	/**
	 * Report the names the compiler replaces in the generated code.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function get()
	{
		// the legacy helper left these two undefined until something was found,
		// which the report itself never noticed but PHP warned about
		$buket = [];
		$echos = [];
		foreach ($this->files->toArray() as $type => $files)
		{
			foreach ($files as $view => $file)
			{
				if (isset($file['path'])
					&& ArrayHelper::check(
						$file
					))
				{
					if (@file_exists($file['path']))
					{
						$string            = FileHelper::getContent(
							$file['path']
						);
						$buket['static'][] = $this->inbetween(
							$string
						);
					}
				}
				elseif (ArrayHelper::check($file))
				{
					foreach ($file as $nr => $doc)
					{
						if (ArrayHelper::check($doc))
						{
							if (@file_exists($doc['path']))
							{
								$string
									= FileHelper::getContent(
									$doc['path']
								);
								$buket[$view][] = $this->inbetween(
									$string
								);
							}
						}
					}
				}
			}
		}
		foreach ($buket as $type => $array)
		{
			foreach ($array as $replacments)
			{
				$replacments = array_unique($replacments);
				foreach ($replacments as $replacment)
				{
					if ($type !== 'static')
					{
						$echos[$replacment] = "#" . "#" . "#" . $replacment
							. "#" . "#" . "#<br />";
					}
					elseif ($type === 'static')
					{
						$echos[$replacment] = "#" . "#" . "#" . $replacment
							. "#" . "#" . "#<br />";
					}
				}
			}
		}

		foreach ($echos as $echo)
		{
			echo $echo . '<br />';
		}
	}

	/**
	 * Get the strings a text carries between two markers.
	 *
	 * @param   string  $str    The string to read.
	 * @param   string  $start  The marker each one opens with.
	 * @param   string  $end    The marker each one closes with.
	 *
	 * @return  array  The strings.
	 *
	 * @since   6.1.7
	 */
	public function inbetween($str, $start = '#' . '#' . '#', $end = '#' . '#' . '#')
	{
		$matches = [];
		$regex   = "/$start([a-zA-Z0-9_]*)$end/";
		preg_match_all($regex, (string) $str, $matches);

		return $matches[1];
	}
}

