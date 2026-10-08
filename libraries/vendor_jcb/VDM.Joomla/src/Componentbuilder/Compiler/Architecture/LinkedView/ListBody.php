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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\LinkedView;


use VDM\Joomla\Componentbuilder\Compiler\Power\Selection;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListItemBuilderInterface as ListItemBuilder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListLinkInterface as ListLink;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DoNotEscape;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Lists;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView\ListBodyInterface;


/**
 * Linked View List Body Class.
 * 
 * Builds the table body a linked admin view renders inside an edit tab: one
 * row per item, the columns that target the linked list, the publish state
 * and id columns, and the paging footer.
 * 
 * Only how a checked-out user is looked up differs between Joomla targets,
 * so that is the extension point the target variants override.
 * 
 * @since  6.1.7
 */
class ListBody implements ListBodyInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

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
	 * @param Config            $config            The Config Class.
	 * @param Lists             $lists             The Lists Class.
	 * @param ListItemBuilder   $listitembuilder   The List Item Builder Class.
	 * @param ListLink          $listlink          The List Link Class.
	 * @param DoNotEscape       $donotescape       The Do Not Escape Class.
	 * @param FieldNames        $fieldnames        The Field Names Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Lists $lists,
		ListItemBuilder $listitembuilder, ListLink $listlink,
		DoNotEscape $donotescape, FieldNames $fieldnames)
	{
		$this->config = $config;
		$this->lists = $lists;
		$this->listitembuilder = $listitembuilder;
		$this->listlink = $listlink;
		$this->donotescape = $donotescape;
		$this->fieldnames = $fieldnames;
	}

	/**
	 * Get the table body of a linked admin view.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 * @param   string  $refview         The referring view.
	 *
	 * @return  string  The generated table body.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode,
		string $refview): string
	{
		if (($items = $this->lists->get($nameListCode)) === null)
		{
			return '';
		}

		$footable_version = $this->config->get('footable_version', 2);
		// make sure the custom links are only added once
		$firstTimeBeingAdded = true;
		$counter = 0;
		$itemClass = '';
		// add the default
		$body = PHP_EOL . "<tbody>";
		$body .= PHP_EOL . "<?php foreach (\$items as \$i => \$item): ?>";
		$body .= PHP_EOL . Indent::_(1) . "<?php";
		$body .= PHP_EOL . Indent::_(2)
			. "\$canCheckin = \$user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$user->id || \$item->checked_out == 0;";
		$body .= $this->getCheckedOutUser();
		$body .= PHP_EOL . Indent::_(2) . "\$canDo = " . Selection::permittedActionsToken() . "::get('" . $nameSingleCode . "', \$item, '" . $nameListCode . "');";
		$body .= PHP_EOL . Indent::_(1) . "?>";
		$body .= PHP_EOL . Indent::_(1) . '<tr>';
		// check if this view has fields that should not be escaped
		$doNotEscape = false;
		if ($this->donotescape->exists($nameListCode))
		{
			$doNotEscape = true;
		}
		// start adding the dynamic
		foreach ($items as $item)
		{
			// check if target is linked list view
			if (1 == $item['target'] || 4 == $item['target'])
			{
				// set the ref
				$ref = '<?php echo $ref; ?>';
				// set some defaults
				$customAdminViewButtons = '';
				// set the item row
				$itemRow = $this->listitembuilder->get(
					$item, $nameSingleCode, $nameListCode, $itemClass,
					$doNotEscape, false, $ref,
					'$displayData->', '$user', $refview
				);
				// check if buttons was aready added
				if ($firstTimeBeingAdded) // TODO we must improve this to allow more items to be targeted instead of just the first item :)
				{
					// get custom admin view buttons
					$customAdminViewButtons
						= $this->listlink->getButtons(
						$nameListCode, $ref
					);
					// make sure the custom admin view buttons are only added once
					$firstTimeBeingAdded = false;
				}
				// add row to body
				$body .= PHP_EOL . Indent::_(2) . "<td>";
				$body .= $itemRow;
				$body .= $customAdminViewButtons;
				$body .= PHP_EOL . Indent::_(2) . "</td>";
				// increment counter
				$counter++;
			}
		}
		$data_value = (3 == $footable_version) ? 'data-sort-value'
			: 'data-value';

		// add the defaults
		if (!$this->fieldnames->isString($nameSingleCode . '.published'))
		{
			$counter++;
			$body .= $this->getPublishStates($data_value);
		}

		// add the defaults
		if (!$this->fieldnames->isString($nameSingleCode . '.id'))
		{
			$counter++;
			$body .= PHP_EOL . Indent::_(2)
				. '<td class="nowrap center hidden-phone">';
			$body .= PHP_EOL . Indent::_(3) . "<?php echo \$item->id; ?>";
			$body .= PHP_EOL . Indent::_(2) . "</td>";
		}
		$body .= PHP_EOL . Indent::_(1) . "</tr>";
		$body .= PHP_EOL . "<?php endforeach; ?>";
		$body .= PHP_EOL . "</tbody>";
		if (2 == $footable_version)
		{
			$body .= PHP_EOL . '<tfoot class="hide-if-no-paging">';
			$body .= PHP_EOL . Indent::_(1) . '<tr>';
			$body .= PHP_EOL . Indent::_(2) . '<td colspan="' . $counter
				. '">';
			$body .= PHP_EOL . Indent::_(3)
				. '<div class="pagination pagination-centered"></div>';
			$body .= PHP_EOL . Indent::_(2) . '</td>';
			$body .= PHP_EOL . Indent::_(1) . '</tr>';
			$body .= PHP_EOL . '</tfoot>';
		}
		$body .= PHP_EOL . '</table>';
		$body .= PHP_EOL . '<?php else: ?>';
		$body .= PHP_EOL . Indent::_(1)
			. '<div class="alert alert-no-items">';
		$body .= PHP_EOL . Indent::_(2) . '<?php echo Joomla__'.'_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('
			. "'JGLOBAL_NO_MATCHING_RESULTS'" . '); ?>';
		$body .= PHP_EOL . Indent::_(1) . '</div>';
		$body .= PHP_EOL . '<?php endif; ?>';

		// return the build
		return $body;
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
	 * Get the publish state column of a row.
	 *
	 * @param   string  $data_value  The sort-value attribute of the target release.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getPublishStates(string $data_value): string
	{
		$prefix = $this->config->lang_prefix;

		// add the defaults
		$body = PHP_EOL . Indent::_(2)
			. "<?php if (\$item->published == 1): ?>";
		$body .= $this->getPublishState($data_value, '1', 'published', $prefix . '_PUBLISHED');

		$body .= PHP_EOL . Indent::_(2)
			. "<?php elseif (\$item->published == 0): ?>";
		$body .= $this->getPublishState($data_value, '2', 'inactive', $prefix . '_INACTIVE');

		$body .= PHP_EOL . Indent::_(2)
			. "<?php elseif (\$item->published == 2): ?>";
		$body .= $this->getPublishState($data_value, '3', 'archived', $prefix . '_ARCHIVED');

		$body .= PHP_EOL . Indent::_(2)
			. "<?php elseif (\$item->published == -2): ?>";
		$body .= $this->getPublishState($data_value, '4', 'trashed', $prefix . '_TRASHED');

		$body .= PHP_EOL . Indent::_(2) . '<?php endif; ?>';

		return $body;
	}

	/**
	 * Get one publish state cell of a row.
	 *
	 * @param   string  $data_value  The sort-value attribute of the target release.
	 * @param   string  $sort        The sort order of this state.
	 * @param   string  $state       The status class suffix of this state.
	 * @param   string  $lang        The language key of this state.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getPublishState(string $data_value, string $sort,
		string $state, string $lang): string
	{
		$body = PHP_EOL . Indent::_(3) . '<td class="center"  '
			. $data_value . '="' . $sort . '">';
		$body .= PHP_EOL . Indent::_(4)
			. '<span class="status-metro status-' . $state . '" title="<?php echo Text:'
			. ':_(' . "'" . $lang . "'"
			. ');  ?>">';
		$body .= PHP_EOL . Indent::_(5) . '<?php echo Joomla__'.'_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('
			. "'"
			. $lang . "'" . '); ?>';
		$body .= PHP_EOL . Indent::_(4) . '</span>';
		$body .= PHP_EOL . Indent::_(3) . '</td>';

		return $body;
	}
}

