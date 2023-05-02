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


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Power\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Power\Parser;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;


/**
 * Compiler Power Injector
 * @since 3.2.0
 */
final class Injector
{
	/**
	 * Power Objects
	 *
	 * @var    Power
	 * @since 3.2.0
	 **/
	protected Power $power;

	/**
	 * Compiler Powers Extractor
	 *
	 * @var    Extractor
	 * @since 3.2.0
	 **/
	protected Extractor $extractor;

	/**
	 * Compiler Powers Parser
	 *
	 * @var    Parser
	 * @since 3.2.0
	 **/
	protected Parser $parser;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * Super Power Update Map
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $map = [];

	/**
	 * Insert Use Statements
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $useStatements = [];

	/**
	 * Insert Trait Statements
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $traits = [];

	/**
	 * Constructor.
	 *
	 * @param Power|null         $power        The power object.
	 * @param Extractor|null     $extractor    The powers extractor object.
	 * @param Parser|null        $parser       The powers parser object.
	 * @param Placeholder|null      $placeholder  The compiler placeholder object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Power $power = null, ?Extractor $extractor = null,
		?Parser $parser = null, ?Placeholder $placeholder = null)
	{
		$this->power = $power ?: Compiler::_('Power');
		$this->extractor = $extractor ?: Compiler::_('Power.Extractor');
		$this->parser = $parser ?: Compiler::_('Power.Parser');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
	}

	/**
	 * Inject the powers found in the code
	 *
	 * @param string   $code The class code
	 *
	 * @return string   The updated code
	 * @since 3.2.0
	 */
	public function power(string $code): string
	{
		if (($guids = $this->extractor->get($code)) !== null)
		{
			return $this->update($guids, $code);
		}

		return $code;
	}

	/**
	 * Update the code
	 *
	 * @param array   $guids The Power guids found
	 * @param string   $code The class code
	 *
	 * @return string   The updated code
	 * @since 3.2.0
	 */
	protected function update(array $guids, string $code): string
	{
		$use_statements = $this->parser->getUseStatements($code);
		$traits = $this->parser->getTraits(
			$this->parser->getClassCode($code) ?? ''
		);

		// reset with each file
		$this->map = [];
		$this->useStatements = [];
		$this->traits = [];

		foreach ($guids as $key => $guid)
		{
			if  (($power = $this->power->get($guid)) !== null)
			{
				if (($name = $this->inspect($power, $use_statements, $traits)) !== null)
				{
					$this->map[$key] = $name;
				}
			}
		}

		// update
		if ($this->map !== [])
		{
			if ($this->useStatements !== [])
			{
				$code = $this->addUseStatements($code, $use_statements);
			}

			return $this->placeholder->update($code, $this->map);
		}

		return $code;
	}

	/**
	 * inspect the super power
	 *
	 * @param object|null  $power          The power object.
	 * @param array|null   $useStatements  The code use statments
	 * @param array|null   $traits         The code traits use statments
	 *
	 * @return string|null   The class name (or as name)
	 * @since 3.2.0
	 */
	protected function inspect(object $power, ?array $useStatements, ?array $traits): ?string
	{
		if (isset($power->type) && in_array($power->type, ['class', 'abstract class', 'final class', 'trait']))
		{
			$statement = 'use ' . $power->_namespace . '\\' . $power->class_name;
			// other class names
			$use_other = [];
			$trait_other = [];
			// some tracker globals
			$has_use_statement = false; // add if not found
			$has_trait_statement = !('trait' === $power->type); // don't add if not trait
			$name = null;
			$trait_name = null;

			// check if the name space is loaded
			if ($useStatements !== null)
			{
				foreach ($useStatements as $use_statement)
				{
					if ($use_statement === $statement . ';' || strpos($use_statement, $statement . ' as ') !== false)
					{
						$name = $this->getName($use_statement);
						$has_use_statement = true;
					}
					else
					{
						$tmp = $this->getName($use_statement);
						if ($power->class_name === $tmp)
						{
							$use_other[$tmp] = $tmp;
						}
					}
				}
			}

			// check if the trait is loaded
			if (!$has_trait_statement && $traits !== null)
			{
				$trait_statement = $name ??  $power->class_name;

				foreach ($traits as $trait)
				{
					if ($trait === $trait_statement)
					{
						$trait_name = $trait;
						$has_trait_statement = true;
					}
				}
			}

			// build the name
			$name = $trait_name ?? $name ?? $power->class_name;

			// if we have a trait we may need to add use and trait
			if ('trait' === $power->type)
			{
				if (!$has_trait_statement)
				{
					$this->traits[$name] = 'use ' . $name . ';';
				}
			}

			// check if we need to update the name
			if ($use_other !== [])
			{
				// set search namespace
				$namespace = ($name !== $power->class_name) ? $power->_namespace . '\\' . $power->class_name : $power->_namespace;

				// get the unique name
				$name = $this->getUniqueName($name, $namespace, $use_other);
			}

			if (!$has_use_statement)
			{
				// if the name is not the same as class name
				if ($name !== $power->class_name)
				{
					$statement .= ' as ' . $name . ';';
				}
				else
				{
					$statement .= ';';
				}

				$this->useStatements[$name] = $statement;
			}

			return $name;
		}

		return null;
	}

	/**
	 * Extracts the class name from a use statement.
	 *
	 * @param string $useStatement The use statement from which to extract the class name
	 *
	 * @return string|null The class name or null if not found
	 * @since 3.2.0
	 */
	protected function getName(string $useStatement): ?string
	{
		// If the input doesn't start with 'use ', assume it's a class name without a use statement
		if (strpos($useStatement, 'use ') !== 0)
		{
			$parts = explode('\\', $useStatement);
			$result = end($parts);

			// Remove '\\' from the beginning and end of the resulting string
			$result = trim($result, '\\');

			// If the resulting string is empty, return null
			return empty($result) ? null : $result;
		}

		$pattern = '/use\s+([\w\\\\]+)(?:\s+as\s+)?([\w]+)?;/';

		if (preg_match($pattern, $useStatement, $matches))
		{
			// If there's an alias, return it
			if (!empty($matches[2]))
			{
				return $matches[2];
			}

			// If there's no alias, extract the class name from the namespace
			$parts = explode('\\', $matches[1]);
			return end($parts);
		}

		return null;
	}

	/**
	 * Removes the last space from the namespace.
	 *
	 * @param string $name      The current name
	 * @param string $namespace The namespace
	 * @param array $useOther   The other use names
	 *
	 * @return string The namespace shortened
	 * @since 3.2.0
	 */
	protected function getUniqueName(string $name, string $namespace, array $useOther): string
	{
		// if the name is already used
		while (isset($useOther[$name]))
		{
			if (($tmp = $this->getName($namespace)) !== null)
			{
				$name = ucfirst($tmp) . $name;
				$namespace = $this->removeLastSpace($namespace);
			}
		}

		return $name;
	}

	/**
	 * Removes the last space from the namespace.
	 *
	 * @param string $namespace The namespace
	 *
	 * @return string The namespace shortened
	 * @since 3.2.0
	 */
	protected function removeLastSpace(string $namespace): string
	{
		// Remove '\\' from the beginning and end of the resulting string
		$namespace = trim($namespace, '\\');

		$parts = explode('\\', $namespace);

		// Remove the last part (the class name)
		array_pop($parts);

		// Reassemble the namespace without the class name
		return implode('\\', $parts);
	}

	/**
	 * Insert a line before the class declaration in the given class code.
	 *
	 * @param string       $code             The class code
	 * @param array|null   $useStatements    The existing use statements
	 *
	 * @return string The modified file content
	 * @since 3.2.0
	 */
	protected function addUseStatements(string $code, ?array $useStatements): string
	{
		if ($useStatements !== null)
		{
			// we add the use statements using existing use statements
			$key = end($useStatements);

			array_unshift($this->useStatements, $key);

			return $this->placeholder->update($code, [$key => implode(PHP_EOL, array_values($this->useStatements))]);
		}

		return $this->addLines($code, implode(PHP_EOL, array_values($this->useStatements)));
	}

	/**
	 * Insert a line before the class declaration in the given class code.
	 *
	 * @param string   $code     The class code
	 * @param string   $lines    The new lines to insert
	 *
	 * @return string The modified file content
	 * @since 3.2.0
	 */
	protected function addLines(string $code, string $lines): string
	{
		// Pattern to match class, final class, abstract class, interface, and trait
		$pattern = '/(?:class|final class|abstract class|interface|trait)\s+[a-zA-Z0-9_]+\s*(?:extends\s+[a-zA-Z0-9_]+\s*)?(?:implements\s+[a-zA-Z0-9_]+(?:\s*,\s*[a-zA-Z0-9_]+)*)?\s*\{/s';

		// Find the position of the class declaration
		preg_match($pattern, $code, $matches, PREG_OFFSET_CAPTURE);
		$class_declaration_pos = $matches[0][1] ?? null;

		if (null !== $class_declaration_pos)
		{
			// Find the position of the last newline character before the class declaration
			$last_newline_pos = strrpos($code, PHP_EOL, -(strlen($code) - $class_declaration_pos));

			// Find the position of the comment block right before the class declaration
			$comment_pattern = '/\s*\*\/\s*$/m';
			$insert_pos = null;
			if (preg_match($comment_pattern, $code, $comment_matches, PREG_OFFSET_CAPTURE, 0, $last_newline_pos))
			{
				$insert_pos = (int) $comment_matches[0][1] + strlen($comment_matches[0][0]);
			}
			else
			{
				// Find the last empty line before the class declaration
				$empty_line_pattern = '/(^|\r\n|\r|\n)[\s]*($|\r\n|\r|\n)/';
				if (preg_match($empty_line_pattern, $code, $empty_line_matches, PREG_OFFSET_CAPTURE, 0, $last_newline_pos))
				{
					$insert_pos = (int) $empty_line_matches[0][1] + strlen($empty_line_matches[0][0]);
				}
			}

			// Insert the new line at the found position
			if (null !== $insert_pos)
			{
				return substr_replace($code, $lines . PHP_EOL, $insert_pos, 0);
			}
		}

		// last try targeting the defined line
		return $this->addLinesAfterDefinedLine($code, $lines);
	}

	/**
	 * Inserts a new line after the defined('_JEXEC') line.
	 *
	 * @param string   $code     The class code
	 * @param string   $lines    The new lines to insert
	 *
	 * @return string The modified file content
	 * @since 3.2.0
	 */
	protected function addLinesAfterDefinedLine(string $code, string $lines): string
	{
		// Patterns to match the defined('_JEXEC') and defined('JPATH_BASE') lines
		$patterns = [
			"/defined\('_JEXEC'\)(.*?)\s*;/",
			"/defined\('JPATH_BASE'\)(.*?)\s*;/",
		];

		$insert_pos = null;

		// Iterate through the patterns and try to find a match
		foreach ($patterns as $pattern)
		{
			preg_match($pattern, $code, $matches, PREG_OFFSET_CAPTURE);
			$defined_line_pos = $matches[0][1] ?? null;

			if ($defined_line_pos !== null)
			{
				// Find the position of the newline character after the defined() line
				$next_lines_pos = strpos($code, PHP_EOL, (int) $defined_line_pos + strlen($matches[0][0]));

				// Insert the new line at the found position
				if ($next_lines_pos !== false)
				{
					$insert_pos = $next_lines_pos;
					break;
				}
			}
		}

		// Insert the new line at the found position
		if ($insert_pos !== null)
		{
			$code = substr_replace($code, PHP_EOL . $lines, $insert_pos, 0);
		}

		return $code;
	}
}

