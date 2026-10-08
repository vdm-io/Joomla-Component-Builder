<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Alias;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueGuid;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueKeys;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Model Record Key Fix Class.
 * 
 * Builds the opening block of the save method of an admin edit view model:
 * the record keys, in the shape every line after it expects. The primary key
 * becomes an integer that is never taken from the request (Joomla's API hands
 * the model a null key on create, and its form filter then drops the key, so
 * the model would otherwise read an undefined index). On a table with a guid
 * column the guid is the server's: an existing record keeps the guid it was
 * stored with, the API never takes one from the request body, and a record
 * without a valid unique guid gets one. On a view with an alias a new record
 * gets the alias key, so the table builds the alias from the title the way a
 * form submit with an empty alias does.
 * 
 * The output is identical for every Joomla target, and it lands in the
 * administrator model and the site edit model alike.
 * 
 * @since  6.1.7
 */
final class RecordKeyFix
{
	/**
	 * The super power that keeps a guid valid and unique.
	 *
	 * @var    string
	 * @since  6.1.7
	 */
	public const GUID_POWER = '9c513baf-b279-43fd-ae29-a585c8cbc4f0';

	/**
	 * The super power that reads one stored value.
	 *
	 * @var    string
	 * @since  6.1.7
	 */
	public const GET_POWER = 'db87c339-5bb6-4291-a7ef-2c48ea1b06bc';

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Database Unique Guid Builder Class.
	 *
	 * @var   DatabaseUniqueGuid
	 * @since 6.1.7
	 */
	protected DatabaseUniqueGuid $databaseuniqueguid;

	/**
	 * The Database Unique Keys Builder Class.
	 *
	 * @var   DatabaseUniqueKeys
	 * @since 6.1.7
	 */
	protected DatabaseUniqueKeys $databaseuniquekeys;

	/**
	 * The Alias Builder Class.
	 *
	 * @var   Alias
	 * @since 6.1.7
	 */
	protected Alias $alias;

	/**
	 * Constructor.
	 *
	 * @param Config              $config              The Config Class.
	 * @param DatabaseUniqueGuid  $databaseuniqueguid  The Database Unique Guid Builder Class.
	 * @param DatabaseUniqueKeys  $databaseuniquekeys  The Database Unique Keys Builder Class.
	 * @param Alias               $alias               The Alias Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		DatabaseUniqueGuid $databaseuniqueguid,
		DatabaseUniqueKeys $databaseuniquekeys,
		Alias $alias)
	{
		$this->config = $config;
		$this->databaseuniqueguid = $databaseuniqueguid;
		$this->databaseuniquekeys = $databaseuniquekeys;
		$this->alias = $alias;
	}

	/**
	 * Get the record key block that opens the save method of a view.
	 *
	 * @param   string  $view  The single view code name.
	 *
	 * @return  string  The block, opening on a blank line.
	 * @since   6.1.7
	 */
	public function get(string $view): string
	{
		$code = [];

		$code[] = PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " The record keys, as every line below expects them: the primary key as an";
		$code[] = Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " integer that is never taken from the request (null from the API on create).";
		$code[] = Indent::_(2) . "\$data['id'] = (int) (\$data['id'] ?? 0);";

		if ($this->hasGuid($view))
		{
			$component = $this->config->component_code_name;

			$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " The guid is the server's: an existing record keeps the guid it was stored";
			$code[] = Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " with, and the API never takes one from the request.";
			$code[] = Indent::_(2) . "if (\$data['id'] > 0)";
			$code[] = Indent::_(2) . "{";
			$code[] = Indent::_(3) . "\$data['guid'] = (string) Super_" . "__db87c339_5bb6_4291_a7ef_2c48ea1b06bc___Power::var('"
				. $view . "', \$data['id'], 'id', 'guid', '=', '" . $component . "');";
			$code[] = Indent::_(2) . "}";
			$code[] = Indent::_(2) . "elseif (Joomla__" . "_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->isClient('api'))";
			$code[] = Indent::_(2) . "{";
			$code[] = Indent::_(3) . "\$data['guid'] = '';";
			$code[] = Indent::_(2) . "}";
			$code[] = Indent::_(2) . "else";
			$code[] = Indent::_(2) . "{";
			$code[] = Indent::_(3) . "\$data['guid'] = (string) (\$data['guid'] ?? '');";
			$code[] = Indent::_(2) . "}";
			$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " Set the guid while it is empty, not valid, or not unique in this table.";
			$code[] = Indent::_(2) . "while (!Super_" . "__9c513baf_b279_43fd_ae29_a585c8cbc4f0___Power::valid(\$data['guid'], '"
				. $view . "', \$data['id'], '" . $component . "'))";
			$code[] = Indent::_(2) . "{";
			$code[] = Indent::_(3) . "\$data['guid'] = (string) Super_" . "__9c513baf_b279_43fd_ae29_a585c8cbc4f0___Power::get();";
			$code[] = Indent::_(2) . "}";
		}

		if (($alias = $this->aliasColumn($view)) !== null)
		{
			$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " A new record without an alias gets one from its title when the table checks it.";
			$code[] = Indent::_(2) . "if (\$data['id'] === 0 && !isset(\$data['" . $alias . "']))";
			$code[] = Indent::_(2) . "{";
			$code[] = Indent::_(3) . "\$data['" . $alias . "'] = '';";
			$code[] = Indent::_(2) . "}";
		}

		return implode(PHP_EOL, $code);
	}

	/**
	 * Whether the table of a view has a guid column.
	 *
	 * A guid field registers in the unique guid registry, unless it carries
	 * a unique index, when it registers among the unique keys instead; both
	 * mean the same column, as the API record resolution already reads them.
	 *
	 * @param   string  $view  The single view code name.
	 *
	 * @return  bool
	 * @since   6.1.7
	 */
	public function hasGuid(string $view): bool
	{
		if ($this->databaseuniqueguid->exists($view))
		{
			return true;
		}

		$unique = $this->databaseuniquekeys->get($view);

		return is_array($unique) && in_array('guid', $unique, true);
	}

	/**
	 * The alias column of a view, when it has one.
	 *
	 * @param   string  $view  The single view code name.
	 *
	 * @return  string|null
	 * @since   6.1.7
	 */
	protected function aliasColumn(string $view): ?string
	{
		$alias = $this->alias->get($view);

		return is_string($alias) && $alias !== '' ? $alias : null;
	}
}

