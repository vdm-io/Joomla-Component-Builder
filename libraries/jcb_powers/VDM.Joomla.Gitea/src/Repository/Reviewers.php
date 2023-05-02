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

namespace VDM\Joomla\Gitea\Repository;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Repository Reviewers
 * 
 * @since 3.2.0
 */
class Reviewers extends Api
{
	/**
	 * Create review requests for a pull request.
	 *
	 * @param	string       $owner				The owner name.
	 * @param	string       $repo				The repository name.
	 * @param	int          $index				The pull request index.
	 * @param	array        $reviewers			Array of reviewers usernames.
	 * @param	array|null   $teamReviewers		Array of team reviewers (optional).
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function request(
		string $owner,
		string $repo,
		int $index,
		array $reviewers,
		?array $teamReviewers = null
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/requested_reviewers";

		// Set the review requests data.
		$data = new \stdClass();
		$data->reviewers = $reviewers;

		if ($teamReviewers !== null)
		{
			$data->team_reviewers = $teamReviewers;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Cancel review requests for a pull request.
	 *
	 * @param	string       $owner				The owner name.
	 * @param	string       $repo				The repository name.
	 * @param	int          $index				The pull request index.
	 * @param	array        $reviewers			Array of reviewers usernames.
	 * @param	array|null   $teamReviewers		Array of team reviewers (optional).
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function cancel(
		string $owner,
		string $repo,
		int $index,
		array $reviewers,
		?array $teamReviewers = null
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/requested_reviewers";

		// Get the URI and set the required variables.
		$uri = $this->uri->get($path);
		$uri->setVar('reviewers', json_encode($reviewers));

		if ($teamReviewers !== null)
		{
			$uri->setVar('teamReviewers', json_encode($teamReviewers));
		}

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 204, 'success'
		);
	}

	/**
	 * Return all users that can be requested to review in this repo.
	 *
	 * @param	string   $owner	The owner name.
	 * @param	string   $repo		The repository name.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/reviewers";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

}

