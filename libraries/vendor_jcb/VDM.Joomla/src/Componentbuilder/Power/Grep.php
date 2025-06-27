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

namespace VDM\Joomla\Componentbuilder\Power;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\JsonHelper;
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
 * @since 3.2.0
 */
final class Grep extends ExtendingGrep implements GrepInterface
{
	/**
	 * Search for a local item
	 *
	 * @param string    $guid    The global unique id of the item
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	protected function searchLocal(string $guid): ?object
	{
		// check if it exists locally
		if (($path = $this->existsLocally($guid)) !== null)
		{
			return $this->getLocal($path, $guid);
		}

		return null;
	}

	/**
	 * Search for a remote item
	 *
	 * @param string    $guid    The global unique id of the item
	 *
	 * @return object|null
	 * @since 3.2.0
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
	 * Get a local power
	 *
	 * @param object    $path    The repository path details
	 * @param string    $guid    The global unique id of the power
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	protected function getLocal(object $path, string $guid): ?object
	{
		if (empty($path->local->{$guid}->settings) || empty($path->local->{$guid}->power))
		{
			return null;
		}

		// get the settings
		if (($settings = FileHelper::getContent($path->full_path . '/' . $path->local->{$guid}->settings, null)) !== null &&
			JsonHelper::check($settings))
		{
			$power = json_decode($settings);

			// get the code
			if (($code = FileHelper::getContent($path->full_path . '/' . $path->local->{$guid}->power, null)) !== null)
			{
				$power->main_class_code = $code;
				return $power;
			}
		}

		return null;
	}

	/**
	 * Get a remote power object from a repository.
	 *
	 * @param object $path  The repository path details
	 * @param string $guid  The global unique ID of the power
	 *
	 * @return object|null
	 * @since  5.1.1
	 */
	protected function getRemote(object $path, string $guid): ?object
	{
		$entry = $path->index[$this->entity]->{$guid} ?? null;
		if (!is_object($entry) || empty($entry->path)
			|| empty($entry->settings) || empty($entry->power))
		{
			return null;
		}

		$relative_path = $entry->path;
		$power_path = $entry->power;
		$settings_path = $entry->settings;

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
			$settings_path,
			$branch
		);

		if ($power === null || !isset($power->{$guid_field}))
		{
			$this->contents->reset_();
			return null;
		}

		$code = $this->loadRemoteFile(
			$path->organisation,
			$path->repository,
			$power_path,
			$branch
		);

		if ($code !== null)
		{
			$power->main_class_code = $code;
		}

		$path_guid = $path->guid ?? null;

		$branch_field = $this->getBranchField();

		if ($branch_field === 'write_branch' && $path_guid !== null)
		{
			$this->setRepoItemSha($power, $path, $settings_path, $branch, "{$path_guid}-settings");
			$this->setRepoItemSha($power, $path, $power_path, $branch, "{$path_guid}-power");

			if ($readme_enabled)
			{
				$readme_name = $this->getItemReadmeName();
				$this->setRepoItemSha($power, $path, "{$relative_path}/{$readme_name}", $branch, "{$path_guid}-readme");
			}
		}

		$this->contents->reset_();

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
	 * @since 3.2.0
	 */
	protected function setRemoteIndexMessage(string $message, string $path, string $repository, string $organisation, ?string $base): void
	{
		if ($repository === 'super-powers' && $organisation !== 'joomla' && (empty($base) || $base === 'https://git.vdm.dev'))
		{
			// Give heads-up about the overriding feature
			$this->app->enqueueMessage(
				Text::sprintf(
					'<p>Super Power</b> repository at <b>https://git.vdm.dev/%s</b> can be used to override any power!<br />But has not yet been set in your account at https://git.vdm.dev/%s<br /><small>This is an optional feature.</small>',
					$path,
					$organisation
				),
				'Message'
			);
		}
		else
		{
			// Give error
			$this->app->enqueueMessage(
				Text::sprintf(
					'<p>Super Power</b> repository at <b>%s/%s</b> gave the following error!<br />%s</p>',
					$this->contents->api(),
					$path,
					$message
				),
				'Error'
			);
		}
	}
}

