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

namespace VDM\Joomla\Componentbuilder\Snippet\Builder;


use VDM\Joomla\Abstraction\Registry;


/**
 * Package Builder Entities
 * 
 * @since 5.1.1
 */
class Entities extends Registry
{
	/**
	 * Constructor.
	 *
	 * Initializes the Registry object with optional data.
	 *
	 * @param  mixed        $data      Optional data to load into the registry.
	 *                                    Can be an array, string, or object.
	 * @param  string|null  $separator The path separator, and empty string will flatten the registry.
	 * @since   5.1.1
	 */
	public function __construct($data = null, ?string $separator = null)
	{
		$data = [
			'snippet' => 'Snippet',
			'snippet_type' => 'SnippetType'
		];

		parent::__construct($data);
	}
}

