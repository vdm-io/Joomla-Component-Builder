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


use VDM\Joomla\Abstraction\Registry;


/**
 * The Network Parsed Urls
 * 
 * @since 5.0.4
 */
final class ParsedUrls extends Registry
{
	/**
	 * Path separator
	 *
	 * @var    string|null
	 * @since 3.2.0
	 */
	protected ?string $separator = '|';
}

