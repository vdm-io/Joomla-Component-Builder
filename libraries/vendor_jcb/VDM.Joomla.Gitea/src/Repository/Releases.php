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
 * The Gitea Repository Releases
 * 
 * @since 3.2.0
 */
class Releases extends Api
{
	/**
	 * List a repo's releases.
	 *
	 * @param	string $ownerName	The owner name.
	 * @param	string $repoName		The repository name.
	 * @param	bool|null $draft		Filter (exclude/include) drafts (optional).
	 * @param	bool|null $preRelease	Filter (exclude/include) pre-releases (optional).
	 * @param	int $page				Page number of results to return (1-based, optional).
	 * @param	int $limit				Page size of results (optional).
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function list(
		string $ownerName,
		string $repoName,
		?bool $draft = null,
		?bool $preRelease = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases";

		// Set additional URI values.
		$this->uri->setVar('page', $page);
		$this->uri->setVar('limit', $limit);

		if ($draft !== null) 
		{
			$this->uri->setVar('draft', $draft);
		}

		if ($preRelease !== null) 
		{
			$this->uri->setVar('pre-release', $preRelease);
		}

		// Send the request.
		return $this->response->get(
		    $this->http->get(
		        $this->uri->get($path)
		    )
		);
	}

	/**
	 * Create a release.
	 *
	 * @param	string   $ownerName		The owner name.
	 * @param	string   $repoName			The repository name.
	 * @param	string   $tagName			The tag name.
	 * @param	string   $targetCommitish	The commitish value that determines where the Git tag is created from.
	 * @param	string   $releaseName		The name of the release.
	 * @param	string   $releaseBody		The description of the release.
	 * @param	bool     $isDraft			Whether the release is a draft.
	 * @param	bool     $isPrerelease		Whether the release is a pre-release.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $ownerName,
		string $repoName,
		string $tagName,
		string $targetCommitish,
		string $releaseName,
		string $releaseBody,
		bool $isDraft = false,
		bool $isPrerelease = false
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases";

		// Set the release data
		$data = new \stdClass();
		$data->tag_name = $tagName;
		$data->target_commitish = $targetCommitish;
		$data->name = $releaseName;
		$data->body = $releaseBody;
		$data->draft = $isDraft;
		$data->prerelease = $isPrerelease;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Get a release by ID.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	int      $releaseId		The release ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $ownerName,
		string $repoName,
		int $releaseId
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases/{$releaseId}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a release by ID.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	int      $releaseId		The release ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $ownerName,
		string $repoName,
		int $releaseId
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases/{$releaseId}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Update a release.
	 *
	 * @param	string       $ownerName		The owner name.
	 * @param	string       $repoName		The repository name.
	 * @param	int          $releaseId			The release ID.
	 * @param	string|null  $tagName		The tag name (optional).
	 * @param	string|null  $targetCommitish	The commitish value that determines where the Git tag is created from (optional).
	 * @param	string|null  $releaseName	The name of the release (optional).
	 * @param	string|null  $description		The description of the release (optional).
	 * @param	bool|null    $isDraft			Whether the release is a draft (optional).
	 * @param	bool|null    $isPrerelease	Whether the release is a pre-release (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function update(
		string $ownerName,
		string $repoName,
		int $releaseId,
		?string $tagName = null,
		?string $targetCommitish = null,
		?string $releaseName = null,
		?string $description = null,
		?bool $isDraft = null,
		?bool $isPrerelease = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases/{$releaseId}";

		// Set the release data
		$data = new \stdClass();

		if ($tagName !== null || $targetCommitish !== null || $releaseName !== null || $description !== null || $isDraft !== null || $isPrerelease !== null)
		{
			$data->editReleaseOption = new \stdClass();

			if ($tagName !== null)
			{
				$data->editReleaseOption->tag_name = $tagName;
			}

			if ($targetCommitish !== null)
			{
				$data->editReleaseOption->target_commitish = $targetCommitish;
			}

			if ($releaseName !== null)
			{
				$data->editReleaseOption->name = $releaseName;
			}

			if ($description !== null)
			{
				$data->editReleaseOption->body = $description;
			}

			if ($isDraft !== null)
			{
				$data->editReleaseOption->draft = $isDraft;
			}

			if ($isPrerelease !== null)
			{
				$data->editReleaseOption->prerelease = $isPrerelease;
			}
		}

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Get a release by tag name.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $tagName		The tag name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function getByTag(
		string $ownerName,
		string $repoName,
		string $tagName
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases/tags/{$tagName}";

		// Configure the URI with the path.
		$this->uri->setVar('owner', $ownerName);
		$this->uri->setVar('repo', $repoName);
		$this->uri->setVar('tag', $tagName);

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a release by tag name.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $tagName		The tag name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function deleteByTag(
		string $ownerName,
		string $repoName,
		string $tagName
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases/tags/{$tagName}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

