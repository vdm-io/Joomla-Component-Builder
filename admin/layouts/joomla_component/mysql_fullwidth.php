<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file

defined('_JEXEC') or die('Restricted access');

$form = $displayData->getForm();

$fields = $displayData->get('fields') ?: array(
	'add_sql',
	'sql',
	'add_sql_uninstall',
	'sql_uninstall'
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
