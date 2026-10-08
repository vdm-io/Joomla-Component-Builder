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

namespace VDM\Joomla\Componentbuilder\Extrusion\Reader;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Language as LanguageRegistry;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\ReaderInterface;


/**
 * Reads one language ini file into the Language registry.
 * 
 * The content is parsed from a string rather than from the path, so the parse is
 * testable without a file, and in raw mode, so Joomla's own escaping survives to
 * be undone here rather than by the ini scanner. The raw scanner removes the
 * quotes that wrap a value but leaves an escaped quote alone, so an embedded
 * quote reaches this reader either as \" from a modern file or as the legacy
 * _QQ_ token, and both become a literal double quote. Nothing else is stripped:
 * a quote that survives the scanner is content, as is any whitespace inside the
 * quotes, and both are kept exactly as Joomla's own language loader keeps them.
 * 
 * Merging is first writer wins: a later file never replaces a constant that is
 * already present with a non-empty value, so reading the component ini before
 * its sys ini leaves the main catalogue in charge. The file is never included,
 * required, or evaluated.
 * 
 * @since 6.1.6
 */
final class Language implements ReaderInterface
{
	/**
	 * The legacy Joomla token that stands in for an embedded double quote.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const QUOTE = '_QQ_';

	/**
	 * The escape a modern Joomla ini file uses for an embedded double quote.
	 *
	 * The raw ini scanner deliberately leaves an escape untouched, so the file
	 * still holds a backslash and a quote when the value reaches this reader.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const ESCAPE = '\\"';

	/**
	 * The Language Registry.
	 *
	 * @var    LanguageRegistry
	 * @since  6.1.6
	 */
	protected LanguageRegistry $language;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   LanguageRegistry  $language  The language catalogue registry.
	 * @param   Report            $report    The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(LanguageRegistry $language, Report $report)
	{
		$this->language = $language;
		$this->report = $report;
	}

	/**
	 * Read one language ini file into the Language registry.
	 *
	 * @param   string       $path  Absolute path to the ini file.
	 * @param   string|null  $name  The catalogue source name, derived from the file name when null.
	 *
	 * @return  bool  True when at least one constant was read.
	 * @since   6.1.6
	 */
	public function read(string $path, ?string $name = null): bool
	{
		$file = $this->key($name ?? pathinfo($path, PATHINFO_FILENAME));
		$this->report->set('language.' . $file . '.path', $path);

		$content = $this->content($path);

		if ($content === null)
		{
			$this->report->set('language.' . $file . '.error', 'the file could not be read');

			return false;
		}

		$parsed = $this->parse($content, $file);

		if ($parsed === null)
		{
			return false;
		}

		$read = 0;
		$stored = 0;
		$unsupported = 0;

		foreach ($parsed as $constant => $value)
		{
			if (is_array($value))
			{
				$unsupported++;
				continue;
			}

			$read++;
			$key = $this->key((string) $constant);

			if ($this->present($key))
			{
				continue;
			}

			$this->language->set('constant.' . $key, $this->value((string) $value));
			$stored++;
		}

		$this->report->set('language.' . $file . '.constants', $read);
		$this->report->set('language.' . $file . '.stored', $stored);
		$this->report->set('language.' . $file . '.kept', $read - $stored);

		if ($unsupported > 0)
		{
			$this->report->set('language.' . $file . '.unsupported', $unsupported);
		}

		return $read > 0;
	}

	/**
	 * How many constants the catalogue holds.
	 *
	 * @return  int  The stored constant count.
	 * @since   6.1.6
	 */
	public function count(): int
	{
		return count((array) $this->language->get('constant', []));
	}

	/**
	 * Resolve one raw ini value into its English string.
	 *
	 * The raw scanner has already removed the quotes that wrapped the value and
	 * has already trimmed an unquoted one, so only the escapes are left to undo.
	 * A quote or a space that reaches this method is therefore part of the string
	 * and is kept: stripping another layer would silently eat the content of a
	 * value that genuinely opens and closes with a quote.
	 *
	 * @param   string  $value  The raw scanner value.
	 *
	 * @return  string  The resolved string.
	 * @since   6.1.6
	 */
	public function value(string $value): string
	{
		return str_replace([self::ESCAPE, self::QUOTE], '"', $value);
	}

	/**
	 * Sanitise one value into a safe registry path segment.
	 *
	 * The registry addresses state by a dot separated path and discards empty
	 * segments, so anything that is not a plain word character collapses to an
	 * underscore and an empty result becomes a stable placeholder.
	 *
	 * @param   string  $value  The raw value.
	 *
	 * @return  string  A safe single path segment.
	 * @since   6.1.6
	 */
	public function key(string $value): string
	{
		$key = preg_replace('/[^A-Za-z0-9_]+/', '_', trim($value));

		return $key === null || $key === '' ? 'unknown' : $key;
	}

	/**
	 * Whether a constant is already present with a usable value.
	 *
	 * @param   string  $key  The constant key.
	 *
	 * @return  bool  True when a later file must leave the constant alone.
	 * @since   6.1.6
	 */
	protected function present(string $key): bool
	{
		return $this->language->exists('constant.' . $key)
			&& (string) $this->language->get('constant.' . $key, '') !== '';
	}

	/**
	 * Read the file without allowing a failure to surface as a warning.
	 *
	 * @param   string  $path  Absolute path to the ini file.
	 *
	 * @return  string|null  The content, or null when it is unusable.
	 * @since   6.1.6
	 */
	protected function content(string $path): ?string
	{
		if ($path === '' || !is_file($path))
		{
			return null;
		}

		$content = @file_get_contents($path);

		return $content === false ? null : $content;
	}

	/**
	 * Parse the content as raw ini without allowing a warning to surface.
	 *
	 * @param   string  $content  The file content.
	 * @param   string  $file     The catalogue source key.
	 *
	 * @return  array<string, mixed>|null  The parsed pairs, or null on a parse failure.
	 * @since   6.1.6
	 */
	protected function parse(string $content, string $file): ?array
	{
		$parsed = @parse_ini_string($content, false, INI_SCANNER_RAW);

		if (!is_array($parsed))
		{
			$this->report->set(
				'language.' . $file . '.error',
				'the content is not valid ini and was not read'
			);

			return null;
		}

		return $parsed;
	}
}

