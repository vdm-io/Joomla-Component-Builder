<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Reader\Php;


/**
 * Reads the body a screen shows out of its own template file.
 * 
 * A Joomla view template opens with PHP -- the execution guard, the imports,
 * whatever the view prepares -- and then closes that block and lays out the
 * markup a person actually sees. What JCB holds for a screen is that second
 * part: everything after the first closing tag. So that is what is taken here,
 * exactly as a power's body is taken out of its class file, rather than a body
 * being invented for the screen.
 * 
 * Nothing about which file this is, or where it sits, is decided here. The
 * caller has already found the screen's template through the layout the
 * component follows; this only separates what a template says from how it
 * prepares to say it.
 * 
 * @since 6.2.0
 */
final class Template
{
	/**
	 * The body of one template file, when it has one.
	 *
	 * @param   string  $path  Absolute path to the template file.
	 *
	 * @return  string|null  The body, or null when the file cannot be read.
	 * @since   6.2.0
	 */
	public function read(string $path): ?string
	{
		if ($path === '' || !is_file($path) || !is_readable($path))
		{
			return null;
		}

		$code = @file_get_contents($path);

		return is_string($code) ? $this->body($code) : null;
	}

	/**
	 * What a template shows, separated from what it prepares.
	 *
	 * A file that never closes its PHP block shows nothing of its own, so it
	 * has no body to take -- and a file that opens with markup is already all
	 * body.
	 *
	 * @param   string  $code  The whole file.
	 *
	 * @return  string  The body, which may be empty.
	 * @since   6.2.0
	 */
	public function body(string $code): string
	{
		if (!str_contains($code, '<?'))
		{
			return trim($code);
		}

		$closed = strpos($code, '?>');

		if ($closed === false)
		{
			return '';
		}

		return trim(substr($code, $closed + 2));
	}
}

