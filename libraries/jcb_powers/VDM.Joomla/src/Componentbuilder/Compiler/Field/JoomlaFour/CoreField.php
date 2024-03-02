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

namespace VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFour;


use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreFieldInterface;


/**
 * Core Joomla Fields
 * 
 * @since 3.2.0
 */
class CoreField implements CoreFieldInterface
{
	/**
	 * Local Core Joomla Fields
	 *
	 * @var    array|null
	 * @since 3.2.0
	 **/
	protected array $fields = [];

	/**
	 * Local Core Joomla Fields Path
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $paths = [];

	/**
	 * Constructor
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		// set the path to the form validation fields
		$this->paths[] = JPATH_LIBRARIES . '/src/Form/Field';
	}

	/**
	 * Get the Array of Existing Validation Field Names
	 *
	 * @param bool      $lowercase Switch to set fields lowercase
	 *
	 * @return array
	 * @since 3.2.0
	 */
	public function get(bool $lowercase = false): array
	{
		if ($this->fields === [])
		{
			// check if the path exist
			foreach ($this->paths as $path)
			{
				$this->set($path);
			}
		}

		// return fields if found
		if ($this->fields !== [])
		{
			// check if the names should be all lowercase
			if ($lowercase)
			{
				return array_map(
					fn($item): string => strtolower((string) $item),
					$this->fields
				);
			}

			return $this->fields;
		}

		// return empty array
		return [];
	}

	/**
	 * Set the fields found in a path
	 *
	 * @param string $path The path to load fields from
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
		$fields = Folder::files($path, '\.php$', true, true);

		// Process the files to extract field names
		$processedFields = array_map(function ($name) {
			$fileName = basename($name);

			// Remove 'Field.php' if it exists or just '.php' otherwise
			if (substr($fileName, -9) === 'Field.php')
			{
				return str_replace('Field.php', '', $fileName);
			}
			else
			{
				return str_replace('.php', '', $fileName);
			}
		}, $fields);

		// Merge with existing fields and remove duplicates
		$this->fields = array_unique(array_merge($processedFields, $this->fields));
	}
}

