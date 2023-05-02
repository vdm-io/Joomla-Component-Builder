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

namespace VDM\Joomla\Gitea\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Gitea\Repository as Repo;
use VDM\Joomla\Gitea\Repository\Archive;
use VDM\Joomla\Gitea\Repository\Assignees;
use VDM\Joomla\Gitea\Repository\Attachments;
use VDM\Joomla\Gitea\Repository\Branch;
use VDM\Joomla\Gitea\Repository\Branch\Protection;
use VDM\Joomla\Gitea\Repository\Collaborator;
use VDM\Joomla\Gitea\Repository\Commits;
use VDM\Joomla\Gitea\Repository\Contents;
use VDM\Joomla\Gitea\Repository\Forks;
use VDM\Joomla\Gitea\Repository\Gpg;
use VDM\Joomla\Gitea\Repository\Hooks;
use VDM\Joomla\Gitea\Repository\Hooks\Git;
use VDM\Joomla\Gitea\Repository\Keys;
use VDM\Joomla\Gitea\Repository\Languages;
use VDM\Joomla\Gitea\Repository\Media;
use VDM\Joomla\Gitea\Repository\Merge;
use VDM\Joomla\Gitea\Repository\Mirror;
use VDM\Joomla\Gitea\Repository\Mirrors;
use VDM\Joomla\Gitea\Repository\Notes;
use VDM\Joomla\Gitea\Repository\Patch;
use VDM\Joomla\Gitea\Repository\Pulls;
use VDM\Joomla\Gitea\Repository\Refs;
use VDM\Joomla\Gitea\Repository\Releases;
use VDM\Joomla\Gitea\Repository\Remote;
use VDM\Joomla\Gitea\Repository\Reviewers;
use VDM\Joomla\Gitea\Repository\Reviews;
use VDM\Joomla\Gitea\Repository\Stargazers;
use VDM\Joomla\Gitea\Repository\Statuses;
use VDM\Joomla\Gitea\Repository\Tags;
use VDM\Joomla\Gitea\Repository\Teams;
use VDM\Joomla\Gitea\Repository\Templates;
use VDM\Joomla\Gitea\Repository\Times;
use VDM\Joomla\Gitea\Repository\Topics;
use VDM\Joomla\Gitea\Repository\Transfer;
use VDM\Joomla\Gitea\Repository\Trees;
use VDM\Joomla\Gitea\Repository\Watchers;
use VDM\Joomla\Gitea\Repository\Wiki;


/**
 * The Gitea Repository Service
 * 
 * @since 3.2.0
 */
class Repository implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(Repo::class, 'Gitea.Repository')
			->share('Gitea.Repository', [$this, 'getRepository'], true);

		$container->alias(Archive::class, 'Gitea.Repository.Archive')
			->share('Gitea.Repository.Archive', [$this, 'getArchive'], true);

		$container->alias(Assignees::class, 'Gitea.Repository.Assignees')
			->share('Gitea.Repository.Assignees', [$this, 'getAssignees'], true);

		$container->alias(Attachments::class, 'Gitea.Repository.Attachments')
			->share('Gitea.Repository.Attachments', [$this, 'getAttachments'], true);

		$container->alias(Branch::class, 'Gitea.Repository.Branch')
			->share('Gitea.Repository.Branch', [$this, 'getBranch'], true);

		$container->alias(Protection::class, 'Gitea.Repository.Branch.Protection')
			->share('Gitea.Repository.Branch.Protection', [$this, 'getProtection'], true);

		$container->alias(Collaborator::class, 'Gitea.Repository.Collaborator')
			->share('Gitea.Repository.Collaborator', [$this, 'getCollaborator'], true);

		$container->alias(Commits::class, 'Gitea.Repository.Commits')
			->share('Gitea.Repository.Commits', [$this, 'getCommits'], true);

		$container->alias(Contents::class, 'Gitea.Repository.Contents')
			->share('Gitea.Repository.Contents', [$this, 'getContents'], true);

		$container->alias(Forks::class, 'Gitea.Repository.Forks')
			->share('Gitea.Repository.Forks', [$this, 'getForks'], true);

		$container->alias(Gpg::class, 'Gitea.Repository.Gpg')
			->share('Gitea.Repository.Gpg', [$this, 'getGpg'], true);

		$container->alias(Hooks::class, 'Gitea.Repository.Hooks')
			->share('Gitea.Repository.Hooks', [$this, 'getHooks'], true);

		$container->alias(Git::class, 'Gitea.Repository.Hooks.Git')
			->share('Gitea.Repository.Hooks.Git', [$this, 'getGit'], true);

		$container->alias(Keys::class, 'Gitea.Repository.Keys')
			->share('Gitea.Repository.Keys', [$this, 'getKeys'], true);

		$container->alias(Languages::class, 'Gitea.Repository.Languages')
			->share('Gitea.Repository.Languages', [$this, 'getLanguages'], true);

		$container->alias(Media::class, 'Gitea.Repository.Media')
			->share('Gitea.Repository.Media', [$this, 'getMedia'], true);

		$container->alias(Merge::class, 'Gitea.Repository.Merge')
			->share('Gitea.Repository.Merge', [$this, 'getMerge'], true);

		$container->alias(Mirror::class, 'Gitea.Repository.Mirror')
			->share('Gitea.Repository.Mirror', [$this, 'getMirror'], true);

		$container->alias(Mirrors::class, 'Gitea.Repository.Mirrors')
			->share('Gitea.Repository.Mirrors', [$this, 'getMirrors'], true);

		$container->alias(Notes::class, 'Gitea.Repository.Notes')
			->share('Gitea.Repository.Notes', [$this, 'getNotes'], true);

		$container->alias(Patch::class, 'Gitea.Repository.Patch')
			->share('Gitea.Repository.Patch', [$this, 'getPatch'], true);

		$container->alias(Pulls::class, 'Gitea.Repository.Pulls')
			->share('Gitea.Repository.Pulls', [$this, 'getPulls'], true);

		$container->alias(Refs::class, 'Gitea.Repository.Refs')
			->share('Gitea.Repository.Refs', [$this, 'getRefs'], true);

		$container->alias(Releases::class, 'Gitea.Repository.Releases')
			->share('Gitea.Repository.Releases', [$this, 'getReleases'], true);

		$container->alias(Remote::class, 'Gitea.Repository.Remote')
			->share('Gitea.Repository.Remote', [$this, 'getRemote'], true);

		$container->alias(Reviewers::class, 'Gitea.Repository.Reviewers')
			->share('Gitea.Repository.Reviewers', [$this, 'getReviewers'], true);

		$container->alias(Reviews::class, 'Gitea.Repository.Reviews')
			->share('Gitea.Repository.Reviews', [$this, 'getReviews'], true);

		$container->alias(Stargazers::class, 'Gitea.Repository.Stargazers')
			->share('Gitea.Repository.Stargazers', [$this, 'getStargazers'], true);

		$container->alias(Statuses::class, 'Gitea.Repository.Statuses')
			->share('Gitea.Repository.Statuses', [$this, 'getStatuses'], true);

		$container->alias(Tags::class, 'Gitea.Repository.Tags')
			->share('Gitea.Repository.Tags', [$this, 'getTags'], true);

		$container->alias(Teams::class, 'Gitea.Repository.Teams')
			->share('Gitea.Repository.Teams', [$this, 'getTeams'], true);

		$container->alias(Templates::class, 'Gitea.Repository.Templates')
			->share('Gitea.Repository.Templates', [$this, 'getTemplates'], true);

		$container->alias(Times::class, 'Gitea.Repository.Times')
			->share('Gitea.Repository.Times', [$this, 'getTimes'], true);

		$container->alias(Topics::class, 'Gitea.Repository.Topics')
			->share('Gitea.Repository.Topics', [$this, 'getTopics'], true);

		$container->alias(Transfer::class, 'Gitea.Repository.Transfer')
			->share('Gitea.Repository.Transfer', [$this, 'getTransfer'], true);

		$container->alias(Trees::class, 'Gitea.Repository.Trees')
			->share('Gitea.Repository.Trees', [$this, 'getTrees'], true);

		$container->alias(Watchers::class, 'Gitea.Repository.Watchers')
			->share('Gitea.Repository.Watchers', [$this, 'getWatchers'], true);

		$container->alias(Wiki::class, 'Gitea.Repository.Wiki')
			->share('Gitea.Repository.Wiki', [$this, 'getWiki'], true);
	}

	 /**
	 * Get the Repository class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Repo
	 * @since 3.2.0
	 */
	public function getRepository(Container $container): Repo
	{
		return new Repo(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}
	
	/**
	 * Get the Archive class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Archive
	 * @since 3.2.0
	 */
	public function getArchive(Container $container): Archive
	{
		return new Archive(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Assignees class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Assignees
	 * @since 3.2.0
	 */
	public function getAssignees(Container $container): Assignees
	{
		return new Assignees(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Attachments class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Attachments
	 * @since 3.2.0
	 */
	public function getAttachments(Container $container): Attachments
	{
		return new Attachments(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Branch class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Branch
	 * @since 3.2.0
	 */
	public function getBranch(Container $container): Branch
	{
		return new Branch(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Branch Protection class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Protection
	 * @since 3.2.0
	 */
	public function getProtection(Container $container): Protection
	{
		return new Protection(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Collaborator class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Collaborator
	 * @since 3.2.0
	 */
	public function getCollaborator(Container $container): Collaborator
	{
		return new Collaborator(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Commits class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Commits
	 * @since 3.2.0
	 */
	public function getCommits(Container $container): Commits
	{
		return new Commits(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Contents class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Contents
	 * @since 3.2.0
	 */
	public function getContents(Container $container): Contents
	{
		return new Contents(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Forks class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Forks
	 * @since 3.2.0
	 */
	public function getForks(Container $container): Forks
	{
		return new Forks(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Gpg class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Gpg
	 * @since 3.2.0
	 */
	public function getGpg(Container $container): Gpg
	{
		return new Gpg(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Hooks class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Hooks
	 * @since 3.2.0
	 */
	public function getHooks(Container $container): Hooks
	{
		return new Hooks(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Hooks Git class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Git
	 * @since 3.2.0
	 */
	public function getGit(Container $container): Git
	{
		return new Git(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Keys class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Keys
	 * @since 3.2.0
	 */
	public function getKeys(Container $container): Keys
	{
		return new Keys(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Languages class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Languages
	 * @since 3.2.0
	 */
	public function getLanguages(Container $container): Languages
	{
		return new Languages(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Media class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Media
	 * @since 3.2.0
	 */
	public function getMedia(Container $container): Media
	{
		return new Media(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Merge class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Merge
	 * @since 3.2.0
	 */
	public function getMerge(Container $container): Merge
	{
		return new Merge(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Mirror class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Mirror
	 * @since 3.2.0
	 */
	public function getMirror(Container $container): Mirror
	{
		return new Mirror(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Mirrors class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Mirrors
	 * @since 3.2.0
	 */
	public function getMirrors(Container $container): Mirrors
	{
		return new Mirrors(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Notes class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Notes
	 * @since 3.2.0
	 */
	public function getNotes(Container $container): Notes
	{
		return new Notes(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Patch class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Patch
	 * @since 3.2.0
	 */
	public function getPatch(Container $container): Patch
	{
		return new Patch(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Pulls class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Pulls
	 * @since 3.2.0
	 */
	public function getPulls(Container $container): Pulls
	{
		return new Pulls(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Refs class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Refs
	 * @since 3.2.0
	 */
	public function getRefs(Container $container): Refs
	{
		return new Refs(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Releases class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Releases
	 * @since 3.2.0
	 */
	public function getReleases(Container $container): Releases
	{
		return new Releases(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Remote class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Remote
	 * @since 3.2.0
	 */
	public function getRemote(Container $container): Remote
	{
		return new Remote(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Reviewers class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Reviewers
	 * @since 3.2.0
	 */
	public function getReviewers(Container $container): Reviewers
	{
		return new Reviewers(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Reviews class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Reviews
	 * @since 3.2.0
	 */
	public function getReviews(Container $container): Reviews
	{
		return new Reviews(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Stargazers class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Stargazers
	 * @since 3.2.0
	 */
	public function getStargazers(Container $container): Stargazers
	{
		return new Stargazers(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Statuses class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Statuses
	 * @since 3.2.0
	 */
	public function getStatuses(Container $container): Statuses
	{
		return new Statuses(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Tags class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Tags
	 * @since 3.2.0
	 */
	public function getTags(Container $container): Tags
	{
		return new Tags(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Teams class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Teams
	 * @since 3.2.0
	 */
	public function getTeams(Container $container): Teams
	{
		return new Teams(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Templates class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Templates
	 * @since 3.2.0
	 */
	public function getTemplates(Container $container): Templates
	{
		return new Templates(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Times class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Times
	 * @since 3.2.0
	 */
	public function getTimes(Container $container): Times
	{
		return new Times(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Topics class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Topics
	 * @since 3.2.0
	 */
	public function getTopics(Container $container): Topics
	{
		return new Topics(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Transfer class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Transfer
	 * @since 3.2.0
	 */
	public function getTransfer(Container $container): Transfer
	{
		return new Transfer(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Trees class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Trees
	 * @since 3.2.0
	 */
	public function getTrees(Container $container): Trees
	{
		return new Trees(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Watchers class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Watchers
	 * @since 3.2.0
	 */
	public function getWatchers(Container $container): Watchers
	{
		return new Watchers(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Wiki class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Wiki
	 * @since 3.2.0
	 */
	public function getWiki(Container $container): Wiki
	{
		return new Wiki(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

}

