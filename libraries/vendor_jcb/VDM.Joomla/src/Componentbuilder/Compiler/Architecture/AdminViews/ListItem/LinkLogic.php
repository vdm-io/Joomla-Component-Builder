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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * List Item Link Logic Class
 * 
 * @since 5.1.5
 */
final class LinkLogic
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.5
	 */
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param   Config  $config  The Config Class.
	 *
	 * @since  5.1.5
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Get the list item link logic.
	 *
	 * @param   array   $item               The item.
	 * @param   string  $itemCode           The item code string.
	 * @param   string  $itemLink           The item link string.
	 * @param   string  $itemLinkAuthority  The link authority string.
	 * @param   string  $nameSingleCode     The single view code name.
	 * @param   string  $nameListCode       The list view code name.
	 * @param   string  $classPointer       The class pointer.
	 * @param   bool    $checkoutTriger     The check out trigger.
	 * @param   bool    $class              The div class adding switch.
	 *
	 * @return  string  The complete link logic of row item.
	 * @since   5.1.5
	 */
	public function get(
		array $item,
		string $itemCode,
		string $itemLink,
		string $itemLinkAuthority,
		string $nameSingleCode,
		string $nameListCode,
		string $classPointer,
		bool $checkoutTriger,
		bool $class = true
	): string
	{
		$code = (string) ($item['code'] ?? '');
		$tab = $this->getWrapperTab($class);

		$link = $this->openNameWrapper($class);
		$link .= $this->buildAuthorizedLinkBlock(
			$itemCode,
			$itemLink,
			$itemLinkAuthority,
			$nameSingleCode,
			$nameListCode,
			$classPointer,
			$checkoutTriger,
			$code,
			$tab
		);
		$link .= $this->closeNameWrapper($class);

		return $link;
	}

	/**
	 * Open the name wrapper when enabled.
	 *
	 * @param   bool  $class  The div class adding switch.
	 *
	 * @return  string  The opening wrapper markup or empty string.
	 * @since   5.1.5
	 */
	protected function openNameWrapper(bool $class): string
	{
		if (!$class)
		{
			return '';
		}

		return PHP_EOL . Indent::_(3) . '<div class="name">';
	}

	/**
	 * Close the name wrapper when enabled.
	 *
	 * @param   bool  $class  The div class adding switch.
	 *
	 * @return  string  The closing wrapper markup or empty string.
	 * @since   5.1.5
	 */
	protected function closeNameWrapper(bool $class): string
	{
		if (!$class)
		{
			return '';
		}

		return PHP_EOL . Indent::_(3) . '</div>';
	}

	/**
	 * Get the wrapper indentation prefix.
	 *
	 * @param   bool  $class  The div class adding switch.
	 *
	 * @return  string  The indentation prefix.
	 * @since   5.1.5
	 */
	protected function getWrapperTab(bool $class): string
	{
		return $class ? Indent::_(1) : '';
	}

	/**
	 * Build the main authorized link block.
	 *
	 * @param   string  $itemCode           The item code string.
	 * @param   string  $itemLink           The item link string.
	 * @param   string  $itemLinkAuthority  The link authority string.
	 * @param   string  $nameSingleCode     The single view code name.
	 * @param   string  $nameListCode       The list view code name.
	 * @param   string  $classPointer       The class pointer.
	 * @param   bool    $checkoutTriger     The check out trigger.
	 * @param   string  $code               The item field code.
	 * @param   string  $tab                The indentation prefix.
	 *
	 * @return  string  The built authorized link block.
	 * @since   5.1.5
	 */
	protected function buildAuthorizedLinkBlock(
		string $itemCode,
		string $itemLink,
		string $itemLinkAuthority,
		string $nameSingleCode,
		string $nameListCode,
		string $classPointer,
		bool $checkoutTriger,
		string $code,
		string $tab
	): string
	{
		$link = '';

		$link .= PHP_EOL . $tab . Indent::_(3) . "<?php if (" . $itemLinkAuthority . "): ?>";
		$link .= PHP_EOL . $tab . Indent::_(4) . '<a href="' . $itemLink . '"><?php echo ' . $itemCode . '; ?></a>';

		if ($checkoutTriger)
		{
			$link .= $this->buildCheckedOutBlock($nameListCode, $tab);
		}

		$link .= PHP_EOL . $tab . Indent::_(3) . "<?php else: ?>";
		$link .= $this->buildUnauthorizedOutput(
			$itemCode,
			$nameSingleCode,
			$classPointer,
			$code,
			$tab,
			$checkoutTriger
		);
		$link .= PHP_EOL . $tab . Indent::_(3) . "<?php endif; ?>";

		return $link;
	}

	/**
	 * Build the checked out block.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 * @param   string  $tab           The indentation prefix.
	 *
	 * @return  string  The checked out block.
	 * @since   5.1.5
	 */
	protected function buildCheckedOutBlock(string $nameListCode, string $tab): string
	{
		$link = '';

		$link .= PHP_EOL . $tab . Indent::_(4) . "<?php if (\$item->checked_out): ?>";
		$link .= PHP_EOL . $tab . Indent::_(5)
			. "<?php echo Joomla__"
			. "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('jgrid.checkedout', \$i, \$userChkOut->name, \$item->checked_out_time, '"
			. $nameListCode
			. ".', \$canCheckin); ?>";
		$link .= PHP_EOL . $tab . Indent::_(4) . "<?php endif; ?>";

		return $link;
	}

	/**
	 * Build the unauthorized output block.
	 *
	 * @param   string  $itemCode        The item code string.
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $classPointer    The class pointer.
	 * @param   string  $code            The item field code.
	 * @param   string  $tab             The indentation prefix.
	 * @param   bool    $checkoutTriger  The check out trigger.
	 *
	 * @return  string  The unauthorized output block.
	 * @since   5.1.5
	 */
	protected function buildUnauthorizedOutput(
		string $itemCode,
		string $nameSingleCode,
		string $classPointer,
		string $code,
		string $tab,
		bool $checkoutTriger
	): string
	{
		if ($this->shouldApplyModalFix($checkoutTriger))
		{
			return $this->buildModalAwareOutput(
				$itemCode,
				$nameSingleCode,
				$classPointer,
				$code,
				$tab
			);
		}

		return PHP_EOL . $tab . Indent::_(4) . "<?php echo " . $itemCode . "; ?>";
	}

	/**
	 * Determine whether the modal fix should be applied.
	 *
	 * @param   bool  $checkoutTriger  The check out trigger.
	 *
	 * @return  bool  True if the modal fix should be applied.
	 * @since   5.1.5
	 */
	protected function shouldApplyModalFix(bool $checkoutTriger): bool
	{
		return $checkoutTriger
			&& $this->config->get('joomla_version', 3) !== 3;
	}

	/**
	 * Build the modal aware unauthorized output.
	 *
	 * @param   string  $itemCode        The item code string.
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $classPointer    The class pointer.
	 * @param   string  $code            The item field code.
	 * @param   string  $tab             The indentation prefix.
	 *
	 * @return  string  The modal aware output block.
	 * @since   5.1.5
	 */
	protected function buildModalAwareOutput(
		string $itemCode,
		string $nameSingleCode,
		string $classPointer,
		string $code,
		string $tab
	): string
	{
		$link = '';

		$link .= PHP_EOL . $tab . Indent::_(4) . "<?php if (!{$classPointer}isModal): ?>";
		$link .= PHP_EOL . $tab . Indent::_(5) . "<?php echo " . $itemCode . "; ?>";
		$link .= PHP_EOL . $tab . Indent::_(4) . "<?php else: ?>";
		$link .= $this->buildModalSelectionBlock($nameSingleCode, $classPointer, $code, $tab, $itemCode);
		$link .= PHP_EOL . $tab . Indent::_(4) . "<?php endif; ?>";

		return $link;
	}

	/**
	 * Build the modal selection block.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $classPointer    The class pointer.
	 * @param   string  $code            The item field code.
	 * @param   string  $tab             The indentation prefix.
	 * @param   string  $itemCode        The item code string.
	 *
	 * @return  string  The modal selection block.
	 * @since   5.1.5
	 */
	protected function buildModalSelectionBlock(
		string $nameSingleCode,
		string $classPointer,
		string $code,
		string $tab,
		string $itemCode
	): string
	{
		$link = '';

		$link .= PHP_EOL . $tab . Indent::_(5) . "<?php";
		$link .= PHP_EOL . $tab . Indent::_(6) . "\$link = \"{\$edit}&id={\$item->id}\";";
		$link .= PHP_EOL . $tab . Indent::_(6) . "\$dataId = \$item->{{$classPointer}getModalTitleKey()} ?? 0;";
		$link .= PHP_EOL . $tab . Indent::_(6)
			. "\$itemHtml = '<a href=\"' . {$classPointer}escape(\$link, false) . '\">' . {$classPointer}escape(\$item->{$code}, false) . '</a>';";
		$link .= PHP_EOL . $tab . Indent::_(6)
			. "\$attribs = 'data-content-select data-content-type=\"com_"
			. $this->config->component_code_name
			. "."
			. $nameSingleCode
			. "\"'";
		$link .= PHP_EOL . $tab . Indent::_(7) . ". ' data-id=\"' . \$dataId . '\"'";
		$link .= PHP_EOL . $tab . Indent::_(7) . ". ' data-title=\"' . {$classPointer}escape(\$item->{$code}, false) . '\"'";
		$link .= PHP_EOL . $tab . Indent::_(7) . ". ' data-uri=\"' . {$classPointer}escape(\$link, false) . '\"'";
		$link .= PHP_EOL . $tab . Indent::_(7) . ". ' data-html=\"' . {$classPointer}escape(\$itemHtml, false) . '\"';";
		$link .= PHP_EOL . $tab . Indent::_(5) . "?>";
		$link .= PHP_EOL . $tab . Indent::_(5) . "<a class=\"select-link\" href=\"javascript:void(0)\" <?php echo \$attribs; ?>>";
		$link .= PHP_EOL . $tab . Indent::_(6) . "<?php echo " . $itemCode . "; ?>";
		$link .= PHP_EOL . $tab . Indent::_(5) . "</a>";

		return $link;
	}
}

