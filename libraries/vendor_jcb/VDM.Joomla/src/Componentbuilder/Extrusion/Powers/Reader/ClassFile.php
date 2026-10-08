<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    22nd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Powers\Reader;


use VDM\Joomla\Componentbuilder\Power\Parser;


/**
 * Reads one PHP file into the parts a power row stores.
 * 
 * The declaration is located with PHP's own lexer rather than patterns, so a
 * class name inside a string, a ::class constant, or an anonymous class can
 * never be mistaken for the file's declaration. The body, license and import
 * statements come from the shared power Parser, so what this reader extracts is
 * exactly what the compiler will later reassemble.
 * 
 * Reading never interprets: what a parent or import refers to is the
 * assembler's question, so this class hands back names exactly as written.
 * 
 * @since 6.1.7
 */
final class ClassFile
{
	/**
	 * The declaration keywords and the power type each one declares.
	 *
	 * An enum has no power type, so it is read but reported unsupported.
	 *
	 * @var    array<int, string|null>
	 * @since  6.1.7
	 */
	private const KINDS = [
		T_CLASS => 'class',
		T_INTERFACE => 'interface',
		T_TRAIT => 'trait',
		T_ENUM => null
	];

	/**
	 * The Power Parser.
	 *
	 * @var    Parser
	 * @since  6.1.7
	 */
	protected Parser $parser;

	/**
	 * Constructor.
	 *
	 * @param   Parser  $parser  The shared power parser.
	 *
	 * @since   6.1.7
	 */
	public function __construct(Parser $parser)
	{
		$this->parser = $parser;
	}

	/**
	 * Read one PHP file's source into the parts a power row stores.
	 *
	 * @param   string  $code  The complete file source.
	 *
	 * @return  array{
	 *              namespace: string, class: string, type: string|null,
	 *              docblock: string, license: string,
	 *              extends: array<string>, implements: array<string>,
	 *              uses: array<int, array{raw: string, name: string, alias: string|null, kind: string}>,
	 *              body: string|null
	 *          }|null  The parts, or null when the file declares no class at all.
	 * @since   6.1.7
	 */
	public function read(string $code): ?array
	{
		// one text for the lexer, the parser and every offset alike
		if (strncmp($code, "\xEF\xBB\xBF", 3) === 0)
		{
			$code = substr($code, 3);
		}

		$code = str_replace(["\r\n", "\r"], "\n", $code);
		$declaration = $this->declaration($code);

		if ($declaration === null)
		{
			return null;
		}

		$offset = (int) $declaration['offset'];
		unset($declaration['offset']);

		$declaration['license'] = $this->license($code);
		$declaration['uses'] = $this->imports($code);

		// null says the parser could not slice the body the lexer promised,
		// which is a fact the caller must see -- an empty body is only real
		// when the declaration itself is empty
		$body = $this->parser->getClassCode($code);

		// a body that does not follow the located declaration was sliced off
		// something else in the file, such as an anonymous class above it
		if (is_string($body) && $body !== '')
		{
			$at = strpos($code, $body, $offset);

			$body = $at === false
				? null
				: $this->indented($code, $body, $at);
		}

		$declaration['body'] = $body;

		return $declaration;
	}

	/**
	 * Give the body back the indentation its first line carried in the file.
	 *
	 * The parser trims the body it slices, which takes the tab off the first
	 * line alone: every other line keeps its indentation, so the stored body
	 * would open one tab to the left of the rest. JCB stores a body with its
	 * first line indented like the others, and a person editing it expects
	 * exactly that.
	 *
	 * @param   string  $code  The complete file source.
	 * @param   string  $body  The sliced body.
	 * @param   int     $at    The byte offset the body starts at in the source.
	 *
	 * @return  string  The body, its first line indented as it was.
	 * @since   6.1.9
	 */
	protected function indented(string $code, string $body, int $at): string
	{
		$line = strrpos(substr($code, 0, $at), "\n");
		$indent = substr($code, $line === false ? 0 : $line + 1, $at - ($line === false ? 0 : $line + 1));

		return (trim($indent, " \t") === '' ? $indent : '') . $body;
	}

	/**
	 * Locate and decompose the first real type declaration in the file.
	 *
	 * @param   string  $code  The complete file source.
	 *
	 * @return  array{
	 *              namespace: string, class: string, type: string|null,
	 *              docblock: string, extends: array<string>, implements: array<string>,
	 *              offset: int
	 *          }|null  The declaration parts, or null when none was found.
	 * @since   6.1.7
	 */
	protected function declaration(string $code): ?array
	{
		$tokens = @token_get_all($code);

		if (!is_array($tokens) || $tokens === [])
		{
			return null;
		}

		$namespace = '';
		$docblock = null;
		$final = false;
		$abstract = false;
		$previous = 0;
		$total = count($tokens);

		for ($i = 0; $i < $total; $i++)
		{
			$token = $tokens[$i];

			if (!is_array($token))
			{
				// punctuation ends whatever statement the last docblock described
				$docblock = null;
				$final = false;
				$abstract = false;
				$previous = 0;

				continue;
			}

			switch ($token[0])
			{
				case T_WHITESPACE:
				case T_COMMENT:
					continue 2;

				case T_DOC_COMMENT:
					$docblock = $token[1];
					continue 2;

				case T_ATTRIBUTE:
					// an attribute stands between a docblock and its subject
					$i = $this->closingBracket($tokens, $i);
					continue 2;

				case T_NAMESPACE:
					$namespace = $this->name($tokens, $i);
					$docblock = null;
					$final = false;
					$abstract = false;
					$previous = $token[0];
					continue 2;

				case T_FINAL:
					$final = true;
					$previous = $token[0];
					continue 2;

				case T_ABSTRACT:
					$abstract = true;
					$previous = $token[0];
					continue 2;

				case T_READONLY:
					// a readonly class is still stored as a plain class, and
					// a readonly anonymous class is still anonymous
					if ($previous !== T_NEW)
					{
						$previous = $token[0];
					}
					continue 2;

				case T_CLASS:
				case T_INTERFACE:
				case T_TRAIT:
				case T_ENUM:
					// a ::class constant or an anonymous class is not a declaration
					if ($previous === T_DOUBLE_COLON || $previous === T_NEW)
					{
						$previous = $token[0];
						continue 2;
					}

					$parts = $this->decompose(
						$tokens, $i, $token[0], $namespace,
						$docblock, $final, $abstract
					);

					if ($parts !== null)
					{
						$parts['offset'] = $this->offset($tokens, $i);
					}

					return $parts;

				default:
					// any other statement claims the docblock and the modifiers
					$docblock = null;
					$final = false;
					$abstract = false;
					$previous = $token[0];
					continue 2;
			}
		}

		return null;
	}

	/**
	 * Decompose one located declaration into its parts.
	 *
	 * @param   array<int, mixed>  $tokens     The file's tokens.
	 * @param   int                $at         The offset of the declaration keyword.
	 * @param   int                $kind       The declaration keyword token.
	 * @param   string             $namespace  The namespace the declaration sits in.
	 * @param   string|null        $docblock   The docblock standing above it.
	 * @param   bool               $final      Whether it was declared final.
	 * @param   bool               $abstract   Whether it was declared abstract.
	 *
	 * @return  array{
	 *              namespace: string, class: string, type: string|null,
	 *              docblock: string, extends: array<string>, implements: array<string>
	 *          }|null  The declaration parts, or null when it carries no name.
	 * @since   6.1.7
	 */
	protected function decompose(
		array $tokens,
		int $at,
		int $kind,
		string $namespace,
		?string $docblock,
		bool $final,
		bool $abstract
	): ?array
	{
		$class = '';
		$named = ['extends' => [], 'implements' => []];
		$bucket = '';
		$buffer = '';
		$total = count($tokens);

		for ($i = $at + 1; $i < $total; $i++)
		{
			$token = $tokens[$i];

			if (!is_array($token))
			{
				if ($token === '{')
				{
					break;
				}

				if ($token === ',' && $bucket !== '' && $buffer !== '')
				{
					$named[$bucket][] = $buffer;
					$buffer = '';
				}

				continue;
			}

			switch ($token[0])
			{
				case T_STRING:
				case T_NAME_QUALIFIED:
				case T_NAME_FULLY_QUALIFIED:
				case T_NAME_RELATIVE:
				case T_NS_SEPARATOR:
					if ($class === '')
					{
						$class = $token[1];
					}
					elseif ($bucket !== '')
					{
						$buffer .= $token[1];
					}
					break;

				case T_EXTENDS:
				case T_IMPLEMENTS:
					if ($bucket !== '' && $buffer !== '')
					{
						$named[$bucket][] = $buffer;
						$buffer = '';
					}

					$bucket = $token[0] === T_EXTENDS ? 'extends' : 'implements';
					break;
			}
		}

		if ($bucket !== '' && $buffer !== '')
		{
			$named[$bucket][] = $buffer;
		}

		if ($class === '')
		{
			return null;
		}

		$type = self::KINDS[$kind];

		if ($type === 'class' && $abstract)
		{
			$type = 'abstract class';
		}
		elseif ($type === 'class' && $final)
		{
			$type = 'final class';
		}

		return [
			'namespace' => $namespace,
			'class' => $class,
			'type' => $type,
			'docblock' => $this->comment((string) $docblock),
			'extends' => $named['extends'],
			'implements' => $named['implements']
		];
	}

	/**
	 * The file's license header, as the complete comment block.
	 *
	 * A power's licensing template stores the whole block, markers included,
	 * exactly as the compiler will emit it again -- so the block is taken
	 * verbatim rather than through the parser, which strips the markers.
	 * Only a comment that opens the file states its license.
	 *
	 * @param   string  $code  The complete file source.
	 *
	 * @return  string  The license block, or an empty string.
	 * @since   6.1.7
	 */
	protected function license(string $code): string
	{
		if (preg_match('/\A(?:\xEF\xBB\xBF)?<\?php\s+(\/\*.*?\*\/)/s', $code, $matches) === 1)
		{
			// JCB keeps the block with the line break that closes it, which is
			// what puts the blank line between the licence and the namespace
			return $matches[1] . "\n";
		}

		return '';
	}

	/**
	 * Every import statement above the class, decomposed for linking.
	 *
	 * @param   string  $code  The complete file source.
	 *
	 * @return  array<int, array{raw: string, name: string, alias: string|null, kind: string}>  The imports.
	 * @since   6.1.7
	 */
	protected function imports(string $code): array
	{
		$imports = [];

		foreach ((array) $this->parser->getUseStatements($code) as $statement)
		{
			foreach ($this->import((string) $statement) as $import)
			{
				$imports[] = $import;
			}
		}

		return $imports;
	}

	/**
	 * Decompose one import statement, expanding groups and comma lists.
	 *
	 * @param   string  $statement  The complete use statement.
	 *
	 * @return  array<int, array{raw: string, name: string, alias: string|null, kind: string}>  The imports it binds.
	 * @since   6.1.7
	 */
	protected function import(string $statement): array
	{
		$inner = trim(preg_replace('/^use\s+/i', '', rtrim(trim($statement), ';')));
		$kind = 'class';

		if (preg_match('/^(function|const)\s+/i', $inner, $matches) === 1)
		{
			$kind = strtolower($matches[1]);
			$inner = trim(substr($inner, strlen($matches[0])));
		}

		// a group import binds every branch under one prefix
		if (preg_match('/^([^\{\}]+)\{([^\{\}]+)\}$/', $inner, $matches) === 1)
		{
			$prefix = rtrim(trim($matches[1]), '\\');
			$branches = explode(',', $matches[2]);
			$imports = [];

			foreach ($branches as $branch)
			{
				$branch = trim($branch);

				// a trailing comma leaves an empty branch behind
				if ($branch === '')
				{
					continue;
				}

				// a branch may carry its own function or const marker
				$branchKind = $kind;

				if (preg_match('/^(function|const)\s+/i', $branch, $marked) === 1)
				{
					$branchKind = strtolower($marked[1]);
					$branch = trim(substr($branch, strlen($marked[0])));
				}

				$import = $this->binding($prefix . '\\' . $branch, $branchKind);

				if ($import !== null)
				{
					$imports[] = $import;
				}
			}

			return $imports;
		}

		$imports = [];

		foreach (explode(',', $inner) as $part)
		{
			$part = trim($part);

			if ($part === '')
			{
				continue;
			}

			$import = $this->binding($part, $kind);

			if ($import !== null)
			{
				$imports[] = $import;
			}
		}

		return $imports;
	}

	/**
	 * Decompose one name-with-optional-alias binding.
	 *
	 * @param   string  $binding  The bound name, possibly aliased.
	 * @param   string  $kind     Whether a class, function or const was bound.
	 *
	 * @return  array{raw: string, name: string, alias: string|null, kind: string}|null  The import, or null when empty.
	 * @since   6.1.7
	 */
	protected function binding(string $binding, string $kind): ?array
	{
		$alias = null;

		if (preg_match('/^(.*?)\s+as\s+(\S+)$/i', $binding, $matches) === 1)
		{
			$binding = trim($matches[1]);
			$alias = trim($matches[2]);
		}

		$binding = trim(trim($binding), '\\');

		if ($binding === '')
		{
			return null;
		}

		$prefix = $kind === 'class' ? '' : $kind . ' ';

		return [
			'raw' => 'use ' . $prefix . $binding
				. ($alias !== null ? ' as ' . $alias : '') . ';',
			'name' => $binding,
			'alias' => $alias,
			'kind' => $kind
		];
	}

	/**
	 * The byte offset at which the token at the given index starts.
	 *
	 * @param   array<int, mixed>  $tokens  The file's tokens.
	 * @param   int                $at      The token index.
	 *
	 * @return  int  The byte offset in the tokenised text.
	 * @since   6.1.7
	 */
	protected function offset(array $tokens, int $at): int
	{
		$offset = 0;

		for ($i = 0; $i < $at; $i++)
		{
			$offset += strlen(is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i]);
		}

		return $offset;
	}

	/**
	 * The offset that closes the attribute opened at the given offset.
	 *
	 * @param   array<int, mixed>  $tokens  The file's tokens.
	 * @param   int                $at      The offset of the attribute opener.
	 *
	 * @return  int  The offset of the closing bracket, or the last offset.
	 * @since   6.1.7
	 */
	protected function closingBracket(array $tokens, int $at): int
	{
		$depth = 1;
		$total = count($tokens);

		for ($i = $at + 1; $i < $total; $i++)
		{
			$token = $tokens[$i];

			if ($token === '[')
			{
				$depth++;
			}
			elseif ($token === ']' && --$depth === 0)
			{
				return $i;
			}
		}

		return $total - 1;
	}

	/**
	 * The name written directly after the token at the given offset.
	 *
	 * @param   array<int, mixed>  $tokens  The file's tokens.
	 * @param   int                $at      The offset of the introducing keyword.
	 *
	 * @return  string  The name, or an empty string.
	 * @since   6.1.7
	 */
	protected function name(array $tokens, int $at): string
	{
		$name = '';
		$total = count($tokens);

		for ($i = $at + 1; $i < $total; $i++)
		{
			$token = $tokens[$i];

			if (!is_array($token))
			{
				break;
			}

			if ($token[0] === T_WHITESPACE || $token[0] === T_COMMENT)
			{
				continue;
			}

			if ($token[0] === T_STRING
				|| $token[0] === T_NAME_QUALIFIED
				|| $token[0] === T_NS_SEPARATOR)
			{
				$name .= $token[1];
				continue;
			}

			break;
		}

		return trim($name, '\\');
	}

	/**
	 * Strip the comment markers off a docblock, keeping its text.
	 *
	 * @param   string  $comment  The raw docblock.
	 *
	 * @return  string  The cleaned text, line by line.
	 * @since   6.1.7
	 */
	protected function comment(string $comment): string
	{
		if ($comment === '')
		{
			return '';
		}

		$comment = str_replace(["\r\n", "\r"], "\n", $comment);
		$comment = preg_replace('/^\/\*\*[\r\n\s]*|[\r\n\s]*\*\/$/m', '', $comment);
		$comment = preg_replace('/^[ \t]*\*[ \t]?/m', '', (string) $comment);
		// only the comment's own margin comes off: a line indented further
		// than its neighbours is indented on purpose, and the description
		// keeps it -- JCB writes the description back exactly as stored
		$lines = array_map('rtrim', explode("\n", (string) $comment));

		// a description keeps its blank lines, exactly as a power stores it
		return trim(implode("\n", $lines), "\n");
	}
}

