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
use VDM\Joomla\Utilities\GuidHelper;


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
	 * Set libraries for the given item and target area.
	 *
	 * @param  string       $key     The key mapper.
	 * @param  object       $item    The item data.
	 * @param  string|null  $target  The area being targeted.
	 *
	 * @return void
	 * @since  3.2.0
	 */
	public function set(string $key, object &$item, ?string $target = null): void
	{
		if (!isset($item->libraries))
		{
			return;
		}

		$target = $this->resolveTarget($target);
		$libraries = $this->normalizeLibraries($item);

		if ($libraries === null)
		{
			return;
		}

		if (is_array($libraries))
		{
			foreach ($libraries as $library)
			{
				$this->registerLibrary($target, $key, $library);
			}

			return;
		}

		$this->registerLibrary($target, $key, $libraries);
	}

	/**
	 * Resolve the active target area.
	 *
	 * @param  string|null  $target  The provided target area.
	 *
	 * @return string  The resolved target area.
	 * @since  3.2.0
	 */
	protected function resolveTarget(?string $target): string
	{
		return $target ?: $this->config->build_target;
	}

	/**
	 * Normalize the item libraries value into an array, string, or null.
	 *
	 * @param  object  $item  The item data.
	 *
	 * @return array|string|null  The normalized libraries value.
	 * @since  3.2.0
	 */
	protected function normalizeLibraries(object &$item): array|string|null
	{
		$libraries = $item->libraries ?? null;

		if ($libraries === null)
		{
			return null;
		}

		if (is_string($libraries) && JsonHelper::check($libraries))
		{
			$decoded = json_decode($libraries, true);

			if (is_array($decoded))
			{
				$item->libraries = $decoded;

				return $decoded;
			}
		}

		if (ArrayHelper::check($libraries))
		{
			return $libraries;
		}

		if (is_string($libraries) && GuidHelper::valid($libraries))
		{
			return $libraries;
		}

		return null;
	}

	/**
	 * Register a library if it is valid, not yet loaded, and exists in storage.
	 *
	 * @param  string  $target   The target area.
	 * @param  string  $key      The key mapper.
	 * @param  mixed   $library  The library GUID candidate.
	 *
	 * @return void
	 * @since  3.2.0
	 */
	protected function registerLibrary(string $target, string $key, $library): void
	{
		if (!is_string($library) || !GuidHelper::valid($library))
		{
			return;
		}

		$managerKey = $this->getManagerKey($target, $key, $library);

		if ($this->librarymanager->exists($managerKey))
		{
			return;
		}

		if (!$this->library->get($library))
		{
			return;
		}

		$this->librarymanager->set($managerKey, true);
	}

	/**
	 * Build the manager key for a library registration.
	 *
	 * @param  string  $target   The target area.
	 * @param  string  $key      The key mapper.
	 * @param  string  $library  The library GUID.
	 *
	 * @return string  The manager key.
	 * @since  3.2.0
	 */
	protected function getManagerKey(string $target, string $key, string $library): string
	{
		return $target . '.' . $key . '.' . $library;
	}
}

