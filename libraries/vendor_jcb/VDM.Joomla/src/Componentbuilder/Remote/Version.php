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

namespace VDM\Joomla\Componentbuilder\Remote;


use Joomla\CMS\Language\Text;
use Joomla\CMS\Version as JoomlaVersion;
use VDM\Joomla\Github\Factory as Github;
use VDM\Joomla\Gitea\Factory as Gitea;
use VDM\Joomla\Utilities\SessionHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;


/**
 * Get Remote Version
 * 
 * @since 5.1.1
 */
final class Version
{
	/**
	 * GitHub organization name.
	 *
	 * @var   string
	 * @since 5.1.1
	 */
	protected string $githubOrg;

	/**
	 * GitHub repository name.
	 *
	 * @var   string
	 * @since 5.1.1
	 */
	protected string $githubRepo;

	/**
	 * Gitea organization name.
	 *
	 * @var   string
	 * @since 5.1.1
	 */
	protected string $giteaOrg;

	/**
	 * Gitea repository name.
	 *
	 * @var   string
	 * @since 5.1.1
	 */
	protected string $giteaRepo;

	/**
	 * Constructor to set repository organization and name for both GitHub and Gitea.
	 *
	 * @param string $githubOrg   GitHub organization name.
	 * @param string $githubRepo  GitHub repository name.
	 * @param string $giteaOrg    Gitea organization name.
	 * @param string $giteaRepo   Gitea repository name.
	 *
	 * @since 5.1.1
	 */
	public function __construct(string $githubOrg, string $githubRepo, string $giteaOrg, string $giteaRepo)
	{
		$this->githubOrg = $githubOrg;
		$this->githubRepo = $githubRepo;
		$this->giteaOrg = $giteaOrg;
		$this->giteaRepo = $giteaRepo;
	}

	/**
	 * Get the current version notice.
	 *
	 * Compares the installed version of the component with the latest available
	 * version from the repository tags and returns an appropriate message.
	 *
	 * @param   string|null  $version  Optional version to compare if manifest version not found.
	 *
	 * @return  array  The array with 'notice' or 'error' and optional 'github-error' / 'gitea-error'.
	 * @since   5.1.1
	 */
	public function get(?string $version = null): array
	{
		$defaultDownloadLink = 'https://git.vdm.dev/joomla/pkg-component-builder/releases';

		$manifest = ComponentbuilderHelper::manifest();
		$localVersion = (string) ($manifest->version ?? $version ?? '1.0.0');
		$joomlaMajor = (string) JoomlaVersion::MAJOR_VERSION;

		$errors = [
			'error' => Text::sprintf('COM_COMPONENTBUILDER_THERE_WAS_AN_ERROR_GETTING_THE_SVERSION_DETAILSA',
				'<a href="' . $defaultDownloadLink . '" title="Version Tag details">'
			)
		];

		$tags = $this->getRepositoryTags($errors, $localVersion);

		if (empty($tags) || !isset($tags[0]->name))
		{
			return $this->mergeErrors($errors);
		}

		$grouped = $this->groupTagsByType($tags, $joomlaMajor);

		$latestStableTag   = $grouped['stable'][0] ?? null;
		$latestStableVer   = $latestStableTag ? $this->normalizeVersion($latestStableTag->name) : '1.0.0';
		$latestStableLink  = $latestStableTag->zipball_url ?? $defaultDownloadLink;

		$versionType = $this->getVersionType($localVersion);
		$versionCompare    = version_compare(
			$this->normalizeVersion($localVersion),
			$latestStableVer
		);

		// Handle pre-release versions
		if ($versionType !== 'stable')
		{
			$isLatestPre = $this->isLatestPreRelease($localVersion, $grouped['pre']);

			$state = $isLatestPre ? Text::_('COM_COMPONENTBUILDER_PRE_RELEASE') : Text::_('COM_COMPONENTBUILDER_OUT_OF_DATE');
			$statement = sprintf(
				'<small><span class="icon-wrench"></span>&nbsp;%s</small>',
				$state
			);

			$color = $isLatestPre ? '#F7B033' : 'red';
			$state = $isLatestPre
				? Text::sprintf("COM_COMPONENTBUILDER_THANK_YOU_FOR_TESTING_THE_S_RELEASE_YOURE_A_JCB_HERO", strtoupper($versionType))
				: Text::sprintf("COM_COMPONENTBUILDER_GRAB_THE_LATEST_S_TESTING_RELEASE", strtoupper($versionType));

			$notice  = sprintf(
				' <a style="color:%s;" href="%s" title="%s">%s</a>',
				$color, $grouped['pre'][0]->zipball_url ?? $defaultDownloadLink, $state, $statement
			);

			return ['notice' => $notice];
		}

		// Stable and up-to-date
		if ($versionCompare === 0)
		{
			$notice = sprintf(
				'<small><span class="icon-shield"></span>&nbsp;%s</small>',
				Text::_('COM_COMPONENTBUILDER_UP_TO_DATE')
			);

			if (!empty($grouped['pre']))
			{
				$notice = sprintf(
					' <a style="color:green;" href="%s" title="%s">%s</a>',
					$grouped['pre'][0]->zipball_url ?? $defaultDownloadLink,
					Text::_('COM_COMPONENTBUILDER_HELP_US_TEST_THE_UPCOMING_RELEASE'),
					$notice
				);
			}

			return ['notice' => $notice];
		}

		// Stable but outdated
		return ['notice' => sprintf(
			'<small><span style="color:red;"><span class="icon-warning-circle"></span>&nbsp;%s</span> ' .
			'<a style="color:green;" href="%s" title="%s">%s</a></small>',
			Text::_('COM_COMPONENTBUILDER_OUT_OF_DATE') . '!',
			$latestStableLink,
			Text::_('COM_COMPONENTBUILDER_YOU_CAN_DIRECTLY_DOWNLOAD_THE_LATEST_UPDATE_OR_USE_THE_JOOMLA_UPDATE_AREA'),
			Text::_('COM_COMPONENTBUILDER_DOWNLOAD_UPDATE') . '!'
		)];
	}

	/**
	 * Normalize version string (strip v/V).
	 *
	 * @param   string   $version  The version string.
	 *
	 * @return  string
	 * @since   5.1.4
	 */
	protected function normalizeVersion(string $version): string
	{
		return ltrim(trim($version), 'vV');
	}

	/**
	 * Check if the local pre-release version is the latest.
	 *
	 * @param   string         $localVersion  The current local version.
	 * @param   array<int, object>  $preTags  All matching pre-release tags.
	 *
	 * @return  bool
	 * @since   5.1.1
	 */
	protected function isLatestPreRelease(string $localVersion, array $preTags): bool
	{
		if (!$preTags)
		{
			return false;
		}

		usort($preTags, fn($a, $b) =>
			version_compare(
				$this->normalizeVersion($b->name),
				$this->normalizeVersion($a->name)
			)
		);

		return version_compare(
			$this->normalizeVersion($localVersion),
			$this->normalizeVersion($preTags[0]->name)
		) === 0;
	}

	/**
	 * Fetch tags from GitHub or fallback to various Gitea instances.
	 *
	 * Appends source keys to the return array on failure.
	 *
	 * @param   array   &$errors       The response array to populate error messages into.
	 * @param   string  $localVersion  The current local version of the component.
	 *
	 * @return  array<int, object>  List of tags or an empty array.
	 * @since   5.1.1
	 */
	protected function getRepositoryTags(array &$errors, $localVersion): array
	{
		if (($tags = SessionHelper::get("jcb-version-tags-{$localVersion}")) !== null)
		{
			return $tags;
		}

		// Attempt GitHub fetch
		if ($tags = $this->tryFetchTags('github', $errors))
		{
			SessionHelper::set("jcb-version-tags-{$localVersion}", $tags);
			return $tags;
		}

		// Try default VDM Gitea instance
		if ($tags = $this->tryFetchTags('gitea', $errors))
		{
			SessionHelper::set("jcb-version-tags-{$localVersion}", $tags);
			return $tags;
		}

		// Try alternative Gitea hosts
		$alternatives = [
			'codeberg' => 'https://codeberg.org',
			'tildegit' => 'https://tildegit.org',
			'disroot' => 'https://git.disroot.org',
		];

		foreach ($alternatives as $key => $url)
		{
			Gitea::_('Gitea.Repository.Tags')->load_($url, '');
			if ($tags = $this->tryFetchTags($key, $errors))
			{
				SessionHelper::set("jcb-version-tags-{$localVersion}", $tags);
				return $tags;
			}
		}

		// Final reset to default host
		return [];
	}

	/**
	 * Attempt to fetch tags from a given source and record any error.
	 *
	 * @param   string  $source   One of: 'github', 'gitea', 'codeberg', 'tildegit', 'disroot'.
	 * @param   array   &$errors  Reference to return array for error recording.
	 *
	 * @return  array<int, object>|null  List of tags or null on failure.
	 * @since   5.1.1
	 */
	protected function tryFetchTags(string $source, array &$errors): ?array
	{
		try {
			return match ($source) {
				'github' => Github::_('Github.Repository.Tags')->list($this->githubOrg, $this->githubRepo, 1, 50),
				default  => Gitea::_('Gitea.Repository.Tags')->list($this->giteaOrg, $this->giteaRepo, 1, 50),
			};
		} catch (\Throwable $e) {
			$errors["{$source}-error"] = $e->getMessage();
		} finally {
			if ($source !== 'github' && $source !== 'gitea') {
				Gitea::_('Gitea.Repository.Tags')->reset_();
			}
		}

		return null;
	}

	/**
	 * Groups and sorts tags into stable and pre-release arrays.
	 *
	 * @param   array<int, object>  $tags   List of repository tags.
	 * @param   string              $major  Major version prefix to match.
	 *
	 * @return  array{stable: array<int, object>, pre: array<int, object>}
	 * @since   5.1.1
	 */
	protected function groupTagsByType(array $tags, string $major): array
	{
		$stable = [];
		$pre    = [];

		foreach ($tags as $tag)
		{
			if (!isset($tag->name))
			{
				continue;
			}

			$version = $this->normalizeVersion($tag->name);

			if (!preg_match('#^' . preg_quote($major, '#') . '\.#', $version))
			{
				continue;
			}

			if (preg_match('/-(alpha|beta|rc)\d*/i', $version)) {
				$pre[] = $tag;
			} else {
				$stable[] = $tag;
			}
		}

		usort($stable, fn($a, $b) =>
			version_compare(
				$this->normalizeVersion($b->name),
				$this->normalizeVersion($a->name)
			)
		);

		usort($pre, fn($a, $b) =>
			version_compare(
				$this->normalizeVersion($b->name),
				$this->normalizeVersion($a->name)
			)
		);

		return ['stable' => $stable, 'pre' => $pre];
	}

	/**
	 * Determine the version type from the string.
	 *
	 * @param   string  $version  The version string to analyze.
	 *
	 * @return  string  'stable', 'alpha', 'beta' or 'rc'.
	 * @since   5.1.1
	 */
	protected function getVersionType(string $version): string
	{
		$version = strtolower($version);

		return str_contains($version, '-alpha') ? 'alpha'
			: (str_contains($version, '-beta') ? 'beta'
			: (str_contains($version, '-rc') ? 'rc' : 'stable'));
	}

	/**
	 * Merge repository fetch errors into the error message as a toggleable Bootstrap block.
	 *
	 * This enhances the 'error' message by appending a red icon and a collapsible
	 * section with the actual GitHub/Gitea error messages.
	 *
	 * @param   array  $errors  The array containing at least 'error' and optionally error details.
	 *
	 * @return  array  The modified array with a richer 'error' message.
	 * @since   5.1.1
	 */
	protected function mergeErrors(array $errors): array
	{
		$bucket = [];

		foreach ($errors as $key => $value)
		{
			if ($key !== 'error')
			{
				$source = ucfirst(explode('-', $key)[0]);
				$bucket[] = '<li><strong>' . $source . ':</strong> ' . htmlspecialchars($value) . '</li>';
			}
		}

		if (empty($bucket))
		{
			return $errors;
		}

		$uid = uniqid('version-error-');

		$toggle = sprintf(
			'&nbsp;<a href="#" class="text-danger ms-2" data-bs-toggle="collapse" data-bs-target="#%s" aria-expanded="false" aria-controls="%s">' .
			'<span class="icon-exclamation-circle" style="font-size:1.2rem;"></span>&nbsp;<small>%s</small></a>',
			$uid,
			$uid,
			Text::_('COM_COMPONENTBUILDER_DETAILS')
		);

		$details = sprintf(
			'<div class="collapse mt-2" id="%s"><ul class="list-unstyled text-danger small ps-3">%s</ul></div>',
			$uid,
			implode('', $bucket)
		);

		$errors['error'] .= $toggle . $details;

		return $errors;
	}
}

