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
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Custom Ajax Custom View Class
 * 
 * @since 3.2.0
 */
class Ajaxcustomview
{
	/**
	 * The gui mapper array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $guiMapper = [
		'table' => 'site_view',
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
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Constructor
	 *
	 * @param Config|null         $config         The compiler config object.
	 * @param Dispenser|null      $dispenser      The compiler customcode dispenser
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Dispenser $dispenser = null)
	{
		$this->config = $config ?: Compiler::_('Config');
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
	public function set(object &$item, string $table = 'site_view')
	{
		// add_Ajax for this view
		if (isset($item->add_php_ajax) && $item->add_php_ajax == 1)
		{
			// set some gui mapper values
			$this->guiMapper['table'] = $table;
			$this->guiMapper['id'] = (int) $item->id;

			// ajax target (since we only have two options really)
			if ('site' === $this->config->build_target)
			{
				$target = 'site';
			}
			else
			{
				$target = 'admin';
			}

			$add_ajax_site = false;

			// check if controller input as been set
			$item->ajax_input = (isset($item->ajax_input)
				&& JsonHelper::check($item->ajax_input))
				? json_decode((string) $item->ajax_input, true) : null;

			if (ArrayHelper::check($item->ajax_input))
			{
				$this->dispenser->hub[$target]['ajax_controller'][$item->code]
					     = array_values($item->ajax_input);

				$add_ajax_site = true;
			}
			unset($item->ajax_input);

			// load the ajax class mathods (if set)
			if (StringHelper::check($item->php_ajaxmethod))
			{
				// set field
				$this->guiMapper['field'] = 'php_ajaxmethod';
				$this->dispenser->set(
					$item->php_ajaxmethod,
					$target,
					'ajax_model',
					$item->code,
					$this->guiMapper
				);

				$add_ajax_site = true;
			}
			unset($item->php_ajaxmethod);

			// should ajax be set
			if ($add_ajax_site)
			{
				// turn on ajax area
				if ('site' === $this->config->build_target)
				{
					$this->config->set('add_site_ajax', true);
				}
				else
				{
					$this->config->set('add_ajax', true);
				}
			}
		}
	}

}

