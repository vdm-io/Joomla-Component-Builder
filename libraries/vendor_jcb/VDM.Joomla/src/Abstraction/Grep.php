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

namespace VDM\Joomla\Abstraction;


use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Application\CMSApplication;
use VDM\Joomla\Gitea\Repository\Contents;
use VDM\Joomla\Interfaces\GrepInterface;


/**
 * Global Resource Empowerment Platform
 * 
 *    The Grep feature will try to find your power in the repositories listed in the global
 *    Options of JCB in the super powers tab, and if it can't be found there will try the global core
 *    Super powers of JCB. All searches are performed according the the [algorithm:cascading]
 *    See documentation for more details: https://git.vdm.dev/joomla/super-powers/wiki
 * 
 * @since 3.2.1
 */
abstract class Grep implements GrepInterface
{
	/**
	 * The local path
	 *
	 * @var    string
	 * @since 3.2.0
	 **/
	public ?string $path;

	/**
	 * All approved paths
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public ?array $paths;

	/**
	 * Order of global search
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	protected array $order = ['local', 'remote'];

	/**
	 * The target branch field name ['read_branch', 'write_branch']
	 *
	 * @var    string
	 * @since 3.2.2
	 **/
	protected string $branch_field = 'read_branch';

	/**
	 * Gitea Repository Contents
	 *
	 * @var    Contents
	 * @since 3.2.0
	 **/
	protected Contents $contents;

	/**
	 * Joomla Application object
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor.
	 *
	 * @param Contents               $contents  The Gitea Repository Contents object.
	 * @param array                  $paths     The approved paths
	 * @param string|null            $path      The local path
	 * @param CMSApplication|null    $app       The CMS Application object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(Contents $contents, array $paths, ?string $path = null, ?CMSApplication $app = null)
	{
		$this->paths = $paths;
		$this->contents = $contents;
		$this->path = $path;
		$this->app = $app ?: Factory::getApplication();

		$this->init();
	}

	/**
	 * Get all remote powers GUID's
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function getRemotePowersGuid(): ?array
	{
		if (!is_array($this->paths) || $this->paths === [])
		{
			return null;
		}

		$powers = [];
		foreach ($this->paths as $path)
		{
			// Get remote index
			$this->remoteIndex($path);

			if (isset($path->index) && is_object($path->index))
			{
				$powers = array_merge($powers, array_keys((array) $path->index));
			}
		}

		return empty($powers) ? null : array_unique($powers);
	}

	/**
	 * Set the branch field
	 *
	 * @param string    $field   The global unique id of the power
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setBranchField(string $field): void
	{
		$this->branch_field = $field;
	}

	/**
	 * Get a power
	 *
	 * @param string      $guid    The global unique id of the power
	 * @param array|null  $order   The search order
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function get(string $guid, ?array $order = null): ?object
	{
		if ($order === null)
		{
			$order = $this->order;
		}

		// we can only search if we have paths
		if (is_array($this->paths) && $this->paths !== [])
		{
			foreach ($order as $target)
			{
				if (($function_name = $this->getFunctionName($target)) !== null &&
					($power = $this->{$function_name}($guid)) !== null)
				{
					return $power;
				}
			}
		}

		return null;
	}

	/**
	 * Load the remote repository index of powers
	 *
	 * @param object    $path    The repository path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	abstract protected function remoteIndex(object &$path): void;

	/**
	 * Get function name
	 *
	 * @param string     $name The targeted function name
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	protected function getFunctionName(string $name): ?string
	{
		$function_name = 'search' . ucfirst(strtolower($name));

		return method_exists($this, $function_name) ? $function_name : null;
	}

	/**
	 * Set path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function init(): void
	{
		if (is_array($this->paths) && $this->paths !== [])
		{
			foreach ($this->paths as $n => &$path)
			{
				if (isset($path->organisation) && strlen($path->organisation) > 1 &&
						isset($path->repository) && strlen($path->repository) > 1)
				{
					// build the path
					$path->path = trim($path->organisation) . '/' . trim($path->repository);

					// update the branch
					$branch_field = $this->getBranchField();
					$branch = $path->{$branch_field} ?? null;

					if ($branch === 'default' || empty($branch))
					{
						$path->{$branch_field} = null;
					}

					// set local path
					if ($this->path && Folder::exists($this->path . '/' . $path->path))
					{
						$path->full_path = $this->path . '/' . $path->path;
					}
				}
				else
				{
					unset($this->paths[$n]);
				}
			}
		}
	}

	/**
	 * Get the branch field
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getBranchField(): string
	{
		return $this->branch_field;
	}
}

