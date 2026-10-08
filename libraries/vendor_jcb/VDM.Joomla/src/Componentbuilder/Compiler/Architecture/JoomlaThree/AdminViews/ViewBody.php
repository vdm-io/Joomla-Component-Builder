<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ViewBody as ExtendingViewBody;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ViewBodyInterface;


/**
 * Admin List View Body Class for Joomla 3.
 * 
 * @since  6.1.7
 */
final class ViewBody extends ExtendingViewBody implements ViewBodyInterface
{
	/**
	 * Get the generated main container opening lines.
	 *
	 * Joomla 3 renders the filter sidebar beside the main container.
	 *
	 * @return  array<int, string>  The generated container lines.
	 *
	 * @since   6.1.7
	 */
	protected function getContainerOpen(): array
	{
		return [
			"<?php if(!empty( \$this->sidebar)): ?>",
			Indent::_(1) . "<div id=\"j-sidebar-container\" class=\"span2\">",
			Indent::_(2) . "<?php echo \$this->sidebar; ?>",
			Indent::_(1) . "</div>",
			Indent::_(1) . "<div id=\"j-main-container\" class=\"span10\">",
			"<?php else : ?>",
			Indent::_(1) . "<div id=\"j-main-container\">",
			"<?php endif; ?>",
		];
	}

	/**
	 * Get the generated batch processing modal lines.
	 *
	 * @param   string  $COMPONENT  The upper case component code name.
	 * @param   string  $VIEWS      The upper case list code name.
	 *
	 * @return  array<int, string>  The generated batch modal lines.
	 *
	 * @since   6.1.7
	 */
	protected function getBatchModal(string $COMPONENT, string $VIEWS): array
	{
		return [
			Indent::_(1) . "<?php //" . Line::_(
					__LINE__, __CLASS__
				) . " Load the batch processing form. ?>",
			Indent::_(1) . "<?php if (\$this->canCreate && \$this->canEdit) : ?>",
			Indent::_(2) . "<?php echo Html::_(",
			Indent::_(3) . "'bootstrap.renderModal',",
			Indent::_(3) . "'collapseModal',",
			Indent::_(3) . "array(",
			Indent::_(4) . "'title' => Joomla__" . "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('COM_" . $COMPONENT . "_"
				. $VIEWS
				. "_BATCH_OPTIONS'),",
			Indent::_(4) . "'footer' => \$this->loadTemplate('batch_footer')",
			Indent::_(3) . "),",
			Indent::_(3) . "\$this->loadTemplate('batch_body')",
			Indent::_(2) . "); ?>",
			Indent::_(1) . "<?php endif; ?>",
		];
	}
}

