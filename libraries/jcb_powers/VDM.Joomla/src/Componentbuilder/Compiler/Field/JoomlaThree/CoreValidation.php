<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaThree;


use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreValidationInterface;


/**
 * Core Joomla Field Validation Rules
 * 
 * @since 3.2.0
 */
class CoreValidation implements CoreValidationInterface
{
	/**
	 * Local Core Joomla Rules
	 *
	 * @var    array|null
	 * @since 3.2.0
	 **/
	protected ?array $rules = null;

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
		if (!$this->rules)
		{
			// check if the path exist
			if (!Folder::exists($this->path))
			{
				return [];
			}

			// we must first store the current working directory
			$joomla = getcwd();

			// go to that folder
			chdir($this->path);

			// load all the files in this path
			$rules = Folder::files('.', '\.php', true, true);

			// change back to Joomla working directory
			chdir($joomla);

			// make sure we have an array
			if (!ArrayHelper::check($rules))
			{
				return false;
			}

			// remove the Rule.php from the name
			$this->rules = array_map( function ($name) {
				return str_replace(array('./','Rule.php'), '', $name);
			}, $rules);
		}

		// return rules if found
		if (is_array($this->rules))
		{
			// check if the names should be all lowercase
			if ($lowercase)
			{
				return array_map( function($item) {
					return strtolower($item);
				}, $this->rules);
			}
			return $this->rules;
		}

		// return empty array
		return [];
	}

}

