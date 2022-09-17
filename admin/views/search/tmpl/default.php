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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
use VDM\Joomla\Componentbuilder\Search\Factory as SearchFactory;
?>
<?php if ($this->canDo->get('search.access')): ?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task === 'search.back') {
			parent.history.back();
			return false;
		} else {
			var form = document.getElementById('adminForm');
			form.task.value = task;
			form.submit();
		}
	}
</script>
<?php $urlId = (isset($this->item->id)) ? '&id='. (int) $this->item->id : ''; ?>
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=search' . $urlId); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<?php if(!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif; ?>
	<?php
	// let's do some tests with the API
	$tableName = 'admin_view';
	$searchValue = '\b\w+Helper';
	// set the search configurations
	SearchFactory::_('Config')->table_name = $tableName;
	SearchFactory::_('Config')->search_value = $searchValue;
	SearchFactory::_('Config')->match_case = 1;
	SearchFactory::_('Config')->whole_word = 0;
	SearchFactory::_('Config')->regex_search = 1;
	SearchFactory::_('Config')->component_id = 0;

	if (($items = SearchFactory::_('Agent')->find()) !== null)
	{
		echo JText::sprintf('COM_COMPONENTBUILDER_WE_FOUND_SOME_INSTANCES_IN_S', $tableName) . '<br /><pre>';
		var_dump($items);
		echo '</pre>';
	}
	else
	{
		echo JText::sprintf('COM_COMPONENTBUILDER_NO_INSTANCES_WHERE_FOUND_S', $tableName);
	}
 	?>
</div>
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
<?php else: ?>
        <h1><?php echo JText::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>

