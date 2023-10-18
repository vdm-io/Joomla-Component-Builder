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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Utilities\FormHelper;


/**
 * Compiler Utilities Xml
 * 
 * @since 3.2.0
 */
final class Xml
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor
	 *
	 * @param Config|null           $config     The compiler config object.
	 * @param CMSApplication|null   $app        The CMS Application object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?CMSApplication $app = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * get the field xml
	 *
	 * @param   array      $attributes   The array of attributes
	 * @param   array      $options      The options to apply to the XML element
	 *
	 * @return  \SimpleXMLElement|null
	 * @since 3.2.0
	 */
	public function get(array $attributes, ?array $options = null): ?\SimpleXMLElement
	{
		return FormHelper::xml($attributes, $options);
	}

	/**
	 * xmlAppend
	 *
	 * @param   \SimpleXMLElement   $xml      The XML element reference in which to inject a comment
	 * @param   mixed              $node     A SimpleXMLElement node to append to the XML element reference,
	 *                                         or a stdClass object containing a comment attribute to be injected
	 *                                         before the XML node and a fieldXML attribute containing a SimpleXMLElement
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function append(\SimpleXMLElement &$xml, $node)
	{
		FormHelper::append($xml, $node);
	}

	/**
	 * xmlComment
	 *
	 * @param   \SimpleXMLElement   $xml        The XML element reference in which to inject a comment
	 * @param   string             $comment    The comment to inject
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function comment(\SimpleXMLElement &$xml, string $comment)
	{
		FormHelper::comment($xml, $comment);
	}

	/**
	 * xmlAddAttributes
	 *
	 * @param   \SimpleXMLElement   $xml          The XML element reference in which to inject a comment
	 * @param   array              $attributes   The attributes to apply to the XML element
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function attributes(\SimpleXMLElement &$xml, array $attributes = [])
	{
		FormHelper::attributes($xml, $attributes);
	}

	/**
	 * xmlAddOptions
	 *
	 * @param   \SimpleXMLElement   $xml          The XML element reference in which to inject a comment
	 * @param   array              $options      The options to apply to the XML element
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function options(\SimpleXMLElement &$xml, array $options = [])
	{
		FormHelper::options($xml, $options);
	}

	/**
	 * XML Pretty Print
	 *
	 * @param   \SimpleXMLElement  $xml       The XML element containing a node to be output
	 * @param   string             $nodename  node name of the input xml element to print out.  this is done to omit the <?xml... tag
	 *
	 * @return  string XML output
	 * @since 3.2.0
	 */
	public function pretty(\SimpleXMLElement $xml, string $nodename): string
	{
		$dom               = dom_import_simplexml($xml)->ownerDocument;
		$dom->formatOutput = true;
		$xmlString         = $dom->saveXML(
			$dom->getElementsByTagName($nodename)->item(0)
		);
		// make sure Tidy is enabled
		if ($this->config->get('tidy', false))
		{
			$tidy = new \Tidy();
			$tidy->parseString(
				$xmlString, [
					'indent'            => true,
					'indent-spaces'     => 8,
					'input-xml'         => true,
					'output-xml'        => true,
					'indent-attributes' => true,
					'wrap-attributes'   => true,
					'wrap' => false
				]
			);
			$tidy->cleanRepair();

			return $this->indent((string) $tidy, ' ', 8, true, false);
		}
		// set tidy warning only once
		elseif ($this->config->set_tidy_warning)
		{
			// set the warning only once
			$this->config->set('set_tidy_warning', false);
			// now set the warning
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREETIDY_ERRORHTHREE'), 'Error'
			);
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_YOU_MUST_ENABLE_THE_BTIDYB_EXTENSION_IN_YOUR_PHPINI_FILE_SO_WE_CAN_TIDY_UP_YOUR_XML_IF_YOU_NEED_HELP_PLEASE_A_SSTART_HEREA', 'href="https://github.com/vdm-io/Joomla-Component-Builder/issues/197#issuecomment-351181754" target="_blank"'), 'Error'
			);
		}

		return $xmlString;
	}

	/**
	 * xmlIndent
	 *
	 * @param   string   $string     The XML input
	 * @param   string   $char       Character or characters to use as the repeated indent
	 * @param   int      $depth      number of times to repeat the indent character
	 * @param   bool     $skipfirst  Skip the first line of the input.
	 * @param   bool     $skiplast   Skip the last line of the input;
	 *
	 * @return  string XML output
	 * @since 3.2.0
	 */
	public function indent(string $string, string $char = ' ', int $depth = 0,
		bool $skipfirst = false, bool $skiplast = false): string
	{
		$output = array();
		$lines  = explode("\n", $string);
		$first  = true;
		$last   = count($lines) - 1;
		foreach ($lines as $i => $line)
		{
			$output[] = (($first && $skipfirst) || $i === $last && $skiplast)
				? $line : str_repeat($char, $depth) . $line;
			$first    = false;
		}

		return implode("\n", $output);
	}
}

