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


use VDM\Joomla\Componentbuilder\Network\ParsedUrls;


/**
 * The Network Url
 * 
 * @since 5.0.4
 */
final class Url
{
	/**
	 * The ParsedUrls Class.
	 *
	 * @var   ParsedUrls
	 * @since 5.0.4
	 */
	protected ParsedUrls $parsedurls;

	/**
	 * Constructor.
	 *
	 * @param ParsedUrls   $parsedurls   The ParsedUrls Class.
	 *
	 * @since 5.0.4
	 */
	public function __construct(ParsedUrls $parsedurls)
	{
		$this->parsedurls = $parsedurls;
	}

	/**
	 * Parses a URL and extracts the domain, organization, and repository.
	 *
	 * This method takes a URL of the format 'https://[domain]/[organization]/[repository]'
	 * and returns an associative array with keys 'domain', 'organization', and 'repository'.
	 *
	 * @param string $url The URL to parse.
	 *
	 * @return object  An object with keys 'domain', 'organization', and 'repository'.
	 * @throws \InvalidArgumentException If the URL is invalid or lacks required components.
	 * @since  5.0.4
	 */
	public function parse(string $url): object
	{
		// Check if the URL has already been parsed and is present in the cache
		if (($parsed = $this->parsedurls->get($url)) !== null)
		{
			return (object) $parsed;
		}

		// Validate the URL format
		if (!filter_var($url, FILTER_VALIDATE_URL))
		{
			throw new \InvalidArgumentException("Invalid URL format: $url");
		}

		// Parse the URL and extract its components
		$parsedUrl = parse_url($url);

		if ($parsedUrl === false)
		{
			throw new \InvalidArgumentException("Invalid URL provided: $url");
		}

		// Ensure the URL contains a host (domain)
		if (empty($parsedUrl['host']))
		{
			throw new \InvalidArgumentException("The URL does not contain a valid domain: $url");
		}
		$domain = $parsedUrl['host'];

		// Set the scheme
		$scheme = $parsedUrl['scheme'] ?? 'https';

		// Ensure the URL contains a path
		if (empty($parsedUrl['path']))
		{
			throw new \InvalidArgumentException("The URL does not contain a valid path: $url");
		}

		// Remove leading and trailing slashes from the path
		$path = trim($parsedUrl['path'], '/');

		// Split the path into components
		$pathParts = explode('/', $path);

		// Ensure the path contains at least two components: organization and repository
		if (count($pathParts) < 2)
		{
			throw new \InvalidArgumentException("The URL must contain both an organization and a repository: $url");
		}

		$organization = $pathParts[0];
		$repository = $pathParts[1];

		// Create a new Parsed Url array
		$parsed = [
			'scheme' => $scheme,
			'domain'	=> $domain,
			'organization'  => $organization,
			'repository'	=> $repository
		];

		// Store the parsed URL in the cache
		$this->parsedurls->set($url, $parsed);

		// Return the parsed URL object
		return (object) $parsed;
	}

	/**
	 * Extract the base domain from a given URL or domain string.
	 *
	 * @param string $url The input URL or domain string.
	 *
	 * @return string The core domain (e.g., domain.com).
	 * @since  5.0.4
	 */
	public function base(string $url): string
	{
		// Parse the URL to extract host
		$parsedUrl = parse_url($url, PHP_URL_HOST);

		// If no host is found, check if the input itself is a domain without protocol
		if (!$parsedUrl)
		{
			$parsedUrl = $url;
		}

		// Remove any trailing slashes or unnecessary characters
		$parsedUrl = rtrim($parsedUrl, '/');

		return $parsedUrl;
	}

	/**
	 * Compares two URLs and checks if their domain and repository are the same.
	 *
	 * This method returns true if both the domain and repository are identical in both URLs.
	 *
	 * @param string $url1 The first URL to compare.
	 * @param string $url2 The second URL to compare.
	 *
	 * @return bool Returns true if the domain and repository are the same; false otherwise.
	 * @throws InvalidArgumentException If any of the URLs are invalid or lack required components.
	 * @since  5.0.4
	 */
	public function equal(string $url1, string $url2): bool
	{
		return $this->compare($url1, $url2, ['domain', 'repository']);
	}

	/**
	 * Compares two URLs strictly and checks if their domain, organization, and repository are the same.
	 *
	 * This method returns true if the domain, organization, and repository are identical in both URLs.
	 *
	 * @param string $url1 The first URL to compare.
	 * @param string $url2 The second URL to compare.
	 *
	 * @return bool Returns true if the domain, organization, and repository are the same; false otherwise.
	 * @throws \InvalidArgumentException If any of the URLs are invalid or lack required components.
	 * @since  5.0.4
	 */
	public function equalStrict(string $url1, string $url2): bool
	{
		return $this->compare($url1, $url2, ['domain', 'organization', 'repository']);
	}

	/**
	 * Compares two URLs and checks if their repositories are the same.
	 *
	 * This method returns true if the repository names are identical in both URLs, regardless of domain and organization.
	 *
	 * @param string $url1 The first URL to compare.
	 * @param string $url2 The second URL to compare.
	 *
	 * @return bool Returns true if the repositories are the same; false otherwise.
	 * @throws \InvalidArgumentException If any of the URLs are invalid or lack required components.
	 * @since  5.0.4
	 */
	public function equalRepo(string $url1, string $url2): bool
	{
		return $this->compare($url1, $url2, ['repository']);
	}

	/**
	 * Compares two URLs based on specified fields.
	 *
	 * This method allows you to compare specific components of two URLs, such as 'domain',
	 * 'organization', and 'repository'. It returns true if all specified fields are equal.
	 *
	 * @param string   $url1   The first URL to compare.
	 * @param string   $url2   The second URL to compare.
	 * @param string[] $fields The fields to compare ('domain', 'organization', 'repository').
	 *
	 * @return bool Returns true if all specified fields are equal; false otherwise.
	 * @throws \InvalidArgumentException If any of the URLs are invalid or lack required components,
	 *                                   or if an invalid field is specified.
	 * @since  5.0.4
	 */
	private function compare(string $url1, string $url2, array $fields): bool
	{
		$parsedUrl1 = $this->parse($url1);
		$parsedUrl2 = $this->parse($url2);

		foreach ($fields as $field)
		{
			if (!property_exists($parsedUrl1, $field) || !property_exists($parsedUrl2, $field))
			{
				throw new \InvalidArgumentException("Invalid field specified for comparison: $field");
			}

			if ($parsedUrl1->$field !== $parsedUrl2->$field)
			{
				return false;
			}
		}

		return true;
	}
}

