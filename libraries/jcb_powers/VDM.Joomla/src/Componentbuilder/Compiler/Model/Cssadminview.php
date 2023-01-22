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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model CSS Admin View Class
 * 
 * @since 3.2.0
 */
class Cssadminview
{
	/**
	 * The areas add array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $areas = [
		'css_view', 'css_views'
	];

	/**
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Constructor
	 *
	 * @param Dispenser|null     $dispenser      The compiler customcode dispenser
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Dispenser $dispenser = null)
	{
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
	}

	/**
	 * Set Admin View Css
	 *
	 * @param   object  $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		foreach ($this->areas as $area)
		{
			if (isset($item->{'add_' . $area})
				&& $item->{'add_' . $area} == 1
				&& StringHelper::check($item->{$area}))
			{
				$this->dispenser->set(
					$item->{$area},
					$area,
					$item->name_single_code,
					null,
					['prefix' => PHP_EOL],
					true,
					true,
					true
				);

				unset($item->{$area});
			}
		}
	}

}

