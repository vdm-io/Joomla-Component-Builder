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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomList;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\CustomFieldTypeFileInterface as CustomFieldTypeFile;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Custom Query Class.
 * 
 * Adds the selects and joins a list query needs for the custom fields of a
 * view, so a field that stores a foreign id also yields its display text.
 * 
 * Building the query is only half of what this does: every custom field of
 * the view has its field type file written as a side effect, whether or not
 * that field contributes anything to the query.
 * 
 * @since  6.1.7
 */
final class CustomQuery
{
	/**
	 * The Custom Field Class.
	 *
	 * @var   CustomField
	 * @since 6.1.7
	 */
	protected CustomField $customfield;

	/**
	 * The Custom List Class.
	 *
	 * @var   CustomList
	 * @since 6.1.7
	 */
	protected CustomList $customlist;

	/**
	 * The Custom Field Type File Class.
	 *
	 * @var   CustomFieldTypeFile
	 * @since 6.1.7
	 */
	protected CustomFieldTypeFile $customfieldtypefile;

	/**
	 * Constructor.
	 *
	 * @param CustomField           $customfield           The Custom Field Class.
	 * @param CustomList            $customlist            The Custom List Class.
	 * @param CustomFieldTypeFile   $customfieldtypefile   The Custom Field Type File Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(CustomField $customfield, CustomList $customlist,
		CustomFieldTypeFile $customfieldtypefile)
	{
		$this->customfield = $customfield;
		$this->customlist = $customlist;
		$this->customfieldtypefile = $customfieldtypefile;
	}

	/**
	 * Get the custom field selects and joins of a list query.
	 *
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $tab             Extra indentation of the generated lines.
	 * @param   bool    $just_text       Select the display text without its id alias.
	 *
	 * @return  string  The generated query lines, empty when the view has none.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameListCode, string $nameSingleCode,
		string $tab = '', bool $just_text = false): string
	{
		if (!$this->customfield->exists($nameListCode))
		{
			return '';
		}

		$query = "";
		foreach ($this->customfield->get($nameListCode) as $filter)
		{
			// only load this if table is set
			if (($this->customlist->exists($nameSingleCode . '.' . $filter['code'])
					&& isset($filter['custom']['table'])
					&& StringHelper::check($filter['custom']['table'])
					&& $filter['method'] == 0)
				|| ($just_text && isset($filter['custom']['table'])
					&& StringHelper::check($filter['custom']['table'])
					&& $filter['method'] == 0))
			{
				$query .= PHP_EOL . PHP_EOL . Indent::_(2) . $tab . "//"
					. Line::_(__Line__, __Class__) . " From the "
					. StringHelper::safe(
						StringHelper::safe(
							$filter['custom']['table'], 'w'
						)
					) . " table.";
				// we must add some fix for none ID keys (I know this is horrible... but we need it)
				// TODO we assume that all tables in admin has ids
				if ($filter['custom']['id'] !== 'id')
				{
					// we want to at times just have the words and not the ids as well
					if ($just_text)
					{
						$query .= PHP_EOL . Indent::_(2) . $tab
							. "\$query->select(\$db->quoteName(['"
							. $filter['custom']['db'] . "."
							. $filter['custom']['text'] . "','"
							. $filter['custom']['db'] . ".id'],['"
							. $filter['code'] . "','"
							. $filter['code'] . "_id']));";
					}
					else
					{
						$query .= PHP_EOL . Indent::_(2) . $tab
							. "\$query->select(\$db->quoteName(['"
							. $filter['custom']['db'] . "."
							. $filter['custom']['text'] . "','"
							. $filter['custom']['db'] . ".id'],['"
							. $filter['code'] . "_" . $filter['custom']['text']
							. "','" . $filter['code'] . "_id']));";
					}
				}
				else
				{
					// we want to at times just have the words and not the ids as well
					if ($just_text)
					{
						$query .= PHP_EOL . Indent::_(2) . $tab
							. "\$query->select(\$db->quoteName('"
							. $filter['custom']['db'] . "."
							. $filter['custom']['text'] . "','"
							. $filter['code'] . "'));";
					}
					else
					{
						$query .= PHP_EOL . Indent::_(2) . $tab
							. "\$query->select(\$db->quoteName('"
							. $filter['custom']['db'] . "."
							. $filter['custom']['text'] . "','"
							. $filter['code'] . "_" . $filter['custom']['text']
							. "'));";
					}
				}
				$query .= PHP_EOL . Indent::_(2) . $tab
					. "\$query->join('LEFT', \$db->quoteName('"
					. $filter['custom']['table'] . "', '"
					. $filter['custom']['db']
					. "') . ' ON (' . \$db->quoteName('a." . $filter['code']
					. "') . ' = ' . \$db->quoteName('"
					. $filter['custom']['db'] . "."
					. $filter['custom']['id'] . "') . ')');";
			}
			// build the field type file
			$this->customfieldtypefile->set(
				$filter, $nameListCode, $nameSingleCode
			);
		}

		return $query;
	}
}

