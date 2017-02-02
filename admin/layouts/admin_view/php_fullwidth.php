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

	@version		2.2.9
	@build			2nd February, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		php_fullwidth.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file

defined('_JEXEC') or die('Restricted access');

$form = $displayData->getForm();

$fields = $displayData->get('fields') ?: array(
	'add_php_ajax',
	'php_ajaxmethod',
	'ajax_input',
	'add_php_getitem',
	'php_getitem',
	'add_php_getitems',
	'php_getitems',
	'add_php_getitems_after_all',
	'php_getitems_after_all',
	'add_php_getlistquery',
	'php_getlistquery',
	'add_php_save',
	'php_save',
	'add_php_postsavehook',
	'php_postsavehook',
	'add_php_allowedit',
	'php_allowedit',
	'add_php_batchcopy',
	'php_batchcopy',
	'add_php_batchmove',
	'php_batchmove',
	'add_php_before_publish',
	'php_before_publish',
	'add_php_after_publish',
	'php_after_publish',
	'add_php_before_delete',
	'php_before_delete',
	'add_php_after_delete',
	'php_after_delete',
	'add_php_document',
	'php_document'
);

?>
<div class="form-vertical">
<?php foreach($fields as $field): ?>
    <div class="control-group">
        <div class="control-label">
            <?php echo $form->getLabel($field); ?>
        </div>
        <div class="controls">
            <?php echo $form->getInput($field); ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
