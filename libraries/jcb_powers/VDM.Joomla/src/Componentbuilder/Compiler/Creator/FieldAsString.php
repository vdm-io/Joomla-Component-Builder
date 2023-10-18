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


use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldDynamic;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Xml;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Get any field as a string Creator Class
 * 
 * @since 3.2.0
 */
final class FieldAsString
{
	/**
	 * The FieldDynamic Class.
	 *
	 * @var   FieldDynamic
	 * @since 3.2.0
	 */
	protected FieldDynamic $fielddynamic;

	/**
	 * The Xml Class.
	 *
	 * @var   Xml
	 * @since 3.2.0
	 */
	protected Xml $xml;

	/**
	 * Constructor.
	 *
	 * @param FieldDynamic   $fielddynamic   The FieldDynamic Class.
	 * @param Xml            $xml            The Xml Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(FieldDynamic $fielddynamic, Xml $xml)
	{
		$this->fielddynamic = $fielddynamic;
		$this->xml = $xml;
	}

	/**
	 * Get field as a string (no matter the build type)
	 *
	 * @param   array    $field           The field data
	 * @param   array    $view            The view data
	 * @param   int      $viewType        The view type
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   array    $placeholders    The placeholder and replace values
	 * @param   string   $dbkey           The custom table key
	 * @param   boolean  $build           The switch to set the build option
	 *
	 * @return  string  The complete field in xml-string
	 * @since 3.2.0
	 */
	public function get(array &$field, array &$view, int $viewType, string $langView,
		string $nameSingleCode, string $nameListCode, array &$placeholders,
		string &$dbkey, bool $build = false): string
	{
		// get field
		$field_xml = $this->fielddynamic->get(
			$field, $view, $viewType, $langView,
			$nameSingleCode, $nameListCode,
			$placeholders, $dbkey, $build
		);

		if (is_string($field_xml))
		{
			return $field_xml;
		}
		elseif (is_object($field_xml) && isset($field_xml->fieldXML))
		{
			return PHP_EOL . Indent::_(2) . "<!--"
				. Line::_(__Line__, __Class__) . " "
				. $field_xml->comment . ' -->' . PHP_EOL
				. Indent::_(1) . $this->xml->pretty(
					$field_xml->fieldXML, 'field'
				);
		}

		return '';
	}
}

