<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueGuid;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueKeys;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Utilities\String\TypeHelper;


/**
 * Api Controller Record Id Class.
 * 
 * Builds the getRecordId method of the item API controller: the primary key
 * when the request carries it, else the record resolved through the first
 * unique key of the table the request carries.
 * 
 * @since 6.1.7
 */
final class RecordId
{
	/**
	 * The column types that never carry an index, as the field builders rule.
	 *
	 * @var    array
	 * @since  6.1.7
	 */
	private const TEXT_TYPES = ['TEXT', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT', 'BLOB', 'TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB'];

	/**
	 * The Database Unique Keys Builder Class.
	 *
	 * @var   DatabaseUniqueKeys
	 * @since 6.1.7
	 */
	protected DatabaseUniqueKeys $databaseuniquekeys;

	/**
	 * The Database Unique Guid Builder Class.
	 *
	 * @var   DatabaseUniqueGuid
	 * @since 6.1.7
	 */
	protected DatabaseUniqueGuid $databaseuniqueguid;

	/**
	 * Constructor.
	 *
	 * @param DatabaseUniqueKeys   $databaseuniquekeys   The Database Unique Keys Builder Class.
	 * @param DatabaseUniqueGuid   $databaseuniqueguid   The Database Unique Guid Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(DatabaseUniqueKeys $databaseuniquekeys,
		DatabaseUniqueGuid $databaseuniqueguid)
	{
		$this->databaseuniquekeys = $databaseuniquekeys;
		$this->databaseuniqueguid = $databaseuniqueguid;
	}

	/**
	 * Get the record id resolution code of the item API controller.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 *
	 * @return  string  The get record id method body.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode): string
	{
		$code = [];

		$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " Take the primary key when the request carries it.";
		$code[] = Indent::_(2) . "\$id = \$this->input->getInt('id', 0);";
		$code[] = PHP_EOL . Indent::_(2) . "if (\$id > 0)";
		$code[] = Indent::_(2) . "{";
		$code[] = Indent::_(3) . "return \$id;";
		$code[] = Indent::_(2) . "}";

		$keys = $this->keys($nameSingleCode);

		if ($keys !== [])
		{
			$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " Resolve the record through the first unique key the request carries.";
			$code[] = Indent::_(2) . "foreach (['" . implode("', '", $keys)
				. "'] as \$key)";
			$code[] = Indent::_(2) . "{";
			$code[] = Indent::_(3) . "\$value = \$this->input->getString(\$key, '');";
			$code[] = PHP_EOL . Indent::_(3) . "if (\$value === '')";
			$code[] = Indent::_(3) . "{";
			$code[] = Indent::_(4) . "continue;";
			$code[] = Indent::_(3) . "}";
			$code[] = PHP_EOL . Indent::_(3) . "\$table = \$this->getModel()->getTable();";
			$code[] = PHP_EOL . Indent::_(3) . "if (\$table->load([\$key => \$value]))";
			$code[] = Indent::_(3) . "{";
			$code[] = Indent::_(4) . "return (int) \$table->id;";
			$code[] = Indent::_(3) . "}";
			$code[] = PHP_EOL . Indent::_(3) . "return 0;";
			$code[] = Indent::_(2) . "}";
		}

		$code[] = PHP_EOL . Indent::_(2) . "return 0;";

		return implode(PHP_EOL, $code);
	}

	/**
	 * The unique keys of the view's table a record can be resolved through.
	 *
	 * The guid comes first when the table has one, then every column that
	 * carries a unique index, in the order the view declares them. This reads
	 * the registries the field builders fill, so it answers once the view's
	 * fieldsets are built; the routes, which render before that, read the
	 * same keys from the view's field definitions with keysOfFields().
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 *
	 * @return  array  The key column names.
	 * @since   6.1.7
	 */
	public function keys(string $nameSingleCode): array
	{
		$keys = [];
		$unique = $this->databaseuniquekeys->get($nameSingleCode);

		if (!is_array($unique))
		{
			$unique = [];
		}

		if ($this->databaseuniqueguid->exists($nameSingleCode)
			|| in_array('guid', $unique, true))
		{
			$keys[] = 'guid';
		}

		foreach ($unique as $key)
		{
			$key = (string) $key;

			if ($key !== 'id' && !in_array($key, $keys, true))
			{
				$keys[] = $key;
			}
		}

		return $keys;
	}

	/**
	 * The same keys, read from the field definitions a loaded view carries.
	 *
	 * The plugin routes render while the component data loads, before any
	 * field builder has run, so they cannot read the registries keys() reads.
	 * This applies the rules the field builders apply: a stored column named
	 * guid is the guid, and a stored column with a unique index on a type
	 * that carries an index is a unique key. The column name follows the
	 * field's name attribute, as the field name resolver takes it.
	 *
	 * @param   array  $fields  The fields of the view, as its settings carry them.
	 *
	 * @return  array  The key column names, the guid first.
	 * @since   6.1.7
	 */
	public function keysOfFields(array $fields): array
	{
		$guid = false;
		$unique = [];

		foreach ($fields as $field)
		{
			if (!is_array($field) || !isset($field['settings']) || !is_object($field['settings']))
			{
				continue;
			}

			// a field kept out of the database has no column
			if (isset($field['list']) && (int) $field['list'] === 2)
			{
				continue;
			}

			$column = $this->column($field['settings']);

			if ($column === '' || $column === 'id')
			{
				continue;
			}

			if ($column === 'guid')
			{
				$guid = true;
			}

			$type = strtoupper((string) ($field['settings']->datatype ?? ''));

			if ((int) ($field['settings']->indexes ?? 0) === 1
				&& !in_array($type, self::TEXT_TYPES, true)
				&& $column !== 'guid'
				&& !in_array($column, $unique, true))
			{
				$unique[] = $column;
			}
		}

		return $guid ? array_merge(['guid'], $unique) : $unique;
	}

	/**
	 * The column name of a field, as the field name resolver takes it.
	 *
	 * @param   object  $settings  The field settings.
	 *
	 * @return  string  The column name, empty when the field has none.
	 * @since   6.1.7
	 */
	private function column(object $settings): string
	{
		$xml = (string) ($settings->xml ?? '');
		$name = $xml !== '' ? (string) GetHelper::between($xml, 'name="', '"') : '';

		if ($name === '')
		{
			$name = (string) ($settings->name ?? '');
		}

		if ($name === '')
		{
			return '';
		}

		// a category field stores its id under catid unless it names a request id
		if (TypeHelper::safe((string) ($settings->type_name ?? '')) === 'category'
			&& strpos($name, '_request_id') === false
			&& strpos($name, '_request_catid') === false)
		{
			return 'catid';
		}

		return (string) FieldHelper::safe($name);
	}
}

