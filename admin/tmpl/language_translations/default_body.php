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
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
defined('_JEXEC') or die;

$edit = "index.php?option=com_componentbuilder&view=language_translations&task=language_translation.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = Factory::getContainer()->
			get(\Joomla\CMS\User\UserFactoryInterface::class)->
				loadUserById($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('language_translation',$item,'language_translations');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('language_translation.edit.state')): ?>
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
		<?php if ($canDo->get('language_translation.edit')): ?>
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
			<?php if ($canDo->get('language_translation.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $item->source; ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo Html::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'language_translations.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $item->source; ?>
			<?php endif; ?>
			<?php
			$langBucket = array();
			if (JsonHelper::check($item->translation))
			{
				$translations = json_decode($item->translation, true);
				if (ArrayHelper::check($translations))
				{
					foreach ($translations as $language)
					{
						if (isset($language['translation']) && StringHelper::check($language['translation'])
						&& isset($language['language']) && StringHelper::check($language['language']))
						{
							$langBucket[$language['language']] = $language['language'];
						}
					}
				}
			}
			// start how many usedin's
			$counterUsedin = array();
			// set how many components use this string
			if (JsonHelper::check($item->components))
			{
				$item->components = json_decode($item->components, true);
			}
			if (($number = ArrayHelper::check($item->components)) !== false)
			{
				if ($number == 1)
				{
					$counterUsedin[] = $number . ' ' . Text::_('COM_COMPONENTBUILDER_COMPONENT');
				}
				else
				{
					$counterUsedin[] = $number . ' ' . Text::_('COM_COMPONENTBUILDER_COMPONENTS');
				}
			}
			// set how many modules use this string
			if (JsonHelper::check($item->modules))
			{
				$item->modules = json_decode($item->modules, true);
			}
			if (($number = ArrayHelper::check($item->modules)) !== false)
			{
				if ($number == 1)
				{
					$counterUsedin[] = $number . ' ' . Text::_('COM_COMPONENTBUILDER_MODULE');
				}
				else
				{
					$counterUsedin[] = $number . ' ' . Text::_('COM_COMPONENTBUILDER_MODULES');
				}
			}
			// set how many plugins use this string
			if (JsonHelper::check($item->plugins))
			{
				$item->plugins = json_decode($item->plugins, true);
			}
			if (($number = ArrayHelper::check($item->plugins)) !== false)
			{
				if ($number == 1)
				{
					$counterUsedin[] = $number . ' ' . Text::_('COM_COMPONENTBUILDER_PLUGIN');
				}
				else
				{
					$counterUsedin[] = $number . ' ' . Text::_('COM_COMPONENTBUILDER_PLUGINS');
				}
			}
			// build the numbers
			$numbersUsedin = '';
			if (ArrayHelper::check($counterUsedin))
			{
				$numbersUsedin = '<br />' . Text::_('COM_COMPONENTBUILDER_USED_IN') . ' ' . implode('<br />', $counterUsedin);
			}
			// load the languages to the string
			if (ArrayHelper::check($langBucket))
			{
				echo '<br /><small>' . Text::_('COM_COMPONENTBUILDER_ALREADY_TRANSLATED_INTO') . ' <em>(' . implode(', ', $langBucket) . ')</em>' . $numbersUsedin . '</small>';
			}
			else
			{
				echo '<br /><small><em>(' . Text::_('COM_COMPONENTBUILDER_NOTRANSLATION') . ')</em>' . $numbersUsedin . '</small>';
			}
			?>
			</div>
		</td>
		<td class="center">
		<?php if ($canDo->get('language_translation.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'language_translations.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'language_translations.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo Html::_('jgrid.published', $item->published, $i, 'language_translations.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo Html::_('jgrid.published', $item->published, $i, 'language_translations.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>