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



?>
<h2><?php echo Text::_('COM_COMPONENTBUILDER_TOTAL_TIME_SAVED'); ?></h2>
<ul>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_TOTAL_FOLDERS_CREATED'); ?>: <b><?php echo '#'.'##FOLDER_COUNT##'.'#'; ?></b></li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_TOTAL_FILES_CREATED'); ?>: <b><?php echo '#'.'##FILE_COUNT##'.'#'; ?></b></li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_TOTAL_FIELDS_CREATED'); ?>: <b><?php echo '#'.'##FIELD_COUNT##'.'#'; ?></b></li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_TOTAL_LINES_WRITTEN'); ?>: <b><?php echo '#'.'##LINE_COUNT##'.'#'; ?></b></li>
	<li><?php echo Text::_('COM_COMPONENTBUILDER_AFOUR_BOOK_OF'); ?>: <b><?php echo '#'.'##PAGE_COUNT##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_PAGES'); ?></b></li>
</ul>
<p>
	<b><?php echo '#'.'##totalHours##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_HOURS'); ?></b> or
	<b><?php echo '#'.'##totalDays##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_EIGHT_HOUR_DAYS'); ?></b>
	<em>(<?php echo Text::_('COM_COMPONENTBUILDER_ACTUAL_TIME_YOU_SAVED'); ?>)</em>
	<br>
	<small>(<?php echo Text::_('COM_COMPONENTBUILDER_IF_CREATING_A_FOLDER_AND_FILE_TOOK_BFIVE_SECONDSB_AND_WRITING_ONE_LINE_OF_CODE_TOOK_BTEN_SECONDSB_NEVER_MAKING_ONE_MISTAKE_OR_TAKING_ANY_COFFEE_BREAK'); ?>)</small>
	<br>
	<b><?php echo '#'.'##actualHoursSpent##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_HOURS'); ?></b> or
	<b><?php echo '#'.'##actualDaysSpent##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_EIGHT_HOUR_DAYS'); ?></b>
	<em>(<?php echo Text::_('COM_COMPONENTBUILDER_THE_ACTUAL_TIME_YOU_SPENT'); ?>)</em>
	<br>
	<small>(<?php echo Text::_('COM_COMPONENTBUILDER_WITH_THE_FOLLOWING_BREAK_DOWN'); ?>:
	<b><?php echo Text::_('COM_COMPONENTBUILDER_DEBUGGING'); ?> @<?php echo '#'.'##debuggingHours##'.'#'; ?><?php echo Text::_('COM_COMPONENTBUILDER_HOURS'); ?></b> = <?php echo Text::_('COM_COMPONENTBUILDER_CODINGTIME'); ?> / 4;
	<b><?php echo Text::_('COM_COMPONENTBUILDER_PLANNING'); ?> @<?php echo '#'.'##planningHours##'.'#'; ?><?php echo Text::_('COM_COMPONENTBUILDER_HOURS'); ?></b> = <?php echo Text::_('COM_COMPONENTBUILDER_CODINGTIME'); ?> / 7;
	<b><?php echo Text::_('COM_COMPONENTBUILDER_MAPPING'); ?> @<?php echo '#'.'##mappingHours##'.'#'; ?><?php echo Text::_('COM_COMPONENTBUILDER_HOURS'); ?></b> = <?php echo Text::_('COM_COMPONENTBUILDER_CODINGTIME'); ?> / 10;
	<b><?php echo Text::_('COM_COMPONENTBUILDER_OFFICE'); ?> @<?php echo '#'.'##officeHours##'.'#'; ?><?php echo Text::_('COM_COMPONENTBUILDER_HOURS'); ?></b> = <?php echo Text::_('COM_COMPONENTBUILDER_CODINGTIME'); ?> / 6;)</small>
</p>
<p>
	<b><?php echo '#'.'##actualTotalHours##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_HOURS'); ?></b> or
	<b><?php echo '#'.'##actualTotalDays##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_EIGHT_HOUR_DAYS'); ?></b>
	<em>(<?php echo Text::_('COM_COMPONENTBUILDER_A_TOTAL_OF_THE_REALISTIC_TIME_FRAME_FOR_THIS_PROJECT'); ?>)</em>
	<br>
	<small>(<?php echo Text::_('COM_COMPONENTBUILDER_IF_CREATING_A_FOLDER_AND_FILE_TOOK_BFIVE_SECONDSB_AND_WRITING_ONE_LINE_OF_CODE_TOOK_BTEN_SECONDSB_WITH_THE_NORMAL_EVERYDAY_REALITIES_AT_THE_OFFICE_THAT_INCLUDES_THE_COMPONENT_PLANNING_MAPPING_DEBUGGING'); ?>.)
	</small>
</p>
<p>
	<?php echo Text::_('COM_COMPONENTBUILDER_PROJECT_DURATION'); ?>: <b><?php echo '#'.'##projectWeekTime##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_WEEKS'); ?></b> or
	<b><?php echo '#'.'##projectMonthTime##'.'#'; ?> <?php echo Text::_('COM_COMPONENTBUILDER_MONTHS'); ?></b>
</p>
