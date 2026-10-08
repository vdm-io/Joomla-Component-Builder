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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\AssetsTableInterface;


/**
 * Component Assets Table Intelligent Fix Class.
 * 
 * Generates the script.php treatment of the `#__assets` table rules
 * column when the component compiles with the intelligent fix option.
 * The install side enlarges the column to carry the component's worst
 * case permission rules, and the uninstall side reverts it. Joomla
 * target variants supply the target-specific treatment through the
 * `installScript()` and `uninstallScript()` extension points.
 * 
 * @since  6.1.7
 */
class AssetsTable implements AssetsTableInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param Config   $config   The Config Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Get the script.php code for the assets table intelligent fix.
	 *
	 * When the intelligent fix option is inactive an empty string is
	 * returned.
	 *
	 * @return  string  The php to place in script.php, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function install(): string
	{
		// WHY DO WE NEED AN ASSET TABLE FIX?
		// https://www.mysqltutorial.org/mysql-varchar/
		// https://stackoverflow.com/a/15227917/1429677
		// https://forums.mysql.com/read.php?24,105964,105964
		// https://git.vdm.dev/joomla/Component-Builder/issues/616#issuecomment-12085
		// 30 actions each +-20 characters with 8 groups
		// that makes 4800 characters and the current Joomla
		// column size is varchar(5120)

		// check if we should add the intelligent fix treatment for the assets table
		if ($this->config->add_assets_table_fix == 2)
		{
			// get worse case
			$access_worse_case = $this->config->get('access_worse_case', 0);
			// get the type we will convert to
			$data_type = ($access_worse_case > 64000) ? "MEDIUMTEXT"
				: "TEXT";

			return $this->installScript($access_worse_case, $data_type);
		}

		return '';
	}

	/**
	 * Get the script.php code for the assets table intelligent reversal.
	 *
	 * When the intelligent fix option is inactive an empty string is
	 * returned.
	 *
	 * @return  string  The php to place in script.php, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function uninstall(): string
	{
		// check if we should add the intelligent uninstall treatment for the assets table
		if ($this->config->add_assets_table_fix == 2)
		{
			return $this->uninstallScript();
		}

		return '';
	}

	/**
	 * Get the generated install treatment of the assets table.
	 *
	 * Joomla 4 and later carry the treatment in the script.php helper
	 * methods, so the generated code only calls the fix with the
	 * component's worst case.
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
		$script   = [];
		$script[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Fix the assets table rules column size.";
		$script[] = Indent::_(3) . '$this->setDatabaseAssetsRulesFix('
			. (int) $access_worse_case . ', "' . $data_type . '");';

		return PHP_EOL . implode(PHP_EOL, $script);
	}

	/**
	 * Get the generated uninstall treatment of the assets table.
	 *
	 * Joomla 4 and later carry the treatment in the script.php helper
	 * methods, so the generated code only calls the removal.
	 *
	 * @return  string  The generated uninstall treatment.
	 *
	 * @since   6.1.7
	 */
	protected function uninstallScript(): string
	{
		$script   = [];
		$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Revert the assets table rules column back to the default.";
		$script[] = Indent::_(2) . '$this->removeDatabaseAssetsRulesFix();';

		return PHP_EOL . implode(PHP_EOL, $script);
	}
}

