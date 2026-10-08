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

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


/**
 * Turns a source identifier into readable text.
 * 
 * This deliberately does not use the shared string helper. That helper reaches
 * into the running Joomla application for its transliteration parameters, and the
 * extrusion readers and resolvers are specified to work without an application so
 * they stay unit testable against a fixture tree. Humanising an identifier needs
 * none of that machinery.
 * 
 * @since 6.1.6
 */
final class Text
{
	/**
	 * Words that stay lower case inside a readable label.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const MINOR = ['a', 'an', 'and', 'as', 'at', 'by', 'for', 'in', 'of', 'on', 'or', 'the', 'to'];

	/**
	 * Turn an identifier into a readable label.
	 *
	 * @param   string  $identifier  The raw identifier, such as name_code.
	 *
	 * @return  string  The readable label, such as Name Code.
	 * @since   6.1.6
	 */
	public function humanise(string $identifier): string
	{
		$words = $this->words($identifier);

		if ($words === [])
		{
			return '';
		}

		$label = [];

		foreach ($words as $position => $word)
		{
			$label[] = $position > 0 && in_array($word, self::MINOR, true)
				? $word
				: ucfirst($word);
		}

		return implode(' ', $label);
	}

	/**
	 * Turn an identifier into a lower-case, underscore separated name.
	 *
	 * @param   string  $identifier  The raw identifier.
	 *
	 * @return  string  The safe name.
	 * @since   6.1.6
	 */
	public function safe(string $identifier): string
	{
		return implode('_', $this->words($identifier));
	}

	/**
	 * Split an identifier into its lower-case words.
	 *
	 * Underscores, hyphens, spaces and camel-case boundaries all separate words,
	 * so both name_code and nameCode become the same two words.
	 *
	 * @param   string  $identifier  The raw identifier.
	 *
	 * @return  array<string>  The lower-case words.
	 * @since   6.1.6
	 */
	public function words(string $identifier): array
	{
		$spaced = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', trim($identifier)) ?? $identifier;
		$spaced = preg_replace('/[^A-Za-z0-9]+/', ' ', $spaced) ?? $spaced;
		$words = preg_split('/\s+/', strtolower(trim($spaced)));

		if ($words === false)
		{
			return [];
		}

		return array_values(array_filter(
			$words,
			static fn (string $word): bool => $word !== ''
		));
	}

	/**
	 * The code name one human name answers to, as folders and constants spell it.
	 *
	 * "Address Type" and address_type are one screen: JCB derives the code
	 * from the name a person reads, and every folder, form and constant the
	 * compiler writes speaks the code. Comparing names to folders therefore
	 * means comparing codes.
	 *
	 * @param   string  $name  The human or code name.
	 *
	 * @return  string  The lower-cased, underscored code.
	 * @since   6.1.9
	 */
	public static function code(string $name): string
	{
		return trim(strtolower((string) preg_replace('/[^A-Za-z0-9]+/', '_', trim($name))), '_');
	}
}

