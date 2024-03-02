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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;

$edit = "index.php?option=com_componentbuilder&view=admin_views&task=admin_view.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = Factory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('admin_view',$item,'admin_views');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('admin_view.edit.state')): ?>
			<?php
				$iconClass = '';
				if (!$this->saveOrder)
				{
					$iconClass = ' inactive tip-top" hasTooltip" title="' . Html::tooltipText('JORDERINGDISABLED');
				}
			?>
			<span class="sortable-handler<?php echo $iconClass; ?>">
				<i class="icon-menu"></i>
			</span>
			<?php if ($this->saveOrder) : ?>
				<input type="text" style="display:none" name="order[]" size="5"
				value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
			<?php endif; ?>
		<?php else: ?>
			&#8942;
		<?php endif; ?>
		</td>
		<td class="nowrap center">
		<?php if ($canDo->get('admin_view.edit')): ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo Html::_('grid.id', $i, $item->id); ?>
					<?php else: ?>
						&#9633;
					<?php endif; ?>
				<?php else: ?>
					<?php echo Html::_('grid.id', $i, $item->id); ?>
				<?php endif; ?>
		<?php else: ?>
			&#9633;
		<?php endif; ?>
		</td>
		<td class="nowrap">
			<div>
			<?php if ($canDo->get('admin_view.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->system_name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo Html::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'admin_views.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $this->escape($item->system_name); ?>
			<?php endif; ?>
			 - 
			<?php echo Text::_($item->type); ?>
			</div>
			<?php
				// setup the buttons
				if (!isset($_buttons) || !ArrayHelper::check($_buttons))
				{
					$_buttons = array(
						array(
							'view' => 'admin_fields',
							'views' => 'admins_fields',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_ADMIN_FIELDS'),
							'icon' => 'list'),
						array(
							'view' => 'admin_fields_relations',
							'views' => 'admins_fields_relations',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_ADMIN_FIELDS_RELATIONS'),
							'icon' => 'tree-2'),
						array(
							'view' => 'admin_fields_conditions',
							'views' => 'admins_fields_conditions',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_ADMIN_FIELDS_CONDITIONS'),
							'icon' => 'shuffle'),
						array(
							'view' => 'admin_custom_tabs',
							'views' => 'admins_custom_tabs',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_ADMIN_CUSTOM_TABS'),
							'icon' => 'folder-plus')
						);
				}
			?>
			<div class="btn-group" style="margin: 5px 0 0 0;">
			<?php foreach ($_buttons as $_button): ?>
				<?php if ($canDo->get($_button['view'].'.edit') && ($id = GetHelper::var($_button['view'], $item->id, 'admin_view', 'id')) !== false): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&id=<?php echo $id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php elseif ($canDo->get($_button['view'].'.create')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&ref=admin_view&refid=<?php echo $item->id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<div><?php echo Text::_('COM_COMPONENTBUILDER_EDIT_VIEW'); ?>: <b>
			<?php echo $this->escape($item->name_single); ?></b><br />
			<?php echo Text::_('COM_COMPONENTBUILDER_LIST_VIEW'); ?>: <b>
			<?php echo $this->escape($item->name_list); ?></b>
			</div>
		</td>
		<td class="hidden-phone">
			<div><em>
			<?php echo $this->escape($item->short_description); ?></em>
			<ul style="list-style: none">
				<li><?php echo Text::_("COM_COMPONENTBUILDER_CUSTOM_BUTTON"); ?>: <b>
			<?php echo Text::_($item->add_custom_button); ?></b></li>
				<li><?php echo Text::_("COM_COMPONENTBUILDER_CUSTOM_IMPORT"); ?>: <b>
			<?php echo Text::_($item->add_custom_import); ?></b></li>
				<li><?php echo Text::_("COM_COMPONENTBUILDER_FADE_IN"); ?>: <b>
			<?php echo Text::_($item->add_fadein); ?></b></li>
				<li><?php echo Text::_("COM_COMPONENTBUILDER_AJAX"); ?>: <b>
			<?php echo Text::_($item->add_php_ajax); ?></b></li>
			</ul>
			</div>
		</td>
		<td class="center">
		<?php if ($canDo->get('admin_view.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'admin_views.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'admin_views.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo Html::_('jgrid.published', $item->published, $i, 'admin_views.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo Html::_('jgrid.published', $item->published, $i, 'admin_views.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>