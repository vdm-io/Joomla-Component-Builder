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

namespace VDM\Joomla\Componentbuilder\Remote;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\GrepInterface;
use VDM\Joomla\Abstraction\Grep as ExtendingGrep;


/**
 * Global Resource Empowerment Platform
 * 
 *    The Grep feature will try to find your power in the repositories
 *    linked to this [area], and if it can't be found there will try the global core
 *    Super Powers of JCB. All searches are performed according the [algorithm:cascading]
 *    See documentation for more details: https://git.vdm.dev/joomla/super-powers/wiki
 * 
 * @since 5.1.1
 */
abstract class Grep extends ExtendingGrep implements GrepInterface
{
	/**
	 * Order of global search
	 *
	 * @var    array
	 * @since 5.1.1
	 **/
	protected array $order = ['remote'];

	/**
	 * Search for a remote item
	 *
	 * @param string    $guid    The global unique id of the item
	 *
	 * @return object|null
	 * @since  5.1.1
	 */
	protected function searchRemote(string $guid): ?object
	{
		// check if it exists remotely
		if (($path = $this->existsRemotely($guid)) !== null)
		{
			return $this->getRemote($path, $guid);
		}

		return null;
	}

	/**
	 * Get a remote snippet object from a repository.
	 *
	 * @param object $path  The repository path details
	 * @param string $guid  The global unique ID of the power
	 *
	 * @return object|null
	 * @since  5.1.1
	 */
	protected function getRemote(object $path, string $guid): ?object
	{
		$relative_path = $path->index[$this->entity]->{$guid}->path ?? null;
		if (empty($relative_path))
		{
			return null;
		}

		$branch         = $this->getBranchName($path);
		$guid_field     = $this->getGuidField();
		$settings_name  = $this->getSettingsName();
		$readme_enabled = $this->hasItemReadme();

		// set the target system
		$target = $path->target ?? 'gitea';
		$this->contents->setTarget($target);

		// load the base and token if set
		$this->loadApi(
			$this->contents,
			$path->base ?? null,
			$path->token ?? null
		);

		$power = $this->loadRemoteFile(
			$path->organisation,
			$path->repository,
			"{$relative_path}/{$settings_name}",
			$branch
		);

		if ($power === null || !isset($power->{$guid_field}))
		{
			$this->contents->reset_();
			return null;
		}

		$path_guid = $path->guid ?? null;

		$branch_field = $this->getBranchField();

		if ($branch_field === 'write_branch' && $path_guid !== null)
		{
			$this->setRepoItemSha($power, $path, "{$relative_path}/{$settings_name}", $branch, "{$path_guid}-settings");

			if ($readme_enabled)
			{
				$readme_name = $this->getItemReadmeName();
				$this->setRepoItemSha($power, $path, "{$relative_path}/{$readme_name}", $branch, "{$path_guid}-readme");
			}
		}

		$this->contents->reset_();

		if (method_exists($this, 'setDependencies'))
		{
			$this->setDependencies($power);
		}

		return $power;
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
	 * @since  3.2.0
	 */
	abstract protected function setRemoteIndexMessage(string $message, string $path, string $repository, string $organisation, ?string $base): void;
}

