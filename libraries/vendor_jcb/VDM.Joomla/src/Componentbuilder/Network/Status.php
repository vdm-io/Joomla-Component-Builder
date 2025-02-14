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


use VDM\Joomla\Componentbuilder\Api\Network;
use VDM\Joomla\Componentbuilder\Network\Core;
use VDM\Joomla\Componentbuilder\Network\Url;


/**
 * The Network Status
 * 
 * @since 5.0.4
 */
final class Status
{
	/**
	 * The Network Class.
	 *
	 * @var   Network
	 * @since 5.0.4
	 */
	protected Network $network;

	/**
	 * The Core Class.
	 *
	 * @var   Core
	 * @since 5.0.4
	 */
	protected Core $core;

	/**
	 * The Url Class.
	 *
	 * @var   Url
	 * @since 5.0.4
	 */
	protected Url $url;

	/**
	 * Constructor.
	 *
	 * @param Network   $network   The Network Class.
	 * @param Core      $core      The Core Class.
	 * @param Url       $url       The Url Class.
	 *
	 * @since 5.0.4
	 */
	public function __construct(Network $network, Core $core, Url $url)
	{
		$this->network = $network;
		$this->core = $core;
		$this->url = $url;
	}

	/**
	 * Retrieves the status for the given network target, utilizing caching via the Core registry.
	 *
	 * @param string  $target        The target network.
	 * @param string  $domain        The domain to retrieve [example: codeberg.org].
	 * @param string  $repository    The repository name.
	 * @param string  $organization  The target repository organization. (default: joomla)
	 *
	 * @return int Will return 1 if active, 0 if not, and -1 if not part of the core.
	 *
	 * @since 5.0.4
	 */
	public function get(string $target, string $domain, string $repository, string $organization = 'joomla'): int
	{
		try {
			$repo = $this->network($target, $domain, $organization, $repository);

			if ($repo === null)
			{
				// Domain not found in the network data
				return -1;
			}

			// Check if the repository is active
			if (isset($repo->status) && is_numeric($repo->status))
			{
				return (int) $repo->status;
			}
			else
			{
				// 'status' property not found or not numeric
				return -1;
			}
		}
		catch (\Exception $e)
		{
			// In case of any exception, return -1
			return -1;
		}
	}

	/**
	 * Retrieves a random active repository target, excluding the specified domain.
	 *
	 * @param string       $target          The target network name.
	 * @param array|null   $excludeDomains  The domain to exclude [default: ['git.vdm.dev']].
	 *
	 * @return object|null The randomly selected active repository, or null if none found.
	 * @since  5.0.4
	 */
	public function active(string $target, ?array $excludeDomains = ['git.vdm.dev']): ?object
	{
		try {
			// Get the network data for the target
			$data = $this->network($target);

			// Filter active repositories excluding the specified domain
			$activeRepos = array_filter($data->network, function ($repo) use ($excludeDomains) {
				$parsed = $this->url->parse($repo->url);
				return isset($repo->status) &&
					$repo->status == 1 &&
					!in_array($parsed->domain, $excludeDomains);
			});

			// Reindex the array to ensure array_rand works correctly
			$activeRepos = array_values($activeRepos);

			// If there are active repositories, select one at random
			if (!empty($activeRepos))
			{
				return $activeRepos[array_rand($activeRepos)];
			}
			else
			{
				// No active repositories found excluding the specified domain
				return null;
			}
		}
		catch (\Exception $e)
		{
			// In case of any exception, return null
			return null;
		}
	}

	/**
	 * Retrieves the data for the given network target, utilizing caching via the Core registry.
	 *
	 * If the data for the target is already cached in the Core registry, it returns that data.
	 * Otherwise, it fetches the data from the Network, caches it, and returns it.
	 *
	 * @param string       $target        The target network name.
	 * @param string|null  $domain        The domain to retrieve [example: codeberg.org].
	 * @param string|null  $organization  The target repository organization.
	 * @param string|null  $repository    The repository name.
	 *
	 * @return object|null  The data retrieved for the target.
	 * @throws \Exception If an error occurs during the network call or if the result contains an 'error' key.
	 * @since  5.0.4
	 */
	public function network(string $target, ?string $domain = null, ?string $organization = null, ?string $repository = null): ?object
	{
		$networkData = $this->fetchNetworkData($target);

		if ($domain !== null)
		{
			return $this->getDomainData($networkData->network, $domain, $organization, $repository);
		}

		return $networkData;
	}

	/**
	 * Retrieves the data filtered by domain, organization, and optionally repository.
	 *
	 * @param array       $network       The network data array.
	 * @param string      $domain        The domain to filter by.
	 * @param string|null $organization  The organization to filter by.
	 * @param string|null $repository    The repository to filter by.
	 *
	 * @return object|null The filtered data, or null if no match is found.
	 * @since  5.0.4
	 */
	private function getDomainData(array $network, string $domain, ?string $organization = null, ?string $repository = null): ?object
	{
		$domainBase = $this->url->base($domain);

		foreach ($network as $repo)
		{
			$parsedUrl = $this->url->parse($repo->url);

			if ($parsedUrl->domain === $domainBase)
			{
				if ($organization !== null && $parsedUrl->organization !== $organization)
				{
					continue;
				}

				if ($repository !== null && $parsedUrl->repository !== $repository)
				{
					continue;
				}

				return $repo;
			}
		}

		return null;
	}

	/**
	 * Fetches and caches the network data for a given target.
	 *
	 * @param string $target The target network name.
	 *
	 * @return object The cached or freshly fetched network data.
	 * @throws \Exception If an error occurs during the network call.
	 * @since  5.0.4
	 */
	private function fetchNetworkData(string $target): object
	{
		// Check if data is cached
		if (($cachedData = $this->core->get($target)) !== null)
		{
			return $cachedData;
		}

		try {
			// Fetch data from the network
			$networkData = $this->network->get($target);
		} catch (\Exception $e) {
			throw new \Exception('Network error: ' . $e->getMessage(), 0, $e);
		}

		// Validate the fetched data
		if (!is_object($networkData) || !property_exists($networkData, 'network'))
		{
			throw new \Exception('Invalid network data: Missing "network" property.');
		}

		if (property_exists($networkData, 'error'))
		{
			throw new \Exception('Network error: ' . $networkData->error);
		}

		// Cache the result
		$this->core->set($target, $networkData);

		return $networkData;
	}
}

