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
use VDM\Joomla\Componentbuilder\Compiler\Builder\LibraryManager;
use VDM\Joomla\Componentbuilder\Compiler\Library\Data as Library;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Libraries Class
 * 
 * @since 3.2.0
 */
class Libraries
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The LibraryManager Class.
	 *
	 * @var   LibraryManager
	 * @since 3.2.0
	 */
	protected LibraryManager $librarymanager;

	/**
	 * The Data Class.
	 *
	 * @var   Library
	 * @since 3.2.0
	 */
	protected Library $library;

	/**
	 * Constructor.
	 *
	 * @param Config           $config           The Config Class.
	 * @param LibraryManager   $librarymanager   The LibraryManager Class.
	 * @param Library          $library          The Data Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, LibraryManager $librarymanager, Library $library)
	{
		$this->config = $config;
		$this->librarymanager = $librarymanager;
		$this->library = $library;
	}

	/**
	 * Set Libraries
	 *
	 * @param   string       $key      The key mapper
	 * @param   object       $item     The item data
	 * @param   string|null  $target   The area being targeted
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $key, object &$item, string $target = null)
	{
		// set the target
		$target = $target ?: $this->config->build_target;

		// make sure json become array
		if (JsonHelper::check($item->libraries))
		{
			$item->libraries = json_decode((string) $item->libraries, true);
		}

		// if we have an array add it
		if (ArrayHelper::check($item->libraries))
		{
			foreach ($item->libraries as $library)
			{
				if (!$this->librarymanager->exists($target . '.' . $key . '.' . (int) $library)
					&& $this->library->get((int) $library))
				{
					$this->librarymanager->set($target . '.' . $key . '.' . (int) $library, true);
				}
			}
		}
		elseif (is_numeric($item->libraries)
			&& !$this->librarymanager->exists($target . '.' . $key . '.' . (int) $item->libraries)
			&& $this->library->get((int) $item->libraries))
		{
			$this->librarymanager->set($target . '.' . $key . '.' . (int) $item->libraries, true);
		}
	}

}

