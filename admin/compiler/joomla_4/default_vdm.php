<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this JCB template file (EVER)
defined('_JCB_TEMPLATE') or die;
?>
###BOM###

use Joomla\CMS\Language\Text;

// No direct access to this file
defined('_JEXEC') or die;

?>
<img alt="<?php echo Text::_('COM_###COMPONENT###'); ?>" width="100%"  src="components/com_###component###/assets/images/vdm-component.###COMP_IMAGE_TYPE###">
<ul class="list-striped">
	<li><b><?php echo Text::_('COM_###COMPONENT###_VERSION'); ?>:</b> <?php echo $this->manifest->version; ?>&nbsp;&nbsp;<span class="update-notice" id="component-update-notice"></span></li>
	<li><b><?php echo Text::_('COM_###COMPONENT###_DATE'); ?>:</b> <?php echo $this->manifest->creationDate; ?></li>
	<li><b><?php echo Text::_('COM_###COMPONENT###_AUTHOR'); ?>:</b> <a href="mailto:<?php echo $this->manifest->authorEmail; ?>"><?php echo $this->manifest->author; ?></a></li>
	<li><b><?php echo Text::_('COM_###COMPONENT###_WEBSITE'); ?>:</b> <a href="<?php echo $this->manifest->authorUrl; ?>" target="_blank"><?php echo $this->manifest->authorUrl; ?></a></li>
	<li><b><?php echo Text::_('COM_###COMPONENT###_LICENSE'); ?>:</b> <?php echo $this->manifest->license; ?></li>
	<li><b><?php echo $this->manifest->copyright; ?></b></li>
</ul>
<div class="clearfix"></div>
<?php if(Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($this->contributors)): ?>
	<?php if(count($this->contributors) > 1): ?>
		<h3><?php echo Text::_('COM_###COMPONENT###_CONTRIBUTORS'); ?></h3>
	<?php else: ?>
		<h3><?php echo Text::_('COM_###COMPONENT###_CONTRIBUTOR'); ?></h3>
	<?php endif; ?>
	<ul class="list-striped">
		<?php foreach($this->contributors as $contributor): ?>
		<li><b><?php echo $contributor['title']; ?>:</b> <?php echo $contributor['name']; ?></li>
		<?php endforeach; ?>
	</ul>
	<div class="clearfix"></div>
<?php endif; ?>