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

namespace VDM\Joomla\Interfaces\Git\Repository;


use VDM\Joomla\Interfaces\Git\ApiInterface;


/**
 * The Git Repository Wiki Interface
 * 
 * @since 5.1.1
 */
interface WikiInterface extends ApiInterface
{
	/**
	 * Create a wiki page.
	 *
	 * @param   string       $owner           The owner name.
	 * @param   string       $repo            The repository name.
	 * @param   string       $title           The title of the wiki page.
	 * @param   string       $contentBase64   The base64 encoded content of the wiki page.
	 * @param   string|null  $message         Optional commit message summarizing the change.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $title,
		string $contentBase64,
		?string $message = null
	): ?object;

	/**
	 * Get a wiki page.
	 *
	 * @param   string   $owner     The owner name.
	 * @param   string   $repo      The repository name.
	 * @param   string   $pageName  The name of the wiki page.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		string $pageName
	): ?object;

	/**
	 * Get all wiki pages.
	 *
	 * @param   string   $owner   The owner name.
	 * @param   string   $repo    The repository name.
	 * @param   int      $page    Page number of results to return (1-based).
	 * @param   int      $limit   Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function pages(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?array;

	/**
	 * Delete a wiki page.
	 *
	 * @param    string   $owner      The owner name.
	 * @param    string   $repo       The repository name.
	 * @param    string   $pageName   The name of the wiki page.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		string $pageName
	): string;

	/**
	 * Edit a wiki page.
	 *
	 * @param   string   $owner     The owner name.
	 * @param   string   $repo      The repository name.
	 * @param   string   $pageName  The name of the wiki page.
	 * @param   string   $title     The new title of the wiki page.
	 * @param   string   $content   The new content of the wiki page.
	 * @param   string   $message   The optional commit message summarizing the change.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $owner,
		string $repo,
		string $pageName,
		string $title,
		string $content,
		string $message = null
	): ?object;

	/**
	 * Get revisions of a wiki page.
	 *
	 * @param    string   $owner      The owner name.
	 * @param    string   $repo       The repository name.
	 * @param    string   $pageName   The name of the wiki page.
	 * @param    int      $page       The page number of results to return (1-based).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function revisions(
		string $owner,
		string $repo,
		string $pageName,
		int $page = 1
	): ?object;
}

