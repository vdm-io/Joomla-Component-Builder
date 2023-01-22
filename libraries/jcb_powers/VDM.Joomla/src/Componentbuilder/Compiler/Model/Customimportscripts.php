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
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Model Custom Import Scripts Class
 * 
 * @since 3.2.0
 */
class Customimportscripts
{
	/**
	 * The areas add array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $areas = [
		'php_import_ext',
		'php_import_display',
		'php_import',
		'php_import_setdata',
		'php_import_save',
		'php_import_headers',
		'html_import_view'
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
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Constructor
	 *
	 * @param Dispenser|null      $dispenser      The compiler customcode dispenser
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Dispenser $dispenser = null)
	{
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
	}

	/**
	 * Set Custom Import Scripts
	 *
	 * @param   object     $item  The item data
	 * @param   string     $table The table
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item, string $table = 'admin_view')
	{
		// set custom import scripts
		if (isset($item->add_custom_import)
			&& $item->add_custom_import == 1)
		{
			// set some gui mapper values
			$this->guiMapper['table'] = $table;
			$this->guiMapper['id'] = (int) $item->id;

			foreach ($this->areas as $area)
			{
				if (isset($item->$area)
					&& StringHelper::check($item->$area))
				{
					// update GUI mapper field
					$this->guiMapper['field'] = $area;
					$this->guiMapper['type']  = 'php';

					// Make sure html gets HTML comment for placeholder
					if ('html_import_view' === $area)
					{
						$this->guiMapper['type'] = 'html';
					}

					$this->dispenser->set(
						$item->$area,
						$area,
						'import_' . $item->name_list_code,
						null,
						$this->guiMapper
					);

					unset($item->$area);
				}
				else
				{
					// load the default TODO: convert getDynamicScripts to a class
					$this->dispenser->hub[$area]['import_' . $item->name_list_code]
						= Helper::_('getDynamicScripts', [$area, true]);
				}
			}
		}
	}

}

