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
 * The Gitea Repository Reviews
 * 
 * @since 3.2.0
 */
class Reviews extends Api
{
	/**
	 * List all reviews for a pull request.
	 *
	 * @param	string  $owner	The owner name.
	 * @param	string  $repo	The repository name.
	 * @param	int     $index	The pull request index.
	 * @param	int     $page	The page number of results to return (1-based).
	 * @param	int     $limit	The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $owner,
		string $repo,
		int $index,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews";

		// Get the URI.
		$uri = $this->uri->get($path);

		// Set query parameters.
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a review for a pull request.
	 *
	 * @param	string $owner			The owner name.
	 * @param	string $repo			The repository name.
	 * @param	int $index			The pull request index.
	 * @param	string $body			The review body text.
	 * @param	string $event			The review event type (APPROVE, REQUEST_CHANGES, COMMENT).
	 * @param	array|null $comments	An array of CreatePullReviewComment objects.
	 * @param	string|null $commitId	The commit ID.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function create(
		string $owner,
		string $repo,
		int $index,
		string $body,
		string $event,
		?array $comments = null,
		?string $commitId = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews";

		// Set the review data.
		$data = new \stdClass();
		$data->body = $body;
		$data->event = $event;

		// Add comments if available.
		if ($comments !== null)
		{
			$data->comments = $comments;
		}

		// Add commitId if available.
		if ($commitId !== null)
		{
			$data->commit_id = $commitId;
		}

		// Send the request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Get a specific review for a pull request.
	 *
	 * @param	string $owner		The owner name.
	 * @param	string $repo		The repository name.
	 * @param	int $index		The pull request index.
	 * @param	int $id			The review ID.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function get(
		string $owner,
		string $repo,
		int $index,
		int $id
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews/{$id}";

		// Set the variables for the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('owner', $owner);
		$uri->setVar('repo', $repo);
		$uri->setVar('index', $index);
		$uri->setVar('id', $id);

		// Send the request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Submit a pending review to a pull request.
	 *
	 * @param	string $owner		The owner name.
	 * @param	string $repo		The repository name.
	 * @param	int $index		The pull request index.
	 * @param	int $id			The review ID.
	 * @param	string $body		The review body text.
	 * @param	string $event		The review event type (APPROVE, REQUEST_CHANGES, COMMENT).
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function submit(
		string $owner,
		string $repo,
		int $index,
		int $id,
		string $body,
		string $event
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews/{$id}";

		// Set the review data.
		$data = new \stdClass();
		$data->body = $body;
		$data->event = $event;

		// Send the request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Delete a specific review from a pull request.
	 *
	 * @param	string $owner		The owner name.
	 * @param	string $repo		The repository name.
	 * @param	int $index		The pull request index.
	 * @param	int $id			The review ID.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function delete(
		string $owner,
		string $repo,
		int $index,
		int $id
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews/{$id}";

		// Set the variables for the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('owner', $owner);
		$uri->setVar('repo', $repo);
		$uri->setVar('index', $index);
		$uri->setVar('id', $id);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 204, 'success'
		);
	}

	/**
	 * Get the comments of a specific review for a pull request.
	 *
	 * @param	string $owner		The owner name.
	 * @param	string $repo		The repository name.
	 * @param	int $index		The pull request index.
	 * @param	int $id			The review ID.
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function comments(
		string $owner,
		string $repo,
		int $index,
		int $id
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews/{$id}/comments";

		// Set the variables for the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('owner', $owner);
		$uri->setVar('repo', $repo);
		$uri->setVar('index', $index);
		$uri->setVar('id', $id);

		// Send the request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Dismiss a review for a pull request.
	 *
	 * @param	string $owner		The owner name.
	 * @param	string $repo		The repository name.
	 * @param	int $index		The pull request index.
	 * @param	int $id			The review ID.
	 * @param	string $message	The dismissal message.
	 * @param	bool $priors		The flag to dismiss prior reviews.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function dismiss(
		string $owner,
		string $repo,
		int $index,
		int $id,
		string $message,
		bool $priors = false
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews/{$id}/dismissals";

		// Set the dismissal data.
		$data = new \stdClass();
		$data->message = $message;
		$data->priors = $priors;

		// Send the request.
		return $this->response->get(
		    $this->http->post(
		        $this->uri->get($path), json_encode($data)
		    )
		);
	}

	/**
	 * Cancel the dismissal of a review for a pull request.
	 *
	 * @param	string $owner		The owner name.
	 * @param	string $repo		The repository name.
	 * @param	int $index		The pull request index.
	 * @param	int $id			The review ID.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function undismiss(
		string $owner,
		string $repo,
		int $index,
		int $id
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/reviews/{$id}/undismissals";

		// Send the request.
		return $this->response->get(
		    $this->http->post(
		        $this->uri->get($path)
		    )
		);
	}

}

