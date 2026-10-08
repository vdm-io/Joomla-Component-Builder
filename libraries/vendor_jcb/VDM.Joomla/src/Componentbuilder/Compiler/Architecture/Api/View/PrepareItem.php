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


use VDM\Joomla\Abstraction\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Builder\BaseSixFour;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ItemsMethodListString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItem;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItemArray;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelBasicField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelMediumField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelWhmcsField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Api View Prepare Item Class.
 * 
 * Builds the prepareItem method of the JSON API views. The item view gets
 * its tags as names, since the item model already decoded everything else.
 * The list view decodes, decrypts and unpacks the stored values the list
 * model leaves raw, because the list model only prepares the columns the
 * admin list shows while the API renders every column.
 * 
 * @since 6.1.7
 */
final class PrepareItem
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Json String Builder Class.
	 *
	 * @var   JsonString
	 * @since 6.1.7
	 */
	protected JsonString $jsonstring;

	/**
	 * The Json Item Builder Class.
	 *
	 * @var   JsonItem
	 * @since 6.1.7
	 */
	protected JsonItem $jsonitem;

	/**
	 * The Json Item Array Builder Class.
	 *
	 * @var   JsonItemArray
	 * @since 6.1.7
	 */
	protected JsonItemArray $jsonitemarray;

	/**
	 * The Base Six Four Builder Class.
	 *
	 * @var   BaseSixFour
	 * @since 6.1.7
	 */
	protected BaseSixFour $basesixfour;

	/**
	 * The Model Basic Field Builder Class.
	 *
	 * @var   ModelBasicField
	 * @since 6.1.7
	 */
	protected ModelBasicField $modelbasicfield;

	/**
	 * The Model Medium Field Builder Class.
	 *
	 * @var   ModelMediumField
	 * @since 6.1.7
	 */
	protected ModelMediumField $modelmediumfield;

	/**
	 * The Model Whmcs Field Builder Class.
	 *
	 * @var   ModelWhmcsField
	 * @since 6.1.7
	 */
	protected ModelWhmcsField $modelwhmcsfield;

	/**
	 * The Items Method List String Builder Class.
	 *
	 * @var   ItemsMethodListString
	 * @since 6.1.7
	 */
	protected ItemsMethodListString $itemsmethodliststring;

	/**
	 * The Tags Builder Class.
	 *
	 * @var   Tags
	 * @since 6.1.7
	 */
	protected Tags $tags;

	/**
	 * Constructor.
	 *
	 * @param Config                  $config                  The Config Class.
	 * @param ContentOne              $contentone              The Content One Builder Class.
	 * @param JsonString              $jsonstring              The Json String Builder Class.
	 * @param JsonItem                $jsonitem                The Json Item Builder Class.
	 * @param JsonItemArray           $jsonitemarray           The Json Item Array Builder Class.
	 * @param BaseSixFour             $basesixfour             The Base Six Four Builder Class.
	 * @param ModelBasicField         $modelbasicfield         The Model Basic Field Builder Class.
	 * @param ModelMediumField        $modelmediumfield        The Model Medium Field Builder Class.
	 * @param ModelWhmcsField         $modelwhmcsfield         The Model Whmcs Field Builder Class.
	 * @param ItemsMethodListString   $itemsmethodliststring   The Items Method List String Builder Class.
	 * @param Tags                    $tags                    The Tags Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, ContentOne $contentone,
		JsonString $jsonstring, JsonItem $jsonitem, JsonItemArray $jsonitemarray,
		BaseSixFour $basesixfour, ModelBasicField $modelbasicfield,
		ModelMediumField $modelmediumfield, ModelWhmcsField $modelwhmcsfield,
		ItemsMethodListString $itemsmethodliststring, Tags $tags)
	{
		$this->config = $config;
		$this->contentone = $contentone;
		$this->jsonstring = $jsonstring;
		$this->jsonitem = $jsonitem;
		$this->jsonitemarray = $jsonitemarray;
		$this->basesixfour = $basesixfour;
		$this->modelbasicfield = $modelbasicfield;
		$this->modelmediumfield = $modelmediumfield;
		$this->modelwhmcsfield = $modelwhmcsfield;
		$this->itemsmethodliststring = $itemsmethodliststring;
		$this->tags = $tags;
	}

	/**
	 * Get the prepare item code of a JSON API view.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   bool    $list            Build for the list view, else for the item view.
	 *
	 * @return  string  The prepare item method body, or nothing when the item needs no work.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, bool $list = false): string
	{
		$script = $list
			? $this->decode($nameSingleCode)
			: $this->tags($nameSingleCode);

		// the body follows the opening brace, so it opens with one line break
		return ($script === '') ? '' : PHP_EOL . ltrim($script, PHP_EOL) . PHP_EOL;
	}

	/**
	 * Decode, decrypt and unpack the stored values the list model leaves raw.
	 *
	 * The order is the one the item model uses: base64, then decryption, then
	 * the JSON values. Every step only touches a string, so a value the list
	 * model already prepared is left alone.
	 *
	 * @param   string  $view  The single code name of the view.
	 *
	 * @return  string  The decode statements.
	 * @since   6.1.7
	 */
	private function decode(string $view): string
	{
		$script = '';
		$done = $this->decoded($view);
		$Component = (string) $this->contentone->get('Component');

		// go from base64 to string
		foreach ($this->pending($this->basesixfour, $view, $done) as $column)
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (isset(\$item->"
				. $column . ") && is_string(\$item->" . $column . ") && \$item->"
				. $column . " !== '')";
			$script .= PHP_EOL . Indent::_(2) . "{";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__LINE__, __CLASS__)
				. " base64 Decode " . $column . ".";
			$script .= PHP_EOL . Indent::_(3) . "\$item->" . $column
				. " = base64_decode(\$item->" . $column . ");";
			$script .= PHP_EOL . Indent::_(2) . "}";
		}

		// decryption
		foreach ($this->config->cryption_types as $cryptionType)
		{
			$cryptionFields = $this->cryptionField((string) $cryptionType);

			if ($cryptionFields === null)
			{
				continue;
			}

			$columns = $this->pending($cryptionFields, $view, $done);

			if ($columns === [])
			{
				continue;
			}

			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__LINE__, __CLASS__) . " Get the " . $cryptionType
				. " encryption.";
			$script .= PHP_EOL . Indent::_(2) . "\$" . $cryptionType
				. "key = " . $Component . "Helper::getCryptKey('"
				. $cryptionType . "');";
			$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " Get the encryption object.";
			$script .= PHP_EOL . Indent::_(2) . "\$" . $cryptionType
				. " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$"
				. $cryptionType . "key);";

			foreach ($columns as $column)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (!empty(\$item->"
					. $column . ") && \$" . $cryptionType . "key && is_string(\$item->"
					. $column . ") && !is_numeric(\$item->" . $column . ") && \$item->"
					. $column . " === base64_encode(base64_decode(\$item->" . $column
					. ", true)))";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__LINE__, __CLASS__)
					. " " . $cryptionType . " decrypt data " . $column . ".";
				$script .= PHP_EOL . Indent::_(3) . "\$item->" . $column
					. " = rtrim(\$" . $cryptionType . "->decryptString(\$item->"
					. $column . "), " . '"\0"' . ");";
				$script .= PHP_EOL . Indent::_(2) . "}";
			}
		}

		// go from json to array
		foreach ($this->pending($this->jsonitem, $view, $done) as $column)
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (isset(\$item->"
				. $column . ") && is_string(\$item->" . $column . ") && \$item->"
				. $column . " !== '')";
			$script .= PHP_EOL . Indent::_(2) . "{";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__LINE__, __CLASS__)
				. " Convert the " . $column . " field to an array.";
			$script .= PHP_EOL . Indent::_(3) . "\$registry = new Registry;";
			$script .= PHP_EOL . Indent::_(3) . "\$registry->loadString(\$item->"
				. $column . ");";
			$script .= PHP_EOL . Indent::_(3) . "\$item->" . $column
				. " = \$registry->toArray();";
			$script .= PHP_EOL . Indent::_(2) . "}";
		}

		// go from json to string
		foreach ($this->pending($this->jsonstring, $view, $done) as $column)
		{
			$makeArray = ($this->jsonitemarray->inArray($column, $view)
				|| strpos($column, 'group') !== false) ? ', true' : '';

			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (isset(\$item->"
				. $column . ") && is_string(\$item->" . $column . ") && \$item->"
				. $column . " !== '')";
			$script .= PHP_EOL . Indent::_(2) . "{";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__LINE__, __CLASS__)
				. " JSON Decode " . $column . ".";
			$script .= PHP_EOL . Indent::_(3) . "\$item->" . $column
				. " = json_decode(\$item->" . $column . $makeArray . ");";
			$script .= PHP_EOL . Indent::_(2) . "}";
		}

		return $script;
	}

	/**
	 * Turn the tags helper the item model loads into the tag names.
	 *
	 * @param   string  $view  The single code name of the view.
	 *
	 * @return  string  The tag statements, or nothing when the view has no tags.
	 * @since   6.1.7
	 */
	private function tags(string $view): string
	{
		if (!$this->tags->exists($view))
		{
			return '';
		}

		$script = PHP_EOL . PHP_EOL . Indent::_(2)
			. "if (isset(\$item->tags) && \$item->tags instanceof TagsHelper)";
		$script .= PHP_EOL . Indent::_(2) . "{";
		$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__LINE__, __CLASS__)
			. " Convert the tags to their names.";
		$script .= PHP_EOL . Indent::_(3) . "\$tags = (string) \$item->tags->tags;";
		$script .= PHP_EOL . Indent::_(3)
			. "\$ids = (\$tags !== '') ? explode(',', \$tags) : [];";
		$script .= PHP_EOL . Indent::_(3)
			. "\$names = (\$ids !== []) ? \$item->tags->getTagNames(\$ids) : [];";
		$script .= PHP_EOL . Indent::_(3)
			. "\$item->tags = (count(\$ids) === count(\$names)) ? array_combine(\$ids, \$names) : array_values(\$names);";
		$script .= PHP_EOL . Indent::_(2) . "}";

		return $script;
	}

	/**
	 * The columns of a store registry the list model has not prepared.
	 *
	 * @param   Registry  $registry  The registry of one store kind.
	 * @param   string    $view      The single code name of the view.
	 * @param   array     $done      The columns the list model prepares.
	 *
	 * @return  array  The column names still to prepare.
	 * @since   6.1.7
	 */
	private function pending(Registry $registry, string $view, array $done): array
	{
		$pending = [];

		if (!$registry->exists($view))
		{
			return $pending;
		}

		$columns = $registry->get($view);

		if (!is_array($columns))
		{
			return $pending;
		}

		foreach ($columns as $column)
		{
			$column = (string) $column;

			if ($column !== '' && !in_array($column, $done, true)
				&& !in_array($column, $pending, true))
			{
				$pending[] = $column;
			}
		}

		return $pending;
	}

	/**
	 * The columns the list model already prepares in its getItems method.
	 *
	 * @param   string  $view  The single code name of the view.
	 *
	 * @return  array  The column names.
	 * @since   6.1.7
	 */
	private function decoded(string $view): array
	{
		$done = [];
		$items = $this->itemsmethodliststring->get($view);

		if (!is_array($items))
		{
			return $done;
		}

		foreach ($items as $item)
		{
			if (is_array($item) && isset($item['name']) && (string) $item['name'] !== '')
			{
				$done[] = (string) $item['name'];
			}
		}

		return $done;
	}

	/**
	 * The registry that holds the fields of one kind of encryption.
	 *
	 * The expert kind is left to the model, it carries its own code.
	 *
	 * @param   string  $cryptionType  The kind of encryption.
	 *
	 * @return  Registry|null  The registry, or null when there is none.
	 * @since   6.1.7
	 */
	private function cryptionField(string $cryptionType): ?Registry
	{
		return match (strtolower($cryptionType))
		{
			'basic' => $this->modelbasicfield,
			'medium' => $this->modelmediumfield,
			'whmcs' => $this->modelwhmcsfield,
			default => null,
		};
	}
}

