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
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\InstallSql as ExtendingInstallSql;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\InstallSqlInterface;


/**
 * Component Install Sql Class for Joomla 3.
 * 
 * Joomla 3 carries no sql header and keeps the zero-date defaults its
 * database accepted, so its default column definitions differ from the
 * shared form.
 * 
 * @since  6.1.7
 */
final class InstallSql extends ExtendingInstallSql implements InstallSqlInterface
{
	/**
	 * Get the sql header of the install.sql.
	 *
	 * Joomla 3 carries no header.
	 *
	 * @return  string  The generated sql header.
	 *
	 * @since   6.1.7
	 */
	protected function header(): string
	{
		return '';
	}

	/**
	 * Get the default created_by column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function createdByColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`created_by` INT(10) unsigned NULL DEFAULT 0,";
	}

	/**
	 * Get the default modified_by column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function modifiedByColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`modified_by` INT(10) unsigned NULL DEFAULT 0,";
	}

	/**
	 * Get the default created column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function createdColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`created` DATETIME NULL DEFAULT '0000-00-00 00:00:00',";
	}

	/**
	 * Get the default modified column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function modifiedColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`modified` DATETIME NULL DEFAULT '0000-00-00 00:00:00',";
	}

	/**
	 * Get the default checked_out column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function checkedOutColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`checked_out` int(11) unsigned NULL DEFAULT 0,";
	}

	/**
	 * Get the default checked_out_time column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function checkedOutTimeColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`checked_out_time` DATETIME NULL DEFAULT '0000-00-00 00:00:00',";
	}

	/**
	 * Get the default metakey column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function metakeyColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`metakey` TEXT NULL,";
	}

	/**
	 * Get the default metadesc column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function metadescColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`metadesc` TEXT NULL,";
	}

	/**
	 * Get the default metadata column definition.
	 *
	 * @return  string  The generated column definition.
	 *
	 * @since   6.1.7
	 */
	protected function metadataColumn(): string
	{
		return PHP_EOL . Indent::_(1)
			. "`metadata` TEXT NULL,";
	}
}

