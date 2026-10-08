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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListHeadOverride;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Lists;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Linked View List Head Class.
 * 
 * Builds the table head a linked admin view renders inside an edit tab,
 * together with the new-record buttons above it.
 * 
 * Which Footable release the component uses decides the responsive
 * attributes of every column, so both releases are built here. Columns are
 * hidden progressively as the table grows: the first three stay on every
 * screen, the next three drop on phones, and the rest drop entirely.
 * 
 * @since  6.1.7
 */
final class ListHead
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Lists Class.
	 *
	 * @var   Lists
	 * @since 6.1.7
	 */
	protected Lists $lists;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * The List Head Override Class.
	 *
	 * @var   ListHeadOverride
	 * @since 6.1.7
	 */
	protected ListHeadOverride $listheadoverride;

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
	 * @param Config             $config             The Config Class.
	 * @param Language           $language           The Language Class.
	 * @param Lists              $lists              The Lists Class.
	 * @param Permission         $permission         The Permission Class.
	 * @param ListHeadOverride   $listheadoverride   The List Head Override Class.
	 * @param FieldNames         $fieldnames         The Field Names Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Language $language,
		Lists $lists, Permission $permission,
		ListHeadOverride $listheadoverride, FieldNames $fieldnames)
	{
		$this->config = $config;
		$this->language = $language;
		$this->lists = $lists;
		$this->permission = $permission;
		$this->listheadoverride = $listheadoverride;
		$this->fieldnames = $fieldnames;
	}

	/**
	 * Get the table head of a linked admin view.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 * @param   int     $addNewButon     Which new-record buttons to add.
	 * @param   string  $refview         The referring view.
	 *
	 * @return  string  The generated table head.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode,
		$addNewButon, string $refview): string
	{
		if (($items = $this->lists->get($nameListCode)) === null)
		{
			return '';
		}

		$footable_version = $this->config->get('footable_version', 2);
		$head = $this->getNewButtons($nameSingleCode, $addNewButon, $refview);

		$head .= '<?php if (Super_' . '__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($items)): ?>';
		// set the style for V2
		$metro_blue = (2 == $footable_version) ? ' metro-blue' : '';
		// set the toggle for V3
		$toggle = (3 == $footable_version)
			? ' data-show-toggle="true" data-toggle-column="first"' : '';
		// set paging
		$paging = (2 == $footable_version)
			? ' data-page-size="20" data-filter="#filter_' . $nameListCode
			. '"'
			: ' data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true"';
		// add html fix for V3
		$htmlFix = (3 == $footable_version)
			? ' data-type="html" data-sort-use="text"' : '';
		$head    .= PHP_EOL . '<table class="footable table data '
			. $nameListCode . $metro_blue . '"' . $toggle . $paging . '>';
		$head    .= PHP_EOL . "<thead>";
		// main lang prefix
		$langView = $this->config->lang_prefix . '_'
			. StringHelper::safe($nameSingleCode, 'U');
		// set status lang
		$statusLangName = $langView . '_STATUS';
		// set id lang
		$idLangName = $langView . '_ID';
		// make sure only first link is used as togeler
		$firstLink = true;
		// add to lang array
		$this->language->set($this->config->lang_target, $statusLangName, 'Status');
		// add to lang array
		$this->language->set($this->config->lang_target, $idLangName, 'Id');
		$head .= PHP_EOL . Indent::_(1) . "<tr>";
		// set controller for data hiding options
		$controller = 1;
		// build the dynamic fields
		foreach ($items as $item)
		{
			// check if target is linked list view
			if (1 == $item['target'] || 4 == $item['target'])
			{
				// check if we have an over-ride
				if (($list_head_override = $this->listheadoverride->
					get($nameListCode . '.' . $item['guid'])) !== null)
				{
					$item['lang'] = $list_head_override;
				}
				$setin = (2 == $footable_version)
					? ' data-hide="phone"' : ' data-breakpoints="xs sm"';
				if ($controller > 3)
				{
					$setin = (2 == $footable_version)
						? ' data-hide="phone,tablet"'
						: ' data-breakpoints="xs sm md"';
				}

				if ($controller > 6)
				{
					$setin = (2 == $footable_version)
						? ' data-hide="all"' : ' data-breakpoints="all"';
				}

				if ($item['link'] && $firstLink)
				{
					$setin     = (2 == $footable_version)
						? ' data-toggle="true"' : '';
					$firstLink = false;
				}
				$head .= PHP_EOL . Indent::_(2) . "<th" . $setin . $htmlFix
					. ">";
				$head .= PHP_EOL . Indent::_(3) . "<?php echo Text:"
					. ":_('" . $item['lang'] . "'); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
				$controller++;
			}
		}
		// set some V3 attr
		$data_hide = (2 == $footable_version)
			? 'data-hide="phone,tablet"' : 'data-breakpoints="xs sm md"';
		// add the defaults
		if (!$this->fieldnames->isString($nameSingleCode . '.published'))
		{
			$head .= PHP_EOL . Indent::_(2) . '<th width="10" ' . $data_hide
				. '>';
			$head .= PHP_EOL . Indent::_(3) . "<?php echo Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
				. $statusLangName . "'); ?>";
			$head .= PHP_EOL . Indent::_(2) . "</th>";
		}

		// add the defaults
		if (!$this->fieldnames->isString($nameSingleCode . '.id'))
		{
			$data_type = (2 == $footable_version)
				? 'data-type="numeric"'
				: 'data-type="number"';
			$head      .= PHP_EOL . Indent::_(2) . '<th width="5" '
				. $data_type
				. ' ' . $data_hide . '>';
			$head      .= PHP_EOL . Indent::_(3) . "<?php echo Text:"
				. ":_('"
				. $idLangName . "'); ?>";
			$head      .= PHP_EOL . Indent::_(2) . "</th>";
		}
		$head .= PHP_EOL . Indent::_(1) . "</tr>";
		$head .= PHP_EOL . "</thead>";

		return $head;
	}

	/**
	 * Get the new-record buttons above a linked view table.
	 *
	 * One adds a new record, three closes this record and adds a new one,
	 * and two offers both as a button group.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   int     $addNewButon     Which new-record buttons to add.
	 * @param   string  $refview         The referring view.
	 *
	 * @return  string  The generated buttons, empty when none were asked for.
	 *
	 * @since   6.1.7
	 */
	protected function getNewButtons(string $nameSingleCode, $addNewButon,
		string $refview): string
	{
		// only add new button if set
		if ($addNewButon <= 0)
		{
			return '';
		}

		// set permissions.
		$accessCheck = "\$can->get('" . $this->permission->getGlobal($nameSingleCode, 'core.create') . "')";
		// add a button for new
		$head = '<?php if (' . $accessCheck . '): ?>';
		// make group button if needed
		$tabB = "";
		if ($addNewButon == 2)
		{
			$head .= PHP_EOL . Indent::_(1) . '<div class="btn-group">';
			$tabB = Indent::_(1);
		}
		// add the new buttons
		if ($addNewButon == 1 || $addNewButon == 2)
		{
			$head .= PHP_EOL . $tabB . Indent::_(1)
				. '<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo Text:'
				. ':_(' . "'" . $this->config->lang_prefix . "_NEW'"
				. '); ?></a>';
		}
		// add the close and new button
		if ($addNewButon == 2 || $addNewButon == 3)
		{
			$head .= PHP_EOL . $tabB . Indent::_(1)
				. '<a class="btn btn-small" onclick="Joomla.submitbutton(\''
				. $refview
				. '.cancel\');" href="<?php echo $close_new; ?>"><span class="icon-new"></span> <?php echo Text:'
				. ':_(' . "'" . $this->config->lang_prefix . "_CLOSE_NEW'"
				. '); ?></a>';
		}
		// close group button if needed
		if ($addNewButon == 2)
		{
			$head .= PHP_EOL . Indent::_(1) . '</div><br /><br />';
		}
		else
		{
			$head .= '<br /><br />';
		}

		return $head . PHP_EOL . '<?php endif; ?>' . PHP_EOL;
	}
}

