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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\EximportButtons as SharedEximportButtons;
use VDM\Joomla\Componentbuilder\Compiler\Builder\EximportView;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Joomla 3 Admin Views Eximport Buttons Class.
 * 
 * A Joomla 3 list view the component allows export or import on is given the
 * toolbar button that starts it, guarded by the permission it needs.
 * 
 * @since 6.1.7
 */
final class EximportButtons extends SharedEximportButtons
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Eximport View Builder Class.
	 *
	 * @var   EximportView
	 * @since 6.1.7
	 */
	protected EximportView $eximportview;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Language     $language     The Language Class.
	 * @param EximportView $eximportview The Eximport View Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Language $language,
		EximportView $eximportview)
	{
		$this->config = $config;
		$this->language = $language;
		$this->eximportview = $eximportview;
	}

	/**
	 * Build the export button of a list view that allows export.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The button.
	 *
	 * @since   6.1.7
	 */
	public function export($nameSingleCode, $nameListCode): string
	{
		$button = '';
		if ($this->eximportview->get($nameListCode))
		{
			// main lang prefix
			$langExport = $this->config->lang_prefix . '_'
				. StringHelper::safe('Export Data', 'U');
			// add to lang array
			$this->language->set($this->config->lang_target, $langExport, 'Export Data');
			$button   = [];
			$button[] = PHP_EOL . PHP_EOL . Indent::_(3)
				. "if (\$this->canDo->get('core.export') && \$this->canDo->get('"
				. $nameSingleCode . ".export'))";
			$button[] = Indent::_(3) . "{";
			$button[] = Indent::_(4) . "Joomla__"."_0c1a176a_304f_433a_8233_37d01ff87815___Power::custom('"
				. $nameListCode . ".exportData', 'download', '', '"
				. $langExport . "', true);";
			$button[] = Indent::_(3) . "}";

			return implode(PHP_EOL, $button);
		}

		return $button;
	}

	/**
	 * Build the import button of a list view that allows import.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The button.
	 *
	 * @since   6.1.7
	 */
	public function import($nameSingleCode, $nameListCode): string
	{
		$button = '';
		if ($this->eximportview->get($nameListCode))
		{
			// main lang prefix
			$langImport = $this->config->lang_prefix . '_'
				. StringHelper::safe('Import Data', 'U');
			// add to lang array
			$this->language->set($this->config->lang_target, $langImport, 'Import Data');
			$button   = [];
			$button[] = PHP_EOL . PHP_EOL . Indent::_(2)
				. "if (\$this->canDo->get('core.import') && \$this->canDo->get('"
				. $nameSingleCode . ".import'))";
			$button[] = Indent::_(2) . "{";
			$button[] = Indent::_(3) . "Joomla__"."_0c1a176a_304f_433a_8233_37d01ff87815___Power::custom('"
				. $nameListCode . ".importData', 'upload', '', '"
				. $langImport
				. "', false);";
			$button[] = Indent::_(2) . "}";

			return implode(PHP_EOL, $button);
		}

		return $button;
	}
}

