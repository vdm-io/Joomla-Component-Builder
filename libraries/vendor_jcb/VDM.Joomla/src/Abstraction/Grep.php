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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Application\CMSApplication;
use VDM\Joomla\Gitea\Repository\Contents;
use VDM\Joomla\Interfaces\Git\ApiInterface as Api;
use VDM\Joomla\Componentbuilder\Network\Resolve;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Interfaces\GrepInterface;


/**
 * Global Resource Empowerment Platform
 * 
 *    The Grep feature will try to find your power in the repositories listed in the global
 *    Options of JCB in the super powers tab, and if it can't be found there will try the global core
 *    Super powers of JCB. All searches are performed according the [algorithm:cascading]
 *    See documentation for more details: https://git.vdm.dev/joomla/super-powers/wiki
 * 
 * @since 3.2.1
 */
abstract class Grep implements GrepInterface
{
	/**
	 * The local path
	 *
	 * @var    string|null
	 * @since 3.2.0
	 **/
	public ?string $path;

	/**
	 * All approved paths
	 *
	 * @var    array|null
	 * @since 3.2.0
	 **/
	public ?array $paths;

	/**
	 * The Grep target [network]
	 *
	 * @var    string
	 * @since  5.0.4
	 **/
	protected ?string $target = null;

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
	 * The target default branch name
	 *
	 * @var    string|null
	 * @since 3.2.2
	 **/
	protected ?string $branch_name = null;

	/**
	 * The index file path
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_path = 'index.json';

	/**
	 * The VDM global API base
	 *
	 * @var    string
	 * @since 5.0.4
	 **/
	protected string $api_base = '//git.vdm.dev/';

	/**
	 * Gitea Repository Contents
	 *
	 * @var    Contents
	 * @since 3.2.0
	 **/
	protected Contents $contents;

	/**
	 * The Resolve Class.
	 *
	 * @var   Resolve
	 * @since 5.0.4
	 */
	protected Resolve $resolve;

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
	 * @param Contents              $contents  The Gitea Repository Contents object.
	 * @param Resolve               $resolve   The Resolve Class.
	 * @param array                 $paths     The approved paths
	 * @param string|null           $path      The local path
	 * @param CMSApplication|null   $app       The CMS Application object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(
		Contents $contents, Resolve $resolve,
		array $paths, ?string $path = null,
		?CMSApplication $app = null)
	{
		$this->contents = $contents;
		$this->resolve = $resolve;
		$this->paths = $paths;
		$this->path = $path;
		$this->app = $app ?: Factory::getApplication();

		$this->initializeInstances();
	}

	/**
	 * Get an item
	 *
	 * @param string       $guid    The global unique id of the item
	 * @param array|null   $order   The search order
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 *
	 * @return object|null
	 * @since 3.2.2
	 */
	public function get(string $guid, ?array $order = null, ?object $repo = null): ?object
	{
		$order = $order ?? $this->order;

		if ($repo !== null)
		{
			return $this->searchSingleRepo($guid, $order, $repo);
		}

		return $this->searchAllRepos($guid, $order);
	}

	/**
	 * Check if an item exists in any repo or in a specific repo.
	 *
	 * @param string $guid The unique identifier for the item.
	 * @param object|null $repo The repository object to check against. If null, all repos will be checked.
	 * @param array|null $order The order of the targets to check. If null, the default order will be used.
	 *
	 * @return bool True if the item exists, false otherwise.
	 * @since 3.2.2
	 */
	public function exists(string $guid, ?object $repo = null, ?array $order = null): bool
	{
		$order = $order ?? $this->order;

		if ($repo !== null)
		{
			return $this->itemExistsInRepo($guid, $repo, $order);
		}

		return $this->itemExistsInAllRepos($guid, $order);
	}

	/**
	 * Get all remote GUID's
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function getRemoteGuid(): ?array
	{
		if (!is_array($this->paths) || $this->paths === [])
		{
			return null;
		}

		$powers = [];
		foreach ($this->paths as $path)
		{
			// Get remote index
			$this->indexRemote($path);

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
	 * @param string    $field   The field to use to get the branch name from the data set
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setBranchField(string $field): void
	{
		$this->branch_field = $field;
	}

	/**
	 * Set the DEFAULT branch name (only used if branch field is not found)
	 *
	 * @param string|null    $name   The default branch to use if no name could be found
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setBranchDefaultName(?string $name): void
	{
		$this->branch_name = $name;
	}

	/**
	 * Set the index path
	 *
	 * @param string    $indexPath    The repository index path
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setIndexPath(string $indexPath): void
	{
		$this->index_path = $indexPath;
	}

	/**
	 * Get the index of a repo
	 *
	 * @param string $guid The unique identifier for the repo.
	 *
	 * @return object|null
	 * @since 3.2.2
	 */
	public function getRemoteIndex(string $guid): ?object
	{
		if (!is_array($this->paths) || $this->paths === [] || empty($guid))
		{
			return null;
		}

		foreach ($this->paths as $path)
		{
			if (!isset($path->guid) || $guid !== $path->guid)
			{
				continue;
			}

			// Get remote index
			$this->indexRemote($path);

			if (isset($path->index) && is_object($path->index))
			{
				return $path->index;
			}
		}

		return null;
	}

	/**
	 * Loads API config using the provided base URL and token.
	 *
	 * This method checks if the base URL contains 'https://git.vdm.dev/'.
	 * If it does, it uses the token as is (which may be null).
	 * If not, it ensures the token is not null by defaulting to an empty string.
	 *
	 * @param Api          $api    The api object with a load_ method.
	 * @param string|null  $base   The base URL path.
	 * @param string|null  $token  The token for authentication (can be null).
	 *
	 * @return void
	 * @since 5.0.4
	 */
	public function loadApi(Api $api, ?string $base, ?string $token): void
	{
		// Determine the token to use based on the base URL
		if ($base && strpos($base, $this->api_base) !== false)
		{
			// If base contains $this->api_base = https://git.vdm.dev/, use the token as is
			$tokenToUse = $token;
		}
		else
		{
			// Otherwise, ensure the token is not null (use empty string if null)
			$tokenToUse = $token ?? '';
		}

		// Load the content with the determined base and token
		$api->load_($base, $tokenToUse);
	}

	/**
	 * Set repository messages and errors based on given conditions.
	 *
	 * @param string       $message       The message to set (if error)
	 * @param string       $path          Path value
	 * @param string       $repository    Repository name
	 * @param string       $organisation  Organisation name
	 * @param string|null  $base          Base URL
	 *
	 * @return void
	 * @since 3.2.0
	 */
	abstract protected function setRemoteIndexMessage(string $message, string $path, string $repository, string $organisation, ?string $base): void;

	/**
	 * Get function name
	 *
	 * @param string     $name   The targeted area name
	 * @param string     $type   The type of function name
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	protected function getFunctionName(string $name, string $type = 'search'): ?string
	{
		$function_name = $type . ucfirst(strtolower($name));

		return method_exists($this, $function_name) ? $function_name : null;
	}

	/**
	 * Search a single repository for an item
	 *
	 * @param string       $guid  The unique identifier for the item.
	 * @param array       $order The order of the targets to check.
	 * @param object      $repo  The repository object to check against.
	 *
	 * @return object|null
	 * @since 3.2.2
	 */
	protected function searchSingleRepo(string $guid, array $order, object $repo): ?object
	{
		foreach ($order as $target)
		{
			if ($this->itemExists($guid, $repo, $target))
			{
				$functionName = $this->getFunctionName($target, 'get');
				if ($functionName !== null && ($power = $this->{$functionName}($repo, $guid)) !== null)
				{
					return $power;
				}
			}
		}

		return null;
	}

	/**
	 * Search all repositories for an item
	 *
	 * @param string       $guid  The unique identifier for the item.
	 * @param object      $repo  The repository object to check against.
	 *
	 * @return object|null
	 * @since 3.2.2
	 */
	protected function searchAllRepos(string $guid, array $order): ?object
	{
		if (is_array($this->paths) && $this->paths !== [])
		{
			foreach ($order as $target)
			{
				$functionName = $this->getFunctionName($target);
				if ($functionName !== null && ($power = $this->{$functionName}($guid)) !== null)
				{
					return $power;
				}
			}
		}

		return null;
	}

	/**
	 * Check if an item exists in a specific repository.
	 *
	 * @param string $guid The unique identifier for the item.
	 * @param object $repo The repository object to check against.
	 * @param array $order The order of the targets to check.
	 *
	 * @return bool True if the item exists, false otherwise.
	 * @since 3.2.2
	 */
	protected function itemExistsInRepo(string $guid, object $repo, array $order): bool
	{
		foreach ($order as $target)
		{
			if ($this->itemExists($guid, $repo, $target))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Check if an item exists in any of the repositories.
	 *
	 * @param string $guid The unique identifier for the item.
	 * @param array $order The order of the targets to check.
	 *
	 * @return bool True if the item exists, false otherwise.
	 * @since 3.2.2
	 */
	protected function itemExistsInAllRepos(string $guid, array $order): bool
	{
		// We can only search if we have paths
		if (is_array($this->paths) && $this->paths !== [])
		{
			foreach ($order as $target)
			{
				foreach ($this->paths as $path)
				{
					if ($this->itemExists($guid, $path, $target))
					{
						return true;
					}
				}
			}
		}
		return false;
	}

	/**
	 * Get the branch field
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function getBranchField(): string
	{
		return $this->branch_field;
	}

	/**
	 * Get the branch default name
	 *
	 * @return string|null
	 * @since 3.2.2
	 */
	protected function getBranchDefaultName(): ?string
	{
		return $this->branch_name;
	}

	/**
	 * Get the branch name
	 *
	 * @param object    $item    The item path
	 *
	 * @return string|null
	 * @since 3.2.2
	 */
	protected function getBranchName(object $item): ?string
	{
		// get the branch field name
		$branch_field = $this->getBranchField();

		return $item->{$branch_field} ?? $this->getBranchDefaultName();
	}

	/**
	 * Get the index path
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function getIndexPath(): string
	{
		return $this->index_path;
	}

	/**
	 * Check if an item exists in a specific repo and target.
	 *
	 * @param string $guid   The unique identifier for the item.
	 * @param object $repo   The repository object to check against.
	 * @param string $target The target to check within the repo.
	 *
	 * @return bool True if the item exists, false otherwise.
	 * @since 3.2.2
	 */
	protected function itemExists(string $guid, object &$repo, string $target): bool
	{
		if (($function_name = $this->getFunctionName($target, 'index')) !== null)
		{
			$this->{$function_name}($repo);

			if (($function_name = $this->getFunctionName($target, 'exists')) !== null &&
				$this->{$function_name}($guid, $repo))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if item exists locally
	 *
	 * @param string   $guid  The global unique id of the item
	 *
	 * @return object|null   return path object
	 * @since 3.2.2
	 */
	protected function existsLocally(string $guid): ?object
	{
		// we can only search if we have paths
		if ($this->path && $this->paths)
		{
			foreach ($this->paths as $path)
			{
				// get local index
				$this->indexLocal($path);

				if ($this->existsLocal($guid, $path))
				{
					return $path;
				}
			}
		}

		return null;
	}

	/**
	 * Check if item exists remotely
	 *
	 * @param string   $guid  The global unique id of the item
	 *
	 * @return object|null   return path object
	 * @since 3.2.2
	 */
	protected function existsRemotely(string $guid): ?object
	{
		// we can only search if we have paths
		if ($this->paths)
		{
			foreach ($this->paths as $path)
			{
				// get local index
				$this->indexRemote($path);

				if ($this->existsRemote($guid, $path))
				{
					return $path;
				}
			}
		}

		return null;
	}

	/**
	 * Check if item exists locally
	 *
	 * @param string   $guid  The global unique id of the item
	 * @param object   $path  The path object
	 *
	 * @return bool   true if it exists
	 * @since 3.2.2
	 */
	protected function existsLocal(string $guid, object $path): bool
	{
		if (!empty($path->local) && isset($path->local->{$guid}))
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if item exists remotely
	 *
	 * @param string   $guid  The global unique id of the item
	 * @param object   $path  The path object
	 *
	 * @return bool   true if it exists
	 * @since 3.2.2
	 */
	protected function existsRemote(string $guid, object $path): bool
	{
		if (!empty($path->index) && isset($path->index->{$guid}))
		{
			return true;
		}

		return false;
	}

	/**
	 * Load the remote repository index of powers
	 *
	 * @param object    $path    The repository path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function indexRemote(object &$path): void
	{
		if (isset($path->index))
		{
			return; // already set
		}

		try
		{
			// load the base and token if set
			$this->loadApi($this->contents, $path->base ?? null, $path->token ?? null);
			$path->index = $this->contents->get($path->organisation, $path->repository, $this->getIndexPath(), $this->getBranchName($path));
		}
		catch (\Exception $e)
		{
			$path->index = null;
			$this->setRemoteIndexMessage($e->getMessage(), $path->path, $path->repository, $path->organisation, $path->base ?? null);
		}
		finally
		{
			// reset back to the global base and token
			$this->contents->reset_();
		}
	}

	/**
	 * Load the local repository index of powers
	 *
	 * @param object    $path    The repository path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function indexLocal(object &$path): void
	{
		if (isset($path->local) || !isset($path->full_path))
		{
			return;
		}

		if (($content = FileHelper::getContent($path->full_path . '/' . $this->getIndexPath(), null)) !== null &&
			JsonHelper::check($content))
		{
			$path->local = json_decode($content);

			return;
		}

		$path->local = null;
	}

	/**
	 * Set path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function initializeInstances(): void
	{
		if (is_array($this->paths) && $this->paths !== [])
		{
			foreach ($this->paths as $n => &$path)
			{
				if (isset($path->organisation) && strlen($path->organisation) > 1 &&
						isset($path->repository) && strlen($path->repository) > 1)
				{
					// resolve API if needed
					if (!empty($path->base))
					{
						$this->resolve->api($this->target ?? $path->repository, $path->base, $path->organisation, $path->repository);
					}

					// build the path
					$path->path = trim($path->organisation) . '/' . trim($path->repository);

					// get the branch field name
					$branch_field = $this->getBranchField();
					// get the branch name
					$branch = $this->getBranchName($path);

					if ($branch === 'default' || empty($branch))
					{
						// will allow us to target the default branch as set by the git system
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
	 * Load the remote file
	 *
	 * @param string         $organisation   The repository organisation
	 * @param string         $repository     The repository name
	 * @param string         $path           The repository path to file
	 * @param string|null    $branch         The repository branch name
	 *
	 * @return mixed
	 * @since 3.2.0
	 */
	protected function loadRemoteFile(string $organisation, string $repository, string $path, ?string $branch)
	{
		try
		{
			$data = $this->contents->get($organisation, $repository, $path, $branch);
		}
		catch (\Exception $e)
		{
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_PFILE_AT_BSSB_GAVE_THE_FOLLOWING_ERRORBR_SP', $this->contents->api(), $path, $e->getMessage()),
				'Error'
			);

			return null;
		}

		return $data;
	}
}

