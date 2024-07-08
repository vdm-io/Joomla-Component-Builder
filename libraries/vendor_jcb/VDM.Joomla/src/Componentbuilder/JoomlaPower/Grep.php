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

namespace VDM\Joomla\Componentbuilder\JoomlaPower;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Interfaces\GrepInterface;
use VDM\Joomla\Abstraction\Grep as ExtendingGrep;


/**
 * Global Resource Empowerment Platform
 * 
 *    The Grep feature will try to find your joomla power in the repositories listed in the global
 *    Options of JCB in the super powers tab, and if it can't be found there will try the global core
 *    Super powers of JCB. All searches are performed according the the [algorithm:cascading]
 *    See documentation for more details: https://git.vdm.dev/joomla/super-powers/wiki
 * 
 * @since 3.2.1
 */
final class Grep extends ExtendingGrep implements GrepInterface
{
	/**
	 * Order of global search
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	protected array $order = ['remote'];

	/**
	 * Load the remote repository index of powers
	 *
	 * @param object    $path    The repository path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function remoteIndex(object &$path): void
	{
		if (isset($path->index))
		{
			return;
		}

		$path->index = null;

		// update the branch
		$branch_field = $this->getBranchField();
		$branch = $path->{$branch_field} ?? $path->read_branch ?? 'master';

		try
		{
			$this->contents->load_($path->base ?? null, $path->token ?? null);
			$source = $this->contents->metadata($path->organisation, $path->repository, 'src', $branch);
			if ($source && is_array($source))
			{
				$path->index = new \stdClass();
				foreach ($source as $index)
				{
					if (is_object($index) && isset($index->name))
					{
						$path->index->{$index->name} = $index;
					}
				}
			}

			$this->contents->reset_();
		}
		catch (\Exception $e)
		{
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_PJOOMLA_POWERB_REPOSITORY_AT_BSSB_GAVE_THE_FOLLOWING_ERRORBR_SP', $this->contents->api(), $path->path, $e->getMessage()),
				'Error'
			);
		}
	}

	/**
	 * Search for a remote power
	 *
	 * @param string    $guid    The global unique id of the power
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	protected function searchRemote(string $guid): ?object
	{
		// we can only search if we have paths
		if (is_array($this->paths))
		{
			foreach ($this->paths as $path)
			{
				// get local index
				$this->remoteIndex($path);

				if (!empty($path->index) && isset($path->index->{$guid}))
				{
					return $this->getRemote($path, $guid);
				}
			}
		}

		return null;
	}

	/**
	 * Get a remote joomla power
	 *
	 * @param object    $path    The repository path details
	 * @param string    $guid    The global unique id of the power
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	protected function getRemote(object $path, string $guid): ?object
	{
		$power = null;
		if (empty($path->index->{$guid}->path))
		{
			return $power;
		}

		// get the branch name
		$branch_field = $this->getBranchField();
		$branch = $path->{$branch_field} ?? $path->read_branch ?? 'master';

		// get the settings
		$this->contents->load_($path->base ?? null, $path->token ?? null);
		if (($power = $this->loadRemoteFile($path->organisation, $path->repository, $path->index->{$guid}->path . '/item.json', $branch)) !== null &&
			isset($power->guid))
		{
			// set the git details in params
			$path_guid = $path->guid ?? null;
			if ($path_guid !== null)
			{
				if (($meta = $this->contents->metadata($path->organisation, $path->repository, $path->index->{$guid}->path . '/item.json', $branch)) !== null &&
					isset($meta->sha))
				{
					if (isset($power->params) && is_object($power->params) &&
						isset($power->params->source) && is_array($power->params->source))
					{
						$power->params->source[$path_guid] = $meta->sha;
					}
					else
					{
						$power->params = (object)[
							'source' => [$path_guid => $meta->sha]
						];
					}
				}
			}
		}
		$this->contents->reset_();

		return $power;
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

