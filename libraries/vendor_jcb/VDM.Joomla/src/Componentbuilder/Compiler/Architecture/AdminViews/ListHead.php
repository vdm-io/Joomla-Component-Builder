<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListColumnNumber;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListHeadOverride;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Lists;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListHeadInterface;


/**
 * Admin List View Head Class.
 * 
 * Generates the table head of an admin list view: the ordering and
 * check-all controls, one sortable or static heading per listed field,
 * and the status and id headings. While building it records the number
 * of rendered columns so the list footer can span them.
 * 
 * The shared implementation emits the modern sorting guard, which also
 * excludes modal layouts; the Joomla 3 variant overrides it.
 * 
 * @since  6.1.7
 */
class ListHead implements ListHeadInterface
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
	 * The AdminFilterType Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The FieldNames Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * The ListHeadOverride Class.
	 *
	 * @var   ListHeadOverride
	 * @since 6.1.7
	 */
	protected ListHeadOverride $listheadoverride;

	/**
	 * The ListColumnNumber Class.
	 *
	 * @var   ListColumnNumber
	 * @since 6.1.7
	 */
	protected ListColumnNumber $listcolumnnumber;

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param Language           $language           The Language Class.
	 * @param Lists              $lists              The Lists Class.
	 * @param AdminFilterType    $adminfiltertype    The AdminFilterType Class.
	 * @param FieldNames         $fieldnames         The FieldNames Class.
	 * @param ListHeadOverride   $listheadoverride   The ListHeadOverride Class.
	 * @param ListColumnNumber   $listcolumnnumber   The ListColumnNumber Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Language $language, Lists $lists,
		AdminFilterType $adminfiltertype, FieldNames $fieldnames,
		ListHeadOverride $listheadoverride, ListColumnNumber $listcolumnnumber)
	{
		$this->config = $config;
		$this->language = $language;
		$this->lists = $lists;
		$this->adminfiltertype = $adminfiltertype;
		$this->fieldnames = $fieldnames;
		$this->listheadoverride = $listheadoverride;
		$this->listcolumnnumber = $listcolumnnumber;
	}

	/**
	 * Get the admin list view table head.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  string  The generated table head, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode): string
	{
		if (($items = $this->lists->get($nameListCode)) !== null)
		{
			// set the Html values based on filter type
			$jhtml_sort        = "grid.sort";
			$jhtml_sort_icon   = "<i class=\"icon-menu-2\"></i>";
			$jhtml_sort_icon_2 = "";
			// for the new filter (2 = topbar)
			if ($this->adminfiltertype->get($nameListCode, 1) == 2)
			{
				$jhtml_sort        = "searchtools.sort";
				$jhtml_sort_icon   = "";
				$jhtml_sort_icon_2 = ", 'icon-menu-2'";
			}
			$allowSortingWhen = $this->getSortingGuard();
			// main lang prefix
			$langView = $this->config->lang_prefix . '_'
				. StringHelper::safe($nameSingleCode, 'U');
			// set status lang
			$statusLangName = $langView . '_STATUS';
			// set id lang
			$idLangName = $langView . '_ID';
			// add to lang array
			$this->language->set($this->config->lang_target, $statusLangName, 'Status');
			// add to lang array
			$this->language->set($this->config->lang_target, $idLangName, 'Id');
			// set default
			$head = '<tr>';
			$head .= PHP_EOL . Indent::_(1) . $allowSortingWhen;
			if (!$this->fieldnames->isString($nameSingleCode . '.ordering'))
			{
				$head .= PHP_EOL . Indent::_(2)
					. '<th width="1%" class="nowrap center hidden-phone">';
				$head .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('" . $jhtml_sort . "', '"
					. $jhtml_sort_icon . "'"
					. ", 'a.ordering', \$this->listDirn, \$this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'"
					. $jhtml_sort_icon_2 . "); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
			}
			$head .= PHP_EOL . Indent::_(2)
				. '<th width="20" class="nowrap center">';
			$head .= PHP_EOL . Indent::_(3)
				. "<?php echo Html::_('grid.checkall'); ?>";
			$head .= PHP_EOL . Indent::_(2) . "</th>";
			$head .= PHP_EOL . Indent::_(1) . "<?php else: ?>";
			$head .= PHP_EOL . Indent::_(2)
				. '<th width="20" class="nowrap center hidden-phone">';
			$head .= PHP_EOL . Indent::_(3) . "&#9662;";
			$head .= PHP_EOL . Indent::_(2) . "</th>";
			$head .= PHP_EOL . Indent::_(2)
				. '<th width="20" class="nowrap center">';
			$head .= PHP_EOL . Indent::_(3) . "&#9632;";
			$head .= PHP_EOL . Indent::_(2) . "</th>";
			$head .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
			// set footer Column number
			$this->listcolumnnumber->set($nameListCode, 4);
			// build the dynamic fields
			foreach ($items as $item)
			{
				// check if target is admin list
				if (1 == $item['target'] || 3 == $item['target'])
				{
					// check if we have an over-ride
					if (($list_head_override = $this->listheadoverride->
						get($nameListCode . '.' . $item['guid'])) !== null)
					{
						$item['lang'] = $list_head_override;
					}
					$class = 'nowrap hidden-phone';
					if ($item['link'])
					{
						$class = 'nowrap';
					}
					// add sort options if required
					if ($item['sort'])
					{
						// if category
						if ($item['type'] === 'category')
						{
							// only one category per/view allowed at this point
							$title = "<?php echo Html::_('" . $jhtml_sort
								. "', '"
								. $item['lang'] . "', 'category_title"
								. "', \$this->listDirn, \$this->listOrder); ?>";
						}
						// set the custom code
						elseif (ArrayHelper::check(
							$item['custom']
						))
						{
							// keep an eye on this
							$title = "<?php echo Html::_('" . $jhtml_sort
								. "', '" . $item['lang'] . "', '" . $item['custom']['db']
								. "." . $item['custom']['text']
								. "', \$this->listDirn, \$this->listOrder); ?>";
						}
						else
						{
							$title = "<?php echo Html::_('" . $jhtml_sort
								. "', '" . $item['lang'] . "', 'a." . $item['code']
								. "', \$this->listDirn, \$this->listOrder); ?>";
						}
					}
					else
					{
						$title = "<?php echo Joomla__" . "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('" . $item['lang'] . "'); ?>";
					}
					$head .= PHP_EOL . Indent::_(1) . '<th class="' . $class . '" >';
					$head .= PHP_EOL . Indent::_(3) . $title;
					$head .= PHP_EOL . Indent::_(1) . "</th>";
					$this->listcolumnnumber->increment($nameListCode);
				}
			}
			// set default
			if (!$this->fieldnames->isString($nameSingleCode . '.published'))
			{
				$head .= PHP_EOL . Indent::_(1)
					. "<?php if (\$this->canState): ?>";
				$head .= PHP_EOL . Indent::_(2)
					. '<th width="10" class="nowrap center" >';
				$head .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('" . $jhtml_sort . "', '"
					. $statusLangName
					. "', 'a.published', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
				$head .= PHP_EOL . Indent::_(1) . "<?php else: ?>";
				$head .= PHP_EOL . Indent::_(2)
					. '<th width="10" class="nowrap center" >';
				$head .= PHP_EOL . Indent::_(3) . "<?php echo Joomla__" . "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
					. $statusLangName . "'); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
				$head .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
			}
			if (!$this->fieldnames->isString($nameSingleCode . '.id'))
			{
				$head .= PHP_EOL . Indent::_(1)
					. '<th width="5" class="nowrap center hidden-phone" >';
				$head .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('" . $jhtml_sort . "', '"
					. $idLangName
					. "', 'a.id', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL . Indent::_(1) . "</th>";
			}
			$head .= PHP_EOL . "</tr>";

			return $head;
		}

		return '';
	}

	/**
	 * Get the generated guard around the sorting and check-all controls.
	 *
	 * From Joomla 4 the controls are also hidden inside a modal layout.
	 *
	 * @return  string  The generated guard.
	 *
	 * @since   6.1.7
	 */
	protected function getSortingGuard(): string
	{
		return "<?php if (!\$this->isModal && \$this->canEdit && \$this->canState): ?>";
	}
}

