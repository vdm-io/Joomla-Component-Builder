<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Component;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\AssetsTable as ExtendingAssetsTable;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\AssetsTableInterface;


/**
 * Component Assets Table Intelligent Fix Class for Joomla 3.
 * 
 * Joomla 3 carries the whole treatment in the generated script.php, so
 * the install and uninstall sides emit the column checks and ALTER
 * statements themselves through the shared code emitter.
 * 
 * @since  6.1.7
 */
final class AssetsTable extends ExtendingAssetsTable implements AssetsTableInterface
{
	/**
	 * Get the generated install treatment of the assets table.
	 *
	 * @param   int     $access_worse_case  The worst case permission rules size.
	 * @param   string  $data_type          The column data type the fix converts to.
	 *
	 * @return  string  The generated install treatment.
	 *
	 * @since   6.1.7
	 */
	protected function installScript(int $access_worse_case, string $data_type): string
	{
		// the if statement about $rule_length
		$codeIF = "\$rule_length <= " . $access_worse_case;
		// fix column size
		$script   = [];
		$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
			. " Fix the assets table rules column size";
		$script[] = Indent::_(5)
			. '$fix_rules_size = "ALTER TABLE `#__assets` CHANGE `rules` `rules` '
			. $data_type
			. ' NOT NULL COMMENT \'JSON encoded access control. Enlarged to '
			. $data_type . ' by JCB\';";';
		$script[] = Indent::_(5) . "\$db->setQuery(\$fix_rules_size);";
		$script[] = Indent::_(5) . "\$db->execute();";
		$codeA    = implode(PHP_EOL, $script);
		// fixed message
		$messageA = Indent::_(5)
			. "\$app->enqueueMessage(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('The <b>#__assets</b> table rules column was resized to the "
			. $data_type
			. " datatype for the components possible large permission rules.'));";
		// do nothing
		$codeB = "";
		// fix not needed so ignore
		$messageB = "";

		// done
		return $this->code(
			$codeIF, $codeA, $codeB, $messageA, $messageB, 2
		);
	}

	/**
	 * Get the generated uninstall treatment of the assets table.
	 *
	 * @return  string  The generated uninstall treatment.
	 *
	 * @since   6.1.7
	 */
	protected function uninstallScript(): string
	{
		// the if statement about $rule_length
		$codeIF = "\$rule_length < 5120";
		// reverse column size
		$script   = [];
		$script[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
			. " Revert the assets table rules column back to the default";
		$script[] = Indent::_(4)
			. '$revert_rule = "ALTER TABLE `#__assets` CHANGE `rules` `rules` varchar(5120) NOT NULL COMMENT \'JSON encoded access control.\';";';
		$script[] = Indent::_(4) . "\$db->setQuery(\$revert_rule);";
		$script[] = Indent::_(4) . "\$db->execute();";
		$codeA    = implode(PHP_EOL, $script);
		// reverted message
		$messageA = Indent::_(4)
			. "\$app->enqueueMessage(Text::_('COM_COMPONENTBUILDER_REVERTED_THE_B_ASSETSB_TABLE_RULES_COLUMN_BACK_TO_ITS_DEFAULT_SIZE_OF_VARCHARFIVE_THOUSAND_ONE_HUNDRED_AND_TWENTY'));";
		// do nothing
		$codeB = "";
		// not reverted message
		$messageB = Indent::_(4)
			. "\$app->enqueueMessage(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('Could not revert the <b>#__assets</b> table rules column back to its default size of varchar(5120), since there is still one or more components that still requires the column to be larger.'));";

		// done
		return $this->code(
			$codeIF, $codeA, $codeB, $messageA, $messageB
		);
	}

	/**
	 * Set code for both install, update and uninstall.
	 *
	 * @param   string  $codeIF    The IF code to fix this issue
	 * @param   string  $codeA     The a code to fix this issue
	 * @param   string  $codeB     The b code to fix this issue
	 * @param   string  $messageA  The fix a message
	 * @param   string  $messageB  The fix b message
	 * @param   int     $tab       The tab depth the code carries.
	 *
	 * @return  string  The generated treatment code.
	 *
	 * @since   6.1.7
	 */
	protected function code(string $codeIF, string $codeA, string $codeB,
		string $messageA, string $messageB, int $tab = 1
	): string
	{
		// reset script
		$script   = [];
		$script[] = Indent::_($tab) . Indent::_(1) . "//" . Line::_(
				__LINE__,__CLASS__
			)
			. " Get the biggest rule column in the assets table at this point.";
		$script[] = Indent::_($tab) . Indent::_(1)
			. '$get_rule_length = "SELECT CHAR_LENGTH(`rules`) as rule_size FROM #__assets ORDER BY rule_size DESC LIMIT 1";';
		$script[] = Indent::_($tab) . Indent::_(1)
			. "\$db->setQuery(\$get_rule_length);";
		$script[] = Indent::_($tab) . Indent::_(1) . "if (\$db->execute())";
		$script[] = Indent::_($tab) . Indent::_(1) . "{";
		$script[] = Indent::_($tab) . Indent::_(2)
			. "\$rule_length = \$db->loadResult();";
		// https://github.com/joomla/joomla-cms/blob/3.10.0-alpha3/installation/sql/mysql/joomla.sql#L22
		// Checked 1st December 2020 (let us know if this changes)
		$script[] = Indent::_($tab) . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			)
			. " Check the size of the rules column";
		$script[] = Indent::_($tab) . Indent::_(2) . "if (" . $codeIF . ")";
		$script[] = Indent::_($tab) . Indent::_(2) . "{";
		$script[] = $codeA;
		$script[] = $messageA;
		$script[] = Indent::_($tab) . Indent::_(2) . "}";
		// only ad this if there is a B part
		if (StringHelper::check($codeB)
			|| StringHelper::check($messageB))
		{
			$script[] = Indent::_($tab) . Indent::_(2) . "else";
			$script[] = Indent::_($tab) . Indent::_(2) . "{";
			$script[] = $codeB;
			$script[] = $messageB;
			$script[] = Indent::_($tab) . Indent::_(2) . "}";
		}
		$script[] = Indent::_($tab) . Indent::_(1) . "}";

		// done
		return PHP_EOL . implode(PHP_EOL, $script);
	}
}

