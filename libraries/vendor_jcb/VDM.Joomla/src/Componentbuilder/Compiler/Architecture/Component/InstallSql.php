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
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ComponentFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseKeys;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseTables;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUninstall;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueKeys;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MetaData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MysqlTableSetting;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UpdateMysql;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\InstallSqlInterface;


/**
 * Component Install Sql Class.
 * 
 * Generates the install.sql of the component: a create statement per
 * active database table with the component's fields and the default
 * columns not overwritten, the keys, the gathered update sql, the
 * component's own custom sql dump, and the assets table enlargements
 * when the component compiled with the sql fix option. Joomla target
 * variants supply the sql header and the default column definitions
 * through extension points.
 * 
 * @since  6.1.7
 */
class InstallSql implements InstallSqlInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 6.1.7
	 */
	protected Registry $registry;

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
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 6.1.7
	 */
	protected Counter $counter;

	/**
	 * The DatabaseTables Class.
	 *
	 * @var   DatabaseTables
	 * @since 6.1.7
	 */
	protected DatabaseTables $databasetables;

	/**
	 * The DatabaseUninstall Class.
	 *
	 * @var   DatabaseUninstall
	 * @since 6.1.7
	 */
	protected DatabaseUninstall $databaseuninstall;

	/**
	 * The UpdateMysql Class.
	 *
	 * @var   UpdateMysql
	 * @since 6.1.7
	 */
	protected UpdateMysql $updatemysql;

	/**
	 * The FieldNames Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * The AccessSwitch Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The ComponentFields Class.
	 *
	 * @var   ComponentFields
	 * @since 6.1.7
	 */
	protected ComponentFields $componentfields;

	/**
	 * The MetaData Class.
	 *
	 * @var   MetaData
	 * @since 6.1.7
	 */
	protected MetaData $metadata;

	/**
	 * The DatabaseUniqueKeys Class.
	 *
	 * @var   DatabaseUniqueKeys
	 * @since 6.1.7
	 */
	protected DatabaseUniqueKeys $databaseuniquekeys;

	/**
	 * The DatabaseKeys Class.
	 *
	 * @var   DatabaseKeys
	 * @since 6.1.7
	 */
	protected DatabaseKeys $databasekeys;

	/**
	 * The MysqlTableSetting Class.
	 *
	 * @var   MysqlTableSetting
	 * @since 6.1.7
	 */
	protected MysqlTableSetting $mysqltablesetting;

	/**
	 * Constructor.
	 *
	 * @param Config              $config               The Config Class.
	 * @param Registry            $registry             The Registry Class.
	 * @param Placeholder         $placeholder          The Placeholder Class.
	 * @param Dispenser           $dispenser            The Dispenser Class.
	 * @param Counter             $counter              The Counter Class.
	 * @param DatabaseTables      $databasetables       The DatabaseTables Class.
	 * @param DatabaseUninstall   $databaseuninstall    The DatabaseUninstall Class.
	 * @param UpdateMysql         $updatemysql          The UpdateMysql Class.
	 * @param FieldNames          $fieldnames           The FieldNames Class.
	 * @param AccessSwitch        $accessswitch         The AccessSwitch Class.
	 * @param ComponentFields     $componentfields      The ComponentFields Class.
	 * @param MetaData            $metadata             The MetaData Class.
	 * @param DatabaseUniqueKeys  $databaseuniquekeys   The DatabaseUniqueKeys Class.
	 * @param DatabaseKeys        $databasekeys         The DatabaseKeys Class.
	 * @param MysqlTableSetting   $mysqltablesetting    The MysqlTableSetting Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Registry $registry,
		Placeholder $placeholder, Dispenser $dispenser, Counter $counter,
		DatabaseTables $databasetables, DatabaseUninstall $databaseuninstall,
		UpdateMysql $updatemysql, FieldNames $fieldnames,
		AccessSwitch $accessswitch, ComponentFields $componentfields,
		MetaData $metadata, DatabaseUniqueKeys $databaseuniquekeys,
		DatabaseKeys $databasekeys, MysqlTableSetting $mysqltablesetting)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->placeholder = $placeholder;
		$this->dispenser = $dispenser;
		$this->counter = $counter;
		$this->databasetables = $databasetables;
		$this->databaseuninstall = $databaseuninstall;
		$this->updatemysql = $updatemysql;
		$this->fieldnames = $fieldnames;
		$this->accessswitch = $accessswitch;
		$this->componentfields = $componentfields;
		$this->metadata = $metadata;
		$this->databaseuniquekeys = $databaseuniquekeys;
		$this->databasekeys = $databasekeys;
		$this->mysqltablesetting = $mysqltablesetting;
	}

	/**
	 * Get the generated install.sql content of the component.
	 *
	 * A component with no active database tables quietly produces an
	 * empty string.
	 *
	 * @return  string  The generated install sql.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		if (($database_tables = $this->databasetables->allActive()) !== [])
		{
			// set the main db prefix
			$component = $this->config->component_code_name;
			// start building the db
			$db = '';
			$db .= $this->header();

			foreach ($database_tables as $view => $fields)
			{
				// cast the object to an array TODO we must update all to use the object
				$fields = (array) $fields;
				// build the uninstallation array
				$this->databaseuninstall->add('table', "DROP TABLE IF EXISTS `#__"
					. $component . "_" . $view . "`;");

				// setup the table DB string
				$db_ = '';
				$db_ .= "CREATE TABLE IF NOT EXISTS `#__" . $component . "_"
					. $view . "` (";
				// check if the table name has changed
				if (($old_table_name = $this->registry->
					get('builder.update_sql.table_name.' . $view . '.old', null)) !== null)
				{
					$key_ = "RENAMETABLE`#__" . $component . "_" . $old_table_name . "`";
					$value_ = "RENAME TABLE `#__" . $component . "_" . $old_table_name . "` to `#__"
						. $component . "_" . $view . "`;";

					$this->updatemysql->set($key_, $value_);
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.id'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`id` INT(11) NOT NULL AUTO_INCREMENT,";
				}
				$db_ .= PHP_EOL . Indent::_(1)
					. "`asset_id` INT(10) unsigned NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',";
				ksort($fields);
				$last_name = 'asset_id';
				foreach ($fields as $field => $data)
				{
					// cast the object to an array TODO we must update all to use the object
					$data = (array) $data;
					// set default
					$default = $data['default'];
					if ($default === 'Other')
					{
						$default = $data['other'];
					}
					// to get just null value add EMPTY to other value.
					if ($default === 'EMPTY')
					{
						$default = $data['null_switch'];
					}
					elseif ($default === 'DATETIME'
						|| $default === 'CURRENT_TIMESTAMP')
					{
						$default = $data['null_switch'] . ' DEFAULT '
							. $default;
					}
					elseif (is_numeric($default))
					{
						$default = $data['null_switch'] . " DEFAULT "
							. $default;
					}
					else
					{
						$default = $data['null_switch'] . " DEFAULT '"
							. $default . "'";
					}

					// set the length (lenght) <-- TYPO :: LVDM :: DON'T TOUCH
					$length = '';
					if (isset($data['lenght']) && $data['lenght'] === 'Other'
						&& isset($data['lenght_other'])
						&& $data['lenght_other'] > 0)
					{
						$length = '(' . $data['lenght_other'] . ')';
					}
					elseif (isset($data['lenght']) && $data['lenght'] > 0)
					{
						$length = '(' . $data['lenght'] . ')';
					}
					// set the field to db
					$db_ .= PHP_EOL . Indent::_(1) . "`" . $field . "` "
						. $data['type'] . $length . " " . $default . ",";
					// check if this a new field that should be added via SQL update
					if ($this->registry->
						get('builder.add_sql.field.' . $view . '.' . $data['GUID'], null))
					{
						// to soon....
						// $key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`ADDCOLUMNIFNOTEXISTS`" . $field . "`";
						// $value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` ADD COLUMN IF NOT EXISTS `" . $field . "` " . $data['type']
						//	. length . " " . $default . " AFTER `" . $last_name . "`;";
						$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`ADD`" . $field . "`";
						$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` ADD `" . $field . "` " . $data['type']
							. $length . " " . $default . " AFTER `" . $last_name . "`;";

						$this->updatemysql->set($key_, $value_);
					}
					// check if the field has changed name and/or data type and lenght
					elseif ($this->registry->
						get('builder.update_sql.field.datatype.' . $view . '.' . $field, null)
						|| $this->registry->
						get('builder.update_sql.field.lenght.' . $view . '.' . $field, null)
						|| $this->registry->
						get('builder.update_sql.field.name.' . $view . '.' . $field, null))
					{
						// if the name changed
						if (($oldName = $this->registry->
							get('builder.update_sql.field.name.' . $view . '.' . $field . '.old', null)) === null)
						{
							$oldName = $field;
						}

						// now set the update SQL
						$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`CHANGE`" . $oldName . "``"
							. $field . "`";
						$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` CHANGE `" . $oldName . "` `"
							. $field . "` " . $data['type'] . $length . " " . $default . ";";

						$this->updatemysql->set($key_, $value_);
					}
					// be sure to track the last name used :)
					$last_name = $field;
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.params'))
				{
					$db_ .= PHP_EOL . Indent::_(1) . "`params` TEXT NULL,";
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.published'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`published` TINYINT(3) NULL DEFAULT 1,";
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.created_by'))
				{
					$db_ .= $this->createdByColumn();
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.modified_by'))
				{
					$db_ .= $this->modifiedByColumn();
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.created'))
				{
					$db_ .= $this->createdColumn();
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.modified'))
				{
					$db_ .= $this->modifiedColumn();
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.checked_out'))
				{
					$db_ .= $this->checkedOutColumn();
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.checked_out_time'))
				{
					$db_ .= $this->checkedOutTimeColumn();
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.version'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`version` INT(10) unsigned NULL DEFAULT 1,";
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.hits'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`hits` INT(10) unsigned NULL DEFAULT 0,";
				}
				// check if view has access
				if ($this->accessswitch->exists($view)
					&& !$this->fieldnames->isString($view . '.access'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`access` INT(10) unsigned NULL DEFAULT 0,";
						// add to component dynamic fields
						$this->componentfields->set($view . '.access',
							[
								'name' => 'access',
								'label' => 'Access',
								'type' => 'accesslevel',
								'title' => false,
								'store' => NULL,
								'tab_name' => NULL,
								'db' => [
									'type' => 'INT(10) unsigned',
									'default' => '0',
									'key' => true,
									'null_switch' => 'NULL'
								]
							]
						);
				}
				// check if default field was overwritten
				if (!$this->fieldnames->isString($view . '.ordering'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`ordering` INT(11) NULL DEFAULT 0,";
				}
				// check if metadata is added to this view
				if ($this->metadata->isString($view))
				{
					// check if default field was overwritten
					if (!$this->fieldnames->isString($view . '.metakey'))
					{
						$db_ .= $this->metakeyColumn();
					}
					// check if default field was overwritten
					if (!$this->fieldnames->isString($view . '.metadesc'))
					{
						$db_ .= $this->metadescColumn();
					}
					// check if default field was overwritten
					if (!$this->fieldnames->isString($view . '.metadata'))
					{
						$db_ .= $this->metadataColumn();
					}
					// add to component dynamic fields
					$this->componentfields->set($view . '.metakey',
						[
							'name' => 'metakey',
							'label' => 'Meta Keywords',
							'type' => 'textarea',
							'title' => false,
							'store' => NULL,
							'tab_name' => 'publishing',
							'db' => [
								'type' => 'TEXT'
							]
						]
					);
					$this->componentfields->set($view . '.metadesc',
						[
							'name' => 'metadesc',
							'label' => 'Meta Description',
							'type' => 'textarea',
							'title' => false,
							'store' => NULL,
							'tab_name' => 'publishing',
							'db' => [
								'type' => 'TEXT'
							]
						]
					);
					$this->componentfields->set($view . '.metadata',
						[
							'name' => 'metadata',
							'label' => 'Meta Data',
							'type' => NULL,
							'title' => false,
							'store' => 'json',
							'tab_name' => 'publishing',
							'db' => [
								'type' => 'TEXT'
							]
						]
					);
				}
				// TODO (we may want this to be dynamicly set)
				$db_ .= PHP_EOL . Indent::_(1) . "PRIMARY KEY  (`id`)";
				// check if a key was set for any of the default fields then we should not set it again
				$check_keys_set = [];
				if ($this->databaseuniquekeys->exists($view))
				{
					foreach ($this->databaseuniquekeys->get($view) as $nr => $key)
					{
						$db_ .= "," . PHP_EOL . Indent::_(1)
							. "UNIQUE KEY `idx_" . $key . "` (`" . $key . "`)";
						$check_keys_set[$key] = $key;
					}
				}
				if ($this->databasekeys->exists($view))
				{
					foreach ($this->databasekeys->get($view) as $nr => $key)
					{
						$db_ .= "," . PHP_EOL . Indent::_(1)
							. "KEY `idx_" . $key . "` (`" . $key . "`)";
						$check_keys_set[$key] = $key;
					}
				}
				// check if view has access
				if (!isset($check_keys_set['access'])
					&& $this->accessswitch->exists($view))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_access` (`access`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['checked_out']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_checkout` (`checked_out`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['created_by']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_createdby` (`created_by`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['modified_by']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_modifiedby` (`modified_by`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['published']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_state` (`published`)";
				}
				// easy bucket
				$easy = [];
				// get the mysql table settings
				foreach (
					$this->config->mysql_table_keys as $_mysqlTableKey => $_mysqlTableVal
				)
				{
					if (($easy[$_mysqlTableKey] = $this->mysqltablesetting->
						get($view . '.' . $_mysqlTableKey)) === null)
					{
						$easy[$_mysqlTableKey]
							= $this->config->mysql_table_keys[$_mysqlTableKey]['default'];
					}
				}
				// add a little fix for the row_format
				if (StringHelper::check($easy['row_format']))
				{
					$easy['row_format'] = ' ROW_FORMAT=' . $easy['row_format'];
				}
				// now build db string
				$db_ .= PHP_EOL . ") ENGINE=" . $easy['engine']
					. " AUTO_INCREMENT=0 DEFAULT CHARSET=" . $easy['charset']
					. " DEFAULT COLLATE=" . $easy['collate']
					. $easy['row_format'] . ";";

				// check if this is a new table that should be added via update SQL
				if ($this->registry->
					get('builder.add_sql.adminview.' . $view, null))
				{
					// build the update array
					$key_ = "CREATETABLEIFNOTEXISTS`#__" . $component . "_" . $view . "`";
					$this->updatemysql->set($key_, $db_);
				}
				// check if the table row_format has changed
				if (StringHelper::check($easy['row_format'])
					&& $this->registry->
					get('builder.update_sql.table_row_format.' . $view, null))
				{
					// build the update array
					$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`" . trim((string) $easy['row_format']);
					$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "`" . $easy['row_format'] . ";";
					$this->updatemysql->set($key_, $value_);
				}
				// check if the table engine has changed
				if ($this->registry->
					get('builder.update_sql.table_engine.' . $view, null))
				{
					// build the update array
					$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`ENGINE=" . $easy['engine'];
					$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` ENGINE = " . $easy['engine'] . ";";
					$this->updatemysql->set($key_, $value_);
				}
				// check if the table charset OR collation has changed (must be updated together)
				if ($this->registry->
					get('builder.update_sql.table_charset.' . $view, null)
					|| $this->registry->
					get('builder.update_sql.table_collate.' . $view, null))
				{
					// build the update array
					$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "CONVERTTOCHARACTERSET"
						. $easy['charset'] . "COLLATE" . $easy['collate'];
					$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` CONVERT TO CHARACTER SET "
						. $easy['charset'] . " COLLATE " . $easy['collate'] . ";";

					$this->updatemysql->set($key_, $value_);
				}

				// add to main DB string
				$db .= $db_ . PHP_EOL . PHP_EOL;
			}

			// add custom sql dump to the file
			if (isset($this->dispenser->hub['sql'])
				&& ArrayHelper::check(
					$this->dispenser->hub['sql']
				))
			{
				foreach ($this->dispenser->hub['sql'] as $for => $customSql)
				{
					$placeholders = [
						Placefix::_('component') => $component,
						Placefix::_('view') => $for
					]; // dont change this just use ###view### or componentbuilder (took you a while to get here right :)

					$db .= $this->placeholder->update(
						$customSql, $placeholders
					) . PHP_EOL . PHP_EOL;
				}

				unset($this->dispenser->hub['sql']);
			}

			// WHY DO WE NEED AN ASSET TABLE FIX?
			// https://www.mysqltutorial.org/mysql-varchar/
			// https://stackoverflow.com/a/15227917/1429677
			// https://forums.mysql.com/read.php?24,105964,105964
			// https://github.com/vdm-io/Joomla-Component-Builder/issues/616#issuecomment-741502980
			// 30 actions each +-20 characters with 8 groups
			// that makes 4800 characters and the current Joomla
			// column size is varchar(5120)

			// just a little event tracking in classes
			// count actions = setAccessSections
			//                 around line206 (infusion call)
			//                 around line26454 (interpretation function)
			// first fix = setInstall
			//                 around line1600 (infusion call)
			//                 around line10063 (interpretation function)
			// second fix = setUninstallScript
			//                 around line2161 (infusion call)
			//                 around line8030 (interpretation function)

			// check if this component needs larger rules
			// also check if the developer will allow this
			// the access actions length must be checked before this
			// only add this option if set to SQL fix
			if ($this->config->add_assets_table_fix == 1)
			{
				// 400 actions worse case is larger the 65535 characters
				if ($this->counter->accessSize > 400)
				{
					$db .= PHP_EOL;
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. '--' . Line::_(
							__LINE__,__CLASS__
						)
						. ' Always insure this column rules is large enough for all the access control values.';
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. "ALTER TABLE `#__assets` CHANGE `rules` `rules` MEDIUMTEXT NOT NULL COMMENT 'JSON encoded access control. Enlarged to MEDIUMTEXT by JCB';";
				}
				// smaller then 400 makes TEXT large enough
				elseif ($this->config->add_assets_table_fix == 1)
				{
					$db .= PHP_EOL;
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. '--' . Line::_(
							__LINE__,__CLASS__
						)
						. ' Always insure this column rules is large enough for all the access control values.';
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. "ALTER TABLE `#__assets` CHANGE `rules` `rules` TEXT NOT NULL COMMENT 'JSON encoded access control. Enlarged to TEXT by JCB';";
				}
			}

			// check if this component needs larger names
			// also check if the developer will allow this
			// the config length must be checked before this
			// only add this option if set to SQL fix
			if ($this->config->add_assets_table_fix && $this->config->add_assets_table_name_fix)
			{
				$db .= PHP_EOL;
				$db .= PHP_EOL . '--';
				$db .= PHP_EOL
					. '--' . Line::_(
						__LINE__,__CLASS__
					)
					. ' Always insure this column name is large enough for long component and view names.';
				$db .= PHP_EOL . '--';
				$db .= PHP_EOL
					. "ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';";
			}

			return $db;
		}

		return '';
	}

	/**
	 * Get the sql header of the install.sql.
	 *
	 * Joomla 4 and later pin the session sql mode and time zone.
	 *
	 * @return  string  The generated sql header.
	 *
	 * @since   6.1.7
	 */
	protected function header(): string
	{
		$db = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";' . PHP_EOL;
		$db .= 'SET time_zone = "+00:00";' . PHP_EOL . PHP_EOL;

		return $db;
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
			. "`created_by` INT unsigned NULL,";
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
			. "`modified_by` INT unsigned,";
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
			. "`created` DATETIME DEFAULT CURRENT_TIMESTAMP,";
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
			. "`modified` DATETIME,";
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
			. "`checked_out` int unsigned,";
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
			. "`checked_out_time` DATETIME,";
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
			. "`metakey` TEXT,";
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
			. "`metadesc` TEXT,";
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
			. "`metadata` TEXT,";
	}
}

