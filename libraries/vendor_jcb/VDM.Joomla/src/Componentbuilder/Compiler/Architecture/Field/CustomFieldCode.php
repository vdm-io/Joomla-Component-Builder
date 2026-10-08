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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Field;


use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Custom Field Code Class.
 * 
 * Collects the PHP a custom field type carries, split into the code that
 * belongs above the generated class and the code that belongs inside it.
 * 
 * The collected code is the same on every Joomla target, so this is one class.
 * 
 * @since  6.1.7
 */
final class CustomFieldCode
{
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
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder)
	{
		$this->placeholder = $placeholder;
	}

	/**
	 * Get the PHP a custom field type carries.
	 *
	 * This is just to get the code. Don't use this to build the field.
	 *
	 * @param   array  $custom  The field complete data set.
	 *
	 * @return  array  The header and class code buckets.
	 *
	 * @since   6.1.7
	 */
	public function get($custom)
	{
		// the code bucket
		$code_bucket = array(
			'JFORM_TYPE_HEADER' => '',
			'JFORM_TYPE_PHP'    => ''
		);
		// set tab and break replacements
		$tabBreak = array(
			'\t' => Indent::_(1),
			'\n' => PHP_EOL
		);
		// load the other PHP options
		foreach (ComponentbuilderHelper::$phpFieldArray as $x)
		{
			// reset the php bucket
			$phpBucket = '';
			// only set if available
			if (isset($custom['php' . $x])
				&& ArrayHelper::check(
					$custom['php' . $x]
				))
			{
				foreach ($custom['php' . $x] as $line => $code)
				{
					if (StringHelper::check($code))
					{
						$phpBucket .= PHP_EOL . $this->placeholder->update(
								$code, $tabBreak
							);
					}
				}
				// check if this is header text
				if ('HEADER' === $x)
				{
					$code_bucket['JFORM_TYPE_HEADER']
						.= PHP_EOL . $phpBucket;
				}
				else
				{
					// JFORM_TYPE_PHP <<<DYNAMIC>>>
					$code_bucket['JFORM_TYPE_PHP']
						.= PHP_EOL . $phpBucket;
				}
			}
		}

		return $code_bucket;
	}
}

