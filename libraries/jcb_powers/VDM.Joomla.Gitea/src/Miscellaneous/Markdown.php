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

namespace VDM\Joomla\Gitea\Miscellaneous;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Miscellaneous Markdown
 * 
 * @since 3.2.0
 */
class Markdown extends Api
{
	/**
	 * Render a markdown document as HTML.
	 *
	 * @param   string  $markdownText  The markdown text to render.
	 * @param   bool    $isWikiPage    Is it a wiki page?
	 * @param   string  $context       Context to render.
	 * @param   string  $mode          Mode to render.
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function render(
		string $markdownText,
		bool $isWikiPage = false,
		string $context = 'string',
		string $mode = 'string'
	): ?string
	{
		// Build the request path.
		$path = "/markdown";

		// Set the markdown data.
		$data = new \stdClass();
		$data->Text = $markdownText;
		$data->Wiki = $isWikiPage;
		$data->Context = $context;
		$data->Mode = $mode;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data),
				['accept' => 'text/html']
			)
		);
	}

	/**
	 * Render raw markdown as HTML.
	 *
	 * @param   string  $rawMarkdown  The raw markdown text to render.
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function raw(string $rawMarkdown): ?string
	{
		// Build the request path.
		$path = "/markdown/raw";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				$rawMarkdown,
				['Content-Type' => 'text/plain', 'accept' => 'text/html']
			)
		);
	}

}

