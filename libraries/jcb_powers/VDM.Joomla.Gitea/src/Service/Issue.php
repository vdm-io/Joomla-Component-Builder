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
use VDM\Joomla\Gitea\Issue as Issu;
use VDM\Joomla\Gitea\Issue\Comments;
use VDM\Joomla\Gitea\Issue\Repository\Comments as RepoComments;
use VDM\Joomla\Gitea\Issue\Deadline;
use VDM\Joomla\Gitea\Labels;
use VDM\Joomla\Gitea\Issue\Labels as IssueLabels;
use VDM\Joomla\Gitea\Issue\Milestones;
use VDM\Joomla\Gitea\Issue\Reactions;
use VDM\Joomla\Gitea\Issue\Reactions\Comment;
use VDM\Joomla\Gitea\Issue\Stopwatch;
use VDM\Joomla\Gitea\Issue\Subscriptions;
use VDM\Joomla\Gitea\Issue\Timeline;
use VDM\Joomla\Gitea\Issue\Times;


/**
 * The Gitea Issue Service
 * 
 * @since 3.2.0
 */
class Issue implements ServiceProviderInterface
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
		$container->alias(Issu::class, 'Gitea.Issue')
			->share('Gitea.Issue', [$this, 'getIssue'], true);

		$container->alias(Comments::class, 'Gitea.Issue.Comments')
			->share('Gitea.Issue.Comments', [$this, 'getComments'], true);

		$container->alias(RepoComments::class, 'Gitea.Issue.Repository.Comments')
			->share('Gitea.Issue.Repository.Comments', [$this, 'getRepoComments'], true);

		$container->alias(Deadline::class, 'Gitea.Issue.Deadline')
			->share('Gitea.Issue.Deadline', [$this, 'getDeadline'], true);

		$container->alias(Labels::class, 'Gitea.Labels')
			->share('Gitea.Labels', [$this, 'getLabels'], true);

		$container->alias(IssueLabels::class, 'Gitea.Issue.Labels')
			->share('Gitea.Issue.Labels', [$this, 'getIssueLabels'], true);

		$container->alias(Milestones::class, 'Gitea.Issue.Milestones')
			->share('Gitea.Issue.Milestones', [$this, 'getMilestones'], true);

		$container->alias(Reactions::class, 'Gitea.Issue.Reactions')
			->share('Gitea.Issue.Reactions', [$this, 'getReactions'], true);

		$container->alias(Comment::class, 'Gitea.Issue.Reactions.Comment')
			->share('Gitea.Issue.Reactions.Comment', [$this, 'getComment'], true);

		$container->alias(Stopwatch::class, 'Gitea.Issue.Stopwatch')
			->share('Gitea.Issue.Stopwatch', [$this, 'getStopwatch'], true);

		$container->alias(Subscriptions::class, 'Gitea.Issue.Subscriptions')
			->share('Gitea.Issue.Subscriptions', [$this, 'getSubscriptions'], true);

		$container->alias(Timeline::class, 'Gitea.Issue.Timeline')
			->share('Gitea.Issue.Timeline', [$this, 'getTimeline'], true);

		$container->alias(Times::class, 'Gitea.Issue.Times')
			->share('Gitea.Issue.Times', [$this, 'getTimes'], true);
	}

	/**
	 * Get the Issue class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Issu
	 * @since 3.2.0
	 */
	public function getIssue(Container $container): Issu
	{
		return new Issu(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Comments class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Comments
	 * @since 3.2.0
	 */
	public function getComments(Container $container): Comments
	{
		return new Comments(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Repository Comments class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  RepoComments
	 * @since 3.2.0
	 */
	public function getRepoComments(Container $container): RepoComments
	{
		return new RepoComments(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Labels class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Labels
	 * @since 3.2.0
	 */
	public function getLabels(Container $container): Labels
	{
		return new Labels(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Issue Labels class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  IssueLabels
	 * @since 3.2.0
	 */
	public function getIssueLabels(Container $container): IssueLabels
	{
		return new IssueLabels(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Milestones class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Milestones
	 * @since 3.2.0
	 */
	public function getMilestones(Container $container): Milestones
	{
		return new Milestones(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Reactions class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Reactions
	 * @since 3.2.0
	 */
	public function getReactions(Container $container): Reactions
	{
		return new Reactions(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Reactions Comment class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Comment
	 * @since 3.2.0
	 */
	public function getComment(Container $container): Comment
	{
		return new Comment(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Stopwatch class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Stopwatch
	 * @since 3.2.0
	 */
	public function getStopwatch(Container $container): Stopwatch
	{
		return new Stopwatch(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Subscriptions class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Subscriptions
	 * @since 3.2.0
	 */
	public function getSubscriptions(Container $container): Subscriptions
	{
		return new Subscriptions(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Timeline class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Timeline
	 * @since 3.2.0
	 */
	public function getTimeline(Container $container): Timeline
	{
		return new Timeline(
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

}

