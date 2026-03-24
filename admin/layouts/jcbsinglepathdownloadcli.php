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
use VDM\Joomla\Componentbuilder\Compiler\Factory as CompilerFactory;

// No direct access to this file
defined('JPATH_BASE') or die;


$path = CompilerFactory::_('FilePaths')->get('component', '');
$url  = $displayData['url'] ?? null;

/**
 * JCB Compiler - Package Path & URL (Single) (CLI)
 *
 * SymfonyStyle-compatible CLI layout.
 * Plain text only. No Markdown. No HTML.
 *
 * @since 5.1.4
 */
$lines = [];

if (!empty($path))
{
	/**
	 * Section header
	 */
	$lines[] = Text::_('COM_COMPONENTBUILDER_PACKAGE_PATH');
	$lines[] = str_repeat('-', 60);

	/**
	 * Path & URL
	 */
	$lines[] = sprintf(
		'%s:',
		Text::_('COM_COMPONENTBUILDER_PACKAGE')
	);
	$lines[] = sprintf(
		'  %s: %s',
		Text::_('COM_COMPONENTBUILDER_PATH'),
		$path
	);

	/**
	 * Note
	 */
	$lines[] = '';
	$lines[] = Text::_('COM_COMPONENTBUILDER_NOTE_THIS_ZIP_FILE_IS_STORED_IN_YOUR_TMP_FOLDER_AND_MAY_BE_PUBLICLY_ACCESSIBLE_UNTIL_YOU_CLEAR_TMP');
}
else
{
	/**
	 * Error case
	 */
	$lines[] = Text::_('COM_COMPONENTBUILDER_ERROR_THE_EXTENSION_WAS_NOT_COMPILED');
}

?>
<?php echo implode(PHP_EOL, $lines); ?>
