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

namespace VDM\Joomla\Componentbuilder\Fieldtype;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\GrepInterface;
use VDM\Joomla\Componentbuilder\Remote\Grep as ExtendingGrep;


/**
 * Global Resource Empowerment Platform
 * 
 *    The Grep feature will try to find your power in the repositories
 *    linked to this [area], and if it can't be found there will try the global core
 *    Super Powers of JCB. All searches are performed according the [algorithm:cascading]
 *    See documentation for more details: https://git.vdm.dev/joomla/super-powers/wiki
 * 
 * @since 5.0.3
 */
final class Grep extends ExtendingGrep implements GrepInterface
{
	/**
	 * The Grep target [network]
	 *
	 * @var    string
	 * @since  5.0.4
	 **/
	protected ?string $target = 'joomla-fieldtypes';

	/**
	 * Set repository messages and errors based on given conditions.
	 *
	 * @param string       $message       The message to set (if error)
	 * @param string       $path          Path value
	 * @param string       $repository    Repository name
	 * @param string       $organisation  Organisation name
	 * @param string|null  $base          Base URL
	 *
	 * @return void
	 * @since  5.0.3
	 */
	protected function setRemoteIndexMessage(string $message, string $path, string $repository, string $organisation, ?string $base): void
	{
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_PJOOMLA_FIELD_TYPEB_REPOSITORY_AT_BSSB_GAVE_THE_FOLLOWING_ERRORBR_SP', $this->contents->api(), $path, $message),
			'Error'
		);
	}
}

