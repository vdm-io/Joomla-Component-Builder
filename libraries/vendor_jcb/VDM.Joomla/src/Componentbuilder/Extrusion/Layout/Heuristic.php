<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Layout;


/**
 * Classifies a source file by what it intrinsically is, not by where it sits.
 * 
 * This is the last discovery tier and the one that makes a component which
 * ignored Joomla's own layout still work. The file kind matters more than the
 * location, so each test below looks inside the file.
 * 
 * @since 6.1.6
 */
final class Heuristic
{
	/**
	 * Whether a SQL file carries a table definition.
	 *
	 * @param   string  $content  The file content or its leading bytes.
	 *
	 * @return  bool  True when the content declares a table.
	 * @since   6.1.6
	 */
	public function isSchema(string $content): bool
	{
		return preg_match('/CREATE\s+TABLE/i', $content) === 1;
	}

	/**
	 * Whether an XML file is a Joomla form.
	 *
	 * @param   string  $content  The file content or its leading bytes.
	 *
	 * @return  bool  True when the document is a form carrying fields.
	 * @since   6.1.6
	 */
	public function isForm(string $content): bool
	{
		if (preg_match('/<\s*form[\s>]/i', $content) !== 1)
		{
			return false;
		}

		return preg_match('/<\s*field\s+[^>]*name\s*=/i', $content) === 1;
	}

	/**
	 * Whether an INI file is this component's language catalogue.
	 *
	 * @param   string  $content  The file content or its leading bytes.
	 * @param   string  $option   The component option, when known.
	 *
	 * @return  bool  True when the file carries this component's constants.
	 * @since   6.1.6
	 */
	public function isLanguage(string $content, string $option = ''): bool
	{
		if ($option !== '')
		{
			$prefix = preg_quote(strtoupper($option), '/');

			if (preg_match('/^\s*' . $prefix . '_[A-Z0-9_]*\s*=/m', $content) === 1)
			{
				return true;
			}
		}

		return preg_match('/^\s*COM_[A-Z0-9_]+\s*=/m', $content) === 1;
	}

	/**
	 * Whether a PHP file is a JCB table definition class.
	 *
	 * This test decides family membership, not usability. Both array syntaxes and
	 * any modifier or type in front of the property therefore match, because
	 * whether the map can actually be trusted is the literal-only reader's
	 * decision. Narrowing this to the short syntax would make a long-form class
	 * silently invisible to discovery instead of visibly refused, which costs the
	 * run the one thing it could have reported: why the class was rejected.
	 *
	 * @param   string  $content  The complete file content.
	 *
	 * @return  bool  True when the file declares a tables map on a child class.
	 * @since   6.1.6
	 */
	public function isTableClass(string $content): bool
	{
		if (preg_match('/\bextends\b/', $content) !== 1)
		{
			return false;
		}

		return preg_match(
			'/(?:protected|public|private)[\s\w\\\\?|]*\$tables\s*=\s*(?:\[|array\s*\()/',
			$content
		) === 1;
	}

	/**
	 * Whether a PHP file is a view template or layout rather than a class.
	 *
	 * @param   string  $content  The complete file content.
	 *
	 * @return  bool  True when the file renders markup instead of declaring a type.
	 * @since   6.1.6
	 */
	public function isViewFile(string $content): bool
	{
		if (preg_match('/^\s*(?:final\s+|abstract\s+)?(?:class|interface|trait|enum)\s+/m', $content) === 1)
		{
			return false;
		}

		return preg_match('/\?>/', $content) === 1
			|| preg_match('/<\s*(?:div|table|ul|form|span|h[1-6])[\s>]/i', $content) === 1;
	}

	/**
	 * Classify one file by content signature.
	 *
	 * @param   string  $path     Absolute file path.
	 * @param   string  $content  The file content or its leading bytes.
	 * @param   string  $option   The component option, when known.
	 *
	 * @return  string|null  The artifact kind, or null when unrecognised.
	 * @since   6.1.6
	 */
	public function classify(string $path, string $content, string $option = ''): ?string
	{
		$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

		if ($extension === 'sql' && $this->isSchema($content))
		{
			return 'schema';
		}

		if ($extension === 'xml' && $this->isForm($content))
		{
			return 'form';
		}

		if ($extension === 'ini' && $this->isLanguage($content, $option))
		{
			return 'language';
		}

		if ($extension === 'php' && $this->isTableClass($content))
		{
			return 'table_class';
		}

		return null;
	}
}

