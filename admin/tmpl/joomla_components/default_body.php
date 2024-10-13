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
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
defined('_JEXEC') or die;

$edit = "index.php?option=com_componentbuilder&view=joomla_components&task=joomla_component.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = Factory::getContainer()->
			get(\Joomla\CMS\User\UserFactoryInterface::class)->
				loadUserById($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('joomla_component',$item,'joomla_components');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('joomla_component.edit.state')): ?>
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
		<?php if ($canDo->get('joomla_component.edit')): ?>
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
			<?php if ($canDo->get('joomla_component.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->system_name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo Html::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'joomla_components.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $this->escape($item->system_name); ?>
			<?php endif; ?>
				- <?php echo $this->escape($item->component_version); ?>
			</div>
			<?php
				// always make sure the $this->return_here is set
				if (!isset($this->return_here))
				{
					$this->return_here = urlencode(base64_encode((string) Uri::getInstance()));
				}
				// setup the buttons
				if (!isset($_buttons) || !ArrayHelper::check($_buttons))
				{
					$_buttons = array();
					$_buttons[0] = array(
						array(
							'view' => 'component_admin_views',
							'views' => 'components_admin_views',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_ADMIN_VIEWS'),
							'icon' => 'stack'),
						array(
							'view' => 'component_custom_admin_views',
							'views' => 'components_custom_admin_views',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_CUSTOM_ADMIN_VIEWS'),
							'icon' => 'screen'),
						array(
							'view' => 'component_site_views',
							'views' => 'components_site_views',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_SITE_VIEWS'),
							'icon' => 'palette'),
						array(
							'view' => 'component_router',
							'views' => 'components_routers',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_SITE_ROUTER'),
							'icon' => 'tree-2'),
						array(
							'view' => 'component_config',
							'views' => 'components_config',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_CONFIG'),
							'icon' => 'options')
						);
					$_buttons[1] = array(
						array(
							'view' => 'component_placeholders',
							'views' => 'components_placeholders',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_PLACEHOLDERS'),
							'icon' => 'search'),
						array(
							'view' => 'component_updates',
							'views' => 'components_updates',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_UPDATES'),
							'icon' => 'database'),
						array(
							'view' => 'component_mysql_tweaks',
							'views' => 'components_mysql_tweaks',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_MYSQL_TWEAKS'),
							'icon' => 'screwdriver'),
						array(
							'view' => 'component_files_folders',
							'views' => 'components_files_folders',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_FILES_FOLDERS'),
							'icon' => 'briefcase')
						);
					$_buttons[2] = array(
						array(
							'view' => 'component_custom_admin_menus',
							'views' => 'components_custom_admin_menus',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_CUSTOM_ADMIN_MENUS'),
							'icon' => 'plus'),
						array(
							'view' => 'component_dashboard',
							'views' => 'components_dashboard',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_DASHBOARD'),
							'icon' => 'dashboard'),
						array(
							'view' => 'component_modules',
							'views' => 'components_modules',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_MODULES'),
							'icon' => 'cube'),
						array(
							'view' => 'component_plugins',
							'views' => 'components_plugins',
							'title' => Text::_('COM_COMPONENTBUILDER_THE_COMPONENT_PLUGINS'),
							'icon' => 'power-cord')
						);
				}
			?>
			<div class="btn-group" style="margin: 5px 0 0 0;">
			<?php foreach ($_buttons[0] as $_button): ?>
				<?php if ($canDo->get($_button['view'].'.edit') && ($id = GetHelper::var($_button['view'], $item->id, 'joomla_component', 'id')) !== false): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&id=<?php echo $id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php elseif ($canDo->get($_button['view'].'.create')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&ref=joomla_component&refid=<?php echo $item->id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<div>
			<?php echo $this->escape($item->name_code); ?>
			</div>
			<div class="btn-group" style="margin: 5px 0 0 0;">
			<?php foreach ($_buttons[1] as $_button): ?>
				<?php if ($canDo->get($_button['view'].'.edit') && ($id = GetHelper::var($_button['view'], $item->id, 'joomla_component', 'id')) !== false): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&id=<?php echo $id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php elseif ($canDo->get($_button['view'].'.create')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&ref=joomla_component&refid=<?php echo $item->id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<div>
			<?php echo $this->escape($item->short_description); ?>
			</div>
			<div class="btn-group" style="margin: 5px 0 0 0;">
			<?php foreach ($_buttons[2] as $_button): ?>
				<?php if ($canDo->get($_button['view'].'.edit') && ($id = GetHelper::var($_button['view'], $item->id, 'joomla_component', 'id')) !== false): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&id=<?php echo $id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php elseif ($canDo->get($_button['view'].'.create')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&ref=joomla_component&refid=<?php echo $item->id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<div><b><?php echo $this->escape($item->companyname); ?></b><br />
			<?php if (StringHelper::check($item->author)) : ?>
				<em><?php echo $this->escape($item->author); ?><em><br />
			<?php endif; ?>
			<?php if (StringHelper::check($item->email) && StringHelper::check($item->author)) : ?>
				<a href="mailto:<?php echo $this->escape($item->email); ?>" title="<?php echo Text::sprintf('COM_COMPONENTBUILDER_EMAIL_S', $item->author); ?>" target="_blank">
					<?php echo $this->escape($item->email); ?>
				</a>
				<br />
			<?php endif; ?>
			<?php if (StringHelper::check($item->website) && StringHelper::check($item->author)) : ?>
				<a href="<?php echo $this->escape($item->website); ?>" title="<?php echo Text::sprintf('COM_COMPONENTBUILDER_WEBSITE_OF_S', $item->companyname); ?>" target="_blank">
					<?php echo $this->escape($item->website); ?>
				</a>
			<?php endif; ?>
			</div>
		</td>
		<td class="center">
		<?php if ($canDo->get('joomla_component.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'joomla_components.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'joomla_components.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo Html::_('jgrid.published', $item->published, $i, 'joomla_components.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo Html::_('jgrid.published', $item->published, $i, 'joomla_components.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>