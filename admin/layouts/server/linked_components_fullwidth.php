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
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;

// No direct access to this file
defined('_JEXEC') or die;

// set the defaults
$items = $displayData->vydlinked_components;
$user = Factory::getApplication()->getIdentity();
$id = $displayData->item->id;
// set the edit URL
$edit = "index.php?option=com_componentbuilder&view=joomla_components&task=joomla_component.edit";
// set a return value
$return = ($id) ? "index.php?option=com_componentbuilder&view=server&layout=edit&id=" . $id : "";
// check for a return value
$jinput = Factory::getApplication()->input;
if ($_return = $jinput->get('return', null, 'base64'))
{
	$return .= "&return=" . $_return;
}
// check if return value was set
if (StringHelper::check($return))
{
	// set the referral values
	$ref = ($id) ? "&ref=server&refid=" . $id . "&return=" . urlencode(base64_encode($return)) : "&return=" . urlencode(base64_encode($return));
}
else
{
	$ref = ($id) ? "&ref=server&refid=" . $id : "";
}

?>
<div class="form-vertical">
<?php if (ArrayHelper::check($items)): ?>
<table class="footable table data joomla_components" data-show-toggle="true" data-toggle-column="first" data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true">
<thead>
	<tr>
		<th data-type="html" data-sort-use="text">
			<?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SYSTEM_NAME_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS_CODE_NAME'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS_DESCRIPTION'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENTS_COMPANY_DETAILS'); ?>
		</th>
		<th width="10" data-breakpoints="xs sm md">
			<?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_STATUS'); ?>
		</th>
		<th width="5" data-type="number" data-breakpoints="xs sm md">
			<?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_ID'); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php foreach ($items as $i => $item): ?>
	<?php
		$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
		$userChkOut = Factory::getContainer()->
			get(\Joomla\CMS\User\UserFactoryInterface::class)->
				loadUserById($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('joomla_component',$item,'joomla_components');
	?>
	<tr>
		<td>
			<div>
			<?php if ($canDo->get('joomla_component.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?><?php echo $ref; ?>"><?php echo $displayData->escape($item->system_name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo Html::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'joomla_components.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $displayData->escape($item->system_name); ?>
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
		<td>
			<div>
			<?php echo $displayData->escape($item->name_code); ?>
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
		<td>
			<div>
			<?php echo $displayData->escape($item->short_description); ?>
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
		<td>
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
		<?php if ($item->published == 1): ?>
			<td class="center"  data-sort-value="1">
				<span class="status-metro status-published" title="<?php echo Text::_('COM_COMPONENTBUILDER_PUBLISHED');  ?>">
					<?php echo Text::_('COM_COMPONENTBUILDER_PUBLISHED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 0): ?>
			<td class="center"  data-sort-value="2">
				<span class="status-metro status-inactive" title="<?php echo Text::_('COM_COMPONENTBUILDER_INACTIVE');  ?>">
					<?php echo Text::_('COM_COMPONENTBUILDER_INACTIVE'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 2): ?>
			<td class="center"  data-sort-value="3">
				<span class="status-metro status-archived" title="<?php echo Text::_('COM_COMPONENTBUILDER_ARCHIVED');  ?>">
					<?php echo Text::_('COM_COMPONENTBUILDER_ARCHIVED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == -2): ?>
			<td class="center"  data-sort-value="4">
				<span class="status-metro status-trashed" title="<?php echo Text::_('COM_COMPONENTBUILDER_TRASHED');  ?>">
					<?php echo Text::_('COM_COMPONENTBUILDER_TRASHED'); ?>
				</span>
			</td>
		<?php endif; ?>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
	<div class="alert alert-no-items">
		<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
	</div>
<?php endif; ?>
</div>
