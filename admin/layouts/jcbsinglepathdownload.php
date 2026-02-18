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

?>
<?php if (!empty($url) && !empty($path)): ?>
<h2><?php echo Text::_('COM_COMPONENTBUILDER_PATH_TO_ZIP_FILE'); ?></h2>
<p>
	<b><?php echo Text::_('COM_COMPONENTBUILDER_PATH'); ?>:</b> <code><?php echo $path; ?></code>
	<br>
	<b><?php echo Text::_('URL'); ?>:</b> <code><?php echo $url; ?></code>
	<br><br>
	<small><?php echo Text::_('COM_COMPONENTBUILDER_HEY_YOU_CAN_ALSO_DOWNLOAD_THE_ZIP_FILE_RIGHT_NOW'); ?></small>
</p>
<div class="btn-toolbar" role="toolbar">
	<div class="btn-group" role="group">
		<a class="btn btn-success btn-small btn-sm" href="<?php echo $url; ?>">
			<span class="icon-download icon-white"></span>
			<?php echo Text::_('COM_COMPONENTBUILDER_DOWNLOAD'); ?>
		</a>
	</div>
</div>
<p>
	<small><b><?php echo Text::_('COM_COMPONENTBUILDER_REMEMBERB_THESE_ZIP_FILES_ARE_IN_YOUR_TMP_FOLDER_AND_THEREFORE_PUBLICLY_ACCESSIBLE_UNTIL_YOU_CLICK_CLEAR_TMP'); ?>!</small>
</p>
<?php else: ?>
<div class="alert alert-danger" role="alert">
	<h4><?php echo Text::_('COM_COMPONENTBUILDER_THERE_WAS_AN_ERROR'); ?>!</h4>
	<p><?php echo Text::_('COM_COMPONENTBUILDER_THE_EXTENSION_WAS_NOT_COMPILED'); ?></p>
</div>
<?php endif; ?>
