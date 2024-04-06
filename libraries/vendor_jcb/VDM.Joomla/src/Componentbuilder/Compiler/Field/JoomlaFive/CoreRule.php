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

namespace VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFive;


use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreRuleInterface;


/**
 * Core Joomla Field Rules
 * 
 * @since 3.2.0
 */
final class CoreRule implements CoreRuleInterface
{
	/**
	 * Local Core Joomla Rules
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $rules = [];

	/**
	 * Local Core Joomla Rules Path
	 *
	 * @var    string
	 * @since 3.2.0
	 **/
	protected string $path;

	/**
	 * Constructor
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		// set the path to the form validation rules
		$this->path = JPATH_LIBRARIES . '/src/Form/Rule';
	}

	/**
	 * Get the Array of Existing Validation Rule Names
	 *
	 * @param bool      $lowercase Switch to set rules lowercase
	 *
	 * @return array
	 * @since 3.2.0
	 */
	public function get(bool $lowercase = false): array
	{
		if ($this->rules === [])
		{
			$this->set($this->path);
		}

		// return rules if found
		if ($this->rules !== [])
		{
			// check if the names should be all lowercase
			if ($lowercase)
			{
				return array_map(
					fn($item): string => strtolower((string) $item),
					$this->rules
				);
			}

			return $this->rules;
		}

		// return empty array
		return [];
	}

	/**
	 * Set the rules found in a path
	 *
	 * @param string $path The path to load rules from
	 * @return void
	 * @since 3.2.0
	 */
	private function set(string $path): void
	{
		// Check if the path exists
		if (!Folder::exists($path))
		{
			return;
		}

		// Load all PHP files in this path
		$rules = Folder::files($path, '\.php$', true, true);

		// Process the files to extract rule names
		$processedRules = array_map(function ($name) {
			$fileName = basename($name);

			// Remove 'Rule.php' if it exists or just '.php' otherwise
			if (substr($fileName, -8) === 'Rule.php')
			{
				return str_replace('Rule.php', '', $fileName);
			}
			else
			{
				return str_replace('.php', '', $fileName);
			}
		}, $rules);

		// Merge with existing rules and remove duplicates
		$this->rules = array_unique(array_merge($processedRules, $this->rules));
	}
}

