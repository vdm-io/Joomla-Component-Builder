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

namespace VDM\Joomla\Componentbuilder\Extrusion\Reader\Php;


/**
 * A literal-only reader for one array-literal class property.
 * 
 * This class is a security boundary, not a convenience. A component source tree
 * may be an unzipped upload, so the file it describes is never included,
 * required, or evaluated, and the extracted literal is never handed to eval.
 * The only mechanism used is token_get_all, which lexes without executing.
 * 
 * The accepted token set is deliberately tiny: quoted strings, integers,
 * floats, square brackets, commas, double arrows, whitespace, comments, a unary
 * minus in front of a number, and the bare words NULL, true, and false. Anything
 * else -- a variable, a constant, a class reference, a concatenation, a function
 * call, an interpolated string, a heredoc, or the array() long form -- aborts
 * the whole parse and returns null. Nothing is partially trusted: a refusal
 * discards the entire result rather than the offending element, and reason()
 * explains what was seen so the run can drop to the next precedence tier.
 * 
 * @since 6.1.6
 */
final class Literal
{
	/**
	 * The deepest array nesting this parser will follow.
	 *
	 * A pathological literal is refused rather than allowed to exhaust the
	 * stack, which keeps an untrusted file from turning a read into a crash.
	 *
	 * @var    int
	 * @since  6.1.6
	 */
	private const MAX_DEPTH = 32;

	/**
	 * The single-character escape sequences a double-quoted literal may carry.
	 *
	 * @var    array<string, string>
	 * @since  6.1.6
	 */
	private const ESCAPES = [
		'n' => "\n",
		't' => "\t",
		'r' => "\r",
		'v' => "\v",
		'e' => "\e",
		'f' => "\f",
		'\\' => '\\',
		'$' => '$',
		'"' => '"'
	];

	/**
	 * Why the last parse refused, or null when it succeeded.
	 *
	 * @var    string|null
	 * @since  6.1.6
	 */
	private ?string $reason = null;

	/**
	 * Parse one array-literal property out of PHP source text.
	 *
	 * @param   string  $source    The complete PHP source, as text.
	 * @param   string  $property  The property name, without its dollar sign.
	 *
	 * @return  array|null  The native array, or null when the read was refused.
	 * @since   6.1.6
	 */
	public function parse(string $source, string $property): ?array
	{
		$this->reason = null;

		if ($source === '' || $property === '')
		{
			$this->refuse('nothing to parse', 1);

			return null;
		}

		$tokens = $this->tokens($source);
		$index = $this->declaration($tokens, $property);

		if ($index === null)
		{
			return null;
		}

		$value = $this->literal($tokens, $index, 1);

		if ($this->reason !== null)
		{
			return null;
		}

		return $value;
	}

	/**
	 * Why the last parse refused.
	 *
	 * @return  string|null  The refusal reason, or null when nothing was refused.
	 * @since   6.1.6
	 */
	public function reason(): ?string
	{
		return $this->reason;
	}

	/**
	 * Lex the source without executing any part of it.
	 *
	 * @param   string  $source  The complete PHP source, as text.
	 *
	 * @return  array<int, array{0: int, 1: string, 2?: int}|string>  The token stream.
	 * @since   6.1.6
	 */
	private function tokens(string $source): array
	{
		$tokens = @token_get_all($source);

		return is_array($tokens) ? $tokens : [];
	}

	/**
	 * Find the opening bracket of the wanted property's array literal.
	 *
	 * A declaration without an initialiser, such as the abstract parent's own
	 * property, is not a match and the scan simply continues.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens    The token stream.
	 * @param   string                                               $property  The property name.
	 *
	 * @return  int|null  The token index of the opening bracket, or null.
	 * @since   6.1.6
	 */
	private function declaration(array $tokens, string $property): ?int
	{
		$count = count($tokens);
		$wanted = '$' . $property;
		$modifiers = $this->modifiers();

		for ($index = 0; $index < $count; $index++)
		{
			$token = $tokens[$index];

			if (!is_array($token)
				|| !in_array($token[0], [T_PUBLIC, T_PROTECTED, T_PRIVATE], true))
			{
				continue;
			}

			$cursor = $this->next($tokens, $index);

			while ($cursor < $count)
			{
				$part = $tokens[$cursor];

				if ($part === '?' || $part === '|'
					|| (is_array($part) && in_array($part[0], $modifiers, true)))
				{
					$cursor = $this->next($tokens, $cursor);

					continue;
				}

				break;
			}

			$part = $tokens[$cursor] ?? null;

			if (!is_array($part) || $part[0] !== T_VARIABLE || $part[1] !== $wanted)
			{
				continue;
			}

			$cursor = $this->next($tokens, $cursor);

			if (($tokens[$cursor] ?? null) !== '=')
			{
				continue;
			}

			$cursor = $this->next($tokens, $cursor);

			if (($tokens[$cursor] ?? null) === '[')
			{
				return $cursor;
			}

			$this->refuse(
				'the ' . $wanted . ' property is not initialised with a short array literal',
				$this->line($tokens, $cursor)
			);

			return null;
		}

		$this->refuse(
			'no ' . $wanted . ' array property was declared in the source',
			1
		);

		return null;
	}

	/**
	 * The tokens that may sit between a visibility keyword and the property.
	 *
	 * @return  array<int>  The skippable token identifiers.
	 * @since   6.1.6
	 */
	private function modifiers(): array
	{
		$modifiers = [T_STATIC, T_ARRAY, T_STRING, T_NS_SEPARATOR];

		foreach (['T_READONLY', 'T_NAME_QUALIFIED', 'T_NAME_FULLY_QUALIFIED'] as $name)
		{
			if (defined($name))
			{
				$modifiers[] = constant($name);
			}
		}

		return $modifiers;
	}

	/**
	 * Parse one array literal, starting at its opening bracket.
	 *
	 * On return the cursor sits on the first significant token after the
	 * literal's closing bracket.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens  The token stream.
	 * @param   int                                                  $index   The cursor, by reference.
	 * @param   int                                                  $depth   The nesting depth of this literal.
	 *
	 * @return  array|null  The parsed array, or null when the read was refused.
	 * @since   6.1.6
	 */
	private function literal(array $tokens, int &$index, int $depth): ?array
	{
		if ($depth > self::MAX_DEPTH)
		{
			$this->refuse(
				'the array literal nests deeper than ' . self::MAX_DEPTH . ' levels',
				$this->line($tokens, $index)
			);

			return null;
		}

		$result = [];
		$auto = null;
		$index = $this->next($tokens, $index);

		while (true)
		{
			$token = $tokens[$index] ?? null;

			if ($token === null)
			{
				$this->refuse(
					'the array literal is never closed',
					$this->line($tokens, $index)
				);

				return null;
			}

			if ($token === ']')
			{
				$index = $this->next($tokens, $index);

				return $result;
			}

			$first = $this->value($tokens, $index, $depth);

			if ($this->reason !== null)
			{
				return null;
			}

			$token = $tokens[$index] ?? null;

			if (is_array($token) && $token[0] === T_DOUBLE_ARROW)
			{
				$index = $this->next($tokens, $index);

				if (!is_int($first) && !is_string($first))
				{
					$this->refuse(
						'an array key must be a quoted string or an integer',
						$this->line($tokens, $index)
					);

					return null;
				}

				$first = $this->normalise($first);

				$value = $this->value($tokens, $index, $depth);

				if ($this->reason !== null)
				{
					return null;
				}

				$result[$first] = $value;

				if (is_int($first))
				{
					$auto = $this->advance($auto, $first);
				}
			}
			else
			{
				$position = $auto ?? 0;
				$result[$position] = $first;
				$auto = $this->advance($auto, $position);
			}

			$token = $tokens[$index] ?? null;

			if ($token === ',')
			{
				$index = $this->next($tokens, $index);

				continue;
			}

			if ($token === ']')
			{
				$index = $this->next($tokens, $index);

				return $result;
			}

			$this->refuse(
				'expected a comma or a closing bracket, saw ' . $this->describe($token),
				$this->line($tokens, $index)
			);

			return null;
		}
	}

	/**
	 * Parse one literal value, refusing anything that is not literal.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens  The token stream.
	 * @param   int                                                  $index   The cursor, by reference.
	 * @param   int                                                  $depth   The nesting depth of the holding array.
	 *
	 * @return  mixed  The literal value, or null when the read was refused.
	 * @since   6.1.6
	 */
	private function value(array $tokens, int &$index, int $depth)
	{
		$token = $tokens[$index] ?? null;

		if ($token === '[')
		{
			return $this->literal($tokens, $index, $depth + 1);
		}

		if ($token === '-')
		{
			return $this->negative($tokens, $index);
		}

		if (!is_array($token))
		{
			$this->refuse(
				'expected a literal value, saw ' . $this->describe($token),
				$this->line($tokens, $index)
			);

			return null;
		}

		if ($token[0] === T_CONSTANT_ENCAPSED_STRING)
		{
			return $this->string($tokens, $index);
		}

		if ($token[0] === T_LNUMBER)
		{
			$index = $this->next($tokens, $index);

			return $this->integer($token[1]);
		}

		if ($token[0] === T_DNUMBER)
		{
			$index = $this->next($tokens, $index);

			return (float) str_replace('_', '', $token[1]);
		}

		if ($token[0] === T_STRING)
		{
			return $this->word($tokens, $index, $token[1]);
		}

		$this->refuse(
			'only literal values are accepted, saw ' . $this->describe($token),
			$this->line($tokens, $index)
		);

		return null;
	}

	/**
	 * Parse a unary minus applied to a number.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens  The token stream.
	 * @param   int                                                  $index   The cursor, by reference.
	 *
	 * @return  int|float|null  The negated number, or null when refused.
	 * @since   6.1.6
	 */
	private function negative(array $tokens, int &$index)
	{
		$cursor = $this->next($tokens, $index);
		$token = $tokens[$cursor] ?? null;

		if (!is_array($token) || ($token[0] !== T_LNUMBER && $token[0] !== T_DNUMBER))
		{
			$this->refuse(
				'a minus sign is only accepted in front of a number',
				$this->line($tokens, $cursor)
			);

			return null;
		}

		$index = $this->next($tokens, $cursor);

		if ($token[0] === T_LNUMBER)
		{
			return -$this->integer($token[1]);
		}

		return -(float) str_replace('_', '', $token[1]);
	}

	/**
	 * Parse one quoted string literal, unescaping it correctly.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens  The token stream.
	 * @param   int                                                  $index   The cursor, by reference.
	 *
	 * @return  string|null  The unescaped string, or null when refused.
	 * @since   6.1.6
	 */
	private function string(array $tokens, int &$index): ?string
	{
		$token = $tokens[$index];
		$value = $this->unquote($token[1]);

		if ($value === null)
		{
			$this->refuse(
				'a quoted string literal could not be unescaped',
				$this->line($tokens, $index)
			);

			return null;
		}

		$index = $this->next($tokens, $index);

		return $value;
	}

	/**
	 * Parse one bare word, accepting only NULL, true, and false.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens  The token stream.
	 * @param   int                                                  $index   The cursor, by reference.
	 * @param   string                                               $word    The bare word's text.
	 *
	 * @return  bool|null  The keyword value, or null for NULL and for a refusal.
	 * @since   6.1.6
	 */
	private function word(array $tokens, int &$index, string $word): ?bool
	{
		$lower = strtolower($word);

		if ($lower !== 'null' && $lower !== 'true' && $lower !== 'false')
		{
			$this->refuse(
				'the bare word ' . $word . ' is not a literal; only NULL, true, and false are accepted',
				$this->line($tokens, $index)
			);

			return null;
		}

		$cursor = $this->next($tokens, $index);
		$following = $tokens[$cursor] ?? null;

		if ($following === '(' || $following === '['
			|| (is_array($following) && $following[0] === T_DOUBLE_COLON))
		{
			$this->refuse(
				'the bare word ' . $word . ' is used as a call or a reference, not as a literal',
				$this->line($tokens, $index)
			);

			return null;
		}

		$index = $cursor;

		if ($lower === 'null')
		{
			return null;
		}

		return $lower === 'true';
	}

	/**
	 * Move PHP's next-free-element counter past one integer key.
	 *
	 * This mirrors the engine's own counter rather than simply counting upwards,
	 * because the position a keyless element takes depends on every integer key
	 * declared before it. The counter has no value until the first integer key is
	 * seen, which is why a negative key can seed it below zero.
	 *
	 * PHP 8.3 changed that seeding: before it, a negative key left the counter at
	 * zero, so [-3 => 'a', 'b'] put the second element at 0, while from 8.3 on it
	 * lands at -2. The running engine's rule is the one followed, so the parsed
	 * array matches what that engine would itself have built.
	 *
	 * @param   int|null  $auto  The counter so far, or null when unseeded.
	 * @param   int       $key   The integer key just stored.
	 *
	 * @return  int  The counter after the key.
	 * @since   6.1.6
	 */
	private function advance(?int $auto, int $key): int
	{
		$next = $key + 1;

		if ($auto === null)
		{
			return PHP_VERSION_ID >= 80300 ? $next : max(0, $next);
		}

		return max($auto, $next);
	}

	/**
	 * Apply PHP's own array-key normalisation to one parsed key.
	 *
	 * PHP stores a key like '5' as the integer 5, which also moves the position
	 * the next keyless element takes. Normalising here keeps the parsed array
	 * identical to what PHP would have built, including that knock-on position.
	 * Only a canonical decimal integer converts: a leading zero, a leading plus,
	 * a negative zero, and anything that would overflow all stay strings, exactly
	 * as PHP leaves them.
	 *
	 * @param   int|string  $key  The parsed key.
	 *
	 * @return  int|string  The normalised key.
	 * @since   6.1.6
	 */
	private function normalise($key)
	{
		if (!is_string($key) || preg_match('/^(?:0|-?[1-9][0-9]*)$/', $key) !== 1)
		{
			return $key;
		}

		$number = (int) $key;

		return (string) $number === $key ? $number : $key;
	}

	/**
	 * The index of the next significant token after one position.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens  The token stream.
	 * @param   int                                                  $index   The current position.
	 *
	 * @return  int  The next significant index, or the token count when exhausted.
	 * @since   6.1.6
	 */
	private function next(array $tokens, int $index): int
	{
		$count = count($tokens);

		for ($cursor = $index + 1; $cursor < $count; $cursor++)
		{
			$token = $tokens[$cursor];

			if (is_array($token)
				&& in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true))
			{
				continue;
			}

			return $cursor;
		}

		return $count;
	}

	/**
	 * The source line a token sits on.
	 *
	 * @param   array<int, array{0: int, 1: string, 2?: int}|string>  $tokens  The token stream.
	 * @param   int                                                  $index   The token position.
	 *
	 * @return  int  The one-based source line.
	 * @since   6.1.6
	 */
	private function line(array $tokens, int $index): int
	{
		for ($cursor = min($index, count($tokens) - 1); $cursor >= 0; $cursor--)
		{
			$token = $tokens[$cursor] ?? null;

			if (is_array($token) && isset($token[2]))
			{
				return (int) $token[2];
			}
		}

		return 1;
	}

	/**
	 * A human-readable name for one token.
	 *
	 * @param   array{0: int, 1: string, 2?: int}|string|null  $token  The token.
	 *
	 * @return  string  The description.
	 * @since   6.1.6
	 */
	private function describe($token): string
	{
		if ($token === null)
		{
			return 'the end of the source';
		}

		if (!is_array($token))
		{
			return '"' . $token . '"';
		}

		$name = token_name($token[0]);
		$text = trim($token[1]);

		if ($text === '' || strlen($text) > 40)
		{
			return $name;
		}

		return $name . ' "' . $text . '"';
	}

	/**
	 * Record a refusal, keeping the first one seen.
	 *
	 * @param   string  $reason  What was refused.
	 * @param   int     $line    The source line it was seen on.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function refuse(string $reason, int $line): void
	{
		if ($this->reason !== null)
		{
			return;
		}

		$this->reason = $reason . ' (line ' . $line . ')';
	}

	/**
	 * Convert one integer literal's text to an integer.
	 *
	 * @param   string  $text  The literal text, in any supported base.
	 *
	 * @return  int  The integer value.
	 * @since   6.1.6
	 */
	private function integer(string $text): int
	{
		$text = str_replace('_', '', $text);

		if (preg_match('/^0[oO]/', $text) === 1)
		{
			return (int) octdec(substr($text, 2));
		}

		return (int) intval($text, 0);
	}

	/**
	 * Unescape one quoted string literal's token text.
	 *
	 * A double-quoted literal only reaches this method when the lexer found no
	 * interpolation in it, because an interpolated string is not a single
	 * constant-encapsed token and is refused before it gets here.
	 *
	 * @param   string  $text  The token text, including its quotes.
	 *
	 * @return  string|null  The unescaped value, or null when it is not a string literal.
	 * @since   6.1.6
	 */
	private function unquote(string $text): ?string
	{
		$offset = 0;

		if ($text !== '' && ($text[0] === 'b' || $text[0] === 'B'))
		{
			$offset = 1;
		}

		$quote = $text[$offset] ?? '';

		if (strlen($text) < $offset + 2 || substr($text, -1) !== $quote)
		{
			return null;
		}

		$body = substr($text, $offset + 1, -1);

		if ($quote === "'")
		{
			return $this->single($body);
		}

		if ($quote === '"')
		{
			return $this->double($body);
		}

		return null;
	}

	/**
	 * Unescape a single-quoted literal's body.
	 *
	 * @param   string  $body  The literal body, without its quotes.
	 *
	 * @return  string  The unescaped value.
	 * @since   6.1.6
	 */
	private function single(string $body): string
	{
		$value = '';
		$length = strlen($body);

		for ($index = 0; $index < $length; $index++)
		{
			$character = $body[$index];
			$following = $body[$index + 1] ?? '';

			if ($character === '\\' && ($following === '\\' || $following === "'"))
			{
				$value .= $following;
				$index++;

				continue;
			}

			$value .= $character;
		}

		return $value;
	}

	/**
	 * Unescape a double-quoted literal's body.
	 *
	 * @param   string  $body  The literal body, without its quotes.
	 *
	 * @return  string  The unescaped value.
	 * @since   6.1.6
	 */
	private function double(string $body): string
	{
		$value = '';
		$length = strlen($body);

		for ($index = 0; $index < $length; $index++)
		{
			$character = $body[$index];

			if ($character !== '\\' || $index + 1 >= $length)
			{
				$value .= $character;

				continue;
			}

			$following = $body[$index + 1];

			if (isset(self::ESCAPES[$following]))
			{
				$value .= self::ESCAPES[$following];
				$index++;

				continue;
			}

			$consumed = 0;
			$value .= $this->sequence($body, $index, $following, $consumed);
			$index += $consumed;
		}

		return $value;
	}

	/**
	 * Expand one numeric or unicode escape sequence.
	 *
	 * @param   string  $body       The literal body.
	 * @param   int     $index      The offset of the backslash.
	 * @param   string  $following  The character after the backslash.
	 * @param   int     $consumed   How many extra bytes were consumed, by reference.
	 *
	 * @return  string  The expanded bytes, or the backslash when nothing matched.
	 * @since   6.1.6
	 */
	private function sequence(string $body, int $index, string $following, int &$consumed): string
	{
		if ($following === 'x'
			&& preg_match('/^[0-9A-Fa-f]{1,2}/', substr($body, $index + 2, 2), $match) === 1)
		{
			$consumed = 1 + strlen($match[0]);

			return chr((int) hexdec($match[0]));
		}

		if ($following === 'u'
			&& preg_match('/^\{([0-9A-Fa-f]{1,6})\}/', substr($body, $index + 2, 8), $match) === 1)
		{
			$consumed = 1 + strlen($match[0]);

			return $this->codepoint((int) hexdec($match[1]));
		}

		if (preg_match('/^[0-7]{1,3}/', substr($body, $index + 1, 3), $match) === 1)
		{
			$consumed = strlen($match[0]);

			return chr(((int) octdec($match[0])) & 0xFF);
		}

		$consumed = 0;

		return '\\';
	}

	/**
	 * Encode one unicode codepoint as UTF-8.
	 *
	 * @param   int  $code  The codepoint.
	 *
	 * @return  string  The UTF-8 bytes.
	 * @since   6.1.6
	 */
	private function codepoint(int $code): string
	{
		if ($code < 0x80)
		{
			return chr($code);
		}

		if ($code < 0x800)
		{
			return chr(0xC0 | ($code >> 6)) . chr(0x80 | ($code & 0x3F));
		}

		if ($code < 0x10000)
		{
			return chr(0xE0 | ($code >> 12))
				. chr(0x80 | (($code >> 6) & 0x3F))
				. chr(0x80 | ($code & 0x3F));
		}

		return chr(0xF0 | ($code >> 18))
			. chr(0x80 | (($code >> 12) & 0x3F))
			. chr(0x80 | (($code >> 6) & 0x3F))
			. chr(0x80 | ($code & 0x3F));
	}
}

