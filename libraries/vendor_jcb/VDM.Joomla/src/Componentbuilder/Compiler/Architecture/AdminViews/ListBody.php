<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Power\Selection;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListItemBuilderInterface as ListItemBuilder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListLinkInterface as ListLink;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DoNotEscape;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListFieldClass;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Lists;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListBodyInterface;


/**
 * Admin View List Body Class.
 * 
 * Builds the table body an admin list view renders: one row per item, the
 * ordering handle, the selection checkbox, every column that targets the
 * admin list, and the publish state and id columns.
 * 
 * Two things differ between Joomla targets — how a checked out user is
 * looked up, and whether the permission tests are also guarded by the modal
 * state — so those are the extension points the target variants override.
 * 
 * @since  6.1.7
 */
class ListBody implements ListBodyInterface
{
	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * The Lists Class.
	 *
	 * @var   Lists
	 * @since 6.1.7
	 */
	protected Lists $lists;

	/**
	 * The List Item Builder Class.
	 *
	 * @var   ListItemBuilder
	 * @since 6.1.7
	 */
	protected ListItemBuilder $listitembuilder;

	/**
	 * The List Link Class.
	 *
	 * @var   ListLink
	 * @since 6.1.7
	 */
	protected ListLink $listlink;

	/**
	 * The List Field Class Class.
	 *
	 * @var   ListFieldClass
	 * @since 6.1.7
	 */
	protected ListFieldClass $listfieldclass;

	/**
	 * The Do Not Escape Class.
	 *
	 * @var   DoNotEscape
	 * @since 6.1.7
	 */
	protected DoNotEscape $donotescape;

	/**
	 * The Field Names Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * Constructor.
	 *
	 * @param Permission       $permission        The Permission Class.
	 * @param Lists            $lists             The Lists Class.
	 * @param ListItemBuilder  $listitembuilder   The List Item Builder Class.
	 * @param ListLink         $listlink          The List Link Class.
	 * @param ListFieldClass   $listfieldclass    The List Field Class Class.
	 * @param DoNotEscape      $donotescape       The Do Not Escape Class.
	 * @param FieldNames       $fieldnames        The Field Names Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Permission $permission,
		Lists $lists,
		ListItemBuilder $listitembuilder,
		ListLink $listlink,
		ListFieldClass $listfieldclass,
		DoNotEscape $donotescape,
		FieldNames $fieldnames)
	{
		$this->permission = $permission;
		$this->lists = $lists;
		$this->listitembuilder = $listitembuilder;
		$this->listlink = $listlink;
		$this->listfieldclass = $listfieldclass;
		$this->donotescape = $donotescape;
		$this->fieldnames = $fieldnames;
	}

	/**
	 * Build the table body of an admin list view.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get($nameSingleCode, $nameListCode)
	{
		if (($items = $this->lists->get($nameListCode)) !== null)
		{
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// add the default
			$body = "<?php foreach (\$this->items as \$i => \$item): ?>";
			$body .= PHP_EOL . Indent::_(1) . "<?php";
			$body .= PHP_EOL . Indent::_(2)
				. "\$canCheckin = \$this->user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$this->user->id || \$item->checked_out == 0;";
			$body .= $this->getCheckedOutUser();

			// only the modal guard differs, the three permission tests do not
			$guard = $this->getModalGuard();

			$allowSortingWhen = "<?php if (" . $guard . "\$canDo->get('"
				. $this->permission->getGlobal($nameSingleCode, 'core.edit.state') . "')): ?>";
			$allowSelectionWhen =  "<?php if (" . $guard . "\$canDo->get('"
				. $this->permission->getGlobal($nameSingleCode, 'core.edit') . "')): ?>";
			$allowPublishedWhen =  "<?php if (" . $guard . "\$canDo->get('"
				. $this->permission->getGlobal($nameSingleCode, 'core.edit.state') . "')) : ?>";
			$body .= PHP_EOL . Indent::_(2) . "\$canDo = " . Selection::permittedActionsToken() . "::get('" . $nameSingleCode . "', \$item, '" . $nameListCode . "');";
			$body .= PHP_EOL . Indent::_(1) . "?>";
			$body .= PHP_EOL . Indent::_(1)
				. '<tr class="row<?php echo $i % 2; ?>">';
			// only load if not overwritten
			if (!$this->fieldnames->isString($nameSingleCode . '.ordering'))
			{
				$body .= PHP_EOL . Indent::_(2)
					. '<td class="order nowrap center hidden-phone">';
				// check if the item has permissions.
				$body .= PHP_EOL . Indent::_(2) . $allowSortingWhen;
				$body .= PHP_EOL . Indent::_(3) . "<?php";
				$body .= PHP_EOL . Indent::_(4) . "\$iconClass = '';";
				$body .= PHP_EOL . Indent::_(4) . "if (!\$this->saveOrder)";
				$body .= PHP_EOL . Indent::_(4) . "{";
				$body .= PHP_EOL . Indent::_(5)
					. "\$iconClass = ' inactive tip-top"
					. '" hasTooltip" title="'
					. "' . Html::tooltipText('JORDERINGDISABLED');";
				$body .= PHP_EOL . Indent::_(4) . "}";
				$body .= PHP_EOL . Indent::_(3) . "?>";
				$body .= PHP_EOL . Indent::_(3)
					. '<span class="sortable-handler<?php echo $iconClass; ?>">';
				$body .= PHP_EOL . Indent::_(4) . '<i class="icon-menu"></i>';
				$body .= PHP_EOL . Indent::_(3) . "</span>";
				$body .= PHP_EOL . Indent::_(3)
					. "<?php if (\$this->saveOrder) : ?>";
				$body .= PHP_EOL . Indent::_(4)
					. '<input type="text" style="display:none" name="order[]" size="5"';
				$body .= PHP_EOL . Indent::_(4)
					. 'value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />';
				$body .= PHP_EOL . Indent::_(3) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(3) . "&#8942;";
				$body .= PHP_EOL . Indent::_(2) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "</td>";
			}
			$body .= PHP_EOL . Indent::_(2) . '<td class="nowrap center">';
			// check if the item has permissions.
			$body .= PHP_EOL . Indent::_(2) . $allowSelectionWhen;
			$body .= PHP_EOL . Indent::_(4)
				. "<?php if (\$item->checked_out) : ?>";
			$body .= PHP_EOL . Indent::_(5) . "<?php if (\$canCheckin) : ?>";
			$body .= PHP_EOL . Indent::_(6)
				. "<?php echo Html::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL . Indent::_(5) . "<?php else: ?>";
			$body .= PHP_EOL . Indent::_(6) . "&#9633;";
			$body .= PHP_EOL . Indent::_(5) . "<?php endif; ?>";
			$body .= PHP_EOL . Indent::_(4) . "<?php else: ?>";
			$body .= PHP_EOL . Indent::_(5)
				. "<?php echo Html::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL . Indent::_(4) . "<?php endif; ?>";
			$body .= PHP_EOL . Indent::_(2) . "<?php else: ?>";
			$body .= PHP_EOL . Indent::_(3) . "&#9633;";
			$body .= PHP_EOL . Indent::_(2) . "<?php endif; ?>";
			$body .= PHP_EOL . Indent::_(2) . "</td>";
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if ($this->donotescape->exists($nameListCode))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($items as $item)
			{
				// check if target is admin list
				if (1 == $item['target'] || 3 == $item['target'])
				{
					// set some defaults
					$customAdminViewButtons = '';
					// set the item default class
					$itemClass = 'hidden-phone';
					// set the item row
					$itemRow = $this->listitembuilder->get(
						$item, $nameSingleCode, $nameListCode, $itemClass, $doNotEscape
					);
					// check if buttons was already added
					if ($firstTimeBeingAdded) // TODO we must improve this to allow more items to be targeted instead of just the first item :)
					{
						// get custom admin view buttons
						$customAdminViewButtons
							= $this->listlink->getButtons($nameListCode, '');
						// make sure the custom admin view buttons are only added once
						$firstTimeBeingAdded = false;
					}
					// add row to body
					$body .= PHP_EOL . Indent::_(2) . "<td class=\""
						. $this->listfieldclass->get(
							$nameListCode . '.' . $item['code'], $itemClass
						) . "\">";
					$body .= $itemRow;
					$body .= $customAdminViewButtons;
					$body .= PHP_EOL . Indent::_(2) . "</td>";
				}
			}
			// add the defaults
			if (!$this->fieldnames->isString($nameSingleCode . '.published'))
			{
				$body .= PHP_EOL . Indent::_(2) . '<td class="center">';
				// check if the item has permissions.
				$body .= PHP_EOL . Indent::_(2) . $allowPublishedWhen;
				$body .= PHP_EOL . Indent::_(4)
					. "<?php if (\$item->checked_out) : ?>";
				$body .= PHP_EOL . Indent::_(5)
					. "<?php if (\$canCheckin) : ?>";
				$body .= PHP_EOL . Indent::_(6)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', true, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(5) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(6)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', false, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(5) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(4) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(5)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', true, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(4) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', false, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(2) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "</td>";
			}
			if (!$this->fieldnames->isString($nameSingleCode . '.id'))
			{
				$body .= PHP_EOL . Indent::_(2) . '<td class="'
					. $this->listfieldclass->get(
						$nameListCode . '.' . $item['code'],
						'nowrap center hidden-phone'
					) . '">';
				$body .= PHP_EOL . Indent::_(3) . "<?php echo \$item->id; ?>";
				$body .= PHP_EOL . Indent::_(2) . "</td>";
			}
			$body .= PHP_EOL . Indent::_(1) . "</tr>";
			$body .= PHP_EOL . "<?php endforeach; ?>";

			// return the build
			return $body;
		}

		return '';
	}

	/**
	 * Get the lookup of the user who has an item checked out.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getCheckedOutUser(): string
	{
		$body = PHP_EOL . Indent::_(2)
			. "\$userChkOut = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getContainer()->";
		$body .= PHP_EOL . Indent::_(3)
			. "get(Joomla__"."_c2980d12_c3ef_4e23_b4a2_e6af1f5900a9___Power::class)->";
		$body .= PHP_EOL . Indent::_(4)
			. "loadUserById((int) (\$item->checked_out ?? 0));";

		return $body;
	}

	/**
	 * Get the guard the permission tests carry ahead of the action check.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getModalGuard(): string
	{
		return "!\$this->isModal && ";
	}
}

