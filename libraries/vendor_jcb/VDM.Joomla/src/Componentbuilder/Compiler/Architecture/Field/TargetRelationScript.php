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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Field;


use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Field Target Relation Script Class.
 * 
 * Chains a form condition to the other conditions of the same view that steer
 * one of its target fields, so the fields they share are decided by one
 * javascript function instead of several that overwrite each other.
 * 
 * The pairs already claimed for a target are remembered for the length of the
 * build, because a pair may only be chained once: the second condition to
 * reach the same target through the same match is not chained again.
 * 
 * @since  6.1.7
 */
final class TargetRelationScript
{
	/**
	 * The match pair already claimed for each target field of a view.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $targetRelationControl = [];

	/**
	 * Find the conditions of this view that steer the same target fields.
	 *
	 * @param   array   $relations  Every condition the view declares.
	 * @param   array   $condition  The condition being chained.
	 * @param   string  $view       The single view code name.
	 *
	 * @return  array  The conditions chained to this one, which may be none.
	 *
	 * @since   6.1.7
	 */
	public function get(array $relations, array $condition, string $view): array
	{
		// reset the buket
		$buket = [];
		// convert to name array
		foreach ($condition['target_field'] as $targetField)
		{
			if (ArrayHelper::check($targetField)
				&& isset($targetField['name']))
			{
				$currentTargets[] = $targetField['name'];
			}
		}
		// start the search
		foreach ($relations as $relation)
		{
			// reset found
			$found = false;
			// chain only none matching fields
			if ($relation['match_field'] !== $condition['match_field']
				&& $relation['target_relation']) // Made this change to see if it improves the expected result (TODO)
			{
				if (ArrayHelper::check(
					$relation['target_field']
				))
				{
					foreach ($relation['target_field'] as $target)
					{
						if (ArrayHelper::check($target)
							&& $this->checkControl(
								$target['name'], $relation['match_name'],
								$condition['match_name'], $view
							))
						{
							if (in_array($target['name'], $currentTargets))
							{
								$this->targetRelationControl[$view][$target['name']]
									= array($relation['match_name'],
									$condition['match_name']);
								$found = true;
								break;
							}
						}
					}
					if ($found)
					{
						$buket[] = $relation;
					}
				}
			}
		}

		return $buket;
	}

	/**
	 * Test whether this target may still be claimed by this pair of matches.
	 *
	 * The two match names stay untyped: they are compared loosely against what
	 * a previous claim recorded, exactly as they always were, and a declaration
	 * would put a cast in front of that comparison.
	 *
	 * @param   string  $targetName          The name of the target field.
	 * @param   mixed   $relationMatchName   The name the chained condition matches on.
	 * @param   mixed   $conditionMatchName  The name the condition being chained matches on.
	 * @param   string  $view                The single view code name.
	 *
	 * @return  bool  True when the target is free, or free of this pair.
	 *
	 * @since   6.1.7
	 */
	public function checkControl(string $targetName, $relationMatchName,
		$conditionMatchName, string $view): bool
	{
		if (isset($this->targetRelationControl[$view])
			&& ArrayHelper::check(
				$this->targetRelationControl[$view]
			))
		{
			if (isset($this->targetRelationControl[$view][$targetName])
				&& ArrayHelper::check(
					$this->targetRelationControl[$view][$targetName]
				))
			{
				if (!in_array(
						$relationMatchName,
						$this->targetRelationControl[$view][$targetName]
					)
					|| !in_array(
						$conditionMatchName,
						$this->targetRelationControl[$view][$targetName]
					))
				{
					return true;
				}
			}
			else
			{
				return true;
			}
		}
		elseif (!isset($this->targetRelationControl[$view])
			|| !ArrayHelper::check(
				$this->targetRelationControl[$view]
			))
		{
			return true;
		}

		return false;
	}
}

