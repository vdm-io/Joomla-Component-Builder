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

namespace VDM\Joomla\Componentbuilder\Power\Generator;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Power code Generator for the Class Injection of JCB
 * 
 * @since 3.2.0
 */
final class ClassInjector
{
	/**
	 * The version
	 *
	 * @var    string
	 * @since 3.2.0
	 **/
	protected string $version;

	/**
	 * The properties
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $properties = [];

	/**
	 * The comments
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $comments = [];

	/**
	 * The arguments
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $arguments = [];

	/**
	 * The assignments
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $assignments = [];

	/**
	 * Get the generated class code
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	public function getCode(): ?string
	{
		if ($this->properties === [])
		{
			return null;
		}

		$code = [];

		$code[] = implode(PHP_EOL . PHP_EOL, $this->properties) . PHP_EOL;
		$code[] = Indent::_(1) . "/**";
		$code[] = Indent::_(1) . " * Constructor.";
		$code[] = Indent::_(1) . " *";
		$code[] = $this->getComments();
		$code[] = Indent::_(1) . " *";
		$code[] = Indent::_(1) . " * @since {$this->version}";
		$code[] = Indent::_(1) . " */";
		$code[] = Indent::_(1) . "public function __construct(" . $this->getArguments() . ")";
		$code[] = Indent::_(1) . "{";
		$code[] = implode(PHP_EOL, $this->assignments);
		$code[] = Indent::_(1) . "}";

		$this->properties = [];
		$this->comments = [];
		$this->arguments = [];
		$this->assignments = [];

		return implode(PHP_EOL, $code);
	}

	/**
	 * Set the class since version
	 *
	 * @param string   $version       The variable version format.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setVersion(string $version): void
	{
		$this->version = $version;
	}

	/**
	 * Set the class property
	 *
	 * @param string   $classname     The variable name in lowerCamelCase format.
	 * @param string   $ClassName     The type hint in PascalCase format.
	 * @param string   $description   The variable description format.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setProperty(string $classname, string $ClassName, string $description): void
	{
		$this->properties[] = implode(PHP_EOL, [
			Indent::_(1) . "/**",
			Indent::_(1) . " * {$description}",
			Indent::_(1) . " *",
			Indent::_(1) . " * @var   {$ClassName}",
			Indent::_(1) . " * @since {$this->version}",
			Indent::_(1) . " */",
			Indent::_(1) . "protected {$ClassName} \${$classname};"
		]);
	}

	/**
	 * Set the comment for the constructor parameter.
	 *
	 * @param string   $classname     The variable name in lowerCamelCase format.
	 * @param string   $ClassName     The type hint in PascalCase format.
	 * @param string   $description   The variable description format.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setComment(string $classname, string $ClassName, string $description): void
	{
		$this->comments[] = [$ClassName, $classname, $description];
	}

	/**
	 * Set the constructor argument.
	 *
	 * @param string $classname The variable name in lowerCamelCase format.
	 * @param string $ClassName The type hint in PascalCase format.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setArgument(string $classname, string $ClassName): void
	{
		$this->arguments[] = "{$ClassName} \${$classname}";
	}

	/**
	 * Set the assignment code inside the constructor.
	 *
	 * @param string $classname      The variable name in lowerCamelCase format.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function setAssignment(string $classname): void
	{
		$this->assignments[] = Indent::_(2) . "\$this->{$classname} = \${$classname};";
	}

	/**
	 * Get the comments for the constructor parameter.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function getComments(): string
	{
		$max_lengths = array_reduce($this->comments, function($carry, $comment) {
			foreach ($comment as $index => $part)
			{
				$carry[$index] = max($carry[$index] ?? 0, strlen($part));
			}
			return $carry;
		}, []);

		$max_lengths[0] = $max_lengths[0] + 2;
		$max_lengths[1] = $max_lengths[1] + 2;

		$comments = array_map(function($comment) use ($max_lengths) {
			return Indent::_(1) . " * @param " . 
			str_pad($comment[0], $max_lengths[0]) . " $" . 
			str_pad($comment[1], $max_lengths[1]) . " " . 
			$comment[2];
		}, $this->comments);

		return implode(PHP_EOL, $comments);
	}

	/**
	 * Format the arguments to ensure they fit within a specified line length.
	 * Arguments are added to the line until the max length is reached. 
	 * Then, they are pushed to a new line with appropriate indentation.
	 *
	 * @return string Formatted arguments
	 * @since 3.2.0
	 */
	private function getArguments(): string
	{
		$maxLength = 60; // or any other preferred line length
		$lines = [];
		$currentLineContent = '';

		foreach ($this->arguments as $argument)
		{
			$proposedContent = $currentLineContent ? $currentLineContent . ', ' . $argument : $argument;

			if (strlen($proposedContent) >= $maxLength)
			{
				$lines[] = $currentLineContent;
				$currentLineContent = Indent::_(2) . $argument;
			}
			else
			{
				$currentLineContent = $proposedContent;
			}
		}

		// Append the last line if it has content
		if ($currentLineContent)
		{
			$lines[] = $currentLineContent;
		}

		return implode(',' . PHP_EOL, $lines);
	}
}

