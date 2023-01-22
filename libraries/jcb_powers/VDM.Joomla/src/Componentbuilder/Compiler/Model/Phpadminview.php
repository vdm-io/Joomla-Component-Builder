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
use VDM\Joomla\Componentbuilder\Compiler\Templatelayout\Data as Templatelayout;


/**
 * Model PHP Admin View Class
 * 
 * @since 3.2.0
 */
class Phpadminview
{
	/**
	 * The areas add array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $areas = [
		'php_getitem',
		'php_before_save',
		'php_save',
		'php_getform',
		'php_postsavehook',
		'php_getitems',
		'php_getitems_after_all',
		'php_getlistquery',
		'php_allowadd',
		'php_allowedit',
		'php_before_cancel',
		'php_after_cancel',
		'php_before_delete',
		'php_after_delete',
		'php_before_publish',
		'php_after_publish',
		'php_batchcopy',
		'php_batchmove',
		'php_document'
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
	 * Compiler Template Layout Data
	 *
	 * @var    Templatelayout
	 * @since 3.2.0
	 */
	protected Templatelayout $templateLayout;

	/**
	 * Constructor
	 *
	 * @param Dispenser|null         $dispenser         The compiler customcode dispenser
	 * @param Templatelayout|null    $templateLayout    The template layout data
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Dispenser $dispenser = null, ?Templatelayout $templateLayout = null)
	{
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
		$this->templateLayout = $templateLayout ?: Compiler::_('Templatelayout.Data');
	}

	/**
	 * Set PHP code
	 *
	 * @param   object     $item  The item data
	 * @param   string     $table The table
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item, string $table = 'admin_view')
	{
		// set some gui mapper values
		$this->guiMapper['table'] = $table;
		$this->guiMapper['id'] = (int) $item->id;

		foreach ($this->areas as $area)
		{
			if (isset($item->{'add_' . $area})
				&& $item->{'add_' . $area} == 1)
			{
				// update GUI mapper field
				$this->guiMapper['field'] = $area;
				$this->dispenser->set(
					$item->{$area},
					$area,
					$item->name_single_code,
					null,
					$this->guiMapper
				);

				// check if we have template or layouts to load
				$this->templateLayout->set(
					$item->{$area}, $item->name_single_code
				);

				unset($item->{$area});
			}
		}
	}

}

