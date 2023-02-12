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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Utilities\Constantpaths;


/**
 * Compiler Utilities Dynamic Path
 * 
 * @since 3.2.0
 */
class Dynamicpath
{
	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Constant Paths
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $paths;

	/**
	 * Constructor.
	 *
	 * @param Placeholder|null      $placeholder      The Compiler Placeholder object.
	 * @param Constantpaths|null    $paths            The Constant Paths object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Placeholder $placeholder = null, ?Constantpaths $paths = null)
	{
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$paths = $paths ?: Compiler::_('Utilities.Constantpaths');

		// load the constant paths
		$this->paths = $paths->get();
	}

	/**
	 * Update path with dynamic value
	 *
	 * @param   string  $path  The path to update
	 *
	 * @return  string   The updated path
	 * @since 3.2.0
	 */
	public function update(string $path): string
	{
		return $this->placeholder->update_(
			$this->placeholder->update(
				$path, $this->paths
			)
		);
	}

}

