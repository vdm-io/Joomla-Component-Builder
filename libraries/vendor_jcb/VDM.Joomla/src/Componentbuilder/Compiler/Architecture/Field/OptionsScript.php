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


use VDM\Joomla\Componentbuilder\Compiler\Field\Groups as FieldGroups;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Field Options Script Class.
 * 
 * Reads the options a watched field declares into the bucket the condition
 * test is built from: a selection field yields its option values, and a text
 * field yields the keywords and the length its options name.
 * 
 * @since  6.1.7
 */
final class OptionsScript
{
	/**
	 * The Field Groups Class.
	 *
	 * @var   FieldGroups
	 * @since 6.1.7
	 */
	protected FieldGroups $fieldgroups;

	/**
	 * Constructor.
	 *
	 * @param FieldGroups  $fieldgroups  The Field Groups Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(FieldGroups $fieldgroups)
	{
		$this->fieldgroups = $fieldgroups;
	}

	/**
	 * Read the options a watched field declares.
	 *
	 * Both arguments stay untyped. The options are whatever the condition
	 * declared, which the first guard tests rather than assumes, and the type
	 * is not guaranteed by the caller either. A field that is neither a
	 * selection nor a text field yields an empty bucket, and the condition test
	 * built over it then tests presence instead.
	 *
	 * @param   mixed  $type     The type of the field being watched.
	 * @param   mixed  $options  The options the field declares.
	 *
	 * @return  array  The option values, or the keywords and length of a text field.
	 *
	 * @since   6.1.7
	 */
	public function get($type, $options): array
	{
		$buket = [];
		if (StringHelper::check($options))
		{
			if ($this->fieldgroups->check($type, 'list')
				|| $this->fieldgroups->check($type, 'dynamic')
				|| !$this->fieldgroups->check($type))
			{
				$optionsArray = array_map(
					'trim', (array) explode(PHP_EOL, (string) $options)
				);
				if (!ArrayHelper::check($optionsArray))
				{
					$optionsArray[] = $optionsArray;
				}
				foreach ($optionsArray as $option)
				{
					if (strpos($option, '|') !== false)
					{
						list($option) = array_map(
							'trim', (array) explode('|', $option)
						);
					}
					if ($option != 'dynamic_list')
					{
						// add option to return buket
						$buket[] = $option;
					}
				}
			}
			elseif ($this->fieldgroups->check($type, 'text'))
			{
				// check to get the key words if set
				$keywords = GetHelper::between(
					$options, 'keywords="', '"'
				);
				if (StringHelper::check($keywords))
				{
					if (strpos((string) $keywords, ',') !== false)
					{
						$keywords = array_map(
							'trim', (array) explode(',', (string) $keywords)
						);
						foreach ($keywords as $keyword)
						{
							$buket['keywords'][] = trim($keyword);
						}
					}
					else
					{
						$buket['keywords'][] = trim((string) $keywords);
					}
				}
				// check to ket string length if set
				$length = GetHelper::between(
					$options, 'length="', '"'
				);
				if (StringHelper::check($length))
				{
					$buket['length'] = $length;
				}
				else
				{
					$buket['length'] = false;
				}
			}
		}

		return $buket;
	}
}

