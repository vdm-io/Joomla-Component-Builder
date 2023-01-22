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
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Templatelayout\Data as Templatelayout;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Custom Buttons Class
 * 
 * @since 3.2.0
 */
class Custombuttons
{
	/**
	 * The areas add array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $areas = [
		'php_model',
		'php_controller',
		'php_model_list',
		'php_controller_list'
	];

	/**
	 * The gui mapper array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $guiMapper = [
		'table' => 'admin_view',
		'id' => null,
		'field' => null,
		'type'  => 'php'
	];

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Template Layout
	 *
	 * @var    Templatelayout
	 * @since 3.2.0
	 */
	protected Templatelayout $templateLayout;

	/**
	 * Constructor
	 *
	 * @param Customcode|null         $customcode        The compiler customcode object.
	 * @param Gui|null                $gui               The compiler customcode gui.
	 * @param Templatelayout|null     $templateLayout    The compiler template layout object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Customcode $customcode = null, ?Gui $gui = null,
		?Templatelayout $templateLayout = null)
	{
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->templateLayout = $templateLayout ?: Compiler::_('Templatelayout.Data');
	}

	/**
	 * Set Custom Buttons and Model/Controllers
	 *
	 * @param   object  $item  The item data
	 * @param   object  $table The table
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item, string $table = 'admin_view')
	{
		if (isset($item->add_custom_button)
			&& $item->add_custom_button == 1)
		{
			// set some gui mapper values
			$this->guiMapper['table'] = $table;
			$this->guiMapper['id'] = (int) $item->id;

			// get the code
			$code = $item->name_single_code ?? $item->code ?? 'error';

			// set for the code
			foreach ($this->areas as $area)
			{
				if (isset($item->{$area})
					&& StringHelper::check(
						$item->{$area}
					))
				{
					// set field
					$this->guiMapper['field'] = $area;
					$item->{$area} = $this->gui->set(
						$this->customcode->update(
							base64_decode((string) $item->{$area})
						),
						$this->guiMapper
					);

					// check if we have template or layouts to load
					$this->templateLayout->set(
						$item->{$area}, $code
					);
				}
			}

			// set the button array
			$item->custom_button = (isset($item->custom_button)
				&& JsonHelper::check($item->custom_button))
				? json_decode((string) $item->custom_button, true) : null;

			if (ArrayHelper::check($item->custom_button))
			{
				$item->custom_buttons = array_values($item->custom_button);
			}

			unset($item->custom_button);
		}
	}

}

