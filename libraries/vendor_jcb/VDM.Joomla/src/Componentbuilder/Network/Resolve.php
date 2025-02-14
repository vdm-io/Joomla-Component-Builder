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

namespace VDM\Joomla\Componentbuilder\Network;


use Joomla\CMS\Log\Log;
use VDM\Joomla\Componentbuilder\Network\Url;
use VDM\Joomla\Componentbuilder\Network\Status;


/**
 * The Network Resolver
 * 
 * @since 5.0.4
 */
final class Resolve
{
	/**
	 * The Url Class.
	 *
	 * @var   Url
	 * @since 5.0.4
	 */
	protected Url $url;

	/**
	 * The Status Class.
	 *
	 * @var   Status
	 * @since 5.0.4
	 */
	protected Status $status;

	/**
	 * Constructor.
	 *
	 * @param Url     $url     The Url Class.
	 * @param Status  $status  The Status Class.
	 *
	 * @since 5.0.4
	 */
	public function __construct(Url $url, Status $status)
	{
		$this->url = $url;
		$this->status = $status;
	}

	/**
	 * Resolves the API for a repository if it is part of the core network.
	 *
	 * This method attempts to verify the status of the API and resolve an active URL if the current one is inactive.
	 *
	 * @param string   $target        The target network.
	 * @param string   &$domain       The API base domain (passed by reference).
	 * @param string   &$organisation The repository organisation (passed by reference).
	 * @param string   &$repository   The repository name (passed by reference).
	 *
	 * @return void
	 * @since  5.0.4
	 */
	public function api(string $target, string &$domain, string &$organisation, string &$repository): void
	{
		try {
			// Check the status of the current API
			$status = $this->status->get($target, $domain, $repository, $organisation);

			// If the API is inactive, attempt to find another active URL
			if ($status == 0)
			{
				$this->resolve($target, $domain, $organisation, $repository);
			}
		} catch (\Exception $e) {
			// ignore any none [in]active urls
			$this->logError($e, 'Failed to resolve API status.');
		}
	}

	/**
	 * Resolves an active API URL if the current API is inactive.
	 *
	 * Updates the `$domain`, `$organisation`, and `$repository` parameters to point to an active API URL.
	 *
	 * @param string   $target        The target network.
	 * @param string   &$domain       The API base domain (passed by reference).
	 * @param string   &$organisation The repository organisation (passed by reference).
	 * @param string   &$repository   The repository name (passed by reference).
	 *
	 * @return void
	 * @throws \Exception
	 * @since  5.0.4
	 */
	private function resolve(string $target, string &$domain, string &$organisation, string &$repository): void
	{
		$activeRepo = $this->active($target);

		if ($activeRepo === null) {
			// No active API found, log or handle this case as needed
			throw new \Exception('No active API found for the target: ' . $target);
		}

		try {
			// Parse the active repository's URL and update the references
			$parsedUrl = $this->url->parse($activeRepo->url);

			$noneActiveDomain = "{$domain}/{$organisation}/{$repository}";
			$activeDomain = "{$parsedUrl->scheme}://{$parsedUrl->domain}/{$parsedUrl->organisation}/{$parsedUrl->repository}";

			// update the values passed by reference
			$domain = $parsedUrl->scheme . '://' . $parsedUrl->domain;
			$organisation = $parsedUrl->organisation ?? $organisation;
			$repository = $parsedUrl->repository ?? $repository;

			// add info
			$this->logInfo("Resolved [{$noneActiveDomain}] to [{$activeDomain}]");
		} catch (\Exception $e) {
			// ignore any none [in]active urls
			$this->logError($e, 'Failed to parse active repository URL.');
		}
	}

	/**
	 * Retrieves a random active repository target, excluding the specified domain.
	 *
	 * @param string  $target  The target network.
	 *
	 * @return object|null   The randomly selected active repository, or null if none found.
	 * @since  5.0.4
	 */
	private function active(string $target): ?object
	{
		try {
			$activeRepo = $this->status->active($target);
		} catch (\Exception $e) {
			// ignore any none [in]active urls
			$this->logError($e, "Failed to get an [{$target}] active repository.");
		}

		return $activeRepo;
	}

	/**
	 * Logs an info custom message.
	 *
	 * @param string     $message   A custom message to include with the log entry.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function logInfo(string $message): void
	{
		Log::add($message, Log::INFO, 'jcb-network-resolve');
	}

	/**
	 * Logs an error with a custom message.
	 *
	 * This method is a placeholder for your actual logging mechanism.
	 *
	 * @param \Exception $exception The exception to log.
	 * @param string     $message   A custom message to include with the log entry.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function logError(\Exception $exception, string $message): void
	{
		Log::add($message . ' Exception: ' . $exception->getMessage(), Log::ERROR, 'jcb-network-resolve');
	}
}

