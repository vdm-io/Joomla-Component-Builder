<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.3.6
	@build			8th March, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		default_vdm.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$manifest = ComponentbuilderHelper::manifest();
JHtml::_('bootstrap.loadCss');

?>
<img alt="<?php echo JText::_('COM_COMPONENTBUILDER'); ?>" src="components/com_componentbuilder/assets/images/component-300.jpg">
<ul class="list-striped">
<li><b><?php echo JText::_('COM_COMPONENTBUILDER_VERSION'); ?>:</b> <?php echo $manifest->version; ?></li>
<li><b><?php echo JText::_('COM_COMPONENTBUILDER_DATE'); ?>:</b> <?php echo $manifest->creationDate; ?></li>
<li><b><?php echo JText::_('COM_COMPONENTBUILDER_AUTHOR'); ?>:</b> <a href="mailto:<?php echo $manifest->authorEmail; ?>"><?php echo $manifest->author; ?></a></li>
<li><b><?php echo JText::_('COM_COMPONENTBUILDER_WEBSITE'); ?>:</b> <a href="<?php echo $manifest->authorUrl; ?>" target="_blank"><?php echo $manifest->authorUrl; ?></a></li>
<li><b><?php echo JText::_('COM_COMPONENTBUILDER_LICENSE'); ?>:</b> <?php echo $manifest->license; ?></li>
<li><b><?php echo $manifest->copyright; ?></b></li>
</ul>
<div class="clearfix"></div>
<?php if(ComponentbuilderHelper::checkArray($this->contributors)): ?>
<?php if(count($this->contributors) > 1): ?>
<h3><?php echo JText::_('COM_COMPONENTBUILDER_CONTRIBUTORS'); ?></h3>
<?php else: ?>
<h3><?php echo JText::_('COM_COMPONENTBUILDER_CONTRIBUTOR'); ?></h3>
<?php endif; ?>
<ul class="list-striped">
	<?php foreach($this->contributors as $contributor): ?>
    <li><b><?php echo $contributor['title']; ?>:</b> <?php echo $contributor['name']; ?></li>
    <?php endforeach; ?>
</ul>
<div class="clearfix"></div>
<?php endif; ?>