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

namespace VDM\Joomla\Componentbuilder\Fieldtype;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\GrepInterface;
use VDM\Joomla\Abstraction\Grep as ExtendingGrep;


/**
 * Global Resource Empowerment Platform
 * 
 *    The Grep feature will try to find your joomla power in the repositories listed in the global
 *    Options of JCB in the super powers tab, and if it can't be found there will try the global core
 *    Super powers of JCB. All searches are performed according the [algorithm:cascading]
 *    See documentation for more details: https://git.vdm.dev/joomla/super-powers/wiki
 * 
 * @since 5.0.3
 */
final class Grep extends ExtendingGrep implements GrepInterface
{
	/**
	 * Order of global search
	 *
	 * @var    array
	 * @since 5.0.3
	 **/
	protected array $order = ['remote'];

	/**
	 * Search for a remote item
	 *
	 * @param string    $guid    The global unique id of the item
	 *
	 * @return object|null
	 * @since  5.0.3
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
	 * Get a remote joomla power
	 *
	 * @param object    $path    The repository path details
	 * @param string    $guid    The global unique id of the power
	 *
	 * @return object|null
	 * @since  5.0.3
	 */
	protected function getRemote(object $path, string $guid): ?object
	{
		$power = null;
		if (empty($path->index->{$guid}->path))
		{
			return $power;
		}

		// get the branch name
		$branch = $this->getBranchName($path);

		// load the base and token if set
		$this->contents->load_($path->base ?? null, $path->token ?? null);

		// get the settings
		if (($power = $this->loadRemoteFile($path->organisation, $path->repository, $path->index->{$guid}->path . '/item.json', $branch)) !== null &&
			isset($power->guid))
		{
			// set the git details in params
			$path_guid = $path->guid ?? null;
			if ($path_guid !== null)
			{
				// get the Settings meta
				if (($meta = $this->contents->metadata($path->organisation, $path->repository, $path->index->{$guid}->path . '/item.json', $branch)) !== null &&
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
	 * @since  5.0.3
	 */
	protected function setRemoteIndexMessage(string $message, string $path, string $repository, string $organisation, ?string $base): void
	{
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_PJOOMLA_FIELD_TYPEB_REPOSITORY_AT_BSSB_GAVE_THE_FOLLOWING_ERRORBR_SP', $this->contents->api(), $path, $message),
			'Error'
		);
	}
}

