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

namespace VDM\Joomla\Componentbuilder\Utilities;


use Joomla\CMS\Http\Http as JoomlaHttp;
use Joomla\Registry\Registry;



/**
 * The Joomla Component Builder Http
 * 
 * @since 5.0.4
 */
final class Http extends JoomlaHttp
{
	/**
	 * Constructor.
	 *
	 * @since   5.0.4
	 * @throws  \InvalidArgumentException
	 **/
	public function __construct()
	{
		// setup config
		$config = [
			'userAgent' => 'JCB/5.0',
			'headers' => [
				'Content-Type' => 'application/json'
			]
		];

		$options = new Registry($config);

		// run parent constructor
		parent::__construct($options);
	}
}

