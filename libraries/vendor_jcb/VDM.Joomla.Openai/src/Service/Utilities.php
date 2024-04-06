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

namespace VDM\Joomla\Openai\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Openai\Utilities\Uri;
use VDM\Joomla\Openai\Utilities\Response;
use VDM\Joomla\Openai\Utilities\Http;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * The Openai Utilities Service
 * 
 * @since 3.2.0
 */
class Utilities implements ServiceProviderInterface
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
		$container->alias(Uri::class, 'Openai.Utilities.Uri')
			->share('Openai.Utilities.Uri', [$this, 'getUri'], true);

		$container->alias(Response::class, 'Openai.Utilities.Response')
			->share('Openai.Utilities.Response', [$this, 'getResponse'], true);

		$container->alias(Http::class, 'Openai.Utilities.Http')
			->share('Openai.Utilities.Http', [$this, 'getHttp'], true);
	}

	/**
	 * Get the Uri class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Uri
	 * @since 3.2.0
	 */
	public function getUri(Container $container): Uri
	{
		return new Uri();
	}

	/**
	 * Get the Response class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Response
	 * @since 3.2.0
	 */
	public function getResponse(Container $container): Response
	{
		return new Response();
	}

	/**
	 * Get the Http class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Http
	 * @since 3.2.0
	 */
	public function getHttp(Container $container): Http
	{
		$openai_token = null;
		$openai_org_token =  null;
		if (Helper::getParams()->get('enable_open_ai') == 1)
		{
			$openai_token = Helper::getParams()->get('openai_token');
			if (Helper::getParams()->get('enable_open_ai_org') == 1)
			{
				$openai_org_token = Helper::getParams()->get('openai_org_token');
			}

			if ($openai_token === 'secret')
			{
				$openai_token = null;
			}

			if ($openai_org_token === 'secret')
			{
				$openai_org_token = null;
			}
		}

		return new Http(
			$openai_token,
			$openai_org_token
		);
	}
}

