<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('JPATH_BASE') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;



?>
<?php if ($displayData->state->get('filter.published') == -2 && ($displayData->canState && $displayData->canDelete)) : ?>
	<script>
		// change the class of the delete button
		jQuery("#toolbar-delete button").toggleClass("btn-danger");
		// function to empty the trash
		function emptyTrash() {
			if (document.adminForm.boxchecked.value == 0) {
				// select all the items visable
				document.adminForm.elements['checkall-toggle'].checked=1;
				Joomla.checkAll(document.adminForm.elements['checkall-toggle']);
				// check to confirm the deletion
				if(confirm('<?php echo Text::_("COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WANT_TO_DELETE_CONFIRMING_WILL_PERMANENTLY_DELETE_THE_SELECTED_ITEMS") ?>')) {
					Joomla.submitbutton('<?php echo $displayData->getName(); ?>.delete');
				} else {
					document.adminForm.elements['checkall-toggle'].checked=0;
					Joomla.checkAll(document.adminForm.elements['checkall-toggle']);
				}
			} else {
				// confirm deletion of those selected
				if (confirm('<?php echo Text::_("COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WANT_TO_DELETE_CONFIRMING_WILL_PERMANENTLY_DELETE_THE_SELECTED_ITEMS") ?>')) {
					Joomla.submitbutton('<?php echo $displayData->getName(); ?>.delete');
				};
			}
			return false;
		}
		// function to exit the tash state
		function exitTrash() {
			document.adminForm.filter_published.selectedIndex = 0;
			document.adminForm.submit();
			return false;
		}
	</script>
	<div class="alert alert-error">
		<?php if (empty($displayData->items)): ?>
			<h4 class="alert-heading">
				<span class="icon-trash"></span>
				<?php echo Text::_("COM_COMPONENTBUILDER_TRASH_AREA") ?>
			</h4>
			<p><?php echo Text::_("COM_COMPONENTBUILDER_YOU_ARE_CURRENTLY_VIEWING_THE_TRASH_AREA_AND_YOU_DONT_HAVE_ANY_ITEMS_IN_TRASH_AT_THE_MOMENT") ?></p>
		<?php else: ?>
			<h4 class="alert-heading">
				<span class="icon-trash"></span>
				<?php echo Text::_("COM_COMPONENTBUILDER_TRASHED_ITEMS") ?>
			</h4>
			<p><?php echo Text::_("COM_COMPONENTBUILDER_YOU_ARE_CURRENTLY_VIEWING_THE_TRASHED_ITEMS") ?></p>
			<button onclick="emptyTrash();" class="btn btn-small btn-danger">
				<span class="icon-delete" aria-hidden="true"></span>
				<?php echo Text::_("COM_COMPONENTBUILDER_EMPTY_TRASH") ?>
			</button>
		<?php endif; ?>
		<button onclick="exitTrash();" class="btn btn-small">
			<span class="icon-back" aria-hidden="true"></span>
			<?php echo Text::_("COM_COMPONENTBUILDER_EXIT_TRASH") ?>
		</button>
	</div>
<?php endif; ?>
