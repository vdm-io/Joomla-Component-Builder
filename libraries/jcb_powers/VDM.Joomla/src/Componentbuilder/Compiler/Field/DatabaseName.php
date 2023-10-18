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


use VDM\Joomla\Componentbuilder\Compiler\Builder\Lists;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Compiler Field Database Name
 * 
 * @since 3.2.0
 */
class DatabaseName
{
	/**
	 * The Lists Class.
	 *
	 * @var   Lists
	 * @since 3.2.0
	 */
	protected Lists $lists;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Constructor.
	 *
	 * @param Lists      $lists      The Lists Class.
	 * @param Registry   $registry   The Registry Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Lists $lists, Registry $registry)
	{
		$this->lists = $lists;
		$this->registry = $registry;
	}

	/**
	 * get the field database name and AS prefix
	 *
	 * @param   string  $nameListCode  The list view name
	 * @param   int     $fieldId       The field ID
	 * @param   string  $targetArea    The area being targeted
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	public function get(string $nameListCode, int $fieldId, string $targetArea = 'builder.list'): ?string
	{
		if ($targetArea === 'builder.list')
		{
			if (($fields = $this->lists->get($nameListCode)) === null)
			{
				return null;
			}
		}
		elseif (($fields = $this->registry->get("${targetArea}.${nameListCode}")) === null)
		{
			return null;
		}

		if ($fieldId < 0)
		{
			switch ($fieldId)
			{
				case -1:
					return 'a.id';
				case -2:
					return 'a.ordering';
				case -3:
					return 'a.published';
			}
		}

		foreach ($fields as $field)
		{
			if ($field['id'] == $fieldId)
			{
				// now check if this is a category
				if ($field['type'] === 'category')
				{
					return 'c.title';
				}
				// set the custom code
				elseif (ArrayHelper::check(
					$field['custom']
				))
				{
					return $field['custom']['db'] . "."
						. $field['custom']['text'];
				}
				else
				{
					return 'a.' . $field['code'];
				}
			}
		}

		return null;
	}
}

