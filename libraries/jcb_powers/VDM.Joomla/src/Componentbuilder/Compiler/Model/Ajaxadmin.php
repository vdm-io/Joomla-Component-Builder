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
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Admin Ajax Class
 * 
 * @since 3.2.0
 */
class Ajaxadmin
{
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
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

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
	 * @param Config|null               $config           The compiler config object.
	 * @param Registry|null             $registry         The compiler registry object.
	 * @param Dispenser|null      $dispenser      The compiler customcode dispenser
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null, ?Dispenser $dispenser = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
	}

	/**
	 * Set Ajax Code
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

		if (isset($item->add_php_ajax) && $item->add_php_ajax == 1)
		{
			// insure the token is added to edit view at least
			$this->dispenser->hub['token'][$item->name_single_code]
				         = true;

			$add_ajax_site = false;

			if ($this->registry->get('builder.site_edit_view.' . $item->id, false))
			{
				// we should add this site ajax to front ajax
				$add_ajax_site = true;
				$this->config->set('add_site_ajax', true);
			}

			// check if controller input as been set
			$item->ajax_input = (isset($item->ajax_input)
				&& JsonHelper::check($item->ajax_input))
				? json_decode((string) $item->ajax_input, true) : null;

			if (ArrayHelper::check($item->ajax_input))
			{
				if ($add_ajax_site)
				{
					$this->dispenser->hub['site']['ajax_controller'][$item->name_single_code]
						= array_values($item->ajax_input);
				}

				$this->dispenser->hub['admin']['ajax_controller'][$item->name_single_code]
					           = array_values($item->ajax_input);

				$this->config->set('add_ajax', true);

				unset($item->ajax_input);
			}

			if (StringHelper::check($item->php_ajaxmethod))
			{
				// make sure we are still in PHP
				$this->guiMapper['type'] = 'php';

				// update GUI mapper field
				$this->guiMapper['field'] = 'php_ajaxmethod';

				$this->dispenser->set(
					$item->php_ajaxmethod,
					'admin',
					'ajax_model',
					$item->name_single_code,
					$this->guiMapper
				);

				if ($add_ajax_site)
				{
					$this->dispenser->set(
						$item->php_ajaxmethod,
						'site',
						'ajax_model',
						$item->name_single_code,
						$this->guiMapper,
						false,
						false
					);
				}

				// switch ajax on
				$this->config->set('add_ajax', true);

				// unset anyway
				unset($item->php_ajaxmethod);
			}
		}
	}

}

