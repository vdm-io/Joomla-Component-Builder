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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ComponentFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MetaData;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Api View Fields Class.
 * 
 * Builds the fields to render of both JSON API views of a view: every column
 * of the table, taken from the component field map the compiler builds, plus
 * the default columns every table carries.
 * 
 * @since 6.1.7
 */
final class Fields
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Component Fields Builder Class.
	 *
	 * @var   ComponentFields
	 * @since 6.1.7
	 */
	protected ComponentFields $componentfields;

	/**
	 * The Access Switch Builder Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The Meta Data Builder Class.
	 *
	 * @var   MetaData
	 * @since 6.1.7
	 */
	protected MetaData $metadata;

	/**
	 * The Field Names Builder Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * Constructor.
	 *
	 * @param Config            $config            The Config Class.
	 * @param ComponentFields   $componentfields   The Component Fields Builder Class.
	 * @param AccessSwitch      $accessswitch      The Access Switch Builder Class.
	 * @param MetaData          $metadata          The Meta Data Builder Class.
	 * @param FieldNames        $fieldnames        The Field Names Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, ComponentFields $componentfields,
		AccessSwitch $accessswitch, MetaData $metadata, FieldNames $fieldnames)
	{
		$this->config = $config;
		$this->componentfields = $componentfields;
		$this->accessswitch = $accessswitch;
		$this->metadata = $metadata;
		$this->fieldnames = $fieldnames;
	}

	/**
	 * Get the fields to render entries of the JSON API views.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 *
	 * @return  string  The array entries, one column per line.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode): string
	{
		$code = '';

		foreach ($this->columns($nameSingleCode) as $column)
		{
			$code .= PHP_EOL . Indent::_(2) . "'" . $column . "',";
		}

		return $code;
	}

	/**
	 * The columns of the view's table.
	 *
	 * The id leads, the view's own fields follow in the order the component
	 * field map holds them, then the default columns the view did not
	 * override, then the meta data columns when the view has them.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 *
	 * @return  array  The column names.
	 * @since   6.1.7
	 */
	public function columns(string $nameSingleCode): array
	{
		$columns = ['id'];
		$fields = $this->componentfields->get($nameSingleCode);

		if (is_array($fields))
		{
			foreach (array_keys($fields) as $column)
			{
				$this->add($columns, (string) $column);
			}
		}

		foreach ($this->config->default_fields as $default)
		{
			$default = (string) $default;

			// the access column exists only when the view has access control
			if ($default === 'access' && !$this->accessswitch->exists($nameSingleCode))
			{
				continue;
			}

			// a default column the view overrides is already in the field map
			if ($this->fieldnames->isString($nameSingleCode . '.' . $default))
			{
				continue;
			}

			$this->add($columns, $default);
		}

		if ($this->metadata->isString($nameSingleCode))
		{
			foreach (['metakey', 'metadesc', 'metadata'] as $column)
			{
				$this->add($columns, $column);
			}
		}

		return $columns;
	}

	/**
	 * Add one column once.
	 *
	 * @param   array   $columns  The columns collected so far.
	 * @param   string  $column   The column to add.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	private function add(array &$columns, string $column): void
	{
		if ($column !== '' && !in_array($column, $columns, true))
		{
			$columns[] = $column;
		}
	}
}

