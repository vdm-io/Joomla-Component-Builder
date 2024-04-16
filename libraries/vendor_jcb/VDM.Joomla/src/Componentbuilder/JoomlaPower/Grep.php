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


use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Componentbuilder\Interfaces\GrepInterface;
use VDM\Joomla\Componentbuilder\Power\Grep as ExtendingGrep;


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
	 * Get a local power
	 *
	 * @param object    $path    The repository path details
	 * @param string    $guid    The global unique id of the power
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	private function getLocal(object $path, string $guid): ?object
	{
		if (empty($path->local->{$guid}->settings))
		{
			return null;
		}

		// get the settings
		if (($settings = FileHelper::getContent($path->full_path . '/' . $path->local->{$guid}->settings, null)) !== null &&
			JsonHelper::check($settings))
		{
			$power = json_decode($settings);

			if (isset($power->guid))
			{
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
	private function getRemote(object $path, string $guid): ?object
	{
		if (empty($path->index->{$guid}->settings))
		{
			return null;
		}

		// get the settings
		if (($power = $this->loadRemoteFile($path->owner, $path->repo, $path->index->{$guid}->settings, $path->branch)) !== null &&
			isset($power->guid))
		{
			return $power;
		}

		return null;
	}

	/**
	 * Load the local repository index of powers
	 *
	 * @param object    $path    The repository path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function localIndex(object &$path)
	{
		if (isset($path->local) || !isset($path->full_path))
		{
			return;
		}

		if (($content = FileHelper::getContent($path->full_path . '/joomla-powers.json', null)) !== null &&
			JsonHelper::check($content))
		{
			$path->local = json_decode($content);

			return;
		}

		$path->local = null;
	}

	/**
	 * Load the remote repository index of powers
	 *
	 * @param object    $path    The repository path details
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function remoteIndex(object &$path)
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
}

