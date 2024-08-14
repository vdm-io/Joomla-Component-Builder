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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldsetDynamic;


/**
 * Extension Fieldset Creator Class
 * 
 * @since 5.0.2
 */
final class FieldsetExtension
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.0.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The FieldsetDynamic Class.
	 *
	 * @var   FieldsetDynamic
	 * @since 5.0.2
	 */
	protected FieldsetDynamic $fieldsetdynamic;

	/**
	 * Constructor.
	 *
	 * @param Placeholder       $placeholder       The Placeholder Class.
	 * @param FieldsetDynamic   $fieldsetdynamic   The Fieldset Dynamic Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Placeholder $placeholder, FieldsetDynamic $fieldsetdynamic)
	{
		$this->placeholder = $placeholder;
		$this->fieldsetdynamic = $fieldsetdynamic;
	}

	/**
	 * build field set for an extention
	 *
	 * @param   object  $extension  The extention object
	 * @param   array   $fields     The fields to build
	 * @param   string  $dbkey      The database key
	 *
	 * @return  string The fields set in xml
	 *
	 * @since 5.0.2
	 */
	public function get(object $extension, array $fields, string $dbkey = 'zz'): string
	{
		// get global placeholders
		$placeholder = $this->placeholder->get();
		// build the fieldset
		return $this->fieldsetdynamic->get(
			$fields, $extension->lang_prefix, $extension->key, $extension->key,
			$placeholder, $dbkey
		);
	}
}

