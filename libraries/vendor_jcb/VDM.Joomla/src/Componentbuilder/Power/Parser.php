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

namespace VDM\Joomla\Componentbuilder\Power;


/**
 * Compiler Power Parser
 *        Very basic php class methods parser, does not catch all edge-cases!
 *        Use this only on code that are following standard good practices
 *        Suggested improvements are welcome
 * 
 * Structure is located with PHP's own lexer: string, heredoc and comment
 * content is blanked out (offsets preserved) before any pattern is applied, so
 * code that only looks like a declaration can never be mistaken for one. Every
 * value is then sliced out of the original code by the offset of its own match,
 * never by searching for its text again.
 * 
 * @since 3.2.0
 */
final class Parser
{
	/**
	 * A PHP identifier, expressed in bytes so that no subject has to be valid UTF-8.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const IDENTIFIER = '[a-zA-Z_\x80-\xFF][a-zA-Z0-9_\x80-\xFF]*';

	/**
	 * A single named type, including qualified and fully qualified names.
	 *
	 * @var    string
	 * @since  6.2.0
	 */
	private const NAMED_TYPE = '\\\\?' . self::IDENTIFIER . '(?:\\\\' . self::IDENTIFIER . ')*';

	/**
	 * An intersection contains at least two named types, never a reference marker.
	 *
	 * @var    string
	 * @since  6.2.0
	 */
	private const INTERSECTION_TYPE = self::NAMED_TYPE . '(?:\s*&\s*' . self::NAMED_TYPE . ')+';

	/**
	 * A union member is a named type or one parenthesized intersection.
	 *
	 * PHP DNF types need only this one level of parentheses, not recursive parsing.
	 *
	 * @var    string
	 * @since  6.2.0
	 */
	private const UNION_MEMBER_TYPE = '(?:' . self::NAMED_TYPE . '|\(\s*' . self::INTERSECTION_TYPE . '\s*\))';

	/**
	 * A property or parameter type: nullable, union, intersection or DNF.
	 *
	 * @var    string
	 * @since  6.1.6
	 * @since  6.2.0  Read complete DNF types and whitespace around type operators.
	 */
	private const TYPE = '(?:\?' . self::NAMED_TYPE . '|' . self::INTERSECTION_TYPE . '|'
		. self::UNION_MEMBER_TYPE . '(?:\s*\|\s*' . self::UNION_MEMBER_TYPE . ')*)';

	/**
	 * Get properties and method declarations and other details from the given code.
	 *
	 * @param string  $code  The code containing class properties & methods
	 *
	 * @return array  An array of properties & method declarations of the given code
	 * @since 3.2.0
	 */
	public function code(string $code): array
	{
		$code = $this->normalizeCode($code);
		$mask = $this->maskLiterals($code);

		return [
			'properties' => $this->properties($code, $mask),
			'methods' => $this->methods($code, $mask)
		];
	}

	/**
	 * Get the class body
	 *
	 * @param string $code The class as a string
	 *
	 * @return string|null The class body, or null if not found
	 * @since 3.2.0
	 **/
	public function getClassCode(string $code): ?string
	{
		$code = $this->normalizeCode($code);
		$mask = $this->maskLiterals($code);

		if (($declaration = $this->classDeclaration($mask)) === null)
		{
			// No class body found, return null
			return null;
		}

		$open = $declaration['brace'];
		$close = $this->closing($mask, $open, '{', '}');

		// an unterminated class still yields everything that was declared
		$body = $close === null
			? substr($code, $open + 1)
			: substr($code, $open + 1, $close - $open - 1);

		return trim($body);
	}

	/**
	 * Get the class license
	 *
	 * @param string $code The class as a string
	 *
	 * @return string|null The class license, or null if not found
	 * @since 3.2.0
	 **/
	public function getClassLicense(string $code): ?string
	{
		$code = $this->normalizeCode($code);

		// Check if the file starts with '<?php'
		if (substr($code, 0, 5) !== '<?php')
		{
			return null;
		}

		// Trim the '<?php' part
		$code = ltrim(substr($code, 5));

		// Check if the next part starts with '/*'
		if (substr($code, 0, 2) !== '/*')
		{
			return null;
		}

		// Find the position of the closing comment '*/'
		$endCommentPos = strpos($code, '*/');

		// If the closing comment '*/' is found, extract and return the license
		if ($endCommentPos !== false)
		{
			$license = substr($code, 2, $endCommentPos - 2);
			return trim($license);
		}

		// No license found, return null
		return null;
	}

	/**
	 * Extracts the `use` import statements declared above the class in the given PHP code.
	 *
	 * Only statements that start a line before the class declaration are
	 * returned, so trait imports and closure bindings inside the class body are
	 * never included. Import groups separated by blank lines are all returned:
	 * a caller adding imports has to see every name that is already bound.
	 *
	 * @param string $code The PHP class as a string
	 *
	 * @return array|null An array of the `use` import statements, or null if none were found
	 * @since 3.2.0
	 */
	public function getUseStatements(string $code): ?array
	{
		$code = $this->normalizeCode($code);
		$mask = $this->maskLiterals($code);

		// only the header, so that trait imports are never treated as class imports
		if (($declaration = $this->classDeclaration($mask)) !== null)
		{
			$mask = substr($mask, 0, $declaration['start']);
		}

		if (!preg_match_all('/^use\s[^;]*;/m', $mask, $matches, PREG_OFFSET_CAPTURE))
		{
			return null;
		}

		$use_statements = [];

		foreach ($matches[0] as $match)
		{
			$use_statements[] = trim(substr($code, $match[1], strlen($match[0])));
		}

		return $use_statements !== [] ? $use_statements : null;
	}

	/**
	 * Extracts trait use statements from the given code.
	 *
	 * @param string  $code  The code containing class traits
	 *
	 * @return array|null An array of trait names
	 * @since 3.2.0
	 */
	public function getTraits(string $code): ?array
	{
		$code = $this->normalizeCode($code);
		$mask = $this->maskLiterals($code);

		// regex to target trait use statements, with or without a conflict-resolution block
		$traitPattern = '/^\s*use\s+([\p{L}0-9\\\\_]+(?:\s*,\s*[\p{L}0-9\\\\_]+)*)\s*(?:;|\{)/mu';

		preg_match_all($traitPattern, $mask, $matches, PREG_SET_ORDER);

		if ($matches != [])
		{
			$traitNames = [];

			foreach ($matches as $match)
			{
				$declaration = $match[1] ?? null;

				if ($declaration !== null)
				{
					$traitNames = array_merge($traitNames, preg_split('/\s*,\s*/', trim($declaration)));
				}
			}

			return $traitNames;
		}

		return null;
	}

	/**
	 * Extracts properties declarations and other details from the given code.
	 *
	 * @param string  $code  The code containing class properties
	 * @param string  $mask  The same code with literal and comment content blanked out
	 *
	 * @return array|null An array of properties declarations and details
	 * @since 3.2.0
	 */
	private function properties(string $code, string $mask): ?array
	{
		// regex to target all properties, with the modifiers in any legal order.
		// An access level is required, so a `static` local variable inside a
		// method body is never mistaken for a class property.
		$modifiers = '(?<modifiers>(?:(?:static|readonly)\s+)*(?:var|public|protected|private)\s+(?:(?:static|readonly)\s+)*)';
		$type = '(?<type>' . self::TYPE . '\s+)?';
		$name = '\$(?<name>' . self::IDENTIFIER . ')';
		$property_pattern = "/\b{$modifiers}{$type}{$name}/";

		preg_match_all($property_pattern, $mask, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

		$properties = [];

		foreach ($matches as $match)
		{
			$start = $match[0][1];
			$after = $start + strlen($match[0][0]);

			// a declaration that does not end in a semicolon belongs to an
			// argument list or groups several names, and is not read as a property
			if (($end = $this->statementEnd($mask, $after)) === null)
			{
				continue;
			}

			$comment = $this->extractDocBlock($code, $start);
			$declaration = $this->flatten(substr($code, $start, $end + 1 - $start));
			$default = null;

			if (($equals = strpos($mask, '=', $after)) !== false && $equals < $end)
			{
				$default = $this->flatten(substr($code, $equals + 1, $end - $equals - 1));
			}

			$properties[] = [
				'name' => '$' . $match['name'][0],
				'access' => $this->accessModifier($match['modifiers'][0]),
				'type' => trim($match['type'][0] ?? ''),
				'static' => $this->hasModifier($match['modifiers'][0], 'static'),
				'default' => $default,
				'comment' => $comment,
				'declaration' => $declaration
			];
		}

		return $properties !== [] ? $properties : null;
	}

	/**
	 * Extracts method declarations and other details from the given code.
	 *
	 * @param string  $code  The code containing class methods
	 * @param string  $mask  The same code with literal and comment content blanked out
	 *
	 * @return array|null An array of method declarations and details
	 * @since 3.2.0
	 */
	private function methods(string $code, string $mask): ?array
	{
		// regex to target all methods/functions, with the modifiers in any legal order
		$modifiers = '(?<modifiers>(?:(?:final|abstract|public|protected|private|static)\s+)*)';
		$name = '(?<name>\w+)';
		$method_pattern = "/^[ \t]*{$modifiers}function\s+&?\s*{$name}\s*(?=\()/m";

		preg_match_all($method_pattern, $mask, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

		$methods = [];

		foreach ($matches as $match)
		{
			$start = $match[0][1];
			$open = $start + strlen($match[0][0]);

			// an unterminated argument list is not a declaration we can trust
			if (($close = $this->closing($mask, $open, '(', ')')) === null)
			{
				continue;
			}

			$arguments = substr($code, $open + 1, $close - $open - 1);
			$hidden = substr($mask, $open + 1, $close - $open - 1);
			$end = $close + 1;
			$return_type = null;

			if (preg_match('/\s*:\s*(?<type>[^{;]+)/A', $mask, $returned, 0, $end))
			{
				$return_type = trim(substr($code, $end, strlen($returned[0])), " \t\n:");
				$end += strlen($returned[0]);
			}

			$comment = $this->extractDocBlock($code, $start);
			$declaration = $this->flatten(substr($code, $start, $end - $start));

			// now load what we found
			$methods[] = [
				'name' => $match['name'][0],
				'access' => $this->accessModifier($match['modifiers'][0]),
				'static' => $this->hasModifier($match['modifiers'][0], 'static'),
				'final' => $this->hasModifier($match['modifiers'][0], 'final'),
				'abstract' => $this->hasModifier($match['modifiers'][0], 'abstract'),
				'return_type' => $this->extractReturnType($return_type, $comment),
				'since' => $this->extractSinceVersion($comment),
				'deprecated' => $this->extractDeprecatedVersion($comment),
				'arguments' => $this->extractFunctionArgumentDetails($comment, $arguments, $hidden),
				'comment' => $comment,
				'declaration' => $declaration,
				'body' => $this->extractMethodBody($code, $mask, $end)
			];
		}

		return $methods !== [] ? $methods : null;
	}

	/**
	 * Locates the first class, interface, trait or enum declaration in the given code.
	 *
	 * @param string $mask  The code with literal and comment content blanked out
	 *
	 * @return array|null  The offset of the declaration and of its opening brace, or null if not found
	 * @since 6.1.6
	 */
	private function classDeclaration(string $mask): ?array
	{
		// Match class, final class, abstract class, readonly class, interface, trait and enum,
		// with any parent and interface list, including fully qualified names
		$pattern = '/^[ \t]*(?:(?:final|abstract|readonly)\s+)*(?:class|interface|trait|enum)\s+'
			. self::IDENTIFIER . '[^{;]*\{/m';

		if (!preg_match($pattern, $mask, $matches, PREG_OFFSET_CAPTURE))
		{
			return null;
		}

		return [
			'start' => $matches[0][1],
			'brace' => $matches[0][1] + strlen($matches[0][0]) - 1
		];
	}

	/**
	 * Extracts the PHPDoc block that stands directly above the given offset.
	 *
	 * @param string $code    The source code containing the declaration
	 * @param int    $offset  The offset at which the declaration starts
	 *
	 * @return string|null  The PHPDoc block, or null if not found
	 * @since 3.2.0
	 */
	private function extractDocBlock(string $code, int $offset): ?string
	{
		$before = rtrim(substr($code, 0, $offset));

		// only a doc block that ends where the declaration begins describes it
		if (substr($before, -2) !== '*/' || ($start = strrpos($before, '/**')) === false)
		{
			return null;
		}

		$comment = substr($before, $start);

		// the block has to be the one that closes here, not an earlier closed block
		if (strpos($comment, '*/') !== strlen($comment) - 2)
		{
			return null;
		}

		return $this->removeWhiteSpaceFromComment($comment);
	}

	/**
	 * Extracts method body based on the end position of its declaration.
	 *
	 * @param string $code      The class code
	 * @param string $mask      The same code with literal and comment content blanked out
	 * @param int    $startPos  The position directly after the method declaration
	 *
	 * @return string|null Method body or null if the method has none
	 * @since 3.2.0
	 */
	private function extractMethodBody(string $code, string $mask, int $startPos): ?string
	{
		if (($open = strpos($mask, '{', $startPos)) === false)
		{
			return null;
		}

		// an abstract or interface method ends before any body can start
		$semicolon = strpos($mask, ';', $startPos);

		if ($semicolon !== false && $semicolon < $open)
		{
			return null;
		}

		if (($close = $this->closing($mask, $open, '{', '}')) === null)
		{
			return null;
		}

		return substr($code, $open + 1, $close - $open - 1);
	}

	/**
	 * Finds the offset that closes the block opened at the given position.
	 *
	 * @param string $mask    The code with literal and comment content blanked out
	 * @param int    $open    The offset of the opening character
	 * @param string $opener  The opening character
	 * @param string $closer  The closing character
	 *
	 * @return int|null  The offset of the closing character, or null if the block never closes
	 * @since 6.1.6
	 */
	private function closing(string $mask, int $open, string $opener, string $closer): ?int
	{
		$depth = 0;
		$length = strlen($mask);

		for ($i = $open; $i < $length; $i++)
		{
			if ($mask[$i] === $opener)
			{
				$depth++;
			}
			elseif ($mask[$i] === $closer)
			{
				$depth--;

				if ($depth <= 0)
				{
					return $i;
				}
			}
		}

		return null;
	}

	/**
	 * Finds the semicolon that ends the statement started at the given position.
	 *
	 * @param string $mask  The code with literal and comment content blanked out
	 * @param int    $from  The offset at which to start looking
	 *
	 * @return int|null  The offset of the semicolon, or null if the statement does not end in one
	 * @since 6.1.6
	 */
	private function statementEnd(string $mask, int $from): ?int
	{
		$depth = 0;
		$length = strlen($mask);

		for ($i = $from; $i < $length; $i++)
		{
			$char = $mask[$i];

			if ($char === '(' || $char === '[' || $char === '{')
			{
				$depth++;
			}
			elseif ($char === ')' || $char === ']' || $char === '}')
			{
				$depth--;

				// we walked out of an enclosing list, so this was never a statement
				if ($depth < 0)
				{
					return null;
				}
			}
			elseif ($depth === 0 && $char === ';')
			{
				return $i;
			}
			elseif ($depth === 0 && $char === ',')
			{
				// a grouped declaration is not read as a single property
				return null;
			}
		}

		return null;
	}

	/**
	 * Splits an argument list on the commas that separate its arguments.
	 *
	 * @param string $mask  The argument list with literal and comment content blanked out
	 *
	 * @return array  The offset and length of every argument
	 * @since 6.1.6
	 */
	private function splitArguments(string $mask): array
	{
		$arguments = [];
		$depth = 0;
		$start = 0;
		$length = strlen($mask);

		for ($i = 0; $i < $length; $i++)
		{
			$char = $mask[$i];

			if ($char === '(' || $char === '[' || $char === '{')
			{
				$depth++;
			}
			elseif ($char === ')' || $char === ']' || $char === '}')
			{
				$depth--;
			}
			elseif ($char === ',' && $depth === 0)
			{
				$arguments[] = [$start, $i - $start];
				$start = $i + 1;
			}
		}

		$arguments[] = [$start, $length - $start];

		return $arguments;
	}

	/**
	 * Extracts the function argument details.
	 *
	 * @param string|null $comment    The function comment if found
	 * @param string|null $arguments  The arguments found on function declaration
	 * @param string|null $mask       The same arguments with literal content blanked out
	 *
	 * @return array|null  The function argument details
	 * @since 3.2.0
	 */
	private function extractFunctionArgumentDetails(?string $comment, ?string $arguments, ?string $mask = null): ?array
	{
		$arg_types_from_declaration = $this->extractArgTypesArguments($arguments, $mask);
		$arg_types_from_comments = null;

		if ($comment)
		{
			$arg_types_from_comments = $this->extractArgTypesFromComment($comment);
		}

		// merge the types
		if ($arg_types_from_declaration)
		{
			return $this->mergeArgumentTypes($arg_types_from_declaration, $arg_types_from_comments);
		}

		return null;
	}

	/**
	 * Extracts the function return type.
	 *
	 * @param string|null $returnType  The return type found in declaration
	 * @param string|null $comment     The function comment if found
	 *
	 * @return string|null  The function return type
	 * @since 3.2.0
	 */
	private function extractReturnType(?string $returnType, ?string $comment): ?string
	{
		if ($returnType === null && $comment)
		{
			return $this->extractReturnTypeFromComment($comment);
		}

		return trim(trim((string) $returnType, ':'));
	}

	/**
	 * Extracts argument types from a given comment.
	 *
	 * @param string  $comment  The comment containing the argument types
	 *
	 * @return array|null An array of argument types
	 * @since 3.2.0
	 */
	private function extractArgTypesFromComment(string $comment): ?array
	{
		preg_match_all('/@param\s+((?:[^\s|]+(?:\|)?)+)?\s+\$([^\s]+)/', $comment, $matches, PREG_SET_ORDER);

		if ($matches !== [])
		{
			$arg_types = [];

			foreach ($matches as $match)
			{
				$arg = $match[2] ?? null;
				$type = $match[1] ?: null;
				if (is_string($arg))
				{
					$arg_types['$' .$arg] = $type;
				}
			}

			return $arg_types;
		}

		return null;
	}

	/**
	 * Extracts argument types from a given declaration.
	 *
	 * @param string|null $arguments  The arguments found on function declaration
	 * @param string|null $mask       The same arguments with literal content blanked out
	 *
	 * @return array|null   An array of argument types
	 * @since 3.2.0
	 * @since 6.2.0  Require complete parameter signatures after attributes and promotion modifiers.
	 */
	private function extractArgTypesArguments(?string $arguments, ?string $mask = null): ?array
	{
		if ($arguments === null || trim($arguments) === '')
		{
			return null;
		}

		$mask ??= $arguments;
		$argument_types = [];

		foreach ($this->splitArguments($mask) as [$start, $length])
		{
			$argument = substr($arguments, $start, $length);
			$hidden = substr($mask, $start, $length);
			$signatureStart = strspn($hidden, " \t\n\r");

			// Attributes may contain brackets, commas and equals signs. Skip their
			// balanced blocks before locating the parameter's own type and default.
			while (substr($hidden, $signatureStart, 2) === '#[')
			{
				$attributeEnd = $this->closing($hidden, $signatureStart + 1, '[', ']');

				if ($attributeEnd === null)
				{
					continue 2;
				}

				$signatureStart = $attributeEnd + 1;
				$signatureStart += strspn($hidden, " \t\n\r", $signatureStart);
			}

			$eqPos = strpos($hidden, '=', $signatureStart);
			$signature = $eqPos === false
				? substr($hidden, $signatureStart)
				: substr($hidden, $signatureStart, $eqPos - $signatureStart);
			$default = $eqPos === false ? null : $this->flatten(substr($argument, $eqPos + 1));

			// Match the entire declaration after optional promotion modifiers. An
			// unsupported type must never be silently read from a matching suffix.
			$pattern = '/\A(?:(?:public|protected|private)(?:\s*\(\s*set\s*\))?\s+|readonly\s+)*'
				. '(?:(' . self::TYPE . ')\s*)?&?\s*(?:\.\.\.)?\s*\$(' . self::IDENTIFIER . ')\s*\z/';

			if (preg_match($pattern, $signature, $arg_matches))
			{
				$type = $arg_matches[1] ?: null;
				$name = $arg_matches[2] ?: null;

				if (is_string($name))
				{
					$argument_types['$' . $name] = [
						'type' => $type,
						'default' => $default,
					];
				}
			}
		}

		return $argument_types !== [] ? $argument_types : null;
	}

	/**
	 * Extracts return type from a given declaration.
	 *
	 * @param string  $comment  The comment containing the return type
	 *
	 * @return string|null   The return type
	 * @since 3.2.0
	 */
	private function extractReturnTypeFromComment(string $comment): ?string
	{
		if (preg_match('/@return\s+((?:[^\s|]+(?:\|)?)+)/', $comment, $matches))
		{
			return $matches[1] ?: null;
		}

		return null;
	}

	/**
	 * Extracts the version number from the @since tag in the given comment.
	 *
	 * @param string|null $comment The comment containing the @since tag and version number
	 *
	 * @return string|null The extracted version number or null if not found
	 * @since 3.2.0
	 */
	private function extractSinceVersion(?string $comment): ?string
	{
		if (is_string($comment) && preg_match('/@since\s+(v?\d+(?:\.\d+)*(?:-(?:alpha|beta|rc)\d*)?)/', $comment, $matches))
		{
			return $matches[1] ?: null;
		}

		return null;
	}

	/**
	 * Extracts the version number from the deprecated tag in the given comment.
	 *
	 * @param string|null $comment The comment containing the deprecated tag and version number
	 *
	 * @return string|null The extracted version number or null if not found
	 * @since 3.2.0
	 */
	private function extractDeprecatedVersion(?string $comment): ?string
	{
		if (is_string($comment) && preg_match('/@deprecated\s+(v?\d+(?:\.\d+)*(?:-(?:alpha|beta|rc)\d*)?)/', $comment, $matches))
		{
			return $matches[1] ?: null;
		}

		return null;
	}

	/**
	 * Remove all white space from each line of the comment
	 *
	 * @param string  $comment  The function declaration containing the return type
	 *
	 * @return string   The return comment
	 * @since 3.2.0
	 */
	private function removeWhiteSpaceFromComment(string $comment): string
	{
		// Remove comment markers and leading/trailing whitespace
		$comment = preg_replace('/^\/\*\*[\r\n\s]*|[\r\n\s]*\*\/$/m', '', $comment);
		$comment = preg_replace('/^[\s]*\*[\s]?/m', '', $comment);

		// Split the comment into lines
		$lines = preg_split('/\r\n|\r|\n/', $comment);

		// Remove white spaces from each line
		$trimmedLines = array_map('trim', $lines);

		// Join the lines back together
		return implode("\n", array_filter($trimmedLines));
	}

	/**
	 * Merges the types from the comments and the arguments.
	 *
	 * @param array         $argTypesFromDeclaration  An array of argument types and default values from the declaration
	 * @param array|null    $argTypesFromComments     An array of argument types from the comments
	 *
	 * @return array A merged array of argument information
	 * @since 3.2.0
	 */
	private function mergeArgumentTypes(array $argTypesFromDeclaration, ?array $argTypesFromComments): array
	{
		$mergedArguments = [];

		foreach ($argTypesFromDeclaration as $name => $declarationInfo)
		{
			$mergedArguments[$name] = [
				'name' => $name,
				'type' => $declarationInfo['type'] ?: $argTypesFromComments[$name] ?? null,
				'default' => $declarationInfo['default'] ?? null,
			];
		}

		return $mergedArguments;
	}

	/**
	 * Reads the access level out of a run of member modifiers.
	 *
	 * @param string  $modifiers  The modifiers found in front of the declaration
	 *
	 * @return string  The declared access level, or the PHP default when none was declared
	 * @since 6.1.6
	 */
	private function accessModifier(string $modifiers): string
	{
		if (preg_match('/\b(var|public|protected|private)\b/', $modifiers, $matches))
		{
			return $matches[1];
		}

		return 'public';
	}

	/**
	 * Checks whether a run of member modifiers declares the given modifier.
	 *
	 * @param string  $modifiers  The modifiers found in front of the declaration
	 * @param string  $modifier   The modifier to look for
	 *
	 * @return bool  True when the modifier was declared
	 * @since 6.1.6
	 */
	private function hasModifier(string $modifiers, string $modifier): bool
	{
		return preg_match('/\b' . $modifier . '\b/', $modifiers) === 1;
	}

	/**
	 * Collapses a declaration onto one line so that it can be stored and compared.
	 *
	 * @param string  $value  The declaration as it stands in the source
	 *
	 * @return string  The declaration on a single line
	 * @since 6.1.6
	 */
	private function flatten(string $value): string
	{
		return trim(preg_replace('/\s{2,}/', ' ', preg_replace('/[\r\n]+/', ' ', $value)));
	}

	/**
	 * Normalize input PHP code for cross-platform consistency.
	 *
	 * - Always removes the UTF-8 BOM (Byte Order Mark) if present.
	 * - Always normalizes line endings to "\n".
	 *
	 * The result does not depend on the host that runs the parse, so the same
	 * class yields the same bodies, declarations and hashes on Linux, macOS and
	 * Windows alike, and BOM-related PHP output errors are prevented.
	 *
	 * @param  string  $code  The raw PHP code as a string.
	 *
	 * @return string  The normalized PHP code string.
	 * @since  5.1.2
	 */
	private function normalizeCode(string $code): string
	{
		// UTF-8 BOM sequence
		static $BOM = "\xEF\xBB\xBF";

		// Always remove UTF-8 BOM if present
		if (strncmp($code, $BOM, 3) === 0)
		{
			$code = substr($code, 3);
		}

		// Universal line ending normalization
		return str_replace(["\r\n", "\r"], "\n", $code);
	}

	/**
	 * Blank out every string, heredoc and comment so only real code is left to match.
	 *
	 * The returned string has exactly the same length and line breaks as the
	 * given code, so an offset found in it always addresses the same byte in the
	 * original. Structure is therefore located in code that cannot contain a
	 * quoted brace, a commented-out method, or a class name inside a template.
	 *
	 * @param  string  $code  The normalized PHP code as a string.
	 *
	 * @return string  The code with all literal and comment content replaced by spaces.
	 * @since  6.1.6
	 */
	private function maskLiterals(string $code): string
	{
		// a stored class body carries no opening tag, so give the lexer one
		$prefix = preg_match('/^\s*<\?php/', $code) === 1 ? '' : '<?php ';
		$shift = strlen($prefix);

		$tokens = @token_get_all($prefix . $code);

		if ($tokens === false || $tokens === [])
		{
			return $code;
		}

		$mask = '';

		foreach ($tokens as $token)
		{
			if (!is_array($token))
			{
				$mask .= $token;
				continue;
			}

			// the quotes stay, so a literal is still recognizable as a value
			if ($token[0] === T_CONSTANT_ENCAPSED_STRING && strlen($token[1]) > 2)
			{
				$mask .= $token[1][0] . $this->blankOut(substr($token[1], 1, -1)) . substr($token[1], -1);
			}
			elseif ($token[0] === T_ENCAPSED_AND_WHITESPACE
				|| $token[0] === T_INLINE_HTML
				|| $token[0] === T_COMMENT
				|| $token[0] === T_DOC_COMMENT)
			{
				$mask .= $this->blankOut($token[1]);
			}
			else
			{
				$mask .= $token[1];
			}
		}

		// the lexer saw the opening tag we may have added, the caller never did
		$mask = substr($mask, $shift);

		// a mask that no longer lines up with the code cannot be trusted
		return strlen($mask) === strlen($code) ? $mask : $code;
	}

	/**
	 * Replace every byte of the given text with a space, keeping its line breaks.
	 *
	 * @param  string  $text  The text to blank out.
	 *
	 * @return string  The blanked text, of exactly the same length.
	 * @since  6.1.6
	 */
	private function blankOut(string $text): string
	{
		return preg_replace('/[^\n]/', ' ', $text) ?? $text;
	}
}

