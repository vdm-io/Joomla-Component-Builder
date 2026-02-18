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

/**
 * JCB Compiler - Statistics & Time Savings (CLI)
 *
 * SymfonyStyle-compatible CLI layout.
 * Plain text only. No Markdown. No HTML.
 *
 * @since 5.1.4
 */
$lines = [];

/**
 * Section header
 */
$lines[] = Text::_('COM_COMPONENTBUILDER_TOTAL_TIME_SAVED');
$lines[] = str_repeat('-', 60);

/**
 * Totals
 */
$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_TOTAL_FOLDERS_CREATED'),
	'#' . '##FOLDER_COUNT##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_TOTAL_FILES_CREATED'),
	'#' . '##FILE_COUNT##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_TOTAL_FIELDS_CREATED'),
	'#' . '##FIELD_COUNT##' . '#'
);

$lines[] = sprintf(
	'%s: %s',
	Text::_('COM_COMPONENTBUILDER_TOTAL_LINES_WRITTEN'),
	'#' . '##LINE_COUNT##' . '#'
);

$lines[] = Text::sprintf(
	'%s: %s %s',
	Text::_('COM_COMPONENTBUILDER_AFOUR_BOOK_OF'),
	'#' . '##PAGE_COUNT##' . '#',
	Text::_('COM_COMPONENTBUILDER_PAGES')
);

/**
 * Estimated time saved
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_ESTIMATED_TIME_SAVED_EIGHTHOUR_DAYS');
$lines[] = sprintf(
	'%s %s %s %s',
	'#' . '##totalHours##' . '#',
	Text::_('COM_COMPONENTBUILDER_HOURS_OR'),
	'#' . '##totalDays##' . '#',
	Text::_('COM_COMPONENTBUILDER_DAYS')
);

/**
 * Actual time spent
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_ACTUAL_TIME_SPENT_EIGHTHOUR_DAYS');
$lines[] = sprintf(
	'%s %s %s %s',
	'#' . '##actualHoursSpent##' . '#',
	Text::_('COM_COMPONENTBUILDER_HOURS_OR'),
	'#' . '##actualDaysSpent##' . '#',
	Text::_('COM_COMPONENTBUILDER_DAYS')
);

/**
 * Breakdown
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_BREAKDOWN');

$lines[] = sprintf(
	'  %s: %s %s (%s / 4)',
	Text::_('COM_COMPONENTBUILDER_DEBUGGING'),
	'#' . '##debuggingHours##' . '#',
	Text::_('COM_COMPONENTBUILDER_HOURS'),
	Text::_('COM_COMPONENTBUILDER_CODING_TIME')
);

$lines[] = sprintf(
	'  %s: %s %s (%s / 7)',
	Text::_('COM_COMPONENTBUILDER_PLANNING'),
	'#' . '##planningHours##' . '#',
	Text::_('COM_COMPONENTBUILDER_HOURS'),
	Text::_('COM_COMPONENTBUILDER_CODING_TIME')
);

$lines[] = sprintf(
	'  %s: %s %s (%s / 10)',
	Text::_('COM_COMPONENTBUILDER_MAPPING'),
	'#' . '##mappingHours##' . '#',
	Text::_('COM_COMPONENTBUILDER_HOURS'),
	Text::_('COM_COMPONENTBUILDER_CODING_TIME')
);

$lines[] = sprintf(
	'  %s: %s %s (%s / 6)',
	Text::_('COM_COMPONENTBUILDER_OFFICE'),
	'#' . '##officeHours##' . '#',
	Text::_('COM_COMPONENTBUILDER_HOURS'),
	Text::_('COM_COMPONENTBUILDER_CODING_TIME')
);

/**
 * Realistic total
 */
$lines[] = '';
$lines[] = Text::_('COM_COMPONENTBUILDER_TOTAL_REALISTIC_PROJECT_TIME_FRAME');
$lines[] = sprintf(
	'%s %s %s %s',
	'#' . '##actualTotalHours##' . '#',
	Text::_('COM_COMPONENTBUILDER_HOURS_OR'),
	'#' . '##actualTotalDays##' . '#',
	Text::_('COM_COMPONENTBUILDER_DAYS')
);

/**
 * Project duration
 */
$lines[] = '';
$lines[] = sprintf(
	'%s: %s %s %s %s',
	Text::_('COM_COMPONENTBUILDER_PROJECT_DURATION'),
	'#' . '##projectWeekTime##' . '#',
	Text::_('COM_COMPONENTBUILDER_WEEKS_OR'),
	'#' . '##projectMonthTime##' . '#',
	Text::_('COM_COMPONENTBUILDER_MONTHS')
);

?>
<?php echo implode(PHP_EOL, $lines); ?>
