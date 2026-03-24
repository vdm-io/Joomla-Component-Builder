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

namespace VDM\Joomla\Git\Repository;


use VDM\Joomla\Gitea\Repository\Contents as Gitea;
use VDM\Joomla\Github\Repository\Contents as Github;
use VDM\Joomla\Interfaces\Git\Repository\ContentsInterface;


/**
 * The Git Repository Contents
 * 
 * @since 5.1.1
 */
final class Contents implements ContentsInterface
{
	/**
	 * The target system
	 *
	 * @var string|null
	 * @since 5.1.1
	 */
	protected ?string $target = null;

	/**
	 * The Contents Class.
	 *
	 * @var   Gitea
	 * @since 5.1.1
	 */
	protected Gitea $gitea;

	/**
	 * The Contents Class.
	 *
	 * @var   Github
	 * @since 5.1.1
	 */
	protected Github $github;

	/**
	 * Constructor.
	 *
	 * @param Gitea    $gitea    The Contents Class.
	 * @param Github   $github   The Contents Class.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Gitea $gitea, Github $github)
	{
		$this->gitea = $gitea;
		$this->github = $github;
	}

	/**
	 * Set the target system to use (gitea or github)
	 *
	 * @param string $system
	 *
	 * @return self
	 * @throws \DomainException
	 * @since 5.1.1
	 */
	public function setTarget(string $system): self
	{
		$system = strtolower(trim($system));

		if (!in_array($system, ['gitea', 'github'], true))
		{
			throw new \DomainException("Invalid target system: {$system}");
		}

		$this->target = $system;

		return $this;
	}

	/**
	 * Ensure a valid target is set
	 *
	 * @return string
	 * @throws \DomainException
	 * @since   5.1.1
	 */
	protected function getTarget(): string
	{
		if ($this->target === null)
		{
			throw new \DomainException('No target system selected. Use $this->setTarget("gitea"|"github") before calling this method.');
		}

		return $this->target;
	}

	/**
	 * Load/Reload API.
	 *
	 * @param   string|null     $url      The url.
	 * @param   string|null     $token    The token.
	 * @param   bool            $backup   The backup swapping switch.
	 *
	 * @return  void
	 * @since   5.1.1
	 **/
	public function load_(?string $url = null, ?string $token = null, bool $backup = true): void
	{
		$target = $this->getTarget();
		$this->{$target}->load_($url, $token, $backup);
	}

	/**
	 * Reset to previous toke, url it set
	 *
	 * @return  void
	 * @since   5.1.1
	 **/
	public function reset_(): void
	{
		$target = $this->getTarget();
		$this->{$target}->reset_();
	}

	/**
	 * Get the API url
	 *
	 * @return  string
	 * @since   5.1.1
	 **/
	public function api()
	{
		$target = $this->getTarget();
		$this->{$target}->api();
	}

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
	 * @since   5.1.1
	 **/
	public function get(string $owner, string $repo, string $filepath, ?string $ref = null)
	{
		$target = $this->getTarget();
		return $this->{$target}->get($owner, $repo, $filepath, $ref);
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
	 * @since   5.1.1
	 **/
	public function metadata(string $owner, string $repo, string $filepath, ?string $ref = null): null|array|object
	{
		$target = $this->getTarget();
		return $this->{$target}->metadata($owner, $repo, $filepath, $ref);
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
	 * @since   5.1.1
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
		$target = $this->getTarget();
		return $this->{$target}->create(
			$owner, $repo, $filepath, $content, $message, $branch,
			$authorName, $authorEmail, $committerName, $committerEmail,
			$newBranch, $authorDate, $committerDate, $signoff
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
	 * @since   5.1.1
	 **/
	public function root(string $owner, string $repo, ?string $ref = null): ?array
	{
		$target = $this->getTarget();
		return $this->{$target}->root($owner, $repo, $ref);
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
	 * @since   5.1.1
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
		$target = $this->getTarget();
		return $this->{$target}->update(
			$owner, $repo, $filepath, $content, $message, $sha, $branch,
			$authorName, $authorEmail, $committerName, $committerEmail,
			$authorDate, $committerDate, $fromPath, $newBranch, $signoff
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
	 * @since   5.1.1
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
		$target = $this->getTarget();
		return $this->{$target}->delete(
			$owner, $repo, $filepath, $message, $sha, $branch,
			$authorName, $authorEmail, $committerName, $committerEmail,
			$authorDate, $committerDate, $newBranch, $signoff
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
	 * @since   5.1.1
	 **/
	public function editor(string $owner, string $repo, string $filepath, ?string $ref = null): ?string
	{
		$target = $this->getTarget();
		return $this->{$target}->editor($owner, $repo, $filepath, $ref);
	}

	/**
	 * Get the blob of a repository.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 * @param   string   $sha    The SHA hash of the blob.
	 *
	 * @return  object|null
	 * @since   5.1.1
	 **/
	public function blob(string $owner, string $repo, string $sha): ?object
	{
		$target = $this->getTarget();
		return $this->{$target}->blob($owner, $repo, $sha);
	}
}

