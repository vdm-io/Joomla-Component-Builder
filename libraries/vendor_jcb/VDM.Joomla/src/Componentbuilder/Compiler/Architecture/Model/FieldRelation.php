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


use VDM\Joomla\Componentbuilder\Compiler\Builder\ListJoin;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Field Relation Class.
 * 
 * Generates the statement that gives a related field its value once a list
 * model has loaded its items. A relation either runs the custom code the
 * field carries, or concatenates the field and every field it joins with a
 * separator between them.
 * 
 * A field may be referenced in that custom code by its numeric id or by its
 * guid, both written as `$item->{...}`, so both spellings are replaced with
 * the real property before the code is emitted.
 * 
 * @since  6.1.7
 */
final class FieldRelation
{
	/**
	 * The List Join Class.
	 *
	 * @var   ListJoin
	 * @since 6.1.7
	 */
	protected ListJoin $listjoin;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param ListJoin      $listjoin      The List Join Class.
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(ListJoin $listjoin, Placeholder $placeholder)
	{
		$this->listjoin = $listjoin;
		$this->placeholder = $placeholder;
	}

	/**
	 * Get the relation statement of one field.
	 *
	 * @param   array   $item          The field definition.
	 * @param   string  $nameListCode  The list view code name.
	 * @param   string  $tab           Extra indentation of the generated lines.
	 *
	 * @return  string  The generated statement.
	 *
	 * @since   6.1.7
	 */
	public function get(array $item, string $nameListCode, string $tab): string
	{
		$fix = '';
		// set fields
		$field_placeholders = [];

		// set list field name
		$field_placeholders['$item->{' . (int) $item['id'] . '}'] = '$item->' . $item['code'];
		$field_placeholders['$item->{' . (string) $item['guid'] . '}'] = '$item->' . $item['code'];
		$field_array[] = '$item->' . $item['code'];

		// load joint field names
		if (isset($item['joinfields'])
			&& ArrayHelper::check(
				$item['joinfields']
			))
		{
			foreach ($item['joinfields'] as $join)
			{
				$join_id = $this->listjoin->get($nameListCode . '.' . (string) $join . '.id', 0);
				$join_string = '$item->' . $this->listjoin->get($nameListCode . '.' . (string) $join . '.code', 'error');

				$field_placeholders['$item->{' . (int) $join_id . '}'] = $join_string;
				$field_placeholders['$item->{' . $join . '}'] = $join_string;
				$field_array[] = $join_string;
			}
		}

		// set based on join_type
		if ((int) $item['join_type'] === 2)
		{
			// code
			$code = (array) explode(
				PHP_EOL, str_replace(
					array_keys($field_placeholders), array_values($field_placeholders), (string) $item['set']
				)
			);
			$fix  .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . implode(
					PHP_EOL . Indent::_(1) . $tab . Indent::_(3), $code
				);
		}
		else
		{
			// concatenate
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
				. Line::_(__Line__, __Class__) . " concatenate these fields";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$item->"
				. $item['code'] . ' = ' . implode(
					" . '" . str_replace("'", '&apos;', (string) $item['set']) . "' . ",
					$field_array
				) . ';';
		}

		return $this->placeholder->update_($fix);
	}
}

