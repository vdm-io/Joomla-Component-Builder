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

namespace VDM\Joomla\Componentbuilder\Compiler\Power;


/**
 * Compiler Power Parser
 *        Very basic php class methods parser, does not catch all edge-cases!
 *        Use this only on code that are following standard good practices
 *        Suggested improvements are welcome
 * @since 3.2.0
 */
final class Parser
{
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
		return [
			'properties' => $this->properties($code),
			'methods' => $this->methods($code)
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
		// Match class, final class, abstract class, interface, and trait
		$pattern = '/(?:class|final class|abstract class|interface|trait)\s+[a-zA-Z0-9_]+\s*(?:extends\s+[a-zA-Z0-9_]+\s*)?(?:implements\s+[a-zA-Z0-9_]+(?:\s*,\s*[a-zA-Z0-9_]+)*)?\s*\{/s';

		// Split the input code based on the class declaration pattern
		$parts = preg_split($pattern, $code, 2, PREG_SPLIT_DELIM_CAPTURE);
		$body = $parts[1] ?? '';

		if ($body !== '')
		{
			// Remove leading and trailing white space
			$body = trim($body);

			// Remove the first opening curly brace if it exists
			if (mb_substr($body, 0, 1) === '{')
			{
				$body = mb_substr($body, 1);
			}

			// Remove the last closing curly brace if it exists
			if (mb_substr($body, -1) === '}')
			{
				$body = mb_substr($body, 0, -1);
			}

			return $body;
		}

		// No class body found, return null
		return null;
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
	 * Extracts the first consecutive `use` statements from the given PHP class.
	 *
	 * @param string $code The PHP class as a string
	 *
	 * @return array|null An array of consecutive `use` statements
	 * @since 3.2.0
	 */
	public function getUseStatements(string $code): ?array
	{
		// Match class, final class, abstract class, interface, and trait
		$pattern = '/(?:class|final class|abstract class|interface|trait)\s+[a-zA-Z0-9_]+\s*(?:extends\s+[a-zA-Z0-9_]+\s*)?(?:implements\s+[a-zA-Z0-9_]+(?:\s*,\s*[a-zA-Z0-9_]+)*)?\s*\{/s';

		// Split the input code based on the class declaration pattern
		$parts = preg_split($pattern, $code, 2, PREG_SPLIT_DELIM_CAPTURE);
		$header = $parts[0] ?? '';

		$use_statements = [];
		$found_first_use = false;

		if ($header !== '')
		{
			$lines = explode(PHP_EOL, $header);

			foreach ($lines as $line)
			{
				if (strpos($line, 'use ') === 0)
				{
					$use_statements[] = trim($line);
					$found_first_use = true;
				}
				elseif ($found_first_use && trim($line) === '')
				{
					break;
				}
			}
		}

		return $found_first_use ? $use_statements : null;
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
		// regex to target trait use statements
		$traitPattern = '/^\s*use\s+[\p{L}0-9\\\\_]+(?:\s*,\s*[\p{L}0-9\\\\_]+)*\s*;/mu';

		preg_match_all($traitPattern, $code, $matches, PREG_SET_ORDER);

		if ($matches != [])
		{
			$traitNames = [];

			foreach ($matches as $n => $match)
			{
				$declaration = $match[0] ?? null;

				if ($declaration !== null)
				{
					$names = preg_replace('/\s*use\s+/', '', $declaration);
					$names = preg_replace('/\s*;/', '', $names);
					$names = preg_split('/\s*,\s*/', $names);

					$traitNames = array_merge($traitNames, $names);
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
	 *
	 * @return array|null An array of properties declarations and details
	 * @since 3.2.0
	 */
	private function properties(string $code): ?array
	{
		// regex to target all properties
		$access = '(?<access>var|public|protected|private)';
		$type = '(?<type>(?:\?|)[\p{L}0-9\\\\]*\s+)?';
		$static = '(?<static>static)?';
		$name = '\$(?<name>\p{L}[\p{L}0-9]*)';
		$default = '(?:\s*=\s*(?<default>\[[^\]]*\]|\d+|\'[^\']*?\'|"[^"]*?"|false|true|null))?';
		$property_pattern = "/\b{$access}\s*{$type}{$static}\s*{$name}{$default};/u";

		preg_match_all($property_pattern, $code, $matches, PREG_SET_ORDER);

		if ($matches != [])
		{
			$properties = [];
			foreach ($matches as $n => $match)
			{
				$declaration = $match[0] ?? null;

				if (is_string($declaration))
				{
					$comment = $this->extractDocBlock($code, $declaration);
					$declaration = trim(preg_replace('/\s{2,}/', ' ',
						preg_replace('/[\r\n]+/', ' ', $declaration)));

					$properties[] = [
						'name' => isset($match['name']) ? '$' . $match['name'] : 'error',
						'access' => $match['access'] ?? 'public',
						'type' => isset($match['type']) ? trim($match['type']) : null,
						'static' => (bool) $match['static'] ?? false,
						'default' => $match['default'] ?? null,
						'comment' => $comment,
						'declaration' => $declaration
					];
				}
			}

			return $properties;
		}

		return null;
	}

	/**
	 * Extracts method declarations and other details from the given code.
	 *
	 * @param string  $code  The code containing class methods
	 *
	 * @return array|null An array of method declarations and details
	 * @since 3.2.0
	 */
	private function methods(string $code): ?array
	{
		// regex to target all methods/functions
		$final_modifier = '(?P<final_modifier>final)?\s*';
		$abstract_modifier = '(?P<abstract_modifier>abstract)?\s*';
		$access_modifier = '(?P<access_modifier>public|protected|private)?\s*';
		$static_modifier = '(?P<static_modifier>static)?\s*';
		$modifier = "{$final_modifier}{$abstract_modifier}{$access_modifier}{$static_modifier}";
		$name = '(?P<name>\w+)';
		$arguments = '(?P<arguments>\(.*?\))?';
		$return_type = '(?P<return_type>\s*:\s*(?:\?[\w\\\\]+|\\\\?[\w\\\\]+(?:\|\s*(?:\?[\w\\\\]+|\\\\?[\w\\\\]+))*)?)?';
		$method_pattern = "/(^\s*?\b{$modifier}function\s+{$name}{$arguments}{$return_type})/sm";

		preg_match_all($method_pattern, $code, $matches, PREG_SET_ORDER);

		if ($matches != [])
		{
			$methods = [];
			foreach ($matches as $n => $match)
			{
				$full_declaration = $match[0] ?? null;

				if (is_string($full_declaration))
				{
					$comment = $this->extractDocBlock($code, $full_declaration);

					$full_declaration = trim(preg_replace('/\s{2,}/', ' ',
						preg_replace('/[\r\n]+/', ' ', $full_declaration)));

					// extract method's body
					$start_pos = strpos($code, $full_declaration) + strlen($full_declaration);
					$method_body = $this->extractMethodBody($code, $start_pos);

					// now load what we found
					$methods[] = [
						'name' => $match['name'] ?? 'error',
						'access' => $match['access_modifier'] ?? 'public',
						'static' => (bool) $match['static_modifier'] ?? false,
						'final' => (bool) $match['final_modifier'] ?? false,
						'abstract' => (bool) $match['abstract_modifier'] ?? false,
						'return_type' => $this->extractReturnType($match['return_type'] ?? null, $comment),
						'since' => $this->extractSinceVersion($comment),
						'deprecated' => $this->extractDeprecatedVersion($comment),
						'arguments' => $this->extractFunctionArgumentDetails($comment, $match['arguments'] ?? null),
						'comment' => $comment,
						'declaration' => str_replace(["\r\n", "\r", "\n"], '', $full_declaration),
						'body' => $method_body
					];
				}
			}

			return $methods;
		}

		return null;
	}

	/**
	 * Extracts the PHPDoc block for a given function declaration.
	 *
	 * @param string $code         The source code containing the function
	 * @param string $declaration  The part of the function declaration
	 *
	 * @return string|null  The PHPDoc block, or null if not found
	 * @since 3.2.0
	 */
	private function extractDocBlock(string $code, string $declaration): ?string
	{
		// Split the code string with the function declaration
		$parts = explode($declaration, $code);
		if (count($parts) < 2)
		{
			// Function declaration not found in the code
			return null;
		}

		// Get the part with the comment (if any)
		$comment = $parts[0];

		// Split the last part using the comment block start marker
		$commentParts = preg_split('/(})?\s+(?=\s*\/\*)(\*)?/', $comment);

		// Get the last comment block
		$lastCommentPart = end($commentParts);

		// Search for the comment block in the last comment part
		if (preg_match('/(\/\*\*[\s\S]*?\*\/)\s*$/u', $lastCommentPart, $matches))
		{
			$comment = $matches[1] ?? null;
			// check if we actually have a comment
			if ($comment)
			{
				return $this->removeWhiteSpaceFromComment($comment);
			}
		}

		return null;
	}

	/**
	 * Extracts method body based on starting position of method declaration.
	 *
	 * @param string $code      The class code
	 * @param string $startPos  The starting position of method declaration
	 *
	 * @return string|null Method body or null if not found
	 * @since 3.2.0
	 */
	private function extractMethodBody(string $code, int $startPos): ?string
	{
		$braces_count = 0;
		$in_method = false;
		$method_body = "";

		for ($i = $startPos; $i < strlen($code); $i++) {
			if ($code[$i] === '{')
			{
				$braces_count++;
				if (!$in_method)
				{
					$in_method = true;
					continue;
				}
			}

			if ($code[$i] === '}')
			{
				$braces_count--;
			}

			if ($in_method)
			{
				$method_body .= $code[$i];
			}

			if ($braces_count <= 0 && $in_method)
			{
				// remove the closing brace
				$method_body = substr($method_body, 0, -1);
				break;
			}
		}

		return $in_method ? $method_body : null;
	}

	/**
	 * Extracts the function argument details.
	 *
	 * @param string|null $comment    The function comment if found
	 * @param string|null $arguments  The arguments found on function declaration
	 *
	 * @return array|null  The function argument details
	 * @since 3.2.0
	 */
	private function extractFunctionArgumentDetails(?string $comment, ?string $arguments): ?array
	{
		$arg_types_from_declaration = $this->extractArgTypesArguments($arguments);
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

		return trim(trim($returnType, ':'));
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
	 *
	 * @return array|null   An array of argument types
	 * @since 3.2.0
	 */
	private function extractArgTypesArguments(?string $arguments): ?array
	{
		if ($arguments)
		{
			$args = preg_split('/,(?![^()\[\]]*(\)|\]))/', trim($arguments, '()'));
			if ($args !== [])
			{
				$argument_types = [];
				foreach ($args as $arg)
				{
					$eqPos = strpos($arg, '=');

					if ($eqPos !== false)
					{
						$arg_parts = [
							substr($arg, 0, $eqPos),
							substr($arg, $eqPos + 1)
						];
					}
					else
					{
						$arg_parts = [$arg];
					}

					if (preg_match('/(?:(\??(?:\w+|\\\\[\w\\\\]+)(?:\|\s*\??(?:\w+|\\\\[\w\\\\]+))*)\s+)?\$(\w+)/', $arg_parts[0], $arg_matches))
					{
						$type = $arg_matches[1] ?: null;
						$name = $arg_matches[2] ?: null;
						$default = isset($arg_parts[1]) ? preg_replace('/\s{2,}/', ' ',
							preg_replace('/[\r\n]+/', ' ', trim($arg_parts[1]))) : null;

						if (is_string($name))
						{
							$argument_types['$' . $name] = [
								'type' => $type,
								'default' => $default,
							];
						}
					}
				}

				return $argument_types;
			}
		}

		return null;
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
				'default' => $declarationInfo['default'] ?: null,
			];
		}

		return $mergedArguments;
	}

}

