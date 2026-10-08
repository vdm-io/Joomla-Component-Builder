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
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUninstall;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Component Uninstall Sql Class.
 * 
 * Generates the uninstall.sql of the component: the drop statements the
 * database uninstall builder gathered, the component's own custom sql
 * uninstall dump, and the assets table reversals when the component
 * compiled with the sql fix option.
 * 
 * @since  6.1.7
 */
class UninstallSql
{
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
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The DatabaseUninstall Class.
	 *
	 * @var   DatabaseUninstall
	 * @since 6.1.7
	 */
	protected DatabaseUninstall $databaseuninstall;

	/**
	 * Constructor.
	 *
	 * @param Config             $config              The Config Class.
	 * @param Placeholder        $placeholder         The Placeholder Class.
	 * @param Dispenser          $dispenser           The Dispenser Class.
	 * @param DatabaseUninstall  $databaseuninstall   The DatabaseUninstall Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		Dispenser $dispenser, DatabaseUninstall $databaseuninstall)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->dispenser = $dispenser;
		$this->databaseuninstall = $databaseuninstall;
	}

	/**
	 * Get the generated uninstall.sql content of the component.
	 *
	 * A component that gathered nothing to drop and carries no custom
	 * sql uninstall dump quietly produces an empty string.
	 *
	 * @return  string  The generated uninstall sql.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		$db = '';
		if ($this->databaseuninstall->isArray('table'))
		{
			$db .= implode(PHP_EOL, $this->databaseuninstall->get('table')) . PHP_EOL;
		}
		// add custom sql uninstall dump to the file
		if (isset($this->dispenser->hub['sql_uninstall'])
			&& StringHelper::check(
				$this->dispenser->hub['sql_uninstall']
			))
		{
			$db .= $this->placeholder->update_(
					$this->dispenser->hub['sql_uninstall']
				) . PHP_EOL;
			unset($this->dispenser->hub['sql_uninstall']);
		}

		// check if this component used larger rules
		// now revert them back on uninstall
		// only add this option if set to SQL fix
		if ($this->config->add_assets_table_fix == 1)
		{
			// https://github.com/joomla/joomla-cms/blob/3.10.0-alpha3/installation/sql/mysql/joomla.sql#L22
			// Checked 1st December 2020 (let us know if this changes)
			$db .= PHP_EOL;
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. '--' . Line::_(
					__LINE__,__CLASS__
				)
				. ' Always insure this column rules is reversed to Joomla defaults on uninstall. (as on 1st Dec 2020)';
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. "ALTER TABLE `#__assets` CHANGE `rules` `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.';";
		}

		// check if this component used larger names
		// now revert them back on uninstall
		// only add this option if set to SQL fix
		if ($this->config->add_assets_table_fix == 1 && $this->config->add_assets_table_name_fix)
		{
			// https://github.com/joomla/joomla-cms/blob/3.10.0-alpha3/installation/sql/mysql/joomla.sql#L20
			// Checked 1st December 2020 (let us know if this changes)
			$db .= PHP_EOL;
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. '--' . Line::_(
					__LINE__,__CLASS__
				)
				. ' Always insure this column name is reversed to Joomla defaults on uninstall. (as on 1st Dec 2020).';
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. "ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';";
		}

		return $db;
	}
}

