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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Abstraction\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Builder\BaseSixFour;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItem;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItemArray;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelBasicField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertFieldInitiator;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelMediumField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelWhmcsField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Get Item Class.
 * 
 * Builds the getItem method of an item model: what it decodes, what it
 * decrypts, what it unpacks, what tags it loads, and whatever the view was
 * given to run alongside it.
 * 
 * @since 6.1.7
 */
final class GetItemMethod
{
	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The Base Six Four Builder Class.
	 *
	 * @var   BaseSixFour
	 * @since 6.1.7
	 */
	protected BaseSixFour $basesixfour;

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
	 * The Json String Builder Class.
	 *
	 * @var   JsonString
	 * @since 6.1.7
	 */
	protected JsonString $jsonstring;

	/**
	 * The Tags Builder Class.
	 *
	 * @var   Tags
	 * @since 6.1.7
	 */
	protected Tags $tags;

	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The Model Expert Field Initiator Class.
	 *
	 * @var   ModelExpertFieldInitiator
	 * @since 6.1.7
	 */
	protected ModelExpertFieldInitiator $modelexpertfieldinitiator;

	/**
	 * The Model Basic Field Class.
	 *
	 * @var   ModelBasicField
	 * @since 6.1.7
	 */
	protected ModelBasicField $modelbasicfield;

	/**
	 * The Model Medium Field Class.
	 *
	 * @var   ModelMediumField
	 * @since 6.1.7
	 */
	protected ModelMediumField $modelmediumfield;

	/**
	 * The Model Whmcs Field Class.
	 *
	 * @var   ModelWhmcsField
	 * @since 6.1.7
	 */
	protected ModelWhmcsField $modelwhmcsfield;

	/**
	 * The Model Expert Field Class.
	 *
	 * @var   ModelExpertField
	 * @since 6.1.7
	 */
	protected ModelExpertField $modelexpertfield;

	/**
	 * Constructor.
	 *
	 * @param ContentOne                $contentone                The Content One Builder Class.
	 * @param Config                    $config                    The Config Class.
	 * @param Placeholder               $placeholder               The Placeholder Class.
	 * @param BaseSixFour               $basesixfour               The Base Six Four Builder Class.
	 * @param JsonItem                  $jsonitem                  The Json Item Builder Class.
	 * @param JsonItemArray             $jsonitemarray             The Json Item Array Builder Class.
	 * @param JsonString                $jsonstring                The Json String Builder Class.
	 * @param Tags                      $tags                      The Tags Builder Class.
	 * @param Dispenser                 $dispenser                 The Customcode Dispenser Class.
	 * @param ModelBasicField           $modelbasicfield           The Model Basic Field Class.
	 * @param ModelMediumField          $modelmediumfield          The Model Medium Field Class.
	 * @param ModelWhmcsField           $modelwhmcsfield           The Model Whmcs Field Class.
	 * @param ModelExpertField          $modelexpertfield          The Model Expert Field Class.
	 * @param ModelExpertFieldInitiator $modelexpertfieldinitiator The Model Expert Field Initiator Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(ContentOne $contentone,
		Config $config,
		Placeholder $placeholder,
		BaseSixFour $basesixfour,
		JsonItem $jsonitem,
		JsonItemArray $jsonitemarray,
		JsonString $jsonstring,
		Tags $tags,
		Dispenser $dispenser,
		ModelBasicField $modelbasicfield,
		ModelMediumField $modelmediumfield,
		ModelWhmcsField $modelwhmcsfield,
		ModelExpertField $modelexpertfield,
		ModelExpertFieldInitiator $modelexpertfieldinitiator)
	{
		$this->contentone = $contentone;
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->basesixfour = $basesixfour;
		$this->jsonitem = $jsonitem;
		$this->jsonitemarray = $jsonitemarray;
		$this->jsonstring = $jsonstring;
		$this->tags = $tags;
		$this->dispenser = $dispenser;
		$this->modelexpertfieldinitiator = $modelexpertfieldinitiator;
		$this->modelbasicfield = $modelbasicfield;
		$this->modelmediumfield = $modelmediumfield;
		$this->modelwhmcsfield = $modelwhmcsfield;
		$this->modelexpertfield = $modelexpertfield;
	}

	/**
	 * Build the getItem method of an item model.
	 *
	 * What the item carries decides what the method does with it: fields the
	 * component stored encoded are decoded, fields it stored encrypted are
	 * decrypted, json is unpacked, and the tags of the item are loaded.
	 *
	 * @param   string  $view  The single view code name.
	 *
	 * @return  string  The method body.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view): string
	{
		$script = '';
		// get the component name
		$Component = $this->contentone->get('Component');
		$component = $this->contentone->get('component');
		// go from base64 to string
		if ($this->basesixfour->exists($view))
		{
			foreach ($this->basesixfour->get($view) as $baseString)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(3)
					. "if (!empty(\$item->" . $baseString
					. "))"; // TODO && base64_encode(base64_decode(\$item->".$baseString.", true)) === \$item->".$baseString.")";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " base64 Decode " . $baseString . ".";
				$script .= PHP_EOL . Indent::_(4) . "\$item->" . $baseString
					. " = base64_decode(\$item->" . $baseString . ");";
				$script .= PHP_EOL . Indent::_(3) . "}";
			}
		}
		// decryption
		foreach ($this->config->cryption_types as $cryptionType)
		{
			$cryptionFields = $this->cryptionField($cryptionType);
			if ($cryptionFields !== null && $cryptionFields->exists($view))
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " Get the " . $cryptionType
						. " encryption.";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $cryptionType
						. "key = " . $Component . "Helper::getCryptKey('"
						. $cryptionType . "');";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Get the encryption object.";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $cryptionType
						. " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$" . $cryptionType . "key);";
					foreach ($cryptionFields->get($view) as $baseString)
					{
						$script .= PHP_EOL . PHP_EOL . Indent::_(3)
							. "if (!empty(\$item->" . $baseString . ") && \$"
							. $cryptionType . "key && !is_numeric(\$item->"
							. $baseString . ") && \$item->" . $baseString
							. " === base64_encode(base64_decode(\$item->"
							. $baseString . ", true)))";
						$script .= PHP_EOL . Indent::_(3) . "{";
						$script .= PHP_EOL . Indent::_(4) . "//"
							. Line::_(__Line__, __Class__) . " " . $cryptionType
							. " decrypt data " . $baseString . ".";
						$script .= PHP_EOL . Indent::_(4) . "\$item->"
							. $baseString . " = rtrim(\$" . $cryptionType
							. "->decryptString(\$item->" . $baseString . "), "
							. '"\0"' . ");";
						$script .= PHP_EOL . Indent::_(3) . "}";
					}
				}
				else
				{
					if ($this->modelexpertfieldinitiator->
						exists("{$view}.get"))
					{
						foreach ($this->modelexpertfieldinitiator->
							get("{$view}.get") as $block
						)
						{
							$script .= PHP_EOL . Indent::_(3) . implode(
								PHP_EOL . Indent::_(3), $block
							);
						}
					}
					// set the expert script
					foreach ($cryptionFields->
						get($view) as $baseString => $opener_)
					{
						$_placeholder_for_field = array('[[[field]]]' => '$item->' . $baseString);
						$script .= $this->placeholder->update(
							PHP_EOL . Indent::_(3) . implode(
								PHP_EOL . Indent::_(3), $opener_['get']
							), $_placeholder_for_field
						);
					}
				}
			}
		}
		// go from json to array
		if ($this->jsonitem->exists($view))
		{
			foreach ($this->jsonitem->get($view) as $jsonItem)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(3)
					. "if (!empty(\$item->" . $jsonItem . "))";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Convert the " . $jsonItem . " field to an array.";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $jsonItem
					. " = new Registry;";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $jsonItem
					. "->loadString(\$item->" . $jsonItem . ");";
				$script .= PHP_EOL . Indent::_(4) . "\$item->" . $jsonItem
					. " = \$" . $jsonItem . "->toArray();";
				$script .= PHP_EOL . Indent::_(3) . "}";
			}
		}
		// go from json to string
		if ($this->jsonstring->exists($view))
		{
			$makeArray = '';
			foreach ($this->jsonstring->get($view) as $jsonString)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(3)
					. "if (!empty(\$item->" . $jsonString . "))";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " JSON Decode " . $jsonString . ".";
				if ($this->jsonitemarray->inArray($jsonString, $view) ||
					strpos((string) $jsonString, 'group') !== false)
				{
					$makeArray = ',true';
				}
				$script .= PHP_EOL . Indent::_(4) . "\$item->" . $jsonString
					. " = json_decode(\$item->" . $jsonString . $makeArray
					. ");";
				$script .= PHP_EOL . Indent::_(3) . "}";
			}
		}
		// add the tag get options
		if ($this->tags->exists($view))
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(3)
				. "if (!empty(\$item->id))";
			$script .= PHP_EOL . Indent::_(3) . "{";
			$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get Tag IDs.";
			$script .= PHP_EOL . Indent::_(4) . "\$item->tags"
				. " = new TagsHelper;";
			$script .= PHP_EOL . Indent::_(4)
				. "\$item->tags->getTagIds(\$item->id, 'com_$component.$view');";
			$script .= PHP_EOL . Indent::_(3) . "}";
		}
		// add custom php to getitem method
		$script .= $this->dispenser->get(
			'php_getitem', $view, PHP_EOL . PHP_EOL
		);

		return $script;
	}
	/**
	 * The registry that holds the fields of one kind of encryption.
	 *
	 * @param   string  $cryptionType  The kind of encryption.
	 *
	 * @return  Registry|null  The registry, or null when there is none.
	 *
	 * @since   6.1.7
	 */
	protected function cryptionField(string $cryptionType): ?Registry
	{
		return match (strtolower($cryptionType))
		{
			'basic' => $this->modelbasicfield,
			'medium' => $this->modelmediumfield,
			'whmcs' => $this->modelwhmcsfield,
			'expert' => $this->modelexpertfield,
			// a type with no registry has no fields to encrypt, so the caller
			// skips it, the same way it skips a type whose registry is empty
			default => null,
		};
	}
}

