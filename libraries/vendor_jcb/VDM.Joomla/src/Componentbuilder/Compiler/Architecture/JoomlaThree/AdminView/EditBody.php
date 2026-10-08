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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminView\EditBody as ExtendingEditBody;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\EditBodyInterface;


/**
 * Admin Edit View Body Class for Joomla 3
 * 
 * Joomla 3 lays the edit view out with the Bootstrap 2 grid and the
 * `bootstrap` tab helper, keeps its side areas unpadded, and closes the
 * outer form container from the body whether or not the view has sides.
 * Its access control tab renders each rule field by hand instead of asking
 * the form for one rules input.
 * 
 * @since 6.1.7
 */
final class EditBody extends ExtendingEditBody implements EditBodyInterface
{
	/**
	 * Get the grid width class prefix of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getWidthClass(): string
	{
		return 'span';
	}

	/**
	 * Get the row class of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getRowClass(): string
	{
		return 'row-fluid form-horizontal-desktop';
	}

	/**
	 * Get the outer form class of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getFormClass(): string
	{
		return 'form-horizontal';
	}

	/**
	 * Get the tab helper name of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getUiTab(): string
	{
		return 'bootstrap';
	}

	/**
	 * Get the markup that opens a side area of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getSideOpen(): string
	{
		return '';
	}

	/**
	 * Get the markup that closes a side area of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getSideClose(): string
	{
		return '';
	}

	/**
	 * Get the row the modern targets wrap the body and its sides in.
	 *
	 * Joomla 3 lays the sides out beside the body without a wrapping row.
	 *
	 * @param   bool  $hasSides  Whether the view renders a side area.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getBodyRowOpen(bool $hasSides): string
	{
		return '';
	}

	/**
	 * Get the containers the body closes for itself.
	 *
	 * @param   bool  $hasSides  Whether the view renders a side area.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getBodyTail(bool $hasSides): string
	{
		return PHP_EOL . '</div>';
	}

	/**
	 * Get the containers the side areas close on the target's behalf.
	 *
	 * @param   bool  $hasSides  Whether the view renders a side area.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getSidesTail(bool $hasSides): string
	{
		return '';
	}

	/**
	 * Get the access-control fieldset of the permissions tab.
	 *
	 * @param   string  $tabLangName  The language key of the tab.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getPermissionsFieldset(string $tabLangName): string
	{
		$tabs = PHP_EOL . Indent::_(4) . '<fieldset class="adminform">';
		$tabs .= PHP_EOL . Indent::_(5) . '<div class="adminformlist">';
		$tabs .= PHP_EOL . Indent::_(5)
			. "<?php foreach (\$this->form->getFieldset('accesscontrol') as \$field): ?>";
		$tabs .= PHP_EOL . Indent::_(6) . "<div>";
		$tabs .= PHP_EOL . Indent::_(7)
			. "<?php echo \$field->label; echo \$field->input;?>";
		$tabs .= PHP_EOL . Indent::_(6) . "</div>";
		$tabs .= PHP_EOL . Indent::_(6) . '<div class="clearfix"></div>';
		$tabs .= PHP_EOL . Indent::_(5) . "<?php endforeach; ?>";
		$tabs .= PHP_EOL . Indent::_(5) . "</div>";
		$tabs .= PHP_EOL . Indent::_(4) . "</fieldset>";

		return $tabs;
	}
}

