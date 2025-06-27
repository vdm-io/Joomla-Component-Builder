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

namespace VDM\Joomla\Componentbuilder\Package;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\GrepInterface;
use VDM\Joomla\Componentbuilder\Remote\Grep;


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
class GrepContent extends Grep implements GrepInterface
{
	/**
	 * The Grep target [network]
	 *
	 * @var    string
	 * @since  5.1.1
	 **/
	protected ?string $target = 'package';

	/**
	 * Get a remote folder.zip from a repository.
	 *
	 * @param object $path  The repository path details
	 * @param string $guid  The global unique ID of the power
	 *
	 * @return object|null
	 * @since  5.1.1
	 */
	protected function getRemote(object $path, string $guid): ?object
	{
		$content_path = $path->index[$this->entity]->{$guid}->path ?? null;
		if (empty($content_path))
		{
			return null;
		}

		$branch = $this->getBranchName($path);

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
			$content_path,
			$branch
		);

		if ($power === null)
		{
			$this->contents->reset_();
			return null;
		}

		$data = $path->index[$this->entity]->{$guid};
		$path_guid = $path->guid ?? null;

		$branch_field = $this->getBranchField();

		if ($branch_field === 'write_branch' && $path_guid !== null)
		{
			$this->setRepoItemSha($data, $path, $content_path, $branch, "{$path_guid}-settings");
		}

		$this->contents->reset_();

		$data->content = $power;

		return $data;
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
	 * @since  5.1.1
	 */
	protected function setRemoteIndexMessage(string $message, string $path, string $repository, string $organisation, ?string $base): void
	{
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_PPACKAGECONTENTB_REPOSITORY_AT_BSSB_GAVE_THE_FOLLOWING_ERRORBR_SP', $this->contents->api(), $path, $message),
			'Error'
		);
	}
}

