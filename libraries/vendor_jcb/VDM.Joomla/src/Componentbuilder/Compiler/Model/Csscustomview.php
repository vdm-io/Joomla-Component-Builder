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
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Css Custom View Class
 * 
 * @since 3.2.0
 */
class Csscustomview
{
	/**
	 * The areas add array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $areas = ['css_document', 'css'];

	/**
	 * Compiler Customcode Class
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Constructor
	 *
	 * @param Customcode|null      $customcode    The compiler customcode object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Customcode $customcode = null)
	{
		$this->customcode = $customcode ?: Compiler::_('Customcode');
	}

	/**
	 * Set Css code
	 *
	 * @param   object     $item  The item data
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
				$item->{$area} = $this->customcode->update(
					base64_decode((string) $item->{$area})
				);
			}
		}
	}

}

