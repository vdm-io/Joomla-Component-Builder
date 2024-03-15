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



use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
defined('JPATH_BASE') or die;

use Joomla\CMS\Form\Form;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   Form    $form       The form instance for render the section
 * @var   string  $basegroup  The base group name
 * @var   string  $group      Current group name
 * @var   array   $buttons    Array of the buttons that will be rendered
 */

?>
<div class="subform-repeatable-group" data-base-name="<?php echo $basegroup; ?>" data-group="<?php echo $group; ?>">
	<?php if (!empty($buttons)) : ?>
	<div class="btn-toolbar text-end">
		<div class="btn-group">
			<?php if (!empty($buttons['add'])) :
				?><button type="button" class="group-add btn btn-sm btn-success" aria-label="<?php echo Text::_('COM_COMPONENTBUILDER_ADD'); ?>"><span class="icon-plus icon-white" aria-hidden="true"></span> </button><?php
			endif; ?>
			<?php if (!empty($buttons['remove'])) :
				?><button type="button" class="group-remove btn btn-sm btn-danger" aria-label="<?php echo Text::_('COM_COMPONENTBUILDER_REMOVE'); ?>"><span class="icon-minus icon-white" aria-hidden="true"></span> </button><?php
			endif; ?>
			<?php if (!empty($buttons['move'])) :
				?><button type="button" class="group-move btn btn-sm btn-primary" aria-label="<?php echo Text::_('COM_COMPONENTBUILDER_MOVE'); ?>"><span class="icon-arrows-alt icon-white" aria-hidden="true"></span> </button><?php
			endif; ?>
		</div>
	</div>
	<?php endif; ?>

	<div data-uk-grid-margin="" class="uk-grid">
		<?php foreach ($form->getGroup('') as $field) : ?>
			<div class="uk-width-medium-1-4 uk-width-large-1-5">
				<div class="uk-panel">
					<?php echo $field->renderField(); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
