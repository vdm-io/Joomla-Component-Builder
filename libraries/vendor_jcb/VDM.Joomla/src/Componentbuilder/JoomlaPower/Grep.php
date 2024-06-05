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

		try
		{
			$path->index = $this->contents->get($path->owner, $path->repo, 'joomla-powers.json', $path->branch);
		}
		catch (\Exception $e)
		{
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_PSUPER_POWERB_REPOSITORY_AT_BSSB_GAVE_THE_FOLLOWING_ERRORBR_SP', $this->contents->api(), $path->path, $e->getMessage()),
				'Error'
			);

			$path->index = null;
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
		if ($this->path && $this->paths)
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
	 * Get a remote power
	 *
	 * @param object    $path    The repository path details
	 * @param string    $guid    The global unique id of the power
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	protected function getRemote(object $path, string $guid): ?object
	{
		if (empty($path->index->{$guid}->settings))
		{
			return null;
		}

		// get the settings
		if (($power = $this->loadRemoteFile($path->owner, $path->repo, $path->index->{$guid}->settings, $path->branch)) !== null &&
			isset($power->guid))
		{
			// set the git details in params
			$power->params = (object) [
				'git' => [
					'owner' => $path->owner,
					'repo' => $path->repo,
					'branch' => $path->branch
				]
			];

			return $power;
		}

		return null;
	}

	/**
	 * Load the remote file
	 *
	 * @param string         $owner    The repository owner
	 * @param string         $repo     The repository name
	 * @param string         $path     The repository path to file
	 * @param string|null    $branch   The repository branch name
	 *
	 * @return mixed
	 * @since 3.2.0
	 */
	protected function loadRemoteFile(string $owner, string $repo, string $path, ?string $branch)
	{
		try
		{
			$data = $this->contents->get($owner, $repo, $path, $branch);
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

