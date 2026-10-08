<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\LinkedView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\LinkedView\Builder as ExtendingBuilder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView\BuilderInterface;


/**
 * Linked View Builder Class for Joomla 4
 * 
 * Seeding a new record from the parent's guid arrived in Joomla 5, so
 * Joomla 4 always passes a referring id instead, even when the two views
 * are tied together on guid.
 * 
 * @since 6.1.7
 */
final class Builder extends ExtendingBuilder implements BuilderInterface
{
	/**
	 * Get the referral block the generated header script carries.
	 *
	 * @param   string|null  $parent_key      The key of the parent view.
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getReferralBlock(?string $parent_key, string $nameSingleCode): string
	{
		return $this->getIdReferralBlock($nameSingleCode);
	}
}

