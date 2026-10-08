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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\LinkedView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\LinkedView\Builder as ExtendingBuilder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView\BuilderInterface;


/**
 * Linked View Builder Class for Joomla 3
 * 
 * Joomla 3 takes its input object from the global application, has no guid
 * seeding, and reaches a new record through the edit task rather than add.
 * 
 * @since 6.1.7
 */
final class Builder extends ExtendingBuilder implements BuilderInterface
{
	/**
	 * Get the statement that puts the input object in scope.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getInputAcquisition(): string
	{
		return PHP_EOL
			. '$jinput = Joomla__'.'_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->input;';
	}

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

	/**
	 * Get the task a new record link points at.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getAddKey(): string
	{
		return 'edit';
	}
}

