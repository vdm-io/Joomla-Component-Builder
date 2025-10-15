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

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteDecrypt;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldDecodeFilter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertFieldInitiator;
use VDM\Joomla\Componentbuilder\Compiler\Builder\EventDispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\DecodeColumn;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\FilterColumn;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\FieldonContentPrepare;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\UikitLoader;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Globals;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\CustomJoin;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;


/**
 * Dynamic Get GetItems
 * 
 * @since 5.1.2
 */
final class GetItems
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The SiteDecrypt Class.
	 *
	 * @var   SiteDecrypt
	 * @since 5.1.2
	 */
	protected SiteDecrypt $sitedecrypt;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.2
	 */
	protected ContentOne $contentone;

	/**
	 * The SiteFieldData Class.
	 *
	 * @var   SiteFieldData
	 * @since 5.1.2
	 */
	protected SiteFieldData $sitefielddata;

	/**
	 * The SiteFieldDecodeFilter Class.
	 *
	 * @var   SiteFieldDecodeFilter
	 * @since 5.1.2
	 */
	protected SiteFieldDecodeFilter $sitefielddecodefilter;

	/**
	 * The ModelExpertFieldInitiator Class.
	 *
	 * @var   ModelExpertFieldInitiator
	 * @since 5.1.2
	 */
	protected ModelExpertFieldInitiator $modelexpertfieldinitiator;

	/**
	 * The EventDispatcher Class.
	 *
	 * @var   EventDispatcher
	 * @since 5.1.2
	 */
	protected EventDispatcher $eventdispatcher;

	/**
	 * The DecodeColumn Class.
	 *
	 * @var   DecodeColumn
	 * @since 5.1.2
	 */
	protected DecodeColumn $decodecolumn;

	/**
	 * The FilterColumn Class.
	 *
	 * @var   FilterColumn
	 * @since 5.1.2
	 */
	protected FilterColumn $filtercolumn;

	/**
	 * The FieldonContentPrepare Class.
	 *
	 * @var   FieldonContentPrepare
	 * @since 5.1.2
	 */
	protected FieldonContentPrepare $fieldoncontentprepare;

	/**
	 * The UikitLoader Class.
	 *
	 * @var   UikitLoader
	 * @since 5.1.2
	 */
	protected UikitLoader $uikitloader;

	/**
	 * The Globals Class.
	 *
	 * @var   Globals
	 * @since 5.1.2
	 */
	protected Globals $globals;

	/**
	 * The CustomJoin Class.
	 *
	 * @var   CustomJoin
	 * @since 5.1.2
	 */
	protected CustomJoin $customjoin;

	/**
	 * Constructor.
	 *
	 * @param Config                      $config                      The Config Class.
	 * @param SiteDecrypt                 $sitedecrypt                 The SiteDecrypt Class.
	 * @param Placeholder                 $placeholder                 The Placeholder Class.
	 * @param ContentOne                  $contentone                  The ContentOne Class.
	 * @param SiteFieldData               $sitefielddata               The SiteFieldData Class.
	 * @param SiteFieldDecodeFilter       $sitefielddecodefilter       The SiteFieldDecodeFilter Class.
	 * @param ModelExpertFieldInitiator   $modelexpertfieldinitiator   The ModelExpertFieldInitiator Class.
	 * @param EventDispatcher             $eventdispatcher             The EventDispatcher Class.
	 * @param DecodeColumn                $decodecolumn                The DecodeColumn Class.
	 * @param FilterColumn                $filtercolumn                The FilterColumn Class.
	 * @param FieldonContentPrepare       $fieldoncontentprepare       The FieldonContentPrepare Class.
	 * @param UikitLoader                 $uikitloader                 The UikitLoader Class.
	 * @param Globals                     $globals                     The Globals Class.
	 * @param CustomJoin                  $customjoin                  The CustomJoin Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, SiteDecrypt $sitedecrypt,
		Placeholder $placeholder, ContentOne $contentone,
		SiteFieldData $sitefielddata,
		SiteFieldDecodeFilter $sitefielddecodefilter,
		ModelExpertFieldInitiator $modelexpertfieldinitiator,
		EventDispatcher $eventdispatcher,
		DecodeColumn $decodecolumn, FilterColumn $filtercolumn,
		FieldonContentPrepare $fieldoncontentprepare,
		UikitLoader $uikitloader, Globals $globals,
		CustomJoin $customjoin)
	{
		$this->config = $config;
		$this->sitedecrypt = $sitedecrypt;
		$this->placeholder = $placeholder;
		$this->contentone = $contentone;
		$this->sitefielddata = $sitefielddata;
		$this->sitefielddecodefilter = $sitefielddecodefilter;
		$this->modelexpertfieldinitiator = $modelexpertfieldinitiator;
		$this->eventdispatcher = $eventdispatcher;
		$this->decodecolumn = $decodecolumn;
		$this->filtercolumn = $filtercolumn;
		$this->fieldoncontentprepare = $fieldoncontentprepare;
		$this->uikitloader = $uikitloader;
		$this->globals = $globals;
		$this->customjoin = $customjoin;
	}

	/**
	 * Generate the GetItems code block for the dynamicget.
	 *
	 * @param  object  $get   The get object.
	 * @param  string  $code  The component code.
	 *
	 * @return string  The resulting PHP code string.
	 * @since  5.1.2
	 */
	public function get($get, string $code): string
	{
		if (empty($code) || !ObjectHelper::check($get))
		{
			return PHP_EOL;
		}

		$this->removeCryptionTypes($code);

		$getItem = PHP_EOL . PHP_EOL . Indent::_(2) . "//"
			. Line::_(__LINE__, __CLASS__) . " Insure all item fields are adapted where needed.";
		$getItem .= PHP_EOL . Indent::_(2) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items))";
		$getItem .= PHP_EOL . Indent::_(2) . "{";
		$getItem .= Placefix::_h("DISPATCHER");
		$getItem .= PHP_EOL . Indent::_(3) . "foreach (\$items as \$nr => &\$item)";
		$getItem .= PHP_EOL . Indent::_(3) . "{";
		$getItem .= PHP_EOL . Indent::_(4) . "//" . Line::_(__LINE__, __CLASS__) . " Always create a slug for sef URL's";
		$getItem .= PHP_EOL . Indent::_(4) . "\$item->slug = (\$item->id ?? '0') . (isset(\$item->alias) ? ':' . \$item->alias : '');";

		$asBucket = [];
		if (isset($get->main_get) && ArrayHelper::check($get->main_get))
		{
			$getItem .= $this->buildPostProcessFieldChecks($get, $code, Indent::_(2), $asBucket);
		}

		$getItem .= $this->buildGlobals($get, $code, Indent::_(2), $asBucket);
		$getItem .= $this->buildCustomJoin($get, $code, Indent::_(2), $asBucket);
		$getItem .= $this->buildCalculation($get);
		$getItem = $this->injectDispatcherIfNeeded($getItem, $code);

		$getItem .= PHP_EOL . Indent::_(3) . "}";
		$getItem .= PHP_EOL . Indent::_(2) . "}";

		if (strlen($getItem) <= 100)
		{
			return PHP_EOL;
		}

		$script = $this->buildCryptionScript($code);

		return $script . $getItem;
	}

	/**
	 * Remove all cryption type flags for this code.
	 *
	 * @param  string  $code
	 *
	 * @return void
	 * @since  5.1.2
	 */
	private function removeCryptionTypes(string $code): void
	{
		foreach ($this->config->cryption_types as $cryptionType)
		{
			$this->sitedecrypt->remove("{$cryptionType}.{$code}");
		}
	}

	/**
	 * Handle decode, filter, prepare, UIkit field processing.
	 *
	 * @param  object   $get
	 * @param  string   $code
	 * @param  string   $tab
	 * @param  string[] &$asBucket
	 *
	 * @return string
	 * @since 5.1.2
	 */
	private function buildPostProcessFieldChecks(object $get, string $code, string $tab, array &$asBucket): string
	{
		$output = '';

		foreach ($get->main_get as $main_get)
		{
			if (!isset($main_get['key'], $main_get['as']))
			{
				continue;
			}

			$path = $code . '.' . $main_get['key'] . '.' . $main_get['as'];

			$decodeChecker = $this->sitefielddata->get('decode.' . $path);
			$decodeFilter = $this->sitefielddecodefilter->get($this->config->build_target . '.' . $path);
			$contentprepareChecker = $this->sitefielddata->get('textareas.' . $path);
			$uikitChecker = $this->sitefielddata->get('uikit.' . $path);

			$decoder         = $this->getDecoderCode($main_get, $code, $tab, $decodeChecker);
			$decoderFilter   = $this->getDecoderFilterCode($main_get, $code, $tab, $decodeFilter);
			$contentPrepare  = $this->getContentPrepareCode($main_get, $code, $tab, $contentprepareChecker);
			$uikit           = $this->getUIKitCode($main_get, $code, $tab, $uikitChecker);

			if ($this->hasFieldProcessing($decoder, $decoderFilter, $contentPrepare, $uikit))
			{
				$output .= $this->buildFieldProcessingBlock($decoder, $decoderFilter, $contentPrepare, $uikit);
			}

			$asBucket[] = $main_get['as'];
		}

		return $output;
	}

	/**
	 * Generate decoder block code for the matched field set.
	 *
	 * @param  array       $get      The get definition.
	 * @param  string      $code     The code name.
	 * @param  string      $tab      The tabing string
	 * @param  array|null  $checker  The decoder rules to apply (if any).
	 *
	 * @return string  The decoder logic code block or an empty string.
	 * @since  5.1.2
	 */
	private function getDecoderCode(array $get, string $code, string $tab, ?array $checker): string
	{
		return ($checker !== null && ArrayHelper::check($checker))
			? $this->decodecolumn->get($get, $checker, '$item', $code, $tab)
			: '';
	}

	/**
	 * Generate filter decoder block for field-specific filters.
	 *
	 * @param  array       $get      The get definition.
	 * @param  string      $code     The code name.
	 * @param  string      $tab      The tabing string
	 * @param  array|null  $checker  The filter configuration to apply (if any).
	 *
	 * @return string  The filtered decoder code block or an empty string.
	 * @since  5.1.2
	 */
	private function getDecoderFilterCode(array $get, string $code, string $tab, ?array $checker): string
	{
		return ($checker !== null && ArrayHelper::check($checker))
			? $this->filtercolumn->get($get, $checker, '$item', '$items[$nr]', $code, $tab)
			: '';
	}

	/**
	 * Generate content preparation code for specified textarea fields.
	 *
	 * @param  array       $get      The get definition.
	 * @param  string      $code     The code name.
	 * @param  string      $tab      The tabing string
	 * @param  array|null  $checker  The content prepare configuration to apply (if any).
	 *
	 * @return string  The content prepare code block or an empty string.
	 * @since  5.1.2
	 */
	private function getContentPrepareCode(array $get, string $code, string $tab, ?array $checker): string
	{
		return ($checker !== null && ArrayHelper::check($checker))
			? $this->fieldoncontentprepare->get($get, $checker, '$item', $code, $tab)
			: '';
	}

	/**
	 * Generate UIkit-specific field formatting code.
	 *
	 * @param  array       $get      The get definition.
	 * @param  string      $code     The code name.
	 * @param  string      $tab      The tabing string
	 * @param  array|null  $checker  The UIkit config for visual formatting (if any).
	 *
	 * @return string  The UIkit loader code block or an empty string.
	 * @since  5.1.2
	 */
	private function getUIKitCode(array $get, string $code, string $tab, ?array $checker): string
	{
		return ($checker !== null && ArrayHelper::check($checker))
			? $this->uikitloader->get($get, $checker, '$item', $code, $tab)
			: '';
	}

	/**
	 * Check if any of the provided code parts contain executable logic.
	 *
	 * @param  string  ...$parts  The list of code strings to evaluate.
	 *
	 * @return bool  True if any string is non-empty and valid.
	 * @since  5.1.2
	 */
	private function hasFieldProcessing(string ...$parts): bool
	{
		foreach ($parts as $part)
		{
			if (StringHelper::check($part))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Build the complete foreach loop block to process all returned items.
	 *
	 * @param  string  $decoder         The decoder block.
	 * @param  string  $decoderFilter   The decoder filter block.
	 * @param  string  $contentPrepare  The content prepare block.
	 * @param  string  $uikit           The UIkit block.
	 *
	 * @return string  The complete loop and return block for $items.
	 * @since  5.1.2
	 */
	private function buildFieldProcessingBlock(
		string $decoder,
		string $decoderFilter,
		string $contentPrepare,
		string $uikit
	): string
	{
		$code = '';

		foreach ([$decoder, $decoderFilter, $contentPrepare, $uikit] as $block)
		{
			if (StringHelper::check($block))
			{
				$code .= $block;
			}
		}

		return $code;
	}

	/**
	 * Build the cryption script injection.
	 *
	 * @param  string  $code
	 *
	 * @return string
	 * @since 5.1.2
	 */
	private function buildCryptionScript(string $code): string
	{
		$script = '';
		$component = $this->contentone->get('Component');

		foreach ($this->config->cryption_types as $cryptionType)
		{
			if ($this->sitedecrypt->get("{$cryptionType}.{$code}") !== null)
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " Get the {$cryptionType} encryption.";
					$script .= PHP_EOL . Indent::_(2) . "\${$cryptionType}key = {$component}Helper::getCryptKey('{$cryptionType}');";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " Get the encryption object.";
					$script .= PHP_EOL . Indent::_(2) . "\${$cryptionType} = new Super__"."_99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\${$cryptionType}key);";
				}
				elseif ($this->modelexpertfieldinitiator->exists("{$code}.get"))
				{
					foreach ($this->modelexpertfieldinitiator->get("{$code}.get") as $block)
					{
						$script .= PHP_EOL . Indent::_(2) . implode(PHP_EOL . Indent::_(2), $block);
					}
				}
			}
		}

		return $script;
	}

	/**
	 * Build the global loader.
	 *
	 * @param  object   $get
	 * @param  string   $code
	 * @param  string   $tab
	 * @param  string[] $asBucket
	 *
	 * @return string
	 * @since 5.1.2
	 */
	private function buildGlobals(object $get, string $code, string $tab, array $asBucket): string
	{
		return $this->globals->get($get->global ?? [], '$item', $asBucket, $tab);
	}

	/**
	 * Build the custom join logic.
	 *
	 * @param  object   $get
	 * @param  string   $code
	 * @param  string   $tab
	 * @param  string[] $asBucket
	 *
	 * @return string
	 * @since 5.1.2
	 */
	private function buildCustomJoin(object $get, string $code, string $tab, array $asBucket): string
	{
		return $this->customjoin->get($get->custom_get ?? [], '$item', $code, $asBucket, $tab);
	}

	/**
	 * Build the custom calculation logic block.
	 *
	 * @param  object  $get
	 *
	 * @return string
	 * @since 5.1.2
	 */
	private function buildCalculation(object $get): string
	{
		if (isset($get->addcalculation) && $get->addcalculation == 1 && !empty($get->php_calculation))
		{
			$get->php_calculation = (array) explode(PHP_EOL, (string) $this->placeholder->update_($get->php_calculation));
			return PHP_EOL . Indent::_(4) . implode(PHP_EOL . Indent::_(4), $get->php_calculation);
		}
		return '';
	}

	/**
	 * Inject dispatcher logic if placeholder exists.
	 *
	 * @param  string  $getItem
	 * @param  string  $code
	 *
	 * @return string
	 * @since 5.1.2
	 */
	private function injectDispatcherIfNeeded(string $getItem, string $code): string
	{
		if (strpos($getItem, (string) Placefix::_h('DISPATCHER')) !== false)
		{
			return str_replace(
				Placefix::_h('DISPATCHER'),
				$this->eventdispatcher->get($code, ''),
				$getItem
			);
		}
		return $getItem;
	}
}

