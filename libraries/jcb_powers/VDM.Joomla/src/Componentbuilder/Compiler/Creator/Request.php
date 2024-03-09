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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Builder\Request as RequestBuilder;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Request Creator Class
 * 
 * @since 3.2.0
 */
final class Request
{
	/**
	 * The Request Class.
	 *
	 * @var   RequestBuilder
	 * @since 3.2.0
	 */
	protected RequestBuilder $requestbuilder;

	/**
	 * Constructor.
	 *
	 * @param RequestBuilder   $requestbuilder   The Request Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(RequestBuilder $requestbuilder)
	{
		$this->requestbuilder = $requestbuilder;
	}

	/**
	 * Set the request values
	 *
	 * @param string $view
	 * @param string $field
	 * @param string $search
	 * @param string $target
	 *
	 * @since 3.2.0
	 */
	public function set(string $view, string $field, string $search, string $target): void
	{
		$key = GetHelper::between($field, $search, '"');
		if (!StringHelper::check($key))
		{
			// is not having special var
			$key = $target;
			// update field
			$field = str_replace($search . '"', 'name="' . $key . '"', (string) $field);
		}
		else
		{
			// update field
			$field = str_replace(
				$search . $key . '"', 'name="' . $key . '"', (string) $field
			);
		}

		// set the values needed for view requests to be made
		$this->requestbuilder->set("$target.$view.$key", $field);
	}
}

