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


use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreRuleInterface as CoreRule;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Compiler Field Rules
 * 
 * @since 3.2.0
 */
class Rule
{
	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Gui Class.
	 *
	 * @var   Gui
	 * @since 3.2.0
	 */
	protected Gui $gui;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The CoreRuleInterface Class.
	 *
	 * @var   CoreRule
	 * @since 3.2.0
	 */
	protected CoreRule $corerule;

	/**
	 * Constructor.
	 *
	 * @param Registry      $registry      The Registry Class.
	 * @param Customcode    $customcode    The Customcode Class.
	 * @param Gui           $gui           The Gui Class.
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param CoreRule      $corerule      The CoreRuleInterface Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Registry $registry, Customcode $customcode, Gui $gui,
		Placeholder $placeholder, CoreRule $corerule)
	{
		$this->registry = $registry;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->placeholder = $placeholder;
		$this->corerule = $corerule;
	}

	/**
	 * Set the validation rule
	 *
	 * @param   int       $id      The field id
	 * @param   string  $field  The field string
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function set(int $id, string $field)
	{
		// check if we have validate (validation rule set)
		$validation_rule = GetHelper::between(
			$field, 'validate="', '"'
		);

		if (StringHelper::check($validation_rule))
		{
			// make sure it is lowercase
			$validation_rule = StringHelper::safe(
				$validation_rule
			);

			// link this field to this validation (don't move this down)
			$this->registry->set("validation.linked.${id}", $validation_rule);

			// make sure it is not already set
			if ($this->registry->get("validation.rules.${validation_rule}") === null)
			{
				// get joomla core validation names  and make sure this rule is not a core validation rule
				if (!in_array($validation_rule, (array) $this->corerule->get(true)))
				{
					// get the class methods for this rule if it exists
					if (($php_code = GetHelper::var(
						'validation_rule', $validation_rule, 'name', 'php'
					)) !== false)
					{
						// open and set the validation rule
						$this->registry->set("validation.rules.${validation_rule}",
							$this->gui->set(
								$this->placeholder->update_(
									$this->customcode->update(
										base64_decode(
											(string) $php_code
										)
									)
								),
								array(
									'table' => 'validation_rule',
									'field' => 'php',
									'id'    => GetHelper::var(
										'validation_rule',
										$validation_rule, 'name', 'id'
									),
									'type'  => 'php'
								)
							)
						);
					}
					else
					{
						// TODO set the notice that this validation rule is custom and was not found
						$this->registry->remove("validation.linked.${id}");
					}
				}
				else
				{
					// remove link (we only want custom validations linked)
					$this->registry->remove("validation.linked.${id}");
				}
			}
		}
	}
}

