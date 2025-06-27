<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Field;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;


/**
 * Compiler Field Modal Select
 * 
 * @since 5.1.1
 */
final class ModalSelect
{
	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 5.1.1
	 */
	protected Structure $structure;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 5.1.1
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The switch to ensure the fix is just added once
	 *
	 * @var    bool
	 * @since 5.1.1
	 */
	protected bool $addedFix = false;

	/**
	 * Constructor.
	 *
	 * @param Structure      $structure      The Structure Class.
	 * @param ContentMulti   $contentmulti   The ContentMulti Class.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Structure $structure, ContentMulti $contentmulti)
	{
		$this->structure = $structure;
		$this->contentmulti = $contentmulti;
	}

	/**
	 * Extracts component and view details from field attributes for a Modal Select field.
	 *
	 * @param array  $fieldAttributes The field attributes containing URLs and SQL table details.
	 *
	 * @return array An associative array with extracted component, view, views, table, id, and text.
	 * @since  5.1.2
	 */
	public function extract(array $fieldAttributes): array
	{
		$component = null;
		$views = null;
		$view = null;

		// Extract parameters from the given URL
		$extractParams = function ($url) {
			if (empty($url)) {
				return ['option' => null, 'view' => null];
			}
			$query = parse_url($url, PHP_URL_QUERY);
			parse_str($query, $params);
			return [
				'option' => $params['option'] ?? $params['amp;option'] ?? null,
				'view' => $params['view'] ?? $params['amp;view'] ?? null,
			];
		};

		// Process URL attributes
		foreach (['urlSelect', 'urlEdit', 'urlNew'] as $urlKey)
		{
			$params = $extractParams($fieldAttributes[$urlKey] ?? '');
			$component ??= $params['option'];
			if ($urlKey === 'urlSelect')
			{
				$views ??= $params['view'];
			}
			else
			{
				$view ??= $params['view'];
			}
		}

		// Determine the target table and extract the view name
		$field_target_table = $fieldAttributes['sql_title_table'] ?? '';
		if (!$view && !empty($field_target_table))
		{
			$clean_table = str_replace('__', '', $field_target_table);
			$view = substr($clean_table, strpos($clean_table, '_') + 1);
		}

		$sql_title_key = $fieldAttributes['sql_title_key'] ?? 'id';
		$sql_title_column = $fieldAttributes['sql_title_column'] ?? 'id';

		// if one field is not id, we add an override to the ModalSelectField as a FIX
		if (!$this->addedFix && $sql_title_key !== 'id')
		{
			$this->structure->build(
				['admin' => 'fieldmodalselect_override'],
				'fieldmodalselect_override'
			);
			$this->structure->build(
				['site' => 'fieldmodalselect_override'],
				'fieldmodalselect_override'
			);
			// to make sure the file is updated TODO
			$this->contentmulti->set('fieldmodalselect_override|BLABLA', 'blabla');

			$this->addedFix = true;
		}

		// make sure we have the target view code name
		$view ??= 'error';

		// add the Title Key for the Modal
		$this->contentmulti->set($view . '|SQL_TITLE_KEY', $sql_title_key);

		// add the Title Column for the Modal
		$this->contentmulti->set($view . '|SQL_TITLE_COLUMN', $sql_title_column);

		return [
			'modal_select' => true,
			'urlSelect' => $fieldAttributes['urlSelect'] ?? '',
			'hint' => $fieldAttributes['hint'] ?? '',
			'titleSelect' => $fieldAttributes['titleSelect'] ?? '',
			'iconSelect' => $fieldAttributes['iconSelect'] ?? '',
			'table' => $field_target_table,
			'id' => $sql_title_key,
			'text' => $sql_title_column,
			'component' => $component ?? 'error',
			'view' => $view,
			'views' => $views ?? 'error',
			'button' => false,
			'extends' => ''
		];
	}
}

