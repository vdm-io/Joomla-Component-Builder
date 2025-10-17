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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;

// No direct access to this file
defined('_JEXEC') or die;

?>
<div class="container my-5">
	<div class="p-5 bg-light border rounded-4 shadow-sm text-center position-relative overflow-hidden">
		<div class="position-absolute top-0 start-0 w-100 h-100 bg-warning bg-opacity-10"></div>
		<div class="position-relative">
			<div class="mb-3">
				<i class="bi bi-box-seam display-4 text-warning"></i>
			</div>
			<h3 class="fw-semibold mb-2"><?php echo Text::_('COM_COMPONENTBUILDER_NO_COMPONENTS_TO_COMPILE'); ?></h3>
			<p class="lead text-muted mb-4">
				<?php echo Text::_('COM_COMPONENTBUILDER_THERE_ARE_CURRENTLY_NO_COMPONENTS_AVAILABLE_FOR_COMPILATION'); ?><br>
				<?php echo Text::_('COM_COMPONENTBUILDER_PLEASE_CREATE_ONE_OR_MORE_COMPONENTS_BEFORE_ATTEMPTING_TO_COMPILE'); ?>
			</p>
			<a href="index.php?option=com_componentbuilder&view=joomla_components" class="btn btn-primary btn-lg px-4">
				<i class="bi bi-plus-circle me-2"></i>
				<?php echo Text::_('COM_COMPONENTBUILDER_CREATE_A_COMPONENT'); ?>
			</a>
		</div>
	</div>
	<div class="mt-4">
		<?php echo LayoutHelper::render('jcbnoticeboard', ['dankie' => $this->dankie]); ?>
	</div>
</div>
