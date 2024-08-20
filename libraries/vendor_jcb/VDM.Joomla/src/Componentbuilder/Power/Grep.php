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
 *    The Grep feature will try to find your power in the repositories listed in the global
 *    Options of JCB in the super powers tab, and if it can't be found there will try the global core
 *    Super powers of JCB. All searches are performed according the the [algorithm:cascading]
 *    See documentation for more details: https://git.vdm.dev/joomla/super-powers/wiki
 * 
 * @since 3.2.0
 */
final class Grep extends ExtendingGrep implements GrepInterface
{
	/**
	 * The index file path
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_path = 'super-powers.json';

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
		if (empty($path->local->{$guid}->settings) || empty($path->local->{$guid}->code))
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
		$power = null;
		if (empty($path->index->{$guid}->settings) || empty($path->index->{$guid}->code))
		{
			return $power;
		}

		// get the branch name
		$branch = $this->getBranchName($path);

		// load the base and token if set
		$this->contents->load_($path->base ?? null, $path->token ?? null);

		// get the settings
		if (($power = $this->loadRemoteFile($path->organisation, $path->repository, $path->index->{$guid}->settings, $branch)) !== null &&
			isset($power->guid))
		{
			// get the code
			if (($code = $this->loadRemoteFile($path->organisation, $path->repository, $path->index->{$guid}->power, $branch)) !== null)
			{
				// set the git details in params
				$power->main_class_code = $code;
			}

			// set the git details in params
			$path_guid = $path->guid ?? null;
			if ($path_guid !== null)
			{
				// get the Settings meta
				if (($meta = $this->contents->metadata($path->organisation, $path->repository, $path->index->{$guid}->settings, $branch)) !== null &&
					isset($meta->sha))
				{
					if (isset($power->params) && is_object($power->params) &&
						isset($power->params->source) && is_array($power->params->source))
					{
						$power->params->source[$path_guid . '-settings'] = $meta->sha;
					}
					else
					{
						$power->params = (object) [
							'source' => [$path_guid . '-settings' => $meta->sha]
						];
					}
				}
				// get the power meta
				if (($meta = $this->contents->metadata($path->organisation, $path->repository, $path->index->{$guid}->power, $branch)) !== null &&
					isset($meta->sha))
				{
					if (isset($power->params) && is_object($power->params) &&
						isset($power->params->source) && is_array($power->params->source))
					{
						$power->params->source[$path_guid . '-power'] = $meta->sha;
					}
					else
					{
						$power->params = (object) [
							'source' => [$path_guid . '-power' => $meta->sha]
						];
					}
				}
				// get the README meta
				if (($meta = $this->contents->metadata($path->organisation, $path->repository, $path->index->{$guid}->path . '/README.md', $branch)) !== null &&
					isset($meta->sha))
				{
					if (isset($power->params) && is_object($power->params) &&
						isset($power->params->source) && is_array($power->params->source))
					{
						$power->params->source[$path_guid . '-readme'] = $meta->sha;
					}
					else
					{
						$power->params = (object) [
							'source' => [$path_guid . '-readme' => $meta->sha]
						];
					}
				}
			}
		}

		// reset back to the global base and token
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

