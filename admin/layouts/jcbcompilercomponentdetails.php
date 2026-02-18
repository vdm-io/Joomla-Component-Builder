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
use Joomla\CMS\Uri\Uri;

// No direct access to this file
defined('JPATH_BASE') or die;

// Prepare image HTML if provided
$imageSrc = !empty($displayData->image) ? htmlspecialchars($displayData->image, ENT_QUOTES) : null;
$imageHtml = $imageSrc
	? '<img alt="' . Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_IMAGE') . '" src="' . Uri::root() . $imageSrc . '" class="img-fluid" style="max-width: 250px;">'
	: '';

// Prepare description
$description = htmlspecialchars($displayData->description ?? $displayData->short_description ?? '', ENT_QUOTES);

// Prepare badges
$placeholderStatus = $displayData->add_placeholders
	? '<span class="badge bg-success">' . Text::_('COM_COMPONENTBUILDER_YES') . '</span>'
	: '<span class="badge bg-danger">' . Text::_('COM_COMPONENTBUILDER_NO') . '</span>';
$debugStatus = $displayData->debug_linenr
	? '<span class="badge bg-success">' . Text::_('COM_COMPONENTBUILDER_YES') . '</span>'
	: '<span class="badge bg-danger">' . Text::_('COM_COMPONENTBUILDER_NO') . '</span>';

?>
<div class="card mb-4"><div class="card-body">
	<h2 class="card-title">
		<?php echo htmlspecialchars($displayData->name, ENT_QUOTES); ?> (v<?php echo htmlspecialchars($displayData->component_version, ENT_QUOTES); ?>)
	</h2>

	<?php if (!empty($imageHtml)): ?>
		<div class="row align-items-center">
			<div class="col-md-7">
				<?php if (!empty($description)): ?>
					<p><?php echo $description; ?></p>
				<?php endif; ?>
				<?php echo LayoutHelper::render('jcbcompilercompanydetails', $displayData); ?>
			</div>
			<div class="col-md-5"><?php echo $imageHtml; ?></div>
		</div>
	<?php else: ?>
		<div class="row align-items-center">
			<?php if (!empty($description)): ?>
				<p><?php echo $description; ?></p>
			<?php endif; ?>
			<?php echo LayoutHelper::render('jcbcompilercompanydetails', $displayData); ?>
		</div>
	<?php endif; ?>

	<h3 class="mt-4"><?php echo Text::_('COM_COMPONENTBUILDER_COMPONENT_SETTINGS'); ?></h3>
	<p>
		<?php echo Text::_('COM_COMPONENTBUILDER_ADD_CUSTOM_CODE_PLACEHOLDERS'); ?>: <?php echo $placeholderStatus; ?><br>
		<?php echo Text::_('COM_COMPONENTBUILDER_DEBUG_LINE_NUMBERS'); ?>: <?php echo $debugStatus; ?>
	</p>

	<h3 class="mt-4"><?php echo Text::_('COM_COMPONENTBUILDER_LICENSE'); ?></h3>
	<p><?php echo nl2br(htmlspecialchars($displayData->license ?? Text::_('COM_COMPONENTBUILDER_NONE_SET'), ENT_QUOTES)); ?></p>

	<h3 class="mt-4"><?php echo Text::_('COM_COMPONENTBUILDER_COPYRIGHT'); ?></h3>
	<p><?php echo nl2br(htmlspecialchars($displayData->copyright ?? Text::_('COM_COMPONENTBUILDER_NONE_SET'), ENT_QUOTES)); ?></p>

	<a href="index.php?option=com_componentbuilder&ref=compiler&view=joomla_components&task=joomla_component.edit&id=<?php echo (int) $displayData->id; ?>"
		class="btn btn-outline-action btn-lg mt-3" style="width: 100%;">
		<span class="icon-edit"></span> <?php echo Text::_('COM_COMPONENTBUILDER_EDIT'); ?> <?php echo htmlspecialchars($displayData->system_name, ENT_QUOTES); ?>
	</a>

</div></div>
