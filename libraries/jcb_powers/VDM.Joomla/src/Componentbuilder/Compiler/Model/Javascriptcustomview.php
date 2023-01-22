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
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Javascript Custom View Class
 * 
 * @since 3.2.0
 */
class Javascriptcustomview
{
	/**
	 * The areas add array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $areas = [
		'javascript_file',
		'js_document'
	];

	/**
	 * The gui mapper array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $guiMapper = [
		'table' => null,
		'id' => null,
		'field' => null,
		'type'  => 'js'
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
	 * Constructor
	 *
	 * @param Customcode|null        $customcode       The compiler customcode object.
	 * @param Gui|null               $gui              The compiler customcode gui.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Customcode $customcode = null, ?Gui $gui = null)
	{
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
	}

	/**
	 * Set Javascript code
	 *
	 * @param   object     $item  The item data
	 * @param   string     $table The table
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item, string $table = 'site_view')
	{
		// set some gui mapper values
		$this->guiMapper['table'] = $table;
		$this->guiMapper['id'] = (int) $item->id;

		foreach ($this->areas as $area)
		{
			if (isset($item->{'add_' . $area})
				&& $item->{'add_' . $area} == 1
				&& StringHelper::check($item->{$area}))
			{
				// update GUI mapper field
				$this->guiMapper['field'] = $area;
				$item->{$area} = $this->gui->set(
					$this->customcode->update(
						base64_decode((string) $item->{$area})
					),
					$this->guiMapper
				);
			}
		}
	}

}

