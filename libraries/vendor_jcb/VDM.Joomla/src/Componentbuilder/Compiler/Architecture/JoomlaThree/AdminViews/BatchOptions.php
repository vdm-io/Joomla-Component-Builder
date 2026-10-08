<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\BatchOptionsInterface;


/**
 * Joomla 3 Admin Views Batch Options Class.
 * 
 * Builds the statements a Joomla 3 list view runs to offer its batch options:
 * the state and access options every view has, the category option of a view
 * that has categories, and one for every other filter field the view was
 * given.
 * 
 * @since 6.1.7
 */
final class BatchOptions implements BatchOptionsInterface
{
	/**
	 * The Admin Filter Type Builder Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The Filter Builder Class.
	 *
	 * @var   Filter
	 * @since 6.1.7
	 */
	protected Filter $filter;

	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Access Switch Builder Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The Field Names Builder Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * The Category Builder Class.
	 *
	 * @var   Category
	 * @since 6.1.7
	 */
	protected Category $category;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * Constructor.
	 *
	 * @param AdminFilterType $adminfiltertype The Admin Filter Type Builder Class.
	 * @param Filter          $filter          The Filter Builder Class.
	 * @param ContentOne      $contentone      The Content One Builder Class.
	 * @param AccessSwitch    $accessswitch    The Access Switch Builder Class.
	 * @param FieldNames      $fieldnames      The Field Names Builder Class.
	 * @param Category        $category        The Category Builder Class.
	 * @param Component       $component       The Component Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(AdminFilterType $adminfiltertype,
		Filter $filter,
		ContentOne $contentone,
		AccessSwitch $accessswitch,
		FieldNames $fieldnames,
		Category $category,
		Component $component)
	{
		$this->adminfiltertype = $adminfiltertype;
		$this->filter = $filter;
		$this->contentone = $contentone;
		$this->accessswitch = $accessswitch;
		$this->fieldnames = $fieldnames;
		$this->category = $category;
		$this->component = $component;
	}

	/**
	 * Build the statements a list view runs to offer its batch options.
	 *
	 * The state and access options every view has, the category option of a view
	 * with categories, and one for every other filter field the view was given.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The statements, or nothing when the view asks for none.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		// start the batch bucket
		$fieldBatch = [];
		// add the default batch
		$this->addDefaultOptions($fieldBatch, $nameSingleCode);
		// add the category filter stuff
		$this->addCategoryOption($fieldBatch, $nameListCode);
		// check if we have other batch options to add
		if ($this->filter->exists($nameListCode))
		{
			// check if we should add some help to get the values (2 = topbar)
			$get_values = false;
			if ($this->adminfiltertype->get($nameListCode, 1) == 2)
			{
				// since the old path is not used, we need to add those values here
				$get_values = true;
			}
			// get component name
			$Component = $this->contentone->get('Component');
			// load the rest of the batch options
			foreach ($this->filter->get($nameListCode) as $filter)
			{
				if ($filter['type'] != 'category'
					&& ArrayHelper::check($filter['custom'])
					&& $filter['custom']['extends'] !== 'user')
				{
					$CodeName     = StringHelper::safe(
						$filter['code'] . ' ' . $filter['custom']['text'], 'W'
					);
					$codeName     = $filter['code']
						. StringHelper::safe(
							$filter['custom']['text'], 'F'
						);
					$fieldBatch[] = PHP_EOL . Indent::_(2)
						. "//" . Line::_(__Line__, __Class__)
						. " Only load " . $CodeName
						. " batch if create, edit, and batch is allowed";
					$fieldBatch[] = Indent::_(2)
						. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$fieldBatch[] = Indent::_(2) . "{";
					// add the get values here
					if ($get_values)
					{
						$type         = StringHelper::safe(
							$filter['custom']['type'], 'F'
						);
						$fieldBatch[] = Indent::_(3) . "//"
							. Line::_(__Line__, __Class__) . " Set " . $CodeName
							. " Selection";
						$fieldBatch[] = Indent::_(3) . "\$this->" . $codeName
							. "Options = FormHelper::loadFieldType('" . $type
							. "')->options;";
						$fieldBatch[] = Indent::_(3) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " We do some sanitation for " . $CodeName
							. " filter";
						$fieldBatch[] = Indent::_(3) . "if ("
							. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $codeName
							. "Options) &&";
						$fieldBatch[] = Indent::_(4) . "isset(\$this->"
							. $codeName
							. "Options[0]->value) &&";
						$fieldBatch[] = Indent::_(4) . "!"
							. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $codeName
							. "Options[0]->value))";
						$fieldBatch[] = Indent::_(3) . "{";
						$fieldBatch[] = Indent::_(4) . "unset(\$this->"
							. $codeName
							. "Options[0]);";
						$fieldBatch[] = Indent::_(3) . "}";
					}
					$fieldBatch[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $CodeName . " Batch Selection";
					$fieldBatch[] = Indent::_(3)
						. "JHtmlBatch_::addListSelection(";
					$fieldBatch[] = Indent::_(4) . "'- Keep Original '.Text:"
						. ":_('" . $filter['lang'] . "').' -',";
					$fieldBatch[] = Indent::_(4) . "'batch[" . $filter['code']
						. "]',";
					$fieldBatch[] = Indent::_(4)
						. "Html::_('select.options', \$this->" . $codeName
						. "Options, 'value', 'text')";
					$fieldBatch[] = Indent::_(3) . ");";
					$fieldBatch[] = Indent::_(2) . "}";
				}
				elseif ($filter['type'] != 'category')
				{
					$CodeName = StringHelper::safe(
						$filter['code'], 'W'
					);

					$fieldBatch[] = PHP_EOL . Indent::_(2)
						. "//" . Line::_(__Line__, __Class__)
						. " Only load " . $CodeName
						. " batch if create, edit, and batch is allowed";
					$fieldBatch[] = Indent::_(2)
						. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$fieldBatch[] = Indent::_(2) . "{";
					// add the get values here
					if ($get_values)
					{
						$fieldBatch[] = Indent::_(3) . "//"
							. Line::_(__Line__, __Class__) . " Set " . $CodeName
							. " Selection";
						$fieldBatch[] = Indent::_(3) . "\$this->"
							. $filter['code']
							. "Options = FormHelper::loadFieldType('"
							. $filter['filter_type']
							. "')->options;";
						$fieldBatch[] = Indent::_(3) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " We do some sanitation for " . $CodeName
							. " filter";
						$fieldBatch[] = Indent::_(3) . "if ("
							. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $filter['code']
							. "Options) &&";
						$fieldBatch[] = Indent::_(4) . "isset(\$this->"
							. $filter['code'] . "Options[0]->value) &&";
						$fieldBatch[] = Indent::_(4) . "!"
							. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $filter['code']
							. "Options[0]->value))";
						$fieldBatch[] = Indent::_(3) . "{";
						$fieldBatch[] = Indent::_(4) . "unset(\$this->"
							. $filter['code'] . "Options[0]);";
						$fieldBatch[] = Indent::_(3) . "}";
					}
					$fieldBatch[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $CodeName . " Batch Selection";
					$fieldBatch[] = Indent::_(3)
						. "JHtmlBatch_::addListSelection(";
					$fieldBatch[] = Indent::_(4) . "'- Keep Original '.Text:"
						. ":_('" . $filter['lang'] . "').' -',";
					$fieldBatch[] = Indent::_(4) . "'batch[" . $filter['code']
						. "]',";
					$fieldBatch[] = Indent::_(4)
						. "Html::_('select.options', \$this->"
						. $filter['code'] . "Options, 'value', 'text')";
					$fieldBatch[] = Indent::_(3) . ");";
					$fieldBatch[] = Indent::_(2) . "}";
				}
			}
		}
		// did we find batch options
		if (ArrayHelper::check($fieldBatch))
		{
			// return the batch
			return PHP_EOL . implode(PHP_EOL, $fieldBatch);
		}

		return '';
	}
	/**
	 * add default batch helper
	 *
	 * @param   array   $batch           The batch code array
	 * @param   string  $nameSingleCode  The single view name
	 *
	 * @return  void
	 *
	 *
	 * @since   3.2.0
	 */
	protected function addDefaultOptions(&$batch, &$nameSingleCode)
	{
		// set component name
		$COPMONENT = $this->component->get('name_code');
		$COPMONENT = StringHelper::safe(
			$COPMONENT, 'U'
		);
		// set batch
		$batch[] = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__Line__, __Class__)
			. " Only load published batch if state and batch is allowed";
		$batch[] = Indent::_(2)
			. "if (\$this->canState && \$this->canBatch)";
		$batch[] = Indent::_(2) . "{";
		$batch[] = Indent::_(3) . "JHtmlBatch_::addListSelection(";
		$batch[] = Indent::_(4) . "Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('COM_" . $COPMONENT
			. "_KEEP_ORIGINAL_STATE'),";
		$batch[] = Indent::_(4) . "'batch[published]',";
		$batch[] = Indent::_(4)
			. "Html::_('select.options', Html::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)";
		$batch[] = Indent::_(3) . ");";
		$batch[] = Indent::_(2) . "}";
		// check if view has access
		if ($this->accessswitch->exists($nameSingleCode)
			&& !$this->fieldnames->isString($nameSingleCode . '.access'))
		{
			$batch[] = PHP_EOL . Indent::_(2)
				. "//" . Line::_(__Line__, __Class__)
				. " Only load access batch if create, edit and batch is allowed";
			$batch[] = Indent::_(2)
				. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
			$batch[] = Indent::_(2) . "{";
			$batch[] = Indent::_(3) . "JHtmlBatch_::addListSelection(";
			$batch[] = Indent::_(4) . "Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('COM_" . $COPMONENT
				. "_KEEP_ORIGINAL_ACCESS'),";
			$batch[] = Indent::_(4) . "'batch[access]',";
			$batch[] = Indent::_(4)
				. "Html::_('select.options', Html::_('access.assetgroups'), 'value', 'text')";
			$batch[] = Indent::_(3) . ");";
			$batch[] = Indent::_(2) . "}";
		}
	}
	/**
	 * build category batch helper
	 *
	 * @param   array   $batch         The batch code array
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  mixed The php to place in view.html.php
	 *
	 *
	 * @since   3.2.0
	 */
	protected function addCategoryOption(&$batch, &$nameListCode)
	{
		if ($this->category->exists("{$nameListCode}.extension"))
		{
			// set component name
			$COPMONENT = $this->component->get('name_code');
			$COPMONENT = StringHelper::safe($COPMONENT, 'U');
			// set filter
			$batch[] = PHP_EOL . Indent::_(2)
				. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
			$batch[] = Indent::_(2) . "{";
			$batch[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Category Batch selection.";
			$batch[] = Indent::_(3) . "JHtmlBatch_::addListSelection(";
			$batch[] = Indent::_(4) . "Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('COM_" . $COPMONENT
				. "_KEEP_ORIGINAL_CATEGORY'),";
			$batch[] = Indent::_(4) . "'batch[category]',";
			$batch[] = Indent::_(4)
				. "Html::_('select.options', Html::_('category.options', '"
				. $this->category->get("{$nameListCode}.extension")
				. "'), 'value', 'text')";
			$batch[] = Indent::_(3) . ");";
			$batch[] = Indent::_(2) . "}";
		}
	}
}

