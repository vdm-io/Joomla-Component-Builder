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


use VDM\Joomla\Interfaces\Git\Repository\ContentsInterface;
use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Repository Contents
 * 
 * @since 3.2.0
 */
class Contents extends Api implements ContentsInterface
{
	/**
	 * Get a file from a repository.
	 *
	 * @param   string       $owner     The owner name.
	 * @param   string       $repo      The repository name.
	 * @param   string       $filepath  The file path.
	 * @param   string|null  $ref       Optional. The name of the commit/branch/tag.
	 *                                  Default the repository's default branch (usually master).
	 *
	 * @return  mixed
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, string $filepath, ?string $ref = null)
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/raw/{$filepath}";

		// Get the URI with the specified path.
		$uri = $this->uri->get($path);

		// Add the ref parameter if provided.
		if ($ref !== null)
		{
			$uri->setVar('ref', $ref);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get the metadata and contents (if a file) of an entry in a repository,
	 * or a list of entries if a directory.
	 *
	 * @param   string       $owner     The owner name.
	 * @param   string       $repo      The repository name.
	 * @param   string       $filepath  The file or directory path.
	 * @param   string|null  $ref       Optional. The name of the commit/branch/tag.
	 *                                  Default the repository's default branch (usually master).
	 *
	 * @return  null|array|object
	 * @since   3.2.0
	 **/
	public function metadata(string $owner, string $repo, string $filepath, ?string $ref = null): null|array|object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/contents/{$filepath}";

		// Get the URI with the specified path.
		$uri = $this->uri->get($path);

		// Add the ref parameter if provided.
		if ($ref !== null)
		{
			$uri->setVar('ref', $ref);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a file in a repository.
	 *
	 * @param   string      $owner           The owner name.
	 * @param   string      $repo            The repository name.
	 * @param   string      $filepath        The file path.
	 * @param   string      $content         The file content.
	 * @param   string      $message         The commit message.
	 * @param   string      $branch          The branch name. Defaults to the repository's default branch.
	 * @param   string|null $authorName      The author's name.
	 * @param   string|null $authorEmail     The author's email.
	 * @param   string|null $committerName   The committer's name.
	 * @param   string|null $committerEmail  The committer's email.
	 * @param   string|null   $newBranch       Whether to create a new branch. Defaults to null.
	 * @param   string|null $authorDate      The author's date.
	 * @param   string|null $committerDate   The committer's date.
	 * @param   bool|null   $signoff         Add a Signed-off-by trailer. Defaults to null.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $filepath,
		string $content,
		string $message,
		string $branch = 'master',
		?string $authorName = null,
		?string $authorEmail = null,
		?string $committerName = null,
		?string $committerEmail = null,
		?string $newBranch = null,
		?string $authorDate = null,
		?string $committerDate = null,
		?bool $signoff = null
	): ?object {
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/contents/{$filepath}";

		// Set the post data
		$data = new \stdClass();
		$data->content = base64_encode($content);
		$data->message = $message;
		$data->branch = $branch;

		if ($authorName !== null || $authorEmail !== null)
		{
			$data->author = new \stdClass();
			if ($authorName !== null)
			{
				$data->author->name = $authorName;
			}
			if ($authorEmail !== null)
			{
				$data->author->email = $authorEmail;
			}
		}

		if ($committerName !== null || $committerEmail !== null)
		{
			$data->committer = new \stdClass();
			if ($committerName !== null)
			{
				$data->committer->name = $committerName;
			}
			if ($committerEmail !== null)
			{
				$data->committer->email = $committerEmail;
			}
		}

		if ($newBranch !== null)
		{
			$data->new_branch = $newBranch;
		}

		if ($authorDate !== null || $committerDate !== null)
		{
			$data->dates = new \stdClass();
			if ($authorDate !== null)
			{
				$data->dates->author = $authorDate;
			}
			if ($committerDate !== null)
			{
				$data->dates->committer = $committerDate;
			}
		}

		if ($signoff !== null)
		{
			$data->signoff = $signoff;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Get the metadata of all the entries of the root directory.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 * @param   string|null $ref The name of the commit/branch/tag. Default the repository's default branch (usually master).
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function root(string $owner, string $repo, ?string $ref = null): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/contents";

		// Get the URI with the specified path.
		$uri = $this->uri->get($path);

		// Add the 'ref' parameter if it's provided.
		if ($ref !== null)
		{
			$uri->setVar('ref', $ref);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$uri
			)
		);
	}

	/**
	 * Update a file in a repository.
	 *
	 * @param   string       $owner          The owner name.
	 * @param   string       $repo           The repository name.
	 * @param   string       $filepath       The file path.
	 * @param   string       $content        The file content.
	 * @param   string       $message        The commit message.
	 * @param   string       $sha            The blob SHA of the file.
	 * @param   string       $branch         The branch name. Defaults to the repository's default branch.
	 * @param   string|null  $authorName     The author name. Defaults to the authenticated user.
	 * @param   string|null  $authorEmail    The author email. Defaults to the authenticated user.
	 * @param   string|null  $committerName  The committer name. Defaults to the authenticated user.
	 * @param   string|null  $committerEmail The committer email. Defaults to the authenticated user.
	 * @param   string|null  $authorDate     The author date.
	 * @param   string|null  $committerDate  The committer date.
	 * @param   string|null  $fromPath       The original file path to move/rename.
	 * @param   string|null  $newBranch      The new branch to create from the specified branch.
	 * @param   bool|null    $signoff        Add a Signed-off-by trailer.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function update(
		string $owner,
		string $repo,
		string $filepath,
		string $content,
		string $message,
		string $sha,
		string $branch = 'master',
		?string $authorName = null,
		?string $authorEmail = null,
		?string $committerName = null,
		?string $committerEmail = null,
		?string $authorDate = null,
		?string $committerDate = null,
		?string $fromPath = null,
		?string $newBranch = null,
		?bool $signoff = null
	): ?object {
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/contents/{$filepath}";

		// Set the file data.
		$data = new \stdClass();
		$data->content = base64_encode($content);
		$data->message = $message;
		$data->branch = $branch;
		$data->sha = $sha;

		if ($authorName !== null || $authorEmail !== null)
		{
			$data->author = new \stdClass();
			
			if ($authorName !== null)
			{
				$data->author->name = $authorName;
			}

			if ($authorEmail !== null)
			{
				$data->author->email = $authorEmail;
			}
		}

		if ($committerName !== null || $committerEmail !== null)
		{
			$data->committer = new \stdClass();

			if ($committerName !== null)
			{
				$data->committer->name = $committerName;
			}

			if ($committerEmail !== null)
			{
				$data->committer->email = $committerEmail;
			}
		}

		if ($authorDate !== null || $committerDate !== null)
		{
			$data->dates = new \stdClass();

			if ($authorDate !== null)
			{
				$data->dates->author = $authorDate;
			}

			if ($committerDate !== null)
			{
				$data->dates->committer = $committerDate;
			}
		}

		if ($fromPath !== null)
		{
			$data->from_path = $fromPath;
		}

		if ($newBranch !== null)
		{
			$data->new_branch = $newBranch;
		}

		if ($signoff !== null)
		{
			$data->signoff = $signoff;
		}

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

	/**
	 * Delete a file in a repository.
	 *
	 * @param   string       $owner          The owner name.
	 * @param   string       $repo           The repository name.
	 * @param   string       $filepath       The file path.
	 * @param   string       $message        The commit message.
	 * @param   string       $sha            The blob SHA of the file.
	 * @param   string|null  $branch         The branch name (optional).
	 * @param   string|null  $authorName     The author name (optional).
	 * @param   string|null  $authorEmail    The author email (optional).
	 * @param   string|null  $committerName  The committer name (optional).
	 * @param   string|null  $committerEmail The committer email (optional).
	 * @param   string|null  $authorDate     The author date (optional).
	 * @param   string|null  $committerDate  The committer date (optional).
	 * @param   string|null  $newBranch      The new branch name (optional).
	 * @param   bool|null    $signoff        Add a Signed-off-by trailer (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		string $filepath,
		string $message,
		string $sha,
		?string $branch = null,
		?string $authorName = null,
		?string $authorEmail = null,
		?string $committerName = null,
		?string $committerEmail = null,
		?string $authorDate = null,
		?string $committerDate = null,
		?string $newBranch = null,
		?bool $signoff = null
	): ?object {
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/contents/{$filepath}";

		// Set the file data.
		$data = new \stdClass();
		$data->message = $message;
		$data->sha = $sha;

		if ($branch !== null) {
			$data->branch = $branch;
		}

		if ($authorName !== null || $authorEmail !== null)
		{
			$data->author = new \stdClass();
			
			if ($authorName !== null)
			{
				$data->author->name = $authorName;
			}

			if ($authorEmail !== null)
			{
				$data->author->email = $authorEmail;
			}
		}

		if ($committerName !== null || $committerEmail !== null)
		{
			$data->committer = new \stdClass();

			if ($committerName !== null)
			{
				$data->committer->name = $committerName;
			}

			if ($committerEmail !== null)
			{
				$data->committer->email = $committerEmail;
			}
		}

		if ($authorDate !== null || $committerDate !== null)
		{
			$data->dates = new \stdClass();

			if ($authorDate !== null)
			{
				$data->dates->author = $authorDate;
			}

			if ($committerDate !== null)
			{
				$data->dates->committer = $committerDate;
			}
		}

		if ($newBranch !== null)
		{
			$data->new_branch = $newBranch;
		}

		if ($signoff !== null)
		{
			$data->signoff = $signoff;
		}

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path), [], null,
				json_encode($data)
			)
		);
	}

	/**
	 * Get the EditorConfig definitions of a file in a repository.
	 *
	 * @param   string       $owner      The owner name.
	 * @param   string       $repo       The repository name.
	 * @param   string       $filepath   The file path.
	 * @param   string|null  $ref        The name of the commit/branch/tag.
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function editor(string $owner, string $repo, string $filepath, string $ref = null): ?string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/editorconfig/{$filepath}";

		// Set the request parameters.
		$uri = $this->uri->get($path);

		if ($ref !== null)
		{
			$uri->setVar('ref', $ref);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get the blob of a repository.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 * @param   string   $sha    The SHA hash of the blob.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function blob(string $owner, string $repo, string $sha): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/git/blobs/{$sha}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}
}

